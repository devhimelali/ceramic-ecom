<style>
    /* Style the submit button */
    .custom-button {
        /* width: 100%; */
        padding: 10px;
        border: none;
        background: var(--floens-base, #C7844F);
        color: white;
        font-size: 16px;
        cursor: pointer;
    }

    .custom-button:hover {
        background: #9a6e4b;
    }

    .enquireBtn {
        width: 70%;
    }

    .owl-carousel .owl-nav button.owl-prev,
    .owl-carousel .owl-nav button.owl-prev,
    .owl-carousel button.owl-dot.owl-nav {
        position: absolute;
        left: 15px;
        top: 50%;
        background-color: #434343c7 !important;
        color: #fff !important;
        font-size: 22px !important;
        border-radius: 50% !important;
        width: 25px;
        height: 25px;
        display: flex;
        align-items: center;
        justify-content: center;
        transform: translateY(-50%);
    }

    .owl-carousel .owl-nav button.owl-next,
    .owl-carousel .owl-nav button.owl-next,
    .owl-carousel button.owl-dot.owl-nav {
        position: absolute;
        right: 12px;
        top: 50%;
        background-color: #434343c7 !important;
        color: #fff !important;
        font-size: 22px !important;
        border-radius: 50% !important;
        width: 25px;
        height: 25px;
        display: flex;
        align-items: center;
        justify-content: center;
        transform: translateY(-50%);
        z-index: 1;
    }

    .product__item {
        border: 1px solid #DED8D3;
        border-radius: 4px;
    }

    .product__item:hover {
        border: 1px solid #2a4e72;
    }

    .product_item_content {
        border: none;
        padding: 0.24px 17px 20px !important;
    }

    span.discount {
        position: absolute;
        right: 7px;
        top: 7px;
        z-index: 2;
        background: #C7844F;
        color: #fff !important;
        padding: 2px 8px;
        border-radius: 18px;
    }

    .product_item_price {
        margin-bottom: 12px;
    }

    .custom-button {
        font-size: 14px !important;
        padding: 12px 24px;
    }

    .addToCartBtn {
        padding: 19px 24px !important;
    }

    .product__item__image {
        border-radius: 4px;
    }

    @media screen and (max-width: 480px) {
        .custom-button {
            /* padding: 12px 1px !important; */

        }
    }
</style>
<div class="row gutter-y-30 mt-3">
    @forelse ($products as $product)
        <div class="col-xl-4 col-lg-4 col-md-6 col-6 product_item">
            <div class="product__item wow fadeInUp" data-wow-duration='1500ms' data-wow-delay='000ms'>
                @php
                    $productImages = $product->images;
                    $variantImages = $product->variations->flatMap(function ($variation) {
                        return $variation->images;
                    });

                    $images = $productImages->merge($variantImages);
                @endphp
                @if ($product->sale_price && $product->regular_price > 0)
                    @php
                        $saving = (($product->regular_price - $product->sale_price) / $product->regular_price) * 100;
                    @endphp
                    <span class="discount" style="margin-left: 10px; font-size: 10px;">
                        Saving {{ number_format($saving, 0) }}%
                    </span>
                @else
                    <span class="discount" style="margin-left: 10px; font-size: 10px;">Saving 0%</span>
                @endif
                <div class="product_item_image product-carousel owl-carousel">
                    @foreach ($images as $image)
                        <img class="item" src="{{ asset($image->path) }}" alt="Natural Stone Tiles"
                            style="height: 300px;">
                    @endforeach
                </div>

                <div class="product_item_content mt-3">
                    <h6 class="product_item_title">
                        <a
                            href="{{ route('product.details', $product->slug) }}">{{ Str::limit($product->name, 15) }}</a>
                    </h6><!-- /.product-title -->
                    <div class="product_item_price">
                        @if ($product->sale_price && $product->regular_price > 0)
                            <span
                                style="text-decoration: line-through; color: #888; font-size: 16px; margin-right: 10px;">
                                {{ env('CURRENCY_SYMBOL') }}{{ number_format($product->regular_price, 2) }}
                            </span>
                            <span style="color: #888; font-size: 16px;">
                                {{ env('CURRENCY_SYMBOL') }}{{ number_format($product->sale_price, 2) }}
                            </span>
                        @else
                            <span>
                                {{ env('CURRENCY_SYMBOL') }}{{ number_format($product->regular_price, 2) }}
                            </span>
                        @endif
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="javascript:void(0);"
                            class="p-3 floens-btn product_item_link me-2 custom-button enquireBtn"
                            data-id="{{ $product->id }}"
                            data-url="{{ route('enquireForm', $product->id) }}">Enquire</a>

                        <a href="javascript:void(0);"
                            class="p-4 floens-btn product_item_link me-2 custom-button addCartItemBtn addToCartBtn"
                            data-product-id="{{ $product->id }}"
                            data-url="{{ route('add.to.cart.form', $product->id) }}">
                            <i style='font-size:17px; right: 15px' class='fas'>&#xf217;</i></a>
                    </div>
                </div><!-- /.product-content -->
            </div><!-- /.product-item -->
        </div><!-- /.col-md-6 col-lg-4 -->
    @empty
        <div class="no-products-message">
            <h2 class="my-auto text-center text-danger">No products found</h2>
        </div>
    @endforelse
</div><!-- /.row -->
<div class="mt-5">
    <div class="mt-4 d-flex justify-content-center" id="pagination-wrapper">
        {{ $products->links('pagination::bootstrap-4') }}
    </div>
</div>

<script>
    $(document).ready(function() {

        var owl = $('.product-carousel');
        owl.owlCarousel({
            items: 1,
            loop: true,
            margin: 10,
            autoplay: true,
            autoplayTimeout: 2000,
            autoplayHoverPause: true,
            nav: true,
            dots: false,
        });

        $('.play').on('click', function() {
            owl.trigger('play.owl.autoplay', [1000]);
        });

        $('.stop').on('click', function() {
            owl.trigger('stop.owl.autoplay');
        });


        displayCartItems();
        $('.enquireBtn').click(function() {
            var productId = $(this).data('id');
            var url = $(this).data('url');
            $.ajax({
                url: url,
                method: 'GET',
                beforeSend: function() {
                    $('#loader').show();
                },
                success: function(response) {
                    $('.enquireSubmitBtn').prop('disabled', false)
                    $('.enquireSubmitBtn').html('Submit')
                    $('#enquireFormResponse').html(response.html);
                    $('#myModal').modal('show');
                },
                complete: function() {
                    $('#loader').hide();
                }
            })
        });

        $('.addToCartBtn').click(function() {
            var productId = $(this).data('product-id');
            var url = $(this).data('url');
            $.ajax({
                url: url,
                method: 'GET',
                beforeSend: function() {
                    $('#loader').show();
                },
                success: function(response) {
                    $('.enquireSubmitBtn').prop('disabled', false)
                    $('.enquireSubmitBtn').html('Add To Cart')
                    $('#addToCartResponse').html(response.html);
                    $('#addToCartModal').modal('show');
                },
                complete: function() {
                    $('#loader').hide();
                }
            })
        });

        $('#enquireForm').submit(function(e) {
            e.preventDefault();
            var formData = $('#enquireForm').serialize();
            $.ajax({
                url: "{{ route('enquire') }}",
                method: 'POST',
                data: formData,
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
    });
</script>
