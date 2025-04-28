@extends('frontend.layouts.app')
@section('title', $product->name)
@section('content')
    <section class="page-header">
        <div class="page-header__bg"
            style="background-image: url('{{ asset('frontend/assets/images/backgrounds/page-header-bg-1-1.png') }}');">
        </div>
        <!-- /.page-header__bg -->
        <div class="container">
            <ul class="floens-breadcrumb list-unstyled">
                <li><i class="text-white icon-home"></i> <a href="{{ route('frontend.home') }}">Home</a></li>
                <li><span class="text-white">shop</span></li>
                <li><span class="text-white">{{ $product->name }}</span></li>
            </ul>
        </div>
    </section>

    <section class="product-details section-space">
        <div class="container">
            <!-- /.product-details -->
            <div class="row gutter-y-50">
                @php
                    $productImages = $product->images;
                    $variantImages = $product->variations->flatMap(function ($variation) {
                        return $variation->images;
                    });

                    $images = $productImages->merge($variantImages);
                @endphp
                <div class="col-lg-6 col-xl-6 wow fadeInLeft product-wrapper" data-wow-delay="200ms">
                    <div class="product-details__img">
                        <style>

                        </style>
                        <div class="swiper product-details__gallery-top">
                            <div class="swiper-wrapper">
                                @foreach ($images as $image)
                                    <div class="swiper-slide">
                                        <img src="{{ asset($image->path) }}" class="product-details__gallery-top__img">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="swiper product-details__gallery-thumb">
                            <div class="swiper-wrapper">
                                @foreach ($images as $image)
                                    @php
                                        $imageable_id = $image->imageable_id;
                                        $imageable_type = $image->imageable_type;
                                        $string = $imageable_type . '-' . $imageable_id;
                                    @endphp
                                    <div class="swiper-slide product-details__gallery-thumb-slide"
                                        data-image-id="{{ $imageable_id }}">
                                        <img src="{{ asset($image->path) }}" class="product-details__gallery-thumb__img">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-xl-6 wow fadeInRight" data-wow-delay="300ms">
                    <div class="product-details__content">
                        <div class="product-details__excerpt">
                            <h3 class="product-details__excerpt__text1">
                                {{ $product->name ?? 'No Name' }}
                            </h3>
                        </div><!-- /.excerp-text -->
                        <div class="product-details__excerpt">
                            <p class="product-details__excerpt__text1">
                                {!! nl2br($product->short_description) !!}
                            </p>
                        </div><!-- /.excerp-text -->
                        <div class="mt-3">
                            @foreach ($attributes as $group)
                                <div class="mb-3 row" id="variation_{{ Str::slug($group['attribute']) }}">
                                    <div class="col-12">
                                        <h6 class="mb-2">{{ $group['attribute'] }}:</h6>
                                        <div class="flex-wrap gap-2 d-flex">
                                            @foreach ($group['values'] as $value)
                                                <label class="attribute-option">
                                                    <input type="radio" class="attribute-input d-none"
                                                        name="{{ $group['attribute'] }}"
                                                        data-attribute="{{ $group['attribute'] }}"
                                                        value="{{ $value }}">
                                                    <span class="badge bg-secondary">{{ $value }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div id="price-wrapper-ditails">
                            <span class="price"
                                style="text-decoration: line-through; color: red; margin-right: 6px;">${{ $product->regular_price }}</span>
                            <span class="price">${{ $product->sale_price ?? $product->regular_price }}</span>
                        </div>

                        <div class="product-details__buttons">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="product-details__description-wrapper">
            <div class="container">
                <!-- /.product-description -->
                <div class="product-details__description">
                    <h3 class="product-details__description__title">product Description</h3>
                    <div class="product-details__text__box wow fadeInUp" data-wow-delay="300ms">
                        <p class="product-details__description__text">
                            {!! $product->description !!}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Products End -->
@endsection
@section('page-script')
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            const totalAttributes = {{ count($attributes) }};
            // ✅ Init Swiper sliders
            var galleryThumbs = new Swiper('.product-details__gallery-thumb', {
                spaceBetween: 10,
                slidesPerView: 4,
                freeMode: true,
                watchSlidesProgress: true,
            });

            var galleryTop = new Swiper('.product-details__gallery-top', {
                spaceBetween: 10,
                thumbs: {
                    swiper: galleryThumbs
                },
                centeredSlides: true,
                slidesPerView: 1,
            });

            // ✅ Reusable function to update gallery
            function updateSwiperGallery(images) {
                galleryTop.removeAllSlides();
                galleryThumbs.removeAllSlides();

                $.each(images, function(index, imagePath) {
                    const imageUrl = '/' + imagePath.replace(/^\/?/, '');

                    galleryTop.appendSlide(`
                    <div class="swiper-slide">
                        <img src="${imageUrl}" class="product-details__gallery-top__img">
                    </div>`);

                    galleryThumbs.appendSlide(`
                    <div class="swiper-slide product-details__gallery-thumb-slide">
                        <img src="${imageUrl}" class="product-details__gallery-thumb__img">
                    </div>`);
                });

                // Optionally reset to first slide
                galleryTop.slideTo(0);
                galleryThumbs.slideTo(0);
            }

            // ✅ Listen to attribute changes
            $('.attribute-input').on('change', function() {
                let selectedAttributes = {};

                $('.attribute-input:checked').each(function() {
                    selectedAttributes[$(this).attr('name')] = $(this).val();
                });

                if (Object.keys(selectedAttributes).length === totalAttributes) {
                    let variationString = $.map(selectedAttributes, function(val, key) {
                        return key + ': ' + val;
                    }).join(' / ');

                    $.ajax({
                        url: "{{ route('get.product.variation.price', $product->id) }}",
                        method: 'GET',
                        data: {
                            variation: variationString
                        },
                        beforeSend: function() {
                            $('#loader').show()
                        },
                        success: function(response) {
                            $('#loader').hide();

                            if (response.status === 'success') {
                                let custom_string = response.data.images.imageable_type + '-' +
                                    response.data.images.imageable_id;

                                let swiperCustomId = $(
                                    `[data-image-id="${response.data.images.imageable_id}"]`
                                ).attr('data-swiper-slide-index');

                                galleryThumbs.slideTo(swiperCustomId[0]);
                                galleryTop.slideTo(swiperCustomId[0]);

                                galleryTop.on('slideChange', function() {
                                    galleryTop.update();
                                    galleryThumbs.update();
                                });

                                // $('[data-image-id=' + custom_string + ']').click();
                                if (response.data.sale_price == null) {
                                    $('#price-wrapper-ditails').html(
                                        `<span class="price">$ ${response.data.regular_price}</span>`
                                    );
                                } else {
                                    $('#price-wrapper-ditails').html(
                                        `<span class="price"
                                    style="text-decoration: line-through; color: red; margin-right: 6px;">$ ${response.data.regular_price}</span>
                                    <span class="price">$ ${response.data.sale_price}</span>`
                                    );
                                }

                            } else {
                                alert(response.message || 'Variation not found.');
                            }
                        },
                        error: function() {
                            $('#loader').hide();
                            alert('Something went wrong.');
                        }
                    });
                }
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
                // $('#addToCartModal').modal('show');
                $.ajax({
                    url: url,
                    method: 'GET',
                    beforeSend: function() {
                        $('#loader').show();
                    },
                    success: function(response) {
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
@endsection
@section('page-style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />
    <style>
        span.price {
            font-size: 20px;
            font-weight: 700;
            color: #e28245;
        }

        .product-details__buttons {
            margin-top: 15px !important;
        }

        .attribute-option {
            cursor: pointer;
        }

        .attribute-option .badge {
            padding: 0.6rem 1rem;
            border: 1px solid transparent;
            transition: all 0.3s ease;
        }

        .attribute-option input:checked+.badge {
            background-color: #e28245 !important;
            color: white;
            border-color: #db783b;
        }

        .product-details__gallery-thumb__img {
            width: 83px !important;
            height: 83px !important;
        }

        .product-details__description figure table {
            width: 100%;
            padding: 20px !important;
            display: block;
            background: #fff;
        }

        .product-details__gallery-top__img {
            height: 521px;
        }

        .product-details__gallery-top {
            width: 100%;
            aspect-ratio: 1 / 1;
            overflow: hidden;
            position: relative;
        }

        .product-details__gallery-top .swiper-wrapper .swiper-slide {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 550px;
            background: #f9f9f9;
        }

        .product-details__gallery-top .swiper-wrapper .swiper-slide img {
            width: auto;
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            display: block;
            margin: 0 auto;
        }

        .floens-breadcrumb li:not(:last-of-type)::after {
            color: #fff;
        }

        .section-space {
            padding-top: var(--section-space, 120px);
            padding-bottom: 0;
        }

        .skeleton-loader {
            background: linear-gradient(-90deg, #f0f0f0 0%, #e2e2e2 50%, #f0f0f0 100%);
            background-size: 200% 100%;
            animation: shimmer 1.2s infinite;
            border-radius: 8px;
            width: 100%;
            height: 400px;
        }

        .skeleton-thumb {
            height: 100px;
        }

        @keyframes shimmer {
            0% {
                background-position: 200% 0;
            }

            100% {
                background-position: -200% 0;
            }
        }

        @media only screen and (max-width: 480px) {
            .product-wrapper {
                margin-top: -40px;
            }

            .product-details__gallery-top .swiper-wrapper .swiper-slide {
                height: 350px;
            }
        }
    </style>
@endsection
