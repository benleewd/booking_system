<?php 
namespace App\Validation;
use App\Models\UserModel;

class UserRules {
    public function validateUser(string $str, string $field, array $data): bool{
        $model = new UserModel();
        $user = $model->where('username', $data['username'])
                        ->first();
        if (!$user)
            // echo "it didnt";
            return false;

        return password_verify($data['password'], $user['password']);
    }
}
?>