<?php

namespace App\Http\Controllers\MiningDirectory;

use App\Http\Controllers\Controller;
use App\Models\Logs\ExhibitionLog;
use App\Models\MiningDirectory\CompanyRepresentative;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class RepresentativeController extends Controller
{
    public function index()
    {
        $id = auth()->id();
        $data = CompanyRepresentative::where('company_id', $id)->orderby('id', 'desc')->get();
        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {
        $id = auth()->id();
        $name = $request->name;
        $position = $request->position;
        $email = $request->email;
        $bio = $request->short_bio;
        $linkedin = $request->linkedin;
        $image = $request->file('image'); // Gunakan file() untuk mendapatkan file yang di-upload

        $save = new CompanyRepresentative();
        $save->name = $name;
        $save->company_id = $id;
        $save->position = $position;
        $save->email = $email;
        $save->bio = $bio;
        $save->linkedin = $linkedin;
        // Handle image upload if needed
        if ($image != null) {

            $base64Image = base64_encode(file_get_contents($image->getRealPath()));
            // Konversi gambar ke base64
            $response = Http::post('https://staging.indonesiaminer.com/api/upload-image/company', [
                'image' => $base64Image,
            ]);

            // Ambil path URL dari respons
            $fullPath = $response['image'];
            $save->image = $fullPath;
        }
        $save->save();
        $company_id = auth()->id();
        $log = ExhibitionLog::where('section', 'representative')->where('company_id', $company_id)->first();
        if ($log == null) {
            $log = new ExhibitionLog();
            $log->section = 'representative';
            $log->company_id = $company_id;
        }
        $log->updated_at = Carbon::now();
        $log->save();
        return response()->json(['message' => 'Berhasil disimpan']);
    }



    public function show($id)
    {
        $representative = CompanyRepresentative::findOrFail($id);

        return response()->json(['data' => $representative]);
    }

    public function update(Request $request, $id)
    {
        $representative = CompanyRepresentative::findOrFail($id);
        $representative->name = $request->input('name');
        $representative->position = $request->input('position');
        $representative->email = $request->input('email');
        $representative->bio = $request->input('short_bio');
        $representative->linkedin = $request->input('linkedin');
        $image = $request->file('image'); // Gunakan file() untuk mendapatkan file yang di-upload
        // Update image if provided
        if ($request->hasFile('image')) {
            // Konversi gambar ke base64
            $base64Image = base64_encode(file_get_contents($image->getRealPath()));
            // Konversi gambar ke base64
            $response = Http::post('https://staging.indonesiaminer.com/api/upload-image/company', [
                'image' => $base64Image,
            ]);

            // Ambil path URL dari respons
            $fullPath = $response['image'];
            $representative->image = $fullPath;
        }

        $representative->save();
        $company_id = auth()->id();
        $log = ExhibitionLog::where('section', 'representative')->where('company_id', $company_id)->first();
        if ($log == null) {
            $log = new ExhibitionLog();
            $log->section = 'representative';
            $log->company_id = $company_id;
        }
        $log->updated_at = Carbon::now();
        $log->save();

        return response()->json(['message' => $request->image]);
    }

    public function destroy($id)
    {
        $representative = CompanyRepresentative::findOrFail($id);
        $representative->delete();
        $company_id = auth()->id();
        $log = ExhibitionLog::where('section', 'representative')->where('company_id', $company_id)->first();
        if ($log == null) {
            $log = new ExhibitionLog();
            $log->section = 'representative';
            $log->company_id = $company_id;
        }
        $log->updated_at = Carbon::now();
        $log->save();
        return response()->json(['message' => 'Data berhasil dihapus']);
    }

    public function log()
    {
        $userId = auth()->id();
        $data = ExhibitionLog::where('section', 'representative')->where('company_id', $userId)->first();
        return $data;
    }
}
