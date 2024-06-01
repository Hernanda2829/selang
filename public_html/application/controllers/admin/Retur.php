<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Retur extends CI_Controller{
	function __construct(){
		parent::__construct();
		if($this->session->userdata('masuk') !=TRUE){
            $url=base_url();
            redirect($url);
        };
		
		$this->load->model('M_retur');
		$this->load->model('Mlogin');
	}
	function index(){
	//if($this->session->userdata('akses')=='1' || $this->session->userdata('akses')=='2'){
	if($this->session->userdata('akses')=='1'){
		$firstDay = $this->getFirstDayOfMonth();
		$lastDay = $this->getLastDayOfMonth();
		$data['firstDayOfMonth'] = $firstDay;
		$data['lastDayOfMonth'] = $lastDay;
		$data['today'] = date('Y-m-d');
		$data['data_retur']=$this->M_retur->get_retur($firstDay,$lastDay);
		$data['userid']=$this->Mlogin->tampil_user();
		$data['regions']=$this->Mlogin->tampil_regions();
		$data['retur']=$this->M_retur->tampil_retur();
		$data['data']=$this->M_retur->tampil_barang();
		$this->load->view('admin/v_retur',$data);
	}elseif($this->session->userdata('akses')=='2') {
		$firstDay = $this->getFirstDayOfMonth();
		$lastDay = $this->getLastDayOfMonth();
		$data['firstDayOfMonth'] = $firstDay;
		$data['lastDayOfMonth'] = $lastDay;
		$data['today'] = date('Y-m-d');
		$data['data_retur']=$this->M_retur->get_retur_kasir($firstDay,$lastDay);
		$data['userid']=$this->Mlogin->tampil_user();
		$data['regions']=$this->Mlogin->tampil_regions();
		$data['retur']=$this->M_retur->tampil_retur_kasir();
		$data['data']=$this->M_retur->tampil_barang_kasir();
		$this->load->view('admin/v_retur_kasir',$data);
	}else{
        echo "Halaman tidak ditemukan";
    }
	}

	// Mendapatkan tanggal pertama bulan sekarang
	private function getFirstDayOfMonth() {
		$firstDay = new DateTime('first day of this month');
		return $firstDay->format('Y-m-d');
	}

	// Mendapatkan tanggal terakhir bulan sekarang
	private function getLastDayOfMonth() {
		$lastDay = new DateTime('last day of this month');
		return $lastDay->format('Y-m-d');
	}
	
	// function get_barang(){
	// if($this->session->userdata('akses')=='1' || $this->session->userdata('akses')=='2'){
	// 	$kobar=$this->input->post('kode_brg');
	// 	$x['brg']=$this->M_retur->get_barang($kobar);
	// 	$this->load->view('admin/v_detail_barang_retur',$x);
	// }else{
    //     echo "Halaman tidak ditemukan";
    // }
	// }

	function get_data_retur() {
		$firstDay = $this->input->post('tgl1');
		$lastDay = $this->input->post('tgl2');
		if($this->session->userdata('akses')=='1'){
        	$data = $this->M_retur->get_retur($firstDay,$lastDay);
		}elseif($this->session->userdata('akses')=='2') {
			$data = $this->M_retur->get_retur_kasir($firstDay,$lastDay);
		}
        if (!empty($data)) {
			$response = array(
				'data' => $data
			);
			echo json_encode($response);
		} else {
			$response = array(
				'message' => 'Data not found'
			);
			echo json_encode($response);
		}

    }

	function get_barang(){
		$regid = $this->input->post('regid');
		$idbrg = $this->input->post('idbrg');
        $data = $this->M_retur->get_barang($regid,$idbrg);
        if (!empty($data)) {
            echo json_encode($data);
        } else {
            echo json_encode(array('error' => 'Data not found'));
        }
	}
	

	function simpan_retur(){
	if($this->session->userdata('akses')=='1' || $this->session->userdata('akses')=='2') {
		$tgltrans=$this->input->post('tgl');
		$nofak=$this->input->post('nofak');
		$regid=$this->input->post('regid');
		$idbrg=$this->input->post('idbrg');
		$nmbrg=$this->input->post('nmbrg');
		$satbrg=$this->input->post('satbrg');
		$katbrg=$this->input->post('katbrg');
		$harpokbrg=str_replace([',', '.'], "", $this->input->post('harpokbrg'));
		$harjulbrg=str_replace([',', '.'], "", $this->input->post('harjulbrg'));
		$qtyret=str_replace(',','.', $this->input->post('qtyret'));
		$ket=$this->input->post('ket');
		$returid=$this->M_retur->get_returid();
		$proses=$this->M_retur->simpan_retur($returid,$tgltrans,$nofak,$regid,$idbrg,$nmbrg,$satbrg,$katbrg,$harpokbrg,$harjulbrg,$qtyret,$ket);
		 // Hapus sesi flash data
        $this->session->unset_userdata('msg');
        if ($proses) {
            $this->session->set_flashdata('msg', '<label class="label label-success">Data Retur berhasil disimpan dan stok barang telah berkurang</label>');
            
        } else {
            $this->session->set_flashdata('msg', '<label class="label label-success">Gagal dalam proses simpan</label>');
        }
		
		redirect('admin/retur');
	}else{
        echo "Halaman tidak ditemukan";
    }
	}

	function hapus_retur(){
	if($this->session->userdata('akses')=='1'){
		$kode = $this->input->post('txtkode');
		$this->M_retur->hapus_retur($kode);
		//--hapus file Retur menu admin v_retur 
		$this->hapus_retur_allfile($kode);
		redirect('admin/retur');
	}else{
        echo "Halaman tidak ditemukan";
    }
	}

	function cetak_data_retur() {
		$firstDay = $this->input->post('tgl1');
		$lastDay = $this->input->post('tgl2');
		$x['tgl1'] = $firstDay;
		$x['tgl2'] = $lastDay;
		$x['userid'] = $this->Mlogin->tampil_user();
		
		if($this->session->userdata('akses')=='1'){
			$x['data_retur'] = $this->M_retur->get_retur($firstDay,$lastDay);
			$this->load->view('admin/cetak/v_cetak_data_retur', $x);
		}elseif($this->session->userdata('akses')=='2') {
			$x['data_retur'] = $this->M_retur->get_retur_kasir($firstDay,$lastDay);
			$this->load->view('admin/cetak/v_cetak_data_retur_kasir', $x);
		}

	}

	function get_tampil_retur(){
		$kode = $this->input->post('kode');
        $data = $this->M_retur->get_tampil_retur($kode);
        if (!empty($data)) {
            echo json_encode($data);
        } else {
            echo json_encode(array('error' => 'Data not found'));
        }
	}

	//------------------Batas Add File Retur ---------------------------------------
	function upload_file() {
        $noid = $this->input->post('txtnoid');
        $idbrg = $this->input->post('txtidbrg');
        $path = FCPATH . 'assets/img/file_retur/';

        // Mengecek apakah ada file yang diunggah (gambar)
        if (!empty($_FILES['bfile']['name'][0])) {
            $files = $_FILES['bfile'];

            foreach ($files['name'] as $key => $file_name) {
                $file_tmp = $files['tmp_name'][$key];

                if (!empty($file_name)) {
                    $config['upload_path']   = $path;
                    $config['allowed_types'] = 'gif|jpg|png|jpeg|webp|svg';
                    $config['max_size']      = 0; // Mengizinkan ukuran file apapun 100
                    $config['max_width']     = 0; //1024
                    $config['max_height']    = 0; //768
                    $this->load->library('upload', $config);

                    $_FILES['bfile_single']['name']     = $file_name;
                    $_FILES['bfile_single']['type']     = $files['type'][$key];
                    $_FILES['bfile_single']['tmp_name'] = $file_tmp;
                    $_FILES['bfile_single']['error']    = $files['error'][$key];
                    $_FILES['bfile_single']['size']     = $files['size'][$key];

                    if ($this->upload->do_upload('bfile_single')) {
                        $upload_data = $this->upload->data();
                        $nmfile = $noid . "-" . ($key + 1) . $upload_data['file_ext'];

                        // Kode untuk menangani file gambar (seperti resize)
                        list($width, $height) = getimagesize($upload_data['full_path']);
                        if ($width > 1024 || $height > 768) {
                            $this->load->library('image_lib');
                            $config_resize['image_library'] = 'gd2';
                            $config_resize['source_image'] = $upload_data['full_path'];
                            $config_resize['maintain_ratio'] = TRUE;
                            $config_resize['width'] = 800;
                            $config_resize['height'] = 600;
                            $this->image_lib->initialize($config_resize);
                            $this->image_lib->resize();
                            $this->image_lib->clear();
                        }
                        // --------------------------------------------------------------

                        rename($upload_data['full_path'], $path . $nmfile);
                        $proses = $this->M_retur->add_file_garansi($noid, $idbrg, $nmfile);
                    } else {
                        // Kode untuk menangani file bebas
                        $file_bebas = $files['tmp_name'][$key];

                        if (!empty($file_bebas)) {
                            $pathFile = $path . $file_name;
                            move_uploaded_file($file_bebas, $pathFile);
                            $nmfile = $noid . "-" . ($key + 1) . '.' . pathinfo($pathFile, PATHINFO_EXTENSION);
                            rename($pathFile, $path . $nmfile);
                            $proses = $this->M_retur->add_file_garansi($noid, $idbrg, $nmfile);
                        } else {
                            $error = array('error' => $this->upload->display_errors());
                            print_r($error);
                        }
                    }
                }
            }
        }

        // Hapus sesi flash data
        $this->session->unset_userdata('msg');
        if ($proses) {
            $this->session->set_flashdata('msg', '<label class="label label-success">Data Upload File / Dokumen Retur berhasil disimpan</label>');
        } else {
            $this->session->set_flashdata('msg', '<label class="label label-danger">Gagal dalam proses simpan</label>');
        }

        redirect('admin/retur');
    }



    function get_retur_file(){
    if($this->session->userdata('akses')=='1' || $this->session->userdata('akses')=='2'){
        //$this->session->unset_userdata('msg'); //menghapus session message flashdata
        $noid = $this->input->post('noid');
        $idbrg = $this->input->post('idbrg');
        $data = $this->M_retur->get_retur_file($noid,$idbrg);
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

	//---menu hapus v_retur_kasir form modal upload---------
    function hapus_retur_file(){
		$rid = $this->input->post('rid2');
        $nmfile = $this->input->post('rfile2');
		$path = FCPATH . 'assets/img/file_retur/';
		// Hapus file  / gambar jika ada
		$file_name = $nmfile;
		if ($file_name) {
			$file_path = $path . $file_name;
			if (file_exists($file_path)) {
				unlink($file_path);
			}
		}
		$data = $this->M_retur->hapus_file($rid);
        if (!empty($data)) {
            echo json_encode($data);
        } else {
            echo json_encode(array('error' => 'Data not found'));
        }

	}
	//-----------------------------------------------------------

	//---menu hapus v_retur form Retur User Admin---------
	function hapus_retur_allfile($kode) {
    $data = $this->M_retur->get_file($kode);
        if (!empty($data) && is_array($data)) {
            foreach ($data as $row) {
				$rid = $row['r_id'];
                $nmfile = $row['r_file'];
                $path = FCPATH . 'assets/img/file_retur/';

                // Hapus file/gambar jika ada
                $file_name = $nmfile;
                if ($file_name) {
                    $file_path = $path . $file_name;
                    if (file_exists($file_path)) {
                        unlink($file_path);

                        // Hapus file dari database hanya jika penghapusan file berhasil
                        $this->M_retur->hapus_file($rid);
                    }
                }
            }
        }
    }









}