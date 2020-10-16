<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url('kegiatan'); ?>">Kegiatan</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= $result['nama_kegiatan'] ?></li>
    </ol>
</nav>

<div class="mb-3">
    <div class="row">
        <div class="col-md-8">
            <div class="d-flex align-items-center p-3 my-1 text-white-50 bg-info rounded shadow-sm">
                <div class="lh-100">
                    <h6 class="mb-0 text-white lh-100 text-uppercase"><?= $result['nama_kegiatan'] ?></h6>
                </div>
            </div>
            <div class="card-body bg-white">
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
                        Agar selanjutnya wajib mengisi Peserta pada Layanan ini.
                    </div>
                </div>
                <h5 class="card-title"><?= $result['nama_kegiatan'] ?></h5>
                <p class="card-text"><?= $result['tanggal_pelaksanaan'] ?></p>
                <p class="card-text"><?= $result['jenis_advokasi_nama'] ?></p>
                <p class="card-text"><?= $result['tahapan'] ?></p>
                <?php if(session('id') === $result['created_by'] || permission(['ADMINISTRATOR'])){ ?>
                <a href="/kegiatan/edit/<?= $result['id']; ?>" class="btn btn-info">Edit</a>
                <?php } ?>
                <a class="btn btn-info" href="<?= base_url("/kegiatan?jenis_advokasi_id=" . $result['jenis_advokasi_id']); ?>">Lihat Rekap</a>
                <?php if(session('id') === $result['created_by'] || permission(['ADMINISTRATOR'])){ ?>
                <a class="btn btn-info" href='<?= base_url("kegiatan/" . $result['id'] . "/" . $result['jenis_advokasi_id'] . "/pelayanan"); ?>'>Entry Peserta</a>
                <?php } ?>
                <a class="btn btn-info" href='<?= base_url("kegiatan/create/" . $result['jenis_advokasi_id']); ?>'>Entry <?= $result['jenis_advokasi_nama'] ?></a>
                <?php if(session('id') === $result['created_by'] || permission(['ADMINISTRATOR'])){ ?>
                <form action="/kegiatan/delete/<?= $result['id']; ?>" method="post" class="d-inline">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah anda yakin?');">Delete</button>
                </form>
                <?php } ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="d-flex align-items-center p-3 my-1 text-white-50 bg-info rounded shadow-sm">
            <!--<img class="mr-3" src="../assets/brand/bootstrap-outline.svg" alt="" width="48" height="48">-->
                <div class="lh-100">
                    <h6 class="mb-0 text-white lh-100">Dokumen</h6>
                </div>
            </div>

            <div class="my-3 p-3 bg-white rounded shadow-sm">
                <?php
                    $i = 1;

                    if($result_materi){
                        foreach($result_materi as $materi):
                        ?>
                        <div class="media text-muted pt-3">
                            <!--<svg class="bd-placeholder-img mr-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 32x32"><title>Placeholder</title><rect width="100%" height="100%" fill="#17a2b8 "/><text x="50%" y="50%" fill="#17a2b8 " dy=".3em">32x32</text></svg>-->
                            <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                                <strong class="d-block text-gray-dark">
                                    <?php if($materi['type'] == "application/pdf" 
                                        || $materi['type'] == "image/jpeg" 
                                        || $materi['type'] == "image/jpg" 
                                        || $materi['type'] == "image/png" 
                                        || $materi['type'] == "image/gif"){ 
                                    ?>
                                        <a href="#" 
                                            data-toggle="modal" 
                                            data-target="#previewFile" 
                                            data-nama-file="<?= $materi['nama_materi'] ?>" 
                                            data-label-file="<?= $materi['label_materi'] ?>"
                                            data-type-file="<?= $materi['type'] ?>"
                                        >
                                            <?= $materi['label_materi'] ?>
                                        </a>
                                    <?php } else { ?>
                                        <a href='<?= base_url("uploads/kegiatan/" . $materi['nama_materi']); ?>'>
                                            <?= $materi['label_materi']; ?>
                                        </a>
                                    <?php } ?>
                                </strong>
                                <span class="badge badge-pill bg-light align-text-bottom" ><?= calculate_file_size($materi['size']); ?></span>
                            </p>
                        </div>
                        
                        <?php endforeach;
                    }else{ ?>
                        <div class="media text-muted pt-3">
                            <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                                <strong class="d-block text-gray-dark">Data tidak ditemukan</strong>
                            </p>
                        </div>
                    <?php }
                ?>
                <?php if(session('id') === $result['created_by'] || permission(['ADMINISTRATOR'])){ ?>
                <small class="d-block text-right mt-3">
                    <a href="<?= base_url('kegiatan/' . $result['id'] . '/materi') ;?>">Entry</a>
                </small>
                <?php } ?>
            </div>
            <div class="d-flex align-items-center p-3 my-1 text-white-50 bg-info rounded shadow-sm">
            <!--<img class="mr-3" src="../assets/brand/bootstrap-outline.svg" alt="" width="48" height="48">-->
                <div class="lh-100">
                    <h6 class="mb-0 text-white lh-100">NARASUMBER</h6>
                </div>
            </div>

            <div class="my-3 p-3 bg-white rounded shadow-sm">
                <?php
                    $i = 1;

                if($result_narasumber){
                    foreach($result_narasumber as $narasumber):
                    ?>
                    <div class="media text-muted pt-3">
                        <!--<svg class="bd-placeholder-img mr-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 32x32"><title>Placeholder</title><rect width="100%" height="100%" fill="#17a2b8 "/><text x="50%" y="50%" fill="#17a2b8 " dy=".3em">32x32</text></svg>-->
                        <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                            <strong class="d-block text-gray-dark"><?= $narasumber['nama_narasumber']; ?></strong>
                        </p>
                    </div>
                    
                    <?php endforeach;
                    }else{ ?>
                        <div class="media text-muted pt-3">
                            <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                                <strong class="d-block text-gray-dark">Data tidak ditemukan</strong>
                            </p>
                        </div>
                    <?php }
                ?>
                <?php if(session('id') === $result['created_by'] || permission(['ADMINISTRATOR'])){ ?>
                <small class="d-block text-right mt-3">
                    <a href="<?= base_url('kegiatan/' . $result['id'] . '/narasumber') ;?>">Entry</a>
                </small>
                <?php } ?>
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

    $(document).ready(function(){
        $('.toast').toast('show');
    });
</script>

<?= $this->endSection(); ?>