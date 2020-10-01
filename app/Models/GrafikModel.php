<?php namespace App\Models;

use CodeIgniter\Model;

class GrafikModel extends Model
{
    public function layananByJenisAdvokasiId($jenis_klpd, $tahun, $id){
        $x = ""; $y = ""; $z = ""; $jy = "";

        if($tahun)
            $x = "AND YEAR(p.tanggal_pelaksanaan) <= YEAR(pelayanan.tanggal_pelaksanaan)";

        if($jenis_klpd){
            $y = "AND k.jenis_klpd = klpd.jenis_klpd";
            $jy = "JOIN klpd k ON k.klpd_id = p.klpd_id";
        }

        if($id)
            $z = "AND p.jenis_advokasi_id = pelayanan.jenis_advokasi_id";

        $builder = $this->db->table('pelayanan');
        $builder->select("
            MONTH(tanggal_pelaksanaan) bulan
            ,COUNT(*) jumlah_pelayanan
            ,(
                SELECT COUNT(*)
                FROM pelayanan p
                $jy
                WHERE MONTH(p.tanggal_pelaksanaan) <= MONTH(pelayanan.tanggal_pelaksanaan) $x $y $z
            ) total_pelayanan
        ");

        $builder->where('YEAR(pelayanan.tanggal_pelaksanaan)', $tahun);
        
        if($jenis_klpd){
            $builder->join('klpd', 'klpd.klpd_id = pelayanan.klpd_id', 'left');
            $builder->where('klpd.jenis_klpd', $jenis_klpd);
        }

        if($id)
            $builder->where('pelayanan.jenis_advokasi_id', $id);
        
        $builder->groupBy('MONTH(tanggal_pelaksanaan)');

        return $builder->get()->getResultArray();
    }   

    public function valuasiByJenisAdvokasiId($jenis_klpd, $tahun, $id){
        $x = ""; $y = ""; $z = ""; $jy = "";

        if($tahun)
            $x = "AND YEAR(p.tanggal_pelaksanaan) <= YEAR(pelayanan.tanggal_pelaksanaan)";

        if($jenis_klpd){
            $y = "AND k.jenis_klpd = klpd.jenis_klpd";
            $jy = "JOIN klpd k ON k.klpd_id = p.klpd_id";
        }

        if($id)
            $z = "AND p.jenis_advokasi_id = pelayanan.jenis_advokasi_id";

        $builder = $this->db->table('pelayanan');
        $builder->select("
            MONTH(tanggal_pelaksanaan) bulan
            ,SUM(paket_nilai_pagu) jumlah_valuasi
            ,(
                SELECT SUM(p.paket_nilai_pagu) total_valuasi
                FROM pelayanan p
                $jy
                WHERE MONTH(p.tanggal_pelaksanaan) <= MONTH(pelayanan.tanggal_pelaksanaan) $x $y $z
            ) total_valuasi
        ");
        
        $builder->where('YEAR(pelayanan.tanggal_pelaksanaan)', $tahun);

        if($jenis_klpd){
            $builder->join('klpd', 'klpd.klpd_id = pelayanan.klpd_id', 'left');
            $builder->where('klpd.jenis_klpd', $jenis_klpd);
        }
        
        if($id)
            $builder->where('pelayanan.jenis_advokasi_id', $id);
            
        $builder->groupBy('MONTH(tanggal_pelaksanaan)');

        return $builder->get()->getResultArray();
    }

    public function layananByKetegoriPermasalahabId($jenis_klpd, $tahun, $id){
        $x = ""; $y = ""; $z = ""; $jy = "";

        if($tahun)
            $x = "AND YEAR(p.tanggal_pelaksanaan) <= YEAR(pelayanan.tanggal_pelaksanaan)";

        if($jenis_klpd){
            $y = "AND k.jenis_klpd = klpd.jenis_klpd";
            $jy = "JOIN klpd k ON k.klpd_id = p.klpd_id";
        }

        if($id)
            $z = "AND p.kategori_permasalahan_id = pelayanan.kategori_permasalahan_id";

        $builder = $this->db->table('pelayanan');
        $builder->select("
            MONTH(tanggal_pelaksanaan) bulan
            ,COUNT(*) jumlah_pelayanan
            ,(
                SELECT COUNT(*)
                FROM pelayanan p
                $jy
                WHERE MONTH(p.tanggal_pelaksanaan) <= MONTH(pelayanan.tanggal_pelaksanaan) $x $y $z
            ) total_pelayanan
        ");

        $builder->where('YEAR(pelayanan.tanggal_pelaksanaan)', $tahun);
        
        if($jenis_klpd){
            $builder->join('klpd', 'klpd.klpd_id = pelayanan.klpd_id', 'left');
            $builder->where('klpd.jenis_klpd', $jenis_klpd);
        }

        if($id)
            $builder->where('pelayanan.kategori_permasalahan_id', $id);
        
        $builder->groupBy('MONTH(tanggal_pelaksanaan)');

        return $builder->get()->getResultArray();
    }   

    public function valuasiByKetegoriPermasalahabId($jenis_klpd, $tahun, $id){
        $x = ""; $y = ""; $z = ""; $jy = "";

        if($tahun)
            $x = "AND YEAR(p.tanggal_pelaksanaan) <= YEAR(pelayanan.tanggal_pelaksanaan)";

        if($jenis_klpd){
            $y = "AND k.jenis_klpd = klpd.jenis_klpd";
            $jy = "JOIN klpd k ON k.klpd_id = p.klpd_id";
        }

        if($id)
            $z = "AND p.kategori_permasalahan_id = pelayanan.kategori_permasalahan_id";

        $builder = $this->db->table('pelayanan');
        $builder->select("
            MONTH(tanggal_pelaksanaan) bulan
            ,SUM(paket_nilai_pagu) jumlah_valuasi
            ,(
                SELECT SUM(p.paket_nilai_pagu) total_valuasi
                FROM pelayanan p
                $jy
                WHERE MONTH(p.tanggal_pelaksanaan) <= MONTH(pelayanan.tanggal_pelaksanaan) $x $y $z
            ) total_valuasi
        ");
        
        $builder->where('YEAR(pelayanan.tanggal_pelaksanaan)', $tahun);

        if($jenis_klpd){
            $builder->join('klpd', 'klpd.klpd_id = pelayanan.klpd_id', 'left');
            $builder->where('klpd.jenis_klpd', $jenis_klpd);
        }
        
        if($id)
            $builder->where('pelayanan.kategori_permasalahan_id', $id);
            
        $builder->groupBy('MONTH(tanggal_pelaksanaan)');

        return $builder->get()->getResultArray();
    }

    public function layananByKlpdId($jenis_klpd, $tahun, $id){
        $x = ""; $y = ""; $z = ""; $jy = "";

        if($tahun)
            $x = "AND YEAR(p.tanggal_pelaksanaan) <= YEAR(pelayanan.tanggal_pelaksanaan)";

        if($jenis_klpd){
            $y = "AND k.jenis_klpd = klpd.jenis_klpd";
            $jy = "JOIN klpd k ON k.klpd_id = p.klpd_id";
        }

        if($id)
            $z = "AND p.klpd_id = pelayanan.klpd_id";

        $builder = $this->db->table('pelayanan');
        $builder->select("
            MONTH(tanggal_pelaksanaan) bulan
            ,COUNT(*) jumlah_pelayanan
            ,(
                SELECT COUNT(*)
                FROM pelayanan p
                $jy
                WHERE MONTH(p.tanggal_pelaksanaan) <= MONTH(pelayanan.tanggal_pelaksanaan) $x $y $z
            ) total_pelayanan
        ");

        $builder->where('YEAR(pelayanan.tanggal_pelaksanaan)', $tahun);
        
        if($jenis_klpd){
            $builder->join('klpd', 'klpd.klpd_id = pelayanan.klpd_id', 'left');
            $builder->where('klpd.jenis_klpd', $jenis_klpd);
        }

        if($id)
            $builder->where('pelayanan.klpd_id', $id);
        
        $builder->groupBy('MONTH(tanggal_pelaksanaan)');

        return $builder->get()->getResultArray();
    }   

    public function valuasiByKlpdId($jenis_klpd, $tahun, $id){
        $x = ""; $y = ""; $z = ""; $jy = "";

        if($tahun)
            $x = "AND YEAR(p.tanggal_pelaksanaan) <= YEAR(pelayanan.tanggal_pelaksanaan)";

        if($jenis_klpd){
            $y = "AND k.jenis_klpd = klpd.jenis_klpd";
            $jy = "JOIN klpd k ON k.klpd_id = p.klpd_id";
        }

        if($id)
            $z = "AND p.klpd_id = pelayanan.klpd_id";

        $builder = $this->db->table('pelayanan');
        $builder->select("
            MONTH(tanggal_pelaksanaan) bulan
            ,SUM(paket_nilai_pagu) jumlah_valuasi
            ,(
                SELECT SUM(p.paket_nilai_pagu) total_valuasi
                FROM pelayanan p
                $jy
                WHERE MONTH(p.tanggal_pelaksanaan) <= MONTH(pelayanan.tanggal_pelaksanaan) $x $y $z
            ) total_valuasi
        ");
        
        $builder->where('YEAR(pelayanan.tanggal_pelaksanaan)', $tahun);

        if($jenis_klpd){
            $builder->join('klpd', 'klpd.klpd_id = pelayanan.klpd_id', 'left');
            $builder->where('klpd.jenis_klpd', $jenis_klpd);
        }
        
        if($id)
            $builder->where('pelayanan.klpd_id', $id);
            
        $builder->groupBy('MONTH(tanggal_pelaksanaan)');

        return $builder->get()->getResultArray();
    }

    public function kualitasByKlpdId($bulan = "", $jenis_klpd = "", $tahun, $id){
        $x = ""; $y = ""; $jx = "";

        if($jenis_klpd){
            $x = "AND k.jenis_klpd = '$jenis_klpd'";
            $jx = "JOIN klpd k ON k.klpd_id = p.klpd_id";
        }

        if($id)
            $y = "AND p.klpd_id = '$id'";

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
                $jx
                WHERE MONTH(p.tanggal_pelaksanaan) <= '$bulan' AND YEAR(p.tanggal_pelaksanaan) <= '$tahun' $x $y
                GROUP BY p.klpd_id
            ) temp
        ";

        $query = $this->db->query($q);
        
        return $query->getRow();
    }

    public function layananByJenisPengadaanId($jenis_klpd, $tahun, $id){
        $x = ""; $y = ""; $z = ""; $jy = "";

        if($tahun)
            $x = "AND YEAR(p.tanggal_pelaksanaan) <= YEAR(pelayanan.tanggal_pelaksanaan)";

        if($jenis_klpd){
            $y = "AND k.jenis_klpd = klpd.jenis_klpd";
            $jy = "JOIN klpd k ON k.klpd_id = p.klpd_id";
        }

        if($id)
            $z = "AND p.paket_jenis_pengadaan_id = pelayanan.paket_jenis_pengadaan_id";

        $builder = $this->db->table('pelayanan');
        $builder->select("
            MONTH(tanggal_pelaksanaan) bulan
            ,COUNT(*) jumlah_pelayanan
            ,(
                SELECT COUNT(*)
                FROM pelayanan p
                $jy
                WHERE MONTH(p.tanggal_pelaksanaan) <= MONTH(pelayanan.tanggal_pelaksanaan) $x $y $z
            ) total_pelayanan
        ");

        $builder->where('YEAR(pelayanan.tanggal_pelaksanaan)', $tahun);
        
        if($jenis_klpd){
            $builder->join('klpd', 'klpd.klpd_id = pelayanan.klpd_id', 'left');
            $builder->where('klpd.jenis_klpd', $jenis_klpd);
        }

        if($id)
            $builder->where('pelayanan.paket_jenis_pengadaan_id', $id);
        
        $builder->groupBy('MONTH(tanggal_pelaksanaan)');

        return $builder->get()->getResultArray();
    }   

    public function valuasiByJenisPengadaanId($jenis_klpd, $tahun, $id){
        $x = ""; $y = ""; $z = ""; $jy = "";

        if($tahun)
            $x = "AND YEAR(p.tanggal_pelaksanaan) <= YEAR(pelayanan.tanggal_pelaksanaan)";

        if($jenis_klpd){
            $y = "AND k.jenis_klpd = klpd.jenis_klpd";
            $jy = "JOIN klpd k ON k.klpd_id = p.klpd_id";
        }

        if($id)
            $z = "AND p.paket_jenis_pengadaan_id = pelayanan.paket_jenis_pengadaan_id";

        $builder = $this->db->table('pelayanan');
        $builder->select("
            MONTH(tanggal_pelaksanaan) bulan
            ,SUM(paket_nilai_pagu) jumlah_valuasi
            ,(
                SELECT SUM(p.paket_nilai_pagu) total_valuasi
                FROM pelayanan p
                $jy
                WHERE MONTH(p.tanggal_pelaksanaan) <= MONTH(pelayanan.tanggal_pelaksanaan) $x $y $z
            ) total_valuasi
        ");
        
        $builder->where('YEAR(pelayanan.tanggal_pelaksanaan)', $tahun);

        if($jenis_klpd){
            $builder->join('klpd', 'klpd.klpd_id = pelayanan.klpd_id', 'left');
            $builder->where('klpd.jenis_klpd', $jenis_klpd);
        }
        
        if($id)
            $builder->where('pelayanan.paket_jenis_pengadaan_id', $id);
            
        $builder->groupBy('MONTH(tanggal_pelaksanaan)');

        return $builder->get()->getResultArray();
    }
}