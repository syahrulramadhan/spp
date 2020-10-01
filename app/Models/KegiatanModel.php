<?php namespace App\Models;

use CodeIgniter\Model;

class KegiatanModel extends Model
{
    protected $table            = 'kegiatan';
    protected $userTimestamps   = true;
    protected $allowedFields    = ['nama_kegiatan', 'tanggal_pelaksanaan', 'jenis_advokasi_id', 'jenis_advokasi_nama', 'tahapan', 'jumlah_layanan', 'created_by'];

    public function getKegiatan($kegiatan_id = false){
        if($kegiatan_id == false){
            return $this->findAll();
        }

        return $this->where(['id' => $kegiatan_id])->first();
    }

    public function store($data = []){
        $this->db->table($this->table)->insert($data);

        return $this->db->insertID();
    }
}