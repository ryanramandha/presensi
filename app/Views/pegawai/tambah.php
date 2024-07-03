<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<section class="content-header mx-3">
    <div class="container-fluid">
        <div class="row mb-1">
            <h1>Tambah Data Pegawai</h1>
        </div>
    </div>
</section>

<section class="content mx-3">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <form action="<?= route_to('pegawai.tambah') ?>" method="post">

                        <?= csrf_field() ?>
                        <?= validation_list_errors('my_list') ?>

                        <div class="form-group">
                            <label for="kode_pegawai">Kode Pegawai</label>
                            <input type="text" class="form-control" name="kode_pegawai" id="kode_pegawai" value="<?= old('kode_pegawai') ?>">
                        </div>
                        <div class="form-group">
                            <label for="nama_pegawai">Nama Pegawai</label>
                            <input type="text" class="form-control" name="nama_pegawai" id="nama_pegawai" value="<?= old('nama_pegawai') ?>">
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <input type="text" class="form-control" name="alamat" id="alamat" value="<?= old('alamat') ?>">
                        </div>
                        <div class="form-group">
                            <label for="no_hp">No HP</label>
                            <input type="number" class="form-control" name="no_hp" id="no_hp" value="<?= old('no_hp') ?>">
                        </div>
                        <div class="form-group">
                            <label for="jabatan">Jabatan</label>
                            <input type="text" class="form-control" name="jabatan" id="jabatan" value="<?= old('jabatan') ?>">
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" name="username" id="username" value="<?= old('username') ?>">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" id="password">
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-success">Simpan</button>
                            <a href="<?= route_to('pegawai') ?>" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>