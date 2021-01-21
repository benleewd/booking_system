<?php namespace App\Controllers;

use App\Models\CRUDModel;

class Sche{}

class Schedule extends BaseController
{
	protected $model;
	protected $uid;

	public function index()
	{
		echo view('templates/header');

		echo view('pages/schedule');

		echo view('templates/footer');
	}

	public function core($func='load')
	{
		switch ($func) {
			case 'load':
				$this->load();
				break;
			
			case 'addSchedule':
				return $this->addSchedule();
				break;

			case 'updateSchedule':
				return $this->updateSchedule();
				break;

			case 'getAllSchedule':
				return $this->getAllSchedule();
				break;

			case 'deleteSchedule':
				return $this->deleteSchedule();
				break;

			default:
				return $this->test();
				break;
		} 
	}
	
	public function load($table='schedule')
	{
		$this->model = new CRUDModel();
		$this->model->init($table);
	}

	public function test()
	{
		return json_encode(session()->get());
	}

	public function addSchedule()
	{
		$incData = $this->request->getJSON();
		$data = array(
			'userid' => $incData->id,
			'start' => $incData->start,
			'end' => $incData->end,
			'resourceid' => $incData->resource,
		);

		$db = db_connect();
		$builder = $db->table("schedule");
		$result = $builder->insert($data);
		
		return json_encode($result);

	}

	public function updateSchedule()
	{
		$incData = $this->request->getJSON();
		$data = array(
			'id' => $incData->id,
			'start' => $incData->newStart,
			'end' => $incData->newEnd,
			'resourceid' => $incData->newResource,
			'userid' => $incData->userid
		);
		$db = db_connect();
		$builder = $db->table("schedule");
		$result = $builder->replace($data);

		return json_encode($result);
		
	}

	public function getAllSchedule()
	{
		// $this->load();
		// return $this->model->read();
		$db = db_connect();
		$builder = $db->table("schedule");
		$builder->select('schedule.id, resourceid, start, end, username');
		$builder->join('users','users.id=schedule.userid');
		$output = array();
		$schedules = $builder->get()->getResultArray();
		foreach ($schedules as $schedule) {
			$s = new Sche();
			$s->id = $schedule['id'];
			$s->text = $schedule['username'];
			$s->start = $schedule['start'];
			$s->end = $schedule['end'];
			$s->resource = $schedule['resourceid'];
			$output[] = $s;
		}
		return json_encode($output);
	}

	public function deleteSchedule()
	{
		$incData = $this->request->getJSON();
		$db = db_connect();
		$builder = $db->table("schedule");
		$result = $builder->where('id', $incData->id)->delete();

		return json_encode($result);
	}
	//--------------------------------------------------------------------

}
