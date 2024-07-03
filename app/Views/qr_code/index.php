<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<section class="content-header mx-3">
    <div class="container-fluid">
        <div class="row mb-1">
            <h1>Data QR Code</h1>
        </div>
    </div>
</section>

<section class="content mx-3">
    <div class="card">
        <div class="card-body">
            <div class="mb-3">
                <a href="<?= route_to('qr_code.cetak') ?>" class="btn btn-primary" target="_blank">Cetak PDF</a>
            </div>
            <img src="<?= $qr_code ?>" alt="QR Code" width="150">
        </div>
    </div>
</section>
<?= $this->endSection() ?>