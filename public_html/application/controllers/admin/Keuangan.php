<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Keuangan extends CI_Controller{
	function __construct(){
		parent::__construct();
		if($this->session->userdata('masuk') !=TRUE){
            $url=base_url();
            redirect($url);
        };
		$this->load->model('Mlogin');
		$this->load->model('M_keuangan');
	}
	
	
	function index(){	
		$data['userid'] = $this->Mlogin->tampil_user();
		//$thnbln=date("Y") . '-' .date("n");
		$thnbln = sprintf('%04d-%02d', date("Y"), date("n"));
		$data['bln'] = date("n");
		$data['thn'] = date("Y");
		// Panggil fungsi untuk mendapatkan data bulan
		$bulanData = $this->getBulanData($data['bln']);
		$data['daftar_bln'] = $bulanData['daftar_bln'];
		$data['nm_bln'] = $bulanData['nm_bln'];
		$data['daftar_thn'] = range(date("Y"), 2010);
		//$bln1 = date('F Y', strtotime('-1 month'));
		//$bln2 = date('F Y');
		//-------------------------------------
		// Mengurangi 1 bulan
		$b1 = strtotime('-1 month', strtotime($thnbln . '-01'));    
		$thnbln1 = sprintf('%04d-%02d', date('Y', $b1), date('n', $b1));
		$tb1 = DateTime::createFromFormat('Y-m', $thnbln1);
		$angka_bln1 = $tb1->format('n'); // Mendapatkan angka bulan dari objek DateTime
		$bulanData1 = $this->getBulanData($angka_bln1);
		$bln1 = $bulanData1['nm_bln']; // Mendapatkan nama bulan untuk angka bulan 1
		// Mendapatkan bulan saat ini
		$tb2 = new DateTime(); 
		$angka_bln2 = $tb2->format('n'); // Mendapatkan angka bulan dari objek DateTime
		$bulanData2 = $this->getBulanData($angka_bln2);
		$bln2 = $bulanData2['nm_bln']; // Mendapatkan nama bulan untuk angka bulan 2
		//--------------------------------------
		$data['bln1'] = $bln1.' '.date("Y");
		$data['bln2'] = $bln2.' '.date("Y");
		$data['jual_bln'] = $this->M_keuangan->get_bulan_jual();
		$data['kategori'] = $this->db->distinct()->select('kategori_report')->get('tbl_kategori')->result_array();
		$data['kat_beban'] = $this->db->select('kat_id,kat_nama')->where('kat_report', 'Yes')->get('tbl_beban_kat')->result_array();
		
	if($this->session->userdata('akses')=='1'){	
		$data['namacab'] = "Gabungan (Global)";
		$data['data'] = $this->M_keuangan->tampil_keuangan_admin($thnbln);
		$data['transfer'] = $this->M_keuangan->tampil_transfer_admin($thnbln);
		$this->load->view('admin/v_keuangan_admin',$data);
	}elseif($this->session->userdata('akses')=='2'){
        $regid=$this->session->userdata('regid');
        $data['data'] = $this->M_keuangan->tampil_keuangan($regid,$thnbln);
		$data['transfer'] = $this->M_keuangan->tampil_transfer($regid,$thnbln);
		$this->load->view('admin/v_keuangan',$data);
    }
	}

	function getBulanData($angka) {
		$daftar_bln = array(
			1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
			5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
			9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
		);

		return array(
			'daftar_bln' => $daftar_bln,
			'nm_bln' => isset($daftar_bln[$angka]) ? $daftar_bln[$angka] : ''
		);
	}

    function get_bulan_lap() {
		$regid = $this->input->post('regid');
		$bln = $this->input->post('cari_bln');
		$thn = $this->input->post('cari_thn');
		//$thnbln = $thn . '-' . $bln;
		$thnbln = sprintf('%04d-%02d', $thn, $bln);
		$data['bln'] = $bln;
		$data['thn'] = $thn;
		// Panggil fungsi untuk mendapatkan data bulan
		$bulanData = $this->getBulanData($data['bln']);
		$data['daftar_bln'] = $bulanData['daftar_bln'];
		$data['nm_bln'] = $bulanData['nm_bln'];
		$data['daftar_thn'] = range(date("Y"), 2010);
		// Mengurangi 1 bulan
		$b1 = strtotime('-1 month', strtotime($thnbln . '-01'));    
		$thnbln1 = sprintf('%04d-%02d', date('Y', $b1), date('n', $b1));
		// Membuat objek DateTime dari string yang diformat
		$tb1 = DateTime::createFromFormat('Y-m', $thnbln1);
		//$bln1 = $tb1->format('F Y');	// Mengonversi ke format 'F Y'
		$tb2 = DateTime::createFromFormat('Y-m', $thnbln); 
		//$bln2 = $tb2->format('F Y');	// Mengonversi ke format 'F Y'
		//-------------------------------------
		$angka_bln1 = $tb1->format('n'); // Mendapatkan angka bulan dari objek DateTime
		$bulanData1 = $this->getBulanData($angka_bln1);
		$bln1 = $bulanData1['nm_bln']; // Mendapatkan nama bulan untuk angka bulan 1
		$angka_bln2 = $tb2->format('n'); // Mendapatkan angka bulan dari objek DateTime
		$bulanData2 = $this->getBulanData($angka_bln2);
		$bln2 = $bulanData2['nm_bln']; // Mendapatkan nama bulan untuk angka bulan 1
		//--------------------------------------
		$data['bln1'] = $bln1.' '.$thn;
		$data['bln2'] = $bln2.' '.$thn;
		$data['userid'] = $this->Mlogin->tampil_user();
		$data['jual_bln'] = $this->M_keuangan->get_bulan_jual();
        $data['data'] = $this->M_keuangan->tampil_keuangan($regid,$thnbln);
		$data['kategori'] = $this->db->distinct()->select('kategori_report')->get('tbl_kategori')->result_array();
		$data['kat_beban'] = $this->db->select('kat_id,kat_nama')->where('kat_report', 'Yes')->get('tbl_beban_kat')->result_array();
		$data['transfer'] = $this->M_keuangan->tampil_transfer($regid,$thnbln);
		$this->load->view('admin/v_keuangan',$data);
	}


	function get_bulan_lap_admin() {
	$regid = $this->input->post('regid');  // Ambil ID cabang dari parameter GET
	$namcab = $this->input->post('namacab');
        //if ($reg_id !== null) {
        if ($regid == '0') {
            $this->get_lap_admin();
        }elseif ($regid !== null && $regid !== '') {
			$bln = $this->input->post('cari_bln');
			$thn = $this->input->post('cari_thn');
			//$thnbln = $thn . '-' . $bln;
			$thnbln = sprintf('%04d-%02d', $thn, $bln);
			$data['bln'] = $bln;
			$data['thn'] = $thn;
			// Panggil fungsi untuk mendapatkan data bulan
			$bulanData = $this->getBulanData($data['bln']);
			$data['daftar_bln'] = $bulanData['daftar_bln'];
			$data['nm_bln'] = $bulanData['nm_bln'];
			$data['daftar_thn'] = range(date("Y"), 2010);
			// Mengurangi 1 bulan
			$b1 = strtotime('-1 month', strtotime($thnbln . '-01'));    
			$thnbln1 = sprintf('%04d-%02d', date('Y', $b1), date('n', $b1));
			// Membuat objek DateTime dari string yang diformat
			$tb1 = DateTime::createFromFormat('Y-m', $thnbln1);
			//$bln1 = $tb1->format('F Y');	// Mengonversi ke format 'F Y'
			$tb2 = DateTime::createFromFormat('Y-m', $thnbln); 
			//$bln2 = $tb2->format('F Y');	// Mengonversi ke format 'F Y'
			//-------------------------------------
			$angka_bln1 = $tb1->format('n'); // Mendapatkan angka bulan dari objek DateTime
			$bulanData1 = $this->getBulanData($angka_bln1);
			$bln1 = $bulanData1['nm_bln']; // Mendapatkan nama bulan untuk angka bulan 1
			$angka_bln2 = $tb2->format('n'); // Mendapatkan angka bulan dari objek DateTime
			$bulanData2 = $this->getBulanData($angka_bln2);
			$bln2 = $bulanData2['nm_bln']; // Mendapatkan nama bulan untuk angka bulan 1
			//--------------------------------------
			$data['namacab'] = $namcab;
			$data['bln1'] = $bln1.' '.$thn;
			$data['bln2'] = $bln2.' '.$thn;
			$data['userid'] = $this->Mlogin->tampil_user();
			$data['jual_bln'] = $this->M_keuangan->get_bulan_jual();
			$data['data'] = $this->M_keuangan->tampil_keuangan($regid,$thnbln);
			$data['kategori'] = $this->db->distinct()->select('kategori_report')->get('tbl_kategori')->result_array();
			$data['kat_beban'] = $this->db->select('kat_id,kat_nama')->where('kat_report', 'Yes')->get('tbl_beban_kat')->result_array();
			$data['transfer'] = $this->M_keuangan->tampil_transfer($regid,$thnbln);
			$this->load->view('admin/v_keuangan_admin',$data);
        } else {
            // Jika ID cabang tidak tersedia, ambil semua data
            $this->get_lap_admin();
        }
		
	}

	function get_lap_admin() {
		$bln = $this->input->post('cari_bln');
		$thn = $this->input->post('cari_thn');
		//$thnbln = $thn . '-' . $bln;
		$thnbln = sprintf('%04d-%02d', $thn, $bln);
		$data['bln'] = $bln;
		$data['thn'] = $thn;
		// Panggil fungsi untuk mendapatkan data bulan
		$bulanData = $this->getBulanData($data['bln']);
		$data['daftar_bln'] = $bulanData['daftar_bln'];
		$data['nm_bln'] = $bulanData['nm_bln'];
		$data['daftar_thn'] = range(date("Y"), 2010);
		// Mengurangi 1 bulan
		$b1 = strtotime('-1 month', strtotime($thnbln . '-01'));    
        $thnbln1 = sprintf('%04d-%02d', date('Y', $b1), date('n', $b1));
		// Membuat objek DateTime dari string yang diformat
		$tb1 = DateTime::createFromFormat('Y-m', $thnbln1);
		//$bln1 = $tb1->format('F Y');	// Mengonversi ke format 'F Y'
		$tb2 = DateTime::createFromFormat('Y-m', $thnbln); 
		//$bln2 = $tb2->format('F Y');	// Mengonversi ke format 'F Y'
		//-------------------------------------
		$angka_bln1 = $tb1->format('n'); // Mendapatkan angka bulan dari objek DateTime
		$bulanData1 = $this->getBulanData($angka_bln1);
		$bln1 = $bulanData1['nm_bln']; // Mendapatkan nama bulan untuk angka bulan 1
		$angka_bln2 = $tb2->format('n'); // Mendapatkan angka bulan dari objek DateTime
		$bulanData2 = $this->getBulanData($angka_bln2);
		$bln2 = $bulanData2['nm_bln']; // Mendapatkan nama bulan untuk angka bulan 1
		//--------------------------------------
		$namcab = $this->input->post('namacab');
		$data['namacab'] = $namcab;
		$data['bln1'] = $bln1.' '.$thn;
		$data['bln2'] = $bln2.' '.$thn;
		$data['userid'] = $this->Mlogin->tampil_user();
		$data['jual_bln'] = $this->M_keuangan->get_bulan_jual();
        $data['data'] = $this->M_keuangan->tampil_keuangan_admin($thnbln);
		$data['kategori'] = $this->db->distinct()->select('kategori_report')->get('tbl_kategori')->result_array();
		$data['kat_beban'] = $this->db->select('kat_id,kat_nama')->where('kat_report', 'Yes')->get('tbl_beban_kat')->result_array();
		$data['transfer'] = $this->M_keuangan->tampil_transfer_admin($thnbln);
		$this->load->view('admin/v_keuangan_admin',$data);
	}

	function get_cetak_admin() {
		$bln = $this->input->post('cari_bln');
		$thn = $this->input->post('cari_thn');
		//$thnbln = $thn . '-' . $bln;
		$thnbln = sprintf('%04d-%02d', $thn, $bln);
		// Mengurangi 1 bulan
		$b1 = strtotime('-1 month', strtotime($thnbln . '-01'));    
        $thnbln1 = sprintf('%04d-%02d', date('Y', $b1), date('n', $b1));
		// Membuat objek DateTime dari string yang diformat
		$tb1 = DateTime::createFromFormat('Y-m', $thnbln1);
		//$bln1 = $tb1->format('F Y');	// Mengonversi ke format 'F Y'
		$tb2 = DateTime::createFromFormat('Y-m', $thnbln); 
		//$bln2 = $tb2->format('F Y');	// Mengonversi ke format 'F Y'
		//-------------------------------------
		$angka_bln1 = $tb1->format('n'); // Mendapatkan angka bulan dari objek DateTime
		$bulanData1 = $this->getBulanData($angka_bln1);
		$bln1 = $bulanData1['nm_bln']; // Mendapatkan nama bulan untuk angka bulan 1
		$angka_bln2 = $tb2->format('n'); // Mendapatkan angka bulan dari objek DateTime
		$bulanData2 = $this->getBulanData($angka_bln2);
		$bln2 = $bulanData2['nm_bln']; // Mendapatkan nama bulan untuk angka bulan 1
		//--------------------------------------
		$namcab = $this->input->post('namacab');
		$x['namacab'] = $namcab;
		$x['bln1'] = $bln1.' '.$thn;
		$x['bln2'] = $bln2.' '.$thn;
		$x['userid'] = $this->Mlogin->tampil_user();
		$x['jual_bln'] = $this->M_keuangan->get_bulan_jual();
        $x['data'] = $this->M_keuangan->tampil_keuangan_admin($thnbln);
		$x['kategori'] = $this->db->distinct()->select('kategori_report')->get('tbl_kategori')->result_array();
		$x['kat_beban'] = $this->db->select('kat_id,kat_nama')->where('kat_report', 'Yes')->get('tbl_beban_kat')->result_array();
		$x['transfer'] = $this->M_keuangan->tampil_transfer_admin($thnbln);
		$this->load->view('admin/cetak/v_cetak_keuangan_admin',$x);
	}	

	function cetak_laporan() {
		$regid = $this->input->post('regid');
		$namcab = $this->input->post('namacab');
		$bln = $this->input->post('cari_bln');
		$thn = $this->input->post('cari_thn');
		if ($this->session->userdata('akses') == '1') {
			if ($regid == '0') {
				$this->get_cetak_admin();
			}elseif ($regid !== null && $regid !== '') {	
				$x['namacab'] = $namcab;
				//$bln = $this->input->post('cari_bln');
				//$thn = $this->input->post('cari_thn');
				//$thnbln = $thn . '-' . $bln;
				$thnbln = sprintf('%04d-%02d', $thn, $bln);
				// Mengurangi 1 bulan
				$b1 = strtotime('-1 month', strtotime($thnbln . '-01'));    
				$thnbln1 = sprintf('%04d-%02d', date('Y', $b1), date('n', $b1));
				// Membuat objek DateTime dari string yang diformat
				$tb1 = DateTime::createFromFormat('Y-m', $thnbln1);
				//$bln1 = $tb1->format('F Y');	// Mengonversi ke format 'F Y'
				$tb2 = DateTime::createFromFormat('Y-m', $thnbln); 
				//$bln2 = $tb2->format('F Y');	// Mengonversi ke format 'F Y'
				//-------------------------------------
				$angka_bln1 = $tb1->format('n'); // Mendapatkan angka bulan dari objek DateTime
				$bulanData1 = $this->getBulanData($angka_bln1);
				$bln1 = $bulanData1['nm_bln']; // Mendapatkan nama bulan untuk angka bulan 1
				$angka_bln2 = $tb2->format('n'); // Mendapatkan angka bulan dari objek DateTime
				$bulanData2 = $this->getBulanData($angka_bln2);
				$bln2 = $bulanData2['nm_bln']; // Mendapatkan nama bulan untuk angka bulan 1
				//--------------------------------------
				$x['bln1'] = $bln1.' '.$thn;
				$x['bln2'] = $bln2.' '.$thn;
				$x['userid'] = $this->Mlogin->tampil_user();
				$x['jual_bln'] = $this->M_keuangan->get_bulan_jual();
				$x['data'] = $this->M_keuangan->tampil_keuangan($regid,$thnbln);
				$x['kategori'] = $this->db->distinct()->select('kategori_report')->get('tbl_kategori')->result_array();
				$x['kat_beban'] = $this->db->select('kat_id,kat_nama')->where('kat_report', 'Yes')->get('tbl_beban_kat')->result_array();
				$x['transfer'] = $this->M_keuangan->tampil_transfer($regid,$thnbln);
				$this->load->view('admin/cetak/v_cetak_keuangan_admin',$x);
			} else {
				// Jika ID cabang tidak tersedia, ambil semua data
				$this->get_cetak_admin();
			}

		
		} elseif ($this->session->userdata('akses') == '2') {
			//$regid = $this->input->post('regid');
			//$bln = $this->input->post('cari_bln');
			//$thn = $this->input->post('cari_thn');
			//$thnbln = $thn . '-' . $bln;
			$thnbln = sprintf('%04d-%02d', $thn, $bln);
			// Mengurangi 1 bulan
			$b1 = strtotime('-1 month', strtotime($thnbln . '-01'));    
			$thnbln1 = sprintf('%04d-%02d', date('Y', $b1), date('n', $b1));
			// Membuat objek DateTime dari string yang diformat
			$tb1 = DateTime::createFromFormat('Y-m', $thnbln1);
			//$bln1 = $tb1->format('F Y');	// Mengonversi ke format 'F Y'
			$tb2 = DateTime::createFromFormat('Y-m', $thnbln); 
			//$bln2 = $tb2->format('F Y');	// Mengonversi ke format 'F Y'
			//-------------------------------------
			$angka_bln1 = $tb1->format('n'); // Mendapatkan angka bulan dari objek DateTime
			$bulanData1 = $this->getBulanData($angka_bln1);
			$bln1 = $bulanData1['nm_bln']; // Mendapatkan nama bulan untuk angka bulan 1
			$angka_bln2 = $tb2->format('n'); // Mendapatkan angka bulan dari objek DateTime
			$bulanData2 = $this->getBulanData($angka_bln2);
			$bln2 = $bulanData2['nm_bln']; // Mendapatkan nama bulan untuk angka bulan 1
			//--------------------------------------
			$x['bln1'] = $bln1.' '.$thn;
			$x['bln2'] = $bln2.' '.$thn;
			$x['userid'] = $this->Mlogin->tampil_user();
			$x['jual_bln'] = $this->M_keuangan->get_bulan_jual();
			$x['data'] = $this->M_keuangan->tampil_keuangan($regid,$thnbln);
			$x['kategori'] = $this->db->distinct()->select('kategori_report')->get('tbl_kategori')->result_array();
			$x['kat_beban'] = $this->db->select('kat_id,kat_nama')->where('kat_report', 'Yes')->get('tbl_beban_kat')->result_array();
			$x['transfer'] = $this->M_keuangan->tampil_transfer($regid,$thnbln);
			$this->load->view('admin/cetak/v_cetak_keuangan', $x);
		}
	}

	
}