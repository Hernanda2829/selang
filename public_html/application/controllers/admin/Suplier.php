<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Suplier extends CI_Controller{
	function __construct(){
		parent::__construct();
		if($this->session->userdata('masuk') !=TRUE){
            $url=base_url();
            redirect($url);
        };
		$this->load->model('M_suplier');
		$this->load->model('Mlogin');
	}
	function index(){
	if($this->session->userdata('akses')=='1'){
		$data['userid'] = $this->Mlogin->tampil_user();
		$data['data']=$this->M_suplier->tampil_suplier();
		$this->load->view('admin/v_suplier',$data);
	}else{
        echo "Halaman tidak ditemukan";
    }
	}
	function tambah_suplier(){
	if($this->session->userdata('akses')=='1'){
		$nama=$this->input->post('nama');
		$alamat=$this->input->post('alamat');
		$notelp=$this->input->post('notelp');
		$this->M_suplier->simpan_suplier($nama,$alamat,$notelp);
		redirect('admin/suplier');
	}else{
        echo "Halaman tidak ditemukan";
    }
	}
	function edit_suplier(){
	if($this->session->userdata('akses')=='1'){
		$kode=$this->input->post('kode');
		$nama=$this->input->post('nama');
		$alamat=$this->input->post('alamat');
		$notelp=$this->input->post('notelp');
		$this->M_suplier->update_suplier($kode,$nama,$alamat,$notelp);
		redirect('admin/suplier');
	}else{
        echo "Halaman tidak ditemukan";
    }
	}
	function hapus_suplier(){
	if($this->session->userdata('akses')=='1'){
		$kode=$this->input->post('kode');
		$this->M_suplier->hapus_suplier($kode);
		redirect('admin/suplier');
	}else{
        echo "Halaman tidak ditemukan";
    }
	}

	function cetak_alamat(){
		$data['kolom'] = $this->input->post('kolom');
		$data['baris'] = $this->input->post('baris');
		$id = $this->input->post('txtidsup');
		$data['userid'] = $this->Mlogin->tampil_user();
		$data['data'] = $this->M_suplier->get_suplier($id);
		$this->load->view('admin/cetak/v_cetak_alamat', $data);
	}


}