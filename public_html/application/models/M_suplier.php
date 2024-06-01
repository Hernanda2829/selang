<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_suplier extends CI_Model{

	function hapus_suplier($kode){
		$hsl=$this->db->query("DELETE FROM tbl_suplier where suplier_id='$kode'");
		return $hsl;
	}

	function update_suplier($kode,$nama,$alamat,$notelp){
		$user_nama=$this->session->userdata('nama');
		$hsl=$this->db->query("UPDATE tbl_suplier set suplier_nama='$nama',suplier_alamat='$alamat',suplier_notelp='$notelp',updated_by='$user_nama',updated_at=now() where suplier_id='$kode'");
		return $hsl;
	}

	function tampil_suplier(){
		$coid=$this->session->userdata('coid');
		$hsl=$this->db->query("SELECT suplier_id,suplier_user_id,suplier_co_id,suplier_nama,suplier_alamat,suplier_notelp FROM tbl_suplier where suplier_co_id='$coid' order by suplier_id desc");
		return $hsl;
	}

	function simpan_suplier($nama,$alamat,$notelp){
		$idadmin=$this->session->userdata('idadmin');
		$user_nama=$this->session->userdata('nama');
		$coid=$this->session->userdata('coid');
		$hsl=$this->db->query("INSERT INTO tbl_suplier(suplier_user_id,suplier_co_id,suplier_nama,suplier_alamat,suplier_notelp,created_by,created_at) VALUES ('$idadmin','$coid','$nama','$alamat','$notelp','$user_nama',now())");
		return $hsl;
	}

	function get_suplier($id){
		$this->db->select('suplier_nama,suplier_alamat,suplier_notelp');
        $this->db->from('tbl_suplier');
        $this->db->where('suplier_id', $id);
        return $this->db->get();
    }

}