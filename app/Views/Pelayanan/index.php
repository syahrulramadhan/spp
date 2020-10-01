<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url('pelayanan/jenis-advokasi'); ?>">Advokasi</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= $title ?></li>
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
                <div class="row">
                    <div class="col-9">
                    </div>
                    <div class="col-3">
                        <form action="" method="GET">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Masukan kata pencarian" name="q" value="<?= $keyword ?>" autofocus>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-info" type="submit">Cari</button>
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
                <table class="table table-sm">
                    <thead>
                    <tr>
                        <th class="text-center col-small">NO</th>
                        <th>NAMA LENGKAP</th>
                        <th>JABATAN</th>
                        <th>TELEPON</th>
                        <th>NAMA PAKET</th>
                        <th>NILAI PAKET</th>
                        <th>JENIS ADVOKASI</th>
                        <th class="text-center col-small">DETAIL</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $i = 1 + ($per_page * ($currentPage - 1));

                        foreach($result as $rows):
                    ?>
                    <tr>
                        <th scope="row" class="text-center"><?= $i++; ?></th>
                        <td><?= $rows['nama']; ?></td>
                        <td><?= $rows['jabatan']; ?></td>
                        <td><?= $rows['nomor_telepon']; ?></td>
                        <td><?= $rows['paket_nama']; ?></td>
                        <td class="text-right"><?= "Rp. ". number_format($rows['paket_nilai_pagu'], 2); ?></td>
                        <td class="text-center"><?= $rows['jenis_advokasi_nama']; ?></td>
                        <td class="text-center">
                            <a class="text-decoration-none" href="pelayanan/<?= $rows['id']; ?>">Lihat</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $pager->links('pelayanan', 'bootstrap_pagination'); ?>

<?= $this->endSection(); ?>