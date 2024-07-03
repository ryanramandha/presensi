<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index', ['filter' => 'auth', 'as' => 'home']);
$routes->get('home', 'Home::index', ['filter' => 'auth', 'as' => 'home']);
$routes->add('profil', 'Home::profil', ['filter' => 'auth', 'as' => 'profil']);

$routes->get('login', 'Login::index', ['as' => 'login']);
$routes->post('login/cek', 'Login::cek', ['as' => 'login.cek']);
$routes->get('logout', 'Login::logout', ['as' => 'logout']);

$routes->add('password', 'Pengguna::password', ['filter' => 'auth', 'as' => 'password']);

$routes->group('pengguna', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Pengguna::index', ['as' => 'pengguna']);
    $routes->add('tambah', 'Pengguna::tambah', ['as' => 'pengguna.tambah']);
    $routes->add('ubah/(:num)', 'Pengguna::ubah/$1', ['as' => 'pengguna.ubah']);
    $routes->post('hapus/(:num)', 'Pengguna::hapus/$1', ['as' => 'pengguna.hapus']);
});

$routes->group('pegawai', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Pegawai::index', ['as' => 'pegawai']);
    $routes->add('tambah', 'Pegawai::tambah', ['as' => 'pegawai.tambah']);
    $routes->add('ubah/(:num)', 'Pegawai::ubah/$1', ['as' => 'pegawai.ubah']);
    $routes->post('hapus/(:num)', 'Pegawai::hapus/$1', ['as' => 'pegawai.hapus']);
});

$routes->group('presensi', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Presensi::index', ['as' => 'presensi']);
    $routes->post('proses', 'Presensi::proses', ['as' => 'presensi.proses']);
    $routes->post('foto', 'Presensi::foto', ['as' => 'presensi.foto']);
});

$routes->group('qr_code', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Qr_code::index', ['as' => 'qr_code']);
    $routes->get('cetak', 'Qr_code::cetak', ['as' => 'qr_code.cetak']);
});

$routes->group('history', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'History::index', ['as' => 'history']);
    $routes->get('show/(:num)', 'History::show/$1', ['as' => 'history.show']);
    $routes->get('cetak/(:num)/(:num)/(:num)/(:any)', 'History::cetak/$1/$2/$3/$4', ['as' => 'history.cetak']);
});

$routes->group('absensi', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Absensi::index', ['as' => 'absensi']);
    $routes->add('tambah', 'Absensi::tambah', ['as' => 'absensi.tambah']);
    $routes->add('ubah/(:num)', 'Absensi::ubah/$1', ['as' => 'absensi.ubah']);
    $routes->post('hapus/(:num)', 'Absensi::hapus/$1', ['as' => 'absensi.hapus']);
});

$routes->group('libur', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Libur::index', ['as' => 'libur']);
    $routes->add('tambah', 'Libur::tambah', ['as' => 'libur.tambah']);
    $routes->add('ubah/(:num)', 'Libur::ubah/$1', ['as' => 'libur.ubah']);
    $routes->post('hapus/(:num)', 'Libur::hapus/$1', ['as' => 'libur.hapus']);
});

$routes->group('permintaan', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Permintaan::index', ['as' => 'permintaan']);
    $routes->add('tambah', 'Permintaan::tambah', ['as' => 'permintaan.tambah']);
    $routes->add('ubah/(:num)', 'Permintaan::ubah/$1', ['as' => 'permintaan.ubah']);
    $routes->post('hapus/(:num)', 'Permintaan::hapus/$1', ['as' => 'permintaan.hapus']);
});

$routes->group('laporan', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Laporan::index', ['as' => 'laporan']);
    $routes->get('cetak/(:num)/(:num)', 'Laporan::cetak/$1/$2', ['as' => 'laporan.cetak']);
});

$routes->group('verifikasi', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Verifikasi::index', ['as' => 'verifikasi']);
    $routes->post('terima/(:num)', 'Verifikasi::terima/$1', ['as' => 'verifikasi.terima']);
    $routes->post('tolak/(:num)', 'Verifikasi::tolak/$1', ['as' => 'verifikasi.tolak']);
});

$routes->get('cuti', 'Cuti::index', ['filter' => 'auth', 'as' => 'cuti']);
$routes->add('pengaturan', 'Pengaturan::index', ['filter' => 'auth', 'as' => 'pengaturan']);
