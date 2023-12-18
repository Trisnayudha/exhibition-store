<?php

namespace App\Http\Controllers;

use App\Models\Promotional\ExhibitionPromotional;
use App\Models\Promotional\ExhibitionPromotionalList;
use Illuminate\Http\Request;

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
            if ($request->hasFile('pdfFiles')) {
                $fileName = time() . '.' . $request->file('pdfFiles')->extension();
                $save_folder = $request->file('pdfFiles')->storeAs('public/files/promotional/advertisement/', $fileName);
                $db = '/storage/files/promotional/advertisement/' . $fileName;
                $save->file = $db;
            }
        }

        $save->save();
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
                $fileName = time() . '_' . $image->getClientOriginalName();
                $filePath = $image->storeAs('public/files/promotional/sosmed/', $fileName);
                $dbPath = '/storage/files/promotional/sosmed/' . $fileName;

                // Save image record to ExhibitionPromotionalList
                $saveImage = new ExhibitionPromotionalList();
                $saveImage->file = $dbPath;
                $saveImage->section = 'image';
                $saveImage->exhibition_promotional_id = $save->id; // Link to the main record
                $saveImage->save();
            }
        }

        // Process PDF files
        if ($pdfs) {
            foreach ($pdfs as $pdf) {
                $fileName = time() . '_' . $pdf->getClientOriginalName();
                $filePath = $pdf->storeAs('public/files/promotional/sosmed/', $fileName);
                $dbPath = '/storage/files/promotional/sosmed/' . $fileName;

                // Save PDF record to ExhibitionPromotionalList
                $savePdf = new ExhibitionPromotionalList();
                $savePdf->file = $dbPath;
                $savePdf->section = 'pdf';
                $savePdf->exhibition_promotional_id = $save->id; // Link to the main record
                $savePdf->save();
            }
        }

        return redirect()->back();
    }

    public function delete($id)
    {
        $data = ExhibitionPromotionalList::findOrFail($id);
        $data->delete();

        return response()->json(['message' => 'success deleted']);
    }
}
