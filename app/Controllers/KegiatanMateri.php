<?php namespace App\Controllers;

use App\Models\KegiatanMateriModel;
use App\Models\KegiatanModel;

class KegiatanMateri extends BaseController
{
	protected $kegiatanMateriModel;
	protected $kegiatanModel;

	public function __construct()
	{
		$this->kegiatanMateriModel = new KegiatanMateriModel();
		$this->kegiatanModel = new KegiatanModel();
		helper(['form', 'url']);
	}

	public function index($id)
	{

        $result = $this->kegiatanMateriModel->getMateriByKegiatanId($id);
		$result_kegiatan = $this->kegiatanModel->getKegiatan($id);

		$data = [
            'title' => 'Dokumen',
			'result' => $result,
			'result_kegiatan' => $result_kegiatan,
			'kegiatan_id' => $id,
            'validation' => \Config\Services::validation()
		];

        return view('KegiatanMateri/index', $data);
	}
    
    public function save($kegiatan_id){
		$rules['label_materi'] = [
			'rules' => 'required',
			'errors' => [
				'required' => 'Label materi harus diisi.'
			]
		];

		$rules['kegiatan_materi'] = [
			'rules' => 'uploaded[kegiatan_materi]|max_size[kegiatan_materi,2048]|mime_in[kegiatan_materi,image/png,image/jpg,image/jpeg,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.presentation]',
			'errors' => [
				'uploaded' => 'Gambar harus diisi',
				'max_size' => 'Maksimal upload gambar 2 MB',
				'mime_in' => 'Upload gambar yang memiliki ekstensi .jpeg/.jpg/.png/.gif'
			]
		];

        if(!$this->validate($rules)){

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