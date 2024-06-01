<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Beban extends CI_Controller{
	function __construct(){
		parent::__construct();
		if($this->session->userdata('masuk') !=TRUE){
            $url=base_url();
            redirect($url);
        };
		$this->load->model('M_beban');
        $this->load->model('Mlogin');
	}

	function index(){
	if($this->session->userdata('akses')=='1'){
		$firstDay = $this->getFirstDayOfMonth();
		$lastDay = $this->getLastDayOfMonth();
		//$firstDay = '2023-11-01';
		//$lastDay = '2024-02-29';
		$data['firstDayOfMonth'] = $firstDay;
		$data['lastDayOfMonth'] = $lastDay;
		$data['today'] = date('Y-m-d');
        $data['userid'] = $this->Mlogin->tampil_user();
		$data['regions']=$this->Mlogin->tampil_regions();
		$data['beban']=$this->M_beban->tampil_kat_beban();
		$data['data']=$this->M_beban->tampil_beban($firstDay,$lastDay);
		$data['rekening']=$this->M_beban->tampil_rekening();
		$this->load->view('admin/v_beban',$data);
	}elseif($this->session->userdata('akses')=='2') {
        $data['userid'] = $this->Mlogin->tampil_user();
		$regid=$this->session->userdata('regid');
		$data['beban']=$this->M_beban->tampil_kat_beban();
		$data['data']=$this->M_beban->tampil_bebankasir($regid);
		$data['rekening']=$this->M_beban->tampil_rekening();
		$this->load->view('admin/v_bebankasir',$data);
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

	function get_tampil_beban() {
		$firstDay = $this->input->post('tgl1');
		$lastDay = $this->input->post('tgl2');
        $data = $this->M_beban->tampil_beban($firstDay,$lastDay);
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

	function tambah_beban(){
	if($this->session->userdata('akses')=='1'){
		$nama=$this->input->post('nama');
		$jml=str_replace([',', '.'], "", $this->input->post('jml'));
		$katid=$this->input->post('katid');
		$tgl=$this->input->post('tgl');
		$regid=$this->input->post('regid');
		$rek=$this->input->post('rek');
		$nobeb=$this->M_beban->get_beban_no();
		$this->M_beban->simpan_beban($nama,$jml,$katid,$tgl,$regid,$nobeb);
		if (!empty($rek)) {
			$this->M_beban->simpan_transaksi($rek,$tgl,$nama,$jml,$regid,$nobeb);
		}
		redirect('admin/beban');
	}elseif($this->session->userdata('akses')=='2') {
        $nama=$this->input->post('nama');
		$jml=str_replace([',', '.'], "", $this->input->post('jml'));
		$katid=$this->input->post('katid');
		$tgl=date('Y-m-d H:i:s');
		$regid = $this->session->userdata('regid');
		$rek=$this->input->post('rek');
		$nobeb=$this->M_beban->get_beban_no();
		$this->M_beban->simpan_beban($nama,$jml,$katid,$tgl,$regid,$nobeb);
		if (!empty($rek)) {
			$this->M_beban->simpan_transaksi($rek,$tgl,$nama,$jml,$regid,$nobeb);
		}
		redirect('admin/beban');
    }
	}

	function edit_beban(){
	if($this->session->userdata('akses')=='1'){
		$kode=$this->input->post('kode');
		$nobeb=$this->input->post('bankno');
		$norek=$this->input->post('norek');
		$nama=$this->input->post('namaE');
		$jml=str_replace([',', '.'], "", $this->input->post('jmlE'));
		$katid=$this->input->post('katidE');
		$tgl=$this->input->post('tglE');
		$regid=$this->input->post('regidE');
		$rek=$this->input->post('rekE');
		$this->M_beban->update_beban($kode,$nama,$jml,$katid,$tgl,$regid);
		
		if (!empty($norek)) { //jika norek ada, berarti sudah pernah menyimpan ke tbl_bank
			if (!empty($rek)) {
				$this->M_beban->update_bank($nobeb,$nama,$jml,$tgl,$regid,$rek);
			}else {
				//ketika $rek kosong, hapus data di tbl_bank , artinnya mengedit data untuk tidak jadi menyimpan pada tbl_bank
				$this->M_beban->hapus_bank($nobeb);
			}
		} else {
			if (!empty($rek)) {
				$this->M_beban->simpan_transaksi($rek,$tgl,$nama,$jml,$regid,$nobeb);
			}
		}
		redirect('admin/beban');
	}elseif($this->session->userdata('akses')=='2') {
        // $kode=$this->input->post('kode');
		// $nama=$this->input->post('nama');
		// $jml=str_replace([',', '.'], "", $this->input->post('jml'));
		// $katid=$this->input->post('katid');
		// $this->M_beban->update_beban($kode,$nama,$jml,$katid);
		// redirect('admin/beban');
    }
	}

	function hapus_beban(){
	if($this->session->userdata('akses')=='1'){
		$kode=$this->input->post('kodeH');
		$nobeb=$this->input->post('banknoH');
		$this->M_beban->hapus_beban($kode,$nobeb);
		redirect('admin/beban');
	}elseif($this->session->userdata('akses')=='2') {
        // $kode=$this->input->post('kode');
		// $this->M_beban->hapus_beban($kode);
		// redirect('admin/beban');
    }
	}


	function get_beban() {
		$idbeb = $this->input->post('idbeb');
        $data = $this->M_beban->get_beban($idbeb);
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

	


}