<!DOCTYPE html>
<html>

<head>
    <title>Order Confirmation</title>
</head>

<body style="font-family: Arial, sans-serif; color: #333333;">

    <div
        style="max-width: 600px; margin: auto; padding: 20px; border: 1px solid #dddddd; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">

        <p>Your payment link has been generated. Please review your order below and proceed with the payment.</p>

        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
            <tr style="background-color: #f2f2f2;">
                <th style="border: 1px solid #dddddd; padding: 8px; text-align: left;">Item</th>
                <th style="border: 1px solid #dddddd; padding: 8px; text-align: left;">Quantity</th>
                <th style="border: 1px solid #dddddd; padding: 8px; text-align: left;">Price</th>
                <th style="border: 1px solid #dddddd; padding: 8px; text-align: left;">Total Price</th>
            </tr>
            @foreach ($items as $key)
                <tr>
                    <td style="border: 1px solid #dddddd; padding: 8px;">
                        {{ $key->name_product . ' - ' . $key->section_product }}</td>
                    <td style="border: 1px solid #dddddd; padding: 8px;">Rp.
                        {{ number_format($key->price, 2, ',', '.') }}</td>
                    <td style="border: 1px solid #dddddd; padding: 8px;">{{ $key->quantity }}</td>
                    <td style="border: 1px solid #dddddd; padding: 8px;">Rp.
                        {{ number_format($key->price * $key->quantity, 2, ',', '.') }}</td>
                </tr>
            @endforeach
            <!-- Repeat rows as necessary for each item -->
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
                <td colspan="3" style="border: 1px solid #dddddd; padding: 8px; text-align: right;">
                    <strong>Sub Total</strong>
                </td>
                <td style="border: 1px solid #dddddd; padding: 8px;"><strong>Rp.
                        {{ number_format($totalDue, 2, ',', '.') }}</strong></td>
            </tr>
            @if ($tax != 0)
                <tr>
                    <td colspan="3" style="border: 1px solid #dddddd; padding: 8px; text-align: right;">
                        <strong>VAT 11%</strong>
                    </td>
                    <td style="border: 1px solid #dddddd; padding: 8px;"><strong>Rp.
                            {{ number_format($totalPPN, 2, ',', '.') }}</strong></td>
                </tr>
            @endif
            <tr>
                <td colspan="3" style="border: 1px solid #dddddd; padding: 8px; text-align: right;">
                    <strong>Total</strong>
                </td>
                <td style="border: 1px solid #dddddd; padding: 8px;"><strong>Rp.
                        {{ number_format($totalDueWithTax, 2, ',', '.') }}</strong></td>
            </tr>
        </table>

        <a href="{{ $items[0]->link }}"
            style="background-color: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; display: inline-block;">Pay
            Now</a>
    </div>

</body>

</html>
