<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Data</li>
        <li class="breadcrumb-item active" aria-current="page"><?= $title ?></li>
    </ol>
</nav>

<div class="card mb-3">
    <div class="row">
        <div class="col-md-12">
            <div class="card-body">
                <?php /* $validation->listErrors(); */ ?>
                <?php if(session()->getFlashdata('pesan')): ?>
                    <div class="alert alert-success" role="alert">
                    <?= session()->getFlashdata('pesan') ?>
                    </div>
                <?php endif; ?>
                <form id="form-submit" action='<?= base_url("/pic/save"); ?>' method="post" enctype="multipart/form-data">
                    <?= csrf_field(); ?>

                    <div class="form-group row">
                        <label for="keterangan" class="col-sm-2 col-form-label">Nama Lengkap </label>
                        <div class="col-sm-10">
                            <?php $isinvalid = ($validation->hasError('user_id')) ? 'is-invalid' : ''; ?>
                            <?= form_dropdown('user_id', $options_user, '', ['id' => 'user_id','class' => "custom-select $isinvalid"]); ?>
                            <div class="invalid-feedback"><?= $validation->getError('user_id'); ?></div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-10">
                        <button type="submit" class="btn btn-info">Tambah Data</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="d-flex align-items-center p-3 my-1 text-white-50 bg-info rounded shadow-sm">
    <div class="lh-100">
        <h6 class="mb-0 text-white lh-100 text-uppercase">TABEL <?= $title ?></h6>
    </div>
</div>

<div class="card mb-3">
    <div class="row">
        <div class="col-md-12">
            <div class="card-body">
                <div class="row">
                    <div class="col-9"></div>
                    <div class="col-3 pull-right">
                        <form id="form-submit" action="" method="GET">
                            <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Masukan kata nama depan / nama belakang" name="q" value="<?= $keyword ?>" autofocus>
                            <div class="input-group-append">
                                <button class="btn btn-outline-info" type="submit"><i class="fa fa-search"></i></button>
                            </div>
                            </div>
                        </form>
                    </div>
                </div>
                <table class="table table-sm">
                    <thead>
                    <tr>
                        <th class="text-center col-small">NO</th>
                        <th>NAMA LENGKAP</th>
                        <th>EMAIL</th>
                        <th class="text-center col-small">STATUS</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        if($result){
                            $i = 1 + ($per_page * ($currentPage - 1));

                            foreach($result as $rows):
                            ?>
                            <tr>
                                <th scope="row" class="text-center"><?= $i++; ?></th>
                                <td>
                                    <div>
                                        <a href="pic/<?= $rows['id']; ?>">
                                            <?= $rows['nama_depan'] . " " . $rows['nama_belakang']; ?>
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <?= $rows['email']; ?>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-pill <?= ($rows['status'] == 'ACTIVE') ? 'badge-success' : 'badge-danger' ?>">
                                        <small><?= ($rows['status'] == 'ACTIVE') ? 'AKTIF' : 'TIDAK AKTIF' ?></small>
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; 
                        }else{
                            echo '<tr class="text-center"><td colspan="4">Data tidak ditemukan</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
                <?= $pager->links('pic', 'bootstrap_pagination'); ?>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    $('#user_id').change(function(){ submit_disable(); });
    $('#user_id').select2();
});
</script>

<?= $this->endSection(); ?>