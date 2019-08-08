<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cms extends CI_Controller {

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
		$this->load->model('backend/cms_model');
		$this->load->library(array('form_validation','session','pagination'));
		$this->load->helper(array('form', 'url', 'file'));
		$this->load->library('email');
		$passArg = array();
	}

	function faq(){
		//$viewArr['viewPage'] = "faq";
		//$this->load->view('frontend/layout', $viewArr);
		$get_faq_content=$this->cms_model->get_faq_content();
		$viewArr['data'] = $get_faq_content;
		$viewArr['viewPage'] = "dummy_faq";
		$this->load->view('frontend/layout', $viewArr);
	}

	function terms(){
		$viewArr['viewPage'] = "terms";
		$this->load->view('frontend/layout', $viewArr);
	}

	function index(){
		/*$page_name = $_GET['page'];
		$data = $this->cms_model->get_data_by_id($page_name);

		$viewArr['cms_content'] = $data['content'];
		$viewArr['viewPage'] = "cms";
		$this->load->view('frontend/layout', $viewArr); */
		$this->contact_us();
	}

	function contact_us(){
		$viewArr['viewPage'] = "contact_us";
		$this->load->view('frontend/layout', $viewArr);
	}

	function about_us(){
		$viewArr['viewPage'] = "about_us";
		$this->load->view('frontend/layout', $viewArr);
	}

	function create_dynamic(){
		$viewArr['viewPage'] = "add_event_dynamic";
		$this->load->view('frontend/layout', $viewArr);
	}


	function contact_send(){

		$this->form_validation->set_error_delimiters('<div style="color:red;">', '</div>');
		$this->form_validation->set_rules('email', 'Email', 'trim|xss_clean|required');
		$this->form_validation->set_rules('name', 'Name', 'trim|xss_clean|required');
		$this->form_validation->set_rules('message', 'Message', 'trim|xss_clean|required');

		if($this->form_validation->run() == FALSE){
            $viewArr['viewPage'] = "contact_us";
		    $this->load->view('frontend/layout', $viewArr);
		}else{

			if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])){
				$secret = '6Lct7w0UAAAAAA2ol3oD3MDzWbLj2D-syFpM1U7S';
				//get verify response data
				$verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
				$responseData = json_decode($verifyResponse);

				if($responseData->success){
				//	$this->load->library('email');
					$this->email->from($this->input->post('email'), 'TicketingSystem');
					$this->email->to('info@ticketing_system.com');
					$this->email->bcc('darshan.more@quagnitia.com');
					$this->email->set_mailtype("html");
					$this->email->subject('Contact Us Message');
					$message = "";
					$message .= "Hi,";
					$message .= "<br>";$message .= "<br>";
					$message .= "We have received new contact us message";
					$message .= "<br>";$message .= "<br>";
					$message .= "Sender Details:";
					$message .= "<br>";$message .= "<br>";
					$message .= "Name: ".$this->input->post('name');
					$message .= "<br>";$message .= "<br>";
					$message .= "Email: ".$this->input->post('email');
					$message .= "<br>";$message .= "<br>";
					$message .= "Subject: ".$this->input->post('subject');
					$message .= "<br>";$message .= "<br>";
					$message .= "Message: ".$this->input->post('message');
					$message .= "<br>";$message .= "<br>";
					$message .= "Thanks,";
					$message .= "<br>";
					$message .= "<br>";
					$message .= "TicketingSystem";
					$message .= "<br>";
					$message .= "<br>";

					$this->email->message($message);
					$resp = $this->email->send();

					$this->session->set_flashdata('msg', '<div class="col-md-6 response_style">Thanks for sending your message</div>');
					redirect('frontend/cms/contact_us', 'refresh');
				}else{
					$this->session->set_flashdata('msg', '<div class="col-md-6 failure_style">Robot verification failed, please try again.</div>');
					redirect('frontend/cms/contact_us', 'refresh');
				}
			}else{
				$this->session->set_flashdata('msg', '<div class="col-md-6 failure_style">Please click on the reCAPTCHA box.</div>');
				redirect('frontend/cms/contact_us', 'refresh');
			}
		}
	}

	function send_order_email(){
		//storing data in a databse
		$email = "darshan.more@quagnitia.com";
		$name = "darshan";

		//configure email settings
		$config['protocol'] = 'sendmail';
		$config['smtp_host'] = 'ssl://smtp.gmail.com';
		$config['mailtype'] = 'html';
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;
		$config['newline'] = "\r\n"; //use double quotes
		$this->load->library('email', $config);
		$this->email->initialize($config);
		$data = array();
		//send mail
		$this->email->from($email, $name);
		$this->email->subject('Order Notification for Test event Oct');
		$this->email->to('darshan.more@quagnitia.com');
		//$body =$this->load->view('templates/email_template',$data,TRUE);

		$body = "thank you";
		$this->email->message($body);

	 echo  $this->email->send();
	}

	function learn(){
		$viewArr['seo_title'] = "Learn More";
		$viewArr['viewPage'] = "learn_more";
		$this->load->view('frontend/layout', $viewArr);
	}

	function dummy_faq(){
		$get_faq_content=$this->cms_model->get_faq_content();
		$viewArr['data'] = $get_faq_content;
		$viewArr['viewPage'] = "dummy_faq";
		$this->load->view('frontend/layout', $viewArr);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */