<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

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
                <h5 class="card-title"><?= $result['nama_kegiatan'] ?></h5>
                <p class="card-text"><?= $result['tanggal_pelaksanaan'] ?></p>
                <p class="card-text"><?= $result['jenis_advokasi_nama'] ?></p>
                <p class="card-text"><?= $result['tahapan'] ?></p>
                <a href="/kegiatan/edit/<?= $result['id']; ?>" class="btn btn-info">Edit</a>

                <form action="/kegiatan/delete/<?= $result['id']; ?>" method="post" class="d-inline">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-info" onclick="return confirm('Apakah anda yakin?');">Delete</button>
                </form>
                <a class="btn btn-info" href='<?= base_url("kegiatan/" . $result['id'] . "/" . $result['jenis_advokasi_id'] . "/pelayanan"); ?>'>Pelayanan</a>

                <a class="btn btn-info" href="/kegiatan">Lihat Rekap</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="d-flex align-items-center p-3 my-1 text-white-50 bg-info rounded shadow-sm">
            <!--<img class="mr-3" src="../assets/brand/bootstrap-outline.svg" alt="" width="48" height="48">-->
                <div class="lh-100">
                    <h6 class="mb-0 text-white lh-100">MATERI</h6>
                </div>
            </div>

            <div class="my-3 p-3 bg-white rounded shadow-sm">
                <h6 class="border-bottom border-gray pb-2 mb-0">Recent updates</h6>

                <?php
                    $i = 1;

                    if($result_materi){
                        foreach($result_materi as $materi):
                        ?>
                        <a href="pelayanan/<?= $rows['id']; ?>" class="text-decoration-none">
                        <div class="media text-muted pt-3">
                            <!--<svg class="bd-placeholder-img mr-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 32x32"><title>Placeholder</title><rect width="100%" height="100%" fill="#17a2b8 "/><text x="50%" y="50%" fill="#17a2b8 " dy=".3em">32x32</text></svg>-->
                            <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                                <strong class="d-block text-gray-dark"><a href='<?= base_url("public/uploads/kegiatan/" . $materi['nama_materi']); ?>'><?= $materi['label_materi']; ?></a></strong>
                                <?= $rows['type']; ?>
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
                    <a href="<?= base_url('kegiatan/' . $result['id'] . '/materi') ;?>">Entry</a>
                </small>
            </div>
            <div class="d-flex align-items-center p-3 my-1 text-white-50 bg-info rounded shadow-sm">
            <!--<img class="mr-3" src="../assets/brand/bootstrap-outline.svg" alt="" width="48" height="48">-->
                <div class="lh-100">
                    <h6 class="mb-0 text-white lh-100">NARASUMBER</h6>
                </div>
            </div>

            <div class="my-3 p-3 bg-white rounded shadow-sm">
                <h6 class="border-bottom border-gray pb-2 mb-0">Recent updates</h6>

                <?php
                    $i = 1;

                if($result_narasumber){
                    foreach($result_narasumber as $narasumber):
                    ?>
                    <div class="media text-muted pt-3">
                        <!--<svg class="bd-placeholder-img mr-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 32x32"><title>Placeholder</title><rect width="100%" height="100%" fill="#17a2b8 "/><text x="50%" y="50%" fill="#17a2b8 " dy=".3em">32x32</text></svg>-->
                        <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                            <strong class="d-block text-gray-dark"><?= $narasumber['nama_narasumber']; ?></strong>
                            <?= $rows['type']; ?>
                            <span class="badge badge-pill bg-light align-text-bottom" ><?= $rows['size']; ?></span>
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
                    <a href="<?= base_url('kegiatan/' . $result['id'] . '/narasumber') ;?>">Entry</a>
                </small>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>