<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_diskon extends CI_Model{

	function hapus_diskon($kode){
		$hsl=$this->db->query("DELETE FROM tbl_discount where disc_id='$kode'");
		return $hsl;
	}

	function update_diskon($kode,$nama_diskon, $rate_diskon){
		$idadmin=$this->session->userdata('idadmin');
		$user_nama=$this->session->userdata('nama');
		$hsl=$this->db->query("UPDATE tbl_discount set disc_ket='$nama_diskon',disc_rate='$rate_diskon',updated_by='$user_nama',updated_at=now() where disc_id='$kode'");
		return $hsl;
	}

	function tampil_diskon(){
		$coid=$this->session->userdata('coid');
		$hsl=$this->db->query("SELECT * from tbl_discount where disc_co_id='$coid' order by disc_id asc");
		return $hsl;
	}

	function simpan_diskon($nama_diskon, $rate_diskon) {
        $idadmin=$this->session->userdata('idadmin');
		$user_nama=$this->session->userdata('nama');
		$coid=$this->session->userdata('coid');
		$data = array(
            'disc_rate' 	=> $rate_diskon,
			'disc_ket' 		=> $nama_diskon,
			'disc_user_id' 	=> $idadmin,
			'disc_co_id' 	=> $coid,
			'created_by' 	=> $user_nama,
			'created_at'	=> date('Y-m-d H:i:s')
        );
        $this->db->insert('tbl_discount', $data);
    }
}