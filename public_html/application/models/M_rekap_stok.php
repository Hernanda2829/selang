<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_rekap_stok extends CI_Model {

    function tampil_rekap_stok($thnbln) {
        $coid = $this->session->userdata('coid');
        $select_columns = "a.reg_id, a.reg_name";

        $kategori = $this->db->select('kategori_id, kategori_nama')->get('tbl_kategori')->result_array();

		//perintah sebelum perbaikan
        // foreach ($kategori as $k) {
        //     $kat = $k['kategori_id'];
        //     $select_columns .= ",
        //         SUM(CASE WHEN c.kategori_id = $kat AND d.stok_regid = a.reg_id AND d.stok_in > 0 THEN d.stok_in ELSE 0 END) -
        //         SUM(CASE WHEN c.kategori_id = $kat AND d.stok_regid = a.reg_id AND d.stok_out > 0 THEN d.stok_out ELSE 0 END) AS stok_global_" . $kat . ", 
        //         SUM(CASE WHEN c.kategori_id = $kat AND d.stok_regid = a.reg_id AND d.stok_in > 0 THEN b.barang_harpok * d.stok_in ELSE 0 END) AS Total_Harpok_" . $kat . ", 
        //         SUM(CASE WHEN c.kategori_id = $kat AND d.stok_regid = a.reg_id AND d.stok_in > 0 THEN b.barang_harjul * d.stok_in ELSE 0 END) AS Total_Harjul_" . $kat;
        // }

		//perintah setelah perbaikan
		// foreach ($kategori as $k) {
        //     $kat = $k['kategori_id'];
        //     $select_columns .= ",
        //         SUM(CASE WHEN c.kategori_id = $kat AND d.stok_regid = a.reg_id AND d.stok_in > 0 THEN d.stok_in ELSE 0 END) -
        //         SUM(CASE WHEN c.kategori_id = $kat AND d.stok_regid = a.reg_id AND d.stok_out > 0 THEN d.stok_out ELSE 0 END) AS stok_global_" . $kat . ", 
		// 		SUM(CASE WHEN c.kategori_id = $kat AND d.stok_regid = a.reg_id THEN (d.stok_in - CASE WHEN d.stok_out > 0 THEN d.stok_out ELSE 0 END) * b.barang_harpok ELSE 0 END) AS Total_Harpok_" . $kat . ",
		// 		SUM(CASE WHEN c.kategori_id = $kat AND d.stok_regid = a.reg_id THEN (d.stok_in - CASE WHEN d.stok_out > 0 THEN d.stok_out ELSE 0 END) * b.barang_harjul ELSE 0 END) AS Total_Harjul_" . $kat;
				
        // }
		
		
		//perintah setelah perbaikan
		foreach ($kategori as $k) {
            $kat = $k['kategori_id'];
            $select_columns .= ",
                SUM(CASE WHEN c.kategori_id = $kat AND d.stok_regid = a.reg_id AND d.stok_in > 0 THEN d.stok_in ELSE 0 END) -
                SUM(CASE WHEN c.kategori_id = $kat AND d.stok_regid = a.reg_id AND d.stok_out > 0 THEN d.stok_out ELSE 0 END) AS stok_global_" . $kat . ", 
				SUM(CASE WHEN c.kategori_id = $kat AND d.stok_regid = a.reg_id THEN (CASE WHEN d.stok_in > 0 THEN d.stok_in ELSE 0 END - CASE WHEN d.stok_out > 0 THEN d.stok_out ELSE 0 END) * b.barang_harpok ELSE 0 END) AS Total_Harpok_" . $kat . ",
				SUM(CASE WHEN c.kategori_id = $kat AND d.stok_regid = a.reg_id THEN (CASE WHEN d.stok_in > 0 THEN d.stok_in ELSE 0 END - CASE WHEN d.stok_out > 0 THEN d.stok_out ELSE 0 END) * b.barang_harjul ELSE 0 END) AS Total_Harjul_" . $kat;
        }

        $this->db->select($select_columns);
        $this->db->from('regions a');
        $this->db->join('tbl_barang b', 'b.barang_co_id = a.reg_co_id', 'left');
        $this->db->join('tbl_kategori c', 'c.kategori_id = b.barang_kategori_id', 'left');
        $this->db->join('tbl_stok d', 'b.barang_id = d.brg_id', 'left');
        $this->db->where('a.reg_co_id', $coid);
        $this->db->where("DATE_FORMAT(d.stok_tgl, '%Y-%m') <= '$thnbln'");
        $this->db->group_by('a.reg_id, a.reg_name'); 
        $this->db->order_by('a.reg_id', 'ASC');

        $result = $this->db->get();

        if (!$result) {
            $error_message = $this->db->error();
            echo "Query error: " . $error_message['message'];
            exit;
        }

        return $result;
    }

    
//     function tampil_barang($regid, $cari){
//     $coid = $this->session->userdata('coid');
//     $select_columns = 'b.barang_id, b.barang_nama, b.barang_satuan, b.barang_harpok, b.barang_harjul, b.barang_kategori_nama';
//     $select_columns .= ", 
//         IFNULL(
//             SUM(CASE WHEN s.stok_regid = '" .$regid. "' AND s.stok_in > 0 THEN s.stok_in ELSE 0 END) - 
//             SUM(CASE WHEN s.stok_regid = '" .$regid. "' AND s.stok_out > 0 THEN s.stok_out ELSE 0 END), 0) 
//         AS stok_cabang";
    
//     $this->db->select($select_columns);
//     $this->db->from('tbl_barang b');
//     $this->db->join('tbl_stok s', 'b.barang_id = s.brg_id', 'left');
//     $this->db->where('b.barang_co_id', $coid); 
//     $this->db->group_by('b.barang_id');
//     $this->db->having('stok_cabang >', 0); // Menambahkan kondisi HAVING

//     if (!empty($cari)) {
//         $this->db->where('b.barang_kategori_nama', $cari);
//     }

//     $this->db->order_by('b.barang_kategori_id', 'ASC');
//     $this->db->order_by('b.barang_id', 'ASC');
//     $result = $this->db->get()->result_array(); 
//     return $result;
// }

function tampil_barang($regid, $carikat, $cekstok,$thnbln){
    $coid = $this->session->userdata('coid');
    $select_columns = 'b.barang_id, b.barang_nama, b.barang_satuan, b.barang_harpok, b.barang_harjul, b.barang_kategori_nama';
    $select_columns .= ", 
        IFNULL(
            SUM(CASE WHEN s.stok_regid = '" .$regid. "' AND s.stok_in > 0 THEN s.stok_in ELSE 0 END) - 
            SUM(CASE WHEN s.stok_regid = '" .$regid. "' AND s.stok_out > 0 THEN s.stok_out ELSE 0 END), 0) 
        AS stok_cabang,
        (b.barang_harpok * IFNULL(
            SUM(CASE WHEN s.stok_regid = '" .$regid. "' AND s.stok_in > 0 THEN s.stok_in ELSE 0 END) - 
            SUM(CASE WHEN s.stok_regid = '" .$regid. "' AND s.stok_out > 0 THEN s.stok_out ELSE 0 END), 0)
        ) AS Total_Harpok, 
        (b.barang_harjul * IFNULL(
            SUM(CASE WHEN s.stok_regid = '" .$regid. "' AND s.stok_in > 0 THEN s.stok_in ELSE 0 END) - 
            SUM(CASE WHEN s.stok_regid = '" .$regid. "' AND s.stok_out > 0 THEN s.stok_out ELSE 0 END), 0)
        ) AS Total_Harjul";
    
    $this->db->select($select_columns);
    $this->db->from('tbl_barang b');
    $this->db->join('tbl_stok s', 'b.barang_id = s.brg_id', 'left');
    $this->db->where('b.barang_co_id', $coid);
    $this->db->where("DATE_FORMAT(s.stok_tgl, '%Y-%m') <= '$thnbln'"); 
    $this->db->group_by('b.barang_id');
    if (empty($cekstok) || $cekstok===0) {
        $this->db->having('stok_cabang >', 0); // Menambahkan kondisi HAVING
    }    
    if (!empty($carikat)) {
        $this->db->where('b.barang_kategori_nama', $carikat);
    }

    $this->db->order_by('b.barang_kategori_id', 'ASC');
    $this->db->order_by('b.barang_id', 'ASC');
    $result = $this->db->get()->result_array(); 
    return $result;
}




}
