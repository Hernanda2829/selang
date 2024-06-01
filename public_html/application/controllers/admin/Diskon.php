<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Diskon extends CI_Controller{
	function __construct(){
		parent::__construct();
		if($this->session->userdata('masuk') !=TRUE){
            $url=base_url();
            redirect($url);
        };
		$this->load->model('M_diskon');
		$this->load->model('Mlogin');
	}
	function index(){
	if($this->session->userdata('akses')=='1'){
		$data['userid'] = $this->Mlogin->tampil_user(); // Mendapatkan data user
		$data['data']=$this->M_diskon->tampil_diskon();
		$this->load->view('admin/v_diskon',$data);
	}else{
        echo "Halaman tidak ditemukan";
    }
	}
	
	function tambah_diskon(){
	if($this->session->userdata('akses')=='1'){
		$nama_diskon = $this->input->post('nama_diskon');
        $rate_diskon = str_replace(',','.', $this->input->post('rate_diskon'));
        $combined_rate_diskon = '';	 // Gabungkan rate_diskon sesuai format yang diinginkan
        $total_rates = count($rate_diskon); //$rate_diskon_combined = implode(';', $rate_diskon);
        for ($i = 0; $i < $total_rates; $i++) {	// Gabungkan rate_diskon sesuai format yang diinginkan
            $combined_rate_diskon .= ($i + 1) . ':' . $rate_diskon[$i];
            if ($i < $total_rates - 1) {
                $combined_rate_diskon .= ';';
            }
        }
        $this->M_diskon->simpan_diskon($nama_diskon, $combined_rate_diskon);
        redirect('admin/diskon');
		//echo "Data diskon berhasil disimpan.";
	}else{
        echo "Halaman tidak ditemukan";
    }
	}

	function edit_diskon(){
	if($this->session->userdata('akses')=='1'){
		$kode=$this->input->post('kode');
		$nama_diskon = $this->input->post('nama_diskon');
        $rate_diskon = str_replace(',','.', $this->input->post('rate_diskon'));
        $combined_rate_diskon = '';	 // Gabungkan rate_diskon sesuai format yang diinginkan
        $total_rates = count($rate_diskon); //$rate_diskon_combined = implode(';', $rate_diskon);
        for ($i = 0; $i < $total_rates; $i++) {	// Gabungkan rate_diskon sesuai format yang diinginkan
            $combined_rate_diskon .= ($i + 1) . ':' . $rate_diskon[$i];
            if ($i < $total_rates - 1) {
                $combined_rate_diskon .= ';';
            }
        }
        $this->M_diskon->update_diskon($kode,$nama_diskon, $combined_rate_diskon);
		redirect('admin/diskon');
	}else{
        echo "Halaman tidak ditemukan";
    }
	}
	function hapus_diskon(){
	if($this->session->userdata('akses')=='1'){
		$kode=$this->input->post('kode');
		$this->M_diskon->hapus_diskon($kode);
		redirect('admin/diskon');
	}else{
        echo "Halaman tidak ditemukan";
    }
	}
}