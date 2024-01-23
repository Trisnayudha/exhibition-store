<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Exhibition\ExhibitionCartList;
use App\Models\Exhibition\ExhibitionPayment;
use App\Models\Logs\ExhibitionLog;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
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
        $data['company'] = Company::where('id', $id)->first();
        $data['codePayment'] = 'ADDITIONAL-' . strtoupper(Str::random(7));
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
        $findPayment = ExhibitionPayment::where('code_payment', $code_payment)->first();
        $findCompany = ExhibitionCartList::where('payment_id', $findPayment->id)->first();
        $id = $findCompany->company_id;
        $data['company'] = Company::where('id', $id)->first();
        $data['codePayment'] = strtoupper(Str::random(7));
        if (empty($code_payment)) {
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
}
