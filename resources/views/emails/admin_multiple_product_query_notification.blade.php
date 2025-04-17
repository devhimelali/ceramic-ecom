<!DOCTYPE html>
<html>

<head>
    <title>New Product Inquiry</title>
</head>

<body>
    <p>Hello Admin,</p>
    <p>A new product inquiry has been submitted.</p>

    <p><strong>Inquiry Details:</strong></p>
    <ul>
        <li><strong>Name:</strong> {{ $queryData['name'] }}</li>
        <li><strong>Email:</strong> {{ $queryData['email'] }}</li>
        <li><strong>Phone:</strong> {{ $queryData['phone'] }}</li>
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
        <li><strong>Message:</strong> {{ $queryData['message'] }}</li>
    </ul>

    <p>Best Regards, <br>{{ app_setting('site_name') }}</p>
</body>

</html>
