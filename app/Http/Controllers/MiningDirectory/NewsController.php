<?php

namespace App\Http\Controllers\MiningDirectory;

use App\Http\Controllers\Controller;
use App\Models\Logs\ExhibitionLog;
use App\Models\MiningDirectory\News\News;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class NewsController extends Controller
{
    public function index()
    {
        $id = auth()->id();
        $data = News::where('company_id', $id)->orderby('id', 'desc')->get();
        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {
        $id = auth()->id();
        $title = $request->title;
        $news_category_id = $request->news_category_id;
        $date_news = $request->date_news;
        $desc = $request->desc;
        $image = $request->file('image'); // Gunakan file() untuk mendapatkan file yang di-upload

        $save = new News();
        $save->highlight = "No";
        $save->all_highlight = "No";
        $save->flag = "Company";
        $save->title = $title;
        $save->news_category_id = $news_category_id;
        $save->company_id = $id;
        $save->date_news = $date_news;
        $save->desc = $desc;

        // Handle image upload if needed
        if ($image) {
            // Simpan gambar ke direktori yang diinginkan (public/images misalnya)
            $imageName = time() . '.' . $request->image->extension();
            $save_folder = $request->image->storeAs('public/images/news/', $imageName);
            $db = '/storage/images/news/' . $imageName;
            // Simpan path gambar ke dalam kolom image di tabel
            $save->image = $db;
        }

        $save->save();
        $company_id = auth()->id();
        $log = ExhibitionLog::where('section', 'news')->where('company_id', $company_id)->first();
        if ($log == null) {
            $log = new ExhibitionLog();
            $log->section = 'news';
            $log->company_id = $company_id;
        }
        $log->updated_at = Carbon::now();
        $log->save();
        return response()->json(['message' => 'Berhasil disimpan']);
    }



    public function show($id)
    {
        $representative = News::findOrFail($id);

        return response()->json(['data' => $representative]);
    }

    public function update(Request $request, $id)
    {
        $title = $request->title;
        $news_category_id = $request->news_category_id;
        $date_news = $request->date_news;
        $desc = $request->desc;
        $image = $request->file('image'); // Gunakan file() untuk mendapatkan file yang di-upload

        $save = News::findOrFail($id);
        $save->highlight = "No";
        $save->all_highlight = "No";
        $save->flag = "Company";
        $save->title = $title;
        $save->news_category_id = $news_category_id;
        $save->company_id = auth()->id();
        $save->date_news = $date_news;
        $save->desc = $desc;

        // Handle image upload if needed
        if ($image) {
            // Simpan gambar ke direktori yang diinginkan (public/images misalnya)
            $imageName = time() . '.' . $request->image->extension();
            $save_folder = $request->image->storeAs('public/images/news/', $imageName);
            $db = '/storage/images/news/' . $imageName;
            // Simpan path gambar ke dalam kolom image di tabel
            $save->image = $db;
        }

        $save->save();
        $company_id = auth()->id();
        $log = ExhibitionLog::where('section', 'news')->where('company_id', $company_id)->first();
        if ($log == null) {
            $log = new ExhibitionLog();
            $log->section = 'news';
            $log->company_id = $company_id;
        }
        $log->updated_at = Carbon::now();
        $log->save();
        return response()->json(['message' => $request->image]);
    }

    public function destroy($id)
    {
        $representative = News::findOrFail($id);
        $representative->delete();
        $company_id = auth()->id();
        $log = ExhibitionLog::where('section', 'news')->where('company_id', $company_id)->first();
        if ($log == null) {
            $log = new ExhibitionLog();
            $log->section = 'news';
            $log->company_id = $company_id;
        }
        $log->updated_at = Carbon::now();
        $log->save();
        return response()->json(['message' => 'Data berhasil dihapus']);
    }

    public function log()
    {
        $userId = auth()->id();
        $data = ExhibitionLog::where('section', 'news')->where('company_id', $userId)->first();
        return $data;
    }
}
