<?= $this->extend('layout/template'); ?>

<?= $this->section('content') ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url('kegiatan'); ?>">Kegiatan</a></li>
        <li class="breadcrumb-item active" aria-current="page">Form <?= $result['nama_jenis_advokasi']; ?></li>
    </ol>
</nav>

<div class="d-flex align-items-center p-3 my-1 text-white-50 bg-info rounded shadow-sm">
    <div class="lh-100">
        <h6 class="mb-0 text-white lh-100 text-uppercase">Form <?= $result['nama_jenis_advokasi']; ?></h6>
    </div>
</div>
<form id="form-submit" action="/kegiatan/save/<?= $result['id']; ?>" method="post" enctype="multipart/form-data">
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
                    <?= csrf_field(); ?>
                    <input type="hidden" name="jenis_advokasi_id" value="<?= $result['id']; ?>">   
                    <input type="hidden" name="jenis_advokasi_nama" value="<?= $result['nama_jenis_advokasi']; ?>">  

                    <div class="form-group row">
                        <label for="nama_kegiatan" class="col-sm-2 col-form-label">Nama Kegiatan <span class="text-danger font-weight-bold">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control <?= ($validation->hasError('nama_kegiatan')) ? 'is-invalid' : ''; ?>" id="nama_kegiatan" name="nama_kegiatan" autofocus value="<?= old('nama_kegiatan'); ?>">
                            <div class="invalid-feedback"><?= $validation->getError('nama_kegiatan'); ?></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tanggal_pelaksanaan" class="col-sm-2 col-form-label">Tanggal Pelaksanaan <span class="text-danger font-weight-bold">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control <?= ($validation->hasError('tanggal_pelaksanaan')) ? 'is-invalid' : ''; ?>" id="tanggal_pelaksanaan" name="tanggal_pelaksanaan" placeholder="DD-MM-YYYY" value="<?= old('tanggal_pelaksanaan'); ?>">
                            <div class="invalid-feedback"><?= $validation->getError('tanggal_pelaksanaan'); ?></div>
                        </div>
                    </div>
                    <?php if(in_array($result['id'], array(8))){ ?>
                    <div class="form-group row" id="field_satker">
                        <label for="tahapan" class="col-sm-2 col-form-label">Tahapan <span class="text-danger font-weight-bold">*</span></label>
                        <div class="col-sm-10">
                            <?php $isinvalid = ($validation->hasError('tahapan')) ? 'is-invalid' : ''; ?>
                            <?= form_dropdown('tahapan', ['' => '--Pilih--', 'AWARENESS' => 'Awareness', 'KOMITMEN' => 'Komitmen', 'PENINGKATAN_KAPASITAS' => 'Peningkatan Kapasitas', 'MONITORING_COACHING' => 'Mentoring/Coaching'], old('tahapan'), ['class' => "custom-select $isinvalid", 'id' => 'tahapan']); ?>
                            <div class="invalid-feedback"><?= $validation->getError('tahapan'); ?></div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card-body">
                    <div class="form-group row">
                        <label for="nama_narasumber" class="col-sm-4 col-form-label">Narasumber 1 <span class="text-danger font-weight-bold">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control <?= ($validation->hasError('nama_narasumber')) ? 'is-invalid' : ''; ?>" id="nama_narasumber" name="nama_narasumber" value="<?= old('nama_narasumber'); ?>">
                            <div class="invalid-feedback"><?= $validation->getError('nama_narasumber'); ?></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama_narasumber_second" class="col-sm-4 col-form-label">Narasumber 2 <?php /*<small>(Opsional)</small>*/ ?></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control <?= ($validation->hasError('nama_narasumber_second')) ? 'is-invalid' : ''; ?>" id="nama_narasumber_second" name="nama_narasumber_second" value="<?= old('nama_narasumber_second'); ?>">
                            <div class="invalid-feedback"><?= $validation->getError('nama_narasumber_second'); ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card-body">
                    <div class="form-group row">
                        <label for="keterangan" class="col-sm-4 col-form-label">
                            Upload Dokumen <?php /*<small>(Opsional)</small>*/ ?>
                        </label>
                        <div class="col-sm-8">
                            <div><input class="form-control" style="margin-top: 0.5em;" type="file" name="kegiatan_file[]" size="20" multiple /></div>
                            <div id="inputForm"></div>
                            <div style="color: white;">
                                <a id="addInput" style="margin: 0.5em 0;" class="btn btn-info"><i class="fa fa-plus"></i></a>
                                <a id="removeInput" class="btn btn-info"><i class="fa fa-minus"></i></a>
                                <a id="removeAllInput" class="btn btn-info"><i class="fa fa-trash"></i></a>
                            </div>
                            <small style="color:red">*jpeg, *.jpg, *.png, *.pdf, *.xls, *.xlsx, *.doc, *.docx, *.ppt, *.pptx (Max 2MB)</small>	
                        </div>
                    </div>
                </div> 
            </div>
            <div class="col-md-12">
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-sm-10">

                        <?php $url = "jenis_advokasi_id=" . $result['id']; ?>

                        <button type="submit" class="btn btn-info">Tambah Data</button>
                        <a class="btn btn-info" href="<?= base_url("kegiatan?" . $url); ?>" <?php /* href="/kegiatan" */ ?>>Lihat Rekap</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script type="text/javascript">
    $('#tahapan').change(function(){ submit_disable(); });
    $('#tahapan').select2();

    $("#addInput").on("click",function(){
        var str = '<input class="form-control"  id="removeInputFile" style="margin-top: 0.5em;" type="file" name="kegiatan_file[]" size="20" multiple />';
        $("#inputForm").append(str);
    });

    $("#removeInput").on("click",function(){
        $("#removeInputFile").remove();
    });

    $("#removeAllInput").on("click",function(){
        $("#inputForm input").remove();
    });
</script>

<?= $this->endsection(); ?>

