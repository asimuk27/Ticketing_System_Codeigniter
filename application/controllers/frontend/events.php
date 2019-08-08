<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Events extends CI_Controller {

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
        $this->load->model('frontend/event_model');
        $this->load->model('frontend/payment_model');
        $this->load->model('frontend/order_model');
        $this->load->model('frontend/login_model');
        $this->load->model('frontend/statistics_model');
        $this->load->model('frontend/champion_model');
        $this->load->model('frontend/banner_model');
        $this->load->library(array('form_validation', 'session', 'pagination', 'image_lib'));
        $this->load->helper(array('form', 'url', 'file', 'pdf_helper'));
        $this->load->library('ciqrcode');

        $passArg = array();
    }

    function index() {
        $get_banner_images = $this->banner_model->get_banner_images();
        $viewArr['get_banner_images'] = $get_banner_images;

        $data = $this->event_model->live_events();
        $viewArr['data'] = $data;
        $viewArr['seo_title'] = "Events";
        $viewArr['viewPage'] = "events_page";
        $this->load->view('frontend/layout', $viewArr);
    }

    function add_event() {
        if (isset($this->session->userdata['logged_in']['id'])) {
            $organiser_id = $this->session->userdata['logged_in']['id'];
        } else {
            $organiser_id = "";
            redirect('frontend/home', 'refresh');
        }

        //organization description
        $organization_description = $this->event_model->get_organiser_details($organiser_id);

        //ger organizer receipt information
        $receipt = $this->event_model->get_organiser_receipt($organiser_id);

        //get event categories
        $this->session->unset_userdata('sponsor_data');
        $viewArr['organization_description'] = $organization_description;
        $viewArr['organization_receipt'] = $receipt;
        $data = $this->event_model->get_event_categories();
        $viewArr['event_category'] = $data;
        $viewArr['viewPage'] = "add_event_dynamic";
        $this->load->view('frontend/layout', $viewArr);
    }

    function event_details($id = NULL) {
        if ($id) {
            $champion_allocation_status = 0;
            $check_suspend_status = $this->event_model->check_suspend_status($id);

            if ($check_suspend_status) {
                $this->error_page();
            } else {
                $event_info = $this->event_model->get_event_details($id);

                if ($event_info) {

                    $champion_allocation_status = $this->event_model->get_event_champion_status($id);

                    $organisation_info = $this->event_model->get_organiser_details($event_info['0']['organiser_id']);
                    if ($organisation_info) {
                        $viewArr['organisation_info'] = $organisation_info;
                    } else {
                        $viewArr['organisation_info'] = "";
                    }
                    $viewArr['event_info'] = $event_info;

                    //
                    $sub_event_id = $this->event_model->get_sub_event_id_by_event_id($id);

                    $sub_event_info = array();
                    $sub_event_sponsers = array();

                    if (!empty($sub_event_id)) {
                        foreach ($sub_event_id as $sub_part) {
                            // get sub event info
                            $sub_event_info = $this->event_model->event_detail_sub_event_by_event_id($sub_part->id);
                            $sub_event_sponsers = $this->event_model->get_sub_event_sponsers($sub_part->id);
                            if ($sub_event_info) {
                                $sub_event_info['sponsors'] = $sub_event_sponsers;
                                $viewArr['sub_event_info'][] = $sub_event_info;

                                $sub_event_info = array();
                            } else {
                                $viewArr['sub_event_info']['sponsors'] = $sub_event_sponsers;
                            }
                        }
                    }

                    // check if organizer is logged in
                    if (isset($this->session->userdata['logged_in']) && ($this->session->userdata['logged_in'] != "")) {
                        if ($this->session->userdata['logged_in']['login_type'] == 1) {
                            $owner_check = "1";
                        } else {
                            $owner_check = "0";
                        }
                    } else {
                        $owner_check = "0";
                    }

                    // meta tag info
                    $meta = array();
                    $meta['image'] = base_url() . "assets/image_uploads/event_image/" . $event_info['0']['original_event_image'];
                    $meta['title'] = $event_info['0']['title'];
                    $meta['description'] = $event_info['0']['event_description'];

                    $viewArr['meta'] = $meta;

                    $viewArr['owner_check'] = $owner_check;
                    $viewArr['champion_allocation_status'] = $champion_allocation_status;
                    $viewArr['viewPage'] = "event_detail";
                    $this->load->view('frontend/layout', $viewArr);
                } else {
                    redirect('frontend/home', 'refresh');
                }
            }
        } else {
            redirect('frontend/home', 'refresh');
        }
    }

    function remove_sponsor_images() {
        if ($_POST) {
            $image_name = $_POST['image_name'];
            $data = $this->session->userdata['sponsor_data'];
            if (($key = array_search($image_name, $data)) !== false) {
                unset($data[$key]);
            }
            $this->session->set_userdata('sponsor_data', $data);
            return true;
        } else {
            $this->add_event();
        }
    }

    function sponsor_data() {

        $config = array();
        $config['upload_path'] = './assets/image_uploads/sponsor_image';
        $config['allowed_types'] = 'gif|jpg|png';
        $new_name = time() . $_FILES["sponsor_image"]['name'];
        $config['file_name'] = $new_name;

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (isset($_FILES['sponsor_image']) && !empty($_FILES['sponsor_image']['name'])) {
            if ($this->upload->do_upload('sponsor_image')) {
                // set a $_POST value for 'image' that we can use later
                $upload_data = $this->upload->data();
                $image_name = $upload_data['file_name'];

                $config['image_library'] = 'gd2';
                $config['source_image'] = './assets/image_uploads/sponsor_image/' . $image_name;
                $config['create_thumb'] = TRUE;
                $config['maintain_ratio'] = TRUE;
                $config['width'] = 250;
                $config['height'] = 250;
                $this->image_lib->clear();
                $this->image_lib->initialize($config);
                $this->image_lib->resize();


                $thumbnail = $upload_data['raw_name'] . '_thumb' . $upload_data['file_ext'];

                if (isset($this->session->userdata['sponsor_data'])) {
                    $data = $this->session->userdata['sponsor_data'];
                    $data[] = $thumbnail;
                    $this->session->set_userdata('sponsor_data', $data);
                } else {
                    $data[] = $thumbnail;
                    $this->session->set_userdata('sponsor_data', $data);
                }
                $result_arr = array();
                $result_arr['status'] = "1";
                $result_arr['message'] = $thumbnail;
                echo json_encode($result_arr);
                exit;
            } else {
                // possibly do some clean up ... then throw an error
                $result_arr = array();
                $result_arr['status'] = "0";
                $result_arr['message'] = $this->upload->display_errors();
                echo json_encode($result_arr);
                exit;
            }
        } else {
            $result_arr = array();
            $result_arr['status'] = "0";
            $result_arr['message'] = "Please upload image";
            echo json_encode($result_arr);
            exit;
        }
    }

    function sponsor_sub_event_data() {

        if (isset($_POST['dynamic_event_count']) && ($_POST['dynamic_event_count'] != "") && ((is_numeric($_POST['dynamic_event_count'])))) {
            $offset_variable = $_POST['dynamic_event_count'];
            $config = array();
            $config['upload_path'] = './assets/image_uploads/sponsor_image';
            $config['allowed_types'] = 'gif|jpg|png';
            $new_name = time() . $_FILES["sponsor_image_" . $offset_variable]['name'];
            $config['file_name'] = $new_name;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (isset($_FILES['sponsor_image_' . $offset_variable]) && !empty($_FILES['sponsor_image_' . $offset_variable]['name'])) {
                if ($this->upload->do_upload('sponsor_image_' . $offset_variable)) {
                    // set a $_POST value for 'image' that we can use later
                    $upload_data = $this->upload->data();
                    $image_name = $upload_data['file_name'];

                    $config['image_library'] = 'gd2';
                    $config['source_image'] = './assets/image_uploads/sponsor_image/' . $image_name;
                    $config['create_thumb'] = TRUE;
                    $config['maintain_ratio'] = TRUE;
                    $config['width'] = 250;
                    $config['height'] = 250;
                    $this->image_lib->clear();
                    $this->image_lib->initialize($config);
                    $this->image_lib->resize();


                    $thumbnail = $upload_data['raw_name'] . '_thumb' . $upload_data['file_ext'];

                    if (isset($this->session->userdata['sponsor_data'])) {
                        $data = $this->session->userdata['sponsor_data'];
                        $data[] = $thumbnail;
                        $this->session->set_userdata('sponsor_data', $data);
                    } else {
                        $data[] = $thumbnail;
                        $this->session->set_userdata('sponsor_data', $data);
                    }
                    $result_arr = array();
                    $result_arr['status'] = "1";
                    $result_arr['message'] = $thumbnail;
                    echo json_encode($result_arr);
                    exit;
                } else {
                    // possibly do some clean up ... then throw an error
                    $result_arr = array();
                    $result_arr['status'] = "0";
                    $result_arr['message'] = $this->upload->display_errors();
                    echo json_encode($result_arr);
                    exit;
                }
            } else {
                $result_arr = array();
                $result_arr['status'] = "0";
                $result_arr['message'] = "Please upload image";
                echo json_encode($result_arr);
                exit;
            }
        } else {
            $result_arr = array();
            $result_arr['status'] = "0";
            $result_arr['message'] = "Please upload image";
            echo json_encode($result_arr);
            exit;
        }
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

    function save() {

        if (isset($this->session->userdata['logged_in']['id'])) {
            $organiser_id = $this->session->userdata['logged_in']['id'];
        } else {
            $organiser_id = "";
        }

        $this->form_validation->set_error_delimiters('<p style="color:red;">', '</p>');
        $this->form_validation->set_rules('title', 'title', 'trim|required|xss_clean');
        $this->form_validation->set_rules('event_location', 'event location', 'trim|required|xss_clean');
        $this->form_validation->set_rules('event_start_date', 'event start date', 'trim|required|xss_clean');
        $this->form_validation->set_rules('event_start_time', 'event start time', 'trim|required|xss_clean');
        $this->form_validation->set_rules('event_end_date', 'event end date', 'trim|required|xss_clean');
        $this->form_validation->set_rules('event_end_time', 'event end time', 'trim|required|xss_clean');
        $this->form_validation->set_rules('event_description', 'event description', 'trim|required|xss_clean');
        $this->form_validation->set_rules('org_description', 'org description', 'trim|required|xss_clean');
        $this->form_validation->set_rules('event_category', 'event category', 'trim|required|xss_clean');
        $this->form_validation->set_rules('event_location_latitude', 'event latitude point', 'trim|xss_clean');
        $this->form_validation->set_rules('event_location_longitude', 'event longitude point', 'trim|xss_clean');
        $this->form_validation->set_rules('donation_receipt_text', 'donation receipt', 'trim|xss_clean');

        $this->form_validation->set_rules('logo', 'logo', 'callback_handle_upload_logo');

        if ($this->form_validation->run() == FALSE) {
            $this->add_event();
        } else {
            if (isset($_POST['remaining_tickets'])) {
                $remaining_tickets = 1;
            } else {
                $remaining_tickets = 0;
            }

            if (isset($_POST['sponsor_request'])) {
                $sponsor_request = 1;
            } else {
                $sponsor_request = 0;
            }

            $formattedAddr = str_replace(' ', '+', $this->input->post('event_location'));
            //Send request and receive json data by address
            $geocodeFromAddr = $this->get_web_page('http://maps.googleapis.com/maps/api/geocode/json?address=' . $formattedAddr . '&sensor=true_or_false');
            $output1 = json_decode($geocodeFromAddr);
            //Get latitude and longitute from json data
            $data_geo['latitude'] = $output1->results[0]->geometry->location->lat;
            $data_geo['longitude'] = $output1->results[0]->geometry->location->lng;
            // organizer main details
            $data = array(
                'title' => $this->input->post('title'),
                'organiser_id' => $organiser_id,
                'donation_receipt_text' => $this->input->post('donation_receipt_text'),
                'status' => 2,
                'event_privacy' => $this->input->post('event_privacy'),
                'event_location' => $this->input->post('event_location'),
                'event_start_date' => date("Y-m-d H:i:s", strtotime(str_replace("/", "-", $this->input->post('event_start_date')))),
                'event_start_time' => $this->input->post('event_start_time'),
                'event_end_date' => date("Y-m-d H:i:s", strtotime(str_replace("/", "-", $this->input->post('event_end_date')))),
                'event_end_time' => $this->input->post('event_end_time'),
                'event_description' => $this->input->post('event_description'),
                'org_description' => $this->input->post('org_description'),
                'event_category' => $this->input->post('event_category'),
                'original_event_image' => $this->input->post('logo'),
                'event_location_latitude' => $data_geo['latitude'],
                'event_location_longitude' => $data_geo['longitude'],
                'show_remaining_tickets' => $remaining_tickets,
                'allow_sponsor_request' => $sponsor_request,
            );

            $event_id = $this->event_model->save_main_event_details($data);

            $loop_count = $_POST['dynamic_event_count'];

            for ($i = 1; $i <= $loop_count; $i++) {
                if (isset($_POST['is_supporter_allowed_' . $i])) {
                    $is_supporter_allowed = 1;
                } else {
                    $is_supporter_allowed = 0;
                }

                if (isset($_POST['verify_supporter_' . $i])) {
                    $verify_supporter = 1;
                } else {
                    $verify_supporter = 0;
                }

                // generate sub_event data array
                $data = array(
                    'schedule_title' => $this->input->post('schedule_title_' . $i),
                    'schedule_location' => $this->input->post('schedule_location_' . $i),
                    'schedule_start_date' => date("Y-m-d H:i:s", strtotime(str_replace("/", "-", $this->input->post('schedule_start_date_' . $i)))),
                    'schedule_start_time' => $this->input->post('schedule_start_time_' . $i),
                    'schedule_end_date' => date("Y-m-d H:i:s", strtotime(str_replace("/", "-", $this->input->post('schedule_end_date_' . $i)))),
                    'schedule_end_time' => $this->input->post('schedule_end_time_' . $i),
                    'schedule_event_description' => $this->input->post('schedule_event_description_' . $i),
                    'event_id' => $event_id,
                    'is_support_allowed' => $is_supporter_allowed,
                    'verify_supporter' => $verify_supporter,
                );

                $sub_event_id = $this->event_model->save_sub_event_details($data);

                // fetch paid ticket data if any
                $output_array = array();
                $data = array();

                if (!isset($_POST['no_image'])) {
                    if (isset($_POST['paid_name_' . $i])) {
                        foreach ($_POST['paid_name_' . $i] as $key => $name) {
                            $data['sub_event_id'] = $sub_event_id;
                            $data['ticket_name'] = $name;
                            $data['price'] = $_POST['paid_price_' . $i][$key];
                            $data['quantity_available'] = $_POST['paid_quantity_' . $i][$key];
                            $data['quantity_sold'] = 0;
                            $data['quantity'] = $_POST['paid_quantity_' . $i][$key];
                            $data['status'] = 1;
                            $data['order_sequence'] = $_POST['paid_order_' . $i][$key];
                            $data['ticket_type_id'] = 1;
                            $data['max_ticket_allowed'] = $_POST['paid_min_count_' . $i][$key];
                            $data['min_ticket_allowed'] = $_POST['paid_max_count_' . $i][$key];
                            $data['sale_end_date'] = date("Y-m-d H:i:s", strtotime(str_replace("/", "-", $_POST['paid_start_ticket_date_' . $i][$key])));
                            $sponsor_id = $this->event_model->save_event_tickets($data);
                            $output_array[] = $data;
                        }
                    }

                    // fetch free ticket data if any
                    $data = array();
                    $output_array = array();
                    if (isset($_POST['free_name_' . $i])) {
                        foreach ($_POST['free_name_' . $i] as $key => $name) {
                            $data['sub_event_id'] = $sub_event_id;
                            $data['ticket_name'] = $name;
                            $data['price'] = "";
                            $data['quantity_available'] = $_POST['free_quantity_' . $i][$key];
                            $data['quantity_sold'] = 0;
                            $data['order_sequence'] = $_POST['free_order_' . $i][$key];
                            $data['quantity'] = $_POST['free_quantity_' . $i][$key];
                            $data['status'] = 1;
                            $data['ticket_type_id'] = 2;
                            $data['max_ticket_allowed'] = $_POST['free_min_count_' . $i][$key];
                            $data['min_ticket_allowed'] = $_POST['free_max_count_' . $i][$key];
                            $data['sale_end_date'] = date("Y-m-d H:i:s", strtotime(str_replace("/", "-", $_POST['free_start_ticket_date_' . $i][$key])));
                            $sponsor_id = $this->event_model->save_event_tickets($data);
                            $output_array[] = $data;
                        }
                    }

                    //donation ticket information
                    $data = array();
                    $output_array = array();
                    if (isset($_POST['donation_name_' . $i])) {
                        foreach ($_POST['donation_name_' . $i] as $key => $name) {
                            $data['sub_event_id'] = $sub_event_id;
                            $data['ticket_name'] = $name;
                            $data['price'] = "";
                            $data['quantity_available'] = $_POST['donation_quantity_' . $i][$key];
                            $data['quantity_sold'] = 0;
                            $data['order_sequence'] = $_POST['donation_order_' . $i][$key];
                            $data['quantity'] = $_POST['donation_quantity_' . $i][$key];
                            $data['status'] = 1;
                            $data['ticket_type_id'] = 3;
                            $data['max_ticket_allowed'] = $_POST['donation_min_count_' . $i][$key];
                            $data['min_ticket_allowed'] = $_POST['donation_max_count_' . $i][$key];
                            $data['sale_end_date'] = date("Y-m-d H:i:s", strtotime(str_replace("/", "-", $_POST['donation_start_ticket_date_' . $i][$key])));
                            $sponsor_id = $this->event_model->save_event_tickets($data);
                            $output_array[] = $data;
                        }
                    }
                }
            }

            /*             * ********email sent to admin when event was complete*********** */
            //storing data in a databse
            $email = "tapan.moharana@gmail.com";

            //configure email settings
            $config['protocol'] = 'sendmail';
            $config['smtp_host'] = 'ssl://smtp.gmail.com';

            $config['smtp_user'] = 'jeetendra.gawas@quagnitia.com';
            $config['smtp_pass'] = 'babji123';
            $config['mailtype'] = 'html';
            $config['charset'] = 'iso-8859-1';
            $config['wordwrap'] = TRUE;
            $config['newline'] = "\r\n"; //use double quotes
            $this->load->library('email', $config);
            $this->email->initialize($config);
            //send mail
            $this->email->from("admin@ticketing_system.com", "TicketingSystem");
            $this->email->subject('Event Created Succesfully' . $data['event_details']['title']);
            $this->email->to($email);
            //$body =$this->load->view('templates/email_template',$data,TRUE);

            $body = "sfsfsfsf";
            //$this->email->attach($attachment_url);
            $this->email->message($body);

            $flag = $this->email->send();
            /*             * ******************************************************* */
            $this->session->set_flashdata('event_id', $event_id);
            redirect('frontend/events/event_save', 'refresh');
        }
    }

    function event_save() {
        $viewArr['viewPage'] = "event_save";
        $this->load->view('frontend/layout', $viewArr);
    }

    // check for image logo upload
    function handle_upload_logo() {
        $config = array();
        $config['upload_path'] = './assets/image_uploads/event_image';
        $config['allowed_types'] = 'gif|jpg|png|JPEG|Jpeg|jpeg|JPG';
        $new_name = time() . $_FILES["logo"]['name'];
        $config['file_name'] = $new_name;

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (isset($_FILES['logo']) && !empty($_FILES['logo']['name'])) {
            if ($this->upload->do_upload('logo')) {
                // set a $_POST value for 'image' that we can use later
                $upload_data = $this->upload->data();
                $_POST['logo'] = $upload_data['file_name'];
                return true;
            } else {
                // possibly do some clean up ... then throw an error
                $this->form_validation->set_message('handle_upload_logo', $this->upload->display_errors());
                return false;
            }
        } else {
            // throw an error because nothing was uploaded
            $this->form_validation->set_message('handle_upload_logo', "You must upload an logo image!");
            return false;
        }
    }

    // check for image logo upload
    function handle_sponsor_image_upload() {
        $config = array();
        $config['upload_path'] = './assets/image_uploads/sponsor_image';
        $config['allowed_types'] = 'gif|jpg|png';
        $new_name = time() . $_FILES["sponsor_image"]['name'];
        $config['file_name'] = $new_name;

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (isset($_FILES['sponsor_image']) && !empty($_FILES['sponsor_image']['name'])) {
            if ($this->upload->do_upload('logo')) {
                // set a $_POST value for 'image' that we can use later
                $upload_data = $this->upload->data();
                $_POST['sponsor_image'] = $upload_data['file_name'];
                return true;
            } else {
                // possibly do some clean up ... then throw an error
                $this->form_validation->set_message('handle_sponsor_image_upload', $this->upload->display_errors());
                return false;
            }
        } else {
            // throw an error because nothing was uploaded
            $this->form_validation->set_message('handle_sponsor_image_upload', "You must upload an sponsor image!");
            return false;
        }
    }

    function manage_events() {

        if (isset($_POST) && (!empty($_POST))) {
            $search_values = $_POST;
            $viewArr['selected_category_filter'] = $_POST['e_category'];
        } else {
            $search_values = array();
            $viewArr['selected_filter'] = "";
        }

        if (isset($_POST['per_page']) && ($_POST['per_page'] != "")) {
            $config['per_page'] = $_POST['per_page'];
            $page_count = $_POST['per_page'];
        } else {
            $page_count = 20;
            $config['per_page'] = 20;
        }
        $totalRec = $this->event_model->get_all_users_count($search_values);

        //pagination configuration
        $config['first_link'] = 'First';
        $config['div'] = 'postList'; //parent div tag id
        $config['base_url'] = base_url() . 'frontend/events/manage_events';
        $config['total_rows'] = $totalRec;
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
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $viewArr['page_count'] = $page_count;
        $viewArr['total_records'] = $totalRec;
        $viewArr['data'] = $this->event_model->get_all_users($config["per_page"], $page, $search_values);

        $category_list = $this->event_model->get_event_category_list();
        $viewArr['category_list'] = $category_list;

        $viewArr['viewPage'] = "manage_events";
        $this->load->view('frontend/layout', $viewArr);
    }

    function event_search() {
        // Display output page

        if (isset($_POST) && (!empty($_POST))) {
            $search_values = $_POST;
            $viewArr['selected_category_filter'] = $_POST['e_category'];
        } else {
            $search_values = array();
            $viewArr['selected_filter'] = "";
        }

        if (isset($_POST['per_page']) && ($_POST['per_page'] != "")) {
            $config['per_page'] = $_POST['per_page'];
            $page_count = $_POST['per_page'];
        } else {
            $page_count = 20;
            $config['per_page'] = 20;
        }
        $totalRec = $this->event_model->get_all_users_count($search_values);

        //pagination configuration
        $config['first_link'] = 'First';
        $config['div'] = 'postList'; //parent div tag id
        $config['base_url'] = base_url() . 'frontend/events/manage_events';
        $config['total_rows'] = $totalRec;
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
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $viewArr['page_count'] = $page_count;
        $viewArr['total_records'] = $totalRec;
        $viewArr['data'] = $this->event_model->get_all_users($config["per_page"], $page, $search_values);

        $category_list = $this->event_model->get_event_category_list();
        $viewArr['category_list'] = $category_list;

        $viewArr['viewPage'] = "manage_events";
        $this->load->view('frontend/layout', $viewArr);
    }

    function ajax_event_names() {
        $session_data = $this->session->userdata['logged_in'];
        $event_names = $this->event_model->get_ajax_event_names($session_data['id']);
        // $jsutarray = array("one","two","three");
        echo json_encode($event_names);
    }

    function ajax_event_city_names() {
        $session_data = $this->session->userdata['logged_in'];
        $event_cities = $this->event_model->get_event_city_names($session_data['id']);
        // $jsutarray = array("one","two","three");
        echo json_encode($event_cities);
    }

    function book_sub_events($sub_event_id = NULL, $ticket_id = NULL) {
        if(!isset($this->session->userdata['logged_in']['id'])){
            $this->session->set_flashdata('message', 'Please register first to buy a tikcet.');
            redirect('frontend/login/user_sign_up', 'refresh');
        }
        if ($sub_event_id) {
            $this->session->set_userdata('book_sub_event_id', $sub_event_id);
            $get_description = $this->event_model->get_sub_event_details($sub_event_id);
            $get_ticket_description = $this->event_model->get_book_ticket_details($sub_event_id);
            $get_champion_description = $this->event_model->get_sub_event_champions($sub_event_id);
            $get_sponsors = $this->event_model->get_sub_event_sponsors($sub_event_id);

            $validate_url = $this->event_model->validate_url($ticket_id, $sub_event_id);

            if (sizeof($validate_url) == 0) {
                redirect('frontend/home', 'refresh');
            }

            $viewArr['data'] = $get_description;
            $viewArr['get_sponsors'] = $get_sponsors;
            $viewArr['sub_event_id'] = $sub_event_id;
            $viewArr['ticket_data'] = $get_ticket_description;
            $viewArr['champion_data'] = $get_champion_description;
            /*
              if(isset($this->session->userdata['logged_in']['id']) && ($this->session->userdata['logged_in']['id'] == "1")){
              echo "<pre>";
              print_r($viewArr);
              }
             */
            //	$this->session->set_userdata('sub_event_id',$sub_event_id);
            $viewArr['viewPage'] = "book_sub_events";
            $this->load->view('frontend/layout', $viewArr);
        } else {
            redirect('frontend/home', 'refresh');
        }
    }

    function save_ticket_details() {

        if (isset($this->session->userdata['logged_in']['id'])) {
            $organiser_id = $this->session->userdata['logged_in']['id'];
        } else {
            $organiser_id = "";
        }

        if ($_POST) {
            $this->session->unset_userdata('cart');
            $this->session->unset_userdata('ticket_data');
            $this->session->unset_userdata('champion_data');
            $this->session->unset_userdata('total_order_amt');
            $this->session->unset_userdata('total_qytt');
        }

        if (!(isset($this->session->userdata['cart']))) {
            //$champ_counter=$_POST['loop_counter']-1;
            $ticket_counter = $_POST['ticket_counter'];
            $ticket_id = $_POST['ticket_id'];
            $ticket_name = $_POST['ticket_name'];
            $ticket_price = $_POST['ticket_price'];
            $qyt = $_POST['qyt'];
            $sub_event_id = $_POST['sub_event_id'];

            $book_data_array = array(
                'ticket_counter' => $ticket_counter,
                'ticket_id' => $ticket_id,
                'ticket_name' => $ticket_name,
                'ticket_price' => $ticket_price,
                'qyt' => $qyt,
                'sub_event_id' => $sub_event_id
            );

            $this->session->set_userdata('cart', $book_data_array);

            if (isset($_POST['champion_ids'])) {

                $champions_choose = $_POST['champion_ids'];
                $amount = $_POST['champion_amt'];
                $message = $_POST['champion_msg'];

                $book_data_array = array(
                    'ticket_counter' => $ticket_counter,
                    'ticket_id' => $ticket_id,
                    'ticket_name' => $ticket_name,
                    'ticket_price' => $ticket_price,
                    'qyt' => $qyt,
                    'champions_choose' => $champions_choose,
                    'amount' => $amount,
                    'message' => $message,
                    'sub_event_id' => $sub_event_id
                );
                $this->session->set_userdata('cart', $book_data_array);
            }
        }




        // echo "<pre>";
        //print_r($this->session->userdata['cart']);exit;
        $get_location = $this->event_model->fetch_location($this->session->userdata['cart']['sub_event_id']);

        $get_organisation_name = $this->event_model->get_org_name($this->session->userdata['cart']['sub_event_id']);

        $c_names = array();
        if (isset($_POST['champion_ids'])) {
            foreach ($this->session->userdata['cart']['champions_choose'] as $champ_names) {
                $get_names = $this->event_model->get_champion_title($champ_names);
                array_push($c_names, $get_names[0]['display_name']);
            }
        }

        $data = array();
        $ticket_data = array();

        $order_amount = 0;
        $total_qytt = 0;
        $temp_ticket_total = 0;
        $temp_count = 0;

        for ($i = 0; $i < $this->session->userdata['cart']['ticket_counter']; $i++) {

            if ($this->session->userdata['cart']['qyt'][$i] == 0 || $this->session->userdata['cart']['qyt'][$i] == '') {

            } else {
                $get_ticket_id = $this->session->userdata['cart']['ticket_id'][$i];
                $get_ticket_price = $this->event_model->get_ticket_price($get_ticket_id);
                if (sizeof($get_ticket_price) == 0) {

                } else {
                    $data_cnt = 0;
                    $ticket_data[$temp_count]['id'] = $this->session->userdata['cart']['ticket_id'][$i];
                    $data_cnt++;
                    $ticket_data[$temp_count]['ticket_name'] = $this->session->userdata['cart']['ticket_name'][$i];
                    $data_cnt++;
                    $ticket_data[$temp_count]['location'] = $get_location[0]['schedule_location'];
                    $data_cnt++;
                    $ticket_data[$temp_count]['fee'] = 0;
                    $data_cnt++;

                    if ($get_ticket_price[0]['ticket_type_id'] != 3)
                        $ticket_data[$temp_count]['ticket_price'] = $get_ticket_price[0]['price'] * $this->session->userdata['cart']['qyt'][$i];
                    else
                        $ticket_data[$temp_count]['ticket_price'] = $this->session->userdata['cart']['ticket_price'][$i] * $this->session->userdata['cart']['qyt'][$i];

                    $order_amount = $order_amount + $ticket_data[$temp_count]['ticket_price'];
                    $temp_ticket_total = $temp_ticket_total + $ticket_data[$temp_count]['ticket_price'];
                    $data_cnt++;
                    $ticket_data[$temp_count]['qyt'] = $this->session->userdata['cart']['qyt'][$i];
                    $total_qytt = $total_qytt + $ticket_data[$temp_count]['qyt'];
                    //echo $total_qytt;exit;
                    $data_cnt++;
                    $temp_count++;
                }
            }
        }

        if (isset($_POST['champion_ids'])) {
            $temp_champion_total = 0;
            for ($i = 0; $i < sizeof($_POST['champion_ids']); $i++) {
                $data_cnt = 0;
                $data[$i]['champ_name'] = $c_names[$i];
                $data_cnt++;
                $data[$i]['champ_choose'] = $this->session->userdata['cart']['champions_choose'][$i];
                $data_cnt++;
                $data[$i]['org_name'] = $get_organisation_name[0]['title'];
                $data_cnt++;
                $data[$i]['champ_amount'] = $this->session->userdata['cart']['amount'][$i];
                $order_amount = $order_amount + $data[$i]['champ_amount'];
                $data_cnt++;
                $data[$i]['champ_message'] = $this->session->userdata['cart']['message'][$i];
                $data_cnt++;

                $temp_champion_total = $temp_champion_total + $data[$i]['champ_amount'];
            }
        }

        if (isset($this->session->userdata['logged_in']['id'])) {
            $session_data = $this->session->userdata['logged_in'];
            $login_status = '1';
            $user_id = $session_data['id'];
        } else {
            $login_status = '2';
            $user_id = '';
        }

        if (isset($_POST['champion_ids'])) {
            $viewArr['champ_counter'] = sizeof($_POST['champion_ids']);
        }


        // get event organizer id
        $organiser_unique_id = $this->order_model->get_event_id_and_organiser_id($this->session->userdata['cart']['sub_event_id']);
        $payment_details = $this->payment_model->get_organizer_payment_methods($organiser_unique_id);


        $viewArr['login_status'] = $login_status;
        $viewArr['user_id'] = $user_id;
        $viewArr['get_location'] = $get_location;
        $viewArr['data'] = $data;
        $viewArr['ticket_data'] = $ticket_data;
        $viewArr['sub_event_id'] = $this->session->userdata['cart']['sub_event_id'];
        $viewArr['order_amount'] = $order_amount;
        $viewArr['total_qytt'] = $total_qytt;
        $viewArr['temp_ticket_total'] = $temp_ticket_total;

        if (isset($temp_champion_total))
            $viewArr['temp_champion_total'] = $temp_champion_total;

        $viewArr['viewPage'] = "show_ticket_details";

        $this->session->set_userdata('ticket_data', $ticket_data);
        $viewArr['payment_method'] = $payment_details;
        $this->session->set_userdata('champion_data', $data);
        $this->session->set_userdata('total_order_amt', $order_amount);
        $this->session->set_userdata('total_qytt', $total_qytt);
        $this->load->view('frontend/layout', $viewArr);
    }

    function save_order_details() {
        if (!isset($this->session->userdata['cart'])) {
            redirect('frontend/home', 'refresh');
        }

        $data = array();
        if (isset($this->session->userdata['logged_in']['id'])) {
            $session_data = $this->session->userdata['logged_in'];
            $user_id = $session_data['id'];
            $login_type = $session_data['login_type'];
        } else {
            $user_id = 0;
            $login_type = 0;
        }

        $result = $this->payment_model->get_last_payment_id();

        if ($result->unique_id == "") {
            $randomNumber = "000000001";
        } else {
            $string = $result->unique_id + 1;
            $randomNumber = str_pad($string, 9, "0", STR_PAD_LEFT);
        }
        $this->session->set_userdata('order_no', $randomNumber);
        $store_ticket_details = array();
        $get_event_id = $this->event_model->get_event_id($this->session->userdata['cart']['sub_event_id']);
        $s = 0;

        for ($i = 0; $i < sizeof($this->session->userdata['ticket_data']); $i++) {
            for ($j = 0; $j < $this->session->userdata['ticket_data'][$i]['qyt']; $j++) {
                $get_ticket_price = $this->event_model->get_ticket_price($this->session->userdata['ticket_data'][$i]['id']);

                $tickets_generated['order_id'] = $randomNumber;
                $tickets_generated['event_id'] = $get_event_id[0]['event_id'];
                $tickets_generated['sub_event_id'] = $this->session->userdata['cart']['sub_event_id'];
                $tickets_generated['ticket_name'] = $this->session->userdata['ticket_data'][$i]['ticket_name'];
                $tickets_generated['price'] = $get_ticket_price[0]['price'];
                $tickets_generated['qyt'] = 1;
                $tickets_generated['ticket_id'] = $this->session->userdata['ticket_data'][$i]['id'];
                $tickets_generated['user_id'] = $user_id;
                $tickets_generated['login_type'] = $login_type;
                //	$tickets_generated['qr_code_image']=$image_name;
                //	$tickets_generated['qr_data']=$params['data'];
                $tickets_generated['ticket_pdf'] = '';
                $tickets_generated['ticket_sequence_no'] = '';
                $tickets_generated['ticket_scan_status'] = '0';

                $id_count = $this->event_model->save_ticket_generation($tickets_generated);

                // generate qr code
                /* 	$params['data'] = base64_encode($randomNumber.'_'.$user_id.'._.'$id_count);
                  $params['level'] = 'H';
                  $params['size'] = 5;
                  $params['cachedir'] = FCPATH.'qr_code_images/';
                  $params['savename'] = FCPATH.'qr_code_images/'.time().'.png';
                  $image_name=time().'.png';
                  $this->ciqrcode->generate($params); */

                $tickets_generated = array();
            }
        }

        if (isset($this->session->userdata['champion_data'])) {
            $donar = array();
            for ($m = 0; $m < sizeof($this->session->userdata['champion_data']); $m++) {
                $donar['champion_page_id'] = $this->session->userdata['champion_data'][$m]['champ_choose'];
                $donar['order_id'] = $randomNumber;
                $donar['donation_amount'] = $this->session->userdata['champion_data'][$m]['champ_amount'];
                $donar['donor_message'] = $this->session->userdata['champion_data'][$m]['champ_message'];
                $donar['donor_name'] = $this->session->userdata['champion_data'][$m]['champ_name'];
                $donar['first_name'] = $_POST['g_fname'];
                $donar['last_name'] = $_POST['g_lname'];
                $donar['email'] = $_POST['g_email'];
                $donar['country'] = $_POST['g_country'];
                $donar['payment_method'] = $_POST['g_payment_method'];
                $donar['payment_status'] = 0;
                $donar['status'] = 0;
                $donar['event_id'] = 0;
                $donar['donation_type'] = '';
                $donar['salutation'] = '';
                $donar['phone'] = '';
                $donar['street'] = '';
                $donar['communication_required'] = 0;
                $this->event_model->save_donar_details($donar);
            }
        }


        // store data and get order number

        $data['order_id'] = $randomNumber;
        $data['user_id'] = $user_id;
        $data['login_type'] = $login_type;
        $data['email'] = $this->input->post('g_email');
        $data['status'] = 0;

        $data['amount'] = $this->session->userdata['total_order_amt'];
        $data['txn_date'] = date("Y-m-d H:i:s");
        $data['reference_number'] = '';
        $data['txn_number'] = '';
        $data['payment_for'] = 'purchase ticket';
        $data['created_date'] = date("Y-m-d H:i:s");
        $data['first_name'] = $this->input->post('g_fname');
        $data['last_name'] = $this->input->post('g_lname');
        $data['country'] = $this->input->post('g_country');
        $data['address1'] = $this->input->post('g_addr');
        $data['address2'] = $this->input->post('g_addr2');
        $data['city'] = $this->input->post('g_city');
        $data['postal_code'] = $this->input->post('g_postal');
        $data['payment_method'] = $this->input->post('g_payment_method');

        $this->event_model->save_payment_summary($data);

        /*
          $this->load->library('m_pdf');

          $tickets_generated=$this->event_model->get_tickets_generated($randomNumber);
          $get_description=$this->event_model->get_sub_event_details($this->session->userdata['cart']['sub_event_id']);

          $start_date =date("jS F Y", strtotime($get_description[0]['schedule_start_date']));
          $end_date =  date("F jS, Y", strtotime($get_description[0]['schedule_end_date']));
          $start_time=$get_description[0]['schedule_start_time'];
          $end_time=$get_description[0]['schedule_end_time'];
          $title=$get_description[0]['schedule_title'];
          $location=$get_description[0]['schedule_location'];

          $final = explode(",",$location);
          $event_count = count($final);

          $url_link=$this->config->item('baseurl');


          $content ='';
          $no_of_ticket = count($tickets_generated);
          foreach($tickets_generated as $tg){
          if($no_of_ticket > '0'){
          $no_of_ticket = $no_of_ticket-1;
          }
          $content ='';
          $ticket_unique_id = $tg["id"];
          $image_url=$tg["qr_code_image"];
          $ticket_id_no=$tg["ticket_id"];
          $ticket_seq_no=$tg["ticket_sequence_no"];
          $o_id=$tg['order_id'];

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
          <td colspan="8" rowspan="1" style="background: white;border:1px solid #ccc" class="fifth"><div class="ticket_labels unique_style">Ticket Sequence No:</div> '.$ticket_id_no.' </td>
          </tr>
          <tr>
          <td colspan="8" rowspan="1" style="background: white;border:1px solid #ccc" class="fifth"><div class="ticket_labels unique_style">Ticket Category:</div> '.$tg['ticket_name'].'</td>
          </tr>';
          $content .='</tbody></table>';
          $content .= '<br><br>';


          $stylesheet = file_get_contents('http://infidigi.com/event_management_uat/assets/frontend/css/ticket_style.css');
          $this->m_pdf->pdf->WriteHTML($stylesheet,1);

          $this->m_pdf->pdf->WriteHTML($content,2);

          if($no_of_ticket > 0){
          $this->m_pdf->pdf->AddPage();
          }
          }

          if (ob_get_contents()) ob_end_clean();
          //download it.
          $this->m_pdf->pdf->Output('assets/tickets_generated/'.$o_id.'.pdf', 'F');
         */
        if ($data['amount'] != "0") {
            $this->initiate_order_payment($data);
        } else {
            //$result = $this->payment_model->update_payment_status('free order',$data['order_id']);

            /* 		$check_email_status = $this->payment_model->check_email_order_status($data['order_id']);

              if($check_email_status){
              $this->send_order_email($data['order_id']);
              }
              $result = $this->payment_model->update_payment_status('free_order',$data['order_id']); */

            //$this->clear_data_on_payment_success();

            $out_array = array();
            $this->generate_tickets($out_array);

            $this->session->set_flashdata('result_data', $data['order_id']);
            redirect('frontend/events/payment_success_url', 'refresh');
        }
    }

    function initiate_order_payment($data) {
        require getcwd() . '/application/libraries/dps/dps.php';

        $PxPay_Url = "https://uat.paymentexpress.com/pxaccess/pxpay.aspx";
        $PxPay_Userid = "AhuraConsulting_Dev"; #Important! Update with your UserId
        $PxPay_Key = "78efe7aad82db9354675fea0c9fa9484d5cdeaeee1be6ad90939ce74f8c14c98"; #Important! Update with your Key

        $pxpay = new PxPay_Curl($PxPay_Url, $PxPay_Userid, $PxPay_Key);

        $request = new PxPayRequest();

        $script_url = $this->config->item('base_url') . 'frontend/events/output_url';
        # the following variables are read from the form

        $MerchantReference = $data['order_id'];
        $Address1 = $data['address1'];
        $Address2 = $data['address2'];
        $Address3 = $data['country'];

        #Calculate AmountInput
        $AmountInput = $data['amount'];

        #Generate a unique identifier for the transaction
        $TxnId = uniqid("ID");

        #Set PxPay properties
        $request->setMerchantReference($MerchantReference);
        $request->setAmountInput($AmountInput);
        $request->setTxnData1($Address1);
        $request->setTxnData2($Address2);
        $request->setTxnData3($Address3);
        $request->setTxnType("Purchase");
        $request->setCurrencyInput("NZD");
        $request->setEmailAddress($data['email']);
        $request->setUrlFail($script_url);   # can be a dedicated failure page
        $request->setUrlSuccess($script_url);   # can be a dedicated success page
        $request->setTxnId($TxnId);

        #Call makeRequest function to obtain input XML
        $request_string = $pxpay->makeRequest($request);

        #Obtain output XML
        $response = new MifMessage($request_string);

        #Parse output XML
        $url = $response->get_element_text("URI");
        $valid = $response->get_attribute("valid");

        #Redirect to payment page
        header("Location: " . $url);
    }

    function output_url() {
        require getcwd() . '/application/libraries/dps/dps.php';

        $PxPay_Url = "https://uat.paymentexpress.com/pxaccess/pxpay.aspx";
        $PxPay_Userid = "AhuraConsulting_Dev"; #Important! Update with your UserId
        $PxPay_Key = "78efe7aad82db9354675fea0c9fa9484d5cdeaeee1be6ad90939ce74f8c14c98"; #Important! Update with your Key

        $pxpay = new PxPay_Curl($PxPay_Url, $PxPay_Userid, $PxPay_Key);

        $enc_hex = $_REQUEST["result"];
        #getResponse method in PxPay object returns PxPayResponse object
        #which encapsulates all the response data
        $rsp = $pxpay->getResponse($enc_hex);

        # the following are the fields available in the PxPayResponse object
        //build output array
        $out_array = array();
        $out_array['success'] = $rsp->getSuccess();   # =1 when request succeeds
        $out_array['amountSettlement'] = $rsp->getAmountSettlement();
        $out_array['auth_code'] = $rsp->getAuthCode();  # from bank
        $out_array['card_name'] = $rsp->getCardName();  # e.g. "Visa"
        $out_array['card_number'] = $rsp->getCardNumber(); # Truncated card number
        $out_array['date_expiry'] = $rsp->getDateExpiry(); # in mmyy format
        $out_array['dps_billing_id'] = $rsp->getDpsBillingId();
        $out_array['billing_id'] = $rsp->getBillingId();
        $out_array['card_holder_name'] = $rsp->getCardHolderName();
        $out_array['dps_txn_ref'] = $rsp->getDpsTxnRef();
        $out_array['txn_type'] = $rsp->getTxnType();
        $out_array['txn_data_1'] = $rsp->getTxnData1();
        $out_array['txn_data_2'] = $rsp->getTxnData2();
        $out_array['txn_data_3'] = $rsp->getTxnData3();
        $out_array['currency_settlement'] = $rsp->getCurrencySettlement();
        $out_array['client_info'] = $rsp->getClientInfo(); # The IP address of the user who submitted the transaction
        $out_array['txn_id'] = $rsp->getTxnId();
        $out_array['currency_input'] = $rsp->getCurrencyInput();
        $out_array['email_address'] = $rsp->getEmailAddress();
        $out_array['merchant_reference'] = $rsp->getMerchantReference();
        $out_array['response_text'] = $rsp->getResponseText();
        $out_array['txn_mac'] = $rsp->getTxnMac(); # An indication as to the uniqueness of a card used in relation to others

        if ($rsp->getSuccess() == "1") {

            # Sending invoices/updating order status within database etc.
            if (!$this->isProcessed($out_array['txn_id'], $out_array['merchant_reference'])) {
                $order_id = $this->session->userdata['order_no'];
                $this->generate_tickets($out_array);
                $this->clear_data_on_payment_success();
                $this->session->set_flashdata('result_data', $order_id);
                redirect('frontend/events/payment_success_url', 'refresh');
            }
        } else {
            redirect('frontend/donation/donation_error_page', 'refresh');
        }
    }

    function generate_tickets($out_array) {
        $order_id = $this->session->userdata['order_no'];
        //if payment is completed mark tickets as processed
        $alter_status = $this->event_model->update_ticket_generated_on_order_success($order_id);

        // generate qa code for tickets of this order
        // get ticket information by order id
        $tickets_data = $this->event_model->get_tickets_generated($this->session->userdata['order_no']);

        // foreach ticket data generate qr code
        foreach ($tickets_data as $result_tickets) {
            $params['data'] = base64_encode($order_id . '_' . $result_tickets['id'] . '_' . $result_tickets['user_id']);
            $params['level'] = 'H';
            $params['size'] = 5;
            $params['cachedir'] = FCPATH . 'qr_code_images/';
            $params['savename'] = FCPATH . 'qr_code_images/' . time() . $result_tickets['id'] . '.png';
            $image_name = time() . $result_tickets['id'] . '.png';
            $this->ciqrcode->generate($params);

            // function to create sequence number
            $sequence = $this->event_model->create_sequence_number($result_tickets['event_id'], $result_tickets['sub_event_id'], $result_tickets['ticket_id']);

            // update ticket data with qa code information
            //build data array
            $qr_code_data = array();
            $qr_code_data['qr_code_image'] = $image_name;
            $qr_code_data['qr_data'] = $params['data'];
            $qr_code_data['ticket_sequence_no'] = $sequence['0']['result_count'] + 1;
            $qr_code_data['id'] = $result_tickets['id'];

            $update_status = $this->event_model->update_ticket_after_payment_process($qr_code_data);
        }

        $this->load->library('m_pdf');

        $tickets_generated = $this->event_model->get_tickets_generated($order_id);
        $get_description = $this->event_model->get_sub_event_details($this->session->userdata['cart']['sub_event_id']);

        $start_date = date("jS F Y", strtotime($get_description[0]['schedule_start_date']));
        $end_date = date("F jS, Y", strtotime($get_description[0]['schedule_end_date']));
        $start_time = $get_description[0]['schedule_start_time'];
        $end_time = $get_description[0]['schedule_end_time'];
        $title = $get_description[0]['schedule_title'];
        $location = $get_description[0]['schedule_location'];

        $final = explode(",", $location);
        $event_count = count($final);

        $url_link = $this->config->item('baseurl');


        $content = '';
        $no_of_ticket = count($tickets_generated);
        foreach ($tickets_generated as $tg) {
            if ($no_of_ticket > '0') {
                $no_of_ticket = $no_of_ticket - 1;
            }
            $content = '';
            $ticket_unique_id = $tg["id"];
            $image_url = $tg["qr_code_image"];
            $ticket_id_no = $tg["ticket_id"];
            $ticket_seq_no = $tg["ticket_sequence_no"];
            $o_id = $tg['order_id'];
            $add_image = "http://infidigi.com/event_management_uat/assets/frontend/images/TicketSuitLogo1_transparent.png";

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
								<td colspan="8" rowspan="1" style="background: white;border:1px solid #ccc" class="fifth"><div class="ticket_labels unique_style">Ticket Category:</div> ' . $tg['ticket_name'] . '</td>
							</tr>';
            $content .='</tbody></table>';
            $content .= '<br><br>';


            $stylesheet = file_get_contents('http://infidigi.com/event_management_dev/assets/frontend/css/ticket_style.css');
            $this->m_pdf->pdf->WriteHTML($stylesheet, 1);

            $this->m_pdf->pdf->WriteHTML($content, 2);

            if ($no_of_ticket > 0) {
                $this->m_pdf->pdf->AddPage();
            }
        }

        if (ob_get_contents())
            ob_end_clean();
        //download it.
        $this->m_pdf->pdf->Output('assets/tickets_generated/' . $order_id . '.pdf', 'F');


        $check_email_status = $this->payment_model->check_email_order_status($order_id);

        if ($check_email_status) {
            $this->send_order_email($order_id);
        }

        if (empty($out_array)) {
            $result = $this->payment_model->update_payment_status('free_order', $order_id);
        } else {
            $result = $this->payment_model->update_payment_status($out_array['txn_id'], $order_id);
        }

        return $result;
    }

    function clear_data_on_payment_success() {

        $this->session->unset_userdata('cart');
        $this->session->unset_userdata('ticket_data');
        $this->session->unset_userdata('champion_data');
        $this->session->unset_userdata('total_order_amt');
        $this->session->unset_userdata('total_qytt');

        if (isset($this->session->userdata['order_no'])) {
            $order_no = $this->session->userdata['order_no'];
            $get_all_ticket_ids = $this->event_model->get_ticket_ids($order_no);
            for ($i = 0; $i < sizeof($get_all_ticket_ids); $i++) {
                $count_ticket_qyt = $this->event_model->calculate_qyts($get_all_ticket_ids[$i]['ticket_id'], $order_no);
                $update_ticket_qyt = $this->event_model->update_qyts($get_all_ticket_ids[$i]['ticket_id'], $count_ticket_qyt[0]['qyts_sold']);
            }
            $this->session->unset_userdata('order_no');
        }

        return true;
    }

    function send_order_email($order_id = NULL) {

        //$order_id = "000000360";
        // based on order id get sub event and event id
        $details = $this->event_model->get_tickets_generated_email($order_id);

        $order_info = $this->event_model->get_order_history_information($order_id);

        if (isset($details['0'])) {
            $data = array();
            $data['even_sub_events'] = $details['0'];
            // get event details
            $event_details = $this->event_model->get_event_info_email($data['even_sub_events']['event_id']);

            $data['order_info'] = $order_info;
            $order_notify_email = $data['order_info']['email'];
            $data['event_details'] = $event_details;

            // get charity details
            $organizer_data = $this->event_model->get_organiser_details($event_details['organiser_id']);
            $data['organizer_data'] = $organizer_data;
            $data['ticket_data'] = $details;

            // get organizer email information
            $organizer_email = $this->event_model->get_organizer_address($event_details['organiser_id']);

            $data['organizer_email'] = $organizer_email;
        } else {
            $data = array();
        }

        //	$attachment_url = $_SERVER['DOCUMENT_ROOT'].'/event_management_uat/assets/tickets_generated/'.$order_id.'.pdf';
        $attachment_url = getcwd() . '/assets/tickets_generated/' . $order_id . '.pdf';

        /*
          echo "<pre>";
          print_r($data);
          exit;
         */
        //storing data in a databse
        $email = "quagnitia.testuser1@gmail.com";
        $name = "darshan";

        //configure email settings
        $config['protocol'] = 'sendmail';
        $config['smtp_host'] = 'ssl://smtp.gmail.com';

        $config['smtp_user'] = 'jeetendra.gawas@quagnitia.com';
        $config['smtp_pass'] = 'babji123';
        $config['mailtype'] = 'html';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['newline'] = "\r\n"; //use double quotes
        $this->load->library('email', $config);
        $this->email->initialize($config);
        //send mail
        $this->email->from("admin@ticketing_system.com", "TicketingSystem");
        $this->email->subject('Order Notification for ' . $data['event_details']['title']);
        $this->email->to($order_notify_email);
        $body = $this->load->view('templates/email_template', $data, TRUE);


        $this->email->attach($attachment_url);
        $this->email->message($body);

        $flag = $this->email->send();
    }

    function isProcessed($txn_id, $merchant_reference) {
        # Check database if order relating to TxnId has alread been processed
        $check_email_status = $this->payment_model->check_email_order_status($merchant_reference);

        if ($check_email_status) {
            return false;
        } else {
            return true;
        }
    }

    function payment_success_url() {

        $this->clear_data_on_payment_success();
        $tickets_data = $this->event_model->get_tickets_generated($this->session->flashdata('result_data'));

        if (!empty($tickets_data)) {
            $viewArr['ticket_id'] = $this->session->flashdata('result_data');
        } else {
            $viewArr['ticket_id'] = "";
        }

        $viewArr['viewPage'] = "payment_success";
        $this->load->view('frontend/layout', $viewArr);
    }

    function test_page() {
        $viewArr['viewPage'] = "payment_success";
        $this->load->view('frontend/layout', $viewArr);
    }

    function get_loggedin_user_details($user_id) {
        $user_details = $this->event_model->get_ajax_user_details($user_id);
        echo json_encode($user_details);
    }

    function verify_login_user() {
        $user_email = $_POST['user_email'];
        $user_password = $_POST['user_password'];
        //echo $user_email;
        $data = $this->event_model->event_check_login($user_email, $user_password);
        // echo $data;
        if (!$data) {
            echo "invalid";
        } else {
            $user_data = $this->login_model->retrive_auth_records($user_email);
            $sess_array = array(
                "id" => $user_data->id,
                'email' => $user_data->email,
                'first_name' => $user_data->first_name,
                'login_type' => $user_data->login_type
            );

            // print_r($sess_array);exit;

            $this->session->set_userdata('logged_in', $sess_array);
            echo json_encode($data);
        }
    }

    function ajax_get_champion_data() {
        $sub_event_id = $this->session->userdata['book_sub_event_id'];
        $get_description = $this->event_model->get_sub_event_champions($sub_event_id);
        echo json_encode($get_description);
    }

    function check_available_quantity($ticket_id, $selected_qyt) {
        $get_result = $this->event_model->get_available_quantity($ticket_id, $selected_qyt);

        if ($get_result == 'success') {
            echo "success";
            exit;
        } else {
            echo $get_result;
            exit;
        }
    }

    function edit_event($id = NULL) {
        if ($id) {
            // check event organizer validity
            if (isset($this->session->userdata['logged_in']['id'])) {
                $log_type = $this->session->userdata['logged_in']['login_type'];
                if ($log_type == '1') {
                    $org_id = $this->session->userdata['logged_in']['id'];
                    // validate authorise event owner
                    $th = $this->event_model->validate_event_owner($id, $org_id);
                    if (empty($th)) {
                        redirect('frontend/home', 'refresh');
                    }
                } else {
                    redirect('frontend/home', 'refresh');
                }
            } else {
                redirect('frontend/home', 'refresh');
            }

            $event_info = $this->event_model->get_event_details($id);

            if (isset($event_info['0'])) {
                $organisation_info = $this->event_model->get_organiser_details($event_info['0']['organiser_id']);
                if ($organisation_info) {
                    $viewArr['organisation_info'] = $organisation_info;
                } else {
                    $viewArr['organisation_info'] = "";
                }
                $viewArr['event_info'] = $event_info['0'];

                //
                $sub_event_id = $this->event_model->get_sub_event_details_by_event_id($id);

                $dynamic_event_cc = count($sub_event_id);

                $sub_event_info = array();

                if (!empty($sub_event_id)) {
                    foreach ($sub_event_id as $sub_part) {
                        // get sub event info
                        // sub event and ticket data
                        $sub_event_info['id'] = $sub_part->id;
                        $sub_event_info['event_id'] = $sub_part->event_id;
                        $sub_event_info['schedule_start_date'] = $sub_part->schedule_start_date;
                        $sub_event_info['schedule_end_date'] = $sub_part->schedule_end_date;
                        $sub_event_info['schedule_start_time'] = $sub_part->schedule_start_time;
                        $sub_event_info['schedule_end_time'] = $sub_part->schedule_end_time;
                        $sub_event_info['schedule_title'] = $sub_part->schedule_title;
                        $sub_event_info['schedule_location'] = $sub_part->schedule_location;
                        $sub_event_info['schedule_event_description'] = $sub_part->schedule_event_description;
                        $sub_event_info['is_support_allowed'] = $sub_part->is_support_allowed;
                        $sub_event_info['verify_supporter'] = $sub_part->verify_supporter;
                        $sub_event_info['status'] = $sub_part->status;
                        $sub_event_info['created_date'] = $sub_part->created_date;
                        $sub_event_info['sub_event_ticket_data'] = $this->event_model->get_ticket_details($sub_part->id);
                        $sub_event_info['sub_event_sponsor_data'] = $this->event_model->get_sub_event_sponsors($sub_part->id);


                        $qyt_counter = 0;
                        foreach ($sub_event_info['sub_event_ticket_data'] as $get_sold_qyt) {
                            if ($get_sold_qyt['quantity_sold'] > 0) {
                                $qyt_counter = 1;
                            }
                        }
                        $sub_event_info['quantity_sold_counter'] = $qyt_counter;
                        $general_data[] = $sub_event_info;
                    }
                }



                // check if organizer is logged in
                if (isset($this->session->userdata['logged_in']) && ($this->session->userdata['logged_in'] != "")) {
                    if ($this->session->userdata['logged_in']['login_type'] == 1) {
                        $owner_check = "1";
                    } else {
                        $owner_check = "0";
                    }
                } else {
                    $owner_check = "0";
                }

                $viewArr['owner_check'] = $owner_check;

                $data = $this->event_model->get_event_categories();
                $viewArr['sub_event_data'] = $general_data;
                $viewArr['event_category'] = $data;
                $viewArr['dynamic_event_count'] = $dynamic_event_cc;
                $viewArr['event_id'] = $id;
                $viewArr['viewPage'] = "edit_event";
                $this->load->view('frontend/layout', $viewArr);
            } else {
                redirect('frontend/home', 'refresh');
            }
        } else {
            redirect('frontend/home', 'refresh');
        }
    }

    function edit_event_posted_data() {
        if (isset($this->session->userdata['logged_in']['id'])) {
            $organiser_id = $this->session->userdata['logged_in']['id'];
        } else {
            redirect('frontend/home', 'refresh');
        }

        $this->form_validation->set_error_delimiters('<p style="color:red;">', '</p>');
        $this->form_validation->set_rules('title', 'title', 'trim|required|xss_clean');
        $this->form_validation->set_rules('event_location', 'event location', 'trim|required|xss_clean');
        $this->form_validation->set_rules('event_start_date', 'event start date', 'trim|required|xss_clean');
        $this->form_validation->set_rules('event_start_time', 'event start time', 'trim|required|xss_clean');
        $this->form_validation->set_rules('event_end_date', 'event end date', 'trim|required|xss_clean');
        $this->form_validation->set_rules('event_end_time', 'event end time', 'trim|required|xss_clean');
        $this->form_validation->set_rules('event_description', 'event description', 'trim|required|xss_clean');
        $this->form_validation->set_rules('org_description', 'org description', 'trim|required|xss_clean');
        $this->form_validation->set_rules('event_category', 'event category', 'trim|required|xss_clean');
        $this->form_validation->set_rules('event_location_latitude', 'event latitude point', 'trim|xss_clean');
        $this->form_validation->set_rules('event_location_longitude', 'event longitude point', 'trim|xss_clean');
        $this->form_validation->set_rules('donation_receipt_text', 'donation receipt', 'trim|xss_clean');

        $this->form_validation->set_rules('logo', 'logo', 'callback_handle_upload_logo_edit');
        //$this->form_validation->set_rules('sponsor_image', 'sponsor image', 'callback_handle_sponsor_image_upload');

        if ($this->form_validation->run() == FALSE) {
            $this->add_event();
        } else {
            if (isset($_POST['remaining_tickets'])) {
                $remaining_tickets = 1;
            } else {
                $remaining_tickets = 0;
            }

            if (isset($_POST['sponsor_request'])) {
                $sponsor_request = 1;
            } else {
                $sponsor_request = 0;
            }

            if (isset($_POST['save_and_publish'])) {
                $event_status = 1;
            } else {
                $event_status = $this->input->post('status_type');
            }

            $data = array(
                'title' => $this->input->post('title'),
                'organiser_id' => $organiser_id,
                'allow_sponsor_request' => $sponsor_request,
                'donation_receipt_text' => $this->input->post('donation_receipt_text'),
                'status' => $event_status,
                'event_privacy' => $this->input->post('event_privacy'),
                'show_remaining_tickets' => $remaining_tickets,
                'event_location' => $this->input->post('event_location'),
                'event_start_date' => date("Y-m-d H:i:s", strtotime(str_replace("/", "-", $this->input->post('event_start_date')))),
                'event_start_time' => $this->input->post('event_start_time'),
                'event_end_date' => date("Y-m-d H:i:s", strtotime(str_replace("/", "-", $this->input->post('event_end_date')))),
                'event_end_time' => $this->input->post('event_end_time'),
                'event_description' => nl2br($this->input->post('event_description')),
                'org_description' => nl2br($this->input->post('org_description')),
                'event_category' => $this->input->post('event_category'),
                'original_event_image' => $this->input->post('logo'),
                'event_location_latitude' => $this->input->post('event_location_latitude'),
                'event_location_longitude' => $this->input->post('event_location_longitude'),
            );



            $eve_id = $this->input->post('update_event_id');

            $this->event_model->update_main_event_details($data, $eve_id);

            $event_id = $eve_id;







            $loop_count = $_POST['dynamic_event_count'];

            for ($i = 1; $i <= 1; $i++) {



                for ($m = 1; $m < $_POST['sub_event_counter']; $m++) {
                    if ($this->input->post('schedule_title_' . $m) == "") {
                        continue;
                    }

                    if (isset($_POST['is_supporter_allowed_' . $m])) {
                        $is_supporter_allowed = 1;
                    } else {
                        $is_supporter_allowed = 0;
                    }

                    if (isset($_POST['verify_supporter_' . $m])) {
                        $verify_supporter = 1;
                    } else {
                        $verify_supporter = 0;
                    }
                    $data = array(
                        'id' => $this->input->post('sub_id_counter_' . $m),
                        'schedule_title' => $this->input->post('schedule_title_' . $m),
                        'schedule_location' => $this->input->post('schedule_location_' . $m),
                        'schedule_start_date' => date("Y-m-d H:i:s", strtotime(str_replace("/", "-", $this->input->post('schedule_start_date_' . $i)))),
                        'schedule_start_time' => $this->input->post('schedule_start_time_' . $m),
                        'schedule_end_date' => date("Y-m-d H:i:s", strtotime(str_replace("/", "-", $this->input->post('schedule_end_date_' . $i)))),
                        'schedule_end_time' => $this->input->post('schedule_end_time_' . $m),
                        'schedule_event_description' => $this->input->post('schedule_event_description_' . $m),
                        'event_id' => $event_id,
                        'is_support_allowed' => $is_supporter_allowed,
                        'verify_supporter' => $verify_supporter,
                    );


                    $get_id = $this->event_model->update_sub_event_details($data);

                    if ($get_id == 0) {
                        $sub_event_id = $this->input->post('sub_id_counter_' . $m);
                    } else {
                        $sub_event_id = $get_id;
                    }


                    // echo "Out of subevents";exit;
                    // fetch paid ticket data if any
                    $output_array = array();
                    $data = array();
                    if (isset($_POST['paid_name_' . $m])) {


                        foreach ($_POST['paid_name_' . $m] as $key => $name) {
                            $data['sub_event_id'] = $sub_event_id;
                            if (isset($_POST['paid_ticket_id_' . $m])) {
                                $data['id'] = $_POST['paid_ticket_id_' . $m][$key];
                            } else {
                                $data['id'] = '';
                            }

                            $data['ticket_name'] = $name;
                            $data['price'] = $_POST['paid_price_' . $m][$key];
                            $data['quantity_available'] = $_POST['paid_quantity_' . $m][$key];
                            //	$data['quantity_sold'] = 0;
                            $data['quantity'] = $_POST['paid_quantity_' . $m][$key];
                            $data['status'] = 1;
                            $data['order_sequence'] = $_POST['paid_order_' . $m][$key];
                            $data['ticket_type_id'] = 1;
                            $data['max_ticket_allowed'] = $_POST['paid_min_count_' . $m][$key];
                            $data['min_ticket_allowed'] = $_POST['paid_max_count_' . $m][$key];
                            $data['sale_end_date'] = date("Y-m-d H:i:s", strtotime(str_replace("/", "-", $_POST['paid_start_ticket_date_' . $m][$key])));
                            //echo "<pre>";
                            //print_r($data);exit;
                            $sponsor_id = $this->event_model->update_and_save_event_tickets($data);
                            $output_array[] = $data;
                        }
                    }


                    // fetch free ticket data if any
                    $data = array();
                    $output_array = array();
                    if (isset($_POST['free_name_' . $m])) {
                        foreach ($_POST['free_name_' . $m] as $key => $name) {
                            $data['sub_event_id'] = $sub_event_id;
                            if (isset($_POST['free_ticket_id_' . $m])) {
                                $data['id'] = $_POST['free_ticket_id_' . $m][$key];
                            } else {
                                $data['id'] = '';
                            }
                            $data['ticket_name'] = $name;
                            $data['price'] = 0;
                            $data['quantity_available'] = $_POST['free_quantity_' . $m][$key];
                            //	$data['quantity_sold'] = 0;
                            $data['order_sequence'] = $_POST['free_order_' . $m][$key];
                            $data['quantity'] = $_POST['free_quantity_' . $m][$key];
                            $data['status'] = 1;
                            $data['ticket_type_id'] = 2;
                            $data['max_ticket_allowed'] = $_POST['free_min_count_' . $m][$key];
                            $data['min_ticket_allowed'] = $_POST['free_max_count_' . $m][$key];
                            $data['sale_end_date'] = date("Y-m-d H:i:s", strtotime(str_replace("/", "-", $_POST['free_start_ticket_date_' . $m][$key])));
                            $sponsor_id = $this->event_model->update_and_save_event_tickets($data);
                            $output_array[] = $data;
                        }
                    }

                    //donation ticket information
                    $data = array();
                    $output_array = array();
                    if (isset($_POST['donation_name_' . $m])) {
                        foreach ($_POST['donation_name_' . $m] as $key => $name) {
                            $data['sub_event_id'] = $sub_event_id;
                            if (isset($_POST['donation_ticket_id_' . $m])) {
                                $data['id'] = $_POST['donation_ticket_id_' . $m][$key];
                            } else {
                                $data['id'] = '';
                            }
                            $data['ticket_name'] = $name;
                            $data['price'] = 0;
                            $data['quantity_available'] = $_POST['donation_quantity_' . $m][$key];
                            //	$data['quantity_sold'] = 0;
                            $data['order_sequence'] = $_POST['donation_order_' . $m][$key];
                            $data['quantity'] = $_POST['donation_quantity_' . $m][$key];
                            $data['status'] = 1;
                            $data['ticket_type_id'] = 3;
                            $data['max_ticket_allowed'] = $_POST['donation_min_count_' . $m][$key];
                            $data['min_ticket_allowed'] = $_POST['donation_max_count_' . $m][$key];
                            $data['sale_end_date'] = date("Y-m-d H:i:s", strtotime(str_replace("/", "-", $_POST['donation_start_ticket_date_' . $m][$key])));
                            $sponsor_id = $this->event_model->update_and_save_event_tickets($data);
                            $output_array[] = $data;
                        }
                    }
                }
            }

            $this->session->set_flashdata('message', "Event successfully updated");
            redirect('frontend/events/manage_events', 'refresh');
        }
    }

    function update_stop_status($status, $ticket_id) {
        $this->event_model->update_stop_status($status, $ticket_id);
    }

    function handle_upload_logo_edit() {
        $config = array();
        $config['upload_path'] = './assets/image_uploads/event_image';
        $config['allowed_types'] = 'gif|jpg|png';
        $new_name = time() . $_FILES["logo"]['name'];
        $config['file_name'] = $new_name;

        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (isset($_FILES['logo']) && !empty($_FILES['logo']['name'])) {
            if ($this->upload->do_upload('logo')) {
                $upload_data = $this->upload->data();
                //echo "<pre>";print_r($upload_data);exit;
                $_POST['logo'] = $upload_data['file_name'];
                return true;
            } else {
                $_POST['logo'] = $this->input->post('old_uploaded_logo');
                return true;
            }
        } else {
            $_POST['logo'] = $this->input->post('old_uploaded_logo');
            return true;
        }
    }

    function delete_ticket_ajax($ticket_id) {
        $this->event_model->delete_ticket_ajax($ticket_id);
    }

    function delete_sponsor() {
        $return_val = $this->event_model->delete_sponsor($_POST['sponsor_image']);

        if ($return_val) {
            echo 1;
        }
    }

    function sponsor_sub_event_data_edit() {
        if (isset($_POST['dynamic_event_count']) && ($_POST['dynamic_event_count'] != "") && ((is_numeric($_POST['dynamic_event_count'])))) {
            $offset_variable = $_GET['id_value']; //$_POST['dynamic_event_count'];
            $config = array();
            $config['upload_path'] = './assets/image_uploads/sponsor_image';
            $config['allowed_types'] = 'gif|jpg|png';
            $new_name = time() . $_FILES["sponsor_image_" . $offset_variable]['name'];
            $config['file_name'] = $new_name;



            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (isset($_FILES['sponsor_image_' . $offset_variable]) && !empty($_FILES['sponsor_image_' . $offset_variable]['name'])) {

                if ($this->upload->do_upload('sponsor_image_' . $offset_variable)) {
                    $upload_data = $this->upload->data();
                    $image_name = $upload_data['file_name'];

                    $config['image_library'] = 'gd2';
                    $config['source_image'] = './assets/image_uploads/sponsor_image/' . $image_name;
                    $config['create_thumb'] = TRUE;
                    $config['maintain_ratio'] = TRUE;
                    $config['width'] = 250;
                    $config['height'] = 250;
                    $this->image_lib->clear();
                    $this->image_lib->initialize($config);
                    $this->image_lib->resize();

                    $event_link = $_POST['hyperlink_' . $offset_variable];
                    $thumbnail = $upload_data['raw_name'] . '_thumb' . $upload_data['file_ext'];
                    $this->event_model->save_sponser_image($event_link, $thumbnail, $_GET['sub_event_key'], $_GET['event_key']);

                    if (isset($this->session->userdata['sponsor_data'])) {
                        $data = $this->session->userdata['sponsor_data'];
                        $data[] = $thumbnail;
                        $this->session->set_userdata('sponsor_data', $data);
                    } else {
                        $data[] = $thumbnail;
                        $this->session->set_userdata('sponsor_data', $data);
                    }
                    $result_arr = array();
                    $result_arr['status'] = "1";
                    $result_arr['message'] = $thumbnail;
                    echo json_encode($result_arr);
                    exit;
                } else {
                    // possibly do some clean up ... then throw an error
                    $result_arr = array();
                    $result_arr['status'] = "0";
                    $result_arr['message'] = $this->upload->display_errors();
                    echo json_encode($result_arr);
                    exit;
                }
            } else {
                $result_arr = array();
                $result_arr['status'] = "0";
                $result_arr['message'] = "Please upload image";
                echo json_encode($result_arr);
                exit;
            }
        } else {
            $result_arr = array();
            $result_arr['status'] = "0";
            $result_arr['message'] = "Please upload image";
            echo json_encode($result_arr);
            exit;
        }
    }

    function cron_job_for_closed_event_check() {
        // check for event expiry date
        $this->event_model->cron_job_for_closed_event_check();
    }

    function set_event_as_active() {
        $queryResult = $this->event_model->set_event_as_active($_POST['event_id']);
        echo $queryResult;
        exit;
    }

    function set_event_as_in_active() {

        $queryResult = $this->event_model->set_event_as_suspended($_POST['event_id']);

        /* if($_POST['event_id']){
          //search is event is popular
          $queryResult = $this->event_model->is_event_popular($_POST['event_id']);

          if($queryResult){
          $queryResult = $this->event_model->remove_event_popular($queryResult['0']['position']);
          }
          } */
        echo "1";
        exit;
    }

    function set_event_event_as_cancelled() {
        $queryResult = $this->event_model->set_event_event_as_cancelled($_POST['event_id']);
        echo $queryResult;
        exit;
    }

    function error_page() {
        $viewArr['viewPage'] = "404";
        $this->load->view('frontend/layout', $viewArr);
    }

    function save_new_sponsor_details() {
        if ($_POST) {

            $data = array(
                'event_id' => $this->input->post('event_id'),
                'event_name' => $this->input->post('event_title'),
                'organiser_id' => $this->input->post('event_organiser_id'),
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'organisation_name' => $this->input->post('org_name'),
                'contact_email' => $this->input->post('email'),
                'contact_number' => $this->input->post('contant_number'),
                'sponsor_type' => $this->input->post('sponsor_type'),
            );

            $result = $this->event_model->save_sponsor_requests($data);

            // get organizer email
            $email_id = $this->event_model->get_organiser_email($this->input->post('event_organiser_id'));

            // send email to organizer
            $this->send_sponsor_request_to_organizer($data, $email_id);

            $this->session->set_flashdata('message', 'Thanks for sending your request to be a sponsor for our event');
            redirect('frontend/events/event_details/' . $this->input->post('event_id'), 'refresh');
            return true;
        } else {
            redirect('frontend/events/event_details/' . $this->input->post('event_id'), 'refresh');
            return true;
        }
    }

    function send_sponsor_request_to_organizer($data, $email_id) {
        $this->load->library('email');
        $this->email->from('admin@ticketing_system.com', 'TicketingSystem');
        $this->email->to($email_id);
        $this->email->set_mailtype("html");

        $this->email->subject('TicketingSystem | New | Sponsor Request');

        $message = "Kia ora Event Manager, ";
        $message .= "<br>";
        $message .= "<br>";
        $message .= "We are happy to let you know that you have received a new sponsorship request";
        $message .= "<br>";
        $message .= "<br>";
        $message .= "Please see details below: ";
        $message .= "<br>";
        $message .= "<br>";
        $message .= "First Name: " . $data['last_name'];
        $message .= "<br>";
        $message .= "<br>";
        $message .= "Last Name: " . $data['last_name'];
        $message .= "<br>";
        $message .= "<br>";
        $message .= "Organisation: " . $data['organisation_name'];
        $message .= "<br>";
        $message .= "<br>";
        $message .= "Contact Email: " . $data['contact_email'];
        $message .= "<br>";
        $message .= "<br>";
        $message .= "Contact Number: " . $data['contact_number'];
        $message .= "<br>";
        $message .= "<br>";
        $message .= "Sponsorship Type: " . $data['sponsor_type'];
        $message .= "<br>";
        $message .= "<br>";
        $message .= "Thanks,";
        $message .= "<br>";
        $message .= "<br>";
        $message .= "TicketingSystem Team";
        $message .= "<br>";
        $message .= "<br>";
        $message .= "<img src=" . $this->config->item('fe_logo_image_url') . " alt='logo' width='100px;'>";
        $message .= "<br>";
        $message .= "<br>";

        $this->email->message($message);
        $resp = $this->email->send();
        return $resp;
    }

    function sponsor_request_listing() {
        if (isset($_POST['per_page']) && ($_POST['per_page'] != "")) {
            $config['per_page'] = $_POST['per_page'];
            $page_count = $_POST['per_page'];
        } else {
            $page_count = 20;
            $config['per_page'] = 20;
        }

        if (isset($_POST) && (!empty($_POST))) {
            $search_values = $_POST;
        } else {
            $search_values = array();
            $search_values['event_list'] = "";
            $search_values['search_date'] = "";
            $search_values['search_text'] = "";
        }

        $totalRec = $this->event_model->get_sponsor_request_by_organization_id_count($search_values);

        //pagination configuration
        $config['first_link'] = 'First';
        $config['div'] = 'postList'; //parent div tag id
        $config['base_url'] = base_url() . 'frontend/events/sponsor_request_listing';
        $config['total_rows'] = $totalRec;
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
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $viewArr['page_count'] = $page_count;
        $viewArr['total_records'] = $totalRec;
        $viewArr['data'] = $this->event_model->get_sponsor_request_by_organization_id_data($config["per_page"], $page, $search_values);

        // get event list by organizer id
        $viewArr['event_list_data'] = $this->event_model->get_sponsor_request_events();

        $viewArr['viewPage'] = "sponsor_request_listing";

        $this->load->view('frontend/layout', $viewArr);
    }

    function delete_sponsor_request() {
        if ($_POST) {
            $result = $this->event_model->delete_sponsor_request($_POST['request_id']);
            echo "1";
            exit;
        } else {
            echo "0";
            exit;
        }
    }

    function event_stats($event_id = NULL) {
        if ($_POST) {
            $search_id = $this->input->post('search');

            if ($search_id == 'all') {
                redirect('frontend/events/event_stats/' . $event_id . '', 'refresh');
            }

            // get donation summary
            $type = "sub_event_id";
            $detail = "main_summary";

            $viewArr['main_summary'] = $this->statistics_model->get_donation_summary($search_id, $type, $detail);

            // get sponsors
            $detail = "sponsors";
            $viewArr['sponsor_data'] = $this->statistics_model->get_donation_summary($search_id, $type, $detail);

            $detail = "champion";
            $viewArr['champion_data'] = $this->statistics_model->get_donation_summary($search_id, $type, $detail);

            $data = $this->statistics_model->get_price_by_id(1, $search_id);

            $get_all_tickets = $this->statistics_model->get_all_tickets_on_subevents($search_id); //done
            $get_event_info = $this->statistics_model->get_event_info($event_id); //done

            $get_event_tickets = $this->statistics_model->get_event_tickets_on_subevents($search_id); // done

            $get_free_tickets = $get_all_tickets['free'];
            $get_paid_tickets = $get_all_tickets['paid'];
            $get_donation_tickets = $get_all_tickets['donation'];
            $get_pending_tickets = $this->statistics_model->get_pending_tickets_on_subevents($search_id);

            $ticket_sales = 0;
            $donations = 0;
            if (!empty($get_event_tickets)) {
                foreach ($get_event_tickets as $val) {
                    $ticket_sales = $ticket_sales + $val['price'];
                }
            }
            $gross_sales = $ticket_sales;
            $viewArr['viewPage'] = "statistics";
            $viewArr['data'] = array('ticket_sales' => $ticket_sales, 'gross_sales' => $gross_sales, 'get_free_tickets' => $get_free_tickets, 'get_paid_tickets' => $get_paid_tickets, 'get_donation_tickets' => $get_donation_tickets);
            $viewArr['get_event_info'] = $get_event_info;
            $set_dropdown_data = $this->statistics_model->set_dropdown_data($event_id);
            $viewArr['set_dropdown_data'] = $set_dropdown_data;
            $viewArr['get_pending_tickets'] = $get_pending_tickets;
            $this->load->view('frontend/layout', $viewArr);
        } else {
            if ($event_id == '') {
                redirect("frontend/home/index");
            }
            $data = $this->statistics_model->get_price_by_id(2, $event_id);
            $exist_status = $this->statistics_model->check_event_id($event_id);
            if ($exist_status == 0) {
                redirect("frontend/home/index");
            }

            // get donation summary
            $type = "event_id";
            $detail = "main_summary";

            $viewArr['main_summary'] = $this->statistics_model->get_donation_summary($event_id, $type, $detail);

            // get sponsors
            $detail = "sponsors";
            $viewArr['sponsor_data'] = $this->statistics_model->get_donation_summary($event_id, $type, $detail);

            $detail = "champion";
            $viewArr['champion_data'] = $this->statistics_model->get_donation_summary($event_id, $type, $detail);

            $get_all_tickets = $this->statistics_model->get_all_tickets($event_id);
            //print_r($get_all_tickets);exit;
            $get_event_info = $this->statistics_model->get_event_info($event_id);
            //print_r($get_event_info);exit;
            $get_event_tickets = $this->statistics_model->get_event_tickets($event_id);
            //$get_donations=$this->organiser_model->get_donations($event_id);
            $get_free_tickets = $get_all_tickets['free'];
            $get_paid_tickets = $get_all_tickets['paid'];
            $get_donation_tickets = $get_all_tickets['donation'];
            $get_pending_tickets = $this->statistics_model->get_pending_tickets($event_id);

            $ticket_sales = 0;
            $donations = 0;
            if (!empty($get_event_tickets)) {
                foreach ($get_event_tickets as $val) {
                    $ticket_sales = $ticket_sales + $val['price'];
                }
            }
            $gross_sales = $ticket_sales;
            $viewArr['viewPage'] = "statistics";
            $viewArr['data'] = array('ticket_sales' => $ticket_sales, 'gross_sales' => $gross_sales, 'get_free_tickets' => $get_free_tickets, 'get_paid_tickets' => $get_paid_tickets, 'get_donation_tickets' => $get_donation_tickets);

            $set_dropdown_data = $this->statistics_model->set_dropdown_data($event_id);
            $viewArr['set_dropdown_data'] = $set_dropdown_data;
            $viewArr['get_pending_tickets'] = $get_pending_tickets;
            $viewArr['get_event_info'] = $get_event_info;
            $this->load->view('frontend/layout', $viewArr);
        }
    }

    function get_subs($event_id, $sub_event_id) {
        $all_events = $this->champion_model->get_all_sub_events($event_id);
        $message = "";
        if ($all_events) {
            foreach ($all_events as $events) {
                if ($events['id'] == $sub_event_id) {
                    $message = "selected";
                } else {
                    $message = "";
                }
                echo "<option value='" . $events['id'] . "'" . $message . ">" . $events['schedule_title'] . "</option>";
            }
            exit;
        } else {
            echo "<option value=''>No events available<option>";
            exit;
        }
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */