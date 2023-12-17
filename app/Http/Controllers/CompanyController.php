<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Logs\ExhibitionLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use app\Helpers\General;
use App\Models\Company\CompanyVideo;

class CompanyController extends Controller
{
    public function postPersonal(Request $request)
    {
        $id = auth()->id();

        //Personal Information
        $prefix_name = $request->prefix_name;
        $name = $request->name;
        $company_type = $request->company_type;
        $company_name = $request->company_name;
        $job_title = $request->job_title;
        $email_alternate = $request->alternative_email;
        $phone_code = $request->phone_code;
        $phone = $request->phone;
        $save = Company::where('id', $id)->first();
        $save->created_at = date('Y-m-d H:i:s');
        $save->ms_prefix_call_id = $prefix_name;
        $save->name = $name;
        $slug = date('Y-m-dHis') . '-' . Str::slug($company_name);
        $save->job_title = $job_title;
        $save->phone = $phone;
        $save->ms_company_type_id = $company_type;
        $save->company_name = $company_name;
        $save->email_alternate = $email_alternate;
        $save->ms_phone_code_id = $phone_code;
        $save->is_register = 1;
        $save->name_pic = $name;
        $save->save();

        $log = ExhibitionLog::where('section', 'personal_information')->where('company_id', $id)->first();
        if ($log == null) {
            $log = new ExhibitionLog();
            $log->section = 'personal_information';
            $log->company_id = $id;
        }
        $log->updated_at = Carbon::now();
        $log->save();
        return redirect()->back();
    }

    public function postCompany(Request $request)
    {
        $id = auth()->id();

        //Company Information
        $company_web = $request->company_web;
        $email = $request->email;
        $desc =  $request->desc;
        $nonresidence = $request->nonresidence;
        $answerresidence = $request->answerresidence;
        $company_address = $request->company_address;
        $company_phone = $request->company_phone;
        $post_code = $request->post_code;
        $category_id = $request->company_category;
        $country = $request->country;
        $state = $request->state;
        $city = $request->city;

        // $category_name = $request->category_name;
        $classify_minerals_id = $request->classify_minerals_id;
        $project_type = $request->project_type;
        // $classify_minerals_name = $request->classify_minerals_name;
        $classify_mining_id = $request->classify_mining_id;
        $commodities_minerals_coal_id = $request->commodities_minerals_coal_id;
        $commodities_minerals_id = $request->commodities_minerals_id;
        $commodities_mining_id = $request->commodities_mining_id;
        $origin_manufacturer_id = $request->origin_manufacturer_id;
        $question_would = $request->question_would;
        $ms_company_class_id = $request->ms_company_class_id;


        $save = Company::where('id', $id)->first();

        $save->company_web = $company_web;
        $save->email = $email;


        $save->company_address = $company_address;
        $save->country = strtoupper($country);
        $save->state = strtoupper($state);
        $save->city = strtoupper($city);
        $save->post_code = $post_code;
        $save->desc = $desc;
        $save->company_phone = $company_phone;
        // $save->ms_company_category_other = $category_name;
        $save->ms_company_category_id = $category_id;
        $save->ms_company_project_type_id = $project_type;
        $save->ms_class_company_minerals_id = $classify_minerals_id;
        $save->ms_class_company_mining_id = $classify_mining_id;
        $save->ms_commod_company_minerals_id = $commodities_minerals_id;
        $save->ms_commod_company_minerals_coal_id = $commodities_minerals_coal_id;
        $save->ms_commod_company_mining_id = $commodities_mining_id;
        $save->ms_origin_manufactur_company_id = $origin_manufacturer_id;
        $save->with_information = $question_would;
        $save->ms_company_class_id = $ms_company_class_id;
        // $save->type = 'Trial';
        // $save->class_company_minerals_other = $classify_minerals_name;
        // $save->class_company_mining_other = $classify_mining_name;
        // $save->commod_company_minerals_other = $commodities_minerals_name;
        // $save->commod_company_minerals_coal_other = $commodities_minerals_coal_name;
        // $save->commod_company_mining_other = $commodities_mining_name;
        // $save->origin_manufactur_company_other = $origin_manufacturer_name;
        $save->save();


        $log = ExhibitionLog::where('section', 'company_information')->where('company_id', $id)->first();
        if ($log == null) {
            $log = new ExhibitionLog();
            $log->section = 'company_information';
            $log->company_id = $id;
        }
        $log->updated_at = Carbon::now();
        $log->save();
        return redirect()->back();
    }

    public function postGeneral(Request $request)
    {
        $id = auth()->id();
        $info_one = $request->info_one;
        $info_two = $request->info_two;
        $info_three = $request->info_three;
        $linkedin = $request->linkedin;
        $facebook = $request->facebook;
        $instagram = $request->instagram;
        $main_video = $request->main_video;
        $video_1 = $request->video_1;
        $video_2 = $request->video_2;
        $video_3 = $request->video_3;

        // dd($request->all());
        $image = $request->input('cropped_image');

        $save = Company::where('id', $id)->first();
        if ($image != null) {

            // Konversi gambar ke base64
            $response = Http::post('http://127.0.0.1:6969/api/upload-image/exhibition', [
                'image' => $image,
            ]);

            // Ambil path URL dari respons
            $fullPath = $response['image'];
            $save->image = $fullPath;
        }
        $save->info_one = $info_one;
        $save->info_two = $info_two;
        $save->info_three = $info_three;
        $save->facebook = $facebook;
        $save->linkedin = $linkedin;
        $save->instagram = $instagram;
        $save->save();

        $videoSections = ['Main Video', 'Video 1', 'Video 2', 'Video 3'];

        foreach ($videoSections as $section) {
            $video = CompanyVideo::where('company_id', $id)->where('section', $section)->first();

            if (empty($video)) {
                $video = new CompanyVideo();
            }

            switch ($section) {
                case 'Main Video':
                    $video->url = $main_video;
                    $video->is_main = 1;
                    break;

                case 'Video 1':
                    $video->url = $video_1;
                    break;

                case 'Video 2':
                    $video->url = $video_2;
                    break;

                case 'Video 3':
                    $video->url = $video_3;
                    break;

                    // Add more cases as needed

                default:
                    // Handle other cases if necessary
                    break;
            }

            $video->company_id = $id;
            $video->section = $section;
            $video->save();
        }


        // dd($youtube_res);
        $log = ExhibitionLog::where('section', 'general')->where('company_id', $id)->first();
        if ($log == null) {
            $log = new ExhibitionLog();
            $log->section = 'general';
            $log->company_id = $id;
        }
        $log->updated_at = Carbon::now();
        $log->save();
        return redirect()->back();
    }
}
