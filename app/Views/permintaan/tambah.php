<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<section class="content-header mx-3">
    <div class="container-fluid">
        <div class="row mb-1">
            <h1>Permintaan Izin/Cuti/Off</h1>
        </div>
    </div>
</section>

<section class="content mx-3">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <form action="<?= route_to('permintaan.tambah') ?>" method="post">

                        <?= csrf_field() ?>
                        <?= validation_list_errors('my_list') ?>

                        <div class="form-group">
                            <label for="tgl_permintaan">Tanggal Permintaan</label>
                            <div class="row">
                                <div class="col-md-3">
                                    <input type="date" class="form-control" name="tgl_permintaan" id="tgl_permintaan" value="<?= old('tgl_permintaan') ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="jenis">Jenis</label>
                            <select class="form-control" name="jenis" id="jenis">
                                <option value="">- Pilih -</option>
                                <option value="Off" <?= old('jenis') == 'Off' ? 'selected' : '' ?>>Off</option>
                                <option value="Cuti" <?= old('jenis') == 'Cuti' ? 'selected' : '' ?>>Cuti</option>
                                <option value="Izin" <?= old('jenis') == 'Izin' ? 'selected' : '' ?>>Izin</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="pesan">Pesan</label>
                            <textarea class="form-control" name="pesan" id="pesan" rows="2"><?= old('pesan') ?></textarea>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-success">Ajukan</button>
                            <a href="<?= route_to('permintaan') ?>" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>