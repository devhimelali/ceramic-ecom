<footer class="main-footer">
    <div class="main-footer__bg"
        style="background-image: url({{ asset('frontend') }}/assets/images/shapes/footer-bg-1-1.png);">
    </div>
    <!-- /.main-footer__bg -->
    <div class="main-footer__top">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-6 wow fadeInUp" data-wow-duration="1500ms" data-wow-delay="00ms">
                    <div class="footer-widget footer-widget--about">
                        <a href="{{ route('frontend.home') }}" class="footer-widget__logo">
                            @php
                                $app_logo = $settings->where('key', 'dark_logo')->first();
                            @endphp
                            <img src="{{ $app_logo ? asset('assets/images/settings/' . $app_logo->value) : '#' }}"
                                width="123" alt="Logo">
                        </a>
                        <p class="footer-widget__about-text">
                            {{ $settings->where('key', 'about_description')->first()->value ?? 'N/A' }}</p>
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
                            <li><a href="{{ route('frontend.aboutUs') }}">About Us</a></li>
                            <li><a href="{{ route('frontend.contact') }}">Contact</a></li>
                            <li><a href="{{ route('term.and.condition') }}">Terms & Conditions</a></li>
                            <li><a href="{{ route('privacy.policy') }}">Privacy Policy</a></li>
                        </ul><!-- /.list-unstyled footer-widget__links -->
                    </div><!-- /.footer-widget -->
                </div><!-- /.col-xl-2 col-lg-3 col-md-3 col-sm-6 -->
                <div class="col-xl-4 col-lg-6 col-md-5 wow fadeInUp" data-wow-duration="1500ms" data-wow-delay="600ms">
                    <div class="footer-widget footer-widget--contact">
                        <div class="footer-widget__top">
                            <div class="footer-widget__title-box"></div><!-- /.footer-widget__title-box -->
                            <h2 class="footer-widget__title">Get inTouch</h2><!-- /.footer-widget__title -->
                        </div><!-- /.footer-widget__top -->
                        <ul class="list-unstyled footer-widget__info">
                            <li><a href="javascript:void(0);"> <span class="icon-location"></span>
                                    {{ $settings->where('key', 'contact_address')->first()->value ?? 'N/A' }}</a>
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
                            <a href="{{ $settings->where('key', 'threads_link')->first()->value ?? '#' }}">
                                <i class="fa-brands fa-threads text-white"></i>
                                <span class="sr-only">Threads</span>
                            </a>
                            <a href="{{ $settings->where('key', 'instagram_link')->first()->value ?? '#' }}">
                                <i class="icon-instagram" aria-hidden="true"></i>
                                <span class="sr-only">Instagram</span>
                            </a>
                            <a href="{{ $settings->where('key', 'tiktok_link')->first()->value ?? '#' }}">
                                <i class="fa-brands fa-tiktok text-white"></i>
                                <span class="sr-only">Tiktok</span>
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

{{-- <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasRightLabel">Shopping cart</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body d-flex flex-column">
        <div class="offcanvas__top flex-grow-1">
            <div class="offcanvas__cart-products">
                <div class="offcanvas__cart-product">
                    <p class="no-items-message">Your cart is empty</p>
                    <div class="offcanvas__cart-product__content__wrapper">
                    </div>
                </div>
            </div>
        </div>
        <div class="offcanvas__bottom">
            <div class="offcanvas__total">
                <span class="offcanvas__total-text">Subtotal:</span>
                <span class="offcanvas__total-price">$100.00</span>
            </div>
            <a href="javascript:void(0);" class="floens-btn cart-page__checkout-btn checkoutBtn"
                data-bs-dismiss="offcanvas" aria-label="Close">Procced to checkout
                <i class="icon-right-arrow"></i></a>
        </div>
    </div>
</div> --}}
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasRightLabel">Shopping Cart</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body d-flex flex-column">
        <div class="offcanvas__top flex-grow-1">
            <!-- Empty cart container -->
            <div class="offcanvas__cart-empty-container" style="display: none;">
                <p class="no-items-message">Your cart is empty</p>
            </div>
            <div class="offcanvas__cart-products">
                <!-- Cart items will be dynamically injected here -->
            </div>
        </div>
        <div class="offcanvas__bottom" style="display: none;">
            <div class="offcanvas__total">
                <span class="offcanvas__total-text">Subtotal:</span>
                <span class="offcanvas__total-price">$0.00</span>
            </div>
            <a href="javascript:void(0);" class="floens-btn cart-page__checkout-btn checkoutBtn"
                data-bs-dismiss="offcanvas" aria-label="Close">Proceed to Checkout
                <i class="icon-right-arrow"></i></a>
        </div>
    </div>
</div>

<style>
    p.no-items-message {
        width: 100%;
        flex-basis: inherit;
        text-align: center;
        height: 50VH;
        transform: translatey(50%);
    }

    .offcanvas__cart-product {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-bottom: 20px;
    }

    .offcanvas__cart-product__content__wrapper {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .offcanvas__cart-product__image {
        max-width: 80px;
        width: 100%;
        overflow: hidden;
    }

    .offcanvas__cart-product__image img {
        width: 100%;
    }

    h3.offcanvas__cart-product__title {
        font-size: 16px;
    }

    span.offcanvas__cart-product__variation {
        font-size: 12px;
    }

    span.offcanvas__cart-product__quantity {
        font-size: 14px;
    }

    span.variation-item {
        font-size: 12px;
    }

    a.offcanvas__cart-product__remove {
        display: block;
        font-size: 16px;
        color: red;
        text-align: right;
    }

    .offcanvas__total {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    span.offcanvas__total-text,
    span.offcanvas__total-price {
        font-size: 25px;
        font-weight: 800;
    }

    a.thm-btn.offcanvas__btn.w-100 {
        display: block;
        text-align: center;
        background: var(--floens-base);
        color: #fff;
        padding: 10px 0;
    }

    .footer-widget--links-one {
        position: relative;
        right: 0px;
        padding-left: 0px;
    }

    @media (max-width: 767px) {
        .offcanvas__cart-product__content__wrapper {
            gap: 10px !important;
        }

        .offcanvas__cart-product__image {
            max-width: 60px !important;
        }

        span.offcanvas__total-text,
        span.offcanvas__total-price {
            font-size: 20px !important;
            font-weight: 700 !important;
        }
    }
</style>

<!-- Default Modals -->
<div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
    style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content p-4">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Product Enquiry</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
            </div>
            <div id="enquireFormResponse"></div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div id="addToCartModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
    style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content p-4">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Add To Card</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
            </div>
            <div id="addToCartResponse"></div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div id="checkoutModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
    style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content p-4">
            <div class="modal-header">
                <h5 class="modal-title" id="checkoutModalLabel">Products Enquiry Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
            </div>
            <form action="" method="post" id="checkoutForm">
                @csrf
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name">Your Name</label>
                            <input type="text" id="name" name="name" placeholder="Enter your name">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" placeholder="Enter your email">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" name="phone" id="phone" placeholder="Enter your phone">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea name="message" id="message" placeholder="Enter your message"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="floens-btn product__item__link mb-3 bg-danger p-3 rounded"
                        data-bs-dismiss="modal"><span>Close</span>
                    </button>

                    <button type="submit"
                        class="floens-btn product__item__link mb-3 p-3 rounded checkoutSubmitBtn"><span>Submit</span>
                    </button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
    $(document).ready(function() {
        $('.checkoutBtn').click(function() {
            $('#checkoutModal').modal('show');
        });

        $('#checkoutForm').submit(function(e) {
            e.preventDefault();

            var formData = new FormData($('#checkoutForm')[0]); // ✅ Use FormData
            var cartItems = JSON.parse(localStorage.getItem('cart') || '[]');

            formData.append('cartItems', JSON.stringify(cartItems)); // ✅ Append JSON

            $.ajax({
                url: "{{ route('submit.cart') }}",
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $('.checkoutSubmitBtn').prop('disabled', true).html(
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending...'
                    );
                },
                success: function(response) {
                    $('.checkoutSubmitBtn').prop('disabled', false).html('Submit');
                    if (response.status == 'success') {
                        notify('success', response.message);
                        $('#checkoutModal').modal('hide');
                        localStorage.removeItem('cart');
                        location.reload();
                    }
                },
                error: function(xhr) {
                    $('.checkoutSubmitBtn').prop('disabled', false).html('Submit');
                    console.log(xhr.responseText);
                    notify('error', 'Something went wrong. Please try again.');
                }
            });
        });

    });
</script>
<style>
    .form-group {
        margin-bottom: 20px;
        position: relative;
    }

    /* Style the labels */
    .form-group label {
        font-size: 14px;
        font-weight: bold;
        color: #333;
        display: block;
        margin-bottom: 5px;
    }

    /* Style the input fields */
    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 10px;
        font-size: 14px;
        border: none;
        border-bottom: 2px solid #b2835e;
        outline: none;
        background: transparent;
        color: #333;
    }

    /* Style the textarea separately */
    .form-group textarea {
        resize: none;
        height: 80px;
        background: #f6f3ef;
    }

    .attribute_list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        align-items: center;
    }
</style>
