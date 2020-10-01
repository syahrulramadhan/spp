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
}