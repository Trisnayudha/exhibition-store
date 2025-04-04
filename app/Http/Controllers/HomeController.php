<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Company\CompanyService;
use App\Models\MiningDirectory\CompanyRepresentative;
use App\Models\MiningDirectory\Media\MediaResource;
use App\Models\MiningDirectory\News\News;
use App\Models\MiningDirectory\Products\Product;
use App\Models\MiningDirectory\Project\Project;
use App\Models\Payment;
use App\Models\Promotional\ExhibitionPromotional;
use App\Models\Promotional\ExhibitionPromotionalList;
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
        $presentaseCompany = $this->countPercen($companyData);
        $data['access'] = $this->getAccess();
        $data['countCompany'] = $presentaseCompany;
        if ($data['access']['directory_access'] == 1) {
            $miningDirectory = $this->getIndonesiaMinerDirectory();
            $presentaseMiningDirectory = $this->countPercen($miningDirectory);
            $data['countMiningDirectory'] = $presentaseMiningDirectory;
        }
        if ($data['access']['promotional_access'] == 1) {
            $promotional = $this->getPromotional();
            $presentasePromotional = $this->countPercen($promotional);
            $data['countPromotional'] = $presentasePromotional;
        }
        if ($data['access']['eventpass_access'] == 1) {
            $eventPass = $this->getEventPass();
            $presentaseEventPass = $this->countPercen($eventPass);
            $data['countEventPass'] = $presentaseEventPass;
        }
        if ($data['access']['exhibition_access'] == 1) {
            $exhibition = $this->getExhibition();
            $presentaseExhibition = $this->countPercen($exhibition);
            $data['countExhibition'] = $presentaseExhibition;
        }
        // dd($data['access']);
        return view('frontend.home.index', $data);
    }

    private function getExhibition()
    {
        $id = auth()->id();
        $data = Company::where('id', $id)->first();

        return [
            'pic_name' => isset($data->pic_name) && !empty($data->pic_name) ? $data->pic_name : null,
            'pic_job_title' => isset($data->pic_job_title) && !empty($data->pic_job_title) ? $data->pic_job_title : null,
            'pic_phone' => isset($data->pic_phone) && !empty($data->pic_phone) ? $data->pic_phone : null,
            'pic_email' => isset($data->pic_email) && !empty($data->pic_email) ? $data->pic_email : null,
            'pic_signature' => isset($data->pic_signature) && !empty($data->pic_signature) ? $data->pic_signature : null,
            'fascia_name' => $data->exhibition_design == 1
                ? (isset($data->fascia_name) && !empty($data->fascia_name) ? $data->fascia_name : null)
                : true,
        ];
    }


    private function getEventPass()
    {
        $id = auth()->id();
        $countPass = $this->getCountPass();

        // Mendapatkan jumlah delegatePass dan exhibitionPass aktif dari database
        $delegatePassCount = Payment::where('payment.company_id', $id)
            ->where('payment.type', 'Exhibition Delegate')->count();
        $exhibitorPassCount = Payment::where('payment.company_id', $id)
            ->whereIn('payment.type', ['Exhibition Upgrade', 'Exhibition Exhibitor'])->count();

        $result = [];

        // Mengisi delegatePass
        for ($i = 1; $i <= $countPass['delegate_pass']; $i++) {
            $delegatePassKey = 'delegatePass_' . $i;
            $result[$delegatePassKey] = ($i <= $delegatePassCount) ? true : null;
        }

        // Mengisi exhibitionPass
        for ($i = 1; $i <= $countPass['exhibitor_pass']; $i++) {
            $exhibitionPassKey = 'exhibitorPass_' . $i;
            $result[$exhibitionPassKey] = ($i <= $exhibitorPassCount) ? true : null;
        }

        $workingPass = Payment::where('payment.company_id', $id)
            ->where('payment.type', 'Exhibition Working')->first();

        $miningPass =  Payment::where('payment.company_id', $id)
            ->where('payment.type', 'Exhibition Mining')->first();
        $result['workingPass'] = $workingPass ? true : null;
        $result['miningPass'] = $miningPass ? true : null;
        return $result;
    }

    private function getCountPass()
    {
        $data = auth()->user(); // Mengambil nama pengguna dari objek auth
        return [
            'delegate_pass' => $data->delegate_pass ?? 0,
            'exhibitor_pass' => $data->exhibitor_pass ?? 0,
        ];
    }
    private function getAccess()
    {
        $data = auth()->user(); // Mengambil nama pengguna dari objek auth
        return [
            'directory_access' => $data->directory_access ?? 0,
            'promotional_access' => $data->promotional_access ?? 0,
            'eventpass_access' => $data->eventpass_access ?? 0,
            'exhibition_access' => $data->exhibition_access ?? 0,
        ];
    }
    private function getPromotional()
    {
        $id = auth()->id();
        $level = auth()->user()->level;
        if ($level == 'sponsors' || $level == 'exhibition_sponsor') {
            $data = $this->getAdvertisement();
            return [
                'file' => $data->file ?? null,
                'link' => $data->link ?? null
            ];
        } else {
            $data = $this->getSosmed();
            // dd($data);

            $response = [
                'desc' => $data['data']->desc ?? null,
                'link' => $data['data']->link ?? null,
            ];

            // Mengisi array image
            for ($i = 0; $i < 5; $i++) {
                $response["image{$i}"] = $data['listImages'][$i]->file ?? null;
            }

            // Mengisi array file
            for ($i = 0; $i < 5; $i++) {
                $response["file{$i}"] = $data['listPdf'][$i]->file ?? null;
            }

            return $response;
        }
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

    private function getIndonesiaMinerDirectory()
    {
        $id = auth()->id();
        $data = Company::where('id', $id)->first();
        $video = $this->getDataVideo();
        $representative = $this->getRepresentative();
        $media = $this->getMedia();
        $product = $this->getProduct();
        $project = $this->getProject();
        $news = $this->getNews();
        // dd($video);
        if (!$data) {
            return []; // atau lakukan penanganan error jika data tidak ditemukan
        }

        return [
            'image' => $data->image,
            'info_one' => $data->info_one,
            'info_two' => $data->info_two,
            'info_three' => $data->info_three,
            'linkedin' => $data->linkedin,
            'facebook' => $data->facebook,
            'instagram' => $data->instagram,
            'main_video' => $video['main_video'] ?? null,
            'video_1' => $video['video_1'] ?? null,
            'video_2' => $video['video_2'] ?? null,
            'video_3' => $video['video_3'] ?? null,
            'representative' => $representative->id ?? null,
            'media' => $media->id ?? null,
            'product' => $product->id ?? null,
            'project' => $project->id ?? null,
            'news' => $news->id ?? null,
        ];
    }



    private function getNews()
    {
        $userId = auth()->id();
        return News::where('company_id', $userId)->first();
    }
    private function getProject()
    {
        $userId = auth()->id();
        return Project::where('company_id', $userId)->first();
    }
    private function getProduct()
    {
        $userId = auth()->id();
        return Product::where('company_id', $userId)->first();
    }

    private function getMedia()
    {
        $userId = auth()->id();
        return MediaResource::where('company_id', $userId)->first();
    }

    private function getRepresentative()
    {
        $userId = auth()->id();
        return CompanyRepresentative::where('company_id', $userId)->first();
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


    private function countPercen($data)
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
