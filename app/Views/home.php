<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<section class="content-header mx-3">
    <div class="container-fluid">
        <div class="row mb-2">
            <h1>Home</h1>
        </div>
    </div>
</section>

<section class="content mx-3">

    <div class="card">
        <div class="card-body text-center my-2">
            <h4>
                Sistem Informasi Presensi Pegawai
                <br>
                Menggunakan Metode Quick Response Code
                <br>
                PT. J&T Express Dropship Penggilingan Jakarta Timur
            </h4>
            <hr>
            <img src="<?= base_url('assets/images/logo.jpg') ?>" alt="Logo J&T Express" width="350">
        </div>
    </div>

</section>
<?= $this->endSection() ?>