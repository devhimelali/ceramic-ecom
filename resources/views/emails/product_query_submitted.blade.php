<!DOCTYPE html>
<html>

<head>
    <title>Product Inquiry Submitted</title>
</head>

<body>
    <p>Dear {{ $queryData['name'] }},</p>
    <p>Thank you for reaching out to us regarding <strong>{{ $queryData['product_name'] }}</strong>.</p>

    <p>We have received your inquiry and will get back to you shortly.</p>

    <p><strong>Inquiry Details:</strong></p>
    <ul>
        <li><strong>Name:</strong> {{ $queryData['name'] }}</li>
        <li><strong>Email:</strong> {{ $queryData['email'] }}</li>
        <li><strong>Phone:</strong> {{ $queryData['phone'] }}</li>
        <li><strong>Message:</strong> {{ $queryData['message'] }}</li>
        <li><strong>Selected Product Variation:</strong>
            <ol>
                <li style="text-transform: capitalize">{{ ucfirst($queryData['variations']) }}</li>
            </ol>
        </li>

    </ul>

    <p>Best regards,<br> {{ app_setting('site_name') }}</p>
</body>

</html>
