<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ScheduleController extends CI_Controller {
	function __construct(){

	parent::__construct();
		/* auth(); */
		$this->load->library('form_validation');
		date_default_timezone_set("Asia/Manila");
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
			 $terminal_origin = $this->input->post('terminal_origin');
			$terminal = $this->db->query("SELECT * FROM tbl_terminal
               WHERE terminal_id ='".$this->db->escape($terminal_origin)."'")->row();
		
			if ($terminal) {
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
	
}

