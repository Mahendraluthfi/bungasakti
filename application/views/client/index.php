<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>CV. BUNGA SAKTI</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="CV. Bunga Sakti Vendor Management System" />
    <meta name="author" content="Naka Developers" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo base_url() ?>assets/logo/bslogo.png">

    <!-- Datatables css -->
    <link href="<?php echo base_url() ?>assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url() ?>assets/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url() ?>assets/libs/datatables.net-keytable-bs5/css/keyTable.bootstrap5.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url() ?>assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url() ?>assets/libs/datatables.net-select-bs5/css/select.bootstrap5.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.0/dist/css/tom-select.css" rel="stylesheet">

    <!-- App css -->
    <link href="<?php echo base_url() ?>assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style">

    <!-- Icons -->
    <link href="<?php echo base_url() ?>assets/css/icons.min.css" rel="stylesheet" type="text/css">
    <script src="<?php echo base_url() ?>assets/libs/jquery/jquery.min.js"></script>

</head>

<!-- body start -->

<body data-menu-color="light" data-sidebar="default">

    <!-- Begin page -->
    <div id="app-layout">
        <!-- Topbar Start -->
        <div class="topbar-custom">
            <div class="container-xxl">
                <div class="d-flex justify-content-between">
                    <ul class="list-unstyled topnav-menu mb-0 d-flex align-items-center">
                        <li>
                            <button class="button-toggle-menu nav-link ps-0">
                                <i data-feather="menu" class="noti-icon"></i>
                            </button>
                        </li>
                        <li class="d-none d-lg-block">
                            <div class="position-relative topbar-search"></div>
                        </li>
                    </ul>

                    <ul class="list-unstyled topnav-menu mb-0 d-flex align-items-center">
                        <li class="dropdown notification-list topbar-dropdown">
                            <a class="nav-link dropdown-toggle nav-user me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <img src="<?php echo base_url() ?>assets/logo/user.png" alt="user-image" class="rounded-circle">
                                <span class="pro-user-name ms-1">
                                    <?php echo $this->session->userdata('sessionName') ?> <i class="mdi mdi-chevron-down"></i>
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end profile-dropdown ">
                                <!-- item-->
                                <div class="dropdown-header noti-title">
                                    <h6 class="text-overflow m-0"><?php echo $this->session->userdata('sessionUsernameCustomer') ?></h6>
                                </div>

                                <a href="<?php echo base_url('login/logout') ?>" class="dropdown-item notify-item">
                                    <i class="mdi mdi-location-exit fs-16 align-middle"></i>
                                    <span>Logout</span>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- end Topbar -->

        <!-- Left Sidebar Start -->
        <div class="app-sidebar-menu">
            <div class="h-100" data-simplebar>
                <!--- Sidemenu -->
                <div id="sidebar-menu">
                    <div class="logo-box">
                        <a href="<?php echo base_url() ?>" class="logo logo-light">
                            <span class="logo-sm">
                                <img src="<?php echo base_url() ?>assets/logo/flatlogo.png" alt="" height="30">
                            </span>
                            <span class="logo-lg">
                                <img src="<?php echo base_url() ?>assets/logo/flatlogo.png" alt="" height="45">
                            </span>
                        </a>
                        <a href="<?php echo base_url() ?>" class="logo logo-dark">
                            <span class="logo-sm">
                                <img src="<?php echo base_url() ?>assets/logo/flatlogo.png" alt="" height="30">
                            </span>
                            <span class="logo-lg">
                                <img src="<?php echo base_url() ?>assets/logo/flatlogo.png" alt="" height="45">
                            </span>
                        </a>
                    </div>
                    <ul id="side-menu">
                        <li class="menu-title">Menu</li>
                        <li>
                            <a href="<?php echo base_url('clientHome') ?>" class="tp-link">
                                <i data-feather="home"></i>
                                <span> Dashboard </span>
                            </a>
                        </li>
                        <li class="menu-title">Pages</li>
                        <li>
                            <a href="<?php echo base_url('clientPurchase') ?>" class="tp-link">
                                <i data-feather="shopping-cart"></i>
                                <span> Purchase Request </span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('clientInvoices') ?>" class="tp-link">
                                <i data-feather="file-text"></i>
                                <span>Invoices</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('profile') ?>" class="tp-link">
                                <i data-feather="user"></i>
                                <span> Profile </span>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- End Sidebar -->
                <div class="clearfix"></div>
            </div>
        </div>
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">
                <?php $this->load->view($content); ?>
            </div> <!-- content -->

            <!-- Footer Start -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col fs-13 text-muted text-center">
                            &copy; <script>
                                document.write(new Date().getFullYear())
                            </script> - by <a href="#!" class="text-reset fw-semibold">Naka Solutions</a>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- end Footer -->

        </div>
        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->


    </div>
    <!-- END wrapper -->

    <!-- Vendor -->
    <script src="<?php echo base_url() ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url() ?>assets/libs/simplebar/simplebar.min.js"></script>
    <script src="<?php echo base_url() ?>assets/libs/node-waves/waves.min.js"></script>
    <script src="<?php echo base_url() ?>assets/libs/waypoints/lib/jquery.waypoints.min.js"></script>
    <script src="<?php echo base_url() ?>assets/libs/jquery.counterup/jquery.counterup.min.js"></script>
    <script src="<?php echo base_url() ?>assets/libs/feather-icons/feather.min.js"></script>

    <!-- Datatables js -->
    <script src="<?php echo base_url() ?>assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>

    <!-- dataTables.bootstrap5 -->
    <script src="<?php echo base_url() ?>assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
    <script src="<?php echo base_url() ?>assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>

    <!-- buttons.colVis -->
    <script src="<?php echo base_url() ?>assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>
    <script src="<?php echo base_url() ?>assets/libs/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="<?php echo base_url() ?>assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="<?php echo base_url() ?>assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>

    <!-- buttons.bootstrap5 -->
    <script src="<?php echo base_url() ?>assets/libs/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js"></script>

    <!-- dataTables.keyTable -->
    <script src="<?php echo base_url() ?>assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="<?php echo base_url() ?>assets/libs/datatables.net-keytable-bs5/js/keyTable.bootstrap5.min.js"></script>

    <!-- dataTable.responsive -->
    <script src="<?php echo base_url() ?>assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?php echo base_url() ?>assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>

    <!-- dataTables.select -->
    <script src="<?php echo base_url() ?>assets/libs/datatables.net-select/js/dataTables.select.min.js"></script>
    <script src="<?php echo base_url() ?>assets/libs/datatables.net-select-bs5/js/select.bootstrap5.min.js"></script>

    <!-- App js-->
    <script src="<?php echo base_url() ?>assets/js/app.js"></script>
    <script src="<?php echo base_url() ?>assets/js/pages/datatable.init.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.0/dist/js/tom-select.complete.min.js"></script>
    <script>
        new TomSelect("#select-beast", {
            create: false,
            sortField: {
                field: "text",
                direction: "asc"
            }
        });
    </script>
</body>

</html>