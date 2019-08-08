<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Events extends CI_Controller {

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
		$this->load->model('backend/event_model');
		$this->load->model('backend/organiser_model');
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
			
			if(in_array("manage_events",$allowed_modules)){
				return false;
			}else{
				return true;	
			}
		}else{
			return true;
		}
	}
	
	public function set_popular_events(){
		$viewArr['viewPage'] = "popular_events";
		$this->load->view('backend/layout', $viewArr); 
	}
	
	public function popular_events(){
		$data = $this->event_model->popular_events();
		$viewArr['data'] = $data;
		$viewArr['viewPage'] = "popular_events";
		$this->load->view('backend/layout', $viewArr); 
	}
	
	public function preview_popular_events(){
		$data = $this->event_model->live_events();
		$viewArr['data'] = $data;
		$viewArr['viewPage'] = "preview_popular_events";
		$this->load->view('backend/layout', $viewArr); 
	}
	
	public function save_popular_events(){
		if($_POST){			
			// build data array
			$data = array(
				'1' => $this->input->post('popular_1'),
				'2' => $this->input->post('popular_2'),
				'3' => $this->input->post('popular_3'),
				'4' => $this->input->post('popular_4'),
				'5' => $this->input->post('popular_5'),
				'6' => $this->input->post('popular_6'),
				'7' => $this->input->post('popular_7'),
				'8' => $this->input->post('popular_8'),
				'9' => $this->input->post('popular_9'),
			);			
			//update popular events
			$total_rec = $this->event_model->update_popular_events($data);
			
			$this->session->set_flashdata('message', 'popular event records updated successfully');			
			redirect('backend/events/popular_events', 'refresh');		
			//print_r($data);
		}else{
			$this->popular_events();
		}		
	}
	
	public function check_event_validity(){
		//post
		if($_POST['event_id']){			
			$data = $this->event_model->check_active_event_clause($_POST['event_id']);			
			if(!empty($data)){
				echo "1";exit;
			}else{
				echo "0";exit;
			}
		}else{
			echo "0";exit;
		}
	}
	
	public function index(){
		// Display output page	

		if(isset($_POST) && (!empty($_POST))){
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
		
		$totalRec = $this->event_model->get_all_users_count($search_values);
				
		//pagination configuration
        $config['first_link']  = 'First';
        $config['div']         = 'postList'; //parent div tag id
        $config['base_url']    = base_url().'index.php/backend/events/index';
        $config['total_rows']  = $totalRec;
       // $config['per_page']    = 10;
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
		$viewArr['listing_data'] = $this->event_model->get_all_users($config["per_page"], $page, $search_values);
		
		$viewArr['categories'] = $this->event_model->get_categories();
		$viewArr['viewPage'] = "event_listing";
		$this->load->view('backend/layout', $viewArr); 
	}
	
	function view_event_details($id){
		$event_info = $this->event_model->get_event_details($id);
		//echo json_encode($event_info);
		$organisation_info = $this->organiser_model->get_organiser_details($event_info['0']['organiser_id']);
	
		if($organisation_info){
			$viewArr['organisation_info'] = $organisation_info;
		}else{
			$viewArr['organisation_info'] = "";
		}
		$viewArr['event_info'] = $event_info;
		// get sub event info
		$viewArr['sub_event_info'] = $this->event_model->get_sub_event_by_event_id($id);
						
		$viewArr['viewPage'] = "view_event_details";
		$this->load->view('backend/layout', $viewArr);
	}
	
	function set_event_as_popular(){
		$queryResult = $this->event_model->set_popular_events($_POST['event_id']);
		echo $queryResult;exit;
	}
	
	function disable_event_as_popular(){
		$queryResult = $this->event_model->disable_popular_events($_POST['event_id']);
		echo $queryResult;exit;
	}
	
	function set_event_as_active(){
		$queryResult = $this->event_model->set_active_events($_POST['event_id']);
		echo $queryResult;exit;
	}
	function set_event_as_inActive(){
		$queryResult = $this->event_model->set_inActive_events($_POST['event_id']);
		
				
		echo "1";exit;
	}
	
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */