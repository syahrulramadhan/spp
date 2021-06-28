<?php namespace App\Models;

use CodeIgniter\Model;

class PengaturanModel extends Model
{
    protected $table            = 'pengaturan';
    protected $useTimestamps   = true;
    protected $allowedFields    = ['id_pengaturan', 'field', 'label', 'deskripsi', 'tipe', 'tipe_param_value', 'foto', 'grup', 'created_at', 'updated_at', 'created_by'];

    public function getPengaturan($pengaturan_id = false){
        if($pengaturan_id == false){
            //return $this->findAll();

            $builder = $this->db->table('pengaturan p');
            $builder->select(
                'p.id
                ,p.field
                ,p.label
                ,p.deskripsi
                ,p.tipe
                ,p.tipe_param_value
                ,p.foto
                ,p.grup
                ,p.created_by
                ,p.created_at
                ,p.updated_at
            ');

            $builder->where('flag', 1);
            $builder->orderBy('p.grup', 'ASC');
            $builder->orderBy('p.field', 'ASC');

            return $builder->get()->getResultArray();
        }

        return $this->where(['p.id' => $pengaturan_id])->first();
    }

    function jumlah_field($list_grup = array()){
        if($list_grup){
            $sql = "SELECT ";

            foreach($list_grup as $row){
                if($row['grup'])
                    $select[] = '(SELECT count(*) FROM pengaturan WHERE grup ="' . $row['grup'] . '" AND flag = 1) as ' . $row['grup'];
            }

            $sql = $sql . implode(",", $select); 
            
            $query = $this->db->query($sql);

            if($query) {
                return $query->getRowArray();
            } return false;
        } return false;
    }

    function list_grup(){
        $sql = "SELECT grup FROM pengaturan WHERE flag = 1 GROUP BY grup ORDER BY grup ASC";

        $query = $this->db->query($sql);

        if($query) {
			return $query->getResultArray();
        } return false;
    }
}