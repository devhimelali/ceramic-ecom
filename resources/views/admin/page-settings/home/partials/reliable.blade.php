<section class="reliable-one reliable-one--home section-space-bottom">
    <div class="container">
        <form action="{{ route('settings.homePageChange') }}" id="homeFormReliableSection" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="row gutter-y-60">
                <div class="col-lg-6">
                    <div class="reliable-one__content" id="home_reliable_one">
                        @php
                            $home_reliable_one_content = $settings->where('key', 'home_reliable_one_content')->first();
                        @endphp
                        @if ($home_reliable_one_content != null)
                            {!! $home_reliable_one_content->value !!}
                        @else
                            <div class="sec-title sec-title--border">

                                <h6 class="sec-title__tagline" contenteditable="true">reliable</h6>
                                <!-- /.sec-title__tagline -->

                                <h3 class="sec-title__title" contenteditable="true">We Provide Reliable Flooring
                                    Services
                                </h3>
                                <!-- /.sec-title__title -->
                            </div><!-- /.sec-title -->
                            <p class="reliable-one__text" contenteditable="true">Our vision is to provide innovative,
                                independent flooring
                                solutions
                                that problems for homes, industries, and workspaces, as well as flooring we would like
                                in
                                our own residences, work spaces,</p><!-- /.reliable-one__text -->
                            <div class="row align-items-center gutter-y-30">
                                <div class="col-xl-6 col-lg-12 col-md-5 col-sm-6">
                                    <div class="reliable-one_info reliable-one_info--one">
                                        <div class="reliable-one_info_icon">
                                            <span class="icon-smiley"></span>
                                        </div><!-- /.reliable-one_info_icon -->
                                        <div class="reliable-one_info_text">
                                            <h4 class="reliable-one_info_title" contenteditable="true">Happy clients
                                            </h4>
                                            <!-- /.reliable-one_info_title -->
                                            <h5 class="reliable-one_info_total" contenteditable="true">2.5M+</h5>
                                            <!-- /.reliable-one_info_total -->
                                        </div><!-- /.reliable-one_info_text -->
                                    </div><!-- /.reliable-one__info -->
                                </div><!-- /.col-xl-6 col-lg-12 col-md-5 col-sm-6 -->
                                <div class="col-xl-6 col-lg-12 col-md-5 col-sm-6">
                                    <div class="reliable-one_info reliable-one_info--two">
                                        <div class="reliable-one_info_icon">
                                            <span class="icon-cooperation"></span>
                                        </div><!-- /.reliable-one_info_icon -->
                                        <div class="reliable-one_info_text">
                                            <h4 class="reliable-one_info_title" contenteditable="true">Trusted
                                                partners
                                            </h4>
                                            <!-- /.reliable-one_info_title -->
                                            <h5 class="reliable-one_info_total" contenteditable="true">420+</h5>
                                            <!-- /.reliable-one_info_total -->
                                        </div><!-- /.reliable-one_info_text -->
                                    </div><!-- /.reliable-one__info -->
                                </div><!-- /.col-xl-6 col-lg-12 col-md-5 col-sm-6 -->
                            </div><!-- /.row -->
                            <a href="{{ route('frontend.contact') }}" class="floens-btn reliable-one__btn">
                                <span>get in touch</span>
                                <i class="icon-right-arrow"></i>
                            </a><!-- /.floens-btn reliable-one__btn -->
                        @endif
                    </div><!-- /.reliable-one__content -->
                    <textarea name="home_reliable_one_content" class="d-none" id="home_reliable_one_content"></textarea>
                </div><!-- /.col-lg-6 -->
                <div class="col-lg-6 wow fadeInRight" data-wow-duration="1500ms">
                    <div class="reliable-one__images">
                        <div class="reliable-one__image">
                            @php
                                $home_two_imageone = $settings->where('key', 'home_twoimage_one')->first();
                            @endphp
                            <img src="{{ $home_two_imageone ? asset($home_twoimage_one->value) : asset('frontend/assets/images/reliable/reliable-1-1.jpg') }}"
                                alt="reliable" class="reliable-one_image_one sec_2_prev_1">

                            <input type="file" class="image-upload home_sec_2_img_1 d-none"
                                data-target="about-one_imageone" name="home_twoimage_one">
                            <label class="upload-btn"
                                onclick="setupImagePreview('.home_sec_2_img_1', '.sec_2_prev_1', '338', '463')">
                                338 × 463 px <br>
                                Upload
                            </label>
                            <div class="reliable-one_image_inner">
                                @php
                                    $images = $settings->where('key', 'home_two_image_two')->first();
                                @endphp
                                <img src="{{ $images ? asset($images->value) : asset('frontend/assets/images/reliable/reliable-1-2.jpg') }}"
                                    alt="reliable" class="reliable-one_image_two sec_2_prev_2">

                                <input type="file" class="image-upload home_sec_2_img_2 d-none"
                                    data-target="about-one_imageone" name="home_twoimage_two">
                                <label class="upload-btn"
                                    onclick="setupImagePreview('.home_sec_2_img_2', '.sec_2_prev_2', '276', '463')">
                                    276 × 463 px <br>
                                    Upload
                                </label>


                            </div><!-- /.reliable-one_image_inner -->
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
        </form>
        <div class="mt-3 text-end">
            <button type="button" id="aboutButtonSectionTwo"
                onclick="saveChanges('#home_reliable_one', '#home_reliable_one_content', '#homeFormReliableSection','#aboutButtonSectionTwo')"
                class="btn btn-primary">Save Changes</button>
        </div>
    </div><!-- /.container -->
</section><!-- /.reliable-one section-space-bottom -->
