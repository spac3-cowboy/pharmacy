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

            <!-- POS -->
            <li class="d-none d-sm-inline-block">
                <a class="nav-link" style="font-size: 36px;" href="{{ route('pos') }}">
                    <i class="uil uil-box"></i>
                </a>
            </li>


            <li class="d-none d-md-inline-block">
                <a class="nav-link" href="#" data-toggle="fullscreen">
                    <i class="ri-fullscreen-line font-22"></i>
                </a>
            </li>

            <li class="dropdown">
                <a class="nav-link dropdown-toggle arrow-none nav-user px-2" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <span class="account-user-avatar">
                        <img src="/assets/images/users/avatar-1.jpg" alt="user-image" width="32" class="rounded-circle">
                    </span>
                    <span class="d-lg-flex flex-column gap-1 d-none">
                        <h5 class="my-0">{{ Auth::user()->name ?? "" }}</h5>
                        <h6 class="my-0 fw-normal">{{ Auth::user()->role ?? "" }}</h6>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated profile-dropdown">



                    <!-- item-->
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
