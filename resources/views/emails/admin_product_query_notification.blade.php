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
        <li><strong>Product:</strong> {{ $queryData['product_name'] }}</li>
        <li><strong>Selected Product Variation:</strong>
            <ol>
                <li style="text-transform: capitalize">{{ ucfirst($queryData['variations']) }}</li>
            </ol>
        </li>
        <li><strong>Message:</strong> {{ $queryData['message'] }}</li>
    </ul>

    <p>Best Regards, <br>{{ app_setting('site_name') }}</p>
</body>

</html>
