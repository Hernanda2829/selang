<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_retur extends CI_Model{

	function get_retur($firstDay, $lastDay) {
		$coid=$this->session->userdata('coid');
		$this->db->select("a.retur_id,DATE_FORMAT(a.retur_tgl,'%d/%m/%Y') AS retur_tgl,a.retur_brg_id,a.retur_brg_nama,a.retur_brg_sat,a.retur_brg_kat,a.retur_harpok,a.retur_qty,(a.retur_harpok*a.retur_qty) AS retur_subtotal,a.retur_keterangan,b.reg_name");
		$this->db->from('tbl_retur a');
		$this->db->join('regions b', 'b.reg_id = a.retur_regid', 'left');
		$this->db->where('DATE(a.retur_tgl) >=', $firstDay);
        $this->db->where('DATE(a.retur_tgl) <=', $lastDay);
		$this->db->where('a.retur_coid', $coid);
		$this->db->order_by('DATE(a.retur_tgl)', 'DESC');
        $result = $this->db->get()->result_array(); 
        return $result;
    }

	function get_retur_kasir($firstDay, $lastDay) {
		$coid=$this->session->userdata('coid');
		$regid=$this->session->userdata('regid');
		$this->db->select("a.retur_id,DATE_FORMAT(a.retur_tgl,'%d/%m/%Y') AS retur_tgl,a.retur_brg_id,a.retur_brg_nama,a.retur_brg_sat,a.retur_brg_kat,a.retur_harjul,a.retur_qty,(a.retur_harjul*a.retur_qty) AS retur_subtotal,a.retur_keterangan,b.reg_name");
		$this->db->from('tbl_retur a');
		$this->db->join('regions b', 'b.reg_id = a.retur_regid', 'left');
		$this->db->where('DATE(a.retur_tgl) >=', $firstDay);
        $this->db->where('DATE(a.retur_tgl) <=', $lastDay);
		$this->db->where('a.retur_coid', $coid);
		$this->db->where('a.retur_regid', $regid);
		$this->db->order_by('DATE(a.retur_tgl)', 'DESC');
        $result = $this->db->get()->result_array(); 
        return $result;
    }

	function hapus_retur($kode){
		//$hsl=$this->db->query("DELETE FROM tbl_retur WHERE retur_id='$kode'");
		//$hsl=$this->db->query("DELETE FROM tbl_stok WHERE stok_no='$kode'" AND stok_ket='Retur');
		//return $hsl;	
		$this->db->trans_start();
            $this->db->where('retur_id', $kode)->delete('tbl_retur');
            $this->db->where('stok_no', $kode)->where('stok_ket', 'Retur')->delete('tbl_stok');
        $this->db->trans_complete();
        return $this->db->trans_status();
	}

	function tampil_retur(){
		$hsl=$this->db->query("SELECT retur_id,DATE_FORMAT(retur_tgl,'%d/%m/%Y') AS retur_tgl,retur_brg_id,retur_brg_nama,retur_brg_sat,retur_harpok,retur_qty,(retur_harpok*retur_qty) AS retur_subtotal,retur_keterangan,regions.reg_name FROM tbl_retur JOIN regions ON tbl_retur.retur_regid=regions.reg_id  ORDER BY DATE(retur_tgl) DESC");
		return $hsl;
	}

	function tampil_retur_kasir(){
		$coid=$this->session->userdata('coid');
		$regid=$this->session->userdata('regid');
		$this->db->select("a.retur_id,DATE_FORMAT(a.retur_tgl,'%d/%m/%Y') AS retur_tgl,a.retur_brg_id,a.retur_brg_nama,a.retur_brg_sat,a.retur_harjul,a.retur_qty,(a.retur_harjul*a.retur_qty) AS retur_subtotal,a.retur_keterangan");
		$this->db->from('tbl_retur a');
		$this->db->where('a.retur_coid', $coid);
		$this->db->where('a.retur_regid', $regid);
		$this->db->order_by('DATE(a.retur_tgl)', 'DESC');
        //$result = $this->db->get()->result_array();
		$result = $this->db->get();
        return $result;
	}

	function simpan_retur($returid,$tgltrans,$nofak,$regid,$idbrg,$nmbrg,$satbrg,$katbrg,$harpokbrg,$harjulbrg,$qtyret,$ket){
		$coid=$this->session->userdata('coid');
		$idadmin=$this->session->userdata('idadmin');
		$user_nama=$this->session->userdata('nama');
		
		$this->db->trans_start(); // Memulai transaksi
		try {
			//1. simpan ke tbl_retur
			$data = array(
				'retur_id' 				=> $returid,
				'retur_tgl_trans' 		=> $tgltrans,
				'retur_no' 				=> $nofak,
				'retur_tgl' 			=> date('Y-m-d H:i:s'),
				'retur_brg_id' 			=> $idbrg,
				'retur_brg_nama' 		=> $nmbrg,
				'retur_brg_sat' 		=> $satbrg,
				'retur_brg_kat' 		=> $katbrg,
				'retur_harpok' 			=> $harpokbrg,
				'retur_harjul' 			=> $harjulbrg,
				'retur_qty' 			=> $qtyret,
				'retur_total_harpok' 	=> $harpokbrg * $qtyret,
				'retur_keterangan' 		=> $ket,
				'retur_user_id' 		=> $idadmin,
				'retur_regid' 			=> $regid,
				'retur_coid' 			=> $coid,
				'created_by' 			=> $user_nama,
				'created_at' 			=> date('Y-m-d H:i:s')
			);
			$this->db->insert('tbl_retur', $data);	

			//2. simpan ke tbl_stok
			$stok_out=array(
				'stok_no' 		=>	$returid,
				'stok_ket'		=>	'Retur',
				'stok_status'	=>	'out',
				'stok_tgl'		=>	date('Y-m-d H:i:s'),
				'brg_id'		=>	$idbrg,
				'brg_nama'		=>	$nmbrg,
				'brg_sat'		=>	$satbrg,
				'brg_kat'		=>	$katbrg,
				'stok_in'		=>	0,
				'stok_out'		=>	$qtyret,
				'stok_user_id'  =>  $idadmin,
				'stok_regid'	=>	$regid,
				'stok_coid'		=>	$coid,
				'created_by'	=>  $user_nama,
				'created_at'	=>	date('Y-m-d H:i:s')
			);
			$this->db->insert('tbl_stok',$stok_out);

			$this->db->trans_complete(); // Menyelesaikan transaksi
			// Check apakah transaksi berhasil atau tidak
			if ($this->db->trans_status() === FALSE) {
				// Transaksi gagal, lakukan sesuatu seperti logging atau memberikan pesan kesalahan
				log_message('error', 'Transaksi gagal');
				return false;
			} else {
				// Transaksi berhasil
				return true;
			}

		} catch (Exception $e) {
			// Tangkap exception jika ada kesalahan
			$this->db->trans_rollback(); // Rollback transaksi
			log_message('error', 'Exception: ' . $e->getMessage());
			return false;
		}
	}

	function tampil_barang(){
		$coid=$this->session->userdata('coid');
		$select_columns = 'b.barang_id, b.barang_nama, b.barang_satuan, b.barang_harpok, b.barang_harjul, b.barang_kategori_nama';
		$this->db->select($select_columns);
		$this->db->from('tbl_barang b');
		$this->db->where('b.barang_co_id', $coid); // Tambahkan kondisi where pada tabel 'tbl_barang'
		//$this->db->order_by('b.barang_id', 'ASC');
		return $this->db->get();
	}

	function tampil_barang_kasir(){
		$coid=$this->session->userdata('coid');
		$regid=$this->session->userdata('regid');
		$select_columns = 'b.barang_id, b.barang_nama, b.barang_satuan, b.barang_harpok, b.barang_harjul, b.barang_kategori_nama';
		$select_columns .= ", 
			IFNULL(
				SUM(CASE WHEN s.stok_regid = '" .$regid. "' AND s.stok_in > 0 THEN s.stok_in ELSE 0 END) - 
				SUM(CASE WHEN s.stok_regid = '" .$regid. "' AND s.stok_out > 0 THEN s.stok_out ELSE 0 END), 0) 
			AS stok_cabang";
		$this->db->select($select_columns);
		$this->db->from('tbl_barang b');
		$this->db->join('tbl_stok s', 'b.barang_id = s.brg_id', 'left');
		$this->db->where('b.barang_co_id', $coid); // Tambahkan kondisi where pada tabel 'tbl_barang'
		$this->db->group_by('b.barang_id, b.barang_nama, b.barang_kategori_nama');
		return $this->db->get();
	}
	

	function get_barang($regid,$idbrg){
		$coid=$this->session->userdata('coid');
		$select_columns = 'b.barang_id,b.barang_nama,b.barang_satuan,b.barang_harpok,b.barang_harjul,b.barang_kategori_nama';
		$select_columns .= ", 
			IFNULL(
				SUM(CASE WHEN s.stok_regid = '" .$regid. "' AND s.stok_in > 0 THEN s.stok_in ELSE 0 END) - 
				SUM(CASE WHEN s.stok_regid = '" .$regid. "' AND s.stok_out > 0 THEN s.stok_out ELSE 0 END), 0) 
			AS stok_cabang";
		
		$this->db->select($select_columns);
		$this->db->from('tbl_barang b');
		$this->db->join('tbl_stok s', 'b.barang_id = s.brg_id', 'left');
		$this->db->where('b.barang_co_id', $coid); // Tambahkan kondisi where pada tabel 'tbl_barang'
		$this->db->where('b.barang_id', $idbrg); // Tambahkan kondisi where untuk barang_id yang diinginkan
		$this->db->group_by('b.barang_id, b.barang_nama, b.barang_disc_id, b.barang_satuan, b.barang_harpok, b.barang_harjul, b.barang_kategori_nama');
		//return $this->db->get();
		$result = $this->db->get()->result_array(); 
        return $result;
	}

	function get_returid(){
		$q = $this->db->query("SELECT MAX(RIGHT(retur_id,6)) AS kd_max FROM tbl_retur WHERE DATE(retur_tgl)=CURDATE()");
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
		return "R".date('dmy').$kd;
	}


	function get_tampil_retur($kode){
		$select_columns = 'a.retur_id,a.retur_tgl_trans,a.retur_no,a.retur_tgl,a.retur_brg_id,a.retur_brg_nama,
						   a.retur_brg_sat,a.retur_brg_kat,a.retur_harpok,a.retur_harjul,a.retur_qty,a.retur_total_harpok,
						   a.retur_keterangan,b.reg_name';
		$this->db->select($select_columns);
		$this->db->from('tbl_retur a');
		$this->db->join('regions b', 'b.reg_id = a.retur_regid', 'left');
		$this->db->where('a.retur_id', $kode);
		$result = $this->db->get()->result_array(); 
        return $result;
	}


	//--------------------batas add file-------------------
	function get_retur_file($noid,$idbrg) {
        $queryA = $this->db->query("SELECT retur_id,retur_no,retur_tgl,retur_brg_id,retur_brg_nama,retur_brg_sat,retur_brg_kat,retur_harjul,retur_qty,(retur_harjul*retur_qty) AS retur_subtotal FROM tbl_retur WHERE retur_id='$noid' AND retur_brg_id='$idbrg' ORDER BY retur_id ASC");
		$queryB = $this->db->query("SELECT r_id,r_noid,r_brg_id,r_file,r_path FROM tbl_retur_file WHERE r_noid='$noid' AND r_brg_id='$idbrg' ORDER BY r_id ASC");
		$resultA = $queryA->result_array(); 
		$resultB = $queryB->result_array(); //banyak row Ambil hasil query sebagai array asosiatif
		return array('queryA' => $resultA, 'queryB' => $resultB);
    }


	function add_file_garansi($noid,$idbrg,$nmfile) {
	$regid=$this->session->userdata('regid');
	$coid=$this->session->userdata('coid');
	$user_nama=$this->session->userdata('nama');
	
	$nmpath = base_url() . 'assets/img/file_retur/' . $nmfile;
	$data=array(
		'r_noid' 			=>	$noid,
		'r_brg_id'			=>	$idbrg,
		'r_file'			=>	$nmfile,
		'r_path'		    =>	$nmpath,
		'r_regid'			=>	$regid,
		'r_coid'			=>	$coid,
		'created_by'	    =>  $user_nama,
		'created_at'	    =>	date('Y-m-d H:i:s')
	);
		$this->db->insert('tbl_retur_file', $data);
		return true;
	}


	function hapus_file($rid){
	 	$hsl=$this->db->query("DELETE FROM tbl_retur_file where r_id='$rid'");
	 	return $hsl;
	}

	//-----menu v_retur user Admin------------
	function get_file($kode) {
		$query = $this->db->query("SELECT r_id,r_noid,r_brg_id,r_file,r_path FROM tbl_retur_file WHERE r_noid='$kode' ORDER BY r_id ASC");
		$result = $query->result_array(); //banyak row Ambil hasil query sebagai array asosiatif
		return $result;
    }	

	//-------------------------------------------------
	
}