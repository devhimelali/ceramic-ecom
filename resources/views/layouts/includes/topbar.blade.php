<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo">
                    <a href="index.html" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="assets/images/logo-sm.png" alt="" height="22">
                                </span>
                        <span class="logo-lg">
                                    <img src="assets/images/logo-dark.png" alt="" height="25">
                                </span>
                    </a>

                    <a href="index.html" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="assets/images/logo-sm.png" alt="" height="22">
                                </span>
                        <span class="logo-lg">
                                    <img src="assets/images/logo-light.png" alt="" height="25">
                                </span>
                    </a>
                </div>

                <button type="button"
                        class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger shadow-none"
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
                    <button type="button"
                            class="btn btn-icon btn-topbar btn-ghost-dark rounded-circle mode-layout"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="bi bi-sun align-middle fs-3xl"></i>
                    </button>
                    <div class="dropdown-menu p-2 dropdown-menu-end" id="light-dark-mode">
                        <a href="#!" class="dropdown-item" data-mode="light"><i
                                class="bi bi-sun align-middle me-2"></i> Defualt (light mode)</a>
                        <a href="#!" class="dropdown-item" data-mode="dark"><i
                                class="bi bi-moon align-middle me-2"></i> Dark</a>
                        <a href="#!" class="dropdown-item" data-mode="auto"><i
                                class="bi bi-moon-stars align-middle me-2"></i> Auto (system defualt)</a>
                    </div>
                </div>

                <div class="dropdown ms-sm-3 header-item topbar-user">
                    <button type="button" class="btn shadow-none" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="d-flex align-items-center">
                                    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                        <img class="rounded-circle header-profile-user"
                                             src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}">
                                    @else
                                        <img class="rounded-circle header-profile-user"
                                             src="assets/images/users/avatar-1.jpg" alt="Header Avatar">
                                    @endif

                                    <span class="text-start ms-xl-2">
                                        <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{auth()->user()->name}}</span>
                                        <span class="d-none d-xl-block ms-1 fs-sm user-name-sub-text">{{ ucfirst(auth()->user()->roles->pluck('name')->first()) }}</span>
                                    </span>
                                </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <h6 class="dropdown-header">Welcome {{auth()->user()->name}}!</h6>
                        <a class="dropdown-item" href="{{route('profile.show')}}"><i
                                class="mdi mdi-account-circle text-muted fs-lg align-middle me-1"></i> <span
                                class="align-middle">Profile</span></a>
                        <a class="dropdown-item" href="javascript:void(0)"><i
                                class="mdi mdi-cog-outline text-muted fs-lg align-middle me-1"></i> <span
                                class="align-middle">Settings</span></a>
                        <form action="{{route('logout')}}" method="post">
                            @csrf
                            <button type="submit" class="dropdown-item" href="javascript:void(0)"><i
                                    class="mdi mdi-logout text-muted fs-lg align-middle me-1"></i> <span
                                    class="align-middle" data-key="t-logout">Logout</span></button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
