<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_markup extends CI_Model {

    function tampil_penjualan_markup($firstDay, $lastDay) {
		$coid=$this->session->userdata('coid');
		$this->db->select("a.jual_nofak,a.jual_cust_nama,DATE_FORMAT(a.jual_tanggal, '%d %M %Y %H:%i:%s') AS jual_tanggal,a.jual_bayar,a.jual_bayar_status,a.jual_total,a.jual_user_id,a.created_by,b.reg_name");
		$this->db->from('tbl_jual_markup a');
		$this->db->join('regions b', 'b.reg_id = a.jual_reg_id', 'left');
		$this->db->where('DATE(a.jual_tanggal) >=', $firstDay);
        $this->db->where('DATE(a.jual_tanggal) <=', $lastDay);
		$this->db->where('a.jual_co_id', $coid);
		$this->db->order_by('DATE(a.jual_tanggal)', 'DESC');
        $result = $this->db->get()->result_array(); 
        return $result;
    }

    // function tampil_penjualan_markup() {
	// 	$coid=$this->session->userdata('coid');
    //     $result = $this->db->query("SELECT jual_nofak,jual_cust_nama,DATE_FORMAT(jual_tanggal, '%d %M %Y %H:%i:%s') AS jual_tanggal,jual_bayar,jual_bayar_status,jual_total,jual_user_id,tbl_jual_markup.created_by,regions.reg_name FROM tbl_jual_markup JOIN regions ON tbl_jual_markup.jual_reg_id=regions.reg_id WHERE jual_co_id='$coid' ORDER BY DATE(jual_tanggal) DESC");
    //     return $result; 
    // }
    
    function tampil_penjualan() {
		$coid=$this->session->userdata('coid');
        $result = $this->db->query("SELECT jual_nofak,jual_cust_nama,DATE_FORMAT(jual_tanggal, '%d %M %Y %H:%i:%s') AS jual_tanggal,jual_bayar,jual_bayar_status,jual_total,jual_user_id,tbl_jual.created_by,regions.reg_name FROM tbl_jual JOIN regions ON tbl_jual.jual_reg_id=regions.reg_id WHERE jual_co_id='$coid' ORDER BY DATE(jual_tanggal) DESC");
        return $result; 
    }

    function getdetailjual($nofak) {
        $queryA = $this->db->query("SELECT * FROM tbl_jual_markup WHERE jual_nofak='$nofak' ORDER BY DATE(jual_tanggal) ASC");
		//$queryB = $this->db->query("SELECT d_jual_nofak, d_jual_barang_id, d_jual_barang_nama, d_jual_barang_satuan, d_jual_qty, d_jual_barang_harjul, d_jual_diskon, d_jual_total,jual_tanggal,jual_cust_nama,jual_bayar,jual_bayar_status,jual_total FROM tbl_jual join tbl_detail_jual ON jual_nofak=d_jual_nofak  WHERE d_jual_nofak='$nofak' ORDER BY d_jual_nofak DESC");
        $queryB = $this->db->query("SELECT d_jual_nofak, d_jual_barang_id, d_jual_barang_nama, d_jual_barang_satuan, d_jual_qty, d_jual_barang_harjul, d_jual_diskon, d_jual_total,jual_tanggal,jual_cust_nama,jual_bayar,jual_bayar_status,jual_total,jual_jml_uang,regions.reg_name,group_id,group_desc,group_sat FROM tbl_jual join tbl_detail_jual ON jual_nofak=d_jual_nofak JOIN regions ON tbl_jual.jual_reg_id=regions.reg_id WHERE d_jual_nofak='$nofak' ORDER BY d_jual_nofak DESC");
		$resultA = $queryA->result_array(); 
		$resultB = $queryB->result_array(); //banyak row Ambil hasil query sebagai array asosiatif
		return array('queryA' => $resultA, 'queryB' => $resultB);
    }

    function create_jual($nofak) {
        $resultA = $this->db->query("INSERT INTO tbl_jual_markup SELECT * FROM tbl_jual WHERE jual_nofak='$nofak'");
        $resultB = $this->db->query("INSERT INTO tbl_detail_jual_markup SELECT * FROM tbl_detail_jual WHERE d_jual_nofak='$nofak'");
        // Menggabungkan hasil A dan B untuk dikembalikan
        return array('resultA' => $resultA, 'resultB' => $resultB);
    }


    function get_markup($nofak) {
        $queryA = $this->db->query("SELECT * FROM tbl_jual_markup WHERE jual_nofak='$nofak'");
		$queryB = $this->db->query("SELECT d_jual_nofak, d_jual_barang_id, d_jual_barang_nama, d_jual_barang_satuan, d_jual_qty, d_jual_barang_harjul, d_jual_diskon, d_jual_total,jual_tanggal,jual_cust_nama,jual_bayar,jual_bayar_status,jual_total,group_id,group_desc,group_sat FROM tbl_jual_markup join tbl_detail_jual_markup ON jual_nofak=d_jual_nofak  WHERE d_jual_nofak='$nofak' ORDER BY d_jual_barang_id ASC");
		$resultA = $queryA->result_array(); 
		$resultB = $queryB->result_array(); //banyak row Ambil hasil query sebagai array asosiatif
		return array('queryA' => $resultA, 'queryB' => $resultB);
    }

    // function update_markup($nofak, $idbrg, $harjul, $diskon, $total, $qty) {
    //     // Perbarui tbl_detail_jual_markup
    //     $this->db->set('d_jual_barang_harjul', $harjul);
    //     $this->db->set('d_jual_diskon', $diskon);
    //     $this->db->set('d_jual_total', $total);
    //     $this->db->set('d_jual_qty', $qty);
    //     $this->db->where('d_jual_nofak', $nofak);
    //     $this->db->where('d_jual_barang_id', $idbrg);
    //     $this->db->update('tbl_detail_jual_markup');

    //     // Hitung total penjualan
    //     $query = $this->db->select_sum('d_jual_total')->where('d_jual_nofak', $nofak)->get('tbl_detail_jual_markup');
    //     $jualtotal = $query->num_rows() > 0 ? $query->row()->d_jual_total : 0;

    //     // Perbarui tbl_jual_markup dengan total penjualan yang baru dihitung
    //     $this->db->set('jual_total', $jualtotal);
    //     $this->db->where('jual_nofak', $nofak);
    //     $hsl = $this->db->update('tbl_jual_markup');

    //     return $hsl;
    // }

    function update_markup($nofak, $idbrg, $harjul, $diskon, $total, $qty, $groupid, $groupdesc, $groupsat) {
        // Perbarui tbl_detail_jual_markup
        $this->db->set('d_jual_barang_harjul', $harjul);
        $this->db->set('d_jual_diskon', $diskon);
        $this->db->set('d_jual_total', $total);
        $this->db->set('d_jual_qty', $qty);
        $this->db->where('d_jual_nofak', $nofak);
        $this->db->where('d_jual_barang_id', $idbrg);
        $this->db->update('tbl_detail_jual_markup');

        //update group_id
        if (!empty($groupid) && $groupid !== 'null') { 
            $this->db->set('group_desc', $groupdesc);
            $this->db->set('group_sat', $groupsat);
            $this->db->where('group_id', $groupid);
            $this->db->where('d_jual_nofak', $nofak);
            $this->db->update('tbl_detail_jual_markup');
        }

        //Ambil kembalian
        $queryA = $this->db->select('jual_jml_uang')->where('jual_nofak', $nofak)->get('tbl_jual_markup');
        $jmluang = $queryA->num_rows() > 0 ? $queryA->row()->jual_jml_uang : 0;

        // Hitung total penjualan
        $queryB = $this->db->select_sum('d_jual_total')->where('d_jual_nofak', $nofak)->get('tbl_detail_jual_markup');
        $jualtotal = $queryB->num_rows() > 0 ? $queryB->row()->d_jual_total : 0;

        $kembalian = floatval($jmluang - $jualtotal);
        $kurangbayar = floatval($jualtotal - $jmluang);
        // Perbarui tbl_jual_markup dengan total penjualan yang baru dihitung
        $this->db->set('jual_total', $jualtotal);
        $this->db->set('jual_kembalian', $kembalian);
        $this->db->set('jual_kurang_bayar', $kurangbayar);
        $this->db->where('jual_nofak', $nofak);
        $hsl = $this->db->update('tbl_jual_markup');

        return $hsl;
    }

    function save_bayar($nofak, $jmlbyr, $kembalian, $kurangbayar) {
        $this->db->set('jual_jml_uang', $jmlbyr);
        $this->db->set('jual_kembalian', $kembalian);
        $this->db->set('jual_kurang_bayar', $kurangbayar);
        $this->db->where('jual_nofak', $nofak);
        $hsl = $this->db->update('tbl_jual_markup');
        return $hsl;
    }

    function hapus_markup($nofak) {
        // Hapus dari tbl_jual_markup
        $this->db->where('jual_nofak', $nofak);
        $hslA = $this->db->delete('tbl_jual_markup');
        // Hapus dari tbl_detail_jual_markup
        $this->db->where('d_jual_nofak', $nofak);
        $hslB = $this->db->delete('tbl_detail_jual_markup');
        // Kembalikan hasil dari kedua operasi DELETE
        return array('hslA' => $hslA, 'hslB' => $hslB);
    }

    function cetak_faktur($nofak){
		$hsl=$this->db->query("SELECT jual_nofak,DATE_FORMAT(jual_tanggal,'%d/%m/%Y %H:%i:%s') AS jual_tanggal,jual_nota,jual_total,jual_jml_uang,jual_kembalian,jual_bayar,jual_kurang_bayar,d_jual_barang_id,d_jual_barang_nama,d_jual_barang_satuan,d_jual_barang_harjul,d_jual_qty,d_jual_diskon,d_jual_total,jual_cust_nama,group_id,group_desc,group_sat FROM tbl_jual_markup JOIN tbl_detail_jual_markup ON jual_nofak=d_jual_nofak WHERE jual_nofak='$nofak'");
		return $hsl;
	}


}
