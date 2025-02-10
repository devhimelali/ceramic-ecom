@php
    use App\Helpers\ImageUploadHelper;
@endphp
@extends('frontend.layouts.app')

@section('content')
    <section class="page-header">
        <div class="page-header__bg"
            style="background-image: url('{{ asset('frontend') }}/assets//images/backgrounds/page-header-bg-1-1.png');">
        </div>
        <!-- /.page-header__bg -->
        <div class="container">
            <h2 class="page-header__title">{{ $product->name }}</h2>
            <ul class="floens-breadcrumb list-unstyled">
                <li><i class="icon-home"></i> <a href="{{ route('frontend.home') }}">Home</a></li>
                <li><span>shop</span></li>
                <li><span>{{ $product->name }}</span></li>
            </ul><!-- /.thm-breadcrumb list-unstyled -->
        </div><!-- /.container -->
    </section><!-- /.page-header -->

    <section class="product-details section-space">
        <div class="container">
            <!-- /.product-details -->
            <div class="row gutter-y-50">
                <div class="col-lg-6 col-xl-6 wow fadeInLeft" data-wow-delay="200ms">
                    <div class="product-details__img">
                        <div class="swiper product-details__gallery-top">
                            <div class="swiper-wrapper">
                                @php
                                    $images = $product->images->where('type', 'gallery');
                                @endphp
                                @foreach ($images as $image)
                                    <div class="swiper-slide">
                                        <img src="{{ ImageUploadHelper::getProductImageUrl($image->image) }}"
                                            alt="product details image" class="product-details__gallery-top__img">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="swiper product-details__gallery-thumb">
                            <div class="swiper-wrapper">
                                @foreach ($images as $image)
                                    <div class="product-details__gallery-thumb-slide swiper-slide">
                                        <img src="{{ ImageUploadHelper::getProductImageUrl($image->image) }}"
                                            alt="product details thumb" class="product-details__gallery-thumb__img">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div><!-- /.column -->
                <div class="col-lg-6 col-xl-6 wow fadeInRight" data-wow-delay="300ms">
                    <div class="product-details__content">
                        {{-- <div class="product-details__top">
                            <div class="product-details__top__left">
                                <h3 class="product-details__name">mosaic tiles</h3><!-- /.product-title -->
                                <h4 class="product-details__price">$69</h4><!-- /.product-price -->
                            </div><!-- /.product-details__price -->
                            <a href="https://www.youtube.com/watch?v=h9MbznbxlLc"
                                class="product-details__video video-button video-popup">
                                <span class="icon-play"></span>
                                <i class="video-button__ripple"></i>
                            </a><!-- /.video-button -->
                        </div> --}}
                        <div class="product-details__excerpt">
                            <p class="product-details__excerpt__text1">
                                {{ $product->short_description }}
                            </p>
                        </div><!-- /.excerp-text -->
                        <div class="product-details__color">
                            @foreach ($product->attributes as $attribute)
                                <h3 class="product-details__content__title">{{ $attribute->name }}</h3>
                            @endforeach

                            <div class="product-details__color__box">

                            </div><!-- /.product-details__color__box -->
                        </div><!-- /.product-details__color -->
                        <div class="product-details__size">
                            <h3 class="product-details__content__title">Size</h3>
                            <div class="product-details__size__box">
                                <button type="button" class="product-details__size__btn"><span>S</span></button>
                                <button type="button" class="product-details__size__btn"><span>M</span></button>
                                <button type="button" class="product-details__size__btn"><span>L</span></button>
                                <button type="button" class="product-details__size__btn"><span>XL</span></button>
                            </div><!-- /.product-details__size__box -->
                        </div><!-- /.product-details__size -->
                        <div class="product-details__info">
                            <div class="product-details__quantity">
                                <h3 class="product-details__content__title">Quantity</h3>
                                <div class="quantity-box">
                                    <button type="button" class="sub"><i class="fa fa-minus"></i></button>
                                    <input type="text" id="1" value="1">
                                    <button type="button" class="add"><i class="fa fa-plus"></i></button>
                                </div>
                            </div><!-- /.quantity -->
                            <div class="product-details__socials">
                                <h3 class="product-details__socials__title">share:</h3>
                                <div class="details-social">
                                    <a href="https://facebook.com/">
                                        <i class="icon-facebook" aria-hidden="true"></i>
                                        <span class="sr-only">Facebook</span>
                                    </a>
                                    <a href="https://twitter.com/">
                                        <i class="icon-twitter" aria-hidden="true"></i>
                                        <span class="sr-only">Twitter</span>
                                    </a>
                                    <a href="https://linkedin.com/">
                                        <i class="icon-linkedin" aria-hidden="true"></i>
                                        <span class="sr-only">Linkedin</span>
                                    </a>
                                    <a href="https://youtube.com/">
                                        <i class="icon-youtube" aria-hidden="true"></i>
                                        <span class="sr-only">Youtube</span>
                                    </a>
                                </div><!-- /.details-social -->
                            </div><!-- /.product-details__socials -->
                        </div><!-- /.product-details__info -->
                        <div class="product-details__buttons">
                            <a href="cart.html" class="product-details__btn-cart floens-btn">
                                <span>Add to Cart</span>
                                <i class="icon-cart"></i>
                            </a>
                        </div><!-- /.qty-btn -->
                    </div>
                </div>
            </div>
            <!-- /.product-details -->
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
                    </div><!-- /.product-details__text__box -->
                </div>
                <!-- /.product-description -->
            </div><!-- /.container -->
        </div><!-- /.product-details__description__wrapper -->
    </section>
    <!-- Products End -->
@endsection
