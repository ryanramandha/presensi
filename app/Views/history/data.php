<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<section class="content-header mx-3">
    <div class="container-fluid">
        <div class="row mb-1">
            <h1>Data History</h1>
        </div>
    </div>
</section>

<section class="content mx-3">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="datatable" data-ordering="false">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Pegawai</th>
                            <th>Nama Pegawai</th>
                            <th>Jabatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pegawai as $row) : ?>
                            <tr>
                                <td></td>
                                <td><?= $row['kode_pegawai'] ?></td>
                                <td><?= $row['nama_pegawai'] ?></td>
                                <td><?= $row['jabatan'] ?></td>
                                <td>
                                    <a href="<?= route_to('history.show', $row['id_pegawai']) ?>" class="btn btn-success btn-sm" title="Detail history">Lihat <i class="fas fa-arrow-right"></i></a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>