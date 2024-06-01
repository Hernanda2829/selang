<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Periode extends CI_Controller{
	function __construct(){
		parent::__construct();
		if($this->session->userdata('masuk') !=TRUE){
            $url=base_url();
            redirect($url);
        };
		$this->load->model('M_periode');
        $this->load->model('Mlogin');
	}

	function index(){
		if($this->session->userdata('akses')=='1'){
			$data['userid'] = $this->Mlogin->tampil_user();
			$data['regions']=$this->Mlogin->tampil_regions();
			$data['data']=$this->M_periode->tampil_periode();
			$this->load->view('admin/v_periode',$data);
		}
	}

	function tambah_periode(){
		if($this->session->userdata('akses')=='1'){
			$pval=$this->input->post('pval');
			$pnama=$this->input->post('pnama');
			$this->M_periode->simpan_periode($pval,$pnama);
			redirect('admin/periode');
		}
	}

	function edit_periode(){
		if($this->session->userdata('akses')=='1'){
			$kode=$this->input->post('kode');
			$pval=$this->input->post('pval');
			$pnama=$this->input->post('pnama');
			$this->M_periode->update_periode($kode,$pval,$pnama);
			redirect('admin/periode');
		}
	}

	function hapus_periode(){
		if($this->session->userdata('akses')=='1'){
			$kode=$this->input->post('kode');
			$this->M_periode->hapus_periode($kode);
			redirect('admin/periode');
		}
	}
}