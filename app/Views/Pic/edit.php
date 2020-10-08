<?= $this->extend('layout/template'); ?>

<?= $this->section('content') ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Data</li>
        <li class="breadcrumb-item"><a href="<?= base_url('pic'); ?>">PIC</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url('pic/' . $result['id']); ?>"><?= $result['nama_depan'] . " " . $result['nama_belakang'] ?></a></li>
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

                <?php /* $validation->listErrors()  */ ?>
                <?php if(session()->getFlashdata('pesan')): ?>
                    <div class="alert alert-success" role="alert">
                    <?= session()->getFlashdata('pesan') ?>
                    </div>
                <?php endif; ?>
                <form id="form-submit" action="/pic/update/<?= $result['id']; ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field(); ?>

                    <div class="form-group row">
                        <label for="user_id" class="col-sm-2 col-form-label">User </label>
                        <div class="col-sm-10">
                            <?= form_dropdown('user_id', $options_user, $result['user_id'], ['id' => 'user_id', 'class' => 'custom-select ']); ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="status" class="col-sm-2 col-form-label">Status </label>
                        <div class="col-sm-10">
                            <?= form_dropdown('status', $options_status, $result['status'], ['id' => 'status', 'class' => 'custom-select ']); ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-10">
                        <button type="submit" class="btn btn-info">Ubah Data</button>
                        <a class="btn btn-info" href="/pic/<?= $result['id']; ?>">Lihat Rekap</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    $('#user_id').select2();
    $('#status').select2();
});
</script>

<?= $this->endsection(); ?>