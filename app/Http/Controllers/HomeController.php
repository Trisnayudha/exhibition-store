<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Company\CompanyService;
use App\Models\MiningDirectory\CompanyRepresentative;
use App\Models\MiningDirectory\Media\MediaResource;
use App\Models\MiningDirectory\News\News;
use App\Models\MiningDirectory\Products\Product;
use App\Models\MiningDirectory\Project\Project;
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
        $miningDirectory = $this->getIndonesiaMinerDirectory();
        $presentaseMiningDirectory = $this->countPercen($miningDirectory);
        $promotional = $this->getPromotional();
        $presentasePromotional = $this->countPercen($promotional);
        $data['countCompany'] = $presentaseCompany;
        $data['countMiningDirectory'] = $presentaseMiningDirectory;
        $data['countPromotional'] = $presentasePromotional;
        $data['access'] = $this->getAccess();
        // dd($data['access']);
        return view('frontend.home.index', $data);
    }


    private function getAccess()
    {
        $data = auth()->user(); // Mengambil nama pengguna dari objek auth
        return [
            'promotional_access' => $data->promotional_access ?? 0,
            'eventpass_access' => $data->eventpass_access ?? 0,
            'exhibition_access' => $data->exhibition_access ?? 0,
        ];
    }
    private function getPromotional()
    {
        $id = auth()->id();
        $level = auth()->user()->level;
        if ($level == 'sponsors') {
            $data = $this->getAdvertisement();
            return [
                'link' => $data->file ?? null,
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
