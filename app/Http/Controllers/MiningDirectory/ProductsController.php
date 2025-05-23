<?php

namespace App\Http\Controllers\MiningDirectory;

use App\Http\Controllers\Controller;
use App\Models\Logs\ExhibitionLog;
use App\Models\MiningDirectory\Products\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductsController extends Controller
{
    public function index()
    {
        $id = auth()->id();
        $data = Product::where('company_id', $id)->orderby('id', 'desc')->get();
        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'category' => 'required',
            // 'location' => 'required',
            'desc' => 'required',
            // 'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Aturan untuk gambar
            // 'file' => 'file|mimes:pdf|max:10240', // Aturan untuk file (maksimal 10MB)
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Proses penyimpanan data
        $media = new Product;
        $media->title = $request->title;
        $media->product_category_id = $request->category;
        $media->location = $request->location;
        $media->desc = $request->desc;
        $media->video = $request->video_url;
        $media->document_name =  $request->document_name;

        $image = $request->file('image'); // Gunakan file() untuk mendapatkan file yang di-upload
        // Update image if provided
        if ($request->hasFile('image')) {
            // Konversi gambar ke base64
            $base64Image = base64_encode(file_get_contents($image->getRealPath()));
            // Konversi gambar ke base64
            $response = Http::post('https://indonesiaminer.com/api/upload-image/company', [
                'image' => $base64Image,
            ]);

            // Ambil path URL dari respons
            $fullPath = $response['image'];
            $media->image = $fullPath;
        }

        $file = $request->file('file');
        if ($request->hasFile('file')) {
            // Konversi file PDF ke base64
            $base64File = base64_encode(file_get_contents($file->getRealPath()));

            // Kirim file base64 ke API
            $responseFile = Http::post('https://indonesiaminer.com/api/upload-file/company', [
                'file' => $base64File,
            ]);

            // Ambil path URL dari respons
            $fullPathFile = $responseFile['file'];
            $media->file = $fullPathFile;
        }

        // Pengaturan tambahan
        $media->company_id = auth()->id(); // Misalnya, menyimpan ID perusahaan dari pengguna yang terautentikasi
        $media->date_product = now(); // Menyimpan tanggal saat ini
        $media->slug = Str::slug($media->title); // Menggunakan helper Str untuk membuat URL yang bersih

        $media->save();
        $company_id = auth()->id();
        $log = ExhibitionLog::where('section', 'product')->where('company_id', $company_id)->first();
        if ($log == null) {
            $log = new ExhibitionLog();
            $log->section = 'product';
            $log->company_id = $company_id;
        }
        $log->updated_at = Carbon::now();
        $log->save();
        return response()->json(['message' => 'Data berhasil disimpan', 'data' => $media]);
    }



    public function show($id)
    {
        $representative = Product::findOrFail($id);

        return response()->json(['data' => $representative]);
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'category' => 'required',
            'description' => 'required',
            // 'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Aturan untuk gambar
            // 'file' => 'file|mimes:pdf|max:10240', // Aturan untuk file (maksimal 10MB)
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Proses pembaruan data
        $product = Product::findOrFail($id);
        $product->title = $request->title;
        $product->product_category_id = $request->category;
        $product->location = $request->location;
        $product->desc = $request->description;
        $product->video = $request->video_url;
        $product->document_name = $request->document_name;

        $image = $request->file('image'); // Gunakan file() untuk mendapatkan file yang di-upload
        // Update image if provided
        if ($request->hasFile('image')) {
            // Konversi gambar ke base64
            $base64Image = base64_encode(file_get_contents($image->getRealPath()));
            // Konversi gambar ke base64
            $response = Http::post('https://indonesiaminer.com/api/upload-image/company', [
                'image' => $base64Image,
            ]);

            // Ambil path URL dari respons
            $fullPath = $response['image'];
            $product->image = $fullPath;
        }

        $file = $request->file('file'); // Gunakan file() untuk mendapatkan file yang di-upload
        // Update image if provided
        if ($request->hasFile('file')) {
            // Konversi gambar ke base64
            $base64File = base64_encode(file_get_contents($file->getRealPath()));
            // Konversi gambar ke base64
            $responseFile = Http::post('https://indonesiaminer.com/api/upload-file/company', [
                'file' => $base64File,
            ]);

            // Ambil path URL dari respons
            $fullPathFile = $responseFile['file'];
            $product->file = $fullPathFile;
        }

        // Pengaturan tambahan
        $product->company_id = auth()->id(); // Misalnya, menyimpan ID perusahaan dari pengguna yang terautentikasi
        $product->date_product = now(); // Menyimpan tanggal saat ini
        $product->slug = Str::slug($product->title); // Menggunakan helper Str untuk membuat URL yang bersih

        $product->save();
        $company_id = auth()->id();
        $log = ExhibitionLog::where('section', 'product')->where('company_id', $company_id)->first();
        if ($log == null) {
            $log = new ExhibitionLog();
            $log->section = 'product';
            $log->company_id = $company_id;
        }
        $log->updated_at = Carbon::now();
        $log->save();
        return response()->json(['message' => 'Data berhasil diperbarui', 'data' => $product]);
    }

    public function destroy($id)
    {
        $representative = Product::findOrFail($id);
        $representative->delete();
        $company_id = auth()->id();
        $log = ExhibitionLog::where('section', 'product')->where('company_id', $company_id)->first();
        if ($log == null) {
            $log = new ExhibitionLog();
            $log->section = 'product';
            $log->company_id = $company_id;
        }
        $log->updated_at = Carbon::now();
        $log->save();
        return response()->json(['message' => 'Data berhasil dihapus']);
    }

    public function log()
    {
        $userId = auth()->id();
        $data = ExhibitionLog::where('section', 'product')->where('company_id', $userId)->first();
        return $data;
    }
}
