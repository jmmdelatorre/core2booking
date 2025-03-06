<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	function __construct(){
		parent::__construct();
       
		date_default_timezone_set("Asia/Manila");
	}
	
    /* Log on to codeastro.com for more projects */
	function getUserIP()
    {
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];

        if(filter_var($client, FILTER_VALIDATE_IP))
        {
            $ip = $client;
        }
        elseif(filter_var($forward, FILTER_VALIDATE_IP))
        {
            $ip = $forward;
        }
        else
        {
            $ip = $remote;
        }

        return $ip;
        
    }
	public function index(){
		$data['ipaddres'] = $this->getUserIP();
		$this->load->view('backend/login',$data);
	}
    
	public function logout(){
		$this->session->sess_destroy();
		redirect(base_url('backend/login'));
	}

	public function user_login(){
    $username = strtolower($this->input->post('username'));
    $getUser = $this->db->query('select * from tbl_admin where username_admin = "'.$username.'"')->row();
    $password = $this->input->post('password');

    if (password_verify($password,$getUser->password_admin)) {
        $sess = array(
            'id_admin' => $getUser->id_admin,
            'username_admin' => $getUser->username_admin,
            'password_admin' => $getUser->password_admin,
            'name_admin'     => $getUser->nama_admin,
            'img_admin'	=> $getUser->img_admin,
            'level'	=> $getUser->level_admin
        );
        
        $this->session->set_userdata($sess);
        redirect('backend/home');
    }else{
    	$this->session->set_flashdata('message', 'swal("Failed", "Incorrect Login Details!", "error");');
    	redirect('backend/login');
    	}
	}

}

