<?php namespace App\Models;

use CodeIgniter\Model;

class KlpdModel extends Model
{
    protected $table            = 'klpd';
    protected $userTimestamps   = true;
    protected $allowedFields    = ['klpd_id','nama_klpd','jenis_klpd','alamat_klpd','website','kd_propinsi','kd_kabupaten','is_not_rekap_display','is2014','is2015','i2016','is2017','is2018','is2019','is2020','created_at','updated_at', 'created_by'];

    public function getKlpd($klpd_id = false){
        if($klpd_id == false){
            //return $this->findAll();

            
            $builder = $this->db->table('klpd');
            $builder->select(
                'klpd.id
                , klpd.klpd_id
                , klpd.nama_klpd
                , klpd.jenis_klpd
                , (
                    SELECT COUNT(*)
                    FROM pelayanan
                    WHERE pelayanan.klpd_id = klpd.klpd_id
                    GROUP BY pelayanan.klpd_id
                ) jumlah_pelayanan
                , (
                    SELECT SUM(pelayanan.paket_nilai_pagu)
                    FROM pelayanan
                    WHERE pelayanan.klpd_id = klpd.klpd_id
                    GROUP BY pelayanan.klpd_id
                ) jumlah_valuasi
                , (
                    SELECT COUNT(DISTINCT(pelayanan.jenis_advokasi_id))
                    FROM pelayanan
                    WHERE pelayanan.klpd_id = klpd.klpd_id
                    GROUP BY pelayanan.klpd_id
                ) jumlah_kualitas
            ');

            $builder->orderBy('nama_klpd ASC');

            return $builder->get()->getResultArray();
        }

        return $this->where(['id' => $klpd_id])->first();
    }

    public function klpdById($id_klpd)
    {
        $builder = $this->db->table('klpd');
        $builder->where('klpd_id', $id_klpd);

        return $builder->get()->getRowArray();
    }
    
    public function getCountKlpd($jenis_klpd){
        $builder = $this->db->table('klpd');

        
        if($jenis_klpd)
            $builder->where('jenis_klpd', $jenis_klpd);

        return $builder->countAllResults();
    }

    public function getListJenisKlpd(){
        $builder = $this->db->table('klpd');

        $builder->select('jenis_klpd');
        $builder->groupBy('jenis_klpd');
        
        return $builder->get()->getResultArray();
    }
}