<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Company\CompanyService;
use App\Models\Logs\ExhibitionLog;
use App\Models\MiningDirectory\Media\MediaCategory;
use App\Models\MiningDirectory\Products\ProductCategory;
use App\Models\Ms\MsClassCompanyMinerals;
use App\Models\Ms\MsClassCompanyMining;
use App\Models\Ms\MsCommodCompanyMinerals;
use App\Models\Ms\MsCommodCompanyMineralsCoal;
use App\Models\Ms\MsCommodCompanyMining;
use App\Models\Ms\MsCompanyCategory;
use App\Models\Ms\MsCompanyClass;
use App\Models\Ms\MsCompanyProjectType;
use App\Models\Ms\MsCompanyType;
use App\Models\Ms\MsOriginManufacturCompany;
use App\Models\Ms\MsPhoneCode;
use App\Models\Ms\MsPrefixCall;
use Illuminate\Http\Request;

class FormController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $type = $request->type;
        $data = [];
        $data['type'] = $type;
        if ($type == 'company-information') {
            $data['prefix_name'] = MsPrefixCall::get();
            $data['company_type'] = MsCompanyType::get();
            $data['phone_code'] = MsPhoneCode::get();
            $data['company_category'] = MsCompanyCategory::get();
            $data['classify_minerals'] = MsClassCompanyMinerals::get();
            $data['classify_mining'] = MsClassCompanyMining::get();
            $data['project_type'] = MsCompanyProjectType::get();
            $data['commodities_minerals'] = MsCommodCompanyMinerals::get();
            $data['commodities_minerals_coal'] = MsCommodCompanyMineralsCoal::get();
            $data['commodities_mining'] = MsCommodCompanyMining::get();
            $data['origin_manufacturer'] = MsOriginManufacturCompany::get();
            $data['ms_company_class'] = MsCompanyClass::get();
            $data['data'] = $this->getDetail();
            $data['personal_information'] = $this->getLogs('personal_information');
            $data['company_information'] = $this->getLogs('company_information');
            // dd($data['section']);
            return view('frontend.form.form-1.form-1', $data);
        } elseif ($type == 'indonesia-miner-directory') {
            $data['data'] = $this->getDetail();
            $data['video'] = $this->getDataVideo();
            $data['general'] = $this->getLogs('general');
            $data['media_category'] = $this->getMediaCategory();
            $data['product_category'] = $this->getProductCategory();
            // dd($data['video']);
            // dd($data);
            return view('frontend.form.form-2.form-2', $data);
        } elseif ($type == 'promotional') {
            return view('frontend.form.form-3.form-3', $data);
        } elseif ($type == 'event-pass') {
            return view('frontend.form.form-4.form-4', $data);
        } elseif ($type == 'exhibition') {
            return view('frontend.form.form-5.form-5', $data);
        } else {
            dd('data tidak ada');
        }
    }

    private function getDetail()
    {
        $userId = auth()->id();
        $data = CompanyService::detailForm($userId);
        return $data;
    }

    private function getDataVideo()
    {
        $userId = auth()->id();
        $videoData = CompanyService::detailVideo($userId);

        $videos = [];
        $count = 0;
        foreach ($videoData as $video) {
            if ($video->is_main) {
                $videos['main_video'] = $video->url;
            } else {
                $videos["video_{$count}"] = $video->url;
            }
            $count++;
        }
        // dd($videos);
        return $videos;
    }

    private function getLogs($section)
    {

        $userId = auth()->id();

        $data = ExhibitionLog::where('section', $section)->where('company_id', $userId)->first();
        return $data;
    }

    private function getMediaCategory()
    {
        $data = MediaCategory::get();
        return $data;
    }

    private function getProductCategory()
    {
        $data = ProductCategory::get();
        return $data;
    }
}
