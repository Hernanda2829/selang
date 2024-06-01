<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_tempo extends CI_Model {

    function tampil_jual_tempo() {
		$coid=$this->session->userdata('coid');
		$select_columns = 'a.jual_nofak, a.jual_cust_nama, a.jual_tanggal, a.jual_tgl_tempo,a.jual_bulan_tempo, a.jual_total,
                          SUM(b.bayar_jumlah) AS sudah_bayar,((a.jual_total) - SUM(b.bayar_jumlah)) AS kurang_bayar,
                          DATEDIFF(CURDATE(), a.jual_tgl_tempo) AS telat_hari,a.jual_kolek,c.kol_ket,c.kol_warna,d.reg_name';
		$this->db->select($select_columns);
		$this->db->from('tbl_jual a');
        $this->db->join('tbl_bayar b', 'b.bayar_nofak = a.jual_nofak', 'left');
        $this->db->join('kolek c', 'c.kol_bln = a.jual_kolek', 'left');
        $this->db->join('regions d', 'd.reg_id = a.jual_reg_id', 'left');
		$this->db->where('a.jual_co_id', $coid);
        $this->db->where('a.jual_bayar', 'Tempo'); 
        $this->db->where('a.jual_bayar_status !=', 'Lunas');
        $this->db->group_by('a.jual_nofak,a.jual_cust_nama');
        $this->db->order_by('c.kol_bln', 'ASC');
		return $this->db->get();
    }

    function update_kolek() {
        $coid = $this->session->userdata('coid');
        // Query untuk mendapatkan data yang sesuai
        $select_columns = 'a.jual_nofak, a.jual_tgl_tempo, DATEDIFF(CURDATE(), a.jual_tgl_tempo) AS telat_hari';
        $this->db->select($select_columns);
        $this->db->from('tbl_jual a');
        $this->db->where('a.jual_co_id', $coid);
        $this->db->where('a.jual_bayar', 'Tempo');
        $this->db->where('a.jual_bayar_status !=', 'Lunas');
        $this->db->order_by('a.jual_tanggal', 'DESC');
        $result = $this->db->get()->result_array();

        // Query untuk mendapatkan nilai maksimal dari kolom kol_hari di tabel kolek
        $this->db->select_max('kol_hari');
        $this->db->from('kolek');
        $max_kol_hari_result = $this->db->get()->row();
        $max_kol_hari = ($max_kol_hari_result) ? $max_kol_hari_result->kol_hari : null;
        // Proses pembaruan
        foreach ($result as $row) {
            $telat_hari = $row['telat_hari'];
            // Menggunakan nilai maksimal jika telat_hari melebihi nilai maksimal
            $telat_hari = min($telat_hari, $max_kol_hari);
            // Query untuk mendapatkan warna dari tabel kolek
            $this->db->select('kol_bln');
            $this->db->from('kolek');
            $this->db->where('kol_hari >=', $telat_hari);
            $this->db->order_by('kol_hari', 'ASC');
            $this->db->limit(1);
            $kolek_result = $this->db->get()->row();
            // Gunakan nilai maksimal dari tabel kolek jika tidak ada hasil
            $kolbln = ($kolek_result) ? $kolek_result->kol_bln : null;
            // Update tabel tbl_jual
            $this->db->set('jual_kolek', $kolbln);
            $this->db->set('jual_hari_telat', $telat_hari);
            $this->db->where('jual_nofak', $row['jual_nofak']);
            $this->db->update('tbl_jual');
        }
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



    //--------------------------------------------------------------
    // function get_tahun_jual(){
	// 	$coid=$this->session->userdata('coid');
	// 	$hsl=$this->db->query("SELECT DISTINCT YEAR(jual_tanggal) AS tahun FROM tbl_jual WHERE jual_co_id='$coid'");
	// 	return $hsl;
	// }

    // function get_jumlah_bulan($tahun) {
    //     $tahun_sekarang = date('Y');
    //     if ($tahun < $tahun_sekarang) {
    //         return 12;
    //     } elseif ($tahun == $tahun_sekarang) {
    //         $bulan_sekarang = date('n');
    //         return $bulan_sekarang;
    //     }
    // }

    function tampil_kolek(){
		$coid=$this->session->userdata('coid');
		$hsl=$this->db->query("SELECT kol_id,kol_bln,kol_hari,kol_warna,kol_ket,stop_sales FROM kolek where kol_coid='$coid' order by kol_id ASC");
		return $hsl;
	}

    function tampil_tempo_rekap($thnbln) {
        $coid = $this->session->userdata('coid'); 
        // Menggunakan alias a, b, dan c untuk memudahkan penulisan
        $this->db->select("a.reg_id, a.reg_name,
            (
                COALESCE(
                    (SELECT SUM(b.jual_total) AS penjualan_tempo 
                    FROM tbl_jual b 
                    WHERE b.jual_reg_id = a.reg_id
                    AND b.jual_bayar = 'Tempo' 
                    AND b.jual_bayar_status != 'Lunas'
                    AND b.jual_kolek='1' 
                    AND DATE_FORMAT(b.jual_tanggal, '%Y-%m') <= '$thnbln'), 0
                ) -
                COALESCE(
                    (SELECT SUM(c.bayar_jumlah) AS sudah_bayar 
                    FROM tbl_jual b 
                    JOIN tbl_bayar c ON c.bayar_nofak = b.jual_nofak 
                    WHERE b.jual_reg_id = a.reg_id 
                    AND b.jual_bayar = 'Tempo'
                    AND b.jual_bayar_status != 'Lunas'
                    AND b.jual_kolek='1'
                    AND DATE_FORMAT(c.bayar_tgl_trans, '%Y-%m') <= '$thnbln'), 0)
            ) AS kol1,
            (
                COALESCE(
                    (SELECT SUM(b.jual_total) AS penjualan_tempo 
                    FROM tbl_jual b 
                    WHERE b.jual_reg_id = a.reg_id
                    AND b.jual_bayar = 'Tempo' 
                    AND b.jual_bayar_status != 'Lunas'
                    AND b.jual_kolek='2' 
                    AND DATE_FORMAT(b.jual_tanggal, '%Y-%m') <= '$thnbln'), 0
                ) -
                COALESCE(
                    (SELECT SUM(c.bayar_jumlah) AS sudah_bayar 
                    FROM tbl_jual b 
                    JOIN tbl_bayar c ON c.bayar_nofak = b.jual_nofak 
                    WHERE b.jual_reg_id = a.reg_id 
                    AND b.jual_bayar = 'Tempo'
                    AND b.jual_bayar_status != 'Lunas'
                    AND b.jual_kolek='2'
                    AND DATE_FORMAT(c.bayar_tgl_trans, '%Y-%m') <= '$thnbln'), 0)
            ) AS kol2,
            (
                COALESCE(
                    (SELECT SUM(b.jual_total) AS penjualan_tempo 
                    FROM tbl_jual b 
                    WHERE b.jual_reg_id = a.reg_id
                    AND b.jual_bayar = 'Tempo' 
                    AND b.jual_bayar_status != 'Lunas'
                    AND b.jual_kolek='3' 
                    AND DATE_FORMAT(b.jual_tanggal, '%Y-%m') <= '$thnbln'), 0
                ) -
                COALESCE(
                    (SELECT SUM(c.bayar_jumlah) AS sudah_bayar 
                    FROM tbl_jual b 
                    JOIN tbl_bayar c ON c.bayar_nofak = b.jual_nofak 
                    WHERE b.jual_reg_id = a.reg_id 
                    AND b.jual_bayar = 'Tempo'
                    AND b.jual_bayar_status != 'Lunas'
                    AND b.jual_kolek='3'
                    AND DATE_FORMAT(c.bayar_tgl_trans, '%Y-%m') <= '$thnbln'), 0)
            ) AS kol3,
            (
                COALESCE(
                    (SELECT SUM(b.jual_total) AS penjualan_tempo 
                    FROM tbl_jual b 
                    WHERE b.jual_reg_id = a.reg_id
                    AND b.jual_bayar = 'Tempo' 
                    AND b.jual_bayar_status != 'Lunas'
                    AND b.jual_kolek='4' 
                    AND DATE_FORMAT(b.jual_tanggal, '%Y-%m') <= '$thnbln'), 0
                ) -
                COALESCE(
                    (SELECT SUM(c.bayar_jumlah) AS sudah_bayar 
                    FROM tbl_jual b 
                    JOIN tbl_bayar c ON c.bayar_nofak = b.jual_nofak 
                    WHERE b.jual_reg_id = a.reg_id 
                    AND b.jual_bayar = 'Tempo'
                    AND b.jual_bayar_status != 'Lunas'
                    AND b.jual_kolek='4'
                    AND DATE_FORMAT(c.bayar_tgl_trans, '%Y-%m') <= '$thnbln'), 0)
            ) AS kol4,
            (
                COALESCE(
                    (SELECT SUM(b.jual_total) AS penjualan_tempo 
                    FROM tbl_jual b 
                    WHERE b.jual_reg_id = a.reg_id
                    AND b.jual_bayar = 'Tempo' 
                    AND b.jual_bayar_status != 'Lunas'
                    AND b.jual_kolek='5' 
                    AND DATE_FORMAT(b.jual_tanggal, '%Y-%m') <= '$thnbln'), 0
                ) -
                COALESCE(
                    (SELECT SUM(c.bayar_jumlah) AS sudah_bayar 
                    FROM tbl_jual b 
                    JOIN tbl_bayar c ON c.bayar_nofak = b.jual_nofak 
                    WHERE b.jual_reg_id = a.reg_id 
                    AND b.jual_bayar = 'Tempo'
                    AND b.jual_bayar_status != 'Lunas'
                    AND b.jual_kolek='5'
                    AND DATE_FORMAT(c.bayar_tgl_trans, '%Y-%m') <= '$thnbln'), 0)
            ) AS kol5"
        );

        $this->db->from('regions a');
        $this->db->join('tbl_jual b', 'b.jual_co_id = a.reg_co_id', 'left');
        $this->db->where('a.reg_co_id', $coid);
        $this->db->group_by('a.reg_name');
        $this->db->order_by('a.reg_id', 'ASC');
        $result = $this->db->get()->result_array();
        return $result;

    }

    function tampil_tempo_cabang($regid, $thnbln) {
        $select = "DATE_FORMAT(a.jual_tanggal, '%d/%m/%Y') AS jual_tanggal, 
                a.jual_cust_nama, 
                a.jual_nofak, 
                a.jual_nota, 
                a.jual_bayar, 
                a.jual_bayar_status, 
                a.jual_total, 
                a.jual_bulan_tempo,
                a.jual_kolek, 
                DATE_FORMAT(a.jual_tgl_tempo, '%d/%m/%Y') AS jual_tgl_tempo, 
                DATEDIFF(CURDATE(), a.jual_tgl_tempo) AS telat_hari, 
                COALESCE(
                        (SELECT SUM(b.bayar_jumlah) AS sudah_bayar 
                        FROM tbl_bayar b 
                        WHERE b.bayar_nofak = a.jual_nofak 
                        AND DATE_FORMAT(b.bayar_tgl_trans, '%Y-%m') <= '$thnbln'), 
                        0
                ) AS sudah_bayar,
                (a.jual_total - COALESCE(
                        (SELECT SUM(b.bayar_jumlah) AS sudah_bayar 
                        FROM tbl_bayar b 
                        WHERE b.bayar_nofak = a.jual_nofak 
                        AND DATE_FORMAT(b.bayar_tgl_trans, '%Y-%m') <= '$thnbln'), 
                        0
                )) AS kurang_bayar";

        $this->db->select($select);
        $this->db->from('tbl_jual a');
        $this->db->where('a.jual_reg_id', $regid);
        $this->db->where('a.jual_bayar', 'Tempo');
        $this->db->where('a.jual_bayar_status !=', 'Lunas');
        $this->db->where("DATE_FORMAT(a.jual_tanggal, '%Y-%m') <=", $thnbln);
        $this->db->group_by('a.jual_nofak, a.jual_cust_nama');
        $this->db->order_by('DATE(a.jual_tanggal) DESC');
        //$this->db->order_by('DATE(a.jual_tanggal) ASC');
        $result = $this->db->get()->result_array();
        return $result;
    }

    function tampil_tempo_cabang_admin($thnbln) {
    $coid=$this->session->userdata('coid');
        $select = "DATE_FORMAT(a.jual_tanggal, '%d/%m/%Y') AS jual_tanggal, 
                a.jual_cust_nama, 
                a.jual_nofak, 
                a.jual_nota, 
                a.jual_bayar, 
                a.jual_bayar_status, 
                a.jual_total, 
                a.jual_bulan_tempo,
                a.jual_kolek, 
                DATE_FORMAT(a.jual_tgl_tempo, '%d/%m/%Y') AS jual_tgl_tempo, 
                DATEDIFF(CURDATE(), a.jual_tgl_tempo) AS telat_hari, 
                COALESCE(
                        (SELECT SUM(b.bayar_jumlah) AS sudah_bayar 
                        FROM tbl_bayar b 
                        WHERE b.bayar_nofak = a.jual_nofak 
                        AND DATE_FORMAT(b.bayar_tgl_trans, '%Y-%m') <= '$thnbln'), 
                        0
                ) AS sudah_bayar,
                (a.jual_total - COALESCE(
                        (SELECT SUM(b.bayar_jumlah) AS sudah_bayar 
                        FROM tbl_bayar b 
                        WHERE b.bayar_nofak = a.jual_nofak 
                        AND DATE_FORMAT(b.bayar_tgl_trans, '%Y-%m') <= '$thnbln'), 
                        0
                )) AS kurang_bayar";

        $this->db->select($select);
        $this->db->from('tbl_jual a');
        $this->db->where('a.jual_co_id', $coid);
        $this->db->where('a.jual_bayar', 'Tempo');
        $this->db->where('a.jual_bayar_status !=', 'Lunas');
        $this->db->where("DATE_FORMAT(a.jual_tanggal, '%Y-%m') <=", $thnbln);
        $this->db->group_by('a.jual_nofak, a.jual_cust_nama');
        $this->db->order_by('DATE(a.jual_tanggal) DESC');
        //$this->db->order_by('DATE(a.jual_tanggal) ASC');
        $result = $this->db->get()->result_array();
        return $result;
    }



}
