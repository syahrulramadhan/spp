<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= $title ?></li>
    </ol>
</nav>


<div class="d-flex align-items-center p-3 my-1 text-white-50 bg-info rounded shadow-sm">
    <div class="lh-100">
        <h6 class="mb-0 text-white lh-100 text-uppercase"><?= $title ?></h6>
    </div>
</div>

<form id="form-header" action="" method="GET">
    <div class="row mt-2">
        <div class="col-10"></div>
        <div class="col-2">
            <div class="input-group mb-3">
                <?= form_dropdown('tahun', $options_tahun, $tahun, ['class' => 'custom-select', 'id' => 'tahun']); ?>
            </div>
        </div>    
    </div>
</form>

<?php
    $i = 1; $jumlah = 3;

    foreach($jenis_advokasi_all as $rows):

    if($i % $jumlah == 1){
        echo '<div class="row mb-2">';
        //echo htmlentities('<div class="row mb-2">');
        //echo "<br>";
    }
?>

<div class="col-md-4 text-center">
    <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
        <div class="col p-4 d-flex flex-column position-static">
            <?php if($rows['image_jenis_advokasi']){ ?>
            <center class="mb-2">
                <img src="<?php echo base_url('uploads/jenis-advokasi/'.$rows['image_jenis_advokasi']) ?>" class="rounded-circle img-thumbnail" style="width: 200px;">
            </center>
            <?php } ?>
            <div style="height: 60px;" class="mb-2"><h3><?= $rows['nama_jenis_advokasi']; ?></h3></div>
            <div class="fluid text-center"><strong class="d-inline-block mb-2 text-primary"><?= $rows['jumlah_pelayanan']; ?></strong></div>
            <br/>
            <?php if(in_array($rows['id'], array(8,9))){ ?>
                <a class="btn btn-success" href="<?= base_url("kegiatan/create/" . $rows['id']); ?>">Entry</a>
                <a class="btn btn-info" style="margin-top: 5px;" href="<?= base_url("kegiatan?jenis_advokasi_id=" . $rows['id']); ?>" class="stretched-link">Rekap</a>
            <?php }else{ ?>
                <a class="btn btn-success" href="<?= base_url("pelayanan/create/" . $rows['id']); ?>">Entry</a>
                <a class="btn btn-info" style="margin-top: 5px;" href="<?= base_url("pelayanan?jenis_advokasi_id=" . $rows['id']); ?>" class="stretched-link">Rekap</a>
            <?php } ?>
        </div>
    </div>
</div>

<?php
    if($i % $jumlah == 0){
        echo "</div>";
    }else if($i == count($jenis_advokasi_all)){
        echo "</div>";
    }

    $i++;
?>

<script>
    $(document).ready(function(){
        $('#tahun').change(function (){
            $('#form-header').delay(200).submit();
        });
    });
</script>

<?php endforeach; ?>

<?= $this->endSection(); ?>