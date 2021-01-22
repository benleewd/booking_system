<?php namespace App\Controllers;

class Facility extends BaseController
{
	public function index()
	{
		echo view('templates/header');

		echo view('admin/addfacility');

		echo view('templates/footer');
	}

	public function addFacility()
	{
		$group = $this->request->getVar('fname');
		$qty = $this->request->getVar('qty');

		if ($group[-1] != "s")
			$group .= "s";

		
	}
	//--------------------------------------------------------------------

}
