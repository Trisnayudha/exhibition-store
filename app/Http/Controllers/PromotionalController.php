<?php

namespace App\Http\Controllers;

use App\Models\Promotional\ExhibitionPromotional;
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
        dd($request->all());
    }
}
