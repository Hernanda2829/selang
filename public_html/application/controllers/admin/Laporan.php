<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Laporan extends CI_Controller{
	function __construct(){
		parent::__construct();
		if($this->session->userdata('masuk') !=TRUE){
            $url=base_url();
            redirect($url);
        };
		$this->load->model('M_kategori');
		$this->load->model('M_barang');
		$this->load->model('M_suplier');
		$this->load->model('M_pembelian');
		$this->load->model('M_penjualan');
		$this->load->model('M_laporan');
		$this->load->model('Mlogin');
	}

	function index(){
	if($this->session->userdata('akses')=='1'){
		$data['userid'] = $this->Mlogin->tampil_user();
		$data['regions']=$this->Mlogin->tampil_regions();
		$data['data']=$this->M_barang->tampil_barang();
		$data['kat']=$this->M_kategori->tampil_kategori();
		$data['jual_bln']=$this->M_laporan->get_bulan_jual();
		$data['jual_thn']=$this->M_laporan->get_tahun_jual();
		$this->load->view('admin/v_laporan',$data);
	}elseif($this->session->userdata('akses')=='2') {
		$data['userid'] = $this->Mlogin->tampil_user();
		$data['regions']=$this->Mlogin->tampil_regions();
		$data['data']=$this->M_barang->tampil_barang();
		$data['kat']=$this->M_kategori->tampil_kategori();
		$data['jual_bln']=$this->M_laporan->get_bulan_jual();
		$data['jual_thn']=$this->M_laporan->get_tahun_jual();
		$this->load->view('admin/v_laporan',$data);
	}else{
        echo "Halaman tidak ditemukan";
    }
	}

	function lap_data_barang(){
		if($this->session->userdata('akses')=='1'){
			$x['userid'] = $this->Mlogin->tampil_user();
			$reg_id=$this->input->post('regions');
			if ($reg_id==0) {
				$x['data']=$this->M_laporan->get_data_barang();
				$this->load->view('admin/laporan/v_lap_barang_gab',$x);
			}else{
				$x['id_reg']=$this->Mlogin->get_regions($reg_id);
				$x['data']=$this->M_laporan->get_data_barang_cab($reg_id);
				$this->load->view('admin/laporan/v_lap_barang',$x);
			}
			// 	echo $this->session->set_flashdata('msg','<label class="label label-danger">Silahkan Pilih Data Cabang</label>');
			// 	redirect('admin/laporan');
		}elseif($this->session->userdata('akses')=='2') {
			$reg_id=$this->session->userdata('regid');
			$x['userid'] = $this->Mlogin->tampil_user();
			$x['data']=$this->M_laporan->get_data_barang_cab($reg_id);
			$this->load->view('admin/laporan/v_lap_barangkasir',$x);
		}
	}

	function lap_stok_barang(){
		if($this->session->userdata('akses')=='1'){
			$x['userid'] = $this->Mlogin->tampil_user();
			$reg_id=$this->input->post('regions');
			$coid = $this->session->userdata('coid');
			if ($reg_id==0) {
				$x['data']=$this->M_laporan->get_data_barang();
				$x['co_id']=$coid;
				$this->load->view('admin/laporan/v_lap_stok_barang_gab',$x);
			}else{
				$x['co_id']=$coid;
				$x['id_reg']=$this->Mlogin->get_regions($reg_id);
				$x['data']=$this->M_laporan->get_data_barang_cab($reg_id);
				$this->load->view('admin/laporan/v_lap_stok_barang',$x);
			}
		}elseif($this->session->userdata('akses')=='2') {
			$coid = $this->session->userdata('coid');
			$x['co_id']=$coid;
			$reg_id=$this->session->userdata('regid');
			$x['userid'] = $this->Mlogin->tampil_user();
			//$x['data']=$this->M_laporan->get_stok_barang();
			$x['data']=$this->M_laporan->get_data_barang_cab($reg_id);
			$this->load->view('admin/laporan/v_lap_stok_barangkasir',$x);
		}
	}

	function lap_data_penjualan(){
		if($this->session->userdata('akses')=='1'){
			$x['userid'] = $this->Mlogin->tampil_user();
			$regid=$this->input->post('regions');
			if ($regid==0) {
				$x['data']=$this->M_laporan->get_data_penjualan();
				$x['jml']=$this->M_laporan->get_total_penjualan();
				$this->load->view('admin/laporan/v_lap_penjualan_gab',$x);
			}else{
				$x['id_reg']=$this->Mlogin->get_regions($regid);
				$x['data']=$this->M_laporan->get_data_penjualankasir($regid);
				$x['jml']=$this->M_laporan->get_total_penjualankasir($regid);
				$this->load->view('admin/laporan/v_lap_penjualan',$x);
			}
		}elseif($this->session->userdata('akses')=='2') {
			$regid=$this->session->userdata('regid');
			$x['userid'] = $this->Mlogin->tampil_user();
			$x['data']=$this->M_laporan->get_data_penjualankasir($regid);
			$x['jml']=$this->M_laporan->get_total_penjualankasir($regid);
			$this->load->view('admin/laporan/v_lap_penjualankasir',$x);
		}
	}

	function lap_penjualan_pertanggal(){
		if($this->session->userdata('akses')=='1'){
			$x['userid'] = $this->Mlogin->tampil_user();
			$x['lap']="laptgl";
			$tanggal=$this->input->post('tgl');
			$regid=$this->input->post('regions');
			if ($regid==0) {
				$x['data']=$this->M_laporan->get_data_jual_pertanggal($tanggal);
				$x['jml']=$this->M_laporan->get_data_total_jual_pertanggal($tanggal);
				$this->load->view('admin/laporan/v_lap_jual_gab',$x);
			}else{
				$x['id_reg']=$this->Mlogin->get_regions($regid);
				$x['data']=$this->M_laporan->get_data_jual_pertanggalkasir($tanggal,$regid);
				$x['jml']=$this->M_laporan->get_data_total_jual_pertanggalkasir($tanggal,$regid);
				$this->load->view('admin/laporan/v_lap_jual',$x);
			}
		}elseif($this->session->userdata('akses')=='2') {
			$x['userid'] = $this->Mlogin->tampil_user();
			$tanggal=$this->input->post('tgl');
			$regid=$this->session->userdata('regid');
			$x['data']=$this->M_laporan->get_data_jual_pertanggalkasir($tanggal,$regid);
			$x['jml']=$this->M_laporan->get_data_total_jual_pertanggalkasir($tanggal,$regid);
			$x['lap']="laptgl";
			$this->load->view('admin/laporan/v_lap_jual_kasir',$x);
		}
	}

	function lap_penjualan_perbulan(){
		if($this->session->userdata('akses')=='1'){
			$x['userid'] = $this->Mlogin->tampil_user();
			$x['lap']="lapbln";
			$bulan=$this->input->post('bln');
			$regid=$this->input->post('regions');
			if ($regid==0) {
				$x['data']=$this->M_laporan->get_jual_perbulan($bulan);
				$x['jml']=$this->M_laporan->get_total_jual_perbulan($bulan);
				$this->load->view('admin/laporan/v_lap_jual_gab',$x);
			}else{
				$x['id_reg']=$this->Mlogin->get_regions($regid);
				$x['data']=$this->M_laporan->get_jual_perbulankasir($bulan,$regid);
				$x['jml']=$this->M_laporan->get_total_jual_perbulankasir($bulan,$regid);
				$this->load->view('admin/laporan/v_lap_jual',$x);
			}	
		}elseif($this->session->userdata('akses')=='2') {
			$x['userid'] = $this->Mlogin->tampil_user();
			$bulan=$this->input->post('bln');
			$regid=$this->session->userdata('regid');
			$x['data']=$this->M_laporan->get_jual_perbulankasir($bulan,$regid);
			$x['jml']=$this->M_laporan->get_total_jual_perbulankasir($bulan,$regid);
			$x['lap']="lapbln";
			$this->load->view('admin/laporan/v_lap_jual_kasir',$x);
		}
	}

	function lap_penjualan_pertahun(){
		if($this->session->userdata('akses')=='1'){
			$x['userid'] = $this->Mlogin->tampil_user();
			$x['lap']="lapthn";
			$tahun=$this->input->post('thn');
			$regid=$this->input->post('regions');
			if ($regid==0) {
				$x['data']=$this->M_laporan->get_jual_pertahun($tahun);
				$x['jml']=$this->M_laporan->get_total_jual_pertahun($tahun);
				$this->load->view('admin/laporan/v_lap_jual_gab',$x);
			}else{
				$x['id_reg']=$this->Mlogin->get_regions($regid);
				$x['data']=$this->M_laporan->get_jual_pertahunkasir($tahun,$regid);
				$x['jml']=$this->M_laporan->get_total_jual_pertahunkasir($tahun,$regid);
				$this->load->view('admin/laporan/v_lap_jual',$x);
			}
		}elseif($this->session->userdata('akses')=='2') {
			$x['userid'] = $this->Mlogin->tampil_user();
			$tahun=$this->input->post('thn');
			$regid=$this->session->userdata('regid');
			$x['data']=$this->M_laporan->get_jual_pertahunkasir($tahun,$regid);
			$x['jml']=$this->M_laporan->get_total_jual_pertahunkasir($tahun,$regid);
			$x['lap']="lapthn";
			$this->load->view('admin/laporan/v_lap_jual_kasir',$x);
		}
	}

	function lap_laba_rugi(){
		if($this->session->userdata('akses')=='1'){
			$x['userid'] = $this->Mlogin->tampil_user();
			$bulan=$this->input->post('bln');
			$regid=$this->input->post('regions');
			if ($regid==0) {
				$x['data']=$this->M_laporan->get_lap_laba_rugi($bulan);
				$x['jml']=$this->M_laporan->get_total_lap_laba_rugi($bulan);
				$this->load->view('admin/laporan/v_lap_laba_rugi_gab',$x);
			}else{
				$x['id_reg']=$this->Mlogin->get_regions($regid);
				$x['data']=$this->M_laporan->get_lap_laba_rugikasir($bulan,$regid);
				$x['jml']=$this->M_laporan->get_total_lap_laba_rugikasir($bulan,$regid);
				$this->load->view('admin/laporan/v_lap_laba_rugi',$x);
			}
		}elseif($this->session->userdata('akses')=='2') {
			//untuk sementara tidak digunakan
			// $x['userid'] = $this->Mlogin->tampil_user();
			// $bulan=$this->input->post('bln');
			// $x['data']=$this->M_laporan->get_lap_laba_rugikasir($bulan);
			// $x['jml']=$this->M_laporan->get_total_lap_laba_rugikasir($bulan);
			// $this->load->view('admin/laporan/v_lap_laba_rugikasir',$x);
		}
	}
}