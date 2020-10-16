<?php namespace App\Controllers;

use App\Models\KegiatanNarasumberModel;
use App\Models\KegiatanModel;

class KegiatanNarasumber extends BaseController
{
	protected $kegiatanNarasumberModel;
	protected $kegiatanModel;

	public function __construct()
	{
		$this->kegiatanNarasumberModel = new KegiatanNarasumberModel();
		$this->kegiatanModel = new KegiatanModel();
		helper('form');
	}

	public function index($id)
	{
        $result = $this->kegiatanNarasumberModel->getNarasumberByKegiatanId($id);
		$result_kegiatan = $this->kegiatanModel->getKegiatan($id);

		$data = [
            'title' => 'Kegiatan Narasumber',
			'result' => $result,
			'result_kegiatan' => $result_kegiatan,
			'kegiatan_id' => $id,
			'validation' => \Config\Services::validation()
		];
    
        return view('KegiatanNarasumber/index', $data);
	}
    
    public function save($kegiatan_id){
		if(!$this->validate([
			'nama_narasumber' => [
				'rules' => 'required|is_unique[kegiatan_narasumber.nama_narasumber]',
				'errors' => [
					'required' => 'Narasumber harus diisi.',
					'is_unique' => 'Narasumber tidak boleh sama dalam satu pelayanan'
				]
			]
		])){

			$validation = \Config\Services::validation();
			return redirect()->to("/kegiatan/$kegiatan_id/narasumber")->withInput()->with('validation', $validation);
		}

        $this->kegiatanNarasumberModel->save([
			'kegiatan_id' => $kegiatan_id,
			'nama_narasumber' => $this->request->getVar('nama_narasumber'),
			'created_by' => session('id')
		]);
		
		session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');
		
		return redirect()->to("/kegiatan/$kegiatan_id/narasumber");
	}

	public function delete($kegiatan_id, $id){
		$result = $this->kegiatanNarasumberModel->find($id);

		if($result){
			$this->kegiatanNarasumberModel->delete($id);

			session()->setFlashdata('pesan', 'Data berhasil dihapus.');

			return redirect()->to("/kegiatan/$kegiatan_id/narasumber");
		}else{
			session()->setFlashdata('warning', 'Data tidak berhasil ditemukan');

			return redirect()->to("/kegiatan/$kegiatan_id/narasumber");
		}
	}
}