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

	public function core($func)
	{
		switch ($func) {
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
			
			case 'checkSchedule':
				return $this->checkSchedule();
				break;
				
			default:
				return $this->test();
				break;
		} 
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
			'start' => $incData->newStart,
			'end' => $incData->newEnd,
			'resourceid' => $incData->newResource
		);
		$db = db_connect();
		$builder = $db->table("schedule");
		$result = $builder->where('id', $incData->id)
						  ->update($data);
		
		return json_encode($result);
		
	}

	public function getAllSchedule()
	{
		$db = db_connect();
		$builder = $db->table("schedule");
		$schedules = $builder->select('schedule.id, resourceid, start, end, username')
							->join('users','users.id=schedule.userid')
							->get()->getResultArray();
		$output = array();
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

	public function checkSchedule()
	{
		$incData = $this->request->getJSON();
		$userid = Intval($incData->userid);
		$id = Intval($incData->id);
		
		$db = db_connect();
		$builder = $db->table("schedule");
		$result = $builder->select('userid')
						  ->join('users', 'users.id=schedule.userid')
						  ->where('schedule.id', $id)
						  ->get()->getResultArray();

		$builder1 = $db->table('users');
		$access_level = $builder1->where('id', $userid)
								 ->get()->getResultArray();

		if (Intval($access_level[0]['access']) === 0)
			return json_encode(true);
		elseif (Intval($result[0]['userid']) === $userid)
			return json_encode(true);
		return json_encode(false);
		
		
	}

	//--------------------------------------------------------------------

}
