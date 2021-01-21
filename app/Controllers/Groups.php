<?php namespace App\Controllers;

use App\Models\CRUDModel;

class Groups extends BaseController
{
	protected $model;

	public function core($func='load')
	{
		switch ($func) {
			case 'load':
				$this->load();
				break;
			
			case 'addGroups':
				return $this->addGroups();
				break;

			case 'updateGroups':
				return $this->updateGroups();
				break;

			case 'getAllGroups':
				return $this->getAllGroups();
				break;

			case 'deleteGroups':
				return $this->deleteGroups();
				break;

			default:
				
				break;
		} 
	}
	
	public function load($table='groups')
	{
		$this->model = new CRUDModel();
		$this->model->init($table);
	}

	public function addGroups()
	{
		if ($this->request->getMethod() == 'post') {
			$data = array(
				'userid' => session()->get('id'),
				'start_dt' => $this->request->getVar('start'),
				'end_dt' => $this->request->getVar('end'),
			);
			return $this->model->create($data);
		}
	}

	public function updateGroups()
	{
		if($this->request->getMethod() == 'post' && $this->request->getVar('id')) {
			$data = array(
				'id' => $this->request->getVar('id'),
				'userid' => session()->get('id'),
				'Groupsid' => $this->request->getVar('newGroups'),
				'start_dt' => $this->request->getVar('newStart'),
				'end_dt' => $this->request->getVar('newEnd'),
			);
			return $this->model->update($data);
		}
	}

	public function getAllGroups()
	{
		$db = db_connect();
		$builder = $db->table("groups");
		return json_encode($builder->get()->getResultArray());
	}

	public function deleteGroups()
	{
		if($this->request->getMethod() == 'post' && $this->request->getVar('id')) {
			return $this->model->delete($this->request->getVar('id'));
		}
	}
	//--------------------------------------------------------------------

}
