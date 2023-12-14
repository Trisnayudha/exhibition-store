<?php

namespace App\Http\Controllers\MiningDirectory;

use App\Http\Controllers\Controller;
use App\Models\Logs\ExhibitionLog;
use App\Models\MiningDirectory\Project\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function index()
    {
        $id = auth()->id();
        $data = Project::where('company_id', $id)->orderby('id', 'desc')->get();
        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'category' => 'required',
            'desc' => 'required',
            // 'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Aturan untuk gambar
            // 'file' => 'file|mimes:pdf|max:10240', // Aturan untuk file (maksimal 10MB)
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Proses penyimpanan data
        $project = new Project;
        $project->title = $request->title;
        $project->project_category_id = $request->category;
        $project->desc = $request->desc;

        // Simpan gambar jika ada
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $project->image = 'images/' . $imageName;
        }
        // Pengaturan tambahan
        $project->company_id = auth()->id(); // Misalnya, menyimpan ID perusahaan dari pengguna yang terautentikasi
        $project->date_project = $request->project_date; // Menyimpan tanggal saat ini
        $project->slug = Str::slug($project->title); // Menggunakan helper Str untuk membuat URL yang bersih

        $project->save();
        $company_id = auth()->id();
        $log = ExhibitionLog::where('section', 'project')->where('company_id', $company_id)->first();
        if ($log == null) {
            $log = new ExhibitionLog();
            $log->section = 'project';
            $log->company_id = $company_id;
        }
        $log->updated_at = Carbon::now();
        $log->save();
        return response()->json(['message' => 'Data berhasil disimpan', 'data' => $project]);
    }

    public function show($id)
    {
        $project = Project::findOrFail($id);

        return response()->json(['data' => $project]);
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
        $project = Project::findOrFail($id);
        $project->title = $request->title;
        $project->project_category_id = $request->category;
        $project->desc = $request->description;
        // Update gambar jika disediakan
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $project->image = 'images/' . $imageName;
        }
        // Pengaturan tambahan
        $project->company_id = auth()->id(); // Misalnya, menyimpan ID perusahaan dari pengguna yang terautentikasi
        $project->date_project = $request->date; // Menyimpan tanggal saat ini
        $project->slug = Str::slug($project->title); // Menggunakan helper Str untuk membuat URL yang bersih

        $project->save();
        $company_id = auth()->id();
        $log = ExhibitionLog::where('section', 'project')->where('company_id', $company_id)->first();
        if ($log == null) {
            $log = new ExhibitionLog();
            $log->section = 'project';
            $log->company_id = $company_id;
        }
        $log->updated_at = Carbon::now();
        $log->save();
        return response()->json(['message' => 'Data berhasil diperbarui', 'data' => $project]);
    }

    public function destroy($id)
    {
        $representative = Project::findOrFail($id);
        $representative->delete();
        $company_id = auth()->id();
        $log = ExhibitionLog::where('section', 'project')->where('company_id', $company_id)->first();
        if ($log == null) {
            $log = new ExhibitionLog();
            $log->section = 'project';
            $log->company_id = $company_id;
        }
        $log->updated_at = Carbon::now();
        $log->save();
        return response()->json(['message' => 'Data berhasil dihapus']);
    }

    public function log()
    {
        $userId = auth()->id();
        $data = ExhibitionLog::where('section', 'project')->where('company_id', $userId)->first();
        return $data;
    }
}
