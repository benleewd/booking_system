<?php namespace App\Controllers;

class Dashboard extends BaseController
{
	public function index()
	{
		$data = [];

		echo view('templates/header', $data);
		echo view('pages/dashboard');
		echo view('templates/footer');
	}

	//--------------------------------------------------------------------

}
