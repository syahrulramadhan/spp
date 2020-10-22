<?php namespace App\Models;

use CodeIgniter\Model;

class PelayananPesertaModel extends Model
{
    protected $table            = 'pelayanan_peserta';
    protected $useTimestamps   = true;
    protected $allowedFields    = ['pelayanan_id', 'nama_peserta', 'created_by'];

    public function getPelayananPeserta(){
        return $this->findAll();
    }

    public function getPesertaByPelayananId($pelayanan_id){
        $builder = $this->db->table('pelayanan_peserta');
        $builder->where('pelayanan_id', $pelayanan_id);

        return $builder->get()->getResultArray(); 
    }

    public function getPaginatedPelayananPesertaData($pelayanan_id, string $keyword = ''){
        $select = 'pelayanan_peserta.id
            , pelayanan_peserta.pelayanan_id
            , pelayanan_peserta.nama_peserta
            , pelayanan_peserta.created_by
        ';

        $builder = $this->table('pelayanan_peserta');
        $builder->select($select);

        if($pelayanan_id){
            $builder->where('pelayanan_peserta.pelayanan_id', $pelayanan_id);
        }

        if($keyword){
            $builder->like('pelayanan_peserta.nama_peserta', $keyword);
        }

        return $builder;
    }
}