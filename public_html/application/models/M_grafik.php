<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_grafik extends CI_Model{
	
    function statistik_stok(){    
    //---perintah sql standar----
    //$query=$this->db->query("select k.kategori_nama,IFNULL( SUM(CASE WHEN s.stok_coid = '1' AND s.stok_in > 0 THEN s.stok_in ELSE 0 END) - SUM(CASE WHEN s.stok_coid = '1' AND s.stok_out > 0 THEN s.stok_out ELSE 0 END), 0) AS tot_stok from tbl_kategori k left join tbl_barang b on k.kategori_id = b.barang_kategori_id left join tbl_stok s on b.barang_id = s.brg_id where b.barang_co_id='1' group by k.kategori_nama");
    //---perintah altenate-------
    $coid = $this->session->userdata('coid');
    $this->db->select('k.kategori_nama');
    $this->db->select('IFNULL(SUM(CASE WHEN s.stok_coid = '.$coid.' AND s.stok_in > 0 THEN s.stok_in ELSE 0 END) - SUM(CASE WHEN s.stok_coid = '.$coid.' AND s.stok_out > 0 THEN s.stok_out ELSE 0 END), 0) AS tot_stok', FALSE); // FALSE untuk mencegah escape
    $this->db->from('tbl_kategori k');
    $this->db->join('tbl_barang b', 'k.kategori_id = b.barang_kategori_id', 'left');
    $this->db->join('tbl_stok s', 'b.barang_id = s.brg_id', 'left');
    $this->db->where('b.barang_co_id', $coid);
    $this->db->group_by('k.kategori_nama');
    $query=$this->db->get();
    //---------------------------
        // $coid = $this->session->userdata('coid');
		// $daftar_cabang = $this->db->where('reg_co_id', $coid)->get('regions')->result();
		// $select_columns = 'k.kategori_nama';
		// $select_columns .= ",
		// 	IFNULL(
		// 		SUM(CASE WHEN s.stok_coid = '" . $daftar_cabang[0]->reg_co_id . "' AND s.stok_in > 0 THEN s.stok_in ELSE 0 END) -
		// 		SUM(CASE WHEN s.stok_coid = '" . $daftar_cabang[0]->reg_co_id . "' AND s.stok_out > 0 THEN s.stok_out ELSE 0 END), 0) 
		// 	AS tot_stok";
		// $this->db->select($select_columns);
		// $this->db->from('tbl_kategori k');
		// $this->db->join('tbl_barang b', 'k.kategori_id = b.barang_kategori_id', 'left');
		// $this->db->join('tbl_stok s', 'b.barang_id = s.brg_id', 'left');
		// $this->db->where('b.barang_co_id', $coid); // Tambahkan kondisi where pada tabel 'tbl_barang'
		// $this->db->group_by('k.kategori_nama');
		// $query=$this->db->get(); 
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function graf_penjualan_perbulan($bulan){
        $query = $this->db->query("SELECT DATE_FORMAT(jual_tanggal,'%d') AS tanggal,SUM(jual_total) total FROM tbl_jual WHERE DATE_FORMAT(jual_tanggal,'%M %Y')='$bulan' GROUP BY DAY(jual_tanggal)");
         
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function graf_penjualan_pertahun($tahun){
        $query = $this->db->query("SELECT DATE_FORMAT(jual_tanggal,'%M') AS bulan,SUM(jual_total) total FROM tbl_jual WHERE YEAR(jual_tanggal)='$tahun' GROUP BY MONTH(jual_tanggal)");
         
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }
}