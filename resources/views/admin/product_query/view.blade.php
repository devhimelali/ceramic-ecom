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
    @foreach ($productQuery->items as $product)
        <tr>
            <th>Product Name</th>
            <td>{{ $product->product->name }}</td>
        </tr>
        <tr>
            <th>Product Quantity</th>
            <td>
                <span class="badge bg-success">{{ $product->quantity }}</span>
            </td>
        </tr>
        <tr>
            <th>Selected Product Variation:</th>
            <td>
                <ul>
                    <li style="text-transform: capitalize">{{ ucfirst(string: $product->variation_name) }}</li>
                </ul>
            </td>
        </tr>
    @endforeach
</table>
