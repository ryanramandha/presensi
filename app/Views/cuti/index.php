<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<section class="content-header mx-3">
    <div class="container-fluid">
        <div class="row mb-1">
            <h1>Data Jatah Cuti Pegawai</h1>
        </div>
    </div>
</section>

<section class="content mx-3">
    <div class="card">
        <div class="card-body">
            <form action="<?= route_to('cuti') ?>" method="get">
                <div class="form-group">
                    <label>Tahun</label>
                    <div class="row">
                        <div class="col-md-2">
                            <input type="number" name="tahun" class="form-control mr-2 mb-1" value="<?= old('tahun', $tahun ?? date('Y')) ?>">
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary mb-1">Tampilkan</button>
                        </div>
                    </div>
                </div>
            </form>

            <div class="row">
                <div class="col-md-12">

                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-sm">
                            <thead>
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Nama Pegawai</th>
                                    <th>Cuti Terpakai</th>
                                    <th>Sisa Jatah Cuti</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($cuti as $row) : ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td><?= $row['nama_pegawai'] ?></td>
                                        <td class="text-center"><?= $row['cuti_terpakai'] ?></td>
                                        <td class="text-center"><?= $row['sisa_cuti'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>