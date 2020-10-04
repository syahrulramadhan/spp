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
			$user = $this->userModel->getPaginatedUserData($keyword);
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
				'rules' => 'required|valid_email',
				'errors' => [
					'required' => 'Email harus diisi.',
					'valid_email' => 'Silakan periksa format email anda.'
				]
			],
			'username' => [
				'rules' => 'required|min_length[10]',
				'errors' => [
					'required' => 'Username harus diisi.',
					'min_length' => 'Username anda terlalu pendek.'
				]
			],
			'password' => [
				'rules' => 'required|min_length[10]',
				'errors' => [
					'required' => 'Password harus diisi.',
					'min_length' => 'Kata sandi anda terlalu pendek.'
				]
			],
			'repassword' => [
				'rules' => 'required|min_length[10]|matches[password]',
				'errors' => [
					'required' => 'Nomor telepon harus diisi.',
					'min_length' => 'Kata sandi anda terlalu pendek.',
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

		$this->userModel->save([
			'nama_depan' => $this->request->getVar('nama_depan'),
			'nama_belakang' => $this->request->getVar('nama_belakang'),
			'email' => $this->request->getVar('email'),
			'username' => $this->request->getVar('username'),
			'salt' => $pass['salt'],
			'password' => $pass['password'],
			'nomor_telepon' => $this->request->getVar('nomor_telepon'),
			'jabatan' => $this->request->getVar('jabatan'),
			'role' => $this->request->getVar('role'),
			'created_by' => session('id')
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
				'rules' => 'required|valid_email',
				'errors' => [
					'required' => 'Email harus diisi.',
					'valid_email' => 'Silakan periksa format email anda.'
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

		$pass = $this->setPassword($this->request->getVar('password'));

		$update = [
			'id' => $id,
			'nama_depan' => $this->request->getVar('nama_depan'),
			'nama_belakang' => $this->request->getVar('nama_belakang'),
			'email' => $this->request->getVar('email'),
			'nomor_telepon' => $this->request->getVar('nomor_telepon'),
			'jabatan' => $this->request->getVar('jabatan')
		];

		if($this->request->getVar('password')){
			$update['salt'] = $pass['salt'];
			$update['password'] = $pass['password'];
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