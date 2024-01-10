<?php

namespace App\Http\Controllers;

use App\Helpers\WhatsappApi;
use App\Models\Company;
use App\Models\Exhibition\ExhibitionCartList;
use App\Models\Exhibition\ExhibitionPayment;
use App\Models\Logs\ExhibitionLog;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Xendit\Xendit;
use Xendit\Invoice;

class PaymentController extends Controller
{
    public function create(Request $request)
    {
        $code_payment = $request->code_payment;
        $findPayment = ExhibitionPayment::where('code_payment', $code_payment)->first();
        // dd($findPayment);
        $findCart = ExhibitionCartList::where('payment_id', $findPayment->id)->get();
        // dd($findCart);
        $findCompany = Company::where('id', $findCart[0]->company_id)->first();
        // dd($findCompany);
        $isProd = env('XENDIT_ISPROD');
        $secretKey = $isProd ? env('XENDIT_SECRET_KEY_PROD') : env('XENDIT_SECRET_KEY_TEST');
        Xendit::setApiKey($secretKey);

        $date = date('Y-m-d\TH:i:s.000\Z'); // Format yang sesuai dengan Xendit
        $dueDate = date('Y-m-d\TH:i:s.000\Z', strtotime('+7 days')); // Tambahkan 7 hari dari saat ini

        $params = [
            'external_id' => $code_payment,
            'payer_email' => $findCompany->pic_email ?? $findCompany->email,
            'description' => 'Invoice Exhibition Indonesia Miner',
            'amount' => $findPayment->total_price,
            'success_redirect_url' => 'https://portal.indonesiaminer.com/success/payment',
            'failure_redirect_url' => url(''),
            'due_date' => $dueDate,
        ];

        $createInvoice = Invoice::create($params);
        $linkPay = $createInvoice['invoice_url'];

        // dd($linkPay);
        $date = date('Y-m-d H:i:s'); // Correct format for SQL
        $dueDate = date('Y-m-d H:i:s', strtotime('+7 days')); // Add 7 days from now in the correct format
        $findPayment->invoice_date = $date;
        $findPayment->invoice_due_date = $dueDate;
        $findPayment->link = $linkPay;
        $findPayment->status = 'unpaid';
        $findPayment->save();
        return view('frontend.invoice.success-create');
    }

    public function payment(Request $request)
    {
        $code_payment = $request->code_payment;
        $total_price = $request->total_price;
        $id = auth()->id();
        $data['items'] = ExhibitionCartList::where('company_id', $id)->whereNull('payment_id')->get();
        $data['company'] = Company::where('id', $id)->first();
        $savePayment = new ExhibitionPayment();
        $savePayment->code_payment = $code_payment;
        $savePayment->status = 'draft';
        $savePayment->total_price = $total_price;
        $savePayment->save();

        foreach ($data['items'] as $item) {
            $item->payment_id = $savePayment->id;
            $item->save();
        }
        ini_set('max_execution_time', 300);
        $pdf = Pdf::loadView('frontend.invoice.download-summary', $data);
        // Generate a unique filename for the PDF
        $filename = 'invoice_' . $code_payment . '_' . time() . '.pdf';
        // Store the PDF in the desired directory within the storage folder
        $pdfPath = 'public/invoice/' . $filename;
        $db = '/storage/invoice/' . $filename;
        Storage::put($pdfPath, $pdf->output());
        // Download the PDF with the specified filename
        $sendwa = new WhatsappApi();
        $sendwa->phone = '081398670330';
        $sendwa->text = 'Hai Mba Riska. Company *' . $data['company']->company_name . '* sudah melakukan request invoice di Exhibition Portal,

Mohon tolong dicheck kembali apakah sudah sesuai atau belum, Jika sudah klik link Generate Payment Link, jika belum sesuai mohon contact company tersebut

Terimakasih

-Bot';
        $sendwa->buttonurl = url('create/invoice?code_payment=' . $code_payment) . ',' . asset($db);
        $sendwa->buttonlabel = 'GENERATE PAYMENT LINK , CHECKING INVOICE';
        $sendwa->document = asset($db);
        // $sendwa->WhatsappMessageWithDocument();
        $sendwa->WhatsappMessageWithLink();

        $log = new ExhibitionLog();
        $log->company_id = $id;
        $log->section = 'invoice';
        $log->save();
        return redirect()->route('invoice')->with('success', 'Success Request Payment');
    }
}
