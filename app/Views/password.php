<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<section class="content-header mx-3">
    <div class="container-fluid">
        <div class="row mb-1">
            <h1>Ubah Password</h1>
        </div>
    </div>
</section>

<section class="content mx-3">

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <form action="<?= route_to('password') ?>" method="post">

                        <?= csrf_field() ?>
                        <?= validation_list_errors('my_list') ?>

                        <div class="form-group">
                            <label for="password_lama">Password Lama</label>
                            <input type="password" class="form-control" name="password_lama" id="password_lama" value="<?= old('password_lama') ?>">
                        </div>
                        <div class="form-group">
                            <label for="password">Password Baru</label>
                            <input type="password" class="form-control" name="password" id="password">
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Ulangi Password Baru</label>
                            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-success">Ubah</button>
                        </div>
                    </form>
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
<script>
    <?php if (session()->has('success')) : ?>
        toastr.success('<?= esc(session('success')) ?>');
    <?php elseif (session()->has('error')) : ?>
        toastr.error('<?= esc(session('error')) ?>');
    <?php endif; ?>
</script>
<?= $this->endSection() ?>