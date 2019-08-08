<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cms extends CI_Controller {

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
		$this->load->model('backend/cms_model');
		$this->load->library(array('form_validation','session','pagination'));
		$this->load->helper(array('form', 'url'));
		$passArg = array();	
		
	//	if(!isset($this->session->userdata['admin_logged_in'])){
		redirect('backend/login', 'refresh');					
	} 
	
	public function view_champ(){
		$viewArr['viewPage'] = "view_fundraising_page";
		$this->load->view('backend/layout', $viewArr); 
	}
	
	public function add_cms(){
		$data = array();
		$viewArr['viewPage'] = "add_cms";
		$this->load->view('backend/layout', $viewArr); 
	}
	
	public function edit_cms(){
		if($_GET['id'] && $_GET['id'] != ""){
			$id = $_GET['id'];
			$result_data = $this->cms_model->get_data_by_id($id);
			$viewArr['listing_data'] = $result_data;			
		}else{
			$id = "";
			// create blank data array	
			$viewArr['listing_data'] = array();
		}		
		$viewArr['viewPage'] = "add_cms";
		$this->load->view('backend/layout', $viewArr); 
	}
	
	public function save_cms(){
		
		$this->form_validation->set_rules('title', 'title', 'trim|required|xss_clean');

		if($this->input->post('id') == ""){
			$this->form_validation->set_rules('content_key', 'content key', 'trim|required|xss_clean|is_unique[cms.content_key]');
		}	
		if($this->form_validation->run() == FALSE){
			$viewArr['viewPage'] = "add_cms";
			$this->load->view('backend/layout', $viewArr);
		}else{
			// build data array
			$data = array();
			$data['id'] = $this->input->post('id');
			$data['title'] = $this->input->post('title');
			$data['content_key'] = $this->input->post('content_key');
			$data['content'] = $this->input->post('editor1');
			
			$result = $this->cms_model->save($data);
			
			if($result){
				$this->session->set_flashdata('message', 'page content successfully saved');
				redirect('backend/cms/index', 'refresh');	
			}else{
				$this->session->set_flashdata('message', 'page content successfully updated');
				redirect('backend/cms/index', 'refresh');	
			}			
		}
	}
	
	public function index(){
		// Display output page	
		$totalRec = $this->cms_model->get_all_users_count();
		
		//pagination configuration
        $config['first_link']  = 'First';
        $config['div']         = 'postList'; //parent div tag id
        $config['base_url']    = base_url().'index.php/backend/users/index';
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
		$viewArr['listing_data'] = $this->cms_model->get_all_users($config["per_page"], $page);
		
		$viewArr['viewPage'] = "cms_listing";
		$this->load->view('backend/layout', $viewArr); 
	}
	

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */