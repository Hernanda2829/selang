<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ExportLapexcel extends CI_Controller {

    function __construct() {
        parent::__construct();
        if($this->session->userdata('masuk') !=TRUE){
            $url=base_url();
            redirect($url);
        };
        $this->load->model('Mlogin');
        $this->load->model('M_laporan');
    }

    function print_excel_data_barang() {
        if($this->session->userdata('akses')=='1') {
			$reg_id=$this->input->post('regions');
			if ($reg_id==0) {
				$x['data']=$this->M_laporan->get_data_barang();
                header("Content-type: application/octet-stream");
                header("Content-Disposition: attachment; filename=Lap_Data_Barang_Global.xls");
                header("Pragma: no-cache");
                header("Expires: 0");
                $this->load->view('admin/laporan/excel/v_excel_lap_barang_gab',$x);
			}else{
				$x['id_reg']=$this->Mlogin->get_regions($reg_id);
                $rg=$x['id_reg']->row_array();
                $rgcode = $rg['reg_code'];
                $rgname = $rg['reg_name'];
				$x['data']=$this->M_laporan->get_data_barang_cab($reg_id);
				header("Content-type: application/octet-stream");
                header("Content-Disposition: attachment; filename=Lap_Data_Barang_".$rgcode.'_'.$rgname.".xls");
                header("Pragma: no-cache");
                header("Expires: 0");
                $this->load->view('admin/laporan/excel/v_excel_lap_barang',$x);
			}
        }elseif($this->session->userdata('akses')=='2') {
            $reg_id=$this->session->userdata('regid');
            $x['userid'] = $this->Mlogin->tampil_user();
            if (!empty($x['userid'])) {
                $userid = $x['userid']->row_array();
                $regcode = $userid['reg_code'];
                $regname = $userid['reg_name'];
            } else {
                $regcode = "Cabang";
                $regname = "";
            }
            $x['data']=$this->M_laporan->get_data_barang_cab($reg_id);
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=Lap_Data_Barang_".$regcode.'_'.$regname.".xls");
            header("Pragma: no-cache");
            header("Expires: 0");
            $this->load->view('admin/laporan/excel/v_excel_lap_barangkasir',$x);
       }
    }

    function print_excel_stok_barang() {
        if($this->session->userdata('akses')=='1') {
			$coid = $this->session->userdata('coid');
            $reg_id=$this->input->post('regions');
			if ($reg_id==0) {
				$x['co_id']=$coid;
                $x['data']=$this->M_laporan->get_data_barang();
                header("Content-type: application/octet-stream");
                header("Content-Disposition: attachment; filename=Lap_Stok_Barang_Global.xls");
                header("Pragma: no-cache");
                header("Expires: 0");
                $this->load->view('admin/laporan/excel/v_excel_lap_stok_gab',$x);
			}else{
                $x['co_id']=$coid;
				$x['id_reg']=$this->Mlogin->get_regions($reg_id);
                $rg=$x['id_reg']->row_array();
                $rgcode = $rg['reg_code'];
                $rgname = $rg['reg_name'];
				$x['data']=$this->M_laporan->get_data_barang_cab($reg_id);
				header("Content-type: application/octet-stream");
                header("Content-Disposition: attachment; filename=Lap_Stok_Barang_".$rgcode.'_'.$rgname.".xls");
                header("Pragma: no-cache");
                header("Expires: 0");
                $this->load->view('admin/laporan/excel/v_excel_lap_stok',$x);
			}
        }elseif($this->session->userdata('akses')=='2') {
            $coid = $this->session->userdata('coid');
            $reg_id=$this->session->userdata('regid');
            $x['userid'] = $this->Mlogin->tampil_user();
            if (!empty($x['userid'])) {
                $userid = $x['userid']->row_array();
                $regcode = $userid['reg_code'];
                $regname = $userid['reg_name'];
            } else {
                $regcode = "Cabang";
                $regname = "";
            }
            $x['co_id']=$coid;
            $x['data']=$this->M_laporan->get_data_barang_cab($reg_id);
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=Lap_Data_Barang_".$regcode.'_'.$regname.".xls");
            header("Pragma: no-cache");
            header("Expires: 0");
            $this->load->view('admin/laporan/excel/v_excel_lap_stokkasir',$x);
       }
    }


    function print_excel_penjualan() {
        if($this->session->userdata('akses')=='1') {
			$regid=$this->input->post('regions');
			if ($regid==0) {
				$x['data']=$this->M_laporan->get_data_penjualan();
				$x['jml']=$this->M_laporan->get_total_penjualan();
				header("Content-type: application/octet-stream");
                header("Content-Disposition: attachment; filename=Lap_Penjualan_Global.xls");
                header("Pragma: no-cache");
                header("Expires: 0");
                $this->load->view('admin/laporan/excel/v_excel_lap_penjualan_gab',$x);
			}else{
                $x['id_reg']=$this->Mlogin->get_regions($regid);
                $rg=$x['id_reg']->row_array();
                $rgcode = $rg['reg_code'];
                $rgname = $rg['reg_name'];
				$x['data']=$this->M_laporan->get_data_penjualankasir($regid);
				$x['jml']=$this->M_laporan->get_total_penjualankasir($regid);
				header("Content-type: application/octet-stream");
                header("Content-Disposition: attachment; filename=Lap_Penjualan_".$rgcode.'_'.$rgname.".xls");
                header("Pragma: no-cache");
                header("Expires: 0");
                $this->load->view('admin/laporan/excel/v_excel_lap_penjualan',$x);
			}
        }elseif($this->session->userdata('akses')=='2') {
            $regid=$this->session->userdata('regid');
            $x['id_reg']=$this->Mlogin->get_regions($regid);
                $rg=$x['id_reg']->row_array();
                $rgcode = $rg['reg_code'];
                $rgname = $rg['reg_name'];
				$x['data']=$this->M_laporan->get_data_penjualankasir($regid);
				$x['jml']=$this->M_laporan->get_total_penjualankasir($regid);
				header("Content-type: application/octet-stream");
                header("Content-Disposition: attachment; filename=Lap_Penjualan_".$rgcode.'_'.$rgname.".xls");
                header("Pragma: no-cache");
                header("Expires: 0");
                $this->load->view('admin/laporan/excel/v_excel_lap_penjualan',$x);
       }
    }

    function print_excel_jual_tanggal() {
        if($this->session->userdata('akses')=='1') {
			$x['lap']="laptgl";
            $tanggal=$this->input->post('tgl');
            $regid=$this->input->post('regions');
			if ($regid==0) {
				$x['data']=$this->M_laporan->get_data_jual_pertanggal($tanggal);
				$x['jml']=$this->M_laporan->get_data_total_jual_pertanggal($tanggal);
				header("Content-type: application/octet-stream");
                header("Content-Disposition: attachment; filename=Lap_Jual_Pertanggal_Global.xls");
                header("Pragma: no-cache");
                header("Expires: 0");
                $this->load->view('admin/laporan/excel/v_excel_lap_jual_gab',$x);
			}else{
                $x['id_reg']=$this->Mlogin->get_regions($regid);
                $rg=$x['id_reg']->row_array();
                $rgcode = $rg['reg_code'];
                $rgname = $rg['reg_name'];
				$x['data']=$this->M_laporan->get_data_jual_pertanggalkasir($tanggal,$regid);
				$x['jml']=$this->M_laporan->get_data_total_jual_pertanggalkasir($tanggal,$regid);
				header("Content-type: application/octet-stream");
                header("Content-Disposition: attachment; filename=Lap_Jual_Pertanggal_".$rgcode.'_'.$rgname.".xls");
                header("Pragma: no-cache");
                header("Expires: 0");
                $this->load->view('admin/laporan/excel/v_excel_lap_jual',$x);
			}
        }elseif($this->session->userdata('akses')=='2') {
            $tanggal=$this->input->post('tgl');
            $regid=$this->session->userdata('regid');
            $x['id_reg']=$this->Mlogin->get_regions($regid);
                $rg=$x['id_reg']->row_array();
                $rgcode = $rg['reg_code'];
                $rgname = $rg['reg_name'];
				$x['data']=$this->M_laporan->get_data_jual_pertanggalkasir($tanggal,$regid);
				$x['jml']=$this->M_laporan->get_data_total_jual_pertanggalkasir($tanggal,$regid);
                $x['lap']="laptgl";
				header("Content-type: application/octet-stream");
                header("Content-Disposition: attachment; filename=Lap_Jual_Pertanggal_".$rgcode.'_'.$rgname.".xls");
                header("Pragma: no-cache");
                header("Expires: 0");
                $this->load->view('admin/laporan/excel/v_excel_lap_jual',$x);
       }
    }

    function print_excel_jual_bulan() {
        if($this->session->userdata('akses')=='1') {
			$x['lap']="lapbln";
            $bulan=$this->input->post('bln');
            $regid=$this->input->post('regions');
			if ($regid==0) {
				$x['data']=$this->M_laporan->get_jual_perbulan($bulan);
				$x['jml']=$this->M_laporan->get_total_jual_perbulan($bulan);
				header("Content-type: application/octet-stream");
                header("Content-Disposition: attachment; filename=Lap_Jual_Perbulan_Global.xls");
                header("Pragma: no-cache");
                header("Expires: 0");
                $this->load->view('admin/laporan/excel/v_excel_lap_jual_gab',$x);
			}else{
                $x['id_reg']=$this->Mlogin->get_regions($regid);
                $rg=$x['id_reg']->row_array();
                $rgcode = $rg['reg_code'];
                $rgname = $rg['reg_name'];
				$x['data']=$this->M_laporan->get_jual_perbulankasir($bulan,$regid);
				$x['jml']=$this->M_laporan->get_total_jual_perbulankasir($bulan,$regid);
				header("Content-type: application/octet-stream");
                header("Content-Disposition: attachment; filename=Lap_Jual_Perbulan_".$rgcode.'_'.$rgname.".xls");
                header("Pragma: no-cache");
                header("Expires: 0");
                $this->load->view('admin/laporan/excel/v_excel_lap_jual',$x);
			}
        }elseif($this->session->userdata('akses')=='2') {
            $bulan=$this->input->post('bln');
            $regid=$this->session->userdata('regid');
            $x['id_reg']=$this->Mlogin->get_regions($regid);
                $rg=$x['id_reg']->row_array();
                $rgcode = $rg['reg_code'];
                $rgname = $rg['reg_name'];
				$x['data']=$this->M_laporan->get_jual_perbulankasir($bulan,$regid);
			    $x['jml']=$this->M_laporan->get_total_jual_perbulankasir($bulan,$regid);
                $x['lap']="lapbln";
				header("Content-type: application/octet-stream");
                header("Content-Disposition: attachment; filename=Lap_Jual_Perbulan_".$rgcode.'_'.$rgname.".xls");
                header("Pragma: no-cache");
                header("Expires: 0");
                $this->load->view('admin/laporan/excel/v_excel_lap_jual',$x);
       }
    }

    function print_excel_jual_tahun() {
        if($this->session->userdata('akses')=='1') {
			$x['lap']="lapthn";
            $tahun=$this->input->post('thn');
            $regid=$this->input->post('regions');
			if ($regid==0) {
				$x['data']=$this->M_laporan->get_jual_pertahun($tahun);
				$x['jml']=$this->M_laporan->get_total_jual_pertahun($tahun);
				header("Content-type: application/octet-stream");
                header("Content-Disposition: attachment; filename=Lap_Jual_Pertahun_Global.xls");
                header("Pragma: no-cache");
                header("Expires: 0");
                $this->load->view('admin/laporan/excel/v_excel_lap_jual_gab',$x);
			}else{
                $x['id_reg']=$this->Mlogin->get_regions($regid);
                $rg=$x['id_reg']->row_array();
                $rgcode = $rg['reg_code'];
                $rgname = $rg['reg_name'];
				$x['data']=$this->M_laporan->get_jual_pertahunkasir($tahun,$regid);
				$x['jml']=$this->M_laporan->get_total_jual_pertahunkasir($tahun,$regid);
				header("Content-type: application/octet-stream");
                header("Content-Disposition: attachment; filename=Lap_Jual_Pertahun_".$rgcode.'_'.$rgname.".xls");
                header("Pragma: no-cache");
                header("Expires: 0");
                $this->load->view('admin/laporan/excel/v_excel_lap_jual',$x);
			}
        }elseif($this->session->userdata('akses')=='2') {
            $tahun=$this->input->post('thn');
            $regid=$this->session->userdata('regid');
            $x['id_reg']=$this->Mlogin->get_regions($regid);
                $rg=$x['id_reg']->row_array();
                $rgcode = $rg['reg_code'];
                $rgname = $rg['reg_name'];
				$x['data']=$this->M_laporan->get_jual_pertahunkasir($tahun,$regid);
                $x['jml']=$this->M_laporan->get_total_jual_pertahunkasir($tahun,$regid);
                $x['lap']="lapthn";
				header("Content-type: application/octet-stream");
                header("Content-Disposition: attachment; filename=Lap_Jual_Pertahun_".$rgcode.'_'.$rgname.".xls");
                header("Pragma: no-cache");
                header("Expires: 0");
                $this->load->view('admin/laporan/excel/v_excel_lap_jual',$x);
       }
    }

    function print_excel_laba_rugi() {
        if($this->session->userdata('akses')=='1') {
            $bulan=$this->input->post('bln');
            $regid=$this->input->post('regions');
			if ($regid==0) {
				$x['id_reg']=$this->Mlogin->get_regions($regid);
                $x['data']=$this->M_laporan->get_lap_laba_rugi($bulan);
				$x['jml']=$this->M_laporan->get_total_lap_laba_rugi($bulan);
                $x['lap']="lapgab";
				header("Content-type: application/octet-stream");
                header("Content-Disposition: attachment; filename=Lap_LabaRugi_Global.xls");
                header("Pragma: no-cache");
                header("Expires: 0");
                $this->load->view('admin/laporan/excel/v_excel_lap_laba_rugi',$x);
			}else{
                $x['id_reg']=$this->Mlogin->get_regions($regid);
                $rg=$x['id_reg']->row_array();
                $rgcode = $rg['reg_code'];
                $rgname = $rg['reg_name'];
				$x['data']=$this->M_laporan->get_lap_laba_rugikasir($bulan,$regid);
				$x['jml']=$this->M_laporan->get_total_lap_laba_rugikasir($bulan,$regid);
                $x['lap']="lapcab";
				header("Content-type: application/octet-stream");
                header("Content-Disposition: attachment; filename=Lap_LabaRugi_".$rgcode.'_'.$rgname.".xls");
                header("Pragma: no-cache");
                header("Expires: 0");
                $this->load->view('admin/laporan/excel/v_excel_lap_laba_rugi',$x);
			}   
        }elseif($this->session->userdata('akses')=='2') {
            $x['userid'] = $this->Mlogin->tampil_user();
            if (!empty($x['userid'])) {
                $userid = $x['userid']->row_array();
                $regcode = $userid['reg_code'];
                $regname = $userid['reg_name'];
            } else {
                $regcode = "Cabang";
                $regname = "";
            }
			$bulan=$this->input->post('bln');
			$x['jml']=$this->M_laporan->get_total_lap_laba_rugikasir($bulan);
			$x['data']=$this->M_laporan->get_lap_laba_rugikasir($bulan);
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=Lap_Laba_Rugi_".$regcode.'_'.$regname.".xls");
            header("Pragma: no-cache");
            header("Expires: 0");
            $this->load->view('admin/laporan/excel/v_excel_lap_laba_rugi',$x);
       }
    }
}
?>
