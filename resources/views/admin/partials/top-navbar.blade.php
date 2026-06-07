@php
use Illuminate\Support\Facades\URL;
$userId = Auth::user()->id;
@endphp

<style>
    .topbar .top-navbar {
        height: 60px !important;
    }

    .logo-img {
        width: 219px;
        height: 56px;
    }

    @media only screen and (max-width: 600px) {
        .logo-img {
            width: 169px;
        }

        .topbar .top-navbar .navbar-header {
            min-width: 170px;
        }


    }
</style>

<header class="topbar noprint">
    <nav class="navbar top-navbar navbar-expand-md navbar-dark">
        <!-- Logo -->
        <div class="navbar-header">
            <a class="navbar-brand" href="{{ url('/admin') }}">
                <!-- Logo icon -->
                <b>
                    <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                    <!-- Dark Small Logo icon -->
                    {{-- <img src="{{ asset('public/elite-admin/assets/images/logo-icon.jpg') }}" alt="homepage"
                        class="dark-logo" /> --}}

                    <!-- Light Small Logo icon -->
                    <img src="{{ asset('public/elite-admin/assets/images/logo-icon.jpg') }}" style="" alt="homepage"
                        class="light-logo logo-img" />
                </b>
                <!--End Logo icon -->

                <!-- Logo text -->
                {{-- <span>
                    <!-- Dark Large Logo text -->
                    <img src="{{ asset('public/elite-admin/assets/images/logo-text.jpg') }}" alt="homepage"
                        class="dark-logo" />

                    <!-- Light Large Logo text -->
                    <img src="{{ asset('public/elite-admin/assets/images/logo-icon.jpg') }}" class="light-logo"
                        alt="homepage" />
                </span> --}}
            </a>
        </div>
        <!-- End Logo -->

        <div class="navbar-collapse">
            <!-- toggle and nav items -->
            <ul class="navbar-nav">
                <!-- This is  -->
                <li class="nav-item">
                    <a class="nav-link nav-toggler d-block d-md-none waves-effect waves-dark" href="javascript:void(0)">
                        <i class="ti-menu"></i>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link sidebartoggler d-none d-lg-block d-md-block waves-effect waves-dark"
                        href="javascript:void(0)">
                        <i class="icon-menu"></i>
                    </a>
                </li>
            </ul>

            <div class="mr-auto d-block d-md-none"></div>

            <div class="d-none d-md-block h2 mr-auto text-white text-roboto">Mannan Plaza</div>


            <!-- User profile and search -->
            <ul class="navbar-nav my-lg-0">
                <!-- User Profile -->
                <li class="nav-item dropdown u-pro">
                    <a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic" href="#"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                        @if (Auth::user()->image)
                        <img src="{{ asset(Auth::user()->image) }}" class="img-thumbnail" alt="User Image" width="100px"
                            height="100px">
                        @else
                        <img src="{{ asset('public/elite-admin/assets/images/users/1.jpg') }}" class="img-thumbnail"
                            alt="User Image" width="100px" height="100px">
                        @endif

                        <span class="hidden-md-down">
                            {{ Auth::user() ? Auth::user()->name : 'Admin' }} &nbsp;<i class="fa fa-angle-down"></i>
                        </span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right animated flipInY">
                        <!-- text-->
                        <a href="{{ route('user.myProfile', [$userId, 1]) }}" class="dropdown-item">
                            <i class="ti-user"></i> My Profile
                        </a>

                        <!-- text-->
                        <a href="{{ route('user.changePassword', [$userId, 1]) }}" class="dropdown-item">
                            <i class="ti-wallet"></i> Change Password
                        </a>

                        <!-- text-->
                        <div class="dropdown-divider"></div>

                        <!-- text-->
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>

                        <a href="{{ Auth::guard('admin')->check() ? route('admin.logout') : (Auth::guard('web')->check() ? route('user.logout') : (Auth::guard('customer')->check() ? route('customer.logout') : route('logout'))) }}"
                            class="dropdown-item"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="dropdown-item">
                            <i class="fa fa-power-off"></i> Logout
                        </a>
                        <!-- text-->
                    </div>
                </li>
                <!-- End User Profile -->

                <li class="nav-item right-side-toggle">
                    <a class="nav-link  waves-effect waves-light" href="javascript:void(0)">
                        <i class="ti-settings"></i>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</header>
