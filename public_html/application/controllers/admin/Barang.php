<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Barang extends CI_Controller{
	function __construct(){
		parent::__construct();
		if($this->session->userdata('masuk') !=TRUE){
            $url=base_url();
            redirect($url);
        };
		$this->load->model('M_kategori');
		$this->load->model('M_barang');
		$this->load->model('Mlogin');
		//$this->load->library('barcode');
	}

	function index(){
		if($this->session->userdata('akses')=='1'){
			//$data['stok_data'] = $this->M_barang->getStokByCabang();
			$data['units'] = $this->M_barang->tampil_units(); // Mendapatkan data units
			$data['regions'] = $this->M_barang->tampil_regions(); // Mendapatkan data regions
			$jmlreg = $data['regions']->num_rows(); // Menghitung jumlah baris (row)
			$data['jmlreg'] = $jmlreg; // Menambahkan jumlah record ke dalam array $data
			$data['userid'] = $this->Mlogin->tampil_user(); // Mendapatkan data user
			$data['kat']=$this->M_kategori->tampil_kategori();
			$data['diskon']=$this->M_barang->tampil_diskon();
			$this->load->view('admin/v_barang',$data);
		}elseif($this->session->userdata('akses')=='2'){
			$data['data']=$this->M_barang->tampil_barang();
			$data['units'] = $this->M_barang->tampil_units(); // Mendapatkan data units
			$data['userid'] = $this->Mlogin->tampil_user(); // Mendapatkan data user
			$data['kat']=$this->M_kategori->tampil_kategori();
			//$data['kat2']=$this->M_kategori->tampil_kategori();
			$this->load->view('admin/v_barangkasir',$data);
		}else{
			echo "Halaman tidak ditemukan";
		}
	}

	function ajaxStokByCabang() {
		$requestData = $this->input->post();
		// Tambahkan penanganan untuk 'draw', 'length', dan 'start'
		$draw = isset($requestData['draw']) ? $requestData['draw'] : 0;
		$length = isset($requestData['length']) ? $requestData['length'] : 10;
		$start = isset($requestData['start']) ? $requestData['start'] : 0;

		$requestData['draw'] = (int)$draw;
		$requestData['length'] = (int)$length;
		$requestData['start'] = (int)$start;

		$data = $this->M_barang->getStokByCabang($requestData);

		$output = [
			"draw" => intval($draw),
			"recordsTotal" => $this->M_barang->hitungTotalData(),
			"recordsFiltered" => $this->M_barang->hitungFilteredData($requestData),
			"data" => $data,
		];

		echo json_encode($output);
	}

	function get_stok_cabang(){
        $idbrg = $this->input->post('idbrg');
		$data = $this->M_barang->get_stok_cabang($idbrg);
        if (!empty($data)) {
            echo json_encode($data);
        } else {
            echo json_encode(array('error' => 'Data not found'));
        }
	}



	function tambah_barang(){
	if($this->session->userdata('akses')=='1'){
		$kobar=$this->input->post('kobar');
		$nabar=$this->input->post('nabar');
		$diskon=$this->input->post('diskon');
		$kat=$this->input->post('kategori');
		$satuan=$this->input->post('satuan');
		$harpok=str_replace([',', '.'], "", $this->input->post('harpok'));
		$harjul=str_replace([',', '.'], "", $this->input->post('harjul'));
		// Mendapatkan data stok untuk setiap region
		$stok_data = array();
		$regions = $this->db->get('regions')->result_array();
		foreach ($regions as $reg) {
			$id_reg = $reg['reg_id'];
			$stok_key = "stok_".$id_reg;
			// Menangkap nilai stok dari input
			$stok_value = str_replace(',', '.', $this->input->post($stok_key));
			// Menyimpan data stok ke dalam array jika nilai tidak 0 atau null
			if (!empty($stok_value)) {
				$stok_data[$id_reg] = $stok_value;
			}
		}
		//--------------------------------------
		$this->M_barang->tambahbarang($kobar,$nabar,$diskon,$kat,$satuan,$harpok,$harjul,$stok_data);
		redirect('admin/barang');
	}else{
        echo "Halaman tidak ditemukan";
    }
	}
	
	function edit_barang(){
	if($this->session->userdata('akses')=='1'){
		$kobar=$this->input->post('kobarE');
		$nabar=$this->input->post('nabarE');
		$diskon=$this->input->post('diskonE');
		$kat=$this->input->post('kategoriE');
		$satuan=$this->input->post('satuanE');
		//$harpok=str_replace(',', '', $this->input->post('harpok'));
		$harpok=str_replace([',', '.'], "", $this->input->post('harpokE'));
		//$harjul=str_replace(',', '', $this->input->post('harjul'));
		$harjul=str_replace([',', '.'], "", $this->input->post('harjulE'));
		// Mendapatkan data stok untuk setiap region
		$stok_data = array();
		$regions = $this->db->get('regions')->result_array();
		foreach ($regions as $reg) {
			$id_reg = $reg['reg_id'];
			$stok_key = "stokE_".$id_reg;
			$qty_key = "qtyE_".$id_reg;
			// Menangkap nilai stok dan qty dari input
			$stok_value = (float) str_replace(',', '.', $this->input->post($stok_key));
			$qty_value = (float) str_replace(',', '.', $this->input->post($qty_key));
			// Menginisialisasi variabel $ket_stok dan $qty_add
			$stok_stat = "";
			$stok_in = 0;
			$stok_out = 0;
			if ($stok_value > $qty_value) {
				$stok_stat = "in";
				$stok_in = $stok_value - $qty_value;
			} elseif ($stok_value < $qty_value) {
				$stok_stat = "out";
				$stok_out = $qty_value - $stok_value;
			}elseif ($stok_value = $qty_value) {
				$stok_value = 0;
				$stok_stat = "";
				$stok_in = 0;
				$stok_out = 0;
			}
			// Menyimpan data stok ke dalam array jika nilai tidak 0 atau null
			if (!empty($stok_value) && $stok_value != 0) {
				// Menambahkan variabel $ket_stok dan $qty_add ke dalam array
				$stok_data[$id_reg] = array(
					'stok_value' => $stok_value,
					'stok_stat' => $stok_stat,
					'stok_in' => $stok_in,
					'stok_out' => $stok_out
				);
			}
		}
		//--------------------------------------
		$this->M_barang->update_barang($kobar,$nabar,$diskon,$kat,$satuan,$harpok,$harjul,$stok_data);
		redirect('admin/barang');
	}else{
        echo "Halaman tidak ditemukan";
    }
	}

	function hapus_barang(){
	if($this->session->userdata('akses')=='1'){
		$kode=$this->input->post('kodeH');
		$this->M_barang->hapus_barang($kode);
		redirect('admin/barang');
	}else{
        echo "Halaman tidak ditemukan";
    }
	}

	function cek_kobar() {
    $kobar = $this->input->get('kobar'); // Ambil kode barang dari parameter GET
    $num_rows = $this->M_barang->cekkobar($kobar);
    // Periksa jumlah baris yang cocok
    if ($num_rows > 0) {
        $response = array('is_registered' => true);
    } else {
        $response = array('is_registered' => false);
    }
    echo json_encode($response);
	}



}