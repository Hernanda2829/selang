<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_laporan extends CI_Model{
	
	function get_data_barang() {
		$coid = $this->session->userdata('coid');
		$daftar_cabang = $this->db->where('reg_co_id', $coid)->get('regions')->result();
		$select_columns = 'k.kategori_id,k.kategori_nama,b.barang_id, b.barang_nama, b.barang_disc_id, b.barang_satuan, b.barang_harpok, b.barang_harjul';
		$select_columns .= ",
			IFNULL(
				SUM(CASE WHEN s.stok_coid = '" . $daftar_cabang[0]->reg_co_id . "' AND s.stok_in > 0 THEN s.stok_in ELSE 0 END) -
				SUM(CASE WHEN s.stok_coid = '" . $daftar_cabang[0]->reg_co_id . "' AND s.stok_out > 0 THEN s.stok_out ELSE 0 END), 0) 
			AS stok_global";

		//tambahkan perintah ini dibawah ini jika ingin mendapatkan hasil perkalian stok global dega harga pokok :
		// $select_columns .= ",
        // (stok_global * b.barang_harpok) AS Total_Harpok,
        // (stok_global * b.barang_harjul) AS Total_Harjul";	
		
		$this->db->select($select_columns);
		$this->db->from('tbl_kategori k');
		$this->db->join('tbl_barang b', 'k.kategori_id = b.barang_kategori_id', 'left');
		$this->db->join('tbl_stok s', 'b.barang_id = s.brg_id', 'left');
		$this->db->where('b.barang_co_id', $coid); // Tambahkan kondisi where pada tabel 'tbl_barang'
		$this->db->group_by('k.kategori_id,k.kategori_nama,b.barang_id, b.barang_nama, b.barang_disc_id, b.barang_satuan, b.barang_harpok, b.barang_harjul');
		return $this->db->get();
	}

	function get_data_barang_cab($reg_id) {
		$coid = $this->session->userdata('coid');
		$daftar_cabang = $this->db->where('reg_co_id', $coid)->get('regions')->result();
		$select_columns = 'k.kategori_id,k.kategori_nama,b.barang_id, b.barang_nama, b.barang_disc_id, b.barang_satuan, b.barang_harpok, b.barang_harjul';
		$select_columns .= ",
			IFNULL(
				SUM(CASE WHEN s.stok_regid = '".$reg_id."' AND s.stok_in > 0 THEN s.stok_in ELSE 0 END) -
				SUM(CASE WHEN s.stok_regid = '".$reg_id."' AND s.stok_out > 0 THEN s.stok_out ELSE 0 END), 0) 
			AS stok_cabang";
		$this->db->select($select_columns);
		$this->db->from('tbl_kategori k');
		$this->db->join('tbl_barang b', 'k.kategori_id = b.barang_kategori_id', 'left');
		$this->db->join('tbl_stok s', 'b.barang_id = s.brg_id', 'left');
		$this->db->where('b.barang_co_id', $coid); // Tambahkan kondisi where pada tabel 'tbl_barang'
		$this->db->group_by('k.kategori_id,k.kategori_nama,b.barang_id, b.barang_nama, b.barang_disc_id, b.barang_satuan, b.barang_harpok, b.barang_harjul');
		return $this->db->get();
	}
	
	function get_data_penjualan(){
		$coid=$this->session->userdata('coid');
		//DATE_FORMAT(jual_tanggal,'%d %M %Y') AS jual_tanggal
		$hsl=$this->db->query("SELECT jual_nofak,DATE_FORMAT(jual_tanggal,'%d %M %Y %H:%i:%s') AS jual_tanggal,jual_total,d_jual_barang_id,d_jual_barang_nama,d_jual_barang_satuan,d_jual_barang_harpok,d_jual_barang_harjul,d_jual_qty,d_jual_diskon,d_jual_total,tbl_detail_jual.created_by FROM tbl_jual JOIN tbl_detail_jual ON jual_nofak=d_jual_nofak where tbl_jual.jual_co_id='$coid' ORDER BY jual_nofak DESC");
		return $hsl;
	}
	function get_total_penjualan(){
		$coid=$this->session->userdata('coid');
		//$hsl=$this->db->query("SELECT SUM(jual_total) as total FROM tbl_jual where jual_co_id='$coid'");
		$hsl=$this->db->query("SELECT SUM(d_jual_total) AS total FROM tbl_jual JOIN tbl_detail_jual ON jual_nofak=d_jual_nofak WHERE tbl_jual.jual_co_id='$coid'");
		return $hsl;
	}
	function get_data_penjualankasir($regid){
		$hsl=$this->db->query("SELECT jual_nofak,DATE_FORMAT(jual_tanggal,'%d %M %Y %H:%i:%s') AS jual_tanggal,jual_total,d_jual_barang_id,d_jual_barang_nama,d_jual_barang_satuan,d_jual_barang_harpok,d_jual_barang_harjul,d_jual_qty,d_jual_diskon,d_jual_total,tbl_detail_jual.created_by FROM tbl_jual JOIN tbl_detail_jual ON jual_nofak=d_jual_nofak WHERE tbl_jual.jual_reg_id='$regid' ORDER BY jual_nofak DESC");
		return $hsl;
	}
	function get_total_penjualankasir($regid){
		//$hsl=$this->db->query("SELECT SUM(jual_total) as total FROM tbl_jual WHERE jual_reg_id='$regid'");
		$hsl=$this->db->query("SELECT SUM(d_jual_total) AS total FROM tbl_jual JOIN tbl_detail_jual ON jual_nofak=d_jual_nofak WHERE tbl_jual.jual_reg_id='$regid'");
		return $hsl;
	}
	function get_data_jual_pertanggal($tanggal){
		$coid=$this->session->userdata('coid');
		$hsl=$this->db->query("SELECT jual_nofak,DATE_FORMAT(jual_tanggal,'%d %M %Y %H:%i:%s') AS jual_tanggal,d_jual_barang_id,d_jual_barang_nama,d_jual_barang_satuan,d_jual_barang_harpok,d_jual_barang_harjul,d_jual_qty,d_jual_diskon,d_jual_total,tbl_detail_jual.created_by FROM tbl_jual JOIN tbl_detail_jual ON jual_nofak=d_jual_nofak WHERE DATE(jual_tanggal)='$tanggal' AND tbl_jual.jual_co_id='$coid' ORDER BY jual_nofak DESC");
		return $hsl;
	}
	function get_data_total_jual_pertanggal($tanggal){
		$coid=$this->session->userdata('coid');
		$hsl=$this->db->query("SELECT DATE_FORMAT(jual_tanggal,'%d %M %Y') AS jual_tanggal,SUM(d_jual_total) AS total FROM tbl_jual JOIN tbl_detail_jual ON jual_nofak=d_jual_nofak WHERE DATE(jual_tanggal)='$tanggal' AND tbl_jual.jual_co_id='$coid'");
		return $hsl;
	}
	function get_data_jual_pertanggalkasir($tanggal,$regid){
		$hsl=$this->db->query("SELECT jual_nofak,DATE_FORMAT(jual_tanggal,'%d %M %Y %H:%i:%s') AS jual_tanggal,d_jual_barang_id,d_jual_barang_nama,d_jual_barang_satuan,d_jual_barang_harpok,d_jual_barang_harjul,d_jual_qty,d_jual_diskon,d_jual_total,tbl_detail_jual.created_by FROM tbl_jual JOIN tbl_detail_jual ON jual_nofak=d_jual_nofak WHERE DATE(jual_tanggal)='$tanggal' AND tbl_jual.jual_reg_id='$regid' ORDER BY jual_nofak DESC");
		return $hsl;
	}
	function get_data_total_jual_pertanggalkasir($tanggal,$regid){
		$hsl=$this->db->query("SELECT DATE_FORMAT(jual_tanggal,'%d %M %Y') AS jual_tanggal,SUM(d_jual_total) AS total FROM tbl_jual JOIN tbl_detail_jual ON jual_nofak=d_jual_nofak WHERE DATE(jual_tanggal)='$tanggal' AND tbl_jual.jual_reg_id='$regid'");
		return $hsl;
	}
	function get_bulan_jual(){
		$coid=$this->session->userdata('coid');
		$hsl=$this->db->query("SELECT DISTINCT DATE_FORMAT(jual_tanggal,'%M %Y') AS bulan FROM tbl_jual WHERE jual_co_id='$coid' ORDER BY DATE_FORMAT(jual_tanggal, '%Y-%m') DESC");
		return $hsl;
	}
	function get_tahun_jual(){
		$coid=$this->session->userdata('coid');
		$hsl=$this->db->query("SELECT DISTINCT YEAR(jual_tanggal) AS tahun FROM tbl_jual WHERE jual_co_id='$coid'");
		return $hsl;
	}
	function get_jual_perbulan($bulan){
		$coid=$this->session->userdata('coid');
		$hsl=$this->db->query("SELECT jual_nofak,DATE_FORMAT(jual_tanggal,'%M %Y') AS bulan,DATE_FORMAT(jual_tanggal,'%d %M %Y') AS jual_tanggal,d_jual_barang_id,d_jual_barang_nama,d_jual_barang_satuan,d_jual_barang_harpok,d_jual_barang_harjul,d_jual_qty,d_jual_diskon,d_jual_total,tbl_jual.created_by FROM tbl_jual JOIN tbl_detail_jual ON jual_nofak=d_jual_nofak WHERE DATE_FORMAT(jual_tanggal,'%M %Y')='$bulan' AND tbl_jual.jual_co_id='$coid' ORDER BY jual_nofak DESC");
		return $hsl;
	}
	function get_total_jual_perbulan($bulan){
		$coid=$this->session->userdata('coid');
		$hsl=$this->db->query("SELECT DATE_FORMAT(jual_tanggal,'%M %Y') AS bulan,SUM(d_jual_total) AS total FROM tbl_jual JOIN tbl_detail_jual ON jual_nofak=d_jual_nofak WHERE DATE_FORMAT(jual_tanggal,'%M %Y')='$bulan' AND tbl_jual.jual_co_id='$coid'");
		return $hsl;
	}
	function get_jual_perbulankasir($bulan,$regid){
		$hsl=$this->db->query("SELECT jual_nofak,DATE_FORMAT(jual_tanggal,'%M %Y') AS bulan,DATE_FORMAT(jual_tanggal,'%d %M %Y') AS jual_tanggal,d_jual_barang_id,d_jual_barang_nama,d_jual_barang_satuan,d_jual_barang_harpok,d_jual_barang_harjul,d_jual_qty,d_jual_diskon,d_jual_total,tbl_jual.created_by FROM tbl_jual JOIN tbl_detail_jual ON jual_nofak=d_jual_nofak WHERE DATE_FORMAT(jual_tanggal,'%M %Y')='$bulan' AND tbl_jual.jual_reg_id='$regid' ORDER BY jual_nofak DESC");
		return $hsl;
	}
	function get_total_jual_perbulankasir($bulan,$regid){
		$hsl=$this->db->query("SELECT DATE_FORMAT(jual_tanggal,'%M %Y') AS bulan,SUM(d_jual_total) AS total FROM tbl_jual JOIN tbl_detail_jual ON jual_nofak=d_jual_nofak WHERE DATE_FORMAT(jual_tanggal,'%M %Y')='$bulan' AND tbl_jual.jual_reg_id='$regid'");
		return $hsl;
	}
	function get_jual_pertahun($tahun){
		$coid=$this->session->userdata('coid');
		$hsl=$this->db->query("SELECT jual_nofak,YEAR(jual_tanggal) AS tahun,DATE_FORMAT(jual_tanggal,'%M %Y') AS bulan,DATE_FORMAT(jual_tanggal,'%d %M %Y') AS jual_tanggal,d_jual_barang_id,d_jual_barang_nama,d_jual_barang_satuan,d_jual_barang_harpok,d_jual_barang_harjul,d_jual_qty,d_jual_diskon,d_jual_total,tbl_jual.created_by FROM tbl_jual JOIN tbl_detail_jual ON jual_nofak=d_jual_nofak WHERE YEAR(jual_tanggal)='$tahun' AND tbl_jual.jual_co_id='$coid' ORDER BY jual_nofak DESC");
		return $hsl;
	}
	function get_total_jual_pertahun($tahun){
		$coid=$this->session->userdata('coid');
		$hsl=$this->db->query("SELECT YEAR(jual_tanggal) AS tahun,SUM(d_jual_total) AS total FROM tbl_jual JOIN tbl_detail_jual ON jual_nofak=d_jual_nofak WHERE YEAR(jual_tanggal)='$tahun' AND tbl_jual.jual_co_id='$coid'");
		return $hsl;
	}
	function get_jual_pertahunkasir($tahun,$regid){
		$hsl=$this->db->query("SELECT jual_nofak,YEAR(jual_tanggal) AS tahun,DATE_FORMAT(jual_tanggal,'%M %Y') AS bulan,DATE_FORMAT(jual_tanggal,'%d %M %Y') AS jual_tanggal,d_jual_barang_id,d_jual_barang_nama,d_jual_barang_satuan,d_jual_barang_harpok,d_jual_barang_harjul,d_jual_qty,d_jual_diskon,d_jual_total,tbl_jual.created_by FROM tbl_jual JOIN tbl_detail_jual ON jual_nofak=d_jual_nofak WHERE YEAR(jual_tanggal)='$tahun' AND tbl_jual.jual_reg_id='$regid' ORDER BY jual_nofak DESC");
		return $hsl;
	}
	function get_total_jual_pertahunkasir($tahun,$regid){
		$hsl=$this->db->query("SELECT YEAR(jual_tanggal) AS tahun,SUM(d_jual_total) AS total FROM tbl_jual JOIN tbl_detail_jual ON jual_nofak=d_jual_nofak WHERE YEAR(jual_tanggal)='$tahun' AND tbl_jual.jual_reg_id='$regid'");
		return $hsl;
	}
	//=========Laporan Laba rugi============
	function get_lap_laba_rugi($bulan){
		$coid=$this->session->userdata('coid');
		$hsl=$this->db->query("SELECT DATE_FORMAT(jual_tanggal,'%d %M %Y %H:%i:%s') as jual_tanggal,d_jual_barang_nama,d_jual_barang_satuan,d_jual_barang_harpok,d_jual_barang_harjul,(d_jual_barang_harjul-d_jual_barang_harpok) AS keunt,d_jual_qty,d_jual_diskon,((d_jual_barang_harjul-d_jual_barang_harpok)*d_jual_qty)-(d_jual_diskon) AS untung_bersih,tbl_jual.created_by FROM tbl_jual JOIN tbl_detail_jual ON jual_nofak=d_jual_nofak WHERE DATE_FORMAT(jual_tanggal,'%M %Y')='$bulan' AND tbl_jual.jual_co_id='$coid'");
		return $hsl;
	}
	function get_total_lap_laba_rugi($bulan){
		$coid=$this->session->userdata('coid');
		$hsl=$this->db->query("SELECT DATE_FORMAT(jual_tanggal,'%M %Y') AS bulan,SUM(((d_jual_barang_harjul-d_jual_barang_harpok)*d_jual_qty)-(d_jual_diskon)) AS total FROM tbl_jual JOIN tbl_detail_jual ON jual_nofak=d_jual_nofak WHERE DATE_FORMAT(jual_tanggal,'%M %Y')='$bulan' AND tbl_jual.jual_co_id='$coid'");
		return $hsl;
	}
	function get_lap_laba_rugikasir($bulan,$regid){
		$hsl=$this->db->query("SELECT DATE_FORMAT(jual_tanggal,'%d %M %Y %H:%i:%s') as jual_tanggal,d_jual_barang_nama,d_jual_barang_satuan,d_jual_barang_harpok,d_jual_barang_harjul,(d_jual_barang_harjul-d_jual_barang_harpok) AS keunt,d_jual_qty,d_jual_diskon,((d_jual_barang_harjul-d_jual_barang_harpok)*d_jual_qty)-(d_jual_diskon) AS untung_bersih,tbl_jual.created_by FROM tbl_jual JOIN tbl_detail_jual ON jual_nofak=d_jual_nofak WHERE DATE_FORMAT(jual_tanggal,'%M %Y')='$bulan' AND tbl_jual.jual_reg_id='$regid'");
		return $hsl;
	}
	function get_total_lap_laba_rugikasir($bulan,$regid){
		$hsl=$this->db->query("SELECT DATE_FORMAT(jual_tanggal,'%M %Y') AS bulan, SUM(((d_jual_barang_harjul-d_jual_barang_harpok)*d_jual_qty)-(d_jual_diskon)) AS total FROM tbl_jual JOIN tbl_detail_jual ON jual_nofak=d_jual_nofak WHERE DATE_FORMAT(jual_tanggal,'%M %Y')='$bulan' AND tbl_jual.jual_reg_id='$regid'");
		return $hsl;
	}
}