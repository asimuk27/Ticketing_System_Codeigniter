<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Donation extends CI_Controller {

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
		$this->load->model('frontend/donation_model');
		$this->load->model('frontend/payment_model');
		$this->load->model('frontend/organiser_model');
		$this->load->library(array('form_validation','session','pagination'));
		$this->load->helper(array('form', 'url', 'file'));
		$passArg = array();
	}


	function view_donation($id = null){
		$data = $this->donation_model->view_champion_by_id($id);

		//get charity
		$organizer_data = $this->organiser_model->get_charity_details($data['charity_name']);
		$viewArr['organizer_data'] = $organizer_data;

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
			$viewArr['user_data'] = $data;
		}

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
	//	$this->form_validation->set_rules('phone', 'phone', 'trim|required');
		$this->form_validation->set_rules('country', 'country', 'trim|required|xss_clean');
	//	$this->form_validation->set_rules('pymt_method', 'pymt_method', 'trim|required|xss_clean');

		if($this->form_validation->run() == FALSE){
			//$this->add_new_champion();
			//$viewArr['amount_donated'] = $amount_donated;
			// check if user is logged in

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
			// build champions data array
			$data = array(
				'champion_page_id' => $id,
				'donor_message' => $this->input->post('donor_mssg'),
				'donor_name' => $this->input->post('org_name'),
				'salutation' => $this->input->post('select_salutation'),
				'donation_amount' => $this->input->post('target_amount'),
				'first_name' => $this->input->post('first_name'),
				'email' => $this->input->post('email'),
				'phone' => $this->input->post('phone'),
				'street' => $this->input->post('street'),
				'country' => $this->input->post('country'),
				'payment_method' => $this->input->post('pymt_method'),
				'status' => 0,
			);

			$result = $this->donation_model->save_donation($data);
			$viewArr['data'] = $data;

			if($result){
				$this->initiate_donation_payment($data,$result);
			}else{
				echo "error";
			}
			///	$this->session->set_flashdata('first_name',$this->input->post('first_name'));
			//redirect('frontend/donation/donation_success', 'refresh');
		}
	}

	function isProcessed($TxnId,$MerchantReference){
		# Check database if order relating to TxnId has alread been processed
		return false;
	}


	function output_url(){
		require getcwd().'/application/libraries/dps/dps.php';

		$PxPay_Url    = "https://uat.paymentexpress.com/pxaccess/pxpay.aspx";
		$PxPay_Userid = "AhuraConsulting_Dev"; #Important! Update with your UserId
		$PxPay_Key    =  "78efe7aad82db9354675fea0c9fa9484d5cdeaeee1be6ad90939ce74f8c14c98"; #Important! Update with your Key

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
		  $out_array['txn_id']             = $rsp->getTxnId();
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
			redirect('frontend/donation/donation_error_page', 'refresh');
		}
	}

	function initiate_donation_payment($data,$record_id){
		require getcwd().'/application/libraries/dps/dps.php';

		$PxPay_Url    = "https://uat.paymentexpress.com/pxaccess/pxpay.aspx";
		$PxPay_Userid = "AhuraConsulting_Dev"; #Important! Update with your UserId
		$PxPay_Key    =  "78efe7aad82db9354675fea0c9fa9484d5cdeaeee1be6ad90939ce74f8c14c98"; #Important! Update with your Key

		$pxpay = new PxPay_Curl($PxPay_Url,$PxPay_Userid,$PxPay_Key);

		$request = new PxPayRequest();

		// store data and get order number
		$result = $this->payment_model->get_last_payment_id();

		if($result->unique_id == ""){
			$randomNumber = "000000001";
		}else{
			//$string = substr($result->unique_id, 1, 9);
			$string = $result->unique_id + 1;
			$randomNumber = str_pad($string, 9, "0", STR_PAD_LEFT);
		}

		$data['order_id'] = $randomNumber;
		if(isset($this->session->userdata['logged_in']) && ($this->session->userdata['logged_in']['id'] != "")){
			$user_id = $this->session->userdata['logged_in']['id'];
		}else{
			$user_id = "";
		}

		// build payment data array
		$payment_data['order_id'] = $data['order_id'];
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
		$payment_data['payment_method'] = "dps";

		// store data for order processing
		$pay_data = $this->payment_model->save_order_information($payment_data);
		$update_status = $this->payment_model->update_donation_with_order_id($record_id,$data['order_id']);

		$script_url = $this->config->item('base_url').'frontend/donation/output_url';
		# the following variables are read from the form

		$MerchantReference = $data['order_id'];
		$Address1 = $data['phone'];
		$Address2 = $data['street'];
		$Address3 = $data['country'];

		#Calculate AmountInput
		$AmountInput = $data['donation_amount'];

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
		$viewArr['viewPage'] = "donation_success_page";
		$this->load->view('frontend/layout', $viewArr);
	}

	function donation_error_page(){
		$viewArr['viewPage'] = "error_page";
		$this->load->view('frontend/layout', $viewArr);
	}


	function send_a_donation_email($data_result = NULL,$order_id){

		$result = $this->donation_model->get_charity_information_by_order_id($order_id['merchant_reference']);

		if(empty($result)){
			return true;
		}
		//echo "<pre>";
		//print_r($result);exit;

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

		$message = $result['salute']." ".$result['donar_first_name'];
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
		$message .= $data_result['created_date'];
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
      // echo "<pre>";
      // print_r($data_result);exit;


		$pdf_message .= "<div style='float:left;'>";
		$pdf_message .= "<img style='float:left;' src=".$logo." alt='_logo' width='150px'>";
		$pdf_message .= "</div>";

		$pdf_message .= "<br>";
		$pdf_message .= $result['donar_first_name'].'<br>';
	/*
	$pdf_message .= $data_result['address1']."<br>";
	*/
		$pdf_message .= $data_result['address2']."<br>";
	/*
	$pdf_message .= $data_result['city'];
		$pdf_message .= "<br>";
		$pdf_message .= $data_result['postal_code'];
	*/
		$pdf_message .= "<br><br>";
		$pdf_message .= date("j F, Y");
		$pdf_message .= "<br>";
		$pdf_message .= "<br>";
		$pdf_message .= "Dear ".$result['donar_first_name'].',';
		$pdf_message .= "<br><br>";
		$pdf_message .= "Thank you so much for your support of our charity ".$result['charity_name'].".";
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
		//exit;
		$attachment_url = getcwd().'/assets/donation_pdf/'.$receipt_file_name.'.pdf';

		$this->email->attach($attachment_url);

		$resp = $this->email->send();
		return $receipt_file_name;
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */