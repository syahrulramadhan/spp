<?php
    namespace App\Validations;

    use App\Models\UserModel;
    use App\Models\PelayananPicModel;
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

        public function is_unique_layanan_pic(string $pic_id, string &$error = null): bool
        {
            $pelayananPicModel = new PelayananPicModel();

            $uri = new \CodeIgniter\HTTP\URI(current_url(true));
            
            $pelayanan_id = $uri->getSegment(2);

            $pic = $pelayananPicModel->where('pelayanan_id', $pelayanan_id)->where('pic_id', $pic_id)->first();

            if($pic){
                return false;
            }else{
                return true;
            }
        }
    }
?>