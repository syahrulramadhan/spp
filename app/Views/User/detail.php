<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Data</li>
        <li class="breadcrumb-item"><a href="<?= base_url('user'); ?>">User</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= $result['nama_depan'] . " " . $result['nama_belakang'] ?></li>
    </ol>
</nav>

<div class="d-flex align-items-center p-3 my-1 text-white-50 bg-info rounded shadow-sm">
    <div class="lh-100">
        <h6 class="mb-0 text-white lh-100 text-uppercase"><?= $result['nama_depan'] . " " . $result['nama_belakang'] ?></h6>
    </div>
</div>

<div class="card mb-3">
    <div class="row">
        <div class="col-md-8">
            <div class="card-body">
                <h5 class="card-title">
                    <?= $result['nama_depan'] . " " . $result['nama_belakang'] ?>
                    <small><?= $result['email'] ?></small>
                </h5>
                
                <p class="card-text"><?= $result['nomor_telepon'] ?></p>
                <p class="card-text"><?= $result['role'] ?></p>
                <p class="card-text"><?= $result['jabatan'] ?></p>
                
                <a href="/user/edit/<?= $result['id']; ?>" class="btn btn-info">Edit</a>

                <form action="/user/delete/<?= $result['id']; ?>" method="post" class="d-inline">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-info" onclick="return confirm('Apakah anda yakin?');">Delete</button>
                </form>
                <a class="btn btn-info" href="/user">Lihat Rekap</a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>