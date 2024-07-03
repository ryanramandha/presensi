<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Informasi Presensi Pegawai PT. J&T Express Dropship Penggilingan Jakarta Timur</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="<?= base_url('assets/fontawesome-free/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/adminlte.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/datatables-bs4/css/dataTables.bootstrap4.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/styles.css') ?>">

    <link rel="shortcut icon" href="<?= base_url('assets/images/logo.jpg') ?>" type="image/x-icon">

    <?= $this->renderSection('css') ?>
</head>

<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fa fa-fw fa-user"></i> <?= session()->get('nama_lengkap') ?> <i class="fas fa-angle-down ml-1"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                        <a href="<?= route_to('password') ?>" class="dropdown-item">
                            <i class="fa fa-fw fa-unlock"></i> Ubah Password
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="<?= route_to('logout') ?>" class="dropdown-item">
                            <i class="fa fa-fw fa-sign-out-alt"></i> Logout
                        </a>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary bg-custom elevation-1">
            <!-- Brand Logo -->
            <a href="<?= route_to('home') ?>" class="brand-link text-center">
                <img src="<?= base_url('assets/images/logo.jpg') ?>" alt="Logo" width="200">
            </a>

            <!-- Sidebar -->
            <div class="sidebar">

                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                        <?php
                        $uri = service('uri');
                        $segment1 = $uri->getSegment(1);
                        ?>

                        <?php if (session()->get('level') == 'Admin') : ?>
                            <li class="nav-item text-white">
                                <a href="<?= route_to('home') ?>" class="nav-link text-white <?= $segment1 == '' || $segment1 == 'home' ? 'active' : '' ?>"><i class="nav-icon fas fa-home"></i>
                                    <p>Home</p>
                                </a>
                            </li>
                            <li class="nav-item text-white">
                                <a href="<?= route_to('history') ?>" class="nav-link text-white <?= $segment1 == 'history' ? 'active' : '' ?>"><i class="nav-icon fas fa-history"></i>
                                    <p>History</p>
                                </a>
                            </li>
                            <li class="nav-item text-white">
                                <a href="<?= route_to('laporan') ?>" class="nav-link text-white <?= $segment1 == 'laporan' ? 'active' : '' ?>"><i class="nav-icon fas fa-print"></i>
                                    <p>Laporan</p>
                                </a>
                            </li>
                            <li class="nav-item text-white">
                                <a href="<?= route_to('libur') ?>" class="nav-link text-white <?= $segment1 == 'libur' ? 'active' : '' ?>"><i class="nav-icon fas fa-calendar-alt"></i>
                                    <p>Jadwal Libur</p>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if (session()->get('level') == 'Pegawai') : ?>
                            <li class="nav-item text-white">
                                <a href="<?= route_to('presensi') ?>" class="nav-link text-white <?= $segment1 == 'presensi' ? 'active' : '' ?>"><i class="nav-icon fas fa-clock"></i>
                                    <p>Presensi</p>
                                </a>
                            </li>
                            <li class="nav-item text-white">
                                <a href="<?= route_to('permintaan') ?>" class="nav-link text-white <?= $segment1 == 'permintaan' ? 'active' : '' ?>"><i class="nav-icon fas fa-envelope-open-text"></i>
                                    <p>Permintaan Izin</p>
                                </a>
                            </li>
                            <li class="nav-item text-white">
                                <a href="<?= route_to('profil') ?>" class="nav-link text-white <?= $segment1 == 'profil' ? 'active' : '' ?>"><i class="nav-icon fas fa-user"></i>
                                    <p>Profil</p>
                                </a>
                            </li>
                            <li class="nav-item text-white">
                                <a href="<?= route_to('history') ?>" class="nav-link text-white <?= $segment1 == 'history' ? 'active' : '' ?>"><i class="nav-icon fas fa-history"></i>
                                    <p>History</p>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if (session()->get('level') == 'Kepala Cabang') : ?>
                            <li class="nav-item text-white">
                                <a href="<?= route_to('home') ?>" class="nav-link text-white <?= $segment1 == '' || $segment1 == 'home' ? 'active' : '' ?>"><i class="nav-icon fas fa-home"></i>
                                    <p>Home</p>
                                </a>
                            </li>
                            <li class="nav-item text-white">
                                <a href="<?= route_to('pengguna') ?>" class="nav-link text-white <?= $segment1 == 'pengguna' ? 'active' : '' ?>"><i class="nav-icon fas fa-user"></i>
                                    <p>Pengguna</p>
                                </a>
                            </li>
                            <li class="nav-item text-white">
                                <a href="<?= route_to('pegawai') ?>" class="nav-link text-white <?= $segment1 == 'pegawai' ? 'active' : '' ?>"><i class="nav-icon fas fa-users"></i>
                                    <p>Pegawai</p>
                                </a>
                            </li>
                            <li class="nav-item text-white">
                                <a href="<?= route_to('qr_code') ?>" class="nav-link text-white <?= $segment1 == 'qr_code' ? 'active' : '' ?>"><i class="nav-icon fas fa-qrcode"></i>
                                    <p>QR Code</p>
                                </a>
                            </li>
                            <li class="nav-item text-white">
                                <a href="<?= route_to('absensi') ?>" class="nav-link text-white <?= $segment1 == 'absensi' ? 'active' : '' ?>"><i class="nav-icon fas fa-clock"></i>
                                    <p>Absensi</p>
                                </a>
                            </li>
                            <li class="nav-item text-white">
                                <a href="<?= route_to('verifikasi') ?>" class="nav-link text-white <?= $segment1 == 'verifikasi' ? 'active' : '' ?>"><i class="nav-icon fas fa-check"></i>
                                    <p>Verifikasi</p>
                                </a>
                            </li>
                            <li class="nav-item text-white">
                                <a href="<?= route_to('history') ?>" class="nav-link text-white <?= $segment1 == 'history' ? 'active' : '' ?>"><i class="nav-icon fas fa-history"></i>
                                    <p>History</p>
                                </a>
                            </li>
                            <li class="nav-item text-white">
                                <a href="<?= route_to('permintaan') ?>" class="nav-link text-white <?= $segment1 == 'permintaan' ? 'active' : '' ?>"><i class="nav-icon fas fa-envelope-open-text"></i>
                                    <p>Permintaan Izin</p>
                                </a>
                            </li>
                            <li class="nav-item text-white">
                                <a href="<?= route_to('cuti') ?>" class="nav-link text-white <?= $segment1 == 'cuti' ? 'active' : '' ?>"><i class="nav-icon fas fa-calendar"></i>
                                    <p>Jatah Cuti</p>
                                </a>
                            </li>
                            <li class="nav-item text-white">
                                <a href="<?= route_to('pengaturan') ?>" class="nav-link text-white <?= $segment1 == 'pengaturan' ? 'active' : '' ?>"><i class="nav-icon fas fa-cog"></i>
                                    <p>Pengaturan</p>
                                </a>
                            </li>
                        <?php endif; ?>

                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <?= $this->renderSection('content') ?>

        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <strong>Copyright &copy; <?= date('Y') ?> - <a href="#" class="text-info">PT. J&T Express Dropship Penggilingan Jakarta Timur</a>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <script src="<?= base_url('assets/jquery/jquery.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('assets/datatables/jquery.dataTables.min.js') ?>"></script>
    <script src="<?= base_url('assets/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/adminlte.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/script.js') ?>"></script>

    <?= $this->renderSection('js') ?>
</body>

</html>