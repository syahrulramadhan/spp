<?php namespace App\Models;

use CodeIgniter\Model;

class JenisAdvokasiModel extends Model
{
    protected $table            = 'jenis_advokasi';
    protected $userTimestamps   = true;
    protected $allowedFields    = ['nama_jenis_advokasi', 'keterangan', 'image_jenis_advokasi', 'jumlah', 'created_by'];

    public function getJenisAdvokasi($jenis_advokasi_id = false){
        if($jenis_advokasi_id == false){
            //return $this->findAll();

            $builder = $this->db->table('jenis_advokasi ja');
            $builder->select(
                'ja.id
                , ja.nama_jenis_advokasi
                , ja.image_jenis_advokasi
                , ja.keterangan
                , (
                    SELECT COUNT(*)
                    FROM pelayanan
                    WHERE pelayanan.jenis_advokasi_id = ja.id
                    GROUP BY pelayanan.jenis_advokasi_id
                ) jumlah_pelayanan
                , (
                    SELECT SUM(pelayanan.paket_nilai_pagu)
                    FROM pelayanan
                    WHERE pelayanan.jenis_advokasi_id = ja.id
                    GROUP BY pelayanan.jenis_advokasi_id
                ) jumlah_valuasi
            ');

            return $builder->get()->getResultArray();
        }

        return $this->where(['id' => $jenis_advokasi_id])->first();
    }

    public function getList(){
		$arr = array();
		
        $builder = $this->db->table('jenis_advokasi');

        $query = $builder->get()->getResultArray(); 

		foreach ($query as $row) {
            $arr[] = $row['id'];
        }
		
        return $arr;
	}
}