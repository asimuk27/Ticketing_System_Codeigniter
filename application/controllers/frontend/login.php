<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

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
		$this->load->model('frontend/login_model');
		$this->load->library(array('form_validation','session','pagination'));
		$this->load->helper(array('form', 'url', 'file'));
		$passArg = array();
	}

	function check_if_user_is_logged(){
		if(isset($this->session->userdata['logged_in'])){
			 redirect("frontend/home/index");
		}
	}

	function index(){
		$this->check_if_user_is_logged();
		$viewArr['seo_title'] = "Login";
		$viewArr['viewPage'] = "login";
		$this->load->view('frontend/layout', $viewArr);
	}

	function login_frontend(){
		if(isset($this->session->userdata['facebook'])){
			$data = $this->session->userdata['facebook'];

			$_POST['first_name'] = $data['first_name'];
			$_POST['last_name'] = $data['last_name'];
			$profile_pic = "https://graph.facebook.com/".$data['id']."/picture?type=large";

			if(isset($data['email'])){
				$_POST['email'] =  $data['email'];
                $check_if_exist_email=$this->login_model->check_user_email($data['email']);

                if($check_if_exist_email==1){

                }else{
                	  $this->session->set_flashdata('message', 'Please register before you login');
                	 redirect("frontend/login/login");
                }

			}else{
				$_POST['email'] = "";
			}
		}else{
			$_POST['email'] = "";
		}

		$this->form_validation->set_error_delimiters('<div style="color:red;">', '</div>');
		$this->form_validation->set_rules('email', 'Email', 'trim|xss_clean|required');

        if($this->form_validation->run() == FALSE){
        	//echo validation_errors();
			$viewArr['viewPage'] = "login";
			$this->load->view('frontend/layout', $viewArr);
		}
		else
		{
		$data = array(
       'first_name' => $this->input->post('first_name'),
       'last_name' => $this->input->post('last_name'),
       'preffered_name' => '',
       'email' => $this->input->post('email'),
       'phone_no' => '',
       'login_type'=>0,
       'street_address' => '',
       'suburb' => '',
       'city' => '',
       'postcode' =>0,
       'country' => '',
       'birth_date' => '1990-01-01',

       'image_path' =>'',
       'facebook_id'=>$data['id'],
       'facebook_image_path'=>$profile_pic,
        );

        $email=$this->input->post('email');
        $this->login_model->add_facebook_user($data,$email);
        $user_data=$this->login_model->retrive_auth_records($email);

		$sess_array = array(
			"id" => $user_data->id,
			'email' => $user_data->email,
			'first_name' => $user_data->first_name,
			'login_type' => $user_data->login_type
		);

         // print_r($sess_array);exit;
          if(isset($this->session->userdata['checkout_login'])){
             $this->session->set_userdata('logged_in', $sess_array);
             $this->session->unset_userdata('checkout_login');
             redirect('frontend/events/save_ticket_details', 'refresh');
	         return true;
          }
          else
          {
          	 $this->session->set_userdata('logged_in', $sess_array);
             redirect('frontend/home', 'refresh');
	         return true;
          }

		}
	}

	public function set_sign_up(){
		$viewArr['viewPage'] = "set_sign_up";
		$this->load->view('frontend/layout', $viewArr);
	}

	public function facebook_login(){
		$this->check_if_user_is_logged();
		$this->load->library('facebook');
		$user = $this->facebook->getUser();
        if ($user) {
            try {
                $data['user_profile'] = $this->facebook->api('/me');
            } catch (FacebookApiException $e) {
                $user = null;
            }
        }else {
            // Solves first time login issue. (Issue: #10)
            //$this->facebook->destroySession();
        }

        if ($user) {
            $data['logout_url'] = site_url('welcome/logout');
        } else {
            $data['login_url'] = $this->facebook->getLoginUrl(array(
                'redirect_uri' => site_url('welcome/login'),
                'scope' => array("email") // permissions here
            ));
        }
        $this->load->view('login',$data);
	}

	function facebook_authentication(){
		$this->check_if_user_is_logged();
		if(isset($this->session->userdata['facebook'])){
			$data = $this->session->userdata['facebook'];

			$_POST['first_name'] = $data['first_name'];
			$_POST['last_name'] = $data['last_name'];
			$profile_pic = "https://graph.facebook.com/".$data['id']."/picture?type=large";

			if(isset($data['email'])){
				$_POST['email'] =  $data['email'];
                $check_if_exist_email=$this->login_model->check_user_email($data['email']);

                if($check_if_exist_email==1 && $this->session->userdata['facebook_status']!='logged_in'){
                      $this->session->set_flashdata('message', 'Your account is already registered.');
                       redirect("frontend/login/user_sign_up");
                }else if($check_if_exist_email==2 && $this->session->userdata['facebook_status'] == 'logged_in'){
                    $this->session->set_flashdata('message', 'Please register');
                    redirect("frontend/login/login");
                }
			}else{
				$_POST['email'] = "";
			}
		}else{
			$_POST['email'] = "";
		}

		$this->form_validation->set_error_delimiters('<div style="color:red;">', '</div>');
		$this->form_validation->set_rules('email', 'Email', 'trim|xss_clean|required');

        if($this->form_validation->run() == FALSE){
        	//echo validation_errors();
			$viewArr['viewPage'] = "login";
			$this->load->view('frontend/layout', $viewArr);
		}else{
		$data = array(
       'first_name' => $this->input->post('first_name'),
       'last_name' => $this->input->post('last_name'),
       'preffered_name' => '',
       'email' => $this->input->post('email'),
       'phone_no' => '',
       'login_type' => '',
       'street_address' => '',
       'suburb' => '',
       'city' => '',
       'postcode' =>'',
       'country' => '',
       'birth_date' =>   '',
       'last_login' => '',
       'image_path' =>'',
       'facebook_id'=>$data['id'],
       'facebook_image_path'=>$profile_pic,
        );

        $email=$this->input->post('email');
        $this->login_model->add_facebook_user($data,$email);
        $user_data=$this->login_model->retrive_auth_records($email);

		$sess_array = array(
			"id" => $user_data->id,
			'email' => $user_data->email,
			'first_name' => $user_data->first_name,
			'login_type' => $user_data->login_type
		);

         // print_r($sess_array);exit;
          if(isset($this->session->userdata['checkout_session'])){
             $this->session->set_userdata('logged_in', $sess_array);
             $this->session->unset_userdata('checkout_session');
             redirect('frontend/events/save_ticket_details', 'refresh');
	         return true;
          }
          else
          {
          	 $this->session->set_userdata('logged_in', $sess_array);
             redirect('frontend/home', 'refresh');
	         return true;
          }
		}
	}

	function user_sign_up(){
		$this->check_if_user_is_logged();
		$viewArr['is_fund_raise'] = "0";
		$viewArr['seo_title'] = "User Register";
		$viewArr['viewPage'] = "user_sign_up";
		$this->load->view('frontend/layout', $viewArr);
	}

	function organiser_sign_up(){
		$this->check_if_user_is_logged();
		//$viewArr['viewPage'] = "organisation_set_up";
		$get_organisation_type=$this->organiser_model->get_organisation_type();
		$viewArr['get_organisation_type'] = $get_organisation_type;
		$viewArr['seo_title'] = "Organiser Register";
		$viewArr['viewPage'] = "organisation_updated";
		$this->load->view('frontend/layout', $viewArr);
	}

	// function to check and validate login process
	public function check_login(){
		$this->check_if_user_is_logged();
		$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_check_database');

		if($this->form_validation->run() == FALSE){
			//Field validation failed.User redirected to login page
			$viewArr['viewPage'] = "login";
			$this->load->view('frontend/layout', $viewArr);
		}else{
			//Go to private area
			$data = $this->session->userdata['logged_in'];
			//redirect('frontend/home', 'refresh');
			if($this->input->post('fund_raise_status')){
				redirect('frontend/champion/fund_raising', 'refresh');
			}else{
				redirect('frontend/home', 'refresh');
			}
		}
	}

	//function to check login details into database.
 function check_database($password){
	//Field validation succeeded.  Validate against database
	$username = $this->input->post('email');

	//query the database for organiser table
	$user_exist = $this->login_model->authenticate_reg_email($username);
	if($user_exist){
		$check_facebook_email=$this->login_model->check_facebook_email($username);
		if($check_facebook_email=='2'){
			$this->form_validation->set_message('check_database', 'Email is associated with facebook, please login with facebook credentials');
			return false;
		}
		$result = $this->login_model->check_login($username, $password);
		  if($result){
			// check if account is under approval
			$active_users = $this->login_model->check_login_status($username);
			if($active_users){
				$output = $this->create_user_session($result['0']);
				if($output){
					return true;
				}else{
					return false;
				}
			}else{
				$data = $this->login_model->check_login_approved($username);
				if(!empty($data)){
					$this->form_validation->set_message('check_database', 'This account has been disabled. Kindly contact admin');
					return false;
				}else{
					//call function to set respective sessions
					$this->form_validation->set_message('check_database', 'This account is not yet approved. Kindly visit after some time');
					return false;
				}
			}
		}else{
			$this->form_validation->set_message('check_database', 'Invalid username or password');
			return false;
		}
	}else{
		$this->form_validation->set_message('check_database', 'Email does not exist');
		return false;
	}
 }
	//function to check login details into database.
	/*function check_database($password){
		$this->check_if_user_is_logged();
		//Field validation succeeded.  Validate against database
		$username = $this->input->post('email');

		//query the database for organiser table
		$result = $this->login_model->check_login($username, $password);

		if($result){
			// check if account is under approval
			$data = $this->login_model->check_login_approval($username);
			if(!empty($data)){
				$this->form_validation->set_message('check_database', 'This account is not yet approved. Kindly visit after some time');
				return false;
			}else{
				//call function to set respective sessions
				$output = $this->create_user_session($result['0']);
				if($output){
					return true;
				}else{
					return false;
				}
			}
		}else{
			$this->form_validation->set_message('check_database', 'Invalid username or password');
			return false;
		}
	}
	*/
	// function to create user session-
	function create_user_session($user_data = NULL){
		$this->check_if_user_is_logged();
		$sess_array = array(

			'id' => $user_data->id,
			'email' => $user_data->email,
			'first_name' => $user_data->first_name,
			'login_type' =>  $user_data->login_type
		);

       $this->session->set_userdata('logged_in', $sess_array);
	   return true;
	}

	function forgot_password(){
		$this->check_if_user_is_logged();
		$viewArr['viewPage'] = "forgot_password";
		$this->load->view('frontend/layout', $viewArr);
	}

	/* function forgot_password_send(){
	//	$this->check_if_user_is_logged();
		if($this->input->post()){
			if($this->input->post('email')){
				if (!filter_var($this->input->post('email'), FILTER_VALIDATE_EMAIL) === false) {
					$result = $this->login_model->checkEmailExist($this->input->post('email'));
					if($result){
						$check_facebook_email=$this->login_model->check_facebook_email($this->input->post('email'));
						if($check_facebook_email=='2'){
							$this->session->set_flashdata('message', 'Email is associated with facebook, please login with facebook credentials');
							redirect($this->config->item("forgot_password"), 'refresh');
						}

						$newCode = mt_rand(10000,99999);
						$res = $this->login_model->updatePswd($result->id,$result->login_type,$newCode);

						$templateData = array(
							"tempCode"=>$newCode,
							"email"=>$result->email,
							"name"=>$result->first_name." ".$result->last_name
						);
					$emailResp = $this->sendEmail($result->email,$templateData);

					if($emailResp){
							$this->session->set_flashdata('message', 'Password sent successfully');
							redirect($this->config->item("forgot_password"), 'refresh');
						}else{
							$this->session->set_flashdata('message', 'Error in updating password please try again.');
							redirect($this->config->item("forgot_password"), 'refresh');
						}
					}else{
						$this->session->set_flashdata('message', 'User with that email id was not found.');
						redirect($this->config->item("forgot_password"), 'refresh');
					}
				}else{
					$this->session->set_flashdata('message', 'Please enter valid email address');
					redirect($this->config->item("forgot_password"), 'refresh');
				}
			}else{
				$this->session->set_flashdata('message', 'Please enter email address');
				redirect($this->config->item("forgot_password"), 'refresh');
			}
		}else{
			$viewArr["viewPage"] = "forgot_password";
			$this->load->view('frontend/layout',$viewArr);
		}
	} */


	function forgot_password_send(){
	//	$this->check_if_user_is_logged();
		if($this->input->post()){
			if($this->input->post('email')){
				if (!filter_var($this->input->post('email'), FILTER_VALIDATE_EMAIL) === false) {
					$result = $this->login_model->checkEmailExist($this->input->post('email'));
					if($result){
						$data = $this->login_model->check_login_approved($this->input->post('email'));
						if(!empty($data)){
							$this->session->set_flashdata('message', '<div style="color:red;">This account has been disabled. Kindly contact admin</div>');
							redirect($this->config->item("forgot_password"), 'refresh');
						}
						$check_facebook_email=$this->login_model->check_facebook_email($this->input->post('email'));
						if($check_facebook_email=='2'){
							$this->session->set_flashdata('message', '<div style="color:red;">Email is associated with facebook, Please login with facebook credentials.</div>');
							redirect($this->config->item("forgot_password"), 'refresh');
						}

						$newCode = mt_rand(10000,99999);
						//$res = $this->login_model->updatePswd($result->id,$result->login_type,$newCode);

						$templateData = array(
							"tempCode"=>$newCode,
							"email"=>$result->email,
							"name"=>$result->first_name." ".$result->last_name
						);
					//$emailResp = $this->sendEmail($result->email,$templateData);
					  $emailResp = $this->sendForgotPasswordEmail($result->email,$templateData);
					if($emailResp){
							$this->session->set_flashdata('message', '<div style="color:green;">Please check your email to reset your account password</div>');
							redirect($this->config->item("forgot_password"), 'refresh');
						}else{
							$this->session->set_flashdata('message', '<div style="color:red;">Error in updating password please try again.</div>');
							redirect($this->config->item("forgot_password"), 'refresh');
						}
					}else{
						$this->session->set_flashdata('message', '<div style="color:red;">User with that email id was not found.</div>');
						redirect($this->config->item("forgot_password"), 'refresh');
					}
				}else{
					$this->session->set_flashdata('message', '<div style="color:red;">Please enter valid email address</div>');
					redirect($this->config->item("forgot_password"), 'refresh');
				}
			}else{
				$this->session->set_flashdata('message', '<div style="color:red;">Please enter email address</div>');
				redirect($this->config->item("forgot_password"), 'refresh');
			}
		}else{
			$viewArr["viewPage"] = "forgot_password";
			$this->load->view('frontend/layout',$viewArr);
		}
	}

	function sendForgotPasswordEmail($email = NULL,$templateData=array()){
		$this->check_if_user_is_logged();

		if(empty($templateData)){
			redirect("frontend/home/index");
		}

		//configure email settings
        $config['protocol'] = 'sendmail';
        $config['smtp_host'] = 'ssl://smtp.gmail.com';

        $config['smtp_user'] = 'jeetendra.gawas@quagnitia.com';
        $config['smtp_pass'] = 'k3gPersist2012';
        $config['mailtype'] = 'html';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['newline'] = "\r\n"; //use double quotes
        $this->load->library('email', $config);
        $this->email->initialize($config);

		$this->email->from("admin@ticketing_system.com", "TicketingSystem");
		$this->email->to($email);
		$md5_email = md5($email);
		$click_url = $this->config->item('base_url')."frontend/password/reset_password/".$md5_email;
		$this->email->subject('TicketingSystem | ForgotPassword');

		$message = "Kia ora ".$templateData['name'];
		$message .= "<br>";$message .= "<br>";
		$message .= "Someone recently requested a password change for your TicketingSystem account.";
		$message .= "<br>";$message .= "<br>";
		$message .= " If this was you then Please click on the following reset password link";
		$message .= "<br>";$message .= "<br>";
		$message .= "<a href='".$click_url."'>Reset Password</a>";
		$message .= "<br>";$message .= "<br>";
		$message .= "If you don't want to change your password or didn't request this, just ignore and delete this message.";
		$message .= "<br>";$message .= "<br>";
		$message .= "Thanks,";
		$message .= "<br>";
		$message .= "<br>";
		$message .= "TicketingSystem Team";
		$message .= "<br>";
		$message .= "<br>";
		$message .= "<img src=".$this->config->item('fe_logo_image_url')." alt='logo' width='100px;'>";
		$message .= "<br>";
		$message .= "<br>";

		$this->email->message($message);
		$resp = $this->email->send();
		return $resp;
	}

	function sendEmail($email = NULL,$templateData=array()){
		$this->check_if_user_is_logged();

		if(empty($templateData)){
			redirect("frontend/home/index");
		}

		/* //$this->load->library('email');
        $email_message = "<div>
		<p>Hi ".$templateData['name']."</p>
		<p>You are registered on TicketingSystem with an email address: ".$templateData['email'].", Upon your request we have generated new password code: <b style='color:green;'>".$templateData['tempCode']."</b></p>
		<p>Please login with this temporary code</p>
		<br>
		<p>Thanks,</p>
		<p>TickeSuite</p>
		<B>Note: Email content is yet to be approved</B>
		</div>"; */

		//configure email settings
        $config['protocol'] = 'sendmail';
        $config['smtp_host'] = 'ssl://smtp.gmail.com';

        $config['smtp_user'] = 'jeetendra.gawas@quagnitia.com';
        $config['smtp_pass'] = 'k3gPersist2012';
        $config['mailtype'] = 'html';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['newline'] = "\r\n"; //use double quotes
        $this->load->library('email', $config);
        $this->email->initialize($config);

		$this->email->from("admin@ticketing_system.com", "TicketingSystem");
		$this->email->to($email);

		$this->email->subject('New Password On User Request.');

		$message = "Kia ora ".$templateData['name'];
		$message .= "<br>";$message .= "<br>";
		$message .= "We have you registered on TICKETING SYSTEM with the email address: ".$templateData['email'].",";
		$message .= "<br>";$message .= "<br>";
		$message .= "Upon your request we have generated new password code: <b style='color:green;'>".$templateData['tempCode']."</b>";
		$message .= "<br>";
		$message .= "<br>";
		$message .= "Please login with this temporary code";
		$message .= "<br>";
		$message .= "<br>";
		$message .= "Thanks,";
		$message .= "<br>";
		$message .= "<br>";
		$message .= "TicketingSystem Team";
		$message .= "<br>";
		$message .= "<br>";
		$message .= "<img src=".$this->config->item('fe_logo_image_url')." alt='logo' width='100px;'>";
		$message .= "<br>";
		$message .= "<br>";

		$this->email->message($message);

		$resp = $this->email->send();
		return $resp;
	}

	function logout(){
		$this->session->unset_userdata('logged_in');
		$this->session->unset_userdata('facebook_status');
		$this->session->unset_userdata('checkout_session');

		$this->load->library('facebook');
		$this->facebook->destroySession();
		redirect('frontend/home', 'refresh');
	}

	function has_email($email = NULL){
		$this->check_if_user_is_logged();
		if($this->login_model->authenticate_facebook_email($email)){
            return true;
        }else{
            $this->form_validation->set_message('has_email', 'Email Not Found Please Register');
            return false;
        }
	}

	function facebook_register_fill_up(){
		if(isset($this->session->userdata['facebook_fill_up']))
		{
			$data = $this->session->userdata['facebook_fill_up'];
			$close_sign_up=1;
			$viewArr['facebook_data'] = $data;
			$viewArr['close_sign_up'] = $close_sign_up;
			$viewArr['fb_status'] = 1;

		}
		$viewArr['viewPage'] = "user_sign_up";
		$this->session->unset_userdata('facebook_fill_up');
		$this->load->view('frontend/layout', $viewArr);
	}

	function facebook_authentication_checkout(){
       	if(isset($this->session->userdata['facebook'])){
		$data = $this->session->userdata['facebook'];

		$_POST['first_name'] = $data['first_name'];
		$_POST['last_name'] = $data['last_name'];
		$profile_pic = "https://graph.facebook.com/".$data['id']."/picture?type=large";

		if(isset($data['email'])){
			$_POST['email'] =  $data['email'];
            $check_if_exist_email=$this->login_model->check_user_email($data['email']);

            if($check_if_exist_email==1){

            }else{
             	$this->session->unset_userdata('facebook_status');
				$this->session->unset_userdata('checkout_session');
				$this->session->set_flashdata('message', 'Your facebook account is not registered on TicketingSystem. Please Register Or Continue as Guest.');
                redirect("frontend/events/save_ticket_details");
            }
		}else{
				$_POST['email'] = "";
			}
		}else{
			$_POST['email'] = "";
		}

		$this->form_validation->set_error_delimiters('<div style="color:red;">', '</div>');
		$this->form_validation->set_rules('email', 'Email', 'trim|xss_clean|required');

        if($this->form_validation->run() == FALSE){
        	//echo validation_errors();
			$viewArr['viewPage'] = "login";
			$this->load->view('frontend/layout', $viewArr);
		}
		else
		{
		$data = array(
       'first_name' => $this->input->post('first_name'),
       'last_name' => $this->input->post('last_name'),
       'preffered_name' => '',
       'email' => $this->input->post('email'),
       'phone_no' => '',
       'login_type'=>0,
       'street_address' => '',
       'suburb' => '',
       'city' => '',
       'postcode' =>0,
       'country' => '',
       'birth_date' => '1990-01-01',
       'image_path' =>'',
       'facebook_id'=>$data['id'],
       'facebook_image_path'=>$profile_pic,
        );

        $email=$this->input->post('email');
        $this->login_model->add_facebook_user($data,$email);
        $user_data=$this->login_model->retrive_auth_records($email);

		$sess_array = array(
			"id" => $user_data->id,
			'email' => $user_data->email,
			'first_name' => $user_data->first_name,
			'login_type' => $user_data->login_type
		);

         // print_r($sess_array);exit;
          if(isset($this->session->userdata['checkout_session'])){
             $this->session->set_userdata('logged_in', $sess_array);
             $this->session->unset_userdata('checkout_session');
             redirect('frontend/events/save_ticket_details', 'refresh');
	         return true;
          }
          else
          {
          	 $this->session->set_userdata('logged_in', $sess_array);
             redirect('frontend/home', 'refresh');
	         return true;
          }
		}
	}

	function login_ajax(){
		if($_POST){
			$data['id']=$_POST['id'];
			$data['first_name']=$_POST['first_name'];
			$data['last_name']=$_POST['last_name'];
			$data['email']=$_POST['email_idz'];

			$this->session->set_userdata("facebook",$data);
			$this->session->set_userdata("facebook_status",'logged_in');
            redirect("frontend/login/facebook_authentication");
		}
	}

	function signup_ajax(){

		if($_POST){
			$data['id']=$_POST['id'];
			$data['first_name']=$_POST['first_name'];
			$data['last_name']=$_POST['last_name'];
			$data['email']=$_POST['email_idz'];

			$this->session->set_userdata("facebook",$data);
			$this->session->set_userdata("facebook_status",'sign_up');
            redirect("frontend/login/facebook_authentication");
		}
	}

	function checkout_login_ajax(){
          if($_POST){
			$data['id']=$_POST['id'];
			$data['first_name']=$_POST['first_name'];
			$data['last_name']=$_POST['first_name'];
			$data['email']=$_POST['email_idz'];

			$this->session->set_userdata("facebook",$data);
            $this->session->set_userdata("checkout_session",$data);
            redirect("frontend/login/facebook_authentication_checkout");
		}
	}

	function user_register(){
		$viewArr['is_fund_raise'] = "1";
		$viewArr['viewPage'] = "user_sign_up";
		$this->load->view('frontend/layout', $viewArr);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */