<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_rekap extends CI_Model {

    //$tahun = 2023; // Ganti dengan tahun yang diinginkan
    //echo "Bulan ke-$bulan: $bulan_tahun\n";
    // Mendapatkan jumlah bulan berdasarkan tahun yang dipilih
    // $jumlah_bulan = 12; // Set default ke 12
    // $result_bulan = $this->db->query("SELECT COUNT(DISTINCT MONTH(jual_tanggal)) AS jumlah_bulan FROM tbl_jual WHERE jual_co_id='$coid' AND YEAR(jual_tanggal) = '$tahun'");
    // if ($result_bulan->num_rows() > 0) {
    //     $row_bulan = $result_bulan->row();
    //     $jumlah_bulan = $row_bulan->jumlah_bulan;
    // }
    //-------------cara lain-----------------    
    //     // Mendapatkan jumlah bulan berdasarkan tahun yang dipilih
    // $jumlah_bulan = 12; // Set default ke 12

    // // Mendapatkan tahun sekarang
    // $tahun_sekarang = date('Y');

    // // Cek apakah tahun yang dipilih sudah lewat atau masih berjalan
    // if ($tahun < $tahun_sekarang) {
    //     // Jika tahun sudah lewat, ambil semua bulan
    //     $result_bulan = $this->db->query("SELECT COUNT(DISTINCT MONTH(jual_tanggal)) AS jumlah_bulan FROM tbl_jual WHERE jual_co_id='$coid' AND YEAR(jual_tanggal) = '$tahun'");
    // } elseif ($tahun == $tahun_sekarang) {
    //     // Jika tahun berjalan saat ini, ambil bulan sampai dengan tanggal saat ini
    //     $bulan_sekarang = date('n'); // Mendapatkan bulan sekarang
    //     $result_bulan = $this->db->query("SELECT COUNT(DISTINCT MONTH(jual_tanggal)) AS jumlah_bulan FROM tbl_jual WHERE jual_co_id='$coid' AND YEAR(jual_tanggal) = '$tahun' AND MONTH(jual_tanggal) <= '$bulan_sekarang'");
    // }

    // if ($result_bulan->num_rows() > 0) {
    //     $row_bulan = $result_bulan->row();
    //     $jumlah_bulan = $row_bulan->jumlah_bulan;
    // }
    //-------------------------------------------

    function get_tahun_jual(){
		$coid=$this->session->userdata('coid');
		$hsl=$this->db->query("SELECT DISTINCT YEAR(jual_tanggal) AS tahun FROM tbl_jual WHERE jual_co_id='$coid' order by YEAR(jual_tanggal) ASC");
		return $hsl;
	}

    function get_jumlah_bulan($tahun) {
        $tahun_sekarang = date('Y');
        if ($tahun < $tahun_sekarang) {
            return 12;
        } elseif ($tahun == $tahun_sekarang) {
            $bulan_sekarang = date('n');
            return $bulan_sekarang;
        }
    }


    function tampil_jual_rekap($tahun) {
        $coid = $this->session->userdata('coid');
        $jumlah_bulan = 12; 
        $tahun_sekarang = date('Y');
        if ($tahun < $tahun_sekarang) {
            $jumlah_bulan = 12; 
        } elseif ($tahun == $tahun_sekarang) {
            $bulan_sekarang = date('n'); // Mendapatkan bulan sekarang
            $jumlah_bulan = $bulan_sekarang;
        }

        $select_columns = "a.reg_id,a.reg_name,";
        for ($bulan = 1; $bulan <= $jumlah_bulan; $bulan++) {
            $bulan_tahun = date("Y-m", strtotime("$tahun-$bulan"));        
            $select_columns .= "(SELECT COALESCE(SUM(b.jual_total), 0) AS omzet
                                FROM tbl_jual b 
                                WHERE b.jual_reg_id = a.reg_id 
                                AND DATE_FORMAT(b.jual_tanggal, '%Y-%m') = '$bulan_tahun') AS omzet$bulan,
                                (SELECT COALESCE(SUM(b.jual_total), 0) AS piutang
                                FROM tbl_jual b 
                                WHERE b.jual_reg_id = a.reg_id 
                                AND b.jual_bayar = 'Tempo' 
                                AND b.jual_bayar_status = 'Belum Lunas' 
                                AND DATE_FORMAT(b.jual_tanggal, '%Y-%m') = '$bulan_tahun') AS piutang$bulan,
                                (SELECT COALESCE(SUM(c.bayar_jumlah), 0) AS pelunasan
                                FROM tbl_bayar c 
                                WHERE c.bayar_reg_id = a.reg_id 
                                AND DATE_FORMAT(c.bayar_tgl_trans, '%Y-%m') = '$bulan_tahun') AS pelunasan$bulan,
                                (SELECT COALESCE(SUM(d.beban_jumlah), 0) AS pengeluaran
                                FROM tbl_beban_opr d 
                                WHERE d.beban_reg_id = a.reg_id
                                AND d.beban_kat_nama !='Transfer' 
                                AND DATE_FORMAT(d.beban_tanggal, '%Y-%m') = '$bulan_tahun') AS pengeluaran$bulan,
                                (SELECT COALESCE(SUM(d.beban_jumlah), 0) AS transfer
                                FROM tbl_beban_opr d 
                                WHERE d.beban_reg_id = a.reg_id
                                AND d.beban_kat_nama ='Transfer' 
                                AND DATE_FORMAT(d.beban_tanggal, '%Y-%m') = '$bulan_tahun') AS transfer$bulan,";
        }

        // (SELECT COALESCE(SUM(d.beban_jumlah), 0) AS pengeluaran
        // FROM tbl_beban_opr d 
        // WHERE d.beban_reg_id = a.reg_id 
        // AND DATE_FORMAT(d.beban_tanggal, '%Y-%m') = '$bulan_tahun') AS pengeluaran$bulan,
        // (SELECT COALESCE(SUM(e.bank_jumlah), 0) AS transfer
        // FROM tbl_bank e 
        // WHERE e.bank_cabang = a.reg_id 
        // AND DATE_FORMAT(e.bank_tanggal, '%Y-%m') = '$bulan_tahun') AS transfer$bulan,";


        $select_columns = rtrim($select_columns, ','); // Menghapus koma terakhir
        $this->db->select($select_columns);
        $this->db->from('regions a');
        $this->db->join('tbl_jual b', 'b.jual_co_id = a.reg_co_id', 'left');
        $this->db->join('tbl_bayar c', 'c.bayar_nofak = b.jual_nofak', 'left');
        $this->db->join('tbl_beban_opr d', 'd.beban_reg_id = a.reg_id', 'left');
        //$this->db->join('tbl_bank e', 'e.bank_cabang = a.reg_id', 'left');
        $this->db->where('a.reg_co_id', $coid);
        $this->db->group_by('a.reg_name');
        $this->db->order_by('a.reg_id', 'ASC');

        $result = $this->db->get();
        // Tambahkan penanganan kesalahan
        if (!$result) {
            $error_message = $this->db->error();
            echo "Query error: " . $error_message['message'];
            exit;
        }
        return $result;
    }


    function tampil_data($regid,$cari,$tgl1,$tgl2) {
        if ($cari == "omzet") {
            $query = 'a.jual_tanggal,a.jual_nofak,a.jual_cust_nama,a.jual_nota,a.jual_bayar,a.jual_bayar_status,a.jual_total';
            $this->db->select($query);
            $this->db->from('tbl_jual a');
            $this->db->where('DATE(a.jual_tanggal) >=', $tgl1);
            $this->db->where('DATE(a.jual_tanggal) <=', $tgl2);
            $this->db->where('a.jual_reg_id', $regid);
            $this->db->order_by('DATE(a.jual_tanggal)', 'ASC');
            $result = $this->db->get()->result_array(); // Menggunakan objek query builder untuk mendapatkan hasil query
            return $result;
        } else if ($cari == "jualtunai") { 
            $query = 'a.jual_tanggal,a.jual_nofak,a.jual_cust_nama,a.jual_nota,a.jual_bayar,a.jual_bayar_status,a.jual_total';
            $this->db->select($query);
            $this->db->from('tbl_jual a');
            $this->db->where('DATE(a.jual_tanggal) >=', $tgl1);
            $this->db->where('DATE(a.jual_tanggal) <=', $tgl2);
            $this->db->where('a.jual_bayar', "Cash");
            $this->db->where('a.jual_reg_id', $regid);
            $this->db->order_by('DATE(a.jual_tanggal)', 'ASC');
            $result = $this->db->get()->result_array(); 
            return $result;
        } else if ($cari == "piutang") { 
            $query = 'a.jual_tanggal,a.jual_nofak,a.jual_cust_nama,a.jual_nota,a.jual_bayar,a.jual_bayar_status,a.jual_total';
            $this->db->select($query);
            $this->db->from('tbl_jual a');
            $this->db->where('DATE(a.jual_tanggal) >=', $tgl1);
            $this->db->where('DATE(a.jual_tanggal) <=', $tgl2);
            $this->db->where('a.jual_bayar', "Tempo");
            $this->db->where('a.jual_reg_id', $regid);
            $this->db->order_by('DATE(a.jual_tanggal)', 'ASC');
            $result = $this->db->get()->result_array(); 
            return $result;
        } else if ($cari == "pelunasan") { 
            $query = 'a.bayar_tgl_trans,a.bayar_nofak,b.jual_cust_nama,b.jual_nota,a.bayar_jumlah,a.bayar_ket';
            $this->db->select($query);
            $this->db->from('tbl_bayar a');
            $this->db->join('tbl_jual b', 'b.jual_nofak = a.bayar_nofak', 'left');
            $this->db->where('DATE(a.bayar_tgl_trans) >=', $tgl1);
            $this->db->where('DATE(a.bayar_tgl_trans) <=', $tgl2);
            $this->db->where('a.bayar_reg_id', $regid);
            $this->db->order_by('DATE(a.bayar_tgl_trans)', 'ASC');
            $result = $this->db->get()->result_array(); 
            return $result;
        } else if ($cari == "pengeluaran") { 
            // $query = 'a.beban_tanggal, a.beban_nama, a.beban_jumlah';
            // $this->db->select($query);
            // $this->db->from('tbl_beban_opr a');
            // $this->db->where('a.beban_tanggal BETWEEN ' . $this->db->escape($tgl1) . ' AND ' . $this->db->escape($tgl2));
            // $this->db->where('a.beban_reg_id', $regid);
            // $this->db->order_by('a.beban_tanggal', 'ASC');
            // $result = $this->db->get()->result_array();
            // return $result;

            $query = 'a.beban_tanggal, a.beban_nama, a.beban_jumlah';
            $this->db->select($query);
            $this->db->from('tbl_beban_opr a');
            $this->db->where('a.beban_tanggal BETWEEN ' . $this->db->escape($tgl1) . ' AND ' . $this->db->escape($tgl2));
            $this->db->where('a.beban_reg_id', $regid);
            $this->db->where('a.beban_kat_nama !=', 'Transfer');
            $this->db->order_by('a.beban_tanggal', 'ASC');
            $result = $this->db->get()->result_array();
            return $result;

        } else if ($cari == "transfer") { 
            // $query = 'a.bank_tanggal,a.bank_ket,a.bank_jumlah';
            // $this->db->select($query);
            // $this->db->from('tbl_bank a');
            // $this->db->where('DATE(a.bank_tanggal) >=', $tgl1);
            // $this->db->where('DATE(a.bank_tanggal) <=', $tgl2);
            // $this->db->where('a.bank_cabang', $regid);
            // $this->db->order_by('DATE(a.bank_tanggal)', 'ASC');
            // $result = $this->db->get()->result_array(); 
            // return $result;

            $query = 'a.beban_tanggal, a.beban_nama, a.beban_jumlah';
            $this->db->select($query);
            $this->db->from('tbl_beban_opr a');
            $this->db->where('a.beban_tanggal BETWEEN ' . $this->db->escape($tgl1) . ' AND ' . $this->db->escape($tgl2));
            $this->db->where('a.beban_reg_id', $regid);
            $this->db->where('a.beban_kat_nama', 'Transfer');
            $this->db->order_by('a.beban_tanggal', 'ASC');
            $result = $this->db->get()->result_array();
            return $result;
        }


        
    }

    

    



}
