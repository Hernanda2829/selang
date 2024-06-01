<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Garansi extends CI_Controller{
	function __construct(){
		parent::__construct();
		if($this->session->userdata('masuk') !=TRUE){
            $url=base_url();
            redirect($url);
        };
        
		$this->load->model('M_garansi');
		$this->load->model('Mlogin');
		
	}

	function index(){
        if($this->session->userdata('akses')=='1'){
            $data['userid'] = $this->Mlogin->tampil_user();
            $data['g_data'] = $this->M_garansi->tampil_garansi();
            $this->load->view('admin/v_garansi', $data);
        }else{
            echo "Halaman tidak ditemukan";
        }
	}

	function get_detail_jual(){
    if($this->session->userdata('akses')=='1') {
        $this->session->unset_userdata('msg'); //menghapus session message flashdata
        $nofak = $this->input->post('nofak');
        $data = $this->M_garansi->getdetailjual($nofak);
        if (!empty($data)) {
            echo json_encode($data);
        } else {
            echo json_encode(array('error' => 'Data not found'));
        }
    } else {
        // Jika akses tidak sesuai, Anda bisa mengirim status 403 Forbidden
        http_response_code(403);
        echo json_encode(array('error' => 'Forbidden'));
    }
	}


    function hapus_data(){
        if($this->session->userdata('akses')=='1'){
            $id=$this->input->post('txtid');
            $gimg=$this->input->post('txtimg');
            $nofak=$this->input->post('txtnofak');
            // medefinisikan Variabel $config terlebih dahulu
            //$path = $config['upload_path'] = FCPATH . 'assets/img/img_barcode/';
            $path = FCPATH . 'assets/img/img_barcode/';
            // Hapus gambar jika ada
            $file_name = $gimg;
            if ($file_name) {
                $file_path = $path . $file_name;
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
            }
            $this->M_garansi->hapus_garansi($id);
            $this->hapus_garansi_file($nofak);
            redirect('admin/garansi');
        }
	}


    function get_garansi_file(){
    if($this->session->userdata('akses')=='1' || $this->session->userdata('akses')=='2'){
        //$this->session->unset_userdata('msg'); //menghapus session message flashdata
        $nofak = $this->input->post('nofak');
        $idbrg = $this->input->post('idbrg');
        $data = $this->M_garansi->get_garansi_file($nofak,$idbrg);
        if (!empty($data)) {
            echo json_encode($data);
        } else {
            echo json_encode(array('error' => 'Data not found'));
        }
    } else {
        // Jika akses tidak sesuai, Anda bisa mengirim status 403 Forbidden
        http_response_code(403);
        echo json_encode(array('error' => 'Forbidden'));
    }
	}

    function hapus_garansi_file($nofak) {
    $data = $this->M_garansi->get_file($nofak);
        if (!empty($data) && is_array($data)) {
            foreach ($data as $row) {
                $gid = $row['g_id'];
                $nmfile = $row['g_file'];
                $path = FCPATH . 'assets/img/file_garansi/';

                // Hapus file/gambar jika ada
                $file_name = $nmfile;
                if ($file_name) {
                    $file_path = $path . $file_name;
                    if (file_exists($file_path)) {
                        unlink($file_path);

                        // Hapus file dari database hanya jika penghapusan file berhasil
                        $this->M_garansi->hapus_file($gid);
                    }
                }
            }
        }
    }


    


}