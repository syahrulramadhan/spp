<?php namespace App\Controllers;

use App\Models\KegiatanModel;
use App\Models\KegiatanMateriModel;
use App\Models\KegiatanNarasumberModel;
use App\Models\KlpdModel;
use App\Models\JenisAdvokasiModel;
use App\Models\PelayananModel;

class Kegiatan extends BaseController
{
	protected $kegiatanModel;
	protected $kegiatanMateriModel;
	protected $kegiatanNarasumberModel;
	protected $klpdModel;
	protected $jenisAdvokasiModel;
	protected $pelayananModel;

	public function __construct()
	{
		$this->kegiatanModel = new KegiatanModel();
		$this->kegiatanMateriModel = new KegiatanMateriModel();
		$this->kegiatanNarasumberModel = new KegiatanNarasumberModel();
		$this->klpdModel = new KlpdModel();
		$this->jenisAdvokasiModel = new JenisAdvokasiModel();
		$this->pelayananModel = new PelayananModel();

		helper(['form', 'url']);
	}

	public function index()
	{
		$keyword = $this->request->getVar('q');
		
		if($keyword){
			$result = $this->kegiatanModel->getPaginatedKegiatanData($keyword);
		}else
			$result = $this->kegiatanModel->getPaginatedKegiatanData();

		$currentPage = ($this->request->getVar('page_kegiatan')) ? $this->request->getVar('page_kegiatan') : 1;
		$per_page = 10;

		$data = [
            'title' => 'Kegiatan',
            'result' => $result->paginate($per_page, 'kegiatan'),
			'keyword' => $keyword,
			'pager' => $result->pager,
			'per_page' => $per_page,
			'currentPage' => $currentPage
        ];
        
        return view('Kegiatan/index', $data);
    }
    
    public function create($jenis_advokasi_id){
		$jenis_advokasi = $this->jenisAdvokasiModel->getJenisAdvokasi($jenis_advokasi_id);

		$data = [
			'title' => 'Form Tambah Data Kegiatan',
			'validation' => \Config\Services::validation(),
			'result' => $jenis_advokasi
		];

		return view('Kegiatan/create', $data);
	}

	public function save($jenis_advokasi_id){
		$rules['jenis_advokasi_id'] = [
			'rules' => 'required',
			'errors' => [
				'required' => 'Jenis advokasi harus diisi.'
			]
		];

		$rules['jenis_advokasi_nama'] = [
			'rules' => 'required',
			'errors' => [
				'required' => 'Jenis advokasi harus diisi.'
			]
		];

		$rules['nama_kegiatan'] = [
			'rules' => 'required|min_length[5]',
			'errors' => [
				'required' => 'Nama kegiatan harus diisi.',
				'min_length' => 'Nama kegiatan anda terlalu pendek?'
			]
		];

		$rules['tanggal_pelaksanaan'] = [
			'rules' => 'required',
			'errors' => [
				'required' => 'Tanggal pelaksanaan kegiatan harus diisi.'
			]
		];

		$rules['nama_narasumber'] = [
			'rules' => 'required',
			'errors' => [
				'required' => 'Narasumber 1 harus diisi.'
			]
		];

		/*
		$rules['kegiatan_file'] = [
			'rules' => 'mime_in[kegiatan_file,image/jpg,image/jpeg,image/png]|max_size[kegiatan_file,2048]',
			'errors' => [
				'mime_in' => 'Format file ini tidak didukung',
				'max_size' => 'Ukuran file lebih besar dari 2 MB'
			]
		];
		*/

		if(in_array($jenis_advokasi_id, array(8))){
			$rules['tahapan'] = [
				'rules' => 'required',
				'errors' => [
					'required' => 'Tahapan harus diisi.'
				]
			];
		}
		
		if(!$this->validate($rules)){

			$validation = \Config\Services::validation();
			return redirect()->to("/kegiatan/create/$jenis_advokasi_id")->withInput()->with('validation', $validation);
		}

		$save = [
			'nama_kegiatan' => $this->request->getVar('nama_kegiatan'),
			'tanggal_pelaksanaan' => $this->dateOutput($this->request->getVar('tanggal_pelaksanaan')),
			'jenis_advokasi_id' => $this->request->getVar('jenis_advokasi_id'),
			'jenis_advokasi_nama' => $this->request->getVar('jenis_advokasi_nama'),
			'tahapan' => $this->request->getVar('tahapan'),
			'created_by' => session('id')
		];

		$kegiatan_id = $this->kegiatanModel->store($save);

		if($kegiatan_id){
			if($this->request->getVar('nama_narasumber')){
				$this->kegiatanNarasumberModel->save([
					'kegiatan_id' => $kegiatan_id,
					'nama_narasumber' => $this->request->getVar('nama_narasumber')
				]);
			}

			if($this->request->getVar('nama_narasumber_second')){
				$this->kegiatanNarasumberModel->save([
					'kegiatan_id' => $kegiatan_id,
					'nama_narasumber' => $this->request->getVar('nama_narasumber_second')
				]);
			}

			if($file = $this->request->getFiles()){
				foreach($file['kegiatan_file'] as $dok){
					if ($dok->isValid() && ! $dok->hasMoved()){
							
						$name = $dok->getRandomName();
						$type = $dok->getClientMimeType();
						$size = $dok->getSize();
							
						$dok->move(ROOTPATH . 'public/uploads/kegiatan', $name);

						$this->kegiatanMateriModel->save([
							'kegiatan_id' => $kegiatan_id,
							'label_materi' => $dok->getName(),
							'nama_materi' => $name,
							'size' => $size,
							'type' => $type,
							'created_by' => session('id')
						]);
					}
				}
			}
		}
		
		session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');
		
		return redirect()->to("/kegiatan/$kegiatan_id");
	}

	public function detail($id){
		$result = $this->kegiatanModel->getKegiatan($id);
		
		$result['tanggal_pelaksanaan'] = $this->tanggalid($result['tanggal_pelaksanaan']);

		$data = [
			'title' => 'Detail Kegiatan',
			'result' => $result,
			'result_materi' => $this->kegiatanMateriModel->getMateriByKegiatanId($id),
			'result_narasumber' => $this->kegiatanNarasumberModel->getNarasumberByKegiatanId($id),
		];

		if(empty($data['result'])){
			throw new \CodeIgniter\Exceptions\PageNotFoundException('Kegiatan dengan ID ' . $id . ' tidak ditemukan.');
		}

		return view('Kegiatan/detail', $data);
	}

	public function edit($id){
		$result = $this->kegiatanModel->getKegiatan($id);
		
		$result['tanggal_pelaksanaan'] = $this->dateInput($result['tanggal_pelaksanaan']);

		$data = [
			'title' => 'Form Edit Data Kegiatan',
			'validation' => \Config\Services::validation(),
			'result' => $result
		];

		return view('Kegiatan/edit', $data);
	}

	public function update($id){
		if(!$this->validate([
			'nama_kegiatan' => [
				'rules' => 'required|min_length[5]',
				'errors' => [
					'required' => 'Nama kegiatan harus diisi.',
					'min_length' => 'Nama kegiatan anda terlalu pendek?'
				]
			],
			'tanggal_pelaksanaan' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'Tanggal pelaksanaan kegiatan harus diisi.'
				]
			]
		])){

			$validation = \Config\Services::validation();
			return redirect()->to('/kegiatan/edit/' . $id)->withInput()->with('validation', $validation);
		}

		$this->kegiatanModel->save([
			'id' => $id,
			'nama_kegiatan' => $this->request->getVar('nama_kegiatan'),
			'tanggal_pelaksanaan' => $this->dateOutput($this->request->getVar('tanggal_pelaksanaan'))
		]);
		
		session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');
		
		return redirect()->to('/kegiatan/edit/' . $id);
	}

	public function delete($id){
		$result = $this->kegiatanModel->find($id);

		if($result){
			$this->kegiatanModel->delete($id);

			session()->setFlashdata('pesan', 'Data berhasil dihapus.');

			return redirect()->to('/kegiatan');
		}
	}

	public function pelayanan($kegiatan_id, $jenis_advokasi_id){
		$result = $this->pelayananModel->getPelayananByKegiatanId($kegiatan_id);
		$result_kegiatan = $this->kegiatanModel->getKegiatan($kegiatan_id);
		$result_jenis_advokasi = $this->jenisAdvokasiModel->getJenisAdvokasi($jenis_advokasi_id);

		//echo "<pre>"; print_r($result); exit;
		
        $data = [
			'title' => 'Form Tambah Data Advokasi ' . $result_jenis_advokasi['nama_jenis_advokasi'],
			'options_klpd' => $this->options_klpd(),
			'validation' => \Config\Services::validation(),
			'result' => $result,
			'kegiatan_id' => $result_kegiatan['id'],
			'jenis_advokasi_id' => $result_jenis_advokasi['id'],
			'nama_jenis_advokasi' => $result_jenis_advokasi['nama_jenis_advokasi'],
		];

		return view('Kegiatan/pelayanan_index', $data);
	}

	public function pelayanan_save($kegiatan_id, $jenis_advokasi_id){
		$result = $this->kegiatanModel->getKegiatan($kegiatan_id);

		$rules['jenis_advokasi_id'] = [
			'rules' => 'required',
			'errors' => [
				'required' => 'Jenis advokasi harus diisi.'
			]
		];

		$rules['jenis_advokasi_nama'] = [
			'rules' => 'required',
			'errors' => [
				'required' => 'Jenis advokasi harus diisi.'
			]
		];

		if(! $this->request->getVar('klpd_id')){
			$rules['klpd_nama_lainnya'] = [
				'rules' => 'required',
				'errors' => [
					'required' => "Instansi lainnya harus diisi"
				]
			];
		}else{
			$rules['klpd_id'] = [
				'rules' => 'required',
				'errors' => [
					'required' => 'K/L/Pemda harus diisi.'
				]
			];

			$rules['kd_satker'] = [
				'rules' => 'required',
				'errors' => [
					'required' => 'Satuan kerja harus diisi.'
				]
			];
		}

		if(!$this->validate($rules)){

			$validation = \Config\Services::validation();
			return redirect()->to("/kegiatan/$kegiatan_id/$jenis_advokasi_id/pelayanan")->withInput()->with('validation', $validation);
		}

		$save = [
			'kegiatan_id' => $kegiatan_id,
			'tanggal_pelaksanaan' => $result['tanggal_pelaksanaan'],
			'jenis_advokasi_id' => $this->request->getVar('jenis_advokasi_id'),
			'jenis_advokasi_nama' => $this->request->getVar('jenis_advokasi_nama'),
			'klpd_id' => $this->request->getVar('klpd_id'),
			'satuan_kerja_id' => $this->request->getVar('kd_satker'),
			'klpd_nama_lainnya' => $this->request->getVar('klpd_nama_lainnya'),
			'keterangan' => $this->request->getVar('keterangan'),
			'created_by' => session('id')
		];

		//echo "<pre>"; print_r($save); exit;

		$this->pelayananModel->save($save);
		
		session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');
		
		return redirect()->to("/kegiatan/$kegiatan_id/$jenis_advokasi_id/pelayanan");
	}

	public function options_klpd(){
		$arr = new KlpdModel();

		$result = ['' => '--Pilih--'];

		foreach ($arr->getKlpd() as $row){
			$result[$row['klpd_id']] = $row['nama_klpd'];
		}

		return $result;
	}

	public function pelayanan_delete($kegiatan_id, $jenis_advokasi_id, $id){
		$result = $this->pelayananModel->find($id);

		if($result){
			$this->pelayananModel->delete($id);

			session()->setFlashdata('pesan', 'Data berhasil dihapus.');

			return redirect()->to("/kegiatan/$kegiatan_id/$jenis_advokasi_id/pelayanan");
		}
	}
}