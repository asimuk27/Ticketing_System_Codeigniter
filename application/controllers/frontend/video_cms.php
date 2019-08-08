<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Video_cms extends CI_Controller {

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
		$this->load->model('frontend/video_cms_model');
		$this->load->library(array('form_validation','session','pagination'));
		$this->load->helper(array('form', 'url', 'file'));
		$this->load->library('email');
		$passArg = array();						
	}

	function index(){
		$viewArr['data']=$this->video_cms_model->get_video_categories();
		$viewArr['viewPage'] = "video_list";
		$this->load->view('frontend/layout', $viewArr); 
	}

	function get_content($id=null){
		$get_data=$this->video_cms_model->get_content($id);
		echo htmlspecialchars_decode(stripslashes($get_data['content']));
	}
}

?>