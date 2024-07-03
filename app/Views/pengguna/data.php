<?= $this->extend('template') ?>

<?= $this->section('content') ?>
    <section class="content-header mx-3">
        <div class="container-fluid">
            <div class="row mb-1">
                <h1>Data Pengguna</h1>
            </div>
        </div>
    </section>

    <section class="content mx-3">
        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <a href="<?= route_to('pengguna.tambah') ?>" class="btn btn-primary">Tambah Data</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered" id="datatable" data-ordering="false">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Lengkap</th>
                                <th>Username</th>
                                <th>Level</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pengguna as $row): ?>
                                <tr>
                                    <td></td>
                                    <td><?= $row['nama_lengkap'] ?></td>
                                    <td><?= $row['username'] ?></td>
                                    <td><?= $row['level'] ?></td>
                                    <td>
                                        <form action="<?= route_to('pengguna.hapus', $row['id_pengguna']) ?>" method="POST">
                                            <?= csrf_field() ?>

                                            <a href="<?= route_to('pengguna.ubah', $row['id_pengguna']) ?>" class="btn btn-success btn-sm">Ubah</a>
                                            <?php if (session()->get('username') != $row['username']): ?>
                                                <button class="btn btn-danger btn-sm delete-confirm" type="submit">Hapus</button>
                                            <?php endif ?>

                                        </form>
                                    </td>
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
