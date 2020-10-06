<?php namespace App\Controllers;

use App\Models\JenisAdvokasiModel;
use App\Models\JenisPengadaanModel;
use App\Models\KategoriPermasalahanModel;
use App\Models\KlpdModel;
use App\Models\PelayananModel;
use App\Models\PelayananFileModel;
use App\Models\PelayananPesertaModel;
use App\Models\PelayananPicModel;
use App\Models\SatuanKerjaModel;
use App\Models\PicModel;

class Pelayanan extends BaseController
{
	protected $jenisAdvokasiModel;
	protected $pelayananModel;
	protected $pelayananFileModel;
	protected $pelayananPesertaModel;
	protected $pelayananPicModel;
	protected $picModel;

	public function __construct()
	{
		$this->jenisAdvokasiModel = new JenisAdvokasiModel();
		$this->pelayananModel = new PelayananModel();
		$this->pelayananFileModel = new PelayananFileModel();
		$this->pelayananPesertaModel = new PelayananPesertaModel();
		$this->pelayananPicModel = new PelayananPicModel();
		$this->picModel = new picModel();

		helper('form');
	}

	public function index()
	{
		//$listJenisAdvokasi = $this->jenisAdvokasiModel->getList();
		
		$keyword = $this->request->getVar('q');

		if($keyword){
			$pelayanan = $this->pelayananModel->search($keyword);
		}else
			$pelayanan = $this->pelayananModel;

		$currentPage = ($this->request->getVar('page_pelayanan')) ? $this->request->getVar('page_pelayanan') : 1;
		$per_page = 10;

		$data = [
            'title' => 'Pelayanan',
			'result' => $pelayanan->paginate($per_page, 'pelayanan'),
			//'list_jenis_advokasi' => $listJenisAdvokasi,
			'keyword' => $keyword,
			'pager' => $this->pelayananModel->pager,
			'per_page' => $per_page,
			'currentPage' => $currentPage
		];

		return view('Pelayanan/index', $data);
	}

	public function jenis_advokasi()
	{
		$data = [
            'title' => 'Layanan',
            'jenis_advokasi_all' => $this->jenisAdvokasiModel->getJenisAdvokasi()
        ];

		return view('Pelayanan/index_jenis_advokasi', $data);
    }

    public function create($id){
		$jenis_advokasi = $this->jenisAdvokasiModel->getJenisAdvokasi($id);

        $data = [
			'title' => 'Form ' . $jenis_advokasi['nama_jenis_advokasi'],
			'options_klpd' => $this->options_klpd(),
			//'options_satuan_kerja' => $this->options_satuan_kerja(),
			'options_pic' => $this->options_pic(),
			'options_jenis_pengadaan' => $this->options_jenis_pengadaan(),
			'options_kategori_permasalahan' => $this->options_kategori_permasalahan(),
			'validation' => \Config\Services::validation(),
			'result' => $jenis_advokasi
		];

		return view('Pelayanan/create', $data);
	}

	public function options_pic(){
		$arr = $this->picModel->getPic();

		$result = ['' => '--Pilih--'];

		foreach ($arr as $row){
			$result[$row['id']] = $row['nama_depan'] . " " . $row['nama_belakang'];
		}

		return $result;
    }

	public function save($id){
		if(in_array($id, array(1,2,3,4,5,6,7))){
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

			if(in_array($id, array(1))){
				$rules['nomor_surat_keluar'] = [
					'rules' => 'required',
					'errors' => [
						'required' => 'Nomor surat keluar harus diisi.'
					]
				];
			}

			if(in_array($id, array(6,7))){
				$rules['nama'] = [
					'rules' => 'required',
					'errors' => [
						'required' => 'Nama harus diisi.'
					]
				];

				$rules['keterangan'] = [
					'rules' => 'required',
					'errors' => [
						'required' => 'Keterangan harus diisi.'
					]
				];
			}

			if(in_array($id, array(1,2,6,7))){
				$rules['jabatan'] = [
					'rules' => 'required',
					'errors' => [
						'required' => 'Jabatan harus diisi.'
					]
				];
			}
			
			if(in_array($id, array(4,5))){
				$rules['paket_nama'] = [
					'rules' => 'required',
					'errors' => [
						'required' => 'Nama paket harus diisi.'
					]
				];

				$rules['paket_nilai_pagu'] = [
					'rules' => 'required',
					'errors' => [
						'required' => 'Nilai paket harus diisi.'
					]
				];
			}

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

			if(in_array($id, array(1,2,3,4,5,6,7))){
				$rules['paket_jenis_pengadaan_id'] = [
					'rules' => 'required',
					'errors' => [
						'required' => 'Jenis Barang/Jasa harus diisi.'
					]
				];

				$rules['kategori_permasalahan_id'] = [
					'rules' => 'required',
					'errors' => [
						'required' => 'Ketegori permasalahan harus diisi.'
					]
				];

				$rules['pic_id'] = [
					'rules' => 'required',
					'errors' => [
						'required' => ((in_array($id, array(1,2))) ? 'Drafter 1' : 'Pic 1') . ' harus diisi.'
					]
				];

				if(in_array($id, array(1))){
					$label_tanggal = 'Tanggal Surat Keluar';
				}else if(in_array($id, array(3))){
					$label_tanggal = 'Tanggal Pertemuan ';
				}else if(in_array($id, array(4,5))){
					$label_tanggal = 'Tanggal Pelaksanaan';
				}else{
					$label_tanggal = 'Tanggal Kirim ';
				}

				$rules['tanggal_pelaksanaan'] = [
					'rules' => 'required',
					'errors' => [
						'required' => $label_tanggal . ' harus diisi.'
					]
				];

				/*
				$rules['pelayanan_file'] = [
					'rules' => 'mime_in[pelayanan_file,image/jpg,image/jpeg,image/png]|max_size[pelayanan_file,2048]',
					'errors' => [
						'mime_in' => 'Format file ini tidak didukung',
						'max_size' => 'Ukuran file lebih besar dari 2 MB'
					]
				];
				*/
			}
			
			if(!$this->validate($rules)){

				$validation = \Config\Services::validation();
				return redirect()->to('/pelayanan/create/' . $id)->withInput()->with('validation', $validation);
			}

			$nilai_pagu = ($this->request->getVar('paket_nilai_pagu')) ? str_replace(".", "", $this->request->getVar('paket_nilai_pagu')) : 0;
			
			$save = [
				'tanggal_pelaksanaan' => $this->dateOutput($this->request->getVar('tanggal_pelaksanaan')),
				'nomor_surat_keluar' => $this->request->getVar('nomor_surat_keluar'),
				'nomor_undangan' => $this->request->getVar('nomor_undangan'),
				'jenis_advokasi_id' => $this->request->getVar('jenis_advokasi_id'),
				'jenis_advokasi_nama' => $this->request->getVar('jenis_advokasi_nama'),
				'nama' => $this->request->getVar('nama'),
				'jabatan' => $this->request->getVar('jabatan'),
				'nomor_telepon' => str_replace("-", "", $this->request->getVar('nomor_telepon')),
				'klpd_id' => $this->request->getVar('klpd_id'),
				'satuan_kerja_id' => $this->request->getVar('kd_satker'),
				'klpd_nama_lainnya' => $this->request->getVar('klpd_nama_lainnya'),
				'paket_kode' => $this->request->getVar('paket_kode'),
				'paket_nama' => $this->request->getVar('paket_nama'),
				'paket_nilai_pagu' => $nilai_pagu,
				'paket_jenis_pengadaan_id' => $this->request->getVar('paket_jenis_pengadaan_id'),
				'kategori_permasalahan_id' => $this->request->getVar('kategori_permasalahan_id'),
				'keterangan' => $this->request->getVar('keterangan'),
				'created_by' => session('id')
			];

			//echo "<pre>"; print_r($save); exit;

			$pelayanan_id = $this->pelayananModel->store($save);

			if($pelayanan_id){
				if($this->request->getVar('pic_id')){
					$this->pelayananPicModel->save([
						'pelayanan_id' => $pelayanan_id,
						'pic_id' => $this->request->getVar('pic_id')
					]);
				}

				if($this->request->getVar('pic_second_id')){
					$this->pelayananPicModel->save([
						'pelayanan_id' => $pelayanan_id,
						'pic_id' => $this->request->getVar('pic_second_id')
					]);
				}

				$file = $this->request->getFile('pelayanan_file');

				if($file->isValid()){
					
					$name = $file->getRandomName();
					$type = $file->getClientMimeType();
					$size = $file->getSize();
						
					$file->move(ROOTPATH . 'public/uploads/pelayanan', $name);

					$this->pelayananFileModel->save([
						'pelayanan_id' => $pelayanan_id,
						'label_file' => $file->getName(),
						'nama_file' => $name,
						'size' => $size,
						'type' => $type,
						'created_by' => session('id')
					]);
				}
			}

			session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');
			
			return redirect()->to('/pelayanan/' . $pelayanan_id);
		}else{
			return redirect()->to('/pelayanan');
		}
	}

	public function edit($jenis_advokasi_id, $id){
		ini_set("display_errors", "1");

		$result = $this->pelayananModel->getPelayananJoin($id);

		$result['tanggal_pelaksanaan'] = $this->dateInput($result['tanggal_pelaksanaan']);

		$data = [
			'title' => 'Edit Pelayanan',
			'result' => $result,
			'options_klpd' => $this->options_klpd(),
			'options_satuan_kerja' => $this->options_satuan_kerja(),
			'options_jenis_pengadaan' => $this->options_jenis_pengadaan(),
			'options_kategori_permasalahan' => $this->options_kategori_permasalahan(),
			'validation' => \Config\Services::validation()
		];

		return view('Pelayanan/edit', $data);
	}

	public function update($jenis_advokasi_id, $id){
		if(in_array($jenis_advokasi_id, array(1,2,3,4,5,6,7))){
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

			if(in_array($jenis_advokasi_id, array(1))){
				$rules['nomor_surat_keluar'] = [
					'rules' => 'required',
					'errors' => [
						'required' => 'Nomor surat keluar harus diisi.'
					]
				];
			}

			if(in_array($jenis_advokasi_id, array(3))){
				$rules['nomor_undangan'] = [
					'rules' => 'required',
					'errors' => [
						'required' => 'Nomor undangan harus diisi.'
					]
				];
			}

			if(in_array($jenis_advokasi_id, array(4,5))){
				$rules['paket_nama'] = [
					'rules' => 'required',
					'errors' => [
						'required' => 'Nama paket harus diisi.'
					]
				];

				$rules['paket_nilai_pagu'] = [
					'rules' => 'required',
					'errors' => [
						'required' => 'Nama harus diisi.'
					]
				];
			}

			if(in_array($id, array(6,7))){
				$rules['nama'] = [
					'rules' => 'required',
					'errors' => [
						'required' => 'Nama harus diisi.'
					]
				];
			
				$rules['keterangan'] = [
					'rules' => 'required',
					'errors' => [
						'required' => 'Keterangan harus diisi.'
					]
				];
			}
			
			if(in_array($id, array(1,2,6,7))){
				$rules['jabatan'] = [
					'rules' => 'required',
					'errors' => [
						'required' => 'Jabatan harus diisi.'
					]
				];
			}

			if(in_array($id, array(1,2,3,4,5,6,7))){
				$rules['paket_jenis_pengadaan_id'] = [
					'rules' => 'required',
					'errors' => [
						'required' => 'Jenis Barang/Jasa harus diisi.'
					]
				];
			
				$rules['kategori_permasalahan_id'] = [
					'rules' => 'required',
					'errors' => [
						'required' => 'Ketegori permasalahan harus diisi.'
					]
				];
			
				if(in_array($id, array(1))){
					$label_tanggal = 'Tanggal Surat Keluar';
				}else if(in_array($id, array(3))){
					$label_tanggal = 'Tanggal Pertemuan ';
				}else if(in_array($id, array(4,5))){
					$label_tanggal = 'Tanggal Pelaksanaan';
				}else{
					$label_tanggal = 'Tanggal Kirim ';
				}
			
				$rules['tanggal_pelaksanaan'] = [
					'rules' => 'required',
					'errors' => [
						'required' => $label_tanggal . ' harus diisi.'
					]
				];
			}

			if(!$this->validate($rules)){

				$validation = \Config\Services::validation();
				return redirect()->to("/pelayanan/$jenis_advokasi_id/edit/$id")->withInput()->with('validation', $validation);
			}

			$nilai_pagu = ($this->request->getVar('paket_nilai_pagu')) ? str_replace(".", "", $this->request->getVar('paket_nilai_pagu')) : 0;
			
			$save = [
				'id' => $id,
				'tanggal_pelaksanaan' => $this->dateOutput($this->request->getVar('tanggal_pelaksanaan')),
				'nomor_surat_keluar' => $this->request->getVar('nomor_surat_keluar'),
				'nomor_undangan' => $this->request->getVar('nomor_undangan'),
				'jenis_advokasi_id' => $this->request->getVar('jenis_advokasi_id'),
				'jenis_advokasi_nama' => $this->request->getVar('jenis_advokasi_nama'),
				'nama' => $this->request->getVar('nama'),
				'jabatan' => $this->request->getVar('jabatan'),
				'nomor_telepon' => str_replace("-", "", $this->request->getVar('nomor_telepon')),
				'klpd_id' => $this->request->getVar('klpd_id'),
				'satuan_kerja_id' => $this->request->getVar('kd_satker'),
				'klpd_nama_lainnya' => $this->request->getVar('klpd_nama_lainnya'),
				'paket_kode' => $this->request->getVar('paket_kode'),
				'paket_nama' => $this->request->getVar('paket_nama'),
				'paket_nilai_pagu' => $nilai_pagu,
				'paket_jenis_pengadaan_id' => $this->request->getVar('paket_jenis_pengadaan_id'),
				'kategori_permasalahan_id' => $this->request->getVar('kategori_permasalahan_id'),
				'keterangan' => $this->request->getVar('keterangan')
			];

			//echo "<pre>"; print_r($save); exit;

			$this->pelayananModel->save($save);
			
			session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');
			
			return redirect()->to("/pelayanan/$jenis_advokasi_id/edit/$id");
		}else{
			return redirect()->to('/pelayanan');
		}
	}

	public function detail($id){
		$result = $this->pelayananModel->getPelayananJoin($id);

		$data = [
			'title' => 'Detail Pelayanan',
			'result' => $result,
			'result_file' => $this->pelayananFileModel->getFileByPelayananId($id),
			'result_peserta' => $this->pelayananPesertaModel->getPesertaByPelayananId($id),
			'result_pic' => $this->pelayananPicModel->getPicByPelayananId($id)
		];

		//echo "<pre>"; print_r($data['result_pic']); exit;

		if(empty($data['result'])){
			throw new \CodeIgniter\Exceptions\PageNotFoundException('Pelayanan dengan ID ' . $id . ' tidak ditemukan.');
		}

		return view('Pelayanan/detail', $data);
	}
	
	public function options_klpd(){
		$arr = new KlpdModel();

		$result = ['' => '--Pilih--'];

		foreach ($arr->getKlpd() as $row){
			$result[$row['klpd_id']] = $row['nama_klpd'];
		}

		return $result;
	}

	public function options_satuan_kerja(){
		$arr = new SatuanKerjaModel();

		$result = ['' => '--Pilih--'];

		foreach ($arr->getSatuanKerja() as $row){
			$result[$row['kd_satker']] = $row['nama_satker'];
		}
		
		return $result;
	}

	public function options_jenis_pengadaan(){
		$arr = new JenisPengadaanModel();

		$result = ['' => '--Pilih--'];

		foreach ($arr->getJenisPengadaan() as $row){
			$result[$row['id']] = $row['nama_jenis_pengadaan'];
		}
		
		return $result;
	}

	public function options_kategori_permasalahan(){
		$arr = new KategoriPermasalahanModel();

		$result = ['' => '--Pilih--'];

		foreach ($arr->getKategoriPermasalahan() as $row){
			$result[$row['id']] = $row['nama_kategori_permasalahan'];
		}
		
		return $result;
	}
}