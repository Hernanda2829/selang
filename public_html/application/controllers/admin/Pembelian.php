<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Pembelian extends CI_Controller{
	function __construct(){
		parent::__construct();
		if($this->session->userdata('masuk') !=TRUE){
            $url=base_url();
            redirect($url);
        };
		$this->load->model('M_kategori');
		$this->load->model('M_barang');
		$this->load->model('M_suplier');
		$this->load->model('M_pembelian');
		$this->load->model('Mlogin');
	}
	function index(){
	if($this->session->userdata('akses')=='1'){
		$x['userid']=$this->Mlogin->tampil_user();
		$x['sup']=$this->M_suplier->tampil_suplier();
		$x['data']=$this->M_barang->tampil_barang();
		$this->load->view('admin/v_pembelian',$x);
	}else{
        echo "Halaman tidak ditemukan";
    }
	}
	function get_barang(){
	if($this->session->userdata('akses')=='1'){
		$kobar=$this->input->post('kode_brg');
		$x['brg']=$this->M_barang->get_barang($kobar);
		$x['units'] = $this->M_barang->tampil_units();
		$this->load->view('admin/v_detail_barang_beli',$x);
	}else{
        echo "Halaman tidak ditemukan";
    }
	}
	
	function add_to_cart(){
	if($this->session->userdata('akses')=='1'){
		$nofak=$this->input->post('nofak');
		$tgl=$this->input->post('tgl');
		$suplier=$this->input->post('suplier');
		$this->session->set_userdata('nofak',$nofak);
		$this->session->set_userdata('tglfak',$tgl);
		$this->session->set_userdata('suplier',$suplier);
		$kobar=$this->input->post('kode_brg');
		$produk=$this->M_barang->get_barang($kobar);
		$i=$produk->row_array();
		if (!empty($i)) {
			$data = array(
				'id'       => $i['barang_id'],
				'name'     => $this->input->post('nabar'),
				'satuan'   => $this->input->post('satuan'),
				//'qty'      => (float) $this->input->post('jumlah'),  
				'qty' 	   => (float) str_replace(',','.', $this->input->post('jumlah')),
				'price'    => str_replace([',', '.'], "", $this->input->post('harbel')),
				'amount'   => str_replace([',', '.'], "", $this->input->post('harbel'))	
            );
		}else{
			$data = array(
				'id'       => $this->input->post('kode_brg'),
				'name'     => $this->input->post('nabar'),
				'satuan'   => $this->input->post('satuan'),
				//'qty'      => (float) $this->input->post('jumlah'),  
				'qty' 	   => (float) str_replace(',','.', $this->input->post('jumlah')),
				'price'    => str_replace([',', '.'], "", $this->input->post('harbel')),
				'amount'   => str_replace([',', '.'], "", $this->input->post('harbel'))	
            );
		}
		$this->cartbeli->insert($data); 
		redirect('admin/pembelian');
	}else{
        echo "Halaman tidak ditemukan";
    }
	}
	
	function remove(){
	if($this->session->userdata('akses')=='1'){
		$row_id=$this->uri->segment(4);
		$this->cartbeli->update(array(
               'rowid'      => $row_id,
               'qty'     => 0
            ));
		redirect('admin/pembelian');
	}else{
        echo "Halaman tidak ditemukan";
    }
	}

	function simpan_pembelian(){
	if($this->session->userdata('akses')=='1'){
		$nofak=$this->session->userdata('nofak');
		$tglfak=$this->session->userdata('tglfak');
		$suplier=$this->session->userdata('suplier');
		if(!empty($nofak) && !empty($tglfak) && !empty($suplier)){
			$beli_kode=$this->M_pembelian->get_kobel();
			$order_proses=$this->M_pembelian->simpan_pembelian($nofak,$tglfak,$suplier,$beli_kode);
			if($order_proses){
				$this->cartbeli->destroy();
				$this->session->unset_userdata('nofak');
				$this->session->unset_userdata('tglfak');
				$this->session->unset_userdata('suplier');
				echo $this->session->set_flashdata('msg','<label class="label label-success">Pembelian Berhasil di Simpan ke Database</label>');
				redirect('admin/pembelian');	
			}else{
				redirect('admin/pembelian');
			}
		}else{
			echo $this->session->set_flashdata('msg','<label class="label label-danger">Pembelian Gagal di Simpan, Mohon Periksa Kembali Semua Inputan Anda!</label>');
			redirect('admin/pembelian');
		}
	}else{
        echo "Halaman tidak ditemukan";
    }	
	}

	function batalsimpan() {
		//redirect('pembelian/remove');
		//menghapus session dan isi cartbeli
		$this->cartbeli->destroy();
		$this->session->unset_userdata('nofak');
		$this->session->unset_userdata('tglfak');
		$this->session->unset_userdata('suplier');
		redirect('admin/pembelian');
	}
}