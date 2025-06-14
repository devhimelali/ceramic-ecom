@extends('frontend.layouts.app')
@section('title', $product->name)
@section('content')
    <section class="page-header">
        <div class="page-header__bg"
             style="background-image: url('{{ asset('frontend/assets/images/backgrounds/page-header-bg-1-1.png') }}');">
        </div>
        <!-- /.page-header__bg -->
        <div class="container">
            <ul class="floens-breadcrumb list-unstyled">
                <li><i class="text-white icon-home"></i> <a href="{{ route('frontend.home') }}">Home</a></li>
                <li><span class="text-white">shop</span></li>
                <li><span class="text-white">{{ $product->name }}</span></li>
            </ul>
        </div>
    </section>

    <section class="product-details section-space">
        <div class="container">
            <!-- /.product-details -->
            <div class="row gutter-y-50">
                @php
                    $productImages = $product->images;
                    $variantImages = $product->variations->flatMap(function ($variation) {
                        return $variation->images;
                    });

                    $images = $productImages->merge($variantImages);
                @endphp
                <div class="col-lg-6 col-xl-6 wow fadeInLeft product-wrapper" data-wow-delay="200ms">
                    <div class="product-details__img">
                        <style>

                        </style>
                        <div class="swiper product-details__gallery-top">
                            <div class="swiper-wrapper">
                                @foreach ($images as $image)
                                    <div class="swiper-slide">
                                        <img src="{{ asset($image->path) }}" class="product-details__gallery-top__img">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="swiper product-details__gallery-thumb">
                            <div class="swiper-wrapper">
                                @foreach ($images as $image)
                                    @php
                                        $imageable_id = $image->imageable_id;
                                        $imageable_type = $image->imageable_type;
                                        $string = $imageable_type . '-' . $imageable_id;
                                    @endphp
                                    <div class="swiper-slide product-details__gallery-thumb-slide"
                                         data-image-id="{{ $imageable_id }}">
                                        <img src="{{ asset($image->path) }}"
                                             class="product-details__gallery-thumb__img">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-xl-6 wow fadeInRight" data-wow-delay="300ms">
                    <div class="product-details__content">
                        <div class="product-details__excerpt d-none d-md-block">
                            <h3 class="product-details__excerpt__text1">
                                {{ $product->name ?? 'No Name' }}
                            </h3>
                        </div>
                        <div class="product-details__excerpt d-none d-md-block">
                            <p class="product-details__excerpt__text1">
                                {!! nl2br($product->short_description) !!}
                            </p>
                        </div>
                        <div class="mt-3">
                            @foreach ($attributes as $group)
                                <div class="mb-3 row" id="variation_{{ Str::slug($group['attribute']) }}">
                                    <div class="col-12">
                                        <h6 class="mb-2">{{ $group['attribute'] }}:</h6>
                                        <div class="flex-wrap gap-2 d-flex">
                                            @foreach ($group['values'] as $value)
                                                <label class="attribute-option">
                                                    <input type="radio" class="attribute-input d-none"
                                                           name="{{ $group['attribute'] }}"
                                                           data-attribute="{{ $group['attribute'] }}"
                                                           value="{{ $value }}">
                                                    <span class="badge bg-secondary">{{ $value }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div id="price-wrapper-ditails">
                            @if ($product->sale_price && $product->regular_price > 0)
                                <span class="price"
                                      style="text-decoration: line-through; color: red; margin-right: 6px;">${{ $product->regular_price }}</span>
                                <span class="price">${{ $product->sale_price ?? $product->regular_price }}</span>
                            @else
                                <span class="price">${{ $product->regular_price ?? $product->regular_price }}</span>
                            @endif

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
                        <!-- Mobile only: keep original position -->
                        <div class="product-details__excerpt d-block d-md-none">
                            <h3 class="product-details__excerpt__text1">
                                {{ $product->name ?? 'No Name' }}
                            </h3>
                        </div>
                        <div class="product-details__excerpt d-block d-md-none">
                            <p class="product-details__excerpt__text1">
                                {!! nl2br($product->short_description) !!}
                            </p>
                        </div>


                    </div>
                </div>
            </div>
        </div>

        <div class="product-details__description-wrapper">
            <div class="container">
                <!-- /.product-description -->
                <div class="product-details__description">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="description-tab" data-bs-toggle="tab"
                                    data-bs-target="#description-tab-pane" type="button" role="tab"
                                    aria-controls="description-tab-pane"
                                    aria-selected="true">
                                Description
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="reviews-tab" data-bs-toggle="tab"
                                    data-bs-target="#reviews-tab-pane"
                                    type="button" role="tab" aria-controls="reviews-tab-pane" aria-selected="false">
                                Reviews
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active mb-3" id="description-tab-pane" role="tabpanel"
                             aria-labelledby="description-tab"
                             tabindex="0">
                            <div class="mt-2 p-4 bg-white">
                                {!! $product->description !!}
                            </div>
                        </div>
                        <div class="tab-pane fade" id="reviews-tab-pane" role="tabpanel" aria-labelledby="reviews-tab"
                             tabindex="0">
                            @php
                                $roundedRating = round($avgRating, 1); // e.g. 4.2
                            @endphp
                            <div class="mt-2 p-4 bg-white">
                                <h3 class="text-center">Customer Reviews</h3>
                                <div class="d-flex align-items-center justify-content-center gap-4 py-3">
                                    <div class="text-center">
                                        <div class="rating-number fw-semibold fs-2">{{ $roundedRating }}</div>

                                        <div class="d-flex justify-content-center gap-1">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @php
                                                    $fillPercent = min(100, max(0, ($roundedRating - $i + 1) * 100));
                                                @endphp
                                                <i class="bi bi-star-fill"
                                                   style="
                            font-size: 1.5rem;
                            background: linear-gradient(90deg, #ffc107 {{ $fillPercent }}%, #e4e5e9 {{ $fillPercent }}%);
                            -webkit-background-clip: text;
                            -webkit-text-fill-color: transparent;
                            display: inline-block;
                       "></i>
                                            @endfor
                                        </div>

                                        <div class="text-muted small mt-1">
                                            Based on {{ $totalRating }} {{ Str::plural('review', $totalRating) }}
                                        </div>
                                    </div>

                                    <div style="height: 2rem; width: 1px; background-color: #ccc;"></div>

                                    <div>
                                        <button type="button" data-bs-toggle="modal" data-bs-target="#writeReviewModal"
                                                class="btn btn-primary review-btn rounded-pill px-4">Write A
                                            Review
                                        </button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <select name="filter_by_rating" id="filter_by_rating" class="form-control">
                                            <option value="">All Ratings</option>
                                            <option value="5">★★★★★ (5 Stars)</option>
                                            <option value="4">★★★★☆ (4 Stars)</option>
                                            <option value="3">★★★☆☆ (3 Stars)</option>
                                            <option value="2">★★☆☆☆ (2 Stars)</option>
                                            <option value="1">★☆☆☆☆ (1 Star)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex align-items-center">
                                            <label for="has_media" class="form-label d-block mb-0">With Media</label>
                                            <div class="form-check form-switch form-check-danger ms-2 pb-0">
                                                <input class="form-check-input" type="checkbox" id="has_media"
                                                       name="has_media">
                                                <label class="form-check-label" for="has_media"
                                                       id="media_label">No</label>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                @if($isReviewExists)
                                    <div class="table-responsive">
                                        <table id="reviews-table" class="table align-middle w-100">
                                            <thead>
                                            <tr>
                                                <th style="width: 20% !important; max-width: 20% !important"></th>
                                                <th style="width: 20% !important; max-width: 20% !important"></th>
                                                <th style="width: 30% !important; max-width: 30% !important"></th>
                                                <th style="width: 30% !important; max-width: 30% !important"></th>
                                            </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                @else
                                    <p class="text-center mt-2">No reviews yet.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="product-home-top-selling py-5">
            <div class="container products">
                <div class="sec-title">
                    <h3 class="sec-title__title">You may also like</h3>
                </div>
                <div class="row pt-5">
                    @forelse ($relatedProducts as $product)
                        <div class="col-xl-3 col-lg-4 col-md-6 col-6 product_item">
                            <div class="product__item wow fadeInUp" data-wow-duration='1500ms'
                                 data-wow-delay='000ms'>
                                @php
                                    $productImages = $product->images;
                                    $variantImages = $product->variations->flatMap(function ($variation) {
                                        return $variation->images;
                                    });

                                    $images = $productImages->merge($variantImages);
                                    $label = $product->label->value;
                                    $labelClass =
                                        $label == 'new arrival'
                                            ? 'new-arrival'
                                            : ($label == 'featured'
                                                ? 'featured'
                                                : 'top_selling');
                                @endphp
                                @if ($product->sale_price && $product->regular_price > 0)
                                    @php
                                        $saving =
                                            (($product->regular_price - $product->sale_price) /
                                                $product->regular_price) *
                                            100;
                                    @endphp
                                    <span class="discount" style="margin-left: 10px; font-size: 10px;">
                                            Saving {{ number_format($saving, 0) }}%
                                        </span>
                                @endif
                                <span class="label {{ $labelClass }}">
                                        {{ $product->label->value }}
                                    </span>
                                <div class="product_item_image product-carousel owl-carousel">
                                    @foreach ($images as $image)
                                        <img class="item product-image" src="{{ asset($image->path) }}"
                                             loading="lazy" alt="{{ $product->name }}">
                                    @endforeach
                                </div>
                                <div class="product_item_content">
                                    <h6 class="product_item_title">
                                        <a
                                                href="{{ route('product.details', $product->slug) }}">{{ Str::limit($product->name, 30) }}</a>
                                    </h6>
                                    <div class="product_item_price">
                                        @if ($product->sale_price && $product->regular_price > 0)
                                            <span
                                                    style="text-decoration: line-through; color: red; font-size: 16px; margin-right: 10px;">
                                                    {{ env('CURRENCY_SYMBOL') }}{{ number_format($product->regular_price, 2) }}
                                                </span>
                                            <span style="color: #888; font-size: 16px;">
                                                    {{ env('CURRENCY_SYMBOL') }}{{ number_format($product->sale_price, 2) }}
                                                </span>
                                        @else
                                            <span>
                                                    {{ env('CURRENCY_SYMBOL') }}{{ number_format($product->regular_price, 2) }}
                                                </span>
                                        @endif
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <a href="javascript:void(0);"
                                           class="p-3 floens-btn product__item__link me-2 mobile-btn custom-button mobile-btn enquireBtn"
                                           data-id="{{ $product->id }}"
                                           data-url="{{ route('enquireForm', $product->id) }}">Enquire</a>

                                        <a href="javascript:void(0);"
                                           class="p-4 floens-btn product__item__link me-2 custom-button addCartItemBtn addToCartBtn"
                                           data-product-id="{{ $product->id }}"
                                           data-url="{{ route('add.to.cart.form', $product->id) }}">
                                            <!--<i style='font-size:17px; right: 15px' class='fas'>&#xf217;</i>-->
                                            <i style='font-size:17px; right: 15px' class='fas'>&#xf217;</i></a>
                                        </a>
                                    </div>
                                </div><!-- /.product-content -->
                            </div><!-- /.product-item -->
                        </div><!-- /.col-md-6 col-lg-4 -->
                    @empty
                        <h5 class="text-center">No products found.</h5>
                    @endforelse
                </div><!-- /.row -->

            </div><!-- /.container -->
        </div>

        <div id="writeReviewModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
             style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="p-4 modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Share your thoughts</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{route('store.product.review')}}" method="post" id="writeReviewForm"
                          enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="product_id" id="product_id" value="{{$product_id}}">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="rating" class="form-label">Rate your experience <span
                                                class="text-danger">*</span></label>
                                    <div id="star-rating" class="star-rating">
                                        <span data-value="1">&#9733;</span>
                                        <span data-value="2">&#9733;</span>
                                        <span data-value="3">&#9733;</span>
                                        <span data-value="4">&#9733;</span>
                                        <span data-value="5">&#9733;</span>
                                        <span id="rating-label" class="ms-2"></span>
                                        <input type="hidden" id="rating" name="rating" value="">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="headline" class="form-label">Add a headline <span
                                                class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="headline" name="headline"
                                           placeholder="Summarize your experience">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="comment" class="form-label">Write a review <span
                                                class="text-danger">*</span></label>
                                    <textarea class="form-control" id="comment" name="comment" rows="4"></textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Your Name <span
                                                class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name"
                                           placeholder="Enter your name">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Your email address <span
                                                class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email"
                                           placeholder="Enter your email address">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="images" class="form-label">Upload images</label>
                                    <input type="file" multiple accept="image/*" class="form-control" id="images"
                                           name="images[]">
                                    <p class="text-danger mt-1"><small>Maximum 10 images allowed</small></p>
                                    <div id="imagePreviewContainer" class="d-flex flex-wrap gap-2 mt-2"></div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="videos" class="form-label">Upload videos</label>
                                    <input type="file" multiple accept="video/*" class="form-control" id="videos"
                                           name="videos[]">
                                    <p class="text-danger mt-1"><small>Maximum 3 videos allowed</small></p>
                                    <div id="videoPreviewContainer" class="d-flex flex-wrap gap-2 mt-2"></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary reviewSubmitBtn" id="writeReviewSubmitBtn">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- Products End -->
@endsection
@section('page-script')
    <script src="{{ asset('assets/cdn/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/cdn/datatables/dataTables.bootstrap5.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/lightgallery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/plugins/video/lg-video.min.js"></script>
    <script src="https://unpkg.com/mediabox/dist/mediabox.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
    <script>
        // For initial load
        document.addEventListener("DOMContentLoaded", function () {
            GLightbox({selector: '.glightbox'});
        });

        // For DataTables redraws
        $('#reviews-table').on('draw.dt', function () {
            GLightbox({selector: '.glightbox'});
        });


    </script>

    <script>
        function initGalleryForRow(galleryId) {
            const $galleryContainer = document.getElementById(galleryId);
            if (!$galleryContainer) return;

            lightGallery($galleryContainer, {
                selector: '.lg-thumb',
                speed: 500,
                controls: true,
                download: false,
                fullscreen: true
            });
        }

        window.initGalleries = function () {
            document.querySelectorAll('.gallery-container').forEach(el => {
                initGalleryForRow(el.id);
            });

            document.querySelectorAll('.gallery-videos').forEach(el => {
                lightGallery(el, {
                    selector: 'a',
                    videojs: true,
                    plugins: [lgVideo],
                    videoMaxWidth: '100%',
                    videoMaxHeight: '100%',
                    autoplayFirstVideo: true,
                    download: false,
                    zoomFromOrigin: false,
                    allowMediaOverlap: true,
                    toggleThumb: true,
                });
            });
        };


        $(document).ready(function () {
            var reviewsTable = $('#reviews-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("reviews.data") }}?product_id={{ $product_id }}',
                    dataSrc: function (json) {
                        return json.data || []; // Always return array
                    },
                    error: function (xhr, error, thrown) {
                        console.error('DataTables error:', error);
                    }
                },
                language: {
                    emptyTable: "No reviews found for this product.",
                    processing: "Loading...",
                },
                columns: [
                    {data: 'name', name: 'name', orderable: false, searchable: true},
                    {data: 'review_details', name: 'review_details', orderable: false, searchable: true},
                    {data: 'media', name: 'media', orderable: false, searchable: false},
                    {data: 'video', name: 'video', orderable: false, searchable: false},
                ],
                drawCallback: function () {
                    initGalleries();
                }
            });


            let productId = '{{ $product_id }}'; // reuse this in filterReviews()

            function filterReviews() {
                let rating = $('#filter_by_rating').val();
                let with_media = $('#has_media').is(':checked') ? 1 : ''; // send 1 or empty

                let url = '{{ route("reviews.data") }}'
                    + '?product_id=' + productId
                    + '&rating=' + rating
                    + '&with_media=' + with_media;

                reviewsTable.ajax.url(url).load();
            }


            $('#filter_by_rating').on('change', function () {
                filterReviews();
            });

            $('#has_media').on('change', function () {
                filterReviews();
            });
        });
        document.getElementById('has_media').addEventListener('change', function () {
            document.getElementById('media_label').textContent = this.checked ? 'Yes' : 'No';
        });


    </script>
    <script>
        const stars = document.querySelectorAll("#star-rating span[data-value]");
        const ratingInput = document.getElementById("rating");
        const ratingLabel = document.getElementById("rating-label");

        const labels = ["Poor", "Fair", "Average", "Good", "Excellent"];

        stars.forEach((star, index) => {
            star.addEventListener("click", () => {
                const value = parseInt(star.getAttribute("data-value"));
                ratingInput.value = value;

                stars.forEach((s, i) => {
                    if (i < value) {
                        s.classList.add("filled");
                    } else {
                        s.classList.remove("filled");
                    }
                });

                ratingLabel.textContent = labels[value - 1];
            });
        });
        document.getElementById('images').addEventListener('change', function (e) {
            const container = document.getElementById('imagePreviewContainer');
            container.innerHTML = '';

            Array.from(e.target.files).forEach((file, index) => {
                if (!file.type.startsWith('image/')) return;

                const reader = new FileReader();
                reader.onload = function (e) {
                    const wrapper = document.createElement('div');
                    wrapper.classList.add('position-relative');

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('rounded', 'shadow-sm');
                    img.style.maxWidth = '80px';
                    img.style.maxHeight = '80px';

                    const btn = document.createElement('button');
                    btn.innerHTML = '&times;';
                    btn.type = 'button';
                    btn.className = 'btn btn-sm btn-danger rounded-circle p-0 d-flex align-items-center justify-content-center position-absolute top-0 end-0';
                    btn.style.width = '18px';
                    btn.style.height = '18px';
                    btn.onclick = () => {
                        wrapper.remove();
                        removeFileFromInput('images', index);
                    };

                    wrapper.appendChild(img);
                    wrapper.appendChild(btn);
                    container.appendChild(wrapper);
                };
                reader.readAsDataURL(file);
            });
        });

        document.getElementById('videos').addEventListener('change', function (e) {
            const container = document.getElementById('videoPreviewContainer');
            container.innerHTML = '';

            // Remove existing thumbnail inputs
            document.querySelectorAll('input[name="video_thumbnails[]"]').forEach(input => input.remove());

            Array.from(e.target.files).forEach((file, index) => {
                if (!file.type.startsWith('video/')) return;

                const video = document.createElement('video');
                video.controls = true;
                video.style.maxWidth = '200px';
                video.style.maxHeight = '100px';
                video.muted = true;
                video.playsInline = true;

                const reader = new FileReader();
                reader.onload = function (e) {
                    video.src = e.target.result;

                    video.onloadeddata = function () {
                        video.currentTime = Math.min(1, video.duration / 2);
                    };

                    video.onseeked = function () {
                        const canvas = document.createElement('canvas');
                        canvas.width = video.videoWidth;
                        canvas.height = video.videoHeight;

                        const ctx = canvas.getContext('2d');
                        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

                        const thumbnailDataUrl = canvas.toDataURL('image/jpeg');

                        // Create hidden input to store thumbnail
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'video_thumbnails[]';
                        input.value = thumbnailDataUrl;

                        document.getElementById('writeReviewForm').appendChild(input);
                    };

                    const wrapper = document.createElement('div');
                    wrapper.classList.add('position-relative');

                    const btn = document.createElement('button');
                    btn.innerHTML = '&times;';
                    btn.type = 'button';
                    btn.className = 'btn btn-sm btn-danger rounded-circle p-0 d-flex align-items-center justify-content-center position-absolute top-0 end-0';
                    btn.style.width = '18px';
                    btn.style.height = '18px';
                    btn.onclick = () => {
                        wrapper.remove();
                        removeFileFromInput('videos', index);

                        // Remove the corresponding thumbnail input
                        const thumbs = document.querySelectorAll('input[name="video_thumbnails[]"]');
                        if (thumbs[index]) thumbs[index].remove();
                    };

                    wrapper.appendChild(video);
                    wrapper.appendChild(btn);
                    container.appendChild(wrapper);
                };
                reader.readAsDataURL(file);
            });
        });

        // Helper to remove file from input
        function removeFileFromInput(inputId, fileIndex) {
            const input = document.getElementById(inputId);
            const dt = new DataTransfer();

            Array.from(input.files).forEach((file, index) => {
                if (index !== fileIndex) {
                    dt.items.add(file);
                }
            });

            input.files = dt.files;
        }

        $('#writeReviewForm').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: new FormData(this),
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $('#writeReviewSubmitBtn').prop('disabled', true);
                    $('#writeReviewSubmitBtn').html(
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...'
                    );
                },
                success: function (response) {
                    console.log(response);
                    if (response.status == 'success') {
                        notify('success', response.message);
                        $('#writeReviewForm')[0].reset();
                        $('#writeReviewModal').modal('hide');
                    }
                },
                error: handleAjaxErrors,
                complete: function () {
                    $('#writeReviewSubmitBtn').prop('disabled', false);
                    $('#writeReviewSubmitBtn').html('Submit');
                }
            });
        });
    </script>

    <script>
        $(document).ready(function () {


            var owl = $('.product-carousel');
            owl.owlCarousel({
                items: 1,
                loop: true,
                margin: 10,
                autoplay: true,
                autoplayTimeout: 2000,
                autoplayHoverPause: true,
                nav: true,
                dots: false,
            });

            $('.play').on('click', function () {
                owl.trigger('play.owl.autoplay', [1000]);
            });

            $('.stop').on('click', function () {
                owl.trigger('stop.owl.autoplay');
            });


            const totalAttributes = {{ count($attributes) }};
            // ✅ Init Swiper sliders
            var galleryThumbs = new Swiper('.product-details__gallery-thumb', {
                spaceBetween: 10,
                slidesPerView: 4,
                freeMode: true,
                watchSlidesProgress: true,
            });

            var galleryTop = new Swiper('.product-details__gallery-top', {
                spaceBetween: 10,
                thumbs: {
                    swiper: galleryThumbs
                },
                centeredSlides: true,
                slidesPerView: 1,
            });

            // ✅ Reusable function to update gallery
            function updateSwiperGallery(images) {
                galleryTop.removeAllSlides();
                galleryThumbs.removeAllSlides();

                $.each(images, function (index, imagePath) {
                    const imageUrl = '/' + imagePath.replace(/^\/?/, '');

                    galleryTop.appendSlide(`
                    <div class="swiper-slide">
                        <img src="${imageUrl}" class="product-details__gallery-top__img">
                    </div>`);

                    galleryThumbs.appendSlide(`
                    <div class="swiper-slide product-details__gallery-thumb-slide">
                        <img src="${imageUrl}" class="product-details__gallery-thumb__img">
                    </div>`);
                });

                // Optionally reset to first slide
                galleryTop.slideTo(0);
                galleryThumbs.slideTo(0);
            }

            // ✅ Listen to attribute changes
            $('.attribute-input').on('change', function () {
                let selectedAttributes = {};

                $('.attribute-input:checked').each(function () {
                    selectedAttributes[$(this).attr('name')] = $(this).val();
                });

                if (Object.keys(selectedAttributes).length === totalAttributes) {
                    let variationString = $.map(selectedAttributes, function (val, key) {
                        return key + ': ' + val;
                    }).join(' / ');

                    $.ajax({
                        url: "{{ route('get.product.variation.price', $product_id) }}",
                        method: 'GET',
                        data: {
                            variation: variationString
                        },
                        beforeSend: function () {
                            $('#loader').show()
                        },
                        success: function (response) {
                            $('#loader').hide();

                            if (response.status === 'success') {
                                let custom_string = response.data.images.imageable_type + '-' +
                                    response.data.images.imageable_id;

                                let swiperCustomId = $(
                                        `[data-image-id="${response.data.images.imageable_id}"]`
                                ).attr('data-swiper-slide-index');

                                galleryThumbs.slideTo(swiperCustomId[0]);
                                galleryTop.slideTo(swiperCustomId[0]);

                                galleryTop.on('slideChange', function () {
                                    galleryTop.update();
                                    galleryThumbs.update();
                                });

                                // $('[data-image-id=' + custom_string + ']').click();
                                if (response.data.sale_price == null) {
                                    $('#price-wrapper-ditails').html(
                                        `<span class="price">$ ${response.data.regular_price}</span>`
                                    );
                                } else {
                                    $('#price-wrapper-ditails').html(
                                        `<span class="price"
                                    style="text-decoration: line-through; color: red; margin-right: 6px;">$ ${response.data.regular_price}</span>
                                    <span class="price">$ ${response.data.sale_price}</span>`
                                    );
                                }

                            } else {
                                alert(response.message || 'Variation not found.');
                            }
                        },
                        error: function () {
                            $('#loader').hide();
                            alert('Something went wrong.');
                        }
                    });
                }
            });

            displayCartItems();
            $('.enquireBtn').click(function () {
                var productId = $(this).data('id');
                var url = $(this).data('url');
                $.ajax({
                    url: url,
                    method: 'GET',
                    beforeSend: function () {
                        $('#loader').show();
                    },
                    success: function (response) {
                        $('#enquireFormResponse').html(response.html);
                        $('#myModal').modal('show');
                    },
                    complete: function () {
                        $('#loader').hide();
                    }
                })
            });

            $('.addToCartBtn').click(function () {
                var productId = $(this).data('product-id');
                var url = $(this).data('url');
                // $('#addToCartModal').modal('show');
                $.ajax({
                    url: url,
                    method: 'GET',
                    beforeSend: function () {
                        $('#loader').show();
                    },
                    success: function (response) {
                        $('#addToCartResponse').html(response.html);
                        $('#addToCartModal').modal('show');
                    },
                    complete: function () {
                        $('#loader').hide();
                    }
                })
            });

            $('#enquireForm').submit(function (e) {
                e.preventDefault();
                var formData = $('#enquireForm').serialize();
                $.ajax({
                    url: "{{ route('enquire') }}",
                    method: 'POST',
                    data: formData,
                    beforeSend: function () {
                        $('.enquireSubmitBtn').prop('disabled', true);
                        $('.enquireSubmitBtn').html(
                            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending...'
                        );
                    },
                    success: function (response) {
                        $('.enquireSubmitBtn').prop('disabled', false);
                        $('.enquireSubmitBtn').html('Submit');
                        if (response.status == 'success') {
                            notify(response.status, response.message);
                            $('#enquireForm')[0].reset();
                            $('#myModal').modal('hide');
                        }

                    },
                    error: function (xhr, status, error) {
                        $('.enquireSubmitBtn').prop('disabled', false);
                        $('.enquireSubmitBtn').html('Submit');
                        let errors = xhr.responseJSON.errors;
                        if (errors) {
                            $.each(errors, function (key, value) {
                                let inputField = $('[name="' + key + '"]');
                                inputField.addClass('is-invalid');
                                notify('error', value[0]);
                            });
                        }
                    }
                });
            });
        });

        $('body').append(`
        <div class="lightbox">
          <a href="#lightbox" class="lightbox-close lightbox-toggle">X</a>
          <div class="lightbox-container">
            <div class="row">
              <div class="col-sm-12 lightbox-column">

              </div>
            </div>
          </div>
        </div>
        `);

        $('.lightbox-toggle').on('click', (event) => {
            event.preventDefault();
            $('.lightbox').fadeToggle('fast');

            let context = $(event.currentTarget).attr('data-lightbox-type');
            let content = $(event.currentTarget).attr('data-lightbox-content');
            console.log(event);
            if (context == 'video') {
                $('.lightbox-column').append(`
        <div class="lightbox-video">
        <iframe src="${content}" frameborder="0" allowfullscreen> </iframe>
        </div>
    `);
            } else if (context == 'image') {
                $('.lightbox-column').append(`
        <img src="${content}" class="img-" frameborder="0" allowfullscreen>
    `);
            }
        });

        $('.lightbox-close').on('click', (event) => {
            event.preventDefault();
            $('.lightbox-column > *').remove();
        });
    </script>
@endsection
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/cdn/datatables/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css"/>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/css/lightgallery-bundle.min.css">
    {{--    <link rel="stylesheet" href="{{asset('assets/libs/mediabox/mediabox.css')}}">--}}
    <link rel="stylesheet" href="https://unpkg.com/mediabox/dist/mediabox.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css"/>
    <style>
        table#reviews-table {
            width: 100% !important;
            display: block;
        }

        table#reviews-table thead, table#reviews-table thead tr, table#reviews-table tbody {
            display: block;
        }

        table.dataTable > thead .sorting_asc, table.dataTable > thead .sorting_desc {
            display: none !important;
        }

        span.price {
            font-size: 20px;
            font-weight: 700;
            color: #e28245;
        }

        .product-details__buttons {
            margin-top: 15px !important;
        }

        .attribute-option {
            cursor: pointer;
        }

        .attribute-option .badge {
            padding: 0.6rem 1rem;
            border: 1px solid transparent;
            transition: all 0.3s ease;
        }

        .attribute-option input:checked + .badge {
            background-color: #e28245 !important;
            color: white;
            border-color: #db783b;
        }

        .product-details__gallery-thumb__img {
            width: 83px !important;
            height: 83px !important;
        }

        .product-details__description figure table {
            width: 100%;
            padding: 20px !important;
            display: block;
            background: #fff;
        }

        .product-details__gallery-top__img {
            height: 521px;
        }

        .product-details__gallery-top {
            width: 100%;
            aspect-ratio: 1 / 1;
            overflow: hidden;
            position: relative;
        }

        .product-details__gallery-top .swiper-wrapper .swiper-slide {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 550px;
            background: #f9f9f9;
        }

        .product-details__gallery-top .swiper-wrapper .swiper-slide img {
            width: auto;
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            display: block;
            margin: 0 auto;
        }

        .floens-breadcrumb li:not(:last-of-type)::after {
            color: #fff;
        }

        .section-space {
            padding-top: var(--section-space, 120px);
            padding-bottom: 0;
        }

        .skeleton-loader {
            background: linear-gradient(-90deg, #f0f0f0 0%, #e2e2e2 50%, #f0f0f0 100%);
            background-size: 200% 100%;
            animation: shimmer 1.2s infinite;
            border-radius: 8px;
            width: 100%;
            height: 400px;
        }

        .skeleton-thumb {
            height: 100px;
        }

        @keyframes shimmer {
            0% {
                background-position: 200% 0;
            }

            100% {
                background-position: -200% 0;
            }
        }

        .product__item {
            border: 1px solid #DED8D3;
            border-radius: 4px;
        }

        .product__item:hover {
            border: 1px solid #2a4e72;
        }

        .label {
            position: absolute;
            right: 7px;
            top: 7px;
            z-index: 2;
            background: #D94F4F;
            color: #fff !important;
            padding: 2px 8px;
            border-radius: 18px;
            text-transform: capitalize;
            font-size: 10px;
        }


        span.discount {
            position: absolute;
            right: 7px;
            top: 34px;
            z-index: 2;
            background: #D94F4F;
            color: #fff !important;
            padding: 2px 8px;
            border-radius: 18px;
            text-transform: capitalize;
            font-size: 10px;
        }

        .top_selling {
            background: #2a4e72
        }

        .new-arrival {
            background: #4FC79A
        }

        .featured {
            background: #C7844F
        }

        .product_item_image {
            width: 100%;
            aspect-ratio: 1 / 1;
            overflow: hidden;
            position: relative;
        }

        .product_item_image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .product-image {
            height: 300px;
        }

        .product_item_content {
            border: none;
            padding: 0.24px 17px 20px !important;
        }

        .product_item_price {
            margin-bottom: 12px;
        }

        .custom-button {
            border: none;
            background: var(--floens-base, #C7844F);
            color: #fff;
            font-size: 12px;
            cursor: pointer;
            padding: 13px 24px !important;
        }

        .custom-button:hover {
            background: #9a6e4b;
        }

        .mobile-btn {
            padding: 11px 0 !important;
        }

        .enquireBtn {
            width: 70%;
        }

        .addToCartBtn {
            padding: 19px 24px !important;
        }

        .owl-carousel .owl-nav button.owl-prev,
        .owl-carousel .owl-nav button.owl-next {
            position: absolute;
            top: 50%;
            background-color: #434343c7 !important;
            color: #fff !important;
            font-size: 22px !important;
            border-radius: 50% !important;
            width: 25px;
            height: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            transform: translateY(-50%);
        }

        .owl-carousel .owl-nav button.owl-prev {
            left: 15px;
        }

        .owl-carousel .owl-nav button.owl-next {
            right: 12px;
            z-index: 1;
        }

        .product-carousel .owl-item {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 235px;
            background: #f9f9f9;
        }

        .product-carousel .owl-item img {
            width: auto;
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            display: block;
            margin-top: 0px;
        }

        .nav-link {
            color: #E28245 !important;
        }

        .rating-stars {
            color: gold;
            font-size: 1.5rem;
        }

        .rating-number {
            font-size: 2rem;
            font-weight: 500;
            color: #E28245;
        }

        .review-summary {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            padding: 1rem 0;
        }

        .divider {
            height: 2rem;
            width: 1px;
            background-color: #ccc;
        }

        .review-text {
            font-size: 0.875rem;
            color: #6c757d;
        }

        .review-btn {
            background-color: #E28245 !important;
            color: #fff !important;
            border: none !important;
            padding: 0.5rem 1.5rem !important;
        }

        .reviewSubmitBtn {
            background-color: #E28245 !important;
            color: #fff !important;
            border: none !important;
        }

        .reviewSubmitBtn:hover {
            background-color: #db783b !important;
        }

        .star-rating span {
            font-size: 30px;
            color: #ccc;
            cursor: pointer;
            transition: color 0.2s;
        }

        .star-rating span.filled {
            color: #ffcc00;
        }

        #rating-label {
            font-size: 15px;
            font-weight: 600;
            color: #333;
        }

        @media only screen and (max-width: 480px) {
            .product-wrapper {
                margin-top: -40px;
            }

            .product-details__gallery-top .swiper-wrapper .swiper-slide {
                height: 350px;
            }

            .sec_1_prev_3 {
                height: 364px !important;
                width: auto !important;
            }

            .sec_1_prev_2 {
                height: 186px;
                width: auto !important;
            }

            .sec_1_prev_1 {
                height: 170px;
                width: auto !important;
            }

            img.reliable-one__image__two.sec_2_prev_2 {
                height: 300px;
                width: auto !important;

            }

            img.reliable-one__image__one.sec_2_prev_1 {
                height: 300px;
                width: auto !important;
            }


            span.label {
                padding: 1px 6px;
                font-size: 8px !important;
            }

            span.discount {
                top: 26px;
                padding: 1px 6px;
                font-size: 8px !important;
            }

            .addToCartBtn {
                padding: 14px 21px !important;
            }

            .addToCartBtn i {
                font-size: 12px !important;
            }

            .product-carousel .owl-item {
                height: 150px;
            }

            .product-carousel .owl-item img {
                margin: 0px;
            }

            .product_item_content {
                margin-top: 0px !important;
            }

            .product_item_content {
                padding: 0.24px 8px 8px !important;
            }

            .owl-carousel .owl-nav button.owl-prev {
                width: 20px;
                height: 20px;
            }

            .owl-carousel .owl-nav button.owl-prev {
                font-size: 14px !important;
            }

            .owl-carousel .owl-nav button.owl-prev,
            .owl-carousel .owl-nav button.owl-prev,
            .owl-carousel button.owl-dot.owl-nav {
                left: 7px;
            }

            .owl-carousel .owl-nav button.owl-next {
                font-size: 13px !important;
            }

            .owl-carousel .owl-nav button.owl-next {
                width: 20px;
                height: 20px;
            }

            .owl-carousel .owl-nav button.owl-next,
            .owl-carousel .owl-nav button.owl-next,
            .owl-carousel button.owl-dot.owl-nav {
                right: 8px;
            }
        }

        .gallery-container {
            display: grid;
            grid-template-columns: repeat(4, 1fr); /* 4 columns */
            gap: 10px; /* space between items */
            max-width: 400px; /* optional: constrain width */
        }

        .gallery-container a img {
            width: 100%;
            height: 50px;
            object-fit: cover;
            display: block;
        }

        .gallery-container a {
            display: block;
        }

        .video-gallery-container a {
            position: relative;
            display: inline-block;
        }

        /*.video-gallery-container i {*/
        /*    position: absolute;*/
        /*    font-size: 12px;*/
        /*    color: white;*/
        /*    z-index: 99;*/
        /*    border: 2px solid red;*/
        /*    left: calc(50% - 15px);*/
        /*    top: calc(50% - 16px);*/
        /*    width: 25px;*/
        /*    text-align: center;*/
        /*    border-radius: 10px;*/
        /*}*/

        /* LIGHTBOX STYLE */
        .lightbox {
            display: none;
            position: fixed;
            z-index: 999;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
        }

        .lightbox .lightbox-video {
            width: 100%;
            padding-bottom: 56%;
        }

        .lightbox iframe {
            position: absolute;
            height: 100%;
            width: 100%;
            left: 0;
            right: 0;
        }

        .lightbox img {
            display: block;
            margin: 0 auto;
        }

        .lightbox .lightbox-close {
            position: absolute;
            display: block;
            top: 10px;
            right: 10px;
            color: #ffffff;
            font-size: 26px;
            height: 50px;
            width: 50px;
            background: rgba(255, 255, 255, 0.3);
            border: 3px solid #ffffff;
            border-radius: 50%;
            line-height: 50px;
            text-align: center;
        }

        .lightbox .lightbox-close:hover {
            text-decoration: none;
        }

        .lightbox .lightbox-container {
            max-width: 1024px;
            margin: 100px auto 25px;
        }

        #reviews-table_length {
            display: none;
        }

    </style>
@endsection
