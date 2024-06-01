<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Cabang extends CI_Controller{
	function __construct(){
		parent::__construct();
		if($this->session->userdata('masuk') !=TRUE){
            $url=base_url();
            redirect($url);
        };
		$this->load->model('M_cabang');
		$this->load->model('Mlogin');
	}
	function index(){
	if($this->session->userdata('akses')=='1'){
		$data['userid'] = $this->Mlogin->tampil_user(); // Mendapatkan data user
		$data['data']=$this->M_cabang->get_cabang();
		$data['regions']=$this->Mlogin->tampil_regions();
		//$data['company']=$this->M_cabang->get_company();
		$this->load->view('admin/v_cabang',$data);
	}else{
        echo "Halaman tidak ditemukan";
    }
	}

	function tambah_cabang(){
	if($this->session->userdata('akses')=='1'){
		$nama_kode=$this->input->post('nama_kode');
		$nama=$this->input->post('nama');
		$deskripsi=$this->input->post('deskripsi');
		$nickname=$this->input->post('nickname');
		$this->M_cabang->simpan_cabang($nama_kode,$nama,$deskripsi,$nickname);
		redirect('admin/cabang');
	}else{
        echo "Halaman tidak ditemukan";
    }
	}

	function edit_cabang(){
	if($this->session->userdata('akses')=='1'){
		$kode=$this->input->post('kode');
		$nama_kode=$this->input->post('nama_kode');
		$nama=$this->input->post('nama');
		$deskripsi=$this->input->post('deskripsi');
		$nickname=$this->input->post('nickname');
		$this->M_cabang->update_cabang($kode,$nama_kode,$nama,$deskripsi,$nickname);
		echo $this->session->set_flashdata('msg','<label class="label label-success">Kantor Cabang Berhasil diupdate</label>');
		redirect('admin/cabang');
	}else{
        echo "Halaman tidak ditemukan";
    }
	}

	function hapus_cabang(){
	if($this->session->userdata('akses')=='1'){
		$kode=$this->input->post('kode');
		$this->M_cabang->hapus_cabang($kode);
		redirect('admin/cabang');
	}else{
        echo "Halaman tidak ditemukan";
    }
	}

	function get_company() {
		$coid = $this->input->post('coid');
        $data = $this->M_cabang->get_company($coid);
        if (!empty($data)) {
            echo json_encode($data);
        } else {
            echo json_encode(array('error' => 'Data not found'));
        }
	}

	
	function edit_company() {
		if ($this->session->userdata('akses') == '1') {
			$path = FCPATH . 'assets/img/';

			$coimgicon = $this->input->post('coimgicon');
			$coimgicon2 = $this->input->post('coimgicon2');

			if ($coimgicon !== $coimgicon2) {
				$this->deleteFile($path, $coimgicon2);

				$nmfile1 = $this->uploadFile('logo1', $path, 'logo_icon', 50, 50);
				if ($nmfile1) {
					$coimgicon = $nmfile1;
				}
			}

			$coimglogo = $this->input->post('coimglogo');
			$coimglogo2 = $this->input->post('coimglogo2');
			if ($coimglogo !== $coimglogo2) {
				$this->deleteFile($path, $coimglogo2);

				$nmfile2 = $this->uploadFile('logo2', $path, 'logo_cetak', 400, 100);
				if ($nmfile2) {
					$coimglogo = $nmfile2;
				}
			}

			$coimgbg = $this->input->post('coimgbg');
			$coimgbg2 = $this->input->post('coimgbg2');
			if ($coimgbg !== $coimgbg2) {
				$this->deleteFile($path, $coimgbg2);

				$nmfile3 = $this->uploadFile('logo3', $path, 'logo_bg', 1024, 768);
				if ($nmfile3) {
					$coimgbg = $nmfile3;
				}
			}

			$coid = $this->input->post('txtcoid');
			$coname = $this->input->post('coname');
			$coaddress = $this->input->post('coaddress');
			$cophone = $this->input->post('cophone');
			$cowebsite = $this->input->post('cowebsite');
			$coemail = $this->input->post('coemail');
			$comoto = $this->input->post('comoto');
			$cocopyright = $this->input->post('cocopyright');
			$coreka = $this->input->post('coreka');
			$corekb = $this->input->post('corekb');

			$this->M_cabang->update_company($coid, $coname, $coaddress, $cophone, $cowebsite, $coemail, $comoto, $coimgicon, $coimglogo, $coimgbg, $cocopyright, $coreka, $corekb);
			echo $this->session->set_flashdata('msg', '<label class="label label-success">Company Profile Berhasil diupdate</label>');
			redirect('admin/cabang');
		} else {
			echo "Halaman tidak ditemukan";
		}
	}

	// Fungsi untuk menghapus file
	function deleteFile($path, $filename) {
		if ($filename) {
			$file_path = $path . $filename;
			if (file_exists($file_path)) {
				unlink($file_path);
			}
		}
	}

	// Fungsi untuk mengunggah file dan melakukan resize jika diperlukan
	function uploadFile($input_name, $path, $prefix, $max_width, $max_height) {
		$config['upload_path']   = $path;
		$config['allowed_types'] = 'ico|gif|jpg|png|jpeg|webp|svg';
		$config['max_size']      = 0; // Mengizinkan ukuran file apapun 100
		$config['max_width']     = 0; //1024
		$config['max_height']    = 0; //768
		$this->load->library('upload', $config);

		if ($this->upload->do_upload($input_name)) {
			$upload_data = $this->upload->data();
			$new_filename = $prefix . $upload_data['file_ext'];

			// Kode untuk menangani file gambar (seperti resize)
			list($width, $height) = getimagesize($upload_data['full_path']);
			if ($width > $max_width || $height > $max_height) {
				$this->load->library('image_lib');
				$config_resize['image_library'] = 'gd2';
				$config_resize['source_image'] = $upload_data['full_path'];
				$config_resize['maintain_ratio'] = TRUE;
				$config_resize['width'] = $max_width;
				$config_resize['height'] = $max_height;
				$this->image_lib->initialize($config_resize);
				$this->image_lib->resize();
				$this->image_lib->clear();
			}

			rename($upload_data['full_path'], $path . $new_filename);
			return $new_filename;
		} else {
			// Tambahkan log jika upload gagal
			log_message('error', 'Upload gagal: ' . $this->upload->display_errors());
			return false;
		}
	}

	
	
}