<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

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
                        <h6 class="mb-0 text-white lh-100">Grafik Layanan <?= $result['nama_jenis_pengadaan'] ?></h6>
                    </div>
                </div>
                <div class="mb-3 p-3 bg-white rounded shadow-sm">
                    <div id="curve_chart_pelayanan" style="width: 100%; height: 400px"></div>
                </div>
                <div class="d-flex align-items-center p-3 my-1 text-white-50 bg-info rounded shadow-sm">
                    <div class="lh-100">
                        <h6 class="mb-0 text-white lh-100">Grafik Valuasi <?= $result['nama_jenis_pengadaan'] ?></h6>
                    </div>
                </div>
                <div class="mb-3 p-3 bg-white rounded shadow-sm">
                    <div id="curve_chart_valuasi" style="width: 100%; height: 400px"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    google.charts.load('current', {'packages':['bar']});
    google.charts.setOnLoadCallback(drawChartLayanan);
    google.charts.setOnLoadCallback(drawChartValuasi);

    function drawChartLayanan() {
    
        var data = google.visualization.arrayToDataTable(<?= $result_chart_pelayanan; ?>);

        var options = {
            chart: {
                title: 'Grafik Layanan <?= $result['nama_jenis_pengadaan'] ?>',
                subtitle: '<?= date('d-m-Y  h:i:s'); ?>'
            },
            colors: ['#8bd1dc','#17a2b8'],
            legend: { position: 'none' },
            vAxis: {
                title: 'Layanan <?= $result['nama_jenis_pengadaan'] ?>'
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
                title: 'Grafik Valuasi <?= $result['nama_jenis_pengadaan'] ?>',
                subtitle: '<?= date('d-m-Y  h:i:s'); ?>'
            },
            colors: ['#8bd1dc','#17a2b8'],
            legend: { position: 'none' },
            vAxis: {
                title: 'Valuasi <?= $result['nama_jenis_pengadaan'] ?>'
            },
            hAxis: {
                title: 'Bulan',
            }
        }

        var chart = new google.charts.Bar(document.getElementById('curve_chart_valuasi'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
    }
</script>

<?= $this->endSection(); ?>