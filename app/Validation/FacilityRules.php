<?php 
namespace App\Validation;

class FacilityRules {
    public function validateGroupName(string $str, string $field, array $data): bool{
        $db = db_connect();
        $builder = $db->table("groups");

        $count = $builder->like('name', $data['fname'])
                        ->countAllResults();
        if ($count > 0)
            // echo "it didnt";
            return false;

        return true;
    }
}
?>