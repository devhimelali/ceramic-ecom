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
                    <a href="{{ $settings->where('key', 'facebook_link')->first()->value ?? '#' }}">
                        <i class="icon-facebook" aria-hidden="true"></i>
                        <span class="sr-only">Facebook</span>
                    </a>
                    <a href="{{ $settings->where('key', 'twitter_link')->first()->value ?? '#' }}">
                        <i class="icon-twitter" aria-hidden="true"></i>
                        <span class="sr-only">Twitter</span>
                    </a>
                    <a href="{{ $settings->where('key', 'instagram_link')->first()->value ?? '#' }}">
                        <i class="icon-instagram" aria-hidden="true"></i>
                        <span class="sr-only">Instagram</span>
                    </a>
                    <a href="{{ $settings->where('key', 'youtube_link')->first()->value ?? '#' }}
                        <i class="icon-youtube"
                        aria-hidden="true"></i>
                        <span class="sr-only">Youtube</span>
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
                <div class="main-header__logo">
                    <a href="index.html">
                        <img src="{{ $settings->where('key', 'dark_logo')->first()->value ?? '#' }}"
                            alt="logo" width="125">
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
                                @foreach (category_show() as $category)
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
                <div class="mobile-nav__btn mobile-nav__toggler">
                    <span></span>
                    <span></span>
                    <span></span>
                </div><!-- /.mobile-nav__toggler -->
                <a href="javascript:void(0);" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight"
                    aria-controls="offcanvasRight" class="main-header__cart">
                    <i class="icon-cart" aria-hidden="true"></i>
                    <span class="sr-only">Cart</span>
                    <span class="totalCartItems"></span>
                </a><!-- /.shopping card -->
                <a href="#" class="search-toggler main-header__search">
                    <i class="icon-search" aria-hidden="true"></i>
                    <span class="sr-only">Search</span>
                </a><!-- /.search-toggler -->
                <a href="#" class="floens-btn main-header__btn">
                    <span>get a quote</span>
                    <i class="icon-right-arrow"></i>
                </a><!-- /.thm-btn main-header__btn -->
                <button class="main-header__sidebar-btn sidebar-btn__toggler">
                    <span class="main-header__sidebar-btn__box"></span><!-- /.main-header__sidebar-btn__box -->
                    <span class="main-header__sidebar-btn__box"></span><!-- /.main-header__sidebar-btn__box -->
                    <span class="main-header__sidebar-btn__box"></span><!-- /.main-header__sidebar-btn__box -->
                </button><!-- /.main-header__sidebar-btn -->
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
