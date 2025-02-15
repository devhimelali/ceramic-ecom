<footer class="main-footer">
    <div class="main-footer__bg"
        style="background-image: url({{ asset('frontend') }}/assets/images/shapes/footer-bg-1-1.png);">
    </div>
    <!-- /.main-footer__bg -->
    <div class="main-footer__top">
        <div class="container">
            <div class="row">
                <div class="col-xl-4 col-lg-6 wow fadeInUp" data-wow-duration="1500ms" data-wow-delay="00ms">
                    <div class="footer-widget footer-widget--about">
                        <a href="index.html" class="footer-widget__logo">
                            <img src="{{ $settings->where('key', 'dark_logo')->first()->value ?? '#' }}" width="123"
                                alt="Logo">
                        </a>
                        <p class="footer-widget__about-text">{{ $settings->where('key', 'about_description')->first()->value ?? 'N/A' }}</p>
                        <div class="mc-form__response"></div><!-- /.mc-form__response -->
                    </div><!-- /.footer-widget -->
                </div><!-- /.col-xl-4 col-lg-6 -->
                <div class="col-xl-2 col-lg-3 col-md-3 col-sm-6 wow fadeInUp" data-wow-duration="1500ms"
                    data-wow-delay="200ms">
                    <div class="footer-widget footer-widget--links footer-widget--links-one">
                        <div class="footer-widget__top">
                            <div class="footer-widget__title-box"></div><!-- /.footer-widget__title-box -->
                            <h2 class="footer-widget__title">Explore</h2><!-- /.footer-widget__title -->
                        </div><!-- /.footer-widget__top -->
                        <ul class="list-unstyled footer-widget__links">
                            <li><a href="{{route('frontend.aboutUs')}}">About Us</a></li>
                            <li><a href="{{route('frontend.contact')}}">Contact</a></li>
                        </ul><!-- /.list-unstyled footer-widget__links -->
                    </div><!-- /.footer-widget -->
                </div><!-- /.col-xl-2 col-lg-3 col-md-3 col-sm-6 -->
                <div class="col-xl-3 col-lg-6 col-md-5 wow fadeInUp" data-wow-duration="1500ms" data-wow-delay="600ms">
                    <div class="footer-widget footer-widget--contact">
                        <div class="footer-widget__top">
                            <div class="footer-widget__title-box"></div><!-- /.footer-widget__title-box -->
                            <h2 class="footer-widget__title">Get inTouch</h2><!-- /.footer-widget__title -->
                        </div><!-- /.footer-widget__top -->
                        <ul class="list-unstyled footer-widget__info">
                            <li><a href="javascript:void(0);">{{ $settings->where('key', 'contact_address')->first()->value ?? 'N/A' }}</a>
                            </li>
                            <li><span class="icon-paper-plane"></span> <a
                                    href="mailto:{{ $settings->where('key', 'contact_email')->first()->value ?? '#' }}">{{ $settings->where('key', 'contact_email')->first()->value ?? 'N/A' }}</a>
                            </li>
                            <li><span class="icon-phone-call"></span> <a
                                    href="tel:{{ $settings->where('key', 'contact_phone')->first()->value ?? '#' }}">{{ $settings->where('key', 'contact_phone')->first()->value ?? 'N/A' }}</a>
                            </li>
                        </ul><!-- /.list-unstyled -->
                    </div><!-- /.footer-widget -->
                </div><!-- /.col-xl-3 col-lg-6 col-md-5 -->
            </div><!-- /.row -->
        </div><!-- /.container -->
    </div><!-- /.main-footer__top -->
    <div class="main-footer__bottom">
        <div class="container">
            <div class="main-footer__bottom__inner">
                <div class="row gutter-y-30 align-items-center">
                    <div class="col-md-5 wow fadeInUp" data-wow-duration="1500ms" data-wow-delay="000ms">
                        <div class="main-footer__social floens-social">
                            <a href="{{ $settings->where('key', 'facebook_link')->first()->value ?? '#' }}">
                                <i class="icon-facebook" aria-hidden="true"></i>
                                <span class="sr-only">Facebook</span>
                            </a>
                            <a href="{{ $settings->where('key', 'twitter_link')->first()->value ?? '#' }}">
                                <i class="icon-twitter" aria-hidden="true"></i>
                                <span class="sr-only">Twitter</span>
                            </a>
                            <a href="{{ $settings->where('key', 'instagram_link')->first()->value ?? '#' }}">
                                <i class="icon-instagram" aria-hidden="true"></i>
                                <span class="sr-only">Instagram</span>
                            </a>
                            <a href="{{ $settings->where('key', 'youtube_link')->first()->value ?? '#' }}">
                                <i class="icon-youtube" aria-hidden="true"></i>
                                <span class="sr-only">Youtube</span>
                            </a>
                        </div><!-- /.main-footer__social -->
                    </div><!-- /.col-md-5 -->
                    <div class="col-md-7 wow fadeInUp" data-wow-duration="1500ms" data-wow-delay="200ms">
                        <div class="main-footer__bottom__copyright">
                            <p class="main-footer__copyright">
                                &copy; {{ $settings->where('key', 'copy_right')->first()->value ?? 'N/A' }}
                            </p>
                        </div><!-- /.main-footer__bottom__copyright -->
                    </div><!-- /.col-md-7 -->
                </div><!-- /.row -->
            </div><!-- /.main-footer__inner -->
        </div><!-- /.container -->
    </div><!-- /.main-footer__bottom -->
</footer><!-- /.main-footer -->

<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasRightLabel">Shopping cart</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">

    </div>
</div>

{{-- Common Modal --}}
<div id="commonModal" class="modal fade show" tabindex="-1" aria-labelledby="myModalLabel" aria-modal="true"
    role="dialog">
    <div class="modal-dialog">
        <div class="modal-content p-4">
            <div class="modal-header">
                <h5 class="modal-title">Product Enquire</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
            </div>
            <form action="" method="post" id="modalForm">
                @csrf
                <div class="contentWrapper p-3"></div>
                <div class="modal-footer">
                    <button type="button" class="floens-btn product__item__link mb-3 bg-danger p-3 rounded"
                        data-bs-dismiss="modal"><span>Close</span>
                    </button>

                    <button type="submit"
                        class="floens-btn product__item__link mb-3 p-3 rounded enquireSubmitBtn"><span>Submit</span>
                    </button>
                </div>
            </form>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

