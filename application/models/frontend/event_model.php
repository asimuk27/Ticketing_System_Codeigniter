<?php

class Event_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->config->load('dbtables', TRUE);
    }

    public function get_event_categories() {
        $this->db->select('id,category_name');
        $this->db->from($this->config->item('ems_event_category', 'dbtables'));
        $query = $this->db->get();

        if ($query->num_rows()) {
            return $query->result();
        } else {
            return false;
        }
    }

    function get_all_users_count($search_values = NULL) {

        $organizer_id = $this->session->userdata['logged_in'];

        $query = "SELECT *";
        $query .= " FROM " . $this->config->item('ems_events', 'dbtables') . " ee";
        $query .= " INNER JOIN " . $this->config->item('ems_organisers', 'dbtables') . " eo ON eo.id = ee.organiser_id ";
        $query .= " WHERE ee.organiser_id = '" . $organizer_id['id'] . "'";

        if (isset($search_values['e_name']) && ($search_values['e_name'] != "")) {
            $query .= " AND ee.title LIKE '%" . $search_values['e_name'] . "%'";
        }

        if (isset($search_values['e_city']) && ($search_values['e_city'] != "")) {
            $query .= " AND ee.event_location LIKE '%" . $search_values['e_city'] . "%'";
        }

        if (isset($search_values['e_category']) && ($search_values['e_category'] != "")) {
            $query .= " AND ee.event_category=" . $search_values['e_category'] . "";
        }

        if (isset($search_values['event_status']) && ($search_values['event_status'] != "")) {
            $query .= " AND ee.status = " . $search_values['event_status'] . "";
        }

        $res = $this->db->query($query);
        $resArr = $res->result_array();
        return count($resArr);
    }

    function get_all_users($limit, $start, $search_values) {
        $organizer_id = $this->session->userdata['logged_in'];
        $query = "SELECT *,ee.id as event_id,ee.title as event_main_tile,ee.status as event_status";
        $query .= " FROM " . $this->config->item('ems_events', 'dbtables') . " ee";
        $query .= " INNER JOIN " . $this->config->item('ems_organisers', 'dbtables') . " eo ON eo.id = ee.organiser_id ";
        $query .= " WHERE ee.organiser_id = '" . $organizer_id['id'] . "'";

        if (isset($search_values['e_name']) && ($search_values['e_name'] != "")) {
            $query .= " AND ee.title LIKE '%" . $search_values['e_name'] . "%'";
        }

        if (isset($search_values['e_city']) && ($search_values['e_city'] != "")) {
            $query .= " AND ee.event_location LIKE '%" . $search_values['e_city'] . "%'";
        }

        if (isset($search_values['e_category']) && ($search_values['e_category'] != "")) {
            $query .= " AND ee.event_category=" . $search_values['e_category'] . "";
        }

        if (isset($search_values['event_status']) && ($search_values['event_status'] != "")) {
            $query .= " AND ee.status = " . $search_values['event_status'] . "";
        }

        $query .= " ORDER BY ee.id DESC";

        $query .= " LIMIT " . $start . ", " . $limit . "";

        $res = $this->db->query($query);
        $resArr = $res->result_array();
        return $resArr;
    }

    function get_srch_det($search_values) {
        //	$organizer_id = $this->session->userdata['logged_in'];
        $query = "SELECT *,ee.id as event_id,ee.title as event_main_title,ee.status as event_status";
        $query .= " FROM " . $this->config->item('ems_events', 'dbtables') . " ee";
        $query .= " INNER JOIN " . $this->config->item('ems_organisers', 'dbtables') . " eo ON eo.id = ee.organiser_id ";
        //	$query .= " WHERE ee.organiser_id = '".$organizer_id['id']."'";


        $query .= " where  ee.admin_status='1' and ( ee.title LIKE '%" . $search_values . "%'";



        $query .= " or ee.event_location LIKE '%" . $search_values . "%'";



        $query .= " or ee.event_category LIKE '%" . $search_values . "%'";
        $query .= " or ee.event_description LIKE '%" . $search_values . "%'";
        $query .= " or ee.org_description LIKE '%" . $search_values . "%')";
        /// $query .= " or ee.status = ".$search_values."";


        $query .= "  ORDER BY ee.id DESC";

        //	$query .= " LIMIT ".$start.", ".$limit."";

        $res = $this->db->query($query);
        $resArr = $res->result_array();
        return $resArr;
    }

    function get_event_details($id) {
        $query = "SELECT *";
        $query .= " FROM " . $this->config->item('ems_events', 'dbtables');

        $query .= " WHERE id = $id ";
        $res = $this->db->query($query);
        $resArr = $res->result_array();
        return $resArr;
    }

    public function get_sub_event_by_event_id($id) {
        $query = "SELECT *,tickets.id as ticket_id";
        $query .= " FROM " . $this->config->item('ems_sub_events', 'dbtables') . " sub_event";
        $query .= " INNER JOIN " . $this->config->item('ems_sub_event_ticket_master', 'dbtables') . " tickets ON sub_event.id = tickets.sub_event_id WHERE stop_status = 0 AND sub_event.id = $id AND ticket_name != ''";

        $query .= " ORDER BY order_sequence ASC";

        $res = $this->db->query($query);
        $resArr = $res->result_array();

        if (!empty($resArr)) {
            return $resArr;
        } else {
            $data = array();
            return $data;
        }
    }

    // function to check if email exist during registration
    function get_organiser_details($id = NULL) {
        $query = " SELECT organization_id,charity_overview,organization_name,charity_name";
        $query .= " FROM " . $this->config->item('ems_organisers_details', 'dbtables');
        $query .= " WHERE organization_id = ? ";
        $dataBindArr = array($id);
        $res = $this->db->query($query, $dataBindArr);
        $resArr = $res->result();
        if (isset($resArr['0'])) {
            return $resArr['0'];
        } else {
            $resArr = array();
            return $resArr;
        }
    }

    public function get_event_details_by_id($id) {
        $this->db->select('*');
        $this->db->from($this->config->item('ems_events', 'dbtables'));
        $this->db->where('id =', $id);
        $query = $this->db->get();

        if ($query->num_rows()) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function get_sub_event_id_by_event_id($id) {
        $this->db->select('id');
        $this->db->from($this->config->item('ems_sub_events', 'dbtables'));
        $this->db->where('event_id =', $id);
        $query = $this->db->get();

        if ($query->num_rows()) {
            return $query->result();
        } else {
            $data = array();
            return $data;
        }
    }

    public function get_sub_event_details_by_event_id($id) {
        $this->db->select('*');
        $this->db->from($this->config->item('ems_sub_events', 'dbtables'));
        $this->db->where('event_id =', $id);
        $query = $this->db->get();

        if ($query->num_rows()) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function get_sponsor_details_by_event_id($id) {
        $this->db->select('*');
        $this->db->from($this->config->item('ems_sub_event_sponsors', 'dbtables'));
        $this->db->where('event_id =', $id);
        $query = $this->db->get();

        if ($query->num_rows()) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function live_events() {

        $query = "SELECT (GROUP_CONCAT(Distinct(event_id))) event_id FROM " . $this->config->item('ems_popular_events', 'dbtables') . " WHERE event_id != '' Order By position";
        $res = $this->db->query($query);
        $resArr = $res->result_array();


        if ($resArr[0]['event_id'] != "") {
            $ids = $resArr['0']['event_id'];
            $query = "SELECT *,id as event_id, title as event_main_title FROM " . $this->config->item('ems_events', 'dbtables') . " WHERE status != 0 AND admin_status='1' and  id IN ($ids) ORDER BY FIELD(id,$ids);";

            $res = $this->db->query($query);
            $resArr = $res->result_array();

            return $resArr;
        } else {
            return false;
        }
    }

    public function save_main_event_details($data) {
        $result = $this->db->insert($this->config->item('ems_events', 'dbtables'), $data);
        $insert_id = $this->db->insert_id();

        return $insert_id;
    }

    public function save_sub_event_details($data) {
        $result = $this->db->insert($this->config->item('ems_sub_events', 'dbtables'), $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function save_event_sponsors($data) {
        $result = $this->db->insert($this->config->item('ems_sub_event_sponsors', 'dbtables'), $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function save_event_tickets($data) {
        $result = $this->db->insert($this->config->item('ems_sub_event_ticket_master', 'dbtables'), $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function get_all_events_count($search_values = NULL) {
        $query = "SELECT *";
        $query .= " FROM " . $this->config->item('ems_events', 'dbtables') . " ee";
        $query .= " INNER JOIN " . $this->config->item('ems_organisers', 'dbtables') . " eo ON eo.id = ee.organiser_id ";
        $query .= " WHERE (ee.status = 1 || ee.status = 4 ||  ee.status = 5 ) and ee.admin_status='1'";
        if ((!empty($search_values))) {
            $query .= " AND event_category LIKE '%" . $search_values['category_name'] . "%' AND ee.title LIKE '%" . $search_values['event_name'] . "%' AND event_location LIKE '%" . $search_values['event_location'] . "%' ";
        }
/// $query;
        $res = $this->db->query($query);
        $resArr = $res->result_array();
        return count($resArr);
    }

    function get_all_events($limit, $start, $search_values) {

        $query = "SELECT ee.status,ee.id,ee.title,ee.original_event_image,ee.event_location,ee.event_start_date,ee.event_end_date";
        $query .= " FROM " . $this->config->item('ems_events', 'dbtables') . " ee";
        $query .= " INNER JOIN " . $this->config->item('ems_organisers', 'dbtables') . " eo ON eo.id = ee.organiser_id ";
        $query .= " WHERE (ee.status = 1 || ee.status = 4 ||  ee.status = 5 ) AND ee.event_privacy = 0 and ee.admin_status='1' ";

        if ((!empty($search_values))) {
            $query .= " AND event_category LIKE '%" . $search_values['category_name'] . "%' AND ee.title LIKE '%" . $search_values['event_name'] . "%' AND event_location LIKE '%" . $search_values['event_location'] . "%'";
        }

        //	$query .= " ORDER BY ee.created_date DESC";
        $query .= " ORDER BY FIELD(ee.status, 1, 5, 4),ee.id DESC";
        //	$query .= " LIMIT ".$start.", ".$limit."";
        $res = $this->db->query($query);
        $resArr = $res->result_array();

        return $resArr;
    }

    function get_event_category_list() {
        $this->db->select('id,category_name');
        $this->db->from($this->config->item('ems_event_category', 'dbtables'));
        $query = $this->db->get();

        if ($query->num_rows()) {
            return $query->result();
        } else {
            return false;
        }
    }

    function get_ajax_event_names($organiser_id) {
        $query = "SELECT title";
        $query .= " FROM " . $this->config->item('ems_events', 'dbtables');
        $query .= " WHERE organiser_id=" . $organiser_id;

        $res = $this->db->query($query);
        $resArr = $res->result_array();

        return $resArr;
    }

    function get_event_city_names($organiser_id) {
        $query = "SELECT event_location";
        $query .= " FROM " . $this->config->item('ems_events', 'dbtables');
        $query .= " WHERE organiser_id=" . $organiser_id;

        $res = $this->db->query($query);
        $resArr = $res->result_array();

        return $resArr;
    }

    function get_event_details_info($organiser_id) {
        $query = "SELECT *";
        $query .= " FROM " . $this->config->item('ems_events', 'dbtables');
        $query .= " WHERE organiser_id=" . $organiser_id;

        $res = $this->db->query($query);
        $resArr = $res->result_array();

        return $resArr;
    }

    function search_event_details($ename, $ecity, $ecategory, $organiser_id) {
        $query = "SELECT *";
        $query .= " FROM " . $this->config->item('ems_events', 'dbtables');
        $query .= " WHERE organiser_id=" . $organiser_id;

        if ($ename != '') {
            $query .= " AND title LIKE '%" . $ename . "%'";
        }

        if ($ecity != '') {

            $query .= " AND event_location LIKE '%" . $ecity . "%'";
        }

        if ($ecategory != '') {
            $query .= " AND event_category=" . $ecategory . "";
        }


        $res = $this->db->query($query);
        $resArr = $res->result_array();

        return $resArr;
    }

    public function get_sub_event_details($sub_id) {
        $query = "SELECT *";
        $query .= " FROM sub_events";
        $query .= " WHERE id=" . $sub_id;

        $res = $this->db->query($query);
        $resArr = $res->result_array();

        return $resArr;
    }

    public function get_ticket_details($sub_event_id) {
        $query = "SELECT *";
        $query .= " FROM tickets_master";
        $query .= " WHERE sub_event_id=" . $sub_event_id;
        $query .= " ORDER BY order_sequence ASC";

        $res = $this->db->query($query);
        $resArr = $res->result_array();

        return $resArr;
    }

    public function get_book_ticket_details($sub_event_id) {
        $query = "SELECT *";
        $query .= " FROM tickets_master";
        $query .= " WHERE stop_status = 0 AND sub_event_id=" . $sub_event_id;
        $query .= " ORDER BY order_sequence ASC";

        $res = $this->db->query($query);
        $resArr = $res->result_array();

        return $resArr;
    }

    public function get_sub_event_champions($sub_id) {
        $query = "SELECT *";
        $query .= " FROM champions";
        $query .= " WHERE status = 1 AND delete_status = 0 AND sub_event_id=" . $sub_id;

        $res = $this->db->query($query);
        $resArr = $res->result_array();

        return $resArr;
    }

    public function get_sub_event_sponsors($sub_event_id) {
        $query = "SELECT * FROM sub_event_sponsors WHERE sub_event_id=" . $sub_event_id;
        $res = $this->db->query($query);
        $resArr = $res->result_array();
        return $resArr;
    }

    public function validate_url($t_id, $s_eid) {
        $query = "SELECT * FROM tickets_master WHERE id=" . $t_id . " AND sub_event_id=" . $s_eid;
        $res = $this->db->query($query);
        $resArr = $res->result_array();
        return $resArr;
    }

    public function get_champion_title($champ_id) {
        $query = "SELECT *";
        $query .= " FROM champions";
        $query .= " WHERE id=" . $champ_id;

        $res = $this->db->query($query);
        $resArr = $res->result_array();

        return $resArr;
    }

    public function fetch_location($sub_event_id) {
        $query = "SELECT *";
        $query .= " FROM sub_events";
        $query .= " WHERE id=" . $sub_event_id;

        $res = $this->db->query($query);
        $resArr = $res->result_array();

        return $resArr;
    }

    public function get_org_name($sub_id) {
        $query = "SELECT sub_e.id, eo.title";
        $query .= " FROM sub_events sub_e";
        $query .= " INNER JOIN event_master eo ON eo.id = sub_e.event_id";
        $query .= " INNER JOIN organisation_contact org ON org.id = eo.organiser_id";
        $query .= " WHERE sub_e.id=" . $sub_id;

        $res = $this->db->query($query);
        $resArr = $res->result_array();

        return $resArr;
    }

    function get_event_id($sub_eid) {
        $query = "SELECT *";
        $query .= " FROM sub_events";
        $query .= " WHERE id=" . $sub_eid . "";

        $res = $this->db->query($query);
        $resArr = $res->result_array();

        return $resArr;
    }

    public function save_ticket_generation($data) {
        $this->db->insert('ticket_generated', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function save_donar_details($data) {
        $this->db->insert('event_donations', $data);
        return true;
    }

    public function save_payment_summary($data) {
        $this->db->set($data);
        $this->db->insert('payment_history');
    }

    public function get_ajax_user_details($user_id) {
        $query = "SELECT *";
        $query .= " FROM user_master";
        $query .= " WHERE id=" . $user_id;

        $res = $this->db->query($query);
        $resArr = $res->result_array();

        return $resArr;
    }

    public function get_order_history_information($order_id = NULL) {
        $query = "SELECT user_id,email,amount,txn_date,txn_number,first_name,last_name,country,address1,address2,city,payment_method";
        $query .= " FROM payment_history";
        $query .= " WHERE order_id =" . $order_id;

        $res = $this->db->query($query);
        $resArr = $res->result_array();

        if (!empty($resArr)) {
            return $resArr['0'];
        } else {
            $resArr = array();
            return $resArr;
        }
    }

    function event_check_login($username, $password) {
        // Read data using username and password
        $condition = "email = " . "'" . $username . "' AND " . "password = " . "'" . md5($password) . "'";
        $this->db->select('*');
        $this->db->from($this->config->item('ems_users', 'dbtables'));
        $this->db->where($condition);
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    function get_tickets_generated($order_id) {
        $query = "SELECT *";
        $query .= " FROM ticket_generated";
        $query .= " WHERE order_id='" . $order_id . "'";

        $res = $this->db->query($query);
        $resArr = $res->result_array();

        return $resArr;
    }

    function get_tickets_generated_email($order_id) {
        $query = "SELECT *,count(*) as quantity";
        $query .= " FROM ticket_generated";
        $query .= " WHERE order_id='" . $order_id . "'";
        $query .= " Group By ticket_id";

        $res = $this->db->query($query);
        $resArr = $res->result_array();

        return $resArr;
    }

    function get_ticket_price($ticket_id) {
        $query = "SELECT *";
        $query .= " FROM tickets_master";
        $query .= " WHERE id=" . $ticket_id . "";

        $res = $this->db->query($query);
        $resArr = $res->result_array();

        return $resArr;
    }

    function get_ticket_price_from_ids($ticket_ids = []) {
        $ticket_id_flip = array_flip($ticket_ids);

        $query = "SELECT *";
        $query .= " FROM tickets_master";
        $query .= " WHERE id IN (" . implode(",", $ticket_ids) . ")";

        $res = $this->db->query($query);
        $resArr = $res->result_array();
        $resNew = array();
        foreach ($resArr as $data) {
            $resNew[$data['id']] = $data;
        }

        return $resNew;
    }

    function get_event_info_email($event_id) {
        $query = "SELECT 	organiser_id,title,event_location,event_location_latitude,event_location_longitude,event_start_date,	event_start_time";
        $query .= " FROM event_master";
        $query .= " WHERE id=" . $event_id . "";

        $res = $this->db->query($query);
        $resArr = $res->result_array();

        if (!empty($resArr)) {
            return $resArr['0'];
        } else {
            $resArr = array();
            return $resArr;
        }
    }

    function get_organizer_address($id) {
        $query = "SELECT email";
        $query .= " FROM organisation_contact";
        $query .= " WHERE id='" . $id . "'";

        $res = $this->db->query($query);
        $resArr = $res->result_array();


        if (!empty($resArr)) {
            return $resArr['0']['email'];
        } else {
            $resArr = array();
            return $resArr;
        }
    }

    function update_qyts($ticket_ids, $qyt_sold) {
        $query = "SELECT *";
        $query .= " FROM tickets_master";
        $query .= " WHERE id=" . $ticket_ids;

        $res = $this->db->query($query);
        $resArr = $res->result_array();

        $current_quantity_sold = $resArr[0]['quantity_sold'];
        $update_quantity_sold = $qyt_sold + $resArr[0]['quantity_sold'];
        $quantity_available = $resArr[0]['quantity_available'] - $qyt_sold;

        if ($quantity_available <= 0) {
            $out_of_stoct = 1;
        } else {
            $out_of_stoct = 0;
        }

        $query2 = "UPDATE tickets_master";
        $query2 .= " SET quantity_sold=" . $update_quantity_sold . ", quantity_available=" . $quantity_available;

        if ($out_of_stoct == 1) {
            $query2 .= ", out_of_stock=" . $out_of_stoct;
        }

        $query2 .= " WHERE id=" . $ticket_ids;
        $res2 = $this->db->query($query2);
        return $res2;
    }

    function get_ticket_ids($order_id) {
        $query = "SELECT DISTINCT ticket_id";
        $query .= " FROM ticket_generated";
        $query .= " WHERE order_id='" . $order_id . "'";

        $res = $this->db->query($query);
        $resArr = $res->result_array();

        return $resArr;
    }

    function calculate_qyts($ticket_id, $order_no) {
        $query = "SELECT COUNT(ticket_id) as qyts_sold";
        $query .= " FROM ticket_generated";
        $query .= " WHERE order_id='" . $order_no . "' AND ticket_id=" . $ticket_id;

        $res = $this->db->query($query);
        $resArr = $res->result_array();

        return $resArr;
    }

    function get_available_quantity($ticket_id, $selected_qyt) {
        $query = "SELECT *";
        $query .= " FROM tickets_master";
        $query .= " WHERE id=" . $ticket_id;
        $res = $this->db->query($query);
        $resArr = $res->result_array();

        $available_qyt = $resArr[0]['quantity_available'] - $selected_qyt;

        if ($available_qyt < 0) {
            return $resArr[0]['quantity_available'];
        } else {
            return "success";
        }
    }

    // function to check if email exist during registration
    function get_organiser_receipt($id = NULL) {
        $query = " SELECT receipt_text";
        $query .= " FROM " . $this->config->item('ems_organisers_finance', 'dbtables');
        $query .= " WHERE organization_id = ? ";
        $dataBindArr = array($id);
        $res = $this->db->query($query, $dataBindArr);
        $resArr = $res->result();
        if (isset($resArr['0'])) {
            return $resArr['0']->receipt_text;
        } else {
            $resArr = array();
            return $resArr;
        }
    }

    public function update_main_event_details($data, $id) {
        $this->db->where('id', $id);
        $this->db->update($this->config->item('ems_events', 'dbtables'), $data);
        return true;
    }

    function update_stop_status($status, $ticket_id) {
        $query = "UPDATE tickets_master";
        $query .= " SET stop_status=" . $status . "";
        $query .= " WHERE id=" . $ticket_id . "";

        $res = $this->db->query($query);
        return true;
    }

    public function update_sub_event_details($data) {

        if (empty($data['id'])) {
            unset($data['id']);
            $result = $this->db->insert($this->config->item('ems_sub_events', 'dbtables'), $data);

            $insert_id = $this->db->insert_id();
            return $insert_id;
        } else {
            // echo "<pre>";print_r($data);
            $this->db->where('id', $data['id']);
            $this->db->update($this->config->item('ems_sub_events', 'dbtables'), $data);

            return 0;
        }
    }

    public function update_and_save_event_tickets($data) {

        if ($data['id'] != '') {
            $this->db->where('id', $data['id']);
            $this->db->update($this->config->item('ems_sub_event_ticket_master', 'dbtables'), $data);
            // echo "<br><br>".$this->db->last_query();
            return true;
        } else {
            unset($data['id']);
            $result = $this->db->insert($this->config->item('ems_sub_event_ticket_master', 'dbtables'), $data);

            $insert_id = $this->db->insert_id();
            return $insert_id;
        }
    }

    function delete_ticket_ajax($ticket_id) {
        $this->db->where('id', $ticket_id);
        $this->db->delete('tickets_master');
        return true;
    }

    function validate_event_owner($event_id, $organizer_id) {
        $query = "SELECT id FROM event_master";
        $query .= " WHERE id='" . $event_id . "' AND organiser_id =" . $organizer_id;

        $res = $this->db->query($query);
        $resArr = $res->result_array();

        if (isset($resArr['0'])) {
            return $resArr['0']['id'];
        } else {
            $resArr = array();
            return $resArr;
        }
    }

    function save_sponser_image($link, $img_name, $sub_event_id, $event_id) {
        $data = array();
        $data['hyperlink'] = $link;
        $data['event_id'] = $event_id;
        $data['sub_event_id'] = $sub_event_id;
        $data['sponsor_image'] = $img_name;

        $this->db->insert($this->config->item('ems_sub_event_sponsors', 'dbtables'), $data);
        return true;
    }

    function delete_sponsor($sponsor_image) {
        $this->db->where('sponsor_image', $sponsor_image);
        if ($this->db->delete($this->config->item('ems_sub_event_sponsors', 'dbtables'))) {
            return 1;
        } else {
            return 0;
        }
    }

    function cron_job_for_closed_event_check() {
        $todays_date = date("Y-m-d");
        $query = "UPDATE " . $this->config->item('ems_events', 'dbtables') . " SET status = 4 WHERE event_end_date < '" . $todays_date . "'";

        $res = $this->db->query($query);

        return $res;
    }

    function set_event_as_active($id) {
        $data['status'] = "1";

        $this->db->where('id', $id);
        $queryResult = $this->db->update($this->config->item('ems_events', 'dbtables'), $data);

        return $queryResult;
    }

    function set_event_as_suspended($id) {
        $data['status'] = "3";
        $this->db->where('id', $id);
        $queryResult = $this->db->update($this->config->item('ems_events', 'dbtables'), $data);

        return $queryResult;
    }

    function set_event_event_as_cancelled($id) {
        $data['status'] = "5";
        $this->db->where('id', $id);
        $queryResult = $this->db->update($this->config->item('ems_events', 'dbtables'), $data);

        return $queryResult;
    }

    function check_suspend_status($id) {
        $query = "SELECT status FROM event_master";
        $query .= " WHERE id='" . $id . "' AND status = 3";

        $res = $this->db->query($query);
        $resArr = $res->result_array();

        if (isset($resArr['0'])) {
            return true;
        } else {
            return false;
        }
    }

    public function save_sponsor_requests($data) {
        $this->db->set($data);
        $res = $this->db->insert('request_event_sponsor');
        return $res;
    }

    function get_sponsor_request_by_organization_id_count($search_values) {
        $organizer_id = $this->session->userdata['logged_in'];

        $query = "SELECT *";
        $query .= " FROM request_event_sponsor ee";
        $query .= " WHERE ee.organiser_id = '" . $organizer_id['id'] . "'";

        if (isset($search_values['event_list']) && ($search_values['event_list'] != "")) {
            $query .= " AND ee.event_id = " . $search_values['event_list'];
        }

        if (isset($search_values['search_date']) && ($search_values['search_date'] != "")) {
            $t_date = date("Y-m-d", strtotime($search_values['search_date']));
            $query .= " AND ee.created_date LIKE '" . $t_date . "%'";
        }

        if (isset($search_values['search_text']) && ($search_values['search_text'] != "")) {
            $query .= " AND (ee.first_name LIKE '%" . $search_values['search_text'] . "%' OR ee.last_name LIKE '%" . $search_values['search_text'] . "%' OR ee.organisation_name LIKE '%" . $search_values['search_text'] . "%')";
        }


        $res = $this->db->query($query);
        $resArr = $res->result_array();
        return count($resArr);
    }

    function get_sponsor_request_by_organization_id_data($limit, $start, $search_values) {
        $organizer_id = $this->session->userdata['logged_in'];

        $query = "SELECT *";
        $query .= " FROM request_event_sponsor ee";
        $query .= " WHERE ee.organiser_id = '" . $organizer_id['id'] . "'";

        if (isset($search_values['event_list']) && ($search_values['event_list'] != "")) {
            $query .= " AND ee.event_id = " . $search_values['event_list'];
        }

        if (isset($search_values['search_date']) && ($search_values['search_date'] != "")) {
            $t_date = date("Y-m-d", strtotime($search_values['search_date']));
            $query .= " AND ee.created_date LIKE '" . $t_date . "%'";
        }

        if (isset($search_values['search_text']) && ($search_values['search_text'] != "")) {
            $query .= " AND (ee.first_name LIKE '%" . $search_values['search_text'] . "%' OR ee.last_name LIKE '%" . $search_values['search_text'] . "%' OR ee.organisation_name LIKE '%" . $search_values['search_text'] . "%')";
        }

        $query .= " ORDER BY id DESC";
        $query .= " LIMIT " . $start . ", " . $limit . "";

        $res = $this->db->query($query);
        $resArr = $res->result_array();

        if (!empty($resArr)) {
            return $resArr;
        } else {
            $resArr = array();
            return $resArr;
        }
    }

    function delete_sponsor_request($id) {
        $this->db->where('id', $id);
        $this->db->delete('request_event_sponsor');
        return true;
    }

    function get_sponsor_request_events() {
        $organizer_id = $this->session->userdata['logged_in'];

        $query = "SELECT event_id,event_name";
        $query .= " FROM request_event_sponsor ee";
        $query .= " WHERE ee.organiser_id = '" . $organizer_id['id'] . "'";
        $query .= " GROUP BY event_id";
        $res = $this->db->query($query);
        $resArr = $res->result_array();

        if (!empty($resArr)) {
            return $resArr;
        } else {
            $resArr = array();
            return $resArr;
        }
    }

    function get_organiser_email($id = NULL) {
        $query = " SELECT email";
        $query .= " FROM " . $this->config->item('ems_organisers', 'dbtables');
        $query .= " WHERE id = $id";
        $res = $this->db->query($query);
        $resArr = $res->result();

        if (!empty($resArr)) {
            return $resArr['0']->email;
        } else {
            $resArr = array();
            return $resArr;
        }
    }

    // 3 dec
    function create_sequence_number($event_id, $sub_event_id, $ticket_id) {
        $query = "SELECT count(*) as result_count FROM ticket_generated WHERE ticket_sequence_no != 0 AND payment_processed = 1 AND ticket_id = " . $ticket_id . " AND event_id = " . $event_id . " AND sub_event_id = " . $sub_event_id;
        $ex = $this->db->query($query);
        $ex2 = $ex->result_array();

        return $ex2;
    }

    function update_ticket_after_payment_process($data) {
        $this->db->where('id', $data['id']);
        $queryResult = $this->db->update("ticket_generated", $data);
        return $queryResult;
    }

    function update_ticket_generated_on_order_success($order_id) {
        /* $data = array();
          $data['payment_processed'] = 1;
          $this->db->where('order_id',$order_id);
          $this->db->update($this->config->item("ticket_generated",$data);
         */
        $query = "UPDATE ticket_generated";
        $query .= " SET payment_processed = 1 WHERE order_id = $order_id";
        $res = $this->db->query($query);
        return $res;
    }

    function get_sub_event_sponsers($sub_event_id) {
        $query = " SELECT *";
        $query .= " FROM " . $this->config->item('ems_sub_event_sponsors', 'dbtables');
        $query .= " WHERE sub_event_id = $sub_event_id";
        $res = $this->db->query($query);
        $resArr = $res->result_array();

        if (!empty($resArr)) {
            return $resArr;
        } else {
            $resArr = array();
            return $resArr;
        }
    }

    public function event_detail_sub_event_by_event_id($id) {
        $query = "SELECT *,tickets.id as ticket_id";
        $query .= " FROM " . $this->config->item('ems_sub_events', 'dbtables') . " sub_event";
        $query .= " INNER JOIN " . $this->config->item('ems_sub_event_ticket_master', 'dbtables') . " tickets ON sub_event.id = tickets.sub_event_id WHERE stop_status = 0 AND sub_event.id = $id AND ticket_name != ''";

        $query .= " ORDER BY order_sequence ASC";

        $res = $this->db->query($query);
        $resArr = $res->result_array();

        if (!empty($resArr)) {
            return $resArr;
        } else {
            $query = "SELECT *";
            $query .= " FROM " . $this->config->item('ems_sub_events', 'dbtables') . " sub_event";
            $query .= " WHERE sub_event.id = $id";

            $res = $this->db->query($query);
            $resArr = $res->result_array();
            $resArr[0]['ticket_status'] = 0;
            return $resArr;
        }
    }

    public function get_event_champion_status($event_id) {
        $query = "SELECT *";
        $query .= " FROM " . $this->config->item('ems_sub_events', 'dbtables') . " sub_event";
        $query .= " WHERE event_id = $event_id AND is_support_allowed = 1";

        $res = $this->db->query($query);
        $resArr = $res->result_array();

        if (!empty($resArr)) {
            return count($resArr);
        } else {
            return 0;
        }
    }

    function get_ticket_price_per_order($order_id) {
        $query = "SELECT sum(price) as total_amount";
        $query .= " FROM ticket_generated";
        $query .= " WHERE order_id='" . $order_id . "'";

        $res = $this->db->query($query);
        $resArr = $res->result_array();

        if (!empty($resArr)) {
            return $resArr[0]['total_amount'];
        } else {
            return 0;
        }
    }

    function get_donation_per_order($order_id) {
        $query = "SELECT title,donation_amount,champion.event_id,champion.sub_event_id,champion.display_name";
        $query .= " FROM event_donations as donation";
        $query .= " INNER JOIN champions as champion ON donation.champion_page_id = champion.id";
        $query .= " WHERE order_id='" . $order_id . "'";

        $res = $this->db->query($query);
        $resArr = $res->result_array();

        if (!empty($resArr)) {
            return $resArr;
        } else {
            return array();
        }
    }

    function get_donation_amount_of_order($order_id) {
        $query = "SELECT sum(donation_amount) as total_amount";
        $query .= " FROM event_donations as donation";
        $query .= " INNER JOIN champions as champion ON donation.champion_page_id = champion.id";
        $query .= " WHERE order_id='" . $order_id . "'";
        $res = $this->db->query($query);
        $resArr = $res->result_array();
        if (!empty($resArr)) {
            return $resArr['0']['total_amount'];
        } else {
            return 0;
        }
    }

}

?>