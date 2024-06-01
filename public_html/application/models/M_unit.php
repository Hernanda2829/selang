<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_unit extends CI_Model{

	function hapus_unit($kode){
		$hsl=$this->db->query("DELETE FROM units where units_id='$kode'");
		return $hsl;
	}

	function update_unit($kode,$nama,$shortnama){
		$user_nama=$this->session->userdata('nama');
		$hsl=$this->db->query("UPDATE units set units_name='$nama',short_name='$shortnama',updated_by='$user_nama',updated_at=now() where units_id='$kode'");
		return $hsl;
	}

	function tampil_unit(){
		$coid=$this->session->userdata('coid');
		$hsl=$this->db->query("SELECT units_id,units_name,short_name FROM units where units_co_id='$coid' order by units_id ASC");
		return $hsl;
	}
	
	function simpan_unit($nama,$shortnama){
		$idadmin=$this->session->userdata('idadmin');
		$user_nama=$this->session->userdata('nama');
		$coid=$this->session->userdata('coid');
		$hsl=$this->db->query("INSERT INTO units(units_name,short_name,units_co_id,created_by,created_at) VALUES ('$nama','$shortnama','$coid','$user_nama',now())");
		return $hsl;
	}

}