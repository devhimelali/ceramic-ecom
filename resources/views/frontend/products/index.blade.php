@extends('frontend.layouts.app')
@section('title', 'Products')
@section('page-style')
    <style>
        .product__sidebar__attribute {
            margin-bottom: 20px;
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
        }

        .product__sidebar__title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .product__sidebar__values {
            padding-left: 20px;
        }

        .product__sidebar__value {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
        }

        .product__sidebar__checkbox {
            margin-right: 10px;
            width: 18px;
            height: 18px;
            accent-color: var(--floens-base, #a36d43);
        }

        .product__sidebar__label {
            font-size: 16px;
            color: #555;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .product__sidebar__label:hover {
            color: var(--floens-base, #C7844F);
        }

        .expand-icon {
            font-size: 20px;
            color: var(--floens-base, #C7844F);
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .expand-icon.open i {
            transform: rotate(183deg);
        }

        .expand-icon i {
            transition: transform 0.3s ease;
        }

        /* Container for Products */
        #products {
            position: relative;
            /* Ensures the loader is positioned within this container */
        }

        /* Custom Loader Style */
        #loader {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 80%;
            background: rgba(10, 10, 10, 0.141);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 10;
        }

        /* Spinner Style */
        .spinner {
            border: 8px solid #f3f3f3;
            border-top: 8px solid #dc7221;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1.5s linear infinite;
            /* Spinner animation */
        }

        /* Loader text style */
        #loader p {
            margin-top: 10px;
            font-size: 16px;
            color: #ffffff;
            /* White text for contrast */
        }

        /* Keyframes for spinner rotation */
        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .no-products-message {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }

        .pagination .page-item.active .page-link {
            background-color: var(--floens-base, #C7844F) !important;
            border-color: var(--floens-base, #C7844F) !important;
            color: #fff !important;
        }

        .pagination .page-link {
            color: #333;
            /* Default color */
        }
    </style>
    <!-- Include jQuery UI CSS -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endsection
@section('content')
    <section class="page-header">
        <div class="page-header__bg"
            style="background-image: url('{{ asset('frontend') }}/assets/images/backgrounds/page-header-bg-1-1.png');"></div>
        <!-- /.page-header__bg -->
        <div class="container">
            <h2 class="page-header__title">Find Your Products</h2>
            <ul class="floens-breadcrumb list-unstyled">
                <li><i class="text-white icon-home"></i> <a href="{{ route('frontend.home') }}">Home</a></li>
                <li><span class="text-white">Products</span></li>
            </ul><!-- /.thm-breadcrumb list-unstyled -->
        </div><!-- /.container -->
    </section><!-- /.page-header -->

    <section class="product-page product-page--left section-space-bottom">
        <div class="container">
            <div class="row gutter-y-60">
                <div class="col-xl-3 col-lg-4">
                    <aside class="product__sidebar">
                        <div class="product__search-box product__sidebar__item">
                            <form action="#" class="product__search" id="product__search">
                                <input type="text" placeholder="search items" value="{{ request('search') }}"
                                    id="searchQuery" />
                                <button type="submit" aria-label="search submit">
                                    <span class="icon-search"></span>
                                </button>
                            </form><!-- /.product__search -->

                        </div><!-- /.search-widget -->
                        <div class="product__price-ranger product__sidebar__item">
                            {{-- <h3 class="product__sidebar__title">Filter by Price</h3> --}}
                            <form action="#" class="price-ranger">
                                <h3 class="product__sidebar__title">Filter by Price</h3>
                                <input type="range" class="form-range" id="price-range" min="0" max="10000"
                                    step="10" value="{{ request('max_price', 10000) }}">
                                <div class="ranger-min-max-block">
                                    <div><span id="min-price">0</span> - <span
                                            id="max-price">{{ request('max_price', 10000) }}</span></div>
                                </div>
                            </form>


                        </div><!-- /.price-slider -->
                        <div class="product__categories product__sidebar__item">
                            @foreach ($attributes as $attribute)
                                @php
                                    // Retrieve and decode attribute values from request
                                    $selectedValues = request()->input('attribute.' . $attribute->id, []);

                                    // Ensure it's an array and decode Base64 values
                                    $decodedValues = array_map(
                                        fn($value) => base64_decode($value),
                                        (array) $selectedValues,
                                    );
                                @endphp
                                <div class="product__sidebar__attribute">
                                    <h3 class="product__sidebar__title product__categories__title"
                                        data-attribute-id="{{ $attribute->id }}">
                                        {{ $attribute->name }}
                                        <span class="expand-icon" id="expand-icon-{{ $attribute->id }}">
                                            <i class="fas fa-plus"></i>
                                        </span>
                                    </h3>
                                    <div class="product__sidebar__values" id="values-{{ $attribute->id }}"
                                        style="display: none;">
                                        @foreach ($attribute->values as $attributeValue)
                                            <div class="product__sidebar__value">
                                                <input type="checkbox" id="attribute_value-{{ $attributeValue->id }}"
                                                    name="attribute[{{ $attribute->id }}][]"
                                                    value="{{ $attributeValue->id }}" class="product__sidebar__checkbox">
                                                <label for="attribute_value-{{ $attributeValue->id }}"
                                                    class="product__sidebar__label">
                                                    {{ $attributeValue->value }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div><!-- /.category-widget -->
                    </aside><!-- /.shop-sidebar -->
                </div><!-- /.col-xl-3 col-lg-4 -->
                <div class="col-xl-9 col-lg-8">
                    <div id="loader" class="loader" style="display: none;">
                        <div class="spinner"></div>
                        <p>Loading...</p>
                    </div>
                    <div id="products" class="pt-4 mt-5">
                    </div>


                </div><!-- /.col-lxl9  col-lg-8-->
            </div><!-- /.row -->
        </div><!-- /.container -->
    </section><!-- /.product-page section-space-bottom -->
@endsection
@section('page-script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let urlParams = new URLSearchParams(window.location.search);

            urlParams.forEach((values, attributeId) => {
                if (attributeId.startsWith("attribute[")) {
                    let decodedValues = values.split(",");
                    decodedValues.forEach(value => {
                        let checkbox = document.querySelector(`input[value="${value}"]`);
                        if (checkbox) {
                            checkbox.checked = true;
                        }
                    });
                }
            });

            checkQueryParams(urlParams);
        });

        $(document).ready(function() {
            $('.product__sidebar__title').on('click', function() {
                let attributeId = $(this).data('attribute-id');
                let valuesSection = $('#values-' + attributeId);
                let expandIcon = $('#expand-icon-' + attributeId).find('i');

                valuesSection.toggle();
                expandIcon.toggleClass('fa-plus fa-minus');
            });

            function encryptValue(value) {
                return btoa(value);
            }


            function updateUrl() {
                let selectedValues = [];

                $('.product__sidebar__checkbox:checked').each(function() {
                    let value = $(this).val();
                    selectedValues.push(encryptValue(value));
                });

                let newUrl = window.location.origin + window.location.pathname;

                if (selectedValues.length > 0) {
                    let queryString = new URLSearchParams();
                    queryString.append('attribute', selectedValues.join(
                        ','));
                    newUrl += '?' + queryString.toString();
                }

                window.history.pushState({
                    path: newUrl
                }, '', newUrl);
            }

            $('.product__sidebar__checkbox').on('change', function() {
                updateUrl();
                let urlParams = new URLSearchParams(window.location.search);
                checkQueryParams(urlParams);
            })
            // checkQueryParams(new URLSearchParams(window.location.search));



            $('#product__search').on('submit', function(e) {
                e.preventDefault();
                var searchQuery = $('#searchQuery').val().trim();
                let urlParams = new URLSearchParams(window.location.search);

                urlParams.delete('search');

                if (searchQuery) {
                    urlParams.append('search', searchQuery);
                }
                var newUrl = window.location.pathname + '?' + urlParams
                    .toString();

                window.history.pushState({
                    path: newUrl
                }, '', newUrl);
                checkQueryParams(new URLSearchParams(window.location.search));
            });
            $('#brand').on('change', function() {
                let urlParams = new URLSearchParams(window.location.search);
                urlParams.set('brand', $(this).val());
                let newUrl = window.location.pathname + '?' + urlParams
                    .toString();
                window.history.pushState({
                    path: newUrl
                }, '', newUrl);
                checkQueryParams(urlParams);
            })


            function decodeValue(value) {
                return atob(value);
            }

            function checkAttributesOnPageLoad() {
                let urlParams = new URLSearchParams(window.location.search);
                let attributeValues = urlParams.get('attribute') ? urlParams.get('attribute').split(',') : [];

                attributeValues.forEach(function(encodedValue) {
                    let decodedValue = decodeValue(encodedValue);

                    let checkbox = $('#attribute_value-' + decodedValue);
                    if (checkbox.length) {
                        checkbox.prop('checked', true);

                        let attributeDiv = checkbox.closest('.product__sidebar__attribute');
                        let valuesDiv = attributeDiv.find('.product__sidebar__values');
                        let expandIcon = attributeDiv.find('.expand-icon i');

                        attributeDiv.show();
                        valuesDiv.show();
                        expandIcon.removeClass('fa-plus').addClass('fa-minus');
                    }
                });
            }
            checkAttributesOnPageLoad();

            let urlParams = new URLSearchParams(window.location.search);

            // Set initial values
            $("#min-price").text(0);
            $("#max-price").text($("#price-range").val());

            // Update max-price dynamically when slider moves
            $("#price-range").on("input", function() {
                $("#max-price").text($(this).val());
            });

            // Trigger AJAX only when mouse is released
            $("#price-range").on("change", function() {
                let maxPrice = $(this).val();

                urlParams.set("min_price", 0);
                urlParams.set("max_price", maxPrice);

                let newUrl = window.location.pathname + "?" + urlParams.toString();
                window.history.pushState(null, "", newUrl);

                checkQueryParams(urlParams); // Call AJAX to reload products
            });





            $(document).on('click', '#pagination-wrapper a', function(e) {
                e.preventDefault();
                let url = $(this).attr('href');
                if (url) {
                    let urlParams = new URLSearchParams(new URL(url).search);
                    checkQueryParams(urlParams);
                }
            });
        });

        function checkQueryParams(urlParams) {
            // Convert URLSearchParams to a plain object
            let paramsObject = {};
            urlParams.forEach((value, key) => {
                paramsObject[key] = value;
            });
            $.ajax({
                url: "{{ route('frontend.productsPage') }}", // Current URL
                data: paramsObject, // Pass plain object as data
                type: "GET",
                beforeSend: function() {
                    $('#loader').show();
                },
                success: function(response) {
                    $('#products').html(response.html); // Update the product list with response
                },
                complete: function() {
                    $('#loader').hide();
                },
                error: function(xhr, status, error) {
                    // Handle errors (Optional)
                    $('#loader').hide();
                }
            });
        }
    </script>
@endsection
