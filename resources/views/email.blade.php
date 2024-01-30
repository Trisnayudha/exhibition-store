<!DOCTYPE html>
<html>

<head>
    <title>Payment Confirmation</title>
    <style>
        .email-container {
            text-align: center;
            font-family: Arial, sans-serif;
        }

        .check-icon {
            color: green;
            font-size: 50px;
        }

        .payment-details {
            margin-top: 20px;
            font-size: 16px;
            line-height: 1.6;
        }

        .footer {
            margin-top: 30px;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="check-icon">✔</div>
        <h2>Payment Successful</h2>

        <div class="payment-details">
            <p>Amount Paid: [Amount]</p>
            <p>Date of Payment: [Date]</p>
            <p>Payment Method: [Payment Method]</p>
        </div>

        <div class="footer">
            <p>Please find attached a copy of the invoice for your reference. If you have any questions or require
                further assistance, please do not hesitate to contact us.</p>
        </div>
    </div>
</body>

</html>
