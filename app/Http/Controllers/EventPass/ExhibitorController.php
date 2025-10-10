<?php

namespace App\Http\Controllers\EventPass;

use App\Http\Controllers\Controller;
use App\Models\Exhibition\ExhibitionCartList;
use App\Models\Logs\ExhibitionLog;
use App\Models\Payment;
use App\Models\Users;
use App\Models\UsersDelegate;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Goutte\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ExhibitorController extends Controller
{
    public function index()
    {
        $id = auth()->id();
        $data = Users::leftjoin('payment', 'users.id', '=', 'payment.users_id')
            ->where('payment.company_id', $id)
            ->where('payment.events_id', 14)
            ->whereIn('payment.type', ['Exhibition Pass Upgrade', 'Exhibition Exhibitor', 'Additional Exhibition Pass'])
            ->orderby('payment.id', 'desc')
            ->select('users.*', 'payment.*', 'users.id as id', 'payment.id as payment_id')
            ->get();

        return response()->json(['data' => $data]);
    }


    public function store(Request $request)
    {
        $companyId = auth()->id();

        // ===== Config (bisa dipindah ke const atau config) =====
        $EVENT_ID       = 14;
        $PACKAGE_ID     = 70;         // Exhibitor (base / upgrade)
        $PAYMENT_METHOD = 'Exhibition Portal';
        $DEFAULT_STATUS = 'Waiting';

        // 1) Validate request
        $validator = Validator::make($request->all(), [
            'name'             => 'required|string|max:255',
            'email'            => 'required|email|max:255',
            'company_type'     => 'required|integer',
            'company_name'     => 'required|string|max:255',
            'phone_code'       => 'required|integer',
            'phone'            => 'required|string|max:50',
            'job_title'        => 'required|string|max:255',
            'address'          => 'nullable|string|max:255',
            'city'             => 'nullable|string|max:255',
            'country'          => 'nullable|string|max:255',
            'post_code'        => 'nullable|string|max:50',
            // upgrade_exhibitor bisa berupa "true"/"false" string dari form
            'upgrade_exhibitor' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Some fields are invalid. Please review your input.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();

        // Normalize upgrade_exhibitor (checkbox string → boolean)
        $upgrade = !($request->input('upgrade_exhibitor') === 'false' || $request->input('upgrade_exhibitor') === null);

        // Derive package/type/price
        $TYPE               = $upgrade ? 'Exhibition Pass Upgrade' : 'Exhibition Exhibitor';
        $PACKAGE_NAME       = $upgrade ? 'Exhibitor Upgrade Pass' : 'Exhibitor Pass';
        $UNIT_PRICE_USD     = $upgrade ? 160 : 0; // upgrade only
        $codePayment        = strtoupper(Str::random(7));

        try {
            $result = DB::transaction(function () use (
                $data,
                $companyId,
                $EVENT_ID,
                $PACKAGE_ID,
                $PAYMENT_METHOD,
                $DEFAULT_STATUS,
                $TYPE,
                $PACKAGE_NAME,
                $UNIT_PRICE_USD,
                $codePayment
            ) {
                // 2) Find or create user by email
                $user = Users::where('email', $data['email'])->first();

                if (!$user) {
                    $user = new Users();
                    $user->email = $data['email'];
                    $user->password = Hash::make('IM2024'); // TODO: ganti flow onboarding real
                } else {
                    // 3) Prevent duplicate active payment for same company + event
                    $existing = Payment::where('company_id', $companyId)
                        ->where('users_id', $user->id)
                        ->where('events_id', $EVENT_ID)
                        ->whereNotIn('status', ['trash', 'cancelled', 'decline'])
                        ->first();

                    if ($existing) {
                        return [
                            'conflict' => true,
                            'message'  => 'This email is already associated with an active exhibitor record for this event under your company.'
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

                // 5) Pricing (IDR) using current FX rate
                $rateIdr = (float) ($this->scrape() ?? 0);
                if ($rateIdr <= 0) {
                    $rateIdr = 16000; // fallback aman
                }
                $priceIdr = $UNIT_PRICE_USD * $rateIdr;

                // 6) Create payment
                $payment = new Payment();
                $payment->type                = $TYPE;
                $payment->code_payment        = $codePayment;
                $payment->users_id            = $user->id;
                $payment->events_id           = $EVENT_ID;
                $payment->package_id          = $PACKAGE_ID;
                $payment->package             = $PACKAGE_NAME;
                $payment->payment_method      = $PAYMENT_METHOD;
                $payment->status              = $DEFAULT_STATUS;
                $payment->aproval_quota_users = 0;
                $payment->company_id          = $companyId;

                $payment->event_price         = $priceIdr;
                $payment->event_price_dollar  = $UNIT_PRICE_USD;
                $payment->total_price         = $priceIdr;
                $payment->total_price_dollar  = $UNIT_PRICE_USD;

                $payment->save();

                // 7) Log (section: exhibitor)
                $log = ExhibitionLog::firstOrNew([
                    'section'    => 'exhibitor',
                    'company_id' => $companyId,
                ]);
                $log->updated_at = Carbon::now();
                $log->save();

                return [
                    'conflict'     => false,
                    'user_id'      => $user->id,
                    'payment_id'   => $payment->id,
                    'code_payment' => $payment->code_payment,
                    'fx_rate_idr'  => $rateIdr,
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
                'message' => 'Exhibitor has been successfully added.',
                'data'    => [
                    'user_id'      => $result['user_id'],
                    'payment_id'   => $result['payment_id'],
                    'code_payment' => $result['code_payment'],
                    'fx_rate_idr'  => $result['fx_rate_idr'],
                ],
            ], 201);
        } catch (\Throwable $e) {
            report($e);
            return response()->json([
                'status'  => 'error',
                'message' => 'A server error occurred. Please contact support if this continues.',
            ], 500);
        }
    }

    public function storeAdditional(Request $request)
    {
        $company_id = auth()->id();
        $name = $request->name;
        $email = $request->email;
        $company_type = $request->company_type;
        $company_name = $request->company_name;
        $phone_code = $request->phone_code;
        $phone = $request->phone;
        $job_title = $request->job_title;
        $address = $request->address;
        $city = $request->city;
        $country = $request->country;
        $post_code = $request->post_code;
        $upgradeExhibitor = $request->input('upgrade_exhibitor') !== 'false';
        // Menentukan nilai berdasarkan status upgradeExhibitor
        if ($upgradeExhibitor) {
            // Logika untuk kasus checkbox upgradeExhibitor tercentang (true)
            $event_ticket = 81;
            $type = 'Additional Exhibition Pass';
            $package = 'Additional Exhibitor Pass';
            $event_price_dollar = 280;
            $event_price = $this->scrape() * $event_price_dollar;
        } else {
            // Logika untuk kasus checkbox upgradeExhibitor tidak tercentang (false)
            $type = 'Exhibition Exhibitor';
            $package = 'Exhibitor Pass';
            $event_ticket = 70;
            $event_price = 0;
            $event_price_dollar = 0;
        }
        $total_price = $event_price;
        $total_price_dollar = $event_price_dollar;
        $code_payment = strtoupper(Str::random(7));
        $events_id = 14;
        $payment_method = 'Exhibition Portal';
        $status = 'Waiting';
        $aproval_quota_users = 0;
        $company_id = $company_id;

        $user = Users::where('email', $email)->first();
        if (empty($user)) {
            $user = new Users();
            $user->email = $email;
            $user->password = Hash::make('IM2024');
        } else {
            //catch user yang menginputkan email dengan data yang sama
            $payment = Payment::where('company_id', $company_id)->where('users_id', $user->id)->first();
            if ($payment) {
                return response()->json(['message' => 'Please use different email']);
            }
        }
        $user->name = $name;
        $user->job_title = $job_title;
        $user->ms_company_type_id = $company_type;
        $user->company_name = $company_name;
        $user->ms_phone_code_id = $phone_code;
        $user->country = $country;
        $user->phone = $phone;
        $user->city = $city;
        $user->post_code = $post_code;
        $user->company_address = $address;
        $user->is_register = 1;
        $user->save();

        $payment = Payment::where('company_id', $company_id)->where('users_id', $user->id)->first();
        if (empty($payment)) {
            $payment = new Payment();
        }
        $payment->type = $type;
        $payment->code_payment = $code_payment;
        $payment->users_id = $user->id;
        $payment->events_id = $events_id;
        $payment->package_id = $event_ticket;
        $payment->package = $package;
        $payment->payment_method = $payment_method;
        $payment->status = $status;
        $payment->aproval_quota_users = $aproval_quota_users;
        $payment->company_id = $company_id;
        $payment->event_price = $total_price;
        $payment->event_price_dollar = $total_price_dollar;
        $payment->total_price = $total_price;
        $payment->total_price_dollar = $total_price_dollar;
        $payment->save();

        // $company_id = auth()->id();
        $log = ExhibitionLog::where('section', 'exhibitor')->where('company_id', $company_id)->first();
        if ($log == null) {
            $log = new ExhibitionLog();
            $log->section = 'exhibitor';
            $log->company_id = $company_id;
        }
        $log->updated_at = Carbon::now();
        $log->save();
        return response()->json(['message' => 'Berhasil disimpan', 'payment' => $payment, 'user' => $user]);
    }

    public function show($id)
    {
        $users = Users::join('payment', 'payment.users_id', 'users.id')->select('users.*', 'payment.type')->where('users.id', $id)->first();

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
        $upgradeExhibitor = $request->input('upgrade_edit_exhibitor');

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
        if ($findPayment) {
            // Menentukan nilai berdasarkan status upgradeExhibitor
            if ($upgradeExhibitor) {
                // Logika untuk kasus checkbox upgradeExhibitor tercentang (true)
                $event_ticket = 70;
                $type = 'Exhibition Pass Upgrade';
                $package = 'Exhibitor Upgrade Pass';
                $event_price = 2597752;
                $event_price_dollar = 160;
            } else {
                // Logika untuk kasus checkbox upgradeExhibitor tidak tercentang (false)
                $type = 'Exhibition Exhibitor';
                $package = 'Exhibitor Pass';
                $event_ticket = 70;
                $event_price = 0;
                $event_price_dollar = 0;
            }
            $findPayment->status = 'Waiting';
            $findPayment->package_id = $event_ticket;
            $findPayment->type = $type;
            $findPayment->package = $package;
            $findPayment->event_price = $event_price;
            $findPayment->event_price_dollar = $event_price_dollar;
            $findPayment->total_price = $event_price;
            $findPayment->total_price_dollar = $event_price_dollar;
            $findPayment->save();
            $findUsersDelegate = UsersDelegate::where('payment_id', $findPayment->id)->first();
            if ($findUsersDelegate) {
                $findUsersDelegate->delete();
            }
        }
        $findExhibition = ExhibitionCartList::where('delegate_id', $findPayment->id)->first();
        if (!empty($findExhibition)) {
            $findExhibition->name_product = $request->name;
            $findExhibition->save();
        }
        // Mengatur log
        $company_id = auth()->id();
        $log = ExhibitionLog::where('section', 'exhibitor')->where('company_id', $company_id)->first();
        if ($log == null) {
            $log = new ExhibitionLog();
            $log->section = 'exhibitor';
            $log->company_id = $company_id;
        }
        $log->updated_at = now();
        $log->save();

        // Mengembalikan respons JSON
        return response()->json(['message' => 'User updated successfully', 'user' => $user, 'payment' => $findPayment, 'exhibitor' => $findExhibition ?? null]);
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
        $log = ExhibitionLog::where('section', 'exhibitor')->where('company_id', $company_id)->first();
        if ($log == null) {
            $log = new ExhibitionLog();
            $log->section = 'exhibitor';
            $log->company_id = $company_id;
        }
        $log->updated_at = Carbon::now();
        $log->save();
        return response()->json(['message' => 'Data berhasil dihapus']);
    }

    public function log()
    {
        $userId = auth()->id();
        $data = ExhibitionLog::where('section', 'delegate')->where('company_id', $userId)->first();
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
