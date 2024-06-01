<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_data_stok extends CI_Model {

    function tampil_barang_global($thnbln){
        $cari_thnbln = date("Y-m", strtotime("-1 month", strtotime($thnbln)));   
		$coid=$this->session->userdata('coid');
		$select_columns = 'b.barang_id, b.barang_nama, b.barang_harpok, b.barang_harjul,b.barang_satuan,b.barang_kategori_nama,';
		
        $select_columns .= "(SELECT IFNULL(
            SUM(CASE WHEN s.stok_coid = '" .$coid. "' AND s.stok_in > 0 THEN s.stok_in ELSE 0 END) - 
            SUM(CASE WHEN s.stok_coid = '" .$coid. "' AND s.stok_out > 0 THEN s.stok_out ELSE 0 END), 0) 
            FROM tbl_stok s
            WHERE s.brg_id = b.barang_id AND DATE_FORMAT(s.stok_tgl, '%Y-%m') <= '$cari_thnbln') 
            AS stok_awal,
            (SELECT IFNULL(SUM(CASE WHEN s.stok_coid = '" .$coid. "' AND s.stok_in > 0 THEN s.stok_in ELSE 0 END), 0) 
            FROM tbl_stok s
            WHERE s.brg_id = b.barang_id AND DATE_FORMAT(s.stok_tgl, '%Y-%m') = '$thnbln') 
            AS stok_tambah,
            (SELECT IFNULL(SUM(CASE WHEN s.stok_coid = '" .$coid. "' AND s.stok_out > 0 THEN s.stok_out ELSE 0 END), 0) 
            FROM tbl_stok s
            WHERE s.brg_id = b.barang_id AND s.stok_ket!='Retur' AND DATE_FORMAT(s.stok_tgl, '%Y-%m') = '$thnbln') 
            AS stok_kurang,
            (SELECT IFNULL(SUM(CASE WHEN s.stok_coid = '" .$coid. "' AND s.stok_out > 0 THEN s.stok_out ELSE 0 END), 0) 
            FROM tbl_stok s
            WHERE s.brg_id = b.barang_id AND s.stok_ket='Retur' AND DATE_FORMAT(s.stok_tgl, '%Y-%m') = '$thnbln') 
            AS retur";
            
        $select_columns .= ", 
			IFNULL(
				SUM(CASE WHEN s.stok_coid = '" .$coid. "' AND s.stok_in > 0 THEN s.stok_in ELSE 0 END) - 
				SUM(CASE WHEN s.stok_coid = '" .$coid. "' AND s.stok_out > 0 THEN s.stok_out ELSE 0 END), 0) 
			AS stok_cabang,
            (b.barang_harpok * IFNULL(
                SUM(CASE WHEN s.stok_coid = '" .$coid. "' AND s.stok_in > 0 THEN s.stok_in ELSE 0 END) - 
                SUM(CASE WHEN s.stok_coid = '" .$coid. "' AND s.stok_out > 0 THEN s.stok_out ELSE 0 END), 0)
            ) AS Total_Harpok, 
            (b.barang_harjul * IFNULL(
                SUM(CASE WHEN s.stok_coid = '" .$coid. "' AND s.stok_in > 0 THEN s.stok_in ELSE 0 END) - 
                SUM(CASE WHEN s.stok_coid = '" .$coid. "' AND s.stok_out > 0 THEN s.stok_out ELSE 0 END), 0)
            ) AS Total_Harjul";
		
		$this->db->select($select_columns);
		$this->db->from('tbl_barang b');
		$this->db->join('tbl_stok s', 'b.barang_id = s.brg_id', 'left');
		$this->db->where('b.barang_co_id', $coid); // Tambahkan kondisi where pada tabel 'tbl_barang'
        $this->db->where("DATE_FORMAT(s.stok_tgl, '%Y-%m') <= '$thnbln'", NULL, FALSE); //tambahkan perintah ini, jika ingin stok akhir/stok cabang di hitung hingga bulan dan tahun pencarian
		$this->db->group_by('b.barang_id');
        $this->db->order_by('b.barang_kategori_id', 'ASC');
        $this->db->order_by('b.barang_id', 'ASC');
		return $this->db->get();
        //catatan :  hilangkan perintah ini : $this->db->where("DATE_FORMAT(s.stok_tgl, '%Y-%m') <= '$thnbln'", NULL, FALSE);
        //           jika ingin perhitungan stok akhir/stok cabang di hitung hingga bulan tahun saat ini.
	}

    function tampil_barang($thnbln,$regid){
        $cari_thnbln = date("Y-m", strtotime("-1 month", strtotime($thnbln)));   
		$coid=$this->session->userdata('coid');
		$select_columns = 'b.barang_id, b.barang_nama, b.barang_harpok, b.barang_harjul,b.barang_satuan,b.barang_kategori_nama,';
		
        $select_columns .= "(SELECT IFNULL(
            SUM(CASE WHEN s.stok_regid = '" .$regid. "' AND s.stok_in > 0 THEN s.stok_in ELSE 0 END) - 
            SUM(CASE WHEN s.stok_regid = '" .$regid. "' AND s.stok_out > 0 THEN s.stok_out ELSE 0 END), 0) 
            FROM tbl_stok s
            WHERE s.brg_id = b.barang_id AND DATE_FORMAT(s.stok_tgl, '%Y-%m') <= '$cari_thnbln') 
            AS stok_awal,
            (SELECT IFNULL(SUM(CASE WHEN s.stok_regid = '" .$regid. "' AND s.stok_in > 0 THEN s.stok_in ELSE 0 END), 0) 
            FROM tbl_stok s
            WHERE s.brg_id = b.barang_id AND DATE_FORMAT(s.stok_tgl, '%Y-%m') = '$thnbln') 
            AS stok_tambah,
            (SELECT IFNULL(SUM(CASE WHEN s.stok_regid = '" .$regid. "' AND s.stok_out > 0 THEN s.stok_out ELSE 0 END), 0) 
            FROM tbl_stok s
            WHERE s.brg_id = b.barang_id AND s.stok_ket!='Retur' AND DATE_FORMAT(s.stok_tgl, '%Y-%m') = '$thnbln') 
            AS stok_kurang,
            (SELECT IFNULL(SUM(CASE WHEN s.stok_regid = '" .$regid. "' AND s.stok_out > 0 THEN s.stok_out ELSE 0 END), 0) 
            FROM tbl_stok s
            WHERE s.brg_id = b.barang_id AND s.stok_ket='Retur' AND DATE_FORMAT(s.stok_tgl, '%Y-%m') = '$thnbln') 
            AS retur";

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
        $this->db->where("DATE_FORMAT(s.stok_tgl, '%Y-%m') <= '$thnbln'", NULL, FALSE); //tambahkan perintah ini, jika ingin stok akhir/stok cabang di hitung hingga bulan dan tahun pencarian
		$this->db->group_by('b.barang_id');
        $this->db->order_by('b.barang_kategori_id', 'ASC');
        $this->db->order_by('b.barang_id', 'ASC');
		return $this->db->get();
	}

    // function tampil_barang($thnbln,$regid){
    //     $cari_thnbln = date("Y-m", strtotime("-1 month", strtotime($thnbln)));   
	// 	$coid=$this->session->userdata('coid');
	// 	$select_columns = 'b.barang_id, b.barang_nama, b.barang_harpok, b.barang_harjul,b.barang_satuan,b.barang_kategori_nama,';
		
    //     //Data sebelum perbaikan
    //     // $select_columns .= "(SELECT IFNULL(
    //     //     SUM(CASE WHEN s.stok_regid = '" .$regid. "' AND s.stok_in > 0 THEN s.stok_in ELSE 0 END) - 
    //     //     SUM(CASE WHEN s.stok_regid = '" .$regid. "' AND s.stok_out > 0 THEN s.stok_out ELSE 0 END), 0) 
    //     //     FROM tbl_stok s
    //     //     WHERE s.brg_id = b.barang_id AND DATE_FORMAT(s.stok_tgl, '%Y-%m') <= '$cari_thnbln') 
    //     //     AS stok_awal,
    //     //     (SELECT IFNULL(SUM(CASE WHEN s.stok_regid = '" .$regid. "' AND s.stok_in > 0 THEN s.stok_in ELSE 0 END), 0) 
    //     //     FROM tbl_stok s
    //     //     WHERE s.brg_id = b.barang_id AND DATE_FORMAT(s.stok_tgl, '%Y-%m') = '$thnbln') 
    //     //     AS stok_tambah,
    //     //     (SELECT IFNULL(SUM(CASE WHEN s.stok_regid = '" .$regid. "' AND s.stok_out > 0 THEN s.stok_out ELSE 0 END), 0) 
    //     //     FROM tbl_stok s
    //     //     WHERE s.brg_id = b.barang_id AND DATE_FORMAT(s.stok_tgl, '%Y-%m') = '$thnbln') 
    //     //     AS stok_kurang";

    //     //Data Setelah diperbaiki
    //     $select_columns .= "(SELECT IFNULL(
    //         SUM(CASE WHEN s.stok_regid = '" .$regid. "' AND s.stok_in > 0 THEN s.stok_in ELSE 0 END) - 
    //         SUM(CASE WHEN s.stok_regid = '" .$regid. "' AND s.stok_out > 0 THEN s.stok_out ELSE 0 END), 0) 
    //         FROM tbl_stok s
    //         WHERE s.brg_id = b.barang_id AND DATE_FORMAT(s.stok_tgl, '%Y-%m') <= '$cari_thnbln') 
    //         AS stok_awal,
    //         (SELECT IFNULL(SUM(CASE WHEN s.stok_regid = '" .$regid. "' AND s.stok_in > 0 THEN s.stok_in ELSE 0 END), 0) 
    //         FROM tbl_stok s
    //         WHERE s.brg_id = b.barang_id AND DATE_FORMAT(s.stok_tgl, '%Y-%m') = '$thnbln') 
    //         AS stok_tambah,
    //         (SELECT IFNULL(SUM(CASE WHEN s.stok_regid = '" .$regid. "' AND s.stok_out > 0 THEN s.stok_out ELSE 0 END), 0) 
    //         FROM tbl_stok s
    //         WHERE s.brg_id = b.barang_id AND s.stok_ket!='Retur' AND DATE_FORMAT(s.stok_tgl, '%Y-%m') = '$thnbln') 
    //         AS stok_kurang,
    //         (SELECT IFNULL(SUM(CASE WHEN s.stok_regid = '" .$regid. "' AND s.stok_out > 0 THEN s.stok_out ELSE 0 END), 0) 
    //         FROM tbl_stok s
    //         WHERE s.brg_id = b.barang_id AND s.stok_ket='Retur' AND DATE_FORMAT(s.stok_tgl, '%Y-%m') = '$thnbln') 
    //         AS retur";

    //     $select_columns .= ", 
	// 		IFNULL(
	// 			SUM(CASE WHEN s.stok_regid = '" .$regid. "' AND s.stok_in > 0 THEN s.stok_in ELSE 0 END) - 
	// 			SUM(CASE WHEN s.stok_regid = '" .$regid. "' AND s.stok_out > 0 THEN s.stok_out ELSE 0 END), 0) 
	// 		AS stok_cabang,
    //         (b.barang_harpok * IFNULL(
    //             SUM(CASE WHEN s.stok_regid = '" .$regid. "' AND s.stok_in > 0 THEN s.stok_in ELSE 0 END) - 
    //             SUM(CASE WHEN s.stok_regid = '" .$regid. "' AND s.stok_out > 0 THEN s.stok_out ELSE 0 END), 0)
    //         ) AS Total_Harpok, 
    //         (b.barang_harjul * IFNULL(
    //             SUM(CASE WHEN s.stok_regid = '" .$regid. "' AND s.stok_in > 0 THEN s.stok_in ELSE 0 END) - 
    //             SUM(CASE WHEN s.stok_regid = '" .$regid. "' AND s.stok_out > 0 THEN s.stok_out ELSE 0 END), 0)
    //         ) AS Total_Harjul";

        
		
	// 	$this->db->select($select_columns);
	// 	$this->db->from('tbl_barang b');
	// 	$this->db->join('tbl_stok s', 'b.barang_id = s.brg_id', 'left');
	// 	$this->db->where('b.barang_co_id', $coid); // Tambahkan kondisi where pada tabel 'tbl_barang'
	// 	$this->db->group_by('b.barang_id');
    //     $this->db->order_by('b.barang_kategori_id', 'ASC');
    //     $this->db->order_by('b.barang_id', 'ASC');
	// 	return $this->db->get();
	// }


    function history_stok($regid,$idbrg,$tgl1,$tgl2) {
        $select_columns = "a.stok_id,a.brg_id,a.brg_nama,a.stok_no,DATE_FORMAT(a.stok_tgl, '%d/%m/%Y') as stok_tgl,a.stok_ket,a.stok_status,a.stok_in,a.stok_out,a.created_by,b.reg_name";
        $this->db->select($select_columns);
        $this->db->from('tbl_stok a');
        $this->db->join('regions b', 'b.reg_id = a.stok_regid', 'left');
        $this->db->where('a.stok_regid', $regid);
        $this->db->where('a.brg_id', $idbrg);
        $this->db->where('DATE(a.stok_tgl) >=', $tgl1);
        $this->db->where('DATE(a.stok_tgl) <=', $tgl2);
        $this->db->order_by('DATE(a.stok_tgl)', 'ASC');
        $result = $this->db->get()->result_array(); 
        return $result;
	}

    function history_stok_global($regid,$idbrg,$tgl1,$tgl2) {
        $coid=$this->session->userdata('coid');
        $select_columns = "a.stok_id,a.brg_id,a.brg_nama,a.stok_no,DATE_FORMAT(a.stok_tgl, '%d/%m/%Y') as stok_tgl,a.stok_ket,a.stok_status,a.stok_in,a.stok_out,a.created_by,b.reg_name";
        $this->db->select($select_columns);
        $this->db->from('tbl_stok a');
        $this->db->join('regions b', 'b.reg_id = a.stok_regid', 'left');
        $this->db->where('a.stok_coid', $coid);
        $this->db->where('a.brg_id', $idbrg);
        $this->db->where('DATE(a.stok_tgl) >=', $tgl1);
        $this->db->where('DATE(a.stok_tgl) <=', $tgl2);
        $this->db->order_by('DATE(a.stok_tgl)', 'ASC');
        $result = $this->db->get()->result_array(); 
        return $result;
	}

    function get_stok($stokid) {
        $select_columns = "a.stok_id,a.brg_id,a.brg_nama,a.stok_no,DATE_FORMAT(a.stok_tgl, '%d/%m/%Y') as stok_tgl,a.stok_ket,a.stok_status,a.stok_in,a.stok_out,a.created_by,b.reg_name";
        $this->db->select($select_columns);
        $this->db->from('tbl_stok a');
        $this->db->join('regions b', 'b.reg_id = a.stok_regid', 'left');
        $this->db->where('a.stok_id', $stokid);
        $result = $this->db->get()->result_array(); 
        return $result;
	}

    function update_stok($stokid,$tgl) {
		$user_nama=$this->session->userdata('nama');
		$this->db->set('stok_tgl', $tgl);
		$this->db->set('updated_by', $user_nama);
		$this->db->set('updated_at', 'NOW()', false);
		$this->db->where('stok_id', $stokid);
		$hsl = $this->db->update('tbl_stok');
		return $hsl;
	}









    

   

    



}
