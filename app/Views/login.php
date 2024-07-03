<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Informasi Presensi Pegawai PT. J&T Express Dropship Penggilingan Jakarta Timur</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url('assets/fontawesome-free/css/all.min.css') ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('assets/css/adminlte.min.css') ?>">

    <link rel="shortcut icon" href="<?= base_url('assets/images/logo.jpg') ?>" type="image/x-icon">
</head>

<body class="hold-transition login-page">

    <div class="login-box">

        <div class="card">
            <div class="card-body login-card-body">

                <div class="row justify-content-end">
                    <div class="col-md-12 py-2 m-auto">
                        <p class="text-center mb-4">
                            <img src="<?= base_url('assets/images/logo.jpg') ?>" alt="Logo" width="300">
                        </p>

                        <?= session()->getFlashdata('pesan'); ?>

                        <form action="<?= route_to('login.cek') ?>" method="post">
                            <?= csrf_field() ?>
                            <div class="input-group mb-3">
                                <input type="text" name="username" value="<?= old('username') ?>" class="form-control" required placeholder="Username">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-user"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="password" name="password" required class="form-control" placeholder="Password">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 mb-1">
                                    <button type="submit" name="login" class="btn btn-danger btn-block">Login</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="<?= base_url('assets/jquery/jquery.min.js') ?>"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url('assets/js/adminlte.min.js') ?>"></script>
</body>

</html>