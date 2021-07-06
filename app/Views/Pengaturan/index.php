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
        <h6 class="mb-0 text-white lh-100 text-uppercase">TABEL <?= $title ?></h6>
    </div>
</div>

<div class="card mb-3">
    <div class="row">
        <div class="col-md-12">
            <div class="card-body">
                <?= $validation->listErrors() ?>    
                <form id="form-submit" action="/pengaturan/save" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
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
                    <?php if($result){ ?>
                        <?php foreach($result as $rows): ?>
                            <?php echo $rows['pengaturan_tabs_opened']; ?>
                                <tr class="prop">
                                    <td width="23%" valign="top"><label for="<?php echo $rows['pengaturan_label']; ?>"><?php echo $rows['pengaturan_label']; ?> </label></td>
                                    <td valign="top">
                                        <?php echo $rows['pengaturan_input']; ?>
                                        <span class="error"></span>
                                        <div class="invalid-feedback"><?= $validation->getError($rows['pengaturan_field']); ?></div>
                                    </td>
                                </tr>
                            <?php echo $rows['pengaturan_tabs_closed']; ?>
                        <?php endforeach; ?>
                    <?php } ?>
                </div>
                <button type="submit" class="btn btn-info">Ubah</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>