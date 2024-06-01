<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Tempo_admin extends CI_Controller{
	function __construct(){
		parent::__construct();
		if($this->session->userdata('masuk') !=TRUE){
            $url=base_url();
            redirect($url);
        };
		$this->load->model('M_tempo_admin');
		$this->load->model('Mlogin');
	}

	function index(){
	if($this->session->userdata('akses')=='1'){
		$data['userid'] = $this->Mlogin->tampil_user();
		$data['data']=$this->M_tempo_admin->tampil_penjualan();
		$data['regions']=$this->Mlogin->tampil_regions();
		$data['periode'] = $this->M_tempo_admin->tampil_periode();
		$data['cust']=$this->M_tempo_admin->tampil_customer_all();
		$data['today'] = date('Y-m-d');
		$this->load->view('admin/v_tempo_admin',$data);
	}else{
        echo "Halaman tidak ditemukan";
    }
	}
	

	function tampil_customer() {
		$regid = $this->input->post('regid');
		$data = $this->M_tempo_admin->tampil_customer($regid);
		if (!empty($data)) {
            echo json_encode($data);
        } else {
            echo json_encode(array('error' => 'Data not found'));
        }
	}

	function get_tempo(){
		$nofak = $this->input->post('kode');
        $data = $this->M_tempo_admin->get_tempo($nofak);
        if (!empty($data)) {
            echo json_encode($data);
        } else {
            echo json_encode(array('error' => 'Data not found'));
        }
	}

	function hapus_tempo(){
	if($this->session->userdata('akses')=='1'){
		$kode=$this->input->post('txtkode');
		$this->M_tempo_admin->hapus_tempo($kode);
		redirect('admin/tempo_admin');
	}else{
        echo "Halaman tidak ditemukan";
    }
	}

	
	function update_tempo() {
	if($this->session->userdata('akses')=='1'){
		$regid=$this->input->post('regid');
		$nofak=$this->input->post('nofak');
		$idcust=$this->input->post('idcust');
		$nota=$this->input->post('nota');
		$jtot=str_replace([',', '.'], "", $this->input->post('jtot'));
		$tgljual=$this->input->post('tgljual');
		$prdbln=$this->input->post('prdbln');
		$tgljual_timestamp = strtotime($tgljual);	// Konversi string tanggal penjualan ke format timestamp
		$jtempo = strtotime("+" . $prdbln . " months", $tgljual_timestamp);	// Hitung tanggal jatuh tempo dengan menambahkan bulan
		$tgljtempo = date("Y-m-d", $jtempo);
		$jhari = (new DateTime($tgljual))->diff(new DateTime($tgljtempo))->days;
		$this->M_tempo_admin->update_tempo($regid,$nofak,$idcust,$nota,$tgljual,$prdbln,$jtot,$tgljtempo,$jhari);
		redirect('admin/tempo_admin');
	}else{
        echo "Halaman tidak ditemukan";
    }

	}

	function add_tempo() {
	if($this->session->userdata('akses')=='1'){
		$regid=$this->input->post('regid2');
		$idcust=$this->input->post('idcust2');
		$nota=$this->input->post('nota2');
		$jtot=str_replace([',', '.'], "", $this->input->post('jtot2'));
		$tgljual=$this->input->post('tgljual2');
		$prdbln=$this->input->post('prdbln2');
		$tgljual_timestamp = strtotime($tgljual);	// Konversi string tanggal penjualan ke format timestamp
		$jtempo = strtotime("+" . $prdbln . " months", $tgljual_timestamp);	// Hitung tanggal jatuh tempo dengan menambahkan bulan
		$tgljtempo = date("Y-m-d", $jtempo);
		$jhari = (new DateTime($tgljual))->diff(new DateTime($tgljtempo))->days;
		$this->M_tempo_admin->add_tempo($regid,$idcust,$nota,$tgljual,$prdbln,$jtot,$tgljtempo,$jhari);
		redirect('admin/tempo_admin');
	}else{
        echo "Halaman tidak ditemukan";
    }

	}
	

}