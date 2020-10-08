<?php namespace App\Controllers;

use App\Models\KategoriPermasalahanModel;
use App\Models\GrafikModel;
use App\Models\KlpdModel;
use App\Models\PelayananModel;

class KategoriPermasalahan extends BaseController
{
	protected $kategoriPermasalahanModel;
	protected $grafikModel;
	protected $klpdModel;
	protected $pelayananModel;

	public function __construct()
	{
		$this->kategoriPermasalahanModel = new KategoriPermasalahanModel();
		$this->grafikModel = new GrafikModel();
		$this->klpdModel = new KlpdModel();
		$this->pelayananModel = new PelayananModel();
		helper(['form', 'url']);
	}

	public function index()
	{
		$keyword = $this->request->getVar('q');

		if($keyword){
			$result = $this->kategoriPermasalahanModel->getPaginatedKategoriPermasalahanData($keyword);
		}else
			$result = $this->kategoriPermasalahanModel->getPaginatedKategoriPermasalahanData();

		$currentPage = ($this->request->getVar('page_kategori_permasalahan')) ? $this->request->getVar('page_kategori_permasalahan') : 1;
		$per_page = 10;

		$data = [
            'title' => 'Kategori Permasalahan',
			'result_grafik_layanan' => $this->grafik(),
			'result_grafik_valuasi' => $this->grafik('grafik_valuasi'),
			'result' => $result->paginate($per_page, 'kategori_permasalahan'),
			'keyword' => $keyword,
			'pager' => $result->pager,
			'per_page' => $per_page,
			'currentPage' => $currentPage
        ];
        
        return view('KategoriPermasalahan/index', $data);
	}
	
	public function grafik($param = ''){
		$result = $this->kategoriPermasalahanModel->getKategoriPermasalahan();

		

		$grafik = [];

		if($result){
			if($param == 'grafik_valuasi'){
				$grafik[0][0] = 'NAMA';
				$grafik[0][1] = 'JUMLAH VALUASI';

				$total = 0;
				
				foreach($result as $key => $rows){
					if($rows['jumlah_valuasi']){
						$grafik[$key + 1][0] = $rows['nama_kategori_permasalahan'];
						$grafik[$key + 1][1] = (double) ($rows['jumlah_valuasi']);

						$total = $total + 1;
					}
				}

				//echo "<pre>"; print_r((array) $grafik); exit;

				if($total < 1)
					return false;
			}else{
				$grafik[0][0] = 'NAMA';
				$grafik[0][1] = 'JUMLAH LAYANAN';

				$total = 0;

				foreach($result as $key => $rows){
					if($rows['jumlah_pelayanan']){
						$grafik[$key + 1][0] = $rows['nama_kategori_permasalahan'];
						$grafik[$key + 1][1] = (int) $rows['jumlah_pelayanan'];
					
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

	public function detail($id){
		$jenis_klpd = $this->request->getVar('jenis_klpd');
		$tahun = ($this->request->getVar('tahun')) ? $this->request->getVar('tahun') : date('Y');
		
		$data = [
			'title' => 'Detail Kategori Permasalahan',
			'result' => $this->kategoriPermasalahanModel->getKategoriPermasalahan($id),
			'jenis_klpd' => $jenis_klpd,
			'tahun' => $tahun,
			'options_jenis_klpd' => $this->options_jenis_klpd(),
			'options_tahun_layanan' => $this->options_tahun_layanan(),
			'result_chart_pelayanan' => $this->chart('chart_layanan', $jenis_klpd, $tahun, $id),
			'result_chart_valuasi' => $this->chart('chart_valuasi', $jenis_klpd, $tahun, $id)
		];

		if(empty($data['result'])){
			throw new \CodeIgniter\Exceptions\PageNotFoundException('Kategori permasalahan dengan ID ' . $id . ' tidak ditemukan.');
		}

		return view('KategoriPermasalahan/detail', $data);
	}

	public function chart($param = "", $jenis_klpd, $tahun, $id){
		$grafik[0][0] = "";
		$grafik[0][1] = "";
		$grafik[0][2] = "";

		for($i=1;$i<=12;$i++){
			$grafik[$i][0] = $this->bulan($i);
			$grafik[$i][1] = 0;
			$grafik[$i][2] = 0;
		}

		if($param == 'chart_valuasi'){
			$result = $this->grafikModel->valuasiByKetegoriPermasalahabId($jenis_klpd, $tahun, $id);

			if($result){
				$grafik[0][0] = 'BULAN';
				$grafik[0][1] = 'JUMLAH VALUASI';
				$grafik[0][2] = 'AKUMULASI VALUASI';

				foreach($result as $rows){
					$grafik[$rows['bulan']][0] = $this->bulan($rows['bulan']);
					$grafik[$rows['bulan']][1] = (double) ($rows['jumlah_valuasi']/1000000);
					$grafik[$rows['bulan']][2] = (double) ($rows['total_valuasi']/1000000);
				}
			}else{
				return false;
			}
		}else{
			$result = $this->grafikModel->layananByKetegoriPermasalahabId($jenis_klpd, $tahun, $id);

			if($result){
				$grafik[0][0] = 'BULAN';
				$grafik[0][1] = 'JUMLAH LAYANAN';
				$grafik[0][2] = 'AKUMULASI LAYANAN';

				foreach($result as $rows){
					$grafik[$rows['bulan']][0] = $this->bulan($rows['bulan']);
					$grafik[$rows['bulan']][1] = (int) ($rows['jumlah_pelayanan']);
					$grafik[$rows['bulan']][2] = (int) ($rows['total_pelayanan']);
				}
			}else{
				return false;
			}
		}

		return json_encode($grafik, JSON_PRETTY_PRINT);
	}

	public function create(){
		$data = [
			'title' => 'Form Tambah Data Kategori Permasalahan',
			'validation' => \Config\Services::validation()
		];

		return view('KategoriPermasalahan/create', $data);
	}

	public function save(){
		if(!$this->validate([
			'nama_kategori_permasalahan' => [
				'rules' => 'required|min_length[5]',
				'errors' => [
					'required' => 'Nama kategori permasalahan harus diisi.',
					'min_length' => 'Nama kategori permasalahan anda terlalu pendek?'
				]
				],
				'keterangan' => [
					'rules' => 'min_length[20]',
					'errors' => [
						'min_length' => 'Keterangan anda terlalu pendek?'
					]
				]
		])){

			$validation = \Config\Services::validation();
			return redirect()->to('/kategori-permasalahan/create')->withInput()->with('validation', $validation);
		}

		$this->kategoriPermasalahanModel->save([
			'nama_kategori_permasalahan' => $this->request->getVar('nama_kategori_permasalahan'),
			'keterangan' => $this->request->getVar('keterangan'),
			'created_by' => session('id')
		]);
		
		session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');
		
		return redirect()->to('/kategori-permasalahan');
	}

	public function edit($id){
		$data = [
			'title' => 'Form Edit Data Kategori Permasalahan',
			'validation' => \Config\Services::validation(),
			'result' => $this->kategoriPermasalahanModel->getKategoriPermasalahan($id)
		];

		return view('KategoriPermasalahan/edit', $data);
	}

	public function update($id){
		if(!$this->validate([
			'nama_kategori_permasalahan' => [
				'rules' => 'required|min_length[5]',
				'errors' => [
					'required' => 'Nama kategori permasalahan harus diisi.',
					'min_length' => 'Nama kategori permasalahan anda terlalu pendek?'
				]
				],
				'keterangan' => [
					'rules' => 'min_length[20]',
					'errors' => [
						'min_length' => 'Keterangan anda terlalu pendek?'
					]
				]
		])){

			$validation = \Config\Services::validation();
			return redirect()->to('/kategori-permasalahan/edit/' . $id)->withInput()->with('validation', $validation);
		}

		$this->kategoriPermasalahanModel->save([
			'id' => $id,
			'nama_kategori_permasalahan' => $this->request->getVar('nama_kategori_permasalahan'),
			'keterangan' => $this->request->getVar('keterangan')
		]);
		
		session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');
		
		return redirect()->to('/kategori-permasalahan/edit/' . $id);
	}

	public function delete($id){
		$result = $this->kategoriPermasalahanModel->find($id);

		if($result){
			$this->kategoriPermasalahanModel->delete($id);

			session()->setFlashdata('pesan', 'Data berhasil dihapus.');

			return redirect()->to('/kategori-permasalahan');
		}
	}
}