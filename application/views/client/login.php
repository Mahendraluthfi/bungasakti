<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="CV. Bunga Sakti Vendor Management System" />
    <meta name="author" content="Naka Developers" />
    <title>Log In | CV. Bunga Sakti</title>
    <link rel="shortcut icon" href="<?php echo base_url() ?>assets/logo/bslogo.png">
    <link href="<?php echo base_url() ?>template/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>template/css/common.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700&display=swap" rel="stylesheet">
    <link href="<?php echo base_url() ?>template/css/theme-06.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="forny-container">

        <div class="forny-inner">
            <div class="forny-two-pane">
                <div>

                    <div class="forny-form">
                        <img class="text-center mb-4" src="<?php echo base_url() ?>assets/logo/flatlogo.png" height="80" alt="">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active bg-transparent" href="#login" data-toggle="tab" role="tab">
                                    <span>Login</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link bg-transparent" href="#register" data-toggle="tab" role="tab">
                                    <span>Register</span>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" role="tabpanel" id="login">
                                <?php echo $this->session->flashdata('msg'); ?>
                                <?php echo form_open('login/submit') ?>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-user"></i>
                                            </span>
                                        </div>
                                        <input required class="form-control" name="email" type="email" placeholder="Email Address">
                                    </div>
                                </div>
                                <div class="form-group password-field">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-lock"></i>
                                            </span>
                                        </div>

                                        <input required class="form-control" name="password" type="password" placeholder="Password">
                                        <div class="input-group-append cursor-pointer">
                                            <span class="input-group-text">
                                                <i class="fas fa-eye"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-6">
                                        <button class="btn btn-primary btn-block">Login</button>
                                    </div>
                                    <div class="col-6 d-flex align-items-center justify-content-end">
                                        <a href="<?php echo base_url('login/forgotPassword') ?>">Forgot password?</a>
                                    </div>
                                </div>
                                <?php echo form_close() ?>
                            </div>

                            <div class="tab-pane fade" role="tabpanel" id="register">
                                <?php echo form_open('login/register') ?>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-user"></i>
                                            </span>
                                        </div>
                                        <input required class="form-control" name="username" type="username" placeholder="Username">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-envelope"></i>
                                            </span>
                                        </div>
                                        <input required class="form-control" name="email" type="email" placeholder="Email Address">
                                    </div>
                                </div>
                                <div class="form-group password-field">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-lock"></i>
                                            </span>
                                        </div>

                                        <input required class="form-control" name="password" type="password" placeholder="Password">

                                        <div class="input-group-append cursor-pointer">
                                            <span class="input-group-text">
                                                <i class="fas fa-eye"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-building"></i>
                                            </span>
                                        </div>
                                        <input required class="form-control" name="companyName" type="text" placeholder="Company Name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-phone"></i>
                                            </span>
                                        </div>
                                        <input required class="form-control" name="contactNumber" type="text" placeholder="Contact Number">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-location-dot"></i>
                                            </span>
                                        </div>
                                        <textarea name="address" required class="form-control" id="" placeholder="Company Address"></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <button class="btn btn-primary btn-block">Register</button>
                                    </div>
                                </div>
                                <?php echo form_close() ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="right-pane">
                    <div class="bg-white px-2 py-2">
                    </div>
                </div>
            </div>
        </div>

    </div>


    <script src="<?php echo base_url() ?>template/js/jquery.min.js"></script>
    <script src="<?php echo base_url() ?>template/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url() ?>template/js/main.js"></script>
    <script src="<?php echo base_url() ?>template/js/demo.js"></script>

</body>

</html>