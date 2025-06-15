@php
    use App\Helpers\ImageUploadHelper;
@endphp
@extends('frontend.layouts.app')
@section('title', 'Home Page Settings')
@section('content')
    <!-- main slider start -->
    @include('admin.page-settings.home.partials.slider')
    <!-- main slider end -->

    <!-- about Start -->
    @include('admin.page-settings.home.partials.about')
    <!-- about End -->

    <!-- service start -->
    @include('admin.page-settings.home.partials.service')
    <!-- service end -->

    <!-- reliable start -->
    @include('admin.page-settings.home.partials.reliable')
    <!-- reliable end -->

    <!-- client carousel start -->
    <div class="client-carousel @@extraClassName">
        <div class="container">
            <div class="client-carousel_one floens-owl_carousel owl-theme owl-carousel"
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
                    <div class="client-carousel_one_item">
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
            <div class="p-4 modal-content">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
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
                        alert(`Image is too small!Minimum required size is ${minWidth} × ${minHeight}
                            px.`, 'error');
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

        function saveChanges(cloneId, appendId, formId, buttonId) {
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
                beforeSend: function() {
                    $(buttonId).prop('disabled', true);
                    $(buttonId).html(
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving.....'
                    )
                },
                success: function(response) {
                    if (response.status === "success") {
                        notify(response.status, response.message);
                    }
                },
                error: function(xhr) {
                    notify('error', 'Failed to save changes.');
                },
                complete: function() {
                    $(buttonId).prop('disabled', false);
                    $(buttonId).html('Save Changes');
                }
            });
        }
    </script>
@endsection
@section('page-style')
    <link rel="preload" as="image" href="{{ asset('frontend/assets/images/backgrounds/slider-1-1.webp') }}"
          type="image/webp" fetchpriority="high" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
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