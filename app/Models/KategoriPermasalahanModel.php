<?php namespace App\Models;

use CodeIgniter\Model;

class KategoriPermasalahanModel extends Model
{
    protected $table            = 'kategori_permasalahan';
    protected $userTimestamps   = true;
    protected $allowedFields    = ['nama_kategori_permasalahan', 'keterangan', 'created_by'];

    public function getKategoriPermasalahan($kategori_permasalahan_id = false){
        if($kategori_permasalahan_id == false){
            //return $this->findAll();

            $builder = $this->db->table('kategori_permasalahan kp');
            $builder->select(
                'kp.id
                , kp.nama_kategori_permasalahan
                , kp.keterangan
                , (
                    SELECT COUNT(*)
                    FROM pelayanan
                    WHERE pelayanan.kategori_permasalahan_id = kp.id
                    GROUP BY pelayanan.kategori_permasalahan_id
                ) jumlah_pelayanan
                , (
                    SELECT SUM(pelayanan.paket_nilai_pagu)
                    FROM pelayanan
                    WHERE pelayanan.kategori_permasalahan_id = kp.id
                    GROUP BY pelayanan.kategori_permasalahan_id
                ) jumlah_valuasi
            ');

            return $builder->get()->getResultArray();
        }

        return $this->where(['id' => $kategori_permasalahan_id])->first();
    }
}