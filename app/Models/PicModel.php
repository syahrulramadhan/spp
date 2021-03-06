<?php namespace App\Models;

use CodeIgniter\Model;

class PicModel extends Model
{
    protected $table            = 'pic';
    protected $useTimestamps   = true;
    protected $allowedFields    = ['user_id','status', 'created_by'];

    public function getPic($pic_id = false){
        if($pic_id == false){

            $builder = $this->db->table('pic p');
            $builder->select('u.id user_id, u.nama_depan, u.nama_belakang, u.email, u.nomor_telepon, u.role, u.jabatan, p.id, p.status');
            $builder->join('user u', 'u.id = p.user_id', 'left');

            return $builder->get()->getResultArray();
        }

        $builder = $this->db->table('pic p');
        $builder->select('u.id user_id, u.nama_depan, u.nama_belakang, u.email, u.nomor_telepon, u.role, u.jabatan, p.id, p.status');
        $builder->join('user u', 'u.id = p.user_id', 'left');
        $builder->where('p.id', $pic_id);

        return $builder->get()->getRowArray();
    }

    public function getUserPic(){
        $builder = $this->db->table('user u');
        $builder->select('u.id user_id, u.nama_depan, u.nama_belakang, u.username, u.email, u.nomor_telepon, u.role, u.jabatan, p.id, p.status');
        $builder->join('pic p', 'u.id = p.user_id', 'left');
        $builder->where('p.user_id IS NULL');

        return $builder->get()->getResultArray();
    }

    public function list($q){
        
        if($q)
            return $this->select('u.id user_id, u.nama_depan, u.nama_belakang, u.email, u.nomor_telepon, u.role, u.jabatan, p.id, p.status')->table('pic p')->join('user u', 'u.id = p.user_id', 'left')->like('u.nama_depan', $q)->orLike('u.nama_belakang', $q);
        
        return $this->table('pic p')->join('user u', 'u.id = p.user_id', 'left');
    }

    public function getPaginatedPicData(string $keyword = ''){
        if ($keyword)
        {
            return $this->select('user.id user_id, user.nama_depan, user.nama_belakang, user.username, user.email, user.nomor_telepon, user.role, user.jabatan, pic.id, pic.status')
                ->join('user', 'user.id = pic.user_id', 'left')
                ->like('user.nama_depan', $keyword)
                ->orLike('user.nama_belakang', $keyword);
        }

        return $this->select('user.id user_id, user.nama_depan, user.nama_belakang, user.username, user.email, user.nomor_telepon, user.role, user.jabatan, pic.id, pic.status')
            ->join('user', 'user.id = pic.user_id', 'left');
    }
}