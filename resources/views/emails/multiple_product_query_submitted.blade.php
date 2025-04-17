<!DOCTYPE html>
<html>

<head>
    <title>Product Inquiry Submitted</title>
</head>

<body>
    <p>Dear {{ $queryData['name'] }},</p>
    <p>Thank you for reaching out to us</p>

    <p>We have received your inquiry and will get back to you shortly.</p>

    <p><strong>Inquiry Details:</strong></p>
    <ul>
        <li><strong>Name:</strong> {{ $queryData['name'] }}</li>
        <li><strong>Email:</strong> {{ $queryData['email'] }}</li>
        <li><strong>Phone:</strong> {{ $queryData['phone'] }}</li>
        <li><strong>Message:</strong> {{ $queryData['message'] }}</li>
        <li><strong>Inquiry Products Summery:</strong></strong>
            <ul>
                @foreach ($queryData['cartItems'] as $item)
                    <li style="margin-top: 10px;"><strong>Product Name:</strong> {{ $item['name'] }}</li>
                    <li><strong>Product Quantity:</strong> {{ $item['quantity'] }}</li>
                    <li>
                        <strong>Selected Product Variation:</strong>
                        <span style="text-transform: capitalize">{{ $item['variation'] }}</span>
                    </li>
                @endforeach
            </ul>
        </li>
    </ul>

    <p>Best regards,<br> {{ app_setting('site_name') }}</p>
</body>

</html>
