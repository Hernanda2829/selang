<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_stok extends CI_Model{

	function tampil_barang() {
		$coid=$this->session->userdata('coid');
		$hsl=$this->db->query("SELECT barang_id,barang_nama,barang_satuan,barang_kategori_nama FROM tbl_barang where barang_co_id='$coid'");
		return $hsl;
	}
	
	function hapus_request_stok($kode){
		$hsl=$this->db->query("DELETE FROM tbl_req_stok where req_stok_no='$kode'"); //hapus tbl_req_stok
		$hsl=$this->db->query("DELETE FROM tbl_detail_reqstok where d_req_stok_no='$kode'"); //hapus tbl_req_stok
		return $hsl;
	}

	function tampil_reqstok(){
		$coid=$this->session->userdata('coid');
		$hsl=$this->db->query("SELECT req_stok_no,DATE_FORMAT(req_stok_tgl ,'%d %M %Y %H:%i:%s') as req_stok_tgl,proses_stok,proses_kirim,total_selisih,tbl_req_stok.created_by,regions.reg_name FROM tbl_req_stok JOIN regions ON tbl_req_stok.req_reg_id=regions.reg_id where req_co_id='$coid' order by DATE(req_stok_tgl) DESC");
		return $hsl;
	}

	function tampil_reqstokkasir(){
		$regid=$this->session->userdata('regid');
		$hsl=$this->db->query("SELECT req_stok_no,DATE_FORMAT(req_stok_tgl ,'%d %M %Y %H:%i:%s') as req_stok_tgl,proses_stok,proses_kirim,total_selisih,tbl_req_stok.created_by FROM tbl_req_stok where req_reg_id='$regid' order by DATE(req_stok_tgl) DESC");
		return $hsl;
	}

	function hapus_detail_stok($kode){
		$hsl=$this->db->query("DELETE FROM tbl_detail_reqstok where d_req_stok_id='$kode'"); 
		return $hsl;
	}
	
	function edit_detail_stok($kode,$qty){
		$user_nama=$this->session->userdata('nama');
		$hsl=$this->db->query("UPDATE tbl_detail_reqstok set d_req_stok_qty='$qty', updated_by='$user_nama',updated_at=now() where d_req_stok_id='$kode'");
		return $hsl;
	}

	function edit_detail_stok_kirim($kode, $stok_no, $kd_brg, $qty_baru) {
		$regid = $this->session->userdata('regid');
		$user_nama = $this->session->userdata('nama');
		//$hsl=$this->db->query("UPDATE tbl_detail_reqstok set kirim_qty='$qty_baru', updated_by='$user_nama',updated_at=now() where d_req_stok_id='$kode'");
		//$hsl=$this->db->query("UPDATE tbl_stok set stok_out='$qty_baru', updated_by='$user_nama',updated_at=now() where stok_no='$stok_no' AND brg_id='$kd_brg'");
		// Update tbl_detail_reqstok
		$this->db->set('kirim_qty', $qty_baru);
		$this->db->set('updated_by', $user_nama);
		$this->db->set('updated_at', 'NOW()', false);
		$this->db->where('d_req_stok_id', $kode);
		$hsl_detail_reqstok = $this->db->update('tbl_detail_reqstok');
		// Update tbl_stok
		$this->db->set('stok_out', $qty_baru);
		$this->db->set('updated_by', $user_nama);
		$this->db->set('updated_at', 'NOW()', false);
		$this->db->where('stok_no', $stok_no);
		$this->db->where('brg_id', $kd_brg);
		$hsl_tbl_stok = $this->db->update('tbl_stok');
		// Cek apakah kedua update berhasil
		if ($hsl_detail_reqstok && $hsl_tbl_stok) {
			return true;
		} else {
			return false;
		}
	}


	function add_detail_stok($noreq,$idbrg,$nm,$sat,$kat,$qty){
	$user_id=$this->session->userdata('idadmin');
	$regid=$this->session->userdata('regid');
	$coid=$this->session->userdata('coid');
	$user_nama=$this->session->userdata('nama');
	$ps=0;//proses stok
	$data=array(
			'd_req_stok_no' 		=>	$noreq,
			'd_barang_id'			=>	$idbrg,
			'd_barang_nama'			=>	$nm,
			'd_barang_satuan'		=>	$sat,
			'd_kategori_nama'		=>	$kat,
			'd_req_stok_qty'		=>	(float) $qty,
			'd_proses_stok'			=>	0,
			'd_proses_kirim'		=>	0,
			'selisih_qty'			=>	0,
			'd_req_user_id'			=>	$user_id,
			'd_req_reg_id'			=>	$regid,
			'd_req_co_id'			=>	$coid,
			'created_by'			=>  $user_nama,
			'created_at'			=>	date('Y-m-d H:i:s')
		);
		$this->db->insert('tbl_detail_reqstok',$data);
	return true;
	}

	function get_detail_stok($noid){
    $query = $this->db->query("SELECT d_barang_id, d_barang_nama,d_barang_satuan,d_kategori_nama,d_req_stok_qty FROM tbl_detail_reqstok WHERE d_req_stok_id='$noid'");
    if ($query->num_rows() > 0) {
        return $query->row_array();
    } else {
        return false;
    }
	}

	function get_req_stok($id){
		$this->db->select("a.req_stok_no,DATE_FORMAT(a.req_stok_tgl ,'%d %M %Y') as req_stok_tgl,a.proses_stok,a.proses_kirim,a.total_selisih,a.created_by,b.reg_name");
		$this->db->from('tbl_req_stok a');
		$this->db->join('regions b', 'b.reg_id = a.req_reg_id', 'left');
		$this->db->where('a.req_stok_no', $id);
		return $this->db->get();	
	}

	function get_reqstok($id){
		$coid=$this->session->userdata('coid');
		$regid=$this->session->userdata('regid');
		$select_columns = 'b.d_req_stok_id, b.d_barang_id, b.d_barang_nama, b.d_barang_satuan, b.d_kategori_nama, b.d_req_stok_qty, b.kirim_qty, b.konfirm_qty, b.selisih_qty';
		$select_columns .= ", 
			IFNULL(
				SUM(CASE WHEN s.stok_regid = '" .$regid. "' AND s.stok_in > 0 THEN s.stok_in ELSE 0 END) - 
				SUM(CASE WHEN s.stok_regid = '" .$regid. "' AND s.stok_out > 0 THEN s.stok_out ELSE 0 END), 0) 
			AS stok_cabang"; 
		
		$this->db->select($select_columns);
		$this->db->from('tbl_detail_reqstok b');
		$this->db->join('tbl_stok s', 'b.d_barang_id = s.brg_id', 'left');
		$this->db->where('b.d_req_stok_no', $id); // Tambahkan kondisi where untuk barang_id yang diinginkan
		$this->db->group_by('b.d_req_stok_id, b.d_barang_id, b.d_barang_nama, b.d_barang_satuan, b.d_kategori_nama, b.d_req_stok_qty, b.kirim_qty, b.konfirm_qty, b.selisih_qty');
		//return $this->db->get()->result();
		return $this->db->get();

	}
	
	function simpan_reqstok($noreqstok, $requestData){
	$user_id=$this->session->userdata('idadmin');
	$user_nama=$this->session->userdata('nama');
	$coid=$this->session->userdata('coid');
	$regid=$this->session->userdata('regid');
	$ps=0;//proses stok
	$pk=0;//proses kirim
	$ts=0;//total selisih
	$this->db->query("INSERT INTO tbl_req_stok(req_stok_no,req_user_id,req_reg_id,req_co_id,proses_stok,proses_kirim,total_selisih,created_by,created_at) VALUES ('$noreqstok','$user_id','$regid','$coid','$ps','$pk','$ts','$user_nama',now())");
	foreach ($requestData as $item) {
	$data=array(
			'd_req_stok_no' 	=>	$noreqstok,
			'd_barang_id'		=>	$item['id'],
			'd_barang_nama'		=>	$item['nama_barang'],
			'd_barang_satuan'	=>	$item['satuan'],
			'd_kategori_nama'	=>	$item['kategori'],
			'd_req_stok_qty'	=>	(float) $item['qty'],
			'd_proses_stok'		=>	0,
			'd_proses_kirim'	=>	0,
			'selisih_qty'		=>	0,
			'd_req_user_id'		=>	$user_id,
			'd_req_reg_id'		=>	$regid,
			'd_req_co_id'		=>	$coid,
			'created_by'		=>  $user_nama,
			'created_at'		=>	date('Y-m-d H:i:s')
		);
		$this->db->insert('tbl_detail_reqstok',$data);
	}
	return true;
	}

	function get_noreqstok(){
		$q = $this->db->query("SELECT MAX(RIGHT(req_stok_no,6)) AS kd_max FROM tbl_req_stok WHERE DATE(req_stok_tgl)=CURDATE()");
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
		return "RS".date('dmy').$kd;
	}

	function simpan_kirimstok($requestData,$nofakValue) {
		$user_id=$this->session->userdata('idadmin');
		$coid=$this->session->userdata('coid');
		$regid=$this->session->userdata('regid');
		$user_nama = $this->session->userdata('nama');
		$pk = '1'; // proses kirim
        foreach ($requestData as $item) {
            $nofak = $item['nofak'];
            $kode = $item['kode'];
            $qty = (float)$item['qty'];
			$kd_brg=$item['kode_barang'];
			$nm_brg= $item['nama_barang'];
			$sat= $item['satuan'];
			$kat= $item['kategori'];

            // Perbarui tbl_detail_reqstok
            $this->db->set('tgl_kirim', 'NOW()', false);
            $this->db->set('kirim_qty', $qty);
            $this->db->set('d_proses_kirim', $pk);
            $this->db->set('updated_by', $user_nama);
            $this->db->set('updated_at', 'NOW()', false);
            $this->db->where('d_req_stok_id', $kode);
            $hsl_detail = $this->db->update('tbl_detail_reqstok');

			//menyimpan pada tbl_stok
			$stok_out=array(
				'stok_no' 		=>	$nofak,
				'stok_ket'		=>	'Kirim_Stok',
				'stok_status'	=>	'out',
				'stok_tgl'		=>	date('Y-m-d H:i:s'),
				'brg_id'		=>	$kd_brg,
				'brg_nama'		=>	$nm_brg,
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

        }
			// Perbarui tbl_req_stok
            $this->db->set('proses_kirim', $pk);
            $this->db->set('updated_by', $user_nama);
            $this->db->set('updated_at', 'NOW()', false);
            $this->db->where('req_stok_no', $nofakValue);
            $hsl_reqstok = $this->db->update('tbl_req_stok');


        if ($hsl_detail && $hsl_reqstok) {
            return true;
        } else {
            return false;
        }
	}

	function simpan_konfirmstok($requestData,$nofakValue) {
		$user_id=$this->session->userdata('idadmin');
		$regid=$this->session->userdata('regid');
		$coid=$this->session->userdata('coid');
		$user_nama = $this->session->userdata('nama');
		$ps = '1'; // proses kirim
        $jml_selisih = 0; // Inisialisasi nilai awal
		foreach ($requestData as $item) {
            $nofak = $item['nofak'];
            $kode = $item['kode'];
            $k_qty = (float)$item['k_qty'];
			$qty = (float)$item['qty'];
			$kd_brg=$item['kode_barang'];
			$nm_brg= $item['nama_barang'];
			$sat= $item['satuan'];
			$kat= $item['kategori'];
			$jml_selisih+=$k_qty - $qty;
            // Perbarui tbl_detail_reqstok
            $this->db->set('tgl_konfirm', 'NOW()', false);
            $this->db->set('konfirm_qty', $qty);
			$this->db->set('selisih_qty', $k_qty - $qty);
            $this->db->set('d_proses_stok', $ps);
            $this->db->set('updated_by', $user_nama);
            $this->db->set('updated_at', 'NOW()', false);
            $this->db->where('d_req_stok_id', $kode);
            $hsl_detail = $this->db->update('tbl_detail_reqstok');

			//menyimpan pada tbl_stok
			$stok_in=array(
				'stok_no' 		=>	$nofak,
				'stok_ket'		=>	'Konfirm_Stok',
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

        }
		// Perbarui tbl_req_stok
            $this->db->set('proses_stok', $ps);
			$this->db->set('total_selisih', $jml_selisih);
            $this->db->set('updated_by', $user_nama);
            $this->db->set('updated_at', 'NOW()', false);
            $this->db->where('req_stok_no', $nofakValue);
            $hsl_reqstok = $this->db->update('tbl_req_stok');
		
		if ($hsl_detail && $hsl_reqstok) {
            return true;
        } else {
            return false;
        }
	}



}