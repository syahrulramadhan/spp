<?= $this->extend('layout/template'); ?>

<?= $this->section('content') ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Data</li>
        <li class="breadcrumb-item"><a href="<?= base_url('user'); ?>">User</a></li>
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
                <?php /* $validation->listErrors()*/  ?>
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
                <form id="form-submit" action="/user/save" method="post" enctype="multipart/form-data">
                    <?= csrf_field(); ?>
                    <div class="form-group row">
                        <label for="nama_depan" class="col-sm-2 col-form-label">Nama Depan <span class="text-danger font-weight-bold">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control <?= ($validation->hasError('nama_depan')) ? 'is-invalid' : ''; ?>" id="nama_depan" name="nama_depan" autofocus value="<?= old('nama_depan'); ?>">
                            <div class="invalid-feedback"><?= $validation->getError('nama_depan'); ?></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama_belakang" class="col-sm-2 col-form-label">Nama Belakang <span class="text-danger font-weight-bold">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control <?= ($validation->hasError('nama_belakang')) ? 'is-invalid' : ''; ?>" id="nama_belakang" name="nama_belakang" value="<?= old('nama_belakang'); ?>">
                            <div class="invalid-feedback"><?= $validation->getError('nama_belakang'); ?></div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="username" class="col-sm-2 col-form-label">Username <span class="text-danger font-weight-bold">*</span></label>
                        <div class="col-sm-10">
                            <input type="username" class="form-control <?= ($validation->hasError('username')) ? 'is-invalid' : ''; ?>" id="username" name="username" value="<?= old('username'); ?>">
                            <div class="invalid-feedback"><?= $validation->getError('username'); ?></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-sm-2 col-form-label">Email <span class="text-danger font-weight-bold">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control <?= ($validation->hasError('email')) ? 'is-invalid' : ''; ?>" id="email" name="email" value="<?= old('email'); ?>">
                            <div class="invalid-feedback"><?= $validation->getError('email'); ?></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-sm-2 col-form-label">Kata Sandi <span class="text-danger font-weight-bold">*</span></label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control <?= ($validation->hasError('password')) ? 'is-invalid' : ''; ?>" id="password" name="password" value="<?= old('password'); ?>">
                            <small id="passwordHelpInline" class="text-muted">
                                Minimal panjang 10 karakter
                            </small>
                            <div class="invalid-feedback"><?= $validation->getError('password'); ?></div>
                            <div><input type="checkbox" onclick="show_password()" class="mt-2"> Tampilkan Kata Sandi</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="repassword" class="col-sm-2 col-form-label">Ulangi Kata Sandi <span class="text-danger font-weight-bold">*</span></label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control <?= ($validation->hasError('repassword')) ? 'is-invalid' : ''; ?>" id="repassword" name="repassword" value="<?= old('repassword'); ?>">
                            <small id="passwordHelpInline" class="text-muted">
                                Minimal panjang 10 karakter
                            </small>
                            <div class="invalid-feedback"><?= $validation->getError('repassword'); ?></div>
                            <div><input type="checkbox" onclick="show_repassword()" class="mt-2"> Tampilkan Ulangi Kata Sandi</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nomor_telepon" class="col-sm-2 col-form-label">Nomor Telepon <span class="text-danger font-weight-bold">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control <?= ($validation->hasError('nomor_telepon')) ? 'is-invalid' : ''; ?>" id="nomor_telepon" name="nomor_telepon" value="<?= old('nomor_telepon'); ?>">
                            <div class="invalid-feedback"><?= $validation->getError('nomor_telepon'); ?></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="role" class="col-sm-2 col-form-label">Role <span class="text-danger font-weight-bold">*</span></label>
                        <div class="col-sm-10">
                            <?php $isinvalid = ($validation->hasError('role')) ? 'is-invalid' : ''; ?>
                            <?= form_dropdown('role', $options_role, old('role'), ['class' => "custom-select $isinvalid", 'id' => 'role']); ?>
                            <div class="invalid-feedback"><?= $validation->getError('role'); ?></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jabatan" class="col-sm-2 col-form-label">Jabatan <?php /*<small>(Opsional)</small>*/ ?></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control <?= ($validation->hasError('jabatan')) ? 'is-invalid' : ''; ?>" id="jabatan" name="jabatan" value="<?= old('jabatan'); ?>">
                            <div class="invalid-feedback"><?= $validation->getError('jabatan'); ?></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-10">
                        <button type="submit" class="btn btn-info">Tambah Data</button>
                        <a class="btn btn-info" href="/user">Lihat Rekap</a>
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

    $('#nomor_telepon').mask('0000-0000-00000');
    $('#role').change(function(){ submit_disable(); });
    $('#role').select2();
</script>

<?= $this->endsection(); ?>