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
		$this->load->model('frontend/organiser_model');
		$this->load->library(array('form_validation','session','pagination'));
		$this->load->helper(array('form', 'url', 'file'));
		$passArg = array();						
	} 
	
	function index(){
		if(isset($this->session->userdata['logged_in'])){
			 redirect("frontend/home/index");
		}
	}	
	
	function organization_set_up_save(){
		$viewArr['viewPage'] = "organisation_set_up_save";
		$this->load->view('frontend/layout', $viewArr); 
	}
	
	function view_profile(){		
		if(isset($this->session->userdata['logged_in']['id'])){	

			if($this->session->userdata['logged_in']['login_type'] == 0){
				 redirect('frontend/home', 'refresh');
			}            
		
			$id = $this->session->userdata['logged_in']['id'];			
			$data = $this->organiser_model->get_organisation_details_by_id($id);				
			$viewArr['data'] = $data;	
			$viewArr['viewPage'] = "organisation_view";
			$this->load->view('frontend/layout', $viewArr);	
		}else{
			redirect('frontend/home', 'refresh');
		}	
	}

	function edit_profile(){
		if(isset($this->session->userdata['logged_in']['id'])){			
			if($this->session->userdata['logged_in']['login_type'] == 0){
				 redirect('frontend/home', 'refresh');
			}  
			
			$id = $this->session->userdata['logged_in']['id'];			
			
			$data = $this->organiser_model->get_organisation_details_by_id($id);
			$get_organisation_type=$this->organiser_model->get_organisation_type();
		
		$viewArr['get_organisation_type'] = $get_organisation_type;	
			$viewArr['data'] = $data;	
			$viewArr['viewPage'] = "organisation_edit";
			$this->load->view('frontend/layout', $viewArr);	
		}else{
			redirect('frontend/home', 'refresh');
		}
	}
	
	function update_organization_details(){
		
		
		
		if(isset($this->session->userdata['logged_in']['id'])){			
			if($this->session->userdata['logged_in']['login_type'] == 0){
				 redirect('frontend/home', 'refresh');
			} 
		}
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
		$this->form_validation->set_rules('organization_name', 'organization_name name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('charity_name', 'charity name', 'trim|required|xss_clean');

		//organisation financial contact details
		$this->form_validation->set_rules('finance_position', 'finance position', 'trim|xss_clean');
		$this->form_validation->set_rules('finance_first_name', 'finance first name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('finance_last_name', 'finance last name', 'trim|required|xss_clean');
	//	$this->form_validation->set_rules('finance_email', 'finance email', 'trim|required|xss_clean|valid_email|is_unique[organization_finance_contact.email]');

		
		// organisation bank details			
		/*$this->form_validation->set_rules('bank_name', 'bank name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('bank_details', 'bank details', 'trim|required|xss_clean');*/
		


		
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
		
		// validation for file upload parameters
		$this->form_validation->set_rules('logo', 'logo', 'callback_handle_upload_logo');
		
		$this->form_validation->set_rules('bank_signature', 'bank signature', 'callback_handle_upload_signature');
	//	$this->form_validation->set_rules('bank_statement', 'bank statement', 'callback_handle_upload_statement');
				
		if($this->form_validation->run() == FALSE){
		//	echo validation_errors();		
			$id = $this->session->userdata['logged_in']['id'];			
			$data = $this->organiser_model->get_organisation_details_by_id($id);				
			$viewArr['data'] = $data;
			$viewArr['viewPage'] = "organisation_edit";
			$this->load->view('frontend/layout', $viewArr);
		}else{
			if($this->input->post('areas') != ""){
				$areas = $this->input->post('areas');				
				$org_areas = implode (",", $areas);
			}else{
				$org_areas = "";
			}
			
			// organizer main details
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
				'preferred_name' => $this->input->post('preferred_name'),
				'last_name' => $this->input->post('last_name'),
				'email' => $this->input->post('email'),
				'phone' => $this->input->post('phone'),
				'fax' => $this->input->post('fax'),
			);
			
			
			$organiser_id = $this->organiser_model->update_organiser($data);
			
			// organiser additional details
			$data = array(				
				'organization_id' => $this->input->post('organiser_id'),
				'organization_name' => $this->input->post('organization_name'),
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
			
			
			$result = $this->organiser_model->update_organiser_additional_details($data);
			
			// organiser finance details
			$data = array(
				'organization_id' => $this->input->post('organiser_id'),
				'position' => $this->input->post('finance_position'),
				'first_name' => $this->input->post('finance_first_name'),
				'last_name' => $this->input->post('finance_last_name'),				
				'phone' => $this->input->post('finance_phone'),
				'fax' => $this->input->post('finance_fax'),
				'email' => $this->input->post('finance_email'),
				/*'bank_name' =>  $this->input->post('bank_name'),
				'bank_details' => $this->input->post('bank_details'),*/
				'receipt_text' => $this->input->post('receipt_text'),
				'signature_text' => $this->input->post('sig_txt'),
				'signature' =>  $this->input->post('old_signature'),				
			); 		

			//echo "<pre>";
			//print_r($data);
			//exit;
			
			$result = $this->organiser_model->update_organiser_finance_details($data);
			redirect('frontend/organiser/view_profile', 'refresh');
		}
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
		$config['allowed_types'] = 'gif|jpg|png';		
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

	function statastics($event_id){

		if($_POST){
           $search_id=$this->input->post('search');

           if($search_id=='all'){
           	 redirect('frontend/organiser/statastics/'.$event_id.'', 'refresh');
           }
            $get_all_tickets=$this->organiser_model->get_all_tickets_on_subevents($search_id);
            $get_event_info=$this->organiser_model->get_event_info($event_id);
           	$get_event_tickets=$this->organiser_model->get_event_tickets_on_subevents($search_id);
			//$get_donations=$this->organiser_model->get_donations_on_subevents($search_id);
			$get_free_tickets=$get_all_tickets['free'];
			$get_paid_tickets=$get_all_tickets['paid'];
			$get_donation_tickets=$get_all_tickets['donation'];
			$get_pending_tickets=$this->organiser_model->get_pending_tickets_on_subevents($search_id); 

			$ticket_sales=0;
			$donations=0;
			if(!empty($get_event_tickets)){
               foreach($get_event_tickets as $val){
			    $ticket_sales=$ticket_sales+$val['price'];
			    }

			}
			
             
          
            $gross_sales=$ticket_sales;
			$viewArr['viewPage'] = "statastics";
			$viewArr['data'] = array('ticket_sales'=>$ticket_sales, 'gross_sales'=>$gross_sales,'get_free_tickets'=>$get_free_tickets,'get_paid_tickets'=>$get_paid_tickets, 'get_donation_tickets'=>$get_donation_tickets);
            $viewArr['get_event_info']=$get_event_info;
            $set_dropdown_data=$this->organiser_model->set_dropdown_data($event_id);
		    $viewArr['set_dropdown_data']=$set_dropdown_data;
			$viewArr['get_pending_tickets']=$get_pending_tickets;
		    $this->load->view('frontend/layout', $viewArr);	
			


		}else{
			$get_all_tickets=$this->organiser_model->get_all_tickets($event_id);
			//print_r($get_all_tickets);exit;
            $get_event_info=$this->organiser_model->get_event_info($event_id);
            //print_r($get_event_info);exit;
			$get_event_tickets=$this->organiser_model->get_event_tickets($event_id);
			//$get_donations=$this->organiser_model->get_donations($event_id);
			$get_free_tickets=$get_all_tickets['free'];
			$get_paid_tickets=$get_all_tickets['paid'];
			$get_donation_tickets=$get_all_tickets['donation'];
			$get_pending_tickets=$this->organiser_model->get_pending_tickets($event_id);


			//print_r($get_pending_tickets);exit;
			
			
			$ticket_sales=0;
			$donations=0;
			if(!empty($get_event_tickets)){
               foreach($get_event_tickets as $val){
			    $ticket_sales=$ticket_sales+$val['price'];
			    }

			}
			
        /*     
            if(!empty($get_donations)){
            	foreach($get_donations as $val2){
			    $donations=$donations+$val2['donation_amount'];
			    }
            }
			*/


			$gross_sales=$ticket_sales;
			$viewArr['viewPage'] = "statastics";
			$viewArr['data'] = array('ticket_sales'=>$ticket_sales, 'gross_sales'=>$gross_sales,'get_free_tickets'=>$get_free_tickets,'get_paid_tickets'=>$get_paid_tickets, 'get_donation_tickets'=>$get_donation_tickets);
            
            $set_dropdown_data=$this->organiser_model->set_dropdown_data($event_id);
		    $viewArr['set_dropdown_data']=$set_dropdown_data;
			$viewArr['get_pending_tickets']=$get_pending_tickets;
			$viewArr['get_event_info']=$get_event_info;
		    $this->load->view('frontend/layout', $viewArr);			
		}
	}

	public function get_terms_and_conditions($key){
		$get_terms_and_conditions=$this->organiser_model->get_terms_and_conditions($key);
		echo json_encode($get_terms_and_conditions);exit;
	}
	
	public function change_organizer_password(){
		//echo "I am in organiser controller";exit;
		if(isset($this->session->userdata['logged_in'])){
			$viewArr['viewPage'] = "change_organizer_password";
			$this->load->view('frontend/layout', $viewArr);
		}else{
			 redirect('frontend/home', 'refresh');
		}
	}
	
	public function organiser_save_change_password(){
		$this->form_validation->set_rules('current_password', 'current password', 'trim|required|xss_clean|callback_check_password');
		$this->form_validation->set_rules('new_password', 'new password', 'trim|required|xss_clean');
		$this->form_validation->set_rules('confirm_password', 'confirm password', 'trim|required|xss_clean');

		if($this->form_validation->run() == FALSE){
			$viewArr['viewPage'] = "change_organizer_password";
			$this->load->view('frontend/layout', $viewArr);
		}else{
			// call model function to update password
			$result = $this->organiser_model->update_password($this->input->post('new_password'));
			$this->session->set_flashdata('message', 'Password successfully updated');
			redirect('frontend/organiser/change_organizer_password', 'refresh');			
		}
	}
	
	// function check current password when user uses change password functionality
	public function check_password($password){		
		$result = $this->organiser_model->check_profile_org_password($password);		
		if($result){
			return true;
		}else{
			$this->form_validation->set_message('check_password', 'Please enter valid old password');
			return false;
		}		
	}
	
	function has_email_organiser(){
		$id = $this->input->post('id');
		$email = $this->input->post('email');
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
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */