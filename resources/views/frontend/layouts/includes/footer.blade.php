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
                            <img src="{{ app_setting('dark_logo') ?? app_setting('light_logo') }}" width="123"
                                alt="Floens HTML Template">
                        </a>
                        <p class="footer-widget__about-text">{{ app_setting('about_description') }}</p>
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
                            <li><a href="about.html">About Us</a></li>
                            <li><a href="services.html">Our Services</a></li>
                            <li><a href="team.html">Meet the Team</a></li>
                            <li><a href="blog-grid-right.html">Recent News</a></li>
                            <li><a href="contact.html">Contact</a></li>
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
                            <li><a href="https://www.google.com/maps">85 Ketch Harbour Road Bensal PA
                                    19020</a>
                            </li>
                            <li><span class="icon-paper-plane"></span> <a
                                    href="mailto:needhelp@company.com">needhelp@company.com</a></li>
                            <li><span class="icon-phone-call"></span> <a href="tel:+9156980036420">+91 5698
                                    0036
                                    420</a></li>
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
                            <a href="https://facebook.com/">
                                <i class="icon-facebook" aria-hidden="true"></i>
                                <span class="sr-only">Facebook</span>
                            </a>
                            <a href="https://twitter.com/">
                                <i class="icon-twitter" aria-hidden="true"></i>
                                <span class="sr-only">Twitter</span>
                            </a>
                            <a href="https://instagram.com/">
                                <i class="icon-instagram" aria-hidden="true"></i>
                                <span class="sr-only">Instagram</span>
                            </a>
                            <a href="https://youtube.com/">
                                <i class="icon-youtube" aria-hidden="true"></i>
                                <span class="sr-only">Youtube</span>
                            </a>
                        </div><!-- /.main-footer__social -->
                    </div><!-- /.col-md-5 -->
                    <div class="col-md-7 wow fadeInUp" data-wow-duration="1500ms" data-wow-delay="200ms">
                        <div class="main-footer__bottom__copyright">
                            <p class="main-footer__copyright">
                                &copy; Copyright <span class="dynamic-year"></span> by Floens HTML Template.
                            </p>
                        </div><!-- /.main-footer__bottom__copyright -->
                    </div><!-- /.col-md-7 -->
                </div><!-- /.row -->
            </div><!-- /.main-footer__inner -->
        </div><!-- /.container -->
    </div><!-- /.main-footer__bottom -->
</footer><!-- /.main-footer -->
