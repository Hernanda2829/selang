<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_history_stok extends CI_Model {

    function tampil_barang_global($tgl) {
        //$tgl2 = date('Y-m-d', strtotime($tgl . ' -1 day'));  
        $coid = $this->session->userdata('coid');
        $select_columns = 'b.barang_id, b.barang_nama, b.barang_satuan, b.barang_kategori_nama,';

        $select_columns .= "
            (SELECT IFNULL(SUM(CASE WHEN s.stok_coid = '" . $coid . "' AND s.stok_in > 0 THEN s.stok_in ELSE 0 END), 0) 
            FROM tbl_stok s
            WHERE s.brg_id = b.barang_id AND DATE_FORMAT(s.stok_tgl, '%Y-%m-%d') = '$tgl') 
            AS stok_tambah,
            (SELECT IFNULL(SUM(CASE WHEN s.stok_coid = '" .$coid. "' AND s.stok_out > 0 THEN s.stok_out ELSE 0 END), 0) 
            FROM tbl_stok s
            WHERE s.brg_id = b.barang_id AND s.stok_ket!='Retur' AND DATE_FORMAT(s.stok_tgl, '%Y-%m-%d') = '$tgl') 
            AS stok_kurang,
            (SELECT IFNULL(SUM(CASE WHEN s.stok_coid = '" .$coid. "' AND s.stok_out > 0 THEN s.stok_out ELSE 0 END), 0) 
            FROM tbl_stok s
            WHERE s.brg_id = b.barang_id AND s.stok_ket='Retur' AND DATE_FORMAT(s.stok_tgl, '%Y-%m-%d') = '$tgl') 
            AS retur";

        $this->db->select($select_columns);
        $this->db->from('tbl_barang b');
        $this->db->join('tbl_stok s', 'b.barang_id = s.brg_id', 'left');
        $this->db->where('b.barang_co_id', $coid); // Tambahkan kondisi where pada tabel 'tbl_barang'
        $this->db->group_by('b.barang_id');
        $this->db->order_by('b.barang_kategori_id', 'ASC');
        $this->db->order_by('b.barang_id', 'ASC');
        return $this->db->get();
    }


    function tampil_barang($tgl,$regid) {
        $coid = $this->session->userdata('coid');
        $select_columns = 'b.barang_id, b.barang_nama, b.barang_satuan, b.barang_kategori_nama,';

        $select_columns .= "
            (SELECT IFNULL(SUM(CASE WHEN s.stok_regid = '" . $regid . "' AND s.stok_in > 0 THEN s.stok_in ELSE 0 END), 0) 
            FROM tbl_stok s
            WHERE s.brg_id = b.barang_id AND DATE_FORMAT(s.stok_tgl, '%Y-%m-%d') = '$tgl') 
            AS stok_tambah,
            (SELECT IFNULL(SUM(CASE WHEN s.stok_regid = '" .$regid. "' AND s.stok_out > 0 THEN s.stok_out ELSE 0 END), 0) 
            FROM tbl_stok s
            WHERE s.brg_id = b.barang_id AND s.stok_ket!='Retur' AND DATE_FORMAT(s.stok_tgl, '%Y-%m-%d') = '$tgl') 
            AS stok_kurang,
            (SELECT IFNULL(SUM(CASE WHEN s.stok_regid = '" .$regid. "' AND s.stok_out > 0 THEN s.stok_out ELSE 0 END), 0) 
            FROM tbl_stok s
            WHERE s.brg_id = b.barang_id AND s.stok_ket='Retur' AND DATE_FORMAT(s.stok_tgl, '%Y-%m-%d') = '$tgl') 
            AS retur";

        $this->db->select($select_columns);
        $this->db->from('tbl_barang b');
        $this->db->join('tbl_stok s', 'b.barang_id = s.brg_id', 'left');
        $this->db->where('b.barang_co_id', $coid); // Tambahkan kondisi where pada tabel 'tbl_barang'
        $this->db->group_by('b.barang_id');
        $this->db->order_by('b.barang_kategori_id', 'ASC');
        $this->db->order_by('b.barang_id', 'ASC');
        return $this->db->get();
    }
    


    function history_stok($regid,$idbrg,$tgl) {
        $select_columns = "a.stok_id,a.brg_id,a.brg_nama,a.stok_no,DATE_FORMAT(a.stok_tgl, '%d/%m/%Y') as stok_tgl,a.stok_ket,a.stok_status,a.stok_in,a.stok_out,a.created_by,b.reg_name";
        $this->db->select($select_columns);
        $this->db->from('tbl_stok a');
        $this->db->join('regions b', 'b.reg_id = a.stok_regid', 'left');
        $this->db->where('a.stok_regid', $regid);
        $this->db->where('a.brg_id', $idbrg);
        $this->db->where("DATE_FORMAT(a.stok_tgl, '%Y-%m-%d') =", $tgl);
        $this->db->order_by('DATE(a.stok_no)', 'ASC');
        $result = $this->db->get()->result_array(); 
        return $result;
	}

    function history_stok_global($idbrg,$tgl) {
        $coid=$this->session->userdata('coid');
        $select_columns = "a.stok_id,a.brg_id,a.brg_nama,a.stok_no,DATE_FORMAT(a.stok_tgl, '%d/%m/%Y') as stok_tgl,a.stok_ket,a.stok_status,a.stok_in,a.stok_out,a.created_by,b.reg_name";
        $this->db->select($select_columns);
        $this->db->from('tbl_stok a');
        $this->db->join('regions b', 'b.reg_id = a.stok_regid', 'left');
        $this->db->where('a.stok_coid', $coid);
        $this->db->where('a.brg_id', $idbrg);
        $this->db->where("DATE_FORMAT(a.stok_tgl, '%Y-%m-%d') =", $tgl);
        $this->db->order_by('DATE(a.stok_tgl)', 'ASC');
        $result = $this->db->get()->result_array(); 
        return $result;
	}

    

 









    

   

    



}
