<?php namespace App\Models;

use CodeIgniter\Model;

class PelayananModel extends Model
{
    protected $table            = 'pelayanan';
    protected $userTimestamps   = true;
    protected $allowedFields    = ['kegiatan_id', 'tanggal_pelaksanaan', 'nomor_surat_keluar', 'nomor_undangan', 'nama', 'jabatan', 'nomor_telepon', 'aktifitas', 'klpd_id', 'klpd_nama', 'satuan_kerja_id', 'satuan_kerja_nama', 'klpd_id_lainnya', 'klpd_nama_lainnya', 'paket_kode', 'paket_nama', 'paket_nilai_pagu', 'paket_jenis_pengadaan_id', 'paket_jenis_pengadaan_nama', 'paket_status', 'efisiensi', 'jenis_advokasi_id', 'jenis_advokasi_nama', 'kategori_permasalahan_id', 'kategori_permasalahan_nama', 'keterangan', 'created_by'];

    public function getPelayanan($pelayanan_id = false){
        if($pelayanan_id == false){
            return $this->findAll();
        }

        return $this->where(['id' => $pelayanan_id])->first();
    }

    public function getPelayananJoin($pelayanan_id = false){
        if($pelayanan_id == false){
            $builder = $this->db->table('pelayanan p');
            $builder->select('p.*, klpd.nama_klpd, sk.nama_satker');
            $builder->join('klpd', 'klpd.klpd_id = p.klpd_id', 'left');
            $builder->join('satuan_kerja sk', 'sk.kd_satker = p.satuan_kerja_id', 'left');
            $builder->orderBy('p.id', 'DESC');

            return $builder->get()->getResultArray();
        }

        $builder = $this->db->table('pelayanan p');
        $builder->select('p.*, klpd.nama_klpd, sk.nama_satker, jp.nama_jenis_pengadaan, kp.nama_kategori_permasalahan');
        $builder->join('klpd', 'klpd.klpd_id = p.klpd_id', 'left');
        $builder->join('satuan_kerja sk', 'sk.kd_satker = p.satuan_kerja_id', 'left');
        $builder->join('jenis_pengadaan jp', 'jp.id = p.paket_jenis_pengadaan_id', 'left');
        $builder->join('kategori_permasalahan kp', 'kp.id = p.kategori_permasalahan_id', 'left');
        $builder->where('p.id', $pelayanan_id);
        $builder->orderBy('p.id', 'DESC');

        return $builder->get()->getRowArray();
    }

    public function getPelayananByKegiatanId($kegiatan_id){
        $builder = $this->db->table('pelayanan p');
        $builder->select('p.*, klpd.nama_klpd klpd_nama, sk.nama_satker satuan_kerja_nama');
        $builder->join('klpd', 'klpd.klpd_id = p.klpd_id', 'left');
        $builder->join('satuan_kerja sk', 'sk.kd_satker = p.satuan_kerja_id', 'left');
        $builder->where('p.kegiatan_id', $kegiatan_id);
        $builder->orderBy('p.id', 'DESC');

        return $builder->get()->getResultArray();
    }

    public function search($q){
        return $this->table('pelayanan')->like('nama', $q)->orLike('paket_nama', $q);
    }

    public function ChartPelayananJumlah($jenis_klpd, $tahun){
        $x = ""; $y = "";

        if($jenis_klpd)
            $x = "AND k.jenis_klpd = klpd.jenis_klpd";

        if($tahun)
            $y = "AND YEAR(p.tanggal_pelaksanaan) <= YEAR(pelayanan.tanggal_pelaksanaan)";

        $builder = $this->db->table('pelayanan');
        $builder->select("
            MONTH(tanggal_pelaksanaan) bulan
            ,COUNT(*) jumlah_pelayanan
            ,(
                SELECT COUNT(*)
                FROM pelayanan p
                JOIN klpd k ON k.klpd_id = p.klpd_id
                WHERE MONTH(p.tanggal_pelaksanaan) <= MONTH(pelayanan.tanggal_pelaksanaan) $x $y
            ) total_pelayanan
        ");

        $builder->join('klpd', 'klpd.klpd_id = pelayanan.klpd_id', 'left');
        $builder->where('YEAR(pelayanan.tanggal_pelaksanaan)', $tahun);
        
        if($jenis_klpd)
            $builder->where('klpd.jenis_klpd', $jenis_klpd);
        
        $builder->groupBy('MONTH(tanggal_pelaksanaan)');

        return $builder->get()->getResultArray();
    }

    public function ChartPelayananValuasi($jenis_klpd, $tahun){
        $x = ""; $y = "";

        if($jenis_klpd)
            $x = "AND k.jenis_klpd = klpd.jenis_klpd";

        if($tahun)
            $y = "AND YEAR(p.tanggal_pelaksanaan) <= YEAR(pelayanan.tanggal_pelaksanaan)";

        $builder = $this->db->table('pelayanan');
        $builder->select("
            MONTH(tanggal_pelaksanaan) bulan
            ,SUM(paket_nilai_pagu) jumlah_valuasi
            ,(
                SELECT SUM(p.paket_nilai_pagu) total_valuasi
                FROM pelayanan p
                JOIN klpd k ON k.klpd_id = p.klpd_id
                WHERE MONTH(p.tanggal_pelaksanaan) <= MONTH(pelayanan.tanggal_pelaksanaan) $x $y
            ) total_valuasi
        ");
        
        $builder->join('klpd', 'klpd.klpd_id = pelayanan.klpd_id', 'left');
        $builder->where('YEAR(pelayanan.tanggal_pelaksanaan)', $tahun);

        if($jenis_klpd)
            $builder->where('klpd.jenis_klpd', $jenis_klpd);
            
        $builder->groupBy('MONTH(tanggal_pelaksanaan)');

        return $builder->get()->getResultArray();
    }

    public function ChartPelayananCoverage($jenis_klpd, $tahun){
        $x = ""; $y = "";

        if($jenis_klpd)
            $x = "AND k.jenis_klpd = klpd.jenis_klpd";

        if($tahun)
            $y = "AND YEAR(p.tanggal_pelaksanaan) <= YEAR(pelayanan.tanggal_pelaksanaan)";

        $builder = $this->db->table('pelayanan');
        $builder->select("
            MONTH(pelayanan.tanggal_pelaksanaan) bulan
            ,COUNT(DISTINCT(pelayanan.klpd_id)) jumlah_coverage
            ,(
                SELECT COUNT(DISTINCT(p.klpd_id)) total_coverage
                FROM pelayanan p
                JOIN klpd k ON k.klpd_id = p.klpd_id
                WHERE MONTH(p.tanggal_pelaksanaan) <= MONTH(pelayanan.tanggal_pelaksanaan) $x $y
            ) total_coverage
        ");

        $builder->join('klpd', 'klpd.klpd_id = pelayanan.klpd_id', 'left');
        $builder->where('YEAR(pelayanan.tanggal_pelaksanaan)', $tahun);

        if($jenis_klpd)
            $builder->where('klpd.jenis_klpd', $jenis_klpd);
            
        $builder->groupBy('MONTH(pelayanan.tanggal_pelaksanaan)');

        return $builder->get()->getResultArray();
    }

    public function ChartPelayananKualitas($bulan = "", $jenis_klpd = "", $tahun){
        $x = "";

        if($jenis_klpd)
            $x = "AND k.jenis_klpd = '$jenis_klpd'";

        $q = "
            SELECT SUM(temp.jumlah_kualitas) total_kualitas
            FROM(
                SELECT 
                    COUNT(DISTINCT(jenis_advokasi_id)) AS jumlah_layanan       
                    ,(CASE 
                            WHEN COUNT(DISTINCT(jenis_advokasi_id)) >= 6 && COUNT(DISTINCT(jenis_advokasi_id)) <= 9 THEN 100
                            WHEN COUNT(DISTINCT(jenis_advokasi_id)) >= 4 && COUNT(DISTINCT(jenis_advokasi_id)) <= 5 THEN 75
                            WHEN COUNT(DISTINCT(jenis_advokasi_id)) >= 2 && COUNT(DISTINCT(jenis_advokasi_id)) <= 3 THEN 50
                            WHEN COUNT(DISTINCT(jenis_advokasi_id)) = 1 THEN 25
                            WHEN COUNT(DISTINCT(jenis_advokasi_id)) = 0 THEN 0
                        END) jumlah_kualitas
                FROM pelayanan p
                JOIN klpd k ON k.klpd_id = p.klpd_id
                WHERE MONTH(p.tanggal_pelaksanaan) <= '$bulan' AND YEAR(p.tanggal_pelaksanaan) <= '$tahun' $x
                GROUP BY p.klpd_id
            ) temp
        ";

        //echo"<pre>"; echo $q; exit;

        $query = $this->db->query($q);
        
        return $query->getRow();
    }

    public function xChartPelayananKualitas(){
        $query = $this->db->query("
            SELECT 
                p.jumlah_kualitas skor,
                COUNT(p.jumlah_kualitas) as jumlah_kualitas
            FROM (
                SELECT 
                klpd_id,     
                jenis_advokasi_id,     
                tanggal_pelaksanaan,
                COUNT(DISTINCT(jenis_advokasi_id)) AS jumlah_layanan,     
                (CASE 
                    WHEN COUNT(DISTINCT(jenis_advokasi_id)) >= 6 && COUNT(DISTINCT(jenis_advokasi_id)) <= 9 THEN 100
                    WHEN COUNT(DISTINCT(jenis_advokasi_id)) >= 4 && COUNT(DISTINCT(jenis_advokasi_id)) <= 5 THEN 75
                    WHEN COUNT(DISTINCT(jenis_advokasi_id)) >= 2 && COUNT(DISTINCT(jenis_advokasi_id)) <= 3 THEN 50
                    WHEN COUNT(DISTINCT(jenis_advokasi_id)) = 1 THEN 25
                    WHEN COUNT(DISTINCT(jenis_advokasi_id)) = 0 THEN 0
                END) AS jumlah_kualitas
                FROM pelayanan 
                GROUP BY klpd_id
            ) p
            GROUP BY P.jumlah_kualitas"
        );
        
        return $query->getResultArray();
    }

    public function store($data = []){
        $this->db->table($this->table)->insert($data);

        return $this->db->insertID();
    }

    public function getTahunLayanan(){
        $builder = $this->db->table('pelayanan');

        $builder->select('YEAR(pelayanan.tanggal_pelaksanaan) tahun');
        $builder->groupBy('YEAR(pelayanan.tanggal_pelaksanaan)');
        
        return $builder->get()->getResultArray();
    }

    public function getJenisAdvokasiByKlpdId($id){
        $builder = $this->db->table('pelayanan');

        $builder->select('DISTINCT(pelayanan.jenis_advokasi_id), pelayanan.jenis_advokasi_nama, count(pelayanan.klpd_id) jumlah_layanan');
        $builder->where('pelayanan.klpd_id', $id);
        $builder->groupBy('pelayanan.jenis_advokasi_id');
        
        return $builder->get()->getResultArray();
    }

    public function getKegiatanByKlpdId($id){
        $builder = $this->db->table('pelayanan p');

        $builder->select('k.nama_kegiatan, k.tanggal_pelaksanaan');
        $builder->where('p.klpd_id', $id);
        $builder->join('kegiatan k', 'k.id = p.kegiatan_id');
        
        return $builder->get()->getResultArray();
    }
}