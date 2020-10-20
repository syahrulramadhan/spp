<?php $this->extend('layout/template'); ?>

<?php $this->section('content'); ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<div class="row">
    <div class="col-md-8">
        <div class="d-flex align-items-center p-3 my-1 text-white-50 bg-info rounded shadow-sm">
            <div class="lh-100">
                <h6 class="mb-0 text-white lh-100">Overview</h6>
            </div>
        </div>
        <div class="card-deck text-center">
            <div class="card box-shadow">
                <div class="card-header bg-info text-white">
                    <h4 class="my-0 font-weight-normal">Jumlah<br/>Layanan</h4>
                </div>
                <div class="card-body align-self-center">
                    <h1 class="card-title pricing-card-title"><?= $result->overview_layanan; ?></h1>
                </div>
            </div>
            <div class="card box-shadow">
                <div class="card-header bg-info text-white">
                    <h4 class="my-0 font-weight-normal">Nilai Valuasi<br/>(Rp)</h4>
                </div>
                <div class="card-body align-self-center">
                    <h1 class="card-title pricing-card-title"><?= $result->overview_valuasi; ?></h1>
                </div>
            </div>
            <div class="card box-shadow">
                <div class="card-header bg-info text-white">
                    <h4 class="my-0 font-weight-normal">Coverage<br/>(%)</h4>
                </div>
                <div class="card-body align-self-center">
                    <h1 class="card-title pricing-card-title"><?= $result->overview_coverage; ?></h1>
                </div>
            </div>
        </div>
        <div class="d-flex align-items-center p-3 my-1 text-white-50 bg-info rounded shadow-sm">
            <div class="lh-100">
                <h6 class="mb-0 text-white lh-100">Grafik Layanan</h6>
            </div>
        </div>
        <div class="mb-3 p-3 bg-white rounded shadow-sm">
            <form id="form-submit" action="<?= base_url('pages') ?>" method="get" class="form-inline">
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
            <div id="curve_chart_pelayanan" style="width: 100%; height: 400px">
                <div class="my-2">Data tidak ditemukan</div>
            </div>
            <div id="tabel_pelayanan" class="table-responsive mt-2" style="width: 100%;">
                <div class="my-2">Data tidak ditemukan</div>
            </div>
        </div>
        <div class="d-flex align-items-center p-3 my-1 text-white-50 bg-info rounded shadow-sm">
            <div class="lh-100">
                <h6 class="mb-0 text-white lh-100">Grafik Valuasi</h6>
            </div>
        </div>
        <div class="mb-3 p-3 bg-white rounded shadow-sm">
            <form id="form-submit" action="<?= base_url('pages') ?>" method="get" class="form-inline">
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
            <div id="curve_chart_valuasi" style="width: 100%; height: 400px">
                <div class="my-2">Data tidak ditemukan</div>
            </div>
            <div id="tabel_valuasi" class="table-responsive mt-2" style="width: 100%;">
                <div class="my-2">Data tidak ditemukan</div>
            </div>
        </div>
        <div class="d-flex align-items-center p-3 my-1 text-white-50 bg-info rounded shadow-sm">
            <div class="lh-100">
                <h6 class="mb-0 text-white lh-100">Grafik Coverage</h6>
            </div>
        </div>
        <div class="mb-3 p-3 bg-white rounded shadow-sm">
            <form id="form-submit" action="<?= base_url('pages') ?>" method="get" class="form-inline">
                <?= csrf_field(); ?>

                <div class="form-group">
                    <label for="klpd" class="col-form-label">Jenis K/L/Pemda </label>
                    <div class="col">
                        <?= form_dropdown('jenis_klpd_coverage', $options_jenis_klpd, $jenis_klpd, ['class' => 'custom-select ', 'id' => 'jenis_klpd_coverage']); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="klpd" class="col-form-label">Tahun </label>
                    <div class="col">
                        <?= form_dropdown('tahun_coverage', $options_tahun_layanan, $tahun, ['class' => 'custom-select ', 'id' => 'tahun_coverage']); ?>
                    </div>
                </div> 

                <button type="submit" class="btn btn-info" id="cari_chart_coverage">Cari</button>
            </form>
            <div id="curve_chart_coverage" style="width: 100%; height: 400px">
                <div class="my-2">Data tidak ditemukan</div>
            </div>
            <div id="tabel_coverage" class="table-responsive mt-2" style="width: 100%;">
                <div class="my-2">Data tidak ditemukan</div>
            </div>
        </div>
        <div class="d-flex align-items-center p-3 my-1 text-white-50 bg-info rounded shadow-sm">
            <div class="lh-100">
                <h6 class="mb-0 text-white lh-100">Grafik Kualitas</h6>
            </div>
        </div>
        <div class="mb-3 p-3 bg-white rounded shadow-sm">
            <form id="form-submit" action="<?= base_url('pages') ?>" method="get" class="form-inline">
                <?= csrf_field(); ?>

                <div class="form-group">
                    <label for="klpd" class="col-form-label">Jenis K/L/Pemda </label>
                    <div class="col">
                        <?= form_dropdown('jenis_klpd_kualitas', $options_jenis_klpd, $jenis_klpd, ['class' => 'custom-select ', 'id' => 'jenis_klpd_kualitas']); ?>
                    </div>
                </div>
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
            <div id="tabel_kualitas" class="table-responsive mt-2" style="width: 100%;">
                <div class="my-2">Data tidak ditemukan</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="p-3 my-1 text-center bg-white rounded">
            <div class="row">
                <div class="pb-2 col-md-8 d-flex flex-wrap align-items-center">
                    <img src="<?= base_url('uploads/lkpp.png') ?>" class="img-fluid" alt="Lembaga Kebijakan Pengadaan Barang/Jasa Pemerintah">
                </div>
                <div class="pb-2 col-md-4">
                    <img src="<?= base_url('uploads/Logo D4-08.png') ?>" class="img-fluid" alt="Deputy Chairman D4">
                </div>
            </div>
        </div>
        <div class="d-flex align-items-center p-3 my-1 text-white-50 bg-info rounded shadow-sm">
            <div class="lh-100">
                <h6 class="mb-0 text-white lh-100">Recent updates Layanan</h6>
            </div>
        </div>

        <div class="p-3 bg-white rounded shadow-sm">
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

    $('#jenis_klpd').select2(); $('#tahun').select2();

    $(document).ready(function(){
        var delay = 1000;

        load_layanan_list();
        google.charts.load('current', {'packages':['bar']});

        setTimeout(function(){
            google.charts.setOnLoadCallback(drawChartLayanan);
        }, delay * 0.5)

        setTimeout(function(){
            google.charts.setOnLoadCallback(drawChartValuasi);
        }, delay * 1);

        setTimeout(function(){
            google.charts.setOnLoadCallback(drawChartCoverage);
        }, delay * 2);

        setTimeout(function(){
            google.charts.setOnLoadCallback(drawChartKualitas);
        }, delay * 3);

        $('#cari_chart_layanan').click(function(e){  
            e.preventDefault();
            google.charts.setOnLoadCallback(drawChartLayanan);
        });

        $('#cari_chart_valuasi').click(function(e){  
            e.preventDefault();
            google.charts.setOnLoadCallback(drawChartValuasi);
        });

        $('#cari_chart_coverage').click(function(e){  
            e.preventDefault();
            google.charts.setOnLoadCallback(drawChartCoverage);
        });

        $('#cari_chart_kualitas').click(function(e){  
            e.preventDefault();
            google.charts.setOnLoadCallback(drawChartKualitas);
        });
    });

    function load_layanan_list(){
        $.ajax({  
            url:"<?= base_url("pelayanan/list-ajax"); ?>",  
            method:"POST",
            success:function(response)  
            { 
                var data = JSON.parse(response);

                $("#daftarPelayanan").html("");

                $.each(data, function(i, item) {
                    var nama_instansi = (data[i].nama_klpd) ? data[i].nama_klpd : data[i].klpd_nama_lainnya;

                    $("#daftarPelayanan").append('<a href="pelayanan/' + data[i].id + '" class="text-decoration-none">' + 
                        '<div class="media text-muted pt-2">' +
                            '<svg class="bd-placeholder-img mr-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 32x32"><title>Placeholder</title><rect width="100%" height="100%" fill="#17a2b8 "/><text x="50%" y="50%" fill="#17a2b8 " dy=".3em">32x32</text></svg>' +
                            '<p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">' +
                                '<strong class="d-block text-gray-dark">' + nama_instansi + '</strong>' + 
                                data[i].paket_nama +
                                '<span class="badge badge-pill bg-light align-text-bottom" >' + data[i].jenis_advokasi_nama + '</span>' +
                            '</p>'+
                        '</div>' +
                    '</a>');
                });
            }  
        });
    }

    function drawChartLayanan() {
        var ajax = $.ajax({
            url: '<?= base_url("pages/chart/chart_layanan"); ?>',
            data: { jenis_klpd: $("#jenis_klpd_layanan").val(), tahun: $("#tahun_layanan").val() },
            dataType: "json", // type of data we're expecting from server
            async: false // make true to avoid waiting for the request to be complete
        });

        var result = JSON.parse(ajax.responseText);
        if(result.status){

            //console.log(result.data);

            var html = "<table class='table table-bordered table-sm'>";
            html += "<tr>";

            $.each(result.data, function(i, item) {
                if(i == 0)
                    html += "<td >" + item[0] + "</td>";
                else
                    html += "<td style='text-align: center;'>" + item[0] + "</td>";
            });

            html += "</tr>";
            html += "<tr>";

            $.each(result.data, function(i, item) {
                if(i == 0)
                    html += "<td >" + item[2] + "</td>";
                else
                    html += "<td style='text-align: center;'>" + number_format(item[2],0,'.',',') + "</td>";
            });

            html += "</tr>";
            html += "</table>";

            $("#tabel_pelayanan").html(html);

            var data = google.visualization.arrayToDataTable(result.data);
            var options = {
                chart: {
                    title: 'Grafik Layanan',
                    subtitle: '<?= date('d-m-Y  h:i:s'); ?>'
                },
                colors: ['#FFAF2E','#FF7A20'],
                legend: { position: 'top'},
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
            url: '<?= base_url("pages/chart/chart_valuasi"); ?>',
            data: { jenis_klpd: $("#jenis_klpd_valuasi").val(), tahun: $("#tahun_valuasi").val() },
            dataType: "json", // type of data we're expecting from server
            async: false // make true to avoid waiting for the request to be complete
        });

        var result = JSON.parse(ajax.responseText);
        if(result.status){

            //console.log(result.data);

            var html = "<table class='table table-bordered table-sm'>";
            html += "<tr>";

            $.each(result.data, function(i, item) {
                if(i == 0)
                    html += "<td >" + item[0] + "</td>";
                else
                    html += "<td style='text-align: center;'>" + item[0] + "</td>";
            });

            html += "</tr>";
            html += "<tr>";

            $.each(result.data, function(i, item) {
                if(i == 0)
                    html += "<td >" + item[2] + "</td>";
                else
                    html += "<td style='text-align: center;'>" + number_format(item[2],0,'.',',') + "</td>";
            });

            html += "</tr>";
            html += "</table>";

            $("#tabel_valuasi").html(html);

            var data = google.visualization.arrayToDataTable(result.data);
            var options = {
                chart: {
                    title: 'Grafik Valuasi (Rp. JUTA)',
                    subtitle: '<?= date('d-m-Y  h:i:s'); ?>'
                },
                colors: ['#FA68F8','#FA00B5'],
                legend: { position: 'top'},
                vAxis: {
                    title: 'Valuasi',
                    format: '#,###'
                },
                hAxis: {
                    title: 'Bulan'
                }
            }

            var chart = new google.charts.Bar(document.getElementById('curve_chart_valuasi'));

            chart.draw(data, google.charts.Bar.convertOptions(options));
        }else{
            $('#curve_chart_valuasi').html('<div class="my-2">Data tidak ditemukan</div>')
        }
    }

    function drawChartCoverage(){
        var ajax = $.ajax({
            url: '<?= base_url("pages/chart/chart_coverage"); ?>',
            data: { jenis_klpd: $("#jenis_klpd_coverage").val(), tahun: $("#tahun_coverage").val() },
            dataType: "json", // type of data we're expecting from server
            async: false // make true to avoid waiting for the request to be complete
        });

        var result = JSON.parse(ajax.responseText);
        if(result.status){

            //console.log(result.data);

            var html = "<table class='table table-bordered table-sm'>";
            html += "<tr>";

            $.each(result.data, function(i, item) {
                if(i == 0)
                    html += "<td >" + item[0] + "</td>";
                else
                    html += "<td style='text-align: center;'>" + item[0] + "</td>";
            });

            html += "</tr>";
            html += "<tr>";

            $.each(result.data, function(i, item) {
                if(i == 0)
                    html += "<td >" + item[2] + "</td>";
                else
                    html += "<td style='text-align: center;'>" + number_format((item[2]*100),2,'.',',') + "</td>";
            });

            html += "</tr>";
            html += "</table>";

            $("#tabel_coverage").html(html);

            var data = google.visualization.arrayToDataTable(result.data);
            var options = {
                chart: {
                    title: 'Grafik Coverage',
                    subtitle: '<?= date('d-m-Y  h:i:s'); ?>'
                },
                colors: ['#DBFF0D','#9AE600'],
                legend: { position: 'top'},
                vAxis: {
                    title: 'Coverage (%)',
                    format: '#,###.## %'
                },
                hAxis: {
                    title: 'Bulan'
                }
            }

            var chart = new google.charts.Bar(document.getElementById('curve_chart_coverage'));

            chart.draw(data, google.charts.Bar.convertOptions(options));
        }else{
            $('#curve_chart_coverage').html('<div class="my-2">Data tidak ditemukan</div>')
        }
    }

    function drawChartKualitas(){
        var ajax = $.ajax({
            url: '<?= base_url("pages/chart/chart_kualitas"); ?>',
            data: { jenis_klpd: $("#jenis_klpd_kualitas").val(), tahun: $("#tahun_kualitas").val() },
            dataType: "json", // type of data we're expecting from server
            async: false // make true to avoid waiting for the request to be complete
        });

        var result = JSON.parse(ajax.responseText);
        if(result.status){

            //console.log(result.data);

            var html = "<table class='table table-bordered table-sm'>";
            html += "<tr>";

            $.each(result.data, function(i, item) {
                if(i == 0)
                    html += "<td >" + item[0] + "</td>";
                else
                    html += "<td style='text-align: center;'>" + item[0] + "</td>";
            });

            html += "</tr>";
            html += "<tr>";

            $.each(result.data, function(i, item) {
                if(i == 0)
                    html += "<td >" + item[1] + "</td>";
                else
                    html += "<td style='text-align: center;'>" + number_format(item[1],2,'.',',') + "</td>";
            });

            html += "</tr>";
            html += "</table>";

            $("#tabel_kualitas").html(html);

            var data = google.visualization.arrayToDataTable(result.data);
            var options = {
                chart: {
                    title: 'Grafik Kualitas',
                    subtitle: '<?= date('d-m-Y  h:i:s'); ?>'
                },
                colors: ['#FA0065'],
                legend: { position: 'top'},
                vAxis: {
                    title: 'Nilai Kualitas',
                    //format: 'percent'
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
<?php $this->endSection(); ?>