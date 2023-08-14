<!-- ========== Topbar Start ========== -->
<div class="navbar-custom border-bottom">
    <div class="topbar container-fluid">
        <div class="d-flex align-items-center gap-lg-2 gap-1">


            <!-- Sidebar Menu Toggle Button -->
            <button class="button-toggle-menu " style="display: inline-block">
                <i class="mdi mdi-menu"></i>
            </button>

            <!-- Horizontal Menu Toggle Button -->
            <button class="navbar-toggle" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                <div class="lines">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </button>


        </div>

        <ul class="topbar-menu d-flex align-items-center gap-3">

            @can("super admin")
            <!-- POS -->
            <li class="d-none d-sm-inline-block">
                <a class="nav-link" href="{{ route('pos') }}" style="
                                                font-size: 18px;
                                                color: white;
                                                background: #e3580e;
                                                display: inline-block;
                                                height: unset;
                                                padding: 4px 17px;
                                                border-radius: 34px;
                                                box-shadow: -3px 3px 5px #ccc;
                                                border: 1px solid #939393ad;
                                            ">
                    POS <i class="uil uil-box"></i>
                </a>
            </li>
            @endcan

            @can("admin")
                <!-- POS -->
                <li class="d-none d-sm-inline-block">
                    <a class="nav-link" href="{{ route('pos') }}" style="
                                            font-size: 18px;
                                            color: white;
                                            background: #e3580e;
                                            display: inline-block;
                                            height: unset;
                                            padding: 4px 17px;
                                            border-radius: 34px;
                                            box-shadow: -3px 3px 5px #ccc;
                                            border: 1px solid #939393ad;
                                        ">
                        POS <i class="uil uil-box"></i>
                    </a>
                </li>
            @endcan

            <li class="d-none d-md-inline-block">
                <a class="nav-link" href="#" data-toggle="fullscreen">
                    <i class="ri-fullscreen-line font-22"></i>
                </a>
            </li>

            <li class="dropdown">
                <a class="nav-link dropdown-toggle arrow-none nav-user px-2" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <span class="account-user-avatar">
                        <img src="users/{{ auth()->user()->image }}" alt="user-image" width="32" class="rounded-circle">
                    </span>
                    <span class="d-lg-flex flex-column gap-1 d-none">
                        <h5 class="my-0">{{ Auth::user()->name ?? "" }}</h5>
                        <h6 class="my-0 fw-normal">{{ Auth::user()->role ?? "" }}</h6>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated profile-dropdown">

                    <!-- Profile -->
                    <a href="{{ route('profile') }}" class="dropdown-item">
                        <i class="mdi mdi-logout me-1"></i>
                        <span>Profile</span>
                    </a>

                    <!-- Log Out -->
                    <a href="javascript:void(0);" class="dropdown-item">
                        <i class="mdi mdi-logout me-1"></i>
                        <form method="post" action="{{ route('auth.logout') }}" style="display: inline;">
                            @csrf
                            <button type="submit" style="border:none; background: none; display: inline;">Logout</button>
                        </form>
                    </a>
                </div>
            </li>
        </ul>
    </div>
</div>
<!-- ========== Topbar End ========== -->
