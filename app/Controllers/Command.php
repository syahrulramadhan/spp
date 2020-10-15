<?php namespace App\Controllers;

use App\Models\KlpdModel;
use App\Models\LaporanPelayananModel;
use App\Models\LaporanValuasiModel;
use App\Models\SatuanKerjaModel;

class Command extends BaseController
{
	protected $klpdModel;
	protected $laporanPelayananModel;
	protected $laporanValuasiModel;
	protected $satuanKerjaModel;

	public function __construct()
	{
		$this->klpdModel = new KlpdModel();
		$this->laporanPelayananModel = new LaporanPelayananModel();
		$this->laporanValuasiModel = new LaporanValuasiModel();
		$this->satuanKerjaModel = new SatuanKerjaModel();
        helper(['form', 'url']);
        
        ini_set("display_errors", "1");
	}

	public function index()
	{
		
    }

    public function crawlKlpd(){
        ini_set('max_execution_time', 3600);

		$result = json_decode($this->getKlpd());
		$number = 1;
		
		foreach ($result as $row) {
            $cek = $this->klpdModel->klpdById($row->id);

            //echo "<pre>"; print_r($cek);
            
			if ($cek) {
				$data = [
                    'id' => $cek['id'],
					'klpd_id' => $row->id,
					'nama_klpd' => $row->nama,
					'jenis_klpd' => $row->jenis,
                    'website' => $row->website,
                    'kd_propinsi' => $row->prp_id,
					'kd_kabupaten' => $row->kbp_id,
					'is_not_rekap_display' => $row->isNotRekapDisplay,
					'is2014' => $row->is2014,
					'is2015' => $row->is2015,
					'is2016' => $row->is2016,
					'is2017' => $row->is2017,
					'is2018' => $row->is2018,
					'is2019' => $row->is2019,
                    'is2020' => $row->is2020,
                    'updated_at' => $this->getDateTime()
                ];

                //echo "<pre>"; print_r($data); exit; 

                $this->klpdModel->save($data);

				echo $number . ". " . $row->nama . " Berhasil diperbarui";
                echo "\n";
			}else{
				$data = [
					'klpd_id' => $row->id,
					'nama_klpd' => $row->nama,
					'jenis_klpd' => $row->jenis,
                    'website' => $row->website,
                    'kd_propinsi' => $row->prp_id,
					'kd_kabupaten' => $row->kbp_id,
					'is_not_rekap_display' => $row->isNotRekapDisplay,
					'is2014' => $row->is2014,
					'is2015' => $row->is2015,
					'is2016' => $row->is2016,
					'is2017' => $row->is2017,
					'is2018' => $row->is2018,
					'is2019' => $row->is2019,
					'is2020' => $row->is2020,
					'created_at' => $this->getDateTime()
                ];
                
                //echo "<pre>"; print_r($data); exit; 

                $this->klpdModel->save($data);

                $data1 = [
					'klpd_id' => $row->id
                ];

                $data2 = [
					'klpd_id' => $row->id
                ];

                $this->laporanPelayananModel->save($data1);
                $this->laporanValuasiModel->save($data2);

				echo $number . ". " . $row->nama . " Berhasil dimasukkan";
				echo "\n";
            }

            $this->crawlSatuanKerja($row->id);

            $number++;
		}
    }
    
    public function crawlSatuanKerja($klpd_id = NULL){
        if($klpd_id){
            $result = json_decode($this->getSatker($klpd_id));

            $number = 1;
            
            foreach ($result as $row) {
                $cek = $this->satuanKerjaModel->SatuanKerjaById($row->id);

                //echo "<pre>"; print_r($cek); exit; 

                if ($cek) {
                    $data = array(
                        'id' => $cek['id'],
                        'kd_satker' => $row->id,
                        'kd_satker_str' => $row->idSatker,
                        'kd_klpd' => $row->idKldi,
                        'nama_satker' => $row->nama,
                        //'id_deleted' => $row->isDeleted,
                        //'audit_update' => $row->auditupdate,
                        'tahun_aktif' => $row->tahunAktif,
                        'updated_at' => $this->getDateTime()
                    );

                    //echo "<pre>"; print_r($data); exit; 

                    $this->satuanKerjaModel->save($data);
                    
                    echo $number . ". " . $row->nama . " Berhasil diperbarui";
                    echo "\n";
                }else{
                
                    $data = array(
                        'kd_satker' => $row->id,
                        'kd_satker_str' => $row->idSatker,
                        'kd_klpd' => $row->idKldi,
                        'nama_satker' => $row->nama,
                        //'id_deleted' => $row->isDeleted,
                        //'audit_update' => $row->auditupdate,
                        'tahun_aktif' => $row->tahunAktif,
                        'created_at' => $this->getDateTime()
                    );
                    
                    //echo "<pre>"; print_r($data); exit; 
                    
                    $this->satuanKerjaModel->save($data);
                    
                    echo $number . ". " . $row->nama . " Berhasil dimasukkan";
                    echo "\n";
                }
                
                $number++;
            }
        }
	}
    
    public function getKlpd(){
		$url = 'https://sirup.lkpp.go.id/sirup/service/daftarKLDI';
		$response = $this->curl_data($url);

        //echo "<pre>"; print_r($response); exit;

		if($response){
			return $response;
		}

		return false;
    }
    
    public function getSatker($klpd = NULL){
		if($klpd){
			$url = 'https://sirup.lkpp.go.id/sirup/service/daftarSatkerByKLDI?kldi=' . $klpd;
			$response = $this->curl_data($url);
		
			return $response;
		} /*else{
			$url = 'https://sirup.lkpp.go.id/sirup/service/daftarSatkerByKLDI';
			$response = $this->curl_data($url);
		
			return $response;
		}*/

		return false;
	}
}