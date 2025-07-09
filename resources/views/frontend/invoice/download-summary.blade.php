<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .header img {
            width: 100px;
        }

        .header-table {
            width: 100%;
            background: #f2f2f2;
        }

        .header-table td {
            padding: 10px;
        }

        .company-info {
            text-align: left;
        }

        .status {
            padding: 10px;
            color: #ffffff;
            text-align: center;
            font-weight: bold;
            transform: rotate(40deg);
            transform-origin: top right;
            position: absolute;
            top: -100px;
            right: -130px;
            width: 200px;
            /* background-color: #ff0000; */
        }

        .status.unpaid {
            background-color: #ff0000;

        }

        .status.paid {
            background-color: #04f761;

        }

        .status.draft {
            background-color: #9f9f9f;

        }

        .invoice-date {
            background-color: #e9e9e9;
            padding: 10px;
        }

        .invoice-body {
            background-color: #ffffff;
            padding: 20px;
        }

        .footer {
            background-color: #f2f2f2;
            padding: 10px;
            text-align: center;
            font-size: 0.8em;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <div style="position: relative;">
        <table class="header-table">
            <tr>
                <td>
                    <img src="{{ asset('logo.png') }}" alt="Exabytes" height="100px" />
                </td>
                <td class="company-info">
                    PT MITRA KARYA INDONESIA<br>
                    CIBIS NINE 11th floor Jl. Tb Simatupang No.2<br>
                    Jl. Tb Simatupang No.2 Cilandak Timur Jakarta 12560,
                    <br>
                    Indonesia<br>
                    P: (021) 8062 3711 E: billing@mmi-indonesia.co.id
                </td>
            </tr>
        </table>
        <?php
        foreach ($items as $key) {
            $status = $key->status;

            // Jika $status adalah null, set nilai default menjadi "draft"
            $status = ($status === null) ? 'draft' : $status;
            ?>

        <div class="status <?php echo strtolower($status); ?>">
            <?php echo strtoupper($status); ?>
        </div>

        <?php
        }
        ?>


    </div>

    <div class="content">
        <div class="invoice-header">
            <p><strong>Invoice Date:</strong> {{ date('d/m/Y H:i') }}</p>
            <?php $dueDate = strtotime('+1 days'); ?>
            <p><strong>Due Date:</strong> {{ date('d/m/Y H:i', $dueDate) }}</p>
            <p><strong>Invoice No: {{ $code_payment }}</strong></p>
        </div>

        <div class="invoice-body">
            <h2>Invoiced To:</h2>
            <p>{{ $company->company_name }}<br>
                Attn: {{ $company->name }}<br>
                {{ $company->company_address }}

            <h2>Description</h2>
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
                            <td class="text-right">Rp. {{ number_format($key->price * $key->quantity, 2, ',', '.') }}
                            </td>
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
                    $totalDueWithTaxAndSurcharge = $totalDue + $totalPPN + $surcharge;
                    ?>

                    <tr>
                        <th colspan="2" class="text-right">Sub Total</th>
                        <th colspan="2" class="text-right">Rp. {{ number_format($totalDue, 2, ',', '.') }}</th>
                    </tr>
                    @if ($tax != 0)
                        <tr>
                            <th colspan="2" class="text-right">VAT 11%</th>
                            <th colspan="2" class="text-right">Rp. {{ number_format($totalPPN, 2, ',', '.') }}</th>
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
                        <th colspan="2" class="text-right">Rp.
                            {{ number_format($totalDueWithTaxAndSurcharge, 2, ',', '.') }}
                        </th>
                    </tr>
                </tbody>
            </table>

        </div>
        <div class="footer">
            <p>This is a computer generated invoice. No signature is required.</p>
        </div>

        <div
            style="max-width: 600px; margin: auto; padding: 20px; border: 1px solid #dddddd; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);margin-top:5px">
            <p>Payment via Bank Transfer:</p>
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                <tr>
                    <td>Bank Name </td>
                    <td>: </td>
                    <td>PT. Bank Mandiri (persero) TBK</td>
                </tr>
                <tr>
                    <td>Account Name </td>
                    <td>: </td>
                    <td>PT. Media MitraKarya Indonesia</td>
                </tr>
                <tr>
                    <td>Branch </td>
                    <td>: </td>
                    <td>Mal Pondoh Indah, Jakarta Indonesia</td>
                </tr>
                <tr>
                    <td>IDR Account </td>
                    <td>: </td>
                    <td>1010009992353</td>
                </tr>
                <tr>
                    <td>SWIFT CODE </td>
                    <td>: </td>
                    <td>BMRIIDJA</td>
                </tr>
            </table>

        </div>
    </div>
</body>

</html>
