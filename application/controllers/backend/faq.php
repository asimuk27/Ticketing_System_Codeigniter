<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Faq extends CI_Controller {

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
		$this->load->model('backend/faq_model');
		$this->load->library(array('form_validation','session','pagination'));
		$this->load->helper(array('form', 'url'));
		$passArg = array();	
						
	} 
	
	function index(){
		// Display output page			
		$this->faq_list();
	}

	
	function faq_list(){
		$viewArr['listing_data'] = $this->faq_model->get_all_faqs();		
		$viewArr['viewPage'] = "faq_list";
		$this->load->view('backend/layout', $viewArr); 
	}
	
	function add_faq(){
		$viewArr['viewPage'] = "add_faq";
		$this->load->view('backend/layout', $viewArr); 
	}

	function save_faq(){	
		  if($_POST){
		  	$this->form_validation->set_rules('header_title', 'Header', 'trim|required|xss_clean');
			$this->form_validation->set_rules('content', 'Content', 'trim|required|xss_clean');
		    

		  	if($this->form_validation->run() == FALSE){
				$viewArr['viewPage'] = "add_faq";
				$this->load->view('backend/layout', $viewArr);
	    	}else{
	    		$get_content=$this->input->post('content');
	    		$get_content=preg_replace('#<[^>]+>#', ' ', $get_content);
                $string =  preg_replace('/\\s/','',$get_content);
	    		
			    if($string==''){
			  	
				$this->session->set_flashdata('error', 'please provide the content');
				redirect('backend/faq/add_faq', 'refresh');	
			    }
			// build data array
			$data = array();

			//$get_order_sequence=$this->cms_model->get_order_sequence();
			
			$data['header_title'] = $this->input->post('header_title');
			$data['content'] = $this->input->post('content');
			//$data['order_sequence'] = $get_order_sequence+1;
			
			$result = $this->faq_model->save_faq($data);
			
			  if($result){
				$this->session->set_flashdata('message', 'Faq successfully saved');
				redirect('backend/faq/faq_list', 'refresh');	
			    }		
		      }
		  	 
		  }else{
		  	redirect('backend/faq/faq_list', 'refresh');	
		  }
	}

	function edit_faq($faq_id=null){
		$viewArr['data'] = $this->faq_model->get_unique_faq($faq_id);
		$viewArr['viewPage'] = "edit_faq";
		$this->load->view('backend/layout', $viewArr); 
	}

	function update_faq(){
		  if($_POST){
		  	$this->form_validation->set_rules('header_title', 'Header', 'trim|required|xss_clean');
		    $this->form_validation->set_rules('content', 'Content', 'trim|required|xss_clean');
		   

		  	if($this->form_validation->run() == FALSE){
				$this->edit_faq();				
	    	}else{
	    		$get_content=$this->input->post('content');
	    		$get_content=preg_replace('#<[^>]+>#', ' ', $get_content);
                $string =  preg_replace('/\\s/','',$get_content);
	    		
			    if($string==''){
			  	
				$this->session->set_flashdata('error', 'please provide the content');
				redirect('backend/faq/edit_faq', 'refresh');	
			    }
			// build data array
			$data = array();

			//$get_order_sequence=$this->cms_model->get_order_sequence();
			$data['id'] = $this->input->post('faq_id');
			$data['header_title'] = $this->input->post('header_title');
			$data['content'] = $this->input->post('content');
			//$data['order_sequence'] = $get_order_sequence+1;
			
			$result = $this->faq_model->update_faq($data);
			
			  if($result){
				$this->session->set_flashdata('message', 'Faq successfully updated');
				redirect('backend/faq/faq_list', 'refresh');	
			    }		
		      }
		  	 
		  }else{
		  	redirect('backend/faq/faq_list', 'refresh');	
		  }
	}

	public function ajax_update_faq_status(){
		$status=$this->input->post('status');
		$id=$this->input->post('id');
		$this->faq_model->ajax_update_faq_status($id,$status);
		echo "1";exit;
	}
	
	public function update_faq_order(){
		 
		 $list=$_POST['a'];
		
         $counter=0;
         
         for($i=1; $i<=sizeof($list); $i++){
             $this->faq_model->update_faq_order($i,$list[$counter]);
              $counter++;
             
         }

	}

	public function update_form(){
		$get_data=$this->faq_model->get_all_order_ids();
		$list=$_POST['order_list'];
		$cnt=0;
		
		foreach($get_data as $data){
			$this->faq_model->update_faq_order($data['id'],$list[$cnt]);
            $cnt++;
		}

		$this->session->set_flashdata('message', 'order updated successfully');
		redirect('backend/faq/index', 'refresh');	
	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */