<?php namespace App\Models;

use CodeIgniter\Model;

class KegiatanNarasumberModel extends Model
{
    protected $table            = 'kegiatan_narasumber';
    protected $userTimestamps   = true;
    protected $allowedFields    = ['kegiatan_id', 'nama_narasumber', 'created_by'];

    public function getKegiatanNarasumber(){
        return $this->findAll();
    }

    public function getNarasumberByKegiatanId($kegiatan_id){
        $builder = $this->db->table('kegiatan_narasumber');
        $builder->where('kegiatan_id', $kegiatan_id);

        return $builder->get()->getResultArray(); 
    }

    public function getPaginatedKegiatanNarasumberData($kegiatan_id, string $keyword = ''){
        $select = 'kegiatan_narasumber.id
            , kegiatan_narasumber.kegiatan_id
            , kegiatan_narasumber.nama_narasumber
            , kegiatan_narasumber.created_by
        ';

        $builder = $this->table('kegiatan_narasumber');
        $builder->select($select);

        if($kegiatan_id){
            $builder->where('kegiatan_narasumber.kegiatan_id', $kegiatan_id);
        }

        if($keyword){
            $builder->like('kegiatan_narasumber.nama_narasumber', $keyword);
        }

        return $builder;
    }
}