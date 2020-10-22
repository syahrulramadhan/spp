<?php namespace App\Models;

use CodeIgniter\Model;

class LaporanValuasiModel extends Model
{
    protected $table            = 'laporan_valuasi';
    protected $useTimestamps   = true;
    protected $allowedFields    = ['klpd_id','field1','field2','field3','field4','field5','field6','field7','field8','field9','created_at','updated_at', 'created_by'];

    public function getLaporanValuasi($klpd_id = false){
        if($klpd_id == false){
            //return $this->findAll();

            $builder = $this->db->table('laporan_valuasi');
            $builder->select(
                'laporan_valuasi.klpd_id
                ,klpd.nama_klpd
                ,laporan_valuasi.field1
                ,laporan_valuasi.field2
                ,laporan_valuasi.field3
                ,laporan_valuasi.field4
                ,laporan_valuasi.field5
                ,laporan_valuasi.field6
                ,laporan_valuasi.field7
                ,laporan_valuasi.field8
                ,laporan_valuasi.field9
            ');

            $builder->join('klpd','klpd.klpd_id = laporan_valuasi.klpd_id', 'left');
            return $builder->get()->getResultArray();
        }

        return $this->where(['id' => $klpd_id])->first();
    }
}