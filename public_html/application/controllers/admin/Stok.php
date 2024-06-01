<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Stok extends CI_Controller{
	function __construct(){
		parent::__construct();
		if($this->session->userdata('masuk') !=TRUE){
            $url=base_url();
            redirect($url);
        };
		$this->load->model('M_stok');
        $this->load->model('Mlogin');
	}

	function index(){
	if($this->session->userdata('akses')=='1'){
        
	}elseif($this->session->userdata('akses')=='2') {
        $data['userid'] = $this->Mlogin->tampil_user();
		$data['data']=$this->M_stok->tampil_barang();
		$this->load->view('admin/v_stok',$data);
    }
	}

	function simpan_reqstok() {
	if($this->session->userdata('akses')=='1'){
        
	}elseif($this->session->userdata('akses')=='2') {
		$requestData = $this->input->post('requestData');
		$noreqstok = $this->M_stok->get_noreqstok();
		$success = $this->M_stok->simpan_reqstok($noreqstok, $requestData);
			if ($success) {
				echo json_encode(['message' => 'Data berhasil disimpan']);
			} else {
				echo json_encode(['message' => 'Gagal menyimpan data.']);
			}
	}
	}

	function tampil_reqstok() {
	if($this->session->userdata('akses')=='1'){
        $data['userid'] = $this->Mlogin->tampil_user();
		$data['data']=$this->M_stok->tampil_reqstok();
		$data['brg']=$this->M_stok->tampil_barang();
		$this->load->view('admin/v_req_stok_admin',$data);
	}elseif($this->session->userdata('akses')=='2') {
        $data['userid'] = $this->Mlogin->tampil_user();
		$data['data']=$this->M_stok->tampil_reqstokkasir();
		$data['brg']=$this->M_stok->tampil_barang();
		$this->load->view('admin/v_request_stok',$data);
    }
	}	
	
	function edit_detailstok() {
	if($this->session->userdata('akses')=='1'){	
		
	}elseif($this->session->userdata('akses')=='2') {
		$kode = $this->input->post('kode');
		$qty = str_replace(',', '.', $this->input->post('qty'));
		$success = $this->M_stok->edit_detail_stok($kode, $qty);
		if ($success) {
			echo json_encode(['message' => 'Data berhasil disimpan']);      
			//echo '<script type="text/javascript">updateSuccess();</script>';
		} else {
			echo json_encode(['message' => 'Gagal menyimpan data.']);
		}
	}
	}

	function edit_detailstok_kirim() {
	if($this->session->userdata('akses')=='1'){	
		$kode = $this->input->post('kode');
		$stok_no = $this->input->post('stok_no');
		$kd_brg = $this->input->post('kd_brg');
		$qty_baru =(float) str_replace(',', '.', $this->input->post('kir_qty'));
		$success = $this->M_stok->edit_detail_stok_kirim($kode,$stok_no,$kd_brg,$qty_baru);
		if ($success) {
			echo json_encode(['message' => 'Data berhasil disimpan']);      
			//echo '<script type="text/javascript">updateSuccess();</script>';
		} else {
			echo json_encode(['message' => 'Gagal menyimpan data.']);
		}
	}elseif($this->session->userdata('akses')=='2') {
		
	}
	}

	function hapus_detailstok() {
	if($this->session->userdata('akses')=='1'){	
		
	}elseif($this->session->userdata('akses')=='2') {
		$kode = $this->input->post('kode');
		$success = $this->M_stok->hapus_detail_stok($kode);
		if ($success) {
			echo json_encode(['message' => 'Data berhasil dihapus']);      
		} else {
			echo json_encode(['message' => 'Gagal menghapus data.']);
		}
	}
	}

	function add_detailstok() {
	if($this->session->userdata('akses')=='1'){	
		
	}elseif($this->session->userdata('akses')=='2') {
		$noreq = $this->input->post('noreq');
		$idbrg = $this->input->post('barang');
		$nm = $this->input->post('nm');
		$sat = $this->input->post('sat');
		$kat = $this->input->post('kat');
		$qty = str_replace(',', '.', $this->input->post('qty'));
		$success = $this->M_stok->add_detail_stok($noreq,$idbrg,$nm,$sat,$kat,$qty);
		if ($success) {
			echo json_encode(['message' => 'Data berhasil disimpan']);      
		} else {
			echo json_encode(['message' => 'Gagal menyimpan data.']);
		}
	}
	}

    function simpan_kirim_stok() {
        $requestData = $this->input->post('requestData');
        $nofakValue = '';
		if (!empty($requestData) && is_array($requestData)) {
			// Ambil 'nofak' dari data pertama dalam 'requestData'
			if (isset($requestData[0]['nofak'])) {
				$nofakValue = $requestData[0]['nofak'];
			}
		}
		$success = $this->M_stok->simpan_kirimstok($requestData,$nofakValue);
        if ($success) {
            echo json_encode(['message' => 'Data berhasil disimpan']);
        } else {
            echo json_encode(['message' => 'Gagal menyimpan data.']);
        }
    }

	function simpan_konfirm_stok() {
    $requestData = $this->input->post('requestData');
    $nofakValue = '';
		if (!empty($requestData) && is_array($requestData)) {
			// Ambil 'nofak' dari data pertama dalam 'requestData'
			if (isset($requestData[0]['nofak'])) {
				$nofakValue = $requestData[0]['nofak'];
			}
		}
		$success = $this->M_stok->simpan_konfirmstok($requestData, $nofakValue);
		if ($success) {
			echo json_encode(['message' => 'Data berhasil disimpan']);
		} else {
			echo json_encode(['message' => 'Gagal menyimpan data.']);
		}
	}

	
	function hapus_reqstok(){
	if($this->session->userdata('akses')=='1'){
		// $kode=$this->input->post('kode');
		// $this->M_beban->hapus_stok($kode);
		// redirect('admin/stok');
	}elseif($this->session->userdata('akses')=='2') {
        $kode = $this->input->post('kode');
		$this->M_stok->hapus_request_stok($kode);
		redirect('admin/stok/tampil_reqstok');
    }
	}



	function cetak_request($id,$ket){
		$x['ket'] = $ket;
		$x['userid'] = $this->Mlogin->tampil_user();
		$x['data_reqstok'] = $this->M_stok->get_reqstok($id);
		$x['reqstok'] = $this->M_stok->get_req_stok($id);
        $this->load->view('admin/cetak/v_cetak_request',$x);
	}

}