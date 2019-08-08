<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Donation_reports extends CI_Controller {

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
		$this->load->model('backend/donation_report_model');
		$this->load->library(array('form_validation','session','pagination'));
		$this->load->helper(array('form', 'url', 'file'));
		$passArg = array();
	}

	function index(){
		//$session_data = $this->session->userdata['logged_in'];
   // $event_list=$this->champion_model->list_events($session_data['id']);
		if(isset($_POST['per_page']) && ($_POST['per_page'] != "")){
			$config['per_page'] = $_POST['per_page'];
			$page_count = $_POST['per_page'];
		}else{
			$page_count = 20;
			$config['per_page'] = 20;
		}

		if(isset($_POST) && (!empty($_POST))){
			//print_r($_POST);exit;
			$search_values = $_POST;
		}else{
			$search_values = array();
			$search_values['searchby_org_id'] = "";
			$search_values['searchby_event_id'] = "";
			$search_values['searchby_sub_event_id'] = "";
	   	}
		     $totalRec = $this->donation_report_model->get_my_donation_count($search_values);
		    // echo "<pre>";print_r($totalRec);exit;
				 $config['first_link']  = 'First';
        $config['div']         = 'postList'; //parent div tag id
        $config['base_url']    = base_url().'index.php/backend/donation_reports/index';
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
		$viewArr['page_count'] = $page_count;
		$viewArr['total_records'] = $totalRec;
		$viewArr['organisers_list'] = $this->donation_report_model->get_all_organisers();
		$viewArr['data'] = $this->donation_report_model->get_my_donation($config["per_page"], $page,$search_values);
		
		$viewArr['viewPage'] = "donation_listing.php";
		$this->load->view('backend/layout', $viewArr);


	}

	public function get_charity_events($charity_id){
		$get_description=$this->donation_report_model->get_charity_events($charity_id);
		echo json_encode($get_description);
	}

	public function get_sub_events($event_id){
		$get_description=$this->donation_report_model->get_sub_events($event_id);
		echo json_encode($get_description);

	}

	public function view_details_donation($id = null)
	{
		$viewArr['data'] = $this->donation_report_model->view_data($id);
		
		///echo "<pre>";
		//print_r($viewArr);
		//echo "</pre>";
		//exit;
		$viewArr['viewPage'] = "donation_view.php";
		$this->load->view('backend/layout', $viewArr);
	}

	function export_csv(){
		
		if(isset($_POST) && (!empty($_POST))){
			$search_values = $_POST;
	  	}else{
			$search_values = array();
		     $search_values['searchby_org_id'] = "";
			$search_values['searchby_event_id'] = "";
			$search_values['searchby_sub_event_id'] = "";
	   	}

	  	$result = $this->donation_report_model->csv_download($search_values);

		if($result){

		}else{
			$this->session->set_flashdata('message', 'No records found');
			redirect('backend/donation_reports', 'refresh');
		}
	}
	
	public function refresh_listing(){
		redirect('backend/donation_reports/', 'refresh');
	}

}


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
