<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Logs\ExhibitionLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ExhibitionController extends Controller
{
    public function storePic(Request $request)
    {
        $company_id = auth()->id();

        $pic_name = $request->pic_name;
        $pic_job_title = $request->pic_job_title;
        $pic_email = $request->pic_email;
        $pic_phone = $request->pic_phone;
        $pic_signature = $request->pic_signature;
        $fascia_name = $request->fascia_name; //conditional

        // dd($request->all());
        $save = Company::where('id', $company_id)->first();
        $save->pic_name = $pic_name;
        $save->pic_job_title = $pic_job_title;
        $save->pic_email = $pic_email;
        $save->pic_phone = $pic_phone;
        // Update image if provided
        if ($pic_signature) {
            $response = Http::post('https://indonesiaminer.com/api/upload-image/company', [
                'image' => $pic_signature,
            ]);
            // Ambil path URL dari respons
            $fullPath = $response['image'];
            $save->pic_signature = $fullPath;
        }
        if ($fascia_name) {

            // Loop through the fascia_name array to replace null with space and capitalize the letters
            $processedFasciaName = array_map(function ($value) {
                return $value !== null ? $value : ' ';
            }, $fascia_name);

            // Join the processed values with spaces
            $fasciaNameText = implode('', $processedFasciaName);

            // Remove trailing spaces
            $fasciaNameText = trim($fasciaNameText);
            $save->fascia_name = $fasciaNameText;
        }
        $save->save();
        $log = ExhibitionLog::where('section', 'pic')->where('company_id', $company_id)->first();
        if ($log == null) {
            $log = new ExhibitionLog();
            $log->section = 'pic';
            $log->company_id = $company_id;
        }
        $log->updated_at = Carbon::now();
        $log->save();
        return redirect()->back()->with('success', 'Success Adding data');
    }
}
