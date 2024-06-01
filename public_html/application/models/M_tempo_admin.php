<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_tempo_admin extends CI_Model{

	function hapus_tempo($kode){
        $this->db->trans_start();
            $this->db->where('jual_nofak', $kode)->delete('tbl_jual');
            $this->db->where('d_jual_nofak', $kode)->delete('tbl_detail_jual');
            $this->db->where('bayar_nofak', $kode)->delete('tbl_bayar');
            $this->db->where('g_nofak', $kode)->delete('tbl_garansi');
            $this->db->where('stok_no', $kode)->delete('tbl_stok');
            $this->db->where('jual_nofak', $kode)->delete('tbl_jual_markup');
            $this->db->where('d_jual_nofak', $kode)->delete('tbl_detail_jual_markup');
        $this->db->trans_complete();
        return $this->db->trans_status();
	}

	function tampil_penjualan(){
		$coid=$this->session->userdata('coid');
		$hsl=$this->db->query("SELECT regions.reg_name, jual_nofak, jual_cust_nama, jual_nota, DATE_FORMAT(jual_tanggal,'%d/%m/%Y') AS jual_tanggal,jual_bulan_tempo,jual_total,jual_bayar_status FROM tbl_jual JOIN regions ON tbl_jual.jual_reg_id=regions.reg_id WHERE jual_bayar='Tempo' AND jual_co_id='$coid' ORDER BY DATE(jual_tanggal) DESC");
		return $hsl;
	}

    function tampil_customer_all(){
		$coid=$this->session->userdata('coid');
		$query = 'a.cust_id,a.cust_nama,a.cust_alamat,a.cust_notelp';
		$this->db->select($query);
		$this->db->from('tbl_customer a');
		$this->db->where('a.cust_co_id', $coid);
		$this->db->order_by('a.cust_id', 'ASC');
		$result = $this->db->get(); 
		return $result;
	}
    
	function tampil_customer($regid){
		$coid=$this->session->userdata('coid');
		$query = 'a.cust_id,a.cust_nama,a.cust_alamat,a.cust_notelp';
		$this->db->select($query);
		$this->db->from('tbl_customer a');
		$this->db->where('a.cust_co_id', $coid);
		$this->db->where('a.cust_reg_id', $regid);
		$this->db->order_by('a.cust_id', 'ASC');
		$result = $this->db->get()->result_array(); 
		return $result;
	}

    function tampil_periode(){
		$coid=$this->session->userdata('coid');
		$hsl=$this->db->query("SELECT p_val,p_nama FROM periode where p_coid='$coid'");
		return $hsl;
	}

	function get_tempo($nofak){
		$this->db->select("a.jual_reg_id, a.jual_nofak, a.jual_cust_id, a.jual_cust_nama, a.jual_nota,DATE_FORMAT(a.jual_tanggal,'%Y-%m-%d') AS jual_tanggal,a.jual_bulan_tempo,a.jual_total,a.jual_bayar_status");
        $this->db->from('tbl_jual a');
        //$this->db->join('regions b', 'b.reg_id = a.jual_reg_id', 'left');
        $this->db->where('a.jual_nofak', $nofak);
        //return $this->db->get();
        $result = $this->db->get()->result_array(); 
		return $result;
    }

	function update_tempo($regid, $nofak, $idcust, $nota, $tgljual, $prdbln, $jtot, $tgljtempo, $jhari) {
		try {
			$user_nama = $this->session->userdata('nama');
			$namacust = ($result = $this->db->where('cust_id', $idcust)->get('tbl_customer')->result()) ? $result[0]->cust_nama : "null";

			$this->db->trans_start(); // Mulai transaksi database

			// Update tabel tbl_jual
			$this->db->set('jual_reg_id', $regid);
			$this->db->set('jual_cust_id', $idcust);
			$this->db->set('jual_cust_nama', $namacust);
			$this->db->set('jual_nota', $nota);
			$this->db->set('jual_tanggal', $tgljual);
			$this->db->set('jual_bulan_tempo', $prdbln);
			$this->db->set('jual_total', $jtot);
			$this->db->set('jual_kurang_bayar', $jtot);
			$this->db->set('jual_tgl_tempo', $tgljtempo);
			$this->db->set('jual_hari_tempo', $jhari);
			$this->db->set('updated_by', $user_nama);
			$this->db->set('updated_at', 'NOW()', false);
			$this->db->where('jual_nofak', $nofak);
			$this->db->update('tbl_jual');

			// Update tabel tbl_detail_jual
			$this->db->set('d_jual_reg_id', $regid);
			$this->db->set('d_jual_tanggal', $tgljual);
			$this->db->set('d_jual_total', $jtot);
			$this->db->set('updated_by', $user_nama);
			$this->db->set('updated_at', 'NOW()', false);
			$this->db->where('d_jual_nofak', $nofak);
			$this->db->update('tbl_detail_jual');

			$this->db->trans_complete(); // Selesai transaksi database

			if ($this->db->trans_status() === FALSE) {
				throw new Exception("Transaksi database gagal.");
			}

			return true; // Jika transaksi berhasil
		} catch (Exception $e) {
			return false; // Jika terjadi kesalahan, kembalikan false
		}
	}


	function add_tempo($regid, $idcust, $nota, $tgljual, $prdbln, $jtot, $tgljtempo, $jhari) {
	try {
		$idadmin=$this->session->userdata('idadmin');
		$user_nama=$this->session->userdata('nama');
		$coid=$this->session->userdata('coid');
		$nofak=$this->get_nofak();
		$namacust = ($result = $this->db->where('cust_id', $idcust)->get('tbl_customer')->result()) ? $result[0]->cust_nama : "null";
			
			$this->db->trans_start(); // Mulai transaksi database
			//1. simpan ke tbl_jual
			$data_jual = array(
					'jual_nofak' => $nofak,
					'jual_tanggal' => $tgljual,
					'jual_nota' => $nota,
					'jual_total' => $jtot,
					'jual_user_id' => $idadmin,
					'jual_reg_id' => $regid,
					'jual_co_id' => $coid,
					'jual_bayar' => 'Tempo',
					'jual_bayar_status' => 'Belum Lunas',
					'jual_kurang_bayar' => $jtot,
					'jual_cust_id' => $idcust,
					'jual_cust_nama' => $namacust,
					'jual_tgl_tempo' => $tgljtempo,
					'jual_bulan_tempo' => $prdbln,
					'jual_hari_tempo' => $jhari,
					'created_by' => $user_nama,
					'created_at' => date('Y-m-d H:i:s')
			);
			$this->db->insert('tbl_jual', $data_jual);
			//2. simpan ke tbl_detail_jual
			$data_detail_jual=array(
					'd_jual_nofak' 			=>	$nofak,
					'd_jual_tanggal' 		=>  $tgljual,
					'd_jual_total'			=>	$jtot,
					'd_jual_user_id'		=>	$idadmin,
					'd_jual_reg_id'			=>	$regid,
					'd_jual_co_id'			=>	$coid,
					'created_by'			=>  $user_nama,
					'created_at'			=>	date('Y-m-d H:i:s')
				);
				$this->db->insert('tbl_detail_jual', $data_detail_jual);
		
				$this->db->trans_complete(); // Selesai transaksi database

				if ($this->db->trans_status() === FALSE) {
					throw new Exception("Transaksi database gagal.");
				}

				return true; // Jika transaksi berhasil
		} catch (Exception $e) {
			return false; // Jika terjadi kesalahan, kembalikan false
		}

	}


	function get_nofak(){
		$q = $this->db->query("SELECT MAX(RIGHT(jual_nofak,6)) AS kd_max FROM tbl_jual WHERE DATE(jual_tanggal)=CURDATE()");
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
		return "F".date('dmy').$kd;
	}


}