<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');class Payment extends CI_Controller {
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
		$this->load->model('backend/user_model');
		$this->load->model('backend/payment_model');
		$this->load->library(array('form_validation','session','pagination'));
		$this->load->helper(array('form', 'url'));
		$passArg = array();
		if(!isset($this->session->userdata['admin_logged_in'])){
			redirect('backend/login', 'refresh');
		}
	}


	public function index(){
		// check if payment is set for all gateways
		//print_r($this->session->userdata['admin_logged_in']);		$login_id = $this->session->userdata['admin_logged_in']['id'];
		$login_type = 3;
		//print_r($login_id);
		// get poli details
		$data_result_flo_2_cash = $this->payment_model->flo_2_cash_details($login_id,$login_type);
		if(isset($data_result_flo_2_cash['0'])){
			// create a blank array object
			$data_result_flo_2_cash = $data_result_flo_2_cash['0'];
		}else{
			$data_result_flo_2_cash = $this->blank_flo_2_cash_obj();
		}

		// get dps payment details
		$data_result_dps = $this->payment_model->dps_payment_details($login_id,$login_type);
		if(isset($data_result_dps['0'])){
			// create a blank array object
			$data_result_dps = $data_result_dps['0'];
		}else{
			$data_result_dps = $this->blank_dps_payment_obj();
		}

		// get dyanamic payment details
		$data_result_dynamic_payment = $this->payment_model->dynamic_payment_details($login_id,$login_type);
		if(isset($data_result_dynamic_payment['0'])){
			// create a blank array object
			$data_result_dynamic_payment = $data_result_dynamic_payment['0'];
		}else{
			$data_result_dynamic_payment = $this->blank_dynamic_payment_payment_obj();
		}
		//print_r($data_result_dynamic_payment);

		// get flo2cash details
		$data_result_poli = $this->payment_model->poli_payment_details();
		if(isset($data_result_poli['0'])){
			// create a blank array object
			$data_result_poli = $data_result_poli['0'];
		}else{
			$data_result_poli = $this->blank_poli_payment_obj();
		}

		// get alipay details
		$data_result_alipay = $this->payment_model->alipay_payment_details($login_id,$login_type);
		if(isset($data_result_alipay['0'])){
			// create a blank array object
			$data_result_alipay = $data_result_alipay['0'];
		}else{
			$data_result_alipay = $this->alipay_payment_obj();
		}



		$viewArr['data_result_flo_2_cash'] = $data_result_flo_2_cash;
		$viewArr['data_result_dps'] = $data_result_dps;
		$viewArr['data_result_dynamic_payment'] = $data_result_dynamic_payment;
		$viewArr['data_result_poli'] = $data_result_poli;
		$viewArr['data_result_alipay'] = $data_result_alipay;    //echo $login_id;		$get_dps_data=$this->payment_model->get_dps_data($login_id);		$get_flo2_data=$this->payment_model->get_flo2_data($login_id);		$viewArr['data_result_flo_2_cash'] = $data_result_flo_2_cash;		$viewArr['data_result_dps'] = $data_result_dps;		$viewArr['data_result_dynamic_payment'] = $data_result_dynamic_payment;		$viewArr['data_result_poli'] = $data_result_poli;		$viewArr['data_result_alipay'] = $data_result_alipay;		$viewArr['dps_data']=$get_dps_data;		$viewArr['dps_flo2']=$get_flo2_data;

	    $viewArr['viewPage'] = "set_up_payments";
		$this->load->view('backend/layout', $viewArr);
	}
	function blank_poli_payment_obj(){
		$data = array();
		$data['id'] = "";
		$data['user_id'] = "";
		$data['login_type'] = "";
		$data['account_id'] = "";
		$data['password'] = "";
		$data['currency_code'] = "";
		$data['merchant_reference'] = "";
		$data['merchant_reference_format'] = "";
		$data['merchant_data'] = "";
		$data['homepage_url'] = "";
		$data['success_url'] = "";
		$data['failure_url'] = "";
		$data['cancel_url'] = "";
		$data['notification_url'] = "";
		$data['timeout'] = "";
		$data['fi_code'] = "";
		$data['company_code'] = "";
		$data['payment_method'] = "";
		return $data;
	}

	function blank_dynamic_payment_payment_obj(){
		$data = array();
		$data['id'] = "";
		$data['user_id'] = "";
		$data['login_type'] = "";
		$data['merchant_id'] = "";
		$data['mcc'] = "";
		$data['trasanction_type'] = "";
		$data['merchant_name'] = "";
		$data['commodity_url'] = "";
		$data['timeout'] = "";
		$data['currency'] = "";
		$data['merchant_reserved_field'] = "";
		$data['supported_method'] = "";
		return $data;
	}

	function alipay_payment_obj(){
		$data = array();
		$data['id'] = "";
		$data['service'] = "";
		$data['alipay_partner_id'] = "";
		$data['alipay_partner_key'] = "";
		$data['character_set'] = "";
		$data['currency'] = "";
		$data['return_url'] = "";
		$data['order_valid_time'] = "";
		$data['supported_method'] = "";
		$data['notification_url'] = "";
		return $data;
	}
	function blank_dps_payment_obj(){
		$data = array();
		$data['id'] = "";
		$data['user_id'] = "";
		$data['login_type'] = "";
		$data['pxpayuserid'] = "";
		$data['pxpaykey'] = "";
		$data['paypayurl'] = "";
		$data['transaction_type'] = "";
		$data['currency'] = "";
		$data['email'] = "";
		$data['failure_url'] = "";
		$data['success_url'] = "";
		$data['visa'] = "";
		$data['american_express'] = "";
		$data['dinner_club'] = "";
		return $data;
	}
	function blank_flo_2_cash_obj(){
		$data = array();
		$data['id'] = "";
		$data['user_id'] = "";
		$data['login_type'] = "";
		$data['account_id'] = "";
		$data['secret_key'] = "";
		$data['merchant_reference'] = "";
		$data['notification_url'] = "";
		$data['custom_data'] = "";
		$data['header_image'] = "";
		$data['header_bottom_border_color'] = "";
		$data['header_background_color'] = "";
		$data['store_card'] = "";
		$data['display_customer_email'] = "";
		$data['payment_method'] = "";
		$data['visa'] = "";
		$data['american_express'] = "";
		$data['dinner_club'] = "";
		$data['return_url'] = "";
		$data['service'] = "";
		return $data;
	}


    function dynamic_payment_method(){

		$this->form_validation->set_error_delimiters('<p style="color:red;">', '</p>');
		$this->form_validation->set_rules('merchant_id','Merchant Id','trim|xss_clean|required');
		$this->form_validation->set_rules('mcc','Mcc','trim|xss_clean|required');
		$this->form_validation->set_rules('trasanction_type','Transaction Type','trim|xss_clean|required');
		$this->form_validation->set_rules('merchant_name','Merchant Name','trim|xss_clean|required');
		$this->form_validation->set_rules('commodity_url','Commodity Url','trim|xss_clean|required');
		$this->form_validation->set_rules('transaction_currency','Transaction Currency','trim|xss_clean|required');
		$this->form_validation->set_rules('order_time_out','Order Time Out','trim|xss_clean|required');
		$this->form_validation->set_rules('merchant_reserved_field','Merchant Reserved Field','trim|xss_clean|required');

		if($this->form_validation->run() == FALSE){
			$viewArr['viewPage'] = "set_up_payments";
			$this->load->view('backend/layout', $viewArr);
		}else{

			if(isset($_POST['supported_method'])){
				$supported_method = 1;
			}else{
				$supported_method = 0;
			}

			$login_type = 3;

			$data_dynamic=array(
			   'user_id' => $this->session->userdata['admin_admin_logged_in']['id'],
			   'merchant_id'=>  $this->input->post('merchant_id'),
			   'mcc'=>$this->input->post('mcc'),
			   'trasanction_type'=>$this->input->post('trasanction_type'),
			   'merchant_name'=>$this->input->post('merchant_name'),
			   'commodity_url'=>$this->input->post('commodity_url'),
			   'currency'=>$this->input->post('transaction_currency'),
			   'timeout'=>$this->input->post('order_time_out'),
			   'merchant_reserved_field'=>$this->input->post('merchant_reserved_field'),
			   'supported_method'=>$supported_method,
			   'login_type' =>$login_type,
			);
		  // print_r($data_dynamic);
		 // exit;
			$result = $this->payment_model->dynamic_payment_method($data_dynamic);
				//print_r($result);
		       //exit;
			if($result){
				$this->session->set_flashdata('msg', 'dynamic payment details successfully updated');
				redirect('backend/payment','refresh');
			}else{
				$this->session->set_flashdata('msg', 'Error in updating record');
				redirect('backend/payment','refresh');
			}
		}
	}

    function flo2Cash_form_method(){
	//echo "abc";
	//exit;
		$this->form_validation->set_error_delimiters('<p style="color:red;">', '</p>');
		$this->form_validation->set_rules('web_payments_integration_service','Web Payments Integration Service','trim|xss_clean|required');
		$this->form_validation->set_rules('flo2Cash_account_id','Flo2Cash Account ID','trim|xss_clean|required');
		$this->form_validation->set_rules('flo2Cash_secret_hash_key','Px Pay Url','trim|xss_clean|required');
		$this->form_validation->set_rules('return_url','Return URL','trim|xss_clean|required');
		$this->form_validation->set_rules('m_ref','m ref','trim|xss_clean');
		$this->form_validation->set_rules('nurl','nurl','trim|xss_clean');
		$this->form_validation->set_rules('himage','himage','trim|xss_clean');
		$this->form_validation->set_rules('hbtcolor','hbtcolor','trim|xss_clean');
		$this->form_validation->set_rules('hbgcolor','hbgcolor','trim|xss_clean');
		$this->form_validation->set_rules('mdcd','mdcd','trim|xss_clean');
		$this->form_validation->set_rules('storecard','storecard','trim|xss_clean');
		$this->form_validation->set_rules('paymethod','paymethod','trim|xss_clean');
		$this->form_validation->set_rules('dce','dce','trim|xss_clean');

		if($this->form_validation->run() == FALSE){
			//echo validation_errors();
			$viewArr['viewPage'] = "set_up_payments";
			$this->load->view('backend/layout', $viewArr);
		}else{

				if(isset($_POST['visa'])){ $visa = 1; }else{ $visa = 0;}
				if(isset($_POST['american_express'])){	$american_express = 1;	}else{	$american_express = 0;	}
				if(isset($_POST['dinner_club'])){ $dinner_club = 1;	}else{ $dinner_club = 0;  }
		  		$login_type = 3;
			   $data_flo2cash=array(
			   'user_id'=> $this->session->userdata['admin_admin_logged_in']['id'],
			   'login_type'=> $login_type,
			   'account_id'=>$this->input->post('flo2Cash_account_id'),
			   'secret_key'=>$this->input->post('flo2Cash_secret_hash_key'),
			   'merchant_reference'=>$this->input->post('m_ref'),
			   'notification_url'=>$this->input->post('nurl'),
			   'custom_data'=>$this->input->post('mdcd'),
			   'header_image'=>$this->input->post('himage'),
			   'header_bottom_border_color'=>$this->input->post('hbtcolor'),
			   'header_background_color'=>$this->input->post('hbgcolor'),
			   'store_card'=>$this->input->post('storecard'),
			   'display_customer_email' =>$this->input->post('dce'),
			   'payment_method' =>$this->input->post('paymethod'),
			   'return_url'=>$this->input->post('return_url'),
			   'service'=>$this->input->post('web_payments_integration_service'),
			   'visa'=>$visa,
			   'american_express'=>$american_express,
			   'dinner_club'=>$dinner_club,
			   );

				$result = $this->payment_model->flo2cash_payment_method($data_flo2cash);

				if($result){
					$this->session->set_flashdata('msg', 'flo2cash payment details successfully updated');
					redirect('backend/payment#flo2Cash','refresh');
				}else{
					$this->session->set_flashdata('msg', 'Error in updating record');
					redirect('backend/payment#flo2Cash','refresh');
				}
			}
		}

    function dps_payment_method(){
		$this->form_validation->set_error_delimiters('<p style="color:red;">', '</p>');
		$this->form_validation->set_rules('pxpayuserid','Px Pay User Id','trim|xss_clean|required');
		$this->form_validation->set_rules('pxpaykey','Px Pay Key','trim|xss_clean|required');
		$this->form_validation->set_rules('pxpayurl','Px Pay Url','trim|xss_clean|required');
		$this->form_validation->set_rules('transaction_type_dps','Transaction Type','trim|xss_clean|required');
		$this->form_validation->set_rules('transaction_currency_dps','Transaction Currency','trim|xss_clean|required');
		$this->form_validation->set_rules('email','Email','trim|xss_clean|required');


	   if($this->form_validation->run() == FALSE){
		 //echo validation_errors();
		$viewArr['viewPage'] = "set_up_payments";
		   $this->load->view('backend/layout', $viewArr);
	   }else{

			if(isset($_POST['dps_visa'])){ $visa = 1; }else{ $visa = 0;}
			if(isset($_POST['dps_american_express'])){	$american_express = 1;	}else{	$american_express = 0;	}
			if(isset($_POST['dps_dinner_club'])){ $dinner_club = 1;	}else{ $dinner_club = 0;  }

          $login_type = 3;
		  $data_dps=array(
			  'user_id'=>$this->session->userdata['admin_admin_logged_in']['id'],
			  'pxpayuserid'=>$this->input->post('pxpayuserid'),
			  'pxpaykey'=>$this->input->post('pxpaykey'),
			  'paypayurl'=>$this->input->post('pxpayurl'),
			  'transaction_type'=>$this->input->post('transaction_type_dps'),
			  'currency'=>$this->input->post('transaction_currency_dps'),
			  'email'=>$this->input->post('email'),
			  'login_type' =>$login_type,
			  'visa'=>$visa,
			  'american_express'=>$american_express,
			  'dinner_club'=>$dinner_club,
			);

			$result = $this->payment_model->dps_payment_method($data_dps);

			if($result){
				$this->session->set_flashdata('msg', 'dps payment details successfully updated');
				redirect('backend/payment#dps','refresh');
			}else{
				$this->session->set_flashdata('msg', 'Error in updating record');
				redirect('backend/payment#dps','refresh');
			}
		}
	}


	function alipay_payment_method(){
		$this->form_validation->set_error_delimiters('<p style="color:red;">', '</p>');
		$this->form_validation->set_rules('service_name','service name','trim|xss_clean|required');
		$this->form_validation->set_rules('alipay_partner_id','partner id','trim|xss_clean|required');
		$this->form_validation->set_rules('alipay_partner_key','partner key','trim|xss_clean|required');
		$this->form_validation->set_rules('character_set','character set','trim|xss_clean|required');
		$this->form_validation->set_rules('alipay_currency','currency','trim|xss_clean|required');
		$this->form_validation->set_rules('alipay_return_url','return url','trim|xss_clean|required');
		$this->form_validation->set_rules('alipay_notification_url','notification url','trim|xss_clean|required');
		$this->form_validation->set_rules('alipay_order_time','order time','trim|xss_clean|required');

		if($this->form_validation->run() == FALSE){
			$viewArr['viewPage'] = "set_up_payments";
			$this->load->view('backend/layout', $viewArr);
		}else{

			if(isset($_POST['alipay_pay_method'])){
				$alipay_pay_method = 1;
			}else{
				$alipay_pay_method = 0;
			}

			$login_type = 3;
			$data_dynamic=array(
			   'user_id' => $this->session->userdata['admin_logged_in']['id'],
			   'service'=>  $this->input->post('service_name'),
			   'alipay_partner_ID'=>$this->input->post('alipay_partner_id'),
			   'alipay_partner_key'=>$this->input->post('alipay_partner_key'),
			   'character_set'=>$this->input->post('character_set'),
			   'currency'=>$this->input->post('alipay_currency'),
			   'return_url'=>$this->input->post('alipay_return_url'),
			   'notification_url'=>$this->input->post('alipay_notification_url'),
			   'order_valid_time'=>$this->input->post('alipay_order_time'),
			   'supported_method'=>$alipay_pay_method,
			   'login_type' =>$login_type,
			);

			$result = $this->payment_model->alipay_payment_method($data_dynamic);

			if($result){
				$this->session->set_flashdata('msg', 'alipay payment details successfully updated');
				redirect('backend/payment#alipay','refresh');
			}else{
				$this->session->set_flashdata('msg', 'Error in updating record');
				redirect('backend/payment#alipay','refresh');
			}
		}
	}	function cc_payment_method(){	//	echo "<pre>";	//	print_r($_POST);exit;		$payment_type=$this->input->post('pay_type');		 if(isset($_POST['cc_used'])){			$use_card=1;		 }else{			$use_card=0;		 }		$pxpayuserid=$this->input->post('pax_pay_userid');		$pxpaykey=$this->input->post('pax_pay_key');		$account_id=$this->input->post('flo_acc_id');		if($payment_type==1){				$dps_status=1;				$floto_status=0;		}else{				$dps_status=0;				$floto_status=1;		}		 $data_dps=array(		'user_id'=>$this->session->userdata['admin_logged_in']['id'],		'pxpayuserid'=>$pxpayuserid,		'pxpaykey'=>$pxpaykey,		'use_card'=>$use_card,		'login_type'=>'3',			'status'=>$dps_status,		 );		 $result_dps=$this->payment_model->save_dps_organiser($data_dps);			$data_flo=array(			'user_id'=>$this->session->userdata['admin_logged_in']['id'],			'account_id'=>$account_id,			 'use_card'=>$use_card,			'login_type'=>'3',			'status'=>$floto_status			);		 $result_flo=$this->payment_model->save_flo2_organiser($data_flo);		 if($payment_type==1){			//set settings for dps			if($use_card == 1){				$dps_status = 1;				$flo_2_status = 0;			}else{				$dps_status = 0;				$flo_2_status = 0;			}			 $dps_settins =array(			'organizer_id'=>$this->session->userdata['admin_logged_in']['id'],			'payment_key'=>'dps',			'payment_method_name'=>'Credit Card',			'status'=>$dps_status,			 );			 $flo2_settins =array(			'organizer_id'=>$this->session->userdata['admin_logged_in']['id'],			'payment_key'=>'flo_2_cash',			'payment_method_name'=>'Credit Card',			'status'=>$flo_2_status,			 );			//$save_flo2_settings=$this->payment_model->save_flo2_settings($flo2_settins);			//$save_dps_settings=$this->payment_model->save_dps_settings($dps_settins);			$this->session->set_flashdata('msg', 'Credit card payment details successfully updated');			redirect('backend/payment#cc','refresh');		 }		 if($payment_type == 2){			 if($use_card == 1){				$dps_status = 0;				$flo_2_status = 1;			}else{				$dps_status = 0;				$flo_2_status = 0;			}			 $flo2_settins =array(			'organizer_id'=>$this->session->userdata['admin_logged_in']['id'],			'payment_key'=>'flo_2_cash',			'payment_method_name'=>'Credit Card',			'status'=>$flo_2_status,			 );			 $dps_settins =array(			'organizer_id'=>$this->session->userdata['admin_logged_in']['id'],			'payment_key'=>'dps',			'payment_method_name'=>'Credit Card',			'status'=>$dps_status,			 );			 //$save_flo2_settings=$this->payment_model->save_flo2_settings($flo2_settins);			 //$save_dps_settings=$this->payment_model->save_dps_settings($dps_settins);			 $this->session->set_flashdata('msg', 'Credit card payment details successfully updated');		  	redirect('backend/payment#cc','refresh');		 }	}
	function poli_payment_method(){		$this->form_validation->set_error_delimiters('<p style="color:red;">', '</p>');		$this->form_validation->set_rules('poli_account_id','Poli Account Id','trim|xss_clean|required');		$this->form_validation->set_rules('poli_password','Poli Password','trim|xss_clean|required');		if($this->form_validation->run() == FALSE){			 $viewArr['viewPage'] = "set_up_payments";			 $this->load->view('backend/layout', $viewArr);		}else{						$data_poli=array(				 'user_id'=>$this->session->userdata['admin_logged_in']['id'],				 'account_id'=>$this->input->post('poli_account_id'),				 'password'=>$this->input->post('poli_password'),				 'login_type' =>'3'			);			$result = $this->payment_model->poli_payment_method($data_poli);			if($result){				$this->session->set_flashdata('msg', 'poli payment details successfully updated');				redirect('backend/payment#poli','refresh');			}else{				$this->session->set_flashdata('msg', 'Error in updating record');				redirect('backend/payment#poli','refresh');			}		}	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
