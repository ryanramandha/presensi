<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<section class="content-header mx-3">
    <div class="container-fluid">
        <div class="row mb-1">
            <h1>Ubah Data Pengguna</h1>
        </div>
    </div>
</section>

<section class="content mx-3">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <form action="<?= route_to('pengguna.ubah', $pengguna['id_pengguna']) ?>" method="post">

                        <?= csrf_field() ?>
                        <?= validation_list_errors('my_list') ?>

                        <div class="form-group">
                            <label for="nama_lengkap">Nama Lengkap</label>
                            <input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap" value="<?= old('nama_lengkap', $pengguna['nama_lengkap']) ?>">
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" name="username" id="username" value="<?= old('username', $pengguna['username']) ?>">
                        </div>
                        <div class="form-group">
                            <label for="level">Level</label>
                            <?php if ($pengguna['level'] == 'Pegawai') : ?>
                                <input type="level" class="form-control" name="level" id="level" value="<?= old('level', $pengguna['level']) ?>" readonly>
                            <?php else : ?>
                                <select class="form-control" name="level" id="level">
                                    <option value="">- Pilih -</option>
                                    <option value="Admin" <?= old('level', $pengguna['level']) == 'Admin' ? 'selected' : '' ?>>Admin</option>
                                    <option value="Kepala Cabang" <?= old('level', $pengguna['level']) == 'Kepala Cabang' ? 'selected' : '' ?>>Kepala Cabang</option>
                                </select>
                            <?php endif ?>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-success">Simpan</button>
                            <a href="<?= route_to('pengguna') ?>" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>