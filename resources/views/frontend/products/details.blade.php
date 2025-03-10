@php
    use App\Helpers\ImageUploadHelper;
@endphp
@extends('frontend.layouts.app')
@section('title', $product->name)
@section('content')
    <section class="page-header">
        <div class="page-header__bg"
            style="background-image: url('{{ asset('frontend') }}/assets//images/backgrounds/page-header-bg-1-1.png');">
        </div>
        <!-- /.page-header__bg -->
        <div class="container">
            <h2 class="page-header__title">{{ $product->name }}</h2>
            <ul class="floens-breadcrumb list-unstyled">
                <li><i class="text-white icon-home"></i> <a href="{{ route('frontend.home') }}">Home</a></li>
                <li><span class="text-white">shop</span></li>
                <li><span class="text-white">{{ $product->name }}</span></li>
            </ul><!-- /.thm-breadcrumb list-unstyled -->
        </div><!-- /.container -->
    </section><!-- /.page-header -->

    <section class="product-details section-space">
        <div class="container">
            <!-- /.product-details -->
            <div class="row gutter-y-50">
                <div class="col-lg-6 col-xl-6 wow fadeInLeft" data-wow-delay="200ms">
                    <div class="product-details__img">
                        <div class="swiper product-details__gallery-top">
                            <div class="swiper-wrapper">
                                @php
                                    $images = $product
                                        ->images()
                                        ->whereIn('type', ['gallery', 'thumbnail'])
                                        ->get();
                                @endphp
                                @forelse ($images as $image)
                                    <div class="swiper-slide">
                                        <img src="{{ ImageUploadHelper::getProductImageUrl($image->image) }}"
                                            alt="product details image" class="product-details__gallery-top__img">
                                    </div>
                                @empty
                                    <div class="swiper-slide">
                                        <img src="{{ asset('frontend/assets/images/product-placeholder.png') }}"
                                            alt="product details image" class="product-details__gallery-top__img">
                                    </div>
                                @endforelse
                            </div>
                        </div>
                        <div class="swiper product-details__gallery-thumb">
                            <div class="swiper-wrapper">
                                @foreach ($images as $image)
                                    <div class="product-details__gallery-thumb-slide swiper-slide">
                                        <img src="{{ ImageUploadHelper::getProductImageUrl($image->image) }}"
                                            alt="product details thumb" class="product-details__gallery-thumb__img">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div><!-- /.column -->
                <div class="col-lg-6 col-xl-6 wow fadeInRight" data-wow-delay="300ms">
                    <div class="product-details__content">
                        <div class="product-details__excerpt">
                            <h3 class="product-details__excerpt__text1">
                                {{ $product->name ?? 'No Name' }}
                            </h3>
                        </div><!-- /.excerp-text -->
                        <div class="product-details__excerpt">
                            <p class="product-details__excerpt__text1">
                                {{ $product->short_description ?? 'No Description' }}
                            </p>
                        </div><!-- /.excerp-text -->
                        <div class="mt-3">
                            @foreach ($attributes as $group)
                                <div class="mb-3 row" id="variation_{{ Str::slug($group['attribute']) }}">
                                    <div class="col-12">
                                        <h6 class="mb-2">{{ $group['attribute'] }}:</h6>
                                        <div class="flex-wrap gap-2 d-flex">
                                            @foreach ($group['values'] as $value)
                                                <span class="p-2 badge bg-secondary">{{ $value }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="product-details__buttons">
                            <div class="d-flex align-items-center justify-content-center">
                                <a href="javascript:void(0);"
                                    class="p-3 floens-btn product__item__link me-2 custom-button enquireBtn"
                                    data-id="{{ $product->id }}"
                                    data-url="{{ route('enquireForm', $product->id) }}">Enquire</a>

                                <a href="javascript:void(0);"
                                    class="p-4 floens-btn product__item__link me-2 custom-button addCartItemBtn addToCartBtn"
                                    data-product-id="{{ $product->id }}"
                                    data-url="{{ route('add.to.cart.form', $product->id) }}">
                                    <i style='font-size:17px; right: 15px' class='fas'>&#xf217;</i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="product-details__description-wrapper">
            <div class="container">
                <!-- /.product-description -->
                <div class="product-details__description">
                    <h3 class="product-details__description__title">product Description</h3>
                    <div class="product-details__text__box wow fadeInUp" data-wow-delay="300ms">
                        <p class="product-details__description__text">
                            {!! $product->description !!}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Products End -->
@endsection
@section('page-script')
    <script>
        $(document).ready(function() {
            displayCartItems();
            $('.enquireBtn').click(function() {
                var productId = $(this).data('id');
                var url = $(this).data('url');
                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function(response) {
                        $('#enquireFormResponse').html(response.html);
                        $('#myModal').modal('show');
                    }
                })
            });

            $('.addToCartBtn').click(function() {
                var productId = $(this).data('product-id');
                var url = $(this).data('url');
                // $('#addToCartModal').modal('show');
                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function(response) {
                        $('#addToCartResponse').html(response.html);
                        $('#addToCartModal').modal('show');
                    }
                })
            });

            $('#enquireForm').submit(function(e) {
                e.preventDefault();
                var formData = $('#enquireForm').serialize();
                $.ajax({
                    url: "{{ route('enquire') }}",
                    method: 'POST',
                    data: formData,
                    beforeSend: function() {
                        $('.enquireSubmitBtn').prop('disabled', true);
                        $('.enquireSubmitBtn').html(
                            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending...'
                        );
                    },
                    success: function(response) {
                        $('.enquireSubmitBtn').prop('disabled', false);
                        $('.enquireSubmitBtn').html('Submit');
                        if (response.status == 'success') {
                            notify(response.status, response.message);
                            $('#enquireForm')[0].reset();
                            $('#myModal').modal('hide');
                        }

                    },
                    error: function(xhr, status, error) {
                        $('.enquireSubmitBtn').prop('disabled', false);
                        $('.enquireSubmitBtn').html('Submit');
                        let errors = xhr.responseJSON.errors;
                        if (errors) {
                            $.each(errors, function(key, value) {
                                let inputField = $('[name="' + key + '"]');
                                inputField.addClass('is-invalid');
                                notify('error', value[0]);
                            });
                        }
                    }
                });
            });
        });
    </script>
@endsection
@section('page-style')
    <style>
        .product-details__description figure table {
            width: 100%;
            padding: 20px !important;
            display: block;
            background: #fff;
        }

        .product-details__gallery-top__img {
            height: 521px;
        }

        .floens-breadcrumb li:not(:last-of-type)::after {
            color: #fff;
        }

        .section-space {
            padding-top: var(--section-space, 120px);
            padding-bottom: 0;
        }
    </style>
@endsection
