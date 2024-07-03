<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<section class="content-header mx-3">
    <div class="container-fluid">
        <div class="row mb-1">
            <h1>Verifikasi Data Presensi</h1>
        </div>
    </div>
</section>

<section class="content mx-3">
    <div class="card">
        <div class="card-body">

            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="datatable" data-ordering="false">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Pegawai</th>
                                    <th>Nama Pegawai</th>
                                    <th>Tanggal</th>
                                    <th>Jam Masuk</th>
                                    <th>Jam Pulang</th>
                                    <th>Foto</th>
                                    <th>Verifikasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($presensi as $row) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $row['kode_pegawai'] ?></td>
                                        <td><?= $row['nama_pegawai'] ?></td>
                                        <td><?= \Carbon\Carbon::parse($row['tanggal'])->locale('id')->isoFormat('dddd, Do MMMM YYYY') ?></td>
                                        <td><?= empty($row['jam_masuk']) ? '' : \Carbon\Carbon::parse($row['jam_masuk'])->format('H:i') ?></td>
                                        <td><?= empty($row['jam_pulang']) ? '' : \Carbon\Carbon::parse($row['jam_pulang'])->format('H:i') ?></td>
                                        <td>
                                            <?php if ($row['foto']) : ?>
                                                <a href="<?= base_url('uploads/' . $row['foto']) ?>" target="_blank">
                                                    <img src="<?= base_url('uploads/' . $row['foto']) ?>" alt="Foto" class="img-thumbnail" width="80">
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <form action="<?= route_to('verifikasi.terima', $row['id_presensi']) ?>" method="POST">
                                                        <?= csrf_field() ?>
                                                        <button class="btn btn-success btn-sm terima-confirm mb-1" type="submit" title="Terima"><i class="fa fa-check fa-fw"></i></button>
                                                    </form>
                                                </div>
                                                <div class="col-md-6">
                                                    <form action="<?= route_to('verifikasi.tolak', $row['id_presensi']) ?>" method="POST">
                                                        <?= csrf_field() ?>
                                                        <button class="btn btn-danger btn-sm tolak-confirm mb-1" type="submit" title="Tolak"><i class="fa fa-times fa-fw"></i></button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
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

<?= $this->section('css') ?>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
<script>
    $(document).ready(function() {
        $('#datatable').on('click', '.tolak-confirm', function(event) {
            var form = $(this).closest("form");
            var name = $(this).data("name");
            event.preventDefault();
            swal({
                    title: "Konfirmasi",
                    text: "Anda yakin data presensi ini mau ditolak?",
                    icon: "warning",
                    buttons: ['Batal', 'Tolak'],
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                    }
                });
        });

        $('#datatable').on('click', '.terima-confirm', function(event) {
            var form = $(this).closest("form");
            var name = $(this).data("name");
            event.preventDefault();
            swal({
                    title: "Konfirmasi",
                    text: "Anda yakin data presensi ini mau diterima?",
                    icon: "warning",
                    buttons: ['Batal', 'Terima'],
                })
                .then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                    }
                });
        });
    });

    <?php if (session()->has('success')) : ?>
        toastr.success('<?= esc(session('success')) ?>');
    <?php elseif (session()->has('error')) : ?>
        toastr.error('<?= esc(session('error')) ?>');
    <?php endif; ?>
</script>
<?= $this->endSection() ?>