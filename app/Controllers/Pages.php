<?php namespace App\Controllers;

class Pages extends BaseController
{
	public function index()
	{
		echo view('templates/header');
		// if (session()->get('isLogged')){
		// 	echo view('pages/home');
		// } else {
		// 	echo view('login');
		// }
		echo view('pages/schedule');
		echo view('templates/footer');
		
	}

	public function showme($page = 'home')
	{
		if (!is_file(APPPATH.'/Views/pages/'.$page.'.php'))
		{
			throw new \CodeIgniter\Exceptions\PageNotFoundException($page);
		}

		echo view('templates/header');

		echo view('pages/'. $page);

		echo view('templates/footer');
	}

	//--------------------------------------------------------------------

}
