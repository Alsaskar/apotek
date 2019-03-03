<?php

class Fungsi{

	// fungsi untuk membuat hari, tanggal, bulan, tahun jadi format bahasa Indonesia
	public function dateindonesia(){
		$hari=date('w');
	    $tgl =date('d');
	    $bln =date('m');
	    $thn =date('Y');
	    switch($hari){
	        case 1 : {
	                    $hari = 'Senin';
	                }break;
	        case 2 : {
	                    $hari = 'Selasa';
	                }break;
	        case 3 : {
	                    $hari = 'Rabu';
	                }break;
	        case 4 : {
	                    $hari = 'Kamis';
	                }break;
	        case 5 : {
	                    $hari = "Jum'at";
	                }break;
	        case 6 : {
	                    $hari = 'Sabtu';
	                }break;
	        default: {
	                    $hari = 'Minggu';
	                }break;
	    }
	     
		switch($bln){       
	        case 1 : {
	                    $bln = 'Januari';
	                }break;
	        case 2 : {
	                    $bln = 'Februari';
	                }break;
	        case 3 : {
	                    $bln = 'Maret';
	                }break;
	        case 4 : {
	                    $bln = 'April';
	                }break;
	        case 5 : {
	                    $bln = 'Mei';
	                }break;
	        case 6 : {
	                    $bln = "Juni";
	                }break;
	        case 7 : {
	                    $bln = 'Juli';
	                }break;
	        case 8 : {
	                    $bln = 'Agustus';
	                }break;
	        case 9 : {
	                    $bln = 'September';
	                }break;
	        case 10 : {
	                    $bln = 'Oktober';
	                }break;     
	        case 11 : {
	                    $bln = 'November';
	                }break;
	        case 12 : {
	                    $bln = 'Desember';
	                }break;
	        default: {
	                    $bln = 'UnKnown';
	                }break;
	    }

		$sekarang = $hari.", ".$tgl." ".$bln." ".$thn;
		return $sekarang;
	}

	// fungsi untuk set url jadi seo
	public function seo_friendly_url($string){
	    $string = str_replace(array('[\', \']'), '', $string);
	    $string = preg_replace('/\[.*\]/U', '', $string);
	    $string = preg_replace('/&(amp;)?#?[a-z0-9]+;/i', '-', $string);
	    $string = preg_replace(array('/[^a-z0-9]/i', '/[-]+/') , '-', $string);

	    return strtolower(trim($string, '-'));
	}


	public function random_url($panjang){
		// tentukan karakter random
		$karakter = 'QWERTYUIOPASDFGHJKLZXCVBNM1234567890';

		// buat variabel kosong sebagai nilai
		$string = "";

		// lakukan proses looping
		for ($i=0; $i < $panjang; $i++) { 
			// lakukan random data dengan nilai awal 0
			// dan nilai akhir sebanyak value "$karakter"
			$random = rand(0, strlen($karakter) -1);

			// melakukan penggabungan antara nilai di kiri dengan nilai
			$string .= $karakter{$random};
		}

		return $string;
	}

	# Fungsi untuk membuat format rupiah pada angka (uang)
	public function format_angka($angka) {
		$hasil =  number_format($angka,0, ",",".");
		return $hasil;
	}

	// Fungsi selisi waktu
	public function selisiWaktu($time){
		if ($time->y > 0)
			return $time->y . ' tahun';

		if ($time->m > 0)
			return $time->m . ' bulan';

		if ($time->d > 0)
			return $time->d . ' hari';

		if ($time->h > 0)
			return $time->h . ' jam';

		if ($time->i > 0)
			return $time->i . ' menit';

		if ($time->s > 0)
			return $time->s . ' detik';
	}

	# Fungsi untuk membalik tanggal dari format English (Y-m-d) -> Indo (d-m-Y)
	public function IndonesiaTgl($tanggal){
		$tgl=substr($tanggal,8,2);
		$bln=substr($tanggal,5,2);
		$thn=substr($tanggal,0,4);
		$tanggal="$tgl-$bln-$thn";
		return $tanggal;
	}

	
}


?>