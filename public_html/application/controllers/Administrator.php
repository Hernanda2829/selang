<?php
class Administrator extends CI_Controller{
    function __construct(){
        parent:: __construct();
        $this->load->model('Mlogin');
    }
    function index(){
        $x['judul']="Silahkan Masuk..!";
        $this->load->view('admin/v_login',$x);
        // $this->session->unset_userdata('user_id'); // Menghapus data user_id dari sesi
        // $this->session->unset_userdata('idadmin');
        // $this->session->unset_userdata('nama');
        // $this->session->unset_userdata('coid');
        // $this->session->unset_userdata('regid'); 
        $this->session->sess_destroy();//menghapus session
    }
    // function cekuser(){
    //     $username=strip_tags(stripslashes($this->input->post('username',TRUE)));
    //     $password=strip_tags(stripslashes($this->input->post('password',TRUE)));
    //     $u=$username;
    //     $p=$password;
    //     $cadmin=$this->Mlogin->cekadmin($u,$p);    
    //     //$admin_array = $cadmin->result_array(); // Jika mengembalikan beberapa baris
    //     $admin_array = $cadmin->row_array(); // Jika mengembalikan satu baris
    //     if (empty($admin_array)) {
    //     // // Tidak ada hasil yang ditemukan
    //     } else {
    //         if ($admin_array['user_status']=='1') {
    //             $this->session->set_userdata('masuk',true);
    //             $this->session->set_userdata('user',$u);
    //             $xcadmin=$cadmin->row_array();
    //             if($xcadmin['user_level']=='1'){
    //                 $this->session->set_userdata('akses','1');
    //                 $idadmin=$xcadmin['user_id'];
    //                 $user_nama=$xcadmin['user_nama'];
    //                 $coid=$xcadmin['user_co_id'];
    //                 $regid=$xcadmin['user_reg_id'];
    //                 $this->session->set_userdata('idadmin',$idadmin);
    //                 $this->session->set_userdata('nama',$user_nama);
    //                 $this->session->set_userdata('coid',$coid);
    //                 $this->session->set_userdata('regid',$regid);
    //             }elseif($xcadmin['user_level']=='2'){
    //                 $this->session->set_userdata('akses','2');
    //                 $idadmin=$xcadmin['user_id'];
    //                 $user_nama=$xcadmin['user_nama'];
    //                 $coid=$xcadmin['user_co_id'];
    //                 $regid=$xcadmin['user_reg_id'];
    //                 $this->session->set_userdata('idadmin',$idadmin);
    //                 $this->session->set_userdata('nama',$user_nama);
    //                 $this->session->set_userdata('coid',$coid);
    //                 $this->session->set_userdata('regid',$regid);
    //             } //Front Office
    //         }else{
    //             echo $this->session->set_flashdata('msg','User anda sudah tidak aktif, silahkan hubungi Administrator');
    //             redirect($url);
    //         }
    //     }
            
    //     if($this->session->userdata('masuk')==true){
    //         redirect('administrator/berhasillogin');
    //     }else{
    //         redirect('administrator/gagallogin');  
    //     }
    
    // }
    //     function berhasillogin(){
    //         redirect('welcome');
    //     }
    //     function gagallogin(){
    //         $url=base_url('administrator');
    //         echo $this->session->set_flashdata('msg','Username Atau Password Salah');
    //         redirect($url);
            
    //     }
    //     function logout(){
    //         $this->session->sess_destroy();
    //         $url=base_url('administrator');
    //         redirect($url);
    //     }

    function cekuser() {
    $username = strip_tags(stripslashes($this->input->post('username', TRUE)));
    $password = strip_tags(stripslashes($this->input->post('password', TRUE)));

    $cadmin = $this->Mlogin->cekadmin($username, $password);

    if (is_array($cadmin)) {
        if ($cadmin['user_status'] == '1') {
            $this->session->set_userdata('masuk', true);
            $this->session->set_userdata('user', $username);
            $this->session->set_userdata('akses', $cadmin['user_level']);
            $this->session->set_userdata('idadmin', $cadmin['user_id']);
            $this->session->set_userdata('nama', $cadmin['user_nama']);
            $this->session->set_userdata('coid', $cadmin['user_co_id']);
            $this->session->set_userdata('regid', $cadmin['user_reg_id']);

            // Front Office
            if ($cadmin['user_level'] == '1' || $cadmin['user_level'] == '2') {
                redirect('administrator/berhasillogin');
            } else {
                $this->session->set_flashdata('msg', 'User anda sudah tidak aktif, silahkan hubungi Administrator');
                redirect('administrator/gagallogin');
            }
        } else {
            $this->session->set_flashdata('msg', 'User anda sudah tidak aktif, silahkan hubungi Administrator');
            redirect('administrator/gagallogin');
        }
    } else {
        $this->session->set_flashdata('msg', $cadmin);
        redirect('administrator/gagallogin');
    }
    }

    function berhasillogin() {
        redirect('welcome');
    }

    function gagallogin() {
        $url = base_url('administrator');
        $this->session->set_flashdata('msg', 'Username Atau Password Salah');
        redirect($url);
    }

    function logout() {
        $this->session->sess_destroy();
        $url = base_url('administrator');
        redirect($url);
    }


}