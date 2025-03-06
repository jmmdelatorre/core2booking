<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	
	function __construct(){
	parent::__construct();
	auth();
		date_default_timezone_set("Asia/Jakarta");
	}
	public function index(){
		$data['title'] = "Home";

		$this->load->view('backend/home', $data);
	}
	function getsecurity($value=''){
		$username = $this->session->userdata('username_admin');
		if (empty($username)) {
			$this->session->sess_destroy();
			redirect('backend/login');
		}
	}
}

