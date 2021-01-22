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
		$data = [];

		helper(['form']);
		if ($this->request->getMethod() == 'post') {
			$rules = [
				'fname' => [
					'rules' => 'required|min_length[3]|validateGroupName[fname]',
					'label' => 'fname',
					'errors' => [
						'validateGroupName' => "A similar facility name exists"
					]
				],
				'qty' => 'required'
			];

			if (!$this->validate($rules)){
				$data['validation'] = $this->validator;
			} else {
				$group = $this->request->getVar('fname');
				$qty = Intval($this->request->getVar('qty'));

				if (substr($group, -1) != "s")
					$groups = $group . "s";

				$db = db_connect();
				$builder = $db->table("groups");

				$lastgid = $builder->get()->getLastRow()->gid;
				$builder->resetQuery();

				$num = Intval(substr($lastgid, 1)) + 1;
				$newgid = "G" . strval($num);
				$builder->insert([
					'gid' => $newgid,
					'name' => $groups
				]);
				
				$builder1 = $db->table('resources');
				for ($i=1; $i < $qty + 1; $i++) { 
					$builder1->insert([
						'gid' => $newgid,
						'name' => $group . " " . $i
					]);
					$builder1->resetQuery();
				}

				return redirect()->to('/admin/addfacility');

			}
		}
		
		echo view('templates/header', $data);

		echo view('admin/addfacility');

		echo view('templates/footer');

	}
	//--------------------------------------------------------------------

}
