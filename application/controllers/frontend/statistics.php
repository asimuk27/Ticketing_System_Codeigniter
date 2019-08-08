<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Statistics extends CI_Controller {

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
		$this->load->model('frontend/event_model');
		$this->load->model('frontend/payment_model');
		$this->load->model('frontend/order_model');
		$this->load->model('frontend/login_model');
		$this->load->model('frontend/statistics_model');
		$this->load->library(array('form_validation','session','pagination','image_lib'));
		$this->load->helper(array('form', 'url', 'file','pdf_helper'));
		$this->load->library('ciqrcode');
		
		$passArg = array();	

	}

	function index($event_id = NULL){
		if(isset($this->session->userdata['logged_in']['id'])){			
		    $organiser_id = $this->session->userdata['logged_in']['id'];	
		}else{
		    $organiser_id = "";
			redirect('frontend/home', 'refresh');
		}
		if($_POST){
           $search_id=$this->input->post('search');

           if($search_id=='all'){
				redirect('frontend/statistics/index/'.$event_id.'', 'refresh');				
           }
		   
		   // get donation summary
			$type = "sub_event_id";
			$detail = "main_summary";

			$viewArr['main_summary'] = $this->statistics_model->get_donation_summary($search_id,$type,$detail);
						
			// get sponsors
			$detail = "sponsors";			
			$viewArr['sponsor_data'] = $this->statistics_model->get_donation_summary($search_id,$type,$detail);
						
			$detail = "champion";			
			$viewArr['champion_data'] = $this->statistics_model->get_donation_summary($search_id,$type,$detail);
				
			$data = $this->statistics_model->get_price_by_id(1,$search_id);
		   
            $get_all_tickets=$this->statistics_model->get_all_tickets_on_subevents($search_id); //done
            $get_event_info=$this->statistics_model->get_event_info($event_id); //done
           
			$get_event_tickets = $this->statistics_model->get_event_tickets_on_subevents($search_id); // done
			
			$get_free_tickets=$get_all_tickets['free'];
			$get_paid_tickets=$get_all_tickets['paid'];
			$get_donation_tickets=$get_all_tickets['donation'];
			$get_pending_tickets=$this->statistics_model->get_pending_tickets_on_subevents($search_id);

			$ticket_sales=0;
			$donations=0;
			if(!empty($get_event_tickets)){
               foreach($get_event_tickets as $val){
			    $ticket_sales=$ticket_sales+$val['price'];
			    }
			}

			 $get_all_events=$this->statistics_model->get_events_of_organiser($organiser_id);
             $viewArr['get_all_events']=$get_all_events;
			
			$viewArr['event_id']=$event_id;
            $gross_sales=$ticket_sales;
			$viewArr['viewPage'] = "organiser_statistics";
			$viewArr['data'] = array('ticket_sales'=>$ticket_sales, 'gross_sales'=>$gross_sales,'get_free_tickets'=>$get_free_tickets,'get_paid_tickets'=>$get_paid_tickets, 'get_donation_tickets'=>$get_donation_tickets);
            $viewArr['get_event_info']=$get_event_info;
            $set_dropdown_data = $this->statistics_model->set_dropdown_data($event_id);
		    $viewArr['set_dropdown_data']=$set_dropdown_data;
			$viewArr['get_pending_tickets']=$get_pending_tickets;
		    $this->load->view('frontend/layout', $viewArr);
		}else{
            

		     if($event_id!=''){
		    	$data = $this->statistics_model->get_price_by_id(2,$event_id);
			    $exist_status =	$this->statistics_model->check_event_id($event_id);
			    if($exist_status==0){
				redirect("frontend/home/index");
			    }
		    }
			

			if($event_id!=''){
				$type = "event_id";
			$detail = "main_summary";
				
			$viewArr['main_summary'] = $this->statistics_model->get_donation_summary($event_id,$type,$detail);
							
			// get sponsors
			$detail = "sponsors";			
			$viewArr['sponsor_data'] = $this->statistics_model->get_donation_summary($event_id,$type,$detail);
							
			$detail = "champion";			
			$viewArr['champion_data'] = $this->statistics_model->get_donation_summary($event_id,$type,$detail);

			 	$get_all_tickets=$this->statistics_model->get_all_tickets($event_id);
			//print_r($get_all_tickets);exit;
            $get_event_info=$this->statistics_model->get_event_info($event_id);
            $viewArr['get_event_info']=$get_event_info;
            //print_r($get_event_info);exit;
			$get_event_tickets=$this->statistics_model->get_event_tickets($event_id);
			//$get_donations=$this->organiser_model->get_donations($event_id);
			$get_free_tickets=$get_all_tickets['free'];
			$get_paid_tickets=$get_all_tickets['paid'];
			$get_donation_tickets=$get_all_tickets['donation'];
			$get_pending_tickets=$this->statistics_model->get_pending_tickets($event_id);
			$viewArr['get_pending_tickets']=$get_pending_tickets;
			
			$ticket_sales=0;
			$donations=0;
			if(!empty($get_event_tickets)){
               foreach($get_event_tickets as $val){
			    $ticket_sales=$ticket_sales+$val['price'];
			    }
			}
			$gross_sales=$ticket_sales;
			
			$viewArr['data'] = array('ticket_sales'=>$ticket_sales, 'gross_sales'=>$gross_sales,'get_free_tickets'=>$get_free_tickets,'get_paid_tickets'=>$get_paid_tickets, 'get_donation_tickets'=>$get_donation_tickets);
			}
			
			// get donation summary
			
								
		
            
            $get_all_events=$this->statistics_model->get_events_of_organiser($organiser_id);
          

            if($event_id!=''){
            	  $set_dropdown_data=$this->statistics_model->set_dropdown_data($event_id);
            	 $viewArr['set_dropdown_data']=$set_dropdown_data;
            	}else{
            	  $viewArr['set_dropdown_data']="";
            	}
		   $viewArr['viewPage'] = "organiser_statistics";
		    $viewArr['get_all_events']=$get_all_events;
			
			$viewArr['event_id']=$event_id;
			
		    $this->load->view('frontend/layout', $viewArr);
		}
	} 
	

}