<?php namespace App\Models;

use CodeIgniter\Model;

class SatuanKerjaModel extends Model
{
    protected $table            = 'satuan_kerja';
    protected $useTimestamps   = true;
    protected $allowedFields    = ['kd_satker','kd_satker', 'kd_satker_str', 'kd_klpd', 'nama_satker', 'id_deleted', 'audit_update', 'tahun_aktif', 'updated_at', 'created_at', 'created_by'];

    public function getSatuanKerja($satuan_kerja_id = false){
        if($satuan_kerja_id == false){
            return $this->findAll();
        }

        return $this->where(['id' => $satuan_kerja_id])->first();
    }
    
    public function getSatuanKerjaByKlpdId($klpd_id){
        $builder = $this->db->table('satuan_kerja sk');
        $builder->where('sk.kd_klpd', $klpd_id);

        return $builder->get()->getResultArray();
    }

    public function SatuanKerjaById($kd_satker){
        $builder = $this->db->table('satuan_kerja sk');
        $builder->where('sk.kd_satker', $kd_satker);

        return $builder->get()->getRowArray();
    }

    public function getPaginatedSatuanKerjaData($klpd_id, string $keyword = ''){
        if ($keyword){
            return $this->table('satuan_kerja')->where('satuan_kerja.kd_klpd', $klpd_id)->like('satuan_kerja.nama_satker', $keyword);
        }

        return $this->table('satuan_kerja')->where('satuan_kerja.kd_klpd', $klpd_id);
    }
}