<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_laba extends CI_Model {

    function get_bulan_jual(){
		$coid=$this->session->userdata('coid');
		$hsl=$this->db->query("SELECT DISTINCT DATE_FORMAT(jual_tanggal,'%M %Y') AS bulan FROM tbl_jual WHERE jual_co_id='$coid' ORDER BY DATE_FORMAT(jual_tanggal, '%Y-%m') DESC");
		return $hsl;
	}

	function tampil_laba($regid,$thnbln) {
        $select_columns = "a.reg_id, a.reg_name,";
        $kategori = $this->db->select('kategori_nama')->get('tbl_kategori')->result_array();
        foreach ($kategori as $k) {
            $kat = preg_replace('/[^a-zA-Z0-9_]/', '', $k['kategori_nama']);
            $select_columns .= "(SELECT COALESCE(SUM(b.d_jual_total), 0)
                                    FROM tbl_detail_jual b JOIN tbl_jual c ON c.jual_nofak=b.d_jual_nofak
                                    WHERE b.d_jual_reg_id = a.reg_id
                                    AND c.jual_bayar = 'Cash'
                                    AND b.d_jual_kategori_nama = '$kat'
                                    AND DATE_FORMAT(b.d_jual_tanggal, '%Y-%m') = '$thnbln') AS harjul_tunai$kat,
                                (SELECT COALESCE(SUM(b.d_jual_total_harpok), 0)
                                    FROM tbl_detail_jual b JOIN tbl_jual c ON c.jual_nofak=b.d_jual_nofak
                                    WHERE b.d_jual_reg_id = a.reg_id
                                    AND c.jual_bayar = 'Cash'
                                    AND b.d_jual_kategori_nama = '$kat'
                                    AND DATE_FORMAT(b.d_jual_tanggal, '%Y-%m') = '$thnbln') AS harpok_tunai$kat,
                                (SELECT COALESCE(SUM(b.d_jual_total), 0)
                                    FROM tbl_detail_jual b JOIN tbl_jual c ON c.jual_nofak=b.d_jual_nofak
                                    WHERE b.d_jual_reg_id = a.reg_id
                                    AND c.jual_bayar = 'Tempo'
                                    AND b.d_jual_kategori_nama = '$kat'
                                    AND DATE_FORMAT(b.d_jual_tanggal, '%Y-%m') = '$thnbln') AS harjul_piutang$kat,
                                (SELECT COALESCE(SUM(b.d_jual_total_harpok), 0)
                                    FROM tbl_detail_jual b JOIN tbl_jual c ON c.jual_nofak=b.d_jual_nofak
                                    WHERE b.d_jual_reg_id = a.reg_id
                                    AND c.jual_bayar = 'Tempo'
                                    AND b.d_jual_kategori_nama = '$kat'
                                    AND DATE_FORMAT(b.d_jual_tanggal, '%Y-%m') = '$thnbln') AS harpok_piutang$kat,
                                (SELECT COALESCE(SUM(b.d_jual_total), 0)
                                    FROM tbl_detail_jual b JOIN tbl_jual c ON c.jual_nofak=b.d_jual_nofak
                                    WHERE b.d_jual_reg_id = a.reg_id
                                    AND b.d_jual_kategori_nama = '$kat'
                                    AND DATE_FORMAT(b.d_jual_tanggal, '%Y-%m') = '$thnbln') AS harjul$kat,
                                (SELECT COALESCE(SUM(b.d_jual_total_harpok), 0)
                                    FROM tbl_detail_jual b JOIN tbl_jual c ON c.jual_nofak=b.d_jual_nofak
                                    WHERE b.d_jual_reg_id = a.reg_id
                                    AND b.d_jual_kategori_nama = '$kat'
                                    AND DATE_FORMAT(b.d_jual_tanggal, '%Y-%m') = '$thnbln') AS harpok$kat,    
                                ";
        }

                             
        // AND c.jual_bayar_status = 'Belum Lunas' //untuk piutang yang belum lunas, kalo lunas nanti tidak terhitung
        $select_columns = rtrim($select_columns, ','); // Remove the trailing comma
        $this->db->select($select_columns);
        $this->db->from('regions a');
        $this->db->join('tbl_detail_jual b', 'b.d_jual_reg_id = a.reg_id', 'left');
        $this->db->where('a.reg_id', $regid);
        $this->db->group_by('a.reg_id, a.reg_name');
        
        $result = $this->db->get();
        if (!$result) {
            $error_message = $this->db->error();
            echo "Query error: " . $error_message['message'];
            exit;
        }
        return $result;
        
        // $result = $this->db->get()->result_array(); 
        // return $result;

        
    }

    function tampil_transfer($regid,$bln) {
        $b1 = DateTime::createFromFormat('F Y', $bln);
        $bln = $b1->format('Y-m');
        $query = "a.beban_jumlah , a.beban_nama, a.beban_kat_nama";
        $this->db->select($query);
        $this->db->from('tbl_beban_opr a');
        $this->db->where("DATE_FORMAT(a.beban_tanggal, '%Y-%m') = '$bln'");
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


    //Laporan Laba Admin
    function tampil_laba_admin($thnbln) {
        $coid=$this->session->userdata('coid');
        $select_columns = "a.reg_co_id,";
        $kategori = $this->db->select('kategori_nama')->get('tbl_kategori')->result_array();
        foreach ($kategori as $k) {
            $kat = preg_replace('/[^a-zA-Z0-9_]/', '', $k['kategori_nama']);
            $select_columns .= "(SELECT COALESCE(SUM(b.d_jual_total), 0)
                                    FROM tbl_detail_jual b JOIN tbl_jual c ON c.jual_nofak=b.d_jual_nofak
                                    WHERE b.d_jual_co_id = a.reg_co_id
                                    AND c.jual_bayar = 'Cash'
                                    AND b.d_jual_kategori_nama = '$kat'
                                    AND DATE_FORMAT(b.d_jual_tanggal, '%Y-%m') = '$thnbln') AS harjul_tunai$kat,
                                (SELECT COALESCE(SUM(b.d_jual_total_harpok), 0)
                                    FROM tbl_detail_jual b JOIN tbl_jual c ON c.jual_nofak=b.d_jual_nofak
                                    WHERE b.d_jual_co_id = a.reg_co_id
                                    AND c.jual_bayar = 'Cash'
                                    AND b.d_jual_kategori_nama = '$kat'
                                    AND DATE_FORMAT(b.d_jual_tanggal, '%Y-%m') = '$thnbln') AS harpok_tunai$kat,
                                (SELECT COALESCE(SUM(b.d_jual_total), 0)
                                    FROM tbl_detail_jual b JOIN tbl_jual c ON c.jual_nofak=b.d_jual_nofak
                                    WHERE b.d_jual_co_id = a.reg_co_id
                                    AND c.jual_bayar = 'Tempo'
                                    AND b.d_jual_kategori_nama = '$kat'
                                    AND DATE_FORMAT(b.d_jual_tanggal, '%Y-%m') = '$thnbln') AS harjul_piutang$kat,
                                (SELECT COALESCE(SUM(b.d_jual_total_harpok), 0)
                                    FROM tbl_detail_jual b JOIN tbl_jual c ON c.jual_nofak=b.d_jual_nofak
                                    WHERE b.d_jual_co_id = a.reg_co_id
                                    AND c.jual_bayar = 'Tempo'
                                    AND b.d_jual_kategori_nama = '$kat'
                                    AND DATE_FORMAT(b.d_jual_tanggal, '%Y-%m') = '$thnbln') AS harpok_piutang$kat,
                                (SELECT COALESCE(SUM(b.d_jual_total), 0)
                                    FROM tbl_detail_jual b JOIN tbl_jual c ON c.jual_nofak=b.d_jual_nofak
                                    WHERE b.d_jual_co_id = a.reg_co_id
                                    AND b.d_jual_kategori_nama = '$kat'
                                    AND DATE_FORMAT(b.d_jual_tanggal, '%Y-%m') = '$thnbln') AS harjul$kat,
                                (SELECT COALESCE(SUM(b.d_jual_total_harpok), 0)
                                    FROM tbl_detail_jual b JOIN tbl_jual c ON c.jual_nofak=b.d_jual_nofak
                                    WHERE b.d_jual_co_id = a.reg_co_id
                                    AND b.d_jual_kategori_nama = '$kat'
                                    AND DATE_FORMAT(b.d_jual_tanggal, '%Y-%m') = '$thnbln') AS harpok$kat,    
                                ";
        }

                             
        // AND c.jual_bayar_status = 'Belum Lunas' //untuk piutang yang belum lunas, kalo lunas nanti tidak terhitung
        $select_columns = rtrim($select_columns, ','); // Remove the trailing comma
        $this->db->select($select_columns);
        $this->db->from('regions a');
        $this->db->join('tbl_detail_jual b', 'b.d_jual_co_id = a.reg_co_id', 'left');
        $this->db->where('a.reg_co_id', $coid);
        $this->db->group_by('a.reg_co_id');
        
        $result = $this->db->get();
        if (!$result) {
            $error_message = $this->db->error();
            echo "Query error: " . $error_message['message'];
            exit;
        }
        return $result;
        
        // $result = $this->db->get()->result_array(); 
        // return $result;

        
    }

    function tampil_transfer_admin($regid,$bln) {
        $coid=$this->session->userdata('coid');
        $b1 = DateTime::createFromFormat('F Y', $bln);
        $bln = $b1->format('Y-m');
        $query = "a.beban_jumlah , a.beban_nama, a.beban_kat_nama";
        $this->db->select($query);
        $this->db->from('tbl_beban_opr a');
        $this->db->where("DATE_FORMAT(a.beban_tanggal, '%Y-%m') = '$bln'");
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


    
    function tampil_beban_global($thnbln) {
        $coid=$this->session->userdata('coid');
        // Select statement
        $query = "COALESCE(SUM(a.beban_jumlah), 0) AS pengeluaran";
        $this->db->select($query);
        $this->db->from('tbl_beban_opr a');
        $this->db->where("DATE_FORMAT(a.beban_tanggal, '%Y-%m') = '$thnbln'");
        $this->db->where('a.beban_co_id', $coid);
        $this->db->where('a.beban_kat_nama !=', 'Transfer');
        // Eksekusi query
        $result = $this->db->get();
        // Cek error
        if (!$result) {
            $error_message = $this->db->error();
            echo "Query error: " . $error_message['message'];
            exit;
        }
        // Mengembalikan hasil query sebagai array
        //return $result->result_array();
        return $result->row_array();
    }

    function tampil_beban($regid,$thnbln) {
        // Select statement
        $query = "COALESCE(SUM(a.beban_jumlah), 0) AS pengeluaran";
        $this->db->select($query);
        $this->db->from('tbl_beban_opr a');
        $this->db->where("DATE_FORMAT(a.beban_tanggal, '%Y-%m') = '$thnbln'");
        $this->db->where('a.beban_reg_id', $regid);
        $this->db->where('a.beban_kat_nama !=', 'Transfer');
        // Eksekusi query
        $result = $this->db->get();
        // Cek error
        if (!$result) {
            $error_message = $this->db->error();
            echo "Query error: " . $error_message['message'];
            exit;
        }
        // Mengembalikan hasil query sebagai array
        return $result->row_array();
    }



}
