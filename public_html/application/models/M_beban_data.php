<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_beban_data extends CI_Model {

    
    function tampil_beban($regid, $tgl1, $tgl2, $cari) {
    // $query = "DATE_FORMAT(a.beban_tanggal, '%d %M %Y %H:%i:%s') AS beban_tanggal , a.beban_nama, a.beban_jumlah,a.beban_kat_id,a.beban_kat_nama";
    //     $this->db->select($query);
    //     $this->db->from('tbl_beban_opr a');
    //     $this->db->join('tbl_beban_kat b', 'b.kat_id = a.beban_kat_id', 'left');
    //     //$this->db->where('a.beban_tanggal BETWEEN ' . $this->db->escape($tgl1) . ' AND ' . $this->db->escape($tgl2));
    //     $this->db->where('DATE(a.beban_tanggal) >=', $tgl1);
    //     $this->db->where('DATE(a.beban_tanggal) <=', $tgl2);
    //     $this->db->where('a.beban_reg_id', $regid);
    //     //$this->db->order_by('DATE(a.beban_tanggal)', 'ASC');
    //     //$this->db->order_by('DATE(a.beban_tanggal) ASC, b.kat_id ASC');
    //     $this->db->order_by('b.kat_id ASC');
    //     $result = $this->db->get()->result_array();
    //     return $result;

            $query = "DATE_FORMAT(a.beban_tanggal, '%d %M %Y %H:%i:%s') AS beban_tanggal , a.beban_nama, a.beban_jumlah,a.beban_kat_id,a.beban_kat_nama";
            $this->db->select($query);
            $this->db->from('tbl_beban_opr a');
            $this->db->join('tbl_beban_kat b', 'b.kat_id = a.beban_kat_id', 'left');
            $this->db->where('DATE(a.beban_tanggal) >=', $tgl1);
            $this->db->where('DATE(a.beban_tanggal) <=', $tgl2);
            $this->db->where('a.beban_reg_id', $regid);

            if (!empty($cari)) {
                $this->db->where('a.beban_kat_id', $cari);
            }
            $this->db->order_by('b.kat_id ASC');
            $result = $this->db->get()->result_array();
            return $result;
    }

    function get_kategori(){
		$coid=$this->session->userdata('coid');
		$hsl=$this->db->query("SELECT kat_id,kat_nama FROM tbl_beban_kat WHERE kat_co_id='$coid'");
		return $hsl;
	}


}
