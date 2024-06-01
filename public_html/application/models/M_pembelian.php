<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_pembelian extends CI_Model{

	function simpan_pembelian($nofak,$tglfak,$suplier,$beli_kode){
		$idadmin=$this->session->userdata('idadmin');
		$user_nama=$this->session->userdata('nama');
		$regid=$this->session->userdata('regid');
		$coid=$this->session->userdata('coid');
		$namaspl = ($result = $this->db->where('suplier_id', $suplier)->get('tbl_suplier')->result()) ? $result[0]->suplier_nama : "null";
		//$this->db->query("INSERT INTO tbl_beli (beli_nofak,beli_tanggal,beli_suplier_id,beli_suplier_nama,beli_user_id,beli_regions_id,beli_co_id,beli_kode,created_by,created_at) VALUES ('$nofak','$tglfak','$suplier','$namaspl','$idadmin','$regid','$coid','$beli_kode','$user_nama',now())");
		$data_beli = array(
			'beli_nofak' => $nofak,
			'beli_tanggal' => $tglfak,
			'beli_suplier_id' => $suplier,
			'beli_suplier_nama' => $namaspl,
			'beli_user_id' => $idadmin,
			'beli_regions_id' => $regid,
			'beli_co_id' => $coid,
			'beli_kode' => $beli_kode,
			'created_by' => $user_nama,
			'created_at' => date('Y-m-d H:i:s')
		);
		$this->db->insert('tbl_beli', $data_beli);

		foreach ($this->cartbeli->contents() as $item) {
			$data=array(
				'd_beli_nofak' 			=>	$nofak,
				'd_beli_barang_id'		=>	$item['id'],
				'd_beli_barang_nama'	=>	$item['name'],
				'd_beli_barang_satuan'	=>	$item['satuan'],
				'd_beli_user_id'		=>	$idadmin,
				'd_beli_regions_id'		=>	$regid,
				'd_beli_co_id'	    	=>	$coid,
				'd_beli_harga'			=>	$item['price'],
				'd_beli_jumlah'			=>	$item['qty'],
				'd_beli_kode'			=>	$beli_kode,
				'proses_stok'			=>	'0',
				'status_stok'			=>	'0',
				'created_by'			=>	$user_nama,
				'created_at'			=>	date('Y-m-d H:i:s')
			);
			$this->db->insert('tbl_detail_beli',$data);
		}
		return true;
	}
	function get_kobel(){
		$q = $this->db->query("SELECT MAX(RIGHT(beli_kode,6)) AS kd_max FROM tbl_beli WHERE DATE(created_at)=CURDATE()");
        $kd = "";
        if($q->num_rows()>0){
            foreach($q->result() as $k){
                $tmp = ((int)$k->kd_max)+1;
                $kd = sprintf("%06s", $tmp);
            }
        }else{
            $kd = "000001";
        }
        return "BL".date('dmy').$kd;
	}
}