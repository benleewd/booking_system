<?php namespace App\Controllers;

class Admin extends BaseController
{
	public function showme($page = 'home')
	{
		if (!is_file(APPPATH.'/Views/admin/'.$page.'.php'))
		{
			throw new \CodeIgniter\Exceptions\PageNotFoundException($page);
		}

		echo view('templates/header');

		echo view('admin/'. $page);

		echo view('templates/footer');
	}

	//--------------------------------------------------------------------

}
