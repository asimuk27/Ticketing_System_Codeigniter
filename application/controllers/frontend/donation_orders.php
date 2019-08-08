<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Donation_orders extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	**/
	function __construct(){
		parent::__construct();
		//Load all required classes
		$this->load->library(array('form_validation','session','pagination'));
		$this->load->helper(array('form', 'url', 'file'));
		$this->load->model('frontend/donation_model');
		$this->load->model('frontend/payment_model');
		$this->load->model('frontend/organiser_model');
		$passArg = array();
	}

	function view_donation($id = null){
		$data = $this->donation_model->view_champion_by_id($id);

		//get charity
		$organizer_data = $this->organiser_model->get_charity_details($data['charity_name']);
		$viewArr['organizer_data'] = $organizer_data;

		// get payment settings
		if(isset($organizer_data->organization_id)){
			$payment_details = $this->payment_model->get_organizer_payment_methods($organizer_data->organization_id);
		}else{
			$payment_details = "";
		}

		$amount_donated = $this->donation_model->amount_given($id);
		$viewArr['amount_donated'] = $amount_donated;
		$viewArr['data'] = $data;

		// check if user is logged in
		if(isset($this->session->userdata['logged_in']) && ($this->session->userdata['logged_in']['login_type'] != "")){
			$user_id = $this->session->userdata['logged_in']['id'];
			//get user details
			$login_type = $this->session->userdata['logged_in']['login_type'];
			if($login_type == 1){
				$data = $this->donation_model->get_organizer_information($user_id);
				$viewArr['user_data'] = $data;
			}else if($login_type == 0){
				$data = $this->donation_model->get_user_information($user_id);
				$viewArr['user_data'] = $data;
			}
		}else{
			//generate blank array
			$data = array();
			$data['first_name'] = "";
			$data['email'] = "";
			$data['phone_no'] = "";
			$data['street_address'] = "";
			$data['city'] = "";
			$data['country'] = "";
			$data['suburb'] = "";
			$data['postal_code'] = "";
			$viewArr['user_data'] = $data;
		}

		$viewArr['payment_method'] = $payment_details;
		$viewArr['viewPage'] = "donation";
		$this->load->view('frontend/layout', $viewArr);
	}

	function save_donation($id){
		$data = array();
		$data = $this->donation_model->view_champion_by_id($id);
		$amount_donated = $this->donation_model->amount_given($id);
		$this->form_validation->set_error_delimiters('<p style="color:red;">', '</p>');
		$this->form_validation->set_rules('', 'page title', 'trim|required|xss_clean');
		$this->form_validation->set_rules('target_amount', 'target amount', 'trim|required|xss_clean');
		$this->form_validation->set_rules('donor_mssg', 'donor_mssg', 'trim|required|xss_clean');
		$this->form_validation->set_rules('org_name', 'org_name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('select_salutation', 'select_salutation', 'trim|required|xss_clean');
		$this->form_validation->set_rules('first_name', 'name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('email', 'email', 'trim|required|xss_clean|valid_email');
		$this->form_validation->set_rules('country', 'country', 'trim|required|xss_clean');


		if($this->form_validation->run() == FALSE){

			// check if user is logged in
			if(isset($this->session->userdata['logged_in']) && ($this->session->userdata['logged_in']['login_type'] != "")){
				$user_id = $this->session->userdata['logged_in']['id'];
				//get user details
				$record = $this->donation_model->get_user_information($user_id);
				$viewArr['user_data'] = $record;
			}else{
				//generate blank array
				$record = array();
				$record['first_name'] = "";
				$record['email'] = "";
				$record['phone_no'] = "";
				$record['street_address'] = "";
				$record['city'] = "";
				$record['country'] = "";
				$viewArr['user_data'] = $record;
			}

			$viewArr['data'] = $data;
			$viewArr['viewPage'] = "donation";
			$this->load->view('frontend/layout', $viewArr);
		}else{
			//
			if($this->input->post('organisation_name') != ""){
				$new_test_name = $this->input->post('organisation_name');
			}else{
				$new_test_name = "";
			}

			if(isset($_POST['charity_name'])){
				$if_yes = $_POST['charity_name'];
			}else{
				$if_yes = "0";
			}

			// build champions data array
			$data = array(
				'champion_page_id' => $id,
				'donor_message' => $this->input->post('donor_mssg'),
				'donor_name' => $this->input->post('org_name'),
				'donar_organisation' => $new_test_name,
				'salutation' => $this->input->post('select_salutation'),
				'donation_amount' => $this->input->post('target_amount'),
				'first_name' => $this->input->post('first_name'),
				'email' => $this->input->post('email'),
				'communication_required' => $if_yes,
				'phone' => $this->input->post('phone'),
				'street' => $this->input->post('street'),
				'country' => $this->input->post('country'),
				'suburb' => $this->input->post('suburb'),
				'postal_code' => $this->input->post('postal_code'),
				'city' => $this->input->post('city'),
				'payment_method' => $this->input->post('check_out_method'),
				'status' => 0,
			);

			$record_id = $this->donation_model->save_donation($data);
			$viewArr['data'] = $data;

			// save order information
				// store data and get order number
				$result = $this->payment_model->get_last_payment_id();

				if($result->unique_id == ""){
					$randomNumber = "000000001";
				}else{
					//$string = substr($result->unique_id, 1, 9);
					$string = $result->unique_id + 1;
					$randomNumber = str_pad($string, 9, "0", STR_PAD_LEFT);
				}

				$order_id = $randomNumber;
				if(isset($this->session->userdata['logged_in']) && ($this->session->userdata['logged_in']['id'] != "")){
					$user_id = $this->session->userdata['logged_in']['id'];
				}else{
					$user_id = "";
				}

				// build payment data array
				$payment_data['order_id'] = $order_id;
				$payment_data['user_id'] = $user_id;
				$payment_data['login_type'] = "";
				$payment_data['email'] = $data['email'];
				$payment_data['amount'] = $data['donation_amount'];
				$payment_data['payment_for'] = "donation";
				$payment_data['first_name'] = "";
				$payment_data['last_name'] = "";
				$payment_data['country'] = $data['country'];
				$payment_data['address1'] = $data['street'];
				$payment_data['address2'] = $data['country'];
				$payment_data['payment_method'] = $data['payment_method'];
				$payment_data['created_date'] = date("Y-m-d H:i:s");

				// get organizer id based on champion unique id
				$organizer_details = $this->donation_model->get_organizer_id($id);
				$payment_data['organiser_id'] = $organizer_details;

				$this->session->set_userdata('processing_order_id', $order_id);

				// store data for order processing
				$pay_data = $this->payment_model->save_order_information($payment_data);
				$update_status = $this->payment_model->update_donation_with_order_id($record_id,$order_id);

			if($record_id){
				$this->initiate_payment($payment_data,$result);
			}else{
				echo "error";
			}
			///	$this->session->set_flashdata('first_name',$this->input->post('first_name'));
			//redirect('frontend/donation/donation_success', 'refresh');
		}
	}

	// payment processing
	function call_to_payment($data){
		echo $data;
		exit;
	}

	function initiate_payment($data){
		$pay_method = $data['payment_method'];

		switch($pay_method){
			case "flo_2_cash":
				$this->flo_2_cash_transaction($data);
				break;
			case "cup":
				$this->dynamic_payment($data);
				break;
			case "poli":
				$this->poli_payment($data);
				break;
			case "alipay":
				$this->call_to_payment($pay_method);
				break;
			case "dps":
				$this->dps_transaction($data);
				break;
			default:
				echo "Error in payment transaction !";
		}
	}

	function isProcessed($TxnId,$MerchantReference){
		# Check database if order relating to TxnId has alread been processed
		return false;
	}


	function output_url(){
		require getcwd().'/application/libraries/dps/dps.php';

		// get credrentials by order id
		$dummy_order_id = $this->session->userdata['processing_order_id'];
		$org_id = $this->donation_model->get_organizer_by_order_id($dummy_order_id);

		// get if organizer or TicketingSystem admin to be used
		$ticket_dps = $this->payment_model->get_ticket_suite_dps($org_id);

		if(!empty($ticket_dps)){
			// get organizer dps details by organizer id
			if($ticket_dps['payment_method'] == 2){
				$dps_creds = $this->payment_model->get_dps_credential_details($org_id,3);
			}else{
				$dps_creds = $this->payment_model->get_dps_credential_details($org_id,1);
			}
		}else{
			redirect('frontend/donation/donation_error_page', 'refresh');
		}

		if(!empty($dps_creds)){
		//	$PxPay_Url    = "https://sec.paymentexpress.com/pxaccess/pxpay.aspx";
			$PxPay_Url    = "https://sec.paymentexpress.com/pxaccess/pxpay.aspx";
			$PxPay_Userid = $dps_creds['pxpayuserid']; #Important! Update with your UserId
			$PxPay_Key    =  $dps_creds['pxpaykey']; #Important! Update with your Key

		}else{
			redirect('frontend/donation/donation_error_page', 'refresh');
		}

		/* // get organizer dps details by organizer id
		$dps_creds = $this->payment_model->get_dps_credential_details($org_id);



		 if(!empty($dps_creds)){
		//	$PxPay_Url    = "https://sec.paymentexpress.com/pxaccess/pxpay.aspx";
			$PxPay_Url    = "https://sec.paymentexpress.com/pxaccess/pxpay.aspx";
			$PxPay_Userid = $dps_creds['pxpayuserid']; #Important! Update with your UserId
			$PxPay_Key    =  $dps_creds['pxpaykey']; #Important! Update with your Key
		}else{
			redirect('frontend/donation/donation_error_page', 'refresh');
		} */
		/* 	$PxPay_Url    = "https://sec.paymentexpress.com/pxaccess/pxpay.aspx";
		$PxPay_Userid = "TicketingSystemHPP";
		$PxPay_Key    =  "f2188ecf1dc3d5e4c63ba07b74d7879cf08f15854fff8f7da42f504e478789ea";
		*/

		$pxpay = new PxPay_Curl($PxPay_Url,$PxPay_Userid,$PxPay_Key);

		$enc_hex = $_REQUEST["result"];
		  #getResponse method in PxPay object returns PxPayResponse object
		  #which encapsulates all the response data
		  $rsp = $pxpay->getResponse($enc_hex);

		  # the following are the fields available in the PxPayResponse object
		  //build output array
		  $out_array = array();
		  $out_array['success'] = $rsp->getSuccess();   # =1 when request succeeds
		  $out_array['amountSettlement']  = $rsp->getAmountSettlement();
		  $out_array['auth_code']          = $rsp->getAuthCode();  # from bank
		  $out_array['card_name']         = $rsp->getCardName();  # e.g. "Visa"
		  $out_array['card_number']        = $rsp->getCardNumber(); # Truncated card number
		  $out_array['date_expiry']        = $rsp->getDateExpiry(); # in mmyy format
		  $out_array['dps_billing_id']      = $rsp->getDpsBillingId();
		  $out_array['billing_id']    	 = $rsp->getBillingId();
		  $out_array['card_holder_name']    = $rsp->getCardHolderName();
		  $out_array['dps_txn_ref']	     = $rsp->getDpsTxnRef();
		  $out_array['txn_type']           = $rsp->getTxnType();
		  $out_array['txn_data_1']          = $rsp->getTxnData1();
		  $out_array['txn_data_2']          = $rsp->getTxnData2();
		  $out_array['txn_data_3']          = $rsp->getTxnData3();
		  $out_array['currency_settlement'] = $rsp->getCurrencySettlement();
		  $out_array['client_info']        = $rsp->getClientInfo(); # The IP address of the user who submitted the transaction
		  $out_array['txn_id']             = $rsp->getDpsTxnRef();
		  $out_array['currency_input']     = $rsp->getCurrencyInput();
		  $out_array['email_address']      = $rsp->getEmailAddress();
		  $out_array['merchant_reference'] = $rsp->getMerchantReference();
		  $out_array['response_text']		 = $rsp->getResponseText();
		  $out_array['txn_mac']            = $rsp->getTxnMac(); # An indication as to the uniqueness of a card used in relation to others

		if($rsp->getSuccess() == "1"){

			# Sending invoices/updating order status within database etc.
			if (!$this->isProcessed($TxnId,$MerchantReference)){
				# Send emails, generate invoices, update order status etc.
				$result = $this->payment_model->update_payment_status($out_array['txn_id'],$out_array['merchant_reference']);
				//$this->session->set_flashdata('result_data',$out_array);
				//redirect('frontend/donation/donation_success', 'refresh');
				$this->donation_success($out_array);
			}
		}else{
			$this->session->set_flashdata('txn_gateway_status', $rsp->ResponseText);
			$this->session->set_flashdata('order_error_id', $out_array['merchant_reference']);
			$result = $this->payment_model->update_payment_status($out_array['txn_id'],$out_array['merchant_reference']);
			redirect('frontend/donation_orders/donation_error_page', 'refresh');
		}
	}

	function dps_transaction($data){

		require getcwd().'/application/libraries/dps/dps.php';

		// get if organizer or TicketingSystem admin to be used
		$ticket_dps = $this->payment_model->get_ticket_suite_dps($data['organiser_id']);

		if(!empty($ticket_dps)){
			// get organizer dps details by organizer id
			if($ticket_dps['payment_method'] == 2){
				$dps_creds = $this->payment_model->get_dps_credential_details($data['organiser_id'],3);
			}else{
				$dps_creds = $this->payment_model->get_dps_credential_details($data['organiser_id'],1);
			}
		}else{
			redirect('frontend/donation_orders/donation_error_page', 'refresh');
		}

		if(!empty($dps_creds)){
		//	$PxPay_Url    = "https://sec.paymentexpress.com/pxaccess/pxpay.aspx";
			$PxPay_Url    = "https://sec.paymentexpress.com/pxaccess/pxpay.aspx";
			$PxPay_Userid = $dps_creds['pxpayuserid']; #Important! Update with your UserId
			$PxPay_Key    =  $dps_creds['pxpaykey']; #Important! Update with your Key

		}else{
			redirect('frontend/donation_orders/donation_error_page', 'refresh');
		}
		/*
	 	$PxPay_Url    = "https://uat.paymentexpress.com/pxaccess/pxpay.aspx";
		$PxPay_Userid = "AhuraConsulting_Dev";
		$PxPay_Key    =  "78efe7aad82db9354675fea0c9fa9484d5cdeaeee1be6ad90939ce74f8c14c98";
	*/
		$pxpay = new PxPay_Curl($PxPay_Url,$PxPay_Userid,$PxPay_Key);

		$request = new PxPayRequest();

		$script_url = $this->config->item('base_url').'frontend/donation_orders/output_url';
		# the following variables are read from the form

		$MerchantReference = $data['order_id'];
		$Address1 = $data['phone'];
		$Address2 = $data['street'];
		$Address3 = $data['country'];

		#Calculate AmountInput
		$AmountInput = $data['amount'];

		#Generate a unique identifier for the transaction
		$TxnId = uniqid("ID");

		#Set PxPay properties
		$request->setMerchantReference($MerchantReference);
		$request->setAmountInput($AmountInput);
		$request->setTxnData1($Address1);
		$request->setTxnData2($Address2);
		$request->setTxnData3($Address3);
		$request->setTxnType("Purchase");
		$request->setCurrencyInput("NZD");
		$request->setEmailAddress($data['email']);
		$request->setUrlFail($script_url);			# can be a dedicated failure page
		$request->setUrlSuccess($script_url);			# can be a dedicated success page
		$request->setTxnId($TxnId);

		#Call makeRequest function to obtain input XML
		$request_string = $pxpay->makeRequest($request);

		#Obtain output XML
		$response = new MifMessage($request_string);

		#Parse output XML
		$url = $response->get_element_text("URI");
		$valid = $response->get_attribute("valid");

		#Redirect to payment page
		header("Location: ".$url);
	}

	function donation_success($out_array = NULL){

		// get donation person information based on order number
		$result = $this->donation_model->get_information_by_order_id($out_array['merchant_reference']);

		$check_email_status = $this->payment_model->check_email_donation_status($out_array['merchant_reference']);

		if($check_email_status){
			$success_msg = $this->send_a_donation_email($result,$out_array);
		}

		$result = $this->payment_model->update_donation_status($out_array['merchant_reference']);

		$viewArr['page_id'] = "Receipts-".$out_array['merchant_reference'];

	//	$this->session->userdata['processing_order_id'];
		$this->session->unset_userdata('processing_order_id');
		$viewArr['viewPage'] = "donation_success_page";
		$this->load->view('frontend/layout', $viewArr);
	}

	function donation_error_page(){
		//$viewArr['viewPage'] = "error_page";
		//$this->load->view('frontend/layout', $viewArr);
		$order_number = $this->session->flashdata('order_error_id');
		// get champion id by order number
		$champion_id = $this->donation_model->get_champion_id_by_order_id($order_number);
		$viewArr['page_id'] = $champion_id;
		$viewArr['order_id'] = $order_number;
		$viewArr['status'] = $this->session->flashdata('txn_gateway_status');
		$viewArr['viewPage'] = "error_donation_page";
		$this->load->view('frontend/layout', $viewArr);
	}


	function send_a_donation_email($data_result = NULL,$order_id){

		$result = $this->donation_model->get_charity_information_by_order_id($order_id['merchant_reference']);

		if(empty($result)){
			return true;
		}

		$receipt_msg = $result['donation_receipt_text'];
		$email_signature = $this->config->item('organisation_signature').$result['signature'];
		$logo = $this->config->item('organisation_logo').$result['logo'];
		$cutter_image = $this->config->item('default_image_url').'kator.jpg';
		$thank_you = $this->config->item('default_image_url').'d.jpg';

		$this->load->library('email');
		$this->email->from('admin@ticketing_system.com', 'TicketingSystem');
		$this->email->to($order_id['email_address']);
		$this->email->set_mailtype("html");

		$this->email->subject('Donation - Notification Email');

		$message = $result['donar_first_name'];
		$message .= "<br>";
		$message .= $data_result['address1'];
		$message .= "<br>";
		$message .= $data_result['address2'];
		$message .= "<br>";
		$message .= $data_result['city'];
		$message .= "<br>";
		$message .= $data_result['postal_code'];
		$message .= "<br>";
		$message .= "<br>";
		$message .= date("j F, Y");
		$message .= "<br>";$message .= "<br>";
		$message .= "<div style='text-align: center;font-weight:bold;'>Thank you for your donation</div>";
		$message .= "<br>";
		$message .= "<br>";
		$message .= "Dear ".$result['donar_first_name'];
		$message .= "<br><br>";
		$message .= "Thank you so much for your support to ".$result['charity_name'];
		$message .= "<br><br>";
		$message .= "Attached is a receipt for your donation";
		$message .= "<br><br>";
	/*	$message .= $receipt_msg;
		$message .= "<br><br>";*/
		$message .= "Once again thank you for your support.";
		$message .= "<br><br>";
		$message .= "Yours sincerely,";
		$message .= "<br><br>";
		$message .= "<img src=".$email_signature." alt='logo' width='100px;'>";
		$message .= "<br>";
		$message .= "<br>";
		$message .= $result['signature_text'];
		$message .= "<br>";

		$pdf_message="";

		$pdf_message .= "<div style='float:left;'>";
		$pdf_message .= "<img style='float:left;' src=".$logo." alt='_logo' width='150px'>";
		$pdf_message .= "</div>";

		$pdf_message .= "<br>";
		$pdf_message .= $result['donar_first_name'].'<br>';

		$pdf_message .= $data_result['address2']."<br>";

		$pdf_message .= "<br><br>";
		$pdf_message .= date("j F, Y");
		$pdf_message .= "<br>";
		$pdf_message .= "<br>";
		$pdf_message .= "Dear ".$result['donar_first_name'].',';
		$pdf_message .= "<br><br>";
		$pdf_message .= "Thank you so much for your support to ".$result['charity_name'].".";
		$pdf_message .= "<br><br>";
		$pdf_message .= "<i>".$receipt_msg."</i>";
		$pdf_message .= "<br><br>";
		$pdf_message .= "Once again thank you for your support.";
		$pdf_message .= "<br><br>";
		$pdf_message .= "Yours sincerely,";
		$pdf_message .= "<br><br>";
		$pdf_message .= "<img src=".$email_signature." alt='logo' width='100px;'>";
		$pdf_message .= "<br>";$pdf_message .= "<br>";
		$pdf_message .= $result['signature_text'];

        $pdf_message .="<br><br><br><img src='".$cutter_image."'/><br><br>";

		 $pdf_message.="<div style='width:50%; float:left'><img src=".$logo." alt='logo' width='100px' /><br><br><div>".$result['donar_first_name']."<br>".$data_result['address1']."<br>".$data_result['address2']."<br>".$data_result['city']."<br>".$data_result['postal_code']."</div></div>";
		 $pdf_message.="<div style='width:50%; float:left'><span>".$result['charity_name']."</span><br><span><b>Donation Receipt</b></span><br><br><label>Charity Number: </label><span>".$result['registration_number']."</span><br><label>Donation Amount: </label><span>$".$order_id['amountSettlement']."</span><br><label>Transaction Number: </label><span>".$order_id['txn_id']."</span><br><label>Donation Date: </label><span>".date("j F, Y")."</span><br></div>";

		 $pdf_message .= "<br>";
		 $pdf_message .="<div style='width:100%;font-size:12px;'>All donations of $5 or above to a qualifying registered charity are eligible for a tax deductible in New Zealand.</div>";
		 $pdf_message .="<br>";


		$this->email->message($message);

		$this->load->library('m_pdf');

		$this->m_pdf->pdf->WriteHTML($pdf_message,2);

        if (ob_get_contents()) ob_end_clean();
	      //download it.

		$receipt_file_name = "Receipts-".$order_id['merchant_reference'];
		$this->m_pdf->pdf->Output('assets/donation_pdf/'.$receipt_file_name.'.pdf', 'F');
		$attachment_url = getcwd().'/assets/donation_pdf/'.$receipt_file_name.'.pdf';
		$this->email->attach($attachment_url);

		$resp = $this->email->send();
		return $receipt_file_name;
	}

	function dynamic_return(){
		if($_POST['respMsg'] == "success"){
			$out_array = array();
			$out_array['merchant_reference'] = $_POST['orderNumber'];
			$out_array['txn_id'] = $_POST['traceNumber'];
			$out_array['amountSettlement'] = $_POST['orderAmount'];

			// get email address
			$email_data = $this->payment_model->get_email_by_order_id($_POST['orderNumber']);

			if(!empty($email_data)){
				$out_array['email_address'] = $email_data;
			}else{
				$out_array['email_address'] = "darshansmore@gmail.com";
			}

			$result = $this->payment_model->update_payment_status($out_array['txn_id'],$out_array['merchant_reference']);
			$this->donation_success($out_array);

		}else{
			redirect('frontend/donation/donation_error_page', 'refresh');
		}
	}

	function dynamic_payment($data){

		require getcwd().'/application/libraries/dynamic/quickpay_service.php';
		mt_srand(quickpay_service::make_seed());
		$param['transType'] = quickpay_conf::CONSUME;
		$param['orderAmount'] = $data['amount'];
		$param['orderNumber'] = $data['order_id'];
		$param['orderTime']   = date('YmdHis');
		$param['orderCurrency'] = quickpay_conf::CURRENCY_CNY;

		// get organizer dps details by organizer id
		$cup_creds = $this->payment_model->get_cup_credential_details($data['organiser_id']);

		 if(!empty($cup_creds)){
			$merchant_id  =  $cup_creds['merchant_id']; #Important! Update with your Key
		}else{
			redirect('frontend/donation/donation_error_page', 'refresh');
		}

		$param['customerIp'] = $_SERVER['REMOTE_ADDR'];
		$param['frontEndUrl'] = $this->config->item('base_url')."/frontend/donation_orders/dynamic_return";
		$param['backEndUrl'] = $this->config->item('base_url')."/frontend/donation_orders/dynamic_return";

		$pay_service = new quickpay_service($param, quickpay_conf::FRONT_PAY,$merchant_id);
		$html = $pay_service->create_html();

		header("Content-Type: text/html; charset=UTF-8");

		echo $html;
	}

	function poli_payment($data){
		// get organizer poli details by organizer id

		$ticket_dps = $this->payment_model->get_ticket_suite_poli($data['organiser_id']);

		if(!empty($ticket_dps)){
			// get organizer dps details by organizer id
			if($ticket_dps['payment_method'] == 2){
				$dps_creds = $this->payment_model->get_poli_credential_details($data['organiser_id'],3);
			}else{
				$dps_creds = $this->payment_model->get_poli_credential_details($data['organiser_id'],1);
			}
		}else{
			redirect('frontend/donation/donation_error_page', 'refresh');
		}

		if(!empty($dps_creds)){
			$user_name = $dps_creds['account_id']; #Important! Update with your UserId
			$password  =  $dps_creds['password']; #Important! Update with your Key
		}else{
			redirect('frontend/donation/donation_error_page', 'refresh');
		}

		$order_id = $data['order_id'];

		// get details based on order_id
		$test_data = $this->donation_model->get_event_details_by_order_id($order_id);

		if(!empty($test_data)){
			$charity = $test_data['charity_name'];
			$title = $test_data['title'];
			$site = "TicketingSystem";
			$test_data =  $site."|".$order_id."|".$charity."|".$title;
		}else{
			$test_data = "";
		}

		$amount = $data['amount'];
		$json_builder = '{
		  "Amount":"'.$amount.'",
		  "CurrencyCode":"NZD",
		  "MerchantReference":"'.$order_id.'",
		  "MerchantReferenceFormat":"3",
		  "MerchantData":"'.$test_data.'",
		  "MerchantHomepageURL":"'.base_url().'frontend/donation_orders/poli_return",
		  "SuccessURL":"'.base_url().'/frontend/donation_orders/poli_return",
		  "FailureURL":"'.base_url().'/frontend/donation_orders/poli_return",
		  "CancellationURL":"'.base_url().'/frontend/donation_orders/poli_return",
		  "NotificationURL":"'.base_url().'/frontend/donation_orders/poli_return",
		}';

		$dummy_var = $user_name.":".$password;
		$auth = base64_encode($dummy_var);
		 $header = array();
		 $header[] = 'Content-Type: application/json';
		 $header[] = 'Authorization: Basic '.$auth;

		// $ch = curl_init("https://poliapi.apac.paywithpoli.com/api/Transaction/Initiate");

		$ch = curl_init("https://poliapi.apac.paywithpoli.com/api/Transaction/Initiate");
		 curl_setopt( $ch, CURLOPT_HTTPHEADER, $header);
		 curl_setopt( $ch, CURLOPT_HEADER, 0);
		 curl_setopt( $ch, CURLOPT_POST, 1);
		 curl_setopt( $ch, CURLOPT_POSTFIELDS, $json_builder);
		 curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 0);
		 curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
		 $response = curl_exec( $ch );
		 curl_close ($ch);

		 $json = json_decode($response, true);

		 if(isset($json["NavigateURL"])){
			  header('Location: '.$json["NavigateURL"]);
		 }else{
			 redirect('frontend/donation/donation_error_page', 'refresh');
		 }
	}



	function flo_2_cash_transaction($data){

	// get organizer poli details by organizer id
	$flo2_creds = $this->payment_model->get_flo2_credential_details($data['organiser_id']);

	if(!empty($flo2_creds)){
		$accout_id = $flo2_creds['account_id'];
	}else{
		redirect('frontend/donation/donation_error_page', 'refresh');
	}

	$return_url = base_url().'/frontend/donation_orders/flo_2_cash_return';
	$notification_url = base_url().'/frontend/donation_orders/flo_2_cash_return';
	$code = '<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
        <script type="text/javascript">
            function closethisasap() {
                document.forms["redirectpost"].submit();
            }
        </script>
    </head>
    <body onload="closethisasap();">
    <form action ="https://demo.flo2cash.co.nz/web2pay/default.aspx" method ="post" id="redirectpost">
	<input type="hidden" name="cmd" value="_xclick"/>
	<input type="hidden" name="account_id" value="'.$accout_id.'"/>
	<input type="hidden" name="return_url"value="'.$return_url.'"/>
	<input type="hidden" name="notification_url" value="'.$return_url.'"/>
	<input type="hidden" name ="header_image" value="http://local.ticketing_system.com/assets/frontend/images/TicketSuitLogo1_transparent.png"/>
	<input type="hidden" name="header_border_bottom"value="22FFDD"/>
	<input type="hidden" name="header_background_colour" value="22FFDD"/>
	<input type="hidden" name="store_card" value="0"/>
	<input type="hidden" name="csc_required" value="1"/>
	<input type="hidden" name="display_customer_email" value="0"/>
	<input type="hidden" name="amount" value="'.$data['amount'].'"/>
	<input type="hidden" name="item_name" value="'.$data['payment_for'].'"/>
	<input type="hidden" name="reference" value="'.$data['order_id'].'"/>
	<input type="hidden" name="custom_data" value="'.$data['order_id'].'"/>
	<input type="hidden" name="particular" value="'.$data['payment_for'].'"/>
	</form>
	</body>
    </html>';
	echo $code;
	}

	function flo_2_cash_return(){
		if($_POST['txn_status'] == "2"){
			$out_array = array();
			$out_array['merchant_reference'] = $_POST['custom_data'];
			$out_array['txn_id'] = $_POST['txn_id'];
			$out_array['amountSettlement'] = $_POST['amount'];

			// get email address
			$email_data = $this->payment_model->get_email_by_order_id($_POST['custom_data']);

			if(!empty($email_data)){
				$out_array['email_address'] = $email_data;
			}else{
				$out_array['email_address'] = "darshansmore@gmail.com";
			}

			$result = $this->payment_model->update_payment_status($out_array['txn_id'],$out_array['merchant_reference']);
			$this->donation_success($out_array);

		}else{
			redirect('frontend/donation/donation_error_page', 'refresh');
		}
	}

	function poli_return(){
		$dummy_order_id = $this->session->userdata['processing_order_id'];
		$org_id = $this->donation_model->get_organizer_by_order_id($dummy_order_id);

		$ticket_dps = $this->payment_model->get_ticket_suite_poli($org_id);

		if(!empty($ticket_dps)){
			// get organizer dps details by organizer id
			if($ticket_dps['payment_method'] == 2){
				$dps_creds = $this->payment_model->get_poli_credential_details($org_id,3);
			}else{
				$dps_creds = $this->payment_model->get_poli_credential_details($org_id,1);
			}
		}else{
			redirect('frontend/donation/donation_error_page', 'refresh');
		}

		if(!empty($dps_creds)){
			$user_name = $dps_creds['account_id']; #Important! Update with your UserId
			$password  =  $dps_creds['password']; #Important! Update with your Key
		}else{
			redirect('frontend/donation/donation_error_page', 'refresh');
		}

		$token = $_GET["token"];
		$dummy_var = $user_name.":".$password;
		$auth = base64_encode($dummy_var);
		$header = array();
		$header[] = 'Authorization: Basic '.$auth;
		$ch = curl_init("https://poliapi.apac.paywithpoli.com/api/Transaction/GetTransaction?token=".urlencode($token));
		curl_setopt( $ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt( $ch, CURLOPT_HEADER, 0);
		curl_setopt( $ch, CURLOPT_POST, 0);
		curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 0);
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
		$response = curl_exec( $ch );
		curl_close ($ch);

		$json = json_decode($response, true);

		// check for payment status
		if(!empty($json)){
			if($json['TransactionStatusCode'] == "Completed"){
				$out_array = array();
				$out_array['merchant_reference'] = $json['MerchantReference'];
				$out_array['txn_id'] = $json['TransactionRefNo'];
				$out_array['amountSettlement'] = $json['AmountPaid'];

				// get email address
				$email_data = $this->payment_model->get_email_by_order_id($json['MerchantReference']);

				if(!empty($email_data)){
					$out_array['email_address'] = $email_data;
				}else{
					$out_array['email_address'] = "darshansmore@gmail.com";
				}

				$result = $this->payment_model->update_payment_status($out_array['txn_id'],$out_array['merchant_reference']);
				$this->donation_success($out_array);
			}else{
				$this->session->set_flashdata('txn_gateway_status', $json['TransactionStatusCode']);
				$this->session->set_flashdata('order_error_id', $json['MerchantReference']);

				$out_array = array();
				$out_array['merchant_reference'] = $json['MerchantReference'];
				$out_array['txn_id'] = $json['TransactionRefNo'];

				$result = $this->payment_model->update_payment_status($out_array['txn_id'],$out_array['merchant_reference']);
				redirect('frontend/donation_orders/donation_error_page', 'refresh');
			}
		}else{
			redirect('frontend/donation/donation_error_page', 'refresh');
		}

	}

	/* function donation_error_page(){
		$order_number = $this->session->flashdata('order_error_id');
		// get champion id by order number
		$champion_id = $this->donation_model->get_champion_id_by_order_id($order_number);
		$viewArr['page_id'] = $champion_id;
		$viewArr['order_id'] = $order_number;
		$viewArr['status'] = $this->session->flashdata('txn_gateway_status');
		$viewArr['viewPage'] = "error_donation_page";
		$this->load->view('frontend/layout', $viewArr);
	} */
	function view_donations($id = NULL,$order_id = NULL){
		$data = $this->donation_model->view_champion_by_id($id);
		//get charity
		$organizer_data = $this->organiser_model->get_charity_details($data['charity_name']);
		$viewArr['organizer_data'] = $organizer_data;

		// get payment settings
		if(isset($organizer_data->organization_id)){
			$payment_details = $this->payment_model->get_organizer_payment_methods($organizer_data->organization_id);
		}else{
			$payment_details = "";
		}

		$amount_donated = $this->donation_model->amount_given($id);
		$viewArr['amount_donated'] = $amount_donated;
		$viewArr['data'] = $data;

		// get already field in information of user_data by order id
		$get_donar_info = $this->donation_model->get_donar_info($order_id,$id);

		if(empty($get_donar_info)){
			redirect('frontend/login', 'refresh');
		}else{
			$data = array();
			$data['donation_amount'] = $get_donar_info['donation_amount'];
			$data['donar_message'] = $get_donar_info['donor_message'];
			$data['first_name'] = $get_donar_info['first_name'];
			$data['email'] = $get_donar_info['email'];
			$data['salutation'] = $get_donar_info['salutation'];
			$data['donation_type'] = $get_donar_info['donor_name'];
			$data['phone_no'] = $get_donar_info['phone'];
			$data['street_address'] = $get_donar_info['street'];
			$data['city'] = $get_donar_info['city'];
			$data['country'] = $get_donar_info['country'];
			$data['suburb'] = $get_donar_info['suburb'];
			$data['postcode'] = $get_donar_info['postal_code'];
			$data['payment_method'] = $get_donar_info['payment_method'];
			$viewArr['user_data'] = $data;
		}

		$viewArr['payment_method'] = $payment_details;
		$viewArr['viewPage'] = "return_donation";
		$this->load->view('frontend/layout', $viewArr);
	}
}