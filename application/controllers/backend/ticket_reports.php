<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ticket_reports extends CI_Controller {

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
        $this->load->model('backend/ticket_report_model');
        $this->load->model('frontend/ticket_model');
        $this->load->model('frontend/event_model');
        $this->load->library(array('form_validation', 'session', 'pagination', 'm_pdf'));
        $this->load->helper(array('form', 'url', 'file', 'pdf_helper'));
        $passArg = array();

        if (!isset($this->session->userdata['admin_logged_in'])) {
            redirect($this->config->item('login_url'), 'refresh');
        }
    }

    function view_ticket($id) {

        $data = $this->ticket_model->get_single_ticket($id);
        $content = '';
        $ticket_unique_id = $data[0]["id"];
        $image_url = $data[0]["qr_code_image"];
        $ticket_id_no = $data[0]["ticket_id"];
        $ticket_seq_no = $data[0]["ticket_sequence_no"];
        $o_id = $data[0]['order_id'];
        $sub_event_id = $data[0]['sub_event_id'];
        $main_event_title = $data[0]['main_event_title'];
        $charity_name = $data[0]['charity_name'];

        $get_description = $this->event_model->get_sub_event_details($sub_event_id);
        $start_date = date("jS F Y", strtotime($get_description[0]['schedule_start_date']));
        $end_date = date("F jS, Y", strtotime($get_description[0]['schedule_end_date']));
        $start_time = $get_description[0]['schedule_start_time'];
        $end_time = $get_description[0]['schedule_end_time'];
        $title = $get_description[0]['schedule_title'];
        $location = $get_description[0]['schedule_location'];
        $url_link = $this->config->item('baseurl');
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
					<td colspan="8" rowspan="1" style="background: white;border:1px solid #ccc" class="fifth"><div class="ticket_labels unique_style">Ticket Category:</div> ' . $data[0]['ticket_name'] . '</td>
				</tr>';
        $content .='</tbody></table>';
        $content .= '<br><br>';

        $get_payemnt_details = $this->ticket_model->get_payemnt_details_for_pdf($o_id);

        foreach ($get_payemnt_details as $get_payemnt_detail)
            if ($get_payemnt_detail["txn_number"] != "") {
                $txn_status = "Completed";
            } else {
                $txn_status = "";
            }

        if ($get_payemnt_detail['payment_method'] == 'dps') {
            $payment_method = "Credit Card (DPS)";
        } else {
            $payment_method = "POLi";
        }

        if ($data[0]["is_deleted"] == 0) {
            $ticket_delete_status = "Active";
        } else {
            $ticket_delete_status = "Deleted";
        }

        $content .= '<table><caption style="background-color: grey;">Details</caption>';
        $content .= '<tr><td style="text-align:left;" class="speacial_te">Organisation Name</td><td>' . $charity_name . '</td></tr>';
        $content .= '<tr><td style="text-align:left; width:180px">Event Name</td><td>' . $main_event_title . '</td></tr>';
        $content .= '<tr><td style="text-align:left; width:180px">Sub Event Name</td><td>' . $title . '</td></tr>';
        $content .= '<tr><td style="text-align:left; width:180px">Ticket Purchase Date</td><td>' . date("d-m-Y", strtotime($get_payemnt_detail['txn_date'])) . '</td></tr>';
        $content .= '<tr><td style="text-align:left; width:180px">Amount In $</td><td>' . number_format($get_payemnt_detail["amount"], 2) . '</td></tr>';
        $content .= '<tr><td style="text-align:left; width:180px">Email</td><td>' . $get_payemnt_detail["email"] . '</td></tr>';
        $content .= '<tr><td style="text-align:left; width:180px">Salutation</td><td>' . $get_payemnt_detail["salutation"] . '</td></tr>';
        $content .= '<tr><td style="text-align:left; width:180px">First Name</td><td>' . $get_payemnt_detail["first_name"] . '</td></tr>';
        $content .= '<tr><td style="text-align:left; width:180px">Last Name</td><td>' . $get_payemnt_detail["last_name"] . '</td></tr>';
        $content .= '<tr><td style="text-align:left; width:180px">Street</td><td>' . $get_payemnt_detail["address1"] . '</td></tr>';
        $content .= '<tr><td style="text-align:left; width:180px">Suburb</td><td>' . $get_payemnt_detail["address2"] . '</td></tr>';
        $content .= '<tr><td style="text-align:left; width:180px">City</td><td>' . $get_payemnt_detail["city"] . '</td></tr>';
        $content .= '<tr><td style="text-align:left; width:180px">Postal Code</td><td>' . $get_payemnt_detail["postal_code"] . '</td></tr>';
        $content .= '<tr><td style="text-align:left; width:180px">Country</td><td>' . $get_payemnt_detail["country"] . '</td></tr>';
        $content .= '<tr><td style="text-align:left; width:180px">Payment Method</td><td>' . $payment_method . '</td></tr>';
        $content .= '<tr><td style="text-align:left; width:180px">TicketingSystem Order ID</td><td>' . $get_payemnt_detail["order_id"] . '</td></tr>';
        $content .= '<tr><td style="text-align:left; width:180px">Payment Id</td><td>' . $get_payemnt_detail["txn_number"] . '</td></tr>';
        $content .= '<tr><td style="text-align:left; width:180px">Payment Gateway Status</td><td>' . $txn_status . '</td></tr>';
        $content .= '<tr><td style="text-align:left; width:180px">Ticket Status</td><td>' . $ticket_delete_status . '</td></tr>';
        $content .='</table>';
        $content .= '<br><br>';

        $stylesheet = $this->get_web_page('http://TicketingSystem.co.nz/assets/frontend/css/ticket_style.css');
        $new_style = "table tr td{background:#fff;border:1px solid #dddddd;height:20px !important;}";

        $this->m_pdf->pdf->WriteHTML($stylesheet, 1);
        $this->m_pdf->pdf->WriteHTML($new_style, 1);

        $this->m_pdf->pdf->WriteHTML($content, 2);

        if ($no_of_ticket > 0) {
            $this->m_pdf->pdf->AddPage();
        }

        $this->m_pdf->pdf->Output($ticket_unique_id . '.pdf', 'I');
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

    function index() {
        if (isset($_POST['per_page']) && ($_POST['per_page'] != "")) {
            $config['per_page'] = $_POST['per_page'];
            $page_count = $_POST['per_page'];
        } else {
            $page_count = 20;
            $config['per_page'] = 20;
        }

        if (isset($_POST) && (!empty($_POST))) {
            //print_r($_POST);exit;
            $search_values = $_POST;
        } else {
            $search_values = array();
            $search_values['searchby_org_id'] = "";
            $search_values['searchby_event_id'] = "";
            $search_values['searchby_sub_event_id'] = "";
        }

        $totalRec = $this->ticket_report_model->get_ticket_report_count($search_values);

        $config['first_link'] = 'First';
        $config['div'] = 'postList'; //parent div tag id
        $config['base_url'] = base_url() . 'index.php/backend/ticket_reports/index';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = 20;
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
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $viewArr['page_count'] = $page_count;
        $viewArr['total_records'] = $totalRec;
        $viewArr['organisers_list'] = $this->ticket_report_model->get_all_organisers();
        $viewArr['data'] = $this->ticket_report_model->get_ticket_records($config["per_page"], $page, $search_values);

        $viewArr['viewPage'] = "ticket_report_listing";
        $this->load->view('backend/layout', $viewArr);
    }

    public function get_charity_events($charity_id) {
        $get_description = $this->ticket_report_model->get_charity_events($charity_id);
        echo json_encode($get_description);
    }

    public function get_sub_events($event_id) {
        $get_description = $this->ticket_report_model->get_sub_events($event_id);
        echo json_encode($get_description);
    }

    public function export_ticket_csv() {
        if (isset($_POST) && (!empty($_POST))) {
            $search_values = $_POST;
        } else {
            $search_values = array();
            $search_values['eid'] = "";
            $search_values['sub_eid'] = "";
            $search_values['search_by_order_id'] = "";
            $search_values['search_by_email'] = "";
        }

        $result = $this->ticket_report_model->csv_download($search_values);
        if ($result) {

        } else {
            $this->session->set_flashdata('message', 'No tickets data found');
            redirect('backend/ticket_reports', 'refresh');
        }
    }

    public function refresh_listing() {
        redirect('backend/ticket_reports/', 'refresh');
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
