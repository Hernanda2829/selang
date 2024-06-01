<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_keuangan extends CI_Model {

    function get_bulan_jual(){
		$coid=$this->session->userdata('coid');
		$hsl=$this->db->query("SELECT DISTINCT DATE_FORMAT(jual_tanggal,'%M %Y') AS bulan FROM tbl_jual WHERE jual_co_id='$coid' ORDER BY DATE_FORMAT(jual_tanggal, '%Y-%m') DESC");
		return $hsl;
	}

	function tampil_keuangan($regid,$thnbln) {
        $b1 = strtotime('-1 month', strtotime($thnbln . '-01'));    // Mengurangi 1 bulan
        $thnbln1 = sprintf('%04d-%02d', date('Y', $b1), date('n', $b1));

        $select_columns = "a.reg_id, a.reg_name,";
        $kategori = $this->db->distinct()->select('kategori_report')->get('tbl_kategori')->result_array();
        foreach ($kategori as $k) {
            $kat = preg_replace('/[^a-zA-Z0-9_]/', '', $k['kategori_report']);
            $select_columns .= "(SELECT COALESCE(SUM(b.d_jual_total), 0)
                                FROM tbl_detail_jual b 
                                JOIN tbl_kategori e ON e.kategori_nama = b.d_jual_kategori_nama
                                WHERE b.d_jual_reg_id = a.reg_id AND e.kategori_report = '$kat'
                                AND DATE_FORMAT(b.d_jual_tanggal, '%Y-%m') = '$thnbln') AS omzet$kat,
                                ";
        }
            $select_columns .="(SELECT COALESCE(SUM(c.jual_total), 0) AS piutang
                                    FROM tbl_jual c 
                                    WHERE c.jual_reg_id = a.reg_id 
                                    AND c.jual_bayar = 'Tempo'
                                    AND DATE_FORMAT(c.jual_tanggal, '%Y-%m') = '$thnbln') AS piutang,
                                (SELECT COALESCE(SUM(c.jual_total), 0) AS penjualan_tunai
                                    FROM tbl_jual c 
                                    WHERE c.jual_reg_id = a.reg_id 
                                    AND c.jual_bayar = 'Cash' 
                                    AND c.jual_bayar_status = 'Lunas' 
                                    AND DATE_FORMAT(c.jual_tanggal, '%Y-%m') = '$thnbln') AS penjualan_tunai,
                            (SELECT COALESCE(SUM(c.jual_total), 0) AS piutangA
                                    FROM tbl_jual c 
                                    WHERE c.jual_reg_id = a.reg_id 
                                    AND c.jual_bayar = 'Tempo'
                                    AND DATE_FORMAT(c.jual_tanggal, '%Y-%m') <= '$thnbln1') AS piutangA,
                            (SELECT COALESCE(SUM(d.bayar_jumlah), 0) AS sudah_bayarA
                                FROM tbl_jual c JOIN tbl_bayar d ON d.bayar_nofak = c.jual_nofak
                                WHERE c.jual_reg_id = a.reg_id 
                                AND c.jual_bayar = 'Tempo'
                                AND DATE_FORMAT(d.bayar_tgl_trans, '%Y-%m') <= '$thnbln1') AS sudah_bayarA,
                            (SELECT COALESCE(SUM(c.jual_total), 0) AS piutangB
                                    FROM tbl_jual c 
                                    WHERE c.jual_reg_id = a.reg_id 
                                    AND c.jual_bayar = 'Tempo'
                                    AND c.jual_bayar_status != 'Lunas'
                                    AND DATE_FORMAT(c.jual_tanggal, '%Y-%m') = '$thnbln') AS piutangB,
                            (SELECT COALESCE(SUM(d.bayar_jumlah), 0) AS sudah_bayarB
                                FROM tbl_jual c JOIN tbl_bayar d ON d.bayar_nofak = c.jual_nofak
                                WHERE c.jual_reg_id = a.reg_id 
                                AND c.jual_bayar = 'Tempo'
                                AND DATE_FORMAT(d.bayar_tgl_trans, '%Y-%m') = '$thnbln') AS sudah_bayarB,
                            (SELECT COALESCE(SUM(d.bayar_jumlah), 0) AS sudah_bayar
                                FROM tbl_jual c JOIN tbl_bayar d ON d.bayar_nofak = c.jual_nofak
                                WHERE c.jual_reg_id = a.reg_id 
                                AND c.jual_bayar = 'Tempo'
                                AND DATE_FORMAT(d.bayar_tgl_trans, '%Y-%m') = '$thnbln') AS sudah_bayar,";
        
        //$kategori_beban = $this->db->select('kat_id')->get('tbl_beban_kat')->result_array();
        $kategori_beban = $this->db->select('kat_id')->where('kat_report', 'Yes')->get('tbl_beban_kat')->result_array();
        foreach ($kategori_beban as $b) {
            //$kat_beb = preg_replace('/[^a-zA-Z0-9_]/', '', $b['kat_nama']);
            $kat_beb = $b['kat_id'];
            $select_columns .= "(SELECT COALESCE(SUM(e.beban_jumlah), 0) AS beban
                                FROM tbl_beban_opr e
                                WHERE e.beban_reg_id = a.reg_id
                                AND e.beban_kat_id = '$kat_beb'
                                AND DATE_FORMAT(e.beban_tanggal, '%Y-%m') = '$thnbln') AS beban$kat_beb,
                                ";
        }
        
        //penambahan untuk menghitung Saldo Akhir Bulan Kemarin
        $select_columns .= "(COALESCE(
                        (SELECT SUM(c.jual_total) AS penjualan_tunai_kemarin
                         FROM tbl_jual c 
                         WHERE c.jual_reg_id = a.reg_id 
                           AND c.jual_bayar = 'Cash' 
                           AND c.jual_bayar_status = 'Lunas' 
                           AND DATE_FORMAT(c.jual_tanggal, '%Y-%m') <= '$thnbln1'), 0
                     ) +
                     COALESCE(
                        (SELECT SUM(d.bayar_jumlah) AS sudah_bayar_kemarin
                         FROM tbl_jual c 
                         JOIN tbl_bayar d ON d.bayar_nofak = c.jual_nofak
                         WHERE c.jual_reg_id = a.reg_id 
                           AND c.jual_bayar = 'Tempo'
                           AND DATE_FORMAT(d.bayar_tgl_trans, '%Y-%m') <= '$thnbln1'), 0
                     ) -
                     COALESCE(
                        (SELECT SUM(e.beban_jumlah) AS beban_kemarin
                         FROM tbl_beban_opr e
                         WHERE e.beban_reg_id = a.reg_id
                           AND e.beban_kat_nama != 'Transfer'
                           AND DATE_FORMAT(e.beban_tanggal, '%Y-%m') <= '$thnbln1'), 0
                     ) -
                     COALESCE(
                        (SELECT SUM(e.beban_jumlah) AS transfer_kemarin
                         FROM tbl_beban_opr e
                         WHERE e.beban_reg_id = a.reg_id
                           AND e.beban_kat_nama = 'Transfer'
                           AND DATE_FORMAT(e.beban_tanggal, '%Y-%m') <= '$thnbln1'), 0
                     )
                ) AS saldo_akhir";




        // AND c.jual_bayar_status = 'Belum Lunas' //untuk piutang yang belum lunas, kalo lunas nanti tidak terhitung
        //$select_columns = rtrim($select_columns, ','); // Remove the trailing comma
        $this->db->select($select_columns);
        $this->db->from('regions a');
        $this->db->join('tbl_detail_jual b', 'b.d_jual_reg_id = a.reg_id', 'left');
        //$this->db->join('tbl_jual c', 'c.jual_nofak = b.d_jual_nofak', 'left');
        //$this->db->join('tbl_bayar d', 'd.bayar_nofak = c.jual_nofak', 'left');
        //$this->db->join('tbl_beban_opr e', 'e.beban_reg_id = a.reg_id', 'left');
        $this->db->where('a.reg_id', $regid);
        $this->db->group_by('a.reg_id, a.reg_name');
        
        // $result = $this->db->get();
        // if (!$result) {
        //     $error_message = $this->db->error();
        //     echo "Query error: " . $error_message['message'];
        //     exit;
        // }
        //return $result;
        
        $result = $this->db->get()->result_array(); 
        return $result;

        
    }

    function tampil_transfer($regid,$thnbln) {
        $query = "a.beban_jumlah , a.beban_nama, a.beban_kat_nama";
        $this->db->select($query);
        $this->db->from('tbl_beban_opr a');
        $this->db->where("DATE_FORMAT(a.beban_tanggal, '%Y-%m') = '$thnbln'");
        $this->db->where('a.beban_reg_id', $regid);
        $this->db->where('a.beban_kat_nama','Transfer');
        $this->db->order_by('DATE(a.beban_tanggal)', 'ASC');
        $result = $this->db->get();

        if (!$result) {
            $error_message = $this->db->error();
            echo "Query error: " . $error_message['message'];
            exit;
        }

        return $result->result_array(); // Mengembalikan hasil query sebagai array
    }






    function tampil_keuangan_admin($thnbln) {
        $coid=$this->session->userdata('coid');
        $b1 = strtotime('-1 month', strtotime($thnbln . '-01'));    // Mengurangi 1 bulan
        $thnbln1 = sprintf('%04d-%02d', date('Y', $b1), date('n', $b1));

        $select_columns = "a.reg_co_id,";
        $kategori = $this->db->distinct()->select('kategori_report')->get('tbl_kategori')->result_array();
        foreach ($kategori as $k) {
            $kat = preg_replace('/[^a-zA-Z0-9_]/', '', $k['kategori_report']);
            $select_columns .= "(SELECT COALESCE(SUM(b.d_jual_total), 0)
                                FROM tbl_detail_jual b 
                                JOIN tbl_kategori e ON e.kategori_nama = b.d_jual_kategori_nama 
                                WHERE b.d_jual_co_id = a.reg_co_id AND e.kategori_report = '$kat' 
                                AND DATE_FORMAT(b.d_jual_tanggal, '%Y-%m') = '$thnbln') AS omzet$kat,
                                ";
        }
            $select_columns .="(SELECT COALESCE(SUM(c.jual_total), 0) AS piutang
                                    FROM tbl_jual c 
                                    WHERE c.jual_co_id = a.reg_co_id 
                                    AND c.jual_bayar = 'Tempo'
                                    AND DATE_FORMAT(c.jual_tanggal, '%Y-%m') = '$thnbln') AS piutang,
                                (SELECT COALESCE(SUM(c.jual_total), 0) AS penjualan_tunai
                                    FROM tbl_jual c 
                                    WHERE c.jual_co_id = a.reg_co_id 
                                    AND c.jual_bayar = 'Cash' 
                                    AND c.jual_bayar_status = 'Lunas' 
                                    AND DATE_FORMAT(c.jual_tanggal, '%Y-%m') = '$thnbln') AS penjualan_tunai,
                            (SELECT COALESCE(SUM(c.jual_total), 0) AS piutangA
                                    FROM tbl_jual c 
                                    WHERE c.jual_co_id = a.reg_co_id 
                                    AND c.jual_bayar = 'Tempo'
                                    AND DATE_FORMAT(c.jual_tanggal, '%Y-%m') <= '$thnbln1') AS piutangA,
                            (SELECT COALESCE(SUM(d.bayar_jumlah), 0) AS sudah_bayarA
                                FROM tbl_jual c JOIN tbl_bayar d ON d.bayar_nofak = c.jual_nofak
                                WHERE c.jual_co_id = a.reg_co_id 
                                AND c.jual_bayar = 'Tempo'
                                AND DATE_FORMAT(d.bayar_tgl_trans, '%Y-%m') <= '$thnbln1') AS sudah_bayarA,
                            (SELECT COALESCE(SUM(c.jual_total), 0) AS piutangB
                                    FROM tbl_jual c 
                                    WHERE c.jual_co_id = a.reg_co_id 
                                    AND c.jual_bayar = 'Tempo'
                                    AND c.jual_bayar_status != 'Lunas'
                                    AND DATE_FORMAT(c.jual_tanggal, '%Y-%m') = '$thnbln') AS piutangB,
                            (SELECT COALESCE(SUM(d.bayar_jumlah), 0) AS sudah_bayarB
                                FROM tbl_jual c JOIN tbl_bayar d ON d.bayar_nofak = c.jual_nofak
                                WHERE c.jual_co_id = a.reg_co_id 
                                AND c.jual_bayar = 'Tempo'
                                AND DATE_FORMAT(d.bayar_tgl_trans, '%Y-%m') = '$thnbln') AS sudah_bayarB,
                            (SELECT COALESCE(SUM(d.bayar_jumlah), 0) AS sudah_bayar
                                FROM tbl_jual c JOIN tbl_bayar d ON d.bayar_nofak = c.jual_nofak
                                WHERE c.jual_co_id = a.reg_co_id 
                                AND c.jual_bayar = 'Tempo'
                                AND DATE_FORMAT(d.bayar_tgl_trans, '%Y-%m') = '$thnbln') AS sudah_bayar,";
        
        //$kategori_beban = $this->db->select('kat_id')->get('tbl_beban_kat')->result_array();
        $kategori_beban = $this->db->select('kat_id')->where('kat_report', 'Yes')->get('tbl_beban_kat')->result_array();
        foreach ($kategori_beban as $b) {
            //$kat_beb = preg_replace('/[^a-zA-Z0-9_]/', '', $b['kat_nama']);
            $kat_beb = $b['kat_id'];
            $select_columns .= "(SELECT COALESCE(SUM(e.beban_jumlah), 0) AS beban
                                FROM tbl_beban_opr e
                                WHERE e.beban_co_id = a.reg_co_id
                                AND e.beban_kat_id = '$kat_beb'
                                AND DATE_FORMAT(e.beban_tanggal, '%Y-%m') = '$thnbln') AS beban$kat_beb,
                                ";
        }

        //penambahan untuk menghitung Saldo Akhir Bulan Kemarin
        $select_columns .= "(
                            COALESCE(
                                (SELECT SUM(c.jual_total) AS penjualan_tunai_kemarin 
                                FROM tbl_jual c 
                                WHERE c.jual_co_id = a.reg_co_id
                                AND c.jual_bayar = 'Cash' 
                                AND c.jual_bayar_status = 'Lunas' 
                                AND DATE_FORMAT(c.jual_tanggal, '%Y-%m') <= '$thnbln1'), 0
                            ) +
                            COALESCE(
                                (SELECT SUM(d.bayar_jumlah) AS sudah_bayar_kemarin 
                                FROM tbl_jual c 
                                JOIN tbl_bayar d ON d.bayar_nofak = c.jual_nofak 
                                WHERE c.jual_co_id = a.reg_co_id 
                                AND c.jual_bayar = 'Tempo' 
                                AND DATE_FORMAT(d.bayar_tgl_trans, '%Y-%m') <= '$thnbln1'), 0
                            ) -
                            COALESCE(
                                (SELECT SUM(e.beban_jumlah) AS beban_kemarin 
                                FROM tbl_beban_opr e 
                                WHERE e.beban_co_id = a.reg_co_id 
                                AND e.beban_kat_nama != 'Transfer' 
                                AND DATE_FORMAT(e.beban_tanggal, '%Y-%m') <= '$thnbln1'), 0
                            ) -
                            COALESCE(
                                (SELECT SUM(e.beban_jumlah) AS transfer_kemarin 
                                FROM tbl_beban_opr e 
                                WHERE e.beban_co_id = a.reg_co_id 
                                AND e.beban_kat_nama = 'Transfer' 
                                AND DATE_FORMAT(e.beban_tanggal, '%Y-%m') <= '$thnbln1'), 0
                            )
                        ) AS saldo_akhir";                       
                                
        
        //$select_columns = rtrim($select_columns, ','); // Remove the trailing comma
        $this->db->select($select_columns);
        $this->db->from('regions a');
        $this->db->join('tbl_detail_jual b', 'b.d_jual_co_id = a.reg_co_id', 'left');
        $this->db->where('a.reg_co_id', $coid);
        $this->db->group_by('a.reg_co_id');        
        $result = $this->db->get()->result_array(); 
        return $result;
    }

    function tampil_transfer_admin($thnbln) {
        $coid=$this->session->userdata('coid');
        $query = "a.beban_jumlah , a.beban_nama, a.beban_kat_nama";
        $this->db->select($query);
        $this->db->from('tbl_beban_opr a');
        $this->db->where("DATE_FORMAT(a.beban_tanggal, '%Y-%m') = '$thnbln'");
        $this->db->where('a.beban_co_id', $coid);
        $this->db->where('a.beban_kat_nama','Transfer');
        $this->db->order_by('DATE(a.beban_tanggal)', 'ASC');
        $result = $this->db->get();

        if (!$result) {
            $error_message = $this->db->error();
            echo "Query error: " . $error_message['message'];
            exit;
        }

        return $result->result_array(); // Mengembalikan hasil query sebagai array
    }




}
