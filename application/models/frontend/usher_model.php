<?php
class Usher_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->config->load('dbtables', TRUE);		
	}

	function get_event_details($event_id){
		$query = "SELECT *";
		$query .= " FROM ".$this->config->item('ems_events','dbtables');
		$query .= " WHERE id=".$event_id;	
         
        $res   = $this->db->query($query);
		$resArr = $res->result_array();
		
		return $resArr[0];
	}

	function get_subevent_details($event_id){
		$query = "SELECT *";
		$query .= " FROM ".$this->config->item('ems_sub_events','dbtables');
		$query .= " WHERE event_id=".$event_id;	
         
        $res   = $this->db->query($query);
		$resArr = $res->result_array();
		
		return $resArr;
	}

	function ajax_call_email($email){
         $query = "SELECT * FROM user_master";
		 $query .=" Where email='".$email."'";
		$res   = $this->db->query($query);
		$resArr = $res->result_array();

		if(isset($resArr['0'])){
			return "success";
		}else{
			
			return "error";
		}
	}
	function ajax_call_email_and_status($email, $sub_event_id){
	//	echo $sub_event_id;exit;
		$query = " SELECT * FROM sub_event_ushers";
		$query .=" WHERE email='".$email."' AND sub_event_id=".$sub_event_id."";
		$res   = $this->db->query($query);
		$resArr = $res->result_array();

		if(isset($resArr['0'])){
			return "exists";
		}
	}

	function get_user_id($email){
		 $query = "SELECT id,password,facebook_id,first_name, last_name FROM user_master";
		 $query .=" Where email='".$email."'";
		$res   = $this->db->query($query);
		$resArr = $res->result_array();
       // echo "<pre>";print_r($resArr);exit;
		return $resArr;
	}

	function save_usher($data){
		$result = $this->db->insert("sub_event_ushers", $data);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}
	function save_usher_details($data){
		$event_id=$data['event_id'];
		$sub_event_id=$data['sub_event_id'];
        
         $query = "SELECT * FROM sub_event_ticket_method";
		 $query .=" Where event_id=".$event_id." AND sub_event_id=".$sub_event_id."";

		// echo $query;exit;
		$res   = $this->db->query($query);
		$resArr = $res->result_array();

		if(empty($resArr)){
          $result = $this->db->insert("sub_event_ticket_method", $data);
		   $insert_id = $this->db->insert_id();
		  return  $insert_id;
		}else{
			return false;

		}



		
	}

	function ajax_subevent_ushers($sub_event_id){
	   
	    $query = "SELECT seu.id,seu.email,um.first_name, um.last_name,ee.title,sub.schedule_title,tm.ticket_checking_method FROM sub_event_ushers seu";
		$query .= " INNER JOIN ".$this->config->item('ems_events','dbtables')." ee ON ee.id = seu.event_id";
		$query .= " INNER JOIN ".$this->config->item('ems_sub_events','dbtables')." sub ON sub.id = seu.sub_event_id";
		$query .= " INNER JOIN sub_event_ticket_method tm ON tm.sub_event_id = seu.sub_event_id";
		$query .= " INNER JOIN user_master um ON um.id = seu.user_id";
		$query .= " WHERE seu.sub_event_id =".$sub_event_id;

		$res   = $this->db->query($query);
		$resArr = $res->result_array();

		return $resArr;


	}

	function delete_user($id){
		$this->db->where('id', $id);
        $this->db->delete('sub_event_ushers');

	}

	function ajax_get_status($get_status){
		  $query = "SELECT ticket_checking_method FROM sub_event_ticket_method";
		  $query .=" Where sub_event_id=".$get_status."";
         // echo $query;exit;
	    $res   = $this->db->query($query);
		$resArr = $res->result_array();

		if(empty($resArr)){
           return 0;
		}else{
			return $resArr[0]['ticket_checking_method'];

		}
	}

	function ajax_change_status($sub_event_id, $status){
          $query = "SELECT * FROM sub_event_ticket_method";
		  $query .=" Where sub_event_id=".$sub_event_id."";

		  $res   = $this->db->query($query);
	      $resArr = $res->result_array();

	      if(empty($resArr)){
            return 0;
	    	}else{
			$data=array('ticket_checking_method'=>$status);
            $this->db->where('sub_event_id',$sub_event_id);
            $this->db->update('sub_event_ticket_method',$data);
            return true;

		  }

	}

	function get_usher_details($sub_event_id){
          
        $query = "SELECT seu.id,seu.email,um.first_name, um.last_name,ee.title,sub.schedule_title,tm.ticket_checking_method FROM sub_event_ushers seu";
		$query .= " INNER JOIN ".$this->config->item('ems_events','dbtables')." ee ON ee.id = seu.event_id";
		$query .= " INNER JOIN ".$this->config->item('ems_sub_events','dbtables')." sub ON sub.id = seu.sub_event_id";
		$query .= " INNER JOIN sub_event_ticket_method tm ON tm.sub_event_id = seu.sub_event_id";
		$query .= " INNER JOIN user_master um ON um.id = seu.user_id";
		$query .= " WHERE seu.sub_event_id =".$sub_event_id;

		$res   = $this->db->query($query);
		$resArr = $res->result_array();

		return $resArr;

	}
	
	function ajax_get_start_end_date($event_id)
	{
		$query = "SELECT schedule_start_date AS start,schedule_end_date AS end,schedule_start_time AS s_time,schedule_end_time AS e_time FROM sub_events";
		$query .=" Where id=".$event_id."";
		$res   = $this->db->query($query);
		$resArr = $res->result_array();
		return $resArr;
	}

	function check_email($email,$sub_event_id){	
		$query = " SELECT * FROM sub_event_ushers";
		$query .=" WHERE email='".$email."' AND sub_event_id=".$sub_event_id."";
		$res   = $this->db->query($query);
		$resArr = $res->result_array();
           
		if(!empty($resArr)){
		    return true;
		}else{
		  	return false;
		}		
	}

	function check_users_master($email){
		$query = "SELECT id FROM user_master";
		$query .=" Where email='".$email."'";
		$res   = $this->db->query($query);
		$resArr = $res->result_array();

		if(!empty($resArr)){
			return true;
		}else{ 
			return false;
		}
	}

	public function get_deleted_usher_data($id){
		$query = " SELECT email,event_id,sub_event_id FROM sub_event_ushers";
		$query .=" WHERE id=".$id."";
		$res   = $this->db->query($query);
		$resArr = $res->result_array();
           
		if(!empty($resArr)){
		    return $resArr[0];
		}else{
		  	return true;
		}
	}
}		