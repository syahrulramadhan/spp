<?php
    namespace App\Validations;

    use App\Models\UserModel;
    use App\Controllers\BaseController;

    class CustomRules{
        public function valid_password(string $password, string &$error = null): bool
        {
            $userModel = new UserModel();
            $baseController = new BaseController();

            $user = $userModel->where('username', session('username'))->orwhere('email', session('username'))->first();

            if($user)
            {
                $salt = $user['salt'];
                $pass = $baseController->setPassword($password, $salt);
                
                if($user['password'] !== $pass['password']){
                    return false;
                }else{
                    return true;
                }
            }else{
                return false;
            }
        }
    }
?>