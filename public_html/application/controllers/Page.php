<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('auth');
        $this->filter_except = array('show_page');
    }

    //gunakan perintah di bawah ini jika scan menggunakan verifikasi login no faktur penjualan dan kode barang
    // public function show_page($invoice_number = null) {
    //     $this->load->model('invoices/Invoice_model');
    //     $data['invoice'] = $this->Invoice_model->getInvoiceByNumber($invoice_number);

    //     if ($this->input->post('kode')) {
    //         $kode_barang = $this->input->post('kode');
    //         $data['garansi_info'] = $this->Invoice_model->getBarangInfo($kode_barang);
    //     }

    //     $this->load->view('invoices/invoice_page', $data);
    // }


    //gunakan perintah ini untuk langsung menampilkan data garansi tanpa verifikasi login
    public function show_page($invoice_number = null) {
        $this->load->model('invoices/Invoice_model');
        $data['invoice'] = $this->Invoice_model->getInvoiceByNumber($invoice_number);
        $this->load->view('invoices/invoice_page', $data);
    }




}