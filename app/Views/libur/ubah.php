<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<section class="content-header mx-3">
    <div class="container-fluid">
        <div class="row mb-1">
            <h1>Ubah Data Jadwal Libur</h1>
        </div>
    </div>
</section>

<section class="content mx-3">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <form action="<?= route_to('libur.ubah', $libur['id_libur']) ?>" method="post">

                        <?= csrf_field() ?>
                        <?= validation_list_errors('my_list') ?>

                        <div class="form-group">
                            <label for="tgl_libur">Tanggal Libur</label>
                            <div class="row">
                                <div class="col-md-3">
                                    <input type="date" class="form-control" name="tgl_libur" id="tgl_libur" value="<?= old('tgl_libur', $libur['tgl_libur']) ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nama_libur">Nama Libur</label>
                            <input type="text" class="form-control" name="nama_libur" id="nama_libur" value="<?= old('nama_libur', $libur['nama_libur']) ?>">
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-success">Simpan</button>
                            <a href="<?= route_to('libur') ?>" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>