<?= $this->extend('layout/template'); ?>

<?= $this->section('content') ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= $title ?></li>
    </ol>
</nav>

<div class="d-flex align-items-center p-3 my-1 text-white-50 bg-info rounded shadow-sm">
    <div class="lh-100">
        <h6 class="mb-0 text-white lh-100 text-uppercase"><?= $title ?></h6>
    </div>
</div>

<div class="card mb-3">
    <div class="row">
        <div class="col-md-12">
            <div class="card-body">
                <?php /* $validation->listErrors() */ ?>
                <?php if(session()->getFlashdata('pesan')): ?>
                    <div class="alert alert-success" role="alert">
                    <?= session()->getFlashdata('pesan') ?>
                    </div>
                <?php endif; ?>
                <?php if(session()->getFlashdata('warning')): ?>
                    <div class="alert alert-warning" role="alert">
                    <?= session()->getFlashdata('warning') ?>
                    </div>
                <?php endif; ?>
                <div class="alert alert-info" role="alert">
                <h4 class="alert-heading"><i class="fa fa-info-circle"></i> Informasi!</h4>
                <hr>
                <p class="mb-0">
                    Minimal panjang 10 karakter
                </p>
                </div>

                <form id="form-submit" action="/pages/ubah-kata-sandi-update/<?= $result['id']; ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field(); ?>
                    <?php if(permission(['ADMINISTRATOR'])){ ?>
                    <div class="form-group row">
                        <label for="username" class="col-sm-2 col-form-label">Username</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control <?= ($validation->hasError('username')) ? 'is-invalid' : ''; ?>" id="username" name="username" value="<?= old('username'); ?>">
                            <div class="invalid-feedback"><?= $validation->getError('username'); ?></div>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if(permission(['ADMIN_CONTENT'])){ ?>
                    <div class="form-group row">
                        <label for="password_lama" class="col-sm-2 col-form-label">Kata Sandi Lama</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control <?= ($validation->hasError('password_lama')) ? 'is-invalid' : ''; ?>" id="password_lama" name="password_lama" value="<?= old('password_lama'); ?>">
                            <div class="invalid-feedback"><?= $validation->getError('password_lama'); ?></div>
                            <div><input type="checkbox" onclick="show_password_lama()" class="mt-2"> Tampilkan Kata Sandi Lama</div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="repassword_lama" class="col-sm-2 col-form-label">Ulangi Kata Sandi Lama</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control <?= ($validation->hasError('repassword_lama')) ? 'is-invalid' : ''; ?>" id="repassword_lama" name="repassword_lama" value="<?= old('repassword_lama'); ?>">
                            <div class="invalid-feedback"><?= $validation->getError('repassword_lama'); ?></div>
                            <div><input type="checkbox" onclick="show_repassword_lama()" class="mt-2"> Tampilkan Ulangi Kata Sandi Lama</div>
                        </div>
                    </div>

                    <hr>
                    <?php } ?>
                    <div class="form-group row">
                        <label for="password" class="col-sm-2 col-form-label">Kata Sandi Baru</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control <?= ($validation->hasError('password')) ? 'is-invalid' : ''; ?>" id="password" name="password" value="<?= old('password'); ?>">
                            <div class="invalid-feedback"><?= $validation->getError('password'); ?></div>
                            <div><input type="checkbox" onclick="show_password()" class="mt-2"> Tampilkan Kata Sandi Baru</div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="repassword" class="col-sm-2 col-form-label">Ulangi Kata Sandi Baru</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control <?= ($validation->hasError('repassword')) ? 'is-invalid' : ''; ?>" id="repassword" name="repassword" value="<?= old('repassword'); ?>">
                            <div class="invalid-feedback"><?= $validation->getError('repassword'); ?></div>
                            <div><input type="checkbox" onclick="show_repassword()" class="mt-2"> Tampilkan Ulangi Kata Sandi Baru</div>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <div class="col-sm-10">
                        <button type="submit" class="btn btn-info">Ubah Data</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function show_password() {
        if ($("#password").attr('type') === "password") {
            $("#password").attr('type', "text")
        } else {
            $("#password").attr('type', "password")
        }  
    }

    function show_repassword(){
        if ($("#repassword").attr('type') === "password") {
            $("#repassword").attr('type', "text")
        } else {
            $("#repassword").attr('type', "password")
        }
    }

    function show_password_lama() {
        if ($("#password_lama").attr('type') === "password") {
            $("#password_lama").attr('type', "text")
        } else {
            $("#password_lama").attr('type', "password")
        }  
    }

    function show_repassword_lama(){
        if ($("#repassword_lama").attr('type') === "password") {
            $("#repassword_lama").attr('type', "text")
        } else {
            $("#repassword_lama").attr('type', "password")
        }
    }
</script>

<?= $this->endsection(); ?>