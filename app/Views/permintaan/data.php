<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<section class="content-header mx-3">
    <div class="container-fluid">
        <div class="row mb-1">
            <h1>Data Permintaan Izin/Cuti/Off</h1>
        </div>
    </div>
</section>

<section class="content mx-3">
    <div class="card">
        <div class="card-body">

            <?php if (session()->get('level') == 'Pegawai') : ?>
                <div class="mb-3">
                    <a href="<?= route_to('permintaan.tambah') ?>" class="btn btn-primary">Pengajuan Baru</a>
                </div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-bordered" id="datatable" data-ordering="false">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pegawai</th>
                            <th>Tanggal Permintaan</th>
                            <th>Jenis</th>
                            <th>Pesan</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                            <?php if (session()->get('level') == 'Kepala Cabang') : ?>
                                <th>Aksi</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($permintaan as $row) : ?>
                            <?php $badge = $row['status'] == 'Menunggu' ? 'secondary' : ($row['status'] == 'Diterima' ? 'success' : 'danger'); ?>
                            <?php $icon = $row['status'] == 'Menunggu' ? 'clock' : ($row['status'] == 'Diterima' ? 'check' : 'times'); ?>
                            <tr>
                                <td></td>
                                <td><?= $row['nama_pegawai'] ?></td>
                                <td><?= \Carbon\Carbon::parse($row['tgl_permintaan'])->locale('id')->isoFormat('dddd, Do MMMM YYYY') ?></td>
                                <td><?= $row['jenis'] ?></td>
                                <td><?= $row['pesan'] ?></td>
                                <td><span class="badge bg-<?= $badge ?>"><i class="fas fa-<?= $icon ?> mr-1"></i> <?= $row['status'] ?></span></td>
                                <td><?= $row['keterangan'] ?></td>
                                <?php if (session()->get('level') == 'Kepala Cabang') : ?>
                                    <td>
                                        <form action="<?= route_to('permintaan.hapus', $row['id_permintaan']) ?>" method="POST">
                                            <?= csrf_field() ?>

                                            <?php if ($row['status'] == 'Menunggu') : ?>
                                                <a href="<?= route_to('permintaan.ubah', $row['id_permintaan']) ?>" class="btn btn-success btn-sm">Proses</a>
                                            <?php endif; ?>
                                            <button class="btn btn-danger btn-sm delete-confirm" type="submit">Hapus</button>

                                        </form>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
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
        $('#datatable').on('click', '.delete-confirm', function(event) {
            var form = $(this).closest("form");
            var name = $(this).data("name");
            event.preventDefault();
            swal({
                    title: "Konfirmasi",
                    text: "Anda yakin data ini mau dihapus?",
                    icon: "warning",
                    buttons: ['Batal', 'Hapus'],
                    dangerMode: true,
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