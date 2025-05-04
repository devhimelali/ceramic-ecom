@extends('frontend.layouts.app')
@section('title', 'Home')

@section('content')
    <!-- shop start -->
    <section class="product-home-top-selling">
        <!-- /.product-home__bg -->
        <div class="container products">
            <div class="sec-title sec-title--center">

                <h6 class="sec-title__tagline">our shop</h6><!-- /.sec-title__tagline -->

                <h3 class="sec-title__title">Top Selling Products in Shop</h3>
                <!-- /.sec-title__title -->
            </div><!-- /.sec-title -->
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    @forelse ($topSellingProducts as $product)
                        <div class="col-xl-3 col-lg-4 col-md-6 col-6 product_item swiper-slide">
                            <div class="product__item wow fadeInUp" data-wow-duration='1500ms' data-wow-delay='000ms'>
                                @php
                                    $productImages = $product->images; // This is already a Collection
                                    $variantImages = $product->variations->flatMap(function ($variation) {
                                        return $variation->images;
                                    });

                                    $images = $productImages->merge($variantImages);
                                    $label = $product->label->value;
                                    $labelClass =
                                        $label == 'new arrival'
                                            ? 'new-arrival'
                                            : ($label == 'featured'
                                                ? 'featured'
                                                : 'top_selling');
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
                                @endif
                                <span class="label {{ $labelClass }}">
                                    {{ $product->label->value }}
                                </span>
                                <div class="product_item_image product-carousel owl-carousel">
                                    @foreach ($images as $image)
                                        <img class="item product-image" src="{{ asset($image->path) }}" loading="lazy"
                                            alt="{{ $product->name }}">
                                    @endforeach
                                </div>
                                <div class="product_item_content">
                                    <h6 class="product_item_title">
                                        <a
                                            href="{{ route('product.details', $product->slug) }}">{{ Str::limit($product->name, 30) }}</a>
                                    </h6>
                                    <div class="product_item_price">
                                        @if ($product->sale_price && $product->regular_price > 0)
                                            <span
                                                style="text-decoration: line-through; color: red; font-size: 16px; margin-right: 10px;">
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
                                            class="p-3 floens-btn product__item__link me-2 mobile-btn custom-button mobile-btn enquireBtn"
                                            data-id="{{ $product->id }}"
                                            data-url="{{ route('enquireForm', $product->id) }}">Enquire</a>

                                        <a href="javascript:void(0);"
                                            class="p-4 floens-btn product__item__link me-2 custom-button addCartItemBtn addToCartBtn"
                                            data-product-id="{{ $product->id }}"
                                            data-url="{{ route('add.to.cart.form', $product->id) }}">
                                            <!--<i style='font-size:17px; right: 15px' class='fas'>&#xf217;</i>-->
                                            <i style='font-size:17px; right: 15px' class='fas'>&#xf217;</i></a>
                                        </a>
                                    </div>
                                </div><!-- /.product-content -->
                            </div><!-- /.product-item -->
                        </div><!-- /.col-md-6 col-lg-4 -->
                    @empty
                        <h5 class="text-center">No products found.</h5>
                    @endforelse
                </div><!-- /.row -->
            </div>
        </div><!-- /.container -->
    </section>
    <!-- shop end -->
    <!-- main slider start -->
    @include('admin.page-settings.home.partials.slider')
    <!-- main slider end -->

    <!-- about Start -->
    <section class="about-one section-space" id="about">
        <div class="container">
            <div class="row gutter-y-60">
                <div class="col-lg-6 wow fadeInLeft" data-wow-duration="1500ms" data-wow-delay="00ms">
                    <div class="about-one__image-grid">
                        <div class="about-one__image">
                            @php
                                $home_one__image__one = $settings->where('key', 'home_one__image__one')->first();
                            @endphp
                            <img src="{{ $home_one__image__one ? asset($home_one__image__one->value) : asset('frontend/assets/images/about/about-1-3.png') }}"
                                alt="about" class="about-one__image__one sec_1_prev_1" loading="lazy">
                            @php
                                $home_one__image__two = $settings->where('key', 'home_one__image__two')->first();
                            @endphp
                            <img src="{{ $home_one__image__two ? asset($home_one__image__two->value) : asset('frontend/assets/images/about/about-1-2.jpg') }}"
                                alt="about" class="about-one__image__two sec_1_prev_2" loading="lazy">
                        </div><!-- /.about-one__image -->
                        <div class="about-one__image">
                            @php
                                $home_one__image__three = $settings->where('key', 'home_one__image__three')->first();
                            @endphp

                            <img src="{{ $home_one__image__three ? asset($home_one__image__three->value) : asset('frontend/assets/images/about/about-1-1.jpg') }}"
                                alt="about" class="about-one__image__three sec_1_prev_3" loading="lazy">
                        </div><!-- /.about-one__image -->
                        <div class="about-one__circle-text">
                            <div class="about-one__circle-text__bg"
                                style="background-image: url('{{ asset('frontend') }}/assets/images/resources/about-award-bg.jpg');">
                            </div>
                            <img src="{{ asset('frontend') }}/assets/images/resources/about-award-symbol.png"
                                alt="award-symbole" class="about-one__circle-text__image" loading="lazy">
                            <div class="about-one__curved-circle curved-circle">
                                <!-- curved-circle start-->
                                <div class="about-one__curved-circle__item curved-circle__item"
                                    data-circle-text-options='{
                     "radius": 84,
                     "forceWidth": true,
                     "forceHeight": true}'>
                                    award winning flooring company
                                </div>
                            </div><!-- curved-circle end-->
                        </div><!-- /.about-one__circle-text -->
                    </div><!-- /.about-one__image-grid -->
                </div><!-- /.col-lg-6 -->
                <div class="col-lg-6">
                    <div class="about-one__content">
                        @if (app_setting('home_about_sec_1'))
                            {!! app_setting('home_about_sec_1') !!}
                        @else
                            <div class="sec-title sec-title--border">

                                <h6 class="sec-title__tagline">about us</h6><!-- /.sec-title__tagline -->

                                <h3 class="sec-title__title">Explore Modern Tiles Stone & Agency</h3>
                                <!-- /.sec-title__title -->
                            </div><!-- /.sec-title -->
                            <div class="about-one__content__text wow fadeInUp" data-wow-duration="1500ms"
                                data-wow-delay="00ms">
                                <h5 class="about-one__text-title">Welcome to Melbourne Building Products, your one-stop
                                    destination
                                    for high-quality building and renovation supplies in Melton, Victoria.</h5>
                                <!-- /.about-one__text-title -->
                                <p class="about-one__text">We’re providing the best quality tiles in town.
                                    At Melbourne Building Products, we’re dedicated to helping you transform your home or
                                    project into a masterpiece. Whether you’re updating a single room, renovating your
                                    entire
                                    house, or working on a large-scale construction project. Tiles company, also known as a
                                    tile
                                    manufacturer or
                                    distributor,
                                    specializes in the production and distribution of various types of tiles used for a
                                    wide
                                    range of applications. These companies play a crucial role in the construn and
                                    interior
                                    design industries by providing tiles for residential.</p><!-- /.about-one__text -->
                            </div><!-- /.about-one__content__text -->
                            <div class="about-one__button wow fadeInUp" data-wow-duration="1500ms" data-wow-delay="00ms">
                                <a href="{{ route('frontend.contact') }}" class="floens-btn">
                                    <span>get in touch</span>
                                    <i class="icon-right-arrow"></i>
                                </a><!-- /.floens-btn -->
                            </div><!-- /.about-one__button -->
                        @endif

                    </div><!-- /.about-one__content -->
                </div><!-- /.col-lg-6 -->
            </div><!-- /.row -->
        </div><!-- /.container -->
        <div class="about-one__shapes">
            <img src="{{ asset('frontend') }}/assets/images/shapes/about-shape-1-1.jpg" alt="about-shape"
                class="about-one__shape about-one__shape--one" loading="lazy">
            <img src="{{ asset('frontend') }}/assets/images/shapes/about-shape-1-1.jpg" alt="about-shape"
                class="about-one__shape about-one__shape--two" loading="lazy">
        </div><!-- /.about-one__shapes -->
    </section><!-- /.about-one section-space -->
    <!-- about End -->



    <!-- services info start -->
    <section class="mt-3 services-one__info">
        <div class="container">
            <div class="services-one__info__inner">
                <div class="services-one__info__bg"
                    style="background-image: url({{ asset('frontend') }}/assets/images/backgrounds/services-info-bg-1.png);">
                </div>
                <!-- /.services-one__info__bg -->
                <div class="row gutter-y-40 align-items-center">
                    <div class="col-lg-6">
                        <div class="services-one__info__left">
                            <h3 class="services-one__info__title">Get a Professional Services</h3>
                            <!-- /.services-one__info__title -->
                            <p class="services-one__info__text">Laminate flooring is a type of synthetic flooring
                                that
                                designed like hardwood, tile, or other natural materials</p>
                            <!-- /.services-one__info__text -->
                        </div><!-- /.services-one__info__left -->
                    </div><!-- /.col-lg-6 -->
                    <div class="col-lg-6">
                        <div class="services-one__info__right">
                            <div class="services-one__info__right__inner">
                                <div class="services-one__info__icon">
                                    <span class="icon-telephone"></span>
                                </div><!-- /.services-one__info__icon -->
                                <a href="tel:{{ $settings->where('key', 'contact_phone')->first()->value ?? '#' }}"
                                    class="services-one__info__number">{{ $settings->where('key', 'contact_phone')->first()->value ?? 'N/A' }}</a>
                                <!-- /.services-one__info__number -->
                            </div><!-- /.services-one__info__right__inner -->
                        </div><!-- /.services-one__info__right -->
                    </div><!-- /.col-lg-6 -->
                </div><!-- /.row -->
                <div class="services-one__info__shape-one"></div><!-- /.services-one__info__shape-one -->
                <div class="services-one__info__shape-two"></div><!-- /.services-one__info__shape-two -->
            </div><!-- /.services-one__info__inner -->
        </div><!-- /.container -->
    </section><!-- /.services-one__info -->
    <!-- services info end -->

    <!-- reliable start -->
    <section class="reliable-one reliable-one--home section-space-bottom">
        <div class="container">
            <div class="row gutter-y-60">
                <div class="col-lg-6">
                    <div class="reliable-one__content">
                        @if (app_setting('home_reliable_one_content'))
                            {!! app_setting('home_reliable_one_content') !!}
                        @else
                            <div class="sec-title sec-title--border">

                                <h6 class="sec-title__tagline">reliable</h6><!-- /.sec-title__tagline -->

                                <h3 class="sec-title__title">We Provide Reliable Flooring Services</h3>
                                <!-- /.sec-title__title -->
                            </div><!-- /.sec-title -->


                            <p class="reliable-one__text">Our vision is to provide innovative, independent flooring
                                solutions
                                that problems for homes, industries, and workspaces, as well as flooring we would like
                                in
                                our own residences, work spaces,</p><!-- /.reliable-one__text -->
                            <div class="row align-items-center gutter-y-30">
                                <div class="col-xl-6 col-lg-12 col-md-5 col-sm-6">
                                    <div class="reliable-one__info reliable-one__info--one">
                                        <div class="reliable-one__info__icon">
                                            <span class="icon-smiley"></span>
                                        </div><!-- /.reliable-one__info__icon -->
                                        <div class="reliable-one__info__text">
                                            <h4 class="reliable-one__info__title">Happy clients</h4>
                                            <!-- /.reliable-one__info__title -->
                                            <h5 class="reliable-one__info__total">2.5M+</h5>
                                            <!-- /.reliable-one__info__total -->
                                        </div><!-- /.reliable-one__info__text -->
                                    </div><!-- /.reliable-one__info -->
                                </div><!-- /.col-xl-6 col-lg-12 col-md-5 col-sm-6 -->
                                <div class="col-xl-6 col-lg-12 col-md-5 col-sm-6">
                                    <div class="reliable-one__info reliable-one__info--two">
                                        <div class="reliable-one__info__icon">
                                            <span class="icon-cooperation"></span>
                                        </div><!-- /.reliable-one__info__icon -->
                                        <div class="reliable-one__info__text">
                                            <h4 class="reliable-one__info__title">Trusted partners</h4>
                                            <!-- /.reliable-one__info__title -->
                                            <h5 class="reliable-one__info__total">420+</h5>
                                            <!-- /.reliable-one__info__total -->
                                        </div><!-- /.reliable-one__info__text -->
                                    </div><!-- /.reliable-one__info -->
                                </div><!-- /.col-xl-6 col-lg-12 col-md-5 col-sm-6 -->
                            </div><!-- /.row -->
                            <a href="{{ route('frontend.contact') }}" class="floens-btn reliable-one__btn">
                                <span>get in touch</span>
                                <i class="icon-right-arrow"></i>
                            </a><!-- /.floens-btn reliable-one__btn -->
                        @endif

                    </div><!-- /.reliable-one__content -->
                </div><!-- /.col-lg-6 -->
                <div class="col-lg-6 wow fadeInRight" data-wow-duration="1500ms">
                    <div class="reliable-one__images">
                        <div class="reliable-one__image">
                            @php
                                $home_two__image__one = $settings->where('key', 'home_two__image__one')->first();
                            @endphp
                            <img src="{{ $home_two__image__one ? asset($home_two__image__one->value) : asset('frontend/assets/images/reliable/reliable-1-1.jpg') }}"
                                loading="lazy" alt="reliable" class="reliable-one__image__one sec_2_prev_1">
                            <div class="reliable-one__image__inner">
                                @php
                                    $images = $settings->where('key', 'home_two__image__two')->first();
                                @endphp
                                <img src="{{ $images ? asset($images->value) : asset('frontend/assets/images/reliable/reliable-1-2.jpg') }}"
                                    alt="reliable" class="reliable-one__image__two sec_2_prev_2" loading="lazy">
                            </div>
                            <div class="experience reliable-one__experience">
                                <div class="experience__inner">
                                    <h3 class="experience__year"
                                        style="background-image: url('{{ asset('frontend') }}/assets/images/shapes/reliable-shape-1-1.png');">
                                        25
                                    </h3>
                                    <p class="experience__text">years of <br> experience</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <style>
        .product-home-top-selling {
            padding-top: 30px;
            padding-bottom: 60px;
            position: relative;
        }

        .product-home-top-selling .sec-title {
            margin-bottom: 60px;
        }

        .product-home {
            padding-top: 60px !important;
            padding-bottom: 20px !important;
        }
    </style>

    <!-- shop start -->
    <section class="product-home">
        <div class="product-home__bg"
            style="background-image: url({{ asset('frontend') }}/assets/images/backgrounds/shop-bg-1.png);">
        </div>
        <!-- /.product-home__bg -->
        <div class="container products">
            <div class="sec-title sec-title--center">

                <h6 class="sec-title__tagline">our shop</h6><!-- /.sec-title__tagline -->

                <h3 class="sec-title__title">Latest Products in Shop</h3>
                <!-- /.sec-title__title -->
            </div><!-- /.sec-title -->

            <div class="swiper mySwiper">
                <div class=" swiper-wrapper">
                    @forelse ($products as $product)
                        <div class="col-xl-3 col-lg-4 col-md-6 col-6 product_item swiper-slide">
                            <div class="product__item wow fadeInUp item" data-wow-duration='1500ms'
                                data-wow-delay='000ms'>
                                @php
                                    $productImages = $product->images; // This is already a Collection
                                    $variantImages = $product->variations->flatMap(function ($variation) {
                                        return $variation->images;
                                    });

                                    $images = $productImages->merge($variantImages);
                                    $label = $product->label->value;
                                    $labelClass =
                                        $label == 'new arrival'
                                            ? 'new-arrival'
                                            : ($label == 'featured'
                                                ? 'featured'
                                                : 'top_selling');
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
                                @endif
                                <span class="label {{ $labelClass }}">
                                    {{ $product->label->value }}
                                </span>
                                <div class="product_item_image product-carousel owl-carousel">
                                    @foreach ($images as $image)
                                        <img class="item product-image" src="{{ asset($image->path) }}" loading="lazy"
                                            alt="{{ $product->name }}">
                                    @endforeach
                                </div>
                                <div class="product_item_content">
                                    <h6 class="product_item_title">
                                        <a
                                            href="{{ route('product.details', $product->slug) }}">{{ Str::limit($product->name, 30) }}</a>
                                    </h6>
                                    <div class="product_item_price">
                                        @if ($product->sale_price && $product->regular_price > 0)
                                            <span
                                                style="text-decoration: line-through; color: red; font-size: 16px; margin-right: 10px;">
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
                                            class="p-3 floens-btn product__item__link me-2 custom-button mobile-btn enquireBtn"
                                            data-id="{{ $product->id }}"
                                            data-url="{{ route('enquireForm', $product->id) }}">Enquire</a>

                                        <a href="javascript:void(0);"
                                            class="p-4 floens-btn product__item__link me-2 custom-button addCartItemBtn addToCartBtn"
                                            data-product-id="{{ $product->id }}"
                                            data-url="{{ route('add.to.cart.form', $product->id) }}">
                                            <i style='font-size:17px; right: 15px' class='fas'>&#xf217;</i></a>
                                        </a>
                                    </div>
                                </div><!-- /.product-content -->
                            </div><!-- /.product-item -->
                        </div><!-- /.col-md-6 col-lg-4 -->
                    @empty
                        <h5 class="text-center">No products found.</h5>
                    @endforelse
                </div><!-- /.row -->
                <div class="swiper-pagination"></div>
            </div>
        </div><!-- /.container -->
    </section><!-- /.product-home -->
    <!-- shop end -->



    @if ($featuredProducts->count() > 0)
        <section class="product-home-top-selling">
            <!-- /.product-home__bg -->
            <div class="container products">
                <div class="sec-title sec-title--center">

                    <h6 class="sec-title__tagline">our shop</h6>

                    <h3 class="sec-title__title">Featured Products Products in Shop</h3>
                </div>
                <div class="swiper mySwiper">
                    <div class="swiper-wrapper">
                        @forelse ($featuredProducts as $product)
                            <div class="col-xl-3 col-lg-4 col-md-6 col-6 product_item swiper-slide">
                                <div class="product__item wow fadeInUp" data-wow-duration='1500ms'
                                    data-wow-delay='000ms'>
                                    @php
                                        $productImages = $product->images; // This is already a Collection
                                        $variantImages = $product->variations->flatMap(function ($variation) {
                                            return $variation->images;
                                        });

                                        $images = $productImages->merge($variantImages);
                                        $label = $product->label->value;
                                        $labelClass =
                                            $label == 'new arrival'
                                                ? 'new-arrival'
                                                : ($label == 'featured'
                                                    ? 'featured'
                                                    : 'top_selling');
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
                                    @endif
                                    <span class="label {{ $labelClass }}">
                                        {{ $product->label->value }}
                                    </span>
                                    <div class="product_item_image product-carousel owl-carousel">
                                        @foreach ($images as $image)
                                            <img class="item product-image" src="{{ asset($image->path) }}"
                                                loading="lazy" alt="{{ $product->name }}">
                                        @endforeach
                                    </div>
                                    <div class="product_item_content">
                                        <h6 class="product_item_title">
                                            <a
                                                href="{{ route('product.details', $product->slug) }}">{{ Str::limit($product->name, 30) }}</a>
                                        </h6>
                                        <div class="product_item_price">
                                            @if ($product->sale_price && $product->regular_price > 0)
                                                <span
                                                    style="text-decoration: line-through; color: red; font-size: 16px; margin-right: 10px;">
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
                                                class="p-3 floens-btn product__item__link me-2 mobile-btn custom-button mobile-btn enquireBtn"
                                                data-id="{{ $product->id }}"
                                                data-url="{{ route('enquireForm', $product->id) }}">Enquire</a>

                                            <a href="javascript:void(0);"
                                                class="p-4 floens-btn product__item__link me-2 custom-button addCartItemBtn addToCartBtn"
                                                data-product-id="{{ $product->id }}"
                                                data-url="{{ route('add.to.cart.form', $product->id) }}">
                                                <!--<i style='font-size:17px; right: 15px' class='fas'>&#xf217;</i>-->
                                                <i style='font-size:17px; right: 15px' class='fas'>&#xf217;</i></a>
                                            </a>
                                        </div>
                                    </div><!-- /.product-content -->
                                </div><!-- /.product-item -->
                            </div><!-- /.col-md-6 col-lg-4 -->
                        @empty
                            <h5 class="text-center">No products found.</h5>
                        @endforelse
                    </div><!-- /.row -->
                </div>
            </div><!-- /.container -->
        </section>
    @endif

@endsection
@section('page-script')
    {{-- <script src="{{ asset('frontend/assets/vendors/owl-carousel/js/owl.carousel.min.js') }}"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        $(document).ready(function() {


            var swiper = new Swiper(".mySwiper", {
                slidesPerView: 4,
                spaceBetween: 30,
                loop: true,
                autoplay: {
                    delay: 2500,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                    dynamicBullets: true,
                },
                breakpoints: {
                    320: {
                        slidesPerView: 2,
                        spaceBetween: 10,
                    },
                    640: {
                        slidesPerView: 2,
                        spaceBetween: 20,
                    },
                    768: {
                        slidesPerView: 3,
                        spaceBetween: 40,
                    },
                    1024: {
                        slidesPerView: 4,
                        spaceBetween: 50,
                    },
                },
            });

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
    <script>
        $(document).ready(function() {
            $('[contenteditable="true"]').removeAttr('contenteditable');
        });
    </script>
@endsection
@section('page-style')
    <link rel="preload" as="image" href="{{ asset('frontend/assets/images/backgrounds/slider-1-1.webp') }}"
        type="image/webp" fetchpriority="high" />
    {{-- <link rel="stylesheet" href="{{ asset('frontend/assets/vendors/owl-carousel/css/owl.carousel.min.css') }}"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <style>
        :root {
            --swiper-navigation-size: 24px !important;
            --swiper-theme-color: #2a4e72;
            --swiper-pagination-bullet-inactive-color: #fff;
            --swiper-pagination-bullet-inactive-opacity: .8;
        }

        .swiper {
            padding: 0 0 60px 0;
        }

        /* ------------ Product CSS Start --------------- */
        .product__item {
            border: 1px solid #DED8D3;
            border-radius: 4px;
        }

        .product__item:hover {
            border: 1px solid #2a4e72;
        }

        .label {
            position: absolute;
            right: 7px;
            top: 7px;
            z-index: 2;
            background: #D94F4F;
            color: #fff !important;
            padding: 2px 8px;
            border-radius: 18px;
            text-transform: capitalize;
            font-size: 10px;
        }


        span.discount {
            position: absolute;
            right: 7px;
            top: 34px;
            z-index: 2;
            background: #D94F4F;
            color: #fff !important;
            padding: 2px 8px;
            border-radius: 18px;
            text-transform: capitalize;
            font-size: 10px;
        }

        .top_selling {
            background: #2a4e72
        }

        .new-arrival {
            background: #4FC79A
        }

        .featured {
            background: #C7844F
        }

        .product_item_image {
            width: 100%;
            aspect-ratio: 1 / 1;
            overflow: hidden;
            position: relative;
        }

        .product_item_image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .product-image {
            height: 300px;
        }

        .product_item_content {
            border: none;
            padding: 0.24px 17px 20px !important;
        }

        .product_item_price {
            margin-bottom: 12px;
        }

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

        .mobile-btn {
            padding: 11px 0 !important;
        }

        .enquireBtn {
            width: 70%;
        }

        .addToCartBtn {
            padding: 19px 24px !important;
        }

        /* ------------ Product CSS End --------------- */

        /* -------------- Owl Carousel CSS Start ------------ */
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

        .product-carousel .owl-item {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 235px;
            background: #f9f9f9;
        }

        .product-carousel .owl-item img {
            width: auto;
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            display: block;
            margin-top: 0px;
        }

        /* -------------- Owl Carousel CSS End ------------ */
        .swiper-button-next,
        .swiper-button-prev {
            color: #2a4e72 !important;
        }

        ::ng-deep .swiper-button-prev:after,
        ::ng-deep .swiper-button-next:after {
            --swiper-navigation-size: 15px;
        }

        @media (max-width: 991px) {
            .main-slider__item {
                padding: 0 0 150px;
            }
        }

        /* media query */
        @media screen and (max-width: 480px) {
            .sec_1_prev_3 {
                height: 364px !important;
                width: auto !important;
            }

            .sec_1_prev_2 {
                height: 186px;
                width: auto !important;
            }

            .sec_1_prev_1 {
                height: 170px;
                width: auto !important;
            }

            img.reliable-one__image__two.sec_2_prev_2 {
                height: 300px;
                width: auto !important;

            }

            img.reliable-one__image__one.sec_2_prev_1 {
                height: 300px;
                width: auto !important;
            }


            span.label {
                padding: 1px 6px;
                font-size: 8px !important;
            }

            span.discount {
                top: 26px;
                padding: 1px 6px;
                font-size: 8px !important;
            }

            .addToCartBtn {
                padding: 14px 21px !important;
            }

            .addToCartBtn i {
                font-size: 12px !important;
            }

            .product-carousel .owl-item {
                height: 150px;
            }

            .product-carousel .owl-item img {
                margin: 0px;
            }

            .product_item_content {
                margin-top: 0px !important;
            }

            .product_item_content {
                padding: 0.24px 8px 8px !important;
            }

            .owl-carousel .owl-nav button.owl-prev {
                width: 20px;
                height: 20px;
            }

            .owl-carousel .owl-nav button.owl-prev {
                font-size: 14px !important;
            }

            .owl-carousel .owl-nav button.owl-prev,
            .owl-carousel .owl-nav button.owl-prev,
            .owl-carousel button.owl-dot.owl-nav {
                left: 7px;
            }

            .owl-carousel .owl-nav button.owl-next {
                font-size: 13px !important;
            }

            .owl-carousel .owl-nav button.owl-next {
                width: 20px;
                height: 20px;
            }

            .owl-carousel .owl-nav button.owl-next,
            .owl-carousel .owl-nav button.owl-next,
            .owl-carousel button.owl-dot.owl-nav {
                right: 8px;
            }

            .products .row {
                --bs-gutter-x: 10px;
            }
        }
    </style>
@endsection
