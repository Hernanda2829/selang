<?php
// application/helpers/auth_helper.php

function check_authentication() {
    $CI =& get_instance();

    // Cek apakah pengguna sudah login
    if (!$CI->session->userdata('logged_in')) {
        redirect('auth/login'); // Redirect ke halaman login jika belum login
    }
}
?>