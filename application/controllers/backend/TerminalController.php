<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TerminalController extends CI_Controller {
	function __construct(){
	parent::__construct();
		
		$this->load->model('CodeGeneratorModel');
		auth();
		date_default_timezone_set("Asia/Manila");
		
	}
	function getsecurity($value=''){
		$username = $this->session->userdata('username_admin');
		if (empty($username)) {
			$this->session->sess_destroy();
			redirect('backend/login');
		}
	}
	public function index(){
		$data['title'] = "Destination/Terminal List";
		$data['tujuan'] =$this->db->query("
        SELECT 
        terminal_id,
        terminal_name,
        (select hcity.ctyname  from hcity where hcity.ctycode=tbl_terminal.depart_city) as departure,
        (select hcity.ctyname  from hcity where hcity.ctycode=tbl_terminal.arrival_city) as arrival,
        terminal_status
        FROM 
        tbl_terminal ")->result_array();
		$this->load->view('backend/terminal', $data);
	}


	public function saveterminal(){
		$terminalcode = $this->CodeGeneratorModel->get_terminalcode();
		$data = array(
			'terminal_id' => $terminalcode,
			'terminal_name' => $this->input->post('terminal_name'),
            'depart_city' => $this->input->post('departure'),
            'arrival_city' => $this->input->post('arrival'),
            'terminal_status' => $this->input->post('terminal_status'),
			 );

		$this->db->insert('tbl_terminal', $data);
		$this->session->set_flashdata('message', 'swal("Data Added Successfully");');
		redirect('terminal');
	}
}
