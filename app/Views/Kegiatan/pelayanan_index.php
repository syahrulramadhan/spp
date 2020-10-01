<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

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

                <form action='<?= base_url("kegiatan/$kegiatan_id/$jenis_advokasi_id/pelayanan/save"); ?>' method="post" enctype="multipart/form-data">
                    <?= csrf_field(); ?>

                    <input type="hidden" name="jenis_advokasi_id" value="<?= $jenis_advokasi_id; ?>">   
                    <input type="hidden" name="jenis_advokasi_nama" value="<?= $nama_jenis_advokasi; ?>">  

                    <div class="form-group row">
                        <label for="klpd" class="col-sm-2 col-form-label">K/L/Pemda </label>
                        <div class="col-sm-10">
                            <?= form_dropdown('klpd_id', $options_klpd, old('klpd_id'), ['class' => 'custom-select ', 'id' => 'klpd_id']); ?>
                        </div>
                    </div>
                    <div class="form-group row" id="field_satker">
                        <label for="kd_satker" class="col-sm-2 col-form-label">Satuan Kerja </label>
                        <div class="col-sm-10">
                            <?= form_dropdown('kd_satker', '', old('kd_satker'), ['class' => 'custom-select', 'id' => 'kd_satker']); ?>
                        </div>
                    </div>
                    <div class="form-group row" id="field_klpd_lainnya">
                        <label for="klpd_nama_lainnya" class="col-sm-2 col-form-label">K/L/Pemda Lainya</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control <?= ($validation->hasError('klpd_nama_lainnya')) ? 'is-invalid' : ''; ?>" id="klpd_nama_lainnya" name="klpd_nama_lainnya" value="<?= old('klpd_nama_lainnya'); ?>">
                            <div class="invalid-feedback"><?= $validation->getError('klpd_nama_lainnya'); ?></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="keterangan" class="col-sm-2 col-form-label">Keterangan</label>
                        <div class="col-sm-10">
                            <textarea class="form-control <?= ($validation->hasError('keterangan')) ? 'is-invalid' : ''; ?>" id="keterangan" rows="3" name="keterangan"><?= old('keterangan') ?></textarea>
                            <div class="invalid-feedback"><?= $validation->getError('keterangan'); ?></div>
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
                        <th>K/L/Pemda</th>
                        <th>SATUAN KERJA</th>
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
                                <div><?= ($rows['klpd_nama']) ? $rows['klpd_nama'] : $rows['klpd_nama_lainnya'] ; ?></div>
                            </td>
                            <td>
                                <div><?= $rows['satuan_kerja_nama']; ?></div>
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

<script>
    $(document).ready(function(){
        //default dropdown satuan kerja
        $("#field_satker").hide();

        // Add <select > element
        $('#klpd_id').change(function(){
            $.ajax({
                url: '<?= base_url('pages/satuan-kerja-ajax') ?>/' + $('#klpd_id').val(),
                type: 'get',
                success: function(response){
                    var data = JSON.parse(response);

                    console.log(JSON.parse(response));

                    if($('#klpd_id').val() != 0){
                        $("#field_klpd_lainnya").hide();
                        $("#field_satker").show();
                    }else{
                        $("#field_klpd_lainnya").show();
                        $("#field_satker").hide();
                    }

                    $("#kd_satker").html("<option value='0' selected>--Pilih--</option>");

                    $.each(data, function(i, item) {
                        $("#kd_satker").append("<option value='" + data[i].kd_satker + "'>" + data[i].nama_satker + "</option>");
                    });
                }
            });
        });
    });
</script>

<?= $this->endSection(); ?>