<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mlogin extends CI_Model{
    // function cekadmin($u,$p){
    //     // $hasil=$this->db->query("select*from tbl_user where user_username='$u'and user_password=md5('$p')");        
    //     // return $hasil;
    //     // //print_r($hasil->result()); // Cetak hasil query
    //     $this->db->select('*');
    //     $hsl = $this->db->get_where('tbl_user', array('user_username' => $u, 'user_password' => md5($p)));    
    //     return $hsl;
    // }

    function cekadmin($username, $password) {
        $this->db->select('*');
        $this->db->where('user_username', $username);
        $result = $this->db->get('tbl_user');
        if ($result->num_rows() > 0) {
            $user_data = $result->row_array();
            // Verifikasi password menggunakan password_verify()
            if (password_verify($password, $user_data['user_password'])) {
                return $user_data; // Mengembalikan data user jika password cocok
            } else {
                return 'Password tidak cocok'; // Password tidak cocok
            }
        } else {
            return 'Username tidak ditemukan'; // Data tidak ditemukan
        }
    }

    function tampil_user(){
        $user_id=$this->session->userdata('idadmin');
		//join tabel company dan regions
        //$hsl=$this->db->query("SELECT user_id,user_nama,user_username,user_title,co_name,co_address,co_phone,co_website,co_email,co_moto,co_imgicon,co_imglogo,co_imgbg,co_copyright,reg_code,reg_id,reg_name,reg_desc,nick_name FROM tbl_user join regions on tbl_user.user_reg_id=regions.reg_id join company on tbl_user.user_co_id=company.co_id  WHERE tbl_user.user_id='$user_id'");
        //return $hsl;
		$this->db->select('a.user_id,a.user_nama,a.user_username,a.user_title,a.user_level_nama,c.co_id,c.co_name,c.co_address,c.co_phone,c.co_website,c.co_email,c.co_moto,c.co_imgicon,c.co_imglogo,c.co_imgbg,c.co_copyright,c.co_rek_a,c.co_rek_b,b.reg_code,b.reg_id,b.reg_name,b.reg_desc,b.nick_name');
        $this->db->from('tbl_user a');
        $this->db->join('regions b', 'b.reg_id = a.user_reg_id', 'inner');
        $this->db->join('company c', 'c.co_id = b.reg_co_id', 'inner');
        $this->db->where('a.user_id', $user_id);
        return $this->db->get();
    }


    function tampil_regions(){
        $coid=$this->session->userdata('coid');
		//$hsl=$this->db->query("SELECT reg_id,reg_name FROM regions where reg_co_id='$coid' order by reg_id asc");
        //return $hsl;
        //$hsl = $this->db->query("SELECT reg_id, reg_name FROM regions WHERE reg_co_id = ? ORDER BY reg_id ASC", array($coid));
        //return $hsl;
		$this->db->select('reg_id, reg_name');
        $this->db->order_by('reg_id', 'ASC');
        $hsl = $this->db->get_where('regions', array('reg_co_id' => $coid));
        return $hsl;

        
	}
    function get_regions($reg_id){
		//$hsl=$this->db->query("SELECT reg_id,reg_code,reg_name FROM regions where reg_id='$reg_id'");
        //return $hsl;
		$this->db->select('reg_id,reg_code,reg_name');
        $hsl = $this->db->get_where('regions', array('reg_id' => $reg_id));
        //return $this->db->get();
        return $hsl;
	}


    function tampil_markup() {
        $regid = $this->session->userdata('regid');
        $this->db->select("jual_nofak, jual_cust_nama, DATE_FORMAT(jual_tanggal, '%d %M %Y %H:%i:%s') AS jual_tanggal, jual_bayar, jual_bayar_status, jual_total, jual_user_id, tbl_jual_markup.created_by, regions.reg_name");
        $this->db->from('tbl_jual_markup');
        $this->db->join('regions', 'tbl_jual_markup.jual_reg_id = regions.reg_id');
        $this->db->where('jual_reg_id', $regid);
        $this->db->order_by('DATE(jual_tanggal)', 'DESC');
        $hsl = $this->db->get();
        return $hsl; 
    }



}
