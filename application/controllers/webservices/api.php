<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
//require APPPATH . 'libraries/REST_Controller.php';

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */

class Api extends CI_Controller
{
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
		$this->load->library(array('session','pagination','email','encrypt','form_validation'));
		$this->load->helper(array('url','form','security'));

		$this->load->model('webservices/api_model');
    }


	public function login(){
		$message = "";
		$logged_in_status = false;
		$flag = false;
		$validation = true;
		$loginValiRes = array();

		$emailRegex = "/^[a-z0-9_\+-]+(\.[a-z0-9_\+-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*\.([a-z]{2,4})$/";
		$email="";

		if(!isset($_POST['email']) || (isset($_POST['email'] ) && $_POST['email'] == "")){
			echo json_encode(array('status' => 'false', 'errorMsg' => 'please enter a valid email id'));
			exit;
		}else{
			if(!preg_match($emailRegex ,($_POST['email']))){
				echo json_encode(array('status' => 'false', 'errorMsg' => 'please enter a valid email id'));
				exit;
			}else{
				$email = $_POST['email'];
			}
		}

		if(!isset($_POST['password']) || (isset($_POST['password']) && $_POST['password'] == '')) {
			echo json_encode(array("response" => array("errorCode"=>"1","errorMsg" => 'Please enter password')));
			exit;
		} else {
			$password = trim($_POST['password']);
		}

		// check if user is valid
		$data_result = $this->api_model->check_login($email,$password);


		if($data_result){
			// check if user is already logged in
			$log_status = $this->api_model->check_login_status($email);

			if($log_status){
				// update login status and update user
			//	$update_status = $this->api_model->update_login_status($email);

				echo json_encode(array('status' => 'true', 'respMsg' => 'User logged in successfully','user_id' => $log_status[0]->user_id));
				exit;
			}else{
				echo json_encode(array('status' => 'false', 'errorMsg' => 'User is already logged in through other device'));
				exit;
			}
		}else{
			echo json_encode(array('status' => 'false', 'errorMsg' => 'Please enter valid credentials'));
			exit;
		}

	}

	public function forgot_password(){
        $message = array();
	    $validation = true;
	    $flag = false;

		$emailRegex = "/^[a-z0-9_\+-]+(\.[a-z0-9_\+-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*\.([a-z]{2,4})$/";
		$email="";

		if(!isset( $_POST['email']) || (isset( $_POST['email'] ) && $_POST['email'] == "")){
			echo json_encode(array('status' => 'false', 'errorMsg' => 'please enter a valid email id'));
			exit;
		}else{
			if(!preg_match($emailRegex ,($_POST['email']))){
				echo json_encode(array('status' => 'false', 'errorMsg' => 'please enter a valid email id'));
				exit;
			}else{
				$email = $_POST['email'];
			}
		}

		// check if email is related to facebook_sign_up
		$email_check = $this->api_model->email_link_to_facebook($email);

		if($email_check){
			echo json_encode(array('status' => 'false', 'errorMsg' => 'Email address is registered with facebook'));
			exit;
		}

		//check if email address exist
		$email_check = $this->api_model->validate_email($email);

		if($email_check){

			$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
			$new_password = substr(str_shuffle($chars),0,8);
			// update password and send over email
			$update_password_status = $this->api_model->update_password($email,$new_password);

			if($update_password_status){
				$this->load->library('email');
				$this->email->from('admin@ticketing_system.com', 'TicketingSystem');
				$this->email->to($email);
				$this->email->bcc('test@test.com');
				$this->email->set_mailtype("html");
				$this->email->subject('Ticket Checker | Forgot Password | Request');

				$message = "Hello ".$email;
				$message .= "<br>";$message .= "<br>";
				$message .= "You have requested forgot password";
				$message .= "<br>";
				$message .= "<br>";
				$message .= "We have generated temporary password for you. Please check below";
				$message .= "<br>";
				$message .= "<br>";
				$message .= "Email: ".$email;
				$message .= "<br>";
				$message .= "Password: ".$new_password;
				$message .= "<br>";
				$message .= "<br>";
				$message .= "Thanks,";
				$message .= "<br>";
				$message .= "<br>";
				$message .= "TicketingSystem Team";
				$message .= "<br>";
				$message .= "<br>";
				$message .= "<img src=".$this->config->item('fe_logo_image_url')." alt='logo' width='100px;'>";
				$message .= "<br>";
				$message .= "<br>";

				$this->email->message($message);
				$resp = $this->email->send();

				if($resp){
					echo json_encode(array('status' => 'true', 'respMsg' => 'Password sent successfully'));
					exit;
				}else{
					echo json_encode(array('status' => 'false', 'errorMsg' => 'error in updating password'));
					exit;
				}
			}
		}else{
			echo json_encode(array('status' => 'false', 'errorMsg' => 'Email is not found'));
			exit;
		}
	}

	function event_details(){
		if(!isset($_POST['event_id']) || (isset($_POST['event_id']) && $_POST['event_id'] == '')) {
			echo json_encode(array('status' => 'false', 'errorMsg' => 'Please enter event id'));
			exit;
		} else {
			$event_id = trim($_POST['event_id']);
		}

		// check if sub event id exist
		 if(!isset($_POST['user_id']) || (isset($_POST['user_id']) && $_POST['user_id'] == '')) {
			echo json_encode(array('status' => 'false', 'errorMsg' => 'Please enter user id'));
			exit;
		} else {
			$user_id = trim($_POST['user_id']);
		}

		// check if valid user id
		$check_user = $this->api_model->check_if_user_id_valid($user_id);

		$check_user = "2";

		if($check_user){
			// check for sub event
			$sub_event_details = $this->api_model->get_sub_event_details($event_id);

			if(isset($sub_event_details['0'])){
				//get main event image
				$event_image = $this->api_model->get_event_image($sub_event_details['0']['event_id']);

				if($event_image){
					$actual_url = $this->config->item('event_image').$event_image['original_event_image'];
				}else{
					$actual_url = "";
				}

				//build event output array
				$sub_event_data = array();
				$sub_event_data['event_image'] = $actual_url;
				$sub_event_data['event_title'] = $sub_event_details['0']['schedule_title'];
				$sub_event_data['event_description'] = $sub_event_details['0']['schedule_event_description'];

				$sub_event_data['event_start_date'] = date("d-m-Y", strtotime(str_replace("/", "-",$sub_event_details['0']['schedule_start_date'])));
				$sub_event_data['event_end_date'] = date("d-m-Y", strtotime(str_replace("/", "-",$sub_event_details['0']['schedule_end_date'])));

				$sub_event_data['event_start_time'] = $sub_event_details['0']['schedule_start_time'];
				$sub_event_data['event_end_time'] = $sub_event_details['0']['schedule_end_time'];


				echo json_encode(array('status' => 'true', 'respMsg' => 'Event details', 'respData' => $sub_event_data));
				exit;
			}else{
				echo json_encode(array('status' => 'false', 'errorMsg' => 'Invalid event id'));
				exit;
			}

		}else{
			echo json_encode(array('status' => 'false', 'errorMsg' => 'Invalid user id'));
			exit;
		}
	}


	function event_listing(){
		// check if sub event id exist
		if(!isset($_POST['user_id']) || (isset($_POST['user_id']) && $_POST['user_id'] == '')) {
			echo json_encode(array('status' => 'false', 'errorMsg' => 'Please enter user id'));
			exit;
		} else {
			$user_id = trim($_POST['user_id']);
		}

		// check if user id is valid
		$check_user = $this->api_model->check_if_user_id_valid($user_id);

		if($check_user){
			// get all events related to user
			$data = $this->api_model->get_sub_event_by_user_id($user_id);


			$final_data_array = array();
			if($data){
				foreach($data as $sub_events){
					$sub_event_details = $this->api_model->get_sub_event_details($sub_events->sub_event_id);
					//get main event image
					$event_image = $this->api_model->get_event_image($sub_events->event_id);

					if($event_image){
						$actual_url = $this->config->item('event_image').$event_image['original_event_image'];
					}else{
						$actual_url = "";
					}
					//build event output array
					$sub_event_data = array();
					$sub_event_data['event_image'] = $actual_url;
					$sub_event_data['event_status'] = 1;
					$sub_event_data['event_id'] = $sub_events->sub_event_id;
					$sub_event_data['event_title'] = $sub_event_details['0']['schedule_title'];
					$sub_event_data['event_description'] = $sub_event_details['0']['schedule_event_description'];
					$sub_event_data['event_start_date'] = date("d-m-Y", strtotime(str_replace("/", "-",$sub_event_details['0']['schedule_start_date'])));
					$sub_event_data['event_end_date'] = date("d-m-Y", strtotime(str_replace("/", "-",$sub_event_details['0']['schedule_end_date'])));
					$sub_event_data['event_start_time'] = $sub_event_details['0']['schedule_start_time'];
					$sub_event_data['event_end_time'] = $sub_event_details['0']['schedule_end_time'];

					// get online offline status
					$on_off_status = $this->api_model->get_onlie_offline_status_by_sub_event_id($sub_events->sub_event_id);

					if($on_off_status){
						if($on_off_status == 1){
							$sub_event_data['availability'] = "Online Only";
						}else if($on_off_status == 2){
							$sub_event_data['availability'] = "Online Or Offline";
						}
					}else{
						$sub_event_data['availability'] = "Online Only";
					}

					$final_data_array[] = $sub_event_data;
				}
				echo json_encode(array('status' => 'true', 'respMsg' => 'Event details', 'respData' => $final_data_array));
				exit;
			}else{
				echo json_encode(array('status' => 'false', 'errorMsg' => 'no event data available'));
				exit;
			}
		}else{
			echo json_encode(array('status' => 'false', 'errorMsg' => 'Invalid user id'));
			exit;
		}
	}

	function logout(){
		// check if sub event id exist
		if(!isset($_POST['user_id']) || (isset($_POST['user_id']) && $_POST['user_id'] == '')) {
			echo json_encode(array('status' => 'false', 'errorMsg' => 'Please enter user id'));
			exit;
		} else {
			$user_id = trim($_POST['user_id']);
		}

		// check if user id is valid
		$check_user = $this->api_model->check_if_user_id_valid($user_id);

		if($check_user){
			$status = $this->api_model->update_logout_status($user_id);

			echo json_encode(array('status' => 'true', 'respMsg' => 'User logout successfully'));
			exit;
		}else{
			echo json_encode(array('status' => 'false', 'errorMsg' => 'Invalid user id'));
			exit;
		}
	}

	function scan_ticket(){
		if(!isset($_POST['qr_code']) || (isset($_POST['qr_code']) && $_POST['qr_code'] == '')) {
		   echo json_encode(array('status' => 'false', 'errorMsg' => 'Please enter valid qr data'));
		   exit;
		} else {
		   $qr_code = trim($_POST['qr_code']);
        }

		if(!isset($_POST['app_user_id']) || (isset($_POST['app_user_id']) && $_POST['app_user_id'] == '')) {
		   echo json_encode(array('status' => 'false', 'errorMsg' => 'Please enter valid app user id'));
		   exit;
		} else {
		   $app_user_id = trim($_POST['app_user_id']);
        }

		// check if sub event id exist
		 if(!isset($_POST['event_id']) || (isset($_POST['event_id']) && $_POST['event_id'] == '')) {
			echo json_encode(array('status' => 'false', 'errorMsg' => 'Please enter event id'));
			exit;
		} else {
			$event_id = trim($_POST['event_id']);
		}

		/* // check if ticket is deleted
		$check_delete_status = $this->api_model->check_ticket_delete_status($qr_code,$event_id);

		if($check_delete_status){
			echo json_encode(array('status' => 'true', 'respMsg' => 'Deleted Ticket'));
			exit;
		} */

		// check if qa data is valid
		$check_qr = $this->api_model->get_qr_data_details($qr_code,$event_id);

		if(isset($check_qr[0]->ticket_scan_status)){
			if($check_qr[0]->ticket_scan_status == 0){
				// update ticket scan status
				$check_status = $this->api_model->update_ticket_status($qr_code);

				$check_status = 1;
				if($check_status){
					// get user first name and last name by order id
					$user_data = $this->api_model->get_ticket_user_details($check_qr[0]->order_id);

					// build user data array
					$user_record_data = array();

					if(isset($user_data['0'])){
						$user_record_data['first_name'] = $user_data['0']->first_name;
						$user_record_data['last_name'] = $user_data['0']->last_name;
					}else{
						$user_record_data['first_name'] = "";
						$user_record_data['last_name'] = "";
					}

					// get ticket type and ticket id
					$ticket_id = $this->api_model->get_ticket_type_details($check_qr[0]->ticket_id);
					$ticket_format_type = "";
					if($ticket_id['0']->ticket_type_id == '1'){
						$ticket_format_type = "Paid";
					}else if($ticket_id['0']->ticket_type_id == '2'){
						$ticket_format_type = "Free";
					}else if($ticket_id['0']->ticket_type_id == '3'){
						$ticket_format_type = "Donation";
					}

					$user_record_data['ticket_id'] = $check_qr[0]->id;
					$user_record_data['ticket_type'] = $ticket_format_type;
					$user_record_data['ticket_type_id'] = $ticket_id['0']->ticket_type_id;

					// update ticket scan history
					$ticket_scanned_data = array();
					$ticket_scanned_data['usher_id'] = $app_user_id;
					$ticket_scanned_data['ticket_generated_id'] = $check_qr[0]->id;
					$ticket_scanned_data['sub_event_id'] = $event_id;
					$ticket_scanned_data['ticket_type_id'] = $ticket_id['0']->ticket_type_id;
					$ticket_scanned_data['scanned_date'] = date('Y-m-d H:i:s');
					$ticket_scanned_data['upload_date'] = date('Y-m-d H:i:s');

					$check_status = $this->api_model->insert_ticket_history($ticket_scanned_data);


					// get issued ticket count for sub event
					$issued_count = $this->api_model->get_ticket_issued_by_sub_event($event_id);

					//get scanned ticket for sub event
					$scanned_count = $this->api_model->get_ticket_scanned_by_sub_event($event_id);

					// get ticket scanned by me for sub event
					$my_scanned_count = $this->api_model->get_ticket_scanned_by_me_sub_event($event_id,$app_user_id);

					// set response array
					$response_array = array();
					$response_array['issued'] = $issued_count;
					$response_array['scanned'] = $scanned_count;
					$response_array['scanned_by_me'] = $my_scanned_count;


					echo json_encode(array('status' => 'true', 'respMsg' => 'Valid Ticket','respData' => $user_record_data,'ticketData' => $response_array));
					exit;
				}else{
					echo json_encode(array('status' => 'false', 'errorMsg' => 'error in scanning'));
					exit;
				}
			}else{
				// get user first name and last name by order id
					$user_data = $this->api_model->get_ticket_user_details($check_qr[0]->order_id);

					// build user data array
					$user_record_data = array();

					if(isset($user_data['0'])){
						$user_record_data['first_name'] = $user_data['0']->first_name;
						$user_record_data['last_name'] = $user_data['0']->last_name;
					}else{
						$user_record_data['first_name'] = "";
						$user_record_data['last_name'] = "";
					}

					// get ticket type and ticket id
					$ticket_id = $this->api_model->get_ticket_type_details($check_qr[0]->ticket_id);
					$ticket_format_type = "";
					if($ticket_id['0']->ticket_type_id == '1'){
						$ticket_format_type = "Paid";
					}else if($ticket_id['0']->ticket_type_id == '2'){
						$ticket_format_type = "Free";
					}else if($ticket_id['0']->ticket_type_id == '3'){
						$ticket_format_type = "Donation";
					}

					$user_record_data['ticket_id'] = $check_qr[0]->ticket_id;
					$user_record_data['ticket_type'] = $ticket_format_type;
					$user_record_data['ticket_type_id'] = $ticket_id['0']->ticket_type_id;

				// get issued ticket count for sub event
				$issued_count = $this->api_model->get_ticket_issued_by_sub_event($event_id);

				//get scanned ticket for sub event
				$scanned_count = $this->api_model->get_ticket_scanned_by_sub_event($event_id);

				// get ticket scanned by me for sub event
				$my_scanned_count = $this->api_model->get_ticket_scanned_by_me_sub_event($event_id,$app_user_id);

				// set response array
				$response_array = array();
				$response_array['issued'] = $issued_count;
				$response_array['scanned'] = $scanned_count;
				$response_array['scanned_by_me'] = $my_scanned_count;

			   echo json_encode(array('status' => 'true', 'respMsg' => 'Ticket Already Scanned','respData' => $user_record_data,'ticketData' => $response_array));
			   exit;
			}
	    }else{
		   echo json_encode(array('status' => 'true', 'respMsg' => 'Invalid Ticket'));
		   exit;

		}
	}

	function dashboard_summary(){
		if(!isset($_POST['user_id']) || (isset($_POST['user_id']) && $_POST['user_id'] == '')) {
		   echo json_encode(array('status' => 'false', 'errorMsg' => 'Please enter app userd id'));
		   exit;
		} else {
		   $user_id = trim($_POST['user_id']);
        }

		if(!isset($_POST['event_id']) || (isset($_POST['event_id']) && $_POST['event_id'] == '')) {
		   echo json_encode(array('status' => 'false', 'errorMsg' => 'Please enter event id'));
		   exit;
		} else {
		   $event_id = trim($_POST['event_id']);
        }

		// get issued ticket count for sub event
		$issued_count = $this->api_model->get_ticket_issued_by_sub_event($event_id);

		//get scanned ticket for sub event
		$scanned_count = $this->api_model->get_ticket_scanned_by_sub_event($event_id);

		// get ticket scanned by me for sub event
		$my_scanned_count = $this->api_model->get_ticket_scanned_by_me_sub_event($event_id,$user_id);

		// set response array
		$response_array = array();
		$response_array['issued'] = $issued_count;
		$response_array['scanned'] = $scanned_count;
		$response_array['scanned_by_me'] = $my_scanned_count;

		echo json_encode(array('status' => 'true', 'respMsg' => 'Ticket summary','respData' => $response_array));
		exit;
	}

	function get_ticket_types(){
		if(!isset($_POST['user_id']) || (isset($_POST['user_id']) && $_POST['user_id'] == '')) {
		   echo json_encode(array('status' => 'false', 'errorMsg' => 'Please enter app user id'));
		   exit;
		} else {
		   $user_id = trim($_POST['user_id']);
        }

		if(!isset($_POST['event_id']) || (isset($_POST['event_id']) && $_POST['event_id'] == '')) {
		   echo json_encode(array('status' => 'false', 'errorMsg' => 'Please enter event id'));
		   exit;
		} else {
		   $event_id = trim($_POST['event_id']);
        }

		//
		$result = $this->all_ticket_details($user_id,$event_id);

		echo json_encode(array('status' => 'true', 'respMsg' => 'Ticket Types Data','respData' => $result));
		exit;

		/* // get data for FREE ticket type
		$issued_count = $this->api_model->get_ticket_issued_by_sub_event_ticket_type($event_id,2);
		$scanned_count = $this->api_model->get_ticket_scanned_by_sub_event_ticket_type($event_id,2);
		$my_scanned_count = $this->api_model->get_ticket_scanned_by_me_sub_event_ticket_type($event_id,$user_id,2);

		// set response array
		$response_free = array();
		$response_free['ticket_type_id'] = 3;
		$response_free['issued'] = $issued_count;
		$response_free['scanned'] = $scanned_count;
		$response_free['scanned_by_me'] = $my_scanned_count;


		// get data for Donation ticket type
		$issued_count = $this->api_model->get_ticket_issued_by_sub_event_ticket_type($event_id,3);
		$scanned_count = $this->api_model->get_ticket_scanned_by_sub_event_ticket_type($event_id,3);
		$my_scanned_count = $this->api_model->get_ticket_scanned_by_me_sub_event_ticket_type($event_id,$user_id,3);

		// set response array
		$response_donation = array();
		$response_donation['ticket_type_id'] = 3;
		$response_donation['issued'] = $issued_count;
		$response_donation['scanned'] = $scanned_count;
		$response_donation['scanned_by_me'] = $my_scanned_count;

		// get data for Paid ticket type
		$issued_count = $this->api_model->get_ticket_issued_by_sub_event_ticket_type($event_id,1);
		$scanned_count = $this->api_model->get_ticket_scanned_by_sub_event_ticket_type($event_id,1);
		$my_scanned_count = $this->api_model->get_ticket_scanned_by_me_sub_event_ticket_type($event_id,$user_id,1);

		// set response array
		$response_paid = array();
		$response_paid['ticket_type_id'] = 1;
		$response_paid['issued'] = $issued_count;
		$response_paid['scanned'] = $scanned_count;
		$response_paid['scanned_by_me'] = $my_scanned_count;

		//final array
		$final_array = array();
		$final_array['free'] = $response_free;
		$final_array['donation'] = $response_donation;
		$final_array['paid'] = $response_paid;

		echo json_encode(array('status' => 'true', 'respMsg' => 'Ticket Types Data','respData' => $final_array));
		exit; */
	}

	function ticket_type_details(){
		if(!isset($_POST['user_id']) || (isset($_POST['user_id']) && $_POST['user_id'] == '')) {
		   echo json_encode(array('status' => 'false', 'errorMsg' => 'Please enter app userd id'));
		   exit;
		} else {
		   $user_id = trim($_POST['user_id']);
        }

		if(!isset($_POST['event_id']) || (isset($_POST['event_id']) && $_POST['event_id'] == '')) {
		   echo json_encode(array('status' => 'false', 'errorMsg' => 'Please enter event id'));
		   exit;
		} else {
		   $event_id = trim($_POST['event_id']);
        }

		if(!isset($_POST['ticket_type_id']) || (isset($_POST['ticket_type_id']) && $_POST['ticket_type_id'] == '')) {
		   echo json_encode(array('status' => 'false', 'errorMsg' => 'Please enter event id'));
		   exit;
		} else {
		   $ticket_type_id = trim($_POST['ticket_type_id']);
        }

		// check for valid ticket type id
		if(!in_array($ticket_type_id, array('1','2','3'), true ) ) {
			 echo json_encode(array('status' => 'false', 'errorMsg' => 'Please enter valid ticket type id'));
		   exit;
		}

		// check if valid user id
		$check_user = $this->api_model->check_if_user_id_valid($user_id);
		$final_output = array();
		if($check_user){
			// get ticket issued list for this sub event
			$total_ticket_data = $this->api_model->get_ticket_scanned_by_sub_event_ticket_type_data($event_id,$ticket_type_id);

			foreach($total_ticket_data as $ticket_info){

				// get user first name and last name by order id
				$user_data = $this->api_model->get_ticket_user_details($ticket_info['order_id']);

				// build user data array
				$user_record_data = array();

				if(isset($user_data['0'])){
					$user_record_data['first_name'] = $user_data['0']->first_name;
					$user_record_data['last_name'] = $user_data['0']->last_name;
				}else{
					$user_record_data['first_name'] = "";
					$user_record_data['last_name'] = "";
				}

				// get ticket type and ticket id
				$ticket_format_type = "";
				if($ticket_type_id == '1'){
					$ticket_format_type = "Paid";
				}else if($ticket_type_id == '2'){
					$ticket_format_type = "Free";
				}else if($ticket_type_id == '3'){
					$ticket_format_type = "Donation";
				}

				$user_record_data['ticket_no'] = $ticket_info['ticket_gen'];
				$user_record_data['ticket_type'] = $ticket_format_type;

				// final output array
				$final_output[] = $user_record_data;
			}

			echo json_encode(array('status' => 'true', 'respMsg' => 'Ticket Types Details','respData' => $final_output));
			exit;
		}else{
			echo json_encode(array('status' => 'false', 'errorMsg' => 'Invalid user id'));
			exit;
		}
	}


	function download_tickets_offline(){
		if(!isset($_POST['user_id']) || (isset($_POST['user_id']) && $_POST['user_id'] == '')) {
		   echo json_encode(array('status' => 'false', 'errorMsg' => 'Please enter user id'));
		   exit;
		} else {
		   $user_id = trim($_POST['user_id']);
        }

		if(!isset($_POST['event_id']) || (isset($_POST['event_id']) && $_POST['event_id'] == '')) {
		   echo json_encode(array('status' => 'false', 'errorMsg' => 'Please enter event id'));
		   exit;
		} else {
		   $event_id = trim($_POST['event_id']);
        }

		// chechk for key
		//$user_id = "1";
		//$event_id = "264";

		if(isset($_POST['get_summary']) || (isset($_POST['get_summary']) && $_POST['get_summary'] != '')) {
		    $get_summary = trim($_POST['get_summary']);
		}else{
			$get_summary = "";
		}

		// get dashboard summary
		$summary = $this->internal_dashboard_summary($event_id,$user_id);




		if(isset($_POST['key']) || (isset($_POST['key']) && $_POST['key'] != '')) {
		   $key = trim($_POST['key']);
		   $page_count = $key*20;
		   $key++;
		} else {
		   $page_count = "20";
		   $key = 2;
        }

		$check_user = $this->api_model->check_if_user_id_valid($user_id);
		$final_output = array();
		$last_output = array();
		if($check_user){
			// get ticket data count
			$ticket_count_total = $this->api_model->get_ticket_issued_by_sub_event($event_id);

			if($ticket_count_total == 0){
				echo json_encode(array('status' => 'false', 'errorMsg' => 'No ticket data available'));
				exit;
			}else if(($ticket_count_total-$page_count) <= 20){
				$key = 0;
			}

			// get ticket data
			$ticket_data = $this->api_model->get_ticket_issued_by_sub_event_data($event_id,$page_count);

			if(empty($ticket_data)){
				$last_output['data'] = array();
				$last_output['key'] = $key;
				$last_output['total_ticket_count'] = array();

				echo json_encode(array('status' => 'true', 'respMsg' => 'Offline Ticket Data','respData' => $last_output));
				exit;
			}

			foreach($ticket_data as $ticket_info){

				// get user first name and last name by order id
				$user_data = $this->api_model->get_ticket_user_details($ticket_info['order_id']);

				// build user data array
				$user_record_data = array();

				if(isset($user_data['0'])){
					$user_record_data['first_name'] = $user_data['0']->first_name;
					$user_record_data['last_name'] = $user_data['0']->last_name;
				}else{
					$user_record_data['first_name'] = "";
					$user_record_data['last_name'] = "";
				}

				// get ticket type information
				$data_ticket = $this->api_model->get_ticket_type_by_ticket_generated_id($ticket_info['ticket_id']);

				$ticket_type_id = $data_ticket[0]['ticket_type_id'];

				// get ticket type and ticket id
				 $ticket_format_type = "";
				if($ticket_type_id == '1'){
					$ticket_format_type = "Paid";
				}else if($ticket_type_id == '2'){
					$ticket_format_type = "Free";
				}else if($ticket_type_id == '3'){
					$ticket_format_type = "Donation";
				}

				$user_record_data['ticket_type_name'] = $ticket_format_type;
				$user_record_data['ticket_type_id'] = $ticket_type_id;
				$user_record_data['ticket_id'] = $ticket_info['id'];
				$user_record_data['event_id'] = $ticket_info['event_id'];
				$user_record_data['qr_data'] = $ticket_info['qr_data'];
				$user_record_data['ticket_no'] = $ticket_info['ticket_sequence_no'];
				$user_record_data['ticket_scan_status'] = $ticket_info['ticket_scan_status'];

				// final output array
				$final_output[] = $user_record_data;
			}

			$data_er = $this->all_ticket_details($user_id,$event_id);

			$last_output['data'] = $final_output;
			$last_output['key'] = $key;
			$last_output['total_ticket_count'] = $ticket_count_total;

			if($key == "1" || $key == "0"){
				echo json_encode(array('status' => 'true', 'respMsg' => 'Offline Ticket Data','respData' => $last_output,'summary'=>$summary,'scanned_summary'=>$data_er));
				exit;
			}else{
				echo json_encode(array('status' => 'true', 'respMsg' => 'Offline Ticket Data','respData' => $last_output,'summary'=>$summary));exit;
			}
		}else{
			echo json_encode(array('status' => 'false', 'errorMsg' => 'Invalid user id'));
			exit;
		}
	}


	function internal_dashboard_summary($event_id,$user_id){

		// get issued ticket count for sub event
		$issued_count = $this->api_model->get_ticket_issued_by_sub_event($event_id);

		//get scanned ticket for sub event
		$scanned_count = $this->api_model->get_ticket_scanned_by_sub_event($event_id);

		// get ticket scanned by me for sub event
		$my_scanned_count = $this->api_model->get_ticket_scanned_by_me_sub_event($event_id,$user_id);

		// set response array
		$response_array = array();
		$response_array['issued'] = $issued_count;
		$response_array['scanned'] = $scanned_count;
		$response_array['scanned_by_me'] = $my_scanned_count;

		return $response_array;
	}

	/*
	function update_offline_ticket_status(){
		if(!isset($_POST['request']) || (isset($_POST['request']) && $_POST['request'] == '')) {
		   echo json_encode(array('status' => 'false', 'errorMsg' => 'Please enter valid request'));
		   exit;
		} else {
		   $request = trim($_POST['request']);
        }

		$result = json_decode($request);

		$r_data = $result->respData;

		if(!empty($r_data)){
			foreach($r_data as $t_data){
				if($t_data->qr_code != ""){
					$check_status = $this->api_test_model->update_ticket_status($t_data->qr_code);
					// update ticket scan history
					$ticket_scanned_data = array();
					$ticket_scanned_data['usher_id'] = $result->user_id;
					$ticket_scanned_data['ticket_generated_id'] = "";
					$ticket_scanned_data['sub_event_id'] = $result->event_id;

					$check_status = $this->api_model->insert_ticket_history($ticket_scanned_data);
				}
			}
		}

		echo json_encode(array('status' => 'true', 'respMsg' => 'Tickets status updated successfully'));
		exit;
	}*/

	function update_offline_ticket_status(){
		if(!isset($_POST['request']) || (isset($_POST['request']) && $_POST['request'] == '')) {
		   echo json_encode(array('status' => 'false', 'errorMsg' => 'Please enter valid request'));
		   exit;
		} else {
		   $request = trim($_POST['request']);
        }

		$result = json_decode($request);
		$r_data = $result->respData;
		$res = json_decode($r_data);
		if(!empty($res)){
			foreach($res as $t_data){
				if($t_data->qr_code != ""){
					$check_status = $this->api_model->update_ticket_status($t_data->qr_code);
					// update ticket scan history
					$ticket_scanned_data = array();
					$ticket_scanned_data['usher_id'] = $result->user_id;
					$ticket_scanned_data['ticket_generated_id'] = $t_data->ticket_id;
					$ticket_scanned_data['ticket_type_id'] = $t_data->ticket_type_id;
					$ticket_scanned_data['sub_event_id'] = $result->event_id;
					$todate = new DateTime($t_data->scan_time);
					$ticket_scanned_data['scanned_date'] = $todate->format('Y-m-d H:i:s');
					$ticket_scanned_data['upload_date'] = date('Y-m-d H:i:s');
					$check_status = $this->api_model->insert_ticket_history($ticket_scanned_data);
				}
			}
		}
		echo json_encode(array('status' => 'true', 'respMsg' => 'Tickets status updated successfully'));
		exit;
	}

	function all_ticket_details($user_id,$event_id){

		$ticket_format_type = "";

		// check if valid user id
		$check_user = $this->api_model->check_if_user_id_valid($user_id);
		$final_output = array();
		if($check_user){
			for($i=1;$i<=3;$i++){			// get ticket issued list for this sub event
				$total_ticket_data = $this->api_model->get_ticket_scanned_by_sub_event_ticket_type_data($event_id,$i);

				// build a response data array
				$response_array = array();

				if($i == '1'){
					$ticket_format_type = "Paid";
				}else if($i == '2'){
					$ticket_format_type = "Free";
				}else if($i == '3'){
					$ticket_format_type = "Donation";
				}

				$response_array['ticket_type'] = $ticket_format_type;
				$response_array['ticket_type_id'] = $i;

				// get summary by ticket id
		$issued_count = $this->api_model->get_ticket_issued_by_sub_event_ticket_type($event_id,$i);
		$scanned_count = $this->api_model->get_ticket_scanned_by_sub_event_ticket_type($event_id,$i);
		$my_scanned_count = $this->api_model->get_ticket_scanned_by_me_sub_event_ticket_type($event_id,$user_id,$i);

				$response_array['issued'] = $issued_count;
				$response_array['scanned'] = $scanned_count;
				$response_array['scanned_by_me'] = $my_scanned_count;

				//
				$final_array[] = $response_array;
			}
			return $final_array;

		//	echo json_encode(array('status' => 'true', 'respMsg' => 'Ticket Types Details','respData' => $final_array));
		//	exit;
		}else{
			return array();
		}
	}


	function facebook_sign_up(){
		$emailRegex = "/^[a-z0-9_\+-]+(\.[a-z0-9_\+-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*\.([a-z]{2,4})$/";
		$email="";

		if(!isset($_POST['email']) || (isset($_POST['email'] ) && $_POST['email'] == "")){
			echo json_encode(array('status' => 'false', 'errorMsg' => 'please enter a valid email id'));
			exit;
		}else{
			if(!preg_match($emailRegex ,($_POST['email']))){
				echo json_encode(array('status' => 'false', 'errorMsg' => 'please enter a valid email id'));
				exit;
			}else{
				$email = $_POST['email'];
			}
		}

		$data_result = $this->api_model->check_fb_login($email);

		if($data_result){
			// check if user is already logged in
			$log_status = $this->api_model->check_login_status($email);

			if($log_status){
				//echo json_encode(array('status' => 'true', 'respMsg' => 'User logged in successfully'));
				echo json_encode(array('status' => 'true', 'respMsg' => 'User logged in successfully','user_id' => $log_status[0]->user_id));
				exit;
			}else{
				echo json_encode(array('status' => 'false', 'errorMsg' => 'User is already logged in through other device'));
				exit;
			}
		}else{
			echo json_encode(array('status' => 'false', 'errorMsg' => 'Please enter valid usher email address'));
			exit;
		}
	}
}