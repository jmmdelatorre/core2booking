<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PaymentController extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper('tglindo_helper');
		$this->load->model('getkod_model');
		date_default_timezone_set("Asia/Jakarta");
	}
	function getsecurity($value=''){
		$username = $this->session->userdata('username');
		if (empty($username)) {
			redirect('login');
		}
	}
    public function payment() {
     
        $client = new \GuzzleHttp\Client([
            'verify' => false,
        ]);

        $data = [
            'data' => [
                'attributes' => [
                    'cancel_url' => $this->input->post('cancel_url'),
                    'billing' => [
                        'address' => [
                            'line1' => $this->input->post('line1'),
                            'line2' => $this->input->post('line2'),
                            'city' => $this->input->post('city'),
                            'state' => $this->input->post('state'),
                            'postal_code' => $this->input->post('postal_code'),
                            'country' => $this->input->post('country'),
                        ],
                        'name' =>'Alvin ',
                        'email' => 'alvin.icaonapo@gmail.com',
                        'phone' => '09669334421',
                    ],
                    'description' =>'Fare Payment',
                    'line_items' => [[
                        'amount' =>10000,
                        'currency' => 'PHP',
                        'description' => 'Payment',
                        'name' => 'asd',
                        'quantity' =>1,
                    ]],
                    'payment_method_types' => ['gcash','paymaya','qrph','billease','card'],
                    'reference_number' => $this->input->post('reference_number'),
                    'send_email_receipt' => true,
                    'show_description' => true,
                    'show_line_items' => true,
                    'statement_descriptor' => $this->input->post('statement_descriptor'),
                    'success_url' => $this->input->post('success_url'),
                ]
            ]
        ];

        try {
            $response = $client->request('POST', 'https://api.paymongo.com/v1/checkout_sessions', [
                'body' => json_encode($data),
                'headers' => [
                    'Content-Type' => 'application/json',
                    'accept' => 'application/json',
                    'authorization' => 'Basic c2tfdGVzdF9IRlhUOGhkTUxnYXI4RGl4RDN1eENoaDE6',
                ],
            ]);
          echo $response->getBody()->getContents();
              $body = json_decode($response->getBody()->getContents(),true);
          
            
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

     public function paymentlist()
     {
        $client = new \GuzzleHttp\Client([
            'verify' => false,
        ]);

        $response = $client->request('GET', 'https://api.paymongo.com/v1/payments?limit=15', [
            'headers' => [
              'accept' => 'application/json',
              'authorization' => 'Basic c2tfdGVzdF9IRlhUOGhkTUxnYXI4RGl4RDN1eENoaDE6',
            ],
          ]);
          
          echo $response->getBody();
     }

     public function retrieve_payment($id)
     {
        $client = new \GuzzleHttp\Client([
            'verify' => false,
        ]);

     /*    $id = 'pay_1HM7nhY7PCfpbSffzUWaTGhn'; */
        
        $response = $client->request('GET', 'https://api.paymongo.com/v1/payments/'.$id, [
          'headers' => [
            'accept' => 'application/json',
            'authorization' => 'Basic c2tfdGVzdF9IRlhUOGhkTUxnYXI4RGl4RDN1eENoaDE6',
          ],
        ]);
        
        echo $response->getBody();
     }
}


