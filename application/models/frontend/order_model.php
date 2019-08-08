<?php
class Order_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->config->load('dbtables', TRUE);		
	}
	
		
	function get_event_id_and_organiser_id($sub_event_id){
	    $query  =  "SELECT eo.organiser_id as organiser_id";
		$query .= " FROM sub_events sub_e";	
		$query .= " INNER JOIN event_master eo ON eo.id = sub_e.event_id";
		$query .= " WHERE sub_e.id='".$sub_event_id."'";	
		
		$res   = $this->db->query($query);
		$resArr = $res->result_array();
		
		if(count($resArr > 0)){
			return $resArr[0]['organiser_id'];
		}else{
			$resArr = array();
			return $resArr;
		}		
	}
	
}

?>