<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_piutang extends CI_Model {

    
    function tampil_tempo($regid) {
        $select = "DATE_FORMAT(a.jual_tanggal, '%d %M %Y') AS jual_tanggal, a.jual_cust_nama, a.jual_nofak, a.jual_nota, a.jual_bayar, a.jual_bayar_status, a.jual_total,a.jual_bulan_tempo,a.jual_tgl_tempo,
                   DATEDIFF(CURDATE(), a.jual_tgl_tempo) AS telat_hari, SUM(b.bayar_jumlah) AS sudah_bayar,((a.jual_total) - SUM(b.bayar_jumlah)) AS kurang_bayar";
        $this->db->select($select);
        $this->db->from('tbl_jual a');
        $this->db->join('tbl_bayar b', 'b.bayar_nofak = a.jual_nofak', 'left');
        $this->db->where('a.jual_reg_id', $regid);
        $this->db->where('a.jual_bayar', 'Tempo');
        $this->db->where('a.jual_bayar_status !=', 'Lunas');
        $this->db->group_by('a.jual_nofak, a.jual_cust_nama');
        $this->db->order_by('a.jual_cust_nama ASC, DATE(a.jual_tanggal) ASC');
        //$this->db->order_by('a.jual_cust_nama', 'ASC');
        $result = $this->db->get()->result_array(); 
        return $result;
    }


    function tampil_rekap_tempo($regid) {
		$select_columns = 'a.jual_nofak, a.jual_cust_nama, a.jual_tanggal, a.jual_tgl_tempo,a.jual_bulan_tempo, a.jual_total,
                          SUM(b.bayar_jumlah) AS sudah_bayar,((a.jual_total) - SUM(b.bayar_jumlah)) AS kurang_bayar,
                          DATEDIFF(CURDATE(), a.jual_tgl_tempo) AS telat_hari,a.jual_kolek,c.kol_ket,c.kol_warna,c.stop_sales';
		$this->db->select($select_columns);
		$this->db->from('tbl_jual a');
        $this->db->join('tbl_bayar b', 'b.bayar_nofak = a.jual_nofak', 'left');
        $this->db->join('kolek c', 'c.kol_bln = a.jual_kolek', 'left');
        //$this->db->join('regions d', 'd.reg_id = a.jual_reg_id', 'left');
		$this->db->where('a.jual_reg_id', $regid);
        $this->db->where('a.jual_bayar', 'Tempo'); 
        $this->db->where('a.jual_bayar_status !=', 'Lunas');
        $this->db->group_by('a.jual_nofak, a.jual_cust_nama');
        //$this->db->order_by('a.jual_tanggal', 'DESC');
        $this->db->order_by('c.kol_bln', 'ASC');
		return $this->db->get();
    }

    function getjualbayar($nofak) { 
        $queryA = $this->db->query("SELECT bayar_nofak, DATE_FORMAT(bayar_tanggal, '%d %M %Y %H:%i:%s') AS bayar_tgl,bayar_tanggal,bayar_total, SUM(bayar_jumlah) AS tot_bayar,(bayar_total-SUM(bayar_jumlah)) AS kur_bayar,bayar_ket FROM tbl_bayar WHERE bayar_nofak = '$nofak' GROUP BY bayar_nofak");
        $queryB = $this->db->query("SELECT bayar_id, DATE_FORMAT(bayar_tgl_trans, '%d %M %Y %H:%i:%s') AS tgl_trans,bayar_jumlah FROM tbl_bayar WHERE bayar_nofak='$nofak'");
        $resultA = $queryA->row_array();
        $resultB = $queryB->result_array();
        return array('queryA' => $resultA, 'queryB' => $resultB);
    }

    function getdetailjual($nofak) {
		$hsl = $this->db->query("SELECT d_jual_nofak, d_jual_barang_id, d_jual_barang_nama, d_jual_barang_satuan, d_jual_qty, d_jual_barang_harjul, d_jual_diskon, d_jual_total,jual_tanggal,jual_cust_nama,jual_bayar,jual_bayar_status,jual_total FROM tbl_jual join tbl_detail_jual ON jual_nofak=d_jual_nofak  WHERE d_jual_nofak='$nofak' ORDER BY d_jual_barang_id ASC");
        return $hsl->result_array();
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


    function tampil_bayar($regid,$tgl1,$tgl2) {
    $query = "DATE_FORMAT(a.bayar_tgl_trans, '%d %M %Y %H:%i:%s') AS bayar_tgl_trans,a.bayar_nofak,b.jual_cust_nama,b.jual_nota,a.bayar_jumlah,a.bayar_ket,b.jual_bulan_tempo,b.jual_tgl_tempo";
        $this->db->select($query);
        $this->db->from('tbl_bayar a');
        $this->db->join('tbl_jual b', 'b.jual_nofak = a.bayar_nofak', 'left');
        $this->db->where('DATE(a.bayar_tgl_trans) >=', $tgl1);
        $this->db->where('DATE(a.bayar_tgl_trans) <=', $tgl2);
        $this->db->where('a.bayar_reg_id', $regid);
        $this->db->order_by('DATE(a.bayar_tgl_trans)', 'ASC');
        $result = $this->db->get()->result_array(); 
        return $result;
    }




}
