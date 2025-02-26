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
</style>

<form action="" method="post" id="enquireForm">
    @csrf
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="name">Variant</label>
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
                                                            style="background-color: {{ strtolower($value) }}; @if (strtolower($value) == 'white') border: 1px solid #ccc; @endif  height: 25px; width: 25px; border-radius: 50%; display: inline-block; cursor: pointer;"></span>
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
                <div class="form-group">
                    <label for="name">Your Name</label>
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
                    <label for="phone">Phone</label>
                    <input type="text" name="phone" id="phone" placeholder="Enter your phone">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="message">Message</label>
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
        $('.selectedValue-' + key).text(value);

        // Highlight the selected variant
        $('.variation_value_pointer[data-key="' + key + '"]').removeClass('selected');
        $(this).addClass('selected');
    });

    // On form submit, get selected values
    $('#enquireForm').on('submit', function(e) {
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

        console.log('Selected Variants:', selectedVariants);
        var id = $('#products_id').val();
        var formData = new FormData(document.getElementById('enquireForm'));
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
            }
        });
    });
</script>
