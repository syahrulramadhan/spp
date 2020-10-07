<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Data</li>
        <li class="breadcrumb-item active" aria-current="page"><?= $title ?></li>
    </ol>
</nav>

<?php if(session()->getFlashdata('pesan')): ?>
    <div class="alert alert-success" role="alert">
    <?= session()->getFlashdata('pesan') ?>
    </div>
<?php endif; ?>

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
                    <div class="col-9">
                        <div class="mb-3">
                            <a href="/user/create" class="btn btn-info">Tambah Data</a>
                        </div>
                    </div>
                    <div class="col-3 pull-right">
                        <form action="" method="GET">
                            <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Masukan kata pencarian" name="q" value="<?= $keyword ?>" autofocus>
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
                        <th>USERNAME</th>
                        <th>EMAIL</th>
                        <th>TELEPON</th>
                        <th>ROLE</th>
                        <th>JABATAN</th>
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
                                        <a href="user/<?= $rows['id']; ?>">
                                            <?= $rows['nama_depan'] . " " . $rows['nama_belakang']; ?>
                                        </a>
                                    </div>
                                </td>
                                <td><?= $rows['username']; ?></td>
                                <td><?= $rows['email']; ?></td>
                                <td><?= $rows['nomor_telepon']; ?></td>
                                <td>
                                    <span class="badge badge-pill badge-info">
                                        <small><?= ($rows['role'] == 'ADMIN_CONTENT') ? 'ADMIN CONTENT' : $rows['role']; ?></small>
                                    </span>
                                <td><?= $rows['jabatan']; ?></td>
                            </tr>
                            <?php endforeach; 
                        }else{
                            echo '<tr class="text-center"><td colspan="7">Data tidak ditemukan</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $pager->links('user', 'bootstrap_pagination'); ?>

<?= $this->endSection(); ?>