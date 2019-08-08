<?php
class My_donation_model extends CI_Model
{
	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->config->load('dbtables', TRUE);		
	}

	function get_my_donation_count($search_values = NULL){
	
		$organizer_id = $this->session->userdata['logged_in'];
		
		$query = "SELECT *";
		$query .= " FROM ".$this->config->item('ems_donations','dbtables')." ee";	
		$query .= " INNER JOIN ".$this->config->item('ems_payment_history','dbtables')." eo ON eo.order_id = ee.order_id ";
		$query .= " INNER JOIN ".$this->config->item('ems_champions','dbtables')." ec ON ec.id = ee.champion_page_id ";
		$query .= " INNER JOIN ".$this->config->item('ems_organisers_details','dbtables')." eorg ON eorg.organization_id = ec.charity_id ";
		$query .= " WHERE eo.txn_number != '' AND eo.user_id = '".$organizer_id['id']."'";
		
		if((!empty($search_values['search_by_order_id']))){			
	    	$query .= " AND eo.order_id LIKE '%".$search_values['search_by_order_id']."%'";							
		}
		
		if((!empty($search_values['search_by_transact_id']))){			
	    	$query .= " AND txn_number LIKE '%".$search_values['search_by_transact_id']."%'";							
		}
		
		$res   = $this->db->query($query);
		$resArr = $res->result_array();		

		return count($resArr);
	}
	
	function get_my_donation($limit = NULL, $start = NULL,$search_values = NULL){
		$organizer_id = $this->session->userdata['logged_in'];
		
		$query = "SELECT ec.id as champ_id,eorg.charity_name,ec.display_name,ee.id,ec.title,donation_amount,eo.order_id,txn_date,txn_number,ee.status";
		$query .= " FROM ".$this->config->item('ems_donations','dbtables')." ee";	
		$query .= " INNER JOIN ".$this->config->item('ems_payment_history','dbtables')." eo ON eo.order_id = ee.order_id ";
		$query .= " INNER JOIN ".$this->config->item('ems_champions','dbtables')." ec ON ec.id = ee.champion_page_id ";
		$query .= " INNER JOIN ".$this->config->item('ems_organisers_details','dbtables')." eorg ON eorg.organization_id = ec.charity_id ";
		$query .= " WHERE eo.txn_number != '' AND eo.user_id = '".$organizer_id['id']."'";
		
		if((!empty($search_values['search_by_order_id']))){			
	    	$query .= " AND eo.order_id LIKE '%".$search_values['search_by_order_id']."%'";							
		}
		
		if((!empty($search_values['search_by_transact_id']))){			
	    	$query .= " AND txn_number LIKE '%".$search_values['search_by_transact_id']."%'";							
		}
		
		$query .= "ORDER BY id DESC";
		$query .= " LIMIT ".$start.", ".$limit."";
		$res   = $this->db->query($query);
		$resArr = $res->result_array();				
		return $resArr;
	}
	
	function view_my_donations($id = NULL){
		$organizer_id = $this->session->userdata['logged_in'];
		
		$query = "SELECT subevnts.schedule_title as schedule_title,evnts.title as event_title,ec.title as title,eorg.charity_name,txn_number,txn_date,ec.display_name,ec.event_id,eo.order_id,donation_amount,donor_message,eo.email,ee.phone,ee.street,ee.country,eo.payment_method,eo.status,is_notified_on_email,user_id";
		$query .= " FROM ".$this->config->item('ems_donations','dbtables')." ee";	
		$query .= " INNER JOIN ".$this->config->item('ems_payment_history','dbtables')." eo ON eo.order_id = ee.order_id ";
		$query .= " INNER JOIN ".$this->config->item('ems_champions','dbtables')." ec ON ec.id = ee.champion_page_id ";
		$query .= " INNER JOIN ".$this->config->item('ems_organisers_details','dbtables')." eorg ON eorg.organization_id = ec.charity_id ";
		$query .= " INNER JOIN ".$this->config->item('ems_events','dbtables')." evnts ON evnts.id = ec.event_id ";
		$query .= " INNER JOIN ".$this->config->item('ems_sub_events','dbtables')." subevnts ON subevnts.id = ec.sub_event_id ";
		
		$query .= " WHERE eo.user_id = '".$organizer_id['id']."' AND ee.id = '".$id."'";
		
		$res   = $this->db->query($query);
		$resArr = $res->result_array();				
		
		if(empty($resArr)){
			$resArr = array();
			return $resArr;
		}else{
			return $resArr['0'];
		}		
	}
}