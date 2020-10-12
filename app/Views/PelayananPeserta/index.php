<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url('pelayanan/jenis-advokasi'); ?>">Layanan</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url('pelayanan'); ?>">Daftar Layanan</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url('pelayanan/' . $pelayanan_id); ?>">Detil Layanan</a></li>
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
                <form id="form-submit" action='<?= base_url("pelayanan/$pelayanan_id/peserta/save"); ?>' method="post" enctype="multipart/form-data">
                    <?= csrf_field(); ?>

                    <div class="form-group row">
                        <label for="nama_peserta" class="col-sm-2 col-form-label">Nama Lengkap</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control <?= ($validation->hasError('nama_peserta')) ? 'is-invalid' : ''; ?>" id="nama_peserta" name="nama_peserta" value="<?= old('nama_peserta'); ?>">
                            <div class="invalid-feedback"><?= $validation->getError('nama_peserta'); ?></div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-10">
                        <button type="submit" class="btn btn-info">Tambah Data</button>
                        <a href="<?= base_url('pelayanan/' . $pelayanan_id); ?>" class="btn btn-info">Lihat Rekap</a>
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

                <table class="table table-bordered table-sm">
                    <thead>
                    <tr>
                        <th class="text-center col-small">NO</th>
                        <th>NAMA LENGKAP</th>
                        <th class="text-center col-small">PILIHAN</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    if($result){
                        $i = 1;

                        foreach($result as $rows):
                        ?>
                        <tr>
                            <th scope="row" class="text-center"><?= $i++; ?></th>
                            <td>
                                <div><?= $rows['nama_peserta']; ?></div>
                            </td>
                            <td class="text-center">
                                <form action="<?php echo base_url("pelayanan/$pelayanan_id/peserta/delete/" . $rows['id']); ?>" method="post" class="d-inline">
                                    <?= csrf_field(); ?>
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah anda yakin?');">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; 
                    }else{ ?>
                        <tr><td colspan="3" class="text-center">Data tidak ditemukan.</td></tr>
                    <?php }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>