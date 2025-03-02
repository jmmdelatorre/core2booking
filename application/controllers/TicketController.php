<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TicketController extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('CodeGeneratorModel');
		date_default_timezone_set("Asia/Jakarta");
	}
	function getsecurity($value=''){
		$username = $this->session->userdata('username');
		if (empty($username)) {
			redirect('login');
		}
	}
	public function index(){
		$this->input->post = array(); // Clear all POST data
		unset($_POST['date'], $_POST['departure_date'], $_POST['departure'], $_POST['arrival']);
		$data['title'] = "Check Schedule";
		$data['asal'] = $this->db->query("SELECT * FROM `tbl_tujuan` ORDER BY kota_tujuan ASC ")->result_array();
		$data['tujuan'] = $this->db->query("SELECT * FROM `tbl_tujuan` group by kota_tujuan ORDER BY kota_tujuan ASC ")->result_array();
		$data['list'] = $this->db->query("SELECT * FROM `tbl_tujuan` ORDER BY kota_tujuan ASC ")->result_array();
		$this->load->view('frontend/ticket_create',$data);
	}

	public function ticket_lookup($value=''){
		$this->load->view('frontend/lookup');
	}

	public function check_schedule() {

		$data['title'] = 'Search Schedule';
		$data['date'] = $this->input->post('date');
		$data['origin'] = $this->input->post('departure');
		$data['destination'] = $this->input->post('arrival');
		$data['numpass'] = $this->input->post('nopass');

		 $departure_date =date('Y-m-d',strtotime($this->input->post('depart_date')));
		
		 $depart_city = $this->input->post('departure');
		
		 $arrival_city = $this->input->post('arrival');

		 $nopass = $this->input->post('nopass');
	
		$this->input->post = array();
		unset($_POST['date'], $_POST['depart_date'], $_POST['departure'], $_POST['arrival']);
	
		$depart_city = $this->db->escape($depart_city);
		$departure_date = $this->db->escape($departure_date);

			$query = "
				SELECT 
				* 
				FROM tbl_schedule 
				LEFT JOIN tbl_bus ON tbl_schedule.bus_id = tbl_bus.bus_id 
				LEFT JOIN tbl_terminal ON tbl_schedule.terminal_origin = tbl_terminal.terminal_id 
				WHERE tbl_terminal.depart_city = $depart_city 
				AND tbl_schedule.departure_date = $departure_date";

			$data['schedule'] = $this->db->query($query)->result_array();
		
			if (!empty($data['schedule'])) {
				$this->load->view('frontend/check_schedule', $data);
			} else {
				$this->session->set_flashdata('message', 'swal("Empty", "No Schedule", "error");');
			}
	}

	public function booking($schedule_id ,$pass){
		$sched_id  = $this->db->escape($schedule_id);

		$query  = "
		SELECT 
		tbl_schedule.*,
		tbl_bus.bus_name,
		tbl_bus.bus_capacity,
		(select tbl_terminal.terminal_name from tbl_terminal where tbl_terminal.terminal_id =tbl_schedule.terminal_origin)  as terminal_origin,
		(select tbl_terminal.terminal_name from tbl_terminal where tbl_terminal.terminal_id =tbl_schedule.terminal_arrival)  as terminal_arrival,
		(select hcity.ctyname from hcity left join tbl_terminal on  hcity.ctycode =tbl_terminal.depart_city where tbl_terminal.terminal_id =tbl_schedule.terminal_origin)  as origin,
		(select hcity.ctyname from hcity left join tbl_terminal on hcity.ctycode =tbl_terminal.depart_city where tbl_terminal.terminal_id =tbl_schedule.terminal_arrival)  as destination
		FROM tbl_schedule 
		LEFT JOIN tbl_bus ON tbl_schedule.bus_id = tbl_bus.bus_id 
		WHERE tbl_schedule.schedule_id = $sched_id";
		$schedule=$this->db->query($query)->row();

		$data['schedule']= $schedule;
		$data['no_pass']= $pass;
		
		$this->load->view('frontend/booking',$data);
	}

	public function booking2(){
		   // Collect form data using input arrays
		   $seats = $this->input->post('seats'); // array of seat numbers
		   $names = $this->input->post('name');  // array of passenger names
		   $ages = $this->input->post('age');    // array of ages
		   $genders = $this->input->post('gender'); // array of genders
		   $contacts = $this->input->post('contact'); // array of contact numbers
		   $farePrice = $this->input->post('farePrice'); // array of contact numbers 
		   $scheduleid =$this->input->post('scheduleID'); // array of contact numbers 
		   $totalAmount =$this->input->post('totAmount'); // array of contact numbers 
		   $email =$this->input->post('email'); // array of contact numbers 
		   // Validate data before processing (Optional)
		   if (empty($seats) || count($seats) !== count($names)) {
			   echo json_encode(['status' => 'error', 'message' => 'Invalid form data']);
			   return;
		   }
		   $sched_id  = $this->db->escape($scheduleid);
		   $query  = "
		   SELECT 
		   tbl_schedule.*,
		   tbl_bus.bus_name,
		   tbl_bus.bus_capacity,
		   (select tbl_terminal.terminal_name from tbl_terminal where tbl_terminal.terminal_id =tbl_schedule.terminal_origin)  as terminal_origin,
		   (select tbl_terminal.terminal_name from tbl_terminal where tbl_terminal.terminal_id =tbl_schedule.terminal_arrival)  as terminal_arrival,
		   (select hcity.ctyname from hcity left join tbl_terminal on  hcity.ctycode =tbl_terminal.depart_city where tbl_terminal.terminal_id =tbl_schedule.terminal_origin)  as origin,
		   (select hcity.ctyname from hcity left join tbl_terminal on hcity.ctycode =tbl_terminal.depart_city where tbl_terminal.terminal_id =tbl_schedule.terminal_arrival)  as destination
		   FROM tbl_schedule 
		   LEFT JOIN tbl_bus ON tbl_schedule.bus_id = tbl_bus.bus_id 
		   WHERE tbl_schedule.schedule_id = $sched_id";
		   $schedule=$this->db->query($query)->row();
		   $order_code = $this->CodeGeneratorModel->get_ordercode();
		   // Prepare data for saving (e.g., inserting into the database)
		   $passengerData = [];
		   for ($i = 0; $i < count($seats); $i++) {
			   $passengerData[] = [
				   'email'=>$email,
				   'order_code' =>$order_code,
				   'ticket_no'=>'T'.$order_code.$scheduleid.str_replace('-','', $schedule->bus_id).$seats[$i],
				   'schedule_id'=>$scheduleid,
				   'bus_id'=> $schedule->bus_id,
				   'seat_number' => $seats[$i],
				   'name' => $names[$i],
				   'age' => $ages[$i],
				   'gender' => $genders[$i],
				   'contact' => $contacts[$i],
				   'fare' => $farePrice,
				   'totalamount' => $totalAmount,
			   ];
		   }
		   $payment_api =$this->payment_details($passengerData);  
		 // Clean output buffer and ensure no output is sent before redirect
        ob_clean();
		return $this->output
        ->set_content_type('application/json')
        ->set_status_header(200)
        ->set_output(json_encode(['redirect_url' => $payment_api]));
	}
	
	public function print_ticket()
	{
		 $payment_id = $this->session->userdata('payment_id');
		 $client_key = $this->session->userdata('client_key');
		 $payment = $this->payment_intent($payment_id,$client_key);
	
		  $data = json_decode($payment,true);
		  $sourceType = $data['data']['attributes']['payments'][0]['attributes']['source']['type'];
		  $status = $data['data']['attributes']['payments'][0]['attributes']['status'];

		  $this->db->where('payment_id',$payment_id);
		  $this->db->set('payment_method',$sourceType);
		  $this->db->set('status',$status);
		  $this->db->update('tbl_transaction');
		  $pid = $this->db->escape($payment_id);
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
		  WHERE tbl_transaction.payment_id =$pid";

		  $ticket['tickets']=$this->db->query($query)->result_array();
	 
		  $this->load->view('frontend/ticket',$ticket);
	}

	
	public function lookup()
	{
		
		  $this->load->view('frontend/lookup');
	}

	public function retrieve_ticket()
	{
		 $payment_id = $this->input->post('order_code');
		  $pid = $this->db->escape($payment_id);
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


	
	public function payment_details($data) {
  
        $client = new \GuzzleHttp\Client([
            'verify' => false,
        ]);
		$success_url = 'https://' . $_SERVER['HTTP_HOST'] . '/TicketController/print_ticket';

        $intent = [
            'data' => [
                'attributes' => [
                    'cancel_url' =>"https://www.google.com",
                    'billing' => [
                        'address' => [
                            'line1' =>'N/A',
                            'line2' => 'N/A',
                            'city' => 'N/A',
                            'state' => 'N/A',
                            'postal_code' => 'N/A',
                            'country' =>'PH',
                        ],
                        'name' =>$data[0]['name'],
                        'email' => $data[0]['email'],
                        'phone' => $data[0]['contact'],
                    ],
                    'description' =>'Fare Payment',
                    'line_items' => [[
                        'amount' =>(int)$data[0]['fare'] * 100,
                        'currency' => 'PHP',
                        'description' => 'Payment',
                        'name' => 'Fare ticket',
                         'quantity' =>count($data),
                    ]],
                    'payment_method_types' => ['gcash','paymaya','qrph','billease','card'],
                    'reference_number' => $data[0]['order_code'],
                    'send_email_receipt' => true,
                    'show_description' => true,
                    'show_line_items' => true,
                    'statement_descriptor' => $this->input->post('statement_descriptor'),
                    'success_url' => $success_url
                ]
            ]
        ];

        try {
            $response = $client->request('POST', 'https://api.paymongo.com/v1/checkout_sessions', [
                'body' => json_encode($intent),
                'headers' => [
                    'Content-Type' => 'application/json',
                    'accept' => 'application/json',
                    'authorization' => 'Basic c2tfdGVzdF9IRlhUOGhkTUxnYXI4RGl4RDN1eENoaDE6',
                ],
            ]);
            
            $body = json_decode($response->getBody()->getContents(), true);
	
            $checkoutUrl = $body['data']['attributes']['checkout_url'];

			$paymentID = $body['data']['attributes']['payment_intent']['id'];
			$client_key =  $body['data']['attributes']['client_key'];
			$this->session->set_userdata('payment_id',$paymentID);
			$this->session->set_userdata('client_key',$client_key);
			foreach ($data as &$item) {
				$item['payment_id'] = $paymentID;
				$item['client_key'] = $client_key;
			}
			$this->db->insert_batch('tbl_transaction', $data);
            return $checkoutUrl;
        } catch (Exception $e) {
			return  'Error: ' . $e->getMessage();
			$this->session->set_flashdata('message', 'swal("Error", "'. $e->getMessage().'", "error");');
        }
    }

	public function payment_intent($pid,$key)
	{
		$client = new \GuzzleHttp\Client(['verify' => false]);

		// Define variables for the request
		$paymentIntentId = $pid;
		$clientKey = $key;
		$apiUrl = "https://api.paymongo.com/v1/payment_intents/{$paymentIntentId}?client_key={$clientKey}";

		$headers = [
			'accept' => 'application/json',
			'authorization' => 'Basic c2tfdGVzdF9IRlhUOGhkTUxnYXI4RGl4RDN1eENoaDE6',
		];

		// Make the request
		$response = $client->request('GET', $apiUrl, ['headers' => $headers]);

		// Output the response
		return $response->getBody();
	}


	public function webhook_listener() {
		// Get raw POST data
		$payload = json_decode(file_get_contents('php://input'), true);
		
		// Log raw payload for debugging (optional)
		log_message('debug', 'Webhook Payload: ' . print_r($payload, true));
	
		if (!empty($payload['data']['attributes']['status']) &&
			$payload['data']['attributes']['status'] === 'succeeded') {
			
			$order_code = $payload['data']['attributes']['reference_number'];
	
			$data = [
				'amount' => $payload['data']['attributes']['amount'] / 100,
				'status' => 'paid',
				'payment_id' => $payload['data']['id'],
				'payment_method' => $payload['data']['attributes']['payment_method_type']
			];
	
			// Update the database record
			$this->db->where('order_code', $order_code);
			$update = $this->db->update('tbl_transaction', $data);
	
			if ($update) {
				http_response_code(200); // Acknowledge to PayMongo
				echo json_encode(['status' => 'success']);
			} else {
				http_response_code(500);
				log_message('error', 'Failed to update database.');
				echo json_encode(['status' => 'db_error']);
			}
		} else {
			http_response_code(400);
			log_message('error', 'Invalid webhook payload.');
			echo json_encode(['status' => 'failed']);
		}
	}
	
	public function checkout($value=''){
		$this->getsecurity();
		$data['tiket'] = $value;
		$send['sendmail'] = $this->db->query("SELECT * FROM tbl_order LEFT JOIN tbl_jadwal on tbl_order.kd_jadwal = tbl_jadwal.kd_jadwal LEFT JOIN tbl_tujuan on tbl_jadwal.kd_tujuan = tbl_tujuan.kd_tujuan LEFT JOIN tbl_bank on tbl_order.kd_bank = tbl_bank.kd_bank WHERE kd_order ='$value'")->row_array();
		$send['count'] = count($send['sendmail']);
		//email
		$subject = 'BTBS';
		$message = $this->load->view('frontend/sendmail',$send, TRUE);
		$to 	 = $this->session->userdata('email');
        $config = [
               'mailtype'  => 'html',
               'charset'   => 'utf-8',
               'protocol'  => 'smtp',
               'smtp_host' => 'ssl://smtp.gmail.com',
               'smtp_user' => 'demo@email.com',    // Ganti dengan email gmail kamu
               'smtp_pass' => 'P@$$\/\/0RD',      // Password gmail kamu
               'smtp_port' => 465,
		   ];
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from('BTBS');
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);
        if ($this->email->send()) {
			$this->session->set_flashdata('message', 'swal("Success", "Please proceed towards payment confirmation!", "success");');
            $this->load->view('frontend/checkout', $data);
        } else {
		//    echo 'Error! Send an error email';
		$this->session->set_flashdata('message', 'swal("Success", "Please proceed towards payment confirmation!", "success");');
            $this->load->view('frontend/checkout', $data);
        }
	}
	

}


