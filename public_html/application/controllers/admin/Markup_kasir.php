<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Markup_kasir extends CI_Controller{
	function __construct(){
		parent::__construct();
		if($this->session->userdata('masuk') !=TRUE){
            $url=base_url();
            redirect($url);
        };
		$this->load->model('Mlogin');
		$this->load->model('M_markup_kasir');
	}
	function index(){
	if($this->session->userdata('akses')=='2'){
		$data['userid'] = $this->Mlogin->tampil_user();
		$data['data'] = $this->M_markup_kasir->tampil_penjualan();
		$this->load->view('admin/v_markup_kasir',$data);
	}
	}

	function get_detail_jual(){
    if($this->session->userdata('akses')=='2'){
        $nofak = $this->input->post('nofak');
        $data = $this->M_markup_kasir->getdetailjual($nofak);
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
	
    function create_jual(){
        if($this->session->userdata('akses')=='2'){
            $nofak = $this->input->post('nofak');
            $result = $this->M_markup_kasir->create_jual($nofak);

            if ($result['resultA'] && $result['resultB']) {
                $data = $this->M_markup_kasir->get_markup($nofak);
                if (!empty($data)) {
                    echo json_encode($data);
                } else {
                    echo json_encode(array('error' => 'Data not found'));
                }
            } else {
                echo json_encode(array('error' => 'Failed to insert data'));
            }
        } else {
            // Jika akses tidak sesuai, Anda bisa mengirim status 403 Forbidden
            http_response_code(403);
            echo json_encode(array('error' => 'Forbidden'));
        }
    }

    function get_markup(){
    if($this->session->userdata('akses')=='2'){
        $nofak = $this->input->post('nofak');
        $data = $this->M_markup_kasir->get_markup($nofak);
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

    function update_markup() {
        $nofak=$this->input->post('nofak');
        $idbrg=$this->input->post('idbrg');
        $harjul=str_replace([',', '.'], "", $this->input->post('harjul'));
        $diskon=str_replace([',', '.'], "", $this->input->post('diskon'));
        $total=str_replace([',', '.'], "", $this->input->post('total'));
        $qty = (float) str_replace(',','.', $this->input->post('qty'));
        $groupid=str_replace([',', '.'], "", $this->input->post('idset'));
        $groupdesc=str_replace([',', '.'], "", $this->input->post('deskset'));
        $groupsat=str_replace([',', '.'], "", $this->input->post('jmlset'));
        
        $data = $this->M_markup_kasir->update_markup($nofak,$idbrg,$harjul,$diskon,$total,$qty,$groupid,$groupdesc,$groupsat);
        if (!empty($data)) {
            echo json_encode($data);
        } else {
            echo json_encode(array('error' => 'Data not found'));
        }
    }

    function save_bayar() {
        $nofak = $this->input->post('nofak');
        $totjual = $this->input->post('totjual');
        $jmlbyr = str_replace([',', '.'], "", $this->input->post('jmlbyr'));
        $kembalian = floatval($jmlbyr - $totjual);
        $kurangbayar = floatval($totjual - $jmlbyr);
        $data = $this->M_markup_kasir->save_bayar($nofak,$jmlbyr,$kembalian,$kurangbayar);
        if (!empty($data)) {
            echo json_encode($data);
        } else {
            echo json_encode(array('error' => 'Data not found'));
        }
    }

    // function hapus_markup(){
    //     if($this->session->userdata('akses')=='2'){
    //         $nofak = $this->input->post('nofak');
    //         $data = $this->M_markup_kasir->hapus_markup($nofak);
    //         if (!empty($data)) {
    //             echo json_encode($data);
    //         } else {
    //             echo json_encode(array('error' => 'Data not found'));
    //         }
    //     } else {
    //         // Jika akses tidak sesuai, Anda bisa mengirim status 403 Forbidden
    //         http_response_code(403);
    //         echo json_encode(array('error' => 'Forbidden'));
    //     }
    // }

    
    function cetak_faktur($nofak){
        $x['userid'] = $this->Mlogin->tampil_user();
		$x['data']=$this->M_markup_kasir->cetak_faktur($nofak);
		$this->load->view('admin/laporan/v_faktur',$x);
	}

    function cetak_faktur2($nofak){
        $x['userid'] = $this->Mlogin->tampil_user();
		$x['data']=$this->M_markup_kasir->cetak_faktur($nofak);
		$this->load->view('admin/laporan/v_faktur_2',$x);
	}


	
}