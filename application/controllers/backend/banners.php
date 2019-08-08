<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Banners extends CI_Controller {

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
		$this->load->model('backend/banner_model');
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
			if(in_array("manage_banners",$allowed_modules)){
				return false;
			}else{
				return true;	
			}
		}else{
			return true;
		}
	}
	
	function delete_banner(){
		$this->banner_model->delete_banner($_POST['banner_id']);
		echo "1";exit;
	}
	
	function index(){
		$this->banner_listing();
	}
	
	function banner_listing(){
		$get_banner_list=$this->banner_model->get_banner_list();
	    $viewArr['viewPage'] = "banner_listing";
	    $viewArr['get_banner_list'] = $get_banner_list;
		$this->load->view('backend/layout', $viewArr); 
	}
	
	function add_banners(){
        $viewArr['viewPage'] = "add_banners";
		$this->load->view('backend/layout', $viewArr);
	}

	function save_banner(){
	//	$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
	//	$this->form_validation->set_rules('title', 'Event Title', 'trim|required|xss_clean');
		$this->form_validation->set_rules('imgInp', 'Image', 'trim|xss_clean|callback_handle_upload_image');
	//	$this->form_validation->set_rules('dt1', 'Start Date', 'trim|required|xss_clean');					
	//	$this->form_validation->set_rules('dt2', 'End Date', 'trim|required|xss_clean');					
		
		if($this->form_validation->run() == FALSE){				
			$viewArr['viewPage'] = "add_banners";
			$this->load->view('backend/layout', $viewArr);			
		}else{
			// organizer main details			
			$data = array(
			//	'event_name' => $this->input->post('title'),
			//	'start_date' => date("Y-m-d H:i:s", strtotime(str_replace("/", "-",$this->input->post('dt1')))),
			//	'end_date' => date("Y-m-d H:i:s", strtotime(str_replace("/", "-",$this->input->post('dt2')))),				
				'image_name' => $this->input->post('banner_image'),				
			);
						
			$event_id = $this->banner_model->save($data);
			
			$this->session->set_flashdata('message', 'Banner successfully added');
			redirect('backend/banners/index', 'refresh');			
		}		
	}
	
	
	// check for image logo upload
	function handle_upload_image(){
		$config = array();
		$config['upload_path']   = './assets/image_uploads/banner_images';
		$config['allowed_types'] = 'gif|jpg|png';
		
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		if (isset($_FILES['imgInp']) && !empty($_FILES['imgInp']['name'])){
			
			$image_info = getimagesize($_FILES["imgInp"]["tmp_name"]);
			$image_width = $image_info[0];			
			$image_height = $image_info[1];
			
			if(($image_width != '1920') && ($image_width != '650')){
				$this->form_validation->set_message('handle_upload_image', "Please use valid image dimension 1920X650");
				return false;
			}			
			
			if ($this->upload->do_upload('imgInp')){
				// set a $_POST value for 'image' that we can use later
				$upload_data    = $this->upload->data();
				$_POST['banner_image'] = $upload_data['file_name'];
				return true;
			}else{
				// possibly do some clean up ... then throw an error
				$this->form_validation->set_message('handle_upload_image', $this->upload->display_errors());
				return false;
			}
		} else {
			// throw an error because nothing was uploaded
			$this->form_validation->set_message('handle_upload_image', "You must upload an banner image!");
			return false;
		}
	}



}
?>