<?php namespace App\Controllers;

use App\Models\KegiatanNarasumberModel;

class KegiatanNarasumber extends BaseController
{
	protected $kegiatanNarasumberModel;

	public function __construct()
	{
		$this->kegiatanNarasumberModel = new KegiatanNarasumberModel();
		helper('form');
	}

	public function index($id)
	{
		ini_set("display_errors", "1");

        $arr = $this->kegiatanNarasumberModel->getNarasumberByKegiatanId($id);
 
		$data = [
            'title' => 'Kegiatan Narasumber',
            'result' => $arr,
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
}