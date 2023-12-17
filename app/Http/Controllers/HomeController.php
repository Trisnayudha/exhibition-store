<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = [];
        $companyData = $this->getCompanyInformation();
        $presentaseCompany = $this->hitungPersentaseKemajuan($companyData);
        $data['countCompany'] = $presentaseCompany;
        // dd($data);
        return view('frontend.home.index', $data);
    }



    private function getCompanyInformation()
    {
        $id = auth()->id();
        $data = Company::where('id', $id)->first();

        if (!$data) {
            return []; // atau lakukan penanganan error jika data tidak ditemukan
        }

        return [
            'name' => $data->name,
            'company_type' => $data->ms_company_category_id,
            'company_name' => $data->company_name,
            'job_title' => $data->job_title,
            'email_alternate' => $data->email_alternate,
            'phone_code' => $data->ms_phone_code_id,
            'phone' => $data->phone,
            'company_web' => $data->company_web,
            'email' => $data->email,
            'desc' => $data->desc,
            'nonresidence' => $data->nonresidence,
            'answerresidence' => $data->nonresidence == 'No' ? 'Free data' : $data->answerresidence,
            'company_address' => $data->company_address,
            'company_phone' => $data->company_phone,
            'post_code' => $data->post_code,
            'category_id' => $data->ms_company_category_id,
            'country' => $data->country,
            'state' => $data->state,
            'city' => $data->city,
        ];
    }


    private function hitungPersentaseKemajuan($data)
    {
        $jumlahField = count($data); // Menghitung jumlah field
        $fieldTerisi = 0;

        foreach ($data as $value) {
            if (!is_null($value)) {
                $fieldTerisi++;
            }
        }

        // Menghitung persentase dan mengonversinya menjadi integer
        return intval(($fieldTerisi / $jumlahField) * 100);
    }
}
