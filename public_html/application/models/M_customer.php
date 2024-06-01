<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_customer extends CI_Model{

	function hapus_customer($kode){
		$hsl=$this->db->query("DELETE FROM tbl_customer where cust_id='$kode'");
		return $hsl;
	}

	function update_customer($kode,$nama,$alamat,$notelp){
		$user_nama=$this->session->userdata('nama');
		$hsl=$this->db->query("UPDATE tbl_customer set cust_nama='$nama',cust_alamat='$alamat',cust_notelp='$notelp',updated_by='$user_nama',updated_at=now() where cust_id='$kode'");
		return $hsl;
	}

	function tampil_customer(){
		$coid=$this->session->userdata('coid');
		$hsl=$this->db->query("SELECT cust_id,cust_reg_id,cust_co_id,cust_nama,cust_alamat,cust_notelp,reg_name FROM tbl_customer JOIN regions ON cust_reg_id=reg_id where cust_co_id='$coid' order by cust_id desc");
		return $hsl;
	}

	function tampil_customerkasir(){
		$coid=$this->session->userdata('coid');
		$regid=$this->session->userdata('regid');
		$hsl=$this->db->query("SELECT cust_id,cust_reg_id,cust_co_id,cust_nama,cust_alamat,cust_notelp,reg_name FROM tbl_customer JOIN regions ON cust_reg_id=reg_id WHERE cust_co_id='$coid' AND cust_reg_id='$regid' order by cust_id desc");
		return $hsl;
	}

	function simpan_customer($nama,$alamat,$notelp){
		$user_id=$this->session->userdata('idadmin');
		$regid=$this->session->userdata('regid');
		$user_nama=$this->session->userdata('nama');
		$coid=$this->session->userdata('coid');
		$hsl=$this->db->query("INSERT INTO tbl_customer(cust_reg_id,cust_co_id,cust_user_id,cust_nama,cust_alamat,cust_notelp,created_by,created_at) VALUES ('$regid','$coid','$user_id','$nama','$alamat','$notelp','$user_nama',now())");
		return $hsl;
	}

}