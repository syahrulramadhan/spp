<?php

if (!function_exists('request')) {
    function request($key, $default = null){
        return (isset($_GET[$key]) ? $_GET[$key] : (isset($_POST[$key]) ? $_POST[$key] : $default));
    }
}

if(!function_exists('input_clear')){
	function input_clear($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}
}

if(!function_exists('permission')){
	function permission($param){
		if($param){
			$result = in_array(session('role'), $param);

			return ($result) ? true : false;
		}
		
		return false;
	}
}

if ( ! function_exists('flagOptions')){
	function flagOptions($q = ''){
		if($q == 'label'){
			$result = array(
				'' => ''
				,1 => '<span class="label label-success">Aktif</span>'
				,0 => '<span class="label label-danger">Tidak Aktif</span>'
			);
		}else{
			$result = array(
				'' => '-- Pilih Status --'
				,1 => 'Aktif'
				,0 => 'Tidak Aktif'
			);
		}

		return $result;
	}
}

if ( ! function_exists('hariOptions')){
	function hariOptions(){
		$result = array(
			'' => '-- Pilih Hari --'
			,0 => 'Minggu'
			,1 => 'Senin'
			,2 => 'Selasa'
			,3 => 'Rabu'
			,4 => 'Kamis'
			,5 => 'Jumat'
			,6 => 'Sabtu'
		);

		return $result;
	}
}

if ( ! function_exists('jenisKelaminOptions')){
	function jenisKelaminOptions(){
		$result = array(
			'' => '-- Pilih Jenis Kelamin --'
		,1 => 'Laki - Laki'
		,2 => 'Perempuan'
		);

		return $result;
	}
}

if ( ! function_exists('dateOutput')){
	function dateOutput($dateInput){
		$dateOutput = NULL;

		if($dateInput){
			$dateInput = explode('/', $dateInput);
			$dateOutput = $dateInput[2] . '-' . $dateInput[1] . '-' . $dateInput[0];
		}

		return $dateOutput;
	}
}

if ( ! function_exists('dateInput')){
	function dateInput($dateOutput){
		$dateInput = NULL;

		if($dateOutput){
			$dateOutput = explode('-', $dateOutput);
			$dateInput = $dateOutput[2] . '/' . $dateOutput[1] . '/' . $dateOutput[0];
		}

		return $dateInput;
	}
}

if ( ! function_exists('word_limit')){
	function word_limit($content, $sum = 5) {
		if (count(explode(' ', $content)) > $sum) {
			$content = implode(' ', array_slice(explode(' ', strip_tags($content)), 0, $sum)) . " ...";
		} 
		
		return $content;
	}
}

if ( ! function_exists('tanggalid')){
	function tanggalid($tgl){
		if($tgl){
			$ubah = gmdate($tgl, time()+60*60*8);
			$pecah = explode("-",$ubah);
			$tanggal = $pecah[2];
			$bulan = bulan($pecah[1]);
			$tahun = $pecah[0];

			return $tanggal.' '.$bulan.' '.$tahun;
		}else{
			return "-";
		}
	}
}

if ( ! function_exists('datetimeconverttanggalid')){
	function datetimeconverttanggalid($tanggal){
		$d = date('d-m-Y-G-i', strtotime($tanggal));

		$pecah = explode("-",$d);
		$tanggal = $pecah[0];
		$bulan = bulan($pecah[1]);
		$tahun = $pecah[2];
		$jam = $pecah[3];
		$menit = $pecah[4];

		return $tanggal . ' ' . $bulan . ' ' . $tahun . ', ' . $jam . ':' . $menit . " WIB";
	}
}

if ( ! function_exists('bulan')){
	function bulan($bln){
		switch ($bln){
			case 1:
				return "Januari";
				break;
			case 2:
				return "Februari";
				break;
			case 3:
				return "Maret";
				break;
			case 4:
				return "April";
				break;
			case 5:
				return "Mei";
				break;
			case 6:
				return "Juni";
				break;
			case 7:
				return "Juli";
				break;
			case 8:
				return "Agustus";
				break;
			case 9:
				return "September";
				break;
			case 10:
				return "Oktober";
				break;
			case 11:
				return "November";
				break;
			case 12:
				return "Desember";
				break;
		}
	}
}

if ( ! function_exists('hariid')){
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
}

if ( ! function_exists('hitung_mundur')){
	function hitung_mundur($wkt){
		$waktu=array(	
			365*24*60*60	=> "tahun",
			30*24*60*60	=> "bulan",
			7*24*60*60		=> "minggu",
			24*60*60			=> "hari",
			60*60				=> "jam",
			60					=> "menit",
			1						=> "detik"
		);

		$hitung = (strtotime(gmdate ("Y-m-d H:i:s", time () + 60 * 60 * 8)) - 3600) - $wkt;

		$hasil = array();
		
		if($hitung<5){
			$hasil = 'kurang dari 5 detik yang lalu';
		}else{
			$stop = 0;
			foreach($waktu as $periode => $satuan){
				if($stop >= 6 || ($stop > 0 && $periode < 60)) {
					break;
				}
				
				$bagi = floor($hitung/$periode);
				
				if($bagi > 0){
					$hasil[] = $bagi . ' ' . $satuan;
					$hitung -= $bagi * $periode;
					$stop++;
				} else if($stop > 0) {
					$stop++;
				}
			}
			
			//$hasil = implode(' ', $hasil) . ' yang lalu';
			$hasil = $hasil[0] . ' yang lalu';
		}
		
		return $hasil;
	}
}

if ( ! function_exists('calculate_file_size')){
	function calculate_file_size($size)
		{
		$sizes = ['B', 'KB', 'MB', 'GB'];
		$count=0;
		if ($size < 1024) {
			return $size . " " . $sizes[$count];
			} else{
			while ($size>1024){
				$size=round($size/1024,2);
				$count++;
			}
			return $size . " " . $sizes[$count];
		}
	}
}

if ( ! function_exists('alert')){
	function alert($class, $message){
		$d = array(
			'success' => "Success!",
			'info' => "Info!",
			'warning' => "Warning!",
			'danger' => "Danger!"
		);

		$alert = "<div class='alert alert-$class'><strong>$d[$class]</strong> $message</div>";

		return $alert;
	}
}