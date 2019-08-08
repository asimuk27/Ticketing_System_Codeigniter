<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

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
		$this->load->library(array('form_validation','session','pagination'));
		$this->load->helper(array('form', 'url', 'file'));
		$this->load->model('frontend/event_model');
		$this->load->model('frontend/banner_model');
		$passArg = array();						
	} 
	
	function index(){
		$get_banner_images = $this->banner_model->get_banner_images();
		$viewArr['get_banner_images'] = $get_banner_images;
		
		$data = $this->event_model->live_events();
		$viewArr['data'] = $data;
		$viewArr['viewPage'] = "main_page";
		$this->load->view('frontend/layout', $viewArr); 
	}
		
	/* function get_events(){		
		$data = $this->event_model->live_events();
		
	} */
	
	function cron_job_for_closed_event_check(){
		// check for event expiry date
		$this->event_model->cron_job_for_closed_event_check();
	}
	
	function search_events($query_string = NULL){		
		//$this->cron_job_for_closed_event_check();		
		if(isset($_POST) && (!empty($_POST))){
			$search_values = $_POST;			
				
			$totalRec = $this->event_model->get_all_events_count($search_values);
			
			//pagination configuration
			$config['first_link']  = 'First';
			$config['div']         = 'postList'; //parent div tag id
			$config['base_url']    = base_url().'index.php/frontend/events/index';
			$config['total_rows']  = $totalRec;
			$config['per_page']    = 20;
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
			$viewArr['total_records'] = $totalRec;
			$viewArr['listing_data'] = $this->event_model->get_all_events($config["per_page"], $page, $search_values);		

			$viewArr['category_data'] = $this->event_model->get_event_categories();
						
			
		$viewArr['viewPage'] = "event_listing";
		$this->load->view('frontend/layout', $viewArr); 
			
		}else if($query_string){
			$data = array();
			$data['category_name'] = "";
			$data['event_name'] = "";
			$data['event_location'] = "";
			$data['search_by_date'] = "";
			if($query_string == 'sport'){
				$data['category_name'] = "1";
			}else if($query_string == 'music'){
				$data['category_name'] = "2";
			}else if($query_string == 'auckland'){
				$data['event_location'] = "auckland";
			}else if($query_string == 'sydney'){
				$data['event_location'] = "sydney";
			}else if($query_string == 'entertainment'){
				$data['category_name'] = "3";
			}else if($query_string == 'games'){
				$data['category_name'] = "4";
			}else{
				redirect('frontend/home', 'refresh');
			}
			
			$search_values = $data;			
			$_POST = $data;	
			$totalRec = $this->event_model->get_all_events_count($search_values);
			
			//pagination configuration
			$config['first_link']  = 'First';
			$config['div']         = 'postList'; //parent div tag id
			$config['base_url']    = base_url().'index.php/frontend/events/index';
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
			$viewArr['total_records'] = $totalRec;
			$viewArr['listing_data'] = $this->event_model->get_all_events($config["per_page"], $page, $search_values);		

			$viewArr['category_data'] = $this->event_model->get_event_categories();
						
			$viewArr['viewPage'] = "event_listing";
			$this->load->view('frontend/layout', $viewArr); 
			
		}else{
			redirect('frontend/home', 'refresh');
		}
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */