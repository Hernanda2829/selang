<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Transfer_stok extends CI_Controller{
	function __construct(){
		parent::__construct();
		if($this->session->userdata('masuk') !=TRUE){
            $url=base_url();
            redirect($url);
        };
		$this->load->model('M_transfer_stok');
        $this->load->model('Mlogin');
	}

	function index(){
		if($this->session->userdata('akses')=='1' || $this->session->userdata('akses')=='2') {
			$data['userid'] = $this->Mlogin->tampil_user();
			$data['data']=$this->M_transfer_stok->tampil_barang();
			$this->load->view('admin/v_transfer_stok',$data);
		}
	}

	function hapus_data_transtok(){
		if($this->session->userdata('akses')=='1' || $this->session->userdata('akses')=='2') {
			$kode = $this->input->post('txtkode');
			$this->M_transfer_stok->hapus_data_transtok($kode);
			redirect('admin/transfer_stok/tampil_transtok');
		}
	}


	function simpan_transtok() {
		if($this->session->userdata('akses')=='1' || $this->session->userdata('akses')=='2') {
			$requestData = $this->input->post('requestData');
			$regidterima = $this->input->post('regid');
			$success = $this->M_transfer_stok->simpan_transtok($requestData,$regidterima);
				if ($success) {
					echo json_encode(['message' => 'Data berhasil disimpan']);
				} else {
					echo json_encode(['message' => 'Gagal menyimpan data.']);
				}
		}
	}

	function tampil_transtok() {
		if($this->session->userdata('akses')=='1' || $this->session->userdata('akses')=='2') {
			$data['userid'] = $this->Mlogin->tampil_user();
			$data['data']=$this->M_transfer_stok->tampil_transtok();
			$data['brg']=$this->M_transfer_stok->tampil_barang();
			$this->load->view('admin/v_transfer_data_stok',$data);
		}
	}		
	
	function tampil_konfirm() {
		if($this->session->userdata('akses')=='1' || $this->session->userdata('akses')=='2') {
			$data['userid'] = $this->Mlogin->tampil_user();
			$data['data']=$this->M_transfer_stok->tampil_konfirm();
			$this->load->view('admin/v_transfer_konfirm',$data);
		}
	}

	function get_transtok(){
		$stokno = $this->input->post('stokno');
		$data = $this->M_transfer_stok->get_transtok($stokno);
        if (!empty($data)) {
            echo json_encode($data);
        } else {
            echo json_encode(array('error' => 'Data not found'));
        }
	}

	function update_transtok(){
		$stokno = $this->input->post('stokno');
		$brgid = $this->input->post('brgid');
		$stokid = $this->input->post('stokid');
		$qty = str_replace(',', '.', $this->input->post('qty'));
		$data = $this->M_transfer_stok->update_transtok($stokno,$brgid,$stokid,$qty);
        if (!empty($data)) {
            echo json_encode($data);
        } else {
            echo json_encode(array('error' => 'Data not found'));
        }
	}

	function hapus_transtok(){
		$stokno = $this->input->post('stokno');
		$stokid = $this->input->post('stokid');
		$brgid = $this->input->post('brgid');
		$data = $this->M_transfer_stok->hapus_transtok($stokno,$stokid,$brgid);
        if (!empty($data)) {
            echo json_encode($data);
        } else {
            echo json_encode(array('error' => 'Data not found'));
        }
	}
	
	function get_barang(){
		$idbrg = $this->input->post('idbrg');
        $data = $this->M_transfer_stok->get_barang($idbrg);
        if (!empty($data)) {
            echo json_encode($data);
        } else {
            echo json_encode(array('error' => 'Data not found'));
        }
	}

	function simpan_addtranstok() {
		//cara simpan ajax ,
		$nostok = $this->input->post('stokno');
		$tgl = $this->input->post('tgl');
		$regcab = $this->input->post('regcab');
		$kd = $this->input->post('kd');
		$nm = $this->input->post('nm');
		$sat = $this->input->post('sat');
		$kat = $this->input->post('kat');
		$qty = str_replace(',', '.', $this->input->post('qty'));
		$data = $this->M_transfer_stok->simpan_addtranstok($nostok,$tgl,$regcab,$kd,$nm,$sat,$kat,$qty);
		if (!empty($data)) {
            echo json_encode($data);
        } else {
            echo json_encode(array('error' => 'Data not found'));
        }

		//cara simpan submit ,
		// $nostok = $this->input->post('txtstoknoA');
		// $tgl = $this->input->post('txttglA');
		// $regcab = $this->input->post('txtregidA');
		// $kd = $this->input->post('kdA');
		// $nm = $this->input->post('nmA');
		// $sat = $this->input->post('satA');
		// $kat = $this->input->post('katA');
		// $qty = str_replace(',', '.', $this->input->post('txtqtyA'));
		// $success = $this->M_transfer_stok->simpan_addtranstok($nostok,$tgl,$regcab,$kd,$nm,$sat,$kat,$qty);
        // if ($success) {
		// 	echo json_encode(['message' => 'Data berhasil disimpan']);      
		// } else {
		// 	echo json_encode(['message' => 'Gagal menyimpan data.']);
		// }
	
	}

	function get_data_transtok(){
		$stokno = $this->input->post('stokno');
		$idbrg = $this->input->post('idbrg');
        $data = $this->M_transfer_stok->get_data_transtok($stokno,$idbrg);
        if (!empty($data)) {
            echo json_encode($data);
        } else {
            echo json_encode(array('error' => 'Data not found'));
        }
	}

	//tidak digunakan karena begitu kirim stok, stok langsung berkurang, insert stok_out pada tbl_stok
	// function get_stok_pending(){
	// 	$idbrg = $this->input->post('idbrg');
	// 	$data = $this->M_transfer_stok->get_stok_pending($idbrg);
    //     if (!empty($data)) {
    //         echo json_encode($data);
    //     } else {
    //         echo json_encode(array('error' => 'Data not found'));
    //     }
	// }

	function simpan_konfirm_stok() {
    $requestData = $this->input->post('requestData');
	$notrans = $this->input->post('notrans');
		$success = $this->M_transfer_stok->simpan_konfirm_stok($requestData, $notrans);
		if ($success) {
			echo json_encode(['message' => 'Data berhasil disimpan']);
		} else {
			echo json_encode(['message' => 'Gagal menyimpan data.']);
		}
	}


	function cetak_kirim($stokno){
		$x['userid'] = $this->Mlogin->tampil_user();
		$x['transtok'] = $this->M_transfer_stok->get_tampil_transtok($stokno);
		$x['detail_transtok'] = $this->M_transfer_stok->get_transtok($stokno);
        $this->load->view('admin/cetak/v_cetak_kirim_stok',$x);
	}

	function cetak_kirim_komplit($stokno){
		$x['userid'] = $this->Mlogin->tampil_user();
		$x['transtok'] = $this->M_transfer_stok->get_tampil_transtok($stokno);
		$x['detail_transtok'] = $this->M_transfer_stok->get_transtok($stokno);
        $this->load->view('admin/cetak/v_cetak_kirim_komplit_stok',$x);
	}

	function cetak_terima($stokno){
		$x['userid'] = $this->Mlogin->tampil_user();
		$x['transtok'] = $this->M_transfer_stok->get_terima_transtok($stokno);
		$x['detail_transtok'] = $this->M_transfer_stok->get_transtok($stokno);
        $this->load->view('admin/cetak/v_cetak_terima_stok',$x);
	}

	function cetak_terima_komplit($stokno){
		$x['userid'] = $this->Mlogin->tampil_user();
		$x['transtok'] = $this->M_transfer_stok->get_terima_transtok($stokno);
		$x['detail_transtok'] = $this->M_transfer_stok->get_transtok($stokno);
        $this->load->view('admin/cetak/v_cetak_terima_komplit_stok',$x);
	}

}