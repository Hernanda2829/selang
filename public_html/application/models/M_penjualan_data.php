<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_penjualan_data extends CI_Model {

    
    function tampil_penjualan_global($firstDay, $lastDay) {
        $coid=$this->session->userdata('coid');
        $this->db->select("DATE_FORMAT(a.jual_tanggal, '%d %M %Y') AS jual_tanggal, a.jual_cust_nama, a.jual_nofak, a.jual_nota, a.jual_bayar, a.jual_bayar_status, a.jual_total,a.jual_bulan_tempo,a.jual_tgl_tempo,b.reg_name");
        $this->db->from('tbl_jual a');
        $this->db->join('regions b', 'b.reg_id = a.jual_reg_id', 'left');
        $this->db->where('DATE(a.jual_tanggal) >=', $firstDay);
        $this->db->where('DATE(a.jual_tanggal) <=', $lastDay);
        $this->db->where('a.jual_co_id', $coid);
        $this->db->order_by('DATE(a.jual_tanggal)', 'ASC');
        $result = $this->db->get()->result_array(); 
        return $result;
    }

    function tampil_penjualan($regid, $firstDay, $lastDay) {
        //$this->db->select("DATE_FORMAT(a.jual_tanggal, '%d %M %Y %H:%i:%s') AS jual_tanggal, a.jual_cust_nama, a.jual_nofak, a.jual_nota, a.jual_bayar, a.jual_bayar_status, a.jual_total,a.jual_bulan_tempo,a.jual_tgl_tempo");
        $this->db->select("DATE_FORMAT(a.jual_tanggal, '%d %M %Y') AS jual_tanggal, a.jual_cust_nama, a.jual_nofak, a.jual_nota, a.jual_bayar, a.jual_bayar_status, a.jual_total,a.jual_bulan_tempo,a.jual_tgl_tempo,b.reg_name");
        $this->db->from('tbl_jual a');
        $this->db->join('regions b', 'b.reg_id = a.jual_reg_id', 'left');
        $this->db->where('DATE(a.jual_tanggal) >=', $firstDay);
        $this->db->where('DATE(a.jual_tanggal) <=', $lastDay);
        $this->db->where('a.jual_reg_id', $regid);
        $this->db->order_by('DATE(a.jual_tanggal)', 'ASC');
        $result = $this->db->get()->result_array(); 
        return $result;
    }

    function getdetailjual($nofak) {
		$queryA = $this->db->query("SELECT bayar_nofak, DATE_FORMAT(bayar_tanggal, '%d %M %Y %H:%i:%s') AS bayar_tgl,bayar_tanggal,bayar_total, SUM(bayar_jumlah) AS tot_bayar,(bayar_total-SUM(bayar_jumlah)) AS kur_bayar,bayar_ket FROM tbl_bayar WHERE bayar_nofak = '$nofak' GROUP BY bayar_nofak");
        $queryB = $this->db->query("SELECT bayar_id, DATE_FORMAT(bayar_tgl_trans, '%d %M %Y %H:%i:%s') AS tgl_trans,bayar_jumlah FROM tbl_bayar WHERE bayar_nofak='$nofak'");
        $queryC = $this->db->query("SELECT d_jual_nofak, d_jual_barang_id, d_jual_barang_nama, d_jual_barang_satuan, d_jual_qty, d_jual_barang_harjul, d_jual_diskon, d_jual_total,jual_tanggal,jual_cust_nama,jual_bayar,jual_bayar_status,jual_total FROM tbl_jual join tbl_detail_jual ON jual_nofak=d_jual_nofak  WHERE d_jual_nofak='$nofak' ORDER BY d_jual_barang_id ASC");
        $resultA = $queryA->row_array();
        $resultB = $queryB->result_array();
        $resultC = $queryC->result_array();
        return array('queryA' => $resultA, 'queryB' => $resultB, 'queryC' => $resultC);
    }

    function get_faktur($nofak){
		$hsl=$this->db->query("SELECT jual_nofak,DATE_FORMAT(jual_tanggal,'%d/%m/%Y %H:%i:%s') AS jual_tanggal,jual_nota,jual_total,jual_jml_uang,jual_kembalian,jual_bayar,jual_kurang_bayar,d_jual_barang_id,d_jual_barang_nama,d_jual_barang_satuan,d_jual_barang_harjul,d_jual_qty,d_jual_diskon,d_jual_total,jual_cust_nama,group_id,group_desc,group_sat FROM tbl_jual JOIN tbl_detail_jual ON jual_nofak=d_jual_nofak WHERE jual_nofak='$nofak'");
		return $hsl;
	}

    


}
