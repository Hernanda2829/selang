<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Penjualan_data extends CI_Controller{
	function __construct(){
		parent::__construct();
		if($this->session->userdata('masuk') !=TRUE){
            $url=base_url();
            redirect($url);
        };
		$this->load->model('Mlogin');
		$this->load->model('M_penjualan_data');
	}

	function index(){
		if($this->session->userdata('akses')=='1'){
			$data['namacab'] = "Gabungan (Global)";
			$regid=$this->session->userdata('regid');
			$firstDay = $this->getFirstDayOfMonth();
			$lastDay = $this->getLastDayOfMonth();
			$data['firstDayOfMonth'] = $firstDay;
			$data['lastDayOfMonth'] = $lastDay;
			$data['regions']=$this->Mlogin->tampil_regions();
			$data['userid'] = $this->Mlogin->tampil_user();
			$data['data'] = $this->M_penjualan_data->tampil_penjualan_global($firstDay,$lastDay);
			$this->load->view('admin/v_penjualan_data_admin',$data);
		}elseif($this->session->userdata('akses')=='2'){
			$regid=$this->session->userdata('regid');
			$firstDay = $this->getFirstDayOfMonth();
			$lastDay = $this->getLastDayOfMonth();
			$data['firstDayOfMonth'] = $firstDay;
			$data['lastDayOfMonth'] = $lastDay;
			$data['userid'] = $this->Mlogin->tampil_user();
			$data['data'] = $this->M_penjualan_data->tampil_penjualan($regid,$firstDay,$lastDay);
			$this->load->view('admin/v_penjualan_data',$data);
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

	function get_penjualan_data() {
        $regid = $this->input->post('regid');
		$firstDay = $this->input->post('tgl1');
		$lastDay = $this->input->post('tgl2'); 
        if($this->session->userdata('akses')=='1'){
			if ($regid == '0') {
				$data = $this->M_penjualan_data->tampil_penjualan_global($firstDay,$lastDay);
			}elseif ($regid !== null && $regid !== '') {
				$data = $this->M_penjualan_data->tampil_penjualan($regid,$firstDay,$lastDay);
			} else {
				$data = $this->M_penjualan_data->tampil_penjualan_global($firstDay,$lastDay);
			}
        }elseif($this->session->userdata('akses')=='2'){
            $data = $this->M_penjualan_data->tampil_penjualan($regid,$firstDay,$lastDay);
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

    function get_detail_jual(){
		$nofak = $this->input->post('nofak');
		$data = $this->M_penjualan_data->getdetailjual($nofak);
		if (!empty($data)) {
			echo json_encode($data);
		} else {
			echo json_encode(array('error' => 'Data not found'));
		}
	}
   
	function cetak_faktur($nofak) {
		$x['userid'] = $this->Mlogin->tampil_user();
		$x['data']=$this->M_penjualan_data->get_faktur($nofak);
		$this->load->view('admin/laporan/v_faktur',$x);
	}

	function cetak_faktur2($nofak) {
		$x['userid'] = $this->Mlogin->tampil_user();
		$x['data']=$this->M_penjualan_data->get_faktur($nofak);
		$this->load->view('admin/laporan/v_faktur_2',$x);
	}
    

	function lap_data_penjualan(){
		if($this->session->userdata('akses')=='1'){
			$regid = $this->input->post('regid');
			$firstDay = $this->input->post('tgl1');
			$lastDay = $this->input->post('tgl2');
			$x['tgl1'] = $firstDay;
			$x['tgl2'] = $lastDay;
			$x['namacab'] = $this->input->post('namacab');
			$x['userid'] = $this->Mlogin->tampil_user();
			if ($regid == '0') {
				$x['data'] = $this->M_penjualan_data->tampil_penjualan_global($firstDay,$lastDay);
			}elseif ($regid !== null && $regid !== '') {
				$x['data'] = $this->M_penjualan_data->tampil_penjualan($regid,$firstDay,$lastDay);
			} else {
				$x['data'] = $this->M_penjualan_data->tampil_penjualan_global($firstDay,$lastDay);
			}
			$this->load->view('admin/cetak/v_cetak_penjualan_admin',$x);
		}elseif($this->session->userdata('akses')=='2') {
			$regid = $this->input->post('regid');
			$firstDay = $this->input->post('tgl1');
			$lastDay = $this->input->post('tgl2');
			$x['userid'] = $this->Mlogin->tampil_user();
			$x['data'] = $this->M_penjualan_data->tampil_penjualan($regid,$firstDay,$lastDay);
			$this->load->view('admin/cetak/v_cetak_penjualan',$x);
		}
	}


	
}