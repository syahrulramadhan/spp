<?php namespace App\Models;

use CodeIgniter\Model;

class PelayananFileModel extends Model
{
    protected $table            = 'pelayanan_file';
    protected $userTimestamps   = true;
    protected $allowedFields    = ['pelayanan_id', 'label_file', 'nama_file', 'size', 'type', 'created_by'];

    public function getPelayananFile(){
        return $this->findAll();
    }

    public function getFileByPelayananId($pelayanan_id){
        $builder = $this->db->table('pelayanan_file');
        $builder->where('pelayanan_id', $pelayanan_id);

        return $builder->get()->getResultArray(); 
    }
}