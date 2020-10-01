<?= $this->extend('layout/template'); ?>

<?= $this->section('content') ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Data</li>
        <li class="breadcrumb-item"><a href="<?= base_url('jenis-advokasi'); ?>">Jenis Advokasi</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url('jenis-advokasi/' . $result['id']); ?>"><?= $result['nama_jenis_advokasi'] ?></a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= $title ?></li>
    </ol>
</nav>

<div class="d-flex align-items-center p-3 my-1 text-white-50 bg-info rounded shadow-sm">
    <div class="lh-100">
        <h6 class="mb-0 text-white lh-100 text-uppercase"><?= $title ?></h6>
    </div>
</div>

<div class="card mb-3">
    <div class="row">
        <div class="col-md-12">
            <div class="card-body">
                <?php if(session()->getFlashdata('pesan')): ?>
                    <div class="alert alert-success" role="alert">
                    <?= session()->getFlashdata('pesan') ?>
                    </div>
                <?php endif; ?>

                <form action="/jenis-advokasi/update/<?= $result['id']; ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field(); ?>
                    <div class="form-group row">
                        <label for="nama_jenis_advokasi" class="col-sm-2 col-form-label">Nama Kategori Permasalahan</label>
                        <div class="col-sm-10">
                            <?= $result['nama_jenis_advokasi']; ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="keterangan" class="col-sm-2 col-form-label">Keterangan</label>
                        <div class="col-sm-10">
                            <textarea class="form-control <?= ($validation->hasError('keterangan')) ? 'is-invalid' : ''; ?>" id="keterangan" rows="3" name="keterangan"><?=(old('keterangan')) ? old('keterangan') : $result['keterangan']; ?></textarea>
                            <div class="invalid-feedback"><?= $validation->getError('keterangan'); ?></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <?php echo form_label('Gambar', 'image_jenis_advokasi', ['class' => 'col-sm-2 col-form-label']); ?>
                        <div class="col-sm-10">
                            <div class="row">
                                <div class="col-3"><img src="<?php echo base_url('uploads/jenis-advokasi/'.$result['image_jenis_advokasi']) ?>" class="img-thumbnail"></div>
                            </div>
                            <?php echo form_upload('image_jenis_advokasi', ""); ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-10">
                        <button type="submit" class="btn btn-info">Ubah Data</button>
                        <a class="btn btn-info" href="/jenis-advokasi/<?= $result['id']; ?>">Lihat Rekap</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endsection(); ?>