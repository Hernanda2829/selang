<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class History_stok extends CI_Controller{
	function __construct(){
		parent::__construct();
		if($this->session->userdata('masuk') !=TRUE){
            $url=base_url();
            redirect($url);
        };
		$this->load->model('Mlogin');
		$this->load->model('M_history_stok');
	}


	function index(){
		$tgl=date('Y-m-d');
		//$tgl='2024-01-23';
		$data['today'] = date('Y-m-d');
		$data['namacab'] = "Gabungan (Global)";
		$data['userid'] = $this->Mlogin->tampil_user();
		$data['data'] = $this->M_history_stok->tampil_barang_global($tgl);
		$this->load->view('admin/v_history_stok', $data);
	}

	
	function tampil_data() {
		$tgl=$this->input->post('tgl');
		$regid = $this->input->post('regid');
		$namcab = $this->input->post('namacab');
		$data['today'] = $tgl;
		$data['namacab'] = $namcab;
		$data['userid'] = $this->Mlogin->tampil_user();
		
		if ($regid == '0') {
            $data['data'] = $this->M_history_stok->tampil_barang_global($tgl);
        }elseif ($regid !== null && $regid !== '') {
			 $data['data'] = $this->M_history_stok->tampil_barang($tgl,$regid);
		} else {
            $data['data'] = $this->M_history_stok->tampil_barang_global($tgl);
        }
		$this->load->view('admin/v_history_stok', $data);
		
		
	}

	function cetak_stok_excel() {
		$tgl=$this->input->post('tgl');
		$regid = $this->input->post('regid');
		$namcab = $this->input->post('namacab');
		$data['today'] = $tgl;
		$data['namacab'] = $namcab;
		$data['userid'] = $this->Mlogin->tampil_user();
		
		if ($regid == '0') {
            $data['data'] = $this->M_history_stok->tampil_barang_global($tgl);
        }elseif ($regid !== null && $regid !== '') {
			 $data['data'] = $this->M_history_stok->tampil_barang($tgl,$regid);
		} else {
            $data['data'] = $this->M_history_stok->tampil_barang_global($tgl);
        }
        
		
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=History_Stok_Barang_".$tgl.".xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		$this->load->view('admin/laporan/excel/v_excel_history_stok',$data);
	}
	

	function history_stok(){
		$regid = $this->input->post('regid');
        $idbrg = $this->input->post('idbrg');
		$tgl = $this->input->post('tgl');
		if ($regid == '0') {
            $data = $this->M_history_stok->history_stok_global($idbrg,$tgl);
        }elseif ($regid !== null && $regid !== '') {
			$data = $this->M_history_stok->history_stok($regid,$idbrg,$tgl);
		} else {
             $data = $this->M_history_stok->history_stok_global($idbrg,$tgl);
        }

        if (!empty($data)) {
            echo json_encode($data);
        } else {
            echo json_encode(array('error' => 'Data not found'));
        }
	}
	


}