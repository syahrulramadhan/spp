<?php namespace App\Controllers;

use App\Models\PicModel;

class Pic extends BaseController
{
	protected $picModel;

	public function __construct()
	{
		$this->picModel = new PicModel();
		helper('form');
	}

	public function index()
	{
		$keyword = $this->request->getVar('q');

		if($keyword){
			$result = $this->picModel->getPaginatedPicData($keyword);
		}else
			$result = $this->picModel->getPaginatedPicData();

		$currentPage = ($this->request->getVar('page_pic')) ? $this->request->getVar('page_pic') : 1;
		$per_page = 10;

		$data = [
            'title' => 'PIC',
			'result' => $result->paginate($per_page, 'pic'),
			'options_user' => $this->options_user(),
			'validation' => \Config\Services::validation(),
			'keyword' => $keyword,
			'pager' => $result->pager,
			'per_page' => $per_page,
			'currentPage' => $currentPage
		];

		return view('Pic/index', $data);
	}
	
	public function detail($id){
		$data = [
			'title' => 'Detail PIC',
			'result' => $this->picModel->getPic($id)
		];

		if(empty($data['result'])){
			throw new \CodeIgniter\Exceptions\PageNotFoundException('PIC dengan ID ' . $id . ' tidak ditemukan.');
		}

		return view('Pic/detail', $data);
	}

	public function options_user($id = false, $name = false){
		$arr = $this->picModel->getUserPic();

		$result = ['' => '--Pilih--'];

		foreach ($arr as $row){
			$result[$row['user_id']] = $row['nama_depan'] . " " . $row['nama_belakang'];
		}

		if($id){
			$result[$id] = $name;
		}

		return $result;
	}

	public function save(){
		if(!$this->validate([
			'user_id' => [
				'rules' => 'required|is_unique[pic.user_id]',
				'errors' => [
					'required' => 'User harus diisi.',
					'is_unique' => 'User tidak dapat ditambahkan jika sudah ada'
				]
			]
		])){

			$validation = \Config\Services::validation();
			return redirect()->to('/pic')->withInput()->with('validation', $validation);
		}

		$this->picModel->save([
			'user_id' => $this->request->getVar('user_id'),
			'status' => 'ACTIVE',
			'created_by' => session('id')
		]);
		
		session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');
		
		return redirect()->to('/pic');
	}

	public function edit($id){
		$res = $this->picModel->getPic($id);

		$data = [
			'title' => 'Form Tambah Data PIC',
			'options_user' => $this->options_user($id, $res['nama_depan'] . " " . $res['nama_belakang']),
			'options_status' => [
				'' => '--Pilih--',
				'ACTIVE' => 'AKTIF',
				'NON_ACTIVE' => 'TIDAK AKTIF'
			],
			'validation' => \Config\Services::validation(),
			'result' => $res
		];

		return view('Pic/edit', $data);
	}

	public function update($id){
		if(!$this->validate([
			'user_id' => [
				'rules' => "required|is_unique[pic.user_id,id,$id]",
				'errors' => [
					'required' => 'User harus diisi.',
					'is_unique' => 'User tidak dapat diubah jika sudah ada'
				]
			]
		])){

			$validation = \Config\Services::validation();
			return redirect()->to('/pic/edit/' . $id)->withInput()->with('validation', $validation);
		}

		$this->picModel->save([
			'id' => $id,
			'user_id' => $this->request->getVar('user_id'),
			'status' => $this->request->getVar('status')
		]);
		
		session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');
		
		return redirect()->to('/pic/edit/' . $id);
	}
}