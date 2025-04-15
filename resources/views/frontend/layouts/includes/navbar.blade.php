<div class="topbar-one">
    <div class="container-fluid">
        <div class="topbar-one__inner">
            <ul class="list-unstyled topbar-one__info">
                <li class="topbar-one__info__item">
                    <span class="icon-paper-plane"></span>
                    <a
                        href="mailto:{{ $settings->where('key', 'contact_email')->first()->value ?? '#' }}">{{ $settings->where('key', 'contact_email')->first()->value ?? 'N/A' }}</a>
                </li>
                <li class="topbar-one__info__item">
                    <span class="icon-phone-call"></span>
                    <a
                        href="tel:{{ $settings->where('key', 'contact_phone')->first()->value ?? '#' }}">{{ $settings->where('key', 'contact_phone')->first()->value ?? 'N/A' }}</a>
                </li>
                <li class="topbar-one__info__item">
                    <span class="icon-location"></span>
                    <address>{{ $settings->where('key', 'contact_address')->first()->value ?? 'N/A' }}</address>
                </li>
            </ul><!-- /.list-unstyled topbar-one__info -->
            <div class="topbar-one__right">
                <div class="topbar-one__social">
                    <a target="_blank" href="{{ $settings->where('key', 'facebook_link')->first()->value ?? '#' }}">
                        <i class="icon-facebook" aria-hidden="true"></i>
                        <span class="sr-only">Facebook</span>
                    </a>
                    <a target="_blank" href="{{ $settings->where('key', 'threads_link')->first()->value ?? '#' }}">
                        <i class="text-white fa-brands fa-threads"></i>
                        <span class="sr-only">Threads</span>
                    </a>
                    <a target="_blank" href="{{ $settings->where('key', 'instagram_link')->first()->value ?? '#' }}">
                        <i class="icon-instagram" aria-hidden="true"></i>
                        <span class="sr-only">Instagram</span>
                    </a>
                    <a target="_blank" href="{{ $settings->where('key', 'tiktok_link')->first()->value ?? '#' }}">
                        <i class="text-white fa-brands fa-tiktok"></i>
                        <span class="sr-only">Tiktok</span>
                    </a>
                </div><!-- /.topbar-one__social -->
            </div><!-- /.topbar-one__right -->
        </div><!-- /.topbar-one__inner -->
    </div><!-- /.container-fluid -->
</div><!-- /.topbar-one -->

<header class="main-header main-header--two sticky-header sticky-header--normal">
    <div class="container-fluid">
        <div class="main-header__inner">
            <div class="main-header__left">
                <div class="mobile-nav__btn mobile-nav__toggler">
                    <span></span>
                    <span></span>
                    <span></span>
                </div><!-- /.mobile-nav__toggler -->
                <div class="main-header__logo">
                    <a href="{{ route('frontend.home') }}">
                        @php
                            $app_logo = $settings->where('key', 'dark_logo')->first();
                        @endphp
                        <img src="{{ $app_logo ? asset('assets/images/settings/' . $app_logo->value) : '#' }}"
                            alt="{{ $app_logo->value }}" class="img-fluid app_logo" loading="lazy">
                    </a>
                </div><!-- /.main-header__logo -->
                <nav class="main-header__nav main-menu">
                    <ul class="main-menu__list">
                        <li>
                            <a href="{{ route('frontend.home') }}">Home</a>
                        </li>

                        <li class="dropdown">
                            <a href="#">Categories</a>
                            <ul>
                                @foreach (category_show()->where('parent_id', null) as $category)
                                    <li>
                                        <a
                                            href="{{ route('frontend.productsPage', ['category' => $category->slug]) }}">{{ $category->name }}</a>
                                        @if ($category->children->count() > 0)
                                            <ul>
                                                @foreach ($category->children as $childCategory)
                                                    <li><a
                                                            href="{{ route('frontend.productsPage', [$childCategory->slug]) }}">{{ $childCategory->name }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif

                                    </li>
                                @endforeach
                                <li class="{{ $active == 'allCategories' ? 'current' : '' }}"><a
                                        href="{{ route('frontend.allCategories') }}">View all</a></li>

                            </ul>
                        </li>

                        <li class="{{ $active == 'products' ? 'current' : '' }}">
                            <a href="{{ route('frontend.productsPage') }}">Products</a>
                        </li>
                        <li class="{{ $active == 'about-us' ? 'current' : '' }}">
                            <a href="{{ route('frontend.aboutUs') }}">About us</a>
                        </li>
                        <li class="{{ $active == 'contact' ? 'current' : '' }}">
                            <a href="{{ route('frontend.contact') }}">Contact</a>
                        </li>
                    </ul>
                </nav><!-- /.main-header__nav -->
            </div><!-- /.main-header__left -->
            <div class="main-header__right">
                <a href="javascript:void(0);" class="search-toggler main-header__search">
                    <i class="icon-search" aria-hidden="true"></i>
                    <span class="sr-only">Search</span>
                </a><!-- /.search-toggler -->
                <a href="javascript:void(0);" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight"
                    aria-controls="offcanvasRight" class="main-header__cart">
                    <i class="icon-cart" aria-hidden="true"></i>
                    <span class="sr-only">Cart</span>
                    <span class="totalCartItems"></span>
                </a><!-- /.shopping card -->
            </div><!-- /.main-header__right -->
        </div><!-- /.main-header__inner -->
    </div><!-- /.container-fluid -->
</header><!-- /.main-header -->
<script>
    $(document).ready(function() {
        $('.totalCartItems').html(getTotalQuantity())
    })
</script>
<style>
    @media (max-width: 425px) {
        .logo-box a img {
            max-height: 60px;
            width: auto;
        }

        .mobile-nav__contact li {
            overflow-wrap: anywhere;
        }

        .main-header__logo a img {
            max-height: 60px;
            width: auto;
        }

        .main-header__search {
            font-size: 16px;
            margin-left: 0px;
            margin-right: 0px !important;
        }

        .main-header__cart {
            margin-left: 15px;
            padding-left: 15px;
            margin-right: 15px;
        }

        .main-header__inner {
            padding-top: 20px !important;
            padding-bottom: 10px !important;
        }
    }

    @media (min-width: 448px) {
        .mobile-nav__btn.mobile-nav__toggler {
            display: none;
        }

        .mobile-nav__contact li {
            overflow-wrap: anywhere;
        }

        .main-header__logo a img {
            max-height: 60px;
            width: auto;
        }

        .logo-box a img {
            max-height: 60px;
            width: auto;
        }
    }

    .main-header__search {
        font-size: 16px;
        margin-left: 0px;
        margin-right: 20px;
    }




    .mobile-nav__btn {
        width: 24px;
        display: flex;
        align-items: center;
        flex-direction: column;
        flex-wrap: wrap;
        cursor: pointer;
        z-index: 3;
        margin: 0 30px 0 10px;
    }

    span.totalCartItems {
        position: absolute;
        right: -12px;
        top: -13px;
        background: #C7844F;
        height: 25px;
        width: 25px;
        border-radius: 50%;
        text-align: center;
        color: #fff;
        font-size: 15px;
    }

    .icon-cart,
    .icon-search {
        font-size: 26px;
    }

    .icon-cart {
        margin-right: 5px;
    }

    .main-header--two .main-menu .main-menu__list>li {
        padding-top: 35px !important;
        padding-bottom: 35px !important;
    }
</style>
