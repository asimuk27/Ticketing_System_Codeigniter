<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Organiser extends CI_Controller {

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
		$this->load->model('backend/organiser_model');
		$this->load->library(array('form_validation','session','pagination'));
		$this->load->helper(array('form', 'url'));
		$passArg = array();

		if(!isset($this->session->userdata['admin_logged_in'])){
			redirect('backend/login', 'refresh');
		}

		//$this->output->enable_profiler(TRUE);
	}

	public function index(){
		// Display output page
		$records = $this->organiser_model->get_pending_for_approval();
		$pending_count = $records['0']['request_pending'];

		if(isset($_POST['searchby']) && ($_POST['searchby'] != "")){
			$search_values = $_POST;
			$viewArr['selected_filter'] = $_POST['searchby'];
		}else{
			$search_values = array();
			$viewArr['selected_filter'] = "";
		}

		$totalRec = $this->organiser_model->get_all_users_count($search_values);

		//pagination configuration
        $config['first_link']  = 'First';
        $config['div']         = 'postList'; //parent div tag id
        $config['base_url']    = base_url().'index.php/backend/organiser/index';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = 10;
        $config["uri_segment"] = 4;
		$choice = $config["total_rows"] / $config["per_page"];
		$config["num_links"] = 3;

		//config for bootstrap pagination class integration
        $config['full_tag_open'] = '<ul class="pagination">';
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
		$viewArr['pending_count'] = $pending_count;
		$viewArr['total_records'] = $totalRec;
		$viewArr['listing_data'] = $this->organiser_model->get_all_users($config["per_page"], $page, $search_values);

		$viewArr['viewPage'] = "organiser_listing";
		$this->load->view('backend/layout', $viewArr);
	}

	function update_organiser_status(){
		// call function to update organiser status
		$this->organiser_model->update_organiser_status($_POST['status'],$_POST['organiser_id']);
		$this->send_status_email($_POST['status'],$_POST['organiser_id']);
		echo "1";exit;
	}

	function send_status_email($status,$organiser_id){

		//echo $status;exit;
		$this->load->library('email');
		$this->email->from('admin@ticketing_system.com', 'TicketingSystem');
		$this->email->set_mailtype("html");
		//get organiser id
		$to_email_address = $this->organiser_model->get_organiser_email($organiser_id);

		if(isset($to_email_address['0']['email'])){
			$this->email->to($to_email_address['0']['email']);
			$this->email->bcc("darshan.more@quagnitia.com");
			if($status == 0){
				$this->email->subject('Organiser account activation');
				$message = "Hello User,";
				$message .= "<br>";$message .= "<br>";
				$message .= "Your account registered with email address: ".$to_email_address['0']['email']." has been activated";

				$message .= "<br>";$message .= "<br>";
				$message .= "Thanks,";
				$message .= "<br>";$message .= "<br>";
				$message .= "TicketingSystem";
				$message .= "<br>";$message .= "<br>";
				$message .= "<img src=".$this->config->item('fe_logo_image_url')." alt='logo' width='100px;'>";
				$message .= "<br>";$message .= "<br>";
				$message .= "<B>Note: Email content is yet to be approved</B>";
				$message .= "<br>";$message .= "<br>";
				$this->email->message($message);
				$result = $this->email->send();
			}else if($status == 2){
				$link = "http://local.ticketing_system.com/frontend/password/set_password/".md5($to_email_address['0']['email']);
				$this->email->subject('Organiser account activation');
				$message = "Kia ora and welcome,";
				$message .= "<br>";$message .= "<br>";
				$message .= "The account registered with the email address ".$to_email_address['0']['email']." has now been activated.";
				$message .= "<br>";
				$message .= "You are now registered with TICKETING SYSTEM and are moments away to managing your events and fundraising for a cause you care about.";
				$message .= "<br>";$message .= "<br>";
				$message .= "To set up your account password please <a href='".$link."'>click here</a>";
				$message .= "<br>";$message .= "<br>";
				$message .= "Thanks,";
				$message .= "<br>";$message .= "<br>";
				$message .= "TicketingSystem";
				$message .= "<br>";$message .= "<br>";
				$message .= "<img src=".$this->config->item('fe_logo_image_url')." alt='logo' width='100px;'>";
				$message .= "<br>";$message .= "<br>";
				$message .= "<B>Note: Email content is yet to be approved</B>";
				$message .= "<br>";$message .= "<br>";
				$this->email->message($message);
				$result = $this->email->send();
			}else if($status == 1){
				$this->email->subject('Organiser account deactivation');

				$message = "Hello User,";
				$message .= "<br>";$message .= "<br>";
				$message .= "Your account registered with email address: ".$to_email_address['0']['email']." has been temporarily disabled";

				$message .= "<br>";$message .= "<br>";
				$message .= "Thanks,";
				$message .= "<br>";$message .= "<br>";
				$message .= "TicketingSystem";
				$message .= "<br>";$message .= "<br>";
				$message .= "<img src=".$this->config->item('fe_logo_image_url')." alt='logo' width='100px;'>";
				$message .= "<br>";$message .= "<br>";
				$message .= "<B>Note: Email content is yet to be approved</B>";
				$message .= "<br>";

				$this->email->message($message);
				$result = $this->email->send();
			}
		}
		return $result;
	}

	function view_organisation($id = NULL){
		if($id){
			$data = $this->organiser_model->view_organisation($id);
			$ip_details = $this->organiser_model->terms_n_conditions_view($id);

			if(isset($data['0'])){
				$viewArr['data'] = $data['0'];
				$viewArr['ip_details'] = $ip_details;
				$viewArr['viewPage'] = "organisation_view";
				$this->load->view('backend/layout', $viewArr);
			}else{
				redirect('backend/organiser', 'refresh');
			}
		}else{
			$this->index();
		}
	}

	function edit_organisation($id = NULL){
		if($id){
			$data = $this->organiser_model->view_organisation($id);
			if(isset($data['0'])){
				$payment_data = $this->organiser_model->get_payment_information($id);

				$viewArr['payment_data'] = $payment_data;
				$get_organisation_type=$this->organiser_model->get_organisation_type();
				$viewArr['get_organisation_type'] = $get_organisation_type;
				$viewArr['data'] = $data['0'];
				$viewArr['viewPage'] = "organisation_edit";
				$this->load->view('backend/layout', $viewArr);
			}else{
				redirect('backend/organiser', 'refresh');
			}
		}else{
			redirect('backend/organiser', 'refresh');
		}
	}

	function save_organiser(){

		/**** validation rules for mandatory fields ****/
		// rules for main organiser contact details
		$this->form_validation->set_error_delimiters('<p style="color:red;">', '</p>');
		$this->form_validation->set_rules('title', 'title', 'trim|required|xss_clean');
		$this->form_validation->set_rules('salutation', 'salutation', 'trim|required|xss_clean');
		$this->form_validation->set_rules('first_name', 'first name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('last_name', 'last name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('organiser_id', 'organiser_id', 'trim|required|xss_clean');

		//	$this->form_validation->set_rules('email', 'email', 'trim|required|xss_clean|valid_email|is_unique[organisation_contact.email]');

		// rules for organisation details
		$this->form_validation->set_rules('organisation_name', 'organisation name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('charity_name', 'charity name', 'trim|required|xss_clean');

		//organisation financial contact details
		$this->form_validation->set_rules('finance_position', 'finance position', 'trim|xss_clean');
		$this->form_validation->set_rules('finance_first_name', 'finance first name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('finance_last_name', 'finance last name', 'trim|required|xss_clean');
	//	$this->form_validation->set_rules('finance_email', 'finance email', 'trim|required|xss_clean|valid_email|is_unique[organization_finance_contact.email]');

		// organisation bank details
		$this->form_validation->set_rules('bank_name', 'bank name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('bank_details', 'bank details', 'trim|required|xss_clean');


		//bank details for ticketsuits
		$this->form_validation->set_rules('bank_name_for_ts', 'bank name for TICKETING SYSTEM', 'trim|required|xss_clean');
		$this->form_validation->set_rules('bank_account_no_for_ts', 'account number TICKETING SYSTEM', 'trim|required|xss_clean');


		/*** other fields ***/
		$this->form_validation->set_rules('phone', 'phone', 'trim|xss_clean');
		$this->form_validation->set_rules('finance_phone', 'finance phone', 'trim|xss_clean');
		$this->form_validation->set_rules('fax', 'fax', 'trim|xss_clean');
		$this->form_validation->set_rules('ird', 'ird', 'trim|xss_clean');
		$this->form_validation->set_rules('charity_overview', 'charity overview', 'trim|xss_clean');
		$this->form_validation->set_rules('street_address', 'street address', 'trim|xss_clean|required');
		$this->form_validation->set_rules('city', 'city', 'trim|xss_clean|required');
		$this->form_validation->set_rules('region', 'state', 'trim|xss_clean|required');
		$this->form_validation->set_rules('postal_code', 'postal code', 'trim|xss_clean|required');
		$this->form_validation->set_rules('country', 'country', 'trim|xss_clean|required');

		// 	validation for file upload parameters
			$this->form_validation->set_rules('logo', 'logo', 'callback_handle_upload_logo');
			$this->form_validation->set_rules('bank_signature', 'bank signature', 'callback_handle_upload_signature');
			$this->form_validation->set_rules('bank_statement', 'bank statement', 'callback_handle_upload_statement');

		//validation for file upload for bank ticketsuits
		    $this->form_validation->set_rules('bank_attachment_for_ts', 'bank attachment for ts', 'callback_handle_upload_ticket_suite_statement');


		if($this->form_validation->run() == FALSE){
			//echo validation_errors();exit;
			$data = $this->organiser_model->view_organisation($this->input->post('organiser_id'));
			$viewArr['data'] = $data['0'];
			$payment_data = $this->organiser_model->get_payment_information($this->input->post('organiser_id'));
			$viewArr['payment_data'] = $payment_data;
			$get_organisation_type=$this->organiser_model->get_organisation_type();

		$viewArr['get_organisation_type'] = $get_organisation_type;
			$viewArr['viewPage'] = "organisation_edit";
			$this->load->view('backend/layout', $viewArr);
		}else{
			if($this->input->post('areas') != ""){
				$areas = $this->input->post('areas');
				$org_areas = implode (",", $areas);
			}else{
				$org_areas = "";
			}

			// set payment array
			$dynamic_payment = array();
			$organizer_unique_id = $this->input->post('organiser_id');

			$dynamic_payment['payment_key'] = "dynamic_payment";
			$dynamic_payment['payment_method'] = $this->input->post('dynamic_payment_method');
			$dynamic_payment['reference_number'] = $this->input->post('dynamic_payment_reference');

			$flo2_cash['payment_key'] = "cc";
			$flo2_cash['payment_method'] = $this->input->post('cc_method');
			$flo2_cash['reference_number'] = $this->input->post('cc_reference');

			/* $dps['payment_key'] = "dps";
			$dps['payment_method'] = $this->input->post('dps_method');
			$dps['reference_number'] = $this->input->post('dps_reference');
			 */
			$poli['payment_key'] = "poli";
			$poli['payment_method'] = $this->input->post('poli_method');
			$poli['reference_number'] = $this->input->post('poli_reference');

			$alipay['payment_key'] = "alipay";
			$alipay['payment_method'] = $this->input->post('alipay_method');
			$alipay['reference_number'] = $this->input->post('alipay_reference');

			$result = $this->organiser_model->update_payment_details($dynamic_payment,$organizer_unique_id);
			$result = $this->organiser_model->update_payment_details($flo2_cash,$organizer_unique_id);
			//$result = $this->organiser_model->update_payment_details($dps,$organizer_unique_id);
			$result = $this->organiser_model->update_payment_details($poli,$organizer_unique_id);
			$result = $this->organiser_model->update_payment_details($alipay,$organizer_unique_id);


			// organizer main details
			$data = array(
				'id' => $this->input->post('organiser_id'),
				'title' => $this->input->post('title'),
				'preferred_name' => $this->input->post('preferred_name'),
				'areas' => $org_areas,
				'organization_nature' => $this->input->post('organization_nature'),
				'donee_status' => $this->input->post('donee_status'),
				'charities_commission' => $this->input->post('charities_commission'),
				'registration_number' => $this->input->post('registration_number'),
				'salutation' => $this->input->post('salutation'),
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'email' => $this->input->post('email'),
				'phone' => $this->input->post('phone'),
				'fax' => $this->input->post('fax'),
				'status' =>  $this->input->post('status')
			);

			$organiser_id = $this->organiser_model->save_organiser($data);

			// organiser additional details
			$data = array(
				'organization_id' => $this->input->post('organiser_id'),
				'organization_name' => $this->input->post('organisation_name'),
				'ird_number' => $this->input->post('ird'),
				'charity_name' => $this->input->post('charity_name'),
				'charity_overview' => $this->input->post('charity_overview'),
				'street_address' => $this->input->post('street_address'),
				'logo' => $this->input->post('old_logo'),
				'city' =>  $this->input->post('city'),
				'region' => $this->input->post('region'),
				'postal_code' => $this->input->post('postal_code'),
				'country' =>  $this->input->post('country'),
			);


			$result = $this->organiser_model->save_organiser_additional_details($data);


		//	$textToStore = nl2br(htmlentities($inputText, ENT_QUOTES, 'UTF-8'));

			// organiser finance details
			$data = array(
				'organization_id' => $this->input->post('organiser_id'),
				'position' => $this->input->post('finance_position'),
				'first_name' => $this->input->post('finance_first_name'),
				'last_name' => $this->input->post('finance_last_name'),
				'phone' => $this->input->post('finance_phone'),
				'fax' => $this->input->post('finance_fax'),
				'bank_name' =>  $this->input->post('bank_name'),
				'bank_name_for_ticket_suite' => $this->input->post('bank_name_for_ts'),
				'account_number_ticket_suite' => $this->input->post('bank_account_no_for_ts'),
				'plan_select' => $this->input->post('plan_select'),
				'bank_details' => $this->input->post('bank_details'),
				'receipt_text' => $this->input->post('receipt_text'),
				'signature' =>  $this->input->post('old_signature'),
				'bank_statement' =>  $this->input->post('old_bank_statement'),
				'bank_statement_ticket_suite' => $this->input->post('old_bank_ticket_suite_statement'),
				'signature_text' =>  $this->input->post('sig_text')
			);
			//echo "<pre>";
			//print_r($data);
			//echo "</pre>";
			//exit;

			// check if status is changed, if yes send email notification
			if($this->input->post('activation_change') == 1){
				if(($this->input->post('status') == "0") || ($this->input->post('status') == "2")){
					$email_status = 1;
				}else{
					$email_status = 0;
				}
				$this->send_status_email($this->input->post('old_status'),$this->input->post('organiser_id'));
			}

			$result = $this->organiser_model->save_organiser_finance_details($data);
			$this->session->set_flashdata('message', 'Record updated successfully');
			redirect('backend/organiser', 'refresh');
		}
	}



	// check for image logo upload
	function handle_upload_signature(){
		$config = array();
		$config['upload_path']   = './assets/image_uploads/signature';
		$config['allowed_types'] = 'gif|jpg|png';

		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		if (isset($_FILES['signature']) && !empty($_FILES['signature']['name'])){
			if ($this->upload->do_upload('signature')){
				// set a $_POST value for 'image' that we can use later
				$upload_data    = $this->upload->data();
				$_POST['old_signature'] = $upload_data['file_name'];
				return true;
			}else{
				// possibly do some clean up ... then throw an error
				$this->form_validation->set_message('handle_upload_signature', $this->upload->display_errors());
				return false;
			}
		}
	}

	// check for image logo upload
	function handle_upload_statement(){
		$config = array();
		$config['upload_path']   = './assets/image_uploads/bank_statement';
		$config['allowed_types'] = 'gif|jpg|png|pdf';
        $new_name = time().'_'.$_FILES["bank_statement"]['name'];
		$config['file_name'] = $new_name;

		$this->load->library('upload', $config);
		$this->upload->initialize($config);

		if (isset($_FILES['bank_statement']) && !empty($_FILES['bank_statement']['name'])){

			if ($this->upload->do_upload('bank_statement')){
				// set a $_POST value for 'image' that we can use later
				$upload_data    = $this->upload->data();
				$_POST['old_bank_statement'] = $upload_data['file_name'];
				return true;
			}else{
				// possibly do some clean up ... then throw an error
				$this->form_validation->set_message('handle_upload_statement', $this->upload->display_errors());
				return false;
			}
		}
	}
	//handle_upload_ticket_suite_statement

	// check for upload statement for TicketingSystem
	function handle_upload_ticket_suite_statement(){
		$config = array();
		$config['upload_path']   = './assets/image_uploads/bank_statement';
		$config['allowed_types'] = 'gif|jpg|png|pdf';
        $new_name = time().'_'.$_FILES["bank_attachment_for_ts"]['name'];
		$config['file_name'] = $new_name;
		$this->load->library('upload', $config);
		$this->upload->initialize($config);

		if (isset($_FILES['bank_attachment_for_ts']) && !empty($_FILES['bank_attachment_for_ts']['name'])){

			if ($this->upload->do_upload('bank_attachment_for_ts')){
				// set a $_POST value for 'image' that we can use later
				$upload_data    = $this->upload->data();
				$_POST['old_bank_ticket_suite_statement'] = $upload_data['file_name'];
				return true;
			}else{
				// possibly do some clean up ... then throw an error
				$this->form_validation->set_message('handle_upload_ticket_suite_statement', $this->upload->display_errors());
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
				$_POST['old_logo'] = $upload_data['file_name'];
				return true;
			}else{
				// possibly do some clean up ... then throw an error
				$this->form_validation->set_message('handle_upload_logo', $this->upload->display_errors());
				return false;
			}
		}
	}

	public function mark_as_incomplete(){
		$this->organiser_model->mark_as_incomplete($_POST['org_id']);
		echo "1";exit;
	}

	public function redirect_organiser_for_edit(){
		$this->session->set_flashdata('message', 'Organiser Updated successfully');
		redirect('backend/organiser', 'refresh');
	}

	function has_email_organiser(){
		if(isset($this->session->userdata['admin_logged_in'])){
			$id = $this->input->post('id');
			$email = $this->input->post('email');

			if($email ==""){
				echo "blank";exit;
			}

			if($email){
				$result = $this->organiser_model->authenticate_reg_email($email);
				if ($result){
					echo "false";
				}else{
				  $this->organiser_model->update_organiser_email($email,$id);
				  echo "true";
				}
			}else{
				echo "wrong";
			}
		}else{
			 redirect('backend/organiser', 'refresh');
		}
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */