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
        justify-content: space-between;
        align-items: center;
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
                        @foreach ($product->attributes as $key => $attribute)
                            <div class="row" data-id="variation_{{ $key }}">
                                <div class="col-lg-5">
                                    <div class="mb-3">
                                        <h6>{{ $attribute->name }}</h6>
                                        <ul class="attribute_list">
                                            @foreach ($attribute->values as $value)
                                                @continue($value->id != $attribute->pivot->attribute_value_id)
                                                <li class="attribute_list_item">
                                                    <input type="hidden" id="variation_{{ $value->id }}"
                                                        name="variation_values[{{ $attribute->id }}]"
                                                        value="{{ $value->id }}">
                                                    @if (strtolower($attribute->name) == 'color')
                                                        <span class="variation_{{ $value->id }}"
                                                            style="background-color: {{ strtolower($value->value) }}; height: 25px; width: 25px; border-radius: 50%; display: inline-block"></span>
                                                    @else
                                                        <span
                                                            class="variation_{{ $value->id }}">{{ $value->value }}</span>
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
            <input type="hidden" name="products[]" id="products">
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
