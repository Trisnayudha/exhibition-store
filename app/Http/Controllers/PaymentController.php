<?php

namespace App\Http\Controllers;

use App\Helpers\WhatsappApi;
use App\Models\Company;
use App\Models\Exhibition\ExhibitionCartList;
use App\Models\Exhibition\ExhibitionPayment;
use App\Models\Logs\ExhibitionLog;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Xendit\Xendit;
use Xendit\Invoice;

class PaymentController extends Controller
{
    private function create($code_payment)
    {
        $code_payment = $code_payment;
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
        $total_price = 0;
        if ($findCompany->npwp != null) {
            $totalPPN = $findPayment->total_price * $findPayment->ppn;
            $total = $findPayment->total_price + $totalPPN;
        } else {
            $total = $findPayment->total_price;
        }
        $params = [
            'external_id' => $code_payment,
            'payer_email' => $findCompany->pic_email ?? $findCompany->email,
            'description' => 'Invoice Exhibition Indonesia Miner',
            'amount' => $total,
            'success_redirect_url' => 'https://portal.indonesiaminer.com/invoice',
            'failure_redirect_url' => url(''),
            'due_date' => $dueDate,
        ];

        $createInvoice = Invoice::create($params);
        $linkPay = $createInvoice['invoice_url'];

        // dd($linkPay);
        $date = date('Y-m-d H:i:s'); // Correct format for SQL
        $dueDate = date('Y-m-d H:i:s', strtotime('+1 days')); // Add 7 days from now in the correct format
        $findPayment->invoice_date = $date;
        $findPayment->invoice_due_date = $dueDate;
        $findPayment->link = $linkPay;
        $findPayment->status = 'unpaid';
        $findPayment->save();

        $data['items'] = ExhibitionCartList::join('exhibition_payment', 'exhibition_payment.id', 'exhibition_cart_list.payment_id')
            ->where('company_id', $findCompany->id)->where('exhibition_payment.code_payment', $code_payment)->get();
        $data['company'] = Company::where('id', $findCompany->id)->first();
        $data['code_payment'] = $code_payment;
        $data['dueDate'] = $dueDate;
        $pdf = Pdf::loadView('frontend.invoice.download-summary', $data);
        $email = $data['company']->pic_email ?? $data['company']->email_alternate;
        Mail::send('email.payment', $data, function ($message) use ($pdf, $code_payment, $email) {
            $message->from(env('EMAIL_SENDER'));
            $message->to($email);
            // $message->to('yudha@indonesiaminer.com');
            $message->subject('Payment Due Today: Indonesia Miner 2024 ' . $code_payment);
            $message->attachData($pdf->output(), $code_payment . '-' . time() . '.pdf');
        });
        $email_login = $data['company']->email;
        Mail::send('email.payment', $data, function ($message) use ($pdf, $code_payment, $email_login) {
            $message->from(env('EMAIL_SENDER'));
            $message->to($email_login);
            // $message->to('yudha@indonesiaminer.com');
            $message->subject('Payment Due Today: Indonesia Miner 2024 ' . $code_payment);
            $message->attachData($pdf->output(), $code_payment . '-' . time() . '.pdf');
        });

        return redirect($linkPay);
    }

    public function payment(Request $request)
    {
        $code_payment = $request->code_payment;
        $total_price = $request->total_price;
        $id = auth()->id();
        $data['items'] = ExhibitionCartList::where('company_id', $id)->whereNull('payment_id')->get();
        $data['company'] = Company::where('id', $id)->first();
        $data['code_payment'] = $code_payment;
        $savePayment = new ExhibitionPayment();
        $savePayment->code_payment = $code_payment;
        $savePayment->status = 'draft';
        $savePayment->total_price = $total_price;
        $savePayment->ppn = 0.11;
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
        $saveFile = ExhibitionPayment::where('id', $savePayment->id)->first();
        $saveFile->file_invoice = asset($db);
        $saveFile->save();
        $sendwa = new WhatsappApi();
        $sendwa->phone = '081398670330';
        // $sendwa->phone = '083829314436';
        $sendwa->message = 'Hai Mba Riska. Company *' . $data['company']->company_name . '* sudah melakukan klik invoice di Exhibition Portal,

Mohon tolong dicheck kembali apakah sudah sesuai atau belum
' . asset($db) . '

Terimakasih

-Bot';
        // $sendwa->buttonurl =  asset($db);
        // $sendwa->buttonlabel = 'CHECKING INVOICE';
        // $sendwa->document = asset($db);
        // $sendwa->WhatsappMessageWithDocument();
        $sendwa->WhatsappMessage();

        $log = new ExhibitionLog();
        $log->company_id = $id;
        $log->section = 'invoice';
        $log->save();

        $createInvoice = $this->create($code_payment);
        return $createInvoice;
    }
}
