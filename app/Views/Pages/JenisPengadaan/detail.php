<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Data</li>
        <li class="breadcrumb-item"><a href="<?= base_url('pages/jenis-pengadaan'); ?>">Jenis Barang/Jasa</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= $result['nama_jenis_pengadaan']; ?></li>
    </ol>
</nav>

<div class="d-flex align-items-center p-3 my-1 text-white-50 bg-info rounded shadow-sm">
    <div class="lh-100">
        <h6 class="mb-0 text-white lh-100 text-uppercase"><?= $result['nama_jenis_pengadaan'] ?></h6>
    </div>
</div>

<div class="card mb-3">
    <div class="row">
        <div class="col-md-8">
            <div class="card-body">
                <h5 class="card-title"><?= $result['nama_jenis_pengadaan']; ?></h5>
                <p class="card-text"><?= $result['keterangan']; ?></p>
                <a href="/pages/jenis-pengadaan" class="btn btn-info">Lihat Rekap</a>
            </div>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="row">
        <div class="col-md-12">
            <div class="card-body">
                <div class="d-flex align-items-center p-3 my-1 text-white-50 bg-info rounded shadow-sm">
                    <div class="lh-100">
                        <h6 class="mb-0 text-white lh-100">Grafik Layanan <?= $result['nama_jenis_pengadaan'] ?></h6>
                    </div>
                </div>
                <div class="mb-3 p-3 bg-white rounded shadow-sm">
                    <form id="form-submit" action="<?= base_url('jenis-advokasi/' . $result['id']) ?>" method="get" class="mt-2 form-inline">
                        <?= csrf_field(); ?>
                        <div class="form-group">
                            <label for="klpd" class="col-form-label">Jenis K/L/Pemda </label>
                            <div class="col">
                                <?= form_dropdown('jenis_klpd_layanan', $options_jenis_klpd, $jenis_klpd, ['class' => 'custom-select ', 'id' => 'jenis_klpd_layanan']); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="klpd" class="col-form-label">Tahun </label>
                            <div class="col">
                                <?= form_dropdown('tahun_layanan', $options_tahun_layanan, $tahun, ['class' => 'custom-select ', 'id' => 'tahun_layanan']); ?>
                            </div>
                        </div> 
                        <button type="submit" class="btn btn-info" id="cari_chart_layanan">Cari</button>
                    </form>
                    <div id="curve_chart_pelayanan" style="width: 100%; height: 400px;">
                        <div class="my-2">Data tidak ditemukan</div>
                    </div>
                </div>
                <div class="d-flex align-items-center p-3 my-1 text-white-50 bg-info rounded shadow-sm">
                    <div class="lh-100">
                        <h6 class="mb-0 text-white lh-100">Grafik Valuasi <?= $result['nama_jenis_pengadaan'] ?></h6>
                    </div>
                </div>
                <div class="mb-3 p-3 bg-white rounded shadow-sm">
                    <form id="form-submit" action="<?= base_url('jenis-advokasi/' . $result['id']) ?>" method="get" class="mt-2 form-inline">
                        <?= csrf_field(); ?>
                        <div class="form-group">
                            <label for="klpd" class="col-form-label">Jenis K/L/Pemda </label>
                            <div class="col">
                                <?= form_dropdown('jenis_klpd_valuasi', $options_jenis_klpd, $jenis_klpd, ['class' => 'custom-select ', 'id' => 'jenis_klpd_valuasi']); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="klpd" class="col-form-label">Tahun </label>
                            <div class="col">
                                <?= form_dropdown('tahun_valuasi', $options_tahun_layanan, $tahun, ['class' => 'custom-select ', 'id' => 'tahun_valuasi']); ?>
                            </div>
                        </div> 
                        <button type="submit" class="btn btn-info" id="cari_chart_valuasi">Cari</button>
                    </form>
                    <div id="curve_chart_valuasi" style="width: 100%; height: 400px;">
                        <div class="my-2">Data tidak ditemukan</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#jenis_klpd').change(function(){ submit_disable(); });
    $('#tahun').change(function(){ submit_disable(); });
    
    $('#jenis_klpd').select2();
    $('#tahun').select2();

    google.charts.load('current', {'packages':['bar']});
    google.charts.setOnLoadCallback(drawChartLayanan);
    google.charts.setOnLoadCallback(drawChartValuasi);

    $(document).ready(function(){
        $('#cari_chart_layanan').click(function(e){  
            e.preventDefault();
            google.charts.setOnLoadCallback(drawChartLayanan);
        });

        $('#cari_chart_valuasi').click(function(e){  
            e.preventDefault();
            google.charts.setOnLoadCallback(drawChartValuasi);
        });
    });

    function drawChartLayanan() {
        var ajax = $.ajax({
            url: '<?= base_url("pages/chartJenisPengadaan/chart_layanan"); ?>',
            data: { id: <?= $id ?>, jenis_klpd: $("#jenis_klpd_layanan").val(), tahun: $("#tahun_layanan").val() },
            dataType: "json", // type of data we're expecting from server
            async: false // make true to avoid waiting for the request to be complete
        });

        var result = JSON.parse(ajax.responseText);
        if(result.status){

            //console.log(result.data);
            var data = google.visualization.arrayToDataTable(result.data);

            var options = {
                chart: {
                    title: 'Grafik Layanan <?= $result['nama_jenis_pengadaan'] ?>',
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
            url: '<?= base_url("pages/chartJenisPengadaan/chart_valuasi"); ?>',
            data: { id: <?= $id ?>, jenis_klpd: $("#jenis_klpd_valuasi").val(), tahun: $("#tahun_valuasi").val() },
            dataType: "json", // type of data we're expecting from server
            async: false // make true to avoid waiting for the request to be complete
        });

        var result = JSON.parse(ajax.responseText);
        if(result.status){

            //console.log(result.data);
                
            var data = google.visualization.arrayToDataTable(result.data);

            var options = {
                chart: {
                    title: 'Grafik Valuasi <?= $result['nama_jenis_pengadaan'] ?> (Rp. JUTA)',
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
</script>

<?= $this->endSection(); ?>