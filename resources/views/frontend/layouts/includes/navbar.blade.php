<header class="main-header main-header--one sticky-header sticky-header--normal">
    <div class="container-fluid">
        <div class="main-header__inner">
            <div class="main-header__logo">
                <a href="#">
                    <img src="{{ app_setting('dark_logo') ?? app_setting('light_logo') }}"
                        alt="{{ app_setting('site_name') }}" width="125">
                    {{-- {{ asset('frontend') }}/assets/images/logo-dark.png --}}
                </a>
            </div><!-- /.main-header__logo -->

            <div class="main-header__right">
                <nav class="main-header__nav main-menu">
                    <ul class="main-menu__list">

                        <li class="{{ $active == 'home' ? 'current' : '' }}">
                            <a href="#">Home</a>
                        </li>

                        <li class="dropdown {{ $active == 'category' ? 'current' : '' }}">
                            <a href="#">Category</a>
                            <ul>
                                @foreach (category_show() as $category)
                                    {{-- <li><a href="#">Team Details</a></li> --}}
                                    <li>
                                        <a href="#">Work</a>
                                        @if (count($category->children) > 0)
                                            <ul>
                                                <li><a href="#">Work</a></li>
                                                <li><a href="#">Work Grid</a></li>
                                                <li><a href="#">Work Carousel</a></li>
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach


                            </ul>
                        </li>
                        <li class="{{ $active == 'about' ? 'current' : '' }}">
                            <a href="#">About</a>
                        </li>
                        <li class="{{ $active == 'services' ? 'current' : '' }}">
                            <a href="#">Services</a>
                        </li>
                        <li class="{{ $active == 'contact' ? 'current' : '' }}">
                            <a href="#">Contact</a>
                        </li>
                    </ul>
                </nav><!-- /.main-header__nav -->
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
                <button class="main-header__sidebar-btn sidebar-btn__toggler">
                    <span class="icon-grid"></span>
                </button><!-- /.main-header__sidebar-btn sidebar-btn__toggler -->
                <a href="tel:(502)203-7840"
                    class="main-header__phone">{{ app_setting('phone') }}</a><!-- /.main-header__phone -->
            </div><!-- /.main-header__right -->
        </div><!-- /.main-header__inner -->
    </div><!-- /.container-fluid -->
</header><!-- /.main-header -->
