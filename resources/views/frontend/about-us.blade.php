@extends('frontend.layouts.app')
@section('page-style')
    <style>
        .sec_1_prev_3 {
            width: 270px;
            height: 617px
        }

        .sec_1_prev_2 {
            width: 240px;
            height: 347px
        }

        .sec_1_prev_1 {
            width: 240px;
            height: 240px
        }

        @media (max-width: 991px) {
            .sec_1_prev_3 {
                height: 400px;
            }

            .sec_1_prev_2 {
                height: 195px;
            }

            .sec_1_prev_1 {
                height: 190px;
            }
        }
    </style>
@endsection

@section('content')
    <section class="page-header">
        <div class="page-header__bg"
            style="background-image: url('{{ asset('frontend') }}/assets/images/backgrounds/page-header-bg-1-1.png');">
        </div><!-- /.page-header__bg -->
        <div class="container">
            <h2 class="page-header__title">About us</h2>
            <ul class="floens-breadcrumb list-unstyled">
                <li><i class="icon-home"></i> <a href="index.html">Home</a></li>
                <li><span>About us</span></li>
            </ul><!-- /.thm-breadcrumb list-unstyled -->
        </div><!-- /.container -->
    </section><!-- /.page-header -->

    <section class="about-one section-space" id="about">
        <div class="container">
            <div class="row gutter-y-60">
                <div class="col-lg-6 wow fadeInLeft" data-wow-duration="1500ms" data-wow-delay="00ms">
                    <div class="about-one__image-grid">
                        <div class="about-one__image">
                            <img src="{{ app_setting('about_one__image__one') ? app_setting('about_one__image__one') : asset('frontend/assets/images/about/about-1-3.png') }}"
                                alt="about" class="about-one__image__one sec_1_prev_1">
                            <img src="{{ app_setting('about_one__image__two') ? app_setting('about_one__image__two') : asset('frontend/assets/images/about/about-1-2.jpg') }}"
                                alt="about" class="about-one__image__two sec_1_prev_2">
                        </div><!-- /.about-one__image -->
                        <div class="about-one__image">
                            <img src="{{ app_setting('about_one__image__three') ? app_setting('about_one__image__three') : asset('frontend/assets/images/about/about-1-1.jpg') }}"
                                alt="about" class="about-one__image__three sec_1_prev_3">
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
                        @if (app_setting('about_sec_1'))
                            {!! app_setting('about_sec_1') !!}
                        @else
                            <div class="sec-title sec-title--border">

                                <h6 class="sec-title__tagline">about us</h6><!-- /.sec-title__tagline -->

                                <h3 class="sec-title__title">Explore Modern Tiles Stone & Agency</h3>
                                <!-- /.sec-title__title -->
                            </div><!-- /.sec-title -->


                            <div class="about-one__content__text wow fadeInUp" data-wow-duration="1500ms"
                                data-wow-delay="00ms">
                                <h5 class="about-one__text-title">We’re providing the best quality tiles in town.</h5>
                                <!-- /.about-one__text-title -->
                                <p class="about-one__text">Tiles company, also known as a tile manufacturer or distributor,
                                    specializes in the production and distribution of various types of tiles used for a wide
                                    range of applications. These companies play a crucial role in the construn and interior
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
                        @endif
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

    <section class="reliable-one @@extraClassName section-space-bottom">
        <div class="container">
            <div class="row gutter-y-60">
                <div class="col-lg-6 wow fadeInLeft" data-wow-duration="1500ms">
                    <div class="reliable-one__images">
                        <div class="reliable-one__image">
                            <img src="{{ asset('frontend') }}/assets/images/reliable/reliable-2-1.jpg" alt="reliable"
                                class="reliable-one__image__one">
                            <div class="reliable-one__image__inner">
                                <img src="{{ asset('frontend') }}/assets/images/reliable/reliable-2-2.jpg" alt="reliable"
                                    class="reliable-one__image__two">
                                {{-- <img src="{{ asset('frontend') }}/assets/images/reliable/reliable-2-3.png" alt="reliable"
                                    class="reliable-one__image__three"> --}}
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
                <div class="col-lg-6">
                    <div class="reliable-one__content">
                        <div class="sec-title sec-title--border">

                            <h6 class="sec-title__tagline">reliable</h6><!-- /.sec-title__tagline -->

                            <h3 class="sec-title__title">We Provide Reliable Flooring Services</h3>
                            <!-- /.sec-title__title -->
                        </div><!-- /.sec-title -->


                        <p class="reliable-one__text">Our vision is to provide innovative, independent flooring solutions
                            that problems for homes, industries, and workspaces, as well as flooring we would like in
                            our own residences, work spaces,</p><!-- /.reliable-one__text -->
                    </div><!-- /.reliable-one__content -->
                </div><!-- /.col-lg-6 -->
            </div><!-- /.row -->
        </div><!-- /.container -->
    </section><!-- /.reliable-one section-space-bottom -->
@endsection
@section('page-script')
    <script>
        $(document).ready(function() {
            $('[contenteditable="true"]').removeAttr('contenteditable');
        });
    </script>
@endsection
