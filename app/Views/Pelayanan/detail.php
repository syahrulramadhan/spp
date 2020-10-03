<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url('pelayanan/jenis-advokasi'); ?>">Advokasi</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url('pelayanan'); ?>">Pelayanan</a></li>
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
                <?php if(in_array($result['id'], array(1,2,6,7))){ ?>
                <h5 class="card-title">
                    <?= $result['nama'] ?>
                    <small><?= $result['nomor_telepon'] ?></small>
                </h5>
                <?php } ?>

                <?php if(in_array($result['id'], array(1))){ ?>
                <p class="card-text"><?= $result['nomot_surat_keluar'] ?></p>
                <?php } ?>

                <?php if(in_array($result['id'], array(3))){ ?>
                <p class="card-text"><?= $result['nomor_undangan'] ?></p>
                <?php } ?>

                <?php if(in_array($result['id'], array(1,2,6,7))){ ?>
                <p class="card-text"><?= $result['jabatan'] ?></p>
                <?php } ?>

                <?php if(in_array($result['id'], array(3))){ ?>
                <p class="card-text"><?= $result['aktifitas'] ?></p>
                <?php } ?>

                <p class="card-text"><?= $result['nama_klpd'] ?></p>
                <p class="card-text"><?= $result['nama_satker'] ?></p>
                <p class="card-text"><?= $result['paket_kode'] ?></p>
                <p class="card-text"><?= $result['paket_nama'] ?></p>
                <p class="card-text">Rp. <?= number_format($result['paket_nilai_pagu'], 2) ?></p>
                <p class="card-text"><?= $result['nama_jenis_pengadaan'] ?></p>
                <p class="card-text"><?= $result['paket_status'] ?></p>

                <?php if(in_array($result['id'], array(4))){ ?>
                    <p class="card-text"><?= $result['efisiensi'] ?></p>
                <?php } ?>

                <p class="card-text"><?= $result['jenis_advokasi_nama'] ?></p>
                <p class="card-text"><?= $result['nama_kategori_permasalahan'] ?></p>
                <p class="card-text"><?= $result['keterangan'] ?></p>

                <a href="/pelayanan/<?= $result['jenis_advokasi_id']; ?>/edit/<?= $result['id']; ?>" class="btn btn-info">Edit</a>
                
                <a class="btn btn-info" href="/pelayanan">Lihat Rekap</a>
            </div>
        </div>
        <div class="col-md-4">
            <?php if(in_array($result['jenis_advokasi_id'], array(1,3,5))){ ?>
                <div class="d-flex align-items-center p-3 my-1 text-white-50 bg-info rounded shadow-sm">
                <!--<img class="mr-3" src="../assets/brand/bootstrap-outline.svg" alt="" width="48" height="48">-->
                    <div class="lh-100">
                        <h6 class="mb-0 text-white lh-100">FILE</h6>
                    </div>
                </div>

                <div class="my-3 p-3 bg-white rounded shadow-sm">
                    <h6 class="border-bottom border-gray pb-2 mb-0">Recent updates</h6>

                    <?php
                        $i = 1;

                        if($result_file){
                            foreach($result_file as $file):
                            ?>
                            <a href="pelayanan/<?= $rows['id']; ?>" class="text-decoration-none">
                            <div class="media text-muted pt-3">
                                <!--<svg class="bd-placeholder-img mr-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 32x32"><title>Placeholder</title><rect width="100%" height="100%" fill="#17a2b8 "/><text x="50%" y="50%" fill="#17a2b8 " dy=".3em">32x32</text></svg>-->
                                <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                                    <strong class="d-block text-gray-dark"><a href='<?= base_url("public/uploads/pelayanan/" . $file['nama_file']); ?>'><?= $file['label_file']; ?></a></strong>
                                    <span class="badge badge-pill bg-light align-text-bottom" ><?= $rows['size']; ?></span>
                                </p>
                            </div>
                            </a>
                            
                            <?php endforeach;
                        }else{ ?>
                            <div class="media text-muted pt-3">
                                <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                                    <strong class="d-block text-gray-dark">Data tidak ditemukan</strong>
                                </p>
                            </div>
                        <?php }
                    ?>

                    <small class="d-block text-right mt-3">
                        <a href="<?= base_url('pelayanan/' . $result['id'] . '/file') ;?>">Entry</a>
                    </small>
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
                    <h6 class="border-bottom border-gray pb-2 mb-0">Recent updates</h6>

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

                    <small class="d-block text-right mt-3">
                        <a href="<?= base_url('pelayanan/' . $result['id'] . '/peserta') ;?>">Entry</a>
                    </small>
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
                    <h6 class="border-bottom border-gray pb-2 mb-0">Recent updates</h6>

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

                    <small class="d-block text-right mt-3">
                        <a href="<?= base_url('pelayanan/' . $result['id'] . '/pic') ;?>">Entry</a>
                    </small>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>