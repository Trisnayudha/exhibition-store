<?php

namespace App\Http\Controllers;

use App\Models\Logs\ExhibitionLog;
use App\Models\Promotional\ExhibitionPromotional;
use App\Models\Promotional\ExhibitionPromotionalList;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PromotionalController extends Controller
{
    public function advertisement(Request $request)
    {
        $userId = auth()->id();
        $link = $request->linkAdvertisement;
        $file = $request->file('pdfFiles');

        $save = ExhibitionPromotional::where('company_id', $userId)->where('section', 'advertisement')->first();
        if (empty($save)) {
            $save = new ExhibitionPromotional();
        }
        $save->link = $link;
        $save->section = 'advertisement';
        $save->type = 'pdf';
        $save->company_id = $userId;

        if ($file) {
            // Check if a file has been uploaded
            $base64File = base64_encode(file_get_contents($file->getRealPath()));

            // Kirim file base64 ke API
            $responseFile = Http::post('https://staging.indonesiaminer.com/api/upload-file/company', [
                'file' => $base64File,
            ]);
            // Ambil path URL dari respons
            $fullPathFile = $responseFile['file'];
            $save->file = $fullPathFile;
        }

        $save->save();
        $log = ExhibitionLog::where('section', 'advertisement')->where('company_id', $userId)->first();
        if ($log == null) {
            $log = new ExhibitionLog();
            $log->section = 'advertisement';
            $log->company_id = $userId;
        }
        $log->updated_at = Carbon::now();
        $log->save();
        return redirect()->back();
    }


    public function sosmed(Request $request)
    {
        $userId = auth()->id();
        $link = $request->linkSocialMedia;
        $desc = $request->desc;
        $images = $request->file('imageSocial');
        $pdfs = $request->file('pdfSocial');

        $save = ExhibitionPromotional::where('company_id', $userId)->where('section', 'sosmed')->first();

        if (empty($save)) {
            $save = new ExhibitionPromotional();
        }

        $save->link = $link;
        $save->desc = $desc;
        $save->section = 'sosmed';
        $save->company_id = $userId;
        $save->file = 'null';
        $save->type = 'null';
        $save->save();

        // Process images
        if ($images) {
            foreach ($images as $image) {
                // Konversi gambar ke base64
                $base64Image = base64_encode(file_get_contents($image->getRealPath()));
                // Konversi gambar ke base64
                $response = Http::post('https://staging.indonesiaminer.com/api/upload-image/company', [
                    'image' => $base64Image,
                ]);

                // Ambil path URL dari respons
                $fullPath = $response['image'];

                // Save image record to ExhibitionPromotionalList
                $saveImage = new ExhibitionPromotionalList();
                $saveImage->file = $fullPath;
                $saveImage->section = 'image';
                $saveImage->exhibition_promotional_id = $save->id; // Link to the main record
                $saveImage->save();
            }
        }

        // Process PDF files
        if ($pdfs) {
            foreach ($pdfs as $pdf) {
                $base64File = base64_encode(file_get_contents($pdf->getRealPath()));

                // Kirim file base64 ke API
                $responseFile = Http::post('https://staging.indonesiaminer.com/api/upload-file/company', [
                    'file' => $base64File,
                ]);
                // Ambil path URL dari respons
                $fullPathFile = $responseFile['file'];

                // Save PDF record to ExhibitionPromotionalList
                $savePdf = new ExhibitionPromotionalList();
                $savePdf->file = $fullPathFile;
                $savePdf->section = 'pdf';
                $savePdf->exhibition_promotional_id = $save->id; // Link to the main record
                $savePdf->save();
            }
        }
        $log = ExhibitionLog::where('section', 'sosmed')->where('company_id', $userId)->first();
        if ($log == null) {
            $log = new ExhibitionLog();
            $log->section = 'sosmed';
            $log->company_id = $userId;
        }
        $log->updated_at = Carbon::now();
        $log->save();
        return redirect()->back();
    }

    public function delete($id)
    {
        $userId = auth()->id();
        $data = ExhibitionPromotionalList::findOrFail($id);
        $data->delete();
        $log = ExhibitionLog::where('section', 'advertisement')->where('company_id', $userId)->first();
        if ($log == null) {
            $log = new ExhibitionLog();
            $log->section = 'advertisement';
            $log->company_id = $userId;
        }
        $log->updated_at = Carbon::now();
        $log->save();
        return response()->json(['message' => 'success deleted']);
    }
}
