@php
    use App\Helpers\ImageUploadHelper;
@endphp
@extends('frontend.layouts.app')
@section('page-style')
    <style>
        /* Style the submit button */
        .custom-button {
            /* width: 100%; */
            padding: 10px;
            border: none;
            background: var(--floens-base, #C7844F);
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        .custom-button:hover {
            background: #9a6e4b;
        }

        .enquireBtn {
            width: 70%;
        }

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
            z-index: 99;
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

        .sec_2_prev_1 {
            width: 338px;
            height: 463px
        }

        .sec_2_prev_2 {
            width: 276px;
            height: 463px
        }

        @media screen and (max-width: 480px) {
            .sec_1_prev_3 {
                height: 324px !important;
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
    <!-- main slider start -->
    @include('admin.page-settings.home.partials.slider')
    <!-- main slider end -->

    <!-- about Start -->
    @include('admin.page-settings.home.partials.about')
    <!-- about End -->



    <!-- services info start -->
    <section class="services-one__info mt-3">
        <div class="container">
            <div class="services-one__info__inner">
                <div class="services-one__info__bg"
                    style="background-image: url({{ asset('frontend') }}/assets/images/backgrounds/services-info-bg-1.png);">
                </div>
                <!-- /.services-one__info__bg -->
                <div class="row gutter-y-40 align-items-center">
                    <div class="col-lg-6">
                        <div class="services-one__info__left">
                            <h3 class="services-one__info__title">Get a Professional Services</h3>
                            <!-- /.services-one__info__title -->
                            <p class="services-one__info__text">Laminate flooring is a type of synthetic flooring
                                that
                                designed like hardwood, tile, or other natural materials</p>
                            <!-- /.services-one__info__text -->
                        </div><!-- /.services-one__info__left -->
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
                <div class="services-one__info__shape-one"></div><!-- /.services-one__info__shape-one -->
                <div class="services-one__info__shape-two"></div><!-- /.services-one__info__shape-two -->
            </div><!-- /.services-one__info__inner -->
        </div><!-- /.container -->
    </section><!-- /.services-one__info -->
    <!-- services info end -->

    <!-- reliable start -->
    @include('admin.page-settings.home.partials.reliable')
    <!-- reliable end -->

    <!-- shop start -->
    <section class="product-home">
        <div class="product-home__bg"
            style="background-image: url({{ asset('frontend') }}/assets/images/backgrounds/shop-bg-1.png);">
        </div>
        <!-- /.product-home__bg -->
        <div class="container">
            <div class="sec-title sec-title--center">

                <h6 class="sec-title__tagline">our shop</h6><!-- /.sec-title__tagline -->

                <h3 class="sec-title__title">Let’s Explore Latest <br> Product in Shop</h3>
                <!-- /.sec-title__title -->
            </div><!-- /.sec-title -->


            <div class="row gutter-y-30">
                @foreach ($products as $product)
                    <div class="col-xl-3 col-lg-4 col-md-6 ">
                        <div class="product__item wow fadeInUp" data-wow-duration='1500ms' data-wow-delay='000ms'>
                            <div class="product__item__image">
                                @php
                                    $images = $product->images->where('type', 'thumbnail')->first();
                                @endphp
                                <img src="{{ ImageUploadHelper::getProductImageUrl($images?->image) }}"
                                    alt="Natural Stone Tiles">
                            </div><!-- /.product-image -->
                            <div class="product__item__content">
                                <h4 class="product__item__title"><a href="#">{{ Str::limit($product->name, 15) }}</a>
                                </h4><!-- /.product-title -->
                                <div class="product__item__price">{{ env('CURRENCY_SYMBOL') }}{{ $product->price }}</div>

                                <div class="d-flex align-items-center justify-content-center">
                                    <a href="javascript:void(0);"
                                        class="floens-btn product__item__link me-2 custom-button p-3 enquireBtn"
                                        data-id="{{ $product->id }}"
                                        data-url="{{ route('enquireForm', $product->id) }}">Enquire</a>

                                    <a href="javascript:void(0);"
                                        class="floens-btn product__item__link me-2 custom-button p-4 addCartItemBtn"
                                        data-product="{{ $product }}">
                                        <i style='font-size:17px; right: 15px' class='fas'>&#xf217;</i></a>
                                </div>



                            </div><!-- /.product-content -->
                        </div><!-- /.product-item -->
                    </div><!-- /.col-md-6 col-lg-4 -->
                @endforeach
            </div><!-- /.row -->
        </div><!-- /.container -->
    </section><!-- /.product-home -->
    <!-- shop end -->


    <!-- client carousel start -->
    <div class="client-carousel @@extraClassName">
        <div class="container">
            <div class="client-carousel__one floens-owl__carousel owl-theme owl-carousel"
                data-owl-options='{
                    "items": 5,
                    "margin": 65,
                    "smartSpeed": 700,
                    "loop":true,
                    "autoplay": 6000,
                    "nav":false,
                    "dots":false,
                    "navText": ["<span class=\"fa fa-angle-left\"></span>","<span class=\"fa fa-angle-right\"></span>"],
                    "responsive":{
                        "0":{
                            "items": 2,
                            "margin": 30
                        },
                        "500":{
                            "items": 3,
                            "margin": 40
                        },
                        "768":{
                            "items": 4,
                            "margin": 50
                        },
                        "992":{
                            "items": 5,
                            "margin": 70
                        },
                        "1200":{
                            "items": 6,
                            "margin": 149
                        }
                    }
                    }'>
                @foreach ($brands as $barand)
                    <div class="client-carousel__one__item">
                        <img src="{{ $barand->image ? asset($barand->image) : asset('assets/placeholder-image-2.png') }}"
                            alt="brand">
                    </div><!-- /.owl-slide-item-->
                @endforeach
            </div><!-- /.thm-owl__slider -->
        </div><!-- /.container -->
    </div><!-- /.client-carousel -->
    <!-- client carousel end -->
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
@endsection
@section('page-script')
    <script>
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
            // console.log(fullContent.html());
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
