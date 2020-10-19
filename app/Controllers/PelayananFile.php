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
		helper(['form', 'url']);
	}

	public function index($id)
	{
		$keyword = $this->request->getVar('q');
		$per_page = ($this->request->getVar('per_page')) ? $this->request->getVar('per_page') : 10;

		if($keyword){
			$result = $this->pelayananFileModel->getPaginatedPelayananFileData($id, $keyword);
		}else
			$result = $this->pelayananFileModel->getPaginatedPelayananFileData($id);

		$currentPage = ($this->request->getVar('page')) ? $this->request->getVar('page') : 1;

		$result_pelayanan = $this->pelayananModel->getPelayananJoin($id);

		$data = [
            'title' => 'Pelayanan File',
            'result' => $result->paginate($per_page, 'pelayanan_file'),
			'result_pelayanan' => $result_pelayanan,
			'options_per_page' => $this->options_per_page(),
			'pelayanan_id' => $id,
			'validation' => \Config\Services::validation(),
			'options_per_page' => $this->options_per_page(),
			'keyword' => $keyword,
			'pager' => $result->pager,
			'per_page' => $per_page,
			'currentPage' => $currentPage
		];

        return view('PelayananFile/index', $data);
	}
    
    public function save($pelayanan_id){
		$rules['label_file'] = [
			'rules' => 'required',
			'errors' => [
				'required' => 'Label file harus diisi.'
			]
		];

		$rules['pelayanan_file'] = [
			'rules' => 'uploaded[pelayanan_file]|max_size[pelayanan_file,2048]|mime_in[pelayanan_file,image/png,image/jpg,image/jpeg,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.presentation]',
			'errors' => [
				'uploaded' => 'Gambar harus diisi',
				'max_size' => 'Maksimal upload gambar 2 MB',
				'mime_in' => 'Upload gambar yang memiliki ekstensi .jpeg/.jpg/.png/.gif'
			]
		];

        if(!$this->validate($rules)){

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