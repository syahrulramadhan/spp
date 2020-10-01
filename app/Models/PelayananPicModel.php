<?php namespace App\Models;

use CodeIgniter\Model;

class PelayananPicModel extends Model
{
    protected $table            = 'pelayanan_pic';
    protected $userTimestamps   = true;
    protected $allowedFields    = ['pelayanan_id', 'pic_id', 'created_by'];

    public function getPelayananPic(){
        $builder = $this->db->table('pelayanan_pic pp');
        $builder->select('u.id user_id, u.nama_depan, u.nama_belakang, u.email, u.nomor_telepon, u.role, u.jabatan, p.id pic_id, p.status, pp.id');
        $builder->join('pic p', 'p.id = pp.pic_id', 'left');
        $builder->join('user u', 'u.id = p.user_id', 'left');

        return $builder->get()->getResultArray();
    }

    public function getPicByPelayananId($pelayanan_id){
        $builder = $this->db->table('pelayanan_pic pp');
        $builder->select('u.id user_id, u.nama_depan, u.nama_belakang, u.email, u.nomor_telepon, u.role, u.jabatan, p.id pic_id, p.status, pp.id');
        $builder->join('pic p', 'p.id = pp.pic_id', 'left');
        $builder->join('user u', 'u.id = p.user_id', 'left');
        $builder->where('pp.pelayanan_id', $pelayanan_id);

        return $builder->get()->getResultArray();
    }
}