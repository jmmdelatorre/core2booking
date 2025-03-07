<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends CI_Controller {
	function __construct(){
	parent::__construct();
	/* auth(); */
	date_default_timezone_set("Asia/Manila");
	}

	public function index(){
		$data['title'] = "Booking List";
 		$data['order'] = $this->db->query("
		SELECT 
		tbl_transaction.*,
		tbl_bus.*,
		tbl_schedule.*,
		tbl_terminal.*,
		tbl_transaction.status as payment_status
		FROM 
		tbl_transaction
			LEFT JOIN tbl_bus ON tbl_transaction.bus_id = tbl_bus.bus_id 
			LEFT JOIN tbl_schedule ON tbl_schedule.schedule_id = tbl_schedule.schedule_id 
			LEFT JOIN tbl_terminal ON tbl_terminal.terminal_id = tbl_schedule.terminal_origin 
		group by tbl_transaction.order_code
		order by  order_code desc
		")->result_array();
		$this->load->view('backend/order', $data);
	}

	public function vieworder($id=''){
		$id = $this->input->get('order').$id;
	 	$passenger = $this->db->query("SELECT * FROM tbl_transaction LEFT JOIN tbl_schedule on tbl_transaction.schedule_id = tbl_schedule.schedule_id WHERE order_code ='".$id."' ")->result_array();
	 	if ($passenger) {
	 		$data['passenger'] = $passenger;
			$data['title'] = "View Bookings";
			
			$this->load->view('backend/view_order',$data);
	 	}else{
	 		$this->session->set_flashdata('message', 'swal("Empty", "No Order", "error");');
    		redirect('backend/tiket');
	 	}
	}

	public function check_ticket($id)
	{
		  $pid = $this->db->escape($id);
		  $query  = "
		  SELECT 
		  tbl_schedule.*,
		  tbl_transaction.*,
		   tbl_bus.*,
		  (select tbl_terminal.terminal_name from tbl_terminal where tbl_terminal.terminal_id =tbl_schedule.terminal_origin)  as terminal_origin,
		  (select tbl_terminal.terminal_name from tbl_terminal where tbl_terminal.terminal_id =tbl_schedule.terminal_arrival)  as terminal_arrival,
		  (select hcity.ctyname from hcity left join tbl_terminal on  hcity.ctycode =tbl_terminal.depart_city where tbl_terminal.terminal_id =tbl_schedule.terminal_origin)  as origin,
		  (select hcity.ctyname from hcity left join tbl_terminal on hcity.ctycode =tbl_terminal.depart_city where tbl_terminal.terminal_id =tbl_schedule.terminal_arrival)  as destination
		  FROM tbl_transaction 
		  LEFT JOIN tbl_schedule on tbl_schedule.schedule_id = tbl_transaction.schedule_id
		  LEFT JOIN tbl_bus ON tbl_schedule.bus_id = tbl_bus.bus_id 
		  WHERE tbl_transaction.order_code =$pid";
		  $ticket['tickets']=$this->db->query($query)->result_array();
		  $this->load->view('frontend/ticket',$ticket);
	}

	public function inserttiket($value=''){
		$id = $this->input->post('kd_order');
		$asal = $this->input->post('asal_beli');
		$tiket = $this->input->post('kd_tiket');
		$nama = $this->input->post('nama');
		$kursi = $this->input->post('no_kursi');
		$umur = $this->input->post('umur_kursi');
		$harga = $this->input->post('harga');
		$tgl = $this->input->post('tgl_beli');
		$status = $this->input->post('status');
		$where = array('kd_order' => $id );
		$update = array('status_order' => $status );
		$this->db->update('tbl_order', $update,$where);
		$data['asal'] = $this->db->query("SELECT * FROM tbl_tujuan WHERE kd_tujuan ='".$asal."'")->row_array();
		$data['cetak'] = $this->db->query("SELECT * FROM tbl_order LEFT JOIN tbl_jadwal on tbl_order.kd_jadwal = tbl_jadwal.kd_jadwal LEFT JOIN tbl_tujuan on tbl_jadwal.kd_tujuan = tbl_tujuan.kd_tujuan WHERE kd_order ='".$id."'")->result_array();
		$pelanggan = $this->db->query("SELECT email_pelanggan FROM tbl_pelanggan WHERE kd_pelanggan ='".$data['cetak'][0]['kd_pelanggan']."'")->row_array();
		$pdfFilePath = "assets/backend/upload/etiket/".$id.".pdf";
		$html = $this->load->view('frontend/cetaktiket', $data, TRUE);
		$this->load->library('m_pdf');
		$this->m_pdf->pdf->WriteHTML($html);
		$this->m_pdf->pdf->Output($pdfFilePath);
		for ($i=0; $i < count($nama) ; $i++) { 
			$simpan = array(
				'kd_tiket' => $tiket[$i],
				'kd_order' => $id,
				'nama_tiket' => $nama[$i],
				'kursi_tiket' => $kursi[$i],
				'umur_tiket' => $umur[$i],
				'asal_beli_tiket' => $asal,
				'harga_tiket' => $harga,
				'status_tiket' => $status,
				'etiket_tiket' => $pdfFilePath,
				'create_tgl_tiket' => date('Y-m-d'),
				'create_admin_tiket' => $this->session->userdata('username_admin')
			);
		$this->db->insert('tbl_tiket', $simpan);
		}
		$this->session->set_flashdata('message', 'swal("Succeed", "Ticket Order Processed Successfully", "success");');
		redirect('backend/order');

		
	}

	public function kirimemail($id=''){
		$data['cetak'] = $this->db->query("SELECT * FROM tbl_order LEFT JOIN tbl_jadwal on tbl_order.kd_jadwal = tbl_jadwal.kd_jadwal LEFT JOIN tbl_tujuan on tbl_jadwal.kd_tujuan = tbl_tujuan.kd_tujuan WHERE kd_order ='".$id."'")->result_array();
		$asal = $data['cetak'][0]['asal_order'];
		$kodeplg = $data['cetak'][0]['kd_pelanggan'];
		$data['asal'] = $this->db->query("SELECT * FROM tbl_tujuan WHERE kd_tujuan ='$asal'")->row_array();
		$pelanggan = $this->db->query("SELECT email_pelanggan FROM tbl_pelanggan WHERE kd_pelanggan ='$kodeplg'")->row_array();
		//email
		$subject = 'E-ticket - Order ID '.$id.' - '.date('dmY');
		$message = $this->load->view('frontend/cetaktiket', $data ,TRUE);
		$attach  = base_url("assets/backend/upload/etiket/".$id.".pdf");
		$to 	= $pelanggan['email_pelanggan'];
		$config = array(
			   'mailtype'  => 'html',
               'charset'   => 'utf-8',
               'protocol'  => 'smtp',
               'smtp_host' => 'ssl://smtp.gmail.com',
               'smtp_user' => 'demo@email.com',    // Ganti dengan email gmail kamu
               'smtp_pass' => 'P@$$\/\/0RD',      // Password gmail kamu
               'smtp_port' => 465,
               'crlf'      => "rn",
               'newline'   => "rn"
		);
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from('BTBS');
        $this->email->to($to);
        $this->email->attach($attach);
        $this->email->subject($subject);
        $this->email->message($message);
        if ($this->email->send()) {
        	$this->session->set_flashdata('message', 'swal("Succeed", "E-Ticket sent!", "success");');
			redirect('backend/order/vieworder/'.$id);
        } else {
            $this->session->set_flashdata('message', 'swal("Failed", "E-Tickets Failed to Send Contact the IT Team", "error");');
			redirect('backend/order/vieworder/'.$id);
        }

	}

}

/* End of file Order.php */
/* Log on to codeastro.com for more projects */
/* Location: ./application/controllers/backend/Order.php */