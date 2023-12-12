<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
        $save->ms_company_type_id = $company_type;
        $save->company_name = $company_name;
        $save->email_alternate = $email_alternate;
        $save->ms_phone_code_id = $phone_code;
        $save->is_register = 1;
        $save->name_pic = $name;
        $save->save();
        return redirect()->back();
    }

    public function postCompany(Request $request)
    {
        $id = auth()->id();

        //Company Information
        $company_web = $request->company_web;
        $email = $request->email;

        $nonresidence = $request->nonresidence;
        $answerresidence = $request->answerresidence;
        $company_address = $request->company_address;
        $company_phone = $request->company_phone;
        $post_code = $request->post_code;
        $category_id = $request->company_category;
        // $category_name = $request->category_name;
        $project_type = $request->project_type;
        $country = $request->country;
        $state = $request->state;
        $city = $request->city;
        $classify_minerals_id = $request->classify_minerals_id;
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
        return redirect()->back();
    }
}
