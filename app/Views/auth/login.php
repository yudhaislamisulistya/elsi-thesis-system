<!doctype html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>StrikingDash</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- inject:css-->

    <link rel="stylesheet" href="<?= base_url('css/plugin.min.css'); ?>">

    <link rel="stylesheet" href="<?= base_url('css/style.css'); ?>">

    <!-- endinject -->

    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('img/png/favicon.png'); ?>">
</head>

<body>
    <main class="main-content">

        <div class="signUP-admin">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-xl-4 col-lg-5 col-md-5 p-0">
                        <div class="signUP-admin-left signIn-admin-left position-relative">
                            <div class="signUP-admin-left__content">
                                <img class="img-fluid" src="<?= base_url('img/png/logo.png'); ?>" alt="logo" height="80px" width="80px" />
                                <h1 class="m-top-25">PT. Tirta Siak - Penerimaan Karyawan Baru</h1>
                            </div><!-- End: .signUP-admin-left__content  -->
                            <div class="signUP-admin-left__img">
                                <img class="img-fluid svg" src="<?= base_url('img/svg/signupIllustration.svg'); ?>" alt="logo" />
                            </div><!-- End: .signUP-admin-left__img  -->
                        </div><!-- End: .signUP-admin-left  -->
                    </div><!-- End: .col-xl-4  -->
                    <div class="col-xl-8 col-lg-7 col-md-7 col-sm-8">
                        <div class="signUp-admin-right signIn-admin-right  p-md-40 p-10">
                            <div class="signUp-topbar d-flex align-items-center justify-content-md-end justify-content-center mt-md-0 mb-md-0 mt-20 mb-1">
                                <p class="mb-0">
                                    Don't have an account?
                                    <a href="<?= route_to("register") ?>" class="color-primary">
                                        Sign up
                                    </a>
                                </p>
                            </div><!-- End: .signUp-topbar  -->
                            <div class="row justify-content-center">
                                <div class="col-xl-7 col-lg-8 col-md-12">
                                    <div class="edit-profile mt-md-25 mt-0">
                                        <div class="card border-0">
                                            <div class="card-header border-0  pb-md-15 pb-10 pt-md-20 pt-10 ">
                                                <div class="edit-profile__title">
                                                    <h6>Sign up to <span class="color-primary">System</span></h6>
                                                </div>
                                            </div>

                                            <div class="card-body">
                                                <?= $this->include('components/alert.php'); ?>
                                                <div class="edit-profile__body">
                                                    <form action="<?= route_to('attemptLogin'); ?>" method="post">
                                                        <div class="form-group mb-20">
                                                            <label for="username">Username</label>
                                                            <input type="text" class="form-control" id="username" placeholder="Username" name="username">
                                                        </div>
                                                        <div class="form-group mb-15">
                                                            <label for="password-field">Password</label>
                                                            <div class="position-relative">
                                                                <input id="password-field" type="password" class="form-control" name="password" placeholder="Password" name="password">
                                                            </div>
                                                        </div>
                                                        <div class="button-group d-flex pt-1 justify-content-md-start justify-content-center">
                                                            <button type="submit" class="btn btn-primary btn-default btn-squared mr-15 text-capitalize lh-normal px-50 py-15 signIn-createBtn ">
                                                                sign in
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div><!-- End: .card-body -->
                                        </div><!-- End: .card -->
                                    </div><!-- End: .edit-profile -->
                                </div><!-- End: .col-xl-5 -->
                            </div>
                        </div><!-- End: .signUp-admin-right  -->
                    </div><!-- End: .col-xl-8  -->
                </div>
            </div>
        </div><!-- End: .signUP-admin  -->

    </main>
    <div id="overlayer">
        <span class="loader-overlay">
            <div class="atbd-spin-dots spin-lg">
                <span class="spin-dot badge-dot dot-primary"></span>
                <span class="spin-dot badge-dot dot-primary"></span>
                <span class="spin-dot badge-dot dot-primary"></span>
                <span class="spin-dot badge-dot dot-primary"></span>
            </div>
        </span>
    </div>

    <!-- inject:js-->

    <script src="<?= base_url('js/plugins.min.js'); ?>"></script>

    <script src="<?= base_url('js/script.min.js'); ?>"></script>

    <!-- endinject-->
</body>

</html>