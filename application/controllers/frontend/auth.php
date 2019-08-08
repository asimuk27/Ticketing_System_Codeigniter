<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php

class Auth extends CI_Controller {
    private $uid;
    private $access_token;
    public function __construct() {
        parent::__construct();
        $this->load->library("session");
        $this->load->helper(array('form', 'url', 'file'));
        $this->load->library("facebook",array(
            "appId"=>"",
            "secret"=>""
        ));
        $this->uid = $this->facebook->getUser();
        $this->access_token = $this->facebook->getAccessToken();
        $this->facebook->setAccessToken($this->access_token);

		if(isset($this->session->userdata['logged_in'])){
			 redirect("frontend/home/index");
		}
    }

	 public function login_home(){
        if($this->uid){
            try {
                $me = $this->facebook->api("/me?fields=email,first_name,last_name");
                $this->session->set_userdata("facebook",$me);
                redirect("frontend/login/login_frontend");
            }catch(FacebookApiExeption $e) {
                $this->uid = NULL;
            }
        }else{
            die("<script>top.location='".$this->facebook->getLoginUrl(array(
                "scope"=>"email,user_friends,public_profile",
                "redirect_url"=>site_url("frontend/auth")
            ))."'</script>");
        }
    }

    public function index() {
            $viewArr['viewPage'] = "auth";
            $this->load->view('frontend/layout', $viewArr);
    }

    public function login() {
        if($this->uid) {
            try {
                $me = $this->facebook->api("/me?fields=email,first_name,last_name");
                $this->session->set_userdata("facebook",$me);
                redirect("frontend/login/facebook_authentication");
            }catch(FacebookApiExeption $e) {
                $this->uid = NULL;
            }
        }else{
            die("<script>top.location='".$this->facebook->getLoginUrl(array(
                "scope"=>"email,user_friends,public_profile",
                "redirect_url"=>site_url("frontend/auth")
            ))."'</script>");
        }
    }

	public function register_fill_up(){
           if($this->uid) {
            try {
                $me = $this->facebook->api("/me?fields=email,first_name,last_name");
                $this->session->set_userdata("facebook_fill_up",$me);
                redirect("frontend/login/facebook_register_fill_up");
            }catch(FacebookApiExeption $e) {
                $this->uid = NULL;
            }
        }else{
            die("<script>top.location='".$this->facebook->getLoginUrl(array(
                "scope"=>"email,user_friends,public_profile",
                "redirect_url"=>site_url("frontend/auth")
            ))."'</script>");
        }
    }

	public function login_checkout(){
        if($this->uid){
            try {
                $me = $this->facebook->api("/me?fields=email,first_name,last_name");
                $this->session->set_userdata("facebook",$me);
                 $this->session->set_userdata("checkout_session",$me);
                redirect("frontend/login/facebook_authentication_checkout");
            }catch(FacebookApiExeption $e) {
                $this->uid = NULL;
            }
        }else{
            die("<script>top.location='".$this->facebook->getLoginUrl(array(
                "scope"=>"email,user_friends,public_profile",
                "redirect_url"=>site_url("frontend/auth")
            ))."'</script>");
        }
    }


    public function logout() {
       $this->facebook->setAccessToken('');
  $sessionArray=array(
    "uid"=>'',
    "access_token"=>'',

  );

    $this->session->unset_userdata($sessionArray);
    $this->session->sess_destroy();
  $this->facebook->destroySession();


  unset($_SESSION);
  session_destroy();
        redirect("frontend/auth");
    }
}