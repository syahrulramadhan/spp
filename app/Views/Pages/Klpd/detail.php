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
                <form action="<?= base_url('jenis-advokasi/' . $result['id']) ?>" method="get" class="mt-2 form-inline">
                    <?= csrf_field(); ?>
                    <div class="form-group">
                        <label for="klpd" class="col-sm-2 col-form-label">Jenis K/L/Pemda </label>
                        <div class="col-sm-10">
                            <?= form_dropdown('jenis_klpd', $options_jenis_klpd, $jenis_klpd, ['class' => 'custom-select ', 'id' => 'jenis_klpd']); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="klpd" class="col-sm-2 col-form-label">Tahun </label>
                        <div class="col-sm-10">
                            <?= form_dropdown('tahun', $options_tahun_layanan, $tahun, ['class' => 'custom-select ', 'id' => 'tahun']); ?>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-info">Cari</button>
                </form>
                <div class="d-flex align-items-center p-3 my-1 text-white-50 bg-info rounded shadow-sm">
                    <div class="lh-100">
                        <h6 class="mb-0 text-white lh-100">Grafik Layanan <?= $result['nama_klpd'] ?></h6>
                    </div>
                </div>
                <div class="mb-3 p-3 bg-white rounded shadow-sm">
                    <div id="curve_chart_pelayanan" style="width: 100%; height: 400px"></div>
                </div>
                <div class="d-flex align-items-center p-3 my-1 text-white-50 bg-info rounded shadow-sm">
                    <div class="lh-100">
                        <h6 class="mb-0 text-white lh-100">Grafik Valuasi <?= $result['nama_klpd'] ?></h6>
                    </div>
                </div>
                <div class="mb-3 p-3 bg-white rounded shadow-sm">
                    <div id="curve_chart_valuasi" style="width: 100%; height: 400px"></div>
                </div>
                <div class="d-flex align-items-center p-3 my-1 text-white-50 bg-info rounded shadow-sm">
                    <div class="lh-100">
                        <h6 class="mb-0 text-white lh-100">Grafik Kualitas <?= $result['nama_klpd'] ?></h6>
                    </div>
                </div>
                <div class="mb-3 p-3 bg-white rounded shadow-sm">
                    <div id="curve_chart_kualitas" style="width: 100%; height: 400px"></div>
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
            <h6 class="border-bottom border-gray pb-2 mb-0">Recent updates</h6>

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
            <h6 class="border-bottom border-gray pb-2 mb-0">Recent updates</h6>

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
                <table class="table table-sm">
                    <thead>
                    <tr>
                        <th style="width: 80px;" class="text-center">NO</th>
                        <th>NAMA SATUAN KERJA</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $i = 1;

                        foreach($result_satuan_kerja as $rows):
                    ?>
                    <tr>
                        <th scope="row" class="text-center"><?= $i++; ?></th>
                        <td>
                            <!--<a href="/pages/klpd/<?= $result['id']; ?>/satuan-kerja/<?= $rows['id']; ?>">-->
                                <?= $rows['nama_satker']; ?>
                            <!--</a>-->
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
    $('#jenis_klpd').select2();
    $('#tahun').select2

    google.charts.load('current', {'packages':['bar']});
    google.charts.setOnLoadCallback(drawChartLayanan);
    google.charts.setOnLoadCallback(drawChartValuasi);
    google.charts.setOnLoadCallback(drawChartKualitas);

    function drawChartLayanan() {
    
        var data = google.visualization.arrayToDataTable(<?= $result_chart_pelayanan; ?>);

        var options = {
            chart: {
                title: 'Grafik Layanan <?= $result['nama_klpd'] ?>',
                subtitle: '<?= date('d-m-Y  h:i:s'); ?>'
            },
            colors: ['#8bd1dc','#17a2b8'],
            legend: { position: 'none' },
            vAxis: {
                title: 'Layanan <?= $result['nama_klpd'] ?>'
            },
            hAxis: {
                title: 'Bulan',
            }
        }

        var chart = new google.charts.Bar(document.getElementById('curve_chart_pelayanan'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
    }

    function drawChartValuasi(){
        var data = google.visualization.arrayToDataTable(<?= $result_chart_valuasi; ?>);

        var options = {
            chart: {
                title: 'Grafik Valuasi <?= $result['nama_klpd'] ?>',
                subtitle: '<?= date('d-m-Y  h:i:s'); ?>'
            },
            colors: ['#8bd1dc','#17a2b8'],
            legend: { position: 'none' },
            vAxis: {
                title: 'Valuasi <?= $result['nama_klpd'] ?>'
            },
            hAxis: {
                title: 'Bulan',
            }
        }

        var chart = new google.charts.Bar(document.getElementById('curve_chart_valuasi'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
    }

    function drawChartKualitas(){
        var data = google.visualization.arrayToDataTable(<?= $result_chart_kualitas; ?>);

        var options = {
            chart: {
                title: 'Grafik Kualitas <?= $result['nama_klpd'] ?>',
                subtitle: '<?= date('d-m-Y  h:i:s'); ?>'
            },
            colors: ['#8bd1dc','#17a2b8'],
            legend: { position: 'none' },
            vAxis: {
                title: 'Kualitas <?= $result['nama_klpd'] ?>'
            },
            hAxis: {
                title: 'Bulan'
            }
        }

        var chart = new google.charts.Bar(document.getElementById('curve_chart_kualitas'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
    }
</script>

<?= $this->endSection(); ?>