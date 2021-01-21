<?php namespace App\Controllers;

use App\Models\CRUDModel;
class Group{}
class Resource{}

class Resources extends BaseController
{
	protected $model;

	public function core($func='load')
	{
		switch ($func) {
			case 'load':
				$this->load();
				break;
			
			case 'addResource':
				return $this->addResource();
				break;

			case 'updateResource':
				return $this->updateResource();
				break;

			case 'getAllResource':
				return $this->getAllResource();
				break;

			case 'deleteResource':
				return $this->deleteResource();
				break;
			
			case 'test':
				return $this->test();
				break;
				
			default:
				
				break;
		} 
	}
	
	public function load($table='resources')
	{
		$this->model = new CRUDModel();
		$this->model->init($table);
	}

	public function addResource()
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

	public function updateResource()
	{
		if($this->request->getMethod() == 'post' && $this->request->getVar('id')) {
			$data = array(
				'id' => $this->request->getVar('id'),
				'userid' => session()->get('id'),
				'resourceid' => $this->request->getVar('newResource'),
				'start_dt' => $this->request->getVar('newStart'),
				'end_dt' => $this->request->getVar('newEnd'),
			);
			return $this->model->update($data);
		}
	}
	public function test()
	{
		$db = db_connect();
		$builder = $db->table("groups");
		return json_encode($builder->where('id', 1)->get()->getResultArray());
	}

	public function getAllResource()
	{
		
		
		$db = db_connect();
		$builder = $db->table("groups");

		$groups = $builder->get()->getResultArray();
		
		$output = array();
		foreach ($groups as $group) {
			$g = new Group();
			$g->id = $group['gid'];
			$g->name = $group['name'];
			$builder1 = $db->table("resources");
			// $builder1->where('gid', $g->id);
			$resources = $builder1->where('gid', $g->id)->get()->getResultArray();
			$children = array();
			foreach ($resources as $resource) {
				$r = new Resource();
				$r->id = $resource['id'];
				$r->name = $resource['name'];
				$children[] = $r;
			}
			$g->children = $children;
			$output[] = $g;
		}

		return json_encode($output);
		
		// if($this->request->getMethod() == 'post' && $this->request->getVar('id')){
		// 	$builder->where('gid', $id);
		// 	return json_encode($builder->get()->getResultArray());
		// }
		// else
		// 	return json_encode($builder->get()->getResultArray());
	}

	public function deleteResource()
	{
		if($this->request->getMethod() == 'post' && $this->request->getVar('id')) {
			return $this->model->delete($this->request->getVar('id'));
		}
	}
	//--------------------------------------------------------------------

}
