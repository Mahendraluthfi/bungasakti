<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Log In | CV. Bunga Sakti</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="CV. Bunga Sakti Vendor Management System" />
    <meta name="author" content="Naka Developers" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo base_url() ?>assets/logo/bslogo.png">

    <!-- App css -->
    <link href="<?php echo base_url() ?>assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Icons -->
    <link href="<?php echo base_url() ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />

</head>

<body class="bg-white">
    <!-- Begin page -->
    <div class="account-page">
        <div class="container-fluid p-0">
            <div class="row align-items-center g-0">
                <div class="col-xl-5">
                    <div class="row">
                        <div class="col-md-7 mx-auto">
                            <div class="mb-0 border-0 p-md-5 p-lg-0 p-4">
                                <div class="mb-4 p-0 text-center">
                                    <a href="#" class="auth-logo">
                                        <img src="<?php echo base_url() ?>assets/logo/flatlogo.png" alt="logo-dark" class="mx-auto mb-3" height="70" />
                                    </a>
                                </div>

                                <div class="pt-0">
                                    <?php echo form_open('appLogin/submit') ?>
                                    <div class="form-group mb-3">
                                        <label for="emailaddress" class="form-label">Username</label>
                                        <input class="form-control" name="username" type="text" id="emailaddress" required="" placeholder="Masukan Username">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input class="form-control" name="password" type="password" required="" id="password" placeholder="Masukan Password">
                                    </div>

                                    <?php echo $this->session->flashdata('msg'); ?>
                                    <div class="form-group mb-0 row">
                                        <div class="col-12">
                                            <div class="d-grid">
                                                <button class="btn btn-primary" type="submit"> Log In </button>
                                            </div>
                                        </div>
                                    </div>
                                    <?php echo form_close() ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-7">
                    <div class="account-page-bg p-md-5 p-4">
                        <div class="text-center">
                            <!-- <h3 class="text-dark mb-3 pera-title">Quick, Effective, and Productive With Tapeli Admin Dashboard</h3> -->
                            <div class="auth-image">
                                <img src="<?php echo base_url() ?>assets/logo/banner.png" class="mx-auto img-fluid" alt="images">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- END wrapper -->

    <!-- Vendor -->
    <script src="<?php echo base_url() ?>assets/libs/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url() ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url() ?>assets/libs/simplebar/simplebar.min.js"></script>
    <script src="<?php echo base_url() ?>assets/libs/node-waves/waves.min.js"></script>
    <script src="<?php echo base_url() ?>assets/libs/waypoints/lib/jquery.waypoints.min.js"></script>
    <script src="<?php echo base_url() ?>assets/libs/jquery.counterup/jquery.counterup.min.js"></script>
    <script src="<?php echo base_url() ?>assets/libs/feather-icons/feather.min.js"></script>

    <!-- App js-->
    <script src="<?php echo base_url() ?>assets/js/app.js"></script>

</body>

</html>