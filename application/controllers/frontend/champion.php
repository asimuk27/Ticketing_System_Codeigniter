<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Champion extends CI_Controller {

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
		$this->load->model('frontend/champion_model');
		$this->load->model('frontend/donation_model');
		$this->load->library(array('form_validation','session','pagination'));
		$this->load->helper(array('form', 'url', 'file'));
		$passArg = array();


	}


	public function fund_raising(){
		if(!isset($this->session->userdata['logged_in'])){
			// open fund raise not login page
			$viewArr['seo_title'] = "Fund Raise";
			$viewArr['viewPage'] = "fund_raise_not_login";
			$this->load->view('frontend/layout', $viewArr);
		}else{
			$this->add_new_champion();
		}
	}

	function add_new_champion(){

		if(!isset($this->session->userdata['logged_in'])){
			redirect('frontend/login', 'refresh');
		}else if(!isset($this->session->userdata['logged_in']['login_type'])){
			redirect('frontend/home', 'refresh');
		}

		if(isset($_GET['event_id']) && isset($_GET['sub_event_id'])){
          $recieved_event_id=$_GET['event_id'];
		  $recieved_sub_event_id=$_GET['sub_event_id'];
		  $get_authentication_details=$this->champion_model->get_authentication_details($recieved_event_id, $recieved_sub_event_id);

		  if($get_authentication_details=='error'){
				redirect('frontend/home', 'refresh');
		  }

		  $get_charity_id=$this->champion_model->get_charity_id($recieved_event_id);
		}

		// check if control is redirected from event details page
		if($this->session->flashdata('champion_data') != ''){
			$post_data = $this->session->flashdata('champion_data');
		}else{
			$post_data = array();
			$post_data['charity_id'] = "";
			$post_data['event_id'] = "";
			$post_data['sub_event_id'] = "";
		}

		//get all organisations
		$all_organizations = $this->champion_model->get_organisations();
		$data_result = array();
		//check type of user login
		if(isset($this->session->userdata['logged_in']['login_type'])){
			if($this->session->userdata['logged_in']['login_type'] == 0){
				// user details
				$data_result = $this->champion_model->get_user_profie($this->session->userdata['logged_in']['login_type'],$this->session->userdata['logged_in']['id']);

				if(isset($data_result[0]['image_path']) && ($data_result[0]['image_path'] !="")){
					$profile_image = $this->config->item('frontend_profileimage_path').$data_result[0]['image_path'];
					$profile_image_name = $data_result[0]['image_path'];
				}else if(isset($data_result[0]['facebook_image_path']) && ($data_result[0]['facebook_image_path'] !="")){
					$profile_image = $data_result[0]['facebook_image_path'];
					$profile_image_name = $data_result[0]['facebook_image_path'];
				}else{
					$profile_image = "";
					$profile_image_name  = "";
				}
			}else{
				redirect('frontend/home', 'refresh');
			}
		}else{
			$profile_image = "";
		}

		if(isset($_GET['event_id']) && isset($_GET['sub_event_id'])){
		  $viewArr['recieved_event_id'] = $recieved_event_id;
		  $viewArr['recieved_sub_event_id'] = $recieved_sub_event_id;
		  $viewArr['get_charity_id'] = $get_charity_id;
		}else{
			$viewArr['recieved_event_id'] = "";
			$viewArr['recieved_sub_event_id'] = "";
			$viewArr['get_charity_id'] = "";
		}
		$viewArr['seo_title'] = "Fund Raise";
		$viewArr['post_data'] = $post_data;
		$viewArr['profile_image_name'] = $profile_image_name;
		$viewArr['profile_image'] = $profile_image;
		$viewArr['organization_list'] = $all_organizations;
		$viewArr['viewPage'] = "add_champion_page";
		$this->load->view('frontend/layout', $viewArr);
	}

	function edit_champion_page($id = NULL){
		if($id){
			$data = $this->champion_model->edit_champion_by_id($id);
			$viewArr['data'] = $data;

			if(isset($data['image_path']) && ($data['image_path'] !="")){
				$profile_image = $this->config->item('frontend_profileimage_path').$data['image_path'];
				$profile_image_name = $data['image_path'];
			}else if(isset($data['facebook_image_path']) && ($data['facebook_image_path'] !="")){
				$profile_image = $data['facebook_image_path'];
				$profile_image_name = $data['facebook_image_path'];
			}else{
				$profile_image = "";
				$profile_image_name  = "";
			}

			$all_organizations = $this->champion_model->get_organisations();

			$viewArr['profile_image_name'] = $profile_image_name;
			$viewArr['profile_image'] = $profile_image;

			$viewArr['viewPage'] = "edit_champion_page";
			$viewArr['organization_list'] = $all_organizations;
			$viewArr['recieved_event_id'] = $data['event_id'];
			$viewArr['image_path_event_id'] = $data['event_id'];
			$viewArr['recieved_sub_event_id'] = $data['sub_event_id'];
			$viewArr['get_charity_id'] = $data['charity_id'];

			$this->load->view('frontend/layout', $viewArr);
		}else{
			redirect('frontend/home', 'refresh');
		}
	}




	function preview_fundraising(){
		$viewArr['viewPage'] = "preview_fundraising";
		$this->load->view('frontend/layout', $viewArr);
	}

	function view_fundraising($id = null){
		$data = $this->champion_model->view_champion_by_id($id);
		$viewArr['data'] = $data;

		//get donation data
		$donation_data = $this->donation_model->get_donation_by_champion_id($id);
		$viewArr['donation_data'] = $donation_data;

		//
		$get_event_image=$this->champion_model->get_image_path($data['event_id']);
		$viewArr['event_image'] = $get_event_image[0]['original_event_image'];

		// build donation statistics
		$statistics_array = array();
		$statistics_array['given'] = "0";
		$statistics_array['still_needed'] = $data['target_amount'];
		$statistics_array['no_of_donations'] = count($donation_data);
		$statistics_array['avg_donations'] = "0";

		if(!empty($donation_data)){
			foreach($donation_data as $donations){
				$statistics_array['given'] += $donations['donation_amount'];
			}
			$statistics_array['avg_donations'] = $statistics_array['given']/$statistics_array['no_of_donations'];
			$statistics_array['still_needed'] = $data['target_amount'] - $statistics_array['given'];

			if($statistics_array['still_needed'] < 0){
				$statistics_array['still_needed'] = "";
			}
		}

		$viewArr['statistics_array'] = $statistics_array;

		$viewArr['viewPage'] = "view_fundraising";
		$this->load->view('frontend/layout', $viewArr);
	}

	function search(){
		if(isset($_POST) && (!empty($_POST))){
			$champions_data = $this->champion_model->search($_POST);

			if(!empty($champions_data)){
			foreach($champions_data as $data_champ){
				// build loop array
				$loop_array = array();
				$loop_array['id'] = $data_champ['id'];
				$loop_array['image_path'] = $data_champ['image_path'];
				$loop_array['facebook_image_path'] = $data_champ['facebook_image_path'];
				$loop_array['display_name'] = $data_champ['display_name'];
				$loop_array['target_amount'] = $data_champ['target_amount'];
				$loop_array['charity_name'] = $data_champ['charity_name'];
				$loop_array['title'] = $data_champ['title'];
				$loop_array['created_date'] = $data_champ['created_date'];
				$loop_array['fundraising_image'] = $data_champ['fundraising_image'];

				// get raised amount
				$loop_array['raised_amount'] = $this->champion_model->get_raised_donation($data_champ['id']);

				$out_array[] = $loop_array;
			}
		}else{
			$out_array = array();
		}

		$viewArr['champions_data'] = $out_array;

			$viewArr['viewPage'] = "champion_listing_supporter";
			$this->load->view('frontend/layout', $viewArr);
		}else{
			redirect('frontend/home', 'refresh');
		}
	}

	function champion_listing(){
		// get all approved champions
		$champions_data = $this->champion_model->get_popular_champions();
		// build a output array

		if(!empty($champions_data)){
			foreach($champions_data as $data_champ){
				// build loop array
				$loop_array = array();
				$loop_array['id'] = $data_champ['id'];
				$loop_array['image_path'] = $data_champ['image_path'];
				$loop_array['facebook_image_path'] = $data_champ['facebook_image_path'];
				$loop_array['display_name'] = $data_champ['display_name'];
				$loop_array['target_amount'] = $data_champ['target_amount'];
				$loop_array['charity_name'] = $data_champ['charity_name'];
				$loop_array['title'] = $data_champ['title'];
				$loop_array['created_date'] = $data_champ['created_date'];
				$loop_array['fundraising_image'] = $data_champ['fundraising_image'];

				// get raised amount
				$loop_array['raised_amount'] = $this->champion_model->get_raised_donation($data_champ['id']);

				$out_array[] = $loop_array;
			}
		}else{
			$out_array = array();
		}
		$viewArr['seo_title'] = "Donations";
		$viewArr['champions_data'] = $out_array;
		$viewArr['viewPage'] = "champion_listing_supporter";
		$this->load->view('frontend/layout', $viewArr);
	}

	function on_load_event_by_organization(){
		if($_GET){
			if(isset($_GET['event_id'])){
				$event_id = $_GET['event_id'];
			}else{
				$event_id = "";
			}

			// find all event by organization id
			$all_events = $this->champion_model->get_all_events_for_champions($_GET['organization_id']);
			$message = "";
			if($all_events){
				echo "<option value=''>-- Select Events --</option>";
				foreach($all_events as $events){

					if($events['id'] == $event_id){
						$message = "selected";
					}else{
						$message = "";
					}

					echo "<option value='".$events['id']."'".$message.">".$events['title']."</option>";
				}
				exit;
			}else{
				echo "<option value=''>No events available<option>";
				exit;
			}
		}else{
			echo "<option value=''>No events available<option>";
			exit;
		}
	}

	function load_sub_event_by_event_id(){
		if($_GET){
			if(isset($_GET['sub_event_id'])){
				$sub_event_id = $_GET['sub_event_id'];
			}else{
				$sub_event_id = "";
			}

			// find all event by organization id
			$all_events = $this->champion_model->get_all_sub_events($_GET['event_id']);
			$message = "";
			if($all_events){
				//echo "<option value=''>-- Select Sub Events --</option>";
				foreach($all_events as $events){
					if($events['id'] == $sub_event_id){
						$message = "selected";
					}else{
						$message = "";
					}
					echo "<option value='".$events['id']."'".$message.">".$events['schedule_title']."</option>";
				}
				exit;
			}else{
				echo "<option value=''>No events available<option>";
				exit;
			}
		}else{
			echo "<option value=''>No events available<option>";
			exit;
		}
	}

	function save_fundraising(){
		$this->form_validation->set_error_delimiters('<p style="color:red;">', '</p>');
		$this->form_validation->set_rules('page_title', 'page title', 'trim|required|xss_clean');
		$this->form_validation->set_rules('display_name', 'display name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('target_amount', 'target amount', 'trim|required|xss_clean');
		$this->form_validation->set_rules('select_charity', 'select charity', 'trim|required|xss_clean');
		$this->form_validation->set_rules('select_event', 'select event', 'trim|required|xss_clean');
		$this->form_validation->set_rules('select_sub_event', 'select sub event', 'trim|required|xss_clean');
		$this->form_validation->set_rules('message', 'fundraising message', 'trim|required|xss_clean');

		if(!isset($_POST['no_image'])){
			 $this->form_validation->set_rules('fundraising_image', 'fundraising image', 'callback_handle_upload_fundraising_image');
		}else{
			$_POST['fundraise_old_image'] = 'fundraising_profile.jpg';
		}

		if($this->form_validation->run() == FALSE){
			$this->add_new_champion();
		}else{
			$sub_event_id=$this->input->post('select_sub_event');
            $get_status=$this->champion_model->get_verified_status($sub_event_id);

            if($get_status[0]['verify_supporter']==1){
            	$status=0;
            } else{
            	$status=1;
            }

			if($get_status[0]['is_support_allowed'] == 0){
            	redirect('frontend/home', 'refresh');
            }

			// build champions data array
			$data = array(
				'title' => $this->input->post('page_title'),
				'display_name' => $this->input->post('display_name'),
				'target_amount' => $this->input->post('target_amount'),
				'charity_id' => $this->input->post('select_charity'),
				'event_id' => $this->input->post('select_event'),
				'sub_event_id' => $this->input->post('select_sub_event'),
				'message' => nl2br($this->input->post('message')),
				'fundraising_image' => $this->input->post('fundraise_old_image'),
				'creator_id' => $this->session->userdata['logged_in']['id'],
				'login_type' => $this->session->userdata['logged_in']['login_type'],
				'status' => $status,
			);



			$result = $this->champion_model->save_champion($data);

			// send notification email
			$this->send_fundraising_emails($data,$result);

			$charity_data = array();
			// get charity name by id
			$charity_name = $this->champion_model->get_charity_name_by_id($this->input->post('select_charity'));

			//get event name by id
			$event_name = $this->champion_model->get_event_name_by_id($this->input->post('select_event'));

			$charity_data['charity_name'] = $charity_name;
			$charity_data['event_name'] = $event_name;

			$viewArr['result'] = $result;
			$viewArr['supporter_verification_status'] = $status;
			$viewArr['charity_data'] = $charity_data;
			$viewArr['viewPage'] = "champion_save";
			$this->load->view('frontend/layout', $viewArr);
		}
	}

	function send_fundraising_emails($data,$result){
		$user_details = $this->champion_model->get_user_details($data['creator_id']);
			if($data['status'] == 0){

			$this->load->library('email');
			$this->email->from('admin@ticketing_system.com', 'TicketingSystem');
			$this->email->to($user_details['email']);
			$this->email->bcc("darshan.more@quagnitia.com");
			$this->email->set_mailtype("html");

			$this->email->subject('Fundraising page under approval');

			$message = "Hello ".$data['display_name'];
			$message .= "<br>";
			$message .= "<br>";
			$message .= "We have received your request for creating a fundraising page for charity";
			$message .= "<br>";
			$message .= "<br>";
			$message .= "Please give us time to go through your details.";
			$message .= "<br>";
			$message .= "<br>";
			$message .= "Once we approve your details you will receive a notification email";
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
			$message .= "<B>Note: Email content is yet to be approved</B>";
			$message .= "<br>";

			$this->email->message($message);
			$resp = $this->email->send();
			return $resp;
		}else{
			$this->load->library('email');
			$this->email->from('admin@ticketing_system.com', 'TicketingSystem');
			$this->email->to($user_details['email']);
			$this->email->bcc("darshan.more@quagnitia.com");
			$this->email->set_mailtype("html");

			$this->email->subject('Congratulations - Fundraising page is live');

			$message = "Hello ".$data['display_name'];
			$message .= "<br>";
			$message .= "<br>";
			$message .= "Congratulations !!!";
			$message .= "<br>";
			$message .= "<br>";
			$message .= "You have successfully posted your fundraising page on our charity";
			$message .= "<br>";
			$message .= "<br>";
			$message .= "It is now live and available for public. Click <a target='_blank' href='http://local.ticketing_system.com/frontend/champion/view_fundraising/".$result."'>here</a> To view your page";
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
			$message .= "<B>Note: Email content is yet to be approved</B>";
			$message .= "<br>";

			$this->email->message($message);
			$resp = $this->email->send();
			return $resp;
		}
	}

	// check for image logo upload
	function handle_upload_fundraising_image(){
		$config = array();
		$config['upload_path']   = './assets/image_uploads/profile_images';
		$config['allowed_types'] = 'gif|jpg|png';
		$new_name = time().$_FILES["fundraising_image"]['name'];
		$config['file_name'] = $new_name;

		$this->load->library('upload', $config);
		$this->upload->initialize($config);

		if (isset($_FILES['fundraising_image']) && !empty($_FILES['fundraising_image']['name'])){
			if ($this->upload->do_upload('fundraising_image')){
				// set a $_POST value for 'image' that we can use later
				$upload_data    = $this->upload->data();
				$_POST['fundraise_old_image'] = $upload_data['file_name'];
				return true;
			}else{
				// possibly do some clean up ... then throw an error
				$this->form_validation->set_message('handle_upload_fundraising_image', $this->upload->display_errors());
				return false;
			}
		} else {
			// throw an error because nothing was uploaded

			//$this->form_validation->set_message('handle_upload_fundraising_image', "You must upload an fundraising image!");
			//return false;
		}
	}

	/*
	public function manage_champions(){
		if(!isset($this->session->userdata['logged_in'])){
			redirect('frontend/home', 'refresh');
		}else{
			$session_data=$this->session->userdata['logged_in'];

		    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		    	$event_name=$this->input->post('event_name');
                $data=$this->champion_model->event_based_listing($session_data['id'],$event_name);
                $viewArr['data']=$data;
		        $viewArr['viewPage'] = "manage_champions";
			    $this->load->view('frontend/layout', $viewArr);
		    } else {
		       $data=$this->champion_model->list_manage_champions($session_data['id']);
		       $viewArr['data']=$data;
		       $viewArr['viewPage'] = "manage_champions";
			   $this->load->view('frontend/layout', $viewArr);
		    }
		}
	}*/


 public function champion_event_list() {

    $session_data=$this->session->userdata['logged_in'];
    $get_user_events=$this->champion_model->user_champion_events($session_data['id']);
   // $jsutarray = array("one","two","three");
    echo json_encode ($get_user_events) ;
 }

 public function approve_champions()
 {

 	  $session_data=$this->session->userdata['logged_in'];
 	  $event_list=$this->champion_model->list_events($session_data['id']);
 	 // print_r($event_list);exit;


		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
		$this->form_validation->set_error_delimiters('<div style="color:red;">', '</div>');

		$this->form_validation->set_rules('eid', 'Event', 'trim|xss_clean|required');
		$this->form_validation->set_rules('sub_eid', 'Subevent', 'trim|xss_clean|required');

		   if($this->form_validation->run() == FALSE){
			//echo validation_errors();
		   $data=$this->champion_model->approve_champion_list($session_data['id']);
           $viewArr['data']=$data;
           $viewArr['event_list']=$event_list;
 	 	   $viewArr['viewPage'] = "approve_champions";
	 	   $this->load->view('frontend/layout', $viewArr);

		   }else{

           $eid=$this->input->post('eid');
		   $sub_eid=$this->input->post('sub_eid');

           $get_sub_event_details=$this->champion_model->get_selected_subevent($sub_eid);


		   $set_eid=$eid;
		   $set_subeid=$sub_eid;
		   $organisers_id=$session_data['id'];
           $data=$this->champion_model->approved_selected_champion_list($eid, $sub_eid, $organisers_id);

           $viewArr['set_eid']=$set_eid;
           $viewArr['set_subeid']=$set_subeid;
           $viewArr['get_sub_event_details']=$get_sub_event_details;
           $viewArr['data']=$data;
           $viewArr['event_list']=$event_list;
 	 	   $viewArr['viewPage'] = "approve_champions";
	 	   $this->load->view('frontend/layout', $viewArr);

	    	}


		}
		else
		{
           $data=$this->champion_model->approve_champion_list($session_data['id']);
           $viewArr['data']=$data;
           $viewArr['event_list']=$event_list;
 	 	   $viewArr['viewPage'] = "approve_champions";
	 	   $this->load->view('frontend/layout', $viewArr);


		}



 }

 public function get_sub_events($event_id)
 {
 	 $sub_event_list=$this->champion_model->list_sub_events($event_id);
 	 print_r($sub_event_list);exit;
 }

 public function update_fundraising_status(){
	if(isset($this->session->userdata['logged_in']['login_type']) && ($this->session->userdata['logged_in']['login_type'] == 1)){
		// build data array
		$data = array();
		if(isset($_POST['status'])){
			if($_POST['status'] == "decline"){
				$data['status'] = 2;
			}else if($_POST['status'] == "approve"){
				$data['status'] = 1;
			}else{
				return false;
			}
		}else{
			return false;
		}

		if(isset($_POST['champion_id'])){
			$data['id'] = $_POST['champion_id'];
		}else{
			return false;
		}
		// call to update fundraiser status function
		$result_set = $this->champion_model->update_fundraising_status($data);
		echo $result_set;
	}else{
		return false;
	}
 }

   public function manage_champions(){
  	    $session_data=$this->session->userdata['logged_in'];

		if(isset($_POST) && (!empty($_POST))){
			$search_values = $_POST;

			if(isset($_POST['champ_status'])){
				$viewArr['selected_champ_status_filter'] = $_POST['champ_status'];
			}else{
				$viewArr['selected_champ_status_filter'] = "";
			}
		}else{
			$search_values = array();
			$viewArr['selected_filter'] = "";
		}

		if(isset($_POST['per_page']) && ($_POST['per_page'] != "")){
			$config['per_page'] = $_POST['per_page'];
			$page_count = $_POST['per_page'];
		}else{
			$page_count = 20;
			$config['per_page'] = 20;
		}

		$totalRec = $this->champion_model->champion_listing_search_count($search_values, $session_data['id']);

		//pagination configuration
        $config['first_link']  = 'First';
        $config['div']         = 'postList'; //parent div tag id
        $config['base_url']    = base_url().'index.php/frontend/champion/manage_champions';
        $config['total_rows']  = $totalRec;
       // $config['per_page']    = 10;
        $config["uri_segment"] = 4;
		$choice = $config["total_rows"] / $config["per_page"];
		$config["num_links"] = 3;

		//config for bootstrap pagination class integration
        $config['full_tag_open'] = '<ul class="pagination" style="float:left;">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4))? $this->uri->segment(4) : 0;
		$viewArr['page_count'] = $page_count;
		$viewArr['total_records'] = $totalRec;
		$viewArr['data'] = $this->champion_model->champion_listing_search_data($config["per_page"], $page, $search_values,$session_data['id']);

		$viewArr['viewPage']="champion_listing";
	    $this->load->view('frontend/layout', $viewArr);
  }

   public function manage_champions_olderte(){
  	    $session_data=$this->session->userdata['logged_in'];
  	    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		//	print_r($_POST);exit;
          $champ_status=$_POST['champ_status'];
          $event_name=$_POST['event_name'];
          $data=$this->champion_model->champion_listing_on_search($champ_status, $event_name, $session_data['id']);
          $viewArr['data']=$data;
 	      $viewArr['viewPage']="champion_listing";
	      $this->load->view('frontend/layout', $viewArr);
		}
		else
		{

  	     $data=$this->champion_model->champion_listing_for_mychamions($session_data['id']);
  	     $viewArr['data']=$data;
 	     $viewArr['viewPage']="champion_listing";
	     $this->load->view('frontend/layout', $viewArr);
		}
  }

  public function ajax_event_names_for_my_champions(){
  	  $session_data=$this->session->userdata['logged_in'];
      $event_names=$this->champion_model->load_event_names($session_data['id']);
  	  echo json_encode($event_names);
  }

   public function approve_champions_list(){

      $session_data=$this->session->userdata['logged_in'];
 	  $event_list=$this->champion_model->list_events($session_data['id']);

 	  $set_eid="";

		if(isset($_POST) && (!empty($_POST))){
			if(isset($_POST['sub_eid']))
			{
				$sub_eid=$this->input->post('sub_eid');

				 if($sub_eid){
			      $get_sub_event_details = $this->champion_model->get_selected_subevent($sub_eid);
		           }else{
			      $get_sub_event_details = array();
		         }
		    }

			$search_values = $_POST;
			$viewArr['selected_category_filter'] = $_POST['eid'];
		}else{
			$search_values = array();
			$viewArr['selected_filter'] = "";
		}

		if(isset($_POST['per_page']) && ($_POST['per_page'] != "")){
			//echo "<pre>";
			//print_r($_POST);exit;
			$config['per_page'] = $_POST['per_page'];
			$page_count = $_POST['per_page'];
		}else{
			$page_count = 20;
			$config['per_page'] = 20;
		}

		$totalRec = $this->champion_model->get_all_champion_count($search_values);
		//echo $totalRec;exit;

		//pagination configuration
        $config['first_link']  = 'First';
        $config['div']         = 'postList'; //parent div tag id
        $config['base_url']    = base_url().'index.php/frontend/champion/approve_champions_list';
        $config['total_rows']  = $totalRec;
       // $config['per_page']    = 10;
        $config["uri_segment"] = 4;
		$choice = $config["total_rows"] / $config["per_page"];
		$config["num_links"] = 3;

		//config for bootstrap pagination class integration
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';


        $this->pagination->initialize($config);
		$page = ($this->uri->segment(4))? $this->uri->segment(4) : 0;
		//echo $page;exit;
		$viewArr['page_count'] = $page_count;
		$viewArr['total_records'] = $totalRec;
		$viewArr['event_list'] = $event_list;
		$viewArr['data'] = $this->champion_model->get_all_details($config["per_page"], $page, $search_values);

		if(isset($get_sub_event_details))
		{
			$viewArr['get_sub_event_details'] = $get_sub_event_details;
		}

	    $viewArr['viewPage'] = "approve_champions_list";
		$this->load->view('frontend/layout', $viewArr);
 }

 public function approve_champions_list_old(){

    $session_data=$this->session->userdata['logged_in'];
 	  $event_list=$this->champion_model->list_events($session_data['id']);
 	 // print_r($event_list);exit;
 	  $set_eid="";

		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
		$this->form_validation->set_error_delimiters('<div style="color:red;">', '</div>');

		$this->form_validation->set_rules('eid', 'Event', 'trim|xss_clean|required');
		$this->form_validation->set_rules('sub_eid', 'Subevent', 'trim|xss_clean');
		$this->form_validation->set_rules('e_status', 'Status', 'trim|xss_clean');

		   if($this->form_validation->run() == FALSE){
			//echo validation_errors();
		   $data=$this->champion_model->approve_champion_list($session_data['id']);
           $viewArr['data']=$data;
           $viewArr['event_list']=$event_list;
 	 	   $viewArr['viewPage'] = "approve_champion_list";
	 	   $this->load->view('frontend/layout', $viewArr);

		   }else{

           $eid=$this->input->post('eid');
		   $sub_eid=$this->input->post('sub_eid');
		   $e_status=$this->input->post('e_status');

		   if($sub_eid){
			   $get_sub_event_details = $this->champion_model->get_selected_subevent($sub_eid);
		   }else{
			   $get_sub_event_details = array();
		   }
		   $set_eid=$eid;
		   $set_subeid=$sub_eid;
		   $organisers_id=$session_data['id'];
           $data=$this->champion_model->approved_selected_champion_list($eid, $sub_eid,$e_status, $organisers_id);

           $viewArr['set_eid']=$set_eid;
           $viewArr['set_subeid']=$set_subeid;
           $viewArr['get_sub_event_details']=$get_sub_event_details;
           $viewArr['data']=$data;
           $viewArr['event_list']=$event_list;
 	 	   $viewArr['viewPage'] = "approve_champions_list";
	 	   $this->load->view('frontend/layout', $viewArr);

			}
		}
		else
		{
           $data=$this->champion_model->approve_champion_list($session_data['id']);
          // echo "<pre>";
         //  print_r($data);exit;
           $viewArr['data']=$data;
           $viewArr['event_list']=$event_list;
 	 	   $viewArr['viewPage'] = "approve_champions_list";
	 	   $this->load->view('frontend/layout', $viewArr);
	   }

 }

 function stopActivateMyPage(){

	if($_POST){
		// build data array
		$data['id'] = $this->input->post('champion_id');
		$data['status'] = $this->input->post('status');
		// call to update fundraiser status function
		$result_set = $this->champion_model->stopActivateMyPage($data);
		echo $result_set;
		exit;
	}

 }

  public function get_invites(){

	$emails_string=$this->input->post('emailTest');
	$array = explode(',', $emails_string);
	// get champion data
	$champion_id = $this->input->post('modal_champ_id');
	$champion_data = $this->champion_model->view_champion_by_id($champion_id);

	foreach($array as $emails){

		//configure email settings
		$config['protocol'] = 'sendmail';
		$config['smtp_host'] = 'ssl://smtp.gmail.com';

		$config['mailtype'] = 'html';
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;
		$config['newline'] = "\r\n"; //use double quotes
		$this->load->library('email', $config);
		$this->email->initialize($config);
		//send mail
		$this->email->from("admin@ticketing_system.com", "TicketingSystem");
		$this->email->to($emails);
		$this->email->subject('Donate to my charity - '.$this->input->post('modal_champ_title'));

		//$body = $this->input->post('modal_champ_title');
		$page_url = $this->config->item('base_url')."index.php/frontend/champion/view_fundraising/".$champion_id;
		// email content
		$content = "Hello $emails,";
		$content .= "<br><br>";
		$content .= "We welcome you to donate funds through our fundraising page created for charity <B>".$champion_data['charity_name']."</B>";
		$content .= "<br><br>";
		$content .= "Please click <a target='_blank' href=".$page_url.">here</a> to visit on fundraising page on TicketingSystem";
		$content .= "<br><br>";
		$content .= "Your small amount will make big difference for our charity organization";
		$content .= "<br><br>";
		$content .= "Thanks,";
		$content .= "<br><br>";
		$content .= $champion_data['display_name']."-TicketingSystem";
		$content .= "<br>";
		$content .= "<img src=".$this->config->item('fe_logo_image_url')." alt='logo' width='100px;'>";
		$content .= "<br>";
		$content .= "<B>Note: Email content is yet to be approved</B>";

		$this->email->message($content);

		$flag = $this->email->send();
	}

	//echo $flag;
	$this->session->set_flashdata('message', 'Your invitation was sent successfully');
	redirect('frontend/champion/manage_champions', 'refresh');

 }

  function get_event_image($event_id){
 	 $get_event_image=$this->champion_model->get_image_path($event_id);
 	 echo $get_event_image[0]['original_event_image'];
  }

  function update_fundraising(){
        $this->form_validation->set_error_delimiters('<p style="color:red;">', '</p>');
		$this->form_validation->set_rules('page_title', 'page title', 'trim|required|xss_clean');
		$this->form_validation->set_rules('display_name', 'display name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('target_amount', 'target amount', 'trim|required|xss_clean');
		$this->form_validation->set_rules('message', 'fundraising message', 'trim|required|xss_clean');

		if(!isset($_POST['no_image'])){
			$this->form_validation->set_rules('fundraising_image', 'fundraising image', 'callback_handle_upload_fundraising_image');
		}else{
			$_POST['fundraise_old_image'] = 'fundraising_profile.jpg';
		}

		if($this->form_validation->run() == FALSE){
			echo validation_errors();exit;

			$this->add_new_champion();
		}else{
			/* $sub_event_id=$this->input->post('select_sub_event');
            $get_status=$this->champion_model->get_verified_status($sub_event_id);

            if($get_status[0]['verify_supporter']==1){
            	$status=0;
            } else{
            	$status=1;
            } */

			// build champions data array
			$data = array(
				'id' => $this->input->post('champion_id'),
				'title' => $this->input->post('page_title'),
				'display_name' => $this->input->post('display_name'),
				'target_amount' => $this->input->post('target_amount'),
				'message' => nl2br($this->input->post('message')),
				'fundraising_image' => $this->input->post('fundraise_old_image'),
				'creator_id' => $this->session->userdata['logged_in']['id'],
				'login_type' => $this->session->userdata['logged_in']['login_type'],
			);

		    $champion_id = $this->input->post('champion_id');
			$result = $this->champion_model->update_champion_page($data);

			$this->session->set_flashdata('message',"Champion page record successfully updated");
			redirect('frontend/champion/manage_champions', 'refresh');
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */