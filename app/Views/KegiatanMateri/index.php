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

<?php if(session('id') === $result_kegiatan['created_by'] || permission(['ADMINISTRATOR'])){ ?>
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
                <form id="form-submit" action='<?= base_url("kegiatan/$kegiatan_id/materi/save"); ?>' method="post" enctype="multipart/form-data">
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
                            <div class="row">
                                <div class="col-3 my-2" id="preview"></div>
                            </div>
                            <?php $isinvalid = ($validation->hasError('kegiatan_materi')) ? 'is-invalid' : ''; ?>
                            <?php echo form_upload('kegiatan_materi','', ['name' => 'kegiatan_materi', 'id' => 'kegiatan_materi', 'class' => "custom-select $isinvalid", 'onchange' => 'return validasiEkstensi()']); ?>
                            <div>
                                <small style="color:red">*.jpeg, *.jpg, *.png, *.pdf, *.doc, *.docx, *.ppt, *.pptx (Max 2MB)</small>	
                            </div>
                            <div class="invalid-feedback"><?= $validation->getError('kegiatan_materi'); ?></div>
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
                <table class="table table-bordered table-sm">
                    <thead>
                    <tr>
                        <th class="text-center col-small">NO</th>
                        <th>NAMA DOKUMEN</th>
                        <th>UKURAN</th>
                        <?php if(session('id') === $result_kegiatan['created_by'] || permission(['ADMINISTRATOR'])){ ?>
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
                                <div>
                                    <?php if($rows['type'] == "application/pdf" 
                                        || $rows['type'] == "image/jpeg" 
                                        || $rows['type'] == "image/jpg" 
                                        || $rows['type'] == "image/png" 
                                        || $rows['type'] == "image/gif"){ 
                                    ?>
                                        <a href="#" 
                                            data-toggle="modal" 
                                            data-target="#previewFile" 
                                            data-nama-file="<?= $rows['nama_materi'] ?>" 
                                            data-label-file="<?= $rows['label_materi'] ?>"
                                            data-type-file="<?= $rows['type'] ?>"
                                        >
                                            <?= $rows['label_materi'] ?>
                                        </a>
                                    <?php } else { ?>
                                        <a href='<?= base_url("uploads/kegiatan/" . $rows['nama_materi']); ?>'>
                                            <?= $rows['label_materi']; ?>
                                        </a>
                                    <?php } ?>
                                    <br><small><?= $rows['type'] ?></small>
                                </div>
                            </td>
                            <td>
                                <div><?= calculate_file_size($rows['size']); ?></div>
                            </td>
                            <?php if(session('id') === $result_kegiatan['created_by'] || permission(['ADMINISTRATOR'])){ ?>
                            <td class="text-center">
                                <form action="<?= base_url("kegiatan/$kegiatan_id/materi/delete/" . $rows['id']); ?>" method="post" class="d-inline">
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
        </div>
    </div>
</div>

<div class="modal fade" id="previewFile" tabindex="-1" role="dialog" aria-labelledby="previewFileLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="previewFileLabel">New message</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script type="text/javascript">
    $('#kegiatan_materi').change(function(){ submit_disable(); });

    function validasiEkstensi(){
        var inputFile = document.getElementById('kegiatan_materi');
        var pathFile = inputFile.value;
        var ekstensiOk = /(\.jpg|\.jpeg|\.png|\.pdf|\.doc|\.docx|\.ppt|\.pptx)$/i;

        console.log(inputFile);

        if(!ekstensiOk.exec(pathFile)){
            alert('Silakan upload file yang memiliki ekstensi .jpeg/.jpg/.png/.pdf/.doc/.docx/.ppt/.pptx');
            inputFile.value = '';
            return false;
        }else{
            // Preview gambar
            if (inputFile.files && inputFile.files[0]) {
                if(/(\.jpg|\.jpeg|\.png)$/i.exec(pathFile)){
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('preview').innerHTML = '<img src="'+e.target.result+'" class="img-thumbnail"/>';
                    };
                    reader.readAsDataURL(inputFile.files[0]);
                }

                document.getElementById('preview').innerHTML = '';
            }
        }
    }

    $('#previewFile').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var namafile = button.data('nama-file');
        var labelfile = button.data('label-file'); 
        var typefile = button.data('type-file');

        var modal = $(this)
        var path = '<?= base_url("uploads/kegiatan"); ?>';

        var embed = "";

        if(typefile == "application/pdf")
            embed = "<embed src='" +  path + '/' + namafile + "' type='application/pdf' width='100%' height='700px'/>";
        else{
            embed = "<img src='" + path + '/' + namafile + "' width='100%'/>";
        }
        
        modal.find('.modal-title').text(labelfile)
        modal.find('.modal-body').html(embed);
    })
</script>

<?= $this->endSection(); ?>