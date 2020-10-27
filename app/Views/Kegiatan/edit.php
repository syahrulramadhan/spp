<?= $this->extend('layout/template'); ?>

<?= $this->section('content') ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url('kegiatan'); ?>">Kegiatan</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url('kegiatan/' . $result['id']); ?>"><?= $result['nama_kegiatan']; ?></a></li>
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
                <?php /* $validation->listErrors(); */ ?>
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
                <form id="form-submit" action="/kegiatan/update/<?= $result['id']; ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field(); ?>
                    <div class="form-group row">
                        <label for="nama_kegiatan" class="col-sm-2 col-form-label">Nama Kegiatan <span class="text-danger font-weight-bold">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control <?= ($validation->hasError('nama_kegiatan')) ? 'is-invalid' : ''; ?>" id="nama_kegiatan" name="nama_kegiatan" autofocus value="<?= (old('nama_kegiatan')) ? old('nama_kegiatan') : $result['nama_kegiatan']; ?>">
                            <div class="invalid-feedback"><?= $validation->getError('nama_kegiatan'); ?></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tanggal_pelaksanaan" class="col-sm-2 col-form-label">Tanggal Pelaksanaan <span class="text-danger font-weight-bold">*</span></label>
                        <div class="col-sm-10">
                        <input type="text" class="form-control <?= ($validation->hasError('tanggal_pelaksanaan')) ? 'is-invalid' : ''; ?>" id="tanggal_pelaksanaan" name="tanggal_pelaksanaan" placeholder="MM/DD/YYYY" autofocus value="<?= (old('tanggal_pelaksanaan')) ? old('tanggal_pelaksanaan') : $result['tanggal_pelaksanaan']; ?>">
                            <div class="invalid-feedback"><?= $validation->getError('tanggal_pelaksanaan'); ?></div>
                        </div>
                    </div>
                    <?php if(in_array($result['jenis_advokasi_id'], array(8))){ ?>
                    <div class="form-group row" id="field_satker">
                        <label for="tahapan" class="col-sm-2 col-form-label">Tahapan <span class="text-danger font-weight-bold">*</span></label>
                        <div class="col-sm-10">
                            <?php $isinvalid = ($validation->hasError('tahapan')) ? 'is-invalid' : ''; ?>
                            <?= form_dropdown('tahapan', ['' => '--Pilih--', 'AWARENESS' => 'Awareness', 'KOMITMEN' => 'Komitmen', 'PENINGKATAN_KAPASITAS' => 'Peningkatan Kapasitas', 'MONITORING_COACHING' => 'Mentoring/Coaching'], (old('tahapan')) ? old('tahapan') : $result['tahapan'], ['class' => "custom-select $isinvalid", 'id' => 'tahapan']); ?>
                            <div class="invalid-feedback"><?= $validation->getError('tahapan'); ?></div>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="form-group row">
                        <div class="col-sm-10">
                        <button type="submit" class="btn btn-info">Ubah Data</button>
                        <a class="btn btn-info" href="/kegiatan/<?= $result['id']; ?>">Lihat Rekap</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#tahapan').change(function(){ submit_disable(); });
    $('#tahapan').select2();
</script>

<?= $this->endsection(); ?>