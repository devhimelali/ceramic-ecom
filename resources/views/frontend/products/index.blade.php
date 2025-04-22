@extends('frontend.layouts.app')
@section('title', 'Products')
@section('page-style')
    <!-- Include jQuery UI CSS -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{ asset('frontend/assets/vendors/owl-carousel/css/owl.carousel.min.css') }}">
    <link rel="preload" as="image" href="{{ asset('frontend/assets/images/backgrounds/page-header-bg-1-1.png') }}">


    <style>
        /* === Product Sidebar Styles === */
        .product__sidebar__attribute {
            margin-bottom: 20px;
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
        }

        .product__sidebar__title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .product__sidebar__values {
            padding-left: 20px;
        }

        .product__sidebar__value {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
        }

        .product__sidebar__checkbox {
            margin-right: 10px;
            width: 18px;
            height: 18px;
            accent-color: var(--floens-base, #a36d43);
        }

        .product__sidebar__label {
            font-size: 16px;
            color: #555;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .product__sidebar__label:hover {
            color: var(--floens-base, #C7844F);
        }

        /* Expand Icon */
        .expand-icon {
            font-size: 20px;
            color: var(--floens-base, #C7844F);
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .expand-icon i {
            transition: transform 0.3s ease;
        }

        .expand-icon.open i {
            transform: rotate(183deg);
        }

        /* === Loader Styles === */
        #products {
            position: relative;
        }

        #loader {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 80%;
            background: rgba(10, 10, 10, 0.14);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 10;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 8px solid #f3f3f3;
            border-top: 8px solid #dc7221;
            border-radius: 50%;
            animation: spin 1.5s linear infinite;
        }

        #loader p {
            margin-top: 10px;
            font-size: 16px;
            color: #fff;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* === Misc Styles === */
        .no-products-message {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }

        .pagination .page-item.active .page-link {
            background-color: var(--floens-base, #C7844F) !important;
            border-color: var(--floens-base, #C7844F) !important;
            color: #fff !important;
        }

        .pagination .page-link {
            color: #333;
        }

        @media (max-width: 767px) {
            .product__info-top {
                display: flex;
                align-items: flex-start !important;
            }
        }

        .product-page {
            padding-top: 0;
        }

        /* === Buttons === */
        .custom-button {
            border: none;
            background: var(--floens-base, #C7844F);
            color: #fff;
            font-size: 12px;
            cursor: pointer;
            padding: 13px 24px !important;
        }

        .custom-button:hover {
            background: #9a6e4b;
        }

        .enquireBtn {
            width: 70%;
        }

        .mobile-btn {
            padding: 11px 0 !important;
        }

        .addToCartBtn {
            padding: 19px 24px !important;
        }

        @media screen and (max-width: 480px) {
            .addToCartBtn {
                padding: 14px 21px !important;
            }

            .addToCartBtn i {
                font-size: 12px !important;
            }
        }

        /* === Carousel Navigation === */
        .owl-carousel .owl-nav button.owl-prev,
        .owl-carousel .owl-nav button.owl-next {
            position: absolute;
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

        .owl-carousel .owl-nav button.owl-prev {
            left: 15px;
        }

        .owl-carousel .owl-nav button.owl-next {
            right: 12px;
            z-index: 1;
        }

        /* === Product Item === */
        .product__item {
            border: 1px solid #DED8D3;
            border-radius: 4px;
        }

        .product__item:hover {
            border-color: #2a4e72;
        }

        .product_item_content {
            border: none;
            padding: 0.24px 17px 20px !important;
        }

        .product__item__image {
            border-radius: 4px;
        }

        .product-image {
            height: 300px;
        }

        @media screen and (max-width: 480px) {
            .product-image {
                height: 207px;
            }
        }

        /* === Discount Tag === */
        span.discount {
            position: absolute;
            top: 7px;
            right: 7px;
            z-index: 2;
            background: #C7844F;
            color: #fff !important;
            padding: 2px 8px;
            border-radius: 18px;
        }

        /* === Price Styling === */
        .product_item_price {
            margin-bottom: 12px;
        }

        .product__item__price {
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 14px !important;
            font-weight: 700;
            color: var(--floens-text, #7A736A);
            line-height: normal;
            margin-bottom: 17px !important;
        }

        .product__item__price span {
            font-size: 13px !important;
        }

        div#filterOffcanvas {
            width: 82%;
        }

        .product_item_image {
            width: 100%;
            aspect-ratio: 1 / 1;
            /* Makes it square */
            overflow: hidden;
            position: relative;
        }

        .product_item_image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
    </style>

@endsection
@section('content')
    <section class="page-header">
        <div class="page-header__bg"
            style="background-image: url('{{ asset('frontend/assets/images/backgrounds/page-header-bg-1-1.png') }}');">
        </div>

        <div class="container">
            <h2 class="page-header__title">Find Your Products</h2>
            <ul class="floens-breadcrumb list-unstyled">
                <li><i class="icon-home text-white"></i> <a href="{{ route('frontend.home') }}">Home</a></li>
                <li><span class="text-white">Products</span></li>
            </ul>
        </div>
    </section>


    <section class="product-page product-page--left section-space-bottom">
        <div class="container">


            <div class="row gutter-y-60">
                <!-- Sidebar: XL and above -->
                <div class="col-xl-3 col-lg-4 d-none d-xl-block" id="sidebar-column">
                    <div id="original-filter-sidebar">
                        <aside class="product__sidebar">
                            <!-- Search Box -->
                            <div class="product__search-box product__sidebar__item">
                                <a href="{{ route('frontend.productsPage') }}" class="btn btn-danger w-100 rounded-0">Reset
                                    Filters</a>
                            </div>
                            <div class="product__search-box product__sidebar__item">
                                <form action="#" class="product__search" id="product__search">
                                    <input type="text" placeholder="search items" value="{{ request('search') }}"
                                        id="searchQuery" />
                                    <button type="submit" aria-label="search submit">
                                        <span class="icon-search"></span>
                                    </button>
                                </form>
                            </div>

                            <!-- Price Filter -->
                            <div class="product__price-ranger product__sidebar__item">
                                <form action="#" class="price-ranger">
                                    <h3 class="product__sidebar__title">Filter by Price</h3>
                                    <input type="range" class="form-range" id="price-range" min="0" max="10000"
                                        step="10" value="{{ request('max_price', 10000) }}">
                                    <div class="ranger-min-max-block">
                                        <div><span id="min-price">0</span> - <span
                                                id="max-price">{{ request('max_price', 10000) }}</span></div>
                                    </div>
                                </form>
                            </div>

                            <!-- Attribute Filters -->
                            <div class="product__categories product__sidebar__item">
                                @foreach ($attributes as $name => $values)
                                    @php
                                        $selectedValues = request()->input('attribute.' . $name, []);
                                        $decodedValues = array_map(
                                            fn($value) => base64_decode($value),
                                            (array) $selectedValues,
                                        );
                                    @endphp
                                    <div class="product__sidebar__attribute">
                                        <h3 class="product__sidebar__title product__categories__title"
                                            data-attribute-id="{{ $name }}">
                                            {{ $name }}
                                            <span class="expand-icon" id="expand-icon-{{ $name }}">
                                                <i class="fas fa-plus"></i>
                                            </span>
                                        </h3>
                                        <div class="product__sidebar__values" id="values-{{ $name }}"
                                            style="display: none;">
                                            @foreach ($values as $attributeValue)
                                                <div class="product__sidebar__value">
                                                    <input type="checkbox" id="attribute_value-{{ $attributeValue->id }}"
                                                        name="attribute[{{ $name }}][]"
                                                        value="{{ $attributeValue->value }}"
                                                        class="product__sidebar__checkbox">
                                                    <label for="attribute_value-{{ $attributeValue->id }}"
                                                        class="product__sidebar__label">
                                                        {{ $attributeValue->value }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </aside>
                    </div>
                </div>
                <div class="col-xl-9 col-lg-8">
                    <div id="loader" class="loader" style="display: none;">
                        <div class="spinner"></div>
                        <p>Loading...</p>
                    </div>
                    <div class="product-wrapper" style="padding-top: 25px;">
                        <div class="product__info-top">
                            <div class="d-xl-none mb-3">
                                <button class="custom-button p-1" style="padding: 6px !important; width: 113px;"
                                    type="button" data-bs-toggle="offcanvas" data-bs-target="#filterOffcanvas">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                            </div>
                            <div class="product__showing-text-box">

                            </div>
                            <div class="product__showing-sort">
                                <select name="sort" id="sort" class="form-select">
                                    <option value="">
                                        Default Sorting</option>
                                    <option value="low-to-high" {{ request('sort') == 'low-to-high' ? 'selected' : '' }}>
                                        Low to High</option>
                                    <option value="high-to-low" {{ request('sort') == 'high-to-low' ? 'selected' : '' }}>
                                        High to Low</option>
                                </select>
                            </div>
                        </div>
                        <div id="products">
                            <div class="row gutter-y-30">
                                @forelse ($products as $product)
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-6 product_item">
                                        <div class="product__item wow fadeInUp" data-wow-duration='1500ms'
                                            data-wow-delay='000ms'>
                                            @php
                                                $productImages = $product->images;
                                                $variantImages = $product->variations->flatMap(function ($variation) {
                                                    return $variation->images;
                                                });

                                                $images = $productImages->merge($variantImages);
                                            @endphp
                                            @if ($product->sale_price && $product->regular_price > 0)
                                                @php
                                                    $saving =
                                                        (($product->regular_price - $product->sale_price) /
                                                            $product->regular_price) *
                                                        100;
                                                @endphp
                                                <span class="discount" style="margin-left: 10px; font-size: 10px;">
                                                    Saving {{ number_format($saving, 0) }}%
                                                </span>
                                            @else
                                                <span class="discount" style="margin-left: 10px; font-size: 10px;">Saving
                                                    0%</span>
                                            @endif
                                            <div class="product_item_image product-carousel owl-carousel">
                                                @foreach ($images as $image)
                                                    <img class="item product-image" src="{{ asset($image->path) }}"
                                                        alt="{{ $product->name }}">
                                                @endforeach
                                            </div>

                                            <div class="product_item_content mt-3">
                                                <h6 class="product_item_title">
                                                    <a
                                                        href="{{ route('product.details', $product->slug) }}">{{ Str::limit($product->name, 15) }}</a>
                                                </h6>
                                                <div class="product_item_price">
                                                    @if ($product->sale_price && $product->regular_price > 0)
                                                        <span
                                                            style="text-decoration: line-through; color: red; font-size: 12px; margin-right: 10px;">
                                                            {{ env('CURRENCY_SYMBOL') }}{{ number_format($product->regular_price, 2) }}
                                                        </span>
                                                        <span style="color: #888; font-size: 12px;">
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
                                                        class="p-3 floens-btn product__item__link me-2 custom-button mobile-btn enquireBtn"
                                                        data-id="{{ $product->id }}"
                                                        data-url="{{ route('enquireForm', $product->id) }}">Enquire</a>

                                                    <a href="javascript:void(0);"
                                                        class="p-4 floens-btn product_item_link me-2 custom-button addCartItemBtn addToCartBtn"
                                                        data-product-id="{{ $product->id }}"
                                                        data-url="{{ route('add.to.cart.form', $product->id) }}">
                                                        <i style='font-size:17px; right: 15px'
                                                            class='fas'>&#xf217;</i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="no-products-message">
                                        <h2 class="my-auto text-center text-danger">No products found</h2>
                                    </div>
                                @endforelse
                            </div><!-- /.row -->
                            <div class="mt-5">
                                <div class="mt-4 d-flex justify-content-center">
                                    {{ $products->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 🔥 Offcanvas HTML (Place near top of layout) -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="filterOffcanvas" aria-labelledby="filterOffcanvasLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="filterOffcanvasLabel">Filters</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div id="mobile-filter-content"></div>
        </div>
    </div>
@endsection

@section('page-script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="{{ asset('frontend/assets/vendors/owl-carousel/js/owl.carousel.min.js') }}"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const urlParams = new URLSearchParams(window.location.search);

            urlParams.forEach((valueString, attributeName) => {
                const values = valueString.split(',');
                values.forEach(val => {
                    $(`.product__sidebar__checkbox[name="attribute[${attributeName}][]"][value="${val}"]`)
                        .prop('checked', true);
                    const valuesSection = $(`#values-${attributeName}`);
                    const icon = $(`#expand-icon-${attributeName} i`);
                    if (valuesSection.length) {
                        valuesSection.show();
                        icon.removeClass('fa-plus').addClass('fa-minus');
                    }
                });
            });

            if (urlParams.has('max_price')) {
                $('#price-range').val(urlParams.get('max_price'));
                $('#max-price').text(urlParams.get('max_price'));
            }
            if (urlParams.has('search')) $('#searchQuery').val(urlParams.get('search'));
            if (urlParams.has('sort_by')) $('#sort').val(urlParams.get('sort_by'));
        });

        $(document).ready(function() {
            $('.product-carousel').each(function() {
                const $carousel = $(this);
                const images = $carousel.find('img');
                let imagesLoaded = 0;

                images.each(function() {
                    if (this.complete) {
                        imagesLoaded++;
                        if (imagesLoaded === images.length) {
                            $carousel.owlCarousel({
                                items: 1,
                                loop: true,
                                margin: 10,
                                nav: true
                            });
                        }
                    } else {
                        $(this).on('load', function() {
                            imagesLoaded++;
                            if (imagesLoaded === images.length) {
                                $carousel.owlCarousel({
                                    items: 1,
                                    loop: true,
                                    margin: 10,
                                    nav: true
                                });
                            }
                        });
                    }
                });
            });

            $('.product__sidebar__title').on('click', function() {
                let attributeId = $(this).data('attribute-id');
                $('#values-' + attributeId).toggle();
                $('#expand-icon-' + attributeId).find('i').toggleClass('fa-plus fa-minus');
            });

            function updateUrl() {
                let url = new URL(window.location.href);
                let searchParams = new URLSearchParams();

                $('.product__sidebar__checkbox:checked').each(function() {
                    const name = $(this).attr('name');
                    const value = $(this).val();
                    const match = name.match(/attribute\[(.+?)\]/);
                    if (match) {
                        const key = match[1];
                        let existing = searchParams.get(key);
                        if (existing) {
                            searchParams.set(key, existing + ',' + value);
                        } else {
                            searchParams.set(key, value);
                        }
                    }
                });

                const maxPrice = $('#price-range').val();
                if (maxPrice) {
                    searchParams.set('min_price', 0);
                    searchParams.set('max_price', maxPrice);
                }

                const query = $('#searchQuery').val().trim();
                if (query !== '') {
                    searchParams.set('search', query);
                }

                const sort = $('#sort').val();
                if (sort !== '') {
                    searchParams.set('sort_by', sort);
                }

                window.location.href = url.pathname + '?' + searchParams.toString();
            }

            $('.product__sidebar__checkbox').on('change', updateUrl);
            $('#price-range').on('change', updateUrl);
            $('#sort').on('change', updateUrl);

            $('#product__search').on('submit', function(e) {
                e.preventDefault();
                updateUrl();
            });

            $('#price-range').on('input', function() {
                $('#max-price').text($(this).val());
            });

            $('.play').on('click', function() {
                owl.trigger('play.owl.autoplay', [1000]);
            });

            $('.stop').on('click', function() {
                owl.trigger('stop.owl.autoplay');
            });

            displayCartItems();

            $('.enquireBtn').click(function() {
                var url = $(this).data('url');
                $.ajax({
                    url: url,
                    method: 'GET',
                    beforeSend: function() {
                        $('#loader').show();
                    },
                    success: function(response) {
                        $('.enquireSubmitBtn').prop('disabled', false).html('Submit');
                        $('#enquireFormResponse').html(response.html);
                        $('#myModal').modal('show');
                    },
                    complete: function() {
                        $('#loader').hide();
                    }
                });
            });

            $('.addToCartBtn').click(function() {
                var url = $(this).data('url');
                $.ajax({
                    url: url,
                    method: 'GET',
                    beforeSend: function() {
                        $('#loader').show();
                    },
                    success: function(response) {
                        $('.enquireSubmitBtn').prop('disabled', false).html('Add To Cart');
                        $('#addToCartResponse').html(response.html);
                        $('#addToCartModal').modal('show');
                    },
                    complete: function() {
                        $('#loader').hide();
                    }
                });
            });

            $('#enquireForm').submit(function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: "{{ route('enquire') }}",
                    method: 'POST',
                    data: formData,
                    beforeSend: function() {
                        $('.enquireSubmitBtn').prop('disabled', true).html(
                            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending...'
                        );
                    },
                    success: function(response) {
                        $('.enquireSubmitBtn').prop('disabled', false).html('Submit');
                        if (response.status == 'success') {
                            notify(response.status, response.message);
                            $('#enquireForm')[0].reset();
                            $('#myModal').modal('hide');
                        }
                    },
                    error: function(xhr) {
                        $('.enquireSubmitBtn').prop('disabled', false).html('Submit');
                        let errors = xhr.responseJSON.errors;
                        if (errors) {
                            $.each(errors, function(key, value) {
                                $('[name="' + key + '"]').addClass('is-invalid');
                                notify('error', value[0]);
                            });
                        }
                    }
                });
            });

            const $sidebar = $('#original-filter-sidebar');
            const $desktopContainer = $('#sidebar-column');
            const $mobileContainer = $('#mobile-filter-content');

            function moveSidebar() {
                const isMobile = $(window).width() < 1199;
                if (isMobile) {
                    if (!$.contains($mobileContainer[0], $sidebar[0])) {
                        $sidebar.detach().appendTo($mobileContainer);
                    }
                } else {
                    if (!$.contains($desktopContainer[0], $sidebar[0])) {
                        $sidebar.detach().appendTo($desktopContainer);
                    }
                }
            }

            moveSidebar();
            let resizeTimeout;
            $(window).on('resize', function() {
                clearTimeout(resizeTimeout);
                resizeTimeout = setTimeout(moveSidebar, 150);
            });
        });
    </script>
@endsection
