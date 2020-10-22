<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url('pelayanan/jenis-advokasi'); ?>">Layanan</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url('pelayanan'); ?>">Daftar Layanan</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url('pelayanan/' . $pelayanan_id); ?>">Detil Layanan</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= $title ?></li>
    </ol>
</nav>

<?php if(session('id') === $result_pelayanan['created_by'] || permission(['ADMINISTRATOR'])){ ?>
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
                <form id="form-submit" action='<?= base_url("pelayanan/$pelayanan_id/pic/save"); ?>' method="post" enctype="multipart/form-data">
                    <?= csrf_field(); ?>
                    
                    <div class="form-group row">
                        <label for="pic_id" class="col-sm-2 col-form-label">Nama Lengkap </label>
                        <div class="col-sm-10">
                            <?php $isinvalid = ($validation->hasError('pic_id')) ? 'is-invalid' : ''; ?>
                            <?= form_dropdown('pic_id', $options_pic, '', ['id' => 'pic_id', 'class' => "custom-select $isinvalid"]); ?>
                            <div class="invalid-feedback"><?= $validation->getError('pic_id'); ?></div>
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
<?php } ?>

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
                        <div class="col-9">
                            Tampilkan <?= form_dropdown('per_page', $options_per_page, $per_page, ['class' => 'custom-select ', 'id' => 'per_page', 'class' => "custom-select col-sm-3 mr-2"]); ?>
                        </div>
                        <div class="col-3 pull-right">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Masukan kata nama" name="q" value="<?= $keyword ?>" autofocus>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-info" type="submit"><i class="fa fa-search"></i></button>
                                </div>
                            </div>  
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead>
                    <tr>
                        <th class="text-center col-small">NO</th>
                        <th>NAMA LENGKAP</th>
                        <?php if(session('id') === $result_pelayanan['created_by'] || permission(['ADMINISTRATOR'])){ ?>
                        <th class="text-center col-small">PILIHAN</th>
                        <?php } ?>
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
                                <div><?= $rows['nama_depan'] . " " . $rows['nama_belakang']; ?></div>
                            </td>
                            <?php if(session('id') === $result_pelayanan['created_by'] || permission(['ADMINISTRATOR'])){ ?>
                            <td class="text-center">
                                <form action="<?php echo base_url("pelayanan/$pelayanan_id/pic/delete/" . $rows['id']); ?>" method="post" class="d-inline">
                                    <?= csrf_field(); ?>
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah anda yakin?');">Delete</button>
                                </form>
                            </td>
                            <?php } ?>
                        </tr>
                        <?php endforeach; 
                    }else{ ?>
                        <tr><td colspan="3" class="text-center">Data tidak ditemukan.</td></tr>
                    <?php }
                    ?>
                    </tbody>
                </table>
                    </div>
                <?= $pager->links('pelayanan_pic', 'bootstrap_pagination'); ?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#pic_id').change(function(){ submit_disable(); });
    $('#pic_id').select2();
</script>

<?= $this->endSection(); ?>