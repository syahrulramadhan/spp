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
                <form id="form-submit" action="" method="GET">
                    <div class="row">
                        <div class="col-6">
                        Tampilkan <?= form_dropdown('per_page', $options_per_page, $per_page, ['class' => 'custom-select ', 'id' => 'per_page', 'class' => "custom-select col-sm-3 mr-2"]); ?>
                        </div>
                        <div class="col-6 pull-right">
                            <div class="input-group mb-3">
                                <?= form_dropdown('tahun', $options_tahun, $tahun, ['class' => 'custom-select ', 'id' => 'tahun', 'class' => "custom-select mr-2"]); ?>
                                <?= form_dropdown('jenis_advokasi_id', ['' => '--Pilih--', '8' => 'Clearing House', '9' => 'Bimbingan Teknis'], $jenis_advokasi_id, ['id' => 'jenis_advokasi_id', 'class' => "custom-select mr-2"]); ?>
                                <input type="text" class="form-control" placeholder="Masukan kata nama" name="q" value="<?= $keyword ?>" autofocus>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-info" type="submit"><i class="fa fa-search"></i></button>
                                </div>
                            </div>  
                        </div>
                    </div>
                </form>
                <?php if(session()->getFlashdata('pesan')): ?>
                    <div class="alert alert-success" role="alert">
                    <?= session()->getFlashdata('pesan') ?>
                    </div>
                <?php endif; ?>
                <?php if(session()->getFlashdata('warning')): ?>
                    <div class="alert alert-warning" role="alert">
                    <?= session()->getFlashdata('warning') ?>
                    </div>
                <?php endif; ?>
                <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead>
                    <tr>
                        <th class="text-center col-small">NO</th>
                        <th>NAMA KEGIATAN</th>
                        <th>TANGGAL PELAKSANAAN</th>
                        <th>JENIS ADVOKASI</th>
                        <th style="width: 200px;" class="text-center col-small">JUMLAH PESERTA</th>
                        <th>DIBUAT OLEH</th>
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
                                    <td class="text-center"><?= $rows['jenis_advokasi_nama']; ?></td>
                                    <td class="text-center"><?= ($rows['jumlah_pelayanan']) ? $rows['jumlah_pelayanan'] : 0; ?></td>
                                    <td><?= $rows['nama_depan'] . " " . $rows['nama_belakang']; ?></td>
                                    <td class="text-center">
                                        <a href="<?= base_url('kegiatan/' . $rows['id']); ?>" class="text-decoration-none">
                                           Lihat
                                        </a>
                                        <?php /*
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
                                    </td>
                                </tr>
                            <?php endforeach; 
                        }else{
                            echo '<tr class="text-center"><td colspan="7">Data tidak ditemukan</td></tr>';
                        }
                    ?>
                    </tbody>
                </table>
                    </div>
                <?= $pager->links('kegiatan', 'bootstrap_pagination'); ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>