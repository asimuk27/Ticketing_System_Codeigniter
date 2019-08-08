<?php

class Ticket_report_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->config->load('dbtables', TRUE);
    }

    function get_ticket_report_count($search_values = NULL) {
        $query = "SELECT tg.id, tg.order_id, count(*) as quantity";
        $query .= " FROM ticket_generated as tg ";
        $query .= " INNER JOIN " . $this->config->item('ems_events', 'dbtables') . " as em ON em.id = tg.event_id";
        $query .= " INNER JOIN sub_events as se ON se.id = tg.sub_event_id";
        $query .= " INNER JOIN payment_history as ph ON ph.order_id = tg.order_id";
        $query .= " INNER JOIN organization_details as od ON em.organiser_id = od.organization_id";

        $query .= " WHERE ph.txn_number != '' GROUP BY tg.ticket_id";

        if ((!empty($search_values['searchby_org_id']))) {
            $query .= " AND od.organization_id =" . $search_values['searchby_org_id'] . "";
        }

        if ((!empty($search_values['searchby_event_id']))) {
            $query .= " AND em.id =" . $search_values['searchby_event_id'] . "";
        }

        if ((!empty($search_values['searchby_sub_event_id']))) {
            $query .= " AND se.id =" . $search_values['searchby_sub_event_id'] . "";
        }

        /* if((!empty($search_values['from_date'])) && (!empty($search_values['to_date'])) ){
          $query .= " AND (ph.created_date BETWEEN ".$search_values['from_date']." and ".$search_values['from_date'].")";
          } */

        if ((!empty($search_values['from_date'])) && (!empty($search_values['to_date']))) {
            $fromdate = new DateTime($search_values['from_date']);
            $todate = new DateTime($search_values['to_date']);
            $from = $fromdate->format('Y-m-d H:i:s');
            $to = $todate->format('Y-m-d H:i:s');
            $query .= " AND (ph.created_date BETWEEN '" . $from . "' and '" . $to . "')";
        } else if ((!empty($search_values['from_date']))) {
            $fromdate = new DateTime($search_values['from_date']);
            //	$todate = new DateTime(date("Y-m-d"));
            $from = $fromdate->format('Y-m-d H:i:s');
            //	$to=$todate->format('Y-m-d H:i:s');
            $query .= " AND (ph.created_date >= '" . $from . "')";
        } else if ((!empty($search_values['to_date']))) {
            $todate = new DateTime($search_values['to_date']);
            $to = $todate->format('Y-m-d H:i:s');
            $query .= " AND (ph.created_date <='" . $to . "')";
        }

        if ((!empty($search_values['payment_type']))) {
            $query .= " AND ph.payment_method LIKE '%" . $search_values['payment_type'] . "%'";
        }

        if ((!empty($search_values['user_email']))) {
            $query .= " AND ph.email LIKE '%" . $search_values['user_email'] . "%'";
        }

        $res = $this->db->query($query);
        $resArr = $res->result_array();

        if (!empty($resArr)) {
            return count($resArr);
        } else {
            return false;
        }
    }

    function get_ticket_records($limit = NULL, $start = NULL, $search_values = NULL) {
		$query  = "SELECT tg.id, od.charity_name, em.title, se.schedule_title, tg.price, tg.ticket_name,ph.email, tg.order_id, count(*) as quantity";
        $query .= " FROM ticket_generated as tg ";
        $query .= " INNER JOIN " . $this->config->item('ems_events', 'dbtables') . " as em ON em.id = tg.event_id";
        $query .= " INNER JOIN sub_events as se ON se.id = tg.sub_event_id";
        $query .= " INNER JOIN payment_history as ph ON ph.order_id = tg.order_id";
        $query .= " INNER JOIN organization_details as od ON em.organiser_id = od.organization_id";
		$query .= " WHERE ph.txn_number != '' GROUP BY tg.ticket_id, tg.order_id";

        if ((!empty($search_values['searchby_org_id']))) {
            $query .= " AND od.organization_id =" . $search_values['searchby_org_id'] . "";
        }

        if ((!empty($search_values['searchby_event_id']))) {
            $query .= " AND em.id =" . $search_values['searchby_event_id'] . "";
        }

        if ((!empty($search_values['searchby_sub_event_id']))) {
            $query .= " AND se.id =" . $search_values['searchby_sub_event_id'] . "";
        }

        /* if((!empty($search_values['from_date'])) && (!empty($search_values['to_date'])) ){
          $query .= " AND (ph.created_date BETWEEN ".$search_values['from_date']." and ".$search_values['from_date'].")";
          } */

        if ((!empty($search_values['user_email']))) {
            $query .= " AND ph.email LIKE '%" . $search_values['user_email'] . "%'";
        }

        if ((!empty($search_values['from_date'])) && (!empty($search_values['to_date']))) {
            $fromdate = new DateTime($search_values['from_date']);
            $todate = new DateTime($search_values['to_date']);
            $from = $fromdate->format('Y-m-d H:i:s');
            $to = $todate->format('Y-m-d H:i:s');
            $query .= " AND (ph.created_date BETWEEN '" . $from . "' and '" . $to . "')";
        } else if ((!empty($search_values['from_date']))) {
            $fromdate = new DateTime($search_values['from_date']);
            //	$todate = new DateTime(date("Y-m-d"));
            $from = $fromdate->format('Y-m-d H:i:s');
            //	$to=$todate->format('Y-m-d H:i:s');
            $query .= " AND (ph.created_date >= '" . $from . "')";
        } else if ((!empty($search_values['to_date']))) {
            $todate = new DateTime($search_values['to_date']);
            $to = $todate->format('Y-m-d H:i:s');
            $query .= " AND (ph.created_date <='" . $to . "')";
        }

        if ((!empty($search_values['payment_type']))) {
            $query .= " AND ph.payment_method LIKE '%" . $search_values['payment_type'] . "%'";
        }

        $query .= " ORDER BY tg.id DESC";
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

    public function get_all_organisers() {
        $query = "SELECT organization_id, charity_name";
        $query .= " FROM " . $this->config->item('ems_organisers_details', 'dbtables') . " as od";
        $query .= " INNER JOIN organisation_contact as oc ON oc.id=od.organization_id";
        $query .= " WHERE oc.status = 1";

        $res = $this->db->query($query);
        $resArr = $res->result_array();
        return $resArr;
    }

    public function get_charity_events($charity_id) {
        $query = "SELECT id, title";
        $query .= " FROM " . $this->config->item('ems_events', 'dbtables');
        $query .= " WHERE organiser_id=" . $charity_id;
        $res = $this->db->query($query);

        $resArr = $res->result_array();

        return $resArr;
    }

    public function get_sub_events($event_id) {
        $query = "SELECT id, schedule_title";
        $query .= " FROM " . $this->config->item('ems_sub_events', 'dbtables');
        $query .= " WHERE event_id=" . $event_id;
        $res = $this->db->query($query);

        $resArr = $res->result_array();

        return $resArr;
    }

    public function csv_download($search_values = null) {
        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        $delimiter = ",";
        $newline = "\r\n";
        $filename = "ticket_reports.csv";

        $query = "SELECT tg.id as TicketId,tg.ticket_sequence_no as TicketSequenceNumber, tg.order_id as OrderId, tg.ticket_name as TicketName, tg.price as AmountIn$, em.title as EventName, schedule_title as SubeventName,eorg.charity_name as CharityName,tg.qyt as Quantity, ph.txn_number as PaymentOrderId, ph.email as BuyersEmail, ph.first_name as BuyersName, ph.created_date as PurchaseDate, ph.city as City, ph.country as Country, ph.postal_code as PostalCode, ph.address1 as Street, ph.address2 as Suburb, ph.payment_method as PaymentMethod,tg.payment_processed as PaymentStatus,tg.is_deleted as IsDeleted";
        $query .= " FROM ticket_generated as tg ";
        $query .= " INNER JOIN " . $this->config->item('ems_events', 'dbtables') . " as em ON em.id = tg.event_id";
        $query .= " INNER JOIN sub_events as se ON se.id = tg.sub_event_id";
        $query .= " INNER JOIN payment_history as ph ON ph.order_id = tg.order_id";
        $query .= " INNER JOIN " . $this->config->item('ems_organisers_details', 'dbtables') . " eorg ON eorg.organization_id = em.organiser_id";

        $query .= " WHERE ph.txn_number != ''";

        if ((!empty($search_values['searchby_org_id']))) {
            $query .= " AND eorg.organization_id =" . $search_values['searchby_org_id'] . "";
        }

        if ((!empty($search_values['searchby_event_id']))) {
            $query .= " AND em.id =" . $search_values['searchby_event_id'] . "";
        }

        if ((!empty($search_values['user_email']))) {
            $query .= " AND ph.email LIKE '%" . $search_values['user_email'] . "%'";
        }

        if ((!empty($search_values['searchby_sub_event_id']))) {
            $query .= " AND se.id =" . $search_values['searchby_sub_event_id'] . "";
        }

        /* if((!empty($search_values['from_date'])) && (!empty($search_values['to_date'])) ){
          $query .= " AND (ph.created_date BETWEEN ".$search_values['from_date']." and ".$search_values['from_date'].")";
          } */

        if ((!empty($search_values['from_date'])) && (!empty($search_values['to_date']))) {
            $fromdate = new DateTime($search_values['from_date']);
            $todate = new DateTime($search_values['to_date']);
            $from = $fromdate->format('Y-m-d H:i:s');
            $to = $todate->format('Y-m-d H:i:s');
            $query .= " AND (ph.created_date BETWEEN '" . $from . "' and '" . $to . "')";
        } else if ((!empty($search_values['from_date']))) {
            $fromdate = new DateTime($search_values['from_date']);
            $from = $fromdate->format('Y-m-d H:i:s');
            $query .= " AND (ph.created_date >= '" . $from . "')";
        } else if ((!empty($search_values['to_date']))) {
            $todate = new DateTime($search_values['to_date']);
            $to = $todate->format('Y-m-d H:i:s');
            $query .= " AND (ph.created_date <='" . $to . "')";
        }

        if ((!empty($search_values['payment_type']))) {
            $query .= " AND ph.payment_method LIKE '%" . $search_values['payment_type'] . "%'";
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

}
