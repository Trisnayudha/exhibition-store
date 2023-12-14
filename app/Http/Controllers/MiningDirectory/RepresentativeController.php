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
        if ($image) {
            // Simpan gambar ke direktori yang diinginkan (public/images misalnya)
            $imageName = time() . '.' . $request->image->extension();
            $save_folder = $request->image->storeAs('public/images/representative/', $imageName);
            $db = '/storage/images/representative/' . $imageName;
            // Simpan path gambar ke dalam kolom image di tabel
            $save->image = $db;
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

        // Update image if provided
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $save_folder = $request->image->storeAs('public/images/representative/', $imageName);
            $db = '/storage/images/representative/' . $imageName;
            // Simpan path gambar ke dalam kolom image di tabel
            $representative->image = $db;
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

        return response()->json(['message' => 'Data berhasil dihapus']);
    }
}
