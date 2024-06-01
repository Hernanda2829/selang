<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice_model extends CI_Model {

    public function getInvoiceByNumber($invoice_number) {
        $query = $this->db->get_where('tbl_garansi', array('g_token' => $invoice_number));
        return $query->row();
    }

    public function getBarangInfo($kode_barang) {
        $query = $this->db->get_where('tbl_garansi', array('g_token' => md5($kode_barang)));
        return $query->row();
    }
}
