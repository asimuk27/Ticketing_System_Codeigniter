<?php

class Ticket_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->config->load('dbtables', TRUE);
    }

    function get_ticket_booking_count($search_values) {
        $organizer_id = $this->session->userdata['logged_in'];
        $query = "SELECT tg.id, tg.order_id, tg.ticket_name, tg.price, tg.order_id, em.title, schedule_title,tg.qyt, ph.txn_number, ph.payment_for";
        $query .= " FROM ticket_generated as tg ";
        $query .= " INNER JOIN " . $this->config->item('ems_events', 'dbtables') . " as em ON em.id = tg.event_id";
        $query .= " INNER JOIN sub_events as se ON se.id = tg.sub_event_id";
        $query .= " INNER JOIN payment_history as ph ON ph.order_id = tg.order_id";
        $query .= " WHERE ph.txn_number != '' AND em.organiser_id = '" . $organizer_id['id'] . "'";

        if (isset($search_values['eid']) && !empty($search_values['eid'])) {
            $query .=" AND em.id=" . $search_values['eid'];
        }
        if (isset($search_values['sub_eid']) && !empty($search_values['sub_eid'])) {
            $query .=" AND se.id=" . $search_values['sub_eid'];
        }

        if (isset($search_values['search_by_order_id']) && !empty($search_values['search_by_order_id'])) {
            $query .=" AND (tg.id ='" . $search_values['search_by_order_id'] . "' OR tg.order_id LIKE '" . $search_values['search_by_order_id'] . "%')";
        }

        if (isset($search_values['search_by_email']) && !empty($search_values['search_by_email'])) {
            $query .=" AND (ph.email LIKE '%" . $search_values['search_by_email'] . "%' OR ph.first_name LIKE '%" . $search_values['search_by_email'] . "%')";
        }



        $res = $this->db->query($query);
        $resArr = $res->result_array();

        if (!empty($resArr)) {
            return count($resArr);
        } else {
            return false;
        }
    }

    function get_ticket_booking_details($limit, $start, $search_values) {
        //print_r($search_values);exit;
        $organizer_id = $this->session->userdata['logged_in'];
		$query = "SELECT tg.id, tg.order_id, tg.ticket_name, tg.price, tg.order_id, em.title, schedule_title,tg.qyt, ph.txn_number, ph.payment_for,em.status,tg.is_deleted,ticket_scan_status, tg.order_id, count(*) as quantity";
        $query .= " FROM ticket_generated as tg ";
        $query .= " INNER JOIN " . $this->config->item('ems_events', 'dbtables') . " as em ON em.id = tg.event_id";
        $query .= " INNER JOIN sub_events as se ON se.id = tg.sub_event_id";
        $query .= " INNER JOIN payment_history as ph ON ph.order_id = tg.order_id";
		$query .= " WHERE ph.txn_number != '' AND em.organiser_id = '" . $organizer_id['id'] . "' GROUP BY tg.ticket_id, tg.order_id";


        if (isset($search_values['eid']) && !empty($search_values['eid'])) {
            $query .=" AND em.id=" . $search_values['eid'];
        }
        if (isset($search_values['sub_eid']) && !empty($search_values['sub_eid'])) {
            $query .=" AND se.id=" . $search_values['sub_eid'];
        }
        if (isset($search_values['search_by_order_id']) && !empty($search_values['search_by_order_id'])) {
            //	$query .=" AND tg.order_id LIKE '%".$search_values['search_by_order_id']."%'";
            $query .=" AND (tg.id = '" . $search_values['search_by_order_id'] . "' OR tg.order_id LIKE '" . $search_values['search_by_order_id'] . "%')";
        }

        if (isset($search_values['search_by_email']) && !empty($search_values['search_by_email'])) {
            $query .=" AND (ph.email LIKE '%" . $search_values['search_by_email'] . "%' OR ph.first_name LIKE '%" . $search_values['search_by_email'] . "%')";
        }


        $query .= " ORDER BY tg.order_id DESC,tg.id ASC";
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

    function get_single_ticket($id) {
        $query = "SELECT tg.id, tg.order_id, tg.event_id, tg.sub_event_id, tg.ticket_name, tg.ticket_pdf,tg.price,tg.qyt,tg.ticket_id,tg.user_id,tg.login_type,tg.qr_code_image, tg.qr_data, tg.ticket_sequence_no, em.title as main_event_title, od.charity_name,tg.is_deleted";
        $query .= " FROM ticket_generated as tg";
        $query .= " INNER JOIN " . $this->config->item('ems_events', 'dbtables') . " as em ON em.id = tg.event_id";
        $query .= " INNER JOIN organization_details as od ON od.organization_id = em.organiser_id";
        $query .= " WHERE tg.id = " . $id;

        $res = $this->db->query($query);
        $resArr = $res->result_array();

        if (!empty($resArr)) {
            return $resArr;
        } else {
            return false;
        }
    }

    function get_single_ticket_user($id) {
        $query = "SELECT *";
        $query .= " FROM ticket_generated";
        $query .= " WHERE id = " . $id;

        $res = $this->db->query($query);
        $resArr = $res->result_array();


        if (!empty($resArr)) {
            return $resArr;
        } else {
            return false;
        }
    }

    //get_ticket_booking_count_user

    function get_user_ticket_booking_details($limit, $start, $search_values) {
        //print_r($search_values);exit;
        $user_id = $this->session->userdata['logged_in'];
        $query = "SELECT tg.id, tg.order_id, tg.ticket_name, tg.price, tg.order_id, em.title, schedule_title,tg.qyt, ph.txn_number, ph.payment_for,em.status,tg.is_deleted,  tg.order_id, count(*) as qunatity";
        $query .= " FROM ticket_generated as tg ";
        $query .= " INNER JOIN " . $this->config->item('ems_events', 'dbtables') . " as em ON em.id = tg.event_id";
        $query .= " INNER JOIN sub_events as se ON se.id = tg.sub_event_id";
        $query .= " INNER JOIN payment_history as ph ON ph.order_id = tg.order_id";
        $query .= " WHERE ph.txn_number != '' AND tg.user_id = '" . $user_id['id'] . "' GROUP BY tg.order_id, tg.ticket_id";


        if (isset($search_values['eid']) && !empty($search_values['eid'])) {
            $query .=" AND em.id=" . $search_values['eid'];
        }
        if (isset($search_values['sub_eid']) && !empty($search_values['sub_eid'])) {
            $query .=" AND se.id=" . $search_values['sub_eid'];
        }
        if (isset($search_values['search_by_order_id']) && !empty($search_values['search_by_order_id'])) {

            $query .=" AND tg.id =" . $search_values['search_by_order_id'] . " OR tg.order_id LIKE '" . $search_values['search_by_order_id'] . "%'";
        }

        $query .= " ORDER BY tg.order_id DESC";
        $query .= " LIMIT " . $start . ", " . $limit . "";

        $res = $this->db->query($query);
        $resArr = $res->result_array();


        if (!empty($resArr)) {
            return $resArr;
        } else {
            return false;
        }
    }

    function get_user_ticket_booking_count($search_values) {
        $user_id = $this->session->userdata['logged_in'];
        $query = "SELECT tg.id, tg.order_id, tg.ticket_name, tg.price, tg.order_id, em.title, schedule_title,tg.qyt, ph.txn_number, ph.payment_for";
        $query .= " FROM ticket_generated as tg ";
        $query .= " INNER JOIN " . $this->config->item('ems_events', 'dbtables') . " as em ON em.id = tg.event_id";
        $query .= " INNER JOIN sub_events as se ON se.id = tg.sub_event_id";
        $query .= " INNER JOIN payment_history as ph ON ph.order_id = tg.order_id";
        $query .= " WHERE ph.txn_number != '' AND tg.user_id = '" . $user_id['id'] . "'";

        if (isset($search_values['eid']) && !empty($search_values['eid'])) {
            $query .=" AND em.id=" . $search_values['eid'];
        }
        if (isset($search_values['sub_eid']) && !empty($search_values['sub_eid'])) {
            $query .=" AND se.id=" . $search_values['sub_eid'];
        }
        if (isset($search_values['search_by_order_id']) && !empty($search_values['search_by_order_id'])) {

            $query .=" AND tg.id =" . $search_values['search_by_order_id'] . " OR tg.order_id LIKE '" . $search_values['search_by_order_id'] . "%'";
        }



        $res = $this->db->query($query);
        $resArr = $res->result_array();

        if (!empty($resArr)) {
            return count($resArr);
        } else {
            return false;
        }
    }

    function get_payemnt_details_for_pdf($order_id) {
        $query = "SELECT *";
        $query .= " FROM payment_history";
        $query .= " WHERE order_id=" . $order_id;


        $res = $this->db->query($query);
        $resArr = $res->result_array();

        if (!empty($resArr)) {
            return $resArr;
        } else {
            return false;
        }
    }

    public function csv_download($search_values = null) {
        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        $delimiter = ",";
        $newline = "\r\n";
        $filename = "ticket_reports.csv";
        $organizer_id = $this->session->userdata['logged_in'];

        $organizer_id = $this->session->userdata['logged_in'];
        $query = "SELECT tg.id as TicketId,tg.ticket_sequence_no as TicketSequenceNumber, tg.order_id as OrderId, tg.ticket_name as TicketName, tg.price as AmountIn$, em.title as EventName, schedule_title as SubeventName,eorg.charity_name as CharityName,tg.qyt as Quantity, ph.txn_number as PaymentOrderId, ph.email as BuyersEmail, ph.first_name as BuyersName, ph.created_date as PurchaseDate, ph.city as City, ph.country as Country, ph.postal_code as PostalCode, ph.address1 as Street, ph.address2 as Suburb, ph.payment_method as PaymentMethod,tg.payment_processed as PaymentStatus,tg.is_deleted as IsDeleted";
        $query .= " FROM ticket_generated as tg ";
        $query .= " INNER JOIN " . $this->config->item('ems_events', 'dbtables') . " as em ON em.id = tg.event_id";
        $query .= " INNER JOIN sub_events as se ON se.id = tg.sub_event_id";
        $query .= " INNER JOIN payment_history as ph ON ph.order_id = tg.order_id";
        $query .= " INNER JOIN " . $this->config->item('ems_organisers_details', 'dbtables') . " eorg ON eorg.organization_id = em.organiser_id";
        $query .= " WHERE ph.txn_number != '' AND em.organiser_id = '" . $organizer_id['id'] . "'";

        if (isset($search_values['eid']) && !empty($search_values['eid'])) {
            $query .=" AND em.id=" . $search_values['eid'];
        }
        if (isset($search_values['sub_eid']) && !empty($search_values['sub_eid'])) {
            $query .=" AND se.id=" . $search_values['sub_eid'];
        }
        if (isset($search_values['search_by_order_id']) && !empty($search_values['search_by_order_id'])) {
            $query .=" AND (tg.id = '" . $search_values['search_by_order_id'] . "' OR tg.order_id LIKE '" . $search_values['search_by_order_id'] . "%')";
        }

        if (isset($search_values['search_by_email']) && !empty($search_values['search_by_email'])) {
            $query .=" AND (ph.email LIKE '%" . $search_values['search_by_email'] . "%' OR ph.first_name LIKE '%" . $search_values['search_by_email'] . "%')";
        }

        $query .= " ORDER BY tg.order_id DESC";

        $res = $this->db->query($query);
        $resArr = $res->result_array();

        if (empty($resArr)) {
            return false;
        } else {
            $data = $this->dbutil->csv_from_result($res, $delimiter, $newline);
            force_download($filename, $data);
        }
    }

    function delete_ajax_ticket($id) {
        $data = array('is_deleted' => '1');
        $this->db->where('id', $id);
        $this->db->update("ticket_generated", $data);

        if ($id) {
            $query = "SELECT tm.id as ticket_id, quantity_sold, quantity_available";
            $query .= " FROM ticket_generated as tg";
            $query .= " INNER JOIN tickets_master as tm ON tm.id = tg.ticket_id";
            $query .= " WHERE tg.id=" . $id;

            $res = $this->db->query($query);
            $resArr = $res->result_array();

            $ticket_id = $resArr[0]['ticket_id'];
            $quantity_sold = $resArr[0]['quantity_sold'] - 1;
            $quantity_available = $resArr[0]['quantity_available'] + 1;

            if ($quantity_sold < 0) {
                $quantity_sold = 0;
            }

            $data = array('quantity_sold' => $quantity_sold, 'quantity_available' => $quantity_available);
            $this->db->where('id', $ticket_id);
            $this->db->update("tickets_master", $data);
        }

        return true;
    }

    function verify_ticket($id) {
        $query = "SELECT *";
        $query .= " FROM ticket_generated";
        $query .= " WHERE id=" . $id;
        $res = $this->db->query($query);
        $resArr = $res->result_array();
        if (!empty($resArr)) {
            return true;
        } else {
            return false;
        }
    }

    function verify_details($id, $org_id) {
        $query = "SELECT tg.id";
        $query .= " FROM ticket_generated as tg";
        $query .= " INNER JOIN " . $this->config->item('ems_events', 'dbtables') . " as em ON em.id = tg.event_id";
        $query .= " WHERE tg.id=" . $id . " AND em.organiser_id=" . $org_id;

        $res = $this->db->query($query);
        $resArr = $res->result_array();

        if (!empty($resArr)) {
            return true;
        } else {
            return false;
        }
    }

    function get_ticket_scan_details($id) {
        $query = "SELECT seu.email,date(ts.upload_date) AS upload_date,time(ts.upload_date) AS upload_time,date(ts.scanned_date) AS date,time(ts.scanned_date) AS time,CONCAT(um.first_name,' ',um.last_name) AS name";

        $query .= " FROM ticket_scan_history as ts";
        $query .= " INNER JOIN sub_event_ushers AS seu ON ts.usher_id = seu.user_id";
        $query .= " INNER JOIN user_master AS um ON ts.usher_id = um.id";
        $query .= " WHERE ticket_generated_id='" . $id . "'";
        $res = $this->db->query($query);
        $resArr = $res->result_array();

        if (!empty($resArr)) {
            return $resArr;
        } else {
            return array();
        }
    }

    // is ticket assign to user id
    function check_valid_ticket_user($user_id, $ticket_id) {
        $query = "SELECT id";
        $query .= " FROM ticket_generated";
        $query .= " WHERE user_id = '" . $user_id . "' AND id = '" . $ticket_id . "'";

        $res = $this->db->query($query);
        $resArr = $res->result_array();


        if (!empty($resArr)) {
            return $resArr;
        } else {
            return array();
            ;
        }
    }

    // check if organiser is valid for a tikcet
    function check_valid_organiser_ticket($ticket_id) {
        $query = "SELECT oc.id";
        $query .= " FROM ticket_generated as tg";
        $query .= " INNER JOIN event_master AS em ON tg.event_id = em.id";
        $query .= " INNER JOIN organisation_contact AS oc ON oc.id = em.organiser_id";
        $query .= " WHERE tg.id = '" . $ticket_id . "'";

        $res = $this->db->query($query);
        $resArr = $res->result_array();

        if (!empty($resArr)) {
            return $resArr['0']['id'];
        } else {
            return array();
            ;
        }
    }

}

?>