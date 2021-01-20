<?php namespace App\Controllers;

use App\Models\CRUDModel;

class Schedule extends BaseController
{
	protected $model;
	protected $uid;

	public function __construct()
	{
		
	}
	public function index()
	{
		
	}

	public function load()
	{
		
	}

	public function insert()
	{
		
		if ($this->request->getMethod() == 'post') {
			$data = array(
				'username' => $this->request->getVar('user'),
				'start_dt' => $this->request->getVar('start'),
				'end_dt' => $this->request->getVar('end'),
			);
			$this->model->save($data);
		}
	}

	public function update()
	{
		if($this->request->getMethod() == 'post' && $this->request->getVar('id')) {
			$data = array(
				'username' => $this->request->getVar('user'),
				'start_dt' => $this->request->getVar('start'),
				'end_dt' => $this->request->getVar('end'),
			);
			$this->model->update($this->request->getVar('id'), $data);
		}
	}
	//--------------------------------------------------------------------

}
