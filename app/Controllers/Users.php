<?php namespace App\Controllers;

use App\Models\UserModel;


class Users extends BaseController
{
	public function index()
	{
		$data = [];

		helper(['form']);

		if ($this->request->getMethod() == 'post') {
			$rules = [
				'username' => 'required|min_length[5]',
				'password' => [
					'rules' => 'required|min_length[8]|max_length[255]|validateUser[username,password]',
					'label' => 'password',
					'errors' => [
						'validateUser' => "Username or Password don't match"
					]
				]
			];
			
			

			if (!$this->validate($rules)) {
				$data['validation'] = $this->validator;
			} else {
				$model = new UserModel();

				$user = $model->where('username', $this->request->getVar('username'))
								->first();

				$this->setUserMethod($user);
				return redirect()->to('dashboard');

			}
		}

		echo view('templates/header', $data);

		echo view('login');

		echo view('templates/footer');
		
	}

	private function setUserMethod($user){
		$data = [
			'id' => $user['id'],
			'username' => $user['username'],
			'access' => $user['access'],
			'isLogged' => true
		];

		session()->set($data);
	}

	public function register()
	{
		$data = [];
		helper(['form']);

		if ($this->request->getMethod() == 'post') {
			$rules = [
				'username' => 'required|min_length[5]|is_unique[users.username]',
				'password' => 'required|min_length[8]|max_length[255]',
				'password_confirm' => 'matches[password]'
			];

			if (!$this->validate($rules)) {
				$data['validation'] = $this->validator;
			} else {
				$model = new UserModel();

				$newdata = [
					'username' => $this->request->getVar('username'),
					'password' => $this->request->getVar('password')
				];
				$model->save($newdata);
				$session = session();
				$session->setFlashdata('success', "Successful Registration");

				return redirect()->to('/');

			}
		}

		echo view('templates/header', $data);

		echo view('register');

		echo view('templates/footer');
	}

	public function logout()
	{
		session()->destroy();
		return redirect()->to('/');
	}
	//--------------------------------------------------------------------

}
