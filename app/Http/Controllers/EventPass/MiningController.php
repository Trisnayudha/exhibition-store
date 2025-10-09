<?php

namespace App\Http\Controllers\EventPass;

use App\Helpers\WhatsappApi;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Exhibition\ExhibitionMiningPass;
use App\Models\Logs\ExhibitionLog;
use App\Models\Payment;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MiningController extends Controller
{
    public function index()
    {
        $id = auth()->id();
        $data = ExhibitionMiningPass::where('company_id', $id)->where('type', 'mining')->get();
        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {
        $id = auth()->id();

        // Ambil data yang diperlukan dari request
        $file_excel = $request->file('file_excel');

        // Validasi file Excel harus ada
        if (!$file_excel) {
            return response()->json(['message' => 'Harap pilih file Excel yang akan diunggah.']);
        }

        // Buat nama file dengan format "excel_(timestamp upload).xlsx"
        $file_name = 'Mining_Pass_Excel_' . time() . '.xlsx';

        // Simpan file Excel di direktori storage/excel_company/ dengan nama file yang dibuat
        $file_path = $file_excel->storeAs('excel_company', $file_name, 'public');
        $db = 'storage/excel_company/' . $file_name;
        $save = new ExhibitionMiningPass();
        $save->file = $db;
        $save->company_id = $id;
        $save->type = 'mining';
        $save->save();

        // Simpan log jika perlu
        $log = ExhibitionLog::where('section', 'mining')->where('company_id', auth()->id())->first();
        if ($log == null) {
            $log = new ExhibitionLog();
            $log->section = 'mining';
            $log->company_id = auth()->id();
        }
        $log->updated_at = Carbon::now();
        $log->save();
        $findCompany = Company::where('id', $id)->first();
        $sendwa = new WhatsappApi();
        $sendwa->phone = '087785140389';
        $sendwa->message = 'Hi Mba lulla,
Ada yang submit Mining Pass nih

dari company ' . $findCompany->name . '

Mohon di check yaa excelnya berikut link untuk quick view nya:
: ' . url($db) . '
';
        $sendwa->WhatsappMessage();
        $sendwa->phone = '081932002663';
        $sendwa->WhatsappMessage();
        return response()->json(['message' => 'Data berhasil disimpan']);
    }


    public function destroy($id)
    {
        $representative = Payment::findOrFail($id);
        $representative->delete();
        $company_id = auth()->id();
        $log = ExhibitionLog::where('section', 'mining')->where('company_id', $company_id)->first();
        if ($log == null) {
            $log = new ExhibitionLog();
            $log->section = 'mining';
            $log->company_id = $company_id;
        }
        $log->updated_at = Carbon::now();
        $log->save();
        return response()->json(['message' => 'Data berhasil dihapus']);
    }

    public function log()
    {
        $userId = auth()->id();
        $data = ExhibitionLog::where('section', 'mining')->where('company_id', $userId)->first();
        return $data;
    }
}
