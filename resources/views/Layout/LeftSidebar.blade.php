<!-- ========== Left Sidebar Start ========== -->
<div class="leftside-menu">

    <!-- Brand Logo Light -->
    <a href="/" class="logo logo-light" style="background: #262d36;">
        <span class="logo-lg">
            <img src="/assets/images/sitelogo.png" alt="logo" style="height: 2.5em;">
        </span>
        <span class="logo-sm">
            <img src="/assets/images/sitelogo.png" alt="small logo">
        </span>
    </a>

    <!-- Brand Logo Dark -->
    <a href="/" class="logo logo-dark">
        <span class="logo-lg">
            <img src="/assets/images/sitelogo.png" alt="dark logo">
        </span>
        <span class="logo-sm">
            <img src="/assets/images/sitelogo.png" alt="small logo">
        </span>
    </a>

    <!-- Sidebar Hover Menu Toggle Button -->
    <div class="button-sm-hover" data-bs-toggle="tooltip" data-bs-placement="right" title="Show Full Sidebar">
        <i class="ri-checkbox-blank-circle-line align-middle"></i>
    </div>

    <!-- Full Sidebar Menu Close Button -->
    <div class="button-close-fullsidebar">
        <i class="ri-close-fill align-middle"></i>
    </div>

    <!-- Sidebar -left -->
    <div class="h-100" id="leftside-menu-container" data-simplebar>
        <!-- Leftbar User -->
        <div class="leftbar-user">
            <a href="pages-profile.html">
                <img src="assets/images/users/avatar-1.jpg" alt="user-image" height="42" class="rounded-circle shadow-sm">
                <span class="leftbar-user-name mt-2">Dominic Keller</span>
            </a>
        </div>

        <!--- Sidemenu -->
        <ul class="side-nav">

            <!-- Dashboard -->
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarDashboards" aria-expanded="false"
                   aria-controls="sidebarDashboards" class="side-nav-link">
                    <i class="ri-dashboard-line"></i>
                    <span class="badge bg-success float-end">5</span>
                    <span> Dashboards </span>
                </a>
                <div class="collapse" id="sidebarDashboards">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="dashboard-analytics.html">Analytics</a>
                        </li>
                        <li>
                            <a href="index.html">Ecommerce</a>
                        </li>
                        <li>
                            <a href="dashboard-projects.html">Projects</a>
                        </li>
                        <li>
                            <a href="dashboard-crm.html">CRM</a>
                        </li>
                        <li>
                            <a href="dashboard-wallet.html">E-Wallet</a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Customer -->
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarEcommerce" aria-expanded="false"
                   aria-controls="sidebarEcommerce" class="side-nav-link">
                    <i class="mdi mdi-account-group"></i>
                    <span> Customers </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarEcommerce">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('customers.index') }}">
                                <i class="mdi mdi-account-details"></i>
                                Customer List
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('customers.create') }}">
                                <i class="mdi mdi-account-multiple-plus-outline"></i>
                                Add Customer
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Manufacturer -->
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarManufacturer" aria-expanded="false" aria-controls="sidebarManufacturer" class="side-nav-link">
                    <i class="mdi mdi-window-open-variant"></i>
                    <span> Manufacturers </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarManufacturer">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('manufacturers.index') }}">
                                <i class="mdi mdi-format-list-numbered"></i>
                                Manufacturer List
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('manufacturers.create') }}">
                                <i class="mdi mdi-bank-plus"></i>
                                Add Manufacturer
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Medicine -->
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarMedicine" aria-expanded="false" aria-controls="sidebarMedicine" class="side-nav-link">
                    <i class="mdi mdi-pill"></i>
                    <span> Medicine </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarMedicine">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('medicines.index') }}">
                                <i class="mdi mdi-format-list-numbered"></i>
                                Medicine List
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('medicines.create') }}">
                                <i class="mdi mdi-account-multiple-plus-outline"></i>
                                Add Medicine
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('categories.index') }}">
                                <i class="mdi mdi-format-list-numbered"></i>
                                Categories List
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Stock -->
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarStock" aria-expanded="false" aria-controls="sidebarStock" class="side-nav-link">
                    <i class="uil uil-coins"></i>
                    <span> Stock </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarStock">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('stocks.instock') }}">
                                <i class="mdi mdi-account-multiple-plus-outline"></i>
                                In Stock
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('stocks.emergencystock') }}">
                                <i class="mdi mdi-format-list-numbered"></i>
                                Emergency Stock
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('stocks.outofstock') }}">
                                <i class="mdi mdi-format-list-numbered"></i>
                                Out Of Stock
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('stocks.expiredstock') }}">
                                <i class="mdi mdi-format-list-numbered"></i>
                                Expired Stock
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('stocks.tobeexpired') }}">
                                <i class="mdi mdi-format-list-numbered"></i>
                                To Be Expired
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Purchase -->
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarPurchase" aria-expanded="false" aria-controls="sidebarPurchase" class="side-nav-link">
                    <i class="uil uil-moneybag"></i>
                    <span> Purchase </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarPurchase">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('purchases.index') }}">
                                <i class="mdi mdi-format-list-numbered"></i>
                                Purchase List
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('purchases.create') }}">
                                <i class="mdi mdi-format-list-numbered"></i>
                                New Purchase
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

        </ul>
        <!--- End Sidemenu -->

        <div class="clearfix"></div>
    </div>
</div>
<!-- ========== Left Sidebar End ========== -->
