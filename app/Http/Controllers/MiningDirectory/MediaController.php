<?php

namespace App\Http\Controllers\MiningDirectory;

use App\Http\Controllers\Controller;
use App\Models\MiningDirectory\Media\MediaResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    public function index()
    {
        $id = auth()->id();
        $data = MediaResource::where('company_id', $id)->orderby('id', 'desc')->get();
        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'category' => 'required',
            'location' => 'required',
            'desc' => 'required',
            // 'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Aturan untuk gambar
            // 'file' => 'file|mimes:pdf|max:10240', // Aturan untuk file (maksimal 10MB)
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Proses penyimpanan data
        $media = new MediaResource;
        $media->title = $request->title;
        $media->media_category_id = $request->category;
        $media->location = $request->location;
        $media->desc = $request->desc;
        // ... tambahkan atribut lainnya sesuai kebutuhan

        // Simpan gambar
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $media->image = 'images/' . $imageName;
        }

        // Simpan file
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('files'), $fileName);
            $media->file = 'files/' . $fileName;
        }

        // Pengaturan tambahan
        $media->company_id = auth()->id(); // Misalnya, menyimpan ID perusahaan dari pengguna yang terautentikasi
        $media->date_media = now(); // Menyimpan tanggal saat ini
        $media->slug = Str::slug($media->title); // Menggunakan helper Str untuk membuat URL yang bersih

        $media->save();

        return response()->json(['message' => 'Data berhasil disimpan', 'data' => $media]);
    }



    public function show($id)
    {
        $representative = MediaResource::findOrFail($id);

        return response()->json(['data' => $representative]);
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'category' => 'required',
            'location' => 'required',
            'description' => 'required',
            // 'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Aturan untuk gambar
            // 'file' => 'file|mimes:pdf|max:10240', // Aturan untuk file (maksimal 10MB)
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Proses pembaruan data
        $media = MediaResource::findOrFail($id);
        $media->title = $request->title;
        $media->media_category_id = $request->category;
        $media->location = $request->location;
        $media->desc = $request->description;

        // Update gambar jika disediakan
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $media->image = 'images/' . $imageName;
        }

        // Update file jika disediakan
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('files'), $fileName);
            $media->file = 'files/' . $fileName;
        }

        // Pengaturan tambahan
        $media->company_id = auth()->id(); // Misalnya, menyimpan ID perusahaan dari pengguna yang terautentikasi
        $media->date_media = now(); // Menyimpan tanggal saat ini
        $media->slug = Str::slug($media->title); // Menggunakan helper Str untuk membuat URL yang bersih

        $media->save();

        return response()->json(['message' => 'Data berhasil diperbarui', 'data' => $media]);
    }

    public function destroy($id)
    {
        $representative = MediaResource::findOrFail($id);
        $representative->delete();

        return response()->json(['message' => 'Data berhasil dihapus']);
    }
}
