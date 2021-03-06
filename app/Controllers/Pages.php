<?php namespace App\Controllers;

use App\Models\SatuanKerjaModel;
use App\Models\KlpdModel;
use App\Models\JenisPengadaanModel;
use App\Models\PelayananModel;
use App\Models\UserModel;
use App\Models\GrafikModel;

class Pages extends BaseController
{
	protected $satuanKerjaModel;
	protected $klpdModel;
	protected $jenisPengadaanModel;
	protected $userModel;
	protected $pelayananModel;
	protected $grafikModel;

	public function __construct()
	{
		$this->satuanKerjaModel = new SatuanKerjaModel();
		$this->klpdModel = new KlpdModel();
		$this->jenisPengadaanModel = new JenisPengadaanModel();
		$this->userModel = new UserModel();
		$this->pelayananModel = new PelayananModel();
		$this->grafikModel = new GrafikModel();

		$this->session = session();
		helper('form');
	}

	public function index()
	{
		$jenis_klpd = $this->request->getVar('jenis_klpd');
		$tahun = ($this->request->getVar('tahun')) ? $this->request->getVar('tahun') : date('Y');

		$result = $this->pelayananModel->overviewLayanan();
		$result->overview_valuasi = $this->singkatan_mata_uang($result->overview_valuasi, 0);

		$data = [
			'jenis_klpd' => $jenis_klpd,
			'tahun' => $tahun,
			'options_jenis_klpd' => $this->options_jenis_klpd_extra(),
			'options_tahun_layanan' => $this->options_tahun_layanan(),
			'result' => $result
		];

		$this->cachePage(10);

		return view('Pages/index', $data);
	}

	public function chart($param = ""){
		header('Access-Control-Allow-Origin: *');
		
		$jenis_klpd = ($this->request->getVar('jenis_klpd')) ? $this->request->getVar('jenis_klpd') : "";
		$tahun = ($this->request->getVar('tahun')) ? $this->request->getVar('tahun') : date('Y');

		$grafik = [];
		$grafik1 = [];

		$grafik1[0][0] = "";
		$grafik1[0][1] = "";

		$grafik[0][0] = "";
		$grafik[0][1] = "";
		$grafik[0][2] = "";

		for($i=1;$i<=12;$i++){
			$grafik1[$i][0] = $this->bulan($i);
			$grafik1[$i][1] = 0;

			$grafik[$i][0] = $this->bulan($i);
			$grafik[$i][1] = 0;
			$grafik[$i][2] = 0;
		}

		if($param == 'chart_valuasi'){
			$result = $this->pelayananModel->ChartPelayananValuasi($jenis_klpd, $tahun);

			if($result){
				$grafik[0][0] = 'Bulan';
				$grafik[0][1] = 'Jumlah Valuasi';
				$grafik[0][2] = 'Akumulasi Valuasi';

				foreach($result as $rows){
					$grafik[$rows['bulan']][0] = $this->bulan($rows['bulan']);
					$grafik[$rows['bulan']][1] = (double) ($rows['jumlah_valuasi']/1000000);
					$grafik[$rows['bulan']][2] = (double) ($rows['total_valuasi']/1000000);
				}
			}else{
				echo json_encode(array('status' => false, 'data' => [])); exit;
			}
		}else if($param == 'chart_coverage'){
			$count = $this->klpdModel->getCountKlpd($jenis_klpd);
			$result = $this->pelayananModel->ChartPelayananCoverage($jenis_klpd, $tahun);

			if($result){
				$grafik[0][0] = 'Bulan';
				$grafik[0][1] = 'Jumlah Coverage';
				$grafik[0][2] = 'Akumulasi Coverage';

				$total_coverage = 0;

				foreach($result as $rows){
					$jumlah_coverage = $rows['total_coverage'] - $total_coverage;

					$grafik[$rows['bulan']][0] = $this->bulan($rows['bulan']);
					$grafik[$rows['bulan']][1] = round($jumlah_coverage/$count, 4);
					$grafik[$rows['bulan']][2] = round($rows['total_coverage']/$count, 4);

					$total_coverage = $rows['total_coverage'];
				}
			}else{
				echo json_encode(array('status' => false, 'data' => [])); exit;
			}
		/*
		}else if($param == 'chart_kualitas'){
			$count = $this->klpdModel->getCountKlpd($jenis_klpd);
			
			$grafik1[0][0] = 'BULAN';
			$grafik1[0][1] = 'RATA-RATA SKOR';

			$total = 0;

			for($i=1;$i<=date('m');$i++){
				$result = $this->pelayananModel->ChartPelayananKualitas($i, $jenis_klpd, $tahun);

				if($result->total_kualitas){
					$grafik1[$i][1] = $result->total_kualitas/$count;

					$total = $total + 1;
				}
			}

			if($total < 1){
				echo json_encode(array('status' => false, 'data' => [])); exit;
			}else{
				$grafik = $grafik1;
			}
		*/
		}else if($param == 'chart_kualitas'){
			$count = $this->klpdModel->getCountKlpd($jenis_klpd);
			$result = $this->pelayananModel->ChartPelayananKualitas($jenis_klpd, $tahun);

			if($result){
				$grafik1[0][0] = 'Bulan';
				$grafik1[0][1] = 'Rata-Rata Skor';

				foreach($result as $rows){
					$grafik1[$rows['bulan']][0] = $this->bulan($rows['bulan']);
					$grafik1[$rows['bulan']][1] = round($rows['nilai_kualitas']/$count, 4);
				}

				$grafik = $grafik1;
			}else{
				echo json_encode(array('status' => false, 'data' => [])); exit;
			}
		}else{
			$result = $this->pelayananModel->ChartPelayananJumlah($jenis_klpd, $tahun);

			if($result){
				$grafik[0][0] = 'Bulan';
				$grafik[0][1] = 'Jumlah Layanan';
				$grafik[0][2] = 'Akumulasi Layanan';

				foreach($result as $rows){
					$grafik[$rows['bulan']][0] = $this->bulan($rows['bulan']);
					$grafik[$rows['bulan']][1] = (int) ($rows['jumlah_pelayanan']);
					$grafik[$rows['bulan']][2] = (int) ($rows['total_pelayanan']);
				}
			}else{
				echo json_encode(array('status' => false, 'data' => [])); exit;
			}
		}

		$this->cachePage(5);
		
		echo json_encode(array('status' => true, 'data' => $grafik, JSON_PRETTY_PRINT));
	}

	public function chartJenisPengadaan($param = ""){
		$id = ($this->request->getVar('id')) ? $this->request->getVar('id') : "";
		$jenis_klpd = ($this->request->getVar('jenis_klpd')) ? $this->request->getVar('jenis_klpd') : "";
		$tahun = ($this->request->getVar('tahun')) ? $this->request->getVar('tahun') : date('Y');

		$grafik = [];
		
		$grafik[0][0] = "";
		$grafik[0][1] = "";
		$grafik[0][2] = "";

		for($i=1;$i<=12;$i++){
			$grafik[$i][0] = $this->bulan($i);
			$grafik[$i][1] = 0;
			$grafik[$i][2] = 0;
		}

		if($param == 'chart_valuasi'){
			$result = $this->grafikModel->valuasiByJenisPengadaanId($jenis_klpd, $tahun, $id);
			
			if($result){
				$grafik[0][0] = 'Bulan';
				$grafik[0][1] = 'Jumlah Valuasi';
				$grafik[0][2] = 'Akumulasi Valuasi';

				foreach($result as $rows){
					$grafik[$rows['bulan']][0] = $this->bulan($rows['bulan']);
					$grafik[$rows['bulan']][1] = (double) ($rows['jumlah_valuasi']/1000000);
					$grafik[$rows['bulan']][2] = (double) ($rows['total_valuasi']/1000000);
				}
			}else{
				echo json_encode(array('status' => false, 'data' => [])); exit;
			}
		}else{
			$result = $this->grafikModel->layananByJenisPengadaanId($jenis_klpd, $tahun, $id);

			if($result){
				$grafik[0][0] = 'Bulan';
				$grafik[0][1] = 'Jumlah Layanan';
				$grafik[0][2] = 'Akumulasi Layanan';

				foreach($result as $rows){
					$grafik[$rows['bulan']][0] = $this->bulan($rows['bulan']);
					$grafik[$rows['bulan']][1] = (int) ($rows['jumlah_pelayanan']);
					$grafik[$rows['bulan']][2] = (int) ($rows['total_pelayanan']);
				}
			}else{
				echo json_encode(array('status' => false, 'data' => [])); exit;
			}
		}

		$this->cachePage(5);

		echo json_encode(array('status' => true, 'data' => $grafik, JSON_PRETTY_PRINT));
	}

	public function chartKlpd($param = ""){
		$id = ($this->request->getVar('id')) ? $this->request->getVar('id') : "";
		$tahun = ($this->request->getVar('tahun')) ? $this->request->getVar('tahun') : date('Y');

		$grafik = [];
		$grafik1 = [];

		$grafik = [];
		$grafik1 = [];

		$grafik1[0][0] = "";
		$grafik1[0][1] = "";

		$grafik[0][0] = "";
		$grafik[0][1] = "";
		$grafik[0][2] = "";

		for($i=1;$i<=12;$i++){
			$grafik1[$i][0] = $this->bulan($i);
			$grafik1[$i][1] = 0;

			$grafik[$i][0] = $this->bulan($i);
			$grafik[$i][1] = 0;
			$grafik[$i][2] = 0;
		}

		if($param == 'chart_valuasi'){
			$result = $this->grafikModel->valuasiByKlpdId($tahun, $id);

			if($result){
				$grafik[0][0] = 'Bulan';
				$grafik[0][1] = 'Jumlah Valuasi';
				$grafik[0][2] = 'Akumulasi Valuasi';

				foreach($result as $rows){
					$grafik[$rows['bulan']][0] = $this->bulan($rows['bulan']);
					$grafik[$rows['bulan']][1] = (double) ($rows['jumlah_valuasi']/1000000);
					$grafik[$rows['bulan']][2] = (double) ($rows['total_valuasi']/1000000);
				}
			}else{
				echo json_encode(array('status' => false, 'data' => [])); exit;
			}
		}else if($param == 'chart_kualitas'){
			$grafik1[0][0] = 'Bulan';
			$grafik1[0][1] = 'Rata-Rata Skor';

			$total = 0;

			for($i=1;$i<=date('m');$i++){
				$result = $this->grafikModel->kualitasByKlpdId($i, $tahun, $id);

				if($result->total_kualitas){
					$grafik1[$i][1] = (int) $result->total_kualitas;

					$total = $total + 1;
				}	
			}

			if($total < 1){
				echo json_encode(array('status' => false, 'data' => [])); exit;
			}else{
				$grafik = $grafik1;
			}
		}else{
			$result = $this->grafikModel->layananByKlpdId($tahun, $id);

			if($result){
				$grafik[0][0] = 'Bulan';
				$grafik[0][1] = 'Jumlah Layanan';
				$grafik[0][2] = 'Akumulasi Layanan';

				foreach($result as $rows){
					$grafik[$rows['bulan']][0] = $this->bulan($rows['bulan']);
					$grafik[$rows['bulan']][1] = (int) ($rows['jumlah_pelayanan']);
					$grafik[$rows['bulan']][2] = (int) ($rows['total_pelayanan']);
				}
			}else{
				echo json_encode(array('status' => false, 'data' => [])); exit;
			}
		}

		$this->cachePage(5);

		echo json_encode(array('status' => true, 'data' => $grafik, JSON_PRETTY_PRINT));
	}

	public function klpd()
	{
		$keyword = $this->request->getVar('q');
		$per_page = ($this->request->getVar('per_page')) ? $this->request->getVar('per_page') : 10;

		if($keyword){
			$result = $this->klpdModel->getPaginatedKlpdData($keyword);
		}else
			$result = $this->klpdModel->getPaginatedKlpdData();

		$currentPage = ($this->request->getVar('page_klpd')) ? $this->request->getVar('page_klpd') : 1;

		$data = [
            'title' => 'K/L/Pemda',
			//'result_grafik_layanan' => $this->klpd_grafik(),
			//'result_grafik_valuasi' => $this->klpd_grafik('grafik_valuasi'),
			'result' => $result->paginate($per_page, 'klpd'),
			'options_per_page' => $this->options_per_page(),
			'keyword' => $keyword,
			'pager' => $result->pager,
			'per_page' => $per_page,
			'currentPage' => $currentPage
		];
		
		return view('Pages/Klpd/index', $data);
	}

	public function klpd_detail($id){
		$keyword = $this->request->getVar('q');
		$tahun = ($this->request->getVar('tahun')) ? $this->request->getVar('tahun') : date('Y');
		$per_page = ($this->request->getVar('per_page')) ? $this->request->getVar('per_page') : 10;

		$result = $this->klpdModel->getKlpd($id);

		if($keyword)
			$result_satuan_kerja = $this->satuanKerjaModel->getPaginatedSatuanKerjaData($result['klpd_id'], $keyword);
		else
			$result_satuan_kerja = $this->satuanKerjaModel->getPaginatedSatuanKerjaData($result['klpd_id']);;

		$currentPage = ($this->request->getVar('page_satuan_kerja')) ? $this->request->getVar('page_satuan_kerja') : 1;
		
		$data = [
			'title' => 'Detail K/L/Pemda',
			'result' => $result,
			'result_satuan_kerja' => $result_satuan_kerja->paginate($per_page, 'satuan_kerja'),
			'options_per_page' => $this->options_per_page(),
			'keyword' => $keyword,
			'pager' => $result_satuan_kerja->pager,
			'per_page' => $per_page,
			'currentPage' => $currentPage,
			'tahun' => $tahun,
			'id' => $result['klpd_id'],
			'options_tahun_layanan' => $this->options_tahun_layanan(),
			'result_jenis_advokasi' => $this->pelayananModel->getJenisAdvokasiByKlpdId($result['klpd_id']),
			'result_kegiatan' => $this->pelayananModel->getKegiatanByKlpdId($result['klpd_id'])
		];

		//echo "<pre>"; print_r($data['result_kegiatan']); exit;

		if(empty($data['result'])){
			throw new \CodeIgniter\Exceptions\PageNotFoundException('K/L/Pemda dengan ID ' . $id . ' tidak ditemukan.');
		}

		return view('Pages/Klpd/detail', $data);
	}
	
	public function klpd_grafik($param = ''){
		$result = $this->klpdModel->getKlpd();

		$grafik = [];

		if($result){
			if($param == 'grafik_valuasi'){
				$grafik[0][0] = 'Nama';
				$grafik[0][1] = 'Jumlah Valuasi';

				$total = 0;
				
				foreach($result as $key => $rows){
					
					$grafik[$key + 1][0] = $rows['nama_klpd'];
					$grafik[$key + 1][1] = (double) ($rows['jumlah_valuasi']/1000000);

					if($rows['jumlah_valuasi']){
						$total = $total + 1;
					}
				}

				if($total < 1)
					return false;
			}else{
				$grafik[0][0] = 'Nama';
				$grafik[0][1] = 'Jumlah Layanan';

				$total = 0;
				
				foreach($result as $key => $rows){
					$grafik[$key + 1][0] = $rows['nama_klpd'];
					$grafik[$key + 1][1] = (int) $rows['jumlah_pelayanan'];

					if($rows['jumlah_valuasi']){
						$total = $total + 1;
					}
				}

				if($total < 1)
					return false;
			}

			return json_encode($grafik, JSON_PRETTY_PRINT);
		}

		return false;
	}

	public function satuan_kerja()
	{
		$arr = $this->satuanKerjaModel->getSatuanKerja();

		$data = [
            'title' => 'Satuan Kerja',
            'result' => $arr
		];

		return view('Pages/SatuanKerja/index', $data);
	}

	public function klpd_ajax($klpd_nama)
	{	
		$result = $this->klpdModel->klpdByName($klpd_nama);

		echo json_encode($result, JSON_PRETTY_PRINT);
	}

	public function satuan_kerja_ajax($klpd_id)
	{
		$result = $this->satuanKerjaModel->getSatuanKerjaByKlpdId($klpd_id);

		echo json_encode($result, JSON_PRETTY_PRINT);
	}

	public function satuan_kerja_detail($klpd_id, $satuan_kerja_id){
		$data = [
			'title' => 'Detail Satuan Kerja',
			'klpd_id' => $klpd_id,
			'result' => $this->satuanKerjaModel->getSatuanKerja($satuan_kerja_id)
		];

		if(empty($data['result'])){
			throw new \CodeIgniter\Exceptions\PageNotFoundException('Satuan kerja dengan ID ' . $satuan_kerja_id . ' tidak ditemukan.');
		}

		return view('Pages/SatuanKerja/detail', $data);
	}

	public function jenis_pengadaan()
	{
		$keyword = $this->request->getVar('q');
		$tahun = ($this->request->getVar('tahun')) ? $this->request->getVar('tahun') : ''; //date('Y');
		$per_page = ($this->request->getVar('per_page')) ? $this->request->getVar('per_page') : 10;

		if($tahun || $keyword){
			$result = $this->jenisPengadaanModel->getPaginatedJenisPengadaanData($tahun, $keyword);
		}else
			$result = $this->jenisPengadaanModel->getPaginatedJenisPengadaanData();

		$currentPage = ($this->request->getVar('page_jenis_pengadaan')) ? $this->request->getVar('page_jenis_pengadaan') : 1;

		$data = [
            'title' => 'Jenis Barang/Jasa',
			'result_grafik_layanan' => $this->jenis_pengadaan_grafik(),
			'result_grafik_valuasi' => $this->jenis_pengadaan_grafik('grafik_valuasi'),
			'result' => $result->paginate($per_page, 'jenis_pengadaan'),
			'options_tahun' => $this->options_tahun_layanan(),
			'options_per_page' => $this->options_per_page(),
			'keyword' => $keyword,
			'tahun' => $tahun,
			'pager' => $result->pager,
			'per_page' => $per_page,
			'currentPage' => $currentPage
		];
    
		return view('Pages/JenisPengadaan/index', $data);
	}

	public function jenis_pengadaan_detail($id){
		$jenis_klpd = $this->request->getVar('jenis_klpd');
		$tahun = ($this->request->getVar('tahun')) ? $this->request->getVar('tahun') : date('Y');
		
		$data = [
			'title' => 'Detail Jenis Pengadaan',
			'result' => $this->jenisPengadaanModel->getJenisPengadaan($id),
			'jenis_klpd' => $jenis_klpd,
			'tahun' => $tahun,
			'id' => $id,
			'options_jenis_klpd' => $this->options_jenis_klpd_extra(),
			'options_tahun_layanan' => $this->options_tahun_layanan(),
		];

		if(empty($data['result'])){
			throw new \CodeIgniter\Exceptions\PageNotFoundException('Jenis pengadaan dengan ID ' . $id . ' tidak ditemukan.');
		}

		return view('Pages/JenisPengadaan/detail', $data);
	}

	public function jenis_pengadaan_grafik($param = ''){
		$result = $this->jenisPengadaanModel->getJenisPengadaan();

		$grafik = [];

		if($result){
			if($param == 'grafik_valuasi'){
				$grafik[0][0] = 'Nama';
				$grafik[0][1] = 'Jumlah Valuasi';

				$total = 0;
				
				foreach($result as $key => $rows){
					$grafik[$key + 1][0] = $rows['nama_jenis_pengadaan'];
					$grafik[$key + 1][1] = (double) ($rows['jumlah_valuasi']/1000000);
					
					if($rows['jumlah_valuasi']){
						$total = $total + 1;
					}
				}

				if($total < 1)
					return false;
			}else{
				$grafik[0][0] = 'Nama';
				$grafik[0][1] = 'Jumlah Layanan';

				$total = 0;

				foreach($result as $key => $rows){
					$grafik[$key + 1][0] = $rows['nama_jenis_pengadaan'];
					$grafik[$key + 1][1] = (int) $rows['jumlah_pelayanan'];

					if($rows['jumlah_pelayanan']){
						$total = $total + 1;
					}
				}

				if($total < 1)
					return false;
			}

			return json_encode($grafik, JSON_PRETTY_PRINT);
		}

		return false;
	}

	public function ubah_password($id){
		$data = [
			'title' => 'Form Ubah Data Password',
			'validation' => \Config\Services::validation(),
			'result' => [
				"id" => $id
			]
		];

		return view('Pages/Profil/edit_password', $data);
	}

	public function ubah_password_update($id){
		if(permission(['ADMINISTRATOR'])){
			$rules['username'] = [
				'rules' => 'required|exist_username_user',
				'errors' => [
					'required' => 'Username harus diisi.',
					'exist_username_user' => 'Username/Email tidak ditemukan'
				]
			];
		}

		if(permission(['ADMIN_CONTENT'])){
			$rules['password_lama'] = [
				'rules' => 'required|valid_password',
				'errors' => [
					'required' => 'Kata sandi lama harus diisi.',
					'valid_password' => 'Kata sandi tidak ditemukan.'
				]
			];

			$rules['repassword_lama'] = [
				'rules' => 'required|matches[password_lama]',
				'errors' => [
					'required' => 'Ulangi kata sandi lama harus diisi.',
					'matches' => 'Kata sandi lama yang diulang tidak sama'
				]
			];
		}

		$rules['password'] = [
			'rules' => 'required|min_length[10]',
			'errors' => [
				'required' => 'Kata sandi harus diisi.',
				'min_length' => 'Kata sandi anda terlalu pendek.'
			]
		];

		$rules['repassword'] = [
			'rules' => 'required|min_length[10]|matches[password]',
			'errors' => [
				'required' => 'Ulangi kata sandi harus diisi.',
				'min_length' => 'Ulangi kata sandi anda terlalu pendek.',
				'matches' => 'Kata sandi yang diulang tidak sama'
			]
		];

		if(!$this->validate($rules)){

			$validation = \Config\Services::validation();
			return redirect()->to('/pages/ubah-kata-sandi/' . $id)->withInput()->with('validation', $validation);
		}

		$pass = $this->setPassword($this->request->getVar('password'));

		if(permission(['ADMINISTRATOR'])){
			$result = $this->userModel->getUserByUsername($this->request->getVar('username'));
			$user_id = $result['id'];
		}

		$this->userModel->save([
			'id' => (permission(['ADMINISTRATOR'])) ? $user_id : $id,
			'salt' => $pass['salt'],
			'password' => $pass['password'],
		]);
		
		session()->setFlashdata('pesan', 'Data berhasil diubah.');
		
		return redirect()->to('/pages/ubah-kata-sandi/' . $id);
	}

	public function profil($id){
		$data = [
			'title' => 'Form Ubah Data Profil',
			'validation' => \Config\Services::validation(),
			'result' => $this->userModel->getUser($id)
		];

		return view('Pages/Profil/edit', $data);
	}

	public function profil_update($id){
		if(!$this->validate([
			'nama_depan' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'Nama depan harus diisi.'
				]
			],
			'nama_belakang' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'Nama belakang harus diisi.'
				]
			],
			'email' => [
				'rules' => "required|valid_email|is_unique[user.email,id,$id]",
				'errors' => [
					'required' => 'Email harus diisi.',
					'valid_email' => 'Silakan periksa format email anda.',
					'is_unique' => 'Email anda harus bernilai unik.'
				]
			],
			'nomor_telepon' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'Nomor telepon harus diisi.'
				]
			]
		])){

			$validation = \Config\Services::validation();
			return redirect()->to('/pages/profil/' . $id)->withInput()->with('validation', $validation);
		}

		$save = [
			'id' => $id,
			'nama_depan' => $this->request->getVar('nama_depan'),
			'nama_belakang' => $this->request->getVar('nama_belakang'),
			'email' => $this->request->getVar('email'),
			'nomor_telepon' => str_replace("-", "", $this->request->getVar('nomor_telepon')),
			'jabatan' => $this->request->getVar('jabatan')
		];

		//echo "<pre>"; print_r($save); exit;

		$this->userModel->save($save);

		$newdata = [
			'nama_lengkap'  => $save['nama_depan'] . " " . $save['nama_belakang'],
			'email'         => $save['email']
		];

		$this->session->set($newdata);
		
		session()->setFlashdata('pesan', 'Data berhasil diubah.');
		
		return redirect()->to('/pages/profil/' . $id);
	}
}
