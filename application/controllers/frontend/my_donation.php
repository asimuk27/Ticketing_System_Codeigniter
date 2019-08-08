<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class My_donation extends CI_Controller {

	/**
	 * Index Page for this controller.
	 * 
	**/
	function __construct(){
		parent::__construct();		
		//Load all required classes		

		$this->load->library(array('form_validation','session','pagination'));
		$this->load->helper(array('form', 'url', 'file'));
		$this->load->model('frontend/my_donation_model');
		$passArg = array();						
	}

	function index(){	
		if(isset($_POST['per_page']) && ($_POST['per_page'] != "")){
			$config['per_page'] = $_POST['per_page'];
			$page_count = $_POST['per_page'];
		}else{
			$page_count = 20;
			$config['per_page'] = 20;
		}
		
		if(isset($_POST) && (!empty($_POST))){
			$search_values = $_POST;						
		}else{
			$search_values = array();
			$search_values['search_by_order_id'] = "";
			$search_values['search_by_transact_id'] = "";
		}
		$totalRec = $this->my_donation_model->get_my_donation_count($search_values);
		
		//pagination configuration
        $config['first_link']  = 'First';
        $config['div']         = 'postList'; //parent div tag id
        $config['base_url']    = base_url().'index.php/frontend/my_donation/index';
        $config['total_rows']  = $totalRec;
        $config["uri_segment"] = 4; 	
		$choice = $config["total_rows"] / $config["per_page"];
		$config["num_links"] = 3;
		
		//config for bootstrap pagination class integration
        $config['full_tag_open'] = '<ul class="pagination" style="float:left;">';
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
		$viewArr['data'] = $this->my_donation_model->get_my_donation($config["per_page"], $page,$search_values);
		
		$viewArr['viewPage'] = "my_donations";
		$this->load->view('frontend/layout', $viewArr); 
	}
	
	function view_donation_details($id = NULL){
		$viewArr['data'] = $this->my_donation_model->view_my_donations($id);
		
		/* echo "<pre>";
		print_r($viewArr);
		exit; */
		
		$viewArr['viewPage'] = "view_my_donations";
		$this->load->view('frontend/layout', $viewArr); 
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */