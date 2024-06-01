<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_kategori extends CI_Model{

	function hapus_kategori($kode){
		$hsl=$this->db->query("DELETE FROM tbl_kategori where kategori_id='$kode'");
		return $hsl;
	}

	function update_kategori($kode,$kat,$kat_report){
		$hsl=$this->db->query("UPDATE tbl_kategori set kategori_nama='$kat', kategori_report='$kat_report' where kategori_id='$kode'");
		return $hsl;
	}

	function tampil_kategori(){
		$coid=$this->session->userdata('coid');
		$hsl=$this->db->query("SELECT kategori_id,kategori_nama,kategori_report FROM tbl_kategori where kategori_co_id='$coid' order by kategori_id asc");
		return $hsl;
	}

	function simpan_kategori($kat,$kat_report){
		$idadmin=$this->session->userdata('idadmin');
		$user_nama=$this->session->userdata('nama');
		$coid=$this->session->userdata('coid');
		$hsl=$this->db->query("INSERT INTO tbl_kategori(kategori_nama,kategori_report,kategori_user_id,kategori_co_id,created_by,created_at) VALUES ('$kat','$kat_report','$idadmin','$coid','$user_nama',now())");
		return $hsl;
	}

}