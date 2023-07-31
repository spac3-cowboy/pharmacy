<!-- ========== Left Sidebar Start ========== -->
<div class="leftside-menu" style="background: black;">

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

            <!-- Tenants -->
            @can("super-admin")
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarTenant" aria-expanded="false" aria-controls="sidebarTenant" class="side-nav-link">
                    <i class="ri-home-4-fill"></i>
                    <span> Tenants </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarTenant">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('tenants.index') }}">
                                <i class="mdi mdi-format-list-numbered"></i>
                                Tenant List
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('tenants.create') }}">
                                <i class="mdi mdi-format-list-numbered"></i>
                                New Tenant
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @endcan

            <!-- Dashboard -->
            <li class="side-nav-item">
                <a href="{{ route('dashboard') }}" class="side-nav-link">
                    <i class="ri-dashboard-line"></i>
                    <span> Dashboards </span>
                </a>
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

            <!-- Vendor -->
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarVendor" aria-expanded="false" aria-controls="sidebarVendor" class="side-nav-link">
                    <i class="mdi mdi-window-open-variant"></i>
                    <span> Vendors </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarVendor">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('vendors.index') }}">
                                <i class="mdi mdi-format-list-numbered"></i>
                                Vendors List
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('vendors.create') }}">
                                <i class="mdi mdi-bank-plus"></i>
                                Add Vendor
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
                        <li>
                            <a href="{{ route('units.index') }}">
                                <i class="mdi mdi-format-list-numbered"></i>
                                Unit List
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
                    <i class="mdi mdi-account-cash"></i>
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
                                <i class="mdi mdi-basket-plus"></i>
                                New Purchase
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Sales -->
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarSales" aria-expanded="false" aria-controls="sidebarSales" class="side-nav-link">
                    <i class="uil uil-moneybag"></i>
                    <span> Sales </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarSales">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('sales.index') }}">
                                <i class="mdi mdi-format-list-numbered"></i>
                                Sales List
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('pos') }}">
                                <i class="mdi mdi-basket-plus"></i>
                                New Sale
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Reports -->
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarReport" aria-expanded="false" aria-controls="sidebarReport" class="side-nav-link">
                    <i class="ri-line-chart-line"></i>
                    <span> Reports </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarReport">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('reports.sales') }}">
                                <i class="mdi mdi-format-list-numbered"></i>
                                Sales Report
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('reports.purchase') }}">
                                <i class="mdi mdi-format-list-numbered"></i>
                                Purchase Report
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('reports.topsoldmedicines') }}">
                                <i class="mdi mdi-format-list-numbered"></i>
                                Top Sold Medicines
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('reports.profit') }}">
                                <i class="mdi mdi-format-list-numbered"></i>
                                Profit
                            </a>
                        </li>
                    </ul>
                </div>
            </li>


            <!-- Settings -->
            <li class="side-nav-item">
                <a href="{{ route('settings.index') }}" class="side-nav-link">
                    <i class="ri-settings-4-fill"></i>
                    <span> Settings </span>
                    <span class="menu-arrow"></span>
                </a>
            </li>

        </ul>
        <!--- End Sidemenu -->

        <div class="clearfix"></div>
    </div>
</div>
<!-- ========== Left Sidebar End ========== -->
