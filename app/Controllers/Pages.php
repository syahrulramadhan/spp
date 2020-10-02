<?php namespace App\Controllers;

use App\Models\SatuanKerjaModel;
use App\Models\KlpdModel;
use App\Models\JenisPengadaanModel;
use App\Models\PelayananModel;
use App\Models\UserModel;
use App\Models\GrafikModel;

class Pages extends BaseController
{
	protected $satuanKerjaModel;
	protected $klpdModel;
	protected $jenisPengadaanModel;
	protected $userModel;
	protected $pelayananModel;
	protected $grafikModel;

	public function __construct()
	{
		$this->satuanKerjaModel = new SatuanKerjaModel();
		$this->klpdModel = new KlpdModel();
		$this->jenisPengadaanModel = new JenisPengadaanModel();
		$this->userModel = new UserModel();
		$this->pelayananModel = new PelayananModel();
		$this->grafikModel = new GrafikModel();

		$this->session = session();
		helper('form');

		ini_set("display_errors", "1");
	}

	public function index()
	{
		$jenis_klpd = $this->request->getVar('jenis_klpd');
		$tahun = ($this->request->getVar('tahun')) ? $this->request->getVar('tahun') : date('Y');
		
        $arr = $this->pelayananModel->getPelayananJoin();

		$data = [
			'result' => $arr,
			'jenis_klpd' => $jenis_klpd,
			'tahun' => $tahun,
			'options_jenis_klpd' => $this->options_jenis_klpd(),
			'options_tahun_layanan' => $this->options_tahun_layanan(),
			'result_chart_pelayanan' => $this->chart('chart_layanan', $jenis_klpd, $tahun),
			'result_chart_valuasi' => $this->chart('chart_valuasi', $jenis_klpd, $tahun),
			'result_chart_coverage' => $this->chart('chart_coverage', $jenis_klpd, $tahun),
			'result_chart_kualitas' => $this->chart('chart_kualitas', $jenis_klpd, $tahun),
		];

		return view('Pages/index', $data);
	}

	public function chart($param = "", $jenis_klpd, $tahun){
		$grafik[0][0] = "";
		$grafik[0][1] = "";
		$grafik[0][2] = "";

		for($i=1;$i<=12;$i++){
			$grafik[$i][0] = $this->bulan($i);
			$grafik[$i][1] = 0;
			$grafik[$i][2] = 0;
		}

		if($param == 'chart_valuasi'){
			$result = $this->pelayananModel->ChartPelayananValuasi($jenis_klpd, $tahun);

			$grafik[0][0] = 'BULAN';
			$grafik[0][1] = 'JUMLAH VALUASI';
			$grafik[0][2] = 'TOTAL VALUASI';

			foreach($result as $rows){
				$grafik[$rows['bulan']][0] = $this->bulan($rows['bulan']);
				$grafik[$rows['bulan']][1] = (double) ($rows['jumlah_valuasi']);
				$grafik[$rows['bulan']][2] = (double) ($rows['total_valuasi']);
			}
		}else if($param == 'chart_coverage'){
			$count = $this->klpdModel->getCountKlpd($jenis_klpd);
			$result = $this->pelayananModel->ChartPelayananCoverage($jenis_klpd, $tahun);

			$grafik[0][0] = 'BULAN';
			$grafik[0][1] = 'JUMLAH COVERAGE';
			$grafik[0][2] = 'TOTAL COVERAGE';

			$total_coverage = 0;

			foreach($result as $rows){
				$jumlah_coverage = $rows['total_coverage'] - $total_coverage;

				$grafik[$rows['bulan']][0] = $this->bulan($rows['bulan']);
				$grafik[$rows['bulan']][1] = ($jumlah_coverage/$count)*100;
				$grafik[$rows['bulan']][2] = ($rows['total_coverage']/$count)*100;

				$total_coverage = $rows['total_coverage'];
			}
		}else if($param == 'chart_kualitas'){
			$count = $this->klpdModel->getCountKlpd($jenis_klpd);

			$grafik[0][0] = 'BULAN';
			$grafik[0][1] = 'JUMLAH KUALITAS';
			$grafik[0][2] = 'RATA-RATA SKOR';

			$total_kualitas = 0;

			for($i=1;$i<=date('m');$i++){
				$result = $this->pelayananModel->ChartPelayananKualitas($i, $jenis_klpd, $tahun);
				$jumlah_kualitas = $result->total_kualitas - $total_kualitas;
				
				$grafik[$i][1] = $jumlah_kualitas/$count;
				$grafik[$i][2] = $result->total_kualitas/$count;

				$total_kualitas = (int) $result->total_kualitas;
			}
		}else{
			$result = $this->pelayananModel->ChartPelayananJumlah($jenis_klpd, $tahun);

			$grafik[0][0] = 'BULAN';
			$grafik[0][1] = 'JUMLAH LAYANAN';
			$grafik[0][2] = 'TOTAL LAYANAN';

			foreach($result as $rows){
				$grafik[$rows['bulan']][0] = $this->bulan($rows['bulan']);
				$grafik[$rows['bulan']][1] = (int) ($rows['jumlah_pelayanan']);
				$grafik[$rows['bulan']][2] = (int) ($rows['total_pelayanan']);
			}
		}

		return json_encode($grafik, JSON_PRETTY_PRINT);
	}

	public function chartJenisPengadaan($param = "", $jenis_klpd, $tahun, $id){
		$grafik[0][0] = "";
		$grafik[0][1] = "";
		$grafik[0][2] = "";

		for($i=1;$i<=12;$i++){
			$grafik[$i][0] = $this->bulan($i);
			$grafik[$i][1] = 0;
			$grafik[$i][2] = 0;
		}

		if($param == 'chart_valuasi'){
			$result = $this->grafikModel->valuasiByJenisPengadaanId($jenis_klpd, $tahun, $id);

			$grafik[0][0] = 'BULAN';
			$grafik[0][1] = 'JUMLAH VALUASI';
			$grafik[0][2] = 'TOTAL VALUASI';

			foreach($result as $rows){
				$grafik[$rows['bulan']][0] = $this->bulan($rows['bulan']);
				$grafik[$rows['bulan']][1] = (double) ($rows['jumlah_valuasi']);
				$grafik[$rows['bulan']][2] = (double) ($rows['total_valuasi']);
			}
		}else{
			$result = $this->grafikModel->layananByJenisPengadaanId($jenis_klpd, $tahun, $id);

			$grafik[0][0] = 'BULAN';
			$grafik[0][1] = 'JUMLAH LAYANAN';
			$grafik[0][2] = 'TOTAL LAYANAN';

			foreach($result as $rows){
				$grafik[$rows['bulan']][0] = $this->bulan($rows['bulan']);
				$grafik[$rows['bulan']][1] = (int) ($rows['jumlah_pelayanan']);
				$grafik[$rows['bulan']][2] = (int) ($rows['total_pelayanan']);
			}
		}

		return json_encode($grafik, JSON_PRETTY_PRINT);
	}

	public function chartKlpd($param = "", $jenis_klpd, $tahun, $id){
		$grafik[0][0] = "";
		$grafik[0][1] = "";
		$grafik[0][2] = "";

		for($i=1;$i<=12;$i++){
			$grafik[$i][0] = $this->bulan($i);
			$grafik[$i][1] = 0;
			$grafik[$i][2] = 0;
		}

		if($param == 'chart_valuasi'){
			$result = $this->grafikModel->valuasiByKlpdId($jenis_klpd, $tahun, $id);

			$grafik[0][0] = 'BULAN';
			$grafik[0][1] = 'JUMLAH VALUASI';
			$grafik[0][2] = 'TOTAL VALUASI';

			foreach($result as $rows){
				$grafik[$rows['bulan']][0] = $this->bulan($rows['bulan']);
				$grafik[$rows['bulan']][1] = (double) ($rows['jumlah_valuasi']);
				$grafik[$rows['bulan']][2] = (double) ($rows['total_valuasi']);
			}
		}else if($param == 'chart_kualitas'){
			$grafik[0][0] = 'BULAN';
			$grafik[0][1] = 'PERTAMBAHAN SKOR';
			$grafik[0][2] = 'SKOR';

			$total_kualitas = 0;

			for($i=1;$i<=date('m');$i++){
				$result = $this->grafikModel->kualitasByKlpdId($i, $jenis_klpd, $tahun, $id);
				$jumlah_kualitas = $result->total_kualitas - $total_kualitas;
				
				$grafik[$i][1] = $jumlah_kualitas;
				$grafik[$i][2] = $result->total_kualitas;

				$total_kualitas = $result->total_kualitas;
			}

			//echo "<pre>"; print_r($grafik); exit;
		}else{
			$result = $this->grafikModel->layananByKlpdId($jenis_klpd, $tahun, $id);

			$grafik[0][0] = 'BULAN';
			$grafik[0][1] = 'JUMLAH LAYANAN';
			$grafik[0][2] = 'TOTAL LAYANAN';

			foreach($result as $rows){
				$grafik[$rows['bulan']][0] = $this->bulan($rows['bulan']);
				$grafik[$rows['bulan']][1] = (int) ($rows['jumlah_pelayanan']);
				$grafik[$rows['bulan']][2] = (int) ($rows['total_pelayanan']);
			}
		}

		return json_encode($grafik, JSON_PRETTY_PRINT);
	}

	public function klpd()
	{
		$arr = $this->klpdModel->getKlpd();

		$data = [
            'title' => 'K/L/Pemda',
			'result' => $arr,
			'result_grafik_layanan' => $this->klpd_grafik(),
			'result_grafik_valuasi' => $this->klpd_grafik('grafik_valuasi')
		];
		
		return view('Pages/Klpd/index', $data);
	}

	public function klpd_detail($id){
		$jenis_klpd = $this->request->getVar('jenis_klpd');
		$tahun = ($this->request->getVar('tahun')) ? $this->request->getVar('tahun') : date('Y');
		$result = $this->klpdModel->getKlpd($id);

		$data = [
			'title' => 'Detail K/L/Pemda',
			'result' => $result,
			'result_satuan_kerja' => $this->satuanKerjaModel->getSatuanKerjaByKlpdId($result['klpd_id']),
			'jenis_klpd' => $jenis_klpd,
			'tahun' => $tahun,
			'options_jenis_klpd' => $this->options_jenis_klpd(),
			'options_tahun_layanan' => $this->options_tahun_layanan(),
			'result_chart_pelayanan' => $this->chartKlpd('chart_layanan', $jenis_klpd, $tahun, $result['klpd_id']),
			'result_chart_valuasi' => $this->chartKlpd('chart_valuasi', $jenis_klpd, $tahun, $result['klpd_id']),
			'result_chart_kualitas' => $this->chartKlpd('chart_kualitas', $jenis_klpd, $tahun, $result['klpd_id']),
			'result_jenis_advokasi' => $this->pelayananModel->getJenisAdvokasiByKlpdId($result['klpd_id']),
			'result_kegiatan' => $this->pelayananModel->getKegiatanByKlpdId($result['klpd_id'])
		];

		//echo "<pre>"; print_r($data['result_kegiatan']); exit;

		if(empty($data['result'])){
			throw new \CodeIgniter\Exceptions\PageNotFoundException('K/L/Pemda dengan ID ' . $id . ' tidak ditemukan.');
		}

		return view('Pages/Klpd/detail', $data);
	}
	
	public function klpd_grafik($param = ''){
		$result = $this->klpdModel->getKlpd();

		$grafik = [];

		if($param == 'grafik_valuasi'){
			$grafik[0][0] = 'NAMA';
			$grafik[0][1] = 'JUMLAH VALUASI';

			foreach($result as $key => $rows){
				$grafik[$key + 1][0] = $rows['nama_klpd'];
				$grafik[$key + 1][1] = (double) ($rows['jumlah_valuasi']);
			}
		}else{
			$grafik[0][0] = 'NAMA';
			$grafik[0][1] = 'JUMLAH LAYANAN';

			foreach($result as $key => $rows){
				$grafik[$key + 1][0] = $rows['nama_klpd'];
				$grafik[$key + 1][1] = (int) $rows['jumlah_pelayanan'];
			}
		}

		return json_encode($grafik, JSON_PRETTY_PRINT);
	}

	public function satuan_kerja()
	{
		$arr = $this->satuanKerjaModel->getSatuanKerja();

		$data = [
            'title' => 'Satuan Kerja',
            'result' => $arr
		];

		return view('Pages/SatuanKerja/index', $data);
	}

	public function satuan_kerja_ajax($klpd_id)
	{
		$result = $this->satuanKerjaModel->getSatuanKerjaByKlpdId($klpd_id);

		echo json_encode($result, JSON_PRETTY_PRINT);
	}

	public function satuan_kerja_detail($klpd_id, $satuan_kerja_id){
		$data = [
			'title' => 'Detail Satuan Kerja',
			'klpd_id' => $klpd_id,
			'result' => $this->satuanKerjaModel->getSatuanKerja($satuan_kerja_id)
		];

		if(empty($data['result'])){
			throw new \CodeIgniter\Exceptions\PageNotFoundException('Satuan kerja dengan ID ' . $satuan_kerja_id . ' tidak ditemukan.');
		}

		return view('Pages/SatuanKerja/detail', $data);
	}

	public function jenis_pengadaan()
	{
		$arr = $this->jenisPengadaanModel->getJenisPengadaan();

		$data = [
            'title' => 'Jenis Barang/Jasa',
			'result' => $arr,
			'result_grafik_layanan' => $this->jenis_pengadaan_grafik(),
			'result_grafik_valuasi' => $this->jenis_pengadaan_grafik('grafik_valuasi'),
		];
    
		return view('Pages/JenisPengadaan/index', $data);
	}

	public function jenis_pengadaan_detail($id){
		$jenis_klpd = $this->request->getVar('jenis_klpd');
		$tahun = ($this->request->getVar('tahun')) ? $this->request->getVar('tahun') : date('Y');
		
		$data = [
			'title' => 'Detail Jenis Pengadaan',
			'result' => $this->jenisPengadaanModel->getJenisPengadaan($id),
			'jenis_klpd' => $jenis_klpd,
			'tahun' => $tahun,
			'options_jenis_klpd' => $this->options_jenis_klpd(),
			'options_tahun_layanan' => $this->options_tahun_layanan(),
			'result_chart_pelayanan' => $this->chartJenisPengadaan('chart_layanan', $jenis_klpd, $tahun, $id),
			'result_chart_valuasi' => $this->chartJenisPengadaan('chart_valuasi', $jenis_klpd, $tahun, $id)
		];

		if(empty($data['result'])){
			throw new \CodeIgniter\Exceptions\PageNotFoundException('Jenis pengadaan dengan ID ' . $id . ' tidak ditemukan.');
		}

		return view('Pages/JenisPengadaan/detail', $data);
	}

	public function jenis_pengadaan_grafik($param = ''){
		$result = $this->jenisPengadaanModel->getJenisPengadaan();

		$grafik = [];

		if($param == 'grafik_valuasi'){
			$grafik[0][0] = 'NAMA';
			$grafik[0][1] = 'JUMLAH VALUASI';

			foreach($result as $key => $rows){
				$grafik[$key + 1][0] = $rows['nama_jenis_pengadaan'];
				$grafik[$key + 1][1] = (double) ($rows['jumlah_valuasi']);
			}
		}else{
			$grafik[0][0] = 'NAMA';
			$grafik[0][1] = 'JUMLAH LAYANAN';

			foreach($result as $key => $rows){
				$grafik[$key + 1][0] = $rows['nama_jenis_pengadaan'];
				$grafik[$key + 1][1] = (int) $rows['jumlah_pelayanan'];
			}
		}

		return json_encode($grafik, JSON_PRETTY_PRINT);
	}

	public function profil($id){
		$data = [
			'title' => 'Form Ubah Data Profil',
			'validation' => \Config\Services::validation(),
			'result' => $this->userModel->getUser($id)
		];

		return view('Pages/Profil/edit', $data);
	}

	public function profil_update($id){
		if(!$this->validate([
			'nama_depan' => [
				'rules' => 'required',
				'errors' => [
					'required' => '{field} nama depan harus diisi.'
				]
			],
			'email' => [
				'rules' => 'required',
				'errors' => [
					'required' => '{field} email harus diisi.'
				]
			],
			'nomor_telepon' => [
				'rules' => 'required',
				'errors' => [
					'required' => '{field} nomor telepon harus diisi.'
				]
			],
			'jabatan' => [
				'rules' => 'required',
				'errors' => [
					'required' => '{field} jabatan harus diisi.'
				]
			]
		])){

			$validation = \Config\Services::validation();
			return redirect()->to('/pages/profil/' . $id)->withInput()->with('validation', $validation);
		}

		$this->userModel->save([
			'id' => $id,
			'nama_depan' => $this->request->getVar('nama_depan'),
			'nama_belakang' => $this->request->getVar('nama_belakang'),
			'email' => $this->request->getVar('email'),
			'password' => md5($this->request->getVar('password')),
			'nomor_telepon' => $this->request->getVar('nomor_telepon'),
			'jabatan' => $this->request->getVar('jabatan')
		]);
		
		session()->setFlashdata('pesan', 'Data berhasil diubah.');
		
		return redirect()->to('/pages/profil/' . $id);
	}
}
