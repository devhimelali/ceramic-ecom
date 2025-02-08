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
            accent-color: #007bff;
        }

        .product__sidebar__label {
            font-size: 16px;
            color: #555;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .product__sidebar__label:hover {
            color: #007bff;
        }

        .expand-icon {
            font-size: 20px;
            color: #007bff;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .expand-icon.open i {
            transform: rotate(45deg);
            /* Rotate the plus icon to a cross when expanded */
        }

        .expand-icon i {
            transition: transform 0.3s ease;
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
                            <h3 class="product__sidebar__title product__categories__title">Categories</h3>
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
                                                    value="{{ $attributeValue->id }}" class="product__sidebar__checkbox">
                                                <label
                                                    for="attribute-{{ $attribute->id }}-value-{{ $attributeValue->id }}"
                                                    class="product__sidebar__label">{{ $attributeValue->value }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach





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

                    <div class="row gutter-y-30">
                        <div class="col-xl-4 col-lg-6 col-md-6 ">
                            <div class="product__item wow fadeInUp" data-wow-duration='1500ms' data-wow-delay='000ms'>
                                <div class="product__item__image">
                                    <img src="{{ asset('frontend') }}/assets/images/products/product-1-1.jpg"
                                        alt="Natural Stone Tiles">
                                </div><!-- /.product-image -->
                                <div class="product__item__content">
                                    <div class="floens-ratings product__item__ratings">
                                        <span class="icon-star"></span>
                                        <span class="icon-star"></span>
                                        <span class="icon-star"></span>
                                        <span class="icon-star"></span>
                                        <span class="icon-star"></span>
                                    </div><!-- /.product-ratings -->
                                    <h4 class="product__item__title"><a href="shop-details.html">Natural Stone Tiles</a>
                                    </h4><!-- /.product-title -->
                                    <div class="product__item__price">$82.00</div><!-- /.product-price -->
                                    <a href="cart.html" class="floens-btn product__item__link">
                                        <span>Add to Cart</span>
                                        <i class="icon-cart"></i>
                                    </a>
                                </div><!-- /.product-content -->
                            </div><!-- /.product-item -->
                        </div><!-- /.col-md-6 col-lg-4 -->
                        <div class="col-xl-4 col-lg-6 col-md-6 ">
                            <div class="product__item wow fadeInUp" data-wow-duration='1500ms' data-wow-delay='100ms'>
                                <div class="product__item__image">
                                    <img src="{{ asset('frontend') }}/assets/images/products/product-1-2.jpg"
                                        alt="Mosaic Tiles">
                                </div><!-- /.product-image -->
                                <div class="product__item__content">
                                    <div class="floens-ratings product__item__ratings">
                                        <span class="icon-star"></span>
                                        <span class="icon-star"></span>
                                        <span class="icon-star"></span>
                                        <span class="icon-star"></span>
                                        <span class="icon-star"></span>
                                    </div><!-- /.product-ratings -->
                                    <h4 class="product__item__title"><a href="shop-details.html">Mosaic Tiles</a></h4>
                                    <!-- /.product-title -->
                                    <div class="product__item__price">$78.00</div><!-- /.product-price -->
                                    <a href="cart.html" class="floens-btn product__item__link">
                                        <span>Add to Cart</span>
                                        <i class="icon-cart"></i>
                                    </a>
                                </div><!-- /.product-content -->
                            </div><!-- /.product-item -->
                        </div><!-- /.col-md-6 col-lg-4 -->
                        <div class="col-xl-4 col-lg-6 col-md-6 ">
                            <div class="product__item wow fadeInUp" data-wow-duration='1500ms' data-wow-delay='200ms'>
                                <div class="product__item__image">
                                    <img src="{{ asset('frontend') }}/assets/images/products/product-1-3.jpg"
                                        alt="Terracotta Tiles">
                                </div><!-- /.product-image -->
                                <div class="product__item__content">
                                    <div class="floens-ratings product__item__ratings">
                                        <span class="icon-star"></span>
                                        <span class="icon-star"></span>
                                        <span class="icon-star"></span>
                                        <span class="icon-star"></span>
                                        <span class="icon-star"></span>
                                    </div><!-- /.product-ratings -->
                                    <h4 class="product__item__title"><a href="shop-details.html">Terracotta Tiles</a></h4>
                                    <!-- /.product-title -->
                                    <div class="product__item__price">$22.00</div><!-- /.product-price -->
                                    <a href="cart.html" class="floens-btn product__item__link">
                                        <span>Add to Cart</span>
                                        <i class="icon-cart"></i>
                                    </a>
                                </div><!-- /.product-content -->
                            </div><!-- /.product-item -->
                        </div><!-- /.col-md-6 col-lg-4 -->
                        <div class="col-xl-4 col-lg-6 col-md-6 ">
                            <div class="product__item wow fadeInUp" data-wow-duration='1500ms' data-wow-delay='300ms'>
                                <div class="product__item__image">
                                    <img src="{{ asset('frontend') }}/assets/images/products/product-1-4.jpg"
                                        alt="Fish Scale Tiles">
                                </div><!-- /.product-image -->
                                <div class="product__item__content">
                                    <div class="floens-ratings product__item__ratings">
                                        <span class="icon-star"></span>
                                        <span class="icon-star"></span>
                                        <span class="icon-star"></span>
                                        <span class="icon-star"></span>
                                        <span class="icon-star"></span>
                                    </div><!-- /.product-ratings -->
                                    <h4 class="product__item__title"><a href="shop-details.html">Fish Scale Tiles</a></h4>
                                    <!-- /.product-title -->
                                    <div class="product__item__price">$49.00</div><!-- /.product-price -->
                                    <a href="cart.html" class="floens-btn product__item__link">
                                        <span>Add to Cart</span>
                                        <i class="icon-cart"></i>
                                    </a>
                                </div><!-- /.product-content -->
                            </div><!-- /.product-item -->
                        </div><!-- /.col-md-6 col-lg-4 -->
                        <div class="col-xl-4 col-lg-6 col-md-6 ">
                            <div class="product__item wow fadeInUp" data-wow-duration='1500ms' data-wow-delay='400ms'>
                                <div class="product__item__image">
                                    <img src="{{ asset('frontend') }}/assets/images/products/product-1-5.jpg"
                                        alt="Digital Print Tiles">
                                </div><!-- /.product-image -->
                                <div class="product__item__content">
                                    <div class="floens-ratings product__item__ratings">
                                        <span class="icon-star"></span>
                                        <span class="icon-star"></span>
                                        <span class="icon-star"></span>
                                        <span class="icon-star"></span>
                                        <span class="icon-star"></span>
                                    </div><!-- /.product-ratings -->
                                    <h4 class="product__item__title"><a href="shop-details.html">Digital Print Tiles</a>
                                    </h4><!-- /.product-title -->
                                    <div class="product__item__price">$31.00</div><!-- /.product-price -->
                                    <a href="cart.html" class="floens-btn product__item__link">
                                        <span>Add to Cart</span>
                                        <i class="icon-cart"></i>
                                    </a>
                                </div><!-- /.product-content -->
                            </div><!-- /.product-item -->
                        </div><!-- /.col-md-6 col-lg-4 -->
                        <div class="col-xl-4 col-lg-6 col-md-6 ">
                            <div class="product__item wow fadeInUp" data-wow-duration='1500ms' data-wow-delay='500ms'>
                                <div class="product__item__image">
                                    <img src="{{ asset('frontend') }}/assets/images/products/product-1-6.jpg"
                                        alt="Penny Tiles">
                                </div><!-- /.product-image -->
                                <div class="product__item__content">
                                    <div class="floens-ratings product__item__ratings">
                                        <span class="icon-star"></span>
                                        <span class="icon-star"></span>
                                        <span class="icon-star"></span>
                                        <span class="icon-star"></span>
                                        <span class="icon-star"></span>
                                    </div><!-- /.product-ratings -->
                                    <h4 class="product__item__title"><a href="shop-details.html">Penny Tiles</a></h4>
                                    <!-- /.product-title -->
                                    <div class="product__item__price">$50.00</div><!-- /.product-price -->
                                    <a href="cart.html" class="floens-btn product__item__link">
                                        <span>Add to Cart</span>
                                        <i class="icon-cart"></i>
                                    </a>
                                </div><!-- /.product-content -->
                            </div><!-- /.product-item -->
                        </div><!-- /.col-md-6 col-lg-4 -->
                        <div class="col-12">
                            <ul class="post-pagination">
                                <li>
                                    <a href="#"><span class="icon-arrow-left"></span></a>
                                </li>
                                <li>
                                    <a href="#">01</a>
                                </li>
                                <li>
                                    <a href="#">02</a>
                                </li>
                                <li>
                                    <a href="#">03</a>
                                </li>
                                <li class="active">
                                    <a href="#"><span class="icon-arrow-right"></span></a>
                                </li>
                            </ul>
                        </div><!-- /.col-12 -->
                    </div><!-- /.row -->
                </div><!-- /.col-lxl9  col-lg-8-->
            </div><!-- /.row -->
        </div><!-- /.container -->
    </section><!-- /.product-page section-space-bottom -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get all the attribute title elements
            const attributeTitles = document.querySelectorAll('.product__sidebar__title');

            attributeTitles.forEach(function(title) {
                title.addEventListener('click', function() {
                    // Get the associated values section and icon
                    const attributeId = title.getAttribute('data-attribute-id');
                    const valuesSection = document.getElementById('values-' + attributeId);
                    const expandIcon = document.getElementById('expand-icon-' + attributeId)
                        .querySelector('i');

                    // Toggle the visibility of the values section
                    if (valuesSection.style.display === 'none' || valuesSection.style.display ===
                        '') {
                        valuesSection.style.display = 'block';
                        // Change the icon to minus
                        expandIcon.classList.remove('fa-plus');
                        expandIcon.classList.add('fa-minus');
                    } else {
                        valuesSection.style.display = 'none';
                        // Change the icon to plus
                        expandIcon.classList.remove('fa-minus');
                        expandIcon.classList.add('fa-plus');
                    }

                    // Rotate the icon when expanded
                    const iconContainer = document.getElementById('expand-icon-' + attributeId);
                    iconContainer.classList.toggle('open');
                });
            });
        });
    </script>
@endsection
