<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Rekap extends CI_Controller{
	function __construct(){
		parent::__construct();
		if($this->session->userdata('masuk') !=TRUE){
            $url=base_url();
            redirect($url);
        };
		$this->load->model('Mlogin');
		$this->load->model('M_rekap');
	}

	function index(){
		$firstDay = $this->getFirstDayOfMonth();
		$lastDay = $this->getLastDayOfMonth();
		$data['firstDayOfMonth'] = $firstDay;
		$data['lastDayOfMonth'] = $lastDay;
		$data['userid'] = $this->Mlogin->tampil_user();
		$data['jual_thn'] = $this->M_rekap->get_tahun_jual();
		//$last_year = $data['jual_thn']->last_row()->tahun;
		//$tahun = $last_year ? $last_year : date('Y');
		//----------------------------------
		if ($data['jual_thn'] && $data['jual_thn']->num_rows() > 0) {	// Periksa apakah $data['jual_thn'] adalah objek dan memiliki baris
			$last_row = $data['jual_thn']->last_row();
			$last_year = isset($last_row->tahun) ? $last_row->tahun : null;	// Periksa apakah properti 'tahun' ada sebelum mengaksesnya
			$tahun = $last_year ? $last_year : date('Y');	// Gunakan nilai default (date('Y')) jika $last_year tidak tersedia
		} else {
			$tahun = date('Y');	// Penanganan jika tidak ada baris yang dikembalikan
		}
		//-----------------------------------
		$data['tahun'] = $tahun;	
		
		$data['jml_bln'] = $this->M_rekap->get_jumlah_bulan($tahun);
		$minJmlBln = 2;	// Menetapkan nilai minimum untuk jml_bln
		// Menggunakan kondisi untuk menetapkan nilai jml_bln
		$data['jml_bln'] = ($data['jml_bln'] == 1) ? $minJmlBln : $data['jml_bln'];
		
		$data['data'] = $this->M_rekap->tampil_jual_rekap($tahun);
		$this->load->view('admin/v_rekap', $data);
	}

	// Mendapatkan tanggal pertama bulan sekarang
	function getFirstDayOfMonth() {
		$firstDay = new DateTime('first day of this month');
		return $firstDay->format('Y-m-d');
	}

	// Mendapatkan tanggal terakhir bulan sekarang
	function getLastDayOfMonth() {
		$lastDay = new DateTime('last day of this month');
		return $lastDay->format('Y-m-d');
	}

	
	function tampil_rekap() {
		$data['userid'] = $this->Mlogin->tampil_user();
		$data['jual_thn']=$this->M_rekap->get_tahun_jual();
        $tahun = $this->input->get('thn'); // Ambil nilai tahun dari get data
		$data['tahun'] = $tahun;
		
		$data['jml_bln'] = $this->M_rekap->get_jumlah_bulan($tahun);
		$minJmlBln = 2;	// Menetapkan nilai minimum untuk jml_bln
		// Menggunakan kondisi untuk menetapkan nilai jml_bln
		$data['jml_bln'] = ($data['jml_bln'] == 1) ? $minJmlBln : $data['jml_bln'];

        $data['data'] = $this->M_rekap->tampil_jual_rekap($tahun);
        $this->load->view('admin/v_rekap', $data); // Sesuaikan dengan nama view data Anda
    }

	function tampil_data() {
		$regid = $this->input->post('regid');
		$cari = $this->input->post('cari');
		$tgl1 = $this->input->post('tgl1');
		$tgl2 = $this->input->post('tgl2');
		
		$data = $this->M_rekap->tampil_data($regid, $cari, $tgl1, $tgl2);
		
		if (!empty($data)) {
			$response = array(
				'data' => $data,
				'cari' => $cari
			);
			echo json_encode($response);
		} else {
			$response = array(
				'message' => 'Data not found'
			);
			echo json_encode($response);
		}
	}

	function cetak_rekap_excel() {
		$data['userid'] = $this->Mlogin->tampil_user();
		$data['jual_thn']=$this->M_rekap->get_tahun_jual();
        $tahun = $this->input->post('thn2'); // Ambil nilai tahun dari get data
		$data['tahun'] = $tahun;
		
		$data['jml_bln'] = $this->M_rekap->get_jumlah_bulan($tahun);
		$minJmlBln = 2;	// Menetapkan nilai minimum untuk jml_bln
		// Menggunakan kondisi untuk menetapkan nilai jml_bln
		$data['jml_bln'] = ($data['jml_bln'] == 1) ? $minJmlBln : $data['jml_bln'];

        $data['data'] = $this->M_rekap->tampil_jual_rekap($tahun);
        
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=Rekap_Data_Penjualan.xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		$this->load->view('admin/laporan/excel/v_excel_rekap_penjualan',$data);
	}


}