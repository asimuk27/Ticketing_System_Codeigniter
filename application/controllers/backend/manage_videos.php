<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class manage_videos extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('backend/manage_cms_model');
		$this->load->library(array('form_validation','session','pagination'));
		$this->load->helper(array('form', 'url'));
		$passArg = array();
		if(!isset($this->session->userdata['admin_logged_in'])){
			redirect('backend/login', 'refresh');
		}

	}

	function index(){
		$viewArr['full_data'] = $this->manage_cms_model->video_listing();
		$viewArr['viewPage'] = "video_cms_listing";
        $this->load->view('backend/layout', $viewArr);
	}
	
	function add_page(){
        $viewArr['viewPage'] = "video_cms_add";
        $this->load->view('backend/layout', $viewArr);
	}

	function save(){
		if($_POST){
		    $this->form_validation->set_rules('content', 'Content', 'trim|required');
		    $this->form_validation->set_rules('category', 'Category', 'trim|required|is_unique[video_cms.category]');
		  	if($this->form_validation->run() == FALSE){				
				$viewArr['viewPage'] = "video_cms_add";
				$this->load->view('backend/layout', $viewArr);			
	    	}else{
				$get_content=$this->input->post('content');
	    		$get_content=preg_replace('#<[^>]+>#', ' ', $get_content);
                $string =  preg_replace('/\\s/','',$get_content);
				$data = array();
				$data['content'] = $this->input->post('content');
				$data['category'] = $this->input->post('category');
				$result = $this->manage_cms_model->insert_video_cms($data);
				if($result){
					$this->session->set_flashdata('message', 'CMS successfully added');
					redirect('backend/manage_videos', 'refresh');
				}		
		    } 
		}else{
			$this->index();
		}
	}

	

	function edit_page($id=null){
		if($id){
		$viewArr['data'] = $this->manage_cms_model->get_video_edit_data($id);
		$viewArr['viewPage'] = "edit_video_cms";
        $this->load->view('backend/layout', $viewArr);
		}else{
			$this->index();
		}
	}

	function update_video_cms(){
		if($_POST){
		    $this->form_validation->set_rules('content', 'Content', 'trim|required');
		   // $this->form_validation->set_rules('category', 'Category', 'trim|required');
		  	if($_POST['old_category']==trim($_POST['category'])){
                $this->form_validation->set_rules('category', 'Category', 'trim|required|xss_clean');
			}else{
                $this->form_validation->set_rules('category', 'Category', 'trim|required|xss_clean|is_unique[video_cms.category]');
			}

			$id = $this->input->post("cms_update");
		  	if($this->form_validation->run() == FALSE){
				$viewArr['data'] = $this->manage_cms_model->get_video_edit_data($id);
				$viewArr['viewPage'] = "edit_video_cms";
				$this->load->view('backend/layout', $viewArr);		
	    	}else{
	    		$get_content=$this->input->post('content');
	    		$get_content=preg_replace('#<[^>]+>#', ' ', $get_content);
                $string =  preg_replace('/\\s/','',$get_content);
				$data = array();				

				$data['content'] = $this->input->post('content');
				$data['category'] = $this->input->post('category');
				$result = $this->manage_cms_model->update_video_cms($data,$id);
				if($result){
					$this->session->set_flashdata('message', 'CMS successfully updated');
					redirect('backend/manage_videos', 'refresh');	
				}
		    } 
		}else{
			$this->index();
		}
	}


	public function delete_cms(){
		$id = "";
		$id=$this->input->post('cms_id');
		if($id){
			$result=$this->manage_cms_model->delete_cms($id);
			echo "1";exit;
		}else{
			echo "1";exit;
		}

	}

}







/* End of file welcome.php */



/* Location: ./application/controllers/welcome.php */

