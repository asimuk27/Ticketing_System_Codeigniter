<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Password extends CI_Controller {

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
		$this->load->model('frontend/login_model');
		$this->load->model('frontend/password_model');
		$this->load->library(array('form_validation','session','pagination'));
		$this->load->helper(array('form', 'url', 'file'));
		$passArg = array();	

		if(isset($this->session->userdata['logged_in']))	
		{
			if($this->session->userdata['logged_in']['login_type'] != 0)
            redirect('frontend/home', 'refresh');
		}								
	} 

	function set_password($token = NULL){	
		if($token != ""){
			$viewArr['token'] = $token;
			$viewArr['viewPage'] = "reset_password";
			$this->load->view('frontend/layout', $viewArr);
		}else{
			 redirect('frontend/home', 'refresh');
		}		
	}
	
	function reset_password($token = NUll){
		if($token != ""){
			$viewArr['token'] = $token;
			$viewArr['viewPage'] = "reset_password_general";
			$this->load->view('frontend/layout', $viewArr);
		}else{
			 redirect('frontend/home', 'refresh');
		}
	}
	
	function save(){
		$viewArr['viewPage'] = "organisation_confirmed";
		$this->load->view('frontend/layout', $viewArr);
	}
	
	function save_general_pass(){
		$viewArr['viewPage'] = "reset_password_general";
		$this->load->view('frontend/layout', $viewArr);
	}
	
	function set_profile_password(){
	
	   $viewArr = array();
	   $this->form_validation->set_error_delimiters('<div style="color:red;">', '</div>');
	   $this->form_validation->set_rules('password', 'Password', 'required');
	   $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|xss_clean|matches[confirm_password]');
	   if($this->form_validation->run() == FALSE){  
			//echo validation_errors();		
			$viewArr['token'] = $this->input->post('token'); 
			$viewArr["viewPage"] = "reset_password_general";
			$this->load->view('frontend/layout',$viewArr);
	   }else{
		    $token = $this->input->post('token'); 				
			$result = $this->password_model->check_registered_users($token);		
			if($result){
				$email = $result['0']->id;
				$type =  $result['0']->login_type;		
				$newCode = $this->input->post('confirm_password');
						
				$res = $this->password_model->update_profile_password($email,$type,$newCode);
				 
				if($res){
					$this->session->set_flashdata('message', 'Password updated successfully, Please login using new password');
					redirect('frontend/login/index', 'refresh');
				}else{					
					$this->session->set_flashdata('message', 'Error in updating password please try again.');
					redirect('frontend/password/reset_password', 'refresh');
				}    
			}else{   
				$this->session->set_flashdata('message', 'Invalid token key used.');
				redirect('frontend/password/reset_password', 'refresh');
			}	
	   }  
	}
	
	function set_new_password(){	
	 
	   $viewArr = array();
	   $this->form_validation->set_error_delimiters('<div style="color:red;">', '</div>');
	   $this->form_validation->set_rules('password', 'Password', 'required');
	   $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|xss_clean|matches[confirm_password]');
	   
	   if($this->form_validation->run() == FALSE){  
			//echo validation_errors();
			$viewArr['token'] = $this->input->post('token'); 
			$viewArr["viewPage"] = "reset_password";
			$this->load->view('frontend/layout',$viewArr);
	   }else{
		    $token = $this->input->post('token'); 				
			$result = $this->password_model->isMd5EmailPresent($token);		
			if($result){
				$newCode = $this->input->post('confirm_password');
				$type = "1";				
				$res = $this->login_model->updatePswd($result,$type,$newCode);
				 
				if($res){
					$this->session->set_flashdata('message', 'Password updated successfully');
					redirect('frontend/password/save', 'refresh');
				}else{
					$this->session->set_flashdata('message', 'Error in updating password please try again.');
					redirect('frontend/password/save', 'refresh');
				}    
			}else{      
				$this->session->set_flashdata('message', 'Invalid token key used.');
				redirect('frontend/password/save', 'refresh');
			}	
	   }         
  }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */