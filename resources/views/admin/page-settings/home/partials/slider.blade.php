<section class="main-slider hero-slider">
    <div class="main-slider__bg">
        <img src="{{ asset('frontend/assets/images/backgrounds/slider-1-1.webp') }}" alt="Main Banner" width="1920"
            height="800" loading="eager" fetchpriority="high" style="object-fit: cover; width: 100%; height: 100%;">
    </div>

    <div class="hero-slider__social">
    </div>
    <a href="#about" class="main-slider__scroll-btn"><span></span></a>
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
                                <h3 class="sec-title__title">{{ $slider->title }}</h3>
                            </div>


                            <p class="main-slider__text">{{ $slider->description }} </p>
                            <a href="{{ route('frontend.aboutUs') }}" class="main-slider__btn floens-btn">
                                <span>discover more</span>
                                <i class="icon-right-arrow"></i>
                            </a>
                        </div>
                    </div>
                    <div class="main-slider__right">
                        <div class="main-slider__image">
                            <div class="main-slider__image__inner">
                                <img src="{{ $slider->image ? asset($slider->image) : asset('frontend/assets/images/slider/slider-thumbs-1-1.jpg') }}"
                                    alt="slider-image" class="main-slider__image__one">
                            </div>
                            <img src="{{ asset('frontend') }}/assets/images/shapes/slider-shape-1-1.jpg" alt="slider"
                                class="main-slider__image__two">
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
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
                <img src="{{ $slider->image ? asset($slider->image) : asset('frontend/assets/images/slider/slider-thumbs-1-1.jpg') }}"
                    alt="slider-thumbs">
            </li>
        @endforeach
    </ul>
</section>
