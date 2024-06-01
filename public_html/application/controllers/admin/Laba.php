<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Laba extends CI_Controller{
	function __construct(){
		parent::__construct();
		if($this->session->userdata('masuk') !=TRUE){
            $url=base_url();
            redirect($url);
        };
		$this->load->model('Mlogin');
		$this->load->model('M_laba');
	}
	
	
	function index() {
		if ($this->session->userdata('akses') == '1') {
			$data['namacab'] = "Gabungan (Global)";
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
			$data['data'] = $this->M_laba->tampil_laba_admin($thnbln);
			$data['beban'] = $this->M_laba->tampil_beban_global($thnbln);
			$data['kategori'] = $this->db->select('kategori_nama')->get('tbl_kategori')->result_array();
			$this->load->view('admin/v_laba_admin', $data);
		} elseif ($this->session->userdata('akses') == '2') {
			$data['userid'] = $this->Mlogin->tampil_user();
			$regid = $this->session->userdata('regid');
			//$thnbln=date("Y") . '-' .date("n");
			$thnbln = sprintf('%04d-%02d', date("Y"), date("n"));
			$data['bln'] = date("n");
			$data['thn'] = date("Y");
			// Panggil fungsi untuk mendapatkan data bulan
			$bulanData = $this->getBulanData($data['bln']);
			$data['daftar_bln'] = $bulanData['daftar_bln'];
			$data['nm_bln'] = $bulanData['nm_bln'];
			$data['daftar_thn'] = range(date("Y"), 2010);
			$data['data'] = $this->M_laba->tampil_laba($regid,$thnbln);
			$data['kategori'] = $this->db->select('kategori_nama')->get('tbl_kategori')->result_array();
			$this->load->view('admin/v_laba', $data);
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


	function get_lap_admin() {
		$namcab = $this->input->post('namacab');
		$data['namacab'] = $namcab;
		$data['userid'] = $this->Mlogin->tampil_user();
		$bln = $this->input->post('cari_bln');
		$thn = $this->input->post('cari_thn');
		//$thnbln = $thn . '-' . $bln;
		$thnbln = sprintf('%04d-%02d', $thn, $bln);
		$data['bln'] = $bln;
		$data['thn'] = $thn;
		// Panggil fungsi untuk mendapatkan data bulan
		$bulanData = $this->getBulanData($bln);
		$data['daftar_bln'] = $bulanData['daftar_bln'];
		$data['nm_bln'] = $bulanData['nm_bln'];
		$data['daftar_thn'] = range(date("Y"), 2010);
		$data['data'] = $this->M_laba->tampil_laba_admin($thnbln);
		$data['beban'] = $this->M_laba->tampil_beban_global($thnbln);
		$data['kategori'] = $this->db->select('kategori_nama')->get('tbl_kategori')->result_array();
		$this->load->view('admin/v_laba_admin', $data);
	}

	function tampil_data() {
	$regid = $this->input->post('regid');  // Ambil ID cabang dari parameter GET
	$namcab = $this->input->post('namacab');	

	if ($this->session->userdata('akses') == '1') {
		if ($regid == '0') {
            $this->get_lap_admin();
        }elseif ($regid !== null && $regid !== '') {
			$data['namacab'] = $namcab;
			$data['userid'] = $this->Mlogin->tampil_user();
			$bln = $this->input->post('cari_bln');
			$thn = $this->input->post('cari_thn');
			//$thnbln = $thn . '-' . $bln;
			$thnbln = sprintf('%04d-%02d', $thn, $bln);
			$data['bln'] = $bln;
			$data['thn'] = $thn;
			// Panggil fungsi untuk mendapatkan data bulan
			$bulanData = $this->getBulanData($bln);
			$data['daftar_bln'] = $bulanData['daftar_bln'];
			$data['nm_bln'] = $bulanData['nm_bln'];
			$data['daftar_thn'] = range(date("Y"), 2010);
			$data['data'] = $this->M_laba->tampil_laba($regid,$thnbln);
			$data['beban'] = $this->M_laba->tampil_beban($regid,$thnbln);
			$data['kategori'] = $this->db->select('kategori_nama')->get('tbl_kategori')->result_array();
			$this->load->view('admin/v_laba_admin', $data);
		} else {
            // Jika ID cabang tidak tersedia, ambil semua data
            $this->get_lap_admin();
        }
	} elseif ($this->session->userdata('akses') == '2') {
		//$regid = $this->input->post('regid');
		$data['userid'] = $this->Mlogin->tampil_user();
		$bln = $this->input->post('cari_bln');
		$thn = $this->input->post('cari_thn');
		//$thnbln = $thn . '-' . $bln;
		$thnbln = sprintf('%04d-%02d', $thn, $bln);
		$data['bln'] = $bln;
		$data['thn'] = $thn;
		// Panggil fungsi untuk mendapatkan data bulan
		$bulanData = $this->getBulanData($bln);
		$data['daftar_bln'] = $bulanData['daftar_bln'];
		$data['nm_bln'] = $bulanData['nm_bln'];
		$data['daftar_thn'] = range(date("Y"), 2010);
		$data['data'] = $this->M_laba->tampil_laba($regid,$thnbln);
		$data['kategori'] = $this->db->select('kategori_nama')->get('tbl_kategori')->result_array();
		$this->load->view('admin/v_laba', $data);
	}
	}

	function get_cetak_admin() {
		$regid = $this->input->post('regid');
		$namcab = $this->input->post('namacab');
		$x['namacab'] = $namcab;
		$bln = $this->input->post('cari_bln');
		$thn = $this->input->post('cari_thn');
		//$thnbln = $thn . '-' . $bln;
		$thnbln = sprintf('%04d-%02d', $thn, $bln);
		$x['bln'] = $bln;
		$x['thn'] = $thn;
		// Panggil fungsi untuk mendapatkan data bulan
		$bulanData = $this->getBulanData($bln);
		$x['daftar_bln'] = $bulanData['daftar_bln'];
		$x['nm_bln'] = $bulanData['nm_bln'];
		$x['daftar_thn'] = range(date("Y"), 2010);
		$x['data'] = $this->M_laba->tampil_laba_admin($thnbln);
		$x['kategori'] = $this->db->select('kategori_nama')->get('tbl_kategori')->result_array();
		$x['userid'] = $this->Mlogin->tampil_user();
		$this->load->view('admin/cetak/v_cetak_laba_admin', $x);
	}

	function cetak_laporan() {
	$regid = $this->input->post('regid');
	$bln = $this->input->post('cari_bln');
	$thn = $this->input->post('cari_thn');
		if ($this->session->userdata('akses') == '1') {
			if ($regid == '0') {
            	$this->get_cetak_admin();
        	}elseif ($regid !== null && $regid !== '') {
				$namcab = $this->input->post('namacab');
				$x['namacab'] = $namcab;
				//$thnbln = $thn . '-' . $bln;
				$thnbln = sprintf('%04d-%02d', $thn, $bln);
				$x['bln'] = $bln;
				$x['thn'] = $thn;
				// Panggil fungsi untuk mendapatkan data bulan
				$bulanData = $this->getBulanData($bln);
				$x['daftar_bln'] = $bulanData['daftar_bln'];
				$x['nm_bln'] = $bulanData['nm_bln'];
				$x['daftar_thn'] = range(date("Y"), 2010);
				$x['data'] = $this->M_laba->tampil_laba($regid,$thnbln);
				$x['kategori'] = $this->db->select('kategori_nama')->get('tbl_kategori')->result_array();
				$x['userid'] = $this->Mlogin->tampil_user();
				$this->load->view('admin/cetak/v_cetak_laba_admin', $x);	
			} else {
            // Jika ID cabang tidak tersedia, ambil semua data
            $this->get_cetak_admin();
        	}

		} elseif ($this->session->userdata('akses') == '2') {
			$x['userid'] = $this->Mlogin->tampil_user();
			//$regid = $this->input->post('regid');
			//$bln = $this->input->post('cari_bln');
			//$thn = $this->input->post('cari_thn');
			//$thnbln = $thn . '-' . $bln;
			$thnbln = sprintf('%04d-%02d', $thn, $bln);
			$x['bln'] = $bln;
			$x['thn'] = $thn;
			// Panggil fungsi untuk mendapatkan data bulan
			$bulanData = $this->getBulanData($bln);
			$x['daftar_bln'] = $bulanData['daftar_bln'];
			$x['nm_bln'] = $bulanData['nm_bln'];
			$x['daftar_thn'] = range(date("Y"), 2010);
			$x['data'] = $this->M_laba->tampil_laba($regid,$thnbln);
			$x['kategori'] = $this->db->select('kategori_nama')->get('tbl_kategori')->result_array();
			$this->load->view('admin/cetak/v_cetak_laba', $x);
		}
	}
	
}