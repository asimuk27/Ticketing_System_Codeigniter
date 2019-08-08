<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {

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
		$this->load->model('backend/user_model');
		$this->load->library(array('form_validation','session','pagination'));
		$this->load->helper(array('form', 'url'));
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
	
	public function check_valid_roles(){
		if(isset($this->session->userdata['admin_logged_in']['user_roles'])){
			$data_modules = $this->session->userdata['admin_logged_in']['user_roles'];
			$allowed_modules = explode(",",$data_modules);
			
			if(in_array("manage_individual_users",$allowed_modules)){
				return false;
			}else{
				return true;	
			}
		}else{
			return true;
		}
	}
	
	public function register_user()
	{
		$data = array(
       'first_name' => $this->input->post('first_name'),
       'last_name' => $this->input->post('last_name'),
       'preffered_name' => $this->input->post('preferred_name'),
       'email' => $this->input->post('email'),
       'phone_no' => $this->input->post('phone_no'),
       'password' => $this->input->post('password'),
       'login_type' => '',
       'street_address' => $this->input->post('street_address'),
       'suburb' => $this->input->post('suburb'),
       'city' => $this->input->post('city'),
       'postcode' => $this->input->post('postcode'),
       'country' => $this->input->post('country'),
       'created_date' => date("Y-m-d h:i:sa"),
       'last_login' => '',
        );

        $this->user_model->add_user($data);
	    $data['message'] = 'Data Inserted Successfully';
	            //Loading View
	    $this->load->view('backend/user_sign_up', $data);
	}
	
	public function index(){
		// Display output page	
		
		
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
			$page_count = 10;
			$config['per_page'] = 10;
		}
		
		$totalRec = $this->user_model->get_all_users_count($search_values);
		
		//pagination configuration
        $config['first_link']  = 'First';
        $config['div']         = 'postList'; //parent div tag id
        $config['base_url']    = base_url().'index.php/backend/users/index';
        $config['total_rows']  = $totalRec;
     //   $config['per_page']    = 10;
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
		$viewArr['listing_data'] = $this->user_model->get_all_users($config["per_page"], $page, $search_values);
		
		$viewArr['viewPage'] = "user_listing";
		$this->load->view('backend/layout', $viewArr); 
	}

	public function deactivate_user($user_id)
	{
	   $this->user_model->deactivate_user($user_id);
	   $this->session->set_flashdata('msg', 'Status has been updated');
	            //Loading View
	   redirect('backend/users/index','refresh');
       
	}

	public function update_user_status()
	{
	    $this->user_model->update_user_status($_POST['status'],$_POST['user_id']);
		echo "1";exit;
	  
       
	}

	public function user_view($user_id)
	{
			
	    $data = $this->user_model->get_viewing_contents($user_id);
        $viewArr['data']=$data;
       // print_r($viewArr['data']);exit;
		$viewArr['viewPage'] = "user_view";
		$this->load->view('backend/layout', $viewArr,$data); 
	}

	public function edit_user($user_id)
	{
		$data = $this->user_model->edit_user_record($user_id);
        $viewArr['data']=$data;
       // print_r($viewArr['data']);exit;
		$viewArr['viewPage'] = "edit_user_profile";
		$this->load->view('backend/layout', $viewArr,$data); 
	}


	

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */