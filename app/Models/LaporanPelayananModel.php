<?php namespace App\Models;

use CodeIgniter\Model;

class LaporanPelayananModel extends Model
{
    protected $table            = 'laporan_layanan';
    protected $userTimestamps   = true;
    protected $allowedFields    = ['klpd_id','field1','field2','field3','field4','field5','field6','field7','field8','field9','created_at','updated_at', 'created_by'];

    public function getLaporanPelayanan($klpd_id = false){
        if($klpd_id == false){
            //return $this->findAll();

            $builder = $this->db->table('laporan_layanan');
            $builder->select(
                'laporan_layanan.klpd_id
                ,klpd.nama_klpd
                ,laporan_layanan.field1
                ,laporan_layanan.field2
                ,laporan_layanan.field3
                ,laporan_layanan.field4
                ,laporan_layanan.field5
                ,laporan_layanan.field6
                ,laporan_layanan.field7
                ,laporan_layanan.field8
                ,laporan_layanan.field9
            ');

            $builder->join('klpd','klpd.klpd_id = laporan_layanan.klpd_id', 'left');
            return $builder->get()->getResultArray();
        }

        return $this->where(['id' => $klpd_id])->first();
    }
}