<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transactions extends CI_Controller {

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
		$this->load->model('frontend/transaction_model');
		$this->load->library(array('form_validation','session','pagination'));
		$this->load->helper(array('form', 'url', 'file'));
		$this->load->library('email');
		$passArg = array();
	}

	function index(){
		$data = $this->transaction_model->get_history();

		if(isset($data) && (!empty($data))){
			$content = "<table border='1'>";
			$content .= "<tr>";
			$content .= "<th>Sr.No.</th>";
			$content .= "<th>Order Id</th>";
			$content .= "<th>Charity Name</th>";
			$content .= "<th>Event</th>";
			$content .= "<th>Sub Event</th>";
			$content .= "<th>User Id</th>";
			$content .= "<th>User Email</th>";
			$content .= "<th>Amount in $</th>";
			$content .= "<th>Txn No</th>";
			$content .= "<th>First Name</th>";
			$content .= "<th>Last Name</th>";
			$content .= "<th>Payment Method</th>";
			$content .= "<th>Status</th>";
			$content .= "</tr>";
			$i = 0;

			$fileContent="Sr.No,Order Id,Charity Name,Event,Sub Event,User Id,User Email,Amount in $,TXN NO,First Name,Last Name,Payment Method,Status \n";

			foreach($data as $result_data){

				$content .= "<tr>";
				$content .= "<td>".++$i."</td>";
				$content .= "<td>".$result_data['order_id']."</td>";
				$content .= "<td>".$result_data['charity_name']."</td>";

				// get event and sub event information
				$event_data = $this->transaction_model->get_event_by_ticket($result_data['order_id']);
				$status = $result_data['email_status'];
				if($event_data){
					$content .= "<td>".$event_data['title']."</td>";
					$content .= "<td>".$event_data['schedule_title']."</td>";
				}else{
					$event_data = $this->transaction_model->get_event_by_donation($result_data['order_id']);

					if($event_data){
						$content .= "<td>".$event_data['title']."</td>";
						$content .= "<td>".$event_data['schedule_title']."</td>";
						$status = $event_data['status'];
					}else{
						$content .= "<td></td>";
						$content .= "<td></td>";
					}
				}

				if($result_data['user_id']){
					$content .= "<td>".$result_data['user_id']."</td>";
					$user_id = $result_data['user_id'];
				}else{
					$content .= "<td>Guest</td>";
					$user_id = "Guest";
				}
				$content .= "<td>".$result_data['email']."</td>";
				$content .= "<td>".$result_data['amount']."</td>";
				$content .= "<td>".$result_data['txn_number']."</td>";
				$content .= "<td>".$result_data['first_name']."</td>";
				$content .= "<td>".$result_data['last_name']."</td>";
				$content .= "<td>".$result_data['payment_method']."</td>";

				if($status){
					$content .= "<td bgcolor='#00FF00'>Completed</td>";
					$p_status = "Completed";
				}else{
					$content .= "<td bgcolor='#FF0000'>In Complete</td>";
					$p_status = "In Complete";
				}

				$content .= "</tr>";

				 $fileContent.= "".$i.",".$result_data['order_id'].",".$result_data['charity_name'].",".$event_data['title'].",".$event_data['schedule_title'].",".$user_id.",".$result_data['email'].",".$result_data['amount'].",".$result_data['txn_number']." ,".$result_data['first_name'].",".$result_data['last_name'].",".$result_data['payment_method'].",".$p_status." \n";

			}

			$content .= "</table>";

			$csv_filename = "daily_report"."_".date("Y-m-d_H-i-s",time()).".csv";
			$fd = fopen(getcwd()."/assets/daily_reports/".$csv_filename, "w");
			fputs($fd, $fileContent);
			fclose($fd);
		}else{
			$content = "No payment history available for last 24 hours";
			$csv_filename = "";
		}


		$result = $this->send_email($content,$csv_filename);
		echo $result;
	}


	function send_email($content,$csv_filename){
		$this->load->library('email');
		$this->email->from('admin@ticketing_system.com', 'TicketingSystem');
		$this->email->to('darshan.more@quagnitia.com');
		$this->email->set_mailtype("html");

		$this->email->subject('Payment Transaction Log');

		$message = "Dear Admin,";
		$message .= "<br>";$message .= "<br>";
		$message .= $content;
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

		if($csv_filename != ""){
			$attachment_url = getcwd().'/assets/daily_reports/'.$attach_path;
			$this->email->attach($attachment_url);
		}

		$resp = $this->email->send();
		return $resp;
	}

}

?>