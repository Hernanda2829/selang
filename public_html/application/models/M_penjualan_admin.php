<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_penjualan_admin extends CI_Model{

	function get_discount($disc_id){
		$hsl=$this->db->query("SELECT * FROM tbl_discount where disc_id='$disc_id'");
		return $hsl;
	}

	function get_produk($kobar,$regid){
		$coid=$this->session->userdata('coid');
		$select_columns = 'b.barang_id, b.barang_nama, b.barang_disc_id, b.barang_satuan, b.barang_harpok, b.barang_harjul, b.barang_kategori_nama';
		$select_columns .= ", 
			IFNULL(
				SUM(CASE WHEN s.stok_regid = '" .$regid. "' AND s.stok_in > 0 THEN s.stok_in ELSE 0 END) - 
				SUM(CASE WHEN s.stok_regid = '" .$regid. "' AND s.stok_out > 0 THEN s.stok_out ELSE 0 END), 0) 
			AS stok_cabang";
		
		$this->db->select($select_columns);
		$this->db->from('tbl_barang b');
		$this->db->join('tbl_stok s', 'b.barang_id = s.brg_id', 'left');
		$this->db->where('b.barang_co_id', $coid); // Tambahkan kondisi where pada tabel 'tbl_barang'
		$this->db->where('b.barang_id', $kobar); // Tambahkan kondisi where untuk barang_id yang diinginkan
		$this->db->group_by('b.barang_id, b.barang_nama, b.barang_disc_id, b.barang_satuan, b.barang_harpok, b.barang_harjul, b.barang_kategori_nama');
		return $this->db->get();
	}

	function get_barang($kobar){
		$coid=$this->session->userdata('coid');
		$select_columns = 'b.barang_id, b.barang_nama, b.barang_disc_id, b.barang_satuan, b.barang_harpok, b.barang_harjul, b.barang_kategori_nama';
		$select_columns .= ", 
			IFNULL(
				SUM(CASE WHEN s.stok_regid = '" .$regid. "' AND s.stok_in > 0 THEN s.stok_in ELSE 0 END) - 
				SUM(CASE WHEN s.stok_regid = '" .$regid. "' AND s.stok_out > 0 THEN s.stok_out ELSE 0 END), 0) 
			AS stok_cabang";
		
		$this->db->select($select_columns);
		$this->db->from('tbl_barang b');
		$this->db->join('tbl_stok s', 'b.barang_id = s.brg_id', 'left');
		$this->db->where('b.barang_co_id', $coid); // Tambahkan kondisi where pada tabel 'tbl_barang'
		$this->db->where('b.barang_id', $kobar); // Tambahkan kondisi where untuk barang_id yang diinginkan
		$this->db->group_by('b.barang_id, b.barang_nama, b.barang_disc_id, b.barang_satuan, b.barang_harpok, b.barang_harjul, b.barang_kategori_nama');
		return $this->db->get();
	}

	function tampil_stok($regid){
		$coid=$this->session->userdata('coid');
		$select_columns = 'b.barang_id, b.barang_nama, b.barang_disc_id, b.barang_satuan, b.barang_harpok, b.barang_harjul, b.barang_kategori_nama';
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
		$result = $this->db->get()->result_array(); 
        return $result;
	}

	function tampil_barang2($regid){
		$coid=$this->session->userdata('coid');
		$select_columns = 'b.barang_id, b.barang_nama, b.barang_disc_id, b.barang_satuan, b.barang_harpok, b.barang_harjul, b.barang_kategori_nama';
		$select_columns .= ", 
			IFNULL(
				SUM(CASE WHEN s.stok_regid = '" .$regid. "' AND s.stok_in > 0 THEN s.stok_in ELSE 0 END) - 
				SUM(CASE WHEN s.stok_regid = '" .$regid. "' AND s.stok_out > 0 THEN s.stok_out ELSE 0 END), 0) 
			AS stok_cabang";
		
		$this->db->select($select_columns);
		$this->db->from('tbl_barang b');
		$this->db->join('tbl_stok s', 'b.barang_id = s.brg_id', 'left');
		$this->db->where('b.barang_co_id', $coid); // Tambahkan kondisi where pada tabel 'tbl_barang'
		$this->db->group_by('b.barang_id, b.barang_nama, b.barang_disc_id, b.barang_satuan, b.barang_harpok, b.barang_harjul, b.barang_kategori_nama');
		return $this->db->get();
	}
	
	function tampil_barang(){
		$coid=$this->session->userdata('coid');
		$regid=$this->session->userdata('regid');
		$select_columns = 'b.barang_id, b.barang_nama, b.barang_disc_id, b.barang_satuan, b.barang_harpok, b.barang_harjul, b.barang_kategori_nama';
		$this->db->select($select_columns);
		$this->db->from('tbl_barang b');
		$this->db->join('tbl_stok s', 'b.barang_id = s.brg_id', 'left');
		$this->db->where('b.barang_co_id', $coid); // Tambahkan kondisi where pada tabel 'tbl_barang'
		$this->db->group_by('b.barang_id, b.barang_nama, b.barang_disc_id, b.barang_satuan, b.barang_harpok, b.barang_harjul, b.barang_kategori_nama');
		return $this->db->get();
	}

	// function tampil_barang(){
	// 	$coid=$this->session->userdata('coid');
	// 	$regid=$this->session->userdata('regid');
	// 	$select_columns = 'b.barang_id, b.barang_nama, b.barang_disc_id, b.barang_satuan, b.barang_harpok, b.barang_harjul, b.barang_kategori_nama';
	// 	$select_columns .= ", 
	// 		IFNULL(
	// 			SUM(CASE WHEN s.stok_regid = '" .$regid. "' AND s.stok_in > 0 THEN s.stok_in ELSE 0 END) - 
	// 			SUM(CASE WHEN s.stok_regid = '" .$regid. "' AND s.stok_out > 0 THEN s.stok_out ELSE 0 END), 0) 
	// 		AS stok_cabang";
		
	// 	$this->db->select($select_columns);
	// 	$this->db->from('tbl_barang b');
	// 	$this->db->join('tbl_stok s', 'b.barang_id = s.brg_id', 'left');
	// 	$this->db->where('b.barang_co_id', $coid); // Tambahkan kondisi where pada tabel 'tbl_barang'
	// 	$this->db->group_by('b.barang_id, b.barang_nama, b.barang_disc_id, b.barang_satuan, b.barang_harpok, b.barang_harjul, b.barang_kategori_nama');
	// 	return $this->db->get();
	// }
	
	function tampil_periode(){
		$coid=$this->session->userdata('coid');
		$hsl=$this->db->query("SELECT p_val,p_nama FROM periode where p_coid='$coid'");
		return $hsl;
	}
							  
	function simpan_penjualan($nofak,$tgljual,$cab,$total,$jml_uang,$kembalian,$sisakurang,$customer,$nota,$carabayar,$statusbayar,$prdbln,$tgljtempo){
		$idadmin=$this->session->userdata('idadmin');
		$user_nama=$this->session->userdata('nama');
		$regid=$this->session->userdata('regid');
		$coid=$this->session->userdata('coid');
		$stok_ket='Penjualan_'.$carabayar;
		$jtgl=date('Y-m-d');
		$jhari = (new DateTime($jtgl))->diff(new DateTime($tgljtempo))->days;
		if (empty($customer) || $customer == '0') {
			$namacust ='Umum';
		}else{
			$namacust = ($result = $this->db->where('cust_id', $customer)->get('tbl_customer')->result()) ? $result[0]->cust_nama : "null";
		}
		
		$this->db->trans_start(); // Memulai transaksi
		try {
			//1. simpan ke tbl_jual
			$data_jual = array(
					'jual_nofak' => $nofak,
					'jual_tanggal' => $tgljual,
					'jual_nota' => $nota,
					'jual_total' => $total,
					'jual_jml_uang' => $jml_uang,
					'jual_kembalian' => $kembalian,
					'jual_user_id' => $idadmin,
					'jual_reg_id' => $cab,
					'jual_co_id' => $coid,
					'jual_bayar' => $carabayar,
					'jual_bayar_status' => $statusbayar,
					'jual_kurang_bayar' => $sisakurang,
					'jual_cust_id' => $customer,
					'jual_cust_nama' => $namacust,
					'jual_tgl_tempo' => $tgljtempo,
					'jual_bulan_tempo' => $prdbln,
					'jual_hari_tempo' => $jhari,
					'created_by' => $user_nama,
					'created_at' => date('Y-m-d H:i:s')
			);
			$this->db->insert('tbl_jual', $data_jual);
			//2. simpan ke tbl_detail_jual
			foreach ($this->cart->contents() as $item) {
				$data=array(
					'd_jual_nofak' 			=>	$nofak,
					'd_jual_tanggal' 		=>  $tgljual,
					'group_id'				=>	$item['kode_set'],
					'group_desc'			=>	$item['desk_set'],
					'group_sat'				=>	$item['jml_set'],
					'd_jual_barang_id'		=>	$item['id'],
					'd_jual_barang_nama'	=>	$item['name'],
					'd_jual_barang_satuan'	=>	$item['satuan'],
					'd_jual_kategori_nama'	=>	$item['kategori'],
					'd_jual_barang_harpok'	=>	$item['harpok'],
					'd_jual_barang_harjul'	=>	$item['amount'],
					'd_jual_qty'			=>	$item['qty'],
					'd_jual_diskon'			=>	$item['disc'],
					'd_jual_total'			=>	$item['subtotal'],
					'd_jual_total_harpok'	=>	$item['harpok'] * $item['qty'],
					'd_jual_user_id'		=>	$idadmin,
					'd_jual_reg_id'			=>	$cab,
					'd_jual_co_id'			=>	$coid,
					'd_jual_diskon_rate'	=>	$item['ratedisc'],
					'created_by'			=>  $user_nama,
					'created_at'			=>	date('Y-m-d H:i:s')
				);
				$this->db->insert('tbl_detail_jual',$data);
				//3. simpan ke tbl_stok
				$stok_out=array(
					'stok_no' 		=>	$nofak,
					'stok_ket'		=>	$stok_ket,
					'stok_status'	=>	'out',
					'stok_tgl'		=>	date('Y-m-d H:i:s'),
					'brg_id'		=>	$item['id'],
					'brg_nama'		=>	$item['name'],
					'brg_sat'		=>	$item['satuan'],
					'brg_kat'		=>	$item['kategori'],
					'stok_in'		=>	0,
					'stok_out'		=>	$item['qty'],
					'stok_user_id'  =>  $idadmin,
					'stok_regid'	=>	$cab,
					'stok_coid'		=>	$coid,
					'created_by'	=>  $user_nama,
					'created_at'	=>	date('Y-m-d H:i:s')
				);
				$this->db->insert('tbl_stok',$stok_out);
			}
			//4. simpan ke tbl_bayar
			if ($carabayar==="Tempo" && floatval($jml_uang) > 0) {
				//$this->db->query("INSERT INTO tbl_bayar (bayar_nofak,bayar_tanggal,bayar_total,bayar_tgl_trans,bayar_jumlah,bayar_ket,bayar_reg_id,bayar_co_id,created_by,created_at) VALUES ('$nofak',now(),'$total',now(),'$jml_uang','$statusbayar','$regid','$coid','$user_nama',now())");
				$data_bayar = array(
					'bayar_nofak' 		=> $nofak,
					'bayar_tanggal' 	=> $tgljual,
					'bayar_total' 		=> $total,
					'bayar_tgl_trans' 	=> $tgljual,
					'bayar_jumlah' 		=> $jml_uang,
					'bayar_ket' 		=> $statusbayar,
					'bayar_reg_id' 		=> $cab,
					'bayar_co_id' 		=> $coid,
					'bayar_user_id'		=> $idadmin,
					'created_by' 		=> $user_nama,
					'created_at' 		=> date('Y-m-d H:i:s')
				);
				$this->db->insert('tbl_bayar', $data_bayar);
			}
		

			$this->db->trans_complete(); // Menyelesaikan transaksi
			// Check apakah transaksi berhasil atau tidak
			if ($this->db->trans_status() === FALSE) {
				// Transaksi gagal, lakukan sesuatu seperti logging atau memberikan pesan kesalahan
				log_message('error', 'Transaksi penjualan gagal');
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

	function cetak_faktur(){
		$nofak=$this->session->userdata('nofak');
		$hsl=$this->db->query("SELECT jual_nofak,DATE_FORMAT(jual_tanggal,'%d/%m/%Y %H:%i:%s') AS jual_tanggal,jual_nota,jual_total,jual_jml_uang,jual_kembalian,jual_bayar,jual_kurang_bayar,d_jual_barang_nama,d_jual_barang_satuan,d_jual_barang_harjul,d_jual_qty,d_jual_diskon,d_jual_total,jual_cust_nama,group_id,group_desc,group_sat FROM tbl_jual JOIN tbl_detail_jual ON jual_nofak=d_jual_nofak WHERE jual_nofak='$nofak'");
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

	
}