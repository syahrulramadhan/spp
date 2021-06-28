<nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-info">
  <!--<a class="navbar-brand mr-auto mr-lg-0" href="#">D.4.1</a>-->
  <button class="navbar-toggler p-0 border-0" type="button" data-toggle="offcanvas">
    <span class="navbar-toggler-icon"></span>
  </button>
  
  <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
    
    <ul class="navbar-nav mr-auto">
    <?php if(session()->has('logged_in')){ ?>
      <li class="nav-item active">
        <a class="nav-link" href="<?= base_url(); ?>">Dashboard <span class="sr-only">(current)</span></a>
      </li>
      <?php if(permission(['ADMINISTRATOR','ADMIN_CONTENT'])){ ?>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Data</a>
        <div class="dropdown-menu" aria-labelledby="dropdown01">
          <a class="dropdown-item" href="/jenis-advokasi">Jenis Advokasi</a>  
          <a class="dropdown-item" href="/pages/jenis-pengadaan">Jenis Barang/Jasa</a>  
          <a class="dropdown-item" href="/kategori-permasalahan">Kategori Permasalahan</a>
          <a class="dropdown-item" href="/pages/klpd">K/L/Pemda</a>
          <a class="dropdown-item" href="/pic">PIC</a>
          <?php if(permission(['ADMINISTRATOR'])){ ?>
          <a class="dropdown-item" href="/user">User</a>
          <?php } ?>
        </div>
      </li>
      <?php } ?>
      <li class="nav-item">
        <a class="nav-link" href="/pelayanan/jenis-advokasi">Layanan</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Laporan</a>
        <div class="dropdown-menu" aria-labelledby="dropdown01">
          <a class="dropdown-item" href="<?= base_url('laporan/laporan-pelayanan') ?>">Laporan Layanan</a>  
          <a class="dropdown-item" href="<?= base_url('laporan/laporan-valuasi') ?>">Laporan Valuasi</a>
        </div>
      </li>
      <?php } ?>
    </ul>
  

    <ul class="nav navbar-nav justify-content-end">
      <li class="nav-item">
        <span class="nav-link text-white"><strong>DASHBOARD KEDEPUTIAN 4</strong></span>
      </li>
    </ul>
    
    <?php if(permission(['ADMINISTRATOR','ADMIN_CONTENT'])){ ?>
    <ul class="navbar-nav justify-content-end">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= session('nama_lengkap') ?></strong></a>
        <div class="dropdown-menu" aria-labelledby="dropdown01">
          <a class="dropdown-item" href="<?= base_url('logout') ?>">Log Out</a>
          <a class="dropdown-item" href="<?= base_url('/pages/ubah-kata-sandi/' . session('id')); ?>">Kata Sandi</a>
          <a class="dropdown-item" href="<?= base_url('/pengaturan'); ?>">Pengaturan</a>
          <a class="dropdown-item" href="<?= base_url('/pages/profil/' . session('id')); ?>">Profile</a>
        </div>
      </li>
    </ul>
    <?php } ?>
    <!--
    <form id="form-submit" class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Search</button>
    </form>
    -->
  </div>
</nav>

<div class="nav-scroller bg-white shadow-sm">
  <nav class="nav nav-underline">
    <!-- <a class="nav-link active" href="/pelayanan">Pelayanan</a> -->

    <?php /* oreach($jenis_advokasi_all as $rows): ?>
    <a class="nav-link" href="#">
      <?= $rows['nama_jenis_advokasi']; ?>
      <span class="badge badge-pill bg-light align-text-bottom"><?= $rows['jumlah'] ?></span>
    </a>
    <?php endforeach; */ ?>

    <!--
    <a class="nav-link" href="#">
      Clearing House<span class="badge badge-pill bg-light align-text-bottom">44</span>
    </a>
    <a class="nav-link" href="#">
      Konsolidaasi<span class="badge badge-pill bg-light align-text-bottom">27</span>
    </a>
    <a class="nav-link" href="#">
      Pendampingan<span class="badge badge-pill bg-light align-text-bottom">2</span>
    </a>
    <a class="nav-link" href="#">
      Rapat Eksternal<span class="badge badge-pill bg-light align-text-bottom">65</span>
    </a>
    <a class="nav-link" href="#">
      Surat<span class="badge badge-pill bg-light align-text-bottom">23</span>
    </a>
    <a class="nav-link" href="#">
      Tatap Muka<span class="badge badge-pill bg-light align-text-bottom">11</span>
    </a>
    <a class="nav-link" href="#">
      WA/Telepon<span class="badge badge-pill bg-light align-text-bottom">4</span>
    </a>
    <a class="nav-link" href="#">
      Web<span class="badge badge-pill bg-light align-text-bottom">5</span>
    </a>
    -->
  </nav>
</div>