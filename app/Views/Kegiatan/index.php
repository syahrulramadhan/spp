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
                <div class="row">
                    <div class="col-9">
                        <div class="mb-3">
                            <a href="/kegiatan/create/8" class="btn btn-info">Clearing House</a>
                            <a href="/kegiatan/create/9" class="btn btn-info">Bimbingan Teknis</a>
                        </div>
                    </div>
                    <div class="col-3 pull-right">
                        <form action="" method="GET">
                            <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Masukan kata nama" name="q" value="<?= $keyword ?>" autofocus>
                            <div class="input-group-append">
                                <button class="btn btn-outline-info" type="submit"><i class="fa fa-search"></i></button>
                            </div>
                            </div>
                        </form>
                    </div>
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
                        if($result){
                            $i = 1 + ($per_page * ($currentPage - 1));

                            foreach($result as $rows):
                                ?>
                                <tr>
                                    <th scope="row" class="text-center"><?= $i++; ?></th>
                                    <td><?= $rows['nama_kegiatan']; ?></td>
                                    <td><?= $rows['tanggal_pelaksanaan']; ?></td>
                                    <td class="text-center"><?= ($rows['jumlah_pelayanan']) ? $rows['jumlah_pelayanan'] : 0; ?></td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="<?= base_url('kegiatan/' . $rows['id']); ?>" class="btn btn-sm btn-success">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a href="<?= base_url('kegiatan/' . $rows['id'] . '/materi'); ?>" class="btn btn-sm btn-success">
                                                <i class="fa fa-file"></i>
                                            </a>
                                            <a href="<?= base_url('kegiatan/' . $rows['id'] . '/' . $rows['jenis_advokasi_id'] . '/pelayanan'); ?>" class="btn btn-sm btn-success">
                                                <i class="fa fa-users"></i>
                                            </a>
                                            <a href="<?= base_url('kegiatan/' . $rows['id'] . '/narasumber'); ?>" class="btn btn-sm btn-success">
                                                <i class="fa fa-user"></i>
                                            </a>
                                        </div>
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
                                        <!--<a class="text-decoration-none" href="kegiatan/<?= $rows['id']; ?>">Lihat</a>-->
                                    </td>
                                </tr>
                            <?php endforeach; 
                        }else{
                            echo '<tr class="text-center"><td colspan="5">Data tidak ditemukan</td></tr>';
                        }
                    ?>
                    </tbody>
                </table>
                <?= $pager->links('kegiatan', 'bootstrap_pagination'); ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>