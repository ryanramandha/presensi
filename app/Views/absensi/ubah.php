<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<section class="content-header mx-3">
    <div class="container-fluid">
        <div class="row mb-1">
            <h1>Ubah Data Absensi</h1>
        </div>
    </div>
</section>

<section class="content mx-3">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <form action="<?= route_to('absensi.ubah', $absensi['id_absensi']) ?>" method="post">

                        <?= csrf_field() ?>
                        <?= validation_list_errors('my_list') ?>

                        <div class="form-group">
                            <label for="id_pegawai">Nama Pegawai</label>
                            <select class="form-control" name="id_pegawai" id="id_pegawai">
                                <option value="">- Pilih -</option>
                                <?php foreach ($pegawai as $row) : ?>
                                    <option value="<?= $row['id_pegawai'] ?>" <?= old('id_pegawai', $absensi['id_pegawai']) == $row['id_pegawai'] ? 'selected' : '' ?>><?= $row['kode_pegawai'] . ' - ' . $row['nama_pegawai'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <div class="row">
                                <div class="col-md-3">
                                    <input type="date" class="form-control" name="tanggal" id="tanggal" value="<?= old('tanggal', $absensi['tanggal']) ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <select class="form-control" name="keterangan" id="keterangan">
                                <option value="">- Pilih -</option>
                                <option value="Off" <?= old('keterangan', $absensi['keterangan']) == 'Off' ? 'selected' : '' ?>>Off</option>
                                <option value="Alfa" <?= old('keterangan', $absensi['keterangan']) == 'Alfa' ? 'selected' : '' ?>>Alfa</option>
                                <option value="Sakit" <?= old('keterangan', $absensi['keterangan']) == 'Sakit' ? 'selected' : '' ?>>Sakit</option>
                                <option value="Izin" <?= old('keterangan', $absensi['keterangan']) == 'Izin' ? 'selected' : '' ?>>Izin</option>
                                <option value="Cuti" <?= old('keterangan', $absensi['keterangan']) == 'Cuti' ? 'selected' : '' ?>>Cuti</option>
                            </select>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-success">Simpan</button>
                            <a href="<?= route_to('absensi') ?>" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>