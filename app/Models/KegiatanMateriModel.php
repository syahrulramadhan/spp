<?php namespace App\Models;

use CodeIgniter\Model;

class KegiatanMateriModel extends Model
{
    protected $table            = 'kegiatan_materi';
    protected $userTimestamps   = true;
    protected $allowedFields    = ['kegiatan_id', 'label_materi', 'nama_materi', 'size', 'type', 'user_id', 'created_by'];

    public function getKegiatanMateri(){
        return $this->findAll();
    }

    public function getMateriByKegiatanId($kegiatan_id){
        $builder = $this->db->table('kegiatan_materi');
        $builder->where('kegiatan_id', $kegiatan_id);

        return $builder->get()->getResultArray(); 
    }
}