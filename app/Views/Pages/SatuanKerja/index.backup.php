<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Dashboard</a></li>
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
                <table class="table table-sm">
                    <thead>
                    <tr>
                        <th class="text-center col-small">#</th>
                        <th>NAMA SATUAN KERJA</th>
                        <th>STATUS SATUAN KERJA</th>
                        <th>KETERANGAN SATUAN KERJA</th>
                        <th>JENIS SATUAN KERJA</th>
                        <th class="text-center col-small">PILIHAN</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $i = 1;

                        foreach($result as $rows):
                    ?>
                    <tr>
                        <th scope="row" class="text-center"><?= $i++; ?></th>
                        <td><?= $rows['nama_satker']; ?></td>
                        <td><?= $rows['status_satker']; ?></td>
                        <td><?= $rows['ket_satker']; ?></td>
                        <td><?= $rows['jenis_satker']; ?></td>
                        <td class="text-center"><a href="satuan-kerja/<?= $rows['id']; ?>" class="btn btn-success">Lihat</a></td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>