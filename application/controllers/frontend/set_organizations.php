<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Set_organizations extends CI_Controller {

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

	public function set_up($id = NULL){
		if($id){
			$this->session->unset_userdata('logged_in');
			// check for valid email address
			$data_id = $this->organiser_model->get_email_by_key($id);

			// check if organization is marked as imcomplete
			$completion_status = $this->organiser_model->check_in_complete_status($data_id);

			if($completion_status){
				redirect('frontend/home', 'refresh');
			}

			if($data_id){
				$data = $this->organiser_model->get_organisation_details_by_id($data_id);
			}else{
				redirect('frontend/home', 'refresh');
			}

			$get_organiser_terms_n_conditions = $this->organiser_model->get_organiser_terms_n_conditions($data_id);
			$get_organisation_type=$this->organiser_model->get_organisation_type();
			$viewArr['get_organisation_type'] = $get_organisation_type;
			//echo "<pre>";
			//print_r($data);exit;
			$viewArr['data'] = $data;
			$viewArr['org_id'] = $data_id;
			$viewArr['t_n_c'] = $get_organiser_terms_n_conditions;

			$tc_status = $this->organiser_model->get_terms_check_status('tc',$data_id);
			$poli_status = $this->organiser_model->get_terms_check_status('poli_tc',$data_id);
			$direct_debit_status = $this->organiser_model->get_terms_check_status('direct_debit_tc',$data_id);
			$viewArr['t_n_c']=array('tc_status'=>$tc_status, 'poli_status'=>$poli_status, 'direct_debit_status'=>$direct_debit_status);

			$viewArr['viewPage'] = "organiser_edit_data";
			$this->load->view('frontend/layout', $viewArr);
		}else{
			redirect('frontend/home', 'refresh');
		}
	}

	public function update_organiser_through_url(){
       // echo "<pre>";
       // print_r($_POST);exit;
		$bank_status=$this->input->post('bank_details_for_ticket_suit');
		//echo $bank_status;exit;
////
		$this->form_validation->set_error_delimiters('<p style="color:red;">', '</p>');
		$this->form_validation->set_rules('title', 'title', 'trim|xss_clean');
		$this->form_validation->set_rules('salutation', 'salutation', 'trim|xss_clean');
		$this->form_validation->set_rules('first_name', 'first name', 'trim|xss_clean');
		$this->form_validation->set_rules('last_name', 'last name', 'trim|xss_clean');


		// rules for organisation details
		$this->form_validation->set_rules('organisation_name', 'organisation name', 'trim|xss_clean');

		//organisation financial contact details
		$this->form_validation->set_rules('finance_position', 'finance position', 'trim|xss_clean');
		$this->form_validation->set_rules('finance_first_name', 'finance first name', 'trim|xss_clean');
		$this->form_validation->set_rules('finance_last_name', 'finance last name', 'trim|xss_clean');
		$this->form_validation->set_rules('finance_email', 'finance email', 'trim|xss_clean|valid_email');

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
		$this->form_validation->set_rules('state', 'state', 'trim|xss_clean');
		$this->form_validation->set_rules('postal_code', 'postal code', 'trim|xss_clean');

		// validation for file upload parameters
		$this->form_validation->set_rules('logo', 'logo', 'callback_handle_upload_logo_url');
		$this->form_validation->set_rules('bank_signature', 'bank signature', 'callback_handle_upload_signature_url');
		$this->form_validation->set_rules('bank_statement', 'bank statement', 'callback_handle_upload_statement_url');
		$this->form_validation->set_rules('bank_attachment_for_ts', 'bank statement', 'callback_handle_upload_ticket_suite_statement_url');

		if($this->form_validation->run() == FALSE){
			$viewArr['viewPage'] = "organisation_updated";
			$this->load->view('frontend/layout', $viewArr);
		}else{

			if($this->input->post('areas') != ""){
				$areas = $this->input->post('areas');
				$org_areas = implode (",", $areas);
			}else{
				$org_areas = "";
			}

			$data = array(
				'id' => $this->input->post('organiser_id'),
				'title' => $this->input->post('title'),
				'areas' => $org_areas,
				'organization_nature' => $this->input->post('organization_nature'),
				'donee_status' => $this->input->post('donee_status'),
				'charities_commission' => $this->input->post('charities_commission'),
				'registration_number' => $this->input->post('registration_number'),
				'salutation' => $this->input->post('salutation'),
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'preferred_name' => $this->input->post('preferred_name'),
				'email' => $this->input->post('email'),
				'phone' => $this->input->post('phone'),
				'fax' => $this->input->post('fax'),
			);

			$data_r = $this->organiser_model->update_organiser($data);

			if(isset($_POST['tc'])){
				$tc = 1;
			}else{
				$tc = 0;
			}

			if(isset($_POST['poli_tc'])){
				$poli_tc = 1;
			}else{
				$poli_tc = 0;
			}

			if(isset($_POST['direct_debit_tc'])){
				$direct_debit_tc = 1;
			}else{
				$direct_debit_tc = 0;
			}



			$organiser_id = $this->input->post('organiser_id');
            $data_save_tc = array(
				'organizer_id' => $organiser_id,
				'key_name' => 'tc',
				'name' => 'Ticketsuit terms and conditions',
				'ip_address' => $_SERVER['REMOTE_ADDR'],
				'date' => date("Y-m-d"),
				'time' => date("g:i a"),
				'status' => $tc
			);

            $this->organiser_model->update_save_terms_n_conditions($data_save_tc);

            $data_save_poli_tc = array(
				'organizer_id' => $organiser_id,
				'key_name' => 'poli_tc',
				'name' => 'POLi  terms and conditions',
				'ip_address' => $_SERVER['REMOTE_ADDR'],
				'date' => date("Y-m-d"),
				'time' => date("g:i a"),
				'status' => $poli_tc
			);

            $this->organiser_model->update_save_terms_n_conditions($data_save_poli_tc);

            $data_save_direct_debit_tc = array(
				'organizer_id' => $organiser_id,
				'key_name' => 'direct_debit_tc',
				'name' => 'Ticketsuit direct debit authority',
				'ip_address' => $_SERVER['REMOTE_ADDR'],
				'date' => date("Y-m-d"),
				'time' => date("g:i a"),
				'status' => $direct_debit_tc
			);

            $this->organiser_model->update_save_terms_n_conditions($data_save_direct_debit_tc);

			// organizer main details
			$data = array(
				'id' => $this->input->post('organiser_id'),
				'title' => $this->input->post('title'),
				'areas' => $org_areas,
				'organization_nature' => $this->input->post('organization_nature'),
				'organization_name' => $this->input->post('organization_name'),
				'donee_status' => $this->input->post('donee_status'),
				'charities_commission' => $this->input->post('charities_commission'),
				'registration_number' => $this->input->post('registration_number'),
				'salutation' => $this->input->post('salutation'),
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'preferred_name' => $this->input->post('preferred_name'),
				'email' => $this->input->post('email'),
				'phone' => $this->input->post('phone'),
				'fax' => $this->input->post('fax'),
			);

			$organiser_id = $this->organiser_model->update_organiser($data);

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
				'region' => $this->input->post('state'),
				'postal_code' => $this->input->post('postal_code'),
				'country' =>  $this->input->post('country'),
			);

			$result = $this->organiser_model->update_organiser_additional_details($data);
			if($bank_status==1){
                $_POST['bank_name_for_ts']=$this->input->post('bank_name');
                $_POST['bank_account_no_for_ts']=$this->input->post('bank_details');

		       }
			// organiser finance details
			$data = array(
				'organization_id' => $this->input->post('organiser_id'),
				'position' => $this->input->post('finance_position'),
				'first_name' => $this->input->post('finance_first_name'),
				'last_name' => $this->input->post('finance_last_name'),
				'phone' => $this->input->post('finance_phone'),
				'fax' => $this->input->post('finance_fax'),
				'bank_name' =>  $this->input->post('bank_name'),
				'bank_details' => $this->input->post('bank_details'),
				'bank_statement' => $this->input->post('old_bank_statement'),
				'bank_name_for_ticket_suite' => $this->input->post('bank_name_for_ts'),
				'account_number_ticket_suite' => $this->input->post('bank_account_no_for_ts'),
				'bank_statement_ticket_suite' => $this->input->post('old_bank_ticket_suite_statement'),
				'receipt_text' => $this->input->post('recpt_txt'),
				'signature_text' => $this->input->post('sig_txt'),
				'signature' =>  $this->input->post('old_signature'),
				'plan_select' =>  $this->input->post('plan_select'),
			);

			$result = $this->organiser_model->update_organiser_finance_details($data);
			redirect('frontend/organiser/organization_set_up_save', 'refresh');

		}
	}



	// check for image logo upload
	function handle_upload_signature_url(){
		$config = array();
		$config['upload_path']   = './assets/image_uploads/signature';
		$config['allowed_types'] = 'gif|jpg|png';

		$this->load->library('upload', $config);
		$this->upload->initialize($config);

		if (isset($_FILES['bank_signature']) && !empty($_FILES['bank_signature']['name'])){
			if ($this->upload->do_upload('bank_signature')){
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
	function handle_upload_statement_url(){
		$config = array();
		$config['upload_path']   = './assets/image_uploads/bank_statement';
		$config['allowed_types'] = 'gif|jpg|png|pdf';
        $new_name = time().'_'.$_FILES["bank_statement"]['name'];
		$config['file_name'] = $new_name;

		$this->load->library('upload', $config);
		$this->upload->initialize($config);

		if (isset($_FILES['bank_statement']) && !empty($_FILES['bank_statement']['name'])){

			if ($this->upload->do_upload('bank_statement')){
				$upload_data    = $this->upload->data();
				$_POST['old_bank_statement'] = $upload_data['file_name'];
				return true;
			}else{
				$this->form_validation->set_message('handle_upload_statement', $this->upload->display_errors());
				return false;
			}
		}
	}
	//handle_upload_ticket_suite_statement

	// check for upload statement for TicketingSystem
	function handle_upload_ticket_suite_statement_url(){
		$config = array();
		$config['upload_path']   = './assets/image_uploads/bank_statement';
		$config['allowed_types'] = 'gif|jpg|png|pdf';
	    $bank_status=$this->input->post('bank_details_for_ticket_suit');

	    if($bank_status!=1){
			$new_name = time().'_'.$_FILES["bank_attachment_for_ts"]['name'];
			$config['file_name'] = $new_name;
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
	    }


		if (isset($_FILES['bank_attachment_for_ts']) && !empty($_FILES['bank_attachment_for_ts']['name'])){
            if($bank_status != 1){
               if ($this->upload->do_upload('bank_attachment_for_ts')){
				$upload_data    = $this->upload->data();
				 if($bank_status != 1){
                   $_POST['old_bank_ticket_suite_statement'] = $upload_data['file_name'];
				 }
				 else{
				 	$_POST['old_bank_ticket_suite_statement'] = $_POST['bank_statement'];
				 }

				return true;
			  }else{

				$this->form_validation->set_message('handle_upload_ticket_suite_statement', $this->upload->display_errors());
				return false;
			   }
            }
            else{
               $_POST['old_bank_ticket_suite_statement'] = $_POST['old_bank_statement'];
            }
		}else{
			$_POST['old_bank_ticket_suite_statement'] = $_POST['old_bank_statement'];
		}
	}

	// check for image logo upload
	function handle_upload_logo_url(){
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


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */