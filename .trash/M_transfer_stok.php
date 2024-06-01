<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_transfer_stok extends CI_Model{

	function get_barang($idbrg){
		$coid=$this->session->userdata('coid');
		$regid=$this->session->userdata('regid');
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
		//$this->db->group_by('b.barang_id, b.barang_nama, b.barang_disc_id, b.barang_satuan, b.barang_harpok, b.barang_harjul, b.barang_kategori_nama');
		$this->db->group_by('b.barang_id');
		//return $this->db->get();
		$result = $this->db->get()->result_array(); 
        return $result;
	}

	function tampil_barang(){
		$regid=$this->session->userdata('regid');
		$coid=$this->session->userdata('coid');
		$select_columns = 'b.barang_id, b.barang_nama, b.barang_satuan, b.barang_harjul, b.barang_kategori_nama';
		$select_columns .= ", 
			IFNULL(
				SUM(CASE WHEN s.stok_regid = '" .$regid. "' AND s.stok_in > 0 THEN s.stok_in ELSE 0 END) - 
				SUM(CASE WHEN s.stok_regid = '" .$regid. "' AND s.stok_out > 0 THEN s.stok_out ELSE 0 END), 0) 
			AS stok_cabang";
		
		$this->db->select($select_columns);
		$this->db->from('tbl_barang b');
		$this->db->join('tbl_stok s', 'b.barang_id = s.brg_id', 'left');
		$this->db->where('b.barang_co_id', $coid); // Tambahkan kondisi where pada tabel 'tbl_barang'
		//$this->db->group_by('b.barang_id, b.barang_nama, b.barang_kategori_nama');
		$this->db->group_by('b.barang_id');
        $this->db->order_by('b.barang_kategori_id', 'ASC');
        $this->db->order_by('b.barang_id', 'ASC');
		return $this->db->get();
	}
	
	function hapus_data_transtok($kode){
		$this->db->trans_start();
            $this->db->where('trans_stok_no', $kode)->delete('tbl_transtok');
			$this->db->where('d_trans_stok_no', $kode)->delete('tbl_detail_transtok');
			$this->db->where('stok_no', $kode)->delete('tbl_stok');
        $this->db->trans_complete();
        return $this->db->trans_status();
	}

	function simpan_transtok($requestData,$regidterima) {
		$nostok = $this->get_nostok();
		$user_id=$this->session->userdata('idadmin');
		$user_nama=$this->session->userdata('nama');
		$coid=$this->session->userdata('coid');
		$regid=$this->session->userdata('regid');
		$pk=0;//proses konfirm 0 belum konfirm, 1 sudah konfirm dan masuk stok
		$ts=0;//total selisih
		
		$this->db->trans_start(); // Memulai transaksi
		try {
			//1. simpan ke tbl_transtok
			$kirim = array(
					'trans_stok_no' 	=> $nostok,
					'trans_stok_tgl' 	=> date('Y-m-d H:i:s'),
					'trans_user_id' 	=> $user_id,
					'trans_reg_id' 		=> $regid,
					'trans_co_id' 		=> $coid,
					'regid_terima' 		=> $regidterima,
					'proses_konfirm' 	=> $pk,
					'total_selisih' 	=> $ts,
					'created_by' 		=> $user_nama,
					'created_at' 		=> date('Y-m-d H:i:s')
			);
			$this->db->insert('tbl_transtok', $kirim);
			
			//2. simpan ke tbl_detail_transtok
			foreach ($requestData as $item) {
				$data = array(
					'd_trans_stok_no' 	=>	$nostok,
					'd_trans_stok_tgl' 	=> 	date('Y-m-d H:i:s'),
					'd_barang_id'		=>	$item['id'],
					'd_barang_nama'		=>	$item['nama_barang'],
					'd_barang_satuan'	=>	$item['satuan'],
					'd_kategori_nama'	=>	$item['kategori'],
					'kirim_qty'			=>	(float) $item['qty'],
					'regid_terima' 		=> 	$regidterima,
					'd_proses_konfirm' 	=> 	$pk,
					'trans_user_id' 	=> 	$user_id,
					'trans_reg_id' 		=> 	$regid,
					'trans_co_id' 		=> 	$coid,
					'created_by'		=>  $user_nama,
					'created_at'		=>	date('Y-m-d H:i:s')
				);
				$this->db->insert('tbl_detail_transtok',$data);

				//3. menyimpan pada tbl_stok, begitu proses transfer stok langsung mengurangi stok
				$stok_out = array(
					'stok_no' 		=>	$nostok,
					'stok_ket'		=>	'Transfer_Stok',
					'stok_status'	=>	'out',
					'stok_tgl'		=>	date('Y-m-d H:i:s'),
					'brg_id'		=>	$item['id'],
					'brg_nama'		=>	$item['nama_barang'],
					'brg_sat'		=>	$item['satuan'],
					'brg_kat'		=>	$item['kategori'],
					'stok_in'		=>	0,
					'stok_out'		=>	(float) $item['qty'],
					'stok_user_id'  =>  $user_id,
					'stok_regid'	=>	$regid,
					'stok_coid'		=>	$coid,
					'created_by'	=>  $user_nama,
					'created_at'	=>	date('Y-m-d H:i:s')
				);
				$this->db->insert('tbl_stok',$stok_out);

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

	function get_nostok(){
		$q = $this->db->query("SELECT MAX(RIGHT(trans_stok_no,6)) AS kd_max FROM tbl_transtok WHERE DATE(trans_stok_tgl)=CURDATE()");
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
		return "TS".date('dmy').$kd;
	}

	
	function tampil_transtok(){
		$regid=$this->session->userdata('regid');
		$hsl=$this->db->query("SELECT trans_stok_no,trans_stok_tgl,tgl_konfirm,proses_konfirm,regid_terima,total_selisih,regions.reg_name FROM tbl_transtok JOIN regions ON tbl_transtok.regid_terima=regions.reg_id where trans_reg_id='$regid' order by DATE(trans_stok_tgl) DESC");
		return $hsl;
	}

	function get_tampil_transtok($stokno){
		$hsl=$this->db->query("SELECT trans_stok_no,trans_stok_tgl,tgl_konfirm,proses_konfirm,regid_terima,total_selisih,regions.reg_name FROM tbl_transtok JOIN regions ON tbl_transtok.regid_terima=regions.reg_id where trans_stok_no='$stokno'");
		return $hsl;
	}

	function get_terima_transtok($stokno){
		$hsl=$this->db->query("SELECT trans_stok_no,trans_stok_tgl,tgl_konfirm,proses_konfirm,trans_reg_id,total_selisih,regions.reg_name FROM tbl_transtok JOIN regions ON tbl_transtok.trans_reg_id=regions.reg_id where trans_stok_no='$stokno'");
		return $hsl;
	}

	function get_transtok($stokno) {
        $select_columns = "a.d_trans_stok_id,a.d_trans_stok_no,DATE_FORMAT(a.d_trans_stok_tgl, '%d/%m/%Y') as d_trans_stok_tgl,a.d_barang_id,a.d_barang_nama,a.d_barang_satuan,a.d_kategori_nama,a.kirim_qty,a.konfirm_qty,a.selisih_qty";
        $this->db->select($select_columns);
        $this->db->from('tbl_detail_transtok a');
        $this->db->where('a.d_trans_stok_no', $stokno);
        $this->db->order_by('a.d_barang_id', 'ASC');
        $result = $this->db->get()->result_array(); 
        return $result;
	}

	function update_transtok($stokno,$brgid,$stokid,$qty) {
		$user_nama=$this->session->userdata('nama');
		$this->db->set('kirim_qty', $qty);
		$this->db->set('updated_by', $user_nama);
		$this->db->set('updated_at', 'NOW()', false);
		$this->db->where('d_trans_stok_id', $stokid);
		$hsl1 = $this->db->update('tbl_detail_transtok');
		// Update tbl_stok
		$this->db->set('stok_out', $qty);
		$this->db->set('updated_by', $user_nama);
		$this->db->set('updated_at', 'NOW()', false);
		$this->db->where('stok_no', $stokno);
		$this->db->where('brg_id', $brgid);
		$hsl2 = $this->db->update('tbl_stok');
		// Cek apakah kedua update berhasil
		if ($hsl1 && $hsl2) {
			return true;
		} else {
			return false;
		}
	}

	function hapus_transtok($stokno,$stokid,$brgid) {
		$this->db->trans_start();
            $this->db->where('d_trans_stok_id', $stokid)->delete('tbl_detail_transtok');
            $this->db->where('stok_no', $stokno)->where('stok_ket', 'Transfer_Stok')->where('brg_id', $brgid)->delete('tbl_stok');
        $this->db->trans_complete();
        return $this->db->trans_status();

	}


	function simpan_addtranstok($nostok,$tgl,$regcab,$kd,$nm,$sat,$kat,$qty){
	$user_id=$this->session->userdata('idadmin');
	$regid=$this->session->userdata('regid');
	$coid=$this->session->userdata('coid');
	$user_nama=$this->session->userdata('nama');
	$pk=0;//proses stok

	$this->db->trans_start(); // Memulai transaksi
	try {
		//1. menambah data pada tbl_detail_transtok, 
		$data=array(
			'd_trans_stok_no' 	=>	$nostok,
			'd_trans_stok_tgl' 	=> 	$tgl,
			'd_barang_id'		=>	$kd,
			'd_barang_nama'		=>	$nm,
			'd_barang_satuan'	=>	$sat,
			'd_kategori_nama'	=>	$kat,
			'kirim_qty'			=>	$qty,
			'regid_terima' 		=> 	$regcab,
			'd_proses_konfirm' 	=> 	$pk,
			'trans_user_id' 	=> 	$user_id,
			'trans_reg_id' 		=> 	$regid,
			'trans_co_id' 		=> 	$coid,
			'created_by'		=>  $user_nama,
			'created_at'		=>	date('Y-m-d H:i:s')
		);
		$this->db->insert('tbl_detail_transtok',$data);
		//2. menyimpan pada tbl_stok, 
		$stok_out = array(
			'stok_no' 		=>	$nostok,
			'stok_ket'		=>	'Transfer_Stok',
			'stok_status'	=>	'out',
			'stok_tgl'		=>	$tgl,
			'brg_id'		=>	$kd,
			'brg_nama'		=>	$nm,
			'brg_sat'		=>	$sat,
			'brg_kat'		=>	$kat,
			'stok_in'		=>	0,
			'stok_out'		=>	$qty,
			'stok_user_id'  =>  $user_id,
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

	function get_data_transtok($stokno,$idbrg) {
        $select_columns = "a.d_trans_stok_id,a.d_trans_stok_no,a.d_barang_id";
        $this->db->select($select_columns);
        $this->db->from('tbl_detail_transtok a');
        $this->db->where('a.d_trans_stok_no', $stokno);
		$this->db->where('a.d_barang_id', $idbrg);
        $result = $this->db->get()->result_array(); 
        return $result;
	}


	function tampil_konfirm(){
		$regid=$this->session->userdata('regid');
		$hsl=$this->db->query("SELECT trans_stok_no,trans_stok_tgl,tgl_konfirm,proses_konfirm,total_selisih,trans_reg_id,regions.reg_name FROM tbl_transtok JOIN regions ON tbl_transtok.trans_reg_id=regions.reg_id where regid_terima='$regid' order by DATE(trans_stok_tgl) DESC");
		return $hsl;
	}

	//tidak digunakan karena begitu kirim stok, stok langsung berkurang, insert stok_out pada tbl_stok
	// function get_stok_pending($idbrg) {
	// 	$regid=$this->session->userdata('regid');
	// 	$coid=$this->session->userdata('coid');
    //     $select_columns = "COALESCE(SUM(a.kirim_qty), 0) AS stok_pending";
    //     $this->db->select($select_columns);
    //     $this->db->from('tbl_detail_transtok a');
    //     $this->db->where('a.d_proses_konfirm', 0); //mencari yang proses konfirm  0 artinya belum di konfirm
	// 	$this->db->where('a.d_barang_id', $idbrg);
	// 	$this->db->where('a.trans_reg_id', $regid);
	// 	$this->db->where('a.trans_co_id', $coid);
    //     $result = $this->db->get()->result_array(); 
    //     return $result;
	// }

	function simpan_konfirm_stok($requestData,$notrans) {
		$user_id=$this->session->userdata('idadmin');
		$regid=$this->session->userdata('regid');
		$coid=$this->session->userdata('coid');
		$user_nama = $this->session->userdata('nama');
		$pk = '1'; // proses konfirm
        $jml_selisih = 0; // Inisialisasi nilai awal
		
		$this->db->trans_start(); // Memulai transaksi
		try {
		
			foreach ($requestData as $item) {
				$stokno = $item['stokno'];
				$stokid = $item['stokid'];
				$k_qty = (float)$item['k_qty'];
				$qty = (float)$item['qty'];
				$sel_qty = (float)$item['sel_qty'];
				$brgid=$item['kode_barang'];
				$nm= $item['nama_barang'];
				$sat= $item['satuan'];
				$kat= $item['kategori'];
				$jml_selisih+=$sel_qty;
				// Perbarui tbl_detail_reqstok
				$this->db->set('d_tgl_konfirm', 'NOW()', false);
				$this->db->set('konfirm_qty', $qty);
				$this->db->set('selisih_qty', $sel_qty);
				$this->db->set('d_proses_konfirm', $pk);
				$this->db->set('konfirm_user_id', $user_id);
				$this->db->set('konfirm_reg_id', $regid);
				$this->db->set('konfirm_co_id', $coid);
				$this->db->set('updated_by', $user_nama);
				$this->db->set('updated_at', 'NOW()', false);
				$this->db->where('d_trans_stok_id', $stokid);
				$this->db->update('tbl_detail_transtok');

				//menyimpan pada tbl_stok
				$stok_in=array(
					'stok_no' 		=>	$stokno,
					'stok_ket'		=>	'Konfirm_Stok',
					'stok_status'	=>	'in',
					'stok_tgl'		=>	date('Y-m-d H:i:s'),
					'brg_id'		=>	$brgid,
					'brg_nama'		=>	$nm,
					'brg_sat'		=>	$sat,
					'brg_kat'		=>	$kat,
					'stok_in'		=>	$qty,
					'stok_out'		=>	0,
					'stok_user_id'  =>  $user_id,
					'stok_regid'	=>	$regid,
					'stok_coid'		=>	$coid,
					'created_by'	=>  $user_nama,
					'created_at'	=>	date('Y-m-d H:i:s')
				);
				$this->db->insert('tbl_stok',$stok_in);

			}
			// Perbarui tbl_transtok
				$this->db->set('tgl_konfirm', 'NOW()', false);
				$this->db->set('proses_konfirm', $pk);
				$this->db->set('total_selisih', $jml_selisih);
				$this->db->set('updated_by', $user_nama);
				$this->db->set('updated_at', 'NOW()', false);
				$this->db->where('trans_stok_no', $notrans);
				$this->db->update('tbl_transtok');
		
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



}