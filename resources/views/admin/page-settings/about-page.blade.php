@extends('frontend.layouts.app')
@section('page-style')
    <style>
        .image-container {
            position: relative;
            display: inline-block;
        }

        .image-container img {
            display: block;
            width: 100%;
            height: auto;
            border-radius: 10px;
        }

        .upload-btn {
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0, 0, 0, 0.7);
            color: #fff;
            padding: 8px 12px;
            font-size: 14px;
            border-radius: 5px;
            cursor: pointer;
            display: inline-block;
            transition: 0.3s;
        }

        .upload-btn:hover {
            background: rgba(0, 0, 0, 0.9);
        }

        .upload-btn input {
            display: none;
        }

        .sec_1_prev_3 {
            width: 270px;
            height: 617px !important;
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
            <form action="{{ route('settings.aboutPageChange') }}" id="aboutFormSectionOne" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="row gutter-y-60">
                    <div class="col-lg-6 wow fadeInLeft" data-wow-duration="1500ms" data-wow-delay="00ms">
                        <div class="about-one__image-grid">
                            <div class="about-one__image">
                                <div class="image-container">
                                    <img src="{{ app_setting('about_one__image__one') ? app_setting('about_one__image__one') : asset('frontend/assets/images/about/about-1-3.png') }}"
                                        alt="about" class="about-one__image__one sec_1_prev_1">


                                    <input type="file" class="image-upload sec_1_img_1 d-none"
                                        data-target="about-one__image__one" name="about_one__image__one">
                                    <label class="upload-btn"
                                        onclick="setupImagePreview('.sec_1_img_1', '.sec_1_prev_1', '240', '240')">
                                        240 × 240 px <br>
                                        Upload
                                    </label>
                                </div>
                                <div class="image-container">
                                    <img src="{{ app_setting('about_one__image__two') ? app_setting('about_one__image__two') : asset('frontend/assets/images/about/about-1-2.jpg') }}"
                                        alt="about" class="about-one__image__two sec_1_prev_2">


                                    <input type="file" class="image-upload sec_1_img_2 d-none"
                                        data-target="about-one__image__two" name="about_one__image__two">
                                    <label onclick="setupImagePreview('.sec_1_img_2', '.sec_1_prev_2','240', '347')"
                                        class="upload-btn">
                                        240 × 347 px <br>
                                        Upload
                                    </label>
                                </div>
                            </div><!-- /.about-one__image -->

                            <div class="about-one__image">
                                <div class="image-container">
                                    <img src="{{ app_setting('about_one__image__three') ? app_setting('about_one__image__three') : asset('frontend/assets/images/about/about-1-1.jpg') }}"
                                        alt="about" class="about-one__image__three sec_1_prev_3">


                                    <input type="file" class="image-upload sec_1_img_3 d-none"
                                        data-target="about-one__image__three" name="about_one__image__three">
                                    <label onclick="setupImagePreview('.sec_1_img_3', '.sec_1_prev_3','270', '617')"
                                        class="upload-btn">
                                        270 × 617 px <br>
                                        Upload
                                    </label>
                                </div>
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
                        <textarea class="d-none" name="about_sec_1" id="about_one__content__one" cols="30" rows="10"></textarea>
                        <div id="about_content__one" class="about-one__content">
                            @if (app_setting('about_sec_1'))
                                {!! app_setting('about_sec_1') !!}
                            @else
                                <div class="sec-title sec-title--border">
                                    <h6 class="sec-title__tagline" contenteditable="true">about us</h6>
                                    <h3 class="sec-title__title" contenteditable="true">Explore Modern Tiles Stone & Agency
                                    </h3>
                                </div>

                                <div class="about-one__content__text">
                                    <h5 class="about-one__text-title" contenteditable="true">We’re providing the best
                                        quality
                                        tiles in town.</h5>
                                    <p class="about-one__text" contenteditable="true">
                                        Tiles company, also known as a tile manufacturer or distributor, specializes in the
                                        production
                                        and distribution of various types of tiles used for a wide range of applications.
                                    </p>
                                </div>

                                <div class="row about-one__inner-row">
                                    <div class="col-xl-6">
                                        <div class="about-one__service about-one__service--one">
                                            <div class="about-one__service__icon">
                                                <span class="icon-toilet"></span>
                                            </div>
                                            <div class="about-one__service__content">
                                                <h4 class="about-one__service__title" contenteditable="true">Tiles & Toilet
                                                </h4>
                                                <p class="about-one__service__text" contenteditable="true">Tiles company,
                                                    also
                                                    known as a tile</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="about-one__service about-one__service--two">
                                            <div class="about-one__service__icon">
                                                <span class="icon-kitchen"></span>
                                            </div>
                                            <div class="about-one__service__content">
                                                <h4 class="about-one__service__title" contenteditable="true">Design Kitchen
                                                    in
                                                    3D</h4>
                                                <p class="about-one__service__text" contenteditable="true">Tiles company,
                                                    also
                                                    known as a tile</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="about-one__button wow fadeInUp" data-wow-duration="1500ms"
                                    data-wow-delay="00ms">
                                    <a href="contact.html" class="floens-btn">
                                        <span>get in touch</span>
                                        <i class="icon-right-arrow"></i>
                                    </a><!-- /.floens-btn -->
                                </div><!-- /.about-one__button -->
                            @endif
                        </div>
                    </div><!-- /.col-lg-6 -->
                </div><!-- /.row -->
            </form>
            <button type="button"
                onclick="saveChanges('#about_content__one', '#about_one__content__one', '#aboutFormSectionOne')"
                class="btn btn-primary">Save Changes</button>
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
            <form action="{{ route('settings.aboutPageChange') }}" id="aboutFormSectionTwo" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="row gutter-y-60">
                    <div class="col-lg-6 wow fadeInLeft" data-wow-duration="1500ms">
                        <div class="reliable-one__images">
                            <div class="reliable-one__image">
                                <img src="{{ asset('frontend') }}/assets/images/reliable/reliable-2-1.jpg" alt="reliable"
                                    class="reliable-one__image__one">
                                <div class="reliable-one__image__inner">
                                    <img src="{{ asset('frontend') }}/assets/images/reliable/reliable-2-2.jpg"
                                        alt="reliable" class="reliable-one__image__two">
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
                    <textarea class="" name="about_sec_2" id="about_one__content__two" cols="30" rows="10"></textarea>
                    <div class="col-lg-6">
                        <div id="about_content__two" class="reliable-one__content">
                            <div class="sec-title sec-title--border">

                                <h6 class="sec-title__tagline"contenteditable="true">reliable</h6>
                                <!-- /.sec-title__tagline -->

                                <h3 class="sec-title__title" contenteditable="true">We Provide Reliable Flooring Services
                                </h3>
                                <!-- /.sec-title__title -->
                            </div><!-- /.sec-title -->


                            <p class="reliable-one__text" contenteditable="true">Our vision is to provide innovative,
                                independent flooring
                                solutions
                                that problems for homes, industries, and workspaces, as well as flooring we would like in
                                our own residences, work spaces,</p><!-- /.reliable-one__text -->
                        </div><!-- /.reliable-one__content -->
                    </div><!-- /.col-lg-6 -->
                </div><!-- /.row -->
                <button type="button"
                    onclick="saveChanges('#about_content__two,#about_one__content__two,#aboutFormSectionTwo')"
                    class="btn btn-primary">Save Changes</button>
            </form>
        </div><!-- /.container -->
    </section><!-- /.reliable-one section-space-bottom -->
@endsection
@section('page-script')
    <script>
        // function setupImagePreview(inputSelector, previewSelector, minWidth, minHeight) {
        //     // inputSelector means which input field to listen to
        //     // previewSelector means which image to change
        //     $(inputSelector).click();
        //     $(inputSelector).change(function() {
        //         if (this.files && this.files[0]) {
        //             var reader = new FileReader();
        //             reader.onload = function(e) {
        //                 $(previewSelector).attr("src", e.target.result);
        //             };
        //             reader.readAsDataURL(this.files[0]);
        //         }
        //     });
        // }


        function setupImagePreview(inputSelector, previewSelector, minWidth, minHeight) {
            $(inputSelector).click();

            $(inputSelector).change(function() {
                if (this.files && this.files[0]) {
                    var file = this.files[0];

                    validateImageSize(file, minWidth, minHeight, function(isValid, imageUrl) {
                        if (isValid) {
                            $(previewSelector).attr("src", imageUrl);
                        }
                    });
                }
            });
        }

        function validateImageSize(file, minWidth, minHeight, callback) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var image = new Image();
                image.src = e.target.result;
                image.onload = function() {
                    if (image.width < minWidth || image.height < minHeight) {
                        alert(`Image is too small! Minimum required size is ${minWidth} × ${minHeight} px.`);
                        callback(false); // Image size is invalid
                    } else {
                        callback(true, e.target.result); // Image is valid
                    }
                };
            };
            reader.readAsDataURL(file);
        }
    </script>

    <script>
        $(document).ready(function() {
            // When content is edited
            $('[contenteditable="true"]').on('blur', function() {
                $(this).addClass('edited'); // Mark as edited
            });
        });

        function saveChanges(cloneId, appendId, formId) {
            let fullContent = $(cloneId).clone();
            $(appendId).val(fullContent.html());

            // Prepare the form data and CSRF token
            let formData = new FormData($(formId)[0]);
            let actionUrl = $(formId).attr('action');

            $.ajax({
                url: actionUrl,
                method: "POST",
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                success: function(response) {
                    if (response.status === "success") {
                        notify(response.status, response.message);
                    }
                },
                error: function(xhr) {
                    notify('error', 'Failed to save changes.');
                }
            });
        }
    </script>
@endsection
