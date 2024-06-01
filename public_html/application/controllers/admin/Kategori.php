<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Kategori extends CI_Controller{
	function __construct(){
		parent::__construct();
		if($this->session->userdata('masuk') !=TRUE){
            $url=base_url();
            redirect($url);
        };
		$this->load->model('M_kategori');
		$this->load->model('Mlogin');
	}
	function index(){
	if($this->session->userdata('akses')=='1'){
		$data['userid']=$this->Mlogin->tampil_user();
		$data['data']=$this->M_kategori->tampil_kategori();
		$this->load->view('admin/v_kategori',$data);
	}else{
        echo "Halaman tidak ditemukan";
    }
	}
	function tambah_kategori(){
	if($this->session->userdata('akses')=='1'){
		$kat=$this->input->post('kategori');
		$kat_report=$this->input->post('katreport');
		$this->M_kategori->simpan_kategori($kat,$kat_report);
		redirect('admin/kategori');
	}else{
        echo "Halaman tidak ditemukan";
    }
	}
	function edit_kategori(){
	if($this->session->userdata('akses')=='1'){
		$kode=$this->input->post('kode');
		$kat=$this->input->post('kategori');
		$kat_report=$this->input->post('katreport');
		$this->M_kategori->update_kategori($kode,$kat,$kat_report);
		redirect('admin/kategori');
	}else{
        echo "Halaman tidak ditemukan";
    }
	}
	function hapus_kategori(){
	if($this->session->userdata('akses')=='1'){
		$kode=$this->input->post('kode');
		$this->M_kategori->hapus_kategori($kode);
		redirect('admin/kategori');
	}else{
        echo "Halaman tidak ditemukan";
    }
	}
}