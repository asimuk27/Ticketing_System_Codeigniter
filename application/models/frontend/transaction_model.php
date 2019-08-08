<?php

class Transaction_model extends CI_Model
{

	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->config->load('dbtables', TRUE);
	}

	function get_history(){
		$query = "SELECT order_id,charity_name,user_id,email,status,amount,amount,txn_number,payment_for,first_name,last_name,payment_method,email_status,ph.created_date ";
		$query .= " FROM payment_history as ph ";
		$query .= " INNER JOIN organization_details as od ON ph.organiser_id = od.organization_id";
		
		$yday = date('Y-m-d h:i:s', strtotime("-1 day"));
		
        $query .= " WHERE ph.created_date > '$yday'";

        $res   = $this->db->query($query);
		$resArr = $res->result_array();

		if(!empty($resArr)){
           return $resArr;
		}else{
           return array();;
		}
	}

	function get_event_by_ticket($order_id){
		$query =   "SELECT em.title, se.schedule_title";
		$query .= " FROM ticket_generated as tg ";	
		$query .= " INNER JOIN ".$this->config->item('ems_events','dbtables')." as em ON em.id = tg.event_id";
		$query .= " INNER JOIN sub_events as se ON se.id = tg.sub_event_id";
		
		$query .= " WHERE tg.order_id = '".$order_id."'";
		$query .= " GROUP BY em.title";
		$res   = $this->db->query($query);
		$resArr = $res->result_array();

		if(!empty($resArr)){
           return $resArr['0'];
		}else{
           return array();;
		}
	}
	
	function get_event_by_donation($order_id){
		 $query = "SELECT evt.title as title, sub_evt.schedule_title as schedule_title,evt_don.status";

		 $query .= " FROM ".$this->config->item('ems_champions','dbtables')." chmp";
		 $query .= " INNER JOIN ".$this->config->item('ems_events','dbtables')." evt ON evt.id = chmp.event_id ";
		 $query .= " INNER JOIN ".$this->config->item('ems_sub_events','dbtables')." sub_evt ON sub_evt.id = chmp.sub_event_id ";
		 $query .= " INNER JOIN ".$this->config->item('ems_donations','dbtables')." evt_don ON evt_don.champion_page_id = chmp.id ";
		
		 $query .= " WHERE evt_don.order_id = '".$order_id."'";
		 $query .= " GROUP BY evt.title";
		 $res   = $this->db->query($query);
		 $resArr = $res->result_array();

		 if(!empty($resArr)){
			  return $resArr['0'];
		 }else{
			  return array();;
		 }		
	}
}

?>