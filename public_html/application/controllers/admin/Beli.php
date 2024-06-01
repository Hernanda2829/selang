<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Beli extends CI_Controller{
	function __construct(){
		parent::__construct();
		if($this->session->userdata('masuk') !=TRUE){
            $url=base_url();
            redirect($url);
        };
		$this->load->model('Mlogin');
		$this->load->model('M_beli');
		$this->load->model('M_barang');
		$this->load->model('M_kategori');
		
	}
	function index(){
		if($this->session->userdata('akses')=='1'){
			$firstDay = $this->getFirstDayOfMonth();
			$lastDay = $this->getLastDayOfMonth();
			$data['firstDayOfMonth'] = $firstDay;
			$data['lastDayOfMonth'] = $lastDay;
			$data['userid'] = $this->Mlogin->tampil_user();
			$data['data']=$this->M_beli->tampil_beli();
			$data['pembelian']=$this->M_beli->get_pembelian($firstDay,$lastDay);
			$data['kat']=$this->M_kategori->tampil_kategori();
			$data['diskon']=$this->M_barang->tampil_diskon();
			$data['brg']=$this->M_barang->tampil_barang();
			$data['units'] = $this->M_barang->tampil_units();
			$this->load->view('admin/v_beli',$data);
		}else{
			echo "Halaman tidak ditemukan";
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

	function update_stok() {
		$kode=$this->input->post('kode');
		$nofak=$this->input->post('nofak');
		$kd_brg=$this->input->post('idbrg');
		$nm_brg=$this->input->post('nmbrg');
		$sat=$this->input->post('satbrg');
		$kat=$this->input->post('katbrg');
		$qty=(float) $this->input->post('jml');
		$harpok=str_replace([',', '.'], "", $this->input->post('txtharpok'));
		$harjul=str_replace([',', '.'], "", $this->input->post('txtharjul'));
		//mengambil stok akhir cabang
		// $br=$this->M_beli->get_brg($kd_brg);
        // $dtbrg=$br->row_array();
		// $stok=$dtbrg['stok_cabang'];
		// $awal_stok=$stok;
		// $akhir_stok=$stok + $qty;
		$br = $this->M_beli->get_brg($kd_brg);
		if (!empty($br)) {
			$dtbrg = $br[0]; // Mengambil hasil pertama dari array, karena result_array() mengembalikan array
			$stok = $dtbrg['stok_cabang'];
			$awal_stok = $stok;
			$akhir_stok = $stok + $qty;
		} else {
			$stok = 0;
			$awal_stok =0;
			$akhir_stok =0;
		}
		$cekbox = $this->input->post('cekbox');
		if (!empty($cekbox)) {	// Periksa apakah checkbox dicentang atau tidak untuk merubah harpok dan harjul di data barang
			$this->M_beli->updatestok($kode,$nofak,$kd_brg,$nm_brg,$sat,$kat,$qty,$awal_stok,$akhir_stok,$harpok,$harjul);
			$this->M_beli->update_barang($kd_brg,$harpok,$harjul);	
		}else {
			$this->M_beli->updatestok($kode,$nofak,$kd_brg,$nm_brg,$sat,$kat,$qty,$awal_stok,$akhir_stok,$harpok,$harjul);
		} 
		redirect('admin/beli');
	}

	function update_harpok() {
	$kd_brg=$this->input->post('idbrgU');
	$harpok=str_replace([',', '.'], "", $this->input->post('harpokU'));
	$harjul=str_replace([',', '.'], "", $this->input->post('harjulU'));
	$this->M_beli->update_barang($kd_brg,$harpok,$harjul);
	redirect('admin/beli');
	}

	function tambah_barang() {
	$nofak=$this->input->post('nofakB');
	$kode=$this->input->post('kodeB');
	$kd_brg=$this->input->post('idbrgB');
	$nm_brg=$this->input->post('nmbrgB');
	$sat=$this->input->post('satbrgB');
	$harpok=str_replace([',', '.'], "", $this->input->post('harpok'));
	$harjul=str_replace([',', '.'], "", $this->input->post('harjul'));
	$qty=(float) $this->input->post('jmlB');
	$kat=$this->input->post('kategori');
	$diskon=$this->input->post('diskon');
	$regid=$this->session->userdata('regid');
	$this->M_beli->add_barang($nofak,$kode,$kd_brg,$nm_brg,$sat,$harpok,$harjul,$qty,$kat,$diskon);
	redirect('admin/beli');
	}

	function edit_beli() {
	$kode=$this->input->post('txtidE');
	$kd_brg=$this->input->post('kdbrgE');
	$nm_brg=$this->input->post('nmbrgE');
	$sat=$this->input->post('satbrgE');
	$qty = (float) str_replace(',','.', $this->input->post('jumbel'));
	$harbel=str_replace([',', '.'], "", $this->input->post('harbel'));
	$this->M_beli->edit_pembelian($kode,$kd_brg,$nm_brg,$sat,$qty,$harbel);
	redirect('admin/beli');
	}

	function hapus_beli() {
	$kode=$this->input->post('txtidbeli');
	$this->M_beli->hapus_pembelian($kode);
	redirect('admin/beli');
	}

	function hapus_data_beli() {
	$kode=$this->input->post('txtkode');
	$this->M_beli->hapus_data_beli($kode);
	redirect('admin/beli');
	}

	function get_data_beli() {
		$firstDay = $this->input->post('tgl1');
		$lastDay = $this->input->post('tgl2');
        $data = $this->M_beli->get_pembelian($firstDay,$lastDay);
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

	function get_detail_beli(){
		$noid = $this->input->post('noid');
		$data = $this->M_beli->getdetailbeli($noid);
		if (!empty($data)) {
			echo json_encode($data);
		} else {
			echo json_encode(array('error' => 'Data not found'));
		}
	}

	function get_beli(){
		$idbeli = $this->input->post('idbeli');
		$data = $this->M_beli->get_beli($idbeli);
		if (!empty($data)) {
			echo json_encode($data);
		} else {
			echo json_encode(array('error' => 'Data not found'));
		}
	}

	function get_brg(){
		$idbrg = $this->input->post('idbrg');
		$data = $this->M_beli->get_brg($idbrg);
		if (!empty($data)) {
			echo json_encode($data);
		} else {
			echo json_encode(array('error' => 'Data not found'));
		}
	}





}