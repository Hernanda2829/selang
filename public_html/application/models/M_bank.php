<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_bank extends CI_Model{

	function tampil_rekening(){
		$coid=$this->session->userdata('coid');
		$hsl=$this->db->query("SELECT rek_id,rek_norek,rek_nama,rek_bank,rek_logo FROM tbl_rekening where rek_coid='$coid' order by rek_id ASC");
		return $hsl;
	}

	function get_rekening($rekid){
    $hsl = $this->db->query("SELECT rek_id, rek_norek, rek_nama, rek_bank, rek_logo FROM tbl_rekening WHERE rek_id='$rekid'");
    return $hsl->row_array();
	}

	function tampil_transaksi($norek){
		// $hsl=$this->db->query("SELECT bank_id,DATE_FORMAT(bank_tanggal,'%d/%m/%Y') as bank_tanggal,bank_ket,debit,kredit FROM tbl_bank where bank_norek='$norek' order by bank_tanggal desc");
		// $result = $hsl->result_array();
    	// return $result;
		//$queryA=$this->db->query("SELECT bank_id,bank_norek,DATE_FORMAT(bank_tanggal,'%Y/%m/%d') as bank_tanggal,bank_ket,debit,kredit FROM tbl_bank where bank_norek='$norek' ORDER BY bank_tanggal DESC");
		$queryA=$this->db->query("SELECT bank_id,bank_norek,DATE_FORMAT(bank_tanggal,'%d/%m/%Y') as bank_tanggal,bank_ket,debit,kredit FROM tbl_bank where bank_norek='$norek' ORDER BY DATE(bank_tanggal) DESC");
		//$queryB = $this->db->query("SELECT COALESCE(SUM(kredit), 0) - COALESCE(SUM(debit), 0) AS current_saldo FROM tbl_bank WHERE bank_norek='$norek'");
		//$queryB=$this->db->query("SELECT (SUM(kredit)-SUM(debit)) AS current_saldo FROM tbl_bank where bank_norek='$norek'");

		$queryB = $this->db->query("SELECT IFNULL(SUM(kredit), 0) - IFNULL(SUM(debit), 0) AS current_saldo FROM tbl_bank WHERE bank_norek='$norek'");
		$resultA = $queryA->result_array();	//banyak row Ambil hasil query sebagai array asosiatif
		$resultB = $queryB->row_array();	//1 row 
		//$resultB = $queryB->result_array(); 
		return array('queryA' => $resultA, 'queryB' => $resultB);
		
	}

	function history_saldo($norek, $tgl1, $tgl2) {
    // $query = "SELECT bank_id, DATE_FORMAT(bank_tanggal, '%d/%m/%Y') as bank_tanggal, bank_ket, debit, kredit 
    //           FROM tbl_bank 
    //           WHERE bank_norek = ? 
    //             AND bank_tanggal >= ? 
    //             AND bank_tanggal <= ? 
    //           ORDER BY bank_tanggal DESC";
    // $hsl = $this->db->query($query, array($norek, $tgl1, $tgl2));
    // $result = $hsl->result_array();
    // return $result;
	
	// $query = "SELECT bank_id, DATE_FORMAT(bank_tanggal, '%d/%m/%Y') as bank_tanggal, bank_ket, debit, kredit 
    //           FROM tbl_bank 
    //           WHERE bank_norek = ? 
    //             AND bank_tanggal >= ? 
    //             AND bank_tanggal <= ? 
    //           ORDER BY DATE(bank_tanggal) ASC";
	//$queryA = $this->db->query($query, array($norek, $tgl1, $tgl2));

	$query = "a.bank_id, DATE_FORMAT(a.bank_tanggal, '%d/%m/%Y') as bank_tanggal, a.bank_ket, a.debit, a.kredit";
	$this->db->select($query);
	$this->db->from('tbl_bank a');
	$this->db->where('a.bank_norek', $norek);
	$this->db->where('DATE(a.bank_tanggal) >=', $tgl1);
	$this->db->where('DATE(a.bank_tanggal) <=', $tgl2);
	$this->db->order_by('DATE(a.bank_tanggal)', 'ASC');
	$queryA = $this->db->get(); 
    
	$queryB = $this->db->query("SELECT IFNULL(SUM(kredit), 0) - IFNULL(SUM(debit), 0) AS current_saldo FROM tbl_bank WHERE bank_norek='$norek' AND bank_tanggal < '$tgl1'");
    $resultA = $queryA->result_array();
	$resultB = $queryB->row_array();
	return array('queryA' => $resultA, 'queryB' => $resultB);

	}


	function hapus_transaksi($kode){
	 	$hsl=$this->db->query("DELETE FROM tbl_bank where bank_id='$kode'");
	 	return $hsl;
	}

	// function update_transaksi($kode,$nama,$jml){
	// 	$user_nama=$this->session->userdata('nama');
	// 	$hsl=$this->db->query("UPDATE tbl_bank set bank_ket='$nama',bank_jumlah='$jml',updated_by='$user_nama',updated_at=now() where bank_id='$kode'");
	// 	return $hsl;
	// }

	//function simpan_transaksi($norek,$tgltrans,$mutasi,$ket,$jml,$debit,$kredit,$cabang,$ket2) {
	function simpan_transaksi($norek,$tgltrans,$mutasi,$ket,$jml,$debit,$kredit) {
		$userid = $this->session->userdata('idadmin');
		$usernama = $this->session->userdata('nama');
		$coid = $this->session->userdata('coid');
		$regid = $this->session->userdata('regid');
		$data = array(
			'bank_norek'    => $norek,
			'bank_tanggal'  => $tgltrans,
			'mutasi'        => $mutasi,
			'bank_ket'      => $ket,
			'bank_jumlah'   => $jml,
			'debit'         => $debit,
			'kredit'        => $kredit,
			//'bank_cabang'   => $cabang,
			//'ket'           => $ket2,
			'bank_user_id'  => $userid,
			'bank_reg_id'   => $regid,
			'bank_co_id'    => $coid,
			'created_by'    => $usernama,
			'created_at'    => date('Y-m-d H:i:s')  
		);
		// Memasukkan data ke dalam tabel 'tbl_bank'
		$this->db->insert('tbl_bank', $data);
		// Mengembalikan nilai keberhasilan, jika diperlukan
		return $this->db->affected_rows() > 0;
	}




	function simpan_rekening($norek,$nmrek,$nmbank,$logobank) {
		$usernama = $this->session->userdata('nama');
		$coid = $this->session->userdata('coid');
		$data = array(
			'rek_norek'   	=> $norek,
			'rek_nama'  	=> $nmrek,
			'rek_bank'      => $nmbank,
			'rek_logo'      => $logobank,
			'rek_coid'  	=> $coid,
			'created_by'    => $usernama,
			'created_at'    => date('Y-m-d H:i:s')  
		);
		// Memasukkan data ke dalam tabel 'tbl_bank'
		$this->db->insert('tbl_rekening', $data);
		// Mengembalikan nilai keberhasilan, jika diperlukan
		return $this->db->affected_rows() > 0;
	}

	function update_rekening($rekid, $norek, $nmrek, $nmbank, $logobank) {
		$usernama = $this->session->userdata('nama');
		$this->db->set('rek_norek', $norek);
		$this->db->set('rek_nama', $nmrek);
		$this->db->set('rek_bank', $nmbank);
		$this->db->set('rek_logo', $logobank);
		$this->db->set('updated_by', $usernama);
		$this->db->set('updated_at', 'NOW()', false);
		$this->db->where('rek_id', $rekid);
		$this->db->update('tbl_rekening');
	}
	//update rek tanpa logo
	function update_rek($rekid, $norek, $nmrek, $nmbank) {
		$usernama = $this->session->userdata('nama');
		$this->db->set('rek_norek', $norek);
		$this->db->set('rek_nama', $nmrek);
		$this->db->set('rek_bank', $nmbank);
		$this->db->set('updated_by', $usernama);
		$this->db->set('updated_at', 'NOW()', false);
		$this->db->where('rek_id', $rekid);
		$this->db->update('tbl_rekening');
	}

	function cek_norek($norek) {
		$query = $this->db->query("SELECT rek_norek FROM tbl_rekening WHERE rek_norek='$norek'");
		return $query->num_rows();
	}

	function hapus_rekening($rekid){
        $hsl=$this->db->query("DELETE FROM tbl_rekening where rek_id='$rekid'");
		return $hsl;
	}


}