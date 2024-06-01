<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Bank extends CI_Controller{
	function __construct(){
		parent::__construct();
		if($this->session->userdata('masuk') !=TRUE){
            $url=base_url();
            redirect($url);
        };
		$this->load->model('M_bank');
        $this->load->model('Mlogin');
	}

	function index(){
		if($this->session->userdata('akses')=='1'){
        	$firstDay = $this->getFirstDayOfMonth();
        	$lastDay = $this->getLastDayOfMonth();
			$data['firstDayOfMonth'] = $firstDay;
        	$data['lastDayOfMonth'] = $lastDay;
			$data['userid'] = $this->Mlogin->tampil_user();
			$data['regions']=$this->Mlogin->tampil_regions();
			$data['data']=$this->M_bank->tampil_rekening();
			$this->load->view('admin/v_bank',$data);
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

	function tambah_transaksi() {
		$norek = $this->input->post('kode');
		$tgltrans = $this->input->post('tgltrans');
		$mutasi = $this->input->post('mutasi');
		$ket = $this->input->post('ket');
		$jml = str_replace([',', '.'], "", $this->input->post('jml'));
		if ($mutasi == "Debit") {
			$debit = $jml;
			$kredit = 0;
		} else {
			$debit = 0;
			$kredit = $jml;
		}
		// $cabang = $this->input->post('cabang');
		// $ket2 = !empty($cabang) ? "Transfer" : '';
		//$result = $this->M_bank->simpan_transaksi($norek, $tgltrans, $mutasi, $ket, $jml, $debit, $kredit, $cabang, $ket2);

		$result = $this->M_bank->simpan_transaksi($norek, $tgltrans, $mutasi, $ket, $jml, $debit, $kredit);
	
		if ($result) {
			// Transaksi berhasil
			$this->session->set_flashdata('success_message', 'Transaksi berhasil disimpan!');
			redirect('admin/bank');
		} else {
			// Transaksi gagal
			$this->session->set_flashdata('error_message', 'Transaksi gagal. Mohon coba lagi.');
			redirect('admin/bank');
		}
	}

	function tambah_rekening() {
		$norek = $this->input->post('no_rek');
		$nmrek = $this->input->post('nm_rek');
		$nmbank = $this->input->post('nm_bank');
		// Proses upload gambar
		$upload_result = $this->do_upload($norek);
		if ($upload_result['status']) {
			$logobank = $upload_result['file_name'];
			// Panggil model untuk menyimpan data rekening
			$result = $this->M_bank->simpan_rekening($norek, $nmrek, $nmbank, $logobank);
			if ($result) {
				$this->session->set_flashdata('success_message', 'Data rekening berhasil disimpan!');
			} else {
				$this->session->set_flashdata('error_message', 'Gagal menyimpan data rekening. Mohon coba lagi.');
			}
		} else {
			$this->session->set_flashdata('error_message', 'Gagal mengunggah gambar. Mohon coba lagi.');
		}

		redirect('admin/bank');
	}

	function do_upload($norek) {
		$config['upload_path']   = FCPATH . 'assets/img/img_bank/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']      = 100;
		$config['max_width']     = 1024;
		$config['max_height']    = 768;
		$this->load->library('upload', $config);
		if (!$this->upload->do_upload('logo_bank')) {
			$error = array('error' => $this->upload->display_errors());
			return array('status' => false, 'error' => $error);
		} else {
			$data = array('upload_data' => $this->upload->data());
			$file_name = $data['upload_data']['file_name'];	//Mendapatkan nama file lama dan ekstensi filenya
			$file_ext = pathinfo($file_name, PATHINFO_EXTENSION);	// Mendapatkan ekstensi file lama
			// Ganti nama file sesuai dengan no_rek dan tambahkan ekstensi
			//$new_file_name = $norek . '_' . $file_name;
			$new_file_name = $norek . '.' . $file_ext;
			rename($config['upload_path'] . $file_name, $config['upload_path'] . $new_file_name);
			return array('status' => true, 'file_name' => $new_file_name);
		}
	}


	function get_rekening(){
        $rekid = $this->input->post('rekid');
        $data = $this->M_bank->get_rekening($rekid);
        if (!empty($data)) {
            echo json_encode($data);
        } else {
            echo json_encode(array('error' => 'Data not found'));
        }
	}

	function edit_rekening(){
		$rekid = $this->input->post('rekid3');
		$norek = $this->input->post('no_rek3');
		$nmrek = $this->input->post('nm_rek3');
		$nmbank = $this->input->post('nm_bank3');
		$nmlogo = $this->input->post('nm_logo');
		$logobaru = $this->input->post('txtlogo');
		if (!empty($logobaru)) {	//jika logo baru tidak kosong / logo lama diganti dengan logo baru

			// Variabel $config belum didefinisikan, definisikan terlebih dahulu
			$path = $config['upload_path'] = FCPATH . 'assets/img/img_bank/';
			// Hapus gambar lama jika ada
			$old_file_name = $nmlogo;
			if ($old_file_name) {
				$old_file_path = $path . $old_file_name;
				if (file_exists($old_file_path)) {
					unlink($old_file_path);
				}
			}

			// Upload gambar baru
			$config['upload_path']   = FCPATH . 'assets/img/img_bank/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size']      = 100;
			$config['max_width']     = 1024;
			$config['max_height']    = 768;
			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('logo_bank3')) {
				// Jika upload gagal, kirim pesan kesalahan ke pengguna
				$error = array('error' => $this->upload->display_errors());
				$this->session->set_flashdata('error_message', 'Gagal mengunggah gambar. Mohon coba lagi.');
			} else {
				// Jika upload berhasil, lanjutkan dengan proses update data rekening
				$data = array('upload_data' => $this->upload->data());
				$file_name = $data['upload_data']['file_name'];
				$file_ext = pathinfo($file_name, PATHINFO_EXTENSION); // Mendapatkan ekstensi file
				$new_file_name = $norek . '.' . $file_ext; // Ganti nama file sesuai dengan no_rek dan tambahkan ekstensi
				rename($config['upload_path'] . $file_name, $config['upload_path'] . $new_file_name);
				$logobank = $new_file_name;

				// Panggil model untuk melakukan update data rekening
				$this->M_bank->update_rekening($rekid, $norek, $nmrek, $nmbank, $logobank);
				// Kirim pesan sukses ke pengguna
				$this->session->set_flashdata('success_message', 'Data rekening berhasil diupdate!');
			}
		}else {
				$this->M_bank->update_rek($rekid, $norek, $nmrek, $nmbank); //update tanpa update logo
				$this->session->set_flashdata('success_message', 'Data rekening berhasil diupdate!');
		}

		redirect('admin/bank');
	}

	function hapus_rekening(){
		$rekid = $this->input->post('txtidbank');
		$nmlogo = $this->input->post('txtnmlogo');
		$path = FCPATH . 'assets/img/img_bank/';
		// Hapus gambar jika ada
		$file_name = $nmlogo;
		if ($file_name) {
			$file_path = $path . $file_name;
			if (file_exists($file_path)) {
				unlink($file_path);
			}
		}
		$this->M_bank->hapus_rekening($rekid);
		redirect('admin/bank');
       
	}

	function history_saldo(){
        $norek = $this->input->post('norekhis');
		$tgl1 = $this->input->post('tgl1');
		$tgl2 = $this->input->post('tgl2');
        $data = $this->M_bank->history_saldo($norek,$tgl1,$tgl2);
        if (!empty($data)) {
            echo json_encode($data);
        } else {
            echo json_encode(array('error' => 'Data not found'));
        }
	}

	function tampil_transaksi(){
        $norek = $this->input->post('norek');
        $data = $this->M_bank->tampil_transaksi($norek);
        if (!empty($data)) {
            echo json_encode($data);
        } else {
            echo json_encode(array('error' => 'Data not found'));
        }
	}

	function hapus_transaksi(){
		$kode = $this->input->post('bankid');
		$result = $this->M_bank->hapus_transaksi($kode);
		
		//menampilkan kembali data
		$norek = $this->input->post('norekhapus');
        $data = $this->M_bank->tampil_transaksi($norek);
        if (!empty($data)) {
            echo json_encode($data);
        } else {
            echo json_encode(array('error' => 'Data not found'));
        }

	}

	function cek_norek() {
		$norek = $this->input->get('norek'); // Ambil kode barang dari parameter GET
		$num_rows = $this->M_bank->cek_norek($norek);
		// Periksa jumlah baris yang cocok
		if ($num_rows > 0) {
			$response = array('is_registered' => true);
		} else {
			$response = array('is_registered' => false);
		}
		echo json_encode($response);
	}		




}