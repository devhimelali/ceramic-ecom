<table class="table table-bordered">
    <tr>
        <th>Name</th>
        <td>{{ $productQuery->name }}</td>
    </tr>
    <tr>
        <th>Email</th>
        <td>{{ $productQuery->email }}</td>
    </tr>
    <tr>
        <th>Phone</th>
        <td>{{ $productQuery->phone }}</td>
    </tr>
    <tr>
        <th>Message</th>
        <td>{{ $productQuery->message }}</td>
    </tr>
    <tr>
        <th>Product Details:</th>
        <td>
            <table class="table table-bordered">
                <thead>
                    <th>Product Name</th>
                    <th>Product Quantity</th>
                    <th>Selected Product Variation:</th>
                </thead>
                <tbody>
                    @foreach ($productQuery->items as $product)
                        <tr>
                            <td>{{ $product->product->name }}</td>
                            <td style="text-align: center">
                                <span class="badge bg-success">{{ $product->quantity }}</span>
                            </td>
                            <td>
                                <span style="text-transform: capitalize">
                                    {{ ucfirst(string: $product->variation_name) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </td>
    </tr>
</table>
