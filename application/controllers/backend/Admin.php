<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
	function __construct(){
	parent::__construct();

		$this->load->library('form_validation');
		/* auth(); */
	}

	public function index(){
		$data['title'] = "Admin Section";
		$data['admin'] = $this->db->query("SELECT * FROM tbl_admin")->result_array();
		$this->load->view('backend/admin', $data);
	}

	
	public function view($id) {
		$data['title'] = "Edit Admin";
		$row = $this->db->get_where('tbl_admin', array('id_admin' => $id))->row();
		$data['id_admin']  = $row->id_admin;
		$data['name']  = $row->name_admin;
		$data['email']  = $row->email_admin;
		$data['username']  = $row->username_admin;
		$data['password']  = $row->password_admin;
		$this->load->view('backend/admin_form', $data);
	}

	public function save() {
		
	
	 $id =$this->input->post('id_admin');
		
		// Set validation rules
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		if (!$id)
		{
// Unique validation for username only on add, not on update
$unique_username = $id ? '' : '|is_unique[tbl_admin.username_admin]';
$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]' . $unique_username, array(
	'required' => 'Username Required.',
	'is_unique' => 'Username Already In Use'
));
		}
		
		
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email', array(
			'required' => 'Email Required.'
		));
		
		// Password rules only for add or if a password is provided during update
		if (!$id || $this->input->post('password')) {
			$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|matches[password2]', array(
				'matches' => 'Password Not Same.',
				'min_length' => 'Password Minimal 4 Characters.'
			));
			$this->form_validation->set_rules('password2', 'Password Confirmation', 'trim|required|matches[password]');
		}
	
		if ($this->form_validation->run() == false) {
			$data['title'] = $id ? "Edit Admin" : "Add Admin";
			
			if ($id) {
				// Fetch existing admin data for the update form
				$data['admin'] = $this->db->get_where('tbl_admin', ['id_admin' => $id])->row_array();
			}
	
			$this->load->view('backend/admin_form', $data);
		} else {
			$data = array(
				'name_admin' => $this->input->post('name'),
				'email_admin' => $this->input->post('email'),
				'username_admin' => strtolower($this->input->post('username')),
				'level_admin' => $this->input->post('level') ?? 2,
				'status_admin' => 1
			);
	
			if ($this->input->post('password')) {
				$data['password_admin'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
			}
	
			if ($id) {
				// Update logic
				$this->db->where('id_admin', $id);
				$this->db->update('tbl_admin', $data);
				$this->session->set_flashdata('message', 'swal("Succeed", "Successfully Updated Account", "success");');
			} else {
				// Add logic
				$data['id_admin'] = $this->CodeGeneratorModel->get_admcode();
				$data['img_admin'] = 'assets/backend/img/default.png';
				$data['date_create_admin'] = time();
				$this->db->insert('tbl_admin', $data);
				$this->session->set_flashdata('message', 'swal("Succeed", "Successfully Added Account", "success");');
			}
			
			redirect('backend/admin');
		}
	}

	public function delete($id)
	{
		$this->db->where('id_admin', $id);
		if($this->db->delete('tbl_admin')) {
			echo json_encode(['success' => true]);
		} else {
			echo json_encode(['success' => false]);
		}
	}
	
}

