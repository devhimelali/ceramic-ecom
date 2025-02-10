@php
    use App\Helpers\ImageUploadHelper;
@endphp
@extends('frontend.layouts.app')
@section('page-style')
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
    </style>
@endsection
@section('content')
    <!-- main slider start -->
    <section class="main-slider hero-slider">
        <div class="main-slider__bg"
            style="background-image: url({{ asset('frontend') }}/assets/images/backgrounds/slider-1-1.jpg);">
        </div>
        <!-- /.main-slider__bg -->
        <div class="hero-slider__social">
            <a href="https://facebook.com/">
                <i class="icon-facebook" aria-hidden="true"></i>
                <span class="sr-only">Facebook</span>
            </a>
            <a href="https://twitter.com/">
                <i class="icon-twitter" aria-hidden="true"></i>
                <span class="sr-only">Twitter</span>
            </a>
            {{-- <a href="https://instagram.com/">
                <i class="icon-instagram" aria-hidden="true"></i>
                <span class="sr-only">Instagram</span>
            </a>
            <a href="https://youtube.com/">
                <i class="icon-youtube" aria-hidden="true"></i>
                <span class="sr-only">Youtube</span>
            </a> --}}
        </div><!-- /.hero-slider__social -->
        <a href="#about" class="main-slider__scroll-btn"><span></span></a><!-- /.main-slider__scroll-btn -->
        <div class="main-slider__carousel floens-slick__carousel--with-counter"
            data-slick-options='{
            "slidesToShow": 1,
            "slidesToScroll": 1,
            "asNavFor": ".main-slider__carousel-thumbs",
            "autoplay": true,
            "fade": true,
            "autoplaySpeed": 4000,
            "speed": 2000,
            "infinite": true,
            "arrows": true,
            "dots": false,
            "prevArrow": "<button class=\"hero-slider__slick-button hero-slider__slick-button--prev\"><i class=\"icon-left-arrow\"></i> Prev</button>",
            "nextArrow": "<button class=\"hero-slider__slick-button hero-slider__slick-button--next\">Next <i class=\"icon-right-arrow\"></i></button>"

        }'>
            <div class="main-slider__item">
                <div class="main-slider__wrapper container-fluid">
                    <div class="main-slider__left">
                        <div class="main-slider__content">
                            <div class="sec-title sec-title--center">

                                <h6 class="sec-title__tagline">Precision Tile & Flooring Solutions</h6>
                                <!-- /.sec-title__tagline -->

                                <h3 class="sec-title__title">Let us Make Your <br> Home Better</h3>
                                <!-- /.sec-title__title -->
                            </div><!-- /.sec-title -->


                            <p class="main-slider__text">Welcome to Melbourne Building Products, your one-stop destination
                                for high-quality building and renovation supplies in Melton, Victoria.
                                At Melbourne Building Products, we’re dedicated to helping you transform your home or
                                project into a masterpiece. Whether you’re updating a single room, renovating your entire
                                house, or working on a large-scale construction project. </p>
                            <!-- /.main-slider__text -->
                            <a href="about.html" class="main-slider__btn floens-btn">
                                <span>discover more</span>
                                <i class="icon-right-arrow"></i>
                            </a><!-- /.main-slider__btn floens-btn -->
                        </div><!-- /.main-slider__content -->
                    </div><!-- /.main-slider__left -->
                    <div class="main-slider__right">
                        <div class="main-slider__image">
                            <div class="main-slider__image__inner">
                                <img src="{{ asset('frontend') }}/assets/images/slider/slider-1-1.jpg" alt="slider"
                                    class="main-slider__image__one">
                            </div><!-- /.main-slider__image__inner -->
                            <img src="{{ asset('frontend') }}/assets/images/shapes/slider-shape-1-1.jpg" alt="slider"
                                class="main-slider__image__two">
                            <a href="https://www.youtube.com/watch?v=h9MbznbxlLc"
                                class="main-slider__video video-button video-button--large  video-popup"
                                style="background-image: url({{ asset('frontend') }}/assets/images/resources/slider-video-bg.png);">
                                <span class="icon-play"></span>
                                <i class="video-button__ripple"></i>
                            </a>
                        </div><!-- /.main-slider__image -->
                    </div><!-- /.main-slider__right -->
                </div><!-- /.main-slider__wrapper .container-fluid -->
            </div><!-- /.main-slider__item -->
            <div class="main-slider__item">
                <div class="main-slider__wrapper container-fluid">
                    <div class="main-slider__left">
                        <div class="main-slider__content">
                            <div class="sec-title sec-title--center">

                                <h6 class="sec-title__tagline">Precision Tile & Flooring Solutions</h6>
                                <!-- /.sec-title__tagline -->

                                <h3 class="sec-title__title">Let us Make Your <br> Home Better</h3>
                                <!-- /.sec-title__title -->
                            </div><!-- /.sec-title -->


                            <p class="main-slider__text">Welcome to Melbourne Building Products, your one-stop destination
                                for high-quality building and renovation supplies in Melton, Victoria.
                                At Melbourne Building Products, we’re dedicated to helping you transform your home or
                                project into a masterpiece. Whether you’re updating a single room, renovating your entire
                                house, or working on a large-scale construction project, </p>
                            <!-- /.main-slider__text -->
                            <a href="about.html" class="main-slider__btn floens-btn">
                                <span>discover more</span>
                                <i class="icon-right-arrow"></i>
                            </a><!-- /.main-slider__btn floens-btn -->
                        </div><!-- /.main-slider__content -->
                    </div><!-- /.main-slider__left -->
                    <div class="main-slider__right">
                        <div class="main-slider__image">
                            <div class="main-slider__image__inner">
                                <img src="{{ asset('frontend') }}/assets/images/slider/slider-1-2.jpg" alt="slider"
                                    class="main-slider__image__one">
                            </div><!-- /.main-slider__image__inner -->
                            <img src="{{ asset('frontend') }}/assets/images/shapes/slider-shape-1-1.jpg" alt="slider"
                                class="main-slider__image__two">
                            <a href="https://www.youtube.com/watch?v=h9MbznbxlLc"
                                class="main-slider__video video-button video-button--large  video-popup"
                                style="background-image: url({{ asset('frontend') }}/assets/images/resources/slider-video-bg.png);">
                                <span class="icon-play"></span>
                                <i class="video-button__ripple"></i>
                            </a>
                        </div><!-- /.main-slider__image -->
                    </div><!-- /.main-slider__right -->
                </div><!-- /.main-slider__wrapper .container-fluid -->
            </div><!-- /.main-slider__item -->
            <div class="main-slider__item">
                <div class="main-slider__wrapper container-fluid">
                    <div class="main-slider__left">
                        <div class="main-slider__content">
                            <div class="sec-title sec-title--center">

                                <h6 class="sec-title__tagline">Precision Tile & Flooring Solutions</h6>
                                <!-- /.sec-title__tagline -->

                                <h3 class="sec-title__title">Let us Make Your <br> Home Better</h3>
                                <!-- /.sec-title__title -->
                            </div><!-- /.sec-title -->


                            <p class="main-slider__text">Welcome to Melbourne Building Products, your one-stop destination
                                for high-quality building and renovation supplies in Melton, Victoria.
                                At Melbourne Building Products, we’re dedicated to helping you transform your home or
                                project into a masterpiece. Whether you’re updating a single room, renovating your entire
                                house, or working on a large-scale construction project, </p>
                            <!-- /.main-slider__text -->
                            <a href="about.html" class="main-slider__btn floens-btn">
                                <span>discover more</span>
                                <i class="icon-right-arrow"></i>
                            </a><!-- /.main-slider__btn floens-btn -->
                        </div><!-- /.main-slider__content -->
                    </div><!-- /.main-slider__left -->
                    <div class="main-slider__right">
                        <div class="main-slider__image">
                            <div class="main-slider__image__inner">
                                <img src="{{ asset('frontend') }}/assets/images/slider/slider-1-3.jpg" alt="slider"
                                    class="main-slider__image__one">
                            </div><!-- /.main-slider__image__inner -->
                            <img src="{{ asset('frontend') }}/assets/images/shapes/slider-shape-1-1.jpg" alt="slider"
                                class="main-slider__image__two">
                            <a href="https://www.youtube.com/watch?v=h9MbznbxlLc"
                                class="main-slider__video video-button video-button--large  video-popup"
                                style="background-image: url({{ asset('frontend') }}/assets/images/resources/slider-video-bg.png);">
                                <span class="icon-play"></span>
                                <i class="video-button__ripple"></i>
                            </a>
                        </div><!-- /.main-slider__image -->
                    </div><!-- /.main-slider__right -->
                </div><!-- /.main-slider__wrapper .container-fluid -->
            </div><!-- /.main-slider__item -->
            <div class="main-slider__item">
                <div class="main-slider__wrapper container-fluid">
                    <div class="main-slider__left">
                        <div class="main-slider__content">
                            <div class="sec-title sec-title--center">

                                <h6 class="sec-title__tagline">Precision Tile & Flooring Solutions</h6>
                                <!-- /.sec-title__tagline -->

                                <h3 class="sec-title__title">Let us Make Your <br> Home Better</h3>
                                <!-- /.sec-title__title -->
                            </div><!-- /.sec-title -->


                            <p class="main-slider__text">Tiles companies typically offer a wide variety of tile
                                styles, shapes, sizes, colors, and finishes. Customers can choose from options such
                                as ceramic tiles porcelain tiles, mosaic tiles, subway tiles, and more.</p>
                            <!-- /.main-slider__text -->
                            <a href="about.html" class="main-slider__btn floens-btn">
                                <span>discover more</span>
                                <i class="icon-right-arrow"></i>
                            </a><!-- /.main-slider__btn floens-btn -->
                        </div><!-- /.main-slider__content -->
                    </div><!-- /.main-slider__left -->
                    <div class="main-slider__right">
                        <div class="main-slider__image">
                            <div class="main-slider__image__inner">
                                <img src="{{ asset('frontend') }}/assets/images/slider/slider-1-4.jpg" alt="slider"
                                    class="main-slider__image__one">
                            </div><!-- /.main-slider__image__inner -->
                            <img src="{{ asset('frontend') }}/assets/images/shapes/slider-shape-1-1.jpg" alt="slider"
                                class="main-slider__image__two">
                            <a href="https://www.youtube.com/watch?v=h9MbznbxlLc"
                                class="main-slider__video video-button video-button--large  video-popup"
                                style="background-image: url({{ asset('frontend') }}/assets/images/resources/slider-video-bg.png);">
                                <span class="icon-play"></span>
                                <i class="video-button__ripple"></i>
                            </a>
                        </div><!-- /.main-slider__image -->
                    </div><!-- /.main-slider__right -->
                </div><!-- /.main-slider__wrapper .container-fluid -->
            </div><!-- /.main-slider__item -->
            <div class="main-slider__item">
                <div class="main-slider__wrapper container-fluid">
                    <div class="main-slider__left">
                        <div class="main-slider__content">
                            <div class="sec-title sec-title--center">

                                <h6 class="sec-title__tagline">Precision Tile & Flooring Solutions</h6>
                                <!-- /.sec-title__tagline -->

                                <h3 class="sec-title__title">Let us Make Your <br> Home Better</h3>
                                <!-- /.sec-title__title -->
                            </div><!-- /.sec-title -->


                            <p class="main-slider__text">Tiles companies typically offer a wide variety of tile
                                styles, shapes, sizes, colors, and finishes. Customers can choose from options such
                                as ceramic tiles porcelain tiles, mosaic tiles, subway tiles, and more.</p>
                            <!-- /.main-slider__text -->
                            <a href="about.html" class="main-slider__btn floens-btn">
                                <span>discover more</span>
                                <i class="icon-right-arrow"></i>
                            </a><!-- /.main-slider__btn floens-btn -->
                        </div><!-- /.main-slider__content -->
                    </div><!-- /.main-slider__left -->
                    <div class="main-slider__right">
                        <div class="main-slider__image">
                            <div class="main-slider__image__inner">
                                <img src="{{ asset('frontend') }}/assets/images/slider/slider-1-5.jpg" alt="slider"
                                    class="main-slider__image__one">
                            </div><!-- /.main-slider__image__inner -->
                            <img src="{{ asset('frontend') }}/assets/images/shapes/slider-shape-1-1.jpg" alt="slider"
                                class="main-slider__image__two">
                            <a href="https://www.youtube.com/watch?v=h9MbznbxlLc"
                                class="main-slider__video video-button video-button--large  video-popup"
                                style="background-image: url({{ asset('frontend') }}/assets/images/resources/slider-video-bg.png);">
                                <span class="icon-play"></span>
                                <i class="video-button__ripple"></i>
                            </a>
                        </div><!-- /.main-slider__image -->
                    </div><!-- /.main-slider__right -->
                </div><!-- /.main-slider__wrapper .container-fluid -->
            </div><!-- /.main-slider__item -->
            <div class="main-slider__item">
                <div class="main-slider__wrapper container-fluid">
                    <div class="main-slider__left">
                        <div class="main-slider__content">
                            <div class="sec-title sec-title--center">

                                <h6 class="sec-title__tagline">Precision Tile & Flooring Solutions</h6>
                                <!-- /.sec-title__tagline -->

                                <h3 class="sec-title__title">Let us Make Your <br> Home Better</h3>
                                <!-- /.sec-title__title -->
                            </div><!-- /.sec-title -->


                            <p class="main-slider__text">Tiles companies typically offer a wide variety of tile
                                styles, shapes, sizes, colors, and finishes. Customers can choose from options such
                                as ceramic tiles porcelain tiles, mosaic tiles, subway tiles, and more.</p>
                            <!-- /.main-slider__text -->
                            <a href="about.html" class="main-slider__btn floens-btn">
                                <span>discover more</span>
                                <i class="icon-right-arrow"></i>
                            </a><!-- /.main-slider__btn floens-btn -->
                        </div><!-- /.main-slider__content -->
                    </div><!-- /.main-slider__left -->
                    <div class="main-slider__right">
                        <div class="main-slider__image">
                            <div class="main-slider__image__inner">
                                <img src="{{ asset('frontend') }}/assets/images/slider/slider-1-2.jpg" alt="slider"
                                    class="main-slider__image__one">
                            </div><!-- /.main-slider__image__inner -->
                            <img src="{{ asset('frontend') }}/assets/images/shapes/slider-shape-1-1.jpg" alt="slider"
                                class="main-slider__image__two">
                            <a href="https://www.youtube.com/watch?v=h9MbznbxlLc"
                                class="main-slider__video video-button video-button--large  video-popup"
                                style="background-image: url({{ asset('frontend') }}/assets/images/resources/slider-video-bg.png);">
                                <span class="icon-play"></span>
                                <i class="video-button__ripple"></i>
                            </a>
                        </div><!-- /.main-slider__image -->
                    </div><!-- /.main-slider__right -->
                </div><!-- /.main-slider__wrapper .container-fluid -->
            </div><!-- /.main-slider__item -->
        </div><!-- /.main-slider__carousel -->
        <ul class="main-slider__carousel-thumbs floens-slick__carousel"
            data-slick-options='{
        "asNavFor": ".main-slider__carousel",
        "slidesToShow": 5,
        "slidesToScroll": 1,
        "autoplay": true,
        "autoplaySpeed": 3000,
        "infinite": true,
        "vertical": true,
        "focusOnSelect": true,
        "dots": false,
        "arrows": false
        }'>
            <li>
                <img src="{{ asset('frontend') }}/assets/images/slider/slider-thumbs-1-1.jpg" alt="slider-thumbs">
            </li>
            <li>
                <img src="{{ asset('frontend') }}/assets/images/slider/slider-thumbs-1-2.jpg" alt="slider-thumbs">
            </li>
            <li>
                <img src="{{ asset('frontend') }}/assets/images/slider/slider-thumbs-1-3.jpg" alt="slider-thumbs">
            </li>
            <li>
                <img src="{{ asset('frontend') }}/assets/images/slider/slider-thumbs-1-4.jpg" alt="slider-thumbs">
            </li>
            <li>
                <img src="{{ asset('frontend') }}/assets/images/slider/slider-thumbs-1-5.jpg" alt="slider-thumbs">
            </li>
            <li>
                <img src="{{ asset('frontend') }}/assets/images/slider/slider-thumbs-1-6.jpg" alt="slider-thumbs">
            </li>
        </ul><!--/.main-slider__carousel-thumbs -->
    </section><!-- /.main-slider -->
    <!-- main slider end -->

    <!-- about Start -->
    <section class="about-one section-space" id="about">
        <div class="container">
            <div class="row gutter-y-60">
                <div class="col-lg-6 wow fadeInLeft" data-wow-duration="1500ms" data-wow-delay="00ms">
                    <div class="about-one__image-grid">
                        <div class="about-one__image">
                            <img src="{{ asset('frontend') }}/assets/images/about/about-1-3.png" alt="about"
                                class="about-one__image__one">
                            <img src="{{ asset('frontend') }}/assets/images/about/about-1-2.jpg" alt="about"
                                class="about-one__image__two">
                        </div><!-- /.about-one__image -->
                        <div class="about-one__image">
                            <img src="{{ asset('frontend') }}/assets/images/about/about-1-1.jpg" alt="about"
                                class="about-one__image__three">
                        </div><!-- /.about-one__image -->
                        <div class="about-one__circle-text">
                            <div class="about-one__circle-text__bg"
                                style="background-image: url('{{ asset('frontend') }}/assets/images/resources/about-award-bg.jpg');">
                            </div>
                            <img src="{{ asset('frontend') }}/assets/images/resources/about-award-symbol.png"
                                alt="award-symbole" class="about-one__circle-text__image">
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
                                project into a masterpiece. Whether you’re updating a single room, renovating your entire
                                house, or working on a large-scale construction project. Tiles company, also known as a tile
                                manufacturer or
                                distributor,
                                specializes in the production and distribution of various types of tiles used for a
                                wide
                                range of applications. These companies play a crucial role in the construn and
                                interior
                                design industries by providing tiles for residential.</p><!-- /.about-one__text -->
                        </div><!-- /.about-one__content__text -->
                        <div class="row about-one__inner-row gutter-y-40">
                            <div class="col-xl-6 wow fadeInUp" data-wow-duration="1500ms" data-wow-delay="00ms">
                                <div class="about-one__service about-one__service--one">
                                    <div class="about-one__service__icon">
                                        <span class="icon-toilet"></span>
                                    </div><!-- /.about-one__service__icon -->
                                    <div class="about-one__service__content">
                                        <h4 class="about-one__service__title">Tiles & Toilet</h4>
                                        <!-- /.about-one__service__title -->
                                        <p class="about-one__service__text">Tiles company, also known as a tile</p>
                                        <!-- /.about-one__service__text -->
                                    </div><!-- /.about-one__service__content -->
                                </div><!-- /.about-one__service -->
                            </div><!-- /.col-xl-6 -->
                            <div class="col-xl-6 wow fadeInUp" data-wow-duration="1500ms" data-wow-delay="200ms">
                                <div class="about-one__service about-one__service--two">
                                    <div class="about-one__service__icon">
                                        <span class="icon-kitchen"></span>
                                    </div><!-- /.about-one__service__icon -->
                                    <div class="about-one__service__content">
                                        <h4 class="about-one__service__title">design Kitchen in 3D</h4>
                                        <!-- /.about-one__service__title -->
                                        <p class="about-one__service__text">Tiles company, also known as a tile</p>
                                        <!-- /.about-one__service__text -->
                                    </div><!-- /.about-one__service__content -->
                                </div><!-- /.about-one__service -->
                            </div><!-- /.col-xl-6 -->
                        </div><!-- /.row -->
                        <div class="about-one__button wow fadeInUp" data-wow-duration="1500ms" data-wow-delay="00ms">
                            <a href="contact.html" class="floens-btn">
                                <span>get in touch</span>
                                <i class="icon-right-arrow"></i>
                            </a><!-- /.floens-btn -->
                        </div><!-- /.about-one__button -->
                    </div><!-- /.about-one__content -->
                </div><!-- /.col-lg-6 -->
            </div><!-- /.row -->
        </div><!-- /.container -->
        <div class="about-one__shapes">
            <img src="{{ asset('frontend') }}/assets/images/shapes/about-shape-1-1.jpg" alt="about-shape"
                class="about-one__shape about-one__shape--one">
            <img src="{{ asset('frontend') }}/assets/images/shapes/about-shape-1-1.jpg" alt="about-shape"
                class="about-one__shape about-one__shape--two">
        </div><!-- /.about-one__shapes -->
    </section><!-- /.about-one section-space -->
    <!-- about End -->



    <!-- services info start -->
    <section class="services-one__info mt-3">
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
                                <a href="tel:{{ app_setting('contact_phone') }}"
                                    class="services-one__info__number">{{ app_setting('contact_phone') }}</a>
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

    {{-- <!-- offer start -->
    <section class="offer-one section-space-two" id="offer">
        <div class="container">
            <div class="offer-one__top">
                <div class="row gutter-y-40 align-items-center">
                    <div class="col-lg-8">
                        <div class="sec-title @@extraClassName">

                            <h6 class="sec-title__tagline">we offer</h6><!-- /.sec-title__tagline -->

                            <h3 class="sec-title__title">Discover our Best Offer to Made Your Home</h3>
                            <!-- /.sec-title__title -->
                        </div><!-- /.sec-title -->


                    </div><!-- /.col-lg-8 -->
                    <div class="col-lg-4">
                        <div class="offer-one__top__text">
                            <p class="offer-one__text">Tiles company, also known as a tile manufacturer or
                                distributor,
                                specializes in the production and distribution of various</p>
                            <!-- /.offer-one__text -->
                        </div><!-- /.offer-one__top__text -->
                    </div><!-- /.col-lg-4 -->
                </div><!-- /.row -->
            </div><!-- /.offer-one__top -->

            <div class="offer-one__main-tab-box tabs-box">
                <div class="offer-one__main-tab-box__bg"
                    style="background-image: url({{ asset('frontend') }}/assets/images/backgrounds/offer-bg-1.jpg);">
                </div>
                <!-- /.offer-one__main-tab-box__bg -->
                <div class="tab-box-buttons wow fadeInLeft" data-wow-delay="00ms" data-wow-duration="1500ms">
                    <ul class="tab-buttons">
                        <li data-tab="#ModernTiels" class="tab-btn active-btn">
                            <button type="button" class="tab-btn__inner">Modern Tiels <span
                                    class="tab-btn__icon icon-right-arrow"></span></button>
                        </li>
                        <li data-tab="#FloorRemoval" class="tab-btn">
                            <button type="button" class="tab-btn__inner">Floor Remova <span
                                    class="tab-btn__icon icon-right-arrow"></span></button>
                        </li>
                        <li data-tab="#KitchenStripOuts" class="tab-btn">
                            <button type="button" class="tab-btn__inner">Kitchen Strip Outs <span
                                    class="tab-btn__icon icon-right-arrow"></span></button>
                        </li>
                        <li data-tab="#WoodFloorRepair" class="tab-btn">
                            <button type="button" class="tab-btn__inner">Wood Floor Repair <span
                                    class="tab-btn__icon icon-right-arrow"></span></button>
                        </li>
                    </ul><!-- /.tab-buttons -->
                </div><!-- /.tab-box-buttons -->
                <div class="tabs-content wow fadeInRight" data-wow-delay="200ms" data-wow-duration="1500ms">
                    <div class="tab active-tab fadeInUp animated" data-wow-delay="200ms" id="ModernTiels"
                        style="display: block;">
                        <div class="offer-one__service">
                            <div class="offer-one__service__image">
                                <img src="{{ asset('frontend') }}/assets/images/offer/offer-service-1-1.jpg"
                                    alt="offer-service">
                                <div class="offer-one__service__shape offer-one__service__shape--one"></div>
                                <!-- /.offer-one__service__shape -->
                                <div class="offer-one__service__shape offer-one__service__shape--two"></div>
                                <!-- /.offer-one__service__shape -->
                            </div><!-- /.offer-one__service__image -->
                            <div class="offer-one__service__content">
                                <h3 class="offer-one__service__title">Modern tiles</h3>
                                <!-- /.offer-one__service__title -->
                                <p class="offer-one__service__text">Many modern tiles companies are conscious of
                                    environmental concern and offer eco-friendly tile options.</p>
                                <!-- /.offer-one__service__text -->
                                <ul class="offer-one__service__list">
                                    <li>
                                        <span class="icon-tick"></span>
                                        More Expensive
                                    </li>
                                    <li>
                                        <span class="icon-tick"></span>
                                        Elegant Vein Patterns
                                    </li>
                                </ul><!-- /.offer-one__service__list -->
                            </div><!-- /.offer-one__service__content -->
                        </div><!-- /.offer-one__service -->
                    </div><!-- /.modern-tiels-tab -->
                    <div class="tab fadeInUp animated" data-wow-delay="200ms" id="FloorRemoval">
                        <div class="offer-one__service">
                            <div class="offer-one__service__image">
                                <img src="{{ asset('frontend') }}/assets/images/offer/offer-service-1-2.jpg"
                                    alt="offer-service">
                                <div class="offer-one__service__shape offer-one__service__shape--one"></div>
                                <!-- /.offer-one__service__shape -->
                                <div class="offer-one__service__shape offer-one__service__shape--two"></div>
                                <!-- /.offer-one__service__shape -->
                            </div><!-- /.offer-one__service__image -->
                            <div class="offer-one__service__content">
                                <h3 class="offer-one__service__title">Floor Remova</h3>
                                <!-- /.offer-one__service__title -->
                                <p class="offer-one__service__text">Many modern tiles companies are conscious of
                                    environmental concern and offer eco-friendly tile options.</p>
                                <!-- /.offer-one__service__text -->
                                <ul class="offer-one__service__list">
                                    <li>
                                        <span class="icon-tick"></span>
                                        More Expensive
                                    </li>
                                    <li>
                                        <span class="icon-tick"></span>
                                        Elegant Vein Patterns
                                    </li>
                                </ul><!-- /.offer-one__service__list -->
                            </div><!-- /.offer-one__service__content -->
                        </div><!-- /.offer-one__service -->
                    </div><!-- /.floor-removal-tab -->
                    <div class="tab fadeInUp animated" data-wow-delay="200ms" id="KitchenStripOuts">
                        <div class="offer-one__service">
                            <div class="offer-one__service__image">
                                <img src="{{ asset('frontend') }}/assets/images/offer/offer-service-1-3.jpg"
                                    alt="offer-service">
                                <div class="offer-one__service__shape offer-one__service__shape--one"></div>
                                <!-- /.offer-one__service__shape -->
                                <div class="offer-one__service__shape offer-one__service__shape--two"></div>
                                <!-- /.offer-one__service__shape -->
                            </div><!-- /.offer-one__service__image -->
                            <div class="offer-one__service__content">
                                <h3 class="offer-one__service__title">Kitchen Strip Outs</h3>
                                <!-- /.offer-one__service__title -->
                                <p class="offer-one__service__text">Many modern tiles companies are conscious of
                                    environmental concern and offer eco-friendly tile options.</p>
                                <!-- /.offer-one__service__text -->
                                <ul class="offer-one__service__list">
                                    <li>
                                        <span class="icon-tick"></span>
                                        More Expensive
                                    </li>
                                    <li>
                                        <span class="icon-tick"></span>
                                        Elegant Vein Patterns
                                    </li>
                                </ul><!-- /.offer-one__service__list -->
                            </div><!-- /.offer-one__service__content -->
                        </div><!-- /.offer-one__service -->
                    </div><!-- /.kitchen-strip-outs-tab -->
                    <div class="tab fadeInUp animated" data-wow-delay="200ms" id="WoodFloorRepair">
                        <div class="offer-one__service">
                            <div class="offer-one__service__image">
                                <img src="{{ asset('frontend') }}/assets/images/offer/offer-service-1-4.jpg"
                                    alt="offer-service">
                                <div class="offer-one__service__shape offer-one__service__shape--one"></div>
                                <!-- /.offer-one__service__shape -->
                                <div class="offer-one__service__shape offer-one__service__shape--two"></div>
                                <!-- /.offer-one__service__shape -->
                            </div><!-- /.offer-one__service__image -->
                            <div class="offer-one__service__content">
                                <h3 class="offer-one__service_title">Wood Floor Repair</h3>
                                <!-- /.offer-one__service__title -->
                                <p class="offer-one__service__text">Many modern tiles companies are conscious of
                                    environmental concern and offer eco-friendly tile options.</p>
                                <!-- /.offer-one__service__text -->
                                <ul class="offer-one__service__list">
                                    <li>
                                        <span class="icon-tick"></span>
                                        More Expensive
                                    </li>
                                    <li>
                                        <span class="icon-tick"></span>
                                        Elegant Vein Patterns
                                    </li>
                                </ul><!-- /.offer-one__service__list -->
                            </div><!-- /.offer-one__service__content -->
                        </div><!-- /.offer-one__service -->
                    </div><!-- /.wood-floor-repair-tab -->
                </div><!-- /.tab-content -->
            </div><!-- /.pricing-page__main-tab-box -->
        </div><!-- /.container -->
    </section><!-- /.offer-one section-space-two -->
    <!-- offer end --> --}}

    <!-- projects start -->
    <section class="projects-one">
        <div class="projects-one__bg"
            style="background-image: url({{ asset('frontend') }}/assets/images/backgrounds/projects-bg-1.png);">
        </div>
        <!-- /.projects-one__bg -->
        <div class="projects-one__container container-fluid">
            <div class="projects-one__carousel floens-owl__carousel floens-owl__carousel--basic-nav owl-carousel owl-theme"
                data-owl-options='{
                "items": 1,
                "margin": 0,
                "loop": true,
                "smartSpeed": 700,
                "nav": false,
                "navText": ["<span class=\"icon-slide-left-arrow\"></span>","<span class=\"icon-slide-right-arrow\"></span>"],
                "dots": false,
                "autoplay": 600,
                "rtl": true,
                "responsive":{
                    "0":{
                        "items": 1,
                        "margin": 15
                    },
                    "530":{
                        "items": 1.4,
                        "margin": 30
                    },
                    "576":{
                        "items": 1.5,
                        "margin": 30
                    },
                    "768":{
                        "items": 1.6,
                        "margin": 30
                    },
                    "992":{
                        "items": 1.7,
                        "margin": 30
                    },
                    "1200":{
                        "items": 1.7,
                        "margin": 30
                    },
                    "1300":{
                        "items": 1.2,
                        "margin": 30
                    },
                    "1400":{
                        "items": 1.2,
                        "margin": 30
                    },
                    "1500":{
                        "items": 1.29,
                        "margin": 30
                    },
                    "1600":{
                        "items": 1.37,
                        "margin": 30
                    },
                    "1700":{
                        "items": 1.46,
                        "margin": 30
                    },
                    "1800":{
                        "items": 1.64,
                        "margin": 30
                    }
                }
            }'>
                <div class="item">
                    <div class="project-card @@extraClassName">
                        <a href="work-details.html" class="project-card__image">
                            <img src="{{ asset('frontend') }}/assets/images/works/project-1-1.jpg" alt="Modern Tiles">
                        </a><!-- /.project-card__image -->
                        <div class="project-card__content">
                            <h3 class="project-card__tagline">Tile Care</h3><!-- /.project-card__tagline -->
                            <div class="project-card__links">
                                <div class="project-card__links__inner">
                                    <h3 class="project-card__title"><a href="work-details.html">Modern Tiles</a>
                                    </h3><!-- /.project-card__title -->
                                    <a href="work-details.html" class="project-card__link floens-btn"><span
                                            class="icon-right-arrow"></span></a><!-- /.project-card__link -->
                                </div><!-- /.project-card__links__inner -->
                            </div><!-- /.project-card__links -->
                        </div><!-- /.project-card__content -->
                    </div><!-- /.project-card -->
                </div><!-- /.item -->
                <div class="item">
                    <div class="project-card @@extraClassName">
                        <a href="work-details.html" class="project-card__image">
                            <img src="{{ asset('frontend') }}/assets/images/works/project-1-2.jpg" alt="Modern Tiles">
                        </a><!-- /.project-card__image -->
                        <div class="project-card__content">
                            <h3 class="project-card__tagline">Tile Care</h3><!-- /.project-card__tagline -->
                            <div class="project-card__links">
                                <div class="project-card__links__inner">
                                    <h3 class="project-card__title"><a href="work-details.html">Modern Tiles</a>
                                    </h3><!-- /.project-card__title -->
                                    <a href="work-details.html" class="project-card__link floens-btn"><span
                                            class="icon-right-arrow"></span></a><!-- /.project-card__link -->
                                </div><!-- /.project-card__links__inner -->
                            </div><!-- /.project-card__links -->
                        </div><!-- /.project-card__content -->
                    </div><!-- /.project-card -->
                </div><!-- /.item -->
                <div class="item">
                    <div class="project-card @@extraClassName">
                        <a href="work-details.html" class="project-card__image">
                            <img src="{{ asset('frontend') }}/assets/images/works/project-1-1.jpg" alt="Modern Tiles">
                        </a><!-- /.project-card__image -->
                        <div class="project-card__content">
                            <h3 class="project-card__tagline">Tile Care</h3><!-- /.project-card__tagline -->
                            <div class="project-card__links">
                                <div class="project-card__links__inner">
                                    <h3 class="project-card__title"><a href="work-details.html">Modern Tiles</a>
                                    </h3><!-- /.project-card__title -->
                                    <a href="work-details.html" class="project-card__link floens-btn"><span
                                            class="icon-right-arrow"></span></a><!-- /.project-card__link -->
                                </div><!-- /.project-card__links__inner -->
                            </div><!-- /.project-card__links -->
                        </div><!-- /.project-card__content -->
                    </div><!-- /.project-card -->
                </div><!-- /.item -->
                <div class="item">
                    <div class="project-card @@extraClassName">
                        <a href="work-details.html" class="project-card__image">
                            <img src="{{ asset('frontend') }}/assets/images/works/project-1-2.jpg" alt="Modern Tiles">
                        </a><!-- /.project-card__image -->
                        <div class="project-card__content">
                            <h3 class="project-card__tagline">Tile Care</h3><!-- /.project-card__tagline -->
                            <div class="project-card__links">
                                <div class="project-card__links__inner">
                                    <h3 class="project-card__title"><a href="work-details.html">Modern Tiles</a>
                                    </h3><!-- /.project-card__title -->
                                    <a href="work-details.html" class="project-card__link floens-btn"><span
                                            class="icon-right-arrow"></span></a><!-- /.project-card__link -->
                                </div><!-- /.project-card__links__inner -->
                            </div><!-- /.project-card__links -->
                        </div><!-- /.project-card__content -->
                    </div><!-- /.project-card -->
                </div><!-- /.item -->
            </div><!-- /.projects-one__carousel -->
        </div><!-- /.container-fluid -->
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-7 projects-one__content-col">
                    <div class="projects-one__content">
                        <div class="sec-title sec-title--border">
                            <h3 class="sec-title__title">Some Design</h3>
                            <!-- /.sec-title__title -->
                        </div><!-- /.sec-title -->


                        <p class="projects-one__text">Tiles company, also known as a tile manufacturer or
                            distributor,
                            specializes in the production and distribution of various types of tiles used for a wide
                            range
                            of applications. These companies</p><!-- /.projects-one__text -->
                        <div class="projects-one__button">
                            <a href="work.html" class="projects-one__btn floens-btn floens-btn--border">
                                <span>view all</span>
                                <i class="icon-right-arrow"></i>
                            </a><!-- /.projects-one__btn floens-btn -->
                        </div><!-- /.projects-one__button -->
                    </div><!-- /.projects-one__content -->
                </div><!-- /.col-xl-6 col-lg-7 -->
            </div><!-- /.row -->
        </div><!-- /.container -->
        <img src="{{ asset('frontend') }}/assets/images/shapes/projects-shape-1-1.jpg" alt="projects"
            class="projects-one__shape">
    </section><!-- /.projects-one section-space -->
    <!-- projects end -->

    <!-- reliable start -->
    <section class="reliable-one reliable-one--home section-space-bottom">
        <div class="container">
            <div class="row gutter-y-60">
                <div class="col-lg-6">
                    <div class="reliable-one__content">
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
                        <a href="contact.html" class="floens-btn reliable-one__btn">
                            <span>get in touch</span>
                            <i class="icon-right-arrow"></i>
                        </a><!-- /.floens-btn reliable-one__btn -->
                    </div><!-- /.reliable-one__content -->
                </div><!-- /.col-lg-6 -->
                <div class="col-lg-6 wow fadeInRight" data-wow-duration="1500ms">
                    <div class="reliable-one__images">
                        <div class="reliable-one__image">
                            <img src="{{ asset('frontend') }}/assets/images/reliable/reliable-1-1.jpg" alt="reliable"
                                class="reliable-one__image__one">
                            <div class="reliable-one__image__inner">
                                <img src="{{ asset('frontend') }}/assets/images/reliable/reliable-1-2.jpg" alt="reliable"
                                    class="reliable-one__image__two">
                            </div><!-- /.reliable-one__image__inner -->
                            <div class="experience reliable-one__experience">
                                <div class="experience__inner">
                                    <h3 class="experience__year"
                                        style="background-image: url('{{ asset('frontend') }}/assets/images/shapes/reliable-shape-1-1.png');">
                                        25
                                    </h3>
                                    <!-- /.experience__year -->
                                    <p class="experience__text">years of <br> experience</p>
                                    <!-- /.experience__text -->
                                </div><!-- /.experience__inner -->
                            </div><!-- /.experience -->
                        </div><!-- /.reliable-one__image -->
                    </div><!-- /.reliable-one__images -->
                </div><!-- /.col-lg-6 -->
            </div><!-- /.row -->
        </div><!-- /.container -->
    </section><!-- /.reliable-one section-space-bottom -->
    <!-- reliable end -->

    <!-- shop start -->
    <section class="product-home">
        <div class="product-home__bg"
            style="background-image: url({{ asset('frontend') }}/assets/images/backgrounds/shop-bg-1.png);">
        </div>
        <!-- /.product-home__bg -->
        <div class="container">
            <div class="sec-title sec-title--center">

                <h6 class="sec-title__tagline">our shop</h6><!-- /.sec-title__tagline -->

                <h3 class="sec-title__title">Let’s Explore Latest <br> Product in Shop</h3>
                <!-- /.sec-title__title -->
            </div><!-- /.sec-title -->


            <div class="row gutter-y-30">
                @foreach ($products as $product)
                    <div class="col-xl-3 col-lg-4 col-md-6 ">
                        <div class="product__item wow fadeInUp" data-wow-duration='1500ms' data-wow-delay='000ms'>
                            <div class="product__item__image">
                                @php
                                    $images = $product->images->where('type', 'thumbnail')->first();
                                @endphp
                                <img src="{{ ImageUploadHelper::getProductImageUrl($images?->image) }}"
                                    alt="Natural Stone Tiles">
                            </div><!-- /.product-image -->
                            <div class="product__item__content">
                                <h4 class="product__item__title"><a
                                        href="#">{{ Str::limit($product->name, 15) }}</a>
                                </h4><!-- /.product-title -->
                                <div class="product__item__price">{{ env('CURRENCY_SYMBOL') }}{{ $product->price }}</div>

                                <div class="d-flex align-items-center justify-content-center">
                                    <a href="javascript:void(0);"
                                        class="floens-btn product__item__link me-2 custom-button p-3 enquireBtn"
                                        data-id="{{ $product->id }}">Enquire</a>

                                    <a href="" class="floens-btn product__item__link me-2 custom-button p-4">
                                        <i style='font-size:17px; right: 15px' class='fas'>&#xf217;</i></a>
                                </div>



                            </div><!-- /.product-content -->
                        </div><!-- /.product-item -->
                    </div><!-- /.col-md-6 col-lg-4 -->
                @endforeach
            </div><!-- /.row -->
        </div><!-- /.container -->
    </section><!-- /.product-home -->
    <!-- shop end -->

    <!-- gallery instagram start -->
    <section class="gallery-instagram @@extraClassName section-space-bottom">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 wow fadeInUp" data-wow-duration="1500ms"
                    data-wow-delay="00ms">
                    <div class="gallery-instagram__image">
                        <img src="{{ asset('frontend') }}/assets/images/gallery/gallery-instagram-1-1.jpg"
                            alt="gallery-instagram">
                        <a href="https://www.instagram.com/" class="gallery-instagram__image__link">
                            <span class="icon-instagram"></span>
                        </a><!-- /.gallery-instagram__image__link -->
                    </div><!-- /.gallery-instagram__image -->
                </div><!-- /.col-xl-2 col-lg-3 col-md-4 col-sm-6 -->
                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 wow fadeInUp" data-wow-duration="1500ms"
                    data-wow-delay="200ms">
                    <div class="gallery-instagram__image">
                        <img src="{{ asset('frontend') }}/assets/images/gallery/gallery-instagram-1-2.jpg"
                            alt="gallery-instagram">
                        <a href="https://www.instagram.com/" class="gallery-instagram__image__link">
                            <span class="icon-instagram"></span>
                        </a><!-- /.gallery-instagram__image__link -->
                    </div><!-- /.gallery-instagram__image -->
                </div><!-- /.col-xl-2 col-lg-3 col-md-4 col-sm-6 -->
                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 wow fadeInUp" data-wow-duration="1500ms"
                    data-wow-delay="400ms">
                    <div class="gallery-instagram__image">
                        <img src="{{ asset('frontend') }}/assets/images/gallery/gallery-instagram-1-3.jpg"
                            alt="gallery-instagram">
                        <a href="https://www.instagram.com/" class="gallery-instagram__image__link">
                            <span class="icon-instagram"></span>
                        </a><!-- /.gallery-instagram__image__link -->
                    </div><!-- /.gallery-instagram__image -->
                </div><!-- /.col-xl-2 col-lg-3 col-md-4 col-sm-6 -->
                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 wow fadeInUp" data-wow-duration="1500ms"
                    data-wow-delay="600ms">
                    <div class="gallery-instagram__image">
                        <img src="{{ asset('frontend') }}/assets/images/gallery/gallery-instagram-1-4.jpg"
                            alt="gallery-instagram">
                        <a href="https://www.instagram.com/" class="gallery-instagram__image__link">
                            <span class="icon-instagram"></span>
                        </a><!-- /.gallery-instagram__image__link -->
                    </div><!-- /.gallery-instagram__image -->
                </div><!-- /.col-xl-2 col-lg-3 col-md-4 col-sm-6 -->
                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 wow fadeInUp" data-wow-duration="1500ms"
                    data-wow-delay="800ms">
                    <div class="gallery-instagram__image">
                        <img src="{{ asset('frontend') }}/assets/images/gallery/gallery-instagram-1-5.jpg"
                            alt="gallery-instagram">
                        <a href="https://www.instagram.com/" class="gallery-instagram__image__link">
                            <span class="icon-instagram"></span>
                        </a><!-- /.gallery-instagram__image__link -->
                    </div><!-- /.gallery-instagram__image -->
                </div><!-- /.col-xl-2 col-lg-3 col-md-4 col-sm-6 -->
                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 wow fadeInUp" data-wow-duration="1500ms"
                    data-wow-delay="1000ms">
                    <div class="gallery-instagram__image">
                        <img src="{{ asset('frontend') }}/assets/images/gallery/gallery-instagram-1-6.jpg"
                            alt="gallery-instagram">
                        <a href="https://www.instagram.com/" class="gallery-instagram__image__link">
                            <span class="icon-instagram"></span>
                        </a><!-- /.gallery-instagram__image__link -->
                    </div><!-- /.gallery-instagram__image -->
                </div><!-- /.col-xl-2 col-lg-3 col-md-4 col-sm-6 -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section><!-- /.gallery-instagram section-space-bottom -->
    <!-- gallery instagram end -->


    <!-- client carousel start -->
    <div class="client-carousel @@extraClassName">
        <div class="container">
            <div class="client-carousel__one floens-owl__carousel owl-theme owl-carousel"
                data-owl-options='{
                    "items": 5,
                    "margin": 65,
                    "smartSpeed": 700,
                    "loop":true,
                    "autoplay": 6000,
                    "nav":false,
                    "dots":false,
                    "navText": ["<span class=\"fa fa-angle-left\"></span>","<span class=\"fa fa-angle-right\"></span>"],
                    "responsive":{
                        "0":{
                            "items": 2,
                            "margin": 30
                        },
                        "500":{
                            "items": 3,
                            "margin": 40
                        },
                        "768":{
                            "items": 4,
                            "margin": 50
                        },
                        "992":{
                            "items": 5,
                            "margin": 70
                        },
                        "1200":{
                            "items": 6,
                            "margin": 149
                        }
                    }
                    }'>
                @foreach ($brands as $barand)
                    <div class="client-carousel__one__item">
                        <img src="{{ $barand->image ? asset($barand->image) : asset('assets/placeholder-image-2.png') }}"
                            alt="brand">
                    </div><!-- /.owl-slide-item-->
                @endforeach
            </div><!-- /.thm-owl__slider -->
        </div><!-- /.container -->
    </div><!-- /.client-carousel -->
    <!-- client carousel end -->
    <!-- Default Modals -->
    @include('frontend.products.enquire-modal')
@endsection
@section('page-script')
    <script>
        $(document).ready(function() {
            $('.enquireBtn').click(function() {
                var productId = $(this).data('id');
                // console.log(productId);
                $('#enquireForm').find('input[name="products[]"]').val(productId);
                $('#myModal').modal('show');
            });

            $('#enquireForm').submit(function(e) {
                e.preventDefault();
                var formData = $('#enquireForm').serialize();
                // console.log(formData);
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
