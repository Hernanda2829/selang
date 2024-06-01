<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Beban_data extends CI_Controller{
	function __construct(){
		parent::__construct();
		if($this->session->userdata('masuk') !=TRUE){
            $url=base_url();
            redirect($url);
        };
		$this->load->model('Mlogin');
		$this->load->model('M_beban_data');
	}
	function index(){
	if($this->session->userdata('akses')=='1'){
		
	}elseif($this->session->userdata('akses')=='2'){
        $regid=$this->session->userdata('regid');
        $tgl1 = $this->getFirstDayOfMonth();
        $tgl2 = $this->getLastDayOfMonth();
		$cari="";
        $data['firstDayOfMonth'] = $tgl1;
        $data['lastDayOfMonth'] = $tgl2;
        $data['userid'] = $this->Mlogin->tampil_user();
        $data['data'] = $this->M_beban_data->tampil_beban($regid,$tgl1,$tgl2,$cari);
		$data['data_kategori'] = $this->M_beban_data->get_kategori();
		$this->load->view('admin/v_beban_data',$data);
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

	function tampil_data_beban($nilai) {
		if ($this->session->userdata('akses') == '1') {
			// ...
		} elseif ($this->session->userdata('akses') == '2') {
			$regid = $this->input->post('regid');
			$tgl1 = $this->input->post('tgl1');
			$tgl2 = $this->input->post('tgl2');
			$cari = $this->input->post('kat_beb');
			$x['tgl1'] = $tgl1;
			$x['tgl2'] = $tgl2;
			$x['userid'] = $this->Mlogin->tampil_user();
			$x['data'] = $this->M_beban_data->tampil_beban($regid, $tgl1, $tgl2, $cari);
			
			if ($nilai == 1) {
				$this->load->view('admin/cetak/v_cetak_beban_a', $x);
			} elseif ($nilai == 2) {
				$this->load->view('admin/cetak/v_cetak_beban_b', $x);
			}
		}
	}


	function get_data_beban() {
        $regid = $this->input->post('regid');
		$tgl1 = $this->input->post('tgl1');
		$tgl2 = $this->input->post('tgl2');
		$cari = $this->input->post('cari');
        
        if($this->session->userdata('akses')=='1'){
        
        }elseif($this->session->userdata('akses')=='2'){
            $data = $this->M_beban_data->tampil_beban($regid,$tgl1,$tgl2,$cari);
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
	
}