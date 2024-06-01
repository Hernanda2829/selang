<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_jual extends CI_Model {

    function getPenjualanData() {
        $coid=$this->session->userdata('coid');
        //$result = $this->db->query("SELECT jual_nofak, DATE_FORMAT(jual_tanggal, '%d %M %Y %H:%i:%s') AS jual_tanggal, jual_total FROM tbl_jual ORDER BY jual_nofak DESC; ");
        $result = $this->db->query("SELECT jual_nofak, DATE_FORMAT(jual_tanggal, '%d %M %Y %H:%i:%s') AS jual_tanggal,jual_bayar,jual_bayar_status,jual_total,tbl_jual.created_by,regions.reg_name,jual_cust_nama FROM tbl_jual JOIN regions ON tbl_jual.jual_reg_id=regions.reg_id WHERE jual_co_id='$coid' ORDER BY jual_tanggal DESC");
        return $result->result_array();  // Ambil hasil query sebagai array asosiatif
    }

    function getPenjualanDataByRegion($reg_id) {
        //$result = $this->db->query("SELECT jual_nofak, DATE_FORMAT(jual_tanggal, '%d %M %Y %H:%i:%s') AS jual_tanggal, jual_total FROM tbl_jual WHERE jual_reg_id='$reg_id' ORDER BY jual_nofak DESC; ");
        $result = $this->db->query("SELECT jual_nofak, DATE_FORMAT(jual_tanggal, '%d %M %Y %H:%i:%s') AS jual_tanggal,jual_bayar,jual_bayar_status,jual_total,jual_user_id,tbl_jual.created_by,regions.reg_name,jual_cust_nama FROM tbl_jual JOIN regions ON tbl_jual.jual_reg_id=regions.reg_id WHERE jual_reg_id='$reg_id' ORDER BY jual_tanggal DESC");
        return $result->result_array();  // Ambil hasil query sebagai array asosiatif
    }

    function getDetailData() {
        $result = $this->db->query("SELECT d_jual_nofak, d_jual_barang_id, d_jual_barang_nama, d_jual_barang_satuan, d_jual_qty, d_jual_barang_harpok, d_jual_barang_harjul, d_jual_diskon, d_jual_total FROM tbl_detail_jual ORDER BY d_jual_nofak DESC");
        return $result->result_array();  // Ambil hasil query sebagai array asosiatif
    }

    function get_faktur($nofak,$userid){
		$hsl=$this->db->query("SELECT jual_nofak,DATE_FORMAT(jual_tanggal,'%d/%m/%Y %H:%i:%s') AS jual_tanggal,jual_nota,jual_total,jual_jml_uang,jual_kembalian,jual_bayar,jual_kurang_bayar,d_jual_barang_id,d_jual_barang_nama,d_jual_barang_satuan,d_jual_barang_harjul,d_jual_qty,d_jual_diskon,d_jual_total,jual_cust_nama,group_id,group_desc,group_sat FROM tbl_jual JOIN tbl_detail_jual ON jual_nofak=d_jual_nofak WHERE jual_nofak='$nofak' AND jual_user_id='$userid'");
		return $hsl;
	}

    function get_fakturAdmin($nofak,$userid){
		$hsl=$this->db->query("SELECT jual_nofak,DATE_FORMAT(jual_tanggal,'%d/%m/%Y %H:%i:%s') AS jual_tanggal,jual_nota,jual_total,jual_jml_uang,jual_kembalian,jual_bayar,jual_kurang_bayar,d_jual_barang_id,d_jual_barang_nama,d_jual_barang_satuan,d_jual_barang_harjul,d_jual_qty,d_jual_diskon,d_jual_total,jual_cust_nama,group_id,group_desc,group_sat FROM tbl_jual JOIN tbl_detail_jual ON jual_nofak=d_jual_nofak WHERE jual_nofak='$nofak'");
		return $hsl;
	}

    function getjualbayar($nofak) { 
        $queryA = $this->db->query("SELECT bayar_reg_id,bayar_nofak, DATE_FORMAT(bayar_tanggal, '%d %M %Y %H:%i:%s') AS bayar_tgl,bayar_tanggal,bayar_total, SUM(bayar_jumlah) AS tot_bayar,(bayar_total-SUM(bayar_jumlah)) AS kur_bayar,bayar_ket FROM tbl_bayar WHERE bayar_nofak = '$nofak' GROUP BY bayar_nofak");
        $queryB = $this->db->query("SELECT bayar_id, DATE_FORMAT(bayar_tgl_trans, '%d %M %Y %H:%i:%s') AS tgl_trans,bayar_jumlah FROM tbl_bayar WHERE bayar_nofak='$nofak'");
        $resultA = $queryA->row_array();
        $resultB = $queryB->result_array();
        return array('queryA' => $resultA, 'queryB' => $resultB);
    }

    function tambahbayar($nofak,$tglbyr,$totbyr,$jmlbyr,$ket) {
        $user_id=$this->session->userdata('idadmin');
        $user_nama=$this->session->userdata('nama');
        $coid=$this->session->userdata('coid');
        $regid=$this->session->userdata('regid');
        //menyimpan pada tbl_bayar
        $data=array(
            'bayar_nofak' 		=>	$nofak,
            'bayar_tanggal'		=>	$tglbyr,
            'bayar_total'	    =>	$totbyr,
            'bayar_tgl_trans'	=>	date('Y-m-d H:i:s'),
            'bayar_jumlah'		=>	$jmlbyr,
            'bayar_ket'		    =>	$ket,
            'bayar_reg_id'		=>	$regid,
            'bayar_co_id'		=>	$coid,
            'bayar_user_id'		=>	$user_id,
            'created_by'	    =>  $user_nama,
            'created_at'	    =>	date('Y-m-d H:i:s')
        );
        $this->db->insert('tbl_bayar',$data);
        if ($ket=="Lunas"){
            //update tbl_bayar
            $this->db->set('bayar_ket', $ket);
            $this->db->set('updated_by', $user_nama);
            $this->db->set('updated_at', 'NOW()', false);
            $this->db->where('bayar_nofak', $nofak);
            $hsl = $this->db->update('tbl_bayar');
            //update tbl_jual
            $this->db->set('jual_bayar_status', $ket);
            $this->db->set('tanggal_lunas', date('Y-m-d H:i:s'));
            $this->db->set('updated_by', $user_nama);
            $this->db->set('updated_at', 'NOW()', false);
            $this->db->where('jual_nofak', $nofak);
            $hsl = $this->db->update('tbl_jual');
            //update tbl_garansi
            $this->db->set('g_status_bayar', $ket);
            $this->db->set('updated_by', $user_nama);
            $this->db->set('updated_at', 'NOW()', false);
            $this->db->where('g_nofak', $nofak);
            $hsl = $this->db->update('tbl_garansi');
        }
        return true;
	}

    function tambah_bayar_admin($nofak,$tglbyr,$totbyr,$jmlbyr,$ket,$tgltrans,$regid) {
        $user_id=$this->session->userdata('idadmin');
        $user_nama=$this->session->userdata('nama');
        $coid=$this->session->userdata('coid');
        //menyimpan pada tbl_bayar
        $data=array(
            'bayar_nofak' 		=>	$nofak,
            'bayar_tanggal'		=>	$tglbyr,
            'bayar_total'	    =>	$totbyr,
            'bayar_tgl_trans'	=>	$tgltrans,
            'bayar_jumlah'		=>	$jmlbyr,
            'bayar_ket'		    =>	$ket,
            'bayar_reg_id'		=>	$regid,
            'bayar_co_id'		=>	$coid,
            'bayar_user_id'		=>	$user_id,
            'created_by'	    =>  $user_nama,
            'created_at'	    =>	date('Y-m-d H:i:s')
        );
        $this->db->insert('tbl_bayar',$data);
        if ($ket=="Lunas"){
            //update tbl_bayar
            $this->db->set('bayar_ket', $ket);
            $this->db->set('updated_by', $user_nama);
            $this->db->set('updated_at', 'NOW()', false);
            $this->db->where('bayar_nofak', $nofak);
            $hsl = $this->db->update('tbl_bayar');
            //update tbl_jual
            $this->db->set('jual_bayar_status', $ket);
            $this->db->set('tanggal_lunas', date('Y-m-d H:i:s'));
            $this->db->set('updated_by', $user_nama);
            $this->db->set('updated_at', 'NOW()', false);
            $this->db->where('jual_nofak', $nofak);
            $hsl = $this->db->update('tbl_jual');
            //update tbl_garansi
            $this->db->set('g_status_bayar', $ket);
            $this->db->set('updated_by', $user_nama);
            $this->db->set('updated_at', 'NOW()', false);
            $this->db->where('g_nofak', $nofak);
            $hsl = $this->db->update('tbl_garansi');
        }
        return true;
	}

    function hapus_penjualan($kode){
		//$hsl=$this->db->query("DELETE FROM tbl_jual where jual_nofak='$kode'");
        //$hsl=$this->db->query("DELETE FROM tbl_detail_jual where d_jual_nofak='$kode'");
        //$hsl=$this->db->query("DELETE FROM tbl_bayar where bayar_nofak='$kode'");
        //$hsl=$this->db->query("DELETE FROM tbl_garansi where g_nofak='$kode'");
        //$hsl=$this->db->query("DELETE FROM tbl_stok where stok_no='$kode'");
        //$hsl=$this->db->query("DELETE FROM tbl_jual_markup where jual_nofak='$kode'");
        //$hsl=$this->db->query("DELETE FROM tbl_detail_jual_markup where d_jual_nofak='$kode'");
		//return $hsl;

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


}
