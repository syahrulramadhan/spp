<?php $this->extend('layout/template'); ?>

<?php $this->section('content'); ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<div class="row">
    <div class="col-md-8">
        <div class="d-flex align-items-center p-3 my-1 text-white-50 bg-info rounded shadow-sm">
            <div class="lh-100">
                <h6 class="mb-0 text-white lh-100">DASHBOARD</h6>
            </div>
        </div>
        <form id="form-submit" action="<?= base_url('pages') ?>" method="get" class="mt-2 form-inline">
            <?= csrf_field(); ?>

            <div class="form-group">
                <label for="klpd" class="col-form-label">Jenis K/L/Pemda </label>
                <div class="col">
                    <?= form_dropdown('jenis_klpd', $options_jenis_klpd, $jenis_klpd, ['class' => 'custom-select ', 'id' => 'jenis_klpd']); ?>
                </div>
            </div>
            <div class="form-group">
                <label for="klpd" class="col-form-label">Tahun </label>
                <div class="col">
                    <?= form_dropdown('tahun', $options_tahun_layanan, $tahun, ['class' => 'custom-select ', 'id' => 'tahun']); ?>
                </div>
            </div> 

            <button type="submit" class="btn btn-info">Cari</button>

        </form>
        <div class="d-flex align-items-center p-3 my-1 text-white-50 bg-info rounded shadow-sm">
            <div class="lh-100">
                <h6 class="mb-0 text-white lh-100">Grafik Layanan</h6>
            </div>
        </div>
        <div class="mb-3 p-3 bg-white rounded shadow-sm">
            <div id="curve_chart_pelayanan" style="width: 100%; height: 400px">
                <div class="text-center my-2">Data tidak ditemukan</div>
            </div>
        </div>
        <div class="d-flex align-items-center p-3 my-1 text-white-50 bg-info rounded shadow-sm">
            <div class="lh-100">
                <h6 class="mb-0 text-white lh-100">Grafik Valuasi</h6>
            </div>
        </div>
        <div class="mb-3 p-3 bg-white rounded shadow-sm">
            <div id="curve_chart_valuasi" style="width: 100%; height: 400px">
                <div class="text-center my-2">Data tidak ditemukan</div>
            </div>
        </div>
        <div class="d-flex align-items-center p-3 my-1 text-white-50 bg-info rounded shadow-sm">
            <div class="lh-100">
                <h6 class="mb-0 text-white lh-100">Grafik Coverage</h6>
            </div>
        </div>
        <div class="mb-3 p-3 bg-white rounded shadow-sm">
            <div id="curve_chart_coverage" style="width: 100%; height: 400px">
                <div class="text-center my-2">Data tidak ditemukan</div>
            </div>
        </div>
        <div class="d-flex align-items-center p-3 my-1 text-white-50 bg-info rounded shadow-sm">
            <div class="lh-100">
                <h6 class="mb-0 text-white lh-100">Grafik Kualitas</h6>
            </div>
        </div>
        <div class="mb-3 p-3 bg-white rounded shadow-sm">
            <div id="curve_chart_kualitas" style="width: 100%; height: 400px">
                <div class="text-center my-2">Data tidak ditemukan</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="p-3 my-1 text-center bg-white rounded">
            <div class="pb-2">
                <img src="<?= base_url('uploads/lkpp.png') ?>" class="img-fluid" alt="Lembaga Kebijakan Pengadaan Barang/Jasa Pemerintah">
            </div>
            <div class="pb-2">
                <img src="<?= base_url('uploads/Logo D4-08.png') ?>" class="img-fluid" alt="Deputy Chairman D4">
            </div>
        </div>
        <div class="d-flex align-items-center p-3 my-1 text-white-50 bg-info rounded shadow-sm">
            <div class="lh-100">
                <h6 class="mb-0 text-white lh-100">Recent updates Layanan</h6>
            </div>
        </div>

        <div class="p-3 bg-white rounded shadow-sm">
            <!--<h6 class="border-bottom border-gray pb-2 mb-0">Recent updates</h6>-->
            <div id="daftarPelayanan"><div class="text-center my-2">Data tidak ditemukan</div></div>
            <small class="d-block text-right mt-3">
                <a href="<?= base_url('pelayanan') ?>" class="text-decoration-none">Selengkapnya</a>
            </small>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#jenis_klpd').change(function(){ submit_disable(); });
    $('#tahun').change(function(){ submit_disable(); });

    $('#jenis_klpd').select2();
    $('#tahun').select2();
    
    $(document).ready(function(){
        $.ajax({  
            url:"<?= base_url("pelayanan/list-ajax"); ?>",  
            method:"POST",
            success:function(response)  
            { 
                var data = JSON.parse(response);

                console.log(data);
                
                $("#daftarPelayanan").html("");

                $.each(data, function(i, item) {
                    $("#daftarPelayanan").append('<a href="pelayanan/' + data[i].id + '" class="text-decoration-none">' + 
                        '<div class="media text-muted pt-2">' +
                            '<svg class="bd-placeholder-img mr-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 32x32"><title>Placeholder</title><rect width="100%" height="100%" fill="#17a2b8 "/><text x="50%" y="50%" fill="#17a2b8 " dy=".3em">32x32</text></svg>' +
                            '<p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">' +
                                '<strong class="d-block text-gray-dark">' + data[i].nama_klpd + '</strong>' + 
                                data[i].paket_nama +
                                '<span class="badge badge-pill bg-light align-text-bottom" >' + data[i].jenis_advokasi_nama + '</span>' +
                            '</p>'+
                        '</div>' +
                    '</a>');
                });
            }  
        });  
    });

    google.charts.load('current', {'packages':['bar']});
    google.charts.setOnLoadCallback(drawChartLayanan);
    google.charts.setOnLoadCallback(drawChartValuasi);
    google.charts.setOnLoadCallback(drawChartCoverage);
    google.charts.setOnLoadCallback(drawChartKualitas);
    
    function drawChartLayanan() {
        var ajax = $.ajax({
            url: '<?= base_url("pages/chart/chart_layanan?jenis_klpd=$jenis_klpd&tahun=$tahun"); ?>',
            //data: {jenis_klpd: '<?= $jenis_klpd; ?>', tahun: <?= $tahun; ?>},
            dataType: "json", // type of data we're expecting from server
            async: false // make true to avoid waiting for the request to be complete
        });

        result = JSON.parse(ajax.responseText);

        var data = google.visualization.arrayToDataTable(result);

        <?php /* var data = google.visualization.arrayToDataTable(<?= $result_chart_pelayanan; ?>); */ ?>

        var options = {
            chart: {
                title: 'Grafik Layanan',
                subtitle: '<?= date('d-m-Y  h:i:s'); ?>'
            },
            //colors: ['#8bd1dc','#17a2b8'],
            colors: ['#FFAF2E','#FF7A20'],
            legend: { position: 'none' },
            vAxis: {
                title: 'Layanan'
            },
            hAxis: {
                title: 'Bulan',
            }
        }

        var chart = new google.charts.Bar(document.getElementById('curve_chart_pelayanan'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
    }

    function drawChartValuasi(){
        var ajax = $.ajax({
            url: '<?= base_url("pages/chart/chart_valuasi?jenis_klpd=$jenis_klpd&tahun=$tahun"); ?>',
            dataType: "json", // type of data we're expecting from server
            async: false // make true to avoid waiting for the request to be complete
        });

        result = JSON.parse(ajax.responseText);

        var data = google.visualization.arrayToDataTable(result);

        <?php /* var data = google.visualization.arrayToDataTable(<?= $result_chart_valuasi; ?>); */ ?>

        var options = {
            chart: {
                title: 'Grafik Valuasi (Rp. JUTA)',
                subtitle: '<?= date('d-m-Y  h:i:s'); ?>'
            },
            colors: ['#FA68F8','#FA00B5'],
            legend: { position: 'none' },
            vAxis: {
                title: 'Valuasi'
            },
            hAxis: {
                title: 'Bulan',
            }
        }

        var chart = new google.charts.Bar(document.getElementById('curve_chart_valuasi'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
    }

    function drawChartCoverage(){
        var ajax = $.ajax({
            url: '<?= base_url("pages/chart/chart_coverage?jenis_klpd=$jenis_klpd&tahun=$tahun"); ?>',
            dataType: "json", // type of data we're expecting from server
            async: false // make true to avoid waiting for the request to be complete
        });

        result = JSON.parse(ajax.responseText);

        var data = google.visualization.arrayToDataTable(result);

        <?php /* var data = google.visualization.arrayToDataTable(<?= $result_chart_coverage; ?>); */ ?>

        var options = {
            chart: {
                title: 'Grafik Coverage',
                subtitle: '<?= date('d-m-Y  h:i:s'); ?>'
            },
            colors: ['#DBFF0D','#9AE600'],
            legend: { position: 'none' },
            vAxis: {
                title: 'Coverage'
                //,format: 'percent'
            },
            hAxis: {
                title: 'Bulan'
            }
        }

        var chart = new google.charts.Bar(document.getElementById('curve_chart_coverage'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
    }

    function drawChartKualitas(){
        var ajax = $.ajax({
            url: '<?= base_url("pages/chart/chart_kualitas?jenis_klpd=$jenis_klpd&tahun=$tahun"); ?>',
            dataType: "json", // type of data we're expecting from server
            async: false // make true to avoid waiting for the request to be complete
        });

        result = JSON.parse(ajax.responseText);

        var data = google.visualization.arrayToDataTable(result);

        <?php /* var data = google.visualization.arrayToDataTable(<?= $result_chart_kualitas; ?>); */ ?>

        var options = {
            chart: {
                title: 'Grafik Kualitas',
                subtitle: '<?= date('d-m-Y  h:i:s'); ?>'
            },
            colors: ['#FA0065'],
            legend: { position: 'none' },
            vAxis: {
                title: 'Kualitas'
            },
            hAxis: {
                title: 'Bulan'
            }
        }

        var chart = new google.charts.Bar(document.getElementById('curve_chart_kualitas'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
    }
</script>
<?php $this->endSection(); ?>