<?php
$page = substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'], "/") + 1);
?>

<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link <?= $page == 'index.php' ? 'active' : '' ?>" href="index.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <a class="nav-link <?= $page == 'order-create.php' ? 'active' : '' ?>" href="order-create.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-bell"></i></div>
                    Create Order
                </a>
                <a class="nav-link <?= $page == 'orders.php' ? 'active' : '' ?>" href="orders.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
                    Orders
                </a>
                <a class="nav-link <?= $page == 'credit-orders.php' ? 'active' : '' ?>" href="credit-orders.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
                    Credit Orders
                </a>
                <a class="nav-link <?= $page == 'reports.php' ? 'active' : '' ?>" href="reports.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-simple"></i></div>
                    Report
                </a>
                <div class="sb-sidenav-menu-heading">Interface</div>
                <a class="nav-link <?= ($page == 'category-create.php') || ($page == 'categories.php') ? 'collapse active' : 'collapsed' ?>"
                   href="#" data-bs-toggle="collapse" data-bs-target="#collapseCategories" aria-expanded="false"
                   aria-controls="collapseCategories">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Product attributes
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse <?= ($page == 'category-create.php') || ($page == 'categories.php') ? 'show' : '' ?>"
                     id="collapseCategories" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link <?= $page == 'brand-create.php' ? 'active' : '' ?>" href="brand-create.php">Add
                            Brand</a>
                        <a class="nav-link <?= $page == 'category-create.php' ? 'active' : '' ?>"
                           href="category-create.php">Add Catgeory</a>
                        <a class="nav-link <?= $page == 'type-create.php' ? 'active' : '' ?>" href="type-create.php">Add
                            Type</a>
                        <a class="nav-link <?= $page == 'categories.php' ? 'active' : '' ?>" href="categories.php">View
                            Categories</a>
                    </nav>
                </div>

                <a class="nav-link <?= ($page == 'product-create.php') || ($page == 'products.php') ? 'collapse active' : 'collapsed' ?>"
                   href="#" data-bs-toggle="collapse" data-bs-target="#collapseProducts" aria-expanded="false"
                   aria-controls="collapseProducts">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Products
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse <?= ($page == 'product-create.php') || ($page == 'products.php') ? 'show' : '' ?>"
                     id="collapseProducts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link <?= $page == 'product-create.php' ? 'active' : '' ?>"
                           href="product-create.php">Add Product</a>
                        <a class="nav-link <?= $page == 'retail-product-create.php' ? 'active' : '' ?>"
                           href="retail-product-create.php">Add Retail Product</a>
                        <a class="nav-link <?= $page == 'grn.php' ? 'active' : '' ?>"
                           href="grn.php">Product Return</a>
                    </nav>
                </div>
                <div class="sb-sidenav-menu-heading">Manage Stores</div>
                <a class="nav-link <?= ($page == 'customer-create.php') || ($page == 'customers.php') ? 'collapse active' : 'collapsed' ?>"
                   href="#" data-bs-toggle="collapse" data-bs-target="#collapseStores" aria-expanded="false"
                   aria-controls="collapseCustomers">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Stores
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse <?= ($page == 'store-create.php') || ($page == 'store-transfers.php') ? 'show' : '' ?>"
                     id="collapseStores" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link <?= $page == 'store-create.php' ? 'active' : '' ?>"
                           href="store-create.php">Add STORE</a>
                        <a class="nav-link <?= $page == 'store-transfers.php' ? 'active' : '' ?>" href="store-transfers.php">Store
                            Transfers</a>
                    </nav>
                </div>

                <div class="sb-sidenav-menu-heading">Manage Users</div>
                <a class="nav-link <?= ($page == 'customer-create.php') || ($page == 'customers.php') ? 'collapse active' : 'collapsed' ?>"
                   href="#" data-bs-toggle="collapse" data-bs-target="#collapseCustomers" aria-expanded="false"
                   aria-controls="collapseCustomers">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Customers
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse <?= ($page == 'customer-create.php') || ($page == 'customers.php') ? 'show' : '' ?>"
                     id="collapseCustomers" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link <?= $page == 'customer-create.php' ? 'active' : '' ?>"
                           href="customer-create.php">Add Customer</a>
                        <a class="nav-link <?= $page == 'customers.php' ? 'active' : '' ?>" href="customers.php">View
                            Customers</a>
                    </nav>
                </div>
                <?php if ($_SESSION['isAdmin']) { ?>
                    <a class="nav-link <?= ($page == 'admin-create.php') || ($page == 'admins.php') ? 'collapse active' : 'collapsed' ?>"
                       href="#" data-bs-toggle="collapse" data-bs-target="#collapseAdmins" aria-expanded="false"
                       aria-controls="collapseAdmins">
                        <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                        Admin Portal
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>

                    <div class="collapse <?= ($page == 'admin-create.php') || ($page == 'admins.php') ? 'show' : '' ?>"
                         id="collapseAdmins" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link <?= $page == 'admin-create.php' ? 'active' : '' ?>"
                               href="admin-create.php">Add Admin</a>
                            <a class="nav-link <?= $page == 'admins.php' ? 'active' : '' ?>" href="admins.php">View
                                Admins</a>
                            <a class="nav-link <?= $page == 'scrap.php' ? 'active' : '' ?>" href="scrap.php">Scraps</a>
                            <a class="nav-link <?= $page == 'profit.php' ? 'active' : '' ?>"
                               href="profit.php">Profits</a>
                        </nav>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            <?= ($_SESSION['loggedInUser']['name']) ?>
        </div>
    </nav>
</div>