<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{
    public function test(Request $request)
    {
        $id = auth()->id();
        $croppedImageBase64 = $request->input('cropped_image');
        $croppedImageBinary = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $croppedImageBase64));

        // Simpan gambar ke storage
        $folderPath = 'public/images/cropped';
        $imageName = uniqid() . '.png';
        $save = Company::where('id', $id)->first();


        dd($request->all());
        Storage::put($folderPath . '/' . $imageName, $croppedImageBinary);


        dd($imageName);
    }
}
