<?= $this->extend('layout/template'); ?>

<?= $this->section('content') ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url('pelayanan/jenis-advokasi'); ?>">Layanan</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= $title ?></li>
    </ol>
</nav>

<div class="d-flex align-items-center p-3 my-1 text-white-50 bg-info rounded shadow-sm">
    <div class="lh-100">
        <h6 class="mb-0 text-white lh-100 text-uppercase"><?= $title ?></h6>
    </div>
</div>

<form id="form-submit" action="<?= base_url('/pelayanan/save/' . $result['id']); ?>" method="post" enctype="multipart/form-data">
    <div class="card mb-3">
        <div class="row">
            <div class="col-md-12">
                <div class="card-body">
                    <?php /* $validation->listErrors() */ ?>

                    <?php /*
                    1	Surat
                    2	Web
                    3	Rapat Eksternal
                    4	Konsolidasi
                    5	Pendampingan
                    6	Tatap Muka
                    7	WA/Telepon
                    8	Clearing House
                    9	Bimbingan Teknis
                    */ ?>

                    <?php if(session()->getFlashdata('pesan')): ?>
                        <div class="alert alert-success" role="alert">
                        <?= session()->getFlashdata('pesan') ?>
                        </div>
                    <?php endif; ?>
                    <?= csrf_field(); ?>
                    <?php if(in_array($result['id'], array(4,5))){ ?>
                    <div role="alert" aria-live="assertive" aria-atomic="true" class="toast" data-autohide="false">
                        <div class="toast-header bg-warning ">
                            <!--<img src="..." class="rounded mr-2" alt="...">-->
                            <strong class="mr-auto text-white"><i class="fa fa-warning"></i> PERHATIAN </strong>
                            <!--<small>11 mins ago</small>-->

                            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="toast-body">
                            <?php 
                                if(in_array($result['id'], array(4))){
                                    echo 'Diisi berdasarkan Paket Konsolidasi bukan setiap Kegiatan.';
                                }else if(in_array($result['id'], array(5))){
                                    echo 'Diisi berdasarkan Paket Pendampingan/Probity Advice bukan setiap Kegiatan';
                                }
                            ?>
                        </div>
                    </div>
                    <?php } ?>

                    <input type="hidden" name="jenis_advokasi_id" value="<?= $result['id']; ?>">   
                    <input type="hidden" name="jenis_advokasi_nama" value="<?= $result['nama_jenis_advokasi']; ?>">  

                    <div class="form-group row">
                        <label for="tanggal_pelaksanaan" class="col-sm-2 col-form-label">
                            <?php 
                                if(in_array($result['id'], array(1))){
                                    echo 'Tanggal Surat Keluar';
                                }else if(in_array($result['id'], array(3))){
                                    echo 'Tanggal Pertemuan ';
                                }else if(in_array($result['id'], array(4,5))){
                                    echo 'Tanggal Pelaksanaan';
                                }else{
                                    echo 'Tanggal Kirim ';
                                }
                            ?> <span class="text-danger font-weight-bold">*</span>
                        </label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control <?= ($validation->hasError('tanggal_pelaksanaan')) ? 'is-invalid' : ''; ?>" id="tanggal_pelaksanaan" name="tanggal_pelaksanaan" placeholder="DD-MM-YYYY" autofocus value="<?= old('tanggal_pelaksanaan'); ?>">
                            <div class="invalid-feedback"><?= $validation->getError('tanggal_pelaksanaan'); ?></div>
                        </div>
                    </div>
                    
                    <?php if(in_array($result['id'], array(1))){ ?>
                    <div class="form-group row">
                        <label for="nomor_surat_keluar" class="col-sm-2 col-form-label">Nomor Surat Keluar <span class="text-danger font-weight-bold">*</span></label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control <?= ($validation->hasError('nomor_surat_keluar')) ? 'is-invalid' : ''; ?>" id="nomor_surat_keluar" name="nomor_surat_keluar" value="<?= old('nomor_surat_keluar'); ?>">
                            <div class="invalid-feedback"><?= $validation->getError('nomor_surat_keluar'); ?></div>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if(in_array($result['id'], array(3))){ ?>
                    <div class="form-group row">
                        <label for="nomor_undangan" class="col-sm-2 col-form-label">Nomor Undangan <?php /*<small>(Opsional)</small>*/ ?></label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control <?= ($validation->hasError('nomor_undangan')) ? 'is-invalid' : ''; ?>" id="nomor_undangan" name="nomor_undangan" value="<?= old('nomor_undangan'); ?>">
                            <div class="invalid-feedback"><?= $validation->getError('nomor_undangan'); ?></div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card-body">
                    <?php if(in_array($result['id'], array(1,2,6,7))){ ?>
                    <div class="form-group row">
                        <label for="nama" class="col-sm-4 col-form-label">
                            <?php 
                                if(in_array($result['id'], array(6))){
                                    echo 'Nama Tamu';
                                }else if(in_array($result['id'], array(7))){
                                    echo 'Nama Penanya';
                                }else{
                                    echo 'Nama Penerima  ';
                                }
                            ?>
                            <?php if(in_array($result['id'], array(1,2))){ ?>
                            <?php /*<small>(Opsional)</small>*/ ?>
                            <?php }else{ ?>
                                <span class="text-danger font-weight-bold">*</span>
                            <?php } ?>
                        </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control <?= ($validation->hasError('nama')) ? 'is-invalid' : ''; ?>" id="nama" name="nama" value="<?= old('nama'); ?>">
                            <div class="invalid-feedback"><?= $validation->getError('nama'); ?></div>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if(in_array($result['id'], array(1,2,6,7))){ ?>
                    <div class="form-group row">
                        <label for="jabatan" class="col-sm-4 col-form-label">Jabatan <span class="text-danger font-weight-bold">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control <?= ($validation->hasError('jabatan')) ? 'is-invalid' : ''; ?>" id="jabatan" name="jabatan" value="<?= old('jabatan'); ?>">
                            <div class="invalid-feedback"><?= $validation->getError('jabatan'); ?></div>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if(in_array($result['id'], array(1,2,6,7))){ ?>
                    <div class="form-group row">
                        <label for="nomor_telepon" class="col-sm-4 col-form-label">Nomor Telepon <?php /*<small>(Opsional)</small>*/ ?></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control <?= ($validation->hasError('nomor_telepon')) ? 'is-invalid' : ''; ?>" id="nomor_telepon" name="nomor_telepon" value="<?= old('nomor_telepon'); ?>">
                            <div class="invalid-feedback"><?= $validation->getError('nomor_telepon'); ?></div>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if(in_array($result['id'], array(1,2,3,4,5,6,7))){ ?>
                    <div class="form-group row">
                        <label for="klpd" class="col-sm-4 col-form-label">K/L/Pemda <span id="field_required_klpd" class="text-danger font-weight-bold">*</span></label>
                        <div class="col-sm-8">
                            <?php $isinvalid = ($validation->hasError('klpd_id')) ? 'is-invalid' : ''; ?>
                            <?= form_dropdown('klpd_id', $options_klpd, old('klpd_id'), ['class' => 'custom-select ', 'id' => 'klpd_id', 'class' => "custom-select  $isinvalid"]); ?>
                            <div class="invalid-feedback"><?= $validation->getError('klpd_id'); ?></div>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if(in_array($result['id'], array(1,2,3,4,5,6,7))){ ?>
                    <div class="form-group row" id="field_satker">
                        <label for="kd_satker" class="col-sm-4 col-form-label">Satuan Kerja <span class="text-danger font-weight-bold">*</span></label>
                        <div class="col-sm-8">
                            <?php $isinvalid = ($validation->hasError('kd_satker')) ? 'is-invalid' : ''; ?>
                            <?= form_dropdown('kd_satker', '', old('kd_satker'), ['class' => 'custom-select', 'id' => 'kd_satker', 'class' => "custom-select  $isinvalid"]); ?>
                            <div class="invalid-feedback"><?= $validation->getError('kd_satker'); ?></div>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if(in_array($result['id'], array(1,2,3,4,5,6,7))){ ?>
                    <div class="form-group row" id="field_klpd_lainnya">
                        <label for="klpd_nama_lainnya" class="col-sm-4 col-form-label">Instansi Lainnya <span class="text-danger font-weight-bold">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control <?= ($validation->hasError('klpd_nama_lainnya')) ? 'is-invalid' : ''; ?>" id="klpd_nama_lainnya" name="klpd_nama_lainnya" value="<?= old('klpd_nama_lainnya'); ?>">
                            <div class="invalid-feedback"><?= $validation->getError('klpd_nama_lainnya'); ?></div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card-body">
                    <?php if(in_array($result['id'], array(1,2,3,4,5,6,7))){ ?>
                    <div class="form-group row">
                        <label for="paket_kode" class="col-sm-4 col-form-label">Kode Paket <?php /*<small>(Opsional)</small>*/ ?></label>
                        <div class="col-sm-8">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control <?= ($validation->hasError('paket_kode')) ? 'is-invalid' : ''; ?>" id="paket_kode" name="paket_kode" placeholder="Masukan kode paket" value="<?= old('paket_kode'); ?>">
                                <?php /*<div class="input-group-append">
                                    <button class="btn btn-outline-info" id="paket_search" type="submit"><i class="fa fa-search"></i></button>
                                </div>*/ ?>
                            </div>
                            <div class="invalid-feedback"><?= $validation->getError('paket_kode'); ?></div>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if(in_array($result['id'], array(1,2,3,4,5,6,7))){ ?>
                    <div class="form-group row">
                        <label for="paket_nama" class="col-sm-4 col-form-label">
                            Nama Paket 
                            <?php if(in_array($result['id'], array(1,2,3,6,7))){ ?>
                            <?php /*<small>(Opsional)</small>*/ ?>
                            <?php }else{ ?>
                            <span class="text-danger font-weight-bold">*</span>
                            <?php } ?>
                        </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control <?= ($validation->hasError('paket_nama')) ? 'is-invalid' : ''; ?>" id="paket_nama" name="paket_nama" value="<?= old('paket_nama'); ?>">
                            <div class="invalid-feedback"><?= $validation->getError('paket_nama'); ?></div>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if(in_array($result['id'], array(1,2,3,4,5,6,7))){ ?>
                    <div class="form-group row">
                        <label for="paket_nilai_pagu" class="col-sm-4 col-form-label">Nilai Paket (Rp.) 
                            <?php if(in_array($result['id'], array(1,2,3,6,7))){ ?>
                            <?php /*<small>(Opsional)</small>*/ ?>
                            <?php }else{ ?>
                            <span class="text-danger font-weight-bold">*</span>
                            <?php } ?>
                        </label>
                        <div class="col-sm-8">
                            <input type="text" maxlength="26" class="form-control <?= ($validation->hasError('paket_nilai_pagu')) ? 'is-invalid' : ''; ?>" id="paket_nilai_pagu" name="paket_nilai_pagu" value="<?= old('paket_nilai_pagu'); ?>">
                            <div class="invalid-feedback"><?= $validation->getError('paket_nilai_pagu'); ?></div>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if(in_array($result['id'], array(1,2,3,4,5,6,7))){ ?>
                    <div class="form-group row">
                        <label for="paket_jenis_pengadaan_id" class="col-sm-4 col-form-label">Jenis Barang/Jasa <span class="text-danger font-weight-bold">*</span></label>
                        <div class="col-sm-8">
                            <?php $isinvalid = ($validation->hasError('paket_jenis_pengadaan_id')) ? 'is-invalid' : ''; ?>
                            <?= form_dropdown('paket_jenis_pengadaan_id', $options_jenis_pengadaan, old('paket_jenis_pengadaan_id'), ['id'=>'paket_jenis_pengadaan_id', 'class' => "custom-select  $isinvalid"]); ?>
                            <div class="invalid-feedback"><?= $validation->getError('paket_jenis_pengadaan_id'); ?></div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card-body">
                    <?php if(in_array($result['id'], array(4))){ ?>
                    <?php } ?>
                    <?php if(in_array($result['id'], array(1,2,3,4,5,6,7))){ ?>
                    <div class="form-group row">
                        <label for="kategori_permasalahan_id" class="col-sm-2 col-form-label">Kategori Permasalahan <span class="text-danger font-weight-bold">*</span></label>
                        <div class="col-sm-4">
                            <?php $isinvalid = ($validation->hasError('kategori_permasalahan_id')) ? 'is-invalid' : ''; ?>
                            <?= form_dropdown('kategori_permasalahan_id', $options_kategori_permasalahan, old('kategori_permasalahan_id'), ['id' => 'kategori_permasalahan_id', 'class' => "custom-select $isinvalid"]); ?>
                            <div class="invalid-feedback"><?= $validation->getError('kategori_permasalahan_id'); ?></div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <?php if(in_array($result['id'], array(1,2,3,4,5,6,7))){ ?>
            <div class="col-md-6">
                <div class="card-body">
                    <div class="form-group row">
                        <label for="pic_id" class="col-sm-4 col-form-label">
                            <?php 
                                if(in_array($result['id'], array(1,2))){
                                    echo 'Drafter 1';
                                }else{
                                    echo 'Pic 1';
                                } 
                            ?>
                            <span class="text-danger font-weight-bold">*</span>
                        </label>
                        <div class="col-sm-8">
                            <?php $isinvalid = ($validation->hasError('pic_id')) ? 'is-invalid' : ''; ?>
                            <?= form_dropdown('pic_id', $options_pic,  old('pic_id'), ['id' => 'pic_id', 'class' => "custom-select $isinvalid"]); ?>
                            <div class="invalid-feedback"><?= $validation->getError('pic_id'); ?></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="pic_id" class="col-sm-4 col-form-label">
                            <?php 
                                if(in_array($result['id'], array(1,2))){
                                    echo 'Drafter 2';
                                }else{
                                    echo 'Pic 2';
                                } 
                            ?>
                            <?php /*<small>(Opsional)</small>*/ ?>
                        </label>
                        <div class="col-sm-8">
                            <?php $isinvalid = ($validation->hasError('pic_second_id')) ? 'is-invalid' : ''; ?>
                            <?= form_dropdown('pic_second_id', $options_pic, old('pic_second_id'), ['id' => 'pic_second_id', 'class' => "custom-select $isinvalid"]); ?>
                            <div class="invalid-feedback"><?= $validation->getError('pic_second_id'); ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
            <?php if(in_array($result['id'], array(1,2,3,4,5,6,7))){ ?>
            <div class="col-md-6">
                <div class="card-body">
                    <div class="form-group row">
                        <label for="keterangan" class="col-sm-4 col-form-label">
                            <?php
                                if(in_array($result['id'], array(3,4,5))){
                                    echo 'Laporan/Notulensi ';
                                }else{
                                    echo 'Upload Dokumen';
                                } 
                            ?>
                            <?php /*<small>(Opsional)</small>*/ ?>
                        </label>
                        <div class="col-sm-8">
                            <div><input class="form-control" style="margin-top: 0.5em;" type="file" name="pelayanan_file[]" size="20" multiple/></div>
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
            <?php } ?>
            <div class="col-md-12">
                <div class="card-body">
                    <?php if(in_array($result['id'], array(1,2,3,4,5,6,7))){ ?>
                    <div class="form-group row">
                        <label for="keterangan" class="col-sm-2 col-form-label">Keterangan 
                            <?php if(in_array($result['id'], array(1,2,3,4,5))){ ?>
                                <?php /*<small>(Opsional)</small>*/ ?>
                            <?php }else{ ?>
                                <span class="text-danger font-weight-bold">*</span>
                            <?php } ?>
                        </label>
                        <div class="col-sm-10">
                            <textarea class="form-control <?= ($validation->hasError('keterangan')) ? 'is-invalid' : ''; ?>" id="keterangan" rows="3" name="keterangan"><?= old('keterangan') ?></textarea>
                            <div class="invalid-feedback"><?= $validation->getError('keterangan'); ?></div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-sm-10">

                        <?php $url = "jenis_advokasi_id=" . $result['id']; ?>

                        <button type="submit" class="btn btn-info">Tambah Data</button>
                        <a class="btn btn-info" href="<?= base_url("pelayanan?" . $url); ?>" <?php /* href="/pelayanan/jenis-advokasi" */ ?>>Lihat Rekap</a>
                        </div>
                    </div>
                </div>
            </div>  
        </div>
    </div>
</form>

<script>
    $(document).ready(function(){
        $('#paket_jenis_pengadaan_id').change(function (){ submit_disable(); });
        $('#kategori_permasalahan_id').change(function (){ submit_disable(); });
        $('#pic_id').change(function (){ submit_disable(); });
        $('#pic_second_id').change(function (){ submit_disable(); });

        $('#paket_nilai_pagu').mask("#.##0", {reverse: true});
        $('#nomor_telepon').mask('0000-0000-00000');

        $('.toast').toast('show');

        $('#klpd_id').select2();
        $('#kd_satker').select2();
        $('#paket_jenis_pengadaan_id').select2();
        $('#kategori_permasalahan_id').select2();
        $('#pic_id').select2();
        $('#pic_second_id').select2();

        var klpd_id = $('#klpd_id').val();

        //alert(klpd_id); 

        if(klpd_id != "" || klpd_id != 0){
            $("#field_klpd_lainnya").hide();
            $("#field_satker").show();
            $("#field_required_klpd").show();

            var kd_satker = '<?= old('kd_satker'); ?>';

            get_satuan_kerja(kd_satker);

            $("#klpd_nama_lainnya").val("");
        }else{
            $("#field_klpd_lainnya").show();
            $("#field_satker").hide();
            $("#field_required_klpd").hide();

            $("#kd_satker").val("");
        }

        // Add <select > element
        $('#klpd_id').change(function(){
            var klpd_id = $('#klpd_id').val();

            if(klpd_id != "" || klpd_id != 0){
                $("#field_klpd_lainnya").hide();
                $("#field_satker").show();
                $("#field_required_klpd").show();

                get_satuan_kerja();

                $("#klpd_nama_lainnya").val("");
            }else{
                $("#field_klpd_lainnya").show();
                $("#field_satker").hide();
                $("#field_required_klpd").hide();

                $("#kd_satker").val("");
            }

            submit_disable(); 
        });
        
        $('#kd_satker').change(function (){ submit_disable(); });

        $('#paket_search').click(function (e){
            e.preventDefault();

            var paket_kode = $('#paket_kode').val();

            $.ajax({
                url: 'https://inaproc.lkpp.go.id/isb/api/818d2bea-046a-4366-a2f7-77cdb25b8c9a/json/184672282/TenderSelesaiDetailSPSEbyKdTender/tipe/4/parameter/' + paket_kode,
                type: "get",
                //dataType : 'json',
                success: function(response){
                    var data = JSON.parse(response);

                    console.log(data);

                    //$('#paket_nama').val();
                    $('#klpd_id').val(data[0].kd_klpd);
                    $('#klpd_id').trigger('change.select2'); 
                    $('#paket_nama').val(data[0].nama_paket);
                    $('#paket_nilai_pagu').val(data[0].pagu);

                    var klpd_id = $('#klpd_id').val();

                    if(klpd_id != "" || klpd_id != 0){
                        $("#field_klpd_lainnya").hide();
                        $("#field_satker").show();
                        $("#field_required_klpd").show();

                        get_satuan_kerja(data[0].kd_satker);

                        $('#kd_satker').trigger('change.select2'); 
                        $("#klpd_nama_lainnya").val("");
                    }else{
                        $("#field_klpd_lainnya").show();
                        $("#field_satker").hide();
                        $("#field_required_klpd").hide();

                        $("#kd_satker").val("");
                    }

                    submit_disable(); 
                }
            });
        });
        
        function get_satuan_kerja(kd_satker = 0){
            $.ajax({
                url: '<?= base_url('pages/satuan-kerja-ajax') ?>/' + $('#klpd_id').val(),
                type: 'get',
                success: function(response){
                    var data = JSON.parse(response);

                    console.log(JSON.parse(response));

                    $("#kd_satker").html("<option value='' selected>--Pilih--</option>");

                    $.each(data, function(i, item) {
                        $("#kd_satker").append("<option value='" + data[i].kd_satker + "'>" + data[i].nama_satker + "</option>");
                    });

                    if(kd_satker)
                        $("#kd_satker").val(kd_satker);
                }
            });
        }

        $("#addInput").on("click",function(){
            var str = '<input class="form-control" id="removeInputFile" style="margin-top: 0.5em;" type="file" name="pelayanan_file[]" size="20" multiple/>';
            $("#inputForm").append(str);
        });

        $("#removeInput").on("click",function(){
            $("#removeInputFile").remove();
        });

        $("#removeAllInput").on("click",function(){
            $("#inputForm input").remove();
        });
    });
</script>

<?= $this->endsection(); ?>