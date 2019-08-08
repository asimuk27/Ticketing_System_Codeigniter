<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

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
		$this->load->model('backend/login_model');
		$this->load->library(array('form_validation','session'));
		$this->load->helper(array('form', 'url'));
		$passArg = array();	
		
	} 
	
	public function my_profile(){
		if(isset($this->session->userdata['admin_logged_in'])){
			$id = $this->session->userdata['admin_logged_in']['id'];
			
			$result = $this->login_model->get_admin_profile($id);
		
			// build output data array
			$data = array();
			$data['name'] = $result->name;
			$data['username'] = $result->username;
			$data['email'] = $result->email;
			
			$viewArr['listing_data'] = $data;		
			$viewArr['viewPage'] = "my_profile";
			$this->load->view('backend/layout', $viewArr); 
		}else{
			$this->load->view('backend/login');
		}		
	}
	
	public function change_password(){
		$viewArr['viewPage'] = "change_password";
		$this->load->view('backend/layout', $viewArr); 
	}
	
	public function save_change_password(){
		$this->form_validation->set_rules('current_password', 'current password', 'trim|required|xss_clean|callback_check_password');
		$this->form_validation->set_rules('new_password', 'new password', 'trim|required|xss_clean');
		$this->form_validation->set_rules('confirm_password', 'confirm password', 'trim|required|xss_clean');
		
		if($this->form_validation->run() == FALSE){
			$viewArr['viewPage'] = "change_password";
			$this->load->view('backend/layout', $viewArr);
		}else{
			// call model function to update password
			$result = $this->login_model->update_password($this->input->post('new_password'));
			
			$this->session->set_flashdata('message', 'Password successfully updated');
			redirect('backend/login/change_password', 'refresh');
			
		}
	}
	
	public function save_profile(){
		if($_POST){
			// update admin profile
			$result = $this->login_model->update_my_profile($_POST['name']);  
			
			$this->session->set_flashdata('message', 'Profile details successfully updated');
			redirect('backend/login/my_profile', 'refresh');			
		}else{
			$this->load->view('backend/login');
		}
	}
	
	// function check current password when user uses change password functionality
	public function check_password($password){		
		$result = $this->login_model->check_login_user_password($password);		
		if($result){
			return true;
		}else{
			$this->form_validation->set_message('check_password', 'Invalid username or password');
			return false;
		}		
	}
	
	public function index(){
		if(isset($this->session->userdata['admin_logged_in'])){
			redirect('backend/dashboard', 'refresh');			
		}
		$this->load->view('backend/login');
	}
	
	public function check_login(){		
		$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
		$this->form_validation->set_rules('pwd', 'Password', 'trim|required|xss_clean|callback_check_database');
		
		if($this->form_validation->run() == FALSE){
			//Field validation failed.User redirected to login page
			$this->load->view('backend/login');			
		}else{			
			//Go to private area
			$data = $this->session->userdata['admin_logged_in'];	
			redirect('backend/dashboard', 'refresh');			
		}		
	}

	
	//function to check login details into database.
	function check_database($password){
		//Field validation succeeded.  Validate against database
		$username = $this->input->post('email'); 		
	
		//query the database
		$result = $this->login_model->check_login($username, $password);  
  
		if($result){	
			// check if account is under approval
			$data = $this->login_model->check_login_approval($username);

			if(!empty($data)){
				$this->form_validation->set_message('check_database', 'This account is not yet approved. For any queries use contact us form');
				return false;
			}else{								
				//call function to set respective sessions
				$output = $this->create_user_session($result['0']);			
				if($output){
					return true;
				}else{
					return false;
				}
			}						
		}else{
			$this->form_validation->set_message('check_database', 'Please enter valid old password');
			return false;
		}
	}
	
	// function to create user session-
	function create_user_session($user_data){		  
		
		// find different role name based on id		
		if($user_data->roles){
			$data_result = $this->login_model->get_roles_by_id($user_data->roles);
		}else{
			$data_result['roles'] = array();
		}		
				  
		$sess_array = array(
		    'id' => $user_data->id,
			'email' => $user_data->email,			
			'last_login' => $user_data->last_login,
			'user_roles' => $data_result['roles']
		);
		
		// update last login date & time
		$data = $this->login_model->update_last_login($user_data->email);
		
		$this->session->set_userdata('admin_logged_in', $sess_array);
		return true;
	}
	
	function logout(){		
		$this->session->unset_userdata('admin_logged_in');
		redirect($this->config->item('login_url'), 'refresh');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */