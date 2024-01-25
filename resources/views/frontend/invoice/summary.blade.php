@extends('index')

@section('content')
    <div class="container mt-2">
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
                                    Jakarta 12560,
                                    Indonesia<br>
                                    P: (021) 8062 3711 E: billing@mmi-indonesia.co.id
                            </div>
                            <div class="col-md-6">
                                <p><strong>Invoiced To:</strong><br>
                                    {{ $company->company_name }}<br>
                                    {{ $company->name }}<br>
                                    {{ $company->company_address }}
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
                                        <td>Rp. {{ number_format($key->price, 2, ',', '.') }}</td>
                                        <td class="text-center">{{ $key->quantity }}</td>
                                        <td class="text-right">Rp.
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
                                ?>

                                <tr>
                                    <th colspan="2" class="text-right">Sub Total</th>
                                    <th colspan="2" class="text-right">Rp. {{ number_format($totalDue, 2, ',', '.') }}
                                    </th>
                                </tr>
                                @if ($tax != 0)
                                    <tr>
                                        <th colspan="2" class="text-right">VAT 11%</th>
                                        <th colspan="2" class="text-right">Rp.
                                            {{ number_format($totalPPN, 2, ',', '.') }}</th>
                                    </tr>
                                @endif
                                <tr>
                                    <th colspan="2" class="text-right">Total</th>
                                    <th colspan="2" class="text-right">Rp.
                                        {{ number_format($totalDueWithTax, 2, ',', '.') }}</th>
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
                                <h2>Rp. {{ number_format($totalDueWithTax, 2, ',', '.') }}</h2>
                            @elseif ($items[0]->status)
                                <span class="badge badge-pill badge-light">PAID OFF</span>
                            @endif
                            @if ($items[0]->status == null)
                                <p class="mt-2">Payment Method:</p>
                                {{-- <select class="form-control mb-3">
                                    <option>Link Xendit</option>
                                    <!-- Add more payment methods here -->
                                </select> --}}
                                <form action="{{ url('payment/request') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="code_payment" value="{{ $codePayment }}">
                                    <input type="hidden" name="total_price" value="{{ $totalDue }}">
                                    <button type="submit" class="btn btn-light btn-block">Request invoice/payment
                                        link</button>
                                </form>
                            @elseif($items[0]->status == 'unpaid')
                                <a href="{{ $items[0]->link }}" target="_blank"
                                    class="btn btn-light btn-block mt-2">Pay</a>
                            @endif

                            {{-- <div class="mt-2">
                                <h4>Actions</h4>
                                <a href="{{ url('dl/invoice?code_payment=' . $items[0]->code_payment . '&company_id=' . $items[0]->company_id) }}"
                                    class="btn btn-light btn-block">Download</a>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('top')
    <style>
        .sticky-top-2 {
            position: -webkit-sticky;
            /* Safari */
            position: sticky;
            top: 1rem;
            z-index: 1020;
            /* Ensure it stays on top of other elements */
        }
    </style>
@endpush
