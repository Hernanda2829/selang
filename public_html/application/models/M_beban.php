<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_beban extends CI_Model{

	// function tampil_beban(){
	// 	$coid=$this->session->userdata('coid');
	// 	$hsl=$this->db->query("SELECT beban_id,beban_no,DATE_FORMAT(beban_tanggal,'%Y-%m-%d') as beban_tanggal,DATE_FORMAT(beban_tanggal,'%d %M %Y %H:%i:%s') as beban_tanggal2,beban_nama,beban_jumlah,beban_kat_id,beban_kat_nama,beban_reg_id,regions.reg_name,tbl_beban_opr.created_by FROM tbl_beban_opr JOIN regions ON tbl_beban_opr.beban_reg_id=regions.reg_id where beban_co_id='$coid' order by beban_id desc");
	// 	return $hsl;
	// }

	function tampil_beban($firstDay, $lastDay) {
		$coid=$this->session->userdata('coid');
		$this->db->select("a.beban_id,a.beban_no,DATE_FORMAT(a.beban_tanggal,'%Y-%m-%d') as beban_tanggal,DATE_FORMAT(a.beban_tanggal,'%d %M %Y %H:%i:%s') as beban_tanggal2,a.beban_nama,a.beban_jumlah,a.beban_kat_id,a.beban_kat_nama,a.beban_reg_id,a.created_by,b.reg_name");
		$this->db->from('tbl_beban_opr a');
		$this->db->join('regions b', 'b.reg_id = a.beban_reg_id', 'left');
		$this->db->where('DATE(a.beban_tanggal) >=', $firstDay);
        $this->db->where('DATE(a.beban_tanggal) <=', $lastDay);
		$this->db->where('a.beban_co_id', $coid);
		$this->db->order_by('DATE(a.beban_tanggal)', 'DESC');
        $result = $this->db->get()->result_array();
        return $result;
    }

	function tampil_rekening(){
		$coid=$this->session->userdata('coid');
		$hsl=$this->db->query("SELECT rek_norek,rek_nama,rek_bank FROM tbl_rekening where rek_coid='$coid'");
		return $hsl;
	}

	function simpan_transaksi($rek,$tgl,$nama,$jml,$regid,$nobeb) {
		$userid = $this->session->userdata('idadmin');
		$usernama = $this->session->userdata('nama');
		$coid = $this->session->userdata('coid');
		$data = array(
			'bank_norek'    => $rek,
			'bank_tanggal'  => $tgl,
			'mutasi'        => 'Kredit',
			'bank_ket'      => $nama,
			'bank_jumlah'   => $jml,
			'debit'         => 0,
			'kredit'        => $jml,
			'bank_cabang'   => $regid,
			'ket'           => 'Transfer',
			'bank_no'       => $nobeb,
			'bank_user_id'  => $userid,
			'bank_reg_id'   => 1, //kode pusat
			'bank_co_id'    => $coid,
			'created_by'    => $usernama,
			'created_at'    => date('Y-m-d H:i:s')  
		);
		$this->db->insert('tbl_bank', $data);
		// Mengembalikan nilai keberhasilan, jika diperlukan
		//return $this->db->affected_rows() > 0;
	}

	function tampil_kat_beban(){
		$coid=$this->session->userdata('coid');
		$hsl=$this->db->query("SELECT kat_id,kat_nama FROM tbl_beban_kat where kat_co_id='$coid'");
		return $hsl;
	}

	function hapus_beban($kode,$nobeb){
		$hsl=$this->db->query("DELETE FROM tbl_beban_opr where beban_id='$kode'");
		$hsl=$this->db->query("DELETE FROM tbl_bank where bank_no='$nobeb'");
		return $hsl;
	}

	
	function tampil_bebankasir($regid){
		$hsl=$this->db->query("SELECT beban_id,DATE_FORMAT(beban_tanggal,'%d %M %Y %H:%i:%s') as beban_tanggal,beban_nama,beban_jumlah,beban_kat_id,beban_kat_nama,beban_user_id,created_by FROM tbl_beban_opr WHERE beban_reg_id='$regid'order by beban_id desc");
		return $hsl;
	}

	function simpan_beban($nama,$jml,$katid,$tgl,$regid,$nobeb) {
		$idadmin = $this->session->userdata('idadmin');
		$user_nama = $this->session->userdata('nama');
		$coid = $this->session->userdata('coid');
		$katnama = ($result = $this->db->where('kat_id', $katid)->get('tbl_beban_kat')->result()) ? $result[0]->kat_nama : "null";
		$data = array(
			'beban_no' => $nobeb,
			'beban_tanggal' => $tgl,
			'beban_nama' => $nama,
			'beban_jumlah' => $jml,
			'beban_kat_id' => $katid,
			'beban_kat_nama' => $katnama,
			'beban_user_id' => $idadmin,
			'beban_reg_id' => $regid,
			'beban_co_id' => $coid,
			'created_by' => $user_nama,
			'created_at' => date('Y-m-d H:i:s')
		);

		$hsl = $this->db->insert('tbl_beban_opr', $data);
		return $hsl;
	}

	function update_beban($kode,$nama,$jml,$katid,$tgl,$regid) {
		$user_nama=$this->session->userdata('nama');
		$katnama = ($result = $this->db->where('kat_id', $katid)->get('tbl_beban_kat')->result()) ? $result[0]->kat_nama : "null";
		// $hsl=$this->db->query("UPDATE tbl_beban_opr set beban_nama='$nama',beban_jumlah='$jml',updated_by='$user_nama',updated_at=now() where beban_id='$kode'");
		// return $hsl;
		$this->db->set('beban_nama', $nama);
		$this->db->set('beban_jumlah', $jml);
		$this->db->set('beban_kat_id', $katid);
		$this->db->set('beban_kat_nama', $katnama);
		$this->db->set('beban_tanggal', $tgl);
		$this->db->set('beban_reg_id', $regid);
		$this->db->set('updated_by', $user_nama);
		$this->db->set('updated_at', 'NOW()', false);
		$this->db->where('beban_id', $kode);
		$hsl = $this->db->update('tbl_beban_opr');
		return $hsl;
	}

	function update_bank($nobeb,$nama,$jml,$tgl,$regid,$rek) {
		$user_nama=$this->session->userdata('nama');
		$this->db->set('bank_norek', $rek);
		$this->db->set('bank_tanggal', $tgl);
		$this->db->set('bank_ket', $nama);
		$this->db->set('bank_jumlah', $jml);
		$this->db->set('kredit', $jml);
		$this->db->set('bank_cabang', $regid);
		$this->db->set('updated_by', $user_nama);
		$this->db->set('updated_at', 'NOW()', false);
		$this->db->where('bank_no', $nobeb);
		$hsl = $this->db->update('tbl_bank');
		return $hsl;
	}


	function get_beban_no(){
		$q = $this->db->query("SELECT MAX(RIGHT(beban_no,6)) AS kd_max FROM tbl_beban_opr WHERE DATE(beban_tanggal)=CURDATE()");
        $kd = "";
        if($q->num_rows()>0){
            foreach($q->result() as $k){
                $tmp = ((int)$k->kd_max)+1;
                $kd = sprintf("%06s", $tmp);
            }
        }else{
            $kd = "000001";
        }
        //return date('dmy').$kd;
		return "BB".date('dmy').$kd;
	}
	

	function find_bank($bebno){
		$this->db->select('bank_norek');
		$this->db->from('tbl_bank');
		$this->db->where('bank_no', $bebno);
		return $this->db->get();
	}

	function hapus_bank($nobeb){
		$hsl=$this->db->query("DELETE FROM tbl_bank where bank_no='$nobeb'");
		return $hsl;
	}
	

	function get_beban($idbeb) {
		$this->db->select("a.beban_id, a.beban_no, DATE_FORMAT(a.beban_tanggal,'%Y-%m-%d') as beban_tanggal, a.beban_nama, a.beban_jumlah, a.beban_kat_id, a.beban_reg_id, b.bank_norek");
		$this->db->from('tbl_beban_opr a');
		$this->db->join('tbl_bank b', 'b.bank_no = a.beban_no', 'left');
		$this->db->where('a.beban_id', $idbeb);
		$result = $this->db->get()->result_array(); 
		return $result;
	}


}