<?php namespace App\Models;

use CodeIgniter\Model;

class GrafikModel extends Model
{
    public function layananByJenisAdvokasiId($jenis_klpd, $tahun, $id){
        $x = ""; $y = ""; $z = "";

        if($tahun)
            $x = "AND YEAR(p.tanggal_pelaksanaan) <= YEAR(pelayanan.tanggal_pelaksanaan)";

        if($jenis_klpd == 'KL'){
            $y = "AND (klpd.jenis_klpd = 'BUMN' 
            OR k.jenis_klpd = 'INSTANSI' 
            OR k.jenis_klpd = 'KEMENTERIAN' 
            OR k.jenis_klpd = 'LEMBAGA' 
            OR k.jenis_klpd = 'PTNBH' 
            OR k.jenis_klpd = 'SWASTA' 
            OR k.jenis_klpd = 'LAINNYA')";
        }else if($jenis_klpd == 'PEMDA'){
            $y = "AND (k.jenis_klpd = 'BUMD' 
            OR k.jenis_klpd = 'KABUPATEN' 
            OR k.jenis_klpd = 'KOTA' 
            OR k.jenis_klpd = 'PROVINSI'
            OR k.jenis_klpd IS NULL)";
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
                LEFT JOIN klpd k ON k.klpd_id = p.klpd_id
                WHERE MONTH(p.tanggal_pelaksanaan) <= MONTH(pelayanan.tanggal_pelaksanaan) $x $y $z
            ) total_pelayanan
        ");

        $builder->join('klpd', 'klpd.klpd_id = pelayanan.klpd_id', 'left');
        $builder->where('YEAR(pelayanan.tanggal_pelaksanaan)', $tahun);

        if($jenis_klpd == 'KL'){
            $builder->Where("
                (klpd.jenis_klpd = 'BUMN' 
                OR klpd.jenis_klpd = 'INSTANSI' 
                OR klpd.jenis_klpd = 'KEMENTERIAN' 
                OR klpd.jenis_klpd = 'LEMBAGA' 
                OR klpd.jenis_klpd = 'PTNBH' 
                OR klpd.jenis_klpd = 'SWASTA' 
                OR klpd.jenis_klpd = 'LAINNYA')
            ");
           
        }else if($jenis_klpd == 'PEMDA'){
            $builder->Where("
                (klpd.jenis_klpd = 'BUMD' 
                OR klpd.jenis_klpd = 'KABUPATEN' 
                OR klpd.jenis_klpd = 'KOTA' 
                OR klpd.jenis_klpd = 'PROVINSI'
                OR klpd.jenis_klpd IS NULL)
            ");
        }

        if($id)
            $builder->where('pelayanan.jenis_advokasi_id', $id);
        
        $builder->groupBy('MONTH(tanggal_pelaksanaan)');

        return $builder->get()->getResultArray();
    }   

    public function valuasiByJenisAdvokasiId($jenis_klpd, $tahun, $id){
        $x = ""; $y = ""; $z = "";

        if($tahun)
            $x = "AND YEAR(p.tanggal_pelaksanaan) <= YEAR(pelayanan.tanggal_pelaksanaan)";

        if($jenis_klpd == 'KL'){
            $y = "AND (klpd.jenis_klpd = 'BUMN' 
            OR k.jenis_klpd = 'INSTANSI' 
            OR k.jenis_klpd = 'KEMENTERIAN' 
            OR k.jenis_klpd = 'LEMBAGA' 
            OR k.jenis_klpd = 'PTNBH' 
            OR k.jenis_klpd = 'SWASTA' 
            OR k.jenis_klpd = 'LAINNYA')";
        }else if($jenis_klpd == 'PEMDA'){
            $y = "AND (k.jenis_klpd = 'BUMD' 
            OR k.jenis_klpd = 'KABUPATEN' 
            OR k.jenis_klpd = 'KOTA' 
            OR k.jenis_klpd = 'PROVINSI'
            OR k.jenis_klpd IS NULL)";
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
                LEFT JOIN klpd k ON k.klpd_id = p.klpd_id
                WHERE MONTH(p.tanggal_pelaksanaan) <= MONTH(pelayanan.tanggal_pelaksanaan) $x $y $z
            ) total_valuasi
        ");
        
        $builder->join('klpd', 'klpd.klpd_id = pelayanan.klpd_id', 'left');
        $builder->where('YEAR(pelayanan.tanggal_pelaksanaan)', $tahun);

        if($jenis_klpd == 'KL'){
            $builder->Where("
                (klpd.jenis_klpd = 'BUMN' 
                OR klpd.jenis_klpd = 'INSTANSI' 
                OR klpd.jenis_klpd = 'KEMENTERIAN' 
                OR klpd.jenis_klpd = 'LEMBAGA' 
                OR klpd.jenis_klpd = 'PTNBH' 
                OR klpd.jenis_klpd = 'SWASTA' 
                OR klpd.jenis_klpd = 'LAINNYA')
            ");
            
        }else if($jenis_klpd == 'PEMDA'){
            $builder->Where("
                (klpd.jenis_klpd = 'BUMD' 
                OR klpd.jenis_klpd = 'KABUPATEN' 
                OR klpd.jenis_klpd = 'KOTA' 
                OR klpd.jenis_klpd = 'PROVINSI'
                OR klpd.jenis_klpd IS NULL)
            ");
        }
        
        if($id)
            $builder->where('pelayanan.jenis_advokasi_id', $id);
            
        $builder->groupBy('MONTH(tanggal_pelaksanaan)');

        return $builder->get()->getResultArray();
    }

    public function layananByKetegoriPermasalahabId($jenis_klpd, $tahun, $id){
        $x = ""; $y = ""; $z = "";

        if($tahun)
            $x = "AND YEAR(p.tanggal_pelaksanaan) <= YEAR(pelayanan.tanggal_pelaksanaan)";

        if($jenis_klpd == 'KL'){
            $y = "AND (klpd.jenis_klpd = 'BUMN' 
            OR k.jenis_klpd = 'INSTANSI' 
            OR k.jenis_klpd = 'KEMENTERIAN' 
            OR k.jenis_klpd = 'LEMBAGA' 
            OR k.jenis_klpd = 'PTNBH' 
            OR k.jenis_klpd = 'SWASTA' 
            OR k.jenis_klpd = 'LAINNYA')";
        }else if($jenis_klpd == 'PEMDA'){
            $y = "AND (k.jenis_klpd = 'BUMD' 
            OR k.jenis_klpd = 'KABUPATEN' 
            OR k.jenis_klpd = 'KOTA' 
            OR k.jenis_klpd = 'PROVINSI'
            OR k.jenis_klpd IS NULL)";
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
                LEFT JOIN klpd k ON k.klpd_id = p.klpd_id
                WHERE MONTH(p.tanggal_pelaksanaan) <= MONTH(pelayanan.tanggal_pelaksanaan) $x $y $z
            ) total_pelayanan
        ");

        $builder->join('klpd', 'klpd.klpd_id = pelayanan.klpd_id', 'left');
        $builder->where('YEAR(pelayanan.tanggal_pelaksanaan)', $tahun);

        if($jenis_klpd == 'KL'){
            $builder->Where("
                (klpd.jenis_klpd = 'BUMN' 
                OR klpd.jenis_klpd = 'INSTANSI' 
                OR klpd.jenis_klpd = 'KEMENTERIAN' 
                OR klpd.jenis_klpd = 'LEMBAGA' 
                OR klpd.jenis_klpd = 'PTNBH' 
                OR klpd.jenis_klpd = 'SWASTA' 
                OR klpd.jenis_klpd = 'LAINNYA')
            ");
            
        }else if($jenis_klpd == 'PEMDA'){
            $builder->Where("
                (klpd.jenis_klpd = 'BUMD' 
                OR klpd.jenis_klpd = 'KABUPATEN' 
                OR klpd.jenis_klpd = 'KOTA' 
                OR klpd.jenis_klpd = 'PROVINSI'
                OR klpd.jenis_klpd IS NULL)
            ");
        }

        if($id)
            $builder->where('pelayanan.kategori_permasalahan_id', $id);
        
        $builder->groupBy('MONTH(tanggal_pelaksanaan)');

        return $builder->get()->getResultArray();
    }   

    public function valuasiByKetegoriPermasalahabId($jenis_klpd, $tahun, $id){
        $x = ""; $y = ""; $z = "";

        if($tahun)
            $x = "AND YEAR(p.tanggal_pelaksanaan) <= YEAR(pelayanan.tanggal_pelaksanaan)";

        if($jenis_klpd == 'KL'){
            $y = "AND (klpd.jenis_klpd = 'BUMN' 
            OR k.jenis_klpd = 'INSTANSI' 
            OR k.jenis_klpd = 'KEMENTERIAN' 
            OR k.jenis_klpd = 'LEMBAGA' 
            OR k.jenis_klpd = 'PTNBH' 
            OR k.jenis_klpd = 'SWASTA' 
            OR k.jenis_klpd = 'LAINNYA')";
        }else if($jenis_klpd == 'PEMDA'){
            $y = "AND (k.jenis_klpd = 'BUMD' 
            OR k.jenis_klpd = 'KABUPATEN' 
            OR k.jenis_klpd = 'KOTA' 
            OR k.jenis_klpd = 'PROVINSI'
            OR k.jenis_klpd IS NULL)";
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
                LEFT JOIN klpd k ON k.klpd_id = p.klpd_id
                WHERE MONTH(p.tanggal_pelaksanaan) <= MONTH(pelayanan.tanggal_pelaksanaan) $x $y $z
            ) total_valuasi
        ");
        
        $builder->join('klpd', 'klpd.klpd_id = pelayanan.klpd_id', 'left');
        $builder->where('YEAR(pelayanan.tanggal_pelaksanaan)', $tahun);
        
        if($jenis_klpd == 'KL'){
            $builder->Where("
                (klpd.jenis_klpd = 'BUMN' 
                OR klpd.jenis_klpd = 'INSTANSI' 
                OR klpd.jenis_klpd = 'KEMENTERIAN' 
                OR klpd.jenis_klpd = 'LEMBAGA' 
                OR klpd.jenis_klpd = 'PTNBH' 
                OR klpd.jenis_klpd = 'SWASTA' 
                OR klpd.jenis_klpd = 'LAINNYA')
            ");
            
        }else if($jenis_klpd == 'PEMDA'){
            $builder->Where("
                (klpd.jenis_klpd = 'BUMD' 
                OR klpd.jenis_klpd = 'KABUPATEN' 
                OR klpd.jenis_klpd = 'KOTA' 
                OR klpd.jenis_klpd = 'PROVINSI'
                OR klpd.jenis_klpd IS NULL)
            ");
        }
        
        if($id)
            $builder->where('pelayanan.kategori_permasalahan_id', $id);
            
        $builder->groupBy('MONTH(tanggal_pelaksanaan)');

        return $builder->get()->getResultArray();
    }

    public function layananByKlpdId($tahun, $id){
        $x = ""; $y = "";

        if($tahun)
            $x = "AND YEAR(p.tanggal_pelaksanaan) <= YEAR(pelayanan.tanggal_pelaksanaan)";

        if($id)
            $y = "AND p.klpd_id = pelayanan.klpd_id";

        $builder = $this->db->table('pelayanan');
        $builder->select("
            MONTH(tanggal_pelaksanaan) bulan
            ,COUNT(*) jumlah_pelayanan
            ,(
                SELECT COUNT(*)
                FROM pelayanan p
                WHERE MONTH(p.tanggal_pelaksanaan) <= MONTH(pelayanan.tanggal_pelaksanaan) $x $y
            ) total_pelayanan
        ");

        $builder->where('YEAR(pelayanan.tanggal_pelaksanaan)', $tahun);

        if($id)
            $builder->where('pelayanan.klpd_id', $id);
        
        $builder->groupBy('MONTH(tanggal_pelaksanaan)');

        return $builder->get()->getResultArray();
    }   

    public function valuasiByKlpdId($tahun, $id){
        $x = ""; $y = "";

        if($tahun)
            $x = "AND YEAR(p.tanggal_pelaksanaan) <= YEAR(pelayanan.tanggal_pelaksanaan)";

        if($id)
            $y = "AND p.klpd_id = pelayanan.klpd_id";

        $builder = $this->db->table('pelayanan');
        $builder->select("
            MONTH(tanggal_pelaksanaan) bulan
            ,SUM(paket_nilai_pagu) jumlah_valuasi
            ,(
                SELECT SUM(p.paket_nilai_pagu) total_valuasi
                FROM pelayanan p
                WHERE MONTH(p.tanggal_pelaksanaan) <= MONTH(pelayanan.tanggal_pelaksanaan) $x $y
            ) total_valuasi
        ");
        
        $builder->where('YEAR(pelayanan.tanggal_pelaksanaan)', $tahun);
        
        if($id)
            $builder->where('pelayanan.klpd_id', $id);
            
        $builder->groupBy('MONTH(tanggal_pelaksanaan)');

        return $builder->get()->getResultArray();
    }

    public function kualitasByKlpdId($bulan = "", $tahun, $id){
        $x = "";

        if($id)
            $x = "AND p.klpd_id = '$id'";

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
                WHERE MONTH(p.tanggal_pelaksanaan) <= '$bulan' AND YEAR(p.tanggal_pelaksanaan) <= '$tahun' $x
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