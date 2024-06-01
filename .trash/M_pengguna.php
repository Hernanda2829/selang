<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_pengguna extends CI_Model{
	function get_pengguna(){
		$coid=$this->session->userdata('coid');
		$hsl=$this->db->query("SELECT user_id,user_nama,user_username,user_password,user_level,user_status,user_title,level_nama,reg_id,reg_name,co_id,co_name FROM tbl_user JOIN tbl_user_level ON tbl_user.user_level=tbl_user_level.level_id JOIN company ON tbl_user.user_co_id=company.co_id JOIN regions ON tbl_user.user_reg_id=regions.reg_id WHERE tbl_user.user_co_id='$coid'");
		return $hsl;
	}
	function get_user_level(){
		$hsl=$this->db->query("SELECT level_id,level_nama,level_akses FROM tbl_user_level order by level_id asc");
		return $hsl;
	}
	function simpan_pengguna($nama,$username,$usertitle,$password,$level,$regid){
		$coid=$this->session->userdata('coid');
		$user_nama=$this->session->userdata('nama');
		// $hsl=$this->db->query("INSERT INTO tbl_user(user_nama,user_username,user_password,user_level,user_status,user_title,user_co_id,user_reg_id,created_by,created_at) VALUES ('$nama','$username',md5('$password'),'$level','1','$usertitle','$coid','$regid','$user_nama',now())");
		// return $hsl;
		// Hash password menggunakan password_hash()
		$hashed_password = password_hash($password, PASSWORD_DEFAULT);
		$data = array(
			'user_nama' 	=> $nama,
			'user_username' => $username,
			'user_password' => $hashed_password,
			'user_level' 	=> $level,
			'user_status' 	=> '1',
			'user_title' 	=> $usertitle,
			'user_co_id' 	=> $coid,
			'user_reg_id' 	=> $regid,
			'created_by'    => $user_nama,
			'created_at'    => date('Y-m-d H:i:s')
		);
		$this->db->insert('tbl_user', $data);
		return true;
	}
	
	function update_pengguna($kode,$nama,$username,$usertitle,$level,$regid){
	//function update_pengguna($kode,$nama,$username,$password,$level){
		//$hsl=$this->db->query("UPDATE tbl_user SET user_nama='$nama',user_username='$username',user_password=md5('$password'),user_level='$level' WHERE user_id='$kode'");
		$user_nama=$this->session->userdata('nama');
		$hsl=$this->db->query("UPDATE tbl_user SET user_nama='$nama',user_username='$username',user_level='$level',user_title='$usertitle',user_reg_id='$regid',updated_by='$user_nama',updated_at=now() WHERE user_id='$kode'");
		return $hsl;
	}
	function update_status_nonaktif($kode){
		$hsl=$this->db->query("UPDATE tbl_user SET user_status='0' WHERE user_id='$kode'");
		return $hsl;
	}
	function update_status_aktif($kode){
		$hsl=$this->db->query("UPDATE tbl_user SET user_status='1' WHERE user_id='$kode'");
		return $hsl;
	}
	
	function update_password($kode,$password){
		//$hsl=$this->db->query("UPDATE tbl_user SET user_password=md5('$password') WHERE user_id='$kode'");
		//return $hsl;
		// Hash password menggunakan password_hash()
		$hashed_password = password_hash($password, PASSWORD_DEFAULT);
		$data = array(
			'user_password' => $hashed_password
		);
		$this->db->where('user_id', $kode);
		$this->db->update('tbl_user', $data);
		return true;
	}
	function get_password($kode){
		$hsl=$this->db->query("SELECT user_password FROM tbl_user WHERE user_id='$kode'");
		return $hsl;
	}

}