<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Penjualan extends CI_Controller{
	function __construct(){
		parent::__construct();
		if($this->session->userdata('masuk') !=TRUE){
            $url=base_url();
            redirect($url);
        };
		
		$this->load->model('M_penjualan');
		$this->load->model('Mlogin');

	}
	
	function index(){
	if($this->session->userdata('akses')=='1') {
		//echo "Maaf anda sebagai admin tidak dapat melakukan transaksi penjualan";
		// $data['userid']=$this->Mlogin->tampil_user();
		// $this->load->view('admin/v_jual',$data);
	}elseif($this->session->userdata('akses')=='2') {
		$data['periode'] = $this->M_penjualan->tampil_periode();
		$data['data']=$this->M_penjualan->tampil_barang();
		$data['userid']=$this->Mlogin->tampil_user();
		$data['cust']=$this->M_penjualan->tampil_customerkasir();
		$data['tglskrg']=date('Y-m-d');
		$this->load->view('admin/v_penjualan',$data);
	}else{
        echo "Halaman tidak ditemukan";
    }
	}
	
	function get_barang(){
	if($this->session->userdata('akses')=='1' || $this->session->userdata('akses')=='2') {
		$kobar=$this->input->post('kode_brg');
		$x['brg']=$this->M_penjualan->get_barang($kobar);
		if ($x['brg']->num_rows() > 0) {
			$data_barang = $x['brg']->row_array();
        	$disc_id = $data_barang['barang_disc_id'];
        	$x['disc']=$this->M_penjualan->get_discount($disc_id);
		}	
		$this->load->view('admin/v_detail_barang_jual',$x);
	}else{
        echo "Halaman tidak ditemukan";
    }
	}
	

	function update_set() {
		$requestData = json_decode($this->input->post('requestData'), true);
		foreach ($requestData as $item) {
			$id = $item['id'];
			$g_id = $item['groupid'];
			$g_desk = $item['groupdesk'];
			$g_jml = $item['groupjml'];

			if (!empty($this->cart->total_items())) {
				foreach ($this->cart->contents() as $items) {
					$rowid = $items['rowid'];

					if ($id == $rowid) {
						$up = array(
							'rowid' => $rowid,
							'kode_set' => $g_id,
							'desk_set' => $g_desk,
							'jml_set' => $g_jml
						);
						$this->cart->update($up);
						
					}
				}
			}
		}
		redirect('admin/penjualan');
	}


	function add_to_cart(){
		if($this->session->userdata('akses')=='1' || $this->session->userdata('akses')=='2'){
			$kode_set = (!empty($this->input->post('kode_set')) ? $this->input->post('kode_set') : null);
			$desk_set = (!empty($this->input->post('desk_set')) ? $this->input->post('desk_set') : null);
			$jml_set = (!empty($this->input->post('jml_set')) ? $this->input->post('jml_set') : null);

			$customer=$this->input->post('customer');
			$nota=$this->input->post('nota');
			$carabayar=$this->input->post('carabayar');
			if ($carabayar=="Cash") {
				$stsbayar='Lunas';
				$this->session->unset_userdata('bln');
				$this->session->unset_userdata('jtm');
			}else {
				$stsbayar='Belum Lunas';
				$prdbln=$this->input->post('prdbln');
				$tgljtempo=$this->input->post('tgljtempo');
				$this->session->set_userdata('bln',$prdbln);
				$this->session->set_userdata('jtm',$tgljtempo);
			}
			$this->session->set_userdata('idcust',$customer);
			$this->session->set_userdata('nota',$nota);
			$this->session->set_userdata('carabyr',$carabayar);
			$this->session->set_userdata('stsbyr',$stsbayar);
			$kobar = $this->input->post('kode_brg');
			$ratedisc = str_replace(',','.', $this->input->post('ratediskon'));
			$produk = $this->M_penjualan->get_barang($kobar);
			$jstok = (float) str_replace('.','', $this->input->post('stok'));
			$jqty = (float) str_replace(',','.', $this->input->post('qty'));
			if ($jqty <=$jstok) {
				if ($produk->num_rows() > 0) {
					$i = $produk->row_array();
					$data = array(
						'id'       => $i['barang_id'],
						'name'     => $i['barang_nama'],
						'satuan'   => $i['barang_satuan'],
						'kategori' => $i['barang_kategori_nama'],
						'harpok'   => $i['barang_harpok'],
						'price'    => str_replace([',', '.'], "", $this->input->post('harjul')) - str_replace([',', '.'], "", $this->input->post('diskon')),
						'disc'     => str_replace([',', '.'], "", $this->input->post('diskon')),
						'qty'      => str_replace(',','.', $this->input->post('qty')),
						'amount'   => str_replace([',', '.'], "", $this->input->post('harjul')),
						'ratedisc' => $ratedisc,
						'kode_set' => $kode_set,
						'desk_set' => $desk_set,
						'jml_set' => $jml_set

					);


					//-----------cek jumlah stok-----------------
					$stok = (float) $this->input->post('stok');
					$qty_input = (float) $this->input->post('qty');

					$is_existing_item = false;
					$existing_item_qty = 0; // Menyimpan jumlah item yang sudah ada di keranjang

					// Periksa apakah keranjang tidak kosong
					if (!empty($this->cart->total_items())) {
						foreach ($this->cart->contents() as $items) {
							$id = $items['id'];
							$qty_lama = (float) $items['qty'];
							$ratedc = (float) $items['ratedisc'];
							$tot_qty = $qty_lama + $qty_input;

							// Jika kode item sudah ada dalam keranjang
							if ($id == $kobar) {
								// Jika rate diskon sama
								if ($ratedc == $ratedisc) {
									$existing_item_qty += $qty_lama;	// Tambahkan jumlah item yang sudah ada di keranjang
								} else {
									// Jika rate diskon tidak sama, berikan pesan kesalahan
									$this->session->set_flashdata('msg', '<label class="label label-danger">Rate Diskon tidak sama, tidak ada penambahan item baru dalam keranjang</label>');
									redirect('admin/penjualan');
								}
							}
						}
					}

					// Total quantity yang akan ada di keranjang jika item baru ditambahkan
					$total_qty_in_cart = $existing_item_qty + $qty_input;

					// Jika total quantity di keranjang masih kurang dari atau sama dengan stok yang tersedia
					if ($total_qty_in_cart <= $stok) {
						// Tambahkan item baru ke keranjang
						$this->cart->insert($data);
					} else {
						// Jika melebihi stok, tampilkan pesan kesalahan
						$this->session->set_flashdata('msg', '<label class="label label-danger">Jumlah Quantity melebihi stok yang tersedia. Silahkan cek kembali inputan anda</label>');
					}
					//---------------------------------------------------------------
					redirect('admin/penjualan');




					//----------------------------------------------------------------------
					//gunakan perintah ini jika ingin menggabungkan kode barang yang sama, dengan penambahan quantity
					// $is_existing_item = false;
					// if (!empty($this->cart->total_items())) {
					// 	foreach ($this->cart->contents() as $items) {
					// 		$id = $items['id'];
					// 		$qtylama =(float) $items['qty'];
					// 		$rowid = $items['rowid'];
					// 		$dc = $items['disc'];
					// 		$ratedc = (float) $items['ratedisc'];
					// 		$stok = (float) $this->input->post('stok');
					// 		$diskon = str_replace([',', '.'], "", $this->input->post('diskon'));
					// 		$totqty = $qtylama + (float) $this->input->post('qty');

					// 		//if ($id == $kobar && $ratedc == $ratedisc) {
					// 		if ($id == $kobar) {
					// 			if ($ratedc == $ratedisc) {  // Periksa jika ratedisc sama
					// 				if ($totqty > $stok) {
					// 					echo $this->session->set_flashdata('msg', '<label class="label label-danger">Jumlah Quantity melebihi stok yang tersedia. Silahkan cek kembali inputan anda</label>');
					// 				} else {
					// 					$up = array(
					// 						'rowid' => $rowid,
					// 						'qty' => $qtylama + (float) $this->input->post('qty'),
					// 						'disc' => $dc + $diskon
					// 					);
					// 					$this->cart->update($up);
					// 				}
					// 				$is_existing_item = true;
					// 				break;  // Keluar dari loop setelah update dilakukan
					// 			}else {
					// 				echo $this->session->set_flashdata('msg', '<label class="label label-danger">Rate Diskon tidak sama, tidak ada penambahan item baru dalam keranjang</label>');
					// 				$is_existing_item = true;
					// 				break;
									
					// 			}
					// 		}
					// 	}
					// }

					// if (!$is_existing_item) {
					// 	$this->cart->insert($data);
					// }
					// 	redirect('admin/penjualan');
					//----------------------------------------------------------------------
					
				} else {
					echo $this->session->set_flashdata('msg', '<label class="label label-danger">Produk tidak ditemukan.</label>');
				}
			}else {
				echo $this->session->set_flashdata('msg', '<label class="label label-danger">Jumlah Quantity melebihi stok yang tersedia. Silahkan cek stok yang tersedia</label>');
			}
			redirect('admin/penjualan');

		}else{
			echo "Halaman tidak ditemukan";
		}
	}

	function remove(){
	if($this->session->userdata('akses')=='1' || $this->session->userdata('akses')=='2'){
		$row_id=$this->uri->segment(4);
		$this->cart->update(array(
               'rowid'      => $row_id,
               'qty'     => 0
            ));
		redirect('admin/penjualan');
	}else{
        echo "Halaman tidak ditemukan";
    }
	}

	function simpan_penjualan(){
	if($this->session->userdata('akses')=='1' || $this->session->userdata('akses')=='2'){	
		$total=$this->input->post('total');
		$jml_uang=$this->input->post('jml_uang2');
		$carabayar=$this->session->userdata('carabyr');
		if ($carabayar==="Cash") {
			if(!empty($total) && !empty($jml_uang)){
				// Ubah $total dan $jml_uang ke tipe numerik jika perlu
				$total = floatval($total);
				$jml_uang = floatval($jml_uang);
				$kembalian = $jml_uang - $total;
				if($jml_uang < $total){
					echo $this->session->set_flashdata('msg','<label class="label label-danger">Jumlah Uang yang anda masukan Kurang</label>');
					redirect('admin/penjualan');
				}else{
					//proses simpan------------------//
					$sisakurang=0; //membuat nol variabel sisakurang
					$nofak=$this->M_penjualan->get_nofak();
					$this->session->set_userdata('nofak',$nofak);	//dibuat session untuk langsung tampil v_faktur, model -> cetak_faktur
					$customer=$this->session->userdata('idcust');
					$nota=$this->session->userdata('nota');
					$carabayar=$this->session->userdata('carabyr');
					$statusbayar=$this->session->userdata('stsbyr');
					$prdbln='';
					$tgljtempo='';
					$order_proses=$this->M_penjualan->simpan_penjualan($nofak,$total,$jml_uang,$kembalian,$sisakurang,$customer,$nota,$carabayar,$statusbayar,$prdbln,$tgljtempo);
					if($order_proses){
						$this->cart->destroy();
						$this->session->unset_userdata('idcust');
						$this->session->unset_userdata('nota');
						$this->session->unset_userdata('carabyr');
						$this->session->unset_userdata('stsbyr');
						$this->session->unset_userdata('bln');
						$this->session->unset_userdata('jtm');
						$data['userid'] = $this->Mlogin->tampil_user(); // Mendapatkan data user
						$this->load->view('admin/alert/alert_sukses',$data);	
					}else{
						redirect('admin/penjualan');
					}
					//batas simpan------------------//
				}
				
			}else{
				echo $this->session->set_flashdata('msg','<label class="label label-danger">Penjualan Gagal di Simpan, Mohon Periksa Kembali Semua Inputan Anda!</label>');
				redirect('admin/penjualan');
			}
		}elseif ($carabayar==="Tempo") {
			//proses simpan------------------//
			// Ubah $total dan $jml_uang ke tipe numerik jika perlu
			$total = floatval($total);
			$jml_uang = floatval($jml_uang);
			$sisakurang = $total-$jml_uang;
			$kembalian=0; //membuat nol variabel kembalian
			$nofak=$this->M_penjualan->get_nofak();
			$this->session->set_userdata('nofak',$nofak);	//dibuat session untuk langsung tampil v_faktur, model -> cetak_faktur
			$customer=$this->session->userdata('idcust');
			$nota=$this->session->userdata('nota');
			$carabayar=$this->session->userdata('carabyr');
			$statusbayar=$this->session->userdata('stsbyr');
			$prdbln=$this->session->userdata('bln');
			$tgljtempo=$this->session->userdata('jtm');
			$order_proses=$this->M_penjualan->simpan_penjualan($nofak,$total,$jml_uang,$kembalian,$sisakurang,$customer,$nota,$carabayar,$statusbayar,$prdbln,$tgljtempo);
			if($order_proses){
				$this->cart->destroy();
				$this->session->unset_userdata('idcust');
				$this->session->unset_userdata('nota');
				$this->session->unset_userdata('carabyr');
				$this->session->unset_userdata('stsbyr');
				$this->session->unset_userdata('bln');
				$this->session->unset_userdata('jtm');
				$data['userid'] = $this->Mlogin->tampil_user(); // Mendapatkan data user
				$this->load->view('admin/alert/alert_sukses',$data);	
			}else{
				redirect('admin/penjualan');
			}
			//batas simpan------------------//
		}else{
        	echo "Halaman tidak ditemukan";
		}

	}else{
        echo "Halaman tidak ditemukan";
     }
	}

	function cetak_faktur(){
		$x['userid'] = $this->Mlogin->tampil_user();
		$x['data']=$this->M_penjualan->cetak_faktur();
		$this->load->view('admin/laporan/v_faktur',$x);
		//$this->session->unset_userdata('nofak');
	}

	function batalsimpan() {
		//redirect('pembelian/remove');
		//menghapus session dan isi cartbeli
		$this->cart->destroy();	
		$this->session->unset_userdata('idcust');
		$this->session->unset_userdata('nota');
		$this->session->unset_userdata('carabyr');
		$this->session->unset_userdata('stsbyr');
		$this->session->unset_userdata('bln');
		$this->session->unset_userdata('jtm');
		redirect('admin/penjualan');
	}


	function cek_customer() {
		$custid = $this->input->post('custid');
		$data = $this->M_penjualan->cek_customer($custid);
		if (!empty($data)) {
            echo json_encode($data);
        } else {
            echo json_encode(array('error' => 'Data not found'));
        }
	}



}


