<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url('pelayanan/jenis-advokasi'); ?>">Layanan</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url('pelayanan'); ?>">Daftar Layanan</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= $result['nama_klpd'] ?></li>
    </ol>
</nav>

<div class="mb-3">
    <div class="row">
        <div class="col-md-8">
            <div class="d-flex align-items-center p-3 my-1 text-white-50 bg-info rounded shadow-sm">
                <div class="lh-100">
                    <h6 class="mb-0 text-white lh-100 text-uppercase"><?= $result['paket_nama'] ?></h6>
                </div>
            </div>
            <div class="card-body bg-white">
                <p class="card-text">
                    <?= $result['tanggal_pelaksanaan'] ?>
                </p>
            
                <?php if(in_array($result['id'], array(1,2,6,7))){ ?>
                <h5 class="card-title">
                    <?= $result['nama'] ?>
                    <small><?= $result['nomor_telepon'] ?></small>
                </h5>
                <?php } ?>

                <?php if(in_array($result['id'], array(1))){ ?>
                    <p class="card-text">
                        <strong>Nomor Surat Keluar</strong>
                        <br><?= $result['nomor_surat_keluar'] ?>
                    </p>
                <?php } ?>

                <?php if(in_array($result['id'], array(3))){ ?>
                <p class="card-text"><?= $result['nomor_undangan'] ?></p>
                <?php } ?>

                <?php if(in_array($result['id'], array(1,2,6,7))){ ?>
                <p class="card-text"><?= $result['jabatan'] ?></p>
                <?php } ?>

                <p class="card-text"><?= $result['nama_klpd'] ?></p>
                <p class="card-text"><?= $result['nama_satker'] ?></p>
                <p class="card-text"><?= $result['paket_kode'] ?></p>
                <p class="card-text"><?= $result['paket_nama'] ?></p>
                <p class="card-text">Rp. <?= number_format($result['paket_nilai_pagu'], 2) ?></p>
                <p class="card-text"><?= $result['nama_jenis_pengadaan'] ?></p>

                <p class="card-text"><?= $result['jenis_advokasi_nama'] ?></p>
                <p class="card-text"><?= $result['nama_kategori_permasalahan'] ?></p>
                <p class="card-text"><?= $result['keterangan'] ?></p>
                
                <?php if(session('id') === $result['created_by'] || permission(['ADMINISTRATOR'])){ ?>
                <?php if(in_array($result['jenis_advokasi_id'], array(1,2,3,4,5,6,7))){ ?>
                    <a href="<?= base_url("pelayanan/" . $result['jenis_advokasi_id'] . "/edit/" . $result['id']); ?>" class="btn btn-info">Edit</a>
                <?php } ?>
                <?php } ?>
                <a class="btn btn-info" href="<?= base_url("/pelayanan?jenis_advokasi_id=" . $result['jenis_advokasi_id']); ?>">Lihat Rekap</a>
                <?php if(in_array($result['jenis_advokasi_id'], array(1,2,3,4,5,6,7))){ ?>
                    <a class="btn btn-info" href="<?= base_url("/pelayanan/create/" . $result['jenis_advokasi_id']); ?>">Entry <?= $result['jenis_advokasi_nama'] ?></a>
                    <?php if(session('id') === $result['created_by'] || permission(['ADMINISTRATOR'])){ ?>
                        <form action="/pelayanan/delete/<?= $result['id']; ?>" method="post" class="d-inline">
                        <?= csrf_field(); ?>
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="jenis_advokasi_id" value="<?= $result['jenis_advokasi_id'] ?>">
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah anda yakin?');">Delete</button>
                    </form>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
        <div class="col-md-4">
            <?php /* if(in_array($result['jenis_advokasi_id'], array(1,3,5))){ */ ?>
            <?php if(in_array($result['jenis_advokasi_id'], array(1,2,3,4,5,6,7))){ ?>
                <div class="d-flex align-items-center p-3 my-1 text-white-50 bg-info rounded shadow-sm">
                <!--<img class="mr-3" src="../assets/brand/bootstrap-outline.svg" alt="" width="48" height="48">-->
                    <div class="lh-100">
                        <h6 class="mb-0 text-white lh-100">FILE</h6>
                    </div>
                </div>

                <div class="my-3 p-3 bg-white rounded shadow-sm">
                    <?php
                        $i = 1;

                        if($result_file){
                            foreach($result_file as $file):
                            ?>
                            <div class="media text-muted pt-3">
                                <!--<svg class="bd-placeholder-img mr-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 32x32"><title>Placeholder</title><rect width="100%" height="100%" fill="#17a2b8 "/><text x="50%" y="50%" fill="#17a2b8 " dy=".3em">32x32</text></svg>-->
                                <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                                    <strong class="d-block text-gray-dark">
                                        <?php if($file['type'] == "application/pdf" 
                                            || $file['type'] == "image/jpeg" 
                                            || $file['type'] == "image/jpg" 
                                            || $file['type'] == "image/png" 
                                            || $file['type'] == "image/gif"){ 
                                        ?>
                                            <a href="#" 
                                                data-toggle="modal" 
                                                data-target="#previewFile" 
                                                data-nama-file="<?= $file['nama_file'] ?>" 
                                                data-label-file="<?= $file['label_file'] ?>"
                                                data-type-file="<?= $file['type'] ?>"
                                            >
                                                <?= $file['label_file'] ?>
                                            </a>
                                        <?php } else { ?>
                                            <a href='<?= base_url("uploads/pelayanan/" . $file['nama_file']); ?>'>
                                                <?= $file['label_file']; ?>
                                            </a>
                                        <?php } ?>
                                    </strong>
                                    <span class="badge badge-pill bg-light align-text-bottom" ><?= calculate_file_size($file['size']); ?></span>
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
                        <a href="<?= base_url('pelayanan/' . $result['id'] . '/file') ;?>">Entry</a>
                    </small>
                    <?php } ?>
                </div>
            <?php } ?>
            <?php if(in_array($result['jenis_advokasi_id'], array(3,4,5))){ ?>
                <div class="d-flex align-items-center p-3 my-1 text-white-50 bg-info rounded shadow-sm">
                <!--<img class="mr-3" src="../assets/brand/bootstrap-outline.svg" alt="" width="48" height="48">-->
                    <div class="lh-100">
                        <h6 class="mb-0 text-white lh-100">PESERTA</h6>
                    </div>
                </div>

                <div class="my-3 p-3 bg-white rounded shadow-sm">
                    <?php
                        $i = 1;

                    if($result_peserta){
                        foreach($result_peserta as $peserta):
                        ?>
                        <div class="media text-muted pt-3">
                            <!--<svg class="bd-placeholder-img mr-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 32x32"><title>Placeholder</title><rect width="100%" height="100%" fill="#17a2b8 "/><text x="50%" y="50%" fill="#17a2b8 " dy=".3em">32x32</text></svg>-->
                            <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                                <strong class="d-block text-gray-dark"><?= $peserta['nama_peserta']; ?></strong>
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
                        <a href="<?= base_url('pelayanan/' . $result['id'] . '/peserta') ;?>">Entry</a>
                    </small>
                    <?php } ?>
                </div>
            <?php } ?>
            <?php if(in_array($result['jenis_advokasi_id'], array(1,2,3,4,5,6,7))){ ?>
                <div class="d-flex align-items-center p-3 my-1 text-white-50 bg-info rounded shadow-sm">
                <!--<img class="mr-3" src="../assets/brand/bootstrap-outline.svg" alt="" width="48" height="48">-->
                    <div class="lh-100">
                        <h6 class="mb-0 text-white lh-100">PIC</h6>
                    </div>
                </div>

                <div class="my-3 p-3 bg-white rounded shadow-sm">
                    <?php
                        $i = 1;

                        if($result_pic){
                            foreach($result_pic as $pic):
                            ?>
                            <div class="media text-muted pt-3">
                                <!--<svg class="bd-placeholder-img mr-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 32x32"><title>Placeholder</title><rect width="100%" height="100%" fill="#17a2b8 "/><text x="50%" y="50%" fill="#17a2b8 " dy=".3em">32x32</text></svg>-->
                                <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                                    <strong class="d-block text-gray-dark"><?= $pic['nama_depan'] . " " . $pic['nama_belakang']; ?></strong>
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
                        <a href="<?= base_url('pelayanan/' . $result['id'] . '/pic') ;?>">Entry</a>
                    </small>
                    <?php } ?>
                </div>
            <?php } ?>
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

<script type="text/javascript">
    $('#previewFile').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var namafile = button.data('nama-file');
        var labelfile = button.data('label-file'); 
        var typefile = button.data('type-file');

        var modal = $(this)
        var path = '<?= base_url("uploads/pelayanan"); ?>';

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