<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ScheduleController extends CI_Controller {
	function __construct(){

	parent::__construct();
		$this->load->helper('tglindo_helper');
		$this->load->model('CodeGeneratorModel');
		$this->getsecurity();
		$this->load->library('form_validation');
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
		$data['title'] = "Schedule Management";
		$data['schedule'] = $this->db->query("
        SELECT 
        schedule_id,
        (select terminal_name from tbl_terminal where tbl_terminal.terminal_id = tbl_schedule.terminal_origin)  as terminal_origin,
        (select terminal_name from tbl_terminal where tbl_terminal.terminal_id = tbl_schedule.terminal_arrival)  as terminal_arrival,
        departure_date,
        departure_time,
        arrival_time,
        price
        FROM 
        tbl_schedule
        ")->result_array();
		$this->load->view('backend/schedule', $data);
	}


	public function view_schedule(){
		$data['title'] = "Add Schedule";
		$data['bus'] = $this->db->query("SELECT * FROM tbl_bus ORDER BY bus_id asc")->result_array();
		$data['terminal'] = $this->db->query("SELECT * FROM tbl_terminal ORDER BY terminal_id asc")->result_array();
		$this->load->view('backend/add_schedule', $data);
	}

	public function saveschedule(){
		
			$terminal_departure = $this->input->post('terminal_departure');
			$terminal = $this->db->query("SELECT * FROM tbl_terminal
               WHERE terminal_id ='".$this->input->post('terminal_origin')."'")->row_array();
			if ($terminal_departure == $terminal['terminal_id']) {
				$this->session->set_flashdata('message', 'swal("Succeed", "Schedule already exists", "error");');
			redirect('schedule/add');
			}else{
			$schedcode = $this->CodeGeneratorModel->get_schedule();
			$data = array(
					'schedule_id' => $schedcode,
					'terminal_origin' => $terminal_departure,
					'terminal_arrival' => $this->input->post('terminal_arrival'),
					'bus_id' => $this->input->post('bus'),
					'departure_date' => $this->input->post('departure_date'),
                    'departure_time' => $this->input->post('departure_time'),
                    'arrival_time' => $this->input->post('arrival_time'),
					'price' => $this->input->post('fare')
					 );
			$this->db->insert('tbl_schedule', $data);
			$this->session->set_flashdata('message', 'swal("Succeed", "New schedule has been added", "success");');
           redirect('schedule/add');
		
			
		}
		
	}
	public function viewjadwal($id=''){
		$data['title'] = "Destination List";
	 	$sqlcek = $this->db->query("SELECT * FROM tbl_jadwal LEFT JOIN tbl_bus on tbl_jadwal.kd_bus = tbl_bus.kd_bus LEFT JOIN tbl_tujuan on tbl_jadwal.kd_tujuan = tbl_tujuan.kd_tujuan WHERE kd_jadwal ='".$id."'")->row_array();
	 	if ($sqlcek) {
	 		$data['asal'] = $this->db->query("SELECT * FROM tbl_tujuan WHERE kd_tujuan = '".$sqlcek['kd_asal']."'")->row_array();
	 		$data['jadwal'] = $sqlcek;
			$data['title'] = "View Schedule";
			// die(print_r($data));
			$this->load->view('backend/view_jadwal',$data);
	 	}else{
	 		$this->session->set_flashdata('message', 'swal("Failed", "Something Went Wrong. Please Try Again", "error");');
			redirect('backend/jadwal');
	 	}
	}	
}

/* End of file Jadwal.php */
/* Log on to codeastro.com for more projects */
/* Location: ./application/controllers/backend/Jadwal.php */