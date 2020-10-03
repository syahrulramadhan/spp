<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url('kegiatan'); ?>">Kegiatan</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url('kegiatan/' . $kegiatan_id); ?>">Detail Kegiatan</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= $title ?></li>
    </ol>
</nav>

<div class="card mb-3">
    <div class="row">
        <div class="col-md-12">
            <div class="card-body">

                <?php if(session()->getFlashdata('pesan')): ?>
                    <div class="alert alert-success" role="alert">
                    <?= session()->getFlashdata('pesan') ?>
                    </div>
                <?php endif; ?>

                <?php /* $validation->listErrors(); */ ?>

                <form action='<?= base_url("kegiatan/$kegiatan_id/materi/save"); ?>' method="post" enctype="multipart/form-data">
                    <?= csrf_field(); ?>

                    <div class="form-group row">
                        <label for="label_materi" class="col-sm-2 col-form-label">Nama Dokumen</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control <?= ($validation->hasError('label_materi')) ? 'is-invalid' : ''; ?>" id="label_materi" name="label_materi" value="<?= old('label_materi'); ?>">
                            <div class="invalid-feedback"><?= $validation->getError('label_materi'); ?></div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <?php echo form_label('File', 'kegiatan_materi', ['class' => 'col-sm-2 col-form-label']); ?>
                        <div class="col-sm-10">
                            <?php if($result['kegiatan_materi']){ ?>
                            <div class="row">
                                <div class="col-3"><img src="<?php echo base_url('uploads/kegiatan/'.$result['kegiatan_materi']) ?>" class="img-thumbnail"></div>
                            </div>
                            <?php } ?>
                            <?php echo form_upload('kegiatan_materi', ""); ?>
                            <div>
                                <small style="color:red">*.pdf, *.doc, *.docx, *.ppt, *.pptx (Max 2MB)</small>	
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-10">
                        <button type="submit" class="btn btn-info">Tambah Data</button>
                        <a href="<?= base_url('kegiatan/' . $kegiatan_id); ?>" class="btn btn-info">Lihat Rekap</a>
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
                <table class="table table-sm">
                    <thead>
                    <tr>
                        <th class="text-center col-small">#</th>
                        <th>NAMA DOKUMEN</th>
                        <th>UKURAN</th>
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
                                <div>
                                    <a href='<?= base_url("public/uploads/kegiatan/" . $rows['nama_materi']); ?>'><?= $rows['label_materi']; ?></a>
                                    <br><small><?= $rows['type'] ?></small>
                                </div>
                            </td>
                            <td>
                                <div><?= $rows['size']; ?></div>
                            </td>
                            <td class="text-center"><a href="#" class="btn btn-danger">Hapus</a></td>
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