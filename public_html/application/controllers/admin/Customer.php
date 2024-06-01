<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Customer extends CI_Controller{
	function __construct(){
		parent::__construct();
		if($this->session->userdata('masuk') !=TRUE){
            $url=base_url();
            redirect($url);
        };
		$this->load->model('M_customer');
		$this->load->model('Mlogin');
	}

	function index(){
	if($this->session->userdata('akses')=='1'){
		$data['userid'] = $this->Mlogin->tampil_user();
		$data['data']=$this->M_customer->tampil_customer();
		$data['show_button'] = true;//tampil button hapus
		$this->load->view('admin/v_customer',$data);
	}elseif($this->session->userdata('akses')=='2') {
        $data['userid'] = $this->Mlogin->tampil_user();
		$data['data']=$this->M_customer->tampil_customerkasir();
		$data['show_button'] = false;//sembunyikan button hapus
		$this->load->view('admin/v_customer',$data);
    }
	}

	function tambah_customer(){
	if($this->session->userdata('akses')=='1'){
		$nama=$this->input->post('nama');
		$alamat=$this->input->post('alamat');
		$notelp=$this->input->post('notelp');
		$this->M_customer->simpan_customer($nama,$alamat,$notelp);
		redirect('admin/customer');
	}elseif($this->session->userdata('akses')=='2') {
        $nama=$this->input->post('nama');
		$alamat=$this->input->post('alamat');
		$notelp=$this->input->post('notelp');
		$this->M_customer->simpan_customer($nama,$alamat,$notelp);
		redirect('admin/customer');
    }
	}

	function edit_customer(){
	if($this->session->userdata('akses')=='1'){
		$kode=$this->input->post('kode');
		$nama=$this->input->post('nama');
		$alamat=$this->input->post('alamat');
		$notelp=$this->input->post('notelp');
		$this->M_customer->update_customer($kode,$nama,$alamat,$notelp);
		redirect('admin/customer');
	}elseif($this->session->userdata('akses')=='2') {
        $kode=$this->input->post('kode');
		$nama=$this->input->post('nama');
		$alamat=$this->input->post('alamat');
		$notelp=$this->input->post('notelp');
		$this->M_customer->update_customer($kode,$nama,$alamat,$notelp);
		redirect('admin/customer');
    }
	}

	function hapus_customer(){
	if($this->session->userdata('akses')=='1'){
		$kode=$this->input->post('kode');
		$this->M_customer->hapus_customer($kode);
		redirect('admin/customer');
	}elseif($this->session->userdata('akses')=='2') {
        //$kode=$this->input->post('kode');
		//$this->M_customer->hapus_customer($kode);
		echo $this->session->set_flashdata('msg', '<label class="label label-danger">Maaf user anda tidak diperkenankan untuk menghapus data tersebut</label>');
		redirect('admin/customer');
    }
	}
}