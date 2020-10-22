<?php namespace App\Models;

use CodeIgniter\Model;

class PelayananFileModel extends Model
{
    protected $table            = 'pelayanan_file';
    protected $useTimestamps   = true;
    protected $allowedFields    = ['pelayanan_id', 'label_file', 'nama_file', 'size', 'type', 'created_by'];

    public function getPelayananFile(){
        return $this->findAll();
    }

    public function getFileByPelayananId($pelayanan_id){
        $builder = $this->db->table('pelayanan_file');
        $builder->where('pelayanan_id', $pelayanan_id);

        return $builder->get()->getResultArray(); 
    }

    public function getPaginatedPelayananFileData($pelayanan_id, string $keyword = ''){
        $select = 'pelayanan_file.id
            , pelayanan_file.pelayanan_id
            , pelayanan_file.label_file
            , pelayanan_file.nama_file
            , pelayanan_file.size
            , pelayanan_file.type
            , pelayanan_file.created_by
        ';

        $builder = $this->table('pelayanan_file');
        $builder->select($select);

        if($pelayanan_id){
            $builder->where('pelayanan_file.pelayanan_id', $pelayanan_id);
        }

        if($keyword){
            $builder->like('pelayanan_file.label_file', $keyword);
        }

        return $builder;
    }
}