<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Data</li>
        <li class="breadcrumb-item"><a href="<?= base_url('pic'); ?>">PIC</a></li>
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
        <div class="col-md-12">
            <div class="card-body">
                <h5 class="card-title">
                    <div><?= $result['nama_depan'] . " " . $result['nama_belakang'] ?></div>
                    <small><?= $result['email'] ?></small>
                </h5>
                
                <p><span class="py-2 px-2 badge <?= ($result['status'] == 'ACTIVE') ? 'badge-success' : 'badge-danger' ?>"><?= ($result['status'] == 'ACTIVE') ? 'AKTIF' : 'TIDAK AKTIF' ?></span></p>
                
                <p class="card-text"><?= $result['nomor_telepon'] ?></p>
                <p class="card-text"><?= $result['jabatan'] ?></p>
                <a href="/pic/edit/<?= $result['id']; ?>" class="btn btn-info">Edit</a>
                <a class="btn btn-info" href="/pic">Lihat Rekap</a>
                <form id="form-submit" action="<?= base_url('/pic/delete/' . $result['id']); ?>" method="post" class="d-inline">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah anda yakin?');">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>