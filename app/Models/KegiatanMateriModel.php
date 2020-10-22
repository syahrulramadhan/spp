<?php namespace App\Models;

use CodeIgniter\Model;

class KegiatanMateriModel extends Model
{
    protected $table            = 'kegiatan_materi';
    protected $useTimestamps   = true;
    protected $allowedFields    = ['kegiatan_id', 'label_materi', 'nama_materi', 'size', 'type', 'user_id', 'created_by'];

    public function getKegiatanMateri(){
        return $this->findAll();
    }

    public function getMateriByKegiatanId($kegiatan_id){
        $builder = $this->db->table('kegiatan_materi');
        $builder->where('kegiatan_id', $kegiatan_id);

        return $builder->get()->getResultArray(); 
    }

    public function getPaginatedKegiatanMateriData($kegiatan_id, string $keyword = ''){
        $select = 'kegiatan_materi.id
            , kegiatan_materi.kegiatan_id
            , kegiatan_materi.label_materi
            , kegiatan_materi.nama_materi
            , kegiatan_materi.size
            , kegiatan_materi.type
            , kegiatan_materi.created_by
        ';

        $builder = $this->table('kegiatan_materi');
        $builder->select($select);

        if($kegiatan_id){
            $builder->where('kegiatan_materi.kegiatan_id', $kegiatan_id);
        }

        if($keyword){
            $builder->like('kegiatan_materi.label_materi', $keyword);
        }

        return $builder;
    }
}