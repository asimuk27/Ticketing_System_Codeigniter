<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Donation_reports extends CI_Controller {

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
		$this->load->model('frontend/donation_report_model');
		$this->load->model('frontend/champion_model');
		$this->load->model('frontend/donation_model');
		$this->load->library(array('form_validation','session','pagination'));
		$this->load->helper(array('form', 'url', 'file'));
		$passArg = array();
	}

	function index(){
		$session_data = $this->session->userdata['logged_in'];
		$event_list=$this->champion_model->list_events($session_data['id']);
		if(isset($_POST['per_page']) && ($_POST['per_page'] != "")){
			$config['per_page'] = $_POST['per_page'];
			$page_count = $_POST['per_page'];
		}else{
			$page_count = 20;
			$config['per_page'] = 20;
		}

		if(isset($_POST) && (!empty($_POST))){
			$search_values = $_POST;
		}else{
			$search_values = array();
			$search_values['search_by_order_id'] = "";
			$search_values['search_by_transact_id'] = "";
	   	}
		     $totalRec = $this->donation_report_model->get_my_donation_count($search_values);
				 $config['first_link']  = 'First';
				 $config['div']         = 'postList'; //parent div tag id
				 $config['base_url']    = base_url().'index.php/frontend/donation_reports/index';
				 $config['total_rows']  = $totalRec;
				 $config["uri_segment"] = 4;
	    	 $choice = $config["total_rows"] / $config["per_page"];
	     	$config["num_links"] = 3;

		//config for bootstrap pagination class integration
				 $config['full_tag_open'] = '<ul class="pagination" style="float:left;">';
				 $config['full_tag_close'] = '</ul>';
				 $config['first_link'] = false;
				 $config['last_link'] = false;
				 $config['first_tag_open'] = '<li>';
				 $config['first_tag_close'] = '</li>';
				 $config['prev_link'] = '&laquo';
				 $config['prev_tag_open'] = '<li class="prev">';
				 $config['prev_tag_close'] = '</li>';
				 $config['next_link'] = '&raquo';
				 $config['next_tag_open'] = '<li>';
				 $config['next_tag_close'] = '</li>';
				 $config['last_tag_open'] = '<li>';
				 $config['last_tag_close'] = '</li>';
				 $config['cur_tag_open'] = '<li class="active"><a href="#">';
				 $config['cur_tag_close'] = '</a></li>';
				 $config['num_tag_open'] = '<li>';
				 $config['num_tag_close'] = '</li>';

		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4))? $this->uri->segment(4) : 0;
		$viewArr['page_count'] = $page_count;
		$viewArr['total_records'] = $totalRec;
		$viewArr['data'] = $this->donation_report_model->get_my_donation($config["per_page"], $page,$search_values);
		$viewArr['event_list'] = $event_list;
		$viewArr['viewPage'] = "donation_reports";
		$this->load->view('frontend/layout', $viewArr);
	}


	public function view_organiser_donations($id=null){
		$viewArr['data'] = $this->donation_report_model->get_view_donation($id);
		$viewArr['viewPage'] = "view_organiser_donations";
		$this->load->view('frontend/layout', $viewArr);
	}


	public function load_sub_event_by_event_id_with_subevents(){
		if($_GET){
			if(isset($_GET['sub_event_id'])){
				$sub_event_id = $_GET['sub_event_id'];
			}else{
				$sub_event_id = "";
			}
			// find all event by organization id
			$all_events = $this->donation_report_model->get_all_sub_events($_GET['event_id']);
			$message = "";
			if($all_events){
				//echo "<option value=''>-- Select Sub Events --</option>";
				foreach($all_events as $events){
					if($events['id'] == $sub_event_id){
						$message = "selected";
					}else{
						$message = "";
					}
					echo "<option value='".$events['id']."'".$message.">".$events['schedule_title']."</option>";
				}
				exit;
			}else{
				echo "<option value=''>No events available<option>";
				exit;
			}
		}else{
			echo "<option value=''>No events available<option>";
			exit;
		}
	}

	/* function export_csv(){
		if(isset($_POST) && (!empty($_POST))){
			$search_values = $_POST;
		}else{
			$search_values = array();
			$search_values['search_by_order_id'] = "";
			$search_values['search_by_transact_id'] = "";
	   	}

		$result = $this->donation_report_model->csv_download($search_values);;
	} */

	function export_csv(){

		if(isset($_POST) && (!empty($_POST))){
			$search_values = $_POST;
	  	}else{
			$search_values = array();
			$search_values['eid'] = "";
			$search_values['sub_eid'] = "";
			$search_values['donation_from'] = "";
			$search_values['pay_status'] = "";
	   	}

	  	$result = $this->donation_report_model->csv_download($search_values);

		if($result){

		}else{
			$this->session->set_flashdata('message', 'No records were found to export');
			redirect('frontend/donation_reports/donation_reports', 'refresh');
		}
	}

	function resent_donation_receipt(){
		if($_POST){
			if($_POST['order_no']){

			// get txn_id based on order information
			$order_id = $_POST['order_no'];

			// function to get email and txn_id
			$data_r = $this->donation_report_model->get_purchaser_details($order_id);


			// build a data array
			$order_array['order_id'] = $order_id;
			$order_array['email_address'] = $_POST['email'];
			$order_array['donar_first_name'] = $data_r[0]['first_name'];
			$order_array['address1'] = $data_r[0]['address1'];
			$order_array['address2'] = $data_r[0]['address2'];
			$order_array['city'] = $data_r[0]['city'];
			$order_array['postal_code'] = $data_r[0]['postal_code'];
			$order_array['created_date'] = $data_r[0]['created_date'];


			$status = $this->send_a_donation_email($order_array);

			 if($status){
				 $this->session->set_flashdata('message',"Donation receipt was successfully sent to email address (".$_POST['email'].").");
				 redirect('frontend/donation_reports/index', 'refresh');
			 }else{
				 $this->session->set_flashdata('message', 'Error in sending email');
				  redirect('frontend/donation_reports/index', 'refresh');
			 }

			}
		}else{
			redirect('frontend/donation_reports/index', 'refresh');
		}
	}


	function send_a_donation_email($order_array){

		$result = $this->donation_model->get_charity_information_by_order_id($order_array['order_id']);

		if(empty($result)){
			return true;
		}

		$receipt_msg = $result['donation_receipt_text'];
		$email_signature = $this->config->item('organisation_signature').$result['signature'];
		$logo = $this->config->item('organisation_logo').$result['logo'];
		$cutter_image = $this->config->item('default_image_url').'kator.jpg';
		$thank_you = $this->config->item('default_image_url').'d.jpg';

		$this->load->library('email');
		$this->email->from('admin@ticketing_system.com', 'TicketingSystem');
		$this->email->to($order_array['email_address']);
		$this->email->set_mailtype("html");

		$this->email->subject('Donation - Notification Email');

		$message = $result['donar_first_name'];
		$message .= "<br>";
		$message .= $order_array['address1'];
		$message .= "<br>";
		$message .= $order_array['address2'];
		$message .= "<br>";
		$message .= $order_array['city'];
		$message .= "<br>";
		$message .= $order_array['postal_code'];
		$message .= "<br>";
		$message .= "<br>";
		//$message .= date("j F, Y");

		$message .= date("j F, Y", strtotime($order_array['created_date']));
		$message .= "<br>";$message .= "<br>";
		$message .= "<div style='text-align: center;font-weight:bold;'>Thank you for your donation</div>";
		$message .= "<br>";
		$message .= "<br>";
		$message .= "Dear ".$result['donar_first_name'];
		$message .= "<br><br>";
		$message .= "Thank you so much for your support to ".$result['charity_name'];
		$message .= "<br><br>";
		$message .= "Attached is a receipt for your donation";
		$message .= "<br><br>";
		/*	$message .= $receipt_msg;
		$message .= "<br><br>";*/
		$message .= "Once again thank you for your support.";
		$message .= "<br><br>";
		$message .= "Yours sincerely,";
		$message .= "<br><br>";
		$message .= "<img src=".$email_signature." alt='logo' width='100px;'>";
		$message .= "<br>";
		$message .= "<br>";
		$message .= $result['signature_text'];
		$message .= "<br>";

		$this->email->message($message);

		$receipt_file_name = "Receipts-".$order_array['order_id'];
		$attachment_url = getcwd().'/assets/donation_pdf/'.$receipt_file_name.'.pdf';
		$this->email->attach($attachment_url);

		$resp = $this->email->send();
		return $resp;
	}
}


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
