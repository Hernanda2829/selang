<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Pengguna extends CI_Controller{
	function __construct(){
		parent::__construct();
		if($this->session->userdata('masuk') !=TRUE){
            $url=base_url();
            redirect($url);
        };
		$this->load->model('M_pengguna');
		$this->load->model('Mlogin');
	}
	function index(){
	if($this->session->userdata('akses')=='1'){
		$data['userid'] = $this->Mlogin->tampil_user(); // Mendapatkan data user
		$data['data']=$this->M_pengguna->get_pengguna();
		$data['user_level']=$this->M_pengguna->get_user_level();
		$data['regions']=$this->Mlogin->tampil_regions();
		$this->load->view('admin/v_pengguna',$data);
	}else{
        echo "Halaman tidak ditemukan";
    }
	}

	function tambah_pengguna(){
	if($this->session->userdata('akses')=='1'){
		$nama=$this->input->post('nama');
		$username=$this->input->post('username');
		$usertitle=$this->input->post('usertitle');
		$password=$this->input->post('password');
		$password2=$this->input->post('password2');
		$level=$this->input->post('level');
		$regid=$this->input->post('regions');
		if ($password2 <> $password) {
			echo $this->session->set_flashdata('msg','<label class="label label-danger">Password yang Anda Masukan Tidak Sama</label>');
			redirect('admin/pengguna');
		}else{
			$this->M_pengguna->simpan_pengguna($nama,$username,$usertitle,$password,$level,$regid);
			echo $this->session->set_flashdata('msg','<label class="label label-success">Pengguna Berhasil ditambahkan</label>');
			redirect('admin/pengguna');
		}
		
	}else{
        echo "Halaman tidak ditemukan";
    }
	}
	
	function edit_pengguna(){
	if($this->session->userdata('akses')=='1'){
		$kode=$this->input->post('kode');
		$nama=$this->input->post('nama');
		$username=$this->input->post('username');
		$usertitle=$this->input->post('usertitle');
		
		$level=$this->input->post('level');
		$regid=$this->input->post('regions');
		$this->M_pengguna->update_pengguna($kode,$nama,$username,$usertitle,$level,$regid);
		echo $this->session->set_flashdata('msg','<label class="label label-success">Pengguna Berhasil diupdate</label>');
		redirect('admin/pengguna');
		
	}else{
        echo "Halaman tidak ditemukan";
    }
	}
	function nonaktifkan(){
	if($this->session->userdata('akses')=='1'){
		$kode=$this->input->post('kode');
		$this->M_pengguna->update_status_nonaktif($kode);
		redirect('admin/pengguna');
	}else{
        echo "Halaman tidak ditemukan";
    }
	}
	function aktifkan(){
	if($this->session->userdata('akses')=='1'){
		$kode=$this->input->post('kode');
		$this->M_pengguna->update_status_aktif($kode);
		redirect('admin/pengguna');
	}else{
        echo "Halaman tidak ditemukan";
    }
	}

	// function editpassword_GAYALAMA() {
    // $pwdlama = md5($this->input->post('pwdlama'));
    // $password = $this->input->post('password');
    // $password2 = $this->input->post('password2');
    // $kode = $this->input->post('kode');
    // $x['pwd'] = $this->M_pengguna->get_password($kode);
    // $p = $x['pwd']->row_array();
    // $passlama = $p['user_password'];
    
    // if ($pwdlama === $passlama) {
    //     if (!empty($password) && !empty($password2)) {
    //         if ($password2 === $password) {
	// 			$this->M_pengguna->update_password($kode,$password);
    //             echo 'Berhasil Ganti Password';
    //         } elseif ($pwdlama===md5($password)) {
	// 			echo 'Harap Ganti Password yang lain';
	// 		} else {
    //             echo 'Password tidak sama';
    //         }
    //     } else {
    //         echo 'Password tidak boleh dikosongkan';
    //     }
    // } else {
    //     echo 'Password lama salah ';
    // }

	function editpassword() {
		// Hash password menggunakan password_hash()
		$pwdlama = $this->input->post('pwdlama');
		$password = $this->input->post('password');
		$password2 = $this->input->post('password2');
		$kode = $this->input->post('kode');
		$x['pwd'] = $this->M_pengguna->get_password($kode);
		$p = $x['pwd']->row_array();
		$passlama = $p['user_password'];
		if (password_verify($pwdlama, $passlama)) {
			if (!empty($password) && !empty($password2)) {
				if ($password2 === $password) {
					$this->M_pengguna->update_password($kode,$password);
					echo 'Berhasil Ganti Password';
				} elseif ($pwdlama===md5($password)) {
					echo 'Harap Ganti Password yang lain';
				} else {
					echo 'Password tidak sama';
				}
			} else {
				echo 'Password tidak boleh dikosongkan';
			}
		} else {
			echo 'Password lama salah ';
		}

	}

	function hapus_pengguna(){
	if($this->session->userdata('akses')=='1'){
		$kode=$this->input->post('kode');
		$this->M_pengguna->hapus_pengguna($kode);
		echo $this->session->set_flashdata('msg','<label class="label label-success">Pengguna Berhasil di hapus</label>');
		redirect('admin/pengguna');
	}elseif($this->session->userdata('akses')=='2') {
        // $kode=$this->input->post('kode');
		// $this->M_beban->hapus_beban($kode);
		// redirect('admin/beban');
    }
	}


}