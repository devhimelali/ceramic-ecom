@extends('frontend.layouts.app')
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
            background: rgba(0, 0, 0, 0.6);
            /* Black background with some transparency */
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 10;
            /* Makes sure the loader appears on top of the content */
        }

        /* Spinner Style */
        .spinner {
            border: 8px solid #f3f3f3;
            /* Light gray background */
            border-top: 8px solid #3498db;
            /* Blue color */
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
    </style>
@endsection
@section('content')
    <section class="page-header">
        <div class="page-header__bg"
            style="background-image: url('{{ asset('frontend') }}/assets/images/backgrounds/page-header-bg-1-1.png');"></div>
        <!-- /.page-header__bg -->
        <div class="container">
            <h2 class="page-header__title">Find Your Products</h2>
            <ul class="floens-breadcrumb list-unstyled">
                <li><i class="icon-home"></i> <a href="{{ route('frontend.home') }}">Home</a></li>
                <li><span>Products</span></li>
            </ul><!-- /.thm-breadcrumb list-unstyled -->
        </div><!-- /.container -->
    </section><!-- /.page-header -->

    <section class="product-page product-page--left section-space-bottom">
        <div class="container">
            <div class="row gutter-y-60">
                <div class="col-xl-3 col-lg-4">
                    <aside class="product__sidebar">
                        <div class="product__search-box product__sidebar__item">
                            <form action="#" class="product__search">
                                <input type="text" placeholder="search items" />
                                <button type="submit" aria-label="search submit">
                                    <span class="icon-search"></span>
                                </button>
                            </form><!-- /.product__search -->
                        </div><!-- /.search-widget -->
                        <div class="product__price-ranger product__sidebar__item">
                            <h3 class="product__sidebar__title">Filter by price</h3>
                            <form action="#" class="price-ranger">
                                <div id="slider-range"></div>
                                <div class="ranger-min-max-block">
                                    <input type="text" readonly class="min">
                                    <span>-</span>
                                    <input type="text" readonly class="max">
                                </div>
                            </form>
                        </div><!-- /.price-slider -->
                        <div class="product__categories product__sidebar__item">
                            {{-- <h3 class="product__sidebar__title product__categories__title">Categories</h3> --}}
                            {{-- <ul class="list-unstyled">
                                <li><a href="shop-right.html" data-text="Metal Tiles"><span>Metal Tiles</span></a></li>
                                <li><a href="shop-right.html" data-text="Hexagonal Tiles"><span>Hexagonal Tiles</span></a>
                                </li>
                                <li><a href="shop-right.html" data-text="Penny Tiles"><span>Penny Tiles</span></a></li>
                                <li><a href="shop-right.html" data-text="Patterned Tiles"><span>Patterned Tiles</span></a>
                                </li>
                                <li><a href="shop-right.html" data-text="Fish Scale Tilesr"><span>Fish Scale
                                            Tiles</span></a></li>
                            </ul> --}}
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
                                                <input type="checkbox"
                                                    id="attribute-{{ $attribute->id }}-value-{{ $attributeValue->id }}"
                                                    name="attribute[{{ $attribute->id }}][]"
                                                    value="{{ $attributeValue->id }}" class="product__sidebar__checkbox"
                                                    @if (in_array($attributeValue->id, $decodedValues)) checked @endif>
                                                <label
                                                    for="attribute-{{ $attribute->id }}-value-{{ $attributeValue->id }}"
                                                    class="product__sidebar__label">
                                                    {{ $attributeValue->value }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach

                            {{-- @foreach ($attributes as $attribute)
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
                                                <input type="checkbox"
                                                    id="attribute-{{ $attribute->id }}-value-{{ $attributeValue->id }}"
                                                    name="attribute[{{ $attribute->id }}][]"
                                                    value="{{ $attributeValue->id }}" class="product__sidebar__checkbox"
                                                    @if (in_array($attributeValue->id, request()->input('attribute.' . $attribute->id, []))) checked @endif>
                                                <label
                                                    for="attribute-{{ $attribute->id }}-value-{{ $attributeValue->id }}"
                                                    class="product__sidebar__label">
                                                    {{ $attributeValue->value }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach --}}


                        </div><!-- /.category-widget -->
                    </aside><!-- /.shop-sidebar -->
                </div><!-- /.col-xl-3 col-lg-4 -->
                <div class="col-xl-9 col-lg-8">
                    <div class="product__info-top">
                        <div class="product__showing-text-box">
                            <p class="product__showing-text">Showing 1–9 of 12 Results</p>
                        </div>
                        <div class="product__showing-sort">
                            <select class="selectpicker" aria-label="default shorting">
                                <option selected>default shorting</option>
                                <option value="1">Sort by view</option>
                                <option value="2">Sort by price</option>
                                <option value="3">Sort by ratings</option>
                            </select>
                        </div>
                    </div>

                    <div id="loader" class="loader" style="display: none;">
                        <div class="spinner"></div>
                        <p>Loading...</p>
                    </div>
                    <div id="products">
                        <!-- Custom Loader (Initially hidden) -->
                        <!-- Products Content -->
                        <!-- Your products content will be placed here -->
                    </div>




                </div><!-- /.col-lxl9  col-lg-8-->
            </div><!-- /.row -->
        </div><!-- /.container -->
    </section><!-- /.product-page section-space-bottom -->
@endsection
@section('page-script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
        });

        $(document).ready(function() {
            // Toggle attribute values on click
            $('.product__sidebar__title').on('click', function() {
                let attributeId = $(this).data('attribute-id');
                let valuesSection = $('#values-' + attributeId);
                let expandIcon = $('#expand-icon-' + attributeId).find('i');

                valuesSection.toggle();
                expandIcon.toggleClass('fa-plus fa-minus');
            });

            // Function to update the URL without reloading the page
            function encryptValue(value) {
                return btoa(value); // Base64 encode the value
            }

            function updateUrl() {
                let selectedValues = {};

                // Group selected values by attribute
                $('.product__sidebar__checkbox:checked').each(function() {
                    let attributeId = $(this).attr('name').match(/\d+/)[0]; // Extract attribute ID
                    let value = $(this).val();

                    if (!selectedValues[attributeId]) {
                        selectedValues[attributeId] = [];
                    }
                    selectedValues[attributeId].push(encryptValue(value)); // Encrypt values
                });

                let newUrl = window.location.origin + window.location.pathname;

                if (Object.keys(selectedValues).length > 0) {
                    let queryString = new URLSearchParams();
                    for (let attr in selectedValues) {
                        queryString.append(`attribute[${attr}]`, selectedValues[attr].join(','));
                    }
                    newUrl += '?' + queryString.toString();
                }

                window.history.pushState({
                    path: newUrl
                }, '', newUrl);
            }


            // Update URL when checkboxes are clicked
            $('.product__sidebar__checkbox').on('change', function() {
                updateUrl();
                checkQueryParams();
            });
            // Run on page load
            checkQueryParams();
        });
        // Function to detect query parameters on page load
        function checkQueryParams() {
            $.ajax({
                url: "{{ url()->current() }}", // Current URL
                type: "GET",
                beforeSend: function() {
                    $('#loader').show();
                },
                success: function(response) {
                    $('#products').html(response.html);
                },
                complete: function() {
                    $('#loader').hide();
                },
                error: function(xhr, status, error) {
                    // Handle errors (Optional)
                    console.log("Error:", error);
                    $('#loader').hide();
                }
            });

        }
    </script>
@endsection
