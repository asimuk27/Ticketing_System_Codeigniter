<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Ushers extends CI_Controller {



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



	function __construct()

	{



		parent::__construct();

		$this->load->model('frontend/usher_model');

		$this->load->model('frontend/champion_model');

		$this->load->model('frontend/event_model');

		$this->load->library(array('form_validation','session','pagination'));



		$this->load->helper(array('form', 'url', 'file','pdf_helper'));

		$this->load->library('ciqrcode');

		$passArg = array();

	}





    public function add_usher($id=null){

    	$get_event_details=$this->usher_model->get_event_details($id);

    	//echo "<pre>";

    	//print_r($get_event_details);exit;

    	$get_subevent_details=$this->usher_model->get_subevent_details($id);

	    $viewArr['viewPage'] = "add_usher";

	    $viewArr['sub_events'] = $get_subevent_details;

	    $viewArr['events'] = $get_event_details;

		$this->load->view('frontend/layout', $viewArr);
TicketingSystem
    }



    public function ajax_call_email()

	{

        $email= $_POST['email'];

        $sub_id= $_POST['sub_id'];







        if(isset($sub_id) && !empty($sub_id)){

           $get_status=$this->usher_model->ajax_call_email_and_status($email,$sub_id);



           if($get_status=='exists'){

              echo $get_status;exit;

           }else{

               $get_status=$this->usher_model->ajax_call_email($email);

               echo $get_status;exit;

           }

        }

        else

		{

            $get_status=$this->usher_model->ajax_call_email($email);

            echo $get_status;exit;



        }

    }



	function validate_user_email(){

		$email=$this->input->post('email');

		$check_email=$this->usher_model->check_users_master($email);



		if($check_email){

			$sub_id=$this->input->post('sub_event_id');

			$email=$this->input->post('email');

			$check_email=$this->usher_model->check_email($email,$sub_id);



			if($check_email){

				$this->form_validation->set_message('validate_user_email', 'Email is already assigned to this event');

				return false;

			}else{

				return true;

			}

		}else{
TicketingSystem
			$this->form_validation->set_message('validate_user_email', 'Email is not registered in TICKETINGSYSTEM system');

			return false;

		}



	}



    public function save_usher()

	{



        if($thiTicketingSystemost())

		{

			$this->form_validation->set_error_delimiters('<div style="color:red;">', '</div>');

			$this->form_validation->set_rules('sub_event_id', 'Sub event', 'required');

			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_validate_user_email');



			if ($this->form_validation->run() == FALSE){

				//echo validation_errors();

				$event_id=$this->input->post('event_id');

				redirect("frontend/ushers/add_usher/".$event_id);

				//$this->add_usher($event_id);

			}else{

				$session_data=$this->session->userdata['logged_in'];

				$email=$this->input->post('email');

				if($email == ""){

					$this->session->set_flashdata('email','Email field is required');

				}

				$get_user_id=$this->usher_model->get_user_id($email);

				$startdate = $this->input->post('startdate');

				$enddate = $this->input->post('enddate');TicketingSystem

				$this->session->set_flashdata('start',$startdate);

				$this->session->set_flashdata('end',$enddate);

				$data = array(

					'event_id' => $this->input->post('event_id'),

					'sub_event_id' => $this->input->post('sub_event_id'),

					'email' => $this->input->post('email'),
TicketingSystem
					'user_id' =>$get_user_id[0]['id'],

					'password' =>$get_user_id[0]['password'],

					'facebook_id' =>$get_user_id[0]['facebook_id'],

					'organiser_id' => $session_data['id'],

					'created_date' => date("Y-m-d H:i:s"));

				$data2 = array(

					'event_id' => $this->input->post('event_id'),

					'sub_event_id' => $this->input->post('sub_event_id'),

					'ticket_checking_method' => $this->input->post('opt'),

					'created_date' => date("Y-m-d H:i:s"));

				$sub_e_id=$this->input->post('sub_event_id');

				$last_id=$this->usher_model->save_usher($data);

				$last_id2=$this->usher_model->save_usher_details($data2);

				$get_usher_details=$this->usher_model->get_usher_details($sub_e_id);

				$event_id=$this->input->post('event_id');

				$get_subevent_details=$this->usher_model->get_subevent_details($event_id);

				$viewArr['sub_events'] = $get_subevent_details;

				$viewArr['usher_data'] = $get_usher_details;

				$viewArr['post_data'] = $_POST;



				// send email notification to usher email address

				//build email data array

				$email_data = array();

				$email_data['first_name'] = $get_user_id[0]['first_name'];

				$email_data['last_name'] = $get_user_id[0]['last_name'];

				$email_data['schedule_title'] = $get_subevent_details[0]['schedule_title'];

				$email_data['schedule_location'] = $get_subevent_details[0]['schedule_location'];

				$email_data['schedule_start_date'] = $get_subevent_details[0]['schedule_start_date'];

				$email_data['schedule_start_time'] = $get_subevent_details[0]['schedule_start_time'];

				$email_data['schedule_end_date'] = $get_subevent_details[0]['schedule_end_date'];

				$email_data['schedule_end_time'] = $get_subevent_details[0]['schedule_end_time'];

				$email_data['email'] =  $this->input->post('email');



				$this->send_usher_registration_email($email_data);



				$this->session->set_flashdata('message', $viewArr);

				redirect("frontend/ushers/add_usher/".$event_id);

			}

        }

    }



	function send_usher_registration_email($email_data){

		$config['protocol'] = 'sendmail';

		$config['smtp_host'] = 'ssl://smtp.gmail.com';



		$config['mailtype'] = 'html';

		$config['charset'] = 'iso-8859-1';

		$config['wordwrap'] = TRUE;

		$config['newline'] = "\r\n"; //use double quotes

		$this->load->library('email', $config);

		$this->email->initialize($config);

		$this->email->from("darshan.more@quagnitia.com", "TICKETINGSYSTEM");

		$this->email->subject('Usher Registration | Event | '.$email_data['schedule_title']);

		$this->email->to($email_data['email']);



		$final_date = date_format(date_create($email_data['schedule_start_date']),'l, F j \A\T ').date_format(date_create($email_data['schedule_start_time']), 'g:i A').' - '.date_format(date_create($email_data['schedule_end_date']),'l, F j \A\T ').date_format(date_create($email_data['schedule_end_time']), 'g:i A');



		$message = " Dear ".$email_data['first_name']." ".$email_data['last_name'];

		$message .= "<br><br>";

		$message .= "You have been registered as an Usher for event: ".$email_data['schedule_title'];

		$message .= "<br><br>";

		$message .= "Location: ".$email_data['schedule_location'];

		$message .= "<br><br>";

		$message .= "Time: ".$final_date;

		$message .= "<br><br>";

		$message .= " Please contact Event Organiser for any other details";

		$message .= "<br><br>";

		$message .= "Thanks,";

		$message .= "<br>";

		$message .= "<br>";

		$message .= "TICKETINGSYSTEM Team";

		$message .= "<br>";



		$this->email->message($message);



		$flag = $this->email->send();



		return $flag;

	}



    public function ajax_subevent_ushers($sub_event_id=null)

	{

		$data=$this->usher_model->ajax_subevent_ushers($sub_event_id);

    	echo json_encode($data);

		exit;

    }



	function delete_user(){



		if(isset($this->session->userdata['logged_in'])){



			$id=$this->input->post('id');



			$get_data=$this->usher_model->get_deleted_usher_data($id);

			$get_user_id=$this->usher_model->get_user_id($get_data['email']);

			$get_subevent_details=$this->usher_model->get_subevent_details($get_data['event_id']);



			$email = $get_data['email'];

			//configure email settings

			$config['protocol'] = 'sendmail';

			$config['smtp_host'] = 'ssl://smtp.gmail.com';



			$config['mailtype'] = 'html';

			$config['charset'] = 'iso-8859-1';

			$config['wordwrap'] = TRUE;

			$config['newline'] = "\r\n"; //use double quotes

			$this->load->library('email', $config);

			$this->email->initialize($config);

			$this->email->from("darshan.more@quagnitia.com", "TICKETINGSYSTEM");

			$this->email->subject('Usher Removed | Event | '.$get_subevent_details[0]['schedule_title']);

			$this->email->to($email);



			$message .= " Dear ".$get_user_id[0]['first_name']." ".$get_user_id[0]['last_name'];

			$message .= "<br><br>";

			$message .= "Your account is deleted as a Usher for event: ".$get_subevent_details[0]['schedule_title'];

			$message .= "<br><br>";

			$message .= "Please contact Event Organiser for any other details";

			$message .= "<br><br>";

			$message .= "Thanks,";

			$message .= "<br>";

			$message .= "<br>";

			$message .= "TICKETINGSYSTEM Team";

			$message .= "<br>";



			//$this->email->attach($attachment_url);

			$this->email->message($message);

			$flag = $this->email->send();



			$this->usher_model->delete_user($id);



			echo "1";exit;

		}else{

			$this->add_usher();

		}

	}



  function ajax_get_status($get_status=null)

  {

        $get_value = $this->usher_model->ajax_get_status($get_status);

        //echo $get_value."<br>";

        if($get_value=='1'){

           echo "online";

        }

        else if($get_value=='2'){

           echo "both";

        }

        else{

           echo "default";

        }



  }



  function ajax_change_status($sub_event_id, $status){

         $get_value=$this->usher_model->ajax_change_status($sub_event_id,$status);



  }



  function ajax_get_start_end_date($event_id = null){

	if($event_id !=0){

		$data = $this->usher_model->ajax_get_start_end_date($event_id);

		$str = date("j F Y",strtotime($data[0]["start"]))."*".date("j F Y",strtotime($data[0]["end"]))."*".$data[0]["s_time"]."*".$data[0]["e_time"];

		echo $str;

	}else{

		echo "";

	}

  }

}



/* End of file welcome.php */

/* Location: ./application/controllers/welcome.php */