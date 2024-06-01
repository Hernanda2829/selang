<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_cabang extends CI_Model{
	function get_cabang(){
		$coid=$this->session->userdata('coid');
		$hsl=$this->db->query("SELECT reg_id,reg_code,reg_name,reg_desc,nick_name,company.co_name FROM regions JOIN company ON regions.reg_co_id=company.co_id WHERE regions.reg_co_id='$coid'");
		return $hsl;
	}
	function simpan_cabang($nama_kode,$nama,$deskripsi,$nickname){
		$coid=$this->session->userdata('coid');
		$user_nama=$this->session->userdata('nama');
		$hsl=$this->db->query("INSERT INTO regions(reg_code,reg_name,reg_desc,nick_name,reg_co_id,created_by,created_at) VALUES ('$nama_kode','$nama','$deskripsi','$nickname','$coid','$user_nama',now())");
		return $hsl;
	}
	function update_cabang($kode,$nama_kode,$nama,$deskripsi,$nickname){
		$user_nama=$this->session->userdata('nama');
		$hsl=$this->db->query("UPDATE regions SET reg_code='$nama_kode',reg_name='$nama',reg_desc='$deskripsi',nick_name='$nickname',updated_by='$user_nama',updated_at=now() WHERE reg_id='$kode'");
		return $hsl;
	}
	function hapus_cabang($kode){
		$hsl=$this->db->query("DELETE FROM regions where reg_id='$kode'");
		return $hsl;
	}

	function get_company($coid) {
		$hsl=$this->db->query("SELECT * FROM company WHERE co_id='$coid'");
		return $hsl->row_array();
	}

	function update_company($coid,$coname,$coaddress,$cophone,$cowebsite,$coemail,$comoto,$coimgicon,$coimglogo,$coimgbg,$cocopyright,$coreka,$corekb) {
		$user_nama=$this->session->userdata('nama');
		$this->db->set('co_name', $coname);
		$this->db->set('co_address', $coaddress);
		$this->db->set('co_phone', $cophone);
		$this->db->set('co_website', $cowebsite);
		$this->db->set('co_email', $coemail);
		$this->db->set('co_moto', $comoto);
		$this->db->set('co_imgicon',$coimgicon);
		$this->db->set('co_imglogo', $coimglogo);
		$this->db->set('co_imgbg', $coimgbg);
		$this->db->set('co_copyright', $cocopyright);
		$this->db->set('co_rek_a', $coreka);
		$this->db->set('co_rek_b', $corekb);
		$this->db->set('updated_by', $user_nama);
		$this->db->set('updated_at', 'NOW()', false);
		$this->db->where('co_id', $coid);
		$hsl = $this->db->update('company');
		return $hsl;
	}


	
}