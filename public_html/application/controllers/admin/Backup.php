<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Backup extends CI_Controller{
	function __construct(){
		parent::__construct();
		if($this->session->userdata('masuk') !=TRUE){
            $url=base_url();
            redirect($url);
        };
		//$this->load->model('M_backup');
        $this->load->model('Mlogin');
		$this->load->dbutil();
        $this->load->helper('url');
	}

	function index(){
	if($this->session->userdata('akses')=='1'){
        $data['userid'] = $this->Mlogin->tampil_user();
		$data['regions']=$this->Mlogin->tampil_regions();		
		$this->load->view('admin/v_backup',$data);
	}
	}

	// public function create_backup() {
    //     // Proses pembuatan backup database
    //     $this->load->dbutil();

    //     // Konfigurasi backup
    //     $prefs = array(
    //         'tables'      => array(),  // Tabel yang akan di-backup, kosongkan untuk semua tabel
    //         'ignore'      => array(),  // Tabel yang akan diabaikan
    //         'filename'    => 'backup_' . date('Y-m-d_H-i-s') . '.sql',
    //         'format'      => 'txt',    // Format backup (txt, gzip, zip)
    //         'add_drop'    => TRUE,
    //         'add_insert'  => TRUE,
    //         'newline'     => "\n"
    //     );

    //     // Proses backup
    //     $backup =& $this->dbutil->backup($prefs);

    //     // Load library file untuk force download
    //     $this->load->helper('download');
    //     force_download($prefs['filename'], $backup);
    // }
	
		public function create_backup() {
		// Header untuk file SQL backup
		$backup_header = "-- phpMyAdmin SQL Dump\n";
		$backup_header .= "-- version 5.2.0\n";
		$backup_header .= "-- https://www.phpmyadmin.net/\n";
		// Tambahkan informasi lainnya sesuai kebutuhan
		
		// Konfigurasi backup
		$prefs = array(
			'tables'      => array(),  // Tabel yang akan di-backup, kosongkan untuk semua tabel
			'ignore'      => array(),  // Tabel yang akan diabaikan
			'filename'    => 'backupdb_ss_pos_' . date('Y-m-d_H-i-s') . '.sql',
			'format'      => 'txt',    // Format backup (txt, gzip, zip)
			'add_drop'    => TRUE,
			'add_insert'  => TRUE,
			'newline'     => "\n"
		);

		// Proses backup menggunakan fasilitas ci3
		$backup =& $this->dbutil->backup($prefs);

		// Gabungkan header dan isi backup
		$backup_content = $backup_header . $backup;

		// Load library file untuk force download
		$this->load->helper('download');
		force_download($prefs['filename'], $backup_content);
	}

	
}