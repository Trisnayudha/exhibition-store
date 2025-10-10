<?php

namespace App\Http\Controllers\EventPass;

use App\Http\Controllers\Controller;
use App\Models\Logs\ExhibitionLog;
use App\Models\Payment;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class WorkingController extends Controller
{
    public function index()
    {
        $id = auth()->id();
        $data = Users::leftjoin('payment', 'users.id', 'payment.users_id')
            ->where('payment.company_id', $id)
            ->where('payment.events_id', 14)

            ->where('payment.type', 'Exhibition Working')
            ->orderby('payment.id', 'desc')
            ->select('users.*', 'payment.*', 'users.id as id', 'payment.id as payment_id')->get();
        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {
        $companyId = auth()->id();

        // ===== Config untuk Working Pass =====
        $EVENT_ID       = 14;
        $PACKAGE_ID     = 71;                // Working Pass
        $TYPE           = 'Exhibition Working';
        $PACKAGE_NAME   = 'Working Pass';
        $PAYMENT_METHOD = 'Exhibition Portal';
        $DEFAULT_STATUS = 'Waiting';

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
            // Jika mau dinamis: 'events_id' => 'sometimes|integer|exists:events,id'
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
            $result = DB::transaction(function () use ($data, $companyId, $EVENT_ID, $PACKAGE_ID, $TYPE, $PACKAGE_NAME, $PAYMENT_METHOD, $DEFAULT_STATUS) {

                // 2) Find or create user by email
                $user = Users::where('email', $data['email'])->first();

                if (!$user) {
                    $user = new Users();
                    $user->email = $data['email'];
                    $user->password = Hash::make('IM2024'); // TODO: replace with real onboarding
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
                            'message'  => 'This email is already associated with an active working pass for this event under your company.'
                        ];
                    }
                }

                // 4) Update user profile
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

                // 5) Create payment
                $payment = new Payment();
                $payment->type                = $TYPE;
                $payment->code_payment        = strtoupper(Str::random(7));
                $payment->users_id            = $user->id;
                $payment->events_id           = $EVENT_ID;
                $payment->package_id          = $PACKAGE_ID;
                $payment->package             = $PACKAGE_NAME;
                $payment->payment_method      = $PAYMENT_METHOD;
                $payment->status              = $DEFAULT_STATUS;
                $payment->aproval_quota_users = 0;
                $payment->company_id          = $companyId;
                // Working Pass tidak berbayar → harga 0
                $payment->event_price         = 0;
                $payment->event_price_dollar  = 0;
                $payment->total_price         = 0;
                $payment->total_price_dollar  = 0;
                $payment->save();

                // 6) Log (section: working)
                $log = ExhibitionLog::firstOrNew([
                    'section'    => 'working',
                    'company_id' => $companyId,
                ]);
                $log->updated_at = Carbon::now();
                $log->save();

                return [
                    'conflict'     => false,
                    'user_id'      => $user->id,
                    'payment_id'   => $payment->id,
                    'code_payment' => $payment->code_payment,
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
                'message' => 'Working pass has been successfully added.',
                'data'    => [
                    'user_id'      => $result['user_id'],
                    'payment_id'   => $result['payment_id'],
                    'code_payment' => $result['code_payment'],
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

        // Mengatur log
        $company_id = auth()->id();
        $log = ExhibitionLog::where('section', 'working')->where('company_id', $company_id)->first();
        if ($log == null) {
            $log = new ExhibitionLog();
            $log->section = 'working';
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
        $representative->delete();
        $company_id = auth()->id();
        $log = ExhibitionLog::where('section', 'working')->where('company_id', $company_id)->first();
        if ($log == null) {
            $log = new ExhibitionLog();
            $log->section = 'working';
            $log->company_id = $company_id;
        }
        $log->updated_at = Carbon::now();
        $log->save();
        return response()->json(['message' => 'Data berhasil dihapus']);
    }

    public function log()
    {
        $userId = auth()->id();
        $data = ExhibitionLog::where('section', 'working')->where('company_id', $userId)->first();
        return $data;
    }
}
