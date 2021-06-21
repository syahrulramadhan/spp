<?php namespace App\Models;

use CodeIgniter\Model;

class PelayananModel extends Model
{
    protected $table            = 'pelayanan';
    protected $useTimestamps   = true;
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
            $builder->select('
                p.id
                , p.kegiatan_id
                , p.tanggal_pelaksanaan
                , p.nomor_surat_keluar
                , p.nomor_undangan
                , p.nama
                , p.jabatan
                , p.nomor_telepon
                , p.aktifitas
                , p.klpd_id
                , p.klpd_nama
                , p.satuan_kerja_id
                , p.satuan_kerja_nama
                , p.klpd_id_lainnya
                , p.klpd_nama_lainnya
                , p.paket_kode
                , p.paket_nama
                , p.paket_nilai_pagu
                , p.paket_jenis_pengadaan_id
                , p.paket_jenis_pengadaan_nama
                , p.paket_status
                , p.efisiensi
                , p.jenis_advokasi_id
                , p.jenis_advokasi_nama
                , p.kategori_permasalahan_id
                , p.kategori_permasalahan_nama
                , p.keterangan
                , p.created_by
                , klpd.nama_klpd
                , sk.nama_satker
            ');
            
            $builder->join('klpd', 'klpd.klpd_id = p.klpd_id', 'left');
            $builder->join('satuan_kerja sk', 'sk.kd_satker = p.satuan_kerja_id', 'left');
            $builder->orderBy('p.id', 'DESC');
            $builder->limit(10);

            return $builder->get()->getResultArray();
        }

        $builder = $this->db->table('pelayanan p');
        $builder->select('
            p.id,
            , p.kegiatan_id
            , p.tanggal_pelaksanaan
            , p.nomor_surat_keluar
            , p.nomor_undangan
            , p.nama
            , p.jabatan
            , p.nomor_telepon
            , p.aktifitas
            , p.klpd_id
            , p.klpd_nama
            , p.satuan_kerja_id
            , p.satuan_kerja_nama
            , p.klpd_id_lainnya
            , p.klpd_nama_lainnya
            , p.paket_kode
            , p.paket_nama
            , p.paket_nilai_pagu
            , p.paket_jenis_pengadaan_id
            , p.paket_jenis_pengadaan_nama
            , p.paket_status
            , p.efisiensi
            , p.jenis_advokasi_id
            , p.jenis_advokasi_nama
            , p.kategori_permasalahan_id
            , p.kategori_permasalahan_nama
            , p.keterangan
            , p.created_by
            , klpd.nama_klpd
            , sk.nama_satker
            , jp.nama_jenis_pengadaan
            , kp.nama_kategori_permasalahan
        ');
        
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

    public function getPaginatedPelayananData($jenis_advokasi_id = 0, $tahun = '', $sort = '', $keyword = ''){
        $select = '
            pelayanan.kegiatan_id
            , pelayanan.tanggal_pelaksanaan
            , pelayanan.nomor_surat_keluar
            , pelayanan.nomor_undangan
            , pelayanan.nama
            , pelayanan.jabatan
            , pelayanan.nomor_telepon
            , pelayanan.aktifitas
            , pelayanan.klpd_id
            , pelayanan.klpd_nama
            , pelayanan.satuan_kerja_id
            , pelayanan.satuan_kerja_nama
            , pelayanan.klpd_id_lainnya
            , pelayanan.klpd_nama_lainnya
            , pelayanan.paket_kode
            , pelayanan.paket_nama
            , pelayanan.paket_nilai_pagu
            , pelayanan.paket_jenis_pengadaan_id
            , pelayanan.paket_jenis_pengadaan_nama
            , pelayanan.paket_status
            , pelayanan.efisiensi
            , pelayanan.jenis_advokasi_id
            , pelayanan.jenis_advokasi_nama
            , pelayanan.kategori_permasalahan_id
            , pelayanan.kategori_permasalahan_nama
            , pelayanan.keterangan
            , pelayanan.created_by
            , klpd.nama_klpd
            , sk.nama_satker
            , user.nama_depan
            , user.nama_belakang
        ';

        $builder = $this->table('pelayanan');
        $builder->select($select);
        $builder->join('user', 'user.id = pelayanan.created_by', 'left');

        if($jenis_advokasi_id){
            $builder->where('jenis_advokasi_id', $jenis_advokasi_id);
        }

        if($tahun){
            $builder->where('YEAR(tanggal_pelaksanaan)', $tahun);
        }

        if($sort){
            if($sort == 'TglBaru')
                $builder->orderBy('pelayanan.tanggal_pelaksanaan', 'DESC');
            else if($sort == 'TglLama')
                $builder->orderBy('pelayanan.tanggal_pelaksanaan', 'ASC');
            else if($sort == 'NilPaTinggi')
                $builder->orderBy('pelayanan.paket_nilai_pagu', 'DESC');
            else if($sort == 'NilPaRendah')
                $builder->orderBy('pelayanan.paket_nilai_pagu', 'ASC');
        }

        if($keyword){
            $builder->where("(nama LIKE '%$keyword%' OR paket_nama LIKE '%$keyword%')");
        }
        
        return $builder;
    }

    public function ChartPelayananJumlah($jenis_klpd, $tahun){
        $x = ""; $y = "";

        if($tahun)
            $x = "AND YEAR(p.tanggal_pelaksanaan) <= YEAR(pelayanan.tanggal_pelaksanaan)";

        if($jenis_klpd == 'KL'){
            $y = "AND (k.jenis_klpd = 'BUMN' 
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

        $builder = $this->db->table('pelayanan');
        $builder->select("
            MONTH(tanggal_pelaksanaan) bulan
            ,COUNT(*) jumlah_pelayanan
            ,(
                SELECT COUNT(*)
                FROM pelayanan p
                LEFT JOIN klpd k ON k.klpd_id = p.klpd_id
                WHERE MONTH(p.tanggal_pelaksanaan) <= MONTH(pelayanan.tanggal_pelaksanaan) $x $y
            ) total_pelayanan
        ");

        $builder->join('klpd', 'klpd.klpd_id = pelayanan.klpd_id', 'left');
        $builder->where('YEAR(pelayanan.tanggal_pelaksanaan)', $tahun);
        
        //if($jenis_klpd) $builder->where('klpd.jenis_klpd', $jenis_klpd);

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
        
        $builder->groupBy('MONTH(tanggal_pelaksanaan)');

        return $builder->get()->getResultArray();
    }

    public function ChartPelayananValuasi($jenis_klpd, $tahun){
        $x = ""; $y = "";

        if($tahun)
            $x = "AND YEAR(p.tanggal_pelaksanaan) <= YEAR(pelayanan.tanggal_pelaksanaan)";

        if($jenis_klpd == 'KL'){
            $y = "AND (k.jenis_klpd = 'BUMN' 
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

        $builder = $this->db->table('pelayanan');
        $builder->select("
            MONTH(tanggal_pelaksanaan) bulan
            ,SUM(paket_nilai_pagu) jumlah_valuasi
            ,(
                SELECT SUM(p.paket_nilai_pagu) total_valuasi
                FROM pelayanan p
                LEFT JOIN klpd k ON k.klpd_id = p.klpd_id
                WHERE MONTH(p.tanggal_pelaksanaan) <= MONTH(pelayanan.tanggal_pelaksanaan) $x $y
            ) total_valuasi
        ");
        
        $builder->join('klpd', 'klpd.klpd_id = pelayanan.klpd_id', 'left');
        $builder->where('YEAR(pelayanan.tanggal_pelaksanaan)', $tahun);

        //if($jenis_klpd) $builder->where('klpd.jenis_klpd', $jenis_klpd);

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

        $builder->groupBy('MONTH(tanggal_pelaksanaan)');

        return $builder->get()->getResultArray();
    }

    public function ChartPelayananCoverage($jenis_klpd, $tahun){
        $x = ""; $y = "";

        if($tahun)
            $x = "AND YEAR(p.tanggal_pelaksanaan) <= YEAR(pelayanan.tanggal_pelaksanaan)";

        if($jenis_klpd == 'KL'){
            $y = "AND (k.jenis_klpd = 'BUMN' 
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

        $builder = $this->db->table('pelayanan');
        $builder->select("
            MONTH(pelayanan.tanggal_pelaksanaan) bulan
            ,COUNT(DISTINCT(pelayanan.klpd_id)) jumlah_coverage
            ,(
                SELECT COUNT(DISTINCT(p.klpd_id)) total_coverage
                FROM pelayanan p
                LEFT JOIN klpd k ON k.klpd_id = p.klpd_id
                WHERE MONTH(p.tanggal_pelaksanaan) <= MONTH(pelayanan.tanggal_pelaksanaan) $x $y
            ) total_coverage
        ");

        $builder->join('klpd', 'klpd.klpd_id = pelayanan.klpd_id', 'left');
        $builder->where('YEAR(pelayanan.tanggal_pelaksanaan)', $tahun);

        //if($jenis_klpd) $builder->where('klpd.jenis_klpd', $jenis_klpd);
          
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
        
        $builder->groupBy('MONTH(pelayanan.tanggal_pelaksanaan)');

        return $builder->get()->getResultArray();
    }

    public function ChartPelayananKualitas($jenis_klpd, $tahun){
        $sql = "
            SELECT MONTH(pelayanan.tanggal_pelaksanaan) bulan, NILAI_KUALITAS(MONTH(pelayanan.tanggal_pelaksanaan), $tahun) nilai_kualitas
            FROM pelayanan
            GROUP BY MONTH(pelayanan.tanggal_pelaksanaan);
        ";
        
        if($jenis_klpd == 'KL'){
            $sql = "
                SELECT MONTH(pelayanan.tanggal_pelaksanaan) bulan, NILAI_KUALITAS_KL(MONTH(pelayanan.tanggal_pelaksanaan), $tahun) nilai_kualitas
                FROM pelayanan
                GROUP BY MONTH(pelayanan.tanggal_pelaksanaan);
            ";
        }else if($jenis_klpd == 'PEMDA'){
            $sql = "
                SELECT MONTH(pelayanan.tanggal_pelaksanaan) bulan, NILAI_KUALITAS_PEMDA(MONTH(pelayanan.tanggal_pelaksanaan), $tahun) nilai_kualitas
                FROM pelayanan
                GROUP BY MONTH(pelayanan.tanggal_pelaksanaan);
            ";
        }
        $query = $this->db->query($sql);
        
        return $query->getResultArray();
    }

    /*
    public function ChartPelayananKualitas($bulan = "", $jenis_klpd = "", $tahun){
        $x = "";

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

        $query = $this->db->query($q);
        
        return $query->getRow();
    }
    */

    public function overviewLayanan(){
        $q = "SELECT 
            (
                SELECT COUNT(*) 
                FROM pelayanan
            ) overview_layanan,
            (
                SELECT SUM(pelayanan.paket_nilai_pagu) 
                FROM pelayanan
            ) overview_valuasi,   
            (
                SELECT COUNT(DISTINCT(pelayanan.klpd_id))
                FROM pelayanan
            ) overview_coverage
        ";

        $query = $this->db->query($q);
                
        return $query->getRow();
    }

    public function store($data = []){
        $data['created_at'] = date('Y-m-d H:i:s');
		$data['updated_at'] = date('Y-m-d H:i:s');

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