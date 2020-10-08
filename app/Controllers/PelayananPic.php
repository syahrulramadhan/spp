<?php namespace App\Controllers;

use App\Models\PelayananPicModel;
use App\Models\PicModel;

class PelayananPic extends BaseController
{
	protected $pelayananPicModel;
	protected $picModel;

	public function __construct()
	{
		$this->pelayananPicModel = new PelayananPicModel();
		$this->picModel = new PicModel();
		helper('form');
	}

	public function index($id)
	{

        $arr = $this->pelayananPicModel->getPicByPelayananId($id);
 
		$data = [
            'title' => 'Pelayanan PIC',
            'result' => $arr,
			'pelayanan_id' => $id,
			'options_pic' => $this->options_pic(),
            'validation' => \Config\Services::validation()
		];

        return view('PelayananPic/index', $data);
	}

	public function options_pic(){
		$arr = $this->picModel->getPic();

		$result = ['' => '--Pilih--'];

		foreach ($arr as $row){
			$result[$row['id']] = $row['nama_depan'] . " " . $row['nama_belakang'];
		}

		return $result;
    }
    
    public function save($pelayanan_id){
		if(!$this->validate([
			'pic_id' => [
				//'rules' => 'required|is_unique[pelayanan_pic.pic_id]',
				'rules' => 'required|is_unique_layanan_pic[pelayanan_pic.pic_id]',
				'errors' => [
					'required' => 'Pic harus diisi.',
					'is_unique_layanan_pic' => 'Pic tidak boleh sama dalam satu pelayanan'
				]
			]
		])){

			$validation = \Config\Services::validation();
			return redirect()->to("/pelayanan/$pelayanan_id/pic")->withInput()->with('validation', $validation);
		}

        $this->pelayananPicModel->save([
			'pelayanan_id' => $pelayanan_id,
			'pic_id' => $this->request->getVar('pic_id'),
			'created_by' => session('id')
		]);

		session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');
		
		return redirect()->to("/pelayanan/$pelayanan_id/pic");
	}

	public function delete($pelayanan_id, $id){
		$result = $this->pelayananPicModel->find($id);

		if($result){
			$this->pelayananPicModel->delete($id);

			session()->setFlashdata('pesan', 'Data berhasil dihapus.');

			return redirect()->to("/pelayanan/$pelayanan_id/pic");
		}
	}

	/*
	public function save($pelayanan_id){
		$validation = \Config\Services::validation();

		$data = [
			'pelayanan_id' => $this->request->getVar('pelayanan_id'),
			'pic_id' => $this->request->getVar('pic_id')
		];

		$validation->setRules([
			'pelayanan_id' => [
				'rules' => 'required',
				'errors' => [
					'required' => '{field} pelayanan harus diisi.'
				]
			],
			'pic_id' => [
				'rules' => 'required|is_unique[pelayanan_pic.pic_id]',
				'errors' => [
					'required' => '{field} pic harus diisi.'
				]
			]
		]);

		if($validation->run() == FALSE){
			session()->setFlashdata('errors', $validation->getErrors());
            return redirect()->to(base_url("/pelayanan/$pelayanan_id/pic"));
		}else{
			$this->pelayananPicModel->save($data);

			session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');
			
			return redirect()->to("/pelayanan/$pelayanan_id/pic");
		}
	}
	*/
}