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
                    <img src="https://indonesiaminer.com/vendor/front/images/indominer-icon.png" alt="Exabytes" />
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
            <?php $dueDate = strtotime('+7 days'); ?>
            <p><strong>Due Date:</strong> {{ date('d/m/Y H:i', $dueDate) }}</p>
        </div>

        <div class="invoice-body">
            <h2>Invoiced To:</h2>
            <p>{{ $company->company_name }}<br>
                Attn: {{ $company->name }}<br>
                {{ $company->company_address }}

            <h2>Description</h2>
            <table>
                <tr>
                    <th>Description</th>
                    <th>Amount</th>
                    <th>Quantity</th>
                    <th class="text-right">Total Amount</th>
                </tr>
                @foreach ($items as $key)
                    <tr>
                        <td>{{ $key->name_product . ' - ' . $key->section_product }}</td>
                        <td>Rp. {{ number_format($key->price, 2, ',', '.') }}</td>
                        <td class="text-center">{{ $key->quantity }}</td>
                        <td class="text-right">Rp. {{ number_format($key->total_price, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
                <!-- Additional items here -->
            </table>
        </div>
        <div class="footer">
            <p>This is a computer generated invoice. No signature is required.</p>
        </div>
    </div>
</body>

</html>
