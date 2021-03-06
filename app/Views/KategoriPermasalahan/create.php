<?= $this->extend('layout/template'); ?>

<?= $this->section('content') ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Data</li>
        <li class="breadcrumb-item"><a href="<?= base_url('kategori-permasalahan'); ?>">Kategori Permasalahan</a></li>
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
                <?php if(session()->getFlashdata('warning')): ?>
                    <div class="alert alert-warning" role="alert">
                    <?= session()->getFlashdata('warning') ?>
                    </div>
                <?php endif; ?>
                <form id="form-submit" action="/kategori-permasalahan/save" method="post" enctype="multipart/form-data">
                    <?= csrf_field(); ?>
                    <div class="form-group row">
                        <label for="nama_kategori_permasalahan" class="col-sm-2 col-form-label">Nama Kategori Permasalahan <span class="text-danger font-weight-bold">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control <?= ($validation->hasError('nama_kategori_permasalahan')) ? 'is-invalid' : ''; ?>" id="nama_kategori_permasalahan" name="nama_kategori_permasalahan" autofocus value="<?= old('nama_kategori_permasalahan'); ?>">
                            <div class="invalid-feedback"><?= $validation->getError('nama_kategori_permasalahan'); ?></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="keterangan" class="col-sm-2 col-form-label">Keterangan <span class="text-danger font-weight-bold">*</span></label>
                        <div class="col-sm-10">
                            <textarea class="form-control <?= ($validation->hasError('keterangan')) ? 'is-invalid' : ''; ?>" id="keterangan" rows="3" name="keterangan"><?= old('keterangan') ?></textarea>
                            <div class="invalid-feedback"><?= $validation->getError('keterangan'); ?></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-10">
                        <button type="submit" class="btn btn-info">Tambah Data</button>
                        <a class="btn btn-info" href="/kategori-permasalahan">Lihat Rekap</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endsection(); ?>