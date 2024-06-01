<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Barcode extends CI_Controller{
	function __construct(){
		parent::__construct();
		if($this->session->userdata('masuk') !=TRUE){
            $url=base_url();
            redirect($url);
        };
        
		$this->load->model('M_barcode');
		$this->load->model('Mlogin');
		$this->load->library('ciqrcode'); //pemanggilan library QR CODE
		
	}
	function index(){
	if($this->session->userdata('akses')=='1'){
		
	}elseif($this->session->userdata('akses')=='2'){
        //$kode="abcdf";
        //$this->M_barcode->buat_img_barcode($kode);
        $data['periode'] = $this->M_barcode->tampil_periode();
        $data['data'] = $this->M_barcode->tampil_penjualan();
		$data['userid'] = $this->Mlogin->tampil_user();
        $data['g_data'] = $this->M_barcode->tampil_garansi();
		$this->load->view('admin/v_barcode', $data);
	}else{
        echo "Halaman tidak ditemukan";
    }
	}

	function get_detail_jual(){
    if($this->session->userdata('akses')=='1' || $this->session->userdata('akses')=='2'){
        $this->session->unset_userdata('msg'); //menghapus session message flashdata
        $nofak = $this->input->post('nofak');
        $data = $this->M_barcode->getdetailjual($nofak);
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


    function add_garansi() {
        $gjualtgl=$this->input->post('gjualtgl');
        $gcustnama=$this->input->post('gcustnama');
        $gnofak=$this->input->post('gnofak');
        $gbrgid=$this->input->post('gbrgid');
        $gbrgnama=$this->input->post('gbrgnama');
        $gbrgsat=$this->input->post('gbrgsat');
        $gqty=str_replace(',','.', $this->input->post('gqty'));
        $gharjul=str_replace([',', '.'], "", $this->input->post('gharjul'));
        $gdiskon=str_replace([',', '.'], "", $this->input->post('gdiskon'));
        $gtotal=str_replace([',', '.'], "", $this->input->post('gtotal'));
        $gjenisbayar=$this->input->post('gjenisbayar');
        $gstatusbayar=$this->input->post('gstatusbayar');
        $gperiode=$this->input->post('periode');
        $gjtempo=$this->input->post('tglJtempo');
        $gket=$this->input->post('ket');
        $proses=$this->M_barcode->addgaransi($gjualtgl,$gcustnama,$gnofak,$gbrgid,$gbrgnama,$gbrgsat,$gqty,$gharjul,$gdiskon,$gtotal,$gjenisbayar,$gstatusbayar,$gperiode,$gjtempo,$gket);
        $kode=$gnofak.'-'.$gbrgid;

        // Hapus sesi flash data
        $this->session->unset_userdata('msg');
        if ($proses) {
            $this->M_barcode->buat_img_barcode($kode);
            $this->session->set_flashdata('msg', '<label class="label label-success">Data Garansi berhasil disimpan dan Image Barcode berhasil dibentuk</label>');
            
        } else {
            $this->session->set_flashdata('msg', '<label class="label label-success">Gagal dalam proses simpan</label>');
        }

        redirect('admin/barcode');

    }

    function cetak_barcode(){
        $data['kolom'] = $this->input->post('kolom');
        $data['baris'] = $this->input->post('baris');
        $data['gimg'] = $this->input->post('gimg');
        $data['kdbrg'] = $this->input->post('kdbrg');
        $this->load->view('admin/v_barcode_cetak', $data);
    }


    function upload_file() {
        $nofak = $this->input->post('txtnofak');
        $idbrg = $this->input->post('txtidbrg');
        $path = FCPATH . 'assets/img/file_garansi/';

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
                        $nmfile = $nofak . "-" . ($key + 1) . $upload_data['file_ext'];

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
                        $proses = $this->M_barcode->add_file_garansi($nofak, $idbrg, $nmfile);
                    } else {
                        // Kode untuk menangani file bebas
                        $file_bebas = $files['tmp_name'][$key];

                        if (!empty($file_bebas)) {
                            $pathFile = $path . $file_name;
                            move_uploaded_file($file_bebas, $pathFile);
                            $nmfile = $nofak . "-" . ($key + 1) . '.' . pathinfo($pathFile, PATHINFO_EXTENSION);
                            rename($pathFile, $path . $nmfile);
                            $proses = $this->M_barcode->add_file_garansi($nofak, $idbrg, $nmfile);
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
            $this->session->set_flashdata('msg', '<label class="label label-success">Data Garansi berhasil disimpan dan Image Barcode berhasil dibentuk</label>');
        } else {
            $this->session->set_flashdata('msg', '<label class="label label-danger">Gagal dalam proses simpan</label>');
        }

        redirect('admin/barcode');
    }



    function get_garansi_file(){
    if($this->session->userdata('akses')=='1' || $this->session->userdata('akses')=='2'){
        //$this->session->unset_userdata('msg'); //menghapus session message flashdata
        $nofak = $this->input->post('nofak');
        $idbrg = $this->input->post('idbrg');
        $data = $this->M_barcode->get_garansi_file($nofak,$idbrg);
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

    function hapus_garansi_file(){
		$gid = $this->input->post('gid2');
        $nmfile = $this->input->post('gfile2');
		$path = FCPATH . 'assets/img/file_garansi/';
		// Hapus file  / gambar jika ada
		$file_name = $nmfile;
		if ($file_name) {
			$file_path = $path . $file_name;
			if (file_exists($file_path)) {
				unlink($file_path);
			}
		}
		$data = $this->M_barcode->hapus_file($gid);
        if (!empty($data)) {
            echo json_encode($data);
        } else {
            echo json_encode(array('error' => 'Data not found'));
        }

	}

    


}