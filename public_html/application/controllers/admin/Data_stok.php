<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Data_stok extends CI_Controller{
	function __construct(){
		parent::__construct();
		if($this->session->userdata('masuk') !=TRUE){
            $url=base_url();
            redirect($url);
        };
		$this->load->model('Mlogin');
		$this->load->model('M_data_stok');
	}


	function index(){
		$firstDay = $this->getFirstDayOfMonth();
		$lastDay = $this->getLastDayOfMonth();
		$data['firstDayOfMonth'] = $firstDay;
		$data['lastDayOfMonth'] = $lastDay;
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
		if($this->session->userdata('akses')=='1'){
			$data['namacab'] = "Gabungan (Global)";
			$data['data'] = $this->M_data_stok->tampil_barang_global($thnbln);
			$this->load->view('admin/v_data_stok', $data);
		}elseif($this->session->userdata('akses')=='2'){
			$regid=$this->session->userdata('regid');
			$data['data'] = $this->M_data_stok->tampil_barang($thnbln,$regid);
			$this->load->view('admin/v_data_stok_kasir', $data);
		}else{
			echo "Halaman tidak ditemukan";
		}

	}

	// Mendapatkan tanggal pertama bulan sekarang
	private function getFirstDayOfMonth() {
		$firstDay = new DateTime('first day of this month');
		return $firstDay->format('Y-m-d');
	}

	// Mendapatkan tanggal terakhir bulan sekarang
	private function getLastDayOfMonth() {
		$lastDay = new DateTime('last day of this month');
		return $lastDay->format('Y-m-d');
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
		$firstDay = $this->getFirstDayOfMonth();
		$lastDay = $this->getLastDayOfMonth();
		$data['firstDayOfMonth'] = $firstDay;
		$data['lastDayOfMonth'] = $lastDay;
		$regid = $this->input->post('regid');
		$namcab = $this->input->post('namacab');
		$bln = $this->input->post('cari_bln');
		$thn = $this->input->post('cari_thn');
		//$thnbln = $thn . '-' . $bln;
		$thnbln = sprintf('%04d-%02d', $thn, $bln);
		$data['bln'] = $bln;
		$data['thn'] = $thn;
		// Panggil fungsi untuk mendapatkan data bulan
		$bulanData = $this->getBulanData($data['bln']);
		$data['userid'] = $this->Mlogin->tampil_user();
		$data['namacab'] = $namcab;
		$data['daftar_bln'] = $bulanData['daftar_bln'];
		$data['nm_bln'] = $bulanData['nm_bln'];
		$data['daftar_thn'] = range(date("Y"), 2010);
		if ($regid == '0') {
            $data['data'] = $this->M_data_stok->tampil_barang_global($thnbln);
        }elseif ($regid !== null && $regid !== '') {
			$data['data'] = $this->M_data_stok->tampil_barang($thnbln,$regid);
		} else {
            $data['data'] = $this->M_data_stok->tampil_barang_global($thnbln);
        }

		if($this->session->userdata('akses')=='1'){
			$this->load->view('admin/v_data_stok', $data);
		}elseif($this->session->userdata('akses')=='2'){
			$this->load->view('admin/v_data_stok_kasir', $data);
		}else{
			echo "Halaman tidak ditemukan";
		}
	}

	//untuk sementara tidak digunakan, jangan di hapus , pada file view juga di komentari
	// function cetak_data_stok() {
	// 	$regid = $this->input->post('regid');
	// 	$namcab = $this->input->post('namacab');
	// 	$bln = $this->input->post('cari_bln');
	// 	$thn = $this->input->post('cari_thn');
	// 	//$thnbln = $thn . '-' . $bln;
	// 	$thnbln = sprintf('%04d-%02d', $thn, $bln);
	// 	$data['bln'] = $bln;
	// 	$data['thn'] = $thn;
	// 	// Panggil fungsi untuk mendapatkan data bulan
	// 	$bulanData = $this->getBulanData($data['bln']);
	// 	$data['userid'] = $this->Mlogin->tampil_user();
	// 	$data['namacab'] = $namcab;
	// 	$data['daftar_bln'] = $bulanData['daftar_bln'];
	// 	$data['nm_bln'] = $bulanData['nm_bln'];
	// 	$data['daftar_thn'] = range(date("Y"), 2010);
	// 	if ($regid == '0') {
    //         $data['data'] = $this->M_data_stok->tampil_barang_global($thnbln);
    //     }elseif ($regid !== null && $regid !== '') {
	// 		$data['data'] = $this->M_data_stok->tampil_barang($thnbln,$regid);
	// 	} else {
    //         $data['data'] = $this->M_data_stok->tampil_barang_global($thnbln);
    //     }

	// 	$this->load->view('admin/cetak/v_cetak_data_stok', $data);
	// }

	function cetak_stok_excel() {
		$regid = $this->input->post('regid');
		$namcab = $this->input->post('namacab');
		$bln = $this->input->post('cari_bln');
		$thn = $this->input->post('cari_thn');
		//$thnbln = $thn . '-' . $bln;
		$thnbln = sprintf('%04d-%02d', $thn, $bln);
		$data['bln'] = $bln;
		$data['thn'] = $thn;
		// Panggil fungsi untuk mendapatkan data bulan
		$bulanData = $this->getBulanData($data['bln']);
		$data['userid'] = $this->Mlogin->tampil_user();
		$data['namacab'] = $namcab;
		$data['daftar_bln'] = $bulanData['daftar_bln'];
		$data['nm_bln'] = $bulanData['nm_bln'];
		$data['daftar_thn'] = range(date("Y"), 2010);

		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=Data_Stok_Barang.xls");
		header("Pragma: no-cache");
		header("Expires: 0");

		if($this->session->userdata('akses')=='1'){
			if ($regid == '0') {
				$data['data'] = $this->M_data_stok->tampil_barang_global($thnbln);
			}elseif ($regid !== null && $regid !== '') {
				$data['data'] = $this->M_data_stok->tampil_barang($thnbln,$regid);
			} else {
				$data['data'] = $this->M_data_stok->tampil_barang_global($thnbln);
			}
			
			$this->load->view('admin/laporan/excel/v_excel_data_stok',$data);

		}elseif($this->session->userdata('akses')=='2'){
			$data['data'] = $this->M_data_stok->tampil_barang($thnbln,$regid);
			$this->load->view('admin/laporan/excel/v_excel_data_stok_kasir',$data);
		}
        
		
		
		
	}

	function history_stok(){
		$regid = $this->input->post('regid');
        $idbrg = $this->input->post('idbrg');
		$tgl1 = $this->input->post('tgl1');
		$tgl2 = $this->input->post('tgl2');
		if($this->session->userdata('akses')=='1'){
			if ($regid == '0') {
				$data = $this->M_data_stok->history_stok_global($regid,$idbrg,$tgl1,$tgl2);
			}elseif ($regid !== null && $regid !== '') {
				$data = $this->M_data_stok->history_stok($regid,$idbrg,$tgl1,$tgl2);
			} else {
				$data = $this->M_data_stok->history_stok_global($regid,$idbrg,$tgl1,$tgl2);
			}
		}elseif($this->session->userdata('akses')=='2'){
			$data = $this->M_data_stok->history_stok($regid,$idbrg,$tgl1,$tgl2);
		}

        if (!empty($data)) {
            echo json_encode($data);
        } else {
            echo json_encode(array('error' => 'Data not found'));
        }
	}

	function get_stok(){
		$stokid = $this->input->post('stokid');
		$data = $this->M_data_stok->get_stok($stokid);
        if (!empty($data)) {
            echo json_encode($data);
        } else {
            echo json_encode(array('error' => 'Data not found'));
        }
	}

	function update_stok(){
		$stokid = $this->input->post('stokid3');
		$tgl = $this->input->post('tgl3');
		$data = $this->M_data_stok->update_stok($stokid,$tgl);
        if (!empty($data)) {
            echo json_encode($data);
        } else {
            echo json_encode(array('error' => 'Data not found'));
        }
	}


}