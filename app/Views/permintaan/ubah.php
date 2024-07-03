<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<section class="content-header mx-3">
    <div class="container-fluid">
        <div class="row mb-1">
            <h1>Proses Permintaan Izin/Cuti/Off</h1>
        </div>
    </div>
</section>

<section class="content mx-3">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">

                    <table class="table table-borderless">
                        <tr>
                            <td class="col-6 col-sm-2">Nama Pegawai</td>
                            <td class="col-6 col-sm-10">: <?= $permintaan['nama_pegawai'] ?></td>
                        </tr>
                        <tr>
                            <td class="col-6 col-sm-2">Jabatan</td>
                            <td class="col-6 col-sm-10">: <?= $permintaan['jabatan'] ?></td>
                        </tr>
                        <tr>
                            <td class="col-6 col-sm-2">Tanggal Permintaan</td>
                            <td class="col-6 col-sm-10">: <?= \Carbon\Carbon::parse($permintaan['tgl_permintaan'])->locale('id')->isoFormat('dddd, Do MMMM YYYY') ?></td>
                        </tr>
                        <tr>
                            <td class="col-6 col-sm-2">Jenis</td>
                            <td class="col-6 col-sm-10">: <?= $permintaan['jenis'] ?></td>
                        </tr>
                        <tr>
                            <td class="col-6 col-sm-2">Pesan</td>
                            <td class="col-6 col-sm-10">: <?= $permintaan['pesan'] ?></td>
                        </tr>
                    </table>

                    <form action="<?= route_to('permintaan.ubah', $permintaan['id_permintaan']) ?>" method="post">

                        <?= csrf_field() ?>
                        <?= validation_list_errors('my_list') ?>

                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" name="status" id="status">
                                <option value="">- Pilih -</option>
                                <option value="Menunggu" <?= old('status', $permintaan['status']) == 'Menunggu' ? 'selected' : '' ?>>Menunggu</option>
                                <option value="Diterima" <?= old('status', $permintaan['status']) == 'Diterima' ? 'selected' : '' ?>>Diterima</option>
                                <option value="Ditolak" <?= old('status', $permintaan['status']) == 'Ditolak' ? 'selected' : '' ?>>Ditolak</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" name="keterangan" id="keterangan" rows="3"><?= $permintaan['keterangan'] ?></textarea>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-success">Simpan</button>
                            <a href="<?= route_to('permintaan') ?>" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>