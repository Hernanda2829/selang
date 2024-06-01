<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_Periode extends CI_Model{

	function hapus_periode($kode){
		$hsl=$this->db->query("DELETE FROM periode where p_id='$kode'");
		return $hsl;
	}

	function update_periode($kode,$pval,$pnama){
		$user_nama=$this->session->userdata('nama');
		$hsl=$this->db->query("UPDATE periode set p_val='$pval',p_nama='$pnama',updated_by='$user_nama',updated_at=now() where p_id='$kode'");
		return $hsl;
	}

	function tampil_periode(){
		$coid=$this->session->userdata('coid');
		$hsl=$this->db->query("SELECT p_id,p_val,p_nama FROM periode where p_coid='$coid' order by p_id ASC");
		return $hsl;
	}
	
	function simpan_periode($pval,$pnama){
		$idadmin=$this->session->userdata('idadmin');
		$user_nama=$this->session->userdata('nama');
		$coid=$this->session->userdata('coid');
		$hsl=$this->db->query("INSERT INTO periode(p_val,p_nama,p_coid,created_by,created_at) VALUES ('$pval','$pnama','$coid','$user_nama',now())");
		return $hsl;
	}

}