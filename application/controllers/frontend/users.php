<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {

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

		if(isset($this->session->userdata['logged_in']))
		{
			if($this->session->userdata['logged_in']['login_type'] != 0)
            redirect('frontend/home', 'refresh');
		}
	}

	public function register_user()
	{
		if(isset($this->session->userdata['logged_in']))
		{
            redirect('frontend/home', 'refresh');
		}
		//$this->handle_upload_signature();
		$this->form_validation->set_error_delimiters('<div style="color:red;">', '</div>');
		$this->form_validation->set_rules('profile_pic', 'Profile Pic', 'callback_handle_upload_signature');
		$this->form_validation->set_rules('first_name', 'First Name', 'trim|xss_clean');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|xss_clean');
		$this->form_validation->set_rules('preferred_name', 'Preferred', 'trim|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'trim|xss_clean|required|callback_has_email[email]');

		$this->form_validation->set_rules('phone_no', 'Phone Number', 'trim|xss_clean');
		$this->form_validation->set_rules('street_address', 'Street Address', 'trim|xss_clean');
		$this->form_validation->set_rules('suburb', 'Suburb', 'trim|xss_clean');

		$this->form_validation->set_rules('country', 'Country', 'trim|xss_clean');
		$this->form_validation->set_rules('postcode', 'Post code', 'trim|xss_clean');
		$this->form_validation->set_rules('birth_date', 'Birth Date', 'trim|xss_clean');
		$this->form_validation->set_rules('city', 'City', 'trim|xss_clean');

        if($this->form_validation->run() == FALSE){
        	//echo validation_errors();
			$viewArr['viewPage'] = "user_sign_up";
			$this->load->view('frontend/layout', $viewArr);
		}
		else
		{


        $email=$this->input->post('email');

		if($_POST['birth_date']==''){
			$birth_date='0000-00-00';
		}
		else
		{
			$birth_date=date("Y-m-d", strtotime(str_replace("/", "-",$this->input->post('birth_date'))));
		}

		$data = array(
       'first_name' => $this->input->post('first_name'),
       'last_name' => $this->input->post('last_name'),
       'preffered_name' => $this->input->post('preferred_name'),
       'email' => $this->input->post('email'),
       'phone_no' => $this->input->post('phone_no'),
       'password' => md5($this->input->post('password')),
       'login_type' => '',
       'street_address' => $this->input->post('street_address'),
       'suburb' => $this->input->post('suburb'),
       'city' => $this->input->post('city'),
       'postcode' => $this->input->post('postcode'),
       'country' => $this->input->post('country'),
       'birth_date' =>   $birth_date,
       'created_date' => date("Y-m-d h:i:sa"),
       'last_login' => '',
       'image_path'=>$this->input->post('profile_pic')
        );


        $this->login_model->add_user($data);
			  $this->session->set_flashdata('msg', 'Registration successfull');
	          $user_data=$this->login_model->retrive_auth_records($email);

		  $sess_array = array(
         "id" => $user_data->id,
         'email' => $user_data->email,
		 'first_name' => $user_data->first_name,
		 'login_type' => $user_data->login_type
          );

         // print_r($sess_array);exit;

          $this->session->set_userdata('logged_in', $sess_array);

		   $this->session->set_flashdata('message', 'Thanks for your registration with TICKETING SYSTEM.');
         // redirect('frontend/users/view_user_profile', 'refresh');
	     // return true;
		if($this->input->post('fund_raise_status')){
			 redirect('frontend/champion/fund_raising', 'refresh');
		 }else{
			redirect('frontend/users/view_user_profile', 'refresh');
		 }

		}





	}

	public function edit_user()
	{

		$this->form_validation->set_error_delimiters('<div style="color:red;">', '</div>');

		$this->form_validation->set_rules('first_name', 'First Name', 'trim|xss_clean');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|xss_clean');
		$this->form_validation->set_rules('preffered_name', 'Preferred', 'trim|xss_clean');
		$this->form_validation->set_rules('phone_no', 'Phone Number', 'trim|xss_clean');
		$this->form_validation->set_rules('street_address', 'Street Address', 'trim|xss_clean');
		$this->form_validation->set_rules('suburb', 'Suburb', 'trim|xss_clean');
		//$this->form_validation->set_rules('suburb', 'Suburb', 'trim|xss_clean');




        if(empty($_FILES['profile_pic']['name']))
        {
        	$_POST['profile_pic']=$this->input->post('old_image');
        }
        else
        {
        	$this->form_validation->set_rules('profile_pic', 'Profile Pic', 'callback_handle_upload_signature_edit');
        }


        if($this->form_validation->run() == FALSE){
        	//echo validation_errors();
			//$viewArr['viewPage'] = "edit_user_profile";
			$this->edit_user_profile();
			//$this->load->view('frontend/layout', $viewArr);
		}
		else
		{

		if($this->input->post('birth_date') != ""){
			$birth_date = date("Y-m-d", strtotime(str_replace("/", "-",$this->input->post('birth_date'))));
		}else{
			$birth_date = "";
		}


		$data = array(
       'first_name' => $this->input->post('first_name'),
       'last_name' => $this->input->post('last_name'),
       'preffered_name' => $this->input->post('preferred_name'),
       'phone_no' => $this->input->post('phone_no'),
       'login_type' => '',
       'street_address' => $this->input->post('street_address'),
       'suburb' => $this->input->post('suburb'),
       'city' => $this->input->post('city'),
       'postcode' => $this->input->post('postcode'),
       'country' => $this->input->post('country'),
       'birth_date' =>   $birth_date,
       'created_date' => date("Y-m-d h:i:sa"),
       'last_login' => '',
       'image_path'=>$this->input->post('profile_pic')
        );



        $session_data=$this->session->userdata['logged_in'];
        $this->login_model->edit_user($data,$session_data['id']);

	    $this->session->set_flashdata('msg', 'Your profile has been updated successfully');
        redirect('frontend/users/view_user_profile', 'refresh');
	    return true;


		}





	}

	function handle_upload_signature(){
	//	echo "In the func";exit;
		$config = array();
		$config['upload_path']   = './assets/image_uploads/profile_images';
		$config['allowed_types'] = 'gif|jpg|png';
		$new_name = time().$_FILES["profile_pic"]['name'];
        $config['file_name'] = $new_name;

		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		if (isset($_FILES['profile_pic']) && !empty($_FILES['profile_pic']['name'])){
			if ($this->upload->do_upload('profile_pic')){
				// set a $_POST value for 'image' that we can use later
				$upload_data    = $this->upload->data();
				$_POST['profile_pic'] = $upload_data['file_name'];
				return true;
			}else{
				//echo $this->upload->display_errors();
				// possibly do some clean up ... then throw an error


				$this->form_validation->set_message('handle_upload_signature', $this->upload->display_errors());
				$_POST['profile_pic'] = '';
				return false;
			}
		}
		else
		{


		        	$_POST['profile_pic'] = '';
					return true;




		}
	}

	function handle_upload_signature_edit(){
	//	echo "In the func";exit;
		$config = array();
		$config['upload_path']   = './assets/image_uploads/profile_images';
		$config['allowed_types'] = 'gif|jpg|png';
		$new_name = time().$_FILES["profile_pic"]['name'];
        $config['file_name'] = $new_name;

		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		if (isset($_FILES['profile_pic']) && !empty($_FILES['profile_pic']['name'])){
			if ($this->upload->do_upload('profile_pic')){
				// set a $_POST value for 'image' that we can use later
				$upload_data    = $this->upload->data();
				$_POST['profile_pic'] = $upload_data['file_name'];
				return true;
			}else{
				//echo $this->upload->display_errors();
				// possibly do some clean up ... then throw an error


				$this->form_validation->set_message('handle_upload_signature_edit', $this->upload->display_errors());
				$_POST['profile_pic'] = '';
				return false;
			}
		}
		else
		{


		        	$_POST['profile_pic'] = '';
					return true;




		}
	}



	public function check_unique_email()
	{
		$get_email=$_POST['email'];

		$res = $this->login_model->check_mail($get_email);

		if($res)
		{
			echo "false";
		}
		else
		{
			echo "true";
		}



	}

	public function edit_user_profile()
	{
		if(isset($this->session->userdata['logged_in'])){
			$session_data=$this->session->userdata['logged_in'];
			$data = $this->login_model->get_editable_contents($session_data['id']);
			$viewArr['data']=$data;
			// print_r($viewArr['data']);exit;
			$viewArr['viewPage'] = "edit_user_profile";
			$this->load->view('frontend/layout', $viewArr,$data);
		}else{
			 redirect('frontend/home', 'refresh');
		}
	}

	public function view_user_profile()
	{
		if(isset($this->session->userdata['logged_in'])){
		$session_data=$this->session->userdata['logged_in'];
	    $data = $this->login_model->get_profile_contents($session_data['id']);
        $viewArr['data']=$data;
      //  print_r($viewArr['data']);exit;
		$viewArr['viewPage'] = "view_user_profile";
		$this->load->view('frontend/layout', $viewArr,$data);
		}else{
			 redirect('frontend/home', 'refresh');
		}
	}

	function has_email($email){
		if ($this->login_model->authenticate_reg_email($email))
            {
                $this->form_validation->set_message('has_email', 'email already in use');
                return false;
            }
            else
            {
             return true;
            }
	}

	public function change_user_password(){
		 if(isset($this->session->userdata['logged_in'])){
			 $session_data=$this->session->userdata['logged_in'];
			 $data = $this->login_model->get_editable_contents($session_data['id']);
			 $viewArr['data']=$data;
			 // print_r($viewArr['data']);exit;
			 $viewArr['viewPage'] = "change_user_password";
			 $this->load->view('frontend/layout', $viewArr,$data);
		 }else{
				redirect('frontend/home', 'refresh');
		 }
	}

	public function user_save_change_password(){
		 $this->form_validation->set_rules('current_password', 'current password', 'trim|required|xss_clean|callback_check_password');
		 $this->form_validation->set_rules('new_password', 'new password', 'trim|required|xss_clean');
		 $this->form_validation->set_rules('confirm_password', 'confirm password', 'trim|required|xss_clean');

		 if($this->form_validation->run() == FALSE){
			 $viewArr['viewPage'] = "change_user_password";
			 $this->load->view('frontend/layout', $viewArr);
		 }else{
			$result = $this->login_model->update_user_password($this->input->post('new_password'));
			$this->session->set_flashdata('message', 'Password successfully updated');
			redirect('frontend/users/change_user_password', 'refresh');
		 }
	}

	// function check current password when user uses change password functionality
	public function check_password($password){
		$result = $this->login_model->check_profile_user_password($password);
		if($result){
			return true;
		}else{
			$this->form_validation->set_message('check_password', 'Please enter valid old current password');
			return false;
		}
	}

	function has_email_individual(){
	//	$id = $this->input->post('id');
		$session_data=$this->session->userdata['logged_in'];

		$email = $this->input->post('email');

		if($email == ""){
			echo "blank";exit;
		}

		$result = $this->login_model->authenticate_reg_email($email);
		if ($result){
			 echo "false";exit;
		}else{
			$this->login_model->update_individual_email($email,$session_data['id']);
			echo "true";exit;
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */