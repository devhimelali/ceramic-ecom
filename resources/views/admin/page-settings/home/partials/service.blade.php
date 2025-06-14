<!-- services info start -->
<section class="mt-3 services-one__info">
    <div class="container">
        <form action="{{ route('settings.homePageChange') }}" id="homeFormServiceSection" method="POST"
              enctype="multipart/form-data">
            @csrf
            <div class="services-one__info__inner">
                <div class="services-one__info__bg"
                     style="background-image: url({{ asset('frontend') }}/assets/images/backgrounds/services-info-bg-1.png);">
                </div>
                <!-- /.services-one__info__bg -->
                <div class="row gutter-y-40 align-items-center">
                    <div class="col-lg-6" id="service_one_content">
                        @php
                            $home_service_one_content = $settings->where('key', 'home_service_one_content')->first();
                        @endphp
                        @if ($home_service_one_content != null)
                            {!! $home_service_one_content->value !!}
                        @else
                        <div class="services-one__info__left">
                            <h3 class="services-one__info__title" contenteditable="true">Get a Professional Services</h3>
                            <!-- /.services-one__info__title -->
                            <p class="services-one__info__text" contenteditable="true">Laminate flooring is a type of synthetic flooring
                                that
                                designed like hardwood, tile, or other natural materials</p>
                            <!-- /.services-one__info__text -->
                        </div><!-- /.services-one__info__left -->
                        @endif
                    </div><!-- /.col-lg-6 -->
                    <div class="col-lg-6">
                        <div class="services-one__info__right">
                            <div class="services-one__info__right__inner">
                                <div class="services-one__info__icon">
                                    <span class="icon-telephone"></span>
                                </div><!-- /.services-one__info__icon -->
                                <a href="tel:{{ $settings->where('key', 'contact_phone')->first()->value ?? '#' }}"
                                   class="services-one__info__number">{{ $settings->where('key', 'contact_phone')->first()->value ?? 'N/A' }}</a>
                                <!-- /.services-one__info__number -->
                            </div><!-- /.services-one__info__right__inner -->
                        </div><!-- /.services-one__info__right -->
                    </div><!-- /.col-lg-6 -->
                </div><!-- /.row -->
                <textarea name="home_service_one_content" class="d-none" id="home_service_one_content"></textarea>
                <div class="services-one__info__shape-one"></div><!-- /.services-one__info__shape-one -->
                <div class="services-one__info__shape-two"></div><!-- /.services-one__info__shape-two -->
            </div><!-- /.services-one__info__inner -->
        </form>
        <div class="mt-2 mb-3 text-end">
            <button type="button" id="aboutButtonSectionThree"
                    onclick="saveChanges('#service_one_content', '#home_service_one_content', '#homeFormServiceSection','#aboutButtonSectionThree')"
                    class="btn btn-primary">Save Changes
            </button>
        </div>
    </div><!-- /.container -->
</section><!-- /.services-one__info -->
<!-- services info end -->