<?= $this->extend('layout/template'); ?>

<?= $this->section('content') ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url('pelayanan/jenis-advokasi'); ?>">Advokasi</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url('pelayanan'); ?>">Pelayanan</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url('pelayanan/' . $result['id']); ?>"><?= $result['nama_klpd'] ?></a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= $title ?></li>
    </ol>
</nav>

<div class="d-flex align-items-center p-3 my-1 text-white-50 bg-info rounded shadow-sm">
    <div class="lh-100">
        <h6 class="mb-0 text-white lh-100 text-uppercase"><?= $result['paket_nama'] ?></h6>
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

                <?= $validation->listErrors() ?>

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

                <form action="/pelayanan/<?= $result['jenis_advokasi_id']; ?>/update/<?= $result['id']; ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field(); ?>

                    <input type="hidden" name="jenis_advokasi_id" value="<?= $result['jenis_advokasi_id']; ?>">   
                    <input type="hidden" name="jenis_advokasi_nama" value="<?= $result['jenis_advokasi_nama']; ?>">  

                    <div class="form-group row">
                        <label for="tanggal_pelaksanaan" class="col-sm-2 col-form-label">Tanggal Pelaksanaan</label>
                        <div class="col-sm-10">
                        <input type="text" class="form-control <?= ($validation->hasError('tanggal_pelaksanaan')) ? 'is-invalid' : ''; ?>" id="tanggal_pelaksanaan" name="tanggal_pelaksanaan" autofocus value="<?= (old('tanggal_pelaksanaan')) ? old('tanggal_pelaksanaan') : $result['tanggal_pelaksanaan']; ?>">
                            <div class="invalid-feedback"><?= $validation->getError('tanggal_pelaksanaan'); ?></div>
                        </div>
                    </div>

                    <?php if(in_array($result['jenis_advokasi_id'], array(1))){ ?>
                    <div class="form-group row">
                        <label for="nomor_surat_keluar" class="col-sm-2 col-form-label">Nomor Surat Keluar</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control <?= ($validation->hasError('nomor_surat_keluar')) ? 'is-invalid' : ''; ?>" id="nomor_surat_keluar" name="nomor_surat_keluar" value="<?=(old('nomor_surat_keluar')) ? old('nomor_surat_keluar') : $result['nomor_surat_keluar']; ?>">
                            <div class="invalid-feedback"><?= $validation->getError('nomor_surat_keluar'); ?></div>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if(in_array($result['jenis_advokasi_id'], array(3))){ ?>
                    <div class="form-group row">
                        <label for="nomor_undangan" class="col-sm-2 col-form-label">Nomor Undangan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control <?= ($validation->hasError('nomor_undangan')) ? 'is-invalid' : ''; ?>" id="nomor_undangan" name="nomor_undangan" value="<?= (old('nomor_undangan')) ? old('nomor_undangan') : $result['nomor_undangan'] ?>">
                            <div class="invalid-feedback"><?= $validation->getError('nomor_undangan'); ?></div>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if(in_array($result['jenis_advokasi_id'], array(1,2,6,7))){ ?>
                    <div class="form-group row">
                        <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control <?= ($validation->hasError('nama')) ? 'is-invalid' : ''; ?>" id="nama" name="nama" value="<?= (old('nama')) ? old('nama') : $result['nama'] ?>">
                            <div class="invalid-feedback"><?= $validation->getError('nama'); ?></div>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if(in_array($result['jenis_advokasi_id'], array(1,2,6,7))){ ?>
                    <div class="form-group row">
                        <label for="jabatan" class="col-sm-2 col-form-label">Jabatan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control <?= ($validation->hasError('jabatan')) ? 'is-invalid' : ''; ?>" id="jabatan" name="jabatan" value="<?= (old('jabatan')) ? old('jabatan') : $result['jabatan'] ?>">
                            <div class="invalid-feedback"><?= $validation->getError('jabatan'); ?></div>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if(in_array($result['jenis_advokasi_id'], array(1,2,6,7))){ ?>
                    <div class="form-group row">
                        <label for="nomor_telepon" class="col-sm-2 col-form-label">Nomor Telepon</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control <?= ($validation->hasError('nomor_telepon')) ? 'is-invalid' : ''; ?>" id="nomor_telepon" name="nomor_telepon" value="<?= (old('nomor_telepon')) ? old('nomor_telepon') : $result['nomor_telepon'] ?>">
                            <div class="invalid-feedback"><?= $validation->getError('nomor_telepon'); ?></div>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if(in_array($result['jenis_advokasi_id'], array(3))){ ?>
                    <div class="form-group row">
                        <label for="aktifitas" class="col-sm-2 col-form-label">Aktifitas</label>
                        <div class="col-sm-10">
                            <textarea class="form-control <?= ($validation->hasError('aktifitas')) ? 'is-invalid' : ''; ?>" id="aktifitas" rows="3" name="aktifitas"><?= (old('aktifitas')) ? old('aktifitas') : $result['aktifitas'] ?></textarea>
                            <div class="invalid-feedback"><?= $validation->getError('aktifitas'); ?></div>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if(in_array($result['jenis_advokasi_id'], array(1,2,3,4,5,6,7))){ ?>
                    <div class="form-group row">
                        <label for="klpd_id" class="col-sm-2 col-form-label">K/L/Pemda </label>
                        <div class="col-sm-10">
                            <?= form_dropdown('klpd_id', $options_klpd, (old('klpd_id')) ? old('klpd_id') : $result['klpd_id'], ['class' => 'custom-select ', 'id' => 'klpd_id']); ?>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if(in_array($result['jenis_advokasi_id'], array(1,2,3,4,5,6,7))){ ?>
                    <div class="form-group row" id="field_satker">
                        <label for="kd_satker" class="col-sm-2 col-form-label">Satuan Kerja </label>
                        <div class="col-sm-10">
                            <?= form_dropdown('kd_satker', '', (old('kd_satker')) ? old('kd_satker') : $result['satuan_kerja_id'], ['class' => 'custom-select', 'id' => 'kd_satker']); ?>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if(in_array($result['jenis_advokasi_id'], array(1,2,3,4,5,6,7))){ ?>
                    <div class="form-group row" id="field_klpd_lainnya">
                        <label for="klpd_nama_lainnya" class="col-sm-2 col-form-label">K/L/Pemda Lainya</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control <?= ($validation->hasError('klpd_nama_lainnya')) ? 'is-invalid' : ''; ?>" id="klpd_nama_lainnya" name="klpd_nama_lainnya" value="<?= (old('klpd_nama_lainnya')) ? old('klpd_nama_lainnya') : $result['klpd_nama_lainnya'] ?>">
                            <div class="invalid-feedback"><?= $validation->getError('klpd_nama_lainnya'); ?></div>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if(in_array($result['jenis_advokasi_id'], array(1,2,3,4,5,6,7))){ ?>
                    <div class="form-group row">
                        <label for="paket_kode" class="col-sm-2 col-form-label">Kode Paket</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control <?= ($validation->hasError('paket_kode')) ? 'is-invalid' : ''; ?>" id="paket_kode" name="paket_kode" value="<?= (old('paket_kode')) ? old('paket_kode') : $result['paket_kode'] ?>">
                            <div class="invalid-feedback"><?= $validation->getError('paket_kode'); ?></div>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if(in_array($result['jenis_advokasi_id'], array(1,2,3,4,5,6,7))){ ?>
                    <div class="form-group row">
                        <label for="paket_nama" class="col-sm-2 col-form-label">Nama Paket</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control <?= ($validation->hasError('paket_nama')) ? 'is-invalid' : ''; ?>" id="paket_nama" name="paket_nama" value="<?= (old('paket_nama')) ? old('paket_nama') : $result['paket_nama'] ?>">
                            <div class="invalid-feedback"><?= $validation->getError('paket_nama'); ?></div>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if(in_array($result['jenis_advokasi_id'], array(1,2,3,4,5,6,7))){ ?>
                    <div class="form-group row">
                        <label for="paket_nilai_pagu" class="col-sm-2 col-form-label">Nilai Paket</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control <?= ($validation->hasError('paket_nilai_pagu')) ? 'is-invalid' : ''; ?>" id="paket_nilai_pagu" name="paket_nilai_pagu" value="<?= (old('paket_nilai_pagu')) ? old('paket_nilai_pagu') : $result['paket_nilai_pagu'] ?>">
                            <div class="invalid-feedback"><?= $validation->getError('paket_nilai_pagu'); ?></div>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if(in_array($result['jenis_advokasi_id'], array(1,2,3,4,5,6,7))){ ?>
                    <div class="form-group row">
                        <label for="paket_jenis_pengadaan_id" class="col-sm-2 col-form-label">Jenis Pengadaan </label>
                        <div class="col-sm-10">
                            <?php $isinvalid = ($validation->hasError('paket_jenis_pengadaan_id')) ? 'is-invalid' : ''; ?>
                            <?= form_dropdown('paket_jenis_pengadaan_id', $options_jenis_pengadaan, (old('efipaket_jenis_pengadaan_idiensi')) ? old('paket_jenis_pengadaan_id') : $result['paket_jenis_pengadaan_id'], ['class' => "custom-select  $isinvalid"]); ?>
                            <div class="invalid-feedback"><?= $validation->getError('paket_jenis_pengadaan_id'); ?></div>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if(in_array($result['jenis_advokasi_id'], array(1,2,3,4,5,6,7))){ ?>
                    <div class="form-group row">
                        <label for="paket_status" class="col-sm-2 col-form-label">Paket Status</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control <?= ($validation->hasError('paket_status')) ? 'is-invalid' : ''; ?>" id="paket_status" name="paket_status" value="<?= (old('paket_status')) ? old('paket_status') : $result['paket_status'] ?>">
                            <div class="invalid-feedback"><?= $validation->getError('paket_status'); ?></div>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if(in_array($result['jenis_advokasi_id'], array(4))){ ?>
                    <div class="form-group row">
                        <label for="efisiensi" class="col-sm-2 col-form-label">Efisiensi</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control <?= ($validation->hasError('efisiensi')) ? 'is-invalid' : ''; ?>" id="efisiensi" name="efisiensi" value="<?= (old('efisiensi')) ? old('efisiensi') : $result['efisiensi'] ?>">
                            <div class="invalid-feedback"><?= $validation->getError('efisiensi'); ?></div>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if(in_array($result['jenis_advokasi_id'], array(1,2,3,4,5,6,7))){ ?>
                    <div class="form-group row">
                        <label for="kategori_permasalahan_id" class="col-sm-2 col-form-label">Kategori Permasalahan </label>
                        <div class="col-sm-10">
                            <?php $isinvalid = ($validation->hasError('kategori_permasalahan_id')) ? 'is-invalid' : ''; ?>
                            <?= form_dropdown('kategori_permasalahan_id', $options_kategori_permasalahan, (old('kategori_permasalahan_id')) ? old('kategori_permasalahan_id') : $result['kategori_permasalahan_id'], ['class' => "custom-select $isinvalid"]); ?>
                            <div class="invalid-feedback"><?= $validation->getError('kategori_permasalahan_id'); ?></div>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if(in_array($result['jenis_advokasi_id'], array(1,2,3,4,5,6,7))){ ?>
                    <div class="form-group row">
                        <label for="keterangan" class="col-sm-2 col-form-label">Keterangan</label>
                        <div class="col-sm-10">
                            <textarea class="form-control <?= ($validation->hasError('keterangan')) ? 'is-invalid' : ''; ?>" id="keterangan" rows="3" name="keterangan"><?= old('keterangan') ?><?= (old('keterangan')) ? old('keterangan') : $result['keterangan'] ?></textarea>
                        </div>
                    </div>
                    <?php } ?>

                    <div class="form-group row">
                        <div class="col-sm-10">
                        <button type="submit" class="btn btn-info">Tambah Data</button>
                        <a class="btn btn-info" href="<?= base_url('pelayanan/' . $result['id']); ?>">Lihat Rekap</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>             

<script>
    $(document).ready(function(){
        //default dropdown satuan kerja
        if($('#klpd_id').val() != 0){
            $("#field_klpd_lainnya").hide();
            $("#field_satker").show();

            var kd_satker = '<?= (old('kd_satker')) ? old('kd_satker') : $result['satuan_kerja_id'] ?>';

            satuan_kerja(kd_satker);
        }else{
            $("#field_klpd_lainnya").show();
            $("#field_satker").hide();
        }

        // Add <select > element
        $('#klpd_id').change(function(){
            satuan_kerja();
        });

        function satuan_kerja(kd_satker = 0){
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

                    $("#kd_satker").html("<option value='0'>--Pilih--</option>");

                    $.each(data, function(i, item) {
                        $("#kd_satker").append("<option value='" + data[i].kd_satker + "'>" + data[i].nama_satker + "</option>");
                    });

                    $("#kd_satker").val(kd_satker);
                }
            });
        }
    });
</script>

<?= $this->endsection(); ?>