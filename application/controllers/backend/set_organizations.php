<?php

class Set_organizations extends CI_Controller {

	//default constructor
    function __construct(){
		parent::__construct();
		//Load all required classes
		$this->load->model('backend/organiser_model');
		$this->load->model('backend/set_organization_model');
		$this->load->library(array('form_validation','session','pagination'));
		$this->load->helper(array('form', 'url','file'));
		$passArg = array();

		if(!isset($this->session->userdata['admin_logged_in'])){
			redirect('backend/login', 'refresh');
		}else{
			$authorise = $this->check_valid_roles();

			if($authorise){
				redirect('backend/login', 'refresh');
			}
		}
	}

	public function save_organization(){
		$this->form_validation->set_error_delimiters('<p style="color:red;">', '</p>');
		$this->form_validation->set_rules('title', 'title', 'trim|required|xss_clean');
		$this->form_validation->set_rules('salutation', 'salutation', 'trim|required|xss_clean');
		$this->form_validation->set_rules('first_name', 'first name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('last_name', 'last name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('last_name', 'last name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('organization_nature', 'Organization Nature', 'trim|xss_clean');

		if($this->input->post('organiser_id') == ""){
			$this->form_validation->set_rules('email', 'email', 'trim|required|xss_clean|valid_email|is_unique[organisation_contact.email]');
		}

		// rules for organisation details
		$this->form_validation->set_rules('organisation_name', 'organisation name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('finance_position', 'finance position', 'trim|xss_clean');
		$this->form_validation->set_rules('finance_first_name', 'finance first name', 'trim|xss_clean');
		$this->form_validation->set_rules('finance_last_name', 'finance last name', 'trim|xss_clean');
		// organisation bank details
		$this->form_validation->set_rules('bank_name', 'bank name', 'trim|xss_clean');
		$this->form_validation->set_rules('bank_details', 'bank details', 'trim|xss_clean');

		/*** other fields ***/
		$this->form_validation->set_rules('phone', 'phone', 'trim|xss_clean');
		$this->form_validation->set_rules('finance_phone', 'finance phone', 'trim|xss_clean');
		$this->form_validation->set_rules('fax', 'fax', 'trim|xss_clean');
		$this->form_validation->set_rules('ird', 'ird', 'trim|xss_clean');

		$this->form_validation->set_rules('charity_overview', 'charity overview', 'trim|xss_clean');

		$this->form_validation->set_rules('street_address', 'street address', 'trim|xss_clean');

		$this->form_validation->set_rules('city', 'city', 'trim|xss_clean');

		$this->form_validation->set_rules('region', 'state', 'trim|xss_clean');

		$this->form_validation->set_rules('postal_code', 'postal code', 'trim|xss_clean');

		$this->form_validation->set_rules('country', 'country', 'trim|xss_clean');

		// 	validation for file upload parameters

		$this->form_validation->set_rules('logo', 'logo', 'callback_handle_upload_logo');

		$this->form_validation->set_rules('bank_signature', 'bank signature', 'callback_handle_upload_signature');

		$this->form_validation->set_rules('bank_statement', 'bank statement', 'callback_handle_upload_statement');
		$this->form_validation->set_rules('bank_attachment_for_ts', 'bank statement', 'callback_handle_upload_attachment_statement');


		if($this->form_validation->run() == FALSE){
			$viewArr['viewPage'] = "set_up_organizations";
			$this->load->view('backend/layout', $viewArr);
		}else{
			if($this->input->post('areas') != ""){
				$areas = $this->input->post('areas');
				$org_areas = implode (",", $areas);
			}else{
				$org_areas = "";
			}
			$org_id = $this->input->post('organiser_id');
			// organizer main details
			$data = array(
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
				'in_complete' => 1,
				'status' =>  0
			);

			$organiser_id = $this->set_organization_model->save_organiser($data);
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
				'region' => $this->input->post('region'),
				'postal_code' => $this->input->post('postal_code'),
				'country' =>  $this->input->post('country'),
			);

			$result = $this->set_organization_model->save_organiser_additional_details($data);

			// organiser finance details
			$data = array(
				'organization_id' => $organiser_id,
				'position' => $this->input->post('finance_position'),
				'first_name' => $this->input->post('finance_first_name'),
				'last_name' => $this->input->post('finance_last_name'),
				'phone' => $this->input->post('finance_phone'),
				'email' => $this->input->post('finance_email'),
				'fax' => $this->input->post('finance_fax'),
				'bank_name' =>  $this->input->post('bank_name'),
				'bank_details' => $this->input->post('bank_details'),
				'receipt_text' => $this->input->post('receipt_text'),
				'signature' =>  $this->input->post('signature'),
				'bank_statement' =>  $this->input->post('bank_statement'),
				'signature_text' =>  $this->input->post('sig_text'),
				'bank_name_for_ticket_suite' =>  $this->input->post('bank_name_for_ts'),
				'account_number_ticket_suite' =>  $this->input->post('bank_account_no_for_ts'),
				'bank_statement_ticket_suite' =>  $this->input->post('bank_attachment_for_ts'),
			);

			$result = $this->set_organization_model->save_organiser_finance_details($data);

			// build data array for email
			$data = array();
			$data['name'] = $this->input->post('first_name');
			$data['email'] = $this->input->post('email');

			// send link on organization email address
			$result = $this->send_org_set_up_email($data);

			$this->session->set_flashdata('message', 'Organization submitted successfully');
			redirect('backend/set_organizations/index', 'refresh');
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
				$_POST['signature'] = $upload_data['file_name'];
				return true;
			}else{
				// possibly do some clean up ... then throw an error
			//	$this->form_validation->set_message('handle_upload_signature', $this->upload->display_errors());
				return true;
			}
		}else{
			$_POST['signature'] = "";
			return true;
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

		//echo "<pre>";
		//print_r($_FILES);exit;
		if (isset($_FILES['bank_statement']) && !empty($_FILES['bank_statement']['name'])){
			if ($this->upload->do_upload('bank_statement')){
                // echo "once uploaded";exit;
				// set a $_POST value for 'image' that we can use later
				$upload_data    = $this->upload->data();
				$_POST['bank_statement'] = $upload_data['file_name'];
				return true;
			}else{
                //echo $this->upload->display_errors();exit;
				// possibly do some clean up ... then throw an error
				$_POST['bank_statement'] ='';
				//$this->form_validation->set_message('handle_upload_statement', $this->upload->display_errors());
				return true;
			}
		}else{
			$_POST['bank_statement'] = '';
			return true;
		}
	}


	function handle_upload_attachment_statement(){
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
				$_POST['bank_attachment_for_ts'] = $upload_data['file_name'];
				return true;
			}else{
                $_POST['bank_attachment_for_ts']='';
				return true;
			}
		}else{
			 $_POST['bank_attachment_for_ts']='';
			 return true;
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
           // echo "here";exit;
			if ($this->upload->do_upload('logo')){
				// set a $_POST value for 'image' that we can use later
				$upload_data    = $this->upload->data();
				$_POST['logo'] = $upload_data['file_name'];
				return true;
			}else{
                // echo "not here";exit;
				// possibly do some clean up ... then throw an error
				$this->form_validation->set_message('handle_upload_logo', $this->upload->display_errors());
				return false;
			}
		}else{
			 $_POST['logo']='';
			 return true;
		}
	}

	public function check_valid_roles(){
		if(isset($this->session->userdata['admin_logged_in']['user_roles'])){
			$data_modules = $this->session->userdata['admin_logged_in']['user_roles'];
			$allowed_modules = explode(",",$data_modules);
			if(in_array("organizer_set_up",$allowed_modules)){
				return false;
			}else{
				return true;
			}
		}else{
			return true;
		}
	}

	function add_new_organizations(){
		$data['areas'] = array();
		$viewArr["data"] = $data['areas'];
		$organisation_type_list = $this->set_organization_model->get_organisation_type();
		$viewArr["organisation_type_list"] = $organisation_type_list;
		$viewArr["viewPage"] = "set_up_organizations";
		$this->load->view('backend/layout',$viewArr);
	}



	function index(){
		if(isset($_POST['searchby']) && ($_POST['searchby'] != "")){
			$search_values = $_POST;
			$viewArr['selected_filter'] = $_POST['searchby'];
		}else{
			$search_values = array();
			$viewArr['selected_filter'] = "";
		}

		if(isset($_POST['page_count']) && ($_POST['page_count'] != "")){
			$config['per_page'] = $_POST['page_count'];
			$page_count = $_POST['page_count'];
		}else{
			$page_count = 5;
			$config['per_page'] = 5;
		}

		$totalRec = $this->set_organization_model->get_all_users_count($search_values);
		//pagination configuration
        $config['first_link']  = 'First';
        $config['div']         = 'postList'; //parent div tag id
        $config['base_url']    = base_url().'index.php/backend/set_organizations/index';
        $config['total_rows']  = $totalRec;
        //$config['per_page']    = 10;
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
		$viewArr['page_count'] = $page_count;
		$viewArr['total_records'] = $totalRec;
		$listing_data = $this->set_organization_model->get_all_users($config["per_page"], $page, $search_values);

		$out_array = array();
		if(!empty($listing_data)){
			foreach($listing_data as $list_data){
				$in_array = array();
				$in_array['signature'] = $list_data['signature'];
				$in_array['id'] = $list_data['id'];
				$in_array['status']= $list_data['status'];
				$in_array['in_complete'] = $list_data['in_complete'];
				$in_array['organization_name'] = $list_data['organization_name'];
				$in_array['first_name'] = $list_data['first_name'];
				$in_array['last_name'] = $list_data['last_name'];
				$in_array['logo'] = $list_data['logo'];
				$in_array['organization_id'] = $list_data['organization_id'];
				$in_array['tc'] = $this->set_organization_model->get_terms_check_status('tc',$list_data['id']);
				$in_array['poli_tc'] = $this->set_organization_model->get_terms_check_status('poli_tc',$list_data['id']);
				$in_array['dd_tc'] = $this->set_organization_model->get_terms_check_status('direct_debit_tc',$list_data['id']);
				$in_array['bank1'] = $list_data['bank1'];
				$in_array['bank2'] = $list_data['bank2'];

				$out_array[] = $in_array;
			}
		}

		$viewArr['listing_data'] = $out_array;
		$viewArr["viewPage"] = "organiser_submisson_listing";
		$this->load->view('backend/layout',$viewArr);
	}

	function send_org_set_up_email($data){
		$key_code = md5($data['email']);
		$link = $this->config->item("organizer_set_up")."/".$key_code;
		$this->load->library('email');
		$this->email->from('quagnitia.testuser1@gmail.com', 'TicketingSystem');
		$this->email->to($data['email']);
		$this->email->set_mailtype("html");
		$this->email->subject('TicketingSystem | Organization | Set Up');
		$message = "Dear ".$data['name'].",";
		$message .= "<br>";
		$message .= "<br>";
		$message .= "We have initiated the setup of an organisation account on your behalf.";
		$message .= "<br>";
		$message .= "<br>";
		$message .= "Please <a href=".$link.">click</a> to complete the required details.";
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
		return $resp;
	}

	//Edit Organization Submission Listing
		function edit_organisation_submission($id = NULL){
		if($id){
			//$data = $this->organiser_model->view_organisation($id);
			$data = $this->set_organization_model->view_organisation($id);
			if(isset($data['0'])){
				//$payment_data = $this->organiser_model->get_payment_information($id);
				$payment_data = $this->set_organization_model->get_payment_information($id);
				$viewArr['payment_data'] = $payment_data;
				//$get_organisation_type=$this->organiser_model->get_organisation_type();
				$get_organisation_type=$this->set_organization_model->get_organisation_type();

				$viewArr['get_organisation_type'] = $get_organisation_type;

				$viewArr['data'] = $data['0'];

				$viewArr['viewPage'] = "organisation_submission_edit";
				$this->load->view('backend/layout', $viewArr);
			}else{
				//redirect('backend/organiser', 'refresh');
				redirect('set_organizations/index', 'refresh');
			}
		}else{
			redirect('set_organizations/index', 'refresh');
		}
	}

	//Save Organiser Submission
        function save_organiser_submission(){

		/**** validation rules for mandatory fields ****/
		// rules for main organiser contact details
		$this->form_validation->set_error_delimiters('<p style="color:red;">', '</p>');
		$this->form_validation->set_rules('title', 'title', 'trim|required|xss_clean');
		$this->form_validation->set_rules('salutation', 'salutation', 'trim|required|xss_clean');
		$this->form_validation->set_rules('first_name', 'first name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('last_name', 'last name', 'trim|required|xss_clean');

		$this->form_validation->set_rules('organisation_name', 'organisation name', 'trim|required|xss_clean');

		// 	validation for file upload parameters*/
			$this->form_validation->set_rules('logo', 'logo', 'callback_handle_upload_logo_sub');
			$this->form_validation->set_rules('bank_signature', 'bank signature', 'callback_handle_upload_signature_sub');
			$this->form_validation->set_rules('bank_statement', 'bank statement', 'callback_handle_upload_statement_sub');

		//validation for file upload for bank ticketsuits
		    $this->form_validation->set_rules('bank_attachment_for_ts', 'bank attachment for ts', 'callback_handle_upload_ticket_suite_statement_sub');


		if($this->form_validation->run() == FALSE){
			//echo validation_errors();exit;
            $data = $this->set_organization_model->view_organisation($this->input->post('organiser_id'));
			$viewArr['data'] = $data['0'];
			$payment_data = $this->set_organization_model->get_payment_information($this->input->post('organiser_id'));		$viewArr['payment_data'] = $payment_data;
			//$get_organisation_type=$this->organiser_model->get_organisation_type();
			$get_organisation_type=$this->set_organization_model->get_organisation_type();

			$viewArr['get_organisation_type'] = $get_organisation_type;
			$viewArr['viewPage'] = "organisation_submission_edit";
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

			$flo2_cash['payment_key'] = "flo2cash";
			$flo2_cash['payment_method'] = $this->input->post('flo2cash_method');
			$flo2_cash['reference_number'] = $this->input->post('flo2cash_reference');

			$dps['payment_key'] = "dps";
			$dps['payment_method'] = $this->input->post('dps_method');
			$dps['reference_number'] = $this->input->post('dps_reference');

			$poli['payment_key'] = "poli";
			$poli['payment_method'] = $this->input->post('poli_method');
			$poli['reference_number'] = $this->input->post('poli_reference');

			$alipay['payment_key'] = "alipay";
			$alipay['payment_method'] = $this->input->post('alipay_method');
			$alipay['reference_number'] = $this->input->post('alipay_reference');

			/* $result = $this->set_organization_model->update_payment_details($dynamic_payment,$organizer_unique_id);
			$result = $this->set_organization_model->update_payment_details($flo2_cash,$organizer_unique_id);
			$result = $this->set_organization_model->update_payment_details($dps,$organizer_unique_id);
			$result = $this->set_organization_model->update_payment_details($poli,$organizer_unique_id);
			$result = $this->set_organization_model->update_payment_details($alipay,$organizer_unique_id);

			*/
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

			//$organiser_id = $this->organiser_model->save_organiser($data);
			$organiser_id = $this->set_organization_model->save_organiser_sub($data);
			//echo "<pre>";
			//print_r($organiser_id);
		//	echo "</pre>";
		//	exit;

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

			//echo "<pre>";
			//print_r($data);
			//echo "</pre>";
			//exit;

			//$result = $this->organiser_model->save_organiser_additional_details($data);
			$result = $this->set_organization_model->save_organiser_additional_details_sub($data);


		//	$textToStore = nl2br(htmlentities($inputText, ENT_QUOTES, 'UTF-8'));

			// organiser finance details
			$data = array(
				'organization_id' => $this->input->post('organiser_id'),
				'position' => $this->input->post('finance_position'),
				'first_name' => $this->input->post('finance_first_name'),
				'last_name' => $this->input->post('finance_last_name'),
				'phone' => $this->input->post('finance_phone'),
				'fax' => $this->input->post('finance_fax'),
				'email' => $this->input->post('finance_email'),
				'bank_name' =>  $this->input->post('bank_name'),
				'bank_name_for_ticket_suite' => $this->input->post('bank_name_for_ts'),
				'account_number_ticket_suite' => $this->input->post('bank_account_no_for_ts'),

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
				$this->send_status_email($email_status,$this->input->post('organiser_id'));
			}


			//$result = $this->organiser_model->save_organiser_finance_details($data);

			$result = $this->set_organization_model->save_organiser_finance_details_sub($data);
			$this->session->set_flashdata('message', 'Record updated successfully');
			//redirect('backend/organiser', 'refresh');
			redirect('backend/set_organizations/index', 'refresh');
		}
	}

	function handle_upload_signature_sub(){
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
	function handle_upload_statement_sub(){
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
	function handle_upload_ticket_suite_statement_sub(){
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
	function handle_upload_logo_sub(){
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

	function sent_charity_to_pending(){
		if($_POST){
			$org_id = $_POST['organiser_id'];
			$data =  $this->set_organization_model->mark_org_as_complete($org_id);

			echo "1";
		}else{
			echo "1";
		}
	}

	function sent_status_email(){
		// get field based on charity id
		$data =  $this->set_organization_model->get_charity_details($_POST['event_id']);

		$link = $this->config->item("organizer_set_up")."/".md5($data['email']);
		$this->load->library('email');
		$this->email->from('quagnitia.testuser1@gmail.com', 'TicketingSystem');
		$this->email->to($data['email']);
		$this->email->set_mailtype("html");
		$this->email->subject('TicketingSystem | Organization | Set Up');
		$message = "Dear ".$data['first_name'];
		$message .= "<br>";$message .= "<br>";
		$message .= "Your organization setup details are incomplete.";
		$message .= "<br>";
		$message .= "<br>";
		$message .= "Kindly update your details on the online application form by clicking this <a href=".$link.">link</a>";
		$message .= "<br>";
		$message .= "<br>";
		$message .= "Once you have completed the online application form the application will automatically be placed in a que for approval by TicketingSystem. ";
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
		echo $resp;
	}
}



?>