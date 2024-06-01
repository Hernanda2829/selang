<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Jual extends CI_Controller{
	function __construct(){
		parent::__construct();
		if($this->session->userdata('masuk') !=TRUE){
            $url=base_url();
            redirect($url);
        };
		$this->load->model('Mlogin');
		$this->load->model('M_jual');
	}
	function index(){
	if($this->session->userdata('akses')=='1'){
		$data['userid'] = $this->Mlogin->tampil_user();
		//$data['data']=$this->M_beli->tampil_beli();
		$this->load->view('admin/v_jual',$data);
	}elseif($this->session->userdata('akses')=='2'){
        $data['userid'] = $this->Mlogin->tampil_user();
		$this->load->view('admin/v_jualkasir',$data);
    }
	}

	function get_penjualan_data() {
    if($this->session->userdata('akses')=='1'){
        $reg_id = $this->input->get('reg_id');  // Ambil ID cabang dari parameter GET
        //if ($reg_id !== null) {
        if ($reg_id === '0') {
            $data = $this->M_jual->getPenjualanData();
        }elseif ($reg_id !== null && $reg_id !== '') {
            // Jika ID cabang tersedia, gunakan untuk memfilter data
            $data = $this->M_jual->getPenjualanDataByRegion($reg_id);
        } else {
            // Jika ID cabang tidak tersedia, ambil semua data
            $data = $this->M_jual->getPenjualanData();
        }
    }elseif($this->session->userdata('akses')=='2'){
        $reg_id=$this->session->userdata('regid');
        $data = $this->M_jual->getPenjualanDataByRegion($reg_id);
    }
        
        echo json_encode($data);
    }

    
    function get_detail_data() {
        $data = $this->M_jual->getDetailData();
        echo json_encode($data);
    }

    //pembatasan hak akses cetak faktur oleh beda user
    // function cetak_faktur($nofak,$userid){
    //     $user_id=$this->session->userdata('idadmin'); //mengambil user yang sedang login
    //     if ($userid==$user_id) {
    //         $x['userid'] = $this->Mlogin->tampil_user();
    //         $x['data']=$this->M_jual->get_faktur($nofak,$userid);
    //         $this->load->view('admin/laporan/v_faktur',$x);
    //     }else if ($this->session->userdata('akses')=='1') {
    //         $x['userid'] = $this->Mlogin->tampil_user();
    //         $x['data']=$this->M_jual->get_fakturAdmin($nofak,$userid);
    //         $this->load->view('admin/laporan/v_faktur',$x);
    //     }else {
    //         echo "Anda tidak diperkenankan mencetak Faktur tersebut";
    //     }
	// }

    function cetak_faktur($nofak,$userid){
        if($this->session->userdata('akses')=='1'){
            $x['userid'] = $this->Mlogin->tampil_user();
            $x['data']=$this->M_jual->get_fakturAdmin($nofak,$userid);
            $this->load->view('admin/laporan/v_faktur',$x);
        }elseif($this->session->userdata('akses')=='2'){
            $x['userid'] = $this->Mlogin->tampil_user();
            $x['data']=$this->M_jual->get_faktur($nofak,$userid);
            $this->load->view('admin/laporan/v_faktur',$x);
        }
	}

    // function cetak_faktur2($nofak,$userid){
    //     $user_id=$this->session->userdata('idadmin'); //mengambil user yang sedang login
    //     if ($userid==$user_id) {
    //         $x['userid'] = $this->Mlogin->tampil_user();
    //         $x['data']=$this->M_jual->get_faktur($nofak,$userid);
    //         $this->load->view('admin/laporan/v_faktur_2',$x);
    //     }else if ($this->session->userdata('akses')=='1') {
    //         $x['userid'] = $this->Mlogin->tampil_user();
    //         $x['data']=$this->M_jual->get_fakturAdmin($nofak,$userid);
    //         $this->load->view('admin/laporan/v_faktur_2',$x);
    //     }else {
    //         echo "Anda tidak diperkenankan mencetak Faktur tersebut";
    //     }
	// }

    function cetak_faktur2($nofak,$userid){
        if($this->session->userdata('akses')=='1'){
            $x['userid'] = $this->Mlogin->tampil_user();
            $x['data']=$this->M_jual->get_fakturAdmin($nofak,$userid);
            $this->load->view('admin/laporan/v_faktur_2',$x);
        }elseif($this->session->userdata('akses')=='2'){
            $x['userid'] = $this->Mlogin->tampil_user();
            $x['data']=$this->M_jual->get_faktur($nofak,$userid);
            $this->load->view('admin/laporan/v_faktur_2',$x);
        }
	}

    function get_jual_bayar() {
        if($this->session->userdata('akses')=='1'){
            $level_user='1';
            $nofak = $this->input->get('nofak'); // Ambil nomor faktur dari parameter GET
            $data = $this->M_jual->getjualbayar($nofak);
            // Periksa apakah ada data yang ditemukan
            if (!empty($data)) {
                $data['queryA']['level_user'] = $level_user;
                // Jika ada data, kirim data dalam format JSON sebagai respons
                echo json_encode($data);
            } else {
                // Jika tidak ada data, kirim respons kosong atau pesan kesalahan jika diperlukan
                echo json_encode(array('error' => 'Data not found'));
            }
        }elseif($this->session->userdata('akses')=='2'){
            $level_user='2';
            $nofak = $this->input->get('nofak'); // Ambil nomor faktur dari parameter GET
            $data = $this->M_jual->getjualbayar($nofak);
            // Periksa apakah ada data yang ditemukan
            if (!empty($data)) {
                $data['queryA']['level_user'] = $level_user;
                // Jika ada data, kirim data dalam format JSON sebagai respons
                echo json_encode($data);
            } else {
                // Jika tidak ada data, kirim respons kosong atau pesan kesalahan jika diperlukan
                echo json_encode(array('error' => 'Data not found'));
            }
        }
    }

    
    function tambah_bayar() {
        $nofak=$this->input->post('kode');
        $tglbyr=$this->input->post('tglbyr');
        $totbyr=$this->input->post('totbyr');
        $kurbyr = str_replace([',', '.'], "", $this->input->post('kurbyr'));
        $jmlbyr = str_replace([',', '.'], "", $this->input->post('jmlbyr'));
        if ($kurbyr==$jmlbyr) {
            $ket="Lunas";
        }else{
            $ket="Belum Lunas";
        }
        $this->M_jual->tambahbayar($nofak,$tglbyr,$totbyr,$jmlbyr,$ket);
        redirect('admin/Jual');
    }

    function tambah_bayar_admin() {
        $nofak=$this->input->post('kode');
        $tglbyr=$this->input->post('tglbyr');
        $totbyr=$this->input->post('totbyr');
        $tgltrans=$this->input->post('tgltrans');
        $regid=$this->input->post('kode_cab');
        $kurbyr = str_replace([',', '.'], "", $this->input->post('kurbyr'));
        $jmlbyr = str_replace([',', '.'], "", $this->input->post('jmlbyr'));
        if ($kurbyr==$jmlbyr) {
            $ket="Lunas";
        }else{
            $ket="Belum Lunas";
        }
        $this->M_jual->tambah_bayar_admin($nofak,$tglbyr,$totbyr,$jmlbyr,$ket,$tgltrans,$regid);
        redirect('admin/Jual');
    }

    function hapus_data(){
	if($this->session->userdata('akses')=='1'){
		$kode=$this->input->post('kodehapus');
		$this->M_jual->hapus_penjualan($kode);
		redirect('admin/Jual');
    }
	}

	
}