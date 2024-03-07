<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Exhibition\ExhibitionCartList;
use App\Models\Exhibition\ExhibitionSticker;
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
        if ($pic_name !== null) {
            $save->pic_name = $pic_name;
        }

        if ($pic_job_title !== null) {
            $save->pic_job_title = $pic_job_title;
        }

        if ($pic_email !== null) {
            $save->pic_email = $pic_email;
        }

        if ($pic_phone !== null) {
            $save->pic_phone = $pic_phone;
        }
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

    public function storeSticker(Request $request)
    {
        $company_id = auth()->id();

        if (request('back-doff-basic') != 0) {
            $cart = new ExhibitionCartList();
            $cart->name_product = request('back-doof-product-basic'); // Ubah sesuai dengan nama produk yang sesuai
            $cart->quantity = request('back-doff-basic');
            $cart->section_product = request('back-doof-section-basic');
            $cart->price = request('back-doof-price-basic');
            $cart->total_price = $cart->quantity * $cart->price;
            $cart->image = request('back-doof-image-basic');
            $cart->company_id = $company_id;
            $cart->save();
        }

        if (request('side-doff-basic') != 0) {
            $cart = new ExhibitionCartList(); // Buat instance baru jika nilai side-doff-basic tidak 0
            $cart->name_product = request('side-doof-product-basic'); // Ubah sesuai dengan nama produk yang sesuai
            $cart->quantity = request('side-doff-basic');
            $cart->section_product = request('side-doof-section-basic');
            $cart->price = request('side-doof-price-basic');
            $cart->total_price = $cart->quantity * $cart->price;
            $cart->image = request('side-doof-image-basic');
            $cart->company_id = $company_id;
            $cart->save();
        }

        if (request('table-basic') != 0) {
            $cart = new ExhibitionCartList(); // Buat instance baru jika nilai table-basic tidak 0
            $cart->name_product = request('table-doof-product-basic'); // Ubah sesuai dengan nama produk yang sesuai
            $cart->quantity = request('table-basic');
            $cart->section_product = request('table-doof-section-basic');
            $cart->price = request('table-doof-price-basic');
            $cart->total_price = $cart->quantity * $cart->price;
            $cart->image = request('table-doof-image-basic');
            $cart->company_id = $company_id;
            $cart->save();
        }

        if (request('basicA') == "on") {
            $stickerA = new ExhibitionSticker(); // Gantilah dengan model yang sesuai
            $stickerA->printing_position = 'A';
            $stickerA->section_sticker = 'basic';
            $stickerA->note = request('note-basicA');
            $stickerA->company_id = $company_id;

            // Handle file upload for basicA
            if (request()->hasFile('file-basicA')) {
                $file = request()->file('file-basicA');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/uploads', $filename); // Simpan file ke direktori yang sesuai
                $db = 'storage/uploads/' . $filename;
                $stickerA->file = $db;
            }

            $stickerA->save();
        }

        if (request('basicB') == "on") {
            $stickerB = new ExhibitionSticker(); // Gantilah dengan model yang sesuai
            $stickerB->printing_position = 'B';
            $stickerB->section_sticker = 'basic';
            $stickerB->note = request('note-basicB');
            $stickerB->company_id = $company_id;

            // Handle file upload for basicB
            if (request()->hasFile('file-basicB')) {
                $file = request()->file('file-basicB');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/uploads', $filename); // Simpan file ke direktori yang sesuai
                $db = 'storage/uploads/' . $filename;
                $stickerB->file = $db;
            }

            $stickerB->save();
        }

        if (request('basicC') == "on") {
            $stickerC = new ExhibitionSticker(); // Gantilah dengan model yang sesuai
            $stickerC->printing_position = 'C';
            $stickerC->section_sticker = 'basic';
            $stickerC->note = request('note-basicC');
            $stickerC->company_id = $company_id;

            // Handle file upload for basicC
            if (request()->hasFile('file-basicC')) {
                $file = request()->file('file-basicC');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/uploads', $filename); // Simpan file ke direktori yang sesuai
                $db = 'storage/uploads/' . $filename;
                $stickerC->file = $db;
            }

            $stickerC->save();
        }

        if (request('basicD') == "on") {
            $stickerD = new ExhibitionSticker(); // Gantilah dengan model yang sesuai
            $stickerD->printing_position = 'D';
            $stickerD->section_sticker = 'basic';
            $stickerD->note = request('note-basicD');
            $stickerD->company_id = $company_id;

            // Handle file upload for basicD
            if (request()->hasFile('file-basicD')) {
                $file = request()->file('file-basicD');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/uploads', $filename); // Simpan file ke direktori yang sesuai
                $db = 'storage/uploads/' . $filename;
                $stickerD->file = $db;
            }

            $stickerD->save();
        }

        if (request('basicE') == "on") {
            $stickerE = new ExhibitionSticker(); // Gantilah dengan model yang sesuai
            $stickerE->printing_position = 'E';
            $stickerE->section_sticker = 'basic';
            $stickerE->note = request('note-basicE');
            $stickerE->company_id = $company_id;

            // Handle file upload for basicE
            if (request()->hasFile('file-basicE')) {
                $file = request()->file('file-basicE');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/uploads', $filename); // Simpan file ke direktori yang sesuai
                $db = 'storage/uploads/' . $filename;
                $stickerE->file = $db;
            }

            $stickerE->save();
        }

        if (request('basicF') == "on") {
            $stickerE = new ExhibitionSticker(); // Gantilah dengan model yang sesuai
            $stickerE->printing_position = 'F';
            $stickerE->section_sticker = 'basic';
            $stickerE->note = request('note-basicF');
            $stickerE->company_id = $company_id;

            // Handle file upload for basicE
            if (request()->hasFile('file-basicF')) {
                $file = request()->file('file-basicF');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/uploads', $filename); // Simpan file ke direktori yang sesuai
                $db = 'storage/uploads/' . $filename;
                $stickerE->file = $db;
            }

            $stickerE->save();
        }

        if (request('basicG') == "on") {
            $stickerE = new ExhibitionSticker(); // Gantilah dengan model yang sesuai
            $stickerE->printing_position = 'G';
            $stickerE->section_sticker = 'basic';
            $stickerE->note = request('note-basicG');
            $stickerE->company_id = $company_id;

            // Handle file upload for basicG
            if (request()->hasFile('file-basicG')) {
                $file = request()->file('file-basicG');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/uploads', $filename); // Simpan file ke direktori yang sesuai
                $db = 'storage/uploads/' . $filename;
                $stickerE->file = $db;
            }

            $stickerE->save();
        }

        if (request('basicH') == "on") {
            $stickerE = new ExhibitionSticker(); // Gantilah dengan model yang sesuai
            $stickerE->printing_position = 'H';
            $stickerE->section_sticker = 'basic';
            $stickerE->note = request('note-basicH');
            $stickerE->company_id = $company_id;

            // Handle file upload for basicH
            if (request()->hasFile('file-basicH')) {
                $file = request()->file('file-basicH');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/uploads', $filename); // Simpan file ke direktori yang sesuai
                $db = 'storage/uploads/' . $filename;
                $stickerE->file = $db;
            }

            $stickerE->save();
        }

        if (request('basicI') == "on") {
            $stickerE = new ExhibitionSticker(); // Gantilah dengan model yang sesuai
            $stickerE->printing_position = 'I';
            $stickerE->section_sticker = 'basic';
            $stickerE->note = request('note-basicI');
            $stickerE->company_id = $company_id;

            // Handle file upload for basicI
            if (request()->hasFile('file-basicI')) {
                $file = request()->file('file-basicI');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/uploads', $filename); // Simpan file ke direktori yang sesuai
                $db = 'storage/uploads/' . $filename;
                $stickerE->file = $db;
            }

            $stickerE->save();
        }

        if (request('basicJ') == "on") {
            $stickerE = new ExhibitionSticker(); // Gantilah dengan model yang sesuai
            $stickerE->printing_position = 'E';
            $stickerE->section_sticker = 'basic';
            $stickerE->note = request('note-basicJ');
            $stickerE->company_id = $company_id;

            // Handle file upload for basicJ
            if (request()->hasFile('file-basicJ')) {
                $file = request()->file('file-basicJ');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/uploads', $filename); // Simpan file ke direktori yang sesuai
                $db = 'storage/uploads/' . $filename;
                $stickerE->file = $db;
            }

            $stickerE->save();
        }

        $log = ExhibitionLog::where('section', 'sticker')->where('company_id', $company_id)->first();
        if ($log == null) {
            $log = new ExhibitionLog();
            $log->section = 'sticker';
            $log->company_id = $company_id;
        }
        $log->updated_at = Carbon::now();
        $log->save();
        return redirect()->back()->with('success', 'Success added Additional Sticker');
    }
}
