<?php namespace App\Models;

use CodeIgniter\Model;

class PelayananPesertaModel extends Model
{
    protected $table            = 'pelayanan_peserta';
    protected $userTimestamps   = true;
    protected $allowedFields    = ['pelayanan_id', 'nama_peserta', 'created_by'];

    public function getPelayananPeserta(){
        return $this->findAll();
    }

    public function getPesertaByPelayananId($pelayanan_id){
        $builder = $this->db->table('pelayanan_peserta');
        $builder->where('pelayanan_id', $pelayanan_id);

        return $builder->get()->getResultArray(); 
    }
}