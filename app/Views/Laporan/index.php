<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Laporan</li>
        <li class="breadcrumb-item active" aria-current="page"><?= $title ?></li>
    </ol>
</nav>

<div class="d-flex align-items-center p-3 my-1 text-white-50 bg-info rounded shadow-sm">
    <div class="lh-100">
        <h6 class="mb-0 text-white lh-100 text-uppercase">LAPORAN <?= $title ?></h6>
    </div>
</div>

<div class="card mb-3">
    <div class="row">
        <div class="col-md-12">
            <div class="card-body">          
                <div class="row">
                    <div class="col-9">
                        <div class="mb-3">
                            <a href="<?= base_url("laporan/$jenis_laporan?format=xlsx") ?>" target="_blank" class="btn btn-info">Export Data Ke Excel</a>
                        </div>
                    </div>
                    <div class="col-3 pull-right">
                        <form id="form-submit" action="" method="GET">
                            <div class="input-group mb-3">
                            </div>
                        </form>
                    </div>
                </div>

                <?php if($jenis_laporan == "laporan-valuasi"){ ?>
                    <?= $this->include('Laporan/ekspor_tabel_valuasi'); ?>
                <?php }else{ ?>
                    <?= $this->include('Laporan/ekspor_tabel_layanan'); ?>
                <?php } ?>
                
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>