<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Exhibition\ExhibitionCartList;
use App\Models\Exhibition\ExhibitionPayment;
use App\Models\Logs\ExhibitionLog;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Goutte\Client;
use Illuminate\Support\Str;


class InvoiceController extends Controller
{

    public function index()
    {
        $id = auth()->id();
        $data['log'] = ExhibitionLog::where('company_id', $id)->where('section', 'invoice')->first();
        $data['company'] = Company::where('id', $id)->first();
        $data['list'] = ExhibitionPayment::join('exhibition_cart_list', 'exhibition_cart_list.payment_id', '=', 'exhibition_payment.id')
            ->where('exhibition_cart_list.company_id', $id)
            ->select(
                'exhibition_payment.code_payment',
                'exhibition_payment.status',
                'exhibition_payment.total_price',
                'exhibition_payment.invoice_date',
                'exhibition_payment.invoice_due_date'
            )
            ->distinct()
            ->get();

        return view('frontend.invoice.index', $data);
    }

    public function summary(Request $request)
    {
        $code_payment = $request->code_payment;
        $id = auth()->id();
        $data['usdCurrency'] = $this->scrape();
        $data['company'] = Company::where('id', $id)->first();
        $data['codePayment'] = 'AdditionalOrder-' . strtoupper(Str::random(7));
        if (empty($code_payment)) {
            $data['items'] = ExhibitionCartList::where('company_id', $id)->whereNull('payment_id')->get();
        } else {
            $data['items'] = ExhibitionCartList::join('exhibition_payment', 'exhibition_payment.id', 'exhibition_cart_list.payment_id')
                ->where('company_id', $id)->where('exhibition_payment.code_payment', $code_payment)->get();
        }
        return view('frontend.invoice.summary', $data);
    }

    public function downloadInvoice(Request $request)
    {
        $code_payment = $request->code_payment;
        $id = $request->company_id;
        $findPayment = ExhibitionPayment::where('code_payment', $code_payment)->first();
        $data['company'] = Company::where('id', $id)->first();
        $data['codePayment'] = strtoupper(Str::random(7));
        $data['surcharge'] = $findPayment->surcharge;
        $data['code_payment'] = $findPayment != null ? $code_payment : 'ADDITIONAL-' . $data['codePayment'];
        if (empty($findPayment)) {
            $data['items'] = ExhibitionCartList::where('company_id', $id)->whereNull('payment_id')->get();
        } else {
            $data['items'] = ExhibitionCartList::join('exhibition_payment', 'exhibition_payment.id', 'exhibition_cart_list.payment_id')
                ->where('company_id', $id)->where('exhibition_payment.code_payment', $code_payment)->get();
        }
        $pdf = Pdf::loadView('frontend.invoice.download-summary', $data);
        $filename = 'invoice_' . $code_payment . '.pdf';
        // Download the PDF with the specified filename
        return $pdf->stream();
    }

    private function scrape()
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
}
