<?php namespace App\Models;

use CodeIgniter\Model;

class CommonModel extends Model
{
    public function getTotal($table, $where){
        $builder = $this->db->table($table);
        $builder->where($where);
        return $builder->countAllResults();
    }
}