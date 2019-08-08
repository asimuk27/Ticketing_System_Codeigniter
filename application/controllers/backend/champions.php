<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Champions extends CI_Controller {

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
		$this->load->model('backend/champion_model');
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
		//$this->output->enable_profiler(TRUE);	
	} 
	
	public function check_valid_roles(){
		if(isset($this->session->userdata['admin_logged_in']['user_roles'])){
			$data_modules = $this->session->userdata['admin_logged_in']['user_roles'];
			$allowed_modules = explode(",",$data_modules);
			
			if(in_array("manage_champions",$allowed_modules)){
				return false;
			}else{
				return true;	
			}
		}else{
			return true;
		}
	}
	
	public function index(){
		// Display output page			
		
		if(isset($_POST) && ($_POST != "")){
			$search_values = $_POST;			
		}else{
			$search_values = array();	
			$viewArr['selected_filter'] = "";
		}
		
		$totalRec = $this->champion_model->get_all_champion_count($search_values);
		
		//pagination configuration
        $config['first_link']  = 'First';
        $config['div']         = 'postList'; //parent div tag id
        $config['base_url']    = base_url().'index.php/backend/champions/index';
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
		$viewArr['listing_data'] = $this->champion_model->get_all_champion($config["per_page"], $page, $search_values);
		
		$viewArr['viewPage'] = "champion_listing";
		$this->load->view('backend/layout', $viewArr); 
	}
	
	public function popular_champions(){
		$data = $this->champion_model->popular_champions();
		$viewArr['data'] = $data;
		$viewArr['viewPage'] = "popular_champions";
		$this->load->view('backend/layout', $viewArr); 
	}

	public function check_champion_validity(){
		//post
		if($_POST['champion_id']){
			$data = $this->champion_model->check_active_champion_clause($_POST['champion_id']);			
			if(!empty($data)){
				echo "1";exit;
			}else{
				echo "0";exit;
			}
		}else{
			echo "0";exit;
		}
	}


	public function save_popular_champions(){
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
			$total_rec = $this->champion_model->update_popular_champions($data);
			
			
			$this->session->set_flashdata('message', 'popular champions records updated successfully');			
			redirect('backend/champions/popular_champions', 'refresh');		
			//print_r($data);
		}else{
			
			$this->popular_champions();
		}		
	}

	public function view_champion($id)
	{
		$data=$this->champion_model->fetch_champion_records($id);
		
		if(isset($data['0'])){
			$viewArr['listing_data'] = $data['0'];
		}else{
			$viewArr['listing_data'] = array();
			redirect('backend/champions', 'refresh');	
		}		
		$viewArr['viewPage'] = "view_fundraising_page";
		$this->load->view('backend/layout', $viewArr);
		
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */