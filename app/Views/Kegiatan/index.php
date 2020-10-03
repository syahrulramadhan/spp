<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= $title ?></li>
    </ol>
</nav>

<div class="d-flex align-items-center p-3 my-1 text-white-50 bg-info rounded shadow-sm">
    <div class="lh-100">
        <h6 class="mb-0 text-white lh-100 text-uppercase">TABEL <?= $title ?></h6>
    </div>
</div>

<div class="card mb-3">
    <div class="row">
        <div class="col-md-12">
            <div class="card-body">

                <div class="mb-3">
                    <a href="/kegiatan/create/8" class="btn btn-info">Clearing House</a>
                    <a href="/kegiatan/create/9" class="btn btn-info">Bimbingan Teknis</a>
                </div>

                <?php if(session()->getFlashdata('pesan')): ?>
                    <div class="alert alert-success" role="alert">
                    <?= session()->getFlashdata('pesan') ?>
                    </div>
                <?php endif; ?>
                <table class="table table-sm">
                    <thead>
                    <tr>
                        <th class="text-center col-small">#</th>
                        <th>NAMA KEGIATAN</th>
                        <th>TANGGAL PELAKSANAAN</th>
                        <th style="width: 200px;" class="text-center col-small">JUMLAH PESERTA</th>
                        <th class="text-center col-small">DETAIL</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $i = 1;

                        foreach($result as $rows):
                    ?>
                    <tr>
                        <th scope="row" class="text-center"><?= $i++; ?></th>
                        <td><?= $rows['nama_kegiatan']; ?></td>
                        <td><?= $rows['tanggal_pelaksanaan']; ?></td>
                        <td class="text-center"><?= ($rows['jumlah_pelayanan']) ? $rows['jumlah_pelayanan'] : 0; ?></td>
                        <td class="text-center">
                            <?php /*
                            <div class="btn-group" role="group">
                                <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Pilih
                                </button>

                                1	Surat
                                2	Web
                                3	Rapat Eksternal
                                4	Konsolidasi
                                5	Pendampingan
                                6	Tatap Muka
                                7	WA/Telepon
                                8	Clearing House
                                9	Bimbingan Teknis

                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                <a class="dropdown-item" href="kegiatan/<?= $rows['id']; ?>/materi">Materi</a>
                                <a class="dropdown-item" href="kegiatan/<?= $rows['id']; ?>">Lihat</a>
                                <a class="dropdown-item" href="kegiatan/<?= $rows['id']; ?>/narasumber">Narasumber</a>
                                <a class="dropdown-item" href="kegiatan/<?= $rows['id']; ?>/<?= $rows['jenis_advokasi_id']; ?>/pelayanan">Pelayanan</a>
                                </div>
                            </div>
                            */ ?>
                            <a class="text-decoration-none" href="kegiatan/<?= $rows['id']; ?>">Lihat</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>