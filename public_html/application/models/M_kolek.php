<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_kolek extends CI_Model{

	function hapus_kolek($kode){
		$hsl=$this->db->query("DELETE FROM kolek where kol_id='$kode'");
		return $hsl;
	}

	function update_kolek($kode,$kolbln,$kolhari,$kolwarna,$kolket,$stopsales){
		$user_nama=$this->session->userdata('nama');
		$hsl=$this->db->query("UPDATE kolek set kol_bln='$kolbln',kol_hari='$kolhari',kol_warna='$kolwarna',kol_ket='$kolket',stop_sales='$stopsales',updated_by='$user_nama',updated_at=now() where kol_id='$kode'");
		return $hsl;
	}

	function tampil_kolek(){
		$coid=$this->session->userdata('coid');
		$hsl=$this->db->query("SELECT kol_id,kol_bln,kol_hari,kol_warna,kol_ket,stop_sales FROM kolek where kol_coid='$coid' order by kol_id ASC");
		return $hsl;
	}
	
	function simpan_kolek($kolbln,$kolhari,$kolwarna,$kolket,$stopsales){
		$idadmin=$this->session->userdata('idadmin');
		$user_nama=$this->session->userdata('nama');
		$coid=$this->session->userdata('coid');
		$hsl=$this->db->query("INSERT INTO kolek(kol_bln,kol_hari,kol_warna,kol_ket,kol_coid,stop_sales,created_by,created_at) VALUES ('$kolbln','$kolhari','$kolwarna','$kolket','$coid','$stopsales','$user_nama',now())");
		return $hsl;
	}

}