<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Data</li>
        <li class="breadcrumb-item active" aria-current="page"><?= $title ?></li>
    </ol>
</nav>

<div class="row mb-2">
    <div class="col-md-6">
        <div class="d-flex align-items-center p-3 my-1 text-white-50 bg-info rounded shadow-sm">
            <div class="lh-100">
                <h6 class="mb-0 text-white lh-100 text-uppercase">GRAFIK PELAYANAN <?= $title ?></h6>
            </div>
        </div>
        <?php if($result_grafik_layanan){ ?>
            <div id="donutchart_layanan" style="width: 100%; height: 500px;"></div>
        <?php }else{ ?>
            <div class="text-center my-2">Data tidak ditemukan</div>
        <?php } ?>
    </div>
    <div class="col-md-6">
        <div class="d-flex align-items-center p-3 my-1 text-white-50 bg-info rounded shadow-sm">
            <div class="lh-100">
                <h6 class="mb-0 text-white lh-100 text-uppercase">GRAFIK VALUASI <?= $title ?></h6>
            </div>
        </div>
        <?php if($result_grafik_valuasi){ ?>
            <div id="donutchart_valuasi" style="width: 100%; height: 500px;"></div>
        <?php }else{ ?>
            <div class="text-center my-2">Data tidak ditemukan</div>
        <?php } ?>
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
                <div class="row">
                    <div class="col-9">
                        <?php if(permission(['ADMINISTRATOR'])){ ?>
                        <div class="mb-2">
                            <a href="/kategori-permasalahan/create" class="btn btn-info">Tambah Data</a>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="col-3 pull-right">
                        <form id="form-submit" action="" method="GET">
                            <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Masukan kata nama" name="q" value="<?= $keyword ?>" autofocus>
                            <div class="input-group-append">
                                <button class="btn btn-outline-info" type="submit"><i class="fa fa-search"></i></button>
                            </div>
                            </div>
                        </form>
                    </div>
                </div>
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
                <table class="table table-bordered table-sm">
                    <thead>
                    <tr>
                        <th class="text-center col-small">NO</th>
                        <th>KATEGORI PERMASALAHAN</th>
                        <th style="width: 200px;" class="text-center col-small">JUMLAH LAYANAN</th>
                        <th style="width: 200px;" class="text-right col-small">VALUASI (Rp. JUTA)</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        if($result){
                            $i = 1 + ($per_page * ($currentPage - 1));

                            foreach($result as $rows):
                                ?>
                                <tr>
                                    <th scope="row" class="text-center"><?= $i++; ?></th>
                                    <td>
                                        <a href="kategori-permasalahan/<?= $rows['id']; ?>"><?= $rows['nama_kategori_permasalahan']; ?></a>
                                    </td>
                                    <td class="text-center">
                                        <?= ($rows['jumlah_pelayanan']) ? $rows['jumlah_pelayanan'] : 0; ?>
                                    </td>
                                    <td class="text-right"><?= "Rp. ". number_format($rows['jumlah_valuasi']/pow(10,6), 2); ?></td>
                                </tr>
                            <?php endforeach; 
                        }else{
                            echo '<tr class="text-center"><td colspan="4">Data tidak ditemukan</td></tr>';
                        }
                    ?>
                    </tbody>
                </table>
                <?= $pager->links('kategori_permasalahan', 'bootstrap_pagination'); ?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChartLayanan);
    google.charts.setOnLoadCallback(drawChartValuasi);

    function drawChartLayanan() {
        var data = google.visualization.arrayToDataTable(<?= $result_grafik_layanan; ?>);

        var options = {
            title: 'JUMLAH LAYANAN',
            pieHole: 0.4,
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart_layanan'));
        chart.draw(data, options);
    }

    function drawChartValuasi() {
        var data = google.visualization.arrayToDataTable(<?= $result_grafik_valuasi; ?>);

        var options = {
            title: 'JUMLAH VALUASI (Rp. JUTA)',
            pieHole: 0.4,
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart_valuasi'));
        chart.draw(data, options);
    }
</script>

<?= $this->endSection(); ?>