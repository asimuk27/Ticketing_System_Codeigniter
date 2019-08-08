<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Orders extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    function __construct() {
        parent::__construct();
        //Load all required classes
        $this->load->model('frontend/organiser_model');
        $this->load->model('frontend/event_model');
        $this->load->model('frontend/payment_model');
        $this->load->model('frontend/donation_model');
        $this->load->model('frontend/login_model');
        $this->load->library(array('form_validation', 'session', 'pagination', 'image_lib'));
        $this->load->helper(array('form', 'url', 'file', 'pdf_helper'));
        $this->load->library('ciqrcode');

        $passArg = array();
    }

    function save_order_details() {


        if (!isset($this->session->userdata['cart'])) {
            redirect('frontend/home', 'refresh');
        }

        $data = array();
        if (isset($this->session->userdata['logged_in']['id'])) {
            $session_data = $this->session->userdata['logged_in'];
            $user_id = $session_data['id'];
            $login_type = $session_data['login_type'];
        } else {
            $user_id = 0;
            $login_type = 0;
        }

        $result = $this->payment_model->get_last_payment_id();

        if ($result->unique_id == "") {
            $randomNumber = "000000001";
        } else {
            $string = $result->unique_id + 1;
            $randomNumber = str_pad($string, 9, "0", STR_PAD_LEFT);
        }
        $this->session->set_userdata('order_no', $randomNumber);
        $store_ticket_details = array();
        $get_event_id = $this->event_model->get_event_id($this->session->userdata['cart']['sub_event_id']);
        $s = 0;

        $ticket_ids = array_column($this->session->userdata['ticket_data'], "id");

        $get_ticket_prices = $this->event_model->get_ticket_price_from_ids($ticket_ids);


        for ($i = 0; $i < sizeof($this->session->userdata['ticket_data']); $i++) {
            for ($j = 0; $j < $this->session->userdata['ticket_data'][$i]['qyt']; $j++) {
//                $get_ticket_price = $this->event_model->get_ticket_price($this->session->userdata['ticket_data'][$i]['id']);

                $get_ticket_price = $get_ticket_prices[$this->session->userdata['ticket_data'][$i]['id']];


                $tickets_generated['order_id'] = $randomNumber;
                $tickets_generated['event_id'] = $get_event_id[0]['event_id'];
                $tickets_generated['sub_event_id'] = $this->session->userdata['cart']['sub_event_id'];
                $tickets_generated['ticket_name'] = $this->session->userdata['ticket_data'][$i]['ticket_name'];
                $tickets_generated['price'] = $get_ticket_price['price'];
                $tickets_generated['qyt'] = 1;
                $tickets_generated['ticket_id'] = $this->session->userdata['ticket_data'][$i]['id'];
                $tickets_generated['user_id'] = $user_id;
                $tickets_generated['login_type'] = $login_type;
                $tickets_generated['ticket_pdf'] = '';
                $tickets_generated['ticket_sequence_no'] = '';
                $tickets_generated['ticket_scan_status'] = '0';

//                print_r($tickets_generated);

                $id_count = $this->event_model->save_ticket_generation($tickets_generated);

                $tickets_generated = array();
            }
        }

//        die("dd");

        if (isset($this->session->userdata['champion_data'])) {
            $donar = array();
            for ($m = 0; $m < sizeof($this->session->userdata['champion_data']); $m++) {
                $donar['champion_page_id'] = $this->session->userdata['champion_data'][$m]['champ_choose'];
                $donar['order_id'] = $randomNumber;
                $donar['donation_amount'] = $this->session->userdata['champion_data'][$m]['champ_amount'];
                $donar['donor_message'] = $this->session->userdata['champion_data'][$m]['champ_message'];
                $donar['donor_name'] = $this->session->userdata['champion_data'][$m]['champ_name'];
                $donar['first_name'] = $_POST['g_fname'];
                $donar['last_name'] = $_POST['g_lname'];
                $donar['email'] = $_POST['g_email'];
                $donar['country'] = $_POST['g_country'];
                $donar['payment_method'] = $_POST['check_out_method'];
                $donar['payment_status'] = 0;
                $donar['status'] = 0;
                $donar['event_id'] = 0;
                $donar['donation_type'] = '';
                $donar['salutation'] = '';
                $donar['phone'] = '';
                $donar['street'] = $_POST['g_addr'];
                $donar['suburb'] = $_POST['g_addr2'];
                $donar['city'] = $_POST['g_city'];
                $donar['postal_code'] = $_POST['g_postal'];
                $donar['communication_required'] = 0;
                $this->event_model->save_donar_details($donar);
            }
        }

        // store data and get order number

        $data['order_id'] = $randomNumber;
        $data['user_id'] = $user_id;
        $data['login_type'] = $login_type;
        $data['email'] = $this->input->post('g_email');
        $data['status'] = 0;

        $data['amount'] = $this->session->userdata['total_order_amt'];
        $data['txn_date'] = date("Y-m-d H:i:s");
        $data['reference_number'] = '';
        $data['txn_number'] = '';
        $data['payment_for'] = 'purchase ticket';
        $data['created_date'] = date("Y-m-d H:i:s");
        $data['first_name'] = $this->input->post('g_fname');
        $data['last_name'] = $this->input->post('g_lname');
        $data['country'] = $this->input->post('g_country');
        $data['address1'] = $this->input->post('g_addr');
        $data['address2'] = $this->input->post('g_addr2');
        $data['city'] = $this->input->post('g_city');
        $data['postal_code'] = $this->input->post('g_postal');
        $data['payment_method'] = $this->input->post('check_out_method');



        $org_data = $this->payment_model->get_organiser_id_for_bookings($this->session->userdata['book_sub_event_id']);
        $data['organiser_id'] = $org_data;

        $this->session->set_userdata('processing_order_id', $randomNumber);


        $data1 = array(
            'first_name' => $this->input->post('g_fname'),
            'last_name' => $this->input->post('g_lname'),
            'preffered_name' => '',
            'email' => $this->input->post('g_email'),
            'phone_no' => $this->input->post('phone_no'),
            'password' => md5($this->input->post('password')),
            'login_type' => '',
            'street_address' => $this->input->post('g_addr'),
            'suburb' => $this->input->post('g_addr2'),
            'city' => $this->input->post('g_city'),
            'postcode' => $this->input->post('g_postal'),
            'country' => $this->input->post('g_country'),
            'birth_date' => '',
            'created_date' => date("Y-m-d h:i:sa"),
            'last_login' => '',
            'image_path' => ''
        );

        $val = $this->login_model->check_user_email($this->input->post('g_email'));
        if ($this->session->userdata('logged_in')) {



            $this->event_model->save_payment_summary($data);
            if ($data['amount'] != "0") {
                $this->initiate_order_payment($data);
            } else {
                $out_array = array();
                $this->generate_tickets($out_array);

                $this->session->set_flashdata('result_data', $data['order_id']);
                redirect('frontend/events/payment_success_url', 'refresh');
            }
        } else {
            if ($val == '1') {
                // echo "here";
                $this->session->set_flashdata('msg', 'Email Already Exist');
                redirect('frontend/events/save_ticket_details', 'refresh');
            } else {
                //  echo "+++";
                $this->login_model->add_user($data1);
                $this->event_model->save_payment_summary($data);
                if ($data['amount'] != "0") {
                    $this->initiate_order_payment($data);
                } else {
                    $out_array = array();
                    $this->generate_tickets($out_array);

                    $this->session->set_flashdata('result_data', $data['order_id']);
                    redirect('frontend/events/payment_success_url', 'refresh');
                }
            }
        }
    }

    function call_to_payment($data) {
        echo $data;
        exit;
    }

    function initiate_order_payment($data) {

        $pay_method = $data['payment_method'];



        switch ($pay_method) {
            case "flo_2_cash":
                $this->flo_2_cash_transaction($data);
                break;
            case "cup":
                $this->dynamic_payment($data);
                break;
            case "poli":
                $this->initiate_poli_payment($data);
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

    function return_poli() {
        $dummy_order_id = $this->session->userdata['processing_order_id'];
        $org_id = $this->donation_model->get_organizer_by_order_id($dummy_order_id);

        $ticket_dps = $this->payment_model->get_ticket_suite_poli($org_id);

        if (!empty($ticket_dps)) {
            // get organizer dps details by organizer id
            if ($ticket_dps['payment_method'] == 2) {
                $dps_creds = $this->payment_model->get_poli_credential_details($org_id, 3);
            } else {
                $dps_creds = $this->payment_model->get_poli_credential_details($org_id, 1);
            }
        } else {
            redirect('frontend/donation/donation_error_page', 'refresh');
        }

        if (!empty($dps_creds)) {
            $user_name = $dps_creds['account_id']; #Important! Update with your UserId
            $password = $dps_creds['password']; #Important! Update with your Key
        } else {
            redirect('frontend/donation/donation_error_page', 'refresh');
        }

        $token = $_GET["token"];

        $dummy_var = $user_name . ":" . $password;
        $auth = base64_encode($dummy_var);

        $header = array();
        $header[] = 'Authorization: Basic ' . $auth;

        $ch = curl_init("https://poliapi.apac.paywithpoli.com/api/Transaction/GetTransaction?token=" . urlencode($token));
        //	 curl_setopt( $ch, CURLOPT_CAINFO, "ca-bundle.crt");
        //	 curl_setopt( $ch, CURLOPT_SSLVERSION, 6);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);

        $json = json_decode($response, true);

        // check for payment status
        if (!empty($json)) {
            if ($json['TransactionStatusCode'] == "Completed") {
                $order_id = $json['MerchantReference'];
                $check_email_status = $this->payment_model->check_email_order_status($order_id);

                if ($check_email_status) {
                    $out_array = array("payment_method" => 'poli', "txn_id" => $json['TransactionRefNo']);
                    $this->generate_tickets($out_array);
                    $this->clear_data_on_payment_success();
                    $this->session->set_flashdata('result_data', $order_id);
                    redirect('frontend/events/payment_success_url', 'refresh');
                } else {
                    return true;
                }
            } else {
                $this->session->set_flashdata('txn_gateway_status', $json['TransactionStatusCode']);
                redirect('frontend/orders/error_page', 'refresh');
            }
        } else {
            redirect('frontend/donation/donation_error_page', 'refresh');
        }
    }

    function initiate_poli_payment($data) {



        $ticket_dps = $this->payment_model->get_ticket_suite_poli($data['organiser_id']);

        if (!empty($ticket_dps)) {
            // get organizer dps details by organizer id
            if ($ticket_dps['payment_method'] == 2) {
                $dps_creds = $this->payment_model->get_poli_credential_details($data['organiser_id'], 3);
            } else {
                $dps_creds = $this->payment_model->get_poli_credential_details($data['organiser_id'], 1);
            }
        } else {
            redirect('frontend/donation/donation_error_page', 'refresh');
        }

        if (!empty($dps_creds)) {
            $user_name = $dps_creds['account_id']; #Important! Update with your UserId
            $password = $dps_creds['password']; #Important! Update with your Key
        } else {
            redirect('frontend/donation/donation_error_page', 'refresh');
        }

        $order_id = $data['order_id'];
        $amount = $data['amount'];
        $json_builder = '{
		  "Amount":"' . $amount . '",
		  "CurrencyCode":"NZD",
		  "MerchantReference":"' . $order_id . '",
		  "MerchantHomepageURL":"' . base_url() . 'frontend/orders/return_poli",
		  "SuccessURL":"' . base_url() . '/frontend/orders/return_poli",
		  "FailureURL":"' . base_url() . '/frontend/orders/return_poli",
		  "CancellationURL":"' . base_url() . '/frontend/orders/return_poli",
		  "NotificationURL":"' . base_url() . '/frontend/orders/return_poli",
		}';

        $dummy_var = $user_name . ":" . $password;
        $auth = base64_encode($dummy_var);

        $header = array();
        $header[] = 'Content-Type: application/json';
        $header[] = 'Authorization: Basic ' . $auth;

        $ch = curl_init("https://poliapi.apac.paywithpoli.com/api/Transaction/Initiate");
        //See the cURL documentation for more information: http://curl.haxx.se/docs/sslcerts.html
        //We recommend using this bundle: https://raw.githubusercontent.com/bagder/ca-bundle/master/ca-bundle.crt
        //	 curl_setopt( $ch, CURLOPT_CAINFO, "ca-bundle.crt");
        //	 curl_setopt( $ch, CURLOPT_SSLVERSION, 6);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_builder);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);

        $json = json_decode($response, true);

        header('Location: ' . $json["NavigateURL"]);
    }

    function flo_2_cash_transaction($data) {
        $return_url = base_url() . '/frontend/orders/flo_2_cash_return';
        $notification_url = base_url() . '/frontend/orders/flo_2_cash_return';
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
	<input type="hidden" name="account_id" value="621503"/>
	<input type="hidden" name="return_url"value="' . $return_url . '"/>
	<input type="hidden" name="notification_url" value="' . $return_url . '"/>
	<input type="hidden" name ="header_image"value="http://local.ticketing_system.com/assets/frontend/images/TicketSuitLogo1_transparent.png"/>
	<input type="hidden" name="header_border_bottom"value="22FFDD"/>
	<input type="hidden" name="header_background_colour" value="22FFDD"/>
	<input type="hidden" name="store_card" value="0"/>
	<input type="hidden" name="csc_required" value="1"/>
	<input type="hidden" name="display_customer_email" value="0"/>
	<input type="hidden" name="amount" value="' . $data['amount'] . '"/>
	<input type="hidden" name="item_name" value="' . $data['payment_for'] . '"/>
	<input type="hidden" name="reference" value="' . $data['order_id'] . '"/>
	<input type="hidden" name="custom_data" value="' . $data['order_id'] . '"/>
	<input type="hidden" name="particular" value="' . $data['payment_for'] . '"/>
	</form>
	</body>
    </html>';
        echo $code;
    }

    function flo_2_cash_return() {
        if ($_POST['txn_status'] == "2") {
            $order_id = $_POST['custom_data'];
            $check_email_status = $this->payment_model->check_email_order_status($_POST['custom_data']);

            if ($check_email_status) {
                $out_array = array("payment_method" => 'flo_2_cash', "txn_id" => $_POST['txn_id']);
                $this->generate_tickets($out_array);
                $this->clear_data_on_payment_success();
                $this->session->set_flashdata('result_data', $order_id);
                redirect('frontend/events/payment_success_url', 'refresh');
            } else {
                return true;
            }
        } else {
            redirect('frontend/donation/donation_error_page', 'refresh');
        }
    }

    function dps_transaction($data) {

        require getcwd() . '/application/libraries/dps/dps.php';

        // get if organizer or TicketingSystem admin to be used
        $ticket_dps = $this->payment_model->get_ticket_suite_dps($data['organiser_id']);

        if (!empty($ticket_dps)) {
            // get organizer dps details by organizer id
            if ($ticket_dps['payment_method'] == 2) {

                $dps_creds = $this->payment_model->get_dps_credential_details($data['organiser_id'], 4);
            } else {
                $dps_creds = $this->payment_model->get_dps_credential_details($data['organiser_id'], 1);
            }
        } else {
            redirect('frontend/donation/donation_error_page', 'refresh');
        }


        if (!empty($dps_creds)) {
            //$PxPay_Url    = "https://sec.paymentexpress.com/pxaccess/pxpay.aspx";
            $PxPay_Url = "https://uat.paymentexpress.com/pxaccess/pxpay.aspx";
            $PxPay_Userid = $dps_creds['pxpayuserid']; #Important! Update with your UserId
            $PxPay_Key = $dps_creds['pxpaykey']; #Important! Update with your Key
        } else {
            redirect('frontend/donation/donation_error_page', 'refresh');
        }



        $pxpay = new PxPay_Curl($PxPay_Url, $PxPay_Userid, $PxPay_Key);

        $request = new PxPayRequest();

        $script_url = $this->config->item('base_url') . 'index.php/frontend/orders/dps_output_url';
        # the following variables are read from the form

        $MerchantReference = $data['order_id'];
        $Address1 = $data['address1'];
        $Address2 = $data['address2'];
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
        $request->setUrlFail($script_url);   # can be a dedicated failure page
        $request->setUrlSuccess($script_url);   # can be a dedicated success page
        $request->setTxnId($TxnId);

        #Call makeRequest function to obtain input XML
        $request_string = $pxpay->makeRequest($request);

        #Obtain output XML
        $response = new MifMessage($request_string);

        #Parse output XML
        $url = $response->get_element_text("URI");
        $valid = $response->get_attribute("valid");



        #Redirect to payment page
        header("Location: " . $url);
    }

    function dps_output_url() {
        require getcwd() . '/application/libraries/dps/dps.php';

        // get credrentials by order id
        $dummy_order_id = $this->session->userdata['processing_order_id'];

        $org_id = $this->donation_model->get_organizer_by_order_id($dummy_order_id);

        // get organizer dps details by organizer id
        $dps_creds = $this->payment_model->get_ticket_suite_dps($org_id);



        if (!empty($dps_creds)) {
            // get organizer dps details by organizer id
            if ($dps_creds['payment_method'] == 2) {

                $dps_creds = $this->payment_model->get_dps_credential_details($org_id, 4);
            } else {
                $dps_creds = $this->payment_model->get_dps_credential_details($org_id, 1);
            }
        } else {
            redirect('frontend/donation/donation_error_page', 'refresh');
        }


        if (!empty($dps_creds)) {
            //$PxPay_Url    = "https://sec.paymentexpress.com/pxaccess/pxpay.aspx";
            $PxPay_Url = "https://uat.paymentexpress.com/pxaccess/pxpay.aspx";
            $PxPay_Userid = $dps_creds['pxpayuserid']; #Important! Update with your UserId
            $PxPay_Key = $dps_creds['pxpaykey']; #Important! Update with your Key
        } else {
            redirect('frontend/donation/donation_error_page', 'refresh');
        }
        /* 	$PxPay_Url    = "https://sec.paymentexpress.com/pxaccess/pxpay.aspx";
          $PxPay_Userid = "TicketingSystemHPP";
          $PxPay_Key    =  "f2188ecf1dc3d5e4c63ba07b74d7879cf08f15854fff8f7da42f504e478789ea";
         */
        $pxpay = new PxPay_Curl($PxPay_Url, $PxPay_Userid, $PxPay_Key);

        $enc_hex = $_REQUEST["result"];
        #getResponse method in PxPay object returns PxPayResponse object
        #which encapsulates all the response data
        $rsp = $pxpay->getResponse($enc_hex);

        # the following are the fields available in the PxPayResponse object
        //build output array
        $out_array = array();
        $out_array['success'] = $rsp->getSuccess();   # =1 when request succeeds
        $out_array['amountSettlement'] = $rsp->getAmountSettlement();
        $out_array['auth_code'] = $rsp->getAuthCode();  # from bank
        $out_array['card_name'] = $rsp->getCardName();  # e.g. "Visa"
        $out_array['card_number'] = $rsp->getCardNumber(); # Truncated card number
        $out_array['date_expiry'] = $rsp->getDateExpiry(); # in mmyy format
        $out_array['dps_billing_id'] = $rsp->getDpsBillingId();
        $out_array['billing_id'] = $rsp->getBillingId();
        $out_array['card_holder_name'] = $rsp->getCardHolderName();
        $out_array['dps_txn_ref'] = $rsp->getDpsTxnRef();
        $out_array['txn_type'] = $rsp->getTxnType();
        $out_array['txn_data_1'] = $rsp->getTxnData1();
        $out_array['txn_data_2'] = $rsp->getTxnData2();
        $out_array['txn_data_3'] = $rsp->getTxnData3();
        $out_array['currency_settlement'] = $rsp->getCurrencySettlement();
        $out_array['client_info'] = $rsp->getClientInfo(); # The IP address of the user who submitted the transaction
        $out_array['txn_id'] = $rsp->getDpsTxnRef();
        $out_array['currency_input'] = $rsp->getCurrencyInput();
        $out_array['email_address'] = $rsp->getEmailAddress();
        $out_array['merchant_reference'] = $rsp->getMerchantReference();
        $out_array['response_text'] = $rsp->getResponseText();
        $out_array['txn_mac'] = $rsp->getTxnMac(); # An indication as to the uniqueness of a card used in relation to others

        if ($rsp->getSuccess() == "1") {

            # Sending invoices/updating order status within database etc.
            if (!$this->isProcessed($out_array['txn_id'], $out_array['merchant_reference'])) {
                $order_id = $this->session->userdata['order_no'];
                $this->generate_tickets($out_array);
                $this->clear_data_on_payment_success();
                $this->session->set_flashdata('result_data', $order_id);
                redirect('frontend/events/payment_success_url', 'refresh');
            }
        } else {
            $this->session->set_flashdata('txn_gateway_status', $rsp->ResponseText);
            redirect('frontend/orders/error_page', 'refresh');
        }
    }

    function generate_tickets($out_array) {
        $order_id = $this->session->userdata['order_no'];
        //if payment is completed mark tickets as processed
        $alter_status = $this->event_model->update_ticket_generated_on_order_success($order_id);

        // generate qa code for tickets of this order
        // get ticket information by order id
        $tickets_data = $this->event_model->get_tickets_generated($this->session->userdata['order_no']);

        // foreach ticket data generate qr code
        foreach ($tickets_data as $result_tickets) {
            $params['data'] = base64_encode($order_id . '_' . $result_tickets['id'] . '_' . $result_tickets['user_id']);
            $params['level'] = 'H';
            $params['size'] = 5;
            $params['cachedir'] = FCPATH . 'qr_code_images/';
            $params['savename'] = FCPATH . 'qr_code_images/' . time() . $result_tickets['id'] . '.png';
            $image_name = time() . $result_tickets['id'] . '.png';
            $this->ciqrcode->generate($params);

            // function to create sequence number
            $sequence = $this->event_model->create_sequence_number($result_tickets['event_id'], $result_tickets['sub_event_id'], $result_tickets['ticket_id']);

            // update ticket data with qa code information
            //build data array
            $qr_code_data = array();
            $qr_code_data['qr_code_image'] = $image_name;
            $qr_code_data['qr_data'] = $params['data'];
            $qr_code_data['ticket_sequence_no'] = $sequence['0']['result_count'] + 1;
            $qr_code_data['id'] = $result_tickets['id'];

            $update_status = $this->event_model->update_ticket_after_payment_process($qr_code_data);
        }

        $this->load->library('m_pdf');

        $tickets_generated = $this->event_model->get_tickets_generated($order_id);
        $get_description = $this->event_model->get_sub_event_details($this->session->userdata['cart']['sub_event_id']);

        $start_date = date("jS F Y", strtotime($get_description[0]['schedule_start_date']));
        $end_date = date("F jS, Y", strtotime($get_description[0]['schedule_end_date']));
        $start_time = $get_description[0]['schedule_start_time'];
        $end_time = $get_description[0]['schedule_end_time'];
        $title = $get_description[0]['schedule_title'];
        $location = $get_description[0]['schedule_location'];

        $final = explode(",", $location);
        $event_count = count($final);

        $url_link = $this->config->item('baseurl');


        $content = '';
        $no_of_ticket = count($tickets_generated);
        foreach ($tickets_generated as $tg) {
            if ($no_of_ticket > '0') {
                $no_of_ticket = $no_of_ticket - 1;
            }
            $content = '';
            $ticket_unique_id = $tg["id"];
            $image_url = $tg["qr_code_image"];
            $ticket_id_no = $tg["ticket_id"];
            $ticket_seq_no = $tg["ticket_sequence_no"];
            $o_id = $tg['order_id'];
            $add_image = "http://TicketingSystem.co.nz/assets/frontend/images/TicketSuitLogo1_transparent.png";


            $content .= '<table class="main_table" cellspacing="7" cellpadding="0">
						<tbody>
							<tr>
								<td colspan="8" style="background: white;" class="fifth"><div class="ticket_labels unique_style">Event Title: </div><div class="title_headings">
								 ' . $title . '</div></td>
								<td colspan="3" rowspan="6" class="ticket_id"><span class="ticket_id_style">Ticket ID:</span>' . $ticket_unique_id . '
									<table class="inner_table" cellspacing="0" cellpadding="0">
										<tbody>
											<tr class="">
												<td id="qa_code_css" style="background: white;border:3px solid black;padding:5px;"><img class="qa_image" src="' . $url_link . 'qr_code_images/' . $image_url . '"></td>
											</tr>
											<tr class="">
													<td id="qa_code_css" style="padding:5px;"><a target="_blank" href="http://local.ticketing_system.com/"><img style="height:45px;" class="qa_image" src="' . $add_image . '"></a></td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="4" class="fifth"><div class="ticket_labels unique_style go_left">Event Date:</div>' . $start_date . '</td>
								<td colspan="4" class="fifth"><div class="go_right ticket_labels unique_style">Event Time:</div> ' . $start_time . '</td>
							</tr>
							<tr>
								<td colspan="8" rowspan="1" style="background: white;border:1px solid #ccc" class="fifth"><div class="ticket_labels unique_style">Location:</div>' . $location;


            $content .= '</td>
							</tr>
							<tr>
								<td colspan="8" rowspan="1" style="background: white;border:1px solid #ccc" class="fifth"><div class="ticket_labels unique_style">Ticket Sequence No:</div> ' . $ticket_seq_no . ' </td>
							</tr>
							<tr>
								<td colspan="8" rowspan="1" style="background: white;border:1px solid #ccc" class="fifth"><div class="ticket_labels unique_style">Ticket Category:</div> ' . $tg['ticket_name'] . '</td>
							</tr>';
            $content .='</tbody></table>';
            $content .= '<br><br>';


            $stylesheet = $this->get_web_page('http://TicketingSystem.co.nz/assets/frontend/css/ticket_style.css');
            $new_style = "table tr td{background:#fff;border:1px solid #dddddd;height:20px !important;}";

            $this->m_pdf->pdf->WriteHTML($stylesheet, 1);
            $this->m_pdf->pdf->WriteHTML($new_style, 1);

            $this->m_pdf->pdf->WriteHTML($content, 2);

            if ($no_of_ticket > 0) {
                $this->m_pdf->pdf->AddPage();
            }
        }

        if (ob_get_contents())
            ob_end_clean();
        //download it.
        $this->m_pdf->pdf->Output('assets/tickets_generated/' . $order_id . '.pdf', 'F');


        $check_email_status = $this->payment_model->check_email_order_status($order_id);

        if (empty($out_array)) {
            $result = $this->payment_model->update_payment_status('free_order', $order_id);
        } else {
            $result = $this->payment_model->update_payment_status($out_array['txn_id'], $order_id);
        }

        if ($check_email_status) {
            $this->send_order_email($order_id);
        }

        return $result;
    }

    function get_web_page($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $contents = curl_exec($ch);
        if (curl_errno($ch)) {
            echo curl_error($ch);
            echo "\n<br />";
            $contents = '';
        } else {
            curl_close($ch);
        }

        if (!is_string($contents) || !strlen($contents)) {
            echo "Failed to get contents.";
            $contents = '';
        }

        return $contents;
    }

    function clear_data_on_payment_success() {
        $this->session->unset_userdata('cart');
        $this->session->unset_userdata('ticket_data');
        $this->session->unset_userdata('champion_data');
        $this->session->unset_userdata('total_order_amt');
        $this->session->unset_userdata('total_qytt');

        $result = $this->payment_model->update_donation_status($out_array['merchant_reference']);

        if (isset($this->session->userdata['order_no'])) {
            $result = $this->payment_model->update_donation_status($this->session->userdata['order_no']);

            $order_no = $this->session->userdata['order_no'];
            $get_all_ticket_ids = $this->event_model->get_ticket_ids($order_no);
            for ($i = 0; $i < sizeof($get_all_ticket_ids); $i++) {
                $count_ticket_qyt = $this->event_model->calculate_qyts($get_all_ticket_ids[$i]['ticket_id'], $order_no);
                $update_ticket_qyt = $this->event_model->update_qyts($get_all_ticket_ids[$i]['ticket_id'], $count_ticket_qyt[0]['qyts_sold']);
            }
            $this->session->unset_userdata('order_no');
        }

        return true;
    }

    function send_order_email($order_id = NULL) {

        $details = $this->event_model->get_tickets_generated_email($order_id);

        $order_info = $this->event_model->get_order_history_information($order_id);

        // get donation details
        $order_donation_summary = $this->event_model->get_donation_per_order($order_id);
        $donation_attachment = "";
        if (isset($details['0'])) {
            $data = array();
            $data['even_sub_events'] = $details['0'];
            // get event details
            $event_details = $this->event_model->get_event_info_email($data['even_sub_events']['event_id']);
            $data['order_info'] = $order_info;
            $order_notify_email = $data['order_info']['email'];
            $data['event_details'] = $event_details;

            // get charity details
            $organizer_data = $this->event_model->get_organiser_details($event_details['organiser_id']);
            $data['organizer_data'] = $organizer_data;
            $data['ticket_data'] = $details;

            // get organizer email information
            $organizer_email = $this->event_model->get_organizer_address($event_details['organiser_id']);

            $data['organizer_email'] = $organizer_email;

            // get total ticket amount for a specific order
            $ticket_price_total = $this->event_model->get_ticket_price_per_order($order_id);
            $data['ticket_total_price'] = $ticket_price_total;

            $data['order_donation_summary'] = $order_donation_summary;
            $data['total_order_donation'] = $this->event_model->get_donation_amount_of_order($order_id);
            if ($order_donation_summary) {
                // generate donation receipt
                $donation_data['order_id'] = $order_id;
                $donation_data['to_email_address'] = $order_info['email'];
                $donation_data['amount_donated'] = $data['total_order_donation'];
                $donation_data['txn_id'] = $order_info['txn_number'];

                $donation_attachment = $this->generate_donation_receipt($donation_data);
            }
        } else if (isset($order_donation_summary['0'])) {

            $data = array();
            $data['even_sub_events']['order_id'] = $order_id;
            // get event details
            $event_details = $this->event_model->get_event_info_email($order_donation_summary['0']['event_id']);
            $data['order_info'] = $order_info;
            $order_notify_email = $data['order_info']['email'];
            $data['event_details'] = $event_details;

            // get charity details
            $organizer_data = $this->event_model->get_organiser_details($event_details['organiser_id']);
            $data['organizer_data'] = $organizer_data;
            $data['ticket_data'] = $details;

            // get organizer email information
            $organizer_email = $this->event_model->get_organizer_address($event_details['organiser_id']);

            $data['organizer_email'] = $organizer_email;

            // get total ticket amount for a specific order
            $ticket_price_total = $this->event_model->get_ticket_price_per_order($order_id);
            $data['ticket_total_price'] = $ticket_price_total;

            $data['order_donation_summary'] = $order_donation_summary;
            $data['total_order_donation'] = $this->event_model->get_donation_amount_of_order($order_id);
            if ($order_donation_summary) {
                // generate donation receipt
                $donation_data['order_id'] = $order_id;
                $donation_data['to_email_address'] = $order_info['email'];
                $donation_data['amount_donated'] = $data['total_order_donation'];
                $donation_data['txn_id'] = $order_info['txn_number'];

                $donation_attachment = $this->generate_donation_receipt($donation_data);
            }
        }


        $attachment_url = getcwd() . '/assets/tickets_generated/' . $order_id . '.pdf';
        //storing data in a databse
        $email = "quagnitia.testuser1@gmail.com";
        $name = "darshan";

        //configure email settings
        $config['protocol'] = 'sendmail';
        $config['smtp_host'] = 'ssl://smtp.gmail.com';
        $config['smtp_user'] = 'jeetendra.gawas@quagnitia.com';
        $config['smtp_pass'] = 'babji123';

        $config['mailtype'] = 'html';

        $config['charset'] = 'iso-8859-1';

        $config['wordwrap'] = TRUE;

        $config['newline'] = "\r\n"; //use double quotes

        $this->load->library('email', $config);

        $this->email->initialize($config);

        //send mail

        $this->email->from("admin@ticketing_system.com", "TicketingSystem");

        $this->email->subject('Order Notification for ' . $data['event_details']['title']);

        $this->email->to($order_notify_email);

        $body = $this->load->view('templates/email_template', $data, TRUE);

        if (!empty($details)) {
            $this->email->attach($attachment_url);
        }

        if (!empty($donation_attachment)) {
            $this->email->attach($donation_attachment);
        }

        $this->email->message($body);
        $flag = $this->email->send();
    }

    function generate_donation_receipt($input_data = NULL) {

        $result = $this->donation_model->get_charity_information_by_order_id($input_data['order_id']);

        if (empty($result)) {
            return true;
        }

        $receipt_msg = $result['donation_receipt_text'];
        $email_signature = $this->config->item('organisation_signature') . $result['signature'];
        $logo = $this->config->item('organisation_logo') . $result['logo'];
        $cutter_image = $this->config->item('default_image_url') . 'kator.jpg';
        $thank_you = $this->config->item('default_image_url') . 'd.jpg';

        $pdf_message = "";

        $pdf_message .= "<div style='float:left;'>";
        $pdf_message .= "<img style='float:left;' src=" . $logo . " alt='_logo' width='150px'>";
        $pdf_message .= "</div>";

        $pdf_message .= "<br>";
        $pdf_message .= $result['donar_first_name'] . '<br>';

        $pdf_message .= $data_result['address2'] . "<br>";

        $pdf_message .= "<br><br>";
        $pdf_message .= date("j F, Y");
        $pdf_message .= "<br>";
        $pdf_message .= "<br>";
        $pdf_message .= "Dear " . $result['donar_first_name'] . ',';
        $pdf_message .= "<br><br>";
        $pdf_message .= "Thank you so much for your support to " . $result['charity_name'] . ".";
        $pdf_message .= "<br><br>";
        $pdf_message .= "<i>" . $receipt_msg . "</i>";
        $pdf_message .= "<br><br>";
        $pdf_message .= "Once again thank you for your support.";
        $pdf_message .= "<br><br>";
        $pdf_message .= "Yours sincerely,";
        $pdf_message .= "<br><br>";
        $pdf_message .= "<img src=" . $email_signature . " alt='logo' width='100px;'>";
        $pdf_message .= "<br>";
        $pdf_message .= "<br>";
        $pdf_message .= $result['signature_text'];

        $pdf_message .="<br><br><br><img src='" . $cutter_image . "'/><br><br>";

        $pdf_message.="<div style='width:50%; float:left'><img src=" . $logo . " alt='logo' width='100px' /><br><br><div>" . $result['donar_first_name'] . "<br>" . $data_result['address1'] . "<br>" . $data_result['address2'] . "<br>" . $data_result['city'] . "<br>" . $data_result['postal_code'] . "</div></div>";
        $pdf_message.="<div style='width:50%; float:left'><span>" . $result['charity_name'] . "</span><br><span><b>Donation Receipt</b></span><br><br><label>Charity Number: </label><span>" . $result['registration_number'] . "</span><br><label>Donation Amount: </label><span>$" . $input_data['amount_donated'] . "</span><br><label>Transaction Number: </label><span>" . $input_data['txn_id'] . "</span><br><label>Donation Date: </label><span>" . date("j F, Y") . "</span><br></div>";

        $pdf_message .= "<br>";
        $pdf_message .="<div style='width:100%;font-size:12px;'>All donations of $5 or above to a qualifying registered charity are eligible for a tax deductible in New Zealand.</div>";
        $pdf_message .="<br>";

        if (ob_get_contents())
            ob_end_clean();
        $pdf = $this->m_pdf->load();
        $pdf->WriteHTML($pdf_message, 2);
        if (ob_get_contents())
            ob_end_clean();

        //download it.
        ob_clean();
        $receipt_file_name = "Receipts-" . $input_data['order_id'];
        $pdf->Output('assets/donation_pdf/' . $receipt_file_name . '.pdf', 'F');

        $attachment_url = getcwd() . '/assets/donation_pdf/' . $receipt_file_name . '.pdf';

        return $attachment_url;
    }

    function send_order_email_old($order_id = NULL) {
        // based on order id get sub event and event id
        $details = $this->event_model->get_tickets_generated_email($order_id);

        $order_info = $this->event_model->get_order_history_information($order_id);

        if (isset($details['0'])) {
            $data = array();
            $data['even_sub_events'] = $details['0'];
            // get event details
            $event_details = $this->event_model->get_event_info_email($data['even_sub_events']['event_id']);

            $data['order_info'] = $order_info;
            $order_notify_email = $data['order_info']['email'];
            $data['event_details'] = $event_details;

            // get charity details
            $organizer_data = $this->event_model->get_organiser_details($event_details['organiser_id']);
            $data['organizer_data'] = $organizer_data;
            $data['ticket_data'] = $details;

            // get organizer email information
            $organizer_email = $this->event_model->get_organizer_address($event_details['organiser_id']);

            $data['organizer_email'] = $organizer_email;
        } else {
            $data = array();
        }

        //$attachment_url = $_SERVER['DOCUMENT_ROOT'].'/event_management_uat/assets/tickets_generated/'.$order_id.'.pdf';

        $attachment_url = getcwd() . '/assets/tickets_generated/' . $order_id . '.pdf';

        //storing data in a databse
        $email = "quagnitia.testuser1@gmail.com";
        $name = "darshan";

        //configure email settings
        $config['protocol'] = 'sendmail';
        $config['smtp_host'] = 'ssl://smtp.gmail.com';

        $config['smtp_user'] = 'jeetendra.gawas@quagnitia.com';
        $config['smtp_pass'] = 'babji123';
        $config['mailtype'] = 'html';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['newline'] = "\r\n"; //use double quotes
        $this->load->library('email', $config);
        $this->email->initialize($config);
        //send mail
        $this->email->from("darshan.more@quagnitia.com", "TicketingSystem");
        $this->email->subject('Order Notification for ' . $data['event_details']['title']);
        $this->email->to($order_notify_email);
        $body = $this->load->view('templates/email_template', $data, TRUE);


        $this->email->attach($attachment_url);
        $this->email->message($body);

        $flag = $this->email->send();
    }

    function isProcessed($txn_id, $merchant_reference) {
        # Check database if order relating to TxnId has alread been processed
        $check_email_status = $this->payment_model->check_email_order_status($merchant_reference);

        if ($check_email_status) {
            return false;
        } else {
            return true;
        }
    }

    function payment_success_url() {

        $this->clear_data_on_payment_success();
        $viewArr['ticket_id'] = $this->session->flashdata('result_data');
        $viewArr['viewPage'] = "payment_success";
        $this->load->view('frontend/layout', $viewArr);
    }

    function dynamic_return() {
        if ($_POST['respMsg'] == "success") {
            $order_id = $_POST['orderNumber'];
            $check_email_status = $this->payment_model->check_email_order_status($_POST['orderNumber']);

            if ($check_email_status) {
                $out_array = array("payment_method" => 'dynamic_payment', "txn_id" => $_POST['qid']);
                $this->generate_tickets($out_array);
                $this->clear_data_on_payment_success();
                $this->session->set_flashdata('result_data', $order_id);
                redirect('frontend/events/payment_success_url', 'refresh');
            } else {
                return true;
            }
        } else {
            redirect('frontend/donation/donation_error_page', 'refresh');
        }
    }

    function dynamic_payment($data) {

        require getcwd() . '/application/libraries/dynamic/quickpay_service.php';
        mt_srand(quickpay_service::make_seed());
        $param['transType'] = quickpay_conf::CONSUME;
        $param['orderAmount'] = $data['amount'];
        $param['orderNumber'] = $data['order_id'];
        $param['orderTime'] = date('YmdHis');
        $param['orderCurrency'] = quickpay_conf::CURRENCY_CNY;

        $param['customerIp'] = $_SERVER['REMOTE_ADDR'];
        $param['frontEndUrl'] = $this->config->item('base_url') . "/frontend/orders/dynamic_return";
        $param['backEndUrl'] = $this->config->item('base_url') . "/frontend/orders/dynamic_return";

        $pay_service = new quickpay_service($param, quickpay_conf::FRONT_PAY);
        $html = $pay_service->create_html();

        header("Content-Type: text/html; charset=" . quickpay_conf::$pay_params['charset']);
        echo '<div  style="visibility:hidden;">';
        echo $html;
        echo '</div>
		<div id="pageloaddiv"></div>
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.2.js"></script>
		<script type="text/javascript">
		$(window).load(function() {
		$("#pageloaddiv").fadeOut(5000);
		});
		</script>
		<style type="text/css">
		#pageloaddiv {
		position: fixed;
		left: 0px;
		top: 0px;
		width: 100%;
		height: 100%;
		z-index: 1000;
		background: url(\'pageloader.gif\') no-repeat center center;
		}
		</style>';
    }

    function error_page() {
        $viewArr['status'] = $this->session->flashdata('txn_gateway_status');
        $viewArr['viewPage'] = "error_page";
        $this->load->view('frontend/layout', $viewArr);
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */