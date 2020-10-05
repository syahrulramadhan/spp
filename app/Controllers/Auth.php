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

	public function register(){

		if($this->request->getPost())
		{
			//lakukan validasi untuk data yang di post
			$data = $this->request->getPost();
			$validate = $this->validation->run($data, 'register');
			$errors = $this->validation->getErrors();

			//jika tidak ada errors jalanakan
			if(!$errors){
				$userModel = new \App\Models\UserModel();

				$user = new \App\Entities\User();

				$user->username = $this->request->getPost('email');
				$user->password = $this->request->getPost('password');

				$user->created_at = date("Y-m-d H:i:s");

				$userModel->save($user);

				return view('Auth/login');
			}

			$this->session->setFlashdata('errors', $errors);
		}

		return view('register');
	}

	public function login(){
		if($this->request->getPost())
		{
			//lakukan validasi untuk data yang di post
			$data = $this->request->getPost();
			$validate = $this->validation->run($data, 'login');
			$errors = $this->validation->getErrors();

			if($errors){
				return view('Auth/login');
			}

			$userModel = new \App\Models\UserModel();

			$username = $this->request->getPost('username');
			$password = $this->request->getPost('password');

			$user = $userModel->where('username', $username)->orwhere('email', $username)->first();

            //echo "<pre>"; print_r($user); exit;

            if($user)
			{
				$salt = $user['salt'];
				$pass = $this->setPassword($password, $salt);
				
				if($user['password'] !== $pass['password']){
					$this->session->setFlashdata('errors', ['Password Salah']);
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

					return redirect()->to(site_url('pages'));
                }
			}else{
				$this->session->setFlashdata('errors', ['User Tidak Ditemukan']);
			}
		}
		return view('Auth/login');
	}

	public function logout()
	{
		$this->session->destroy();
		return redirect()->to(base_url('auth/login'));
	}
}

?>