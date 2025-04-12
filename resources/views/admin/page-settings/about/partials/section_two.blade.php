<section class="reliable-one @@extraClassName section-space-bottom">
    <div class="container">
        <form action="{{ route('settings.aboutPageChange') }}" id="aboutFormSectionTwo" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="row gutter-y-60">

                <div class="col-lg-6 wow fadeInLeft" data-wow-duration="1500ms">
                    <div class="reliable-one__images">
                        <div class="reliable-one__image">
                            @php
                                $about_two__image__one = $settings->where('key', 'about_two__image__one')->first();
                            @endphp
                            <img src="{{ $about_two__image__one ? asset($about_two__image__one->value) : asset('frontend/assets/images/reliable/reliable-2-1.jpg') }}"
                                alt="reliable" class="reliable-one__image__one sec_2_prev_1">


                            <input type="file" class="image-upload sec_2_img_1 d-none"
                                data-target="reliable-one__image__one" name="about_two__image__one">
                            <label class="upload-btn"
                                onclick="setupImagePreview('.sec_2_img_1', '.sec_2_prev_1', '338', '338')">
                                338 × 338 px <br>
                                Upload
                            </label>


                            <div class="reliable-one__image__inner">
                                @php
                                    $about_two__image__two = $settings->where('key', 'about_two__image__two')->first();
                                @endphp
                                <img src="{{ $about_two__image__two ? asset($about_two__image__two->value) : asset('frontend/assets/images/reliable/reliable-2-2.jpg') }}"
                                    alt="reliable" class="reliable-one__image__two sec_2_prev_2">

                                <input type="file" class="image-upload sec_2_img_2 d-none"
                                    data-target="reliable-one__image__two" name="about_two__image__two">
                                <label class="upload-btn"
                                    onclick="setupImagePreview('.sec_2_img_2', '.sec_2_prev_2', '338', '338')">
                                    338 × 338 px <br>
                                    Upload
                                </label>
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
                <textarea class="d-none" name="about_sec_2" id="about_one__content__two" cols="30" rows="10"></textarea>
                <div class="col-lg-6">
                    <div id="about_content__two" class="reliable-one__content">
                        @if (app_setting('about_sec_2'))
                            {!! app_setting('about_sec_2') !!}
                        @else
                            <div class="sec-title sec-title--border">

                                <h6 class="sec-title__tagline"contenteditable="true">reliable</h6>
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
                                our own residences, work spaces,
                            </p><!-- /.reliable-one__text -->
                        @endif
                    </div><!-- /.reliable-one__content -->
                </div><!-- /.col-lg-6 -->
            </div><!-- /.row -->
        </form>
        <div class="mt-5 text-end">
            <button type="button" id="aboutButtonSectionTwo"
                onclick="saveChanges('#about_content__two','#about_one__content__two','#aboutFormSectionTwo','#aboutButtonSectionTwo')"
                class="btn btn-primary">Save
                Changes</button>
        </div>

    </div><!-- /.container -->
</section><!-- /.reliable-one section-space-bottom -->
