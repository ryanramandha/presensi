<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<section class="content-header mx-3">
    <div class="container-fluid">
        <div class="row mb-1">
            <h1>Data History <?= $pegawai['nama_pegawai'] ?></h1>
        </div>
    </div>
</section>

<section class="content mx-3">
    <div class="card">
        <div class="card-body">
            <form action="<?= route_to('history.show', $pegawai['id_pegawai']) ?>" method="get">
                <div class="form-group">
                    <label>Periode</label>
                    <div class="row">
                        <div class="col-md-2">
                            <select name="bulan" class="form-control mr-2 mb-1" required>
                                <?php for ($m = 1; $m <= 12; ++$m) : ?>
                                    <option value="<?= $m ?>" <?= $bulan == $m ? 'selected' : '' ?>><?= \Carbon\Carbon::create()->day(1)->month($m)->locale('id')->isoFormat('MMMM') ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="tahun" class="form-control mr-2 mb-1" value="<?= old('tahun', $tahun ?? date('Y')) ?>">
                        </div>
                        <div class="col-md-2">
                            <select name="jenis" id="jenis" class="form-control mr-2 mb-1" required>
                                <option value="presensi" <?= $jenis == 'presensi' ? 'selected' : '' ?>>Presensi</option>
                                <option value="absensi" <?= $jenis == 'absensi' ? 'selected' : '' ?>>Absensi</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary mb-1">Tampilkan</button>
                            <a href="<?= route_to('history') ?>" class="btn btn-secondary ml-2 mb-1">Kembali</a>
                        </div>
                    </div>
                </div>
            </form>

            <?php if (!empty($bulan) && !empty($tahun) && !empty($jenis) && session()->get('level') == 'Admin') : ?>
                <a href="<?= route_to('history.cetak', $pegawai['id_pegawai'], $bulan, $tahun, $jenis) ?>" class="btn btn-success mb-4" title="Cetak" target="_blank"><i class="fa fa-print"></i> Cetak PDF</a>
            <?php endif; ?>

            <div class="row">
                <div class="col-md-12">
                    <table class="table">
                        <tr>
                            <td class="col-6 col-sm-3">Kode Pegawai</td>
                            <td class="col-6 col-sm-9">: <?= $pegawai['kode_pegawai'] ?></td>
                        </tr>
                        <tr>
                            <td class="col-6 col-sm-3">Nama Pegawai</td>
                            <td class="col-6 col-sm-9">: <?= $pegawai['nama_pegawai'] ?></td>
                        </tr>
                        <tr>
                            <td class="col-6 col-sm-3">Jabatan</td>
                            <td class="col-6 col-sm-9">: <?= $pegawai['jabatan'] ?></td>
                        </tr>
                    </table>

                    <?php if ($jenis == 'presensi') : ?>
                        <div class="table-responsive">
                            <table class="table table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Jam Masuk</th>
                                        <th>Jam Pulang</th>
                                        <th>Foto</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($presensi as $row) : ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= \Carbon\Carbon::parse($row['tanggal'])->locale('id')->isoFormat('dddd, Do MMMM YYYY') ?></td>
                                            <td><?= \Carbon\Carbon::parse($row['jam_masuk'])->format('H:i') ?></td>
                                            <td><?= \Carbon\Carbon::parse($row['jam_pulang'])->format('H:i') ?></td>
                                            <td>
                                                <?php if ($row['foto']) : ?>
                                                    <a href="<?= base_url('uploads/' . $row['foto']) ?>" target="_blank">
                                                        <img src="<?= base_url('uploads/' . $row['foto']) ?>" alt="Foto" class="img-thumbnail" width="80">
                                                    </a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php elseif ($jenis == 'absensi') : ?>
                        <div class="table-responsive">
                            <table class="table table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($absensi as $row) : ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= \Carbon\Carbon::parse($row['tanggal'])->locale('id')->isoFormat('dddd, Do MMMM YYYY') ?></td>
                                            <td><?= $row['keterangan'] ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>