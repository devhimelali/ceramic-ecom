<div class="topbar-one">
    <div class="container-fluid">
        <div class="topbar-one__inner">
            <ul class="list-unstyled topbar-one__info">
                <li class="topbar-one__info__item">
                    <span class="icon-paper-plane"></span>
                    <a href="mailto:{{ app_setting('contact_email') }}">{{ app_setting('contact_email') }}</a>
                </li>
                <li class="topbar-one__info__item">
                    <span class="icon-phone-call"></span>
                    <a href="tel:{{ app_setting('contact_phone') }}">{{ app_setting('contact_phone') }}</a>
                </li>
                <li class="topbar-one__info__item">
                    <span class="icon-location"></span>
                    <address>{{ app_setting('contact_address') }}</address>
                </li>
            </ul><!-- /.list-unstyled topbar-one__info -->
            <div class="topbar-one__right">
                <div class="topbar-one__social">
                    <a href="https://facebook.com/">
                        <i class="icon-facebook" aria-hidden="true"></i>
                        <span class="sr-only">Facebook</span>
                    </a>
                    <a href="https://twitter.com/">
                        <i class="icon-twitter" aria-hidden="true"></i>
                        <span class="sr-only">Twitter</span>
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
                        <img src="{{ app_setting('dark_logo') ?? app_setting('light_logo') }}" alt="Floens HTML"
                            width="125">
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
                                        <a href="#">{{ $category->name }}</a>
                                        @if ($category->children->count() > 0)
                                            <ul>
                                                @foreach ($category->children as $childCategory)
                                                    <li><a href="#">{{ $childCategory->name }}</a></li>
                                                @endforeach
                                            </ul>
                                        @endif

                                    </li>
                                @endforeach
                                <li class="{{ $active == 'allCategories' ? 'current' : '' }}"><a
                                        href="{{ route('frontend.allCategories') }}">View all</a></li>

                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#">Products</a>
                        </li>
                        <li class="dropdown">
                            <a href="#">About us</a>
                        </li>
                        <li>
                            <a href="contact.html">Contact</a>
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
                <a href="cart.html" class="main-header__cart">
                    <i class="icon-cart" aria-hidden="true"></i>
                    <span class="sr-only">Cart</span>
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
