<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_beli extends CI_Model{

	function get_pembelian($firstDay, $lastDay) {
		$coid=$this->session->userdata('coid');
		$this->db->select("a.beli_kode,a.beli_nofak,DATE_FORMAT(a.beli_tanggal,'%d %M %Y') AS beli_tanggal,a.beli_suplier_nama");
		$this->db->from('tbl_beli a');
		$this->db->where('DATE(a.beli_tanggal) >=', $firstDay);
        $this->db->where('DATE(a.beli_tanggal) <=', $lastDay);
		$this->db->where('a.beli_co_id', $coid);
		$this->db->order_by('DATE(a.beli_tanggal)', 'DESC');
        $result = $this->db->get()->result_array(); 
        return $result;
    }

	function getdetailbeli($noid){
		$this->db->select("b.d_beli_barang_id,b.d_beli_barang_nama,b.d_beli_barang_satuan,b.d_beli_jumlah,b.d_beli_harga");
		$this->db->from('tbl_detail_beli b');
		$this->db->where('b.d_beli_kode', $noid);
		$this->db->order_by('b.d_beli_barang_id', 'ASC');
		$result = $this->db->get()->result_array(); 
        return $result;
	}

	function tampil_beli(){
		$coid=$this->session->userdata('coid');
		// $hsl=$this->db->query("SELECT d_beli_id,d_beli_nofak,beli_tanggal,beli_suplier_nama,d_beli_barang_id,d_beli_barang_nama,d_beli_barang_satuan,d_beli_jumlah,d_beli_harga,(d_beli_harga/d_beli_jumlah) as harpok,proses_stok,status_stok,tgl_proses,awal_stok,akhir_stok,d_harpok,d_harjul,d_kategori_nama FROM tbl_beli JOIN tbl_detail_beli ON beli_nofak=d_beli_nofak WHERE beli_co_id='$coid' order by tbl_detail_beli.created_at Desc");
		// return $hsl;
		$this->db->select('d_beli_id, d_beli_nofak, beli_tanggal, beli_suplier_nama, d_beli_barang_id, d_beli_barang_nama, d_beli_barang_satuan, d_beli_jumlah, d_beli_harga, (d_beli_harga/d_beli_jumlah) as harpok, proses_stok, status_stok, tgl_proses, awal_stok, akhir_stok, d_harpok, d_harjul, d_kategori_nama');
		$this->db->from('tbl_beli');
		$this->db->join('tbl_detail_beli', 'tbl_beli.beli_kode = tbl_detail_beli.d_beli_kode');
		$this->db->where('tbl_beli.beli_co_id', $coid);
		$this->db->order_by('DATE(beli_tanggal)', 'DESC');
		return $this->db->get();
	}

	function get_beli($idbeli){
		$this->db->select('d_beli_id, d_beli_nofak, beli_tanggal, beli_suplier_nama, d_beli_barang_id, d_beli_barang_nama, d_beli_barang_satuan, d_beli_jumlah, d_beli_harga, (d_beli_harga/d_beli_jumlah) as harpok, proses_stok, status_stok, tgl_proses, awal_stok, akhir_stok, d_harpok, d_harjul, d_kategori_nama');
		$this->db->from('tbl_beli');
		$this->db->join('tbl_detail_beli', 'tbl_beli.beli_kode = tbl_detail_beli.d_beli_kode');
		$this->db->where('tbl_detail_beli.d_beli_id', $idbeli);
		$result = $this->db->get()->result_array(); 
        return $result;
	}

	function find_brg($idbrg){
		$this->db->select('barang_id');
		$this->db->from('tbl_barang');
		$this->db->where('barang_id', $idbrg);
		return $this->db->get();
	}

	function get_brg($idbrg){
		$coid=$this->session->userdata('coid');
		$regid=$this->session->userdata('regid');
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
		$this->db->where('b.barang_id', $idbrg); // Tambahkan kondisi where untuk barang_id yang diinginkan
		$this->db->group_by('b.barang_id, b.barang_nama, b.barang_disc_id, b.barang_satuan, b.barang_harpok, b.barang_harjul, b.barang_kategori_nama');
		$result = $this->db->get()->result_array(); 
        return $result;
	}

	function update_barang($kd_brg,$harpok,$harjul) {
		$user_nama=$this->session->userdata('nama');
		$this->db->set('barang_harpok', $harpok);
		$this->db->set('barang_harjul', $harjul);
		$this->db->set('updated_by', $user_nama);
		$this->db->set('updated_at', 'NOW()', false);
		$this->db->where('barang_id', $kd_brg);
		$hsl = $this->db->update('tbl_barang');
		return $hsl;
	}

	
	function updatestok($kode,$nofak,$kd_brg,$nm_brg,$sat,$kat,$qty,$awal_stok,$akhir_stok,$harpok,$harjul){
		$user_id=$this->session->userdata('idadmin');
		$user_nama=$this->session->userdata('nama');
		$coid=$this->session->userdata('coid');
		$regid=$this->session->userdata('regid');
		$this->db->set('proses_stok', '1');	//arti proses_stok 1 adalah pembelian tsb sudah di proses input stok
		$this->db->set('tgl_proses', date('Y-m-d H:i:s'));
		$this->db->set('awal_stok', $awal_stok);
		$this->db->set('akhir_stok', $akhir_stok);
		$this->db->set('d_harpok', $harpok);
		$this->db->set('d_harjul', $harjul);
		$this->db->set('d_kategori_nama', $kat);
		$this->db->where('d_beli_id', $kode);
		$this->db->update('tbl_detail_beli');	
		//untuk d_harpok, d_harjul dan d_kategori_nama pada awal dibentuk tbl_detail_beli nilainya kosong
		//namun setelah di update , d_harpok, d_harjul, d_kategori_nama di isi sesuai nilai pada data barang.
		//menyimpan pada tbl_stok
		//pembelian barang dengan kode barang yang sudah terdaftar, sehingga menambah stok barang saja
			$stok_in=array(
				'stok_no' 		=>	$nofak,
				'stok_ket'		=>	'Pembelian_Update',
				'stok_status'	=>	'in',
				'stok_tgl'		=>	date('Y-m-d H:i:s'),
				'brg_id'		=>	$kd_brg,
				'brg_nama'		=>	$nm_brg,
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
		return true;
	}

	function add_barang($nofak,$kode,$kd_brg,$nm_brg,$sat,$harpok,$harjul,$qty,$kat,$diskon) {
		$idadmin=$this->session->userdata('idadmin');
		$user_nama=$this->session->userdata('nama');
		$coid=$this->session->userdata('coid');
		$regid=$this->session->userdata('regid');
		$katnama = ($result = $this->db->where('kategori_id', $kat)->get('tbl_kategori')->result()) ? $result[0]->kategori_nama : "null";
		$data=array(
			'barang_id' 			=>	$kd_brg,
			'barang_nama'			=>	$nm_brg,
			'barang_satuan'			=>	$sat,
			'barang_harpok'			=>	$harpok,
			'barang_harjul'			=>	$harjul,
			'barang_tgl_input'		=>	date('Y-m-d H:i:s'),
			'barang_kategori_id'	=>	$kat,
			'barang_kategori_nama'  =>  $katnama,
			'barang_user_id'		=>	$idadmin,
			'barang_disc_id'		=>	$diskon,
			'barang_co_id'			=>	$coid,
			'created_by'			=>	$user_nama,
			'created_at'			=>	date('Y-m-d H:i:s')
			);
			$this->db->insert('tbl_barang',$data);
		//update proses stok di tbl_detail_beli
		$this->db->set('proses_stok', '1');	//arti proses_stok 1 adalah pembelian tsb sudah di proses input stok
		$this->db->set('status_stok', '1');	//arti status_stok 1 adalah kode barang baru , kalo 0 kode barang lama
		$this->db->set('tgl_proses', date('Y-m-d H:i:s'));
		$this->db->set('awal_stok', 0);
		$this->db->set('akhir_stok', $qty);
		$this->db->set('d_harpok', $harpok);
		$this->db->set('d_harjul', $harjul);
		$this->db->set('d_kategori_nama', $katnama);
		$this->db->where('d_beli_id', $kode);
		$this->db->update('tbl_detail_beli');

		//menyimpan pada tbl_stok
		$stok_in=array(
			'stok_no' 		=>	$nofak,
			'stok_ket'		=>	'Pembelian_Baru',
			'stok_status'	=>	'in',
			'stok_tgl'		=>	date('Y-m-d H:i:s'),
			'brg_id'		=>	$kd_brg,
			'brg_nama'		=>	$nm_brg,
			'brg_sat'		=>	$sat,
			'brg_kat'		=>	$katnama,
			'stok_in'		=>	$qty,
			'stok_out'		=>	0,
			'stok_user_id'  =>  $idadmin,
			'stok_regid'	=>	$regid,
			'stok_coid'		=>	$coid,
			'created_by'	=>  $user_nama,
			'created_at'	=>	date('Y-m-d H:i:s')
		);
		$this->db->insert('tbl_stok',$stok_in);
		return true;
	}

	function edit_pembelian($kode,$kd_brg,$nm_brg,$sat,$qty,$harbel) {
	$user_nama=$this->session->userdata('nama');
	// Perbarui tbl_detail_beli
	$this->db->set('d_beli_barang_id', $kd_brg);
	$this->db->set('d_beli_barang_nama', $nm_brg);
	$this->db->set('d_beli_barang_satuan', $sat);
	$this->db->set('d_beli_harga', $harbel);
	$this->db->set('d_beli_jumlah', $qty);
	$this->db->set('updated_by', $user_nama);
	$this->db->set('updated_at', 'NOW()', false);
	$this->db->where('d_beli_id', $kode);
	$hsl = $this->db->update('tbl_detail_beli');
	return $hsl;
	}

	function hapus_pembelian($kode){
		$hsl=$this->db->query("DELETE FROM tbl_detail_beli where d_beli_id='$kode'");
		return $hsl;
	}

	function hapus_data_beli($kode){
		$hsl=$this->db->query("DELETE FROM tbl_beli where beli_kode='$kode'");
		$hsl=$this->db->query("DELETE FROM tbl_detail_beli where d_beli_kode='$kode'");
		return $hsl;
	}

}