<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_orders extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	function __construct(){
		parent::__construct();
		//Load all required classes
		$this->load->model('frontend/organiser_model');
		$this->load->model('frontend/event_model');
		$this->load->library(array('form_validation','session','pagination'));
		$this->load->helper(array('form', 'url', 'file'));
		$passArg = array();

		if(isset($this->session->userdata['logged_in']['login_type'])){
			if($this->session->userdata['logged_in']['login_type'] != 1){
				redirect('frontend/login', 'refresh');
			}
		}
	}

	function view_order($order_id = NULL){
		if($order_id){
			// check if order is valid
			$details = $this->event_model->get_tickets_generated_email($order_id);
			$order_info = $this->event_model->get_order_history_information($order_id);
		// get donation details
		$order_donation_summary = $this->event_model->get_donation_per_order($order_id);

		if(isset($details['0'])){
			$data = array();
			$viewArr['even_sub_events'] = $details['0'];
			// get event details
			$event_details = $this->event_model->get_event_info_email($viewArr['even_sub_events']['event_id']);
			$viewArr['order_info'] = $order_info;
			$order_notify_email = $viewArr['order_info']['email'];
			$viewArr['event_details'] = $event_details;

			// get charity details
			$organizer_data = $this->event_model->get_organiser_details($event_details['organiser_id']);
			$viewArr['organizer_data'] = $organizer_data;
			$viewArr['ticket_data'] = $details;

			// get organizer email information
			$organizer_email = $this->event_model->get_organizer_address($event_details['organiser_id']);

			$viewArr['organizer_email'] = $organizer_email;

			// get total ticket amount for a specific order
			$ticket_price_total = $this->event_model->get_ticket_price_per_order($order_id);
			$viewArr['ticket_total_price'] = $ticket_price_total;

			$viewArr['order_donation_summary'] = $order_donation_summary;
			$viewArr['total_order_donation'] =$this->event_model->get_donation_amount_of_order($order_id);

		}else if(isset($order_donation_summary['0'])){

			$data = array();
			$viewArr['even_sub_events']['order_id'] = $order_id;
			// get event details
			$event_details = $this->event_model->get_event_info_email($order_donation_summary['0']['event_id']);
			$viewArr['order_info'] = $order_info;
			$order_notify_email = $viewArr['order_info']['email'];
			$viewArr['event_details'] = $event_details;

			// get charity details
			$organizer_data = $this->event_model->get_organiser_details($event_details['organiser_id']);
			$viewArr['organizer_data'] = $organizer_data;
			$viewArr['ticket_data'] = $details;

			// get organizer email information
			$organizer_email = $this->event_model->get_organizer_address($event_details['organiser_id']);

			$viewArr['organizer_email'] = $organizer_email;

			// get total ticket amount for a specific order
			$ticket_price_total = $this->event_model->get_ticket_price_per_order($order_id);
			$viewArr['ticket_total_price'] = $ticket_price_total;

			$viewArr['order_donation_summary'] = $order_donation_summary;
			$viewArr['total_order_donation'] =$this->event_model->get_donation_amount_of_order($order_id);
		}else{
			redirect('frontend/tickets/manage_ticket_booking', 'refresh');
		}

			$viewArr['viewPage'] = "view_order_template";
			$this->load->view('frontend/layout', $viewArr);
		}else{
			redirect('frontend/tickets/manage_ticket_booking', 'refresh');
		}
	}


	function resent_order_email(){
		$this->form_validation->set_rules('to_email', 'email', 'trim|required|xss_clean|valid_email');
		$this->form_validation->set_rules('order_id', 'Order Id', 'trim|required|xss_clean');

		$donation_attach_url = "";
		if($this->form_validation->run() == FALSE){
			$this->view_order($this->input->post('order_id'));
		}else{
			$order_id = $this->input->post('order_id');
			$email_address = $this->input->post('to_email');

			$details = $this->event_model->get_tickets_generated_email($order_id);

		$order_info = $this->event_model->get_order_history_information($order_id);

		// get donation details
		$order_donation_summary = $this->event_model->get_donation_per_order($order_id);

		if(isset($details['0'])){
			$data = array();
			$data['even_sub_events'] = $details['0'];
			// get event details
			$event_details = $this->event_model->get_event_info_email($data['even_sub_events']['event_id']);
			$data['order_info'] = $order_info;
			$order_notify_email = $data['order_info']['email'];
			$data['event_details'] = $event_details;

			// get charity details
			$organizer_data = $this->event_model->get_organiser_details($event_details['organiser_id']);
			$data['organizer_data'] = $organizer_data;
			$data['ticket_data'] = $details;

			// get organizer email information
			$organizer_email = $this->event_model->get_organizer_address($event_details['organiser_id']);

			$data['organizer_email'] = $organizer_email;

			// get total ticket amount for a specific order
			$ticket_price_total = $this->event_model->get_ticket_price_per_order($order_id);
			$data['ticket_total_price'] = $ticket_price_total;

			$data['order_donation_summary'] = $order_donation_summary;
			$data['total_order_donation'] =$this->event_model->get_donation_amount_of_order($order_id);

			if($order_donation_summary){
				$receipt_file_name = "Receipts-".$order_id;
				$donation_attach_url = getcwd().'/assets/donation_pdf/'.$receipt_file_name.'.pdf';
			}
		}else if(isset($order_donation_summary['0'])){

			$data = array();
			$data['even_sub_events']['order_id'] = $order_id;
			// get event details
			$event_details = $this->event_model->get_event_info_email($order_donation_summary['0']['event_id']);
			$data['order_info'] = $order_info;
			$order_notify_email = $data['order_info']['email'];
			$data['event_details'] = $event_details;

			// get charity details
			$organizer_data = $this->event_model->get_organiser_details($event_details['organiser_id']);
			$data['organizer_data'] = $organizer_data;
			$data['ticket_data'] = $details;

			// get organizer email information
			$organizer_email = $this->event_model->get_organizer_address($event_details['organiser_id']);

			$data['organizer_email'] = $organizer_email;

			// get total ticket amount for a specific order
			$ticket_price_total = $this->event_model->get_ticket_price_per_order($order_id);
			$data['ticket_total_price'] = $ticket_price_total;

			$data['order_donation_summary'] = $order_donation_summary;
			$data['total_order_donation'] =$this->event_model->get_donation_amount_of_order($order_id);

			$receipt_file_name = "Receipts-".$order_id;
			$donation_attach_url = getcwd().'/assets/donation_pdf/'.$receipt_file_name.'.pdf';
		}

		$attachment_url = getcwd().'/assets/tickets_generated/'.$order_id.'.pdf';
		//storing data in a databse
		$email = "quagnitia.testuser1@gmail.com";
		$name = "darshan";

		//configure email settings
		$config['protocol'] = 'sendmail';
		$config['smtp_host'] = 'ssl://smtp.gmail.com';
		$config['smtp_user'] = 'jeetendra.gawas@quagnitia.com';
		$config['smtp_pass'] = 'babji123';

		$config['mailtype'] = 'html';

		$config['charset'] = 'iso-8859-1';

		$config['wordwrap'] = TRUE;

		$config['newline'] = "\r\n"; //use double quotes

		$this->load->library('email', $config);

		$this->email->initialize($config);

		//send mail

		$this->email->from("admin@ticketing_system.com", "TicketingSystem");

		$this->email->subject('Order Notification for '.$data['event_details']['title']);

		$this->email->to($email_address);

		$body =$this->load->view('templates/email_template',$data,TRUE);

		if(!empty($details)){
			$this->email->attach($attachment_url);
		}

		if(!empty($donation_attach_url)){
			$this->email->attach($donation_attach_url);
		}

		$this->email->message($body);
		$flag = $this->email->send();

			if($flag){
				$this->session->set_flashdata('message',"Order email for #".$order_id." was successfully sent to email address (".$email_address.").");
			//	$this->view_order($order_id);
				redirect('frontend/tickets/manage_ticket_booking', 'refresh');
			}else{
				$this->session->set_flashdata('message',"Error in sending email");
				//$this->view_order($order_id);
				redirect('frontend/manage_orders/view_order/'.$order_id.'#success', 'refresh');
			}
		}
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */