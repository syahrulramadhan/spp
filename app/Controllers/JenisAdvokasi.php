<?php namespace App\Controllers;

use App\Models\JenisAdvokasiModel;
use App\Models\GrafikModel;
use App\Models\KlpdModel;
use App\Models\PelayananModel;

class JenisAdvokasi extends BaseController
{
	protected $jenisAdvokasiModel;
	protected $grafikModel;
	protected $klpdModel;
	protected $pelayananModel;
	

	public function __construct()
	{
		$this->jenisAdvokasiModel = new JenisAdvokasiModel();
		$this->grafikModel = new GrafikModel();
		$this->klpdModel = new KlpdModel();
		$this->pelayananModel = new PelayananModel();

		helper(['form', 'url']);
	}

	public function index()
	{
		$keyword = $this->request->getVar('q');
		$per_page = ($this->request->getVar('per_page')) ? $this->request->getVar('per_page') : 10;

		if($keyword){
			$result = $this->jenisAdvokasiModel->getPaginatedJenisAdvokasiData('', $keyword);
		}else
			$result = $this->jenisAdvokasiModel->getPaginatedJenisAdvokasiData();

		$currentPage = ($this->request->getVar('page_jenis_advokasi')) ? $this->request->getVar('page_jenis_advokasi') : 1;
	
		$data = [
            'title' => 'Jenis Advokasi',
			'result_grafik_layanan' => $this->grafik(),
			'result_grafik_valuasi' => $this->grafik('grafik_valuasi'),
			'result' => $result->paginate($per_page, 'jenis_advokasi'),
			'options_per_page' => $this->options_per_page(),
			'keyword' => $keyword,
			'pager' => $result->pager,
			'per_page' => $per_page,
			'currentPage' => $currentPage
		];
    
		return view('JenisAdvokasi/index', $data);
	}
	
	public function detail($id){
		$jenis_klpd = $this->request->getVar('jenis_klpd');
		$tahun = ($this->request->getVar('tahun')) ? $this->request->getVar('tahun') : date('Y');

		$data = [
			'title' => 'Detail Jenis Advokasi',
			'result' => $this->jenisAdvokasiModel->getJenisAdvokasi($id),
			'jenis_klpd' => $jenis_klpd,
			'tahun' => $tahun,
			'id' => $id,
			'options_jenis_klpd' => $this->options_jenis_klpd_extra(),
			'options_tahun_layanan' => $this->options_tahun_layanan()
		];

		if(empty($data['result'])){
			throw new \CodeIgniter\Exceptions\PageNotFoundException('Jenis advokasi dengan ID ' . $id . ' tidak ditemukan.');
		}

		return view('JenisAdvokasi/detail', $data);
	}

	public function chart($param = ""){
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
			$result = $this->grafikModel->valuasiByJenisAdvokasiId($jenis_klpd, $tahun, $id);

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
			$result = $this->grafikModel->layananByJenisAdvokasiId($jenis_klpd, $tahun, $id);

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

	public function grafik($param = ''){
		$result = $this->jenisAdvokasiModel->getJenisAdvokasi();

		$grafik = [];

		if($result){
			if($param == 'grafik_valuasi'){
				$grafik[0][0] = 'Nama';
				$grafik[0][1] = 'Jumlah Valuasi';

				$total = 0;

				foreach($result as $key => $rows){
					$grafik[$key + 1][0] = $rows['nama_jenis_advokasi'];
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
					$grafik[$key + 1][0] = $rows['nama_jenis_advokasi'];
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

	public function edit($id){
		permission_redirect(['ADMINISTRATOR']);

		$data = [
			'title' => 'Form Edit Data Jenis Advokasi',
			'validation' => \Config\Services::validation(),
			'result' => $this->jenisAdvokasiModel->getJenisAdvokasi($id)
		];

		return view('JenisAdvokasi/edit', $data);
	}

	public function update($id){
		permission_redirect(['ADMINISTRATOR']);
		
		/*
		$rules['keterangan'] = [
			'rules' => 'min_length[20]',
			'errors' => [
				'min_length' => 'Isi keterangan anda terlalu pendek?'
			]
		];
		*/

		$rules['image_jenis_advokasi'] = [
			'rules' => 'uploaded[image_jenis_advokasi]|max_size[image_jenis_advokasi,2048]|mime_in[image_jenis_advokasi,image/png,image/jpg,image/jpeg,image/gif]',
			'errors' => [
				'uploaded' => 'Gambar harus diisi',
				'max_size' => 'Maksimal upload gambar 2 MB',
				'mime_in' => 'Upload gambar yang memiliki ekstensi .jpeg/.jpg/.png/.gif'
			]
		];

		if(!$this->validate($rules)){
			$validation = \Config\Services::validation();
			return redirect()->to("/jenis-advokasi/edit/$id")->withInput()->with('validation', $validation);
		}
		
		// get file
		$image = $this->request->getFile('image_jenis_advokasi');
		// random name file
		$name = $image->getRandomName();

		$image->move(ROOTPATH . 'public/uploads/jenis-advokasi', $name);

		$this->jenisAdvokasiModel->save([
			'id' => $id,
			//'keterangan' => $this->request->getVar('keterangan'),
			'image_jenis_advokasi' => $name,
			'created_by' => session('id')
		]);
		
		session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');
		
		return redirect()->to("/jenis-advokasi/edit/$id");
	}
}