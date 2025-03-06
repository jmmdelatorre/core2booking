
<?php defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('auth')) {
    function auth() {
        $CI = &get_instance(); // Get CodeIgniter instance
        $username = $CI->session->userdata('username_admin');
        if (empty($username)) {
            $CI->session->sess_destroy();
            redirect('backend/login');
            exit; // Ensure no further processing
        }
    }
}