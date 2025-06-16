@push('style')
    <style>
        .mySwiperThumbs .swiper-slide {
            opacity: 0.6;
            cursor: pointer;
        }

        .mySwiperThumbs .swiper-slide-thumb-active img {
            opacity: 1;
            border: 2px solid #e28245;
            border-radius: 5px;
        }

        .main-image {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 400px;
            background: #f9f9f9;
            border-radius: 10px;
        }

        .main-image img {
            width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .thumb-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 5px;
        }
    </style>
@endpush

<div class="container">
    <div class="row gutter-y-50">
        @php
            $productImages = $product->images;
            $variantImages = $product->variations->flatMap(function ($variation) {
                return $variation->images;
            });
            $images = $productImages->merge($variantImages);

            $imageIdToIndex = [];
            foreach ($images as $index => $image) {
                $imageIdToIndex[$image->id] = $index;
            }
        @endphp

        <div class="col-lg-6 col-xl-6 wow fadeInLeft product-wrapper">
            <!-- Main Swiper -->
            <div class="swiper mySwiper2 mb-3">
                <div class="swiper-wrapper">
                    @foreach ($images as $image)
                        <div class="swiper-slide main-image">
                            <img src="{{ asset($image->path) }}" class="img-fluid" />
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Thumbnail Swiper -->
            <div class="swiper mySwiperThumbs">
                <div class="swiper-wrapper">
                    @foreach ($images as $image)
                        <div class="swiper-slide">
                            <img src="{{ asset($image->path) }}" class="img-fluid thumb-image" />
                        </div>
                    @endforeach
                </div>
            </div>
        </div>



        <div class="col-lg-6 col-xl-6 wow fadeInRight" data-wow-delay="300ms">
            <div class="product-details__content">
                <div class="product-details__excerpt d-none d-md-block">
                    <h3 class="product-details__excerpt__text1">
                        {{ $product->name ?? 'No Name' }}
                    </h3>
                </div>
                <div class="product-details__excerpt d-none d-md-block">
                    <p class="product-details__excerpt__text1">
                        {!! nl2br($product->short_description) !!}
                    </p>
                </div>
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
                                                data-attribute="{{ $group['attribute'] }}" value="{{ $value }}">
                                            <span class="badge bg-secondary">{{ $value }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div id="price-wrapper-ditails">
                    @if ($product->sale_price && $product->regular_price > 0)
                        <span class="price"
                            style="text-decoration: line-through; color: red; margin-right: 6px;">${{ $product->regular_price }}</span>
                        <span class="price">${{ $product->sale_price ?? $product->regular_price }}</span>
                    @else
                        <span class="price">${{ $product->regular_price ?? $product->regular_price }}</span>
                    @endif

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
                <!-- Mobile only: keep original position -->
                <div class="product-details__excerpt d-block d-md-none">
                    <h3 class="product-details__excerpt__text1">
                        {{ $product->name ?? 'No Name' }}
                    </h3>
                </div>
                <div class="product-details__excerpt d-block d-md-none">
                    <p class="product-details__excerpt__text1">
                        {!! nl2br($product->short_description) !!}
                    </p>
                </div>


            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        const imageIdToIndex = @json($imageIdToIndex);

        const swiperThumbs = new Swiper(".mySwiperThumbs", {
            spaceBetween: 10,
            slidesPerView: 5,
            freeMode: true,
            watchSlidesProgress: true,
        });

        const mainSwiper = new Swiper(".mySwiper2", {
            spaceBetween: 10,
            thumbs: {
                swiper: swiperThumbs,
            },
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
        });

        function goToImageById(imageId) {
            const index = imageIdToIndex[imageId];
            if (typeof index !== 'undefined') {
                mainSwiper.slideTo(index);
            } else {
                alert("Image ID not found.");
            }
        }
        const totalAttributes = {{ count($attributes) }};
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
                    url: "{{ route('get.product.variation.price', $product_id) }}",
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
                            if (response.data.images !== null) {
                                goToImageById(response.data.images.id);
                            }

                            // $('[data-image-id=' + custom_string + ']').click();
                            if (response.data.sale_price == null) {
                                $('#price-wrapper-ditails').html(
                                    `<span class="price">$${response.data.regular_price}</span>`
                                );
                            } else {
                                $('#price-wrapper-ditails').html(
                                    `<span class="price"
                                    style="text-decoration: line-through; color: red; margin-right: 6px;">$${response.data.regular_price}</span>
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
    </script>
@endpush
