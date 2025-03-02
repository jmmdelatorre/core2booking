<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BusController extends CI_Controller {
	function __construct(){

	parent::__construct();
		$this->load->model('CodeGeneratorModel');
		date_default_timezone_set("Asia/Manila");
	}

	public function index(){
	$data['title'] = "Bus Management";
	$data['bus'] = $this->db->query("SELECT * FROM tbl_bus ORDER BY bus_name asc")->result_array();
	$this->load->view('backend/bus', $data);	
	}

	public function viewbus($id=''){
		$data['title'] = "View Bus";
		$data['bus'] = $this->db->query("SELECT * FROM tbl_bus WHERE bus_id = '".$id."'")->row_array();
		$this->load->view('backend/view_bus', $data);
	}

	public function saveBus(){
        $bus_plate = $this->input->post('bus_plate');
    
        // Check if the bus already exists based on the bus_plate
        $existingBus = $this->db->get_where('tbl_bus', ['bus_plate' => $bus_plate])->row();
    
        $data = array(
            'bus_name' => $this->input->post('bus_name'),
            'bus_plate' => $bus_plate,
            'bus_capacity' => $this->input->post('bus_capacity'),
            'bus_status' => '1'
        );
    
        if ($existingBus) {
            // Update existing bus
            $this->db->where('bus_plate', $bus_plate);
            $this->db->update('tbl_bus', $data);
            $this->session->set_flashdata('message', 'swal("Succeed", "Bus Data Updated", "success");');
        } else {
            // Insert new bus
            $data['bus_id'] = $this->CodeGeneratorModel->get_buscode();
            $this->db->insert('tbl_bus', $data);
            $this->session->set_flashdata('message', 'swal("Succeed", "Bus Data Saved", "success");');
        }
    
        redirect('backend/Buscontroller'); 
	}

}