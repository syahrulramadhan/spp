<?php namespace App\Models;

use CodeIgniter\Model;

class CommonModel extends Model
{
    public function getTotal($table, $where){
        $builder = $this->db->table($table);
        $builder->where($where);
        return $builder->countAllResults();
    }

    public function perhitunganLaporanLayanan($jenis_advokasi){
        $advokasi = [
            0 => '',
            1 => 'field1',
            2 => 'field2',
            3 => 'field3',
            4 => 'field4',
            5 => 'field5',
            6 => 'field6',
            7 => 'field7',
            8 => 'field8',
            9 => 'field9',
        ];

        $field = $advokasi[$jenis_advokasi];

        if($field){
            $q = "
                UPDATE
                laporan_layanan
                ,(
                    SELECT pelayanan.klpd_id, COUNT(*) AS jumlah_layanan
                    FROM pelayanan    
                    JOIN jenis_advokasi ON jenis_advokasi.id = pelayanan.jenis_advokasi_id
                    WHERE jenis_advokasi.id = ?
                    GROUP BY pelayanan.klpd_id
                ) temp
                SET $field = temp.jumlah_layanan
                WHERE laporan_layanan.klpd_id = temp.klpd_id
            ";

            
            $query = $this->db->query($q, [$jenis_advokasi]);
            
            return $query;
        }
    }

    public function perhitunganLaporanValuasi($jenis_advokasi){
        $advokasi = [
            0 => '',
            1 => 'field1',
            2 => 'field2',
            3 => 'field3',
            4 => 'field4',
            5 => 'field5',
            6 => 'field6',
            7 => 'field7',
            8 => 'field8',
            9 => 'field9',
        ];

        $field = $advokasi[$jenis_advokasi];

        if($field){
            $q = "
                UPDATE
                laporan_valuasi
                ,(
                    SELECT pelayanan.klpd_id, SUM(pelayanan.paket_nilai_pagu) jumlah_valuasi
                    FROM pelayanan    
                    JOIN jenis_advokasi ON jenis_advokasi.id = pelayanan.jenis_advokasi_id
                    WHERE jenis_advokasi.id = ?
                    GROUP BY pelayanan.klpd_id
                ) temp
                SET $field = temp.jumlah_valuasi
                WHERE laporan_valuasi.klpd_id = temp.klpd_id
            ";

            
            $query = $this->db->query($q, [$jenis_advokasi]);
            
            return $query;
        }
    }

    public function updateByKey($table, $data, $id, $value)
    {
        $query = $this->db->table($table)->update($data, array($id => $value));
        return $query;
    }
}