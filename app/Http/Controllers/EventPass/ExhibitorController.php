<?php

namespace App\Http\Controllers\EventPass;

use App\Http\Controllers\Controller;
use App\Models\Logs\ExhibitionLog;
use App\Models\Payment;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ExhibitorController extends Controller
{
    public function index()
    {
        $id = auth()->id();
        $data = Users::leftjoin('payment', 'users.id', '=', 'payment.users_id')
            ->where('payment.company_id', $id)
            ->whereIn('payment.type', ['Exhibition Upgrade', 'Exhibition Exhibitor'])
            ->orderby('payment.id', 'desc')
            ->select('users.*', 'payment.*', 'users.id as id', 'payment.id as payment_id')
            ->get();

        return response()->json(['data' => $data]);
    }


    public function store(Request $request)
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
            $event_ticket = 72;
            $type = 'Exhibition Upgrade';
            $package = 'Exhibitor Upgrade Pass';
            $event_price = 4342002;
            $event_price_dollar = 280;
        } else {
            // Logika untuk kasus checkbox upgradeExhibitor tidak tercentang (false)
            $type = 'Exhibition Exhibitor';
            $package = 'Exhibitor Pass';
            $event_ticket = 69;
            $event_price = 0;
            $event_price_dollar = 0;
        }
        $total_price = $event_price;
        $total_price_dollar = $event_price_dollar;
        $code_payment = strtoupper(Str::random(7));
        $events_id = 12;
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
        $payment->save();

        // $company_id = auth()->id();
        $log = ExhibitionLog::where('section', 'delegate')->where('company_id', $company_id)->first();
        if ($log == null) {
            $log = new ExhibitionLog();
            $log->section = 'delegate';
            $log->company_id = $company_id;
        }
        $log->updated_at = Carbon::now();
        $log->save();
        return response()->json(['message' => 'Berhasil disimpan']);
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

        // Simpan perubahan pada user
        $user->save();
        $findPayment = Payment::where('users_id', $id)->where('events_id', '12')->first();
        if ($findPayment) {
            // Menentukan nilai berdasarkan status upgradeExhibitor
            if ($upgradeExhibitor) {
                // Logika untuk kasus checkbox upgradeExhibitor tercentang (true)
                $event_ticket = 72;
                $type = 'Exhibition Upgrade';
                $package = 'Exhibitor Upgrade Pass';
                $event_price = 4342002;
                $event_price_dollar = 280;
            } else {
                // Logika untuk kasus checkbox upgradeExhibitor tidak tercentang (false)
                $type = 'Exhibition Exhibitor';
                $package = 'Exhibitor Pass';
                $event_ticket = 69;
                $event_price = 0;
                $event_price_dollar = 0;
            }
            $findPayment->package_id = $event_ticket;
            $findPayment->type = $type;
            $findPayment->package = $package;
            $findPayment->event_price = $event_price;
            $findPayment->event_price_dollar = $event_price_dollar;
            $findPayment->total_price = $event_price;
            $findPayment->total_price_dollar = $event_price_dollar;
            $findPayment->save();
        }
        // Mengatur log
        $company_id = auth()->id();
        $log = ExhibitionLog::where('section', 'delegate')->where('company_id', $company_id)->first();
        if ($log == null) {
            $log = new ExhibitionLog();
            $log->section = 'delegate';
            $log->company_id = $company_id;
        }
        $log->updated_at = now();
        $log->save();

        // Mengembalikan respons JSON
        return response()->json(['message' => 'User updated successfully', 'user' => $user]);
    }


    public function destroy($id)
    {
        $representative = Payment::findOrFail($id);
        $representative->delete();
        $company_id = auth()->id();
        $log = ExhibitionLog::where('section', 'delegate')->where('company_id', $company_id)->first();
        if ($log == null) {
            $log = new ExhibitionLog();
            $log->section = 'delegate';
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
}