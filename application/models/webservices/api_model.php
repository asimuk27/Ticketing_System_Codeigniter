<?php
class Api_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->config->load('dbtables', TRUE);
	}
	
	
	function check_login($email,$password){	
		$this->db->select('*');
		$this->db->from($this->config->item('ems_sub_event_ushers','dbtables'));
		$this->db->where('email =', $email);
		$this->db->where('password =', md5($password));
		$query = $this->db->get();

		if ($query->num_rows()) {
			return $query->result();
		} else {
			return false;
		}	
	}
	
	function check_login_status($email){
		$this->db->select('user_id,login_status');
		$this->db->from($this->config->item('ems_sub_event_ushers','dbtables'));
		$this->db->where('email =', $email);
		$this->db->where('login_status =', 0);
		$query = $this->db->get();

		if ($query->num_rows()) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	function update_login_status($email){
		$query = "UPDATE ".$this->config->item('ems_sub_event_ushers','dbtables');
		$query .= " SET login_status='1'";
		$query .= " WHERE email = '".$email."'";
		$res   = $this->db->query($query);
		
		return true;  
	}
	
	function validate_email($email){
		$this->db->select('email');
		$this->db->from($this->config->item('ems_sub_event_ushers','dbtables'));
		$this->db->where('email =', $email);
		$query = $this->db->get();

		if ($query->num_rows()) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	function update_password($email,$password){
		$query = "UPDATE ".$this->config->item('ems_sub_event_ushers','dbtables');
		$query .= " SET password = '".md5($password)."'";
		$query .= " WHERE email = '".$email."'";
		$res   = $this->db->query($query);
		
		return true;  
	}
	
	function check_if_user_id_valid($user_id){
		$this->db->select('user_id');
		$this->db->from($this->config->item('ems_sub_event_ushers','dbtables'));
		$this->db->where('user_id =', $user_id);
		$query = $this->db->get();

		if ($query->num_rows()) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	function get_sub_event_details($sub_event_id){
		$query = "SELECT *";
		$query .= " FROM ".$this->config->item('ems_sub_events','dbtables');
		$query .= " WHERE id=".$sub_event_id."";	

		$res   = $this->db->query($query);
		$resArr = $res->result_array();
		
		return $resArr;
	}
	
	function get_event_image($event_id){
		$query = "SELECT original_event_image";
		$query .= " FROM ".$this->config->item('ems_events','dbtables');
		$query .= " WHERE id = ".$event_id."";	

		$res   = $this->db->query($query);
		$resArr = $res->result_array();
	
		if(count($resArr) > 0){
			return $resArr['0'];			
		}else{
			$resArr = array();
			return $resArr;			
		}		
	}
	
	function get_sub_event_by_user_id($user_id){
		$this->db->select('*');
		$this->db->from($this->config->item('ems_sub_event_ushers','dbtables'));
		$this->db->where('user_id =', $user_id);
		$this->db->group_by('sub_event_id');		
		$query = $this->db->get();		

		if ($query->num_rows()) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	function update_logout_status($user_id){
		$query = "UPDATE ".$this->config->item('ems_sub_event_ushers','dbtables');
		$query .= " SET login_status = 0";
		$query .= " WHERE user_id = '".$user_id."'";
		$res   = $this->db->query($query);
		
		return true;  
	}
	
	function get_qr_data_details($qr_data,$event_id){
  		$this->db->select('id,qr_data,ticket_scan_status,order_id,ticket_id');
		$this->db->from($this->config->item('ems_event_ticket_generated','dbtables'));
		$this->db->where('qr_data =', $qr_data);
		$this->db->where('sub_event_id =', $event_id);
		$this->db->where('is_deleted =', 0);
		$query = $this->db->get();
								
		if ($query->num_rows()) {
			return $query->result();
		} else {
			return false;
		} 
	}
	
	function check_ticket_delete_status($qr_data,$event_id){
  		$this->db->select('id');
		$this->db->from($this->config->item('ems_event_ticket_generated','dbtables'));
		$this->db->where('qr_data =', $qr_data);
		$this->db->where('sub_event_id =', $event_id);
		$this->db->where('is_deleted = 1');
		$query = $this->db->get();
								
		if ($query->num_rows()) {
			return $query->result();
		} else {
			return false;
		} 
	}
	
	function update_ticket_status($qr_data){
		$query = "UPDATE ".$this->config->item('ems_event_ticket_generated','dbtables');
		$query .= " SET ticket_scan_status = 1";
		$query .= " WHERE qr_data = '".$qr_data."'";
		$res   = $this->db->query($query);
	
		return true;  
	}
	
	function insert_ticket_history($data){
		$result = $this->db->insert('ticket_scan_history', $data);
		$insert_id = $this->db->insert_id();
		
		return  $insert_id;
	}
	
	
	function get_ticket_user_details($order_id){
  		$this->db->select('first_name,last_name');
		$this->db->from($this->config->item('ems_payment_history','dbtables'));
		$this->db->where('order_id =', $order_id);
		$query = $this->db->get();
				
		if ($query->num_rows()) {
			return $query->result();
		} else {
			return 0;
		} 
	}
	
	function get_ticket_type_details($ticket_id){
		$this->db->select('ticket_type_id');
		$this->db->from($this->config->item('ems_sub_event_ticket_master','dbtables'));
		$this->db->where('id =', $ticket_id);
		$query = $this->db->get();
				
		if ($query->num_rows()) {
			return $query->result();
		} else {
			return 0;
		} 
	}
	
	function get_ticket_issued_by_sub_event($sub_event_id){
		$this->db->select('*');
		$this->db->from($this->config->item('ems_event_ticket_generated','dbtables'));
		$this->db->where('sub_event_id =', $sub_event_id);
		$this->db->where('is_deleted = 0');
		$this->db->where('payment_processed =', '1');
		$query = $this->db->get();
				
		if ($query->num_rows()) {
			return $query->num_rows();
		} else {
			return 0;
		} 
	}
	
	function get_ticket_scanned_by_sub_event($sub_event_id){
		$this->db->select('*');
		$this->db->from($this->config->item('ems_event_ticket_generated','dbtables'));
		$this->db->where('sub_event_id =', $sub_event_id);
		$this->db->where('ticket_scan_status =', 1);
		$query = $this->db->get();
				
		if ($query->num_rows()) {
			return $query->num_rows();
		} else {
			return 0;
		} 
	}
	
	function get_ticket_scanned_by_me_sub_event($sub_event_id,$user_id){		
		$query = "SELECT *";
		$query .= " FROM ".$this->config->item('ems_event_ticket_generated','dbtables')." ee";	
		$query .= " INNER JOIN ".$this->config->item('ems_ticket_scan_history','dbtables')." eo ON ee.id = eo.ticket_generated_id ";
		$query .= " WHERE eo.usher_id = '".$user_id."' AND eo.sub_event_id = '".$sub_event_id."'";
		
		$res   = $this->db->query($query);
		$resArr = $res->result_array();				
		
		if(count($resArr) > 0){
			return count($resArr);			
		}else{
			$resArr = array();
			return 0;			
		}
	}
	
	function get_ticket_issued_by_sub_event_ticket_type($sub_event_id,$ticket_type){
		$this->db->select('*');
		$this->db->from('ticket_generated');
		$this->db->join('tickets_master', 'tickets_master.id = ticket_generated.ticket_id');
		
		$this->db->where('ticket_generated.sub_event_id =', $sub_event_id);
		$this->db->where('tickets_master.ticket_type_id =', $ticket_type);
		$this->db->where('ticket_generated.is_deleted = 0');
		$this->db->where('ticket_generated.payment_processed =', '1');
		$query = $this->db->get();
					
		if($query->num_rows()){
			return $query->num_rows();
		} else {
			return 0;
		}
	}
	
	
	function get_ticket_scanned_by_sub_event_ticket_type($sub_event_id,$ticket_type){
		$this->db->select('*');
		$this->db->from('ticket_generated');
		$this->db->join('tickets_master', 'tickets_master.id = ticket_generated.ticket_id');
		
		$this->db->where('ticket_generated.sub_event_id =', $sub_event_id);
		$this->db->where('ticket_scan_status =', 1);
		$this->db->where('tickets_master.ticket_type_id =', $ticket_type);
		$query = $this->db->get();
						
		if($query->num_rows()){
			return $query->num_rows();
		} else {
			return 0;
		}
	}
	
	function get_ticket_scanned_by_me_sub_event_ticket_type($sub_event_id,$user_id,$ticket_type){
		
		$query = "SELECT *";
		$query .= " FROM ".$this->config->item('ems_event_ticket_generated','dbtables')." ee";	
		$query .= " INNER JOIN ".$this->config->item('ems_ticket_scan_history','dbtables')." eo ON ee.id = eo.ticket_generated_id ";
		
		$query .= " WHERE eo.ticket_type_id = '".$ticket_type."' AND eo.usher_id = '".$user_id."' AND eo.sub_event_id = '".$sub_event_id."'";
		
		$res   = $this->db->query($query);
		$resArr = $res->result_array();				
		return count($resArr);
		
	}
	
	 function get_ticket_scanned_by_sub_event_ticket_type_data($sub_event_id,$ticket_type){
		/* $this->db->select('*');
		$this->db->from($this->config->item('ems_event_ticket_generated','dbtables'));
		$this->db->where('sub_event_id =', $sub_event_id);
		$this->db->where('ticket_scan_status =', 1);
		$query = $this->db->get();
				
		if ($query->num_rows()) {
			return $query->result_array();
		} else {
			return array();
		}  */
		
		$this->db->select('*,ticket_generated.id as ticket_gen');
		$this->db->from('ticket_generated');
		$this->db->join('tickets_master', 'tickets_master.id = ticket_generated.ticket_id');
		
		$this->db->where('ticket_generated.sub_event_id =', $sub_event_id);
		$this->db->where('ticket_scan_status =', 1);
		$this->db->where('tickets_master.ticket_type_id =', $ticket_type);
		$query = $this->db->get();
						
		if($query->num_rows()){
			return $query->result_array();
		} else {
			return 0;
		}
	}
	
	function get_ticket_issued_by_sub_event_data($sub_event_id,$start = NULL){
		$this->db->select('ticket_id,id,sub_event_id as event_id,order_id,qr_data,ticket_sequence_no,ticket_scan_status');
		$this->db->from($this->config->item('ems_event_ticket_generated','dbtables'));
		$this->db->where('sub_event_id =', $sub_event_id);
		$this->db->where('is_deleted =', '0');
	//	$this->db->where('payment_processed =', '1');
		
		$this->db->limit(20, $start);
		$query = $this->db->get();
		
		
		if ($query->num_rows()) {
			return $query->result_array();
		} else {
			return array();
		} 
	}
	
	function get_ticket_type_by_ticket_generated_id($ticket_id){
		$this->db->select('ticket_type_id');
		$this->db->from($this->config->item('ems_sub_event_ticket_master','dbtables'));
		$this->db->where('id =', $ticket_id);
		
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->result_array();
		} else {
			return array();
		} 		
	}
	
	// get online offline status by sub event id
	function get_onlie_offline_status_by_sub_event_id($sub_event_id){
		$this->db->select('ticket_checking_method');
		$this->db->from('sub_event_ticket_method');
		$this->db->where('sub_event_id =', $sub_event_id);
		
		$query = $this->db->get();
		if ($query->num_rows()) {
			$resArr =  $query->result_array();
			return $resArr[0]['ticket_checking_method'];
		} else {
			return false;
		} 
	}
	
	function check_fb_login($email){	
		$this->db->select('*');
		$this->db->from($this->config->item('ems_sub_event_ushers','dbtables'));
		$this->db->where('email =', $email);		
		$query = $this->db->get();

		if ($query->num_rows()) {
			return $query->result();
		} else {
			return false;
		}	
	}
	
	function email_link_to_facebook($email){
		$this->db->select('*');
		$this->db->from($this->config->item('ems_sub_event_ushers','dbtables'));
		$this->db->where('email =', $email);
		$this->db->where('facebook_id != ""');			
		$query = $this->db->get();

		if ($query->num_rows()) {
			return $query->result();
		} else {
			return false;
		}
	}
	
}