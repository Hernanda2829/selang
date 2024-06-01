<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Unit extends CI_Controller{
	function __construct(){
		parent::__construct();
		if($this->session->userdata('masuk') !=TRUE){
            $url=base_url();
            redirect($url);
        };
		$this->load->model('M_unit');
        $this->load->model('Mlogin');
	}

	function index(){
		if($this->session->userdata('akses')=='1'){
			$data['userid'] = $this->Mlogin->tampil_user();
			$data['regions']=$this->Mlogin->tampil_regions();
			$data['data']=$this->M_unit->tampil_unit();
			$this->load->view('admin/v_unit',$data);
		}
	}

	function tambah_unit(){
		if($this->session->userdata('akses')=='1'){
			$nama=$this->input->post('nama');
			$shortnama=$this->input->post('shortnama');
			$this->M_unit->simpan_unit($nama,$shortnama);
			redirect('admin/unit');
		}
	}

	function edit_unit(){
		if($this->session->userdata('akses')=='1'){
			$kode=$this->input->post('kode');
			$nama=$this->input->post('nama');
			$shortnama=$this->input->post('shortnama');
			$this->M_unit->update_unit($kode,$nama,$shortnama);
			redirect('admin/unit');
		}
	}

	function hapus_unit(){
		if($this->session->userdata('akses')=='1'){
			$kode=$this->input->post('kode');
			$this->M_unit->hapus_unit($kode);
			redirect('admin/unit');
		}
	}
}