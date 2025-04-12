@php
    use App\Helpers\ImageUploadHelper;
@endphp
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
        left: 20px;
        top: 50%;
        background-color: var(--base-color) !important;
        display: block;
        padding: 0 .3em !important;
        font-size: 3em;
        margin: 0;
        cursor: pointer;
        color: #fff;
        transform: translate(-50%, -50%);
    }

    .owl-carousel .owl-nav button.owl-next,
    .owl-carousel .owl-nav button.owl-next,
    .owl-carousel button.owl-dot.owl-nav {
        position: absolute;
        right: -23px;
        top: 50%;
        background-color: var(--base-color) !important;
        display: block;
        padding: 0 .3em !important;
        font-size: 3em;
        margin: 0;
        cursor: pointer;
        color: #fff;
        transform: translate(-50%, -50%);
    }
</style>
<div class="row gutter-y-30">
    @forelse ($products as $product)
        <div class="col-xl-4 col-lg-6 col-md-6 ">
            <div class="product__item wow fadeInUp" data-wow-duration='1500ms' data-wow-delay='000ms'>
                @php
                    $images = $product->images->filter(function ($image) {
                        return in_array($image->type, ['gallery', 'thumbnail']);
                    });
                @endphp
                <div class="product__item__image product-carousel owl-carousel">
                    @foreach ($images as $image)
                        <img class="item"
                            src="{{ ImageUploadHelper::getProductImageUrl($image?->image, 'products', 'thumbnail') }}"
                            alt="Natural Stone Tiles">
                    @endforeach
                </div>

                <div class="product__item__content">
                    <h6 class="product__item__title"><a
                            href="{{ route('product.details', $product->slug) }}">{{ Str::limit($product->name, 15) }}</a>
                    </h6><!-- /.product-title -->
                    <div class="product__item__price">{{ env('CURRENCY_SYMBOL') }}{{ $product->price }}</div>
                    <!-- /.product-price -->
                    {{-- <a href="#" class="py-3 floens-btn product__item__link">
                        <span>Add to Cart</span>
                        <i class="icon-cart"></i>
                    </a> --}}

                    <div class="d-flex align-items-center justify-content-center">
                        <a href="javascript:void(0);"
                            class="p-3 floens-btn product__item__link me-2 custom-button enquireBtn"
                            data-id="{{ $product->id }}"
                            data-url="{{ route('enquireForm', $product->id) }}">Enquire</a>

                        <a href="javascript:void(0);"
                            class="p-4 floens-btn product__item__link me-2 custom-button addCartItemBtn addToCartBtn"
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
            $('#myModal').modal('show');
            var productId = $(this).data('id');
            var url = $(this).data('url');
            $.ajax({
                url: url,
                method: 'GET',
                beforeSend: function() {
                    $('#myModal .modal-body').html(
                        '<div class="text-center d-flex align-items-center justify-content-center" style="height: 200px;"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>'
                    );
                    $('.enquireSubmitBtn').prop('disabled', true)
                    $('.enquireSubmitBtn').html('Processing...')
                },
                success: function(response) {
                    $('.enquireSubmitBtn').prop('disabled', false)
                    $('.enquireSubmitBtn').html('Submit')
                    $('#enquireFormResponse').html(response.html);
                }
            })
        });

        $('.addToCartBtn').click(function() {
            var productId = $(this).data('product-id');
            var url = $(this).data('url');
            $('#addToCartModal').modal('show');
            $.ajax({
                url: url,
                method: 'GET',
                beforeSend: function() {
                    $('#addToCartModal .modal-body').html(
                        '<div class="text-center d-flex align-items-center justify-content-center" style="height: 200px;"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>'
                    );
                    $('.enquireSubmitBtn').prop('disabled', true)
                    $('.enquireSubmitBtn').html('Processing...')
                },
                success: function(response) {
                    $('.enquireSubmitBtn').prop('disabled', false)
                    $('.enquireSubmitBtn').html('Add To Cart')
                    $('#addToCartResponse').html(response.html);
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
