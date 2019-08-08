<?php
class Event_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->config->load('dbtables', TRUE);		
	}
	
	
	function get_all_users_count($search_values = NULL){
		$query = "SELECT *";
		$query .= " FROM " . $this->config->item('ems_events','dbtables');		
	
		if((!empty($search_values))){			
	    	$query .= " WHERE {$search_values['searchby']} LIKE '%".$search_values['keyword']."%'";							
		}		
		
		$res   = $this->db->query($query);
		$resArr = $res->result_array();
				
		return count($resArr);
	}
	
	function get_all_users($limit, $start, $search_values){		
		
		$query = "SELECT *";
		$query .= " FROM " . $this->config->item('ems_events','dbtables');		
	
		if((!empty($search_values))){			
	    	$query .= " WHERE {$search_values['searchby']} LIKE '%".$search_values['keyword']."%'";							
		}
		$query .= " LIMIT ".$start.", ".$limit."";
		$res   = $this->db->query($query);
		$resArr = $res->result_array();
		
		return $resArr;
	}
	
	
	
}
?>