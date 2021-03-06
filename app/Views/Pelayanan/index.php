<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url('pelayanan/jenis-advokasi'); ?>">Layanan</a></li>
        <li class="breadcrumb-item active" aria-current="page">Daftar <?= $title ?></li>
    </ol>
</nav>

<div class="d-flex align-items-center p-3 my-1 text-white-50 bg-info rounded shadow-sm">
    <div class="lh-100">
        <h6 class="mb-0 text-white lh-100 text-uppercase">TABEL <?= $title ?></h6>
    </div>
</div>

<div class="card mb-3">
    <div class="row">
        <div class="col-md-12">
            <div class="card-body">
                <form id="form-submit" action="" method="GET">
                    <div class="row">
                        <div class="col-4">
                            Tampilkan <?= form_dropdown('per_page', $options_per_page, $per_page, ['class' => 'custom-select ', 'id' => 'per_page', 'class' => "custom-select col-sm-3 mr-2"]); ?>
                        </div>
                        <div class="col-8">
                            
                                <div class="input-group mb-3">
                                    <?= form_dropdown('sort', $options_sort, $sort, ['class' => 'custom-select mr-2', 'id' => 'sort']); ?>
                                    <?= form_dropdown('tahun', $options_tahun, $tahun, ['class' => 'custom-select mr-2', 'id' => 'tahun']); ?>
                                    <?= form_dropdown('klpd', $options_klpd, $klpd, ['class' => 'custom-select mr-2', 'id' => 'klpd']); ?>
                                    <?= form_dropdown('jenis_advokasi_id', $options_jenis_advokasi, $jenis_advokasi_id, ['id' => 'jenis_advokasi_id', 'class' => "custom-select mr-2"]); ?>
                                    <input type="text" class="form-control" placeholder="Masukan kata nama / nama paket" name="q" value="<?= $keyword ?>" autofocus>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-info" type="submit"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            
                        </div>    
                    </div>
                </form>
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
                <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead>
                    <tr>
                        <th class="text-center col-small">NO</th>
                        <th>
                        <?php 
                            if(in_array($jenis_advokasi_id, array(1))){
                                echo 'TANGGAL SURAT KELUAR';
                            }else if(in_array($jenis_advokasi_id, array(3))){
                                echo 'TANGGAL PERTEMUAN';
                            }else if(in_array($jenis_advokasi_id, array(4,5))){
                                echo 'TANGGAL PELAKSANAAN';
                            }else{
                                echo 'TANGGAL KIRIM';
                            }
                        ?>
                        </th>
                        <th>NAMA LENGKAP</th>
                        <th>JABATAN</th>
                        <th>TELEPON</th>
                        <th>NAMA PAKET</th>
                        <th>NILAI PAKET (Rp. Juta)</th>
                        <th>JENIS ADVOKASI</th>
                        <th>DIBUAT OLEH</th>
                        <th class="text-center col-small">DETAIL</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        if($result){
                            $i = 1 + ($per_page * ($currentPage - 1));

                            $cons_value = "<small>Tidak Ada Data</small>";

                            foreach($result as $rows):
                                $tanggal_pelaksanaan = ($rows['tanggal_pelaksanaan']) ? $rows['tanggal_pelaksanaan'] : $cons_value;
                                $nama = ($rows['nama']) ? $rows['nama'] : $cons_value;
                                $jabatan = ($rows['jabatan']) ? $rows['jabatan'] : $cons_value;
                                $nomor_telepon = ($rows['nomor_telepon']) ? $rows['nomor_telepon'] : $cons_value;
                                $paket_nama = ($rows['paket_nama']) ? $rows['paket_nama'] : $cons_value;
                                $jenis_advokasi_nama = ($rows['jenis_advokasi_nama']) ? $rows['jenis_advokasi_nama'] : $cons_value;
                                $paket_nilai_pagu = ($rows['paket_nilai_pagu']) ? "Rp. ". number_format($rows['paket_nilai_pagu']/1000000, 2) : $cons_value;
                            ?>
                            <tr>
                                <th scope="row" class="text-center"><?= $i++; ?></th>
                                <td><?= tanggalid($tanggal_pelaksanaan); ?></td>
                                <td><?= $nama; ?></td>
                                <td><?= $jabatan; ?></td>
                                <td><?= $nomor_telepon; ?></td>
                                <td><?= $paket_nama; ?></td>
                                <td class="text-right"><?= $paket_nilai_pagu; ?></td>
                                <td class="text-center"><?= $jenis_advokasi_nama; ?></td>
                                <td><?= $rows['nama_depan'] . " " . $rows['nama_belakang']; ?></td>
                                <td class="text-center">
                                    <a href="<?= base_url('pelayanan/' . $rows['id']); ?>" class="text-decoration-none">
                                        Lihat
                                    </a>
                                    <?php /*
                                    <div class="btn-group">
                                        <a href="<?= base_url('pelayanan/' . $rows['id']); ?>" class="btn btn-sm btn-success">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <?php if(in_array($rows['jenis_advokasi_id'], array(1,2,3,4,5,6,7))){ ?>
                                        <a href="<?= base_url('pelayanan/' . $rows['jenis_advokasi_id'] . '/edit/' . $rows['id']); ?>" class="btn btn-sm btn-success">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <?php } ?>
                                        <?php if(in_array($rows['jenis_advokasi_id'], array(1,2,3,4,5,6,7))){ ?>
                                        <a href="<?= base_url('pelayanan/' . $rows['id'] . '/file'); ?>" class="btn btn-sm btn-success">
                                            <i class="fa fa-file"></i>
                                        </a>
                                        <?php } ?>
                                        <?php if(in_array($rows['jenis_advokasi_id'], array(3,4,5))){ ?>
                                        <a href="<?= base_url('pelayanan/' . $rows['id'] . '/peserta'); ?>" class="btn btn-sm btn-success">
                                            <i class="fa fa-users"></i>
                                        </a>
                                        <?php } ?>
                                        <?php if(in_array($rows['jenis_advokasi_id'], array(1,2,3,4,5,6,7))){ ?>
                                        <a href="<?= base_url('pelayanan/' . $rows['id'] . '/pic'); ?>" class="btn btn-sm btn-success">
                                            <i class="fa fa-user"></i>
                                        </a>
                                        <?php } ?>
                                        */ ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; 
                        }else{
                            echo '<tr class="text-center"><td colspan="8">Data tidak ditemukan</td></tr>';
                        }  
                        ?>
                    </tbody>
                </table>
                    </div>
            </div>
        </div>
    </div>
</div>

<?= $pager->links('pelayanan', 'bootstrap_pagination'); ?>
<script>
    $(document).ready(function(){
        $('#jenis_advokasi_id').change(function (){ submit_disable(); });
    })
</script>
<?= $this->endSection(); ?>