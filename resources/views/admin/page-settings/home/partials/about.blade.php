<!-- about Start -->
<section class="about-one section-space" id="about">
    <div class="container">
        <form action="{{ route('settings.homePageChange') }}" id="aboutFormSectionOne" method="POST"
              enctype="multipart/form-data">
            @csrf
            <div class="row gutter-y-60">
                <div class="col-lg-6 wow fadeInLeft" data-wow-duration="1500ms" data-wow-delay="00ms">
                    <div class="about-one__image-grid">

                        <div class="about-one__image">
                            <div class="image-container">
                                @php
                                    $home_one_image_one = $settings->where('key', 'home_one__image__one')->first();
                                @endphp
                                <img src="{{ $home_one_image_one ? asset($home_one_image_one->value) : asset('frontend/assets/images/about/about-1-3.png') }}"
                                     alt="about" class="about-one_image_one sec_1_prev_1">
                                <input type="file" class="image-upload home_sec_1_img_1 d-none"
                                       data-target="about-one_imageone" name="home_one__image__one">
                                <label class="upload-btn"
                                       onclick="setupImagePreview('.home_sec_1_img_1', '.sec_1_prev_1', '240', '240')">
                                    240 × 240 px <br>
                                    Upload
                                </label>
                            </div>
                            <div class="image-container">
                                @php
                                    $images = $settings->where('key', 'home_one__image__two')->first();
                                @endphp
                                <img src="{{ $images ? asset($images->value) : asset('frontend/assets/images/about/about-1-2.jpg') }}"
                                     alt="about" class="about-one_image_two sec_1_prev_2">


                                <input type="file" class="image-upload home_sec_1_img_2 d-none"
                                       data-target="about-one_imagetwo" name="home_one__image__two">
                                <label onclick="setupImagePreview('.home_sec_1_img_2', '.sec_1_prev_2','240', '347')"
                                       class="upload-btn">
                                    240 × 347 px <br>
                                    Upload
                                </label>
                            </div>
                        </div><!-- /.about-one__image -->


                        <div class="about-one__image">
                            <div class="image-container">
                                @php
                                    $images = $settings->where('key', 'home_one__image__three')->first();
                                @endphp
                                <img src="{{ $images ? asset($images->value) : asset('frontend/assets/images/about/about-1-1.jpg') }}"
                                     alt="about" class="about-one_image_three sec_1_prev_3">


                                <input type="file" class="image-upload home_sec_1_img_3 d-none"
                                       data-target="about-one_imagethree" name="home_one__image__three">
                                <label onclick="setupImagePreview('.home_sec_1_img_3', '.sec_1_prev_3','270', '617')"
                                       class="mt-3 upload-btn">
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
                    <textarea name="home_about_sec_1" class="d-none" id="about_one_content_one"></textarea>
                    <div class="about-one__content" id="about_content_one">
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
                                    At Melbourne Building Products, we’re dedicated to helping you transform your home
                                    or
                                    project into a masterpiece. Whether you’re updating a single room, renovating your
                                    entire
                                    house, or working on a large-scale construction project. Tiles company, also known
                                    as a
                                    tile
                                    manufacturer or
                                    distributor,
                                    specializes in the production and distribution of various types of tiles used for a
                                    wide
                                    range of applications. These companies play a crucial role in the construn and
                                    interior
                                    design industries by providing tiles for residential.</p><!-- /.about-one__text -->
                            </div><!-- /.about-one__content__text -->
                            <div class="about-one__button wow fadeInUp" data-wow-duration="1500ms"
                                 data-wow-delay="00ms">
                                <a href="{{ route('frontend.contact') }}" class="floens-btn">
                                    <span>get in touch</span>
                                    <i class="icon-right-arrow"></i>
                                </a><!-- /.floens-btn -->
                            </div><!-- /.about-one__button -->
                        @endif

                    </div><!-- /.about-one__content -->
                </div><!-- /.col-lg-6 -->
            </div><!-- /.row -->
        </form>
        <div class="mt-3 text-end">
            <button type="button" id="aboutButtonSectionOne"
                    onclick="saveChanges('#about_content_one', '#about_one_content_one', '#aboutFormSectionOne','#aboutButtonSectionOne')"
                    class="btn btn-primary">Save Changes
            </button>
        </div><!-- /.col-lg-6 -->
    </div><!-- /.container -->
    <div class="about-one__shapes">
        <img src="{{ asset('frontend') }}/assets/images/shapes/about-shape-1-1.jpg" alt="about-shape"
             class="about-one__shape about-one__shape--one" loading="lazy">
        <img src="{{ asset('frontend') }}/assets/images/shapes/about-shape-1-1.jpg" alt="about-shape"
             class="about-one__shape about-one__shape--two" loading="lazy">
    </div><!-- /.about-one__shapes -->
</section><!-- /.about-one section-space -->
<!-- about End -->