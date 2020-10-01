<?php namespace App\Controllers;

use App\Models\PelayananFileModel;

class PelayananFIle extends BaseController
{
	protected $pelayananFileModel;

	public function __construct()
	{
		$this->pelayananFileModel = new PelayananFileModel();
		helper('form');
	}

	public function index($id)
	{

        $arr = $this->pelayananFileModel->getFileByPelayananId($id);
 
		$data = [
            'title' => 'Pelayanan File',
            'result' => $arr,
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
}