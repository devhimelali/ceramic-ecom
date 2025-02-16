<div class="app-menu navbar-menu">
    @php
        $logo = $settings->where('key', 'dark_logo')->first()->value ?? '#';
    @endphp
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="{{ route('admin.dashboard') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('assets/images/settings/' . $logo) }}" alt="" height="36">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('assets/images/settings/' . $logo) }}" alt="" height="36">
            </span>
        </a>
        <a href="{{ route('admin.dashboard') }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset('assets/images/settings/' . $logo) }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('assets/images/settings/' . $logo) }}" alt="" height="48">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-3xl header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">

                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link menu-link {{ $active == 'dashboard' ? 'active' : '' }}" aria-expanded="false">
                        <i class="ph-gauge"></i>
                        <span data-key="t-dashboards">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('brands.index') }}"
                        class="nav-link menu-link {{ $active == 'brand' ? 'active' : '' }}" aria-expanded="false">
                        <i class="ph-gauge"></i>
                        <span data-key="t-dashboards">Brand</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('categories.index') }}"
                        class="nav-link menu-link {{ $active == 'category' ? 'active' : '' }}" aria-expanded="false">
                        <i class="ph-gauge"></i>
                        <span data-key="t-dashboards">Category</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('orders.index') }}"
                        class="nav-link menu-link {{ $active == 'order' ? 'active' : '' }}" aria-expanded="false">
                        <i class="ph-gauge"></i>
                        <span data-key="t-dashboards">Orders</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('attributes.index') }}"
                        class="nav-link menu-link {{ $active == 'attribute' ? 'active' : '' }}" aria-expanded="false">
                        <i class="ph-gauge"></i>
                        <span data-key="t-dashboards">Attribute</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('products.index') }}"
                        class="nav-link menu-link {{ $active == 'products' ? 'active' : '' }}" aria-expanded="false">
                        <i class="ph ph-package"></i>
                        <span data-key="t-dashboards">Products</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('product.queries') }}"
                        class="nav-link menu-link {{ $active == 'product_query' ? 'active' : '' }}"
                        aria-expanded="false">
                        <i class="ph ph-address-book"></i>
                        <span data-key="t-dashboards">Product Queries</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('contacts.index') }}"
                        class="nav-link menu-link {{ $active == 'contacts' ? 'active' : '' }}" aria-expanded="false">
                        <i class="ph ph-address-book"></i>
                        <span data-key="t-dashboards">Contacts</span>
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a href="{{ route('settings.index') }}"
                        class="nav-link menu-link {{ $active == 'settings' ? 'active' : '' }}" aria-expanded="false">
                        <i class="ph-gear"></i>
                        <span data-key="t-dashboards">Settings</span>
                    </a>
                    <a href="{{ route('settings.aboutPage') }}"
                        class="nav-link menu-link {{ $active == 'settings' ? 'active' : '' }}" aria-expanded="false">
                        <i class="ph-gear"></i>
                        <span data-key="t-dashboards">About Page</span>
                    </a>
                </li> --}}

                <li class="nav-item">
                    <a class="nav-link menu-link {{ $active == 'settings' || $active == 'about' ? 'active' : '' }}"
                        href="#settings" data-bs-toggle="collapse" role="button" aria-expanded="true"
                        aria-controls="settings">
                        <i class="ph-gear"></i> <span data-key="t-dashboards">Settings</span>
                    </a>
                    <div class="menu-dropdown collapse {{ $active == 'settings' || $active == 'about' || $active == 'home' ? 'show' : '' }}"
                        id="settings" style="">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('settings.index') }}"
                                    class="nav-link {{ $active == 'settings' ? 'active' : '' }}"
                                    data-key="t-analytics">Settings</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('sliders.index') }}"
                                    class="nav-link {{ $active == 'home' ? 'active' : '' }}"
                                    data-key="t-analytics">Home Page</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('settings.aboutPageChange') }}" target="_blank"
                                    class="nav-link {{ $active == 'about' ? 'active' : '' }}"
                                    data-key="t-analytics">About
                                    Page</a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>
