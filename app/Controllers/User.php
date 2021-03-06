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
		permission_redirect(['ADMINISTRATOR']);

		$keyword = $this->request->getVar('q');
		$per_page = ($this->request->getVar('per_page')) ? $this->request->getVar('per_page') : 10;

		if($keyword)
			$user = $this->userModel->getPaginatedUserData($keyword);
		else
			$user = $this->userModel;

		$currentPage = ($this->request->getVar('page_user')) ? $this->request->getVar('page_user') : 1;

		$data = [
            'title' => 'User',
			'result' => $user->paginate($per_page, 'user'),
			'options_per_page' => $this->options_per_page(),
			'keyword' => $keyword,
			'pager' => $this->userModel->pager,
			'per_page' => $per_page,
			'currentPage' => $currentPage
		];
    
		return view('User/index', $data);
	}
	
	public function detail($id){
		permission_redirect(['ADMINISTRATOR']);

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
		permission_redirect(['ADMINISTRATOR']);

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
		permission_redirect(['ADMINISTRATOR']);

		if(!$this->validate([
			'nama_depan' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'Nama depan harus diisi.'
				]
			],
			'nama_belakang' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'Nama belakang harus diisi.'
				]
			],
			'email' => [
				'rules' => 'required|valid_email|is_unique[user.email]',
				'errors' => [
					'required' => 'Email harus diisi.',
					'valid_email' => 'Silakan periksa format email anda.',
					'is_unique' => 'Email anda harus bernilai unik.'
				]
			],
			'username' => [
				'rules' => 'required|min_length[10]|is_unique[user.username]',
				'errors' => [
					'required' => 'Username harus diisi.',
					'min_length' => 'Username anda terlalu pendek.',
					'is_unique' => 'Username anda harus bernilai unik.'
				]
			],
			'password' => [
				'rules' => 'required|min_length[10]',
				'errors' => [
					'required' => 'Kata sandi harus diisi.',
					'min_length' => 'Kata sandi anda terlalu pendek.'
				]
			],
			'repassword' => [
				'rules' => 'required|min_length[10]|matches[password]',
				'errors' => [
					'required' => 'Ulangi kata sandi harus diisi.',
					'min_length' => 'Ulangi kata sandi anda terlalu pendek.',
					'matches' => 'Kata sandi yang diulang tidak sama'
				]
			],
			'nomor_telepon' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'Nomor telepon harus diisi.'
				]
			],
			'role' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'Role harus diisi.'
				]
			]
		])){

			$validation = \Config\Services::validation();
			return redirect()->to('/user/create')->withInput()->with('validation', $validation);
		}

		$pass = $this->setPassword($this->request->getVar('password'));

		$save = [
			'nama_depan' => $this->request->getVar('nama_depan'),
			'nama_belakang' => $this->request->getVar('nama_belakang'),
			'email' => $this->request->getVar('email'),
			'username' => $this->request->getVar('username'),
			'salt' => $pass['salt'],
			'password' => $pass['password'],
			'nomor_telepon' => str_replace("-", "", $this->request->getVar('nomor_telepon')),
			'jabatan' => $this->request->getVar('jabatan'),
			'role' => $this->request->getVar('role'),
			'created_by' => session('id')
		];

		$this->userModel->save($save);
		
		//echo "<pre>"; print_r($save); exit;

		session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');
		
		return redirect()->to('/user');
	}

	public function edit($id){
		permission_redirect(['ADMINISTRATOR']);

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
		permission_redirect(['ADMINISTRATOR']);

		if(!$this->validate([
			'nama_depan' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'Nama depan harus diisi.'
				]
			],
			'nama_belakang' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'Nama belakang harus diisi.'
				]
			],
			'email' => [
				'rules' => "required|valid_email|is_unique[user.email,id,$id]",
				'errors' => [
					'required' => 'Email harus diisi.',
					'valid_email' => 'Silakan periksa format email anda.',
					'is_unique' => 'Email anda harus bernilai unik.'
				]
			],
			'nomor_telepon' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'Nomor telepon harus diisi.'
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
			'nomor_telepon' => str_replace("-", "", $this->request->getVar('nomor_telepon')),
			'jabatan' => $this->request->getVar('jabatan')
		];

		$this->userModel->save($update);
		
		session()->setFlashdata('pesan', 'Data berhasil diubah.');
		
		return redirect()->to('/user/edit/' . $id);
	}

	public function delete($id){
		permission_redirect(['ADMINISTRATOR']);

		$result = $this->userModel->find($id);

		if($result){
			$this->userModel->delete($id);

			session()->setFlashdata('pesan', 'Data berhasil dihapus.');

			return redirect()->to('/user');
		}else{
			session()->setFlashdata('warning', 'Data tidak berhasil ditemukan');

			return redirect()->to("/user");
		}
	}
}