<?php namespace App\Models;

use CodeIgniter\Model;

class JenisPengadaanModel extends Model
{
    protected $table            = 'jenis_pengadaan';
    protected $useTimestamps   = true;
    protected $allowedFields    = ['nama_jenis_pengadaan', 'keterangan', 'created_by'];

    public function getJenisPengadaan($jenis_pengadaan_id = false){
        if($jenis_pengadaan_id == false){
            //return $this->findAll();

            $builder = $this->db->table('jenis_pengadaan jp');
            $builder->select(
                'jp.id
                , jp.nama_jenis_pengadaan
                , jp.keterangan
                , (
                    SELECT COUNT(*)
                    FROM pelayanan
                    WHERE pelayanan.paket_jenis_pengadaan_id = jp.id
                    GROUP BY pelayanan.paket_jenis_pengadaan_id
                ) jumlah_pelayanan
                , (
                    SELECT SUM(pelayanan.paket_nilai_pagu)
                    FROM pelayanan
                    WHERE pelayanan.paket_jenis_pengadaan_id = jp.id
                    GROUP BY pelayanan.paket_jenis_pengadaan_id
                ) jumlah_valuasi
            ');

            return $builder->get()->getResultArray();

        }

        return $this->where(['id' => $jenis_pengadaan_id])->first();
    }

    public function getPaginatedJenisPengadaanData(string $keyword = ''){
        $select = '
            jenis_pengadaan.id
            , jenis_pengadaan.nama_jenis_pengadaan
            , jenis_pengadaan.keterangan
            , (
                SELECT COUNT(*)
                FROM pelayanan
                WHERE pelayanan.paket_jenis_pengadaan_id = jenis_pengadaan.id
                GROUP BY pelayanan.paket_jenis_pengadaan_id
            ) jumlah_pelayanan
            , (
                SELECT SUM(pelayanan.paket_nilai_pagu)
                FROM pelayanan
                WHERE pelayanan.paket_jenis_pengadaan_id = jenis_pengadaan.id
                GROUP BY pelayanan.paket_jenis_pengadaan_id
            ) jumlah_valuasi
        ';

        if ($keyword)
        {
            return $this->select($select)
                ->like('jenis_pengadaan.nama_jenis_pengadaan', $keyword);
        }

        return $this->select($select);
    }
}