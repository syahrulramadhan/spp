<?php
namespace App\Controllers;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */

use CodeIgniter\Controller;

class BaseController extends Controller
{

	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = [];

	/**
	 * Constructor.
	 */
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.:
		// $this->session = \Config\Services::session();
	}

	public function jenis_advokasi_all()
	{
		$result = $this->jenisAdvokasiModel->getJenisAdvokasi();

		return $result;
	}

	function dateOutput($dateInput){
		$dateOutput = NULL;

		if($dateInput){
			$dateInput = explode('/', $dateInput);
			$dateOutput = $dateInput[2] . '-' . $dateInput[0] . '-' . $dateInput[1];
		}

		return $dateOutput;
	}

	function dateInput($dateOutput){
		$dateInput = NULL;

		if($dateOutput){
			$dateOutput = explode('-', $dateOutput);
			$dateInput = $dateOutput[1] . '/' . $dateOutput[2] . '/' . $dateOutput[0];
		}

		return $dateInput;
	}

	function tanggalid($tgl){
		if($this->is_date($tgl)){
			$ubah = gmdate($tgl, time()+60*60*8);
			$pecah = explode("-",$ubah);
			$tanggal = $pecah[2];
			$bulan = $this->bulan($pecah[1]);
			$tahun = $pecah[0];

			return $tanggal.' '.$bulan.' '.$tahun;
		}else{
			return "-";
		}
	}

	function bulan($bln){
		switch ($bln){
			case 1:
				return "Jan";
				break;
			case 2:
				return "Feb";
				break;
			case 3:
				return "Mar";
				break;
			case 4:
				return "Apr";
				break;
			case 5:
				return "Mei";
				break;
			case 6:
				return "Jun";
				break;
			case 7:
				return "Jul";
				break;
			case 8:
				return "Agu";
				break;
			case 9:
				return "Sep";
				break;
			case 10:
				return "Okt";
				break;
			case 11:
				return "Nov";
				break;
			case 12:
				return "Des";
				break;
		}
	}
	
	function is_date($str){
		$stamp = strtotime( $str );
		if (!is_numeric($stamp)){
			return FALSE;
		}

		$month = date( 'm', $stamp );
		$day   = date( 'd', $stamp );
		$year  = date( 'Y', $stamp );

		if (checkdate($month, $day, $year)){
			return TRUE;
		}
		return FALSE;
	}

	function hariid($tanggal){
		$ubah = gmdate($tanggal, time()+60*60*8);
		$pecah = explode("-",$ubah);
		$tgl = $pecah[2];
		$bln = $pecah[1];
		$thn = $pecah[0];

		$nama = date("l", mktime(0,0,0,$bln,$tgl,$thn));
		$nama_hari = "";
		if($nama=="Sunday") {$nama_hari="Minggu";}
		else if($nama=="Monday") {$nama_hari="Senin";}
		else if($nama=="Tuesday") {$nama_hari="Selasa";}
		else if($nama=="Wednesday") {$nama_hari="Rabu";}
		else if($nama=="Thursday") {$nama_hari="Kamis";}
		else if($nama=="Friday") {$nama_hari="Jumat";}
		else if($nama=="Saturday") {$nama_hari="Sabtu";}
		
		return $nama_hari;
	}

	function getDateTime()
    {
        return date("Y-m-d H:i:s");
	}
	
	function curl_data($url, $isPost = 0, $params = "")
	{
		try {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, $isPost);
			if ($params) {
				if (is_array($params)) {
					curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
				} else {
					curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
				}
			}
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_TIMEOUT, 10000);
			$response = curl_exec($ch);

			//echo "<pre>";
			//var_dump(curl_getinfo($ch));
			//exit;

			curl_close($ch);

			return $response;
		}catch (\Exception $e){
			//die($e->getMessage());
			log_message('error', $e);
			return null;
		}
	}

	public function options_jenis_klpd_extra(){
		$result = [
			'ALL' => 'All',
			'KL' => 'K/L',
			'PEMDA' => 'Pemda'
		];

		return $result;
	}

	public function options_jenis_klpd(){
		$arr = $this->klpdModel->getListJenisKlpd();

		$result = ['0' => '--Pilih--'];

		for($i=2020; $i<=date("Y"); $i++){
			$result[$i] = $row[$i];
		}

		return $result;
	}

	public function options_tahun_layanan(){
		$arr = $this->pelayananModel->getTahunLayanan();

		$result = ['0' => '--Pilih--'];

		foreach ($arr as $row){
			$result[$row['tahun']] = $row['tahun'];
		}

		return $result;
	}

	public function options_jenis_advokasi(){
		$arr = $this->jenisAdvokasiModel->getJenisAdvokasi();

		$result = ['0' => '--Pilih--'];

		foreach ($arr as $row){
			$result[$row['id']] = $row['nama_jenis_advokasi'];
		}

		return $result;
	}

	public function setPassword(string $pass, $salt = "")
	{
		if($salt){
			$result['salt'] = $salt;
		}else{
			$salt = uniqid('', true);

			$result['salt'] = $salt;
		}
		
		$result['password'] = md5(md5($salt.$pass));

		return $result;
	}
}
