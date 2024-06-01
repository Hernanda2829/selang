<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_garansi extends CI_Model{

	function tampil_garansi() {
		$coid=$this->session->userdata('coid');
		$hsl = $this->db->query("SELECT g_id,g_jual_tgl,g_nofak,g_cust_nama,g_brg_id,g_brg_nama,g_brg_sat,g_qty,g_harjul,g_diskon,g_total,g_image FROM tbl_garansi WHERE g_coid='$coid' ORDER BY DATE(g_jual_tgl) DESC");
		return $hsl;

	}
	
	function getdetailjual($nofak) {
        $queryA = $this->db->query("SELECT * FROM tbl_garansi WHERE g_nofak='$nofak' ORDER BY g_brg_id ASC");
		$queryB = $this->db->query("SELECT d_jual_nofak, d_jual_barang_id, d_jual_barang_nama, d_jual_barang_satuan, d_jual_qty, d_jual_barang_harjul, d_jual_diskon, d_jual_total,jual_tanggal,jual_cust_nama,jual_bayar,jual_bayar_status,jual_total FROM tbl_jual join tbl_detail_jual ON jual_nofak=d_jual_nofak  WHERE d_jual_nofak='$nofak' ORDER BY d_jual_nofak DESC");
		$resultA = $queryA->result_array(); 
		$resultB = $queryB->result_array(); //banyak row Ambil hasil query sebagai array asosiatif
		return array('queryA' => $resultA, 'queryB' => $resultB);
    }

	function hapus_garansi($id){
        $hsl=$this->db->query("DELETE FROM tbl_garansi where g_id='$id'");
		return $hsl;
	}


	function get_garansi_file($nofak,$idbrg) {
		$query = $this->db->query("SELECT g_id,g_nofak,g_brg_id,g_file,g_path FROM tbl_garansi_file WHERE g_nofak='$nofak' AND g_brg_id='$idbrg' ORDER BY g_id ASC");
		$result = $query->result_array(); //banyak row Ambil hasil query sebagai array asosiatif
		return $result;
    }

	function get_file($nofak) {
		$query = $this->db->query("SELECT g_id,g_nofak,g_brg_id,g_file,g_path FROM tbl_garansi_file WHERE g_nofak='$nofak' ORDER BY g_id ASC");
		$result = $query->result_array(); //banyak row Ambil hasil query sebagai array asosiatif
		return $result;
    }	

	function hapus_file($gid){
	 	$hsl=$this->db->query("DELETE FROM tbl_garansi_file where g_id='$gid'");
	 	return $hsl;
	}

}