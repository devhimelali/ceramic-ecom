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
            <th>Product Details</th>
            <td>
                <ul>
                    @forelse ($product->variations as $variation)
                        <li>
                            <strong>{{ \App\Models\Attribute::find($variation->pivot->attribute_id)->name }} : </strong>
                            {{ \App\Models\AttributeValue::find($variation->pivot->attribute_value_id)->value }}
                        </li>

                    @empty
                        <p>No Variations</p>
                    @endforelse
                </ul>
            </td>
        </tr>
    @endforeach
</table>
