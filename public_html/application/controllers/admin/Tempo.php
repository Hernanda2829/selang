<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Tempo extends CI_Controller{
	function __construct(){
		parent::__construct();
		if($this->session->userdata('masuk') !=TRUE){
            $url=base_url();
            redirect($url);
        };
		$this->load->model('Mlogin');
		$this->load->model('M_tempo');
	}
	function index(){
	if($this->session->userdata('akses')=='1'){
		$this->M_tempo->update_kolek();
		$data['userid'] = $this->Mlogin->tampil_user();
		$data['data']=$this->M_tempo->tampil_jual_tempo();
		//----------------------------------------
		$data['datakolek'] = $this->M_tempo->tampil_kolek();
		$thnbln = sprintf('%04d-%02d', date("Y"), date("n"));
		$data['bln'] = date("n");
		$data['thn'] = date("Y");
		// Panggil fungsi untuk mendapatkan data bulan
		$bulanData = $this->getBulanData($data['bln']);
		$data['daftar_bln'] = $bulanData['daftar_bln'];
		$data['nm_bln'] = $bulanData['nm_bln'];
		$data['daftar_thn'] = range(date("Y"), 2010);
		
		$data['thnbln'] = $thnbln;
		$data['datatempo'] = $this->M_tempo->tampil_tempo_rekap($thnbln);
		$this->load->view('admin/v_tempo',$data);
	}elseif($this->session->userdata('akses')=='2'){    
		
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

	function get_tampil_tempo() {
		$bln = $this->input->post('cari_bln');
		$thn = $this->input->post('cari_thn');
		//$thnbln = $thn . '-' . $bln;
		$thnbln = sprintf('%04d-%02d', $thn, $bln);
        $data = $this->M_tempo->tampil_tempo_rekap($thnbln);
		if (!empty($data)) {
			// Jika ada data, kirim data dalam format JSON sebagai respons
			echo json_encode($data);
		} else {
			// Jika tidak ada data, kirim respons kosong atau pesan kesalahan jika diperlukan
			echo json_encode(array('error' => 'Data not found'));
		}
    }

	function get_jual_bayar() {
		$nofak = $this->input->get('nofak'); // Ambil nomor faktur dari parameter GET
		$data = $this->M_tempo->getjualbayar($nofak);
		// Periksa apakah ada data yang ditemukan
		if (!empty($data)) {
			// Jika ada data, kirim data dalam format JSON sebagai respons
			echo json_encode($data);
		} else {
			// Jika tidak ada data, kirim respons kosong atau pesan kesalahan jika diperlukan
			echo json_encode(array('error' => 'Data not found'));
		}
    }

	function get_detail_jual(){
		$nofak = $this->input->post('nofak');
		$data = $this->M_tempo->getdetailjual($nofak);
		if (!empty($data)) {
			echo json_encode($data);
		} else {
			echo json_encode(array('error' => 'Data not found'));
		}
	}

	function cetak_rekap() {
		$data['userid'] = $this->Mlogin->tampil_user();
		$bln = $this->input->post('cari_bln');
		$thn = $this->input->post('cari_thn');
		$thnbln = sprintf('%04d-%02d', $thn, $bln);
		$bulan = $this->getBulanData($bln);
		$nmbln = $bulan['nm_bln']; // Mendapatkan nama bulan untuk angka bulan 1
		$data['bln'] = $bln;
		$data['thn'] = $thn;
		$data['blnthn'] = $nmbln.' '.$thn;
		$data['datakolek'] = $this->M_tempo->tampil_kolek();
		$data['datatempo'] = $this->M_tempo->tampil_tempo_rekap($thnbln);
		$this->load->view('admin/cetak/v_cetak_rekap_tempo', $data);
	}


	function tampil_tempo_cabang() {
		$bln = $this->input->post('cari_bln');
		$thn = $this->input->post('cari_thn');
		$regid = $this->input->post('regid');
		$thnbln = sprintf('%04d-%02d', $thn, $bln);

		if ($regid == '0') {
            $data = $this->M_tempo->tampil_tempo_cabang_admin($thnbln);
        }elseif ($regid !== null && $regid !== '') {
			$data = $this->M_tempo->tampil_tempo_cabang($regid,$thnbln);
		} else {
            $data = $this->M_tempo->tampil_tempo_cabang_admin($thnbln);
        }
        
		if (!empty($data)) {
			// Jika ada data, kirim data dalam format JSON sebagai respons
			echo json_encode($data);
		} else {
			// Jika tidak ada data, kirim respons kosong atau pesan kesalahan jika diperlukan
			echo json_encode(array('error' => 'Data not found'));
		}
    }

	function cetak_lihat_excel() {
		$data['userid'] = $this->Mlogin->tampil_user();
		$bln = $this->input->post('txtbln');
		$thn = $this->input->post('txtthn');
		$regid = $this->input->post('txtregid');
		$cab = $this->input->post('txtcab');
		$thnbln = sprintf('%04d-%02d', $thn, $bln);
		$bulan = $this->getBulanData($bln);
		$nmbln = $bulan['nm_bln']; // Mendapatkan nama bulan untuk angka bulan 1
		$data['bln'] = $bln;
		$data['thn'] = $thn;
		$data['blnthn'] = $nmbln.' '.$thn;
		$data['cab'] = $cab;
		if ($regid == '0') {
            $data['data'] = $this->M_tempo->tampil_tempo_cabang_admin($thnbln);
        }elseif ($regid !== null && $regid !== '') {
			$data['data'] = $this->M_tempo->tampil_tempo_cabang($regid,$thnbln);
		} else {
            $data['data'] = $this->M_tempo->tampil_tempo_cabang_admin($thnbln);
        }
	
        header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=Rekap_Tempo.xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		$this->load->view('admin/laporan/excel/v_excel_rekap_tempo_lihat',$data);
	}

}