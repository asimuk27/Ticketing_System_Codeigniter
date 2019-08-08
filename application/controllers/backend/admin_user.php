<?phpTicketingSystemTicketingSystemTicketingSystem

class Admin_user extends CI_Controller

{



	//default constructor

    function __construct(){

		parent::__construct();

		//Load all required classes

		$this->load->model('backend/admin_user_model');

		$this->load->library(array('form_validation','session','pagination'));

		$this->load->helper(array('form', 'url'));

		$passArg = array();



		if(!isset($this->session->userdata['admin_logged_in'])){
			redirect('backend/login', 'refresh');
		}else{
			$authorise = $this->check_valid_roles();
			if($authorise){
				redirect('backend/login', 'refresh');
			}
		}
	}

	public function check_valid_roles(){
		if(isset($this->session->userdata['admin_logged_in']['user_roles'])){
			$data_modules = $this->session->userdata['admin_logged_in']['user_roles'];
			$allowed_modules = explode(",",$data_modules);
			if(in_array("manage_admins",$allowed_modules)){
				return false;
			}else{
				return true;
			}
		}else{
			return true;
		}

	}



	function index(){

		if(isset($_POST['searchby']) && ($_POST['searchby'] != "")){

			$search_values = $_POST;

			$viewArr['selected_filter'] = $_POST['searchby'];

		}else{

			$search_values = array();

			$viewArr['selected_filter'] = "";

		}



		if(isset($_POST['page_count']) && ($_POST['page_count'] != "")){

			$config['per_page'] = $_POST['page_count'];

			$page_count = $_POST['page_count'];

		}else{

			$page_count = 5;

			$config['per_page'] = 5;

		}



		 $totalRec = $this->admin_user_model->get_all_users_count($search_values);



		//pagination configuration

        $config['first_link']  = 'First';

        $config['div']         = 'postList'; //parent div tag id

        $config['base_url']    = base_url().'index.php/backend/admin_user/index';

        $config['total_rows']  = $totalRec;

        //$config['per_page']    = 10;

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

		$viewArr['page_count'] = $page_count;

		$viewArr['total_records'] = $totalRec;

		$viewArr['listing_data'] = $this->admin_user_model->get_all_users($config["per_page"], $page, $search_values);



		$viewArr["viewPage"] = "admin_user_listing";

		$this->load->view('backend/layout',$viewArr);

	}





	function add_user_form(){

		$viewArr['get_roles'] = $this->admin_user_model->get_user_roles();

		$viewArr["viewPage"] = "add_admin_user";

		$this->load->view('backend/layout',$viewArr);

	}



	function insert_admin_user(){

		$message = array();

		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

		$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');



		$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email|is_unique[admin_users.email]');



		if($this->form_validation->run() == FALSE){

			$this->add_user_form();

		}else{

			if($this->input->post('role_areas') != ""){

				$areas = $this->input->post('role_areas');

				$org_areas = implode (",", $areas);

			}else{

				$org_areas = "";

			}



			$data = array(

				'name' => $this->input->post('name'),

				'email' => $this->input->post('email'),

				'password' => md5($this->input->post('password')),

				'roles' => $org_areas,

				'status' => '1',

			);

			$res = $this->admin_user_model->insert_admin_user($data);



			if($res == True){

				$this->send_new_entry_email_to_admin($data);

				$this->session->set_flashdata('message', 'New Admin Successfully Created.');//$message[] = "<p style='color:green;'></p>";

			}else{

				$this->session->set_flashdata('message', 'The email-id you are trying to use, already exists. Please try with different email..');

			}

			redirect('backend/admin_user/index', 'refresh');

		}

	}





	function send_new_entry_email_to_admin($data){

		$this->load->library('email');

		$this->email->from('quagnitia.testuser1@gmail.com', 'TICKETINGSYSTEM');

		$this->email->to($data['email']);

		$this->email->set_mailtype("html");

		$this->email->subject('New Admin registration ');


		$message = "Hello ".$data['name'].",";

		$message .= "<br>";

		$message .= "<br>";

		$message .= "Your acccount is registered on TICKETINGSYSTEM system for admin role.";

		$message .= "<br>";

		$message .= "<br>";

		$message .= "Login details are given below:";

		$message .= "<br>";

		$message .= "<br>";

		$message .= "Email: ".$data['email'];

		$message .= "<br>";

		$message .= "Password: ".$_POST['password'];

		$message .= "<br>";

		$message .= "<br>";

		$message .= "Once your are logged into system please change your password.";

		$message .= "<br>";

		$message .= "<br>";

		$message .= "Thanks,";

		$message .= "<br>";

		$message .= "<br>";

		$message .= "TICKETINGSYSTEM Team";

		$message .= "<br>";

		$message .= "<br>";

		$message .= "<img src=".$this->config->item('fe_logo_image_url')." alt='logo' width='100px;'>";

		$message .= "<br>";

		$message .= "<br>";



		$this->email->message($message);

		$resp = $this->email->send();

		return $resp;

	}



}



?>