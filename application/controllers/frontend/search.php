<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Controller {

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
		//$get_banner_images = $this->event_model->get_event();
		//$viewArr['get_banner_images'] = $get_banner_images;
		
		
	
		$data = $this->event_model->get_srch_det($_POST['srch']);
		$viewArr['data'] = $data;
		$viewArr['viewPage'] = "main_page";
		$this->load->view('frontend/layout', $viewArr); 
	}
		
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */