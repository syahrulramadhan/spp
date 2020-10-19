<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Data</li>
        <li class="breadcrumb-item"><a href="<?= base_url('pages/klpd'); ?>">K/L/Pemda</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= $result['nama_klpd'] ?></li>
    </ol>
</nav>

<div class="card mb-1">
    <div class="row">
        <div class="col-md-12">
            <div class="card-body">
                <div>
                    <h5 class="card-title"><?= $result['nama_klpd']; ?></h5>
                    <p class="card-text"><?= $result['jenis_klpd'] ?></p>
                    <a href="/pages/klpd" class="btn btn-info">Lihat Rekap</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="row">
        <div class="col-md-8">
            <div class="card-body">
                <div class="d-flex align-items-center p-3 my-1 text-white-50 bg-info rounded shadow-sm">
                    <div class="lh-100">
                        <h6 class="mb-0 text-white lh-100">Grafik Layanan <?= $result['nama_klpd'] ?></h6>
                    </div>
                </div>
                <div class="mb-3 p-3 bg-white rounded shadow-sm">
                    <form id="form-submit" action="<?= base_url('pages/klpd/' . $result['id']) ?>" method="get" class="mt-2 form-inline">
                        <?= csrf_field(); ?>
                        <div class="form-group">
                            <label for="klpd" class="col-form-label">Tahun </label>
                            <div class="col">
                                <?= form_dropdown('tahun_layanan', $options_tahun_layanan, $tahun, ['class' => 'custom-select ', 'id' => 'tahun_layanan']); ?>
                            </div>
                        </div> 
                        <button type="submit" class="btn btn-info" id="cari_chart_layanan">Cari</button>
                    </form>
                    <div id="curve_chart_pelayanan" style="width: 100%; height: 400px">
                        <div class="my-2">Data tidak ditemukan</div>    
                    </div>
                </div>
                <div class="d-flex align-items-center p-3 my-1 text-white-50 bg-info rounded shadow-sm">
                    <div class="lh-100">
                        <h6 class="mb-0 text-white lh-100">Grafik Valuasi <?= $result['nama_klpd'] ?></h6>
                    </div>
                </div>
                <div class="mb-3 p-3 bg-white rounded shadow-sm">
                    <form id="form-submit" action="<?= base_url('pages/klpd/' . $result['id']) ?>" method="get" class="mt-2 form-inline">
                        <?= csrf_field(); ?>
                        <div class="form-group">
                            <label for="klpd" class="col-form-label">Tahun </label>
                            <div class="col">
                                <?= form_dropdown('tahun_valuasi', $options_tahun_layanan, $tahun, ['class' => 'custom-select ', 'id' => 'tahun_valuasi']); ?>
                            </div>
                        </div> 
                        <button type="submit" class="btn btn-info" id="cari_chart_valuasi">Cari</button>
                    </form>
                    <div id="curve_chart_valuasi" style="width: 100%; height: 400px">
                        <div class="my-2">Data tidak ditemukan</div>
                    </div>
                </div>
                <div class="d-flex align-items-center p-3 my-1 text-white-50 bg-info rounded shadow-sm">
                    <div class="lh-100">
                        <h6 class="mb-0 text-white lh-100">Grafik Kualitas <?= $result['nama_klpd'] ?></h6>
                    </div>
                </div>
                <div class="mb-3 p-3 bg-white rounded shadow-sm">
                    <form id="form-submit" action="<?= base_url('pages/klpd/' . $result['id']) ?>" method="get" class="mt-2 form-inline">
                        <?= csrf_field(); ?>
                        <div class="form-group">
                            <label for="klpd" class="col-form-label">Tahun </label>
                            <div class="col">
                                <?= form_dropdown('tahun_kualitas', $options_tahun_layanan, $tahun, ['class' => 'custom-select ', 'id' => 'tahun_kualitas']); ?>
                            </div>
                        </div> 
                        <button type="submit" class="btn btn-info" id="cari_chart_kualitas">Cari</button>
                    </form>
                    <div id="curve_chart_kualitas" style="width: 100%; height: 400px">
                        <div class="my-2">Data tidak ditemukan</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="d-flex align-items-center p-3 my-1 text-white-50 bg-info rounded shadow-sm">
            <!--<img class="mr-3" src="../assets/brand/bootstrap-outline.svg" alt="" width="48" height="48">-->
                <div class="lh-100">
                    <h6 class="mb-0 text-white lh-100">History Layanan</h6>
                </div>
            </div>

            <div class="my-3 p-3 bg-white rounded shadow-sm">
            <?php
                $i = 1;

                foreach($result_jenis_advokasi as $rows):
            ?>
            
            <div class="media text-muted pt-3">
                <!--<svg class="bd-placeholder-img mr-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 32x32"><title>Placeholder</title><rect width="100%" height="100%" fill="#17a2b8 "/><text x="50%" y="50%" fill="#17a2b8 " dy=".3em">32x32</text></svg>-->
                <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                    <strong class="d-block text-gray-dark"><?= $rows['jenis_advokasi_nama']; ?><span class="badge badge-pill bg-light align-text-bottom" ><?= $rows['jumlah_layanan']; ?></span></strong>
                </p>
            </div>

            <?php endforeach; ?>

            <!--
            <small class="d-block text-right mt-3">
                <a href="#">All updates</a>
            </small>
            -->
            </div>
            <div class="d-flex align-items-center p-3 my-1 text-white-50 bg-info rounded shadow-sm">
            <!--<img class="mr-3" src="../assets/brand/bootstrap-outline.svg" alt="" width="48" height="48">-->
                <div class="lh-100">
                    <h6 class="mb-0 text-white lh-100">History Kegiatan</h6>
                </div>
            </div>

            <div class="my-3 p-3 bg-white rounded shadow-sm">
            <?php
                $i = 1;

                foreach($result_kegiatan as $rows):
            ?>
            
            <div class="media text-muted pt-3">
                <!--<svg class="bd-placeholder-img mr-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 32x32"><title>Placeholder</title><rect width="100%" height="100%" fill="#17a2b8 "/><text x="50%" y="50%" fill="#17a2b8 " dy=".3em">32x32</text></svg>-->
                <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                    <strong class="d-block text-gray-dark"><?= $rows['nama_kegiatan']; ?></strong>
                </p>
            </div>

            <?php endforeach; ?>

            <!--
            <small class="d-block text-right mt-3">
                <a href="#">All updates</a>
            </small>
            -->
            </div>
        </div>
    </div>
</div>

<?php if(session()->getFlashdata('pesan')): ?>
    <div class="alert alert-success" role="alert">
    <?= session()->getFlashdata('pesan') ?>
    </div>
<?php endif; ?>

<div class="d-flex align-items-center p-3 my-1 text-white-50 bg-info rounded shadow-sm">
    <div class="lh-100">
        <h6 class="mb-0 text-white lh-100 text-uppercase">TABEL SATUAN KERJA</h6>
    </div>
</div>

<div class="card mb-3">
    <div class="row">
        <div class="col-md-12">
            <div class="card-body">
                <form id="form-submit" action="" method="GET">
                    <div class="row">
                        <div class="col-9">Tampilkan <?= form_dropdown('per_page', $options_per_page, $per_page, ['class' => 'custom-select ', 'id' => 'per_page', 'class' => "custom-select col-sm-3 mr-2"]); ?></div>
                        <div class="col-3 pull-right">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Masukan kata nama" name="q" value="<?= $keyword ?>" autofocus>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-info" type="submit"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <table class="table table-bordered table-sm">
                    <thead>
                    <tr>
                        <th style="width: 80px;" class="text-center">NO</th>
                        <th>NAMA SATUAN KERJA</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        if($result_satuan_kerja){
                            $i = 1 + ($per_page * ($currentPage - 1));

                            foreach($result_satuan_kerja as $rows): ?>
                                <tr>
                                    <th scope="row" class="text-center"><?= $i++; ?></th>
                                    <td>
                                        <?php /* <a href="/pages/klpd/<?= $result['id']; ?>/satuan-kerja/<?= $rows['id']; ?>"> */ ?>
                                            <?= $rows['nama_satker']; ?>
                                        <?php /* </a> */ ?>
                                    </td>
                                </tr>
                            <?php endforeach; 
                        }else{
                            echo '<tr class="text-center"><td colspan="2">Data tidak ditemukan</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
                <?= $pager->links('satuan_kerja', 'bootstrap_pagination'); ?>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $('#tahun').change(function(){ submit_disable(); });

    $('#tahun').select2

    google.charts.load('current', {'packages':['bar']});
    google.charts.setOnLoadCallback(drawChartLayanan);
    google.charts.setOnLoadCallback(drawChartValuasi);
    google.charts.setOnLoadCallback(drawChartKualitas);

    $(document).ready(function(){
        $('#cari_chart_layanan').click(function(e){  
            e.preventDefault();
            google.charts.setOnLoadCallback(drawChartLayanan);
        });

        $('#cari_chart_valuasi').click(function(e){  
            e.preventDefault();
            google.charts.setOnLoadCallback(drawChartValuasi);
        });

        $('#cari_chart_kualitas').click(function(e){  
            e.preventDefault();
            google.charts.setOnLoadCallback(drawChartKualitas);
        });
    });

    function drawChartLayanan() {
        var ajax = $.ajax({
            url: '<?= base_url("pages/chartKlpd/chart_layanan"); ?>',
            data: { id: '<?= $id ?>', tahun: $("#tahun_layanan").val() },
            dataType: "json", // type of data we're expecting from server
            async: false // make true to avoid waiting for the request to be complete
        });

        var result = JSON.parse(ajax.responseText);
        if(result.status){

            //console.log(result.data);

            var data = google.visualization.arrayToDataTable(result.data);

            var options = {
                chart: {
                    title: 'Grafik Layanan <?= $result['nama_klpd'] ?>',
                    subtitle: '<?= date('d-m-Y  h:i:s'); ?>'
                },
                colors: ['#FFAF2E','#FF7A20'],
                legend: { position: 'top' },
                vAxis: {
                    title: 'Jumlah Layanan'
                },
                hAxis: {
                    title: 'Bulan',
                }
            }

            var chart = new google.charts.Bar(document.getElementById('curve_chart_pelayanan'));

            chart.draw(data, google.charts.Bar.convertOptions(options));
        }else{
            $('#curve_chart_pelayanan').html('<div class="my-2">Data tidak ditemukan</div>')
        }
    }

    function drawChartValuasi(){
        var ajax = $.ajax({
            url: '<?= base_url("pages/chartKlpd/chart_valuasi"); ?>',
            data: { id: '<?= $id ?>', tahun: $("#tahun_layanan").val() },
            dataType: "json", // type of data we're expecting from server
            async: false // make true to avoid waiting for the request to be complete
        });

        var result = JSON.parse(ajax.responseText);
        if(result.status){

            //console.log(result.data);

            var data = google.visualization.arrayToDataTable(result.data);

            var options = {
                chart: {
                    title: 'Grafik Valuasi <?= $result['nama_klpd'] ?> (Rp. JUTA)',
                    subtitle: '<?= date('d-m-Y  h:i:s'); ?>'
                },
                colors: ['#FA68F8','#FA00B5'],
                legend: { position: 'top' },
                vAxis: {
                    title: 'Valuasi',
                    format: '#,###'
                },
                hAxis: {
                    title: 'Bulan',
                }
            }

            var chart = new google.charts.Bar(document.getElementById('curve_chart_valuasi'));

            chart.draw(data, google.charts.Bar.convertOptions(options));
        }else{
            $('#curve_chart_valuasi').html('<div class="my-2">Data tidak ditemukan</div>')
        }
    }

    function drawChartKualitas(){
        var ajax = $.ajax({
            url: '<?= base_url("pages/chartKlpd/chart_kualitas"); ?>',
            data: { id: '<?= $id ?>', tahun: $("#tahun_layanan").val() },
            dataType: "json", // type of data we're expecting from server
            async: false // make true to avoid waiting for the request to be complete
        });

        var result = JSON.parse(ajax.responseText);
        if(result.status){

            //console.log(result.data);

            var data = google.visualization.arrayToDataTable(result.data);

            var options = {
                chart: {
                    title: 'Grafik Kualitas <?= $result['nama_klpd'] ?>',
                    subtitle: '<?= date('d-m-Y  h:i:s'); ?>'
                },
                colors: ['#FA0065'],
                legend: { position: 'top' },
                vAxis: {
                    title: 'Nilai Kualitas'
                },
                hAxis: {
                    title: 'Bulan'
                }
            }

            var chart = new google.charts.Bar(document.getElementById('curve_chart_kualitas'));

            chart.draw(data, google.charts.Bar.convertOptions(options));
        }else{
            $('#curve_chart_kualitas').html('<div class="my-2">Data tidak ditemukan</div>')
        }
    }
</script>

<?= $this->endSection(); ?>