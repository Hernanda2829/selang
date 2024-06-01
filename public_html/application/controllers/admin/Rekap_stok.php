<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Rekap_stok extends CI_Controller{
	function __construct(){
		parent::__construct();
		if($this->session->userdata('masuk') !=TRUE){
            $url=base_url();
            redirect($url);
        };
		$this->load->model('Mlogin');
		$this->load->model('M_rekap_stok');
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
		$data['data'] = $this->M_rekap_stok->tampil_rekap_stok($thnbln);
		$data['regions']=$this->Mlogin->tampil_regions();
		$data['kategori'] = $this->db->select('kategori_id, kategori_nama')->get('tbl_kategori')->result_array();
		$this->load->view('admin/v_rekap_stok', $data);
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


	function tampil_rekap() {
		$data['userid'] = $this->Mlogin->tampil_user();
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
		$data['data'] = $this->M_rekap_stok->tampil_rekap_stok($thnbln);
		$data['regions']=$this->Mlogin->tampil_regions();
		$data['kategori'] = $this->db->select('kategori_id, kategori_nama')->get('tbl_kategori')->result_array();
		$this->load->view('admin/v_rekap_stok', $data);
	}

	function cetak_rekap() {
		$data['userid'] = $this->Mlogin->tampil_user();
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
		$data['data'] = $this->M_rekap_stok->tampil_rekap_stok($thnbln);
		$data['kategori'] = $this->db->select('kategori_id, kategori_nama')->get('tbl_kategori')->result_array();
		$this->load->view('admin/cetak/v_cetak_rekap_stok', $data);
	}

	function cetak_rekap_excel() {
		$data['userid'] = $this->Mlogin->tampil_user();
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
		$data['data'] = $this->M_rekap_stok->tampil_rekap_stok($thnbln);
		$data['kategori'] = $this->db->select('kategori_id, kategori_nama')->get('tbl_kategori')->result_array();
        header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=Akumulasi_Stok_Barang.xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		$this->load->view('admin/laporan/excel/v_excel_rekap_stok',$data);
	}

		
	function tampil_barang() {
		$bln = $this->input->post('cari_bln');
		$thn = $this->input->post('cari_thn');
		$thnbln = sprintf('%04d-%02d', $thn, $bln);
		$regid=$this->input->post('regid');
		$carikat=$this->input->post('carikat');
		$cekstok=$this->input->post('cekstok');
        $data = $this->M_rekap_stok->tampil_barang($regid,$carikat,$cekstok,$thnbln);
        if (!empty($data)) {
			echo json_encode($data);
		} else {
			echo json_encode(array('error' => 'Data not found'));
		}

    }

	function cetak_produk() {
		$data['userid'] = $this->Mlogin->tampil_user();
		$nmcab = $this->input->post('txtnmcab');
		$bln = $this->input->post('txtbln');
		$thn = $this->input->post('txtthn');
		$thnbln = sprintf('%04d-%02d', $thn, $bln);
		$data['bln'] = $bln;
		$data['thn'] = $thn;
		//Panggil fungsi untuk mendapatkan data bulan
		$bulanData = $this->getBulanData($data['bln']);
		$data['nm_bln'] = $bulanData['nm_bln'];
		$regid=$this->input->post('txtregid');
		$carikat=$this->input->post('txtcarikat');
		$cekstok=$this->input->post('txtcekstok');
		$data['data'] = $this->M_rekap_stok->tampil_barang($regid,$carikat,$cekstok,$thnbln);
		$data['nmcab'] = $nmcab;
		$this->load->view('admin/cetak/v_cetak_rekap_produk', $data);
	}

	function cetak_produk_excel() {
		$data['userid'] = $this->Mlogin->tampil_user();
		$nmcab = $this->input->post('txtnmcab');
		$bln = $this->input->post('txtbln');
		$thn = $this->input->post('txtthn');
		$thnbln = sprintf('%04d-%02d', $thn, $bln);
		$data['bln'] = $bln;
		$data['thn'] = $thn;
		//Panggil fungsi untuk mendapatkan data bulan
		$bulanData = $this->getBulanData($data['bln']);
		$data['nm_bln'] = $bulanData['nm_bln'];
		$regid=$this->input->post('txtregid');
		$carikat=$this->input->post('txtcarikat');
		$cekstok=$this->input->post('txtcekstok');
		$data['data'] = $this->M_rekap_stok->tampil_barang($regid,$carikat,$cekstok,$thnbln);
		$data['nmcab'] = $nmcab;
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=Rekap_Stok_Barang_".$nmcab.".xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		$this->load->view('admin/laporan/excel/v_excel_rekap_produk',$data);
	}
	

	

	




}