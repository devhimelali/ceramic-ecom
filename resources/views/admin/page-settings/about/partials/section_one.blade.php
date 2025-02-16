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
                                    class="upload-btn mt-3">
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
                                <a href="{{ route('frontend.contact') }}" class="floens-btn">
                                    <span>get in touch</span>
                                    <i class="icon-right-arrow"></i>
                                </a><!-- /.floens-btn -->
                            </div><!-- /.about-one__button -->
                        @endif
                    </div>
                </div><!-- /.col-lg-6 -->
            </div><!-- /.row -->
        </form>
        <div class="mt-3 text-end">
            <button type="button"
                onclick="saveChanges('#about_content__one', '#about_one__content__one', '#aboutFormSectionOne')"
                class="btn btn-primary">Save Changes</button>
        </div>
    </div><!-- /.container -->
    <div class="about-one__shapes">
        <img src="{{ asset('frontend') }}/assets/images/shapes/about-shape-1-1.jpg" alt="about-shape"
            class="about-one__shape about-one__shape--one">
        <img src="{{ asset('frontend') }}/assets/images/shapes/about-shape-1-1.jpg" alt="about-shape"
            class="about-one__shape about-one__shape--two">
    </div><!-- /.about-one__shapes -->
</section><!-- /.about-one section-space -->
