<?php namespace App\Controllers;

use App\Models\PelayananModel;
use App\Models\PelayananFileModel;

class PelayananFIle extends BaseController
{
	protected $pelayananModel;
	protected $pelayananFileModel;

	public function __construct()
	{
		$this->pelayananModel = new PelayananModel();
		$this->pelayananFileModel = new PelayananFileModel();
		helper('form');
	}

	public function index($id)
	{

        $result = $this->pelayananFileModel->getFileByPelayananId($id);
		$result_pelayanan = $this->pelayananModel->getPelayananJoin($id);

		$data = [
            'title' => 'Pelayanan File',
            'result' => $result,
            'result_pelayanan' => $result_pelayanan,
			'pelayanan_id' => $id,
            'validation' => \Config\Services::validation()
		];

        return view('PelayananFile/index', $data);
	}
    
    public function save($pelayanan_id){
        if(!$this->validate([
			'label_file' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'Label file harus diisi.'
				]
            ]
		])){

			$validation = \Config\Services::validation();
			return redirect()->to("/pelayanan/$pelayanan_id/file")->withInput()->with('validation', $validation);
		}
        

        // get file
        $image = $this->request->getFile('pelayanan_file');

        $name = $image->getRandomName();
        $type = $image->getClientMimeType();
        $size = $image->getSize();
         
        $image->move(ROOTPATH . 'public/uploads/pelayanan', $name);

        $this->pelayananFileModel->save([
			'pelayanan_id' => $pelayanan_id,
            'label_file' => $this->request->getVar('label_file'),
            'nama_file' => $name,
            'size' => $size,
            'type' => $type,
			'created_by' => session('id')
		]);

		session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');
		
		return redirect()->to("/pelayanan/$pelayanan_id/file");
	}

	public function delete($pelayanan_id, $id){
		$result = $this->pelayananFileModel->find($id);

		if($result){
			$this->pelayananFileModel->delete($id);

			$path = getcwd() . '/uploads/pelayanan/' . $result['nama_file'];
        
			if (is_file($path)) {
				unlink($path);
			}
			
			session()->setFlashdata('pesan', 'Data berhasil dihapus.');

			return redirect()->to("/pelayanan/$pelayanan_id/file");
		}else{
			session()->setFlashdata('warning', 'Data tidak berhasil ditemukan');

			return redirect()->to("/pelayanan/$pelayanan_id/file");
		}
	}
}