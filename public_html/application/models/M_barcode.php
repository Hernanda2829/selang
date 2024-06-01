<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_barcode extends CI_Model{

	function buat_img_barcode($kode) {
		//$kode = 'abcd';
		$hashed_kode = md5($kode);
    	$url = base_url() . 'page/show_page/' . $hashed_kode; // Menggunakan base_url() untuk membentuk URL lengkap

		$config['cacheable'] = true; //boolean, the default is true
		//-------------------------------------------
		$config['cachedir'] = APPPATH . 'cache/'; // Ubah ini sesuai dengan lokasi direktori cache yang ada di dalam aplikasi Anda
		$config['errorlog'] = APPPATH . 'logs/'; // Ubah ini sesuai dengan lokasi direktori logs yang ada di dalam aplikasi Anda
		$config['imagedir'] = FCPATH . 'assets/img/img_barcode/'; // Ini adalah path ke direktori penyimpanan gambar QR Code
		//--------------------------------------------
		$config['quality'] = true; //boolean, the default is true
		$config['size'] = '1024'; //integer, the default is 1024
		$config['black'] = array(224, 255, 255); // array, default is array(255, 255, 255)
		$config['white'] = array(70, 130, 180); // array, default is array(0, 0, 0)
		// Inisialisasi library CIQRCode
		$this->ciqrcode->initialize($config);
		// Buat nama gambar QR Code sesuai dengan nim
		//$image_name = $kode . '.png';
		$image_name = $hashed_kode . '.png';
		// Data yang akan dijadikan QR CODE
		//$params['data'] = $kode;
		$params['data'] = $url;
		// Level H=High
		$params['level'] = 'H';
		// Ukuran QR Code
		$params['size'] = 10;
		// Simpan gambar QR CODE ke direktori yang sudah didefinisikan
		$params['savename'] = $config['imagedir'] . $image_name;
		// Fungsi untuk menghasilkan QR CODE
		$this->ciqrcode->generate($params);
		// Menambahkan logo di tengah QR Code
		$this->tambah_logo_di_tengah($params['savename']);
	}

	// versi Transparan dengan 2 lingkaran biru dan merah
	// function tambah_logo_di_tengah($image_path) {
	// 	// Path ke logo
	// 	$logo_path = FCPATH . 'assets/img/logoSS.png'; // Ganti dengan path logo Anda
		
	// 	// Inisialisasi gambar QR Code dan logo
	// 	$qr_code = imagecreatefrompng($image_path);
	// 	$logo = imagecreatefrompng($logo_path);

	// 	// Mendapatkan ukuran gambar QR Code dan logo
	// 	$qr_code_width = imagesx($qr_code);
	// 	$qr_code_height = imagesy($qr_code);
	// 	$logo_width = imagesx($logo);
	// 	$logo_height = imagesy($logo);

	// 	// Membuat gambar dengan latar belakang transparan
	// 	$result_image = imagecreatetruecolor($qr_code_width, $qr_code_height);
	// 	imagesavealpha($result_image, true);
	// 	$trans_background = imagecolorallocatealpha($result_image, 0, 0, 0, 127);
	// 	imagefill($result_image, 0, 0, $trans_background);

	// 	// Menghitung posisi tengah logo di gambar QR Code
	// 	$x = ($qr_code_width - $logo_width) / 2;
	// 	$y = ($qr_code_height - $logo_height) / 2;

	// 	// Menyalin gambar QR Code ke hasil gambar
	// 	imagecopy($result_image, $qr_code, 0, 0, 0, 0, $qr_code_width, $qr_code_height);

	// 	// Menambahkan garis lingkaran hitam pada logo
	// 	$radius = min($logo_width, $logo_height) / 2;
	// 	$centerX = $x + $logo_width / 2;
	// 	$centerY = $y + $logo_height / 2;

	// 	// Lingkaran pertama dengan warna hitam
	// 	//$circleColor1 = imagecolorallocatealpha($result_image, 0, 0, 0, 0);
	// 	$circleColor1 = imagecolorallocatealpha($result_image, 235, 50, 56, 0); // Warna merah #eb3238
	// 	imageellipse($result_image, $centerX, $centerY, $logo_width, $logo_height, $circleColor1);

	// 	// Lingkaran kedua dengan warna putih (misalnya)
	// 	//$circleColor2 = imagecolorallocatealpha($result_image, 255, 255, 255, 0);
	// 	$circleColor2 = imagecolorallocatealpha($result_image, 19, 131, 187, 0); // Warna biru #1383bb
	// 	imageellipse($result_image, $centerX, $centerY, $logo_width * 1.05, $logo_height * 1.05, $circleColor2);

	// 	// Menyalin logo ke hasil gambar
	// 	imagecopy($result_image, $logo, $x, $y, 0, 0, $logo_width, $logo_height);

	// 	// Menyimpan gambar QR Code dengan logo dan dua lingkaran
	// 	imagepng($result_image, $image_path);

	// 	// Menghancurkan gambar dari memori
	// 	imagedestroy($result_image);
	// 	imagedestroy($qr_code);
	// 	imagedestroy($logo);
	// }

	//versi lingkaran tetapi masih ada background berbentuk persegi dengan warna latar hitam
	//contoh 1
// 	function tambah_logo_di_tengah($image_path) {
    
//         // Path ke logo
//         $logo_path = FCPATH . 'assets/img/logoSS2.png'; // Ganti dengan path logo Anda
//         // Inisialisasi gambar QR Code dan logo
//         $qr_code = imagecreatefrompng($image_path);
//         $logo = imagecreatefrompng($logo_path);

//         // Mendapatkan ukuran gambar QR Code dan logo
//         $qr_code_width = imagesx($qr_code);
//         $qr_code_height = imagesy($qr_code);
//         $logo_width = imagesx($logo);
//         $logo_height = imagesy($logo);

//         // Menghitung posisi tengah logo di gambar QR Code
//         $x = ($qr_code_width - $logo_width) / 2;
//         $y = ($qr_code_height - $logo_height) / 2;

//         // Menambahkan logo ke gambar QR Code
//         imagecopy($qr_code, $logo, $x, $y, 0, 0, $logo_width, $logo_height);

//         // Menyimpan gambar QR Code dengan logo
//         imagepng($qr_code, $image_path);

//         // Menghancurkan gambar dari memori
//         imagedestroy($qr_code);
//         imagedestroy($logo);
// }

//versi lingkaran berwarna
//contoh 2
function tambah_logo_di_tengah($image_path) {
    // Path ke logo
    $logo_path = FCPATH . 'assets/img/logoSS120.png'; // Ganti dengan path logo Anda

    // Inisialisasi gambar QR Code dan logo
    $qr_code = imagecreatefrompng($image_path);
    $logo = imagecreatefrompng($logo_path);

    // Mendapatkan ukuran gambar QR Code dan logo
    $qr_code_width = imagesx($qr_code);
    $qr_code_height = imagesy($qr_code);
    $logo_width = imagesx($logo);
    $logo_height = imagesy($logo);

    // Membuat gambar dengan latar belakang transparan
    $result_image = imagecreatetruecolor($qr_code_width, $qr_code_height);
    imagesavealpha($result_image, true);
    $trans_background = imagecolorallocatealpha($result_image, 0, 0, 0, 127);
    imagefill($result_image, 0, 0, $trans_background);

    // Menghitung posisi tengah logo di gambar QR Code
    $x = ($qr_code_width - $logo_width) / 2;
    $y = ($qr_code_height - $logo_height) / 2;

    // Menggabungkan gambar QR Code dengan logo
    imagecopy($result_image, $qr_code, 0, 0, 0, 0, $qr_code_width, $qr_code_height);
    imagecopy($result_image, $logo, $x, $y, 0, 0, $logo_width, $logo_height);

    // Menyimpan gambar QR Code dengan logo dan latar belakang transparan
    imagepng($result_image, $image_path);

    // Menghancurkan gambar dari memori
    imagedestroy($result_image);
    imagedestroy($qr_code);
    imagedestroy($logo);
}

//versi lingkaran warna image hitam putih
//contoh 3

// function tambah_logo_di_tengah($image_path) {
//     // Path ke logo
//     $logo_path = FCPATH . 'assets/img/logoSS3.png'; // Ganti dengan path logo Anda

//     // Inisialisasi gambar QR Code dan logo
//     $qr_code = imagecreatefrompng($image_path);
//     $logo = imagecreatefrompng($logo_path);

//     // Mendapatkan ukuran gambar QR Code dan logo
//     $qr_code_width = imagesx($qr_code);
//     $qr_code_height = imagesy($qr_code);
//     $logo_width = imagesx($logo);
//     $logo_height = imagesy($logo);

//     // Membuat gambar dengan latar belakang transparan
//     $result_image = imagecreatetruecolor($qr_code_width, $qr_code_height);
//     imagesavealpha($result_image, true);
//     $trans_background = imagecolorallocatealpha($result_image, 0, 0, 0, 127);
//     imagefill($result_image, 0, 0, $trans_background);

//     // Menghitung posisi tengah logo di gambar QR Code
//     $x = ($qr_code_width - $logo_width) / 2;
//     $y = ($qr_code_height - $logo_height) / 2;

//     // Menggabungkan gambar QR Code dengan logo
//     imagecopy($result_image, $qr_code, 0, 0, 0, 0, $qr_code_width, $qr_code_height);
//     imagecopy($result_image, $logo, $x, $y, 0, 0, $logo_width, $logo_height);

//     // Menyimpan gambar QR Code dengan logo dan latar belakang transparan
//     imagepng($result_image, $image_path);

//     // Menghancurkan gambar dari memori
//     imagedestroy($result_image);
//     imagedestroy($qr_code);
//     imagedestroy($logo);
// }


//versi lingkaran tetapi masih ada background berbentuk persegi dengan warna latar hitam
	//contoh 4
// 	function tambah_logo_di_tengah($image_path) {
    
//         // Path ke logo
//         $logo_path = FCPATH . 'assets/img/logoSS3.png'; // Ganti dengan path logo Anda
//         // Inisialisasi gambar QR Code dan logo
//         $qr_code = imagecreatefrompng($image_path);
//         $logo = imagecreatefrompng($logo_path);

//         // Mendapatkan ukuran gambar QR Code dan logo
//         $qr_code_width = imagesx($qr_code);
//         $qr_code_height = imagesy($qr_code);
//         $logo_width = imagesx($logo);
//         $logo_height = imagesy($logo);

//         // Menghitung posisi tengah logo di gambar QR Code
//         $x = ($qr_code_width - $logo_width) / 2;
//         $y = ($qr_code_height - $logo_height) / 2;

//         // Menambahkan logo ke gambar QR Code
//         imagecopy($qr_code, $logo, $x, $y, 0, 0, $logo_width, $logo_height);

//         // Menyimpan gambar QR Code dengan logo
//         imagepng($qr_code, $image_path);

//         // Menghancurkan gambar dari memori
//         imagedestroy($qr_code);
//         imagedestroy($logo);
// }


//versi lingkaran warna image hitam putih
//contoh 5

// function tambah_logo_di_tengah($image_path) {
//     // Path ke logo
//     $logo_path = FCPATH . 'assets/img/logoSS5.png'; // Ganti dengan path logo Anda

//     // Inisialisasi gambar QR Code dan logo
//     $qr_code = imagecreatefrompng($image_path);
//     $logo = imagecreatefrompng($logo_path);

//     // Mendapatkan ukuran gambar QR Code dan logo
//     $qr_code_width = imagesx($qr_code);
//     $qr_code_height = imagesy($qr_code);
//     $logo_width = imagesx($logo);
//     $logo_height = imagesy($logo);

//     // Membuat gambar dengan latar belakang transparan
//     $result_image = imagecreatetruecolor($qr_code_width, $qr_code_height);
//     imagesavealpha($result_image, true);
//     $trans_background = imagecolorallocatealpha($result_image, 0, 0, 0, 127);
//     imagefill($result_image, 0, 0, $trans_background);

//     // Menghitung posisi tengah logo di gambar QR Code
//     $x = ($qr_code_width - $logo_width) / 2;
//     $y = ($qr_code_height - $logo_height) / 2;

//     // Menggabungkan gambar QR Code dengan logo
//     imagecopy($result_image, $qr_code, 0, 0, 0, 0, $qr_code_width, $qr_code_height);
//     imagecopy($result_image, $logo, $x, $y, 0, 0, $logo_width, $logo_height);

//     // Menyimpan gambar QR Code dengan logo dan latar belakang transparan
//     imagepng($result_image, $image_path);

//     // Menghancurkan gambar dari memori
//     imagedestroy($result_image);
//     imagedestroy($qr_code);
//     imagedestroy($logo);
// }

// //versi lingkaran tetapi masih ada background berbentuk persegi dengan warna latar hitam
// 	//contoh 6
// 	function tambah_logo_di_tengah($image_path) {
    
//         // Path ke logo
//         $logo_path = FCPATH . 'assets/img/logoSS5.png'; // Ganti dengan path logo Anda
//         // Inisialisasi gambar QR Code dan logo
//         $qr_code = imagecreatefrompng($image_path);
//         $logo = imagecreatefrompng($logo_path);

//         // Mendapatkan ukuran gambar QR Code dan logo
//         $qr_code_width = imagesx($qr_code);
//         $qr_code_height = imagesy($qr_code);
//         $logo_width = imagesx($logo);
//         $logo_height = imagesy($logo);

//         // Menghitung posisi tengah logo di gambar QR Code
//         $x = ($qr_code_width - $logo_width) / 2;
//         $y = ($qr_code_height - $logo_height) / 2;

//         // Menambahkan logo ke gambar QR Code
//         imagecopy($qr_code, $logo, $x, $y, 0, 0, $logo_width, $logo_height);

//         // Menyimpan gambar QR Code dengan logo
//         imagepng($qr_code, $image_path);

//         // Menghancurkan gambar dari memori
//         imagedestroy($qr_code);
//         imagedestroy($logo);
// }


	function addgaransi($gjualtgl,$gcustnama,$gnofak,$gbrgid,$gbrgnama,$gbrgsat,$gqty,$gharjul,$gdiskon,$gtotal,$gjenisbayar,$gstatusbayar,$gperiode,$gjtempo,$gket) {
	$user_id=$this->session->userdata('idadmin');
	$regid=$this->session->userdata('regid');
	$coid=$this->session->userdata('coid');
	$user_nama=$this->session->userdata('nama');
	
	$ghari = (new DateTime($gjualtgl))->diff(new DateTime($gjtempo))->days;
	$kode = $gnofak.'-'.$gbrgid;
	$gtoken = md5($kode);
	$gimage = $gtoken.'.png';
	$gurl = base_url() . 'assets/img/img_barcode/' . $gimage;

	$data=array(
		'g_jual_tgl' 		=>	$gjualtgl,
		'g_cust_nama'		=>	$gcustnama,
		'g_nofak'	    	=>	$gnofak,
		'g_brg_id'			=>	$gbrgid,
		'g_brg_nama'		=>	$gbrgnama,
		'g_brg_sat'		    =>	$gbrgsat,
		'g_qty'		    	=>	$gqty,
		'g_harjul'		    =>	$gharjul,
		'g_diskon'		    =>	$gdiskon,
		'g_total'		    =>	$gtotal,
		'g_jenis_bayar'		=>	$gjenisbayar,
		'g_status_bayar'	=>	$gstatusbayar,
		'g_periode'		    =>	$gperiode,
		'g_jtempo'		    =>	$gjtempo,
		'g_hari'		    =>	$ghari,
		'g_ket'		    	=>	$gket,
		'g_image'		    =>	$gimage,
		'g_url'		    	=>	$gurl,
		'g_token'		    =>	$gtoken,
		'g_user_id'			=>	$user_id,
		'g_regid'			=>	$regid,
		'g_coid'			=>	$coid,
		'created_by'	    =>  $user_nama,
		'created_at'	    =>	date('Y-m-d H:i:s')
	);
		$this->db->insert('tbl_garansi', $data);
		return true;
	}

	function tampil_periode(){
		$coid=$this->session->userdata('coid');
		$hsl=$this->db->query("SELECT p_val,p_nama FROM periode where p_coid='$coid'");
		return $hsl;
	}

	function tampil_penjualan() {
		$regid=$this->session->userdata('regid');
        $result = $this->db->query("SELECT jual_nofak,jual_cust_nama,DATE_FORMAT(jual_tanggal, '%d %M %Y %H:%i:%s') AS jual_tanggal,jual_bayar,jual_bayar_status,jual_total,jual_user_id,tbl_jual.created_by,regions.reg_name FROM tbl_jual JOIN regions ON tbl_jual.jual_reg_id=regions.reg_id WHERE jual_reg_id='$regid' ORDER BY DATE(jual_tanggal) DESC");
        return $result; 
    }

	// function getdetailjual($nofak) {
    //     //$result = $this->db->query("SELECT d_jual_nofak, d_jual_barang_id, d_jual_barang_nama, d_jual_barang_satuan, d_jual_qty, d_jual_barang_harjul, d_jual_diskon, d_jual_total FROM tbl_detail_jual WHERE d_jual_nofak='$nofak' ORDER BY d_jual_nofak DESC");
	// 	$result = $this->db->query("SELECT d_jual_nofak, d_jual_barang_id, d_jual_barang_nama, d_jual_barang_satuan, d_jual_qty, d_jual_barang_harjul, d_jual_diskon, d_jual_total,jual_tanggal,jual_cust_nama,jual_bayar,jual_bayar_status,jual_total FROM tbl_jual join tbl_detail_jual ON jual_nofak=d_jual_nofak  WHERE d_jual_nofak='$nofak' ORDER BY d_jual_nofak DESC");
    //     return $result->result_array();  // Ambil hasil query sebagai array asosiatif
    // }

	function getdetailjual($nofak) {
        $queryA = $this->db->query("SELECT * FROM tbl_garansi WHERE g_nofak='$nofak' ORDER BY g_brg_id ASC");
		$queryB = $this->db->query("SELECT d_jual_nofak, d_jual_barang_id, d_jual_barang_nama, d_jual_barang_satuan, d_jual_qty, d_jual_barang_harjul, d_jual_diskon, d_jual_total,jual_tanggal,jual_cust_nama,jual_bayar,jual_bayar_status,jual_total FROM tbl_jual join tbl_detail_jual ON jual_nofak=d_jual_nofak  WHERE d_jual_nofak='$nofak' ORDER BY d_jual_nofak DESC");
		$resultA = $queryA->result_array(); 
		$resultB = $queryB->result_array(); //banyak row Ambil hasil query sebagai array asosiatif
		return array('queryA' => $resultA, 'queryB' => $resultB);
    }

	function tampil_garansi() {
		$regid=$this->session->userdata('regid');
		$hsl = $this->db->query("SELECT g_jual_tgl,g_nofak,g_cust_nama,g_brg_id,g_brg_nama,g_brg_sat,g_qty,g_harjul,g_diskon,g_total FROM tbl_garansi WHERE g_regid='$regid' ORDER BY DATE(g_jual_tgl) DESC");
		return $hsl;

	}	

	function get_garansi_file($nofak,$idbrg) {
        $queryA = $this->db->query("SELECT * FROM tbl_garansi WHERE g_nofak='$nofak' AND g_brg_id='$idbrg' ORDER BY g_id ASC");
		$queryB = $this->db->query("SELECT g_id,g_nofak,g_brg_id,g_file,g_path FROM tbl_garansi_file WHERE g_nofak='$nofak' AND g_brg_id='$idbrg' ORDER BY g_id ASC");
		$resultA = $queryA->result_array(); 
		$resultB = $queryB->result_array(); //banyak row Ambil hasil query sebagai array asosiatif
		return array('queryA' => $resultA, 'queryB' => $resultB);
    }


	function add_file_garansi($nofak,$idbrg,$nmfile) {
	$regid=$this->session->userdata('regid');
	$coid=$this->session->userdata('coid');
	$user_nama=$this->session->userdata('nama');
	
	$nmpath = base_url() . 'assets/img/file_garansi/' . $nmfile;
	$data=array(
		'g_nofak' 			=>	$nofak,
		'g_brg_id'			=>	$idbrg,
		'g_file'			=>	$nmfile,
		'g_path'		    =>	$nmpath,
		'g_regid'			=>	$regid,
		'g_coid'			=>	$coid,
		'created_by'	    =>  $user_nama,
		'created_at'	    =>	date('Y-m-d H:i:s')
	);
		$this->db->insert('tbl_garansi_file', $data);
		return true;
	}


	function hapus_file($gid){
	 	$hsl=$this->db->query("DELETE FROM tbl_garansi_file where g_id='$gid'");
	 	return $hsl;
	}





}