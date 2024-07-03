<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<section class="content-header mx-3">
    <div class="container-fluid">
        <div class="row mb-1">
            <h1>Data Laporan</h1>
        </div>
    </div>
</section>

<section class="content mx-3">
    <div class="card">
        <div class="card-body">
            <form action="<?= route_to('laporan') ?>" method="get">
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
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary mb-1">Tampilkan</button>
                        </div>
                    </div>
                </div>
            </form>

            <?php if (!empty($bulan) && !empty($tahun)) : ?>
                <a href="<?= route_to('laporan.cetak', $bulan, $tahun) ?>" class="btn btn-success mb-4" title="Cetak" target="_blank"><i class="fa fa-print"></i> Cetak PDF</a>
            <?php endif; ?>

            <div class="row">
                <div class="col-md-12">

                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-sm">
                            <thead>
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Nama Pegawai</th>
                                    <th>Hadir</th>
                                    <th>Off</th>
                                    <th>Alfa</th>
                                    <th>Sakit</th>
                                    <th>Izin</th>
                                    <th>Cuti</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($pegawai as $row) : ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td><?= $row['nama_pegawai'] ?></td>
                                        <td class="text-center"><?= $row['hadir'] > 0 ? $row['hadir'] : '' ?></td>
                                        <td class="text-center"><?= $row['off'] > 0 ? $row['off'] : '' ?></td>
                                        <td class="text-center"><?= $row['alfa'] > 0 ? $row['alfa'] : '' ?></td>
                                        <td class="text-center"><?= $row['sakit'] > 0 ? $row['sakit'] : '' ?></td>
                                        <td class="text-center"><?= $row['izin'] > 0 ? $row['izin'] : '' ?></td>
                                        <td class="text-center"><?= $row['cuti'] > 0 ? $row['cuti'] : '' ?></td>
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