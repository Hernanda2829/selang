<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Piutang extends CI_Controller{
	function __construct(){
		parent::__construct();
		if($this->session->userdata('masuk') !=TRUE){
            $url=base_url();
            redirect($url);
        };
		$this->load->model('Mlogin');
		$this->load->model('M_piutang');
	}
	
	function index(){
	if($this->session->userdata('akses')=='1'){
		
	}elseif($this->session->userdata('akses')=='2'){
        $regid=$this->session->userdata('regid');
		$tgl1 = $this->getFirstDayOfMonth();
        $tgl2 = $this->getLastDayOfMonth();
        $data['firstDayOfMonth'] = $tgl1;
        $data['lastDayOfMonth'] = $tgl2;
		$data['userid'] = $this->Mlogin->tampil_user();
        $data['data'] = $this->M_piutang->tampil_tempo($regid);
		$data['rekap'] = $this->M_piutang->tampil_rekap_tempo($regid);
		$data['pembayaran'] = $this->M_piutang->tampil_bayar($regid,$tgl1,$tgl2);
		$this->load->view('admin/v_piutang',$data);
    }
	}

	function get_jual_bayar() {
		$nofak = $this->input->get('nofak'); // Ambil nomor faktur dari parameter GET
		$data = $this->M_piutang->getjualbayar($nofak);
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
		$data = $this->M_piutang->getdetailjual($nofak);
		if (!empty($data)) {
			echo json_encode($data);
		} else {
			echo json_encode(array('error' => 'Data not found'));
		}
	}
    

	function get_jual_bayar2() {
		$level_user='2';
		$nofak = $this->input->get('nofak'); // Ambil nomor faktur dari parameter GET
		$data = $this->M_piutang->getjualbayar($nofak);
		// Periksa apakah ada data yang ditemukan
		if (!empty($data)) {
			$data['queryA']['level_user'] = $level_user;
			// Jika ada data, kirim data dalam format JSON sebagai respons
			echo json_encode($data);
		} else {
			// Jika tidak ada data, kirim respons kosong atau pesan kesalahan jika diperlukan
			echo json_encode(array('error' => 'Data not found'));
		}
   
    }

	function tambah_bayar() {
        $nofak=$this->input->post('kode3');
        $tglbyr=$this->input->post('tglbyr3');
        $totbyr=$this->input->post('totbyr3');
        $kurbyr = str_replace([',', '.'], "", $this->input->post('kurbyr3'));
        $jmlbyr = str_replace([',', '.'], "", $this->input->post('jmlbyr'));
        if ($kurbyr==$jmlbyr) {
            $ket="Lunas";
        }else{
            $ket="Belum Lunas";
        }
        $this->M_piutang->tambahbayar($nofak,$tglbyr,$totbyr,$jmlbyr,$ket);
        redirect('admin/piutang');
    }


	function cetak_piutang(){
		if($this->session->userdata('akses')=='1'){
		
		}elseif($this->session->userdata('akses')=='2') {
			$regid=$this->session->userdata('regid');
			$x['userid'] = $this->Mlogin->tampil_user();
			$x['data'] = $this->M_piutang->tampil_tempo($regid);
			$this->load->view('admin/cetak/v_cetak_piutang',$x);
		}

	}

	function cetak_rekap(){
		if($this->session->userdata('akses')=='1'){
		
		}elseif($this->session->userdata('akses')=='2') {
			$regid=$this->session->userdata('regid');
			$x['userid'] = $this->Mlogin->tampil_user();
			$x['data'] = $this->M_piutang->tampil_rekap_tempo($regid);
			$this->load->view('admin/cetak/v_cetak_piutang_rekap',$x);
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

	function get_pembayaran() {
        $regid = $this->input->post('regid');
		$tgl1 = $this->input->post('tgl1');
		$tgl2 = $this->input->post('tgl2');
        
        if($this->session->userdata('akses')=='1'){
        
        }elseif($this->session->userdata('akses')=='2'){
            $data = $this->M_piutang->tampil_bayar($regid,$tgl1,$tgl2);
        }
        
        if (!empty($data)) {
			$response = array(
				'data' => $data
			);
			echo json_encode($response);
		} else {
			$response = array(
				'message' => 'Data not found'
			);
			echo json_encode($response);
		}

    }


	function cetak_bayar(){
		if($this->session->userdata('akses')=='1'){
		
		}elseif($this->session->userdata('akses')=='2') {
			$regid = $this->input->post('regid');
			$tgl1 = $this->input->post('tgl1');
			$tgl2 = $this->input->post('tgl2');
			$x['tgl1'] = $tgl1;
        	$x['tgl2'] = $tgl2;
			$x['userid'] = $this->Mlogin->tampil_user();
			$x['data'] = $this->M_piutang->tampil_bayar($regid,$tgl1,$tgl2);
			$this->load->view('admin/cetak/v_cetak_piutang_bayar',$x);
		}

	}


	
}