<?php namespace App\Controllers;

use App\Models\JenisAdvokasiModel;
use App\Models\LaporanPelayananModel;
use App\Models\LaporanValuasiModel;

class Laporan extends BaseController
{
	protected $picModel;

	public function __construct()
	{
		$this->jenisAdvokasiModel = new JenisAdvokasiModel();
		$this->laporanPelayananModel = new LaporanPelayananModel();
		$this->laporanValuasiModel = new LaporanValuasiModel();
		helper('form');
	}

	public function index($jenis_laporan)
	{
        $format = $this->request->getVar('format');

        if($jenis_laporan == "laporan-valuasi"){
            $title = "Valuasi";
            $result = $this->laporanValuasiModel->getLaporanValuasi();
        }else{
            $title = "Layanan";
            $result = $this->laporanPelayananModel->getLaporanPelayanan();
        }

        $result_jenis_advokasi = $this->jenisAdvokasiModel->getJenisAdvokasi();

        $data = [
            'title' => $title,
            'format' => $format,
			'result' => $result,
			'jenis_laporan' => $jenis_laporan,
			'result_jenis_advokasi' => $result_jenis_advokasi
        ];
        
        if($format == 'xlsx'){
            $date = date('d-m-Y h-i-s');

            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=Data Laporan Layanan " . $date . ".xls");
            
            if($jenis_laporan == "laporan-valuasi")
                return view('Laporan/ekspor_tabel_valuasi', $data);
            else
                return view('Laporan/ekspor_tabel_layanan', $data);
        }else{
            return view('Laporan/index', $data);
        }
    }
}