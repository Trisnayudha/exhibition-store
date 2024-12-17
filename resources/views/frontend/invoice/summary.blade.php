@extends('index')

@section('content')
    <div class="container mt-2">
        @if ($company->deadline <= '2025-05-25')
            {{-- <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i><b>Please note that a 30% surcharge will be added to your total order after May 25, 2024.</b></i>
                </strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div> --}}
        @else
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i><b>Please note that a 30% surcharge will be added to your total order after May 29, 2025.</b></i>
                </strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-8 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h2>INVOICE #{{ $codePayment }}</h2>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <p><strong>Pay To:</strong><br>
                                    PT MITRA KARYA INDONESIA<br>
                                    CIBIS NINE 11th floor Jl. Tb Simatupang No.2<br>
                                    Jakarta 12560, Indonesia<br>
                                    P: (021) 8062 3711 E: billing@mmi-indonesia.co.id
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Invoiced To:</strong><br>
                                    {{ $company->company_name }}<br>
                                    {{ $company->name }}<br>
                                    {{ $company->company_address }}
                                </p>
                            </div>
                        </div>

                        <table class="table" style="font-size: 14px">
                            <thead>
                                <tr>
                                    <th>Description</th>
                                    <th>Amount</th>
                                    <th>Quantity</th>
                                    <th class="text-right">Total Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $key)
                                    <tr>
                                        <td>{{ $key->name_product . ' - ' . $key->section_product }}</td>
                                        <td>IDR {{ number_format($key->price, 2, ',', '.') }}</td>
                                        <td class="text-center">{{ $key->quantity }}</td>
                                        <td class="text-right">IDR
                                            {{ number_format($key->price * $key->quantity, 2, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                                <?php
                                $totalDue = 0;
                                $countPPN = 0.11; // 11% tax as a decimal
                                $npwp = $company->npwp;
                                $tax = $npwp ? $countPPN : 0; // Tax is 11% if NPWP exists, else 0
                                foreach ($items as $key) {
                                    $totalDue += $key->price * $key->quantity;
                                }
                                
                                $totalPPN = $totalDue * $tax;
                                $totalDueWithTax = $totalDue + $totalPPN;
                                $currentDate = date('Y-m-d');
                                // Surcharge calculation
                                $surcharge = 0;
                                if (($company->deadline < '2025-05-25' && $currentDate > '2025-05-25') || ($company->deadline > '2025-05-25' && $currentDate > '2024-05-29')) {
                                    $surcharge = $totalDue * 0.3;
                                }
                                $totalDueWithTaxAndSurcharge = $totalDueWithTax + $surcharge;
                                
                                $totalUSD = $totalDueWithTaxAndSurcharge / $usdCurrency; // Convert to USD
                                $formattedTotalUSD = number_format($totalUSD, 2, ',', '.'); // Format as USD
                                ?>

                                <tr>
                                    <th colspan="2" class="text-right">Sub Total</th>
                                    <th colspan="2" class="text-right">IDR {{ number_format($totalDue, 2, ',', '.') }}
                                    </th>
                                </tr>
                                @if ($tax != 0)
                                    <tr>
                                        <th colspan="2" class="text-right">VAT 11%</th>
                                        <th colspan="2" class="text-right">IDR
                                            {{ number_format($totalPPN, 2, ',', '.') }}</th>
                                    </tr>
                                @endif
                                @if ($surcharge > 0)
                                    <tr>
                                        <th colspan="2" class="text-right">Surcharge 30%</th>
                                        <th colspan="2" class="text-right">IDR
                                            {{ number_format($surcharge, 2, ',', '.') }}</th>
                                    </tr>
                                @endif
                                <tr>
                                    <th colspan="2" class="text-right">Total</th>
                                    <th colspan="2" class="text-right">
                                        <p>IDR {{ number_format($totalDueWithTaxAndSurcharge, 2, ',', '.') }} </p>
                                        <p>{{ $formattedTotalUSD }} USD</p>
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="2"></th>
                                    <th colspan="2" class="text-right"></th>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="sticky-top-2">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            @if ($items[0]->status != 'paid')
                                <span class="badge badge-pill badge-danger">Unpaid</span>
                                <h3>Total Due</h3>
                                <h2>IDR {{ number_format($totalDueWithTaxAndSurcharge, 2, ',', '.') }}</h2>
                                <h2>USD {{ $formattedTotalUSD }} </h2>
                            @elseif ($items[0]->status)
                                <span class="badge badge-pill badge-light">PAID OFF</span>
                            @endif

                            @if ($items[0]->status == null || $items[0]->status == 'unpaid')
                                <p class="mt-2 mb-1">Please select your preferred payment method:</p>
                                <select id="paymentMethod" class="form-control mb-3">
                                    <option value="link" selected>Payment Link</option>
                                    <option value="manual">Manual Invoice</option>
                                </select>

                                <div id="paymentLinkSection">
                                    @if ($items[0]->status == null)
                                        <form action="{{ url('payment/request') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="code_payment" value="{{ $codePayment }}">
                                            <input type="hidden" name="total_price" value="{{ $totalDue }}">
                                            <button type="submit" class="btn btn-light btn-block loadpayment">Payment
                                                link</button>
                                        </form>
                                    @elseif($items[0]->status == 'unpaid')
                                        <a href="{{ $items[0]->link }}" target="_blank"
                                            class="btn btn-light btn-block mt-2">Payment link</a>
                                    @endif
                                </div>

                                <!-- Manual Invoice Section -->
                                <div id="manualInvoiceSection" style="display: none;">
                                    <p class="mt-2" style="font-size: 14px;">
                                        <b>Prefer an alternative payment method? </b>
                                        Please transfer the due amount to the following bank account only, then upload your
                                        payment receipt. Your payment will be verified on weekdays (Monday - Friday) within
                                        a maximum of 24 hours.
                                    </p>

                                    <div class="card bg-white text-dark mb-2" style="font-size:14px;">
                                        <div class="card-body" style="padding: 10px;">
                                            <p class="mb-2"> <strong>BANK DETAILS </strong></p>
                                            <p class="mb-1"><strong>Bank Name:</strong> PT. Bank Mandiri (Persero) TBK</p>
                                            <p class="mb-1"><strong>Account Name:</strong> PT. Media Mitrakarya Indonesia
                                            </p>
                                            <p class="mb-1"><strong>Branch:</strong> Mal Pondok Indah 1, Jakarta Indonesia
                                            </p>
                                            <p class="mb-1">
                                                <strong>IDR Account:</strong>
                                                <span id="accountNumberText">1010009992353</span>
                                                <button type="button" id="copyAccountNumberBtn"
                                                    class="btn btn-sm btn-outline-secondary ml-2">
                                                    <i class="fa fa-copy"></i> Copy
                                                </button>
                                            </p>
                                            <p class="mb-0"><strong>SWIFT CODE:</strong> BMRIIDJA</p>
                                        </div>
                                    </div>

                                    <!-- Upload Payment Receipt Button -->
                                    <button type="button" class="btn btn-warning btn-block mt-2 animated-button"
                                        data-toggle="modal" data-target="#uploadReceiptModal">
                                        Upload Payment Receipt
                                    </button>

                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Modal for Upload Payment Receipt -->
    <div class="modal fade" id="uploadReceiptModal" tabindex="-1" role="dialog" aria-labelledby="uploadReceiptModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ url('payment/manual') }}" method="POST" enctype="multipart/form-data" id="paymentForm">
                @csrf
                <input type="hidden" name="code_payment" value="{{ $codePayment }}">
                <input type="hidden" name="total_price" value="{{ $totalDue }}">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="uploadReceiptModalLabel">Upload Payment Receipt</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="font-size:14px;">
                        <div class="form-group">
                            <label>Transfer Date</label>
                            <input type="date" name="transfer_date" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Invoice Number</label>
                            <input type="text" name="invoice_number" class="form-control"
                                value="{{ $codePayment }}" readonly>
                        </div>
                        <div class="form-group">
                            <label>Payment Method</label>
                            <input type="text" name="payment_method" class="form-control" value="Manual Invoice"
                                readonly>
                        </div>
                        <div class="form-group">
                            <label>Transferred Amount (IDR)</label>
                            <input type="text" name="transferred_amount" class="form-control" id="transferredAmount"
                                placeholder="Enter the amount transferred" required>
                        </div>
                        <div class="form-group">
                            <label>Payment Receipt (Max 2MB, PDF/JPG/JPEG/PNG)</label>
                            <input type="file" name="payment_receipt" class="form-control-file"
                                accept=".pdf,.jpg,.jpeg,.png" required>
                        </div>
                        <small class="form-text text-muted">
                            Please ensure the uploaded file is clear and does not exceed 2MB.
                        </small>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit Receipt</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('top')
    <style>
        /* Add this CSS to your stylesheet */

        /* Define the animation */
        @keyframes pulse {
            0% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(0, 123, 255, 0.7);
            }

            70% {
                transform: scale(1.05);
                box-shadow: 0 0 0 10px rgba(0, 123, 255, 0);
            }

            100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(0, 123, 255, 0);
            }
        }

        /* Apply the animation to the button */
        .animated-button {
            position: relative;
            animation: pulse 2s infinite;
            transition: transform 0.2s;
        }

        .animated-button:hover {
            transform: scale(1.1);
        }
    </style>
@endpush

@push('bottom')
    <script>
        document.getElementById('paymentMethod').addEventListener('change', function() {
            let method = this.value;
            let paymentLinkSection = document.getElementById('paymentLinkSection');
            let manualInvoiceSection = document.getElementById('manualInvoiceSection');

            if (method === 'link') {
                paymentLinkSection.style.display = 'block';
                manualInvoiceSection.style.display = 'none';
            } else {
                paymentLinkSection.style.display = 'none';
                manualInvoiceSection.style.display = 'block';
            }
        });

        // Copy to Clipboard
        const copyBtn = document.getElementById('copyAccountNumberBtn');
        const accountNumberText = document.getElementById('accountNumberText');

        copyBtn.addEventListener('click', function() {
            const range = document.createRange();
            range.selectNode(accountNumberText);
            window.getSelection().removeAllRanges();
            window.getSelection().addRange(range);

            try {
                document.execCommand('copy');
                window.getSelection().removeAllRanges();
                alert('Account number copied to clipboard!');
            } catch (err) {
                console.error('Unable to copy', err);
            }
        });

        // Format IDR input
        const transferredAmountInput = document.getElementById('transferredAmount');
        transferredAmountInput.addEventListener('input', function(e) {
            // Remove all non-digit characters
            let value = this.value.replace(/\D/g, '');
            // Format with dots as thousand separators
            this.value = formatNumberWithDots(value);
        });

        function formatNumberWithDots(value) {
            // Convert string to array of digits reversed
            let rev = value.split('').reverse();
            let formatted = [];
            for (let i = 0; i < rev.length; i++) {
                if (i > 0 && i % 3 === 0) {
                    formatted.push('.');
                }
                formatted.push(rev[i]);
            }
            // Reverse back and join
            return formatted.reverse().join('');
        }
    </script>
@endpush
