<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Pages::index');
$routes->get('/login', 'Auth::login');
$routes->get('/logout', 'Auth::logout');

$routes->get('/pages/jenis-pengadaan', 'Pages::jenis_pengadaan');
$routes->get('/pages/jenis-pengadaan/(:num)', 'Pages::jenis_pengadaan_detail/$1');

$routes->get('/pages/satuan-kerja-ajax/(:any)', 'Pages::satuan_kerja_ajax/$1');

$routes->get('/pages/klpd', 'Pages::klpd');
$routes->get('/pages/klpd/(:num)', 'Pages::klpd_detail/$1');
$routes->get('/pages/klpd/(:num)/satuan-kerja/', 'Pages::satuan_kerja');
$routes->get('/pages/klpd/(:num)/satuan-kerja/(:num)', 'Pages::satuan_kerja_detail/$1/$2');
$routes->get('/pages/satuan-kerja-ajax/(:any)', 'Pages::satuan_kerja_ajax/$1');
$routes->get('/pages/klpd-ajax/(:any)', 'Pages::klpd_ajax/$1');

$routes->get('/pages/profil/(:num)', 'Pages::profil/$1');
$routes->post('/pages/profil-update/(:num)', 'Pages::profil_update/$1');
$routes->get('/pages/ubah-kata-sandi/(:num)', 'Pages::ubah_password/$1');
$routes->post('/pages/ubah-kata-sandi-update/(:num)', 'Pages::ubah_password_update/$1');

$routes->get('/jenis-advokasi', 'JenisAdvokasi::index');
$routes->get('/jenis-advokasi/(:num)', 'JenisAdvokasi::detail/$1');
$routes->get('/jenis-advokasi/edit/(:num)', 'JenisAdvokasi::edit/$1');
$routes->post('/jenis-advokasi/update/(:num)', 'JenisAdvokasi::update/$1');
$routes->get('/jenis-advokasi/grafik/(:any)', 'JenisAdvokasi::grafik/$1');
$routes->get('/jenis-advokasi/chart/(:any)', 'JenisAdvokasi::chart/$1');

$routes->get('/kategori-permasalahan', 'KategoriPermasalahan::index');
$routes->get('/kategori-permasalahan/create', 'KategoriPermasalahan::create');
$routes->post('/kategori-permasalahan/save', 'KategoriPermasalahan::save');
$routes->get('/kategori-permasalahan/edit/(:num)', 'KategoriPermasalahan::edit/$1');
$routes->post('/kategori-permasalahan/update/(:num)', 'KategoriPermasalahan::update/$1');
$routes->get('/kategori-permasalahan/(:num)', 'KategoriPermasalahan::detail/$1');
$routes->delete('/kategori-permasalahan/delete/(:num)', 'KategoriPermasalahan::delete/$1');
$routes->get('/kategori-permasalahan/grafik/(:any)', 'KategoriPermasalahan::chart/$1');
$routes->get('/kategori-permasalahan/chart/(:any)', 'KategoriPermasalahan::chart/$1');


$routes->get('/pic', 'Pic::index');
$routes->get('/pic/create', 'Pic::create');
$routes->post('/pic/save', 'Pic::save');
$routes->get('/pic/(:num)', 'Pic::detail/$1');

$routes->get('/user', 'User::index');
$routes->get('/user/create', 'User::create');
$routes->post('/user/save', 'User::save');
$routes->get('/user/(:num)', 'User::detail/$1');

$routes->get('/pelayanan/jenis-advokasi', 'Pelayanan::jenis_advokasi');
$routes->post('/pelayanan/list-ajax', 'Pelayanan::list_ajax');
$routes->get('/pelayanan/(:num)', 'Pelayanan::detail/$1');
$routes->get('/pelayanan/(:num)/edit/(:num)', 'Pelayanan::edit/$1/$2');
$routes->post('/pelayanan/(:num)/update/(:num)', 'Pelayanan::update/$1/$2');

$routes->get('/pelayanan/(:num)/pic/', 'PelayananPic::index/$1');
$routes->get('/pelayanan/(:num)/pic/create', 'PelayananPic::create/$1');
$routes->post('/pelayanan/(:num)/pic/save', 'PelayananPic::save/$1');
$routes->delete('/pelayanan/(:num)/pic/delete/(:num)', 'PelayananPic::delete/$1/$2');

$routes->get('/pelayanan/(:num)/peserta/', 'PelayananPeserta::index/$1');
$routes->get('/pelayanan/(:num)/peserta/create', 'PelayananPeserta::create/$1');
$routes->post('/pelayanan/(:num)/peserta/save', 'PelayananPeserta::save/$1');
$routes->delete('/pelayanan/(:num)/peserta/delete/(:num)', 'PelayananPeserta::delete/$1/$2');

$routes->get('/pelayanan/(:num)/file/', 'PelayananFile::index/$1');
$routes->get('/pelayanan/(:num)/file/create', 'PelayananFile::create/$1');
$routes->post('/pelayanan/(:num)/file/save', 'PelayananFile::save/$1');
$routes->delete('/pelayanan/(:num)/file/delete/(:num)', 'PelayananFile::delete/$1/$2');

$routes->get('/kegiatan', 'Kegiatan::index');
$routes->get('/kegiatan/create', 'Kegiatan::create');
$routes->post('/kegiatan/save', 'Kegiatan::save');
$routes->get('/kegiatan/(:num)', 'Kegiatan::detail/$1');

$routes->get('/kegiatan/(:num)/narasumber/', 'KegiatanNarasumber::index/$1');
$routes->get('/kegiatan/(:num)/narasumber/create', 'KegiatanNarasumber::create/$1');
$routes->post('/kegiatan/(:num)/narasumber/save', 'KegiatanNarasumber::save/$1');
$routes->delete('/kegiatan/(:num)/narasumber/delete/(:num)', 'KegiatanNarasumber::delete/$1/$2');

$routes->get('/kegiatan/(:num)/materi/', 'KegiatanMateri::index/$1');
$routes->get('/kegiatan/(:num)/materi/create', 'KegiatanMateri::create/$1');
$routes->post('/kegiatan/(:num)/materi/save', 'KegiatanMateri::save/$1');
$routes->delete('/kegiatan/(:num)/materi/delete/(:num)', 'KegiatanMateri::delete/$1/$2');

$routes->get('/kegiatan/(:num)/(:num)/pelayanan', 'Kegiatan::pelayanan/$1/$2');
$routes->post('/kegiatan/(:num)/(:num)/pelayanan/save', 'Kegiatan::pelayanan_save/$1/$2');
$routes->delete('/kegiatan/(:num)/(:num)/pelayanan/delete/(:num)', 'Kegiatan::pelayanan_delete/$1/$2/$3');

$routes->get('/laporan/(:any)', 'Laporan::index/$1');
$routes->get('/laporan/(:any)', 'Laporan::index/$1');
/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
