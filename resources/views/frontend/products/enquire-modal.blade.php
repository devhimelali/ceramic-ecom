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

    span.variation_value_pointer.selected {
        background: #e28245;
        padding: 4px 8px;
        border-radius: 4px;
        color: #fff;
    }

    span.color-variation.selected {
        transform: scale(1.14);
    }

    .variationContainer {
        border: 1px solid #d7d7d7;
        padding: 6px 14px 0px 14px;
    }

    .singleVariationContainer:not(:last-child) {
        border-bottom: 1px solid #d7d7d7;
        margin-bottom: 10px;
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

<form action="" method="post" id="enquireForm">
    @csrf
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="name" style="font-size: 16px">Variant <span class="text-danger"
                            style="font-size: 12px;">* (Please select the product variation)</span></label>
                    <div class="col-lg-12 variationContainer">
                        @foreach ($attributes as $group)
                            <div class="row singleVariationContainer"
                                data-id="variation_{{ Str::slug($group['attribute']) }}">
                                <div class="col-lg-12">
                                    <div>
                                        <h6 class="attribute-title">
                                            {{ $group['attribute'] }}: <span
                                                class="selectedValue-{{ Str::slug($group['attribute']) }}"></span>
                                        </h6>
                                        <ul class="attribute_list">
                                            @foreach ($group['values'] as $value)
                                                <li class="attribute_list_item">
                                                    {{-- Hidden input for variation selection --}}
                                                    @if (Str::slug($group['attribute']) == 'color')
                                                        <span
                                                            class="variation_{{ Str::slug($value) }} variation_value_pointer color-variation"
                                                            data-id="{{ Str::slug($value) }}"
                                                            data-key="{{ Str::slug($group['attribute']) }}"
                                                            data-value="{{ $value }}"
                                                            style="border: 1px solid #ddd; padding: 4px 8px; border-radius: 4px; background-color: {{ strtolower($value) }}; @if (strtolower($value) == 'white') border: 1px solid #ccc; @endif  height: 25px; width: 25px; border-radius: 50%; display: inline-block; cursor: pointer;"></span>
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

            <div class="col-md-12">
                <div class="form-group">
                    <label for="name">Your Name <span class="text-danger">*</span></label>
                    <input type="text" id="name" name="name" placeholder="Enter your name">
                </div>
            </div>
            <input type="hidden" name="product_id" id="products_id" value="{{ $product->id }}">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" placeholder="Enter your email">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="phone">Phone <span class="text-danger">*</span></label>
                    <input type="text" name="phone" id="phone" placeholder="Enter your phone">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="message">Message <span class="text-danger">*</span></label>
                    <textarea name="message" id="message" placeholder="Enter your message"></textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="floens-btn product__item__link mb-3 bg-danger p-3 rounded"
            data-bs-dismiss="modal"><span>Close</span>
        </button>
        <button type="submit"
            class="floens-btn product__item__link mb-3 p-3 rounded enquireSubmitBtn"><span>Submit</span>
        </button>
    </div>
</form>

<script>
    // Click event for selecting variation values
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
        }).appendTo('#enquireForm');

        // Update the UI to show the selected variant
        $('.selectedValue-' + key).text(value).css({
            "font-size": "13px",
            "font-weight": "200",
            "border": "1px solid red",
            "padding": "2px 5px",
            "border-radius": "3px",
            "background": "red",
            "color": "white"
        });

        // Highlight the selected variant
        $('.variation_value_pointer[data-key="' + key + '"]').removeClass('selected');
        $(this).addClass('selected');
    });

    // On form submit, get selected values and send the data via AJAX
    $('#enquireForm').on('submit', function(e) {
        e.preventDefault(); // Prevent default submission for testing

        // var selectedVariants = {};

        // // Collect the selected variation values
        // $('input[name^="variation_values"]').each(function() {
        //     var match = $(this).attr('name').match(
        //         /\[([^\]]+)\]/); // Extract text inside square brackets
        //     if (match) {
        //         var key = match[1]; // Get the extracted key
        //         var value = $(this).val();
        //         selectedVariants[key] = value;
        //     }
        // });
        let selectedVariants = {};

        // Loop through each input with name starting with variation_values
        $('input[name^="variation_values"]').each(function() {
            var match = $(this).attr('name').match(/\[([^\]]+)\]/); // extract key from [key]
            if (match) {
                var key = match[1]; // e.g., Color, Size, etc.
                var value = $(this).val(); // selected value
                selectedVariants[key] = value;
            }
        });

        // Convert to attribute_string format
        let attributeString = Object.entries(selectedVariants)
            .map(([key, value]) => `${key}: ${value}`)
            .join(' / ');



        // Include the product ID and other form data
        var id = $('#products_id').val();
        var formData = new FormData(document.getElementById('enquireForm'));
        formData.append('variation', attributeString);
        var actionUrl = "{{ route('submit.single.product.query', $product->id) }}";

        $.ajax({
            url: actionUrl,
            method: 'POST',
            data: formData,
            contentType: false, // Ensure that contentType is false when sending FormData
            processData: false, // Do not process the data as a query string
            beforeSend: function() {
                $('.enquireSubmitBtn').prop('disabled', true);
                $('.enquireSubmitBtn').html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending...'
                );
            },
            success: function(response) {
                $('.enquireSubmitBtn').prop('disabled', false);
                $('.enquireSubmitBtn').html('Submit');
                if (response.status == 'success') {
                    notify(response.status, response.message);
                    $('#enquireForm')[0].reset();
                    $('#myModal').modal('hide');
                }
            },
            error: function(xhr, status, error) {
                $('.enquireSubmitBtn').prop('disabled', false);
                $('.enquireSubmitBtn').html('Submit');
                let errors = xhr.responseJSON.errors;
                if (errors) {
                    $.each(errors, function(key, value) {
                        let inputField = $('[name="' + key + '"]');
                        inputField.addClass('is-invalid');
                        notify('error', value[0]);
                    });
                }
            }
        });
    });
</script>
