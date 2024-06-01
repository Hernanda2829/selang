<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Kolek extends CI_Controller{
	function __construct(){
		parent::__construct();
		if($this->session->userdata('masuk') !=TRUE){
            $url=base_url();
            redirect($url);
        };
		$this->load->model('M_kolek');
        $this->load->model('Mlogin');
	}

	function index(){
		if($this->session->userdata('akses')=='1'){
			$data['userid'] = $this->Mlogin->tampil_user();
			$data['regions']=$this->Mlogin->tampil_regions();
			$data['data']=$this->M_kolek->tampil_kolek();
			$this->load->view('admin/v_kolek',$data);
		}
	}

	function tambah_kolek(){
		if($this->session->userdata('akses')=='1'){
			$kolbln=$this->input->post('kolbln');
			$kolhari=$this->input->post('kolhari');
			$kolwarna=$this->input->post('kolwarna');
			$kolket=$this->input->post('kolket');
			$stopsales=$this->input->post('stopsales');
			$this->M_kolek->simpan_kolek($kolbln,$kolhari,$kolwarna,$kolket,$stopsales);
			redirect('admin/kolek');
		}
	}

	function edit_kolek(){
		if($this->session->userdata('akses')=='1'){
			$kode=$this->input->post('kode');
			$kolbln=$this->input->post('kolbln');
			$kolhari=$this->input->post('kolhari');
			$kolwarna=$this->input->post('kolwarna');
			$kolket=$this->input->post('kolket');
			$stopsales=$this->input->post('stopsales');
			$this->M_kolek->update_kolek($kode,$kolbln,$kolhari,$kolwarna,$kolket,$stopsales);
			redirect('admin/kolek');
		}
	}

	function hapus_kolek(){
		if($this->session->userdata('akses')=='1'){
			$kode=$this->input->post('kode');
			$this->M_kolek->hapus_kolek($kode);
			redirect('admin/kolek');
		}
	}
}