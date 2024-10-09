<?php

namespace App\Http\Controllers;

use App\Models\MineexpoExhibitor;
use Goutte\Client;
use Illuminate\Http\Request;

class WebScrapingController extends Controller
{
    public function scrape()
    {
        $client = new Client();

        // URL target
        $url = 'https://kursdollar.org/real-time/USD/';
        // Mengirim permintaan GET ke halaman web
        $crawler = $client->request('GET', $url);

        // Mencari elemen dengan ID "nilai"
        $value = $crawler->filter('.in_table tr:nth-child(3) > td:first-child')->text();

        // Menghilangkan titik dan mengganti koma dengan titik
        $value = str_replace('.', '', $value);
        $value = str_replace(',', '.', $value);

        // Mengonversi nilai tukar menjadi float
        $floatValue = (float) $value;

        // Mengonversi nilai tukar menjadi integer (dengan pembulatan)
        $intValue = (int) round($floatValue);

        // Mengembalikan nilai tukar dalam format integer
        return $intValue;
    }

    public function scrape_v2(Request $request)
    {
        // Set waktu eksekusi menjadi 5 menit
        set_time_limit(300);
        $client = new Client();

        // Ambil parameter `exhid` dari URL dan pisahkan berdasarkan koma
        $exhids = explode(',', $request->input('exhid'));

        // Array untuk menyimpan hasil dari proses simpan data
        $saved_ids = [];
        $failed_ids = [];

        // Loop melalui setiap `exhid`
        foreach ($exhids as $exhid) {
            // Pastikan exhid adalah integer
            $exhid = intval($exhid);

            // URL target dengan exhid
            $url = "https://mine2024.mapyourshow.com/8_0/exhibitor/exhibitor-details.cfm?exhid={$exhid}";

            try {
                $crawler = $client->request('GET', $url);
            } catch (\Exception $e) {
                $failed_ids[] = $exhid; // Jika gagal, tambahkan ke daftar gagal
                continue; // Lanjutkan ke ID berikutnya
            }

            // Ambil data utama dari halaman
            $name = $this->getName($crawler); // Ambil nama eksibitor
            $address = $this->getAddress($crawler);
            $phone = $this->getPhone($crawler);
            $website = $this->getWebsite($crawler);
            $description = $this->getDescription($crawler);
            $contacts = $this->getContacts($crawler);
            $categories = $this->getCategories($crawler);
            $social_links = $this->getSocialLinks($crawler);

            // Pencarian email dari website
            $emails = $this->getEmails($client, $website);

            try {
                // Simpan data ke database menggunakan model
                MineexpoExhibitor::updateOrCreate(
                    ['exhid' => $exhid], // Kondisi untuk update jika sudah ada
                    [
                        'name' => $name, // Tambahkan nama eksibitor
                        'address' => $address,
                        'phone' => $phone,
                        'website' => $website,
                        'description' => $description,
                        'emails' => json_encode($emails),
                        'categories' => json_encode($categories),
                        'linkedin' => $social_links['linkedin'] ?? null,
                        'instagram' => $social_links['instagram'] ?? null,
                        'facebook' => $social_links['facebook'] ?? null
                    ]
                );
                $saved_ids[] = $exhid; // Jika berhasil, tambahkan ke daftar berhasil
            } catch (\Exception $e) {
                $failed_ids[] = $exhid; // Jika gagal, tambahkan ke daftar gagal
            }
        }

        // Hitung jumlah ID yang berhasil dan gagal
        $total_saved = count($saved_ids);
        $total_failed = count($failed_ids);

        // Respon hasil
        return response()->json([
            'status' => 'success',
            'message' => 'Proses scraping selesai.',
            'saved_count' => $total_saved,
            'failed_count' => $total_failed,
            'failed_ids' => $failed_ids
        ]);
    }


    // Ambil nama eksibitor dari halaman
    private function getName($crawler)
    {
        return $crawler->filter('h1')->count() > 0
            ? $crawler->filter('h1')->text()
            : null;
    }

    // Ambil alamat dari halaman
    private function getAddress($crawler)
    {
        return $crawler->filter('.showcase-address')->count() > 0
            ? $crawler->filter('.showcase-address')->text()
            : null;
    }

    // Ambil nomor telepon dari halaman
    private function getPhone($crawler)
    {
        return $crawler->filter('.showcase-web-phone li')->count() > 0
            ? $crawler->filter('.showcase-web-phone li')->last()->text()
            : null;
    }

    // Ambil URL website dari halaman
    private function getWebsite($crawler)
    {
        return $crawler->filter('.showcase-web-phone a')->count() > 0
            ? $crawler->filter('.showcase-web-phone a')->attr('href')
            : null;
    }

    // Ambil deskripsi dari halaman
    private function getDescription($crawler)
    {
        return $crawler->filter('.showroom-about p.js-read-more')->count() > 0
            ? $crawler->filter('.showroom-about p.js-read-more')->text()
            : null;
    }

    // Ambil data kontak dari halaman
    private function getContacts($crawler)
    {
        return $crawler->filter('.grid.grid-3-col .vbc_contact')->count() > 0
            ? $crawler->filter('.grid.grid-3-col .vbc_contact')->each(function ($node) {
                return [
                    'name' => $node->filter('h3')->count() > 0 ? $node->filter('h3')->text() : null,
                    'title' => $node->filter('p.muted')->count() > 0 ? $node->filter('p.muted')->text() : null,
                    'image' => $node->filter('img')->count() > 0 ? $node->filter('img')->attr('src') : null,
                ];
            })
            : [];
    }

    // Ambil data kategori dari script
    private function getCategories($crawler)
    {
        $categories = [];
        $crawler->filter('script')->each(function ($node) use (&$categories) {
            $script_content = $node->text();
            if (strpos($script_content, 'productcategories') !== false) {
                preg_match("/productcategories\s*:\s*\[\s*(.+?)\s*\]\s*}/s", $script_content, $matches);
                if (isset($matches[1])) {
                    $json_string = '[' . $matches[1] . ']';
                    $json_string = str_replace("'", '"', $json_string);
                    $json_string = preg_replace('/,\s*}/', '}', $json_string);
                    $data = json_decode($json_string, true);

                    if (json_last_error() === JSON_ERROR_NONE) {
                        foreach ($data as $index => $category) {
                            $categories['category_' . ($index + 1)] = [
                                'title' => $category['category'] ?? '',
                                'subtitle' => $category['subcategory'] ?? '',
                            ];
                        }
                    }
                }
            }
        });
        return $categories;
    }

    // Ambil tautan sosial media dari halaman
    private function getSocialLinks($crawler)
    {
        $social_links = [];
        $crawler->filter('.showcase-social a')->each(function ($node) use (&$social_links) {
            $href = $node->attr('href');
            if (strpos($href, 'facebook.com') !== false) {
                $social_links['facebook'] = $href;
            } elseif (strpos($href, 'linkedin.com') !== false) {
                $social_links['linkedin'] = $href;
            } elseif (strpos($href, 'instagram.com') !== false) {
                $social_links['instagram'] = $href;
            }
        });
        return $social_links;
    }

    // Ambil email dari website
    private function getEmails($client, $website)
    {
        $emails = [];

        if ($website) {
            try {
                $crawler = $client->request('GET', $website);

                $crawler->filter('body')->each(function ($node) use (&$emails) {
                    $text = $node->text();
                    preg_match_all('/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/', $text, $matches);

                    if (!empty($matches[0])) {
                        $uniqueEmails = array_unique($matches[0]);
                        $emailCount = min(count($uniqueEmails), 3); // Batasi hingga 3 email

                        // Ambil 3 email pertama dan beri nama email_1, email_2, email_3
                        for ($i = 0; $i < $emailCount; $i++) {
                            $emails['email_' . ($i + 1)] = $uniqueEmails[$i];
                        }
                    }
                });
            } catch (\Exception $e) {
                $emails['error'] = 'Gagal mengakses situs web untuk mengambil email';
            }
        }

        return $emails;
    }
}
