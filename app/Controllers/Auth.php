<?php
namespace App\Controllers;

class Auth extends BaseController
{
	public function __construct()
	{
		helper('form');
		$this->validation = \Config\Services::validation();
        $this->session = session();
	}

	public function login(){
		$data = [
			'title' => 'Form Login',
			'validation' => \Config\Services::validation()
		];

		if($this->request->getPost())
		{
			$rules['username'] = [
				'rules' => 'required|exist_username_user',
				'errors' => [
					'required' => 'Username/Email harus diisi.',
					'exist_username_user' => 'Username/Email tidak ditemukan'
				]
			];
	
			$rules['password'] = [
				'rules' => 'required',
				'errors' => [
					'required' => 'Password harus diisi.'
				]
			];
			
			if(!$this->validate($rules)){
	
				$validation = \Config\Services::validation();
				return redirect()->to("login")->withInput()->with('validation', $validation);
			}

			$userModel = new \App\Models\UserModel();

			$username = $this->request->getPost('username');
			$password = $this->request->getPost('password');

			$user = $userModel->where('username', $username)->orwhere('email', $username)->first();

            if($user){
				$salt = $user['salt'];
				$pass = $this->setPassword($password, $salt);
				
				if($user['password'] !== $pass['password']){
					$this->session->setFlashdata('error', 'Kata sandi anda salah');
				}else{
                    $newdata = [
                        'nama_lengkap'  => $user['nama_depan'] . " " . $user['nama_belakang'],
                        'username'      => $user['username'],
						'email'         => $user['email'],
                        'id'            => $user['id'],
                        'role'          => $user['role'],
                        'logged_in'     => TRUE
                    ];

					$this->session->set($newdata);

					return redirect()->to(base_url('pages'));
                }
			}else{
				$this->session->setFlashdata('error', 'Username/Email tidak ditemukan');
			}
		}

		return view('Auth/login', $data);
	}

	public function logout()
	{
		$this->session->destroy();
		return redirect()->to(base_url('auth/login'));
	}
}

?>