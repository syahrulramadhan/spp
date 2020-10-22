<?php namespace App\Models;

use CodeIgniter\Model;

class PelayananPicModel extends Model
{
    protected $table            = 'pelayanan_pic';
    protected $useTimestamps   = true;
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

    public function getPaginatedPelayananPicData($pelayanan_id, string $keyword = ''){
        $select = 'pelayanan_pic.id
            , pelayanan_pic.pelayanan_id
            , pelayanan_pic.pic_id
            , pelayanan_pic.created_by
            , pic.status
            , user.nama_depan
            , user.nama_belakang
        ';

        $builder = $this->table('pelayanan_pic');
        $builder->select($select);
        $builder->join('pic', 'pic.id = pelayanan_pic.pic_id', 'left');
        $builder->join('user', 'user.id = pic.user_id', 'left');

        if($pelayanan_id){
            $builder->where('pelayanan_pic.pelayanan_id', $pelayanan_id);
        }

        if($keyword){
            $builder->like('user.nama_depan', $keyword)->orLike('user.nama_belakang', $keyword);
        }

        return $builder;
    }
}