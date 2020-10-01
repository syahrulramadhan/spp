<?php namespace App\Controllers;

use App\Models\UserModel;
//use App\Entities\User;

class User extends BaseController
{
	protected $userModel;

	public function __construct()
	{
		$this->userModel = new UserModel();
		//$this->user = new User();
		helper('form');
	}

	public function index()
	{
		$keyword = $this->request->getVar('q');

		if($keyword)
			$user = $this->userModel->search($keyword);
		else
			$user = $this->userModel;

		$currentPage = ($this->request->getVar('page_user')) ? $this->request->getVar('page_user') : 1;
		$per_page = 10;

		$data = [
            'title' => 'User',
			'result' => $user->paginate($per_page, 'user'),
			'keyword' => $keyword,
			'pager' => $this->userModel->pager,
			'per_page' => $per_page,
			'currentPage' => $currentPage
		];
    
		return view('User/index', $data);
	}
	
	public function detail($id){
		$data = [
			'title' => 'Detail User',
			'result' => $this->userModel->getUser($id)
		];

		if(empty($data['result'])){
			throw new \CodeIgniter\Exceptions\PageNotFoundException('User dengan ID ' . $id . ' tidak ditemukan.');
		}

		return view('User/detail', $data);
	}

	public function create(){
		$data = [
			'title' => 'Form Tambah Data User',
			'options_role' => [
				'' => '--Pilih--',
				'ADMINISTRATOR' => 'ADMINISTRATOR',
				'ADMIN_CONTENT' => 'ADMIN CONTENT'
			],
			'validation' => \Config\Services::validation()
		];

		return view('User/create', $data);
	}

	public function save(){
		if(!$this->validate([
			'nama_depan' => [
				'rules' => 'required',
				'errors' => [
					'required' => '{field} nama depan harus diisi.'
				]
			],
			'email' => [
				'rules' => 'required',
				'errors' => [
					'required' => '{field} email harus diisi.'
				]
			],
			'nomor_telepon' => [
				'rules' => 'required',
				'errors' => [
					'required' => '{field} nomor telepon harus diisi.'
				]
			],
			'jabatan' => [
				'rules' => 'required',
				'errors' => [
					'required' => '{field} jabatan harus diisi.'
				]
			],
			'role' => [
				'rules' => 'required',
				'errors' => [
					'required' => '{field} role harus diisi.'
				]
			]
		])){

			$validation = \Config\Services::validation();
			return redirect()->to('/user/create')->withInput()->with('validation', $validation);
		}

		$this->userModel->save([
			'nama_depan' => $this->request->getVar('nama_depan'),
			'nama_belakang' => $this->request->getVar('nama_belakang'),
			'email' => $this->request->getVar('email'),
			'password' => md5($this->request->getVar('password')),
			'nomor_telepon' => $this->request->getVar('nomor_telepon'),
			'jabatan' => $this->request->getVar('jabatan'),
			'role' => $this->request->getVar('role')
		]);
		
		session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');
		
		return redirect()->to('/user');
	}

	public function edit($id){
		$data = [
			'title' => 'Form Ubah Data User',
			'options_role' => [
				'' => '--Pilih--',
				'ADMINISTRATOR' => 'ADMINISTRATOR',
				'ADMIN_CONTENT' => 'ADMIN CONTENT'
			],
			'validation' => \Config\Services::validation(),
			'result' => $this->userModel->getUser($id)
		];

		return view('User/edit', $data);
	}

	public function update($id){
		if(!$this->validate([
			'nama_depan' => [
				'rules' => 'required',
				'errors' => [
					'required' => '{field} nama depan harus diisi.'
				]
			],
			'email' => [
				'rules' => 'required',
				'errors' => [
					'required' => '{field} email harus diisi.'
				]
			],
			'nomor_telepon' => [
				'rules' => 'required',
				'errors' => [
					'required' => '{field} nomor telepon harus diisi.'
				]
			],
			'jabatan' => [
				'rules' => 'required',
				'errors' => [
					'required' => '{field} jabatan harus diisi.'
				]
			]
		])){

			$validation = \Config\Services::validation();
			return redirect()->to('/user/edit/' . $id)->withInput()->with('validation', $validation);
		}

		$update = [
			'id' => $id,
			'nama_depan' => $this->request->getVar('nama_depan'),
			'nama_belakang' => $this->request->getVar('nama_belakang'),
			'email' => $this->request->getVar('email'),
			'nomor_telepon' => $this->request->getVar('nomor_telepon'),
			'role' => $this->request->getVar('role'),
			'jabatan' => $this->request->getVar('jabatan'),
			'created_by' => session('id')
		];

		if($this->request->getVar('password')){
			$update['password'] = md5($this->request->getVar('password'));
		}

		$this->userModel->save($update);
		
		session()->setFlashdata('pesan', 'Data berhasil diubah.');
		
		return redirect()->to('/user/edit/' . $id);
	}

	public function delete($id){
		$this->userModel->delete($id);

		session()->setFlashdata('pesan', 'Data berhasil dihapus.');

		return redirect()->to('/user');
	}
}