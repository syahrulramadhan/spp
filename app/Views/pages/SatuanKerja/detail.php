<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Data</li>
        <li class="breadcrumb-item"><a href="<?= base_url('pages/klpd'); ?>">K/L/Pemda</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url('pages/klpd/' . $klpd_id); ?>">Satuan Kerja</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= $result['nama_satker'] ?></li>
    </ol>
</nav>

<div class="d-flex align-items-center p-3 my-1 text-white-50 bg-info rounded shadow-sm">
    <div class="lh-100">
        <h6 class="mb-0 text-white lh-100 text-uppercase"><?= $result['nama_satker'] ?></h6>
    </div>
</div>

<div class="card mb-3">
    <div class="row no-gutters">
        <div class="col-md-8">
        <div class="card-body">
            <h5 class="card-title"><?= $result['nama_satker']; ?></h5>
            <p class="card-text"><?= $result['status_satker'] ?></p>
            <p class="card-text"><?= $result['ket_satker'] ?></p>
            <p class="card-text"><?= $result['jenis_satker'] ?></p>
            <a href="/pages/klpd/<?= $klpd_id; ?>" class="btn btn-info">Lihat Rekap</a>
        </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>