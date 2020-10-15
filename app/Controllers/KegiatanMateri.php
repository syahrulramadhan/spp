<?php namespace App\Controllers;

use App\Models\KegiatanMateriModel;

class KegiatanMateri extends BaseController
{
	protected $kegiatanMateriModel;

	public function __construct()
	{
        ini_set("display_errors", "1");

		$this->kegiatanMateriModel = new KegiatanMateriModel();
		helper('form');
	}

	public function index($id)
	{

        $arr = $this->kegiatanMateriModel->getMateriByKegiatanId($id);
 
		$data = [
            'title' => 'Dokumen',
            'result' => $arr,
			'kegiatan_id' => $id,
            'validation' => \Config\Services::validation()
		];

        return view('KegiatanMateri/index', $data);
	}
    
    public function save($kegiatan_id){
        if(!$this->validate([
			'label_materi' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'Label materi harus diisi.'
				]
            ]
		])){

			$validation = \Config\Services::validation();
			return redirect()->to("/kegiatan/$kegiatan_id/materi")->withInput()->with('validation', $validation);
		}
        

        // get file
        $image = $this->request->getFile('kegiatan_materi');

        $name = $image->getRandomName();
        $type = $image->getClientMimeType();
        $size = $image->getSize();
         
        $image->move(ROOTPATH . 'public/uploads/kegiatan', $name);

        $save = [
			'kegiatan_id' => $kegiatan_id,
            'label_materi' => $this->request->getVar('label_materi'),
            'nama_materi' => $name,
            'size' => $size,
            'type' => $type,
			'created_by' => session('id')
        ];

        //echo "<pre>"; print_r($save); exit;
        
        $this->kegiatanMateriModel->save($save);

		session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');
		
		return redirect()->to("/kegiatan/$kegiatan_id/materi");
	}

	public function delete($kegiatan_id, $id){
		$result = $this->kegiatanMateriModel->find($id);

		if($result){
			$this->kegiatanMateriModel->delete($id);

			$path = getcwd() . '/uploads/kegiatan/' . $result['nama_materi'];
        
			if (is_file($path)) {
				unlink($path);
			}

			session()->setFlashdata('pesan', 'Data berhasil dihapus.');

			return redirect()->to("/kegiatan/$kegiatan_id/materi");
		}else{
			session()->setFlashdata('warning', 'Data tidak berhasil ditemukan');

			return redirect()->to("/kegiatan/$kegiatan_id/materi");
		}
	}
}