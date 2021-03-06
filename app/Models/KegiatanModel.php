<?php namespace App\Models;

use CodeIgniter\Model;

class KegiatanModel extends Model
{
    protected $table            = 'kegiatan';
    protected $useTimestamps   = true;
    protected $allowedFields    = ['nama_kegiatan', 'tanggal_pelaksanaan', 'jenis_advokasi_id', 'jenis_advokasi_nama', 'tahapan', 'jumlah_layanan', 'created_by'];

    public function getKegiatan($kegiatan_id = false){
        if($kegiatan_id == false){
            //return $this->findAll();

            $builder = $this->db->table('kegiatan k');
            $builder->select(
                'k.id
                , k.nama_kegiatan
                , k.tanggal_pelaksanaan
                , k.jenis_advokasi_id
                , k.jenis_advokasi_nama
                , k.tahapan
                , (
                    SELECT COUNT(*)
                    FROM pelayanan
                    WHERE pelayanan.kegiatan_id = k.id
                    GROUP BY pelayanan.kegiatan_id
                ) jumlah_pelayanan
            ');

            return $builder->get()->getResultArray();
        }

        return $this->where(['id' => $kegiatan_id])->first();
    }

    public function store($data = []){
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        $this->db->table($this->table)->insert($data);

        return $this->db->insertID();
    }

    public function getPaginatedKegiatanData($jenis_advokasi_id = 0, $tahun = '', $keyword = ''){
        $select = '
            kegiatan.id
            , kegiatan.nama_kegiatan
            , kegiatan.tanggal_pelaksanaan
            , kegiatan.jenis_advokasi_id
            , kegiatan.jenis_advokasi_nama
            , kegiatan.tahapan
            , user.nama_depan
            , user.nama_belakang
            , (
                SELECT COUNT(*)
                FROM pelayanan
                WHERE pelayanan.kegiatan_id = kegiatan.id
                GROUP BY pelayanan.kegiatan_id
            ) jumlah_pelayanan
        ';

        $builder = $this->table('kegiatan');
        $builder->select($select);
        $builder->join('user', 'user.id = kegiatan.created_by', 'left');

        if($jenis_advokasi_id){
            $builder->where('jenis_advokasi_id', $jenis_advokasi_id);
        }

        if($tahun){
            $builder->where('YEAR(tanggal_pelaksanaan)', $tahun);
        }

        if($keyword){
            $builder->like('kegiatan.nama_kegiatan', $keyword);
        }

        return $builder;
    }
}