<?php

namespace App\Http\Controllers\EventPass;

use App\Http\Controllers\Controller;
use App\Models\Exhibition\ExhibitionCartList;
use App\Models\Logs\ExhibitionLog;
use App\Models\Payment;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Goutte\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AdditionalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = auth()->id();
        $data = Users::leftjoin('payment', 'users.id', 'payment.users_id')
            ->where('payment.company_id', $id)
            ->where('payment.events_id', 14)
            ->where('payment.type', 'Exhibition Delegate Additional')
            ->orderby('payment.id', 'desc')
            ->select('users.*', 'payment.*', 'users.id as id', 'payment.id as payment_id')->get();
        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {
        $companyId = auth()->id();

        // === Config for "Additional Delegate" ===
        $EVENT_ID            = 14;
        $PACKAGE_ID          = 81;
        $TYPE                = 'Exhibition Delegate Additional';
        $PACKAGE_NAME        = 'Additional Delegate Pass';
        $PAYMENT_METHOD      = 'Exhibition Portal';
        $DEFAULT_STATUS      = 'Waiting';
        $APPROVAL_QUOTA_FLAG = 0;
        $PRICE_USD           = 400; // unit price in USD

        // 1) Validate request
        $validator = Validator::make($request->all(), [
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|max:255',
            'company_type'  => 'required|integer',
            'company_name'  => 'required|string|max:255',
            'phone_code'    => 'required|integer',
            'phone'         => 'required|string|max:50',
            'job_title'     => 'required|string|max:255',
            'address'       => 'nullable|string|max:255',
            'city'          => 'nullable|string|max:255',
            'country'       => 'nullable|string|max:255',
            'post_code'     => 'nullable|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Some fields are invalid. Please review your input.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();

        try {
            $result = DB::transaction(function () use (
                $data,
                $companyId,
                $EVENT_ID,
                $PACKAGE_ID,
                $TYPE,
                $PACKAGE_NAME,
                $PAYMENT_METHOD,
                $DEFAULT_STATUS,
                $APPROVAL_QUOTA_FLAG,
                $PRICE_USD
            ) {
                // 2) Find or create user by email
                $user = Users::where('email', $data['email'])->first();

                if (!$user) {
                    $user = new Users();
                    $user->email = $data['email'];
                    $user->password = Hash::make('IM2026'); // TODO: replace with real onboarding
                } else {
                    // 3) Prevent duplicate active payment for the same company + event
                    $existingPayment = Payment::where('company_id', $companyId)
                        ->where('users_id', $user->id)
                        ->where('events_id', $EVENT_ID)
                        ->whereNotIn('status', ['trash', 'cancelled', 'decline'])
                        ->first();

                    if ($existingPayment) {
                        return [
                            'conflict' => true,
                            'message'  => 'This email is already associated with an active delegate for this event under your company.'
                        ];
                    }
                }

                // 4) Update user profile fields
                $user->name               = $data['name'];
                $user->job_title          = $data['job_title'];
                $user->ms_company_type_id = $data['company_type'];
                $user->company_name       = $data['company_name'];
                $user->ms_phone_code_id   = $data['phone_code'];
                $user->country            = $data['country'] ?? null;
                $user->phone              = $data['phone'];
                $user->city               = $data['city'] ?? null;
                $user->post_code          = $data['post_code'] ?? null;
                $user->company_address    = $data['address'] ?? null;
                $user->is_register        = 1;
                $user->edit_approved      = null;
                $user->save();

                // 5) Pricing (IDR) using current rate
                $rateIdr = (float) ($this->scrape() ?? 0); // make sure scrape() returns numeric
                if ($rateIdr <= 0) {
                    // fallback rate to avoid 0 pricing if scrape fails
                    $rateIdr = 16000;
                }
                $priceIdr = $rateIdr * $PRICE_USD;

                // 6) Create payment
                $payment = new Payment();
                $payment->type                = $TYPE;
                $payment->code_payment        = strtoupper(Str::random(7));
                $payment->users_id            = $user->id;
                $payment->events_id           = $EVENT_ID;
                $payment->package_id          = $PACKAGE_ID;
                $payment->package             = $PACKAGE_NAME;
                $payment->payment_method      = $PAYMENT_METHOD;
                $payment->status              = $DEFAULT_STATUS;
                $payment->aproval_quota_users = $APPROVAL_QUOTA_FLAG;
                $payment->company_id          = $companyId;

                // store both IDR & USD values
                $payment->event_price         = $priceIdr;
                $payment->event_price_dollar  = $PRICE_USD;
                $payment->total_price         = $priceIdr;
                $payment->total_price_dollar  = $PRICE_USD;

                $payment->save();

                // 7) Update log (section: additional)
                $log = ExhibitionLog::firstOrNew([
                    'section'    => 'additional',
                    'company_id' => $companyId,
                ]);
                $log->updated_at = Carbon::now();
                $log->save();

                return [
                    'conflict'     => false,
                    'user_id'      => $user->id,
                    'payment_id'   => $payment->id,
                    'code_payment' => $payment->code_payment,
                    'rate_idr'     => $rateIdr,
                ];
            });

            if (!empty($result['conflict'])) {
                return response()->json([
                    'status'  => 'error',
                    'message' => $result['message'],
                ], 409);
            }

            return response()->json([
                'status'  => 'ok',
                'message' => 'Additional delegate has been successfully added.',
                'data'    => [
                    'user_id'      => $result['user_id'],
                    'payment_id'   => $result['payment_id'],
                    'code_payment' => $result['code_payment'],
                    'fx_rate_idr'  => $result['rate_idr'],
                ]
            ], 201);
        } catch (\Throwable $e) {
            report($e);
            return response()->json([
                'status'  => 'error',
                'message' => 'A server error occurred. Please contact support if this continues.',
            ], 500);
        }
    }

    public function show($id)
    {
        $users = Users::findOrFail($id);

        return response()->json(['data' => $users]);
    }

    public function update(Request $request, $id)
    {
        // Mengambil data user berdasarkan ID
        $user = Users::find($id);

        // Cek apakah user dengan ID yang diberikan ditemukan
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Mengatur data user berdasarkan request
        $user->name = $request->name;
        $user->email = $request->email;
        $user->job_title = $request->job_title;
        $user->phone = $request->phone;
        $user->company_address = $request->company_address;
        $user->city = $request->city;
        $user->country = $request->country;
        $user->post_code = $request->post_code;
        $user->edit_approved = null;

        // Simpan perubahan pada user
        $user->save();
        $findPayment = Payment::where('users_id', $id)->where('events_id', '14')->first();
        $findExhibition = ExhibitionCartList::where('delegate_id', $findPayment->id)->first();
        $findExhibition->name_product = $request->name;
        $findExhibition->save();
        // Mengatur log
        $company_id = auth()->id();
        $log = ExhibitionLog::where('section', 'additional')->where('company_id', $company_id)->first();
        if ($log == null) {
            $log = new ExhibitionLog();
            $log->section = 'additional';
            $log->company_id = $company_id;
        }
        $log->updated_at = now();
        $log->save();

        // Mengembalikan respons JSON
        return response()->json(['message' => 'User updated successfully', 'user' => $user]);
    }


    public function destroy($id)
    {
        $representative = Payment::where('users_id', $id)->where('events_id', 14)->first();
        $cart = ExhibitionCartList::where('delegate_id', $representative->id)->first();
        if ($cart) {
            $cart->delete();
        }
        $representative->delete();
        $company_id = auth()->id();
        $log = ExhibitionLog::where('section', 'additional')->where('company_id', $company_id)->first();
        if ($log == null) {
            $log = new ExhibitionLog();
            $log->section = 'additional';
            $log->company_id = $company_id;
        }
        $log->updated_at = Carbon::now();
        $log->save();
        return response()->json(['message' => 'Data berhasil dihapus']);
    }

    public function log()
    {
        $userId = auth()->id();
        $data = ExhibitionLog::where('section', 'additional')->where('company_id', $userId)->first();
        return $data;
    }
    private function scrape()
    {
        $client = new Client();

        // URL target
        $url = 'https://kursdollar.org/real-time/USD/';
        // Mengirim permintaan GET ke halaman web
        $crawler = $client->request('GET', $url);

        // Mencari elemen dengan ID "nilai"
        $value = $crawler->filter('.in_table tr:nth-child(3) > td:first-child')->text();

        // Menghilangkan titik dan mengganti koma dengan titik
        $value = str_replace('.', '', $value);
        $value = str_replace(',', '.', $value);

        // Mengonversi nilai tukar menjadi float
        $floatValue = (float) $value;

        // Mengonversi nilai tukar menjadi integer (dengan pembulatan)
        $intValue = (int) round($floatValue);

        // Mengembalikan nilai tukar dalam format integer
        return $intValue;
    }
}
