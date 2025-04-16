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

    span.color-variation.selected {
        transform: scale(1.14) !important;
    }

    .variationContainer {
        border: 1px solid #d7d7d7;
        padding: 0px 12px 0px 12px;
    }

    .singleVariationContainer:not(:last-child) {
        border-bottom: 1px solid #d7d7d7;
        margin: 0 -12px 0 -12px;
        /*padding: 3px 0;*/
    }

    .attribute-title {
        display: inline-block;
        float: left;
        margin-right: 30px;
        color: black;
        font-size: 14px !important;
        line-height: 26px;
    }
</style>

<form action="" method="post" id="cartForm">
    @csrf
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <div class="col-lg-12 variationContainer">
                        @foreach ($attributes as $group)
                            <div class="row singleVariationContainer"
                                data-id="variation_{{ Str::slug($group['attribute']) }}">
                                <div class="col-lg-12 py-2">
                                    <div>
                                        <h6 class="attribute-title mb-0">{{ $group['attribute'] }}:
                                            <span class="selectedValue-{{ Str::slug($group['attribute']) }}"></span>
                                        </h6>
                                        <ul class="attribute_list">
                                            @foreach ($group['values'] as $value)
                                                <li class="attribute_list_item">
                                                    @if (Str::slug($group['attribute']) == 'color')
                                                        <span
                                                            class="variation_{{ Str::slug($value) }} variation_value_pointer color-variation"
                                                            data-id="{{ Str::slug($value) }}"
                                                            data-key="{{ Str::slug($group['attribute']) }}"
                                                            data-value="{{ $value }}"
                                                            style="border: 1px solid #ddd; padding: 4px 8px; border-radius: 4px; background-color: {{ strtolower($value) }}; @if (strtolower($value) == 'white') border: 1px solid #ccc; @endif height: 25px; width: 25px; border-radius: 50%; display: inline-block; cursor: pointer;">
                                                        </span>
                                                    @else
                                                        <span
                                                            class="variation_{{ Str::slug($value) }} variation_value_pointer"
                                                            data-id="{{ Str::slug($value) }}"
                                                            data-key="{{ Str::slug($group['attribute']) }}"
                                                            data-value="{{ $value }}"
                                                            style="cursor: pointer; border: 1px solid #ddd; padding: 4px 8px; border-radius: 4px;">
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

            {{-- product quantity --}}
            <div class="col-md-12">
                <h6>Product Quantity</h6>
                <div class="product-details__quantity">
                    <div class="quantity-box">
                        <button type="button" class="sub"><i class="fa fa-minus"></i></button>
                        <input type="text" id="product_quality" value="1" name="product_quality">
                        <button type="button" class="add"><i class="fa fa-plus"></i></button>
                    </div>
                </div>
            </div>

            {{-- hidden product data --}}
            <input type="hidden" name="product_id" id="products_id" value="{{ $product->id }}">
            <input type="hidden" name="product_name" id="product_name" value="{{ $product->name }}">
            <input type="hidden" name="product_price" id="product_price" value="{{ $product->price }}">
            <input type="hidden" name="image" id="image"
                value="{{ ImageUploadHelper::getProductImageUrl($product->images->where('type', 'thumbnail')->first()?->image) }}">
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="floens-btn product__item__link mb-3 bg-danger p-3 rounded"
            data-bs-dismiss="modal">
            <span>Close</span>
        </button>

        <button type="submit" class="floens-btn product__item__link mb-3 p-3 rounded enquireSubmitBtn">
            <span>Add To Cart</span>
        </button>
    </div>
</form>

<script>
    $(document).ready(function() {
        // Increment Quantity
        $(".add").click(function() {
            let input = $("#product_quality");
            let currentValue = parseInt(input.val(), 10) || 1;
            input.val(currentValue + 1);
        });

        // Decrement Quantity
        $(".sub").click(function() {
            let input = $("#product_quality");
            let currentValue = parseInt(input.val(), 10) || 1;
            if (currentValue > 1) {
                input.val(currentValue - 1);
            }
        });

        // Only numeric input allowed
        $("#product_quality").on("input", function() {
            this.value = this.value.replace(/[^0-9]/g, '');
            if (this.value === '' || parseInt(this.value) < 1) {
                this.value = 1;
            }
        });

        // Handle variation click
        $('.variation_value_pointer').on('click', function() {
            var key = $(this).data('key');
            var value = $(this).data('value');

            // Remove old input if exists
            $('input[name="variation_values[' + key + ']"]').remove();

            // Add new input
            $('<input>').attr({
                type: 'hidden',
                name: 'variation_values[' + key + ']',
                value: value
            }).appendTo('#cartForm');

            // UI feedback
            $('.variation_value_pointer[data-key="' + key + '"]').removeClass('selected');
            $(this).addClass('selected');

            // Optional: show selection next to attribute label
            $('.selectedValue-' + key).text(value);
        });

        // Handle Form Submit
        $('#cartForm').on('submit', function(e) {
            e.preventDefault();

            var selectedVariants = {};
            $('input[name^="variation_values"]').each(function() {
                var match = $(this).attr('name').match(/\[([^\]]+)]/);
                if (match) {
                    selectedVariants[match[1]] = $(this).val();
                }
            });

            let productId = $('#products_id').val();
            let productName = $('#product_name').val();
            let productPrice = $('#product_price').val();
            let productImage = $('#image').val();
            let productQuality = $('#product_quality').val();

            // Perform your logic
            addItem(productId, productName, productPrice, productQuality, productImage,
                selectedVariants);
            notify('success', 'Product added to cart.');

            // Reset form (removes variation inputs too)
            $('#cartForm')[0].reset();
            $('#cartForm input[name^="variation_values"]').remove();
            $('.variation_value_pointer').removeClass('selected');
            $('.attribute-title span').text('');

            // Hide Modal & Refresh cart view
            $('#addToCartModal').modal('hide');
            displayCartItems();
            $('.totalCartItems').html(getTotalQuantity());
        });
    });
</script>
