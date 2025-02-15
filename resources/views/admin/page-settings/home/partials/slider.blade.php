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
        @foreach ($sliders as $slider)
            <div class="main-slider__item">
                <div class="main-slider__wrapper container-fluid">
                    <div class="main-slider__left">
                        <div class="main-slider__content">
                            <div class="sec-title sec-title--center">

                                {{-- <h6 class="sec-title__tagline">Precision Tile & Flooring Solutions</h6> --}}
                                <!-- /.sec-title__tagline -->

                                <h3 class="sec-title__title">{{ $slider->title }}</h3>
                                <!-- /.sec-title__title -->
                            </div><!-- /.sec-title -->


                            <p class="main-slider__text">{{ $slider->description }} </p>
                            <!-- /.main-slider__text -->
                            <a href="{{ route('frontend.aboutUs') }}" class="main-slider__btn floens-btn">
                                <span>discover more</span>
                                <i class="icon-right-arrow"></i>
                            </a><!-- /.main-slider__btn floens-btn -->
                        </div><!-- /.main-slider__content -->
                    </div><!-- /.main-slider__left -->
                    <div class="main-slider__right">
                        <div class="main-slider__image">
                            <div class="main-slider__image__inner">
                                <img src="{{ $slider->image ?? asset('frontend/assets/images/slider/slider-thumbs-1-1.jpg') }}"
                                    alt="slider" class="main-slider__image__one">
                            </div><!-- /.main-slider__image__inner -->
                            <img src="{{ asset('frontend') }}/assets/images/shapes/slider-shape-1-1.jpg" alt="slider"
                                class="main-slider__image__two">
                        </div><!-- /.main-slider__image -->
                    </div><!-- /.main-slider__right -->
                </div><!-- /.main-slider__wrapper .container-fluid -->
            </div><!-- /.main-slider__item -->
        @endforeach
        {{-- <div class="main-slider__item">
            <div class="main-slider__wrapper container-fluid">
                <div class="main-slider__left">
                    <div class="main-slider__content">
                        <div class="sec-title sec-title--center">

                            <h6 class="sec-title__tagline">Precision Tile & Flooring Solutions</h6>
                            <!-- /.sec-title__tagline -->

                            <h3 class="sec-title__title">Let us Make Your <br> Home Better 2</h3>
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
                    </div><!-- /.main-slider__image -->
                </div><!-- /.main-slider__right -->
            </div><!-- /.main-slider__wrapper .container-fluid -->
        </div><!-- /.main-slider__item -->
        <div class="main-slider__item">
            <div class="main-slider__wrapper container-fluid">
                <div class="main-slider__left">
                    <div class="main-slider__content">
                        <div class="sec-title sec-title--center">

                            <h6 class="sec-title__tagline">Precision Tile & Flooring Solutions 3</h6>
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
                    </div><!-- /.main-slider__image -->
                </div><!-- /.main-slider__right -->
            </div><!-- /.main-slider__wrapper .container-fluid -->
        </div><!-- /.main-slider__item -->
        <div class="main-slider__item">
            <div class="main-slider__wrapper container-fluid">
                <div class="main-slider__left">
                    <div class="main-slider__content">
                        <div class="sec-title sec-title--center">

                            <h6 class="sec-title__tagline">Precision Tile & Flooring Solutions 4</h6>
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
                    </div><!-- /.main-slider__image -->
                </div><!-- /.main-slider__right -->
            </div><!-- /.main-slider__wrapper .container-fluid -->
        </div><!-- /.main-slider__item -->
        <div class="main-slider__item">
            <div class="main-slider__wrapper container-fluid">
                <div class="main-slider__left">
                    <div class="main-slider__content">
                        <div class="sec-title sec-title--center">

                            <h6 class="sec-title__tagline">Precision Tile & Flooring Solutions 5</h6>
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
                    </div><!-- /.main-slider__image -->
                </div><!-- /.main-slider__right -->
            </div><!-- /.main-slider__wrapper .container-fluid -->
        </div><!-- /.main-slider__item -->
        <div class="main-slider__item">
            <div class="main-slider__wrapper container-fluid">
                <div class="main-slider__left">
                    <div class="main-slider__content">
                        <div class="sec-title sec-title--center">

                            <h6 class="sec-title__tagline">Precision Tile & Flooring Solutions 6</h6>
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
                    </div><!-- /.main-slider__image -->
                </div><!-- /.main-slider__right -->
            </div><!-- /.main-slider__wrapper .container-fluid -->
        </div><!-- /.main-slider__item --> --}}
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
        @foreach ($sliders as $slider)
            <li>
                <img src="{{ $slider->image ?? asset('frontend/assets/images/slider/slider-thumbs-1-1.jpg') }}"
                    alt="slider-thumbs">
            </li>
        @endforeach
        {{-- <li>
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
        </li> --}}
    </ul><!--/.main-slider__carousel-thumbs -->
</section><!-- /.main-slider -->
