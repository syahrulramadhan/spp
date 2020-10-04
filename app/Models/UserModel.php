<?php namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'user';
    protected $primaryKey       = 'id';
    protected $userTimestamps   = true;
    protected $allowedFields    = ['nama_depan', 'nama_belakang', 'email', 'username', 'password', 'salt', 'nomor_telepon', 'role', 'jabatan', 'created_by'];
	//protected $returnType       = 'App\Entities\User';
    protected $useTimestamps    = false;
    
    public function getUser($user_id = false){
        if($user_id == false){
            return $this->findAll();
        }

        return $this->where(['id' => $user_id])->first();
    }

    public function search(string $keyword = ''){
        return $this->table('user')->like('nama_depan', $keyword)->orLike('nama_belakang', $keyword);
    }
}