<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tickets extends CI_Controller {

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
		$this->load->model('frontend/ticket_model');
		$this->load->model('frontend/champion_model');
		$this->load->model('frontend/event_model');
		$this->load->library(array('form_validation','session','pagination','image_lib','m_pdf'));

		$this->load->helper(array('form', 'url', 'file','pdf_helper'));
		$this->load->library('ciqrcode');
        $passArg = array();
        // $this->output->enable_profiler(TRUE);
	}


    public function manage_ticket_booking(){

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

		$totalRec = $this->ticket_model->get_ticket_booking_count($search_values);
        $config['first_link']  = 'First';
        $config['div']         = 'postList'; //parent div tag id
        $config['base_url']    = base_url().'index.php/frontend/tickets/manage_ticket_booking';
        $config['total_rows']  = $totalRec;
       // $config['per_page']    = 10;
        $config["uri_segment"] = 4;
		$choice = $config["total_rows"] / $config["per_page"];
		$config["num_links"] = 3;

		//config for bootstrap pagination class integration
        $config['full_tag_open'] = '<ul class="pagination" style="float:left">';
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
		$viewArr['data'] = $this->ticket_model->get_ticket_booking_details($config["per_page"], $page, $search_values);

		if(isset($get_sub_event_details))
		{
			$viewArr['get_sub_event_details'] = $get_sub_event_details;
		}

	    $viewArr['viewPage'] = "organizer_ticket_booking";
		$this->load->view('frontend/layout', $viewArr);
    }

    public function view_ticket($id=null){
    	     if($id == NULL){
			redirect("frontend/home/index");
		}

		if(isset($this->session->userdata['logged_in'])){
			if($this->session->userdata['logged_in']['login_type'] == 1){
				// check if ticket is assigned to this user_error
				$result = $this->ticket_model->check_valid_organiser_ticket($id);

				if($result){
					if($this->session->userdata['logged_in']['id'] != $result){
						redirect("frontend/home/index");
					}
				}else{
					redirect("frontend/home/index");
				}
			}else{
				redirect("frontend/home/index");
			}
		}else{
			redirect("frontend/home/index");
		}

		$data=$this->ticket_model->get_single_ticket($id);

		if(empty($data)){
			redirect("frontend/home/index");
		}

             $content='';
			 $ticket_unique_id = $data[0]["id"];
             $image_url=$data[0]["qr_code_image"];
         	 $ticket_id_no=$data[0]["ticket_id"];
         	 $ticket_seq_no=$data[0]["ticket_sequence_no"];
             $o_id=$data[0]['order_id'];
             $sub_event_id=$data[0]['sub_event_id'];
             $main_event_title=$data[0]['main_event_title'];
             $charity_name=$data[0]['charity_name'];

              $get_description=$this->event_model->get_sub_event_details($sub_event_id);
              $start_date =date("jS F Y", strtotime($get_description[0]['schedule_start_date']));
              $end_date =  date("F jS, Y", strtotime($get_description[0]['schedule_end_date']));
              $start_time=$get_description[0]['schedule_start_time'];
              $end_time=$get_description[0]['schedule_end_time'];
              $title=$get_description[0]['schedule_title'];
              $location=$get_description[0]['schedule_location'];
              $url_link=$this->config->item('baseurl');
			  $add_image = base_url()."assets/frontend/images/TicketSuitLogo1_transparent.png";

		        $content .= '<table class="main_table" cellspacing="7" cellpadding="0">
				<tbody>
					<tr>
						<td colspan="8" style="background: white;" class="fifth"><div class="ticket_labels unique_style">Event Title: </div><div class="title_headings">
						 '.$title.'</div></td>
						<td colspan="3" rowspan="6" class="ticket_id"><span class="ticket_id_style">Ticket ID:</span>'.$ticket_unique_id.'
							<table class="inner_table" cellspacing="0" cellpadding="0">
								<tbody>
									<tr class="">
										<td id="qa_code_css" style="background: white;border:3px solid black;padding:5px;"><img class="qa_image" src="'.$url_link.'qr_code_images/'.$image_url.'"></td>
									</tr>
									<tr class="">
										<td id="qa_code_css" style="padding:5px;"><a target="_blank" href="http://local.ticketing_system.com/"><img style="height:45px;" class="qa_image" src="'.$add_image.'"></a></td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
					<tr>
						<td colspan="4" class="fifth"><div class="ticket_labels unique_style go_left">Event Date:</div>'.$start_date.'</td>
						<td colspan="4" class="fifth"><div class="go_right ticket_labels unique_style">Event Time:</div> '.$start_time.'</td>
					</tr>
					<tr>
						<td colspan="8" rowspan="1" style="background: white;border:1px solid #ccc" class="fifth"><div class="ticket_labels unique_style">Location:</div>'.$location;


					$content .= '</td>
					</tr>
					<tr>
						<td colspan="8" rowspan="1" style="background: white;border:1px solid #ccc" class="fifth"><div class="ticket_labels unique_style">Ticket Sequence No:</div> '.$ticket_seq_no.' </td>
					</tr>
					<tr>
						<td colspan="8" rowspan="1" style="background: white;border:1px solid #ccc" class="fifth"><div class="ticket_labels unique_style">Ticket Category:</div> '.$data[0]['ticket_name'].'</td>
					</tr>';
	            $content .='</tbody></table>';
				$content .= '<br><br>';

                $get_payemnt_details=$this->ticket_model->get_payemnt_details_for_pdf($o_id);

                foreach($get_payemnt_details as $get_payemnt_detail)

				if($get_payemnt_detail["txn_number"] != ""){
					$txn_status = "Completed";
				}else{
					$txn_status = "";
				}

				if($get_payemnt_detail['payment_method'] == 'dps'){
					$payment_method = "Credit Card (DPS)";
				}else{
					$payment_method = "POLi";
				}

				if($data[0]["is_deleted"] == 0){
					$ticket_delete_status = "Active";
				}else{
					$ticket_delete_status = "Deleted";
				}

				$result_data = $this->ticket_model->get_ticket_scan_details($id);

				if(!empty($result_data)){
					$content .=  '<table><caption style="background-color: grey;">Ticket Scan History</caption>';
					$content .=  '<tr><th>Scanned Date</th><th>Upload Date</th><th>Usher Name</th><th>Email</th></tr>';
					$i=1;
					foreach($result_data as $values){
						$content .=  '<tr><td style="text-align:left; width:160px">'.date("d-m-Y", strtotime($values["date"])).'  '.date("g:i a", strtotime($values["time"])).'</td><td style="text-align:left; width:160px">'.date("d-m-Y", strtotime($values["upload_date"])).'  '.date("g:i a", strtotime($values["upload_time"])).'</td><td style="text-align:left; width:180px">'.$values["name"].'</td><td>'.$values["email"].'</td></tr>';
						$i++;
					}
					$content .=  '</table><br>';
				}

				$content .=	 '<table><caption style="background-color: grey;">Details</caption>';
				$content .=	 '<tr><td style="text-align:left; width:180px">Organisation Name</td><td>'.$charity_name.'</td></tr>';
				$content .=	 '<tr><td style="text-align:left; width:180px">Event Name</td><td>'.$main_event_title.'</td></tr>';
				$content .=	 '<tr><td style="text-align:left; width:180px">Sub Event Name</td><td>'.$title.'</td></tr>';
				$content .=	 '<tr><td style="text-align:left; width:180px">Ticket Purchase Date</td><td>'.$get_payemnt_detail["txn_date"].'</td></tr>';
				$content .=	 '<tr><td style="text-align:left; width:180px">Amount In $</td><td>'.number_format($get_payemnt_detail["amount"],2).'</td></tr>';
				$content .=	 '<tr><td style="text-align:left; width:180px">Email</td><td>'.$get_payemnt_detail["email"].'</td></tr>';
				$content .=	 '<tr><td style="text-align:left; width:180px">Salutation</td><td>'.$get_payemnt_detail["salutation"].'</td></tr>';
				$content .=	 '<tr><td style="text-align:left; width:180px">First Name</td><td>'.$get_payemnt_detail["first_name"].'</td></tr>';
				$content .=	 '<tr><td style="text-align:left; width:180px">Last Name</td><td>'.$get_payemnt_detail["last_name"].'</td></tr>';
				$content .=	 '<tr><td style="text-align:left; width:180px">Street</td><td>'.$get_payemnt_detail["address1"].'</td></tr>';
				$content .=	 '<tr><td style="text-align:left; width:180px">Suburb</td><td>'.$get_payemnt_detail["address2"].'</td></tr>';
				$content .=	 '<tr><td style="text-align:left; width:180px">City</td><td>'.$get_payemnt_detail["city"].'</td></tr>';
				$content .=	 '<tr><td style="text-align:left; width:180px">Postal Code</td><td>'.$get_payemnt_detail["postal_code"].'</td></tr>';
				$content .=	 '<tr><td style="text-align:left; width:180px">Country</td><td>'.$get_payemnt_detail["country"].'</td></tr>';
				$content .=	 '<tr><td style="text-align:left; width:180px">Payment Method</td><td>'.$payment_method.'</td></tr>';
				$content .=	 '<tr><td style="text-align:left; width:180px">TicketingSystem Order ID</td><td>'.$get_payemnt_detail["order_id"].'</td></tr>';
				$content .=	 '<tr><td style="text-align:left; width:180px">Payment Id</td><td>'.$get_payemnt_detail["txn_number"].'</td></tr>';
				$content .=	 '<tr><td style="text-align:left; width:180px">Payment Gateway Status</td><td>'.$txn_status.'</td></tr>';
				$content .=	 '<tr><td style="text-align:left; width:180px">Ticket Status</td><td>'.$ticket_delete_status.'</td></tr>';
				 $content .='</table>';
				$content .= '<br><br>';

		$stylesheet = $this->get_web_page('http://TicketingSystem.co.nz/assets/frontend/css/ticket_style.css');
		$new_style = "table tr td{background:#fff;border:1px solid #dddddd;height:20px !important;}";

		$this->m_pdf->pdf->WriteHTML($stylesheet,1);
		$this->m_pdf->pdf->WriteHTML($new_style,1);

		$this->m_pdf->pdf->WriteHTML($content,2);

		 if($no_of_ticket > 0){
			$this->m_pdf->pdf->AddPage();
		 }

		$this->m_pdf->pdf->Output($ticket_unique_id.'.pdf', 'I');
    }

	function get_web_page($url){
		$ch = curl_init();
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
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

	 public function manage_user_ticket_booking(){
    	$session_data=$this->session->userdata['logged_in'];
		$event_list=$this->champion_model->list_events_user($session_data['id']);//see in the model

    	$set_eid="";

		if(isset($_POST) && (!empty($_POST))){
			if(isset($_POST['sub_eid']))
			{
				//echo "<pre>";
				//print_r($_POST);exit;
				 $sub_eid=$this->input->post('sub_eid');
				 //echo $sub_eid;exit;

				  if($sub_eid){
			       $get_sub_event_details = $this->champion_model->get_selected_subevent($sub_eid);
			      // print_r($get_sub_event_details);exit;
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

		$totalRec = $this->ticket_model->get_user_ticket_booking_count($search_values);
        $config['first_link']  = 'First';
        $config['div']         = 'postList'; //parent div tag id
        $config['base_url']    = base_url().'index.php/frontend/tickets/manage_user_ticket_booking';
        $config['total_rows']  = $totalRec;
       // $config['per_page']    = 10;
        $config["uri_segment"] = 4;
		$choice = $config["total_rows"] / $config["per_page"];
		$config["num_links"] = 3;

		//config for bootstrap pagination class integration
        $config['full_tag_open'] = '<ul class="pagination" style="float:left">';
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
		$viewArr['data'] = $this->ticket_model->get_user_ticket_booking_details($config["per_page"], $page, $search_values);

		if(isset($get_sub_event_details))
		{
			$viewArr['get_sub_event_details'] = $get_sub_event_details;
		}

	    $viewArr['viewPage'] = "user_ticket_booking";
		$this->load->view('frontend/layout', $viewArr);
    }

    public function view_user_ticket($id=null){
		if($id == NULL){
			redirect("frontend/home/index");
		}

		if(isset($this->session->userdata['logged_in'])){
			if($this->session->userdata['logged_in']['login_type'] == 0){
				// check if ticket is assigned to this user_error
				$result = $this->ticket_model->check_valid_ticket_user($this->session->userdata['logged_in']['id'],$id);

				if(empty($result)){
					redirect("frontend/home/index");
				}
			}else{
				redirect("frontend/home/index");
			}
		}else{
			redirect("frontend/home/index");
		}

		$data=$this->ticket_model->get_single_ticket_user($id);
    	if(empty($data)){
			redirect("frontend/home/index");
		}

             $content='';
			 $ticket_unique_id = $data[0]["id"];
             $image_url=$data[0]["qr_code_image"];
         	 $ticket_id_no=$data[0]["ticket_id"];
         	 $ticket_seq_no=$data[0]["ticket_sequence_no"];
             $o_id=$data[0]['order_id'];
             $sub_event_id=$data[0]['sub_event_id'];

              $get_description=$this->event_model->get_sub_event_details($sub_event_id);
              $start_date =date("jS F Y", strtotime($get_description[0]['schedule_start_date']));
              $end_date =  date("F jS, Y", strtotime($get_description[0]['schedule_end_date']));
              $start_time=$get_description[0]['schedule_start_time'];
              $end_time=$get_description[0]['schedule_end_time'];
              $title=$get_description[0]['schedule_title'];
              $location=$get_description[0]['schedule_location'];
              $url_link=$this->config->item('baseurl');
          $add_image = "http://TicketingSystem.co.nz/assets/frontend/images/TicketSuitLogo1_transparent.png";

		     $content .= '<table class="main_table" cellspacing="7" cellpadding="0">
				<tbody>
					<tr>
						<td colspan="8" style="background: white;" class="fifth"><div class="ticket_labels unique_style">Event Title: </div><div class="title_headings">
						 '.$title.'</div></td>
						<td colspan="3" rowspan="6" class="ticket_id"><span class="ticket_id_style">Ticket ID:</span>'.$ticket_unique_id.'
							<table class="inner_table" cellspacing="0" cellpadding="0">
								<tbody>
									<tr class="">
										<td id="qa_code_css" style="background: white;border:3px solid black;padding:5px;"><img class="qa_image" src="'.$url_link.'qr_code_images/'.$image_url.'"></td>
									</tr>
									<tr class="">
										<td id="qa_code_css" style="padding:5px;"><a target="_blank" href="http://local.ticketing_system.com/"><img style="height:45px;" class="qa_image" src="'.$add_image.'"></a></td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
					<tr>
						<td colspan="4" class="fifth"><div class="ticket_labels unique_style go_left">Event Date:</div>'.$start_date.'</td>
						<td colspan="4" class="fifth"><div class="go_right ticket_labels unique_style">Event Time:</div> '.$start_time.'</td>
					</tr>
					<tr>
						<td colspan="8" rowspan="1" style="background: white;border:1px solid #ccc" class="fifth"><div class="ticket_labels unique_style">Location:</div>'.$location;


					$content .= '</td>
					</tr>
					<tr>
						<td colspan="8" rowspan="1" style="background: white;border:1px solid #ccc" class="fifth"><div class="ticket_labels unique_style">Ticket Sequence No:</div> '.$ticket_seq_no.' </td>
					</tr>
					<tr>
						<td colspan="8" rowspan="1" style="background: white;border:1px solid #ccc" class="fifth"><div class="ticket_labels unique_style">Ticket Category:</div> '.$data[0]['ticket_name'].'</td>
					</tr>';
	            $content .='</tbody></table>';
				$content .= '<br><br>';


		$stylesheet = $this->get_web_page('http://TicketingSystem.co.nz/assets/frontend/css/ticket_style.css');
		$new_style = "table tr td{background:#fff;border:1px solid #dddddd;height:20px !important;}";

		$this->m_pdf->pdf->WriteHTML($stylesheet,1);
		$this->m_pdf->pdf->WriteHTML($new_style,1);

		$this->m_pdf->pdf->WriteHTML($content,2);

		 if($no_of_ticket > 0){
			$this->m_pdf->pdf->AddPage();
		 }

		$this->m_pdf->pdf->Output($ticket_unique_id.'.pdf', 'I');
    }

	public function export_csv(){
		if(isset($_POST) && (!empty($_POST))){
			$search_values = $_POST;
		}else{
			$search_values = array();
			$search_values['eid'] = "";
			$search_values['sub_eid'] = "";
			$search_values['search_by_order_id'] = "";
			$search_values['search_by_email'] = "";
		}

		$result = $this->ticket_model->csv_download($search_values);
		if($result){

		}else{
			$this->session->set_flashdata('message', 'No tickets data found');
			redirect('frontend/tickets/manage_ticket_booking', 'refresh');
		}
	}



		function change_ticket_status(){
		$id=$this->input->post('id');
		$verify_ticket=$this->ticket_model->verify_ticket($id);
		if($verify_ticket){
			if(isset($this->session->userdata['logged_in'])){
			  if($this->session->userdata['logged_in']['login_type'] == 1){
				  $org_id = $this->session->userdata['logged_in']['id'];

				  $verify_data=$this->ticket_model->verify_details($id,$org_id);

				  if($verify_data){
					   $this->ticket_model->delete_ajax_ticket($id);
						echo "1";exit;
				  }else{
						echo "4";exit;
				  }
			  }else{
			   redirect("frontend/home/index");
			  }
			}else{
			 redirect("frontend/home/index");
			}
		}else{
			 redirect("frontend/home/index");
		}
	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */