<?php namespace App\Models;

class CRUDModel
{
	protected $db;
	protected $builder;
	protected $success;

	public function __construct()
	{
		
	}

	public function init($table)
	{
		$this->db = db_connect();
		$this->builder = $this->db->table($table);
	}

	public function create($data)
	{	
		$result = $this->builder->insert($data);
		$this->builder->resetQuery();
		
		return json_encode($result);
	}

	public function read($id=none)
	{
		if ($id != none){
			$this->builder->where('id', $id);
		}
		$result = $this->builder->get()->getResultArray();
		$this->builder->resetQuery();

		return json_encode($result);
	}

	public function update($data)
	{
		$result = $this->builder->replace($data);
		$this->builder->resetQuery();

		return json_encode($result);

	}

	public function delete($data)
	{
		$result = $this->builder->where('id', $data)->delete();
		$this->builder->resetQuery();

		return json_encode($result);
	}
	//--------------------------------------------------------------------

}
