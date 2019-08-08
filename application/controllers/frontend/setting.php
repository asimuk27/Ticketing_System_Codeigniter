<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setting extends CI_Controller {

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
		$this->load->library(array('form_validation','session','pagination'));
		$this->load->helper(array('form', 'url', 'file'));
		$passArg = array();						
	} 
		
	function index(){
		$this->load->library('email');
		$this->email->from('darshan.more@quagnitia.com', 'darshan');
		$this->email->to('darshansmore@gmail.com'); 
		$this->email->subject('Email Test');
		$this->email->message('Testing the email class.');				
		$result = $this->email->send();
		
		echo $result;
	}
	

	function get_sql_status(){
		$this->load->model('frontend/settings_model');
		echo $this->settings_model->get_sql_status();		
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */