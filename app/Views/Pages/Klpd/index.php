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
        <div id="donutchart_layanan" style="width: 100%; height: 500px;"></div>
    </div>
    <div class="col-md-6">
        <div class="d-flex align-items-center p-3 my-1 text-white-50 bg-info rounded shadow-sm">
            <div class="lh-100">
                <h6 class="mb-0 text-white lh-100 text-uppercase">GRAFIK VALUASI <?= $title ?></h6>
            </div>
        </div>
        <div id="donutchart_valuasi" style="width: 100%; height: 500px;"></div>
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
                <?php if(session()->getFlashdata('pesan')): ?>
                    <div class="alert alert-success" role="alert">
                    <?= session()->getFlashdata('pesan') ?>
                    </div>
                <?php endif; ?>

                <table class="table table-sm">
                    <thead>
                    <tr>
                        <th class="text-center col-small">NO</th>
                        <th>NAMA</th>
                        <th style="width: 200px;" class="text-center col-small">JENIS K/L/Pemda</th>
                        <th style="width: 200px;" class="text-center col-small">JUMLAH LAYANAN</th>
                        <th style="width: 200px;" class="text-right col-small">VALUASI (Rp. JUTA)</th>
                        <th style="width: 100px;" class="text-center col-small">KUALITAS</th>
                        <th class="text-center col-small">GRAFIK</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $i = 1;

                        foreach($result as $rows):
                    ?>
                    <tr>
                        <th scope="row" class="text-center"><?= $i++; ?></th>
                        <td><?= $rows['nama_klpd']; ?></td>
                        <td class="text-center"><?= $rows['jenis_klpd']; ?></td>
                        <td class="text-center">
                            <?= ($rows['jumlah_pelayanan']) ? $rows['jumlah_pelayanan'] : 0; ?>
                        </td>
                        <td class="text-right"><?= "Rp. ". number_format($rows['jumlah_valuasi']/pow(10,6), 2); ?></td>
                        <td class="text-center">
                            <?php 
                                $badge = "danger"; $skor = 0;

                                if($rows['jumlah_kualitas']){
                                    if(($rows['jumlah_kualitas'] >= 6) && ($rows['jumlah_kualitas'] <= 9)){
                                        $badge = "success"; $skor = 100;
                                    }elseif ($rows['jumlah_kualitas'] >= 4 && $rows['jumlah_kualitas'] <= 5){
                                        $badge = "primary"; $skor = 75;
                                    }elseif ($rows['jumlah_kualitas'] >= 2 && $rows['jumlah_kualitas'] <= 3){
                                        $badge = "warning"; $skor = 50;
                                    }elseif ($rows['jumlah_kualitas'] == 1){
                                        $badge = "secondary"; $skor = 25;
                                    }else{
                                        $badge = "danger"; $skor = 0;
                                    }
                                }
                            ?>
                            
                            <span class="badge badge-pill badge-<?=$badge; ?>">
                                <small>
                                    <?= $skor; ?>
                                </small>
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="/pages/klpd/<?= $rows['id']; ?>" class="text-decoration-none">Lihat</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
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
            title: 'JUMLAH VALUASI',
            pieHole: 0.4,
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart_valuasi'));
        chart.draw(data, options);
    }
</script>

<?= $this->endSection(); ?>