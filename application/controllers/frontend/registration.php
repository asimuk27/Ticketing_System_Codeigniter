<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Registration extends CI_Controller {

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
		$this->load->library(array('form_validation','session','pagination'));
		$this->load->helper(array('form', 'url', 'file'));
		$passArg = array();
	}

	function has_email($email){
		if ($this->organiser_model->authenticate_reg_email($email)){
            $this->form_validation->set_message('has_email', 'email already in use');
            return false;
        }else{
            return true;
        }
	}

	function save_organiser(){

		$bank_status=$this->input->post('bank_details_for_ticket_suit');
		//echo $bank_status;exit;
		if($bank_status==1){
           $_FILES['bank_attachment_for_ts']['name']=$_FILES['bank_statement']['name'];
           $_FILES['bank_attachment_for_ts']['status']=1;

		}else{
			//echo $_FILES['bank_attachment_for_ts']['name'];exit;
			$_FILES['bank_attachment_for_ts']['status']=0;
		}



      //echo "<pre>";
		//print_r($_POST);exit;

		$this->form_validation->set_error_delimiters('<p style="color:red;">', '</p>');
		$this->form_validation->set_rules('title', 'title', 'trim|required|xss_clean');
		$this->form_validation->set_rules('salutation', 'salutation', 'trim|required|xss_clean');
		$this->form_validation->set_rules('first_name', 'first name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('last_name', 'last name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('email', 'email', 'trim|required|xss_clean|valid_email|callback_has_email[email]');

		// rules for organisation details
		$this->form_validation->set_rules('organisation_name', 'organisation name', 'trim|required|xss_clean|is_unique[organization_details.organization_name]');
		$this->form_validation->set_rules('charity_name', 'charity name', 'trim|required|xss_clean|is_unique[organization_details.charity_name]');

		//organisation financial contact details
		$this->form_validation->set_rules('finance_position', 'finance position', 'trim|xss_clean');
		$this->form_validation->set_rules('finance_first_name', 'finance first name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('finance_last_name', 'finance last name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('finance_email', 'finance email', 'trim|required|xss_clean|valid_email');

		// organisation bank details
		$this->form_validation->set_rules('bank_name', 'bank name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('bank_details', 'bank details', 'trim|required|xss_clean');

		/*** other fields ***/
		$this->form_validation->set_rules('phone', 'phone', 'trim|xss_clean');
		$this->form_validation->set_rules('finance_phone', 'finance phone', 'trim|xss_clean');
		$this->form_validation->set_rules('fax', 'fax', 'trim|xss_clean');
		$this->form_validation->set_rules('ird', 'ird', 'trim|xss_clean');
		$this->form_validation->set_rules('charity_overview', 'charity overview', 'trim|xss_clean');
		$this->form_validation->set_rules('street_address', 'street address', 'trim|xss_clean|required');
		$this->form_validation->set_rules('city', 'city', 'trim|xss_clean|required');
		$this->form_validation->set_rules('state', 'state', 'trim|xss_clean|required');
		$this->form_validation->set_rules('postal_code', 'postal code', 'trim|xss_clean|required');
	//	$this->form_validation->set_rules('country', 'country', 'trim|xss_clean|required');

		// validation for file upload parameters
		$this->form_validation->set_rules('logo', 'logo', 'callback_handle_upload_logo');
		$this->form_validation->set_rules('bank_signature', 'bank signature', 'callback_handle_upload_signature');
		$this->form_validation->set_rules('bank_statement', 'bank statement', 'callback_handle_upload_statement');
		$this->form_validation->set_rules('bank_attachment_for_ts', 'bank statement', 'callback_handle_upload_attachment_statement');




		if($this->form_validation->run() == FALSE){
			//echo validation_errors();            			$data = $this->organiser_model->get_organisation_details_by_id($id);							$viewArr['data'] = $data;
			$get_organisation_type=$this->organiser_model->get_organisation_type();
			$viewArr['get_organisation_type'] = $get_organisation_type;
			$viewArr['viewPage'] = "organisation_updated";
			$this->load->view('frontend/layout', $viewArr);
		}else{

			if($this->input->post('areas') != ""){
				$areas = $this->input->post('areas');
				$org_areas = implode (",", $areas);
			}else{
				$org_areas = "";
			}

            $bank_status=$this->input->post('bank_details_for_ticket_suit');
			if($bank_status==1){
				$bank_account_no_for_ts=$this->input->post('bank_details');
				$bank_name_for_ts=$_POST['bank_name'];
				$bank_attachment_for_ts=$this->input->post('bank_statement');
			}else{
				$bank_account_no_for_ts=$this->input->post('bank_account_no_for_ts');
				$bank_name_for_ts=$this->input->post('bank_name_for_ts');
				$bank_attachment_for_ts=$this->input->post('bank_attachment_for_ts');
			}
			//echo $bank_account_no_for_ts."<br>".$bank_name_for_ts."<br>".$bank_attachment_for_ts;exit;
			// organizer main details
			$data = array(
				'title' => $this->input->post('title'),
				'salutation' => $this->input->post('salutation'),
				'preferred_name' => $this->input->post('preferred_name'),
				'areas' => $org_areas,
				'organization_nature' => $this->input->post('organization_nature'),
				'donee_status' => $this->input->post('donee_status'),
				'charities_commission' => $this->input->post('charities_commission'),
				'registration_number' => $this->input->post('registration_number'),
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'email' => $this->input->post('email'),
				'phone' => $this->input->post('phone'),
				'fax' => $this->input->post('fax'),
				'status' =>  2,
			);

			$send_data_to_email = $data;
			$organiser_id = $this->organiser_model->save_organiser($data);

            $data_save_tc = array(
				'organizer_id' => $organiser_id,
				'key_name' => 'tc',
				'name' => 'Ticketsuit terms and conditions',
				'ip_address' => $_SERVER['REMOTE_ADDR'],
				'date' => date("Y-m-d"),
				'time' => date("g:i a"),
			);

            $this->organiser_model->save_terms_n_conditions($data_save_tc);

            $data_save_poli_tc = array(
				'organizer_id' => $organiser_id,
				'key_name' => 'poli_tc',
				'name' => 'POLi  terms and conditions',
				'ip_address' => $_SERVER['REMOTE_ADDR'],
				'date' => date("Y-m-d"),
				'time' => date("g:i a"),

			);


            $this->organiser_model->save_terms_n_conditions($data_save_poli_tc);

            $data_save_direct_debit_tc = array(
				'organizer_id' => $organiser_id,
				'key_name' => 'direct_debit_tc',
				'name' => 'Ticketsuit direct debit authority',
				'ip_address' => $_SERVER['REMOTE_ADDR'],
				'date' => date("Y-m-d"),
				'time' => date("g:i a"),

			);


            $this->organiser_model->save_terms_n_conditions($data_save_direct_debit_tc);

			// organiser additional details
			$data = array(
				'organization_id' => $organiser_id,
				'organization_name' => $this->input->post('organisation_name'),
				'ird_number' => $this->input->post('ird'),
				'charity_name' => $this->input->post('charity_name'),
				'charity_overview' => $this->input->post('charity_overview'),
				'street_address' => $this->input->post('street_address'),
				'logo' => $this->input->post('logo'),
				'city' =>  $this->input->post('city'),
				'region' => $this->input->post('state'),
				'postal_code' => $this->input->post('postal_code'),
				'country' =>  $this->input->post('country'),
			);



			$result = $this->organiser_model->save_organiser_additional_details($data);

			// organiser finance details
			$data = array(
				'organization_id' => $organiser_id,
				'position' => $this->input->post('finance_position'),
				'first_name' => $this->input->post('finance_first_name'),
				'last_name' => $this->input->post('finance_last_name'),
				'email' => $this->input->post('finance_email'),
				'phone' => $this->input->post('finance_phone'),
				'fax' => $this->input->post('finance_fax'),
				'bank_name' =>  $this->input->post('bank_name'),
				'bank_details' => $this->input->post('bank_details'),
				'receipt_text' => $this->input->post('recpt_txt'),
				'signature' =>  $this->input->post('bank_signature'),
				'bank_statement' =>  $this->input->post('bank_statement'),
				'bank_name_for_ticket_suite' => $bank_name_for_ts,
				'account_number_ticket_suite' => $bank_account_no_for_ts,
				'bank_statement_ticket_suite' => $bank_attachment_for_ts,
				'signature_text' =>  $this->input->post('sig_txt'),
				'plan_select' =>  $this->input->post('plan_select'),
			);

			$result = $this->organiser_model->save_organiser_finance_details($data);
			$this->send_organizer_entry_email_to_admin($this->input->post('email'));
			$this->send_organiser_under_approval_email($send_data_to_email);

			$viewArr['viewPage'] = "organisation_save";
			$this->load->view('frontend/layout', $viewArr);
		}
	}

	function send_organizer_entry_email_to_admin($email){
		$this->load->library('email');
		$this->email->from('admin@ticketing_system.com', 'TicketingSystem');
		$this->email->to('darshan.more@quagnitia.com');
		$this->email->set_mailtype("html");

		$this->email->subject('New organization entry - Needs approval');

		$message = "Hello Admin,";
		$message .= "<br>";$message .= "<br>";
		$message .= "We have a new organizer entry into our telesuite system that needs approval.";
		$message .= "<br>";
		$message .= "<br>";
		$message .= "Email address: ".$email;
		$message .= "<br>";
		$message .= "<br>";
		$message .= "Kindly initiate the approval process for above mentioned email address";
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
		$message .= "<B>Note: Email content is yet to be approved</B>";
		$message .= "<br>";

		$this->email->message($message);
		$resp = $this->email->send();
		return $resp;
	}

	function send_organiser_under_approval_email($data){
		$this->load->library('email');
		$this->email->from('admin@ticketing_system.com', 'TicketingSystem');
		$this->email->to($data['email']);
		$this->email->bcc("darshan.more@quagnitia.com");

		$this->email->set_mailtype("html");

		$this->email->subject('TicketingSystem | Organisation | New');

		$message = "Kia ora ".$data['salutation']." ".$data['first_name']." ".$data['last_name'].",";
		$message .= "<br>";$message .= "<br>";
		$message .= "Your organizer account is successfully registered with TicketingSystem";
		$message .= "<br>";
		$message .= "<br>";
		$message .= "Email address: ".$data['email'];
		$message .= "<br>";
		$message .= "<br>";
		$message .= "Please give us time to go through your details. We shall notify you once your account is approved";
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
		$this->email->message($message);
		$resp = $this->email->send();
		return $resp;
	}

	// check for image logo upload
	function handle_upload_signature(){
		$config = array();
		$config['upload_path']   = './assets/image_uploads/signature';
		$config['allowed_types'] = 'gif|jpg|png';

		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		if (isset($_FILES['bank_signature']) && !empty($_FILES['bank_signature']['name'])){
			if ($this->upload->do_upload('bank_signature')){
				// set a $_POST value for 'image' that we can use later
				$upload_data    = $this->upload->data();
				$_POST['bank_signature'] = $upload_data['file_name'];
				return true;
			}else{
				// possibly do some clean up ... then throw an error
				$this->form_validation->set_message('handle_upload_signature', $this->upload->display_errors());
				return false;
			}
		} else {
			// throw an error because nothing was uploaded
			$this->form_validation->set_message('handle_upload_signature', "You must upload an signature file!");
			return false;
		}
	}

	// check for image logo upload
	function handle_upload_statement(){
		$config = array();
		$config['upload_path']   = './assets/image_uploads/bank_statement';
		$config['allowed_types'] = '*';
        $new_name = time().'_'.$_FILES["bank_statement"]['name'];
		$config['file_name'] = $new_name;
		$this->load->library('upload', $config);
		$this->upload->initialize($config);

		if (isset($_FILES['bank_statement']) && !empty($_FILES['bank_statement']['name'])){
			if ($this->upload->do_upload('bank_statement')){
				// set a $_POST value for 'image' that we can use later
				$upload_data    = $this->upload->data();
				$_POST['bank_statement'] = $upload_data['file_name'];
				return true;
			}else{
				// possibly do some clean up ... then throw an error
				$this->form_validation->set_message('handle_upload_statement', $this->upload->display_errors());
				return false;
			}
		} else {
			// throw an error because nothing was uploaded
			$this->form_validation->set_message('handle_upload_statement', "You must upload an bank statement file!");
			return false;
		}
	}

	function handle_upload_attachment_statement(){
		//echo "<pre>";print_r($_FILES);exit;
		$config = array();
		$config['upload_path']   = './assets/image_uploads/bank_statement';
		$config['allowed_types'] = '*';

		if($_FILES['bank_attachment_for_ts']['status']!=1){
        $new_name = time().'_'.$_FILES["bank_attachment_for_ts"]['name'];
		$config['file_name'] = $new_name;
		$this->load->library('upload', $config);
		$this->upload->initialize($config);

		}else{


			$_POST['bank_attachment_for_ts']=time().'_'.$_FILES['bank_attachment_for_ts']['name'];
			 $new_name = time().'_'.$_FILES["bank_attachment_for_ts"]['name'];
		$config['file_name'] = $new_name;
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		}

		if (isset($_FILES['bank_attachment_for_ts']) && !empty($_FILES['bank_attachment_for_ts']['name'])){
			//echo $_FILES['bank_attachment_for_ts']['status'];exit;


			if($_FILES['bank_attachment_for_ts']['status']!=1){

				if ($this->upload->do_upload('bank_statement')){
				// set a $_POST value for 'image' that we can use later
				$upload_data    = $this->upload->data();
				$_POST['bank_attachment_for_ts'] = $upload_data['file_name'];
				return true;
			}else{
				if($_FILES['bank_attachment_for_ts']['status']!=1){
					$this->form_validation->set_message('handle_upload_attachment_statement', $this->upload->display_errors());
				    return false;
				}

			   }
			}

		} else {
			   if($_FILES['bank_attachment_for_ts']['status']!=1){
					$this->form_validation->set_message('handle_upload_attachment_statement', "You must upload an bank statement file!");
			       return false;
				}

		}
	}

	// check for image logo upload
	function handle_upload_logo(){
		$config = array();
		$config['upload_path']   = './assets/image_uploads/organisation_logo';
		$config['allowed_types'] = 'gif|jpg|png';

		$this->load->library('upload', $config);
		$this->upload->initialize($config);

		if (isset($_FILES['logo']) && !empty($_FILES['logo']['name'])){
			if ($this->upload->do_upload('logo')){
				// set a $_POST value for 'image' that we can use later
				$upload_data    = $this->upload->data();
				$_POST['logo'] = $upload_data['file_name'];
				return true;
			}else{
				// possibly do some clean up ... then throw an error
				$this->form_validation->set_message('handle_upload_logo', $this->upload->display_errors());
				return false;
			}
		} else {
			// throw an error because nothing was uploaded
			$this->form_validation->set_message('handle_upload_logo', "You must upload an logo image!");
			return false;
		}
	}

	//function to check if email id exist
	function email_unique_check(){
		// function to check if email exist
		$email_id = $_POST['email'];
	//	$result = $this->organiser_model->isEmailPresent($email_id);
		$result = $this->organiser_model->authenticate_reg_email($email_id);

		if($result){
			echo "false";
		}else{
			echo "true";
		}
	}

	//function to check if email id exist
	function charity_name_unique_check(){
		// function to check if email exist
		$name = $_POST['charity_name'];
		$result = $this->organiser_model->isCharityNamePresent($name);

		if($result){
			echo "false";
		}else{
			echo "true";
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */