<?= $this->extend('layout/template'); ?>

<?= $this->section('content') ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

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
                <form id="form-submit" action="/pages/profil_update/<?= $result['id']; ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field(); ?>
                    <div class="form-group row">
                        <label for="nama_depan" class="col-sm-2 col-form-label">Nama Depan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control <?= ($validation->hasError('nama_depan')) ? 'is-invalid' : ''; ?>" id="nama_depan" name="nama_depan" autofocus value="<?= (old('nama_depan')) ? old('nama_depan') : $result['nama_depan']; ?>">
                            <div class="invalid-feedback"><?= $validation->getError('nama_depan'); ?></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama_belakang" class="col-sm-2 col-form-label">Nama Belakang</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control <?= ($validation->hasError('nama_belakang')) ? 'is-invalid' : ''; ?>" id="nama_belakang" name="nama_belakang" value="<?= (old('nama_belakang')) ? old('nama_belakang') : $result['nama_belakang']; ?>">
                            <div class="invalid-feedback"><?= $validation->getError('nama_belakang'); ?></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="role" class="col-sm-2 col-form-label">Username</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="<?= $result['username']; ?>" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control <?= ($validation->hasError('email')) ? 'is-invalid' : ''; ?>" id="email" name="email" value="<?= (old('email')) ? old('email') : $result['email']; ?>">
                            <div class="invalid-feedback"><?= $validation->getError('email'); ?></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nomor_telepon" class="col-sm-2 col-form-label">Nomor Telepon</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control <?= ($validation->hasError('nomor_telepon')) ? 'is-invalid' : ''; ?>" id="nomor_telepon" name="nomor_telepon" value="<?= (old('nomor_telepon')) ? old('nomor_telepon') : $result['nomor_telepon']; ?>">
                            <div class="invalid-feedback"><?= $validation->getError('nomor_telepon'); ?></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="role" class="col-sm-2 col-form-label">Role</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="<?= $result['role']; ?>" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jabatan" class="col-sm-2 col-form-label">Jabatan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control <?= ($validation->hasError('jabatan')) ? 'is-invalid' : ''; ?>" id="jabatan" name="jabatan" value="<?= (old('jabatan')) ? old('jabatan') : $result['jabatan']; ?>">
                            <div class="invalid-feedback"><?= $validation->getError('jabatan'); ?></div>
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

<script>
    $('#nomor_telepon').mask('0000-0000-00000');
</script>

<?= $this->endsection(); ?>