<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Company\CompanyService;
use App\Models\Exhibition\ExhibitionMiningPassProgress;
use App\Models\Logs\ExhibitionLog;
use App\Models\MiningDirectory\Media\MediaCategory;
use App\Models\MiningDirectory\News\NewsCategory;
use App\Models\MiningDirectory\Products\ProductCategory;
use App\Models\MiningDirectory\Project\ProjectCategory;
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
use App\Models\Promotional\ExhibitionPromotional;
use App\Models\Promotional\ExhibitionPromotionalList;
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
        $data['form_number'] = 1;
        $data['type'] = $type;
        $data['access'] = $this->getAccess();
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
            $data['project_category'] = $this->getProjectCategory();
            $data['news_category'] = $this->getNewsCategory();
            // dd($data['video']);
            // dd($data);
            return view('frontend.form.form-2.form-2', $data);
        } elseif ($type == 'promotional') {
            $data['advertisement'] = $this->getAdvertisement();
            $data['log_advertisement'] = $this->getLogs('advertisement');
            $data['data'] = $this->getDetail();
            $data['sosmed'] = $this->getSosmed();
            $data['log_sosmed'] = $this->getLogs('sosmed');
            // dd($data);
            return view('frontend.form.form-3.form-3', $data);
        } elseif ($type == 'event-pass') {
            $data['company_type'] = MsCompanyType::get();
            $data['phone_code'] = MsPhoneCode::get();
            $data['progress'] = $this->getEventPassProgress();
            return view('frontend.form.form-4.form-4', $data);
        } elseif ($type == 'exhibition') {
            $data['data'] = $this->getDetail();
            $data['log_pic'] = $this->getLogs('pic');
            $data['fascia_name'] = $this->fasciaName();
            return view('frontend.form.form-5.form-5', $data);
        } else {
            dd('data tidak ada');
        }
    }

    private function getEventPassProgress()
    {
        $userId = auth()->id();
        return ExhibitionMiningPassProgress::where('company_id', $userId)->first();
    }

    private function fasciaName()
    {
        $data = $this->getDetail();
        // Membagi teks menjadi array dengan setiap karakter menjadi elemen array
        $fasciaNameArray = str_split($data->fascia_name);
        return $fasciaNameArray;
    }
    private function getAccess()
    {
        $data = auth()->user(); // Mengambil nama pengguna dari objek auth
        return [
            'promotional_access' => $data->promotional_access ?? 0,
            'eventpass_access' => $data->eventpass_access ?? 0,
            'exhibition_access' => $data->exhibition_access ?? 0,
            'delegate_pass' => $data->delegate_pass ?? 0,
            'exhibitor_pass' => $data->exhibitor_pass ?? 0,
            'working_pass' => $data->working_pass ?? 0,
        ];
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

    private function getProjectCategory()
    {
        $data = ProjectCategory::get();
        return $data;
    }

    private function getNewsCategory()
    {
        $data = NewsCategory::get();
        return $data;
    }

    private function getAdvertisement()
    {
        $userId = auth()->id();
        $data = ExhibitionPromotional::where('company_id', $userId)->where('section', 'advertisement')->first();
        return $data;
    }

    private function getSosmed()
    {
        $userId = auth()->id();
        $list = [];
        $data = ExhibitionPromotional::where('company_id', $userId)->where('section', 'sosmed')->first();
        // dd($data);
        if ($data) {
            $listImages = ExhibitionPromotionalList::where('exhibition_promotional_id', $data->id)->where('section', 'image')->get();
            $listPdf = ExhibitionPromotionalList::where('exhibition_promotional_id', $data->id)->where('section', 'pdf')->get();
        }
        $list = [
            'data' => $data ?? null,
            'listImages' => $listImages ?? null,
            'listPdf' => $listPdf ?? null
        ];
        return $list;
    }
}
