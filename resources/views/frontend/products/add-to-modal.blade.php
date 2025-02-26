@php
    use App\Helpers\ImageUploadHelper;
@endphp
<style>
    /* Style each form group */
    .form-group {
        margin-bottom: 20px;
        position: relative;
    }

    /* Style the labels */
    .form-group label {
        font-size: 14px;
        font-weight: bold;
        color: #333;
        display: block;
        margin-bottom: 5px;
    }

    /* Style the input fields */
    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 10px;
        font-size: 14px;
        border: none;
        border-bottom: 2px solid #b2835e;
        outline: none;
        background: transparent;
        color: #333;
    }

    /* Style the textarea separately */
    .form-group textarea {
        resize: none;
        height: 80px;
        background: #f6f3ef;
    }

    .attribute_list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        align-items: center;
    }

    '




    span.color-variation.selected {
        transform: scale(1.14) !important;
    }
</style>

<form action="" method="post" id="cartForm">
    @csrf
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <div class="col-lg-12 variationContainer">
                        @foreach ($result as $group)
                            <div class="row" data-id="variation_{{ Str::slug($group['attribute']) }}">
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <h6>{{ $group['attribute'] }}: <span
                                                class="selectedValue-{{ Str::slug($group['attribute']) }}"></span></h6>
                                        <ul class="attribute_list">
                                            @foreach ($group['values'] as $value)
                                                <li class="attribute_list_item">
                                                    {{-- <input type="hidden" name="variation_values[]"
                                                        data-id="{{ Str::slug($value) }}" value=""> --}}
                                                    @if (Str::slug($group['attribute']) == 'color')
                                                        <span
                                                            class="variation_{{ Str::slug($value) }} variation_value_pointer color-variation"
                                                            data-id="{{ Str::slug($value) }}"
                                                            data-key="{{ Str::slug($group['attribute']) }}"
                                                            data-value="{{ $value }}"
                                                            style="background-color: {{ strtolower($value) }}; @if (strtolower($value) == 'white') border: 1px solid #ccc; @endif height: 25px; width: 25px; border-radius: 50%; display: inline-block; cursor: pointer;"></span>
                                                    @else
                                                        <span
                                                            class="variation_{{ Str::slug($value) }} variation_value_pointer"
                                                            data-id="{{ Str::slug($value) }}"
                                                            data-key="{{ Str::slug($group['attribute']) }}"
                                                            data-value="{{ $value }}" style="cursor: pointer;">
                                                            {{ $value }}
                                                        </span>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                {{-- product quality --}}
                <h6>Product Quality</h6>
                <div class="product-details__quantity">
                    <div class="quantity-box">
                        <button type="button" class="sub"><i class="fa fa-minus"></i></button>
                        <input type="text" id="product_quality" value="1">
                        <button type="button" class="add"><i class="fa fa-plus"></i></button>
                    </div>
                </div>
            </div>
            <input type="hidden" name="product_id" id="products_id" value="{{ $product->id }}">
            <input type="hidden" name="product_name" id="product_name" value="{{ $product->name }}">
            <input type="hidden" name="product_price" id="product_price" value="{{ $product->price }}">
            <input type="hidden" name="image" id="image"
                value="{{ ImageUploadHelper::getProductImageUrl($product->images->where('type', 'thumbnail')->first()?->image) }}">
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="floens-btn product__item__link mb-3 bg-danger p-3 rounded"
            data-bs-dismiss="modal"><span>Close</span>
        </button>

        <button type="submit" class="floens-btn product__item__link mb-3 p-3 rounded enquireSubmitBtn"><span>Add To
                Cart</span>
        </button>
    </div>
</form>
<script>
    $(".add").click(function() {
        let input = $("#product_quality");
        let currentValue = parseInt(input.val(), 10);
        input.val(currentValue + 1);
    });

    $(".sub").click(function() {
        let input = $("#product_quality");
        let currentValue = parseInt(input.val(), 10);
        if (currentValue > 1) {
            input.val(currentValue - 1);
        }
    });

    $("#product_quality").on("input", function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    $('.variation_value_pointer').on('click', function() {
        var id = $(this).attr('data-id');
        var key = $(this).attr('data-key');
        var value = $(this).attr('data-value');

        // Remove previously selected input for this key
        $('input[name="variation_values[' + key + ']"]').remove();

        // Create a new hidden input field for the selected variant
        $('<input>').attr({
            type: 'hidden',
            name: 'variation_values[' + key + ']',
            value: value
        }).appendTo('#cartForm');

        // Update the UI to show the selected variant
        $('.selectedValue-' + key).text(value);

        // Highlight the selected variant
        $('.variation_value_pointer[data-key="' + key + '"]').removeClass('selected');
        $(this).addClass('selected');
    });

    // On form submit, get selected values
    $('#cartForm').on('submit', function(e) {
        e.preventDefault(); // Prevent default submission for testing

        var selectedVariants = {};

        $('input[name^="variation_values"]').each(function() {
            var match = $(this).attr('name').match(
                /\[([^\]]+)\]/); // Extract text inside square brackets
            if (match) {
                var key = match[1]; // Get the extracted key
                var value = $(this).val();
                selectedVariants[key] = value;
            }
        });

        var productId = $('#products_id').val();
        var productName = $('#product_name').val();
        var productPrice = $('#product_price').val();
        var productImage = $('#image').val();
        var productQuality = $('#product_quality').val();

        addItem(productId, productName, productPrice, productQuality, productImage, selectedVariants);
        notify('success', 'Product added to cart.');
        $('#cartForm')[0].reset();
        $('#addToCartModal').modal('hide');
        displayCartItems();
        $('.totalCartItems').html(getTotalQuantity())
    });
</script>
