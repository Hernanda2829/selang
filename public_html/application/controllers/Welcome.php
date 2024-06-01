<?php
class Welcome extends CI_Controller{
	function __construct(){
		parent::__construct();
		if($this->$this->load->library('session')->userdata('masuk') !=TRUE){
            $url=base_url();
            redirect($url);
        };
		$this->load->model('Mlogin');
	}
	
	function index(){
		$data['userid']=$this->load->model('Mlogin')->tampil_user();
		$data['datamarkup']=$this->load->model('Mlogin')->tampil_markup();
		$this->load->view('admin/v_index', $data);
	}
}