<div class="navbar navbar-expand-lg shadow-sm" id="page-topbar">
    <div class="container-fluid">
        <div class="d-flex w-100 align-items-center">
            <!-- Left Side: Brand and Admin Button -->
            <div class="d-flex align-items-center">
                <a class="navbar-brand d-none d-sm-block" href="{{route('home')}}">
                    <h2 class="m-0 text-primary font-24">{{ __('message.jigjiga') }}</h2>
                </a>

                @if (isAdminPanel())
                    <button type="button" class="btn-sm px-3 font-24 header-item ms-2" id="vertical-menu-btn">
                        <i class="ri-indent-decrease"></i>
                    </button>
                @endif
            </div>

            <!-- Right Side: User Controls -->
            <div class="d-flex align-items-center ms-auto">
                <!-- Language Dropdown -->
                <div class="dropdown d-inline-block">
                    <button type="button" class="header-item noti-icon" id="page-header-languages-dropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset('assets/images/lang.jpg') }}"
                            alt="{{ selectedLanguage()->name ?? 'English' }}"
                            title="{{ selectedLanguage()->name ?? 'English' }}"
                            class="rounded-circle avatar-xs fit-image text black">
                    </button>

                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="page-header-languages-dropdown">
                        <div>
                            @foreach (languages() as $language)
                                <a href="{{ route('local', $language->code) }}"
                                    class="dropdown-item {{ app()->getLocale() == $language->code ? 'active' : '' }}"
                                    title="{{ $language->code }}">
                                    <div class="d-flex">
                                        <img src="{{ asset('assets/images/lang.jpg') }}"
                                            class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                        <div class="flex-1">{{ $language->name ?? 'English' }}</div>
                                    </div>
                                </a>
                            @endforeach

                        </div>
                    </div>
                </div>

                @if (Auth::check())
                    <div class="dropdown d-inline-block ms-2 user-dropdown">
                        <button type="button" class="header-item" id="page-header-user-dropdown" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <img class="rounded-circle avatar-xs fit-image header-profile-user"
                                src="{{ getSingleImage(auth()->user(), 'profile_image') }}" alt="Header Avatar">
                            <span class="d-none d-xl-inline-block ms-1 font-medium">{{ auth()->user()->name }}</span>
                            <i class="mdi mdi-chevron-down d-xl-inline-block"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end py-1" aria-labelledby="page-header-user-dropdown">
                            <a class="dropdown-item" href="{{ route(userPrefix() . '.profile') }}"><i
                                    class="ri-user-line align-middle me-1 "></i> {{ __('message.profile') }}</a>

                            @if (isTenant())
                                <a class="dropdown-item" href="{{ route(userPrefix() . '.change-password') }}"><i
                                        class="ri-lock-2-line align-middle me-1"></i>
                                    {{ __('message.change_password') }}</a>
                                <a class="dropdown-item" href="{{ route(userPrefix() . '.messages') }}"><i
                                        class="ri-mail-lock-line align-middle me-1"></i>
                                    {{ __('message.message') }}
                                    @if (getUnreadMessage() > 0)
                                        <span class="badge bg-success rounded-pill">{{ getUnreadMessage() }}</span>
                                    @endif
                                </a>
                            @endif

                            @if (isAdmin())
                                <a class="dropdown-item" href="{{ route('admin.setting') }}"><i
                                        class="ri-settings-2-line align-middle me-1"></i> {{ __('message.settings') }}</a>
                            @endif

                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="ri-shut-down-line align-middle me-1"></i> {{ __('message.logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Mobile Toggler -->
            @if (!isAdminPanel())
                <button class="navbar-toggler d-lg-none ms-2" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarContent">
                    <span class="navbar-toggler-icon"></span>
                </button>
            @endif
        </div>
        <!-- Navigation Links (Will collapse on mobile) -->
        @if (!isAdminPanel())
            <div class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <div class="collapse navbar-collapse" id="navbarContent">
                        <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                            @if (isAdmin() || isOwner())
                                <li class="nav-item">
                                    <a class="nav-link active h2" href="{{route('dashboard')}}">Dashboard</a>
                                </li>
                            @endif

                            <li class="nav-item">
                                <a class="nav-link text-nowrap h3" href="#about">Contact Us</a>
                            </li>
                            <li class="nav-item me-2">
                                <a class="nav-link text-nowrap h3" href="#about">About Us</a>
                            </li>
                            <li class="nav-item me-2">
                                <a class="nav-link text-nowrap h3" href="#about">Faq</a>
                            </li>

                            @if (!Auth::check())

                                <li class="nav-item me-2">
                                    <a class="btn btn-outline-dark text-nowrap mb-2" href="{{ route('register') }}">Sign
                                        Up</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('login')}}"><button class="btn btn-success text-nowrap mb-2">Sign
                                            In</button></a>
                                </li>
                            @endif

                        </ul>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>