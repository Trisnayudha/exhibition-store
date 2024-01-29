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
                                $totalUSD = $totalDueWithTax / $usdCurrency; // Convert to USD
                                $formattedTotalUSD = number_format($totalUSD, 2, ',', '.'); // Format as USD
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
                                    <th colspan="2" class="text-right">
                                        <p>Rp. {{ number_format($totalDueWithTax, 2, ',', '.') }} </p>
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
                                <h2>Rp. {{ number_format($totalDueWithTax, 2, ',', '.') }}</h2>
                                <h2>{{ $formattedTotalUSD }} USD</h2> <!-- Format as USD -->
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
                                    <button type="submit" class="btn btn-light btn-block loadpayment">Payment link</button>
                                </form>
                            @elseif($items[0]->status == 'unpaid')
                                <a href="{{ $items[0]->link }}" target="_blank"
                                    class="btn btn-light btn-block mt-2">Payment link</a>
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
    <div class="overlay" style="display: none;"></div>
    <!-- Sisanya tetap sama -->
    <div class="loading-wrapper" style="display: none;">
        <img src="https://portal.indonesiaminer.com/logo.png" alt="Logo" class="logo">
        <div class="loading"></div>
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

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            /* Transparansi hitam */
            z-index: 998;
            /* Pastikan ini lebih rendah dari loader tapi cukup tinggi untuk menutupi konten lain */
        }

        .loading-wrapper {
            position: fixed;
            /* Mengubah dari relative menjadi fixed */
            top: 50%;
            /* Setengah dari tinggi layar */
            left: 50%;
            /* Setengah dari lebar layar */
            transform: translate(-50%, -50%);
            /* Menggeser elemen untuk benar-benar berada di tengah */
            width: 100px;
            height: 100px;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 999;
            /* Memastikan loading muncul di atas semua elemen lain */
        }

        .logo {
            width: 80%;
            height: auto;
            position: absolute;
            z-index: 10;
        }

        .loading {
            border: 5px solid #f3f3f3;
            border-top: 5px solid blue;
            border-radius: 50%;
            width: 100%;
            height: 100%;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
@endpush

@push('bottom')
    <script>
        $(document).ready(function() {
            $('.loadpayment').click(function() {
                $('.loading-wrapper, .overlay').show(); // Menampilkan loader dan overlay
            });
        });
    </script>
@endpush
