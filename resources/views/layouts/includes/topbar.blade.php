<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            @php
                $logo = $settings->where('key', 'dark_logo')->first()->value ?? '#';
            @endphp
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo">
                    <a href="{{ route('admin.dashboard') }}" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="{{ asset('assets/images/settings/' . $logo) }}" alt="" height="22"
                                loading="lazy">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ asset('assets/images/settings/' . $logo) }}" alt="" height="25"
                                loading="lazy">
                        </span>
                    </a>

                    <a href="{{ route('admin.dashboard') }}" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="{{ asset('assets/images/settings/' . $logo) }}" alt="" height="22"
                                loading="lazy">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ asset('assets/images/settings/' . $logo) }}" alt="" height="25"
                                loading="lazy">
                        </span>
                    </a>
                </div>

                <button type="button"
                    class="px-3 shadow-none btn btn-sm fs-16 header-item vertical-menu-btn topnav-hamburger"
                    id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>
            </div>

            <div class="d-flex align-items-center">

                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-dark rounded-circle"
                        data-toggle="fullscreen">
                        <i class='bi bi-arrows-fullscreen fs-lg'></i>
                    </button>
                </div>

                <div class="dropdown topbar-head-dropdown ms-1 header-item">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-dark rounded-circle mode-layout"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="align-middle bi bi-sun fs-3xl"></i>
                    </button>
                    <div class="p-2 dropdown-menu dropdown-menu-end" id="light-dark-mode">
                        <a href="#!" class="dropdown-item" data-mode="light"><i
                                class="align-middle bi bi-sun me-2"></i> Defualt (light mode)</a>
                        <a href="#!" class="dropdown-item" data-mode="dark"><i
                                class="align-middle bi bi-moon me-2"></i> Dark</a>
                        <a href="#!" class="dropdown-item" data-mode="auto"><i
                                class="align-middle bi bi-moon-stars me-2"></i> Auto (system defualt)</a>
                    </div>
                </div>

                <div class="dropdown ms-sm-3 header-item topbar-user">
                    <button type="button" class="shadow-none btn" id="page-header-user-dropdown"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <img class="rounded-circle header-profile-user"
                                    src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}">
                            @else
                                <img class="rounded-circle header-profile-user" src="assets/images/users/avatar-1.jpg"
                                    alt="Header Avatar">
                            @endif

                            <span class="text-start ms-xl-2">
                                <span
                                    class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{ auth()->user()->name }}</span>
                                <span
                                    class="d-none d-xl-block ms-1 fs-sm user-name-sub-text">{{ ucfirst(auth()->user()->roles->pluck('name')->first()) }}</span>
                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <h6 class="dropdown-header">Welcome {{ auth()->user()->name }}!</h6>
                        <a class="dropdown-item" href="{{ route('profile.show') }}"><i
                                class="align-middle mdi mdi-account-circle text-muted fs-lg me-1"></i> <span
                                class="align-middle">Profile</span></a>
                        <a class="dropdown-item" href="javascript:void(0)"><i
                                class="align-middle mdi mdi-cog-outline text-muted fs-lg me-1"></i> <span
                                class="align-middle">Settings</span></a>
                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <button type="submit" class="dropdown-item" href="javascript:void(0)"><i
                                    class="align-middle mdi mdi-logout text-muted fs-lg me-1"></i> <span
                                    class="align-middle" data-key="t-logout">Logout</span></button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
