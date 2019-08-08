<?php
class User_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->config->load('dbtables', TRUE);		
	}
	
	
	function get_all_users_count($search_values = NULL){
		$query = "SELECT *";
		$query .= " FROM " . $this->config->item('ems_users','dbtables');		
	
		if((!empty($search_values))){			
	    	$query .= " WHERE {$search_values['searchby']} LIKE '%".$search_values['keyword']."%'";							
		}		
		
		$res   = $this->db->query($query);
		$resArr = $res->result_array();
				
		return count($resArr);
	}
	
	function update_user_status($status,$user_id)
	{
		$data = array();
		if($status){
			$data['status'] = "0";
		}else{
			$data['status'] = "1";
		}				
		$this->db->where('id', $user_id);
	
		$queryResult = $this->db->update($this->config->item('ems_users','dbtables'), $data);
	
		return $queryResult;
	}

	function get_viewing_contents($get_id)
	{
		$condition = "id =".$get_id;
		$this->db->select('*');
		$this->db->from('user_master');
		$this->db->where($condition);
		$query = $this->db->get();

		if ($query->num_rows() == 1) {
			return $query->row();
		} else {
			return false;
		}
	}
	
	function get_all_users($limit, $start, $search_values){		
		
		$query = "SELECT *";
		$query .= " FROM " . $this->config->item('ems_users','dbtables');		
	
		if((!empty($search_values))){			
	    	$query .= " WHERE {$search_values['searchby']} LIKE '%".$search_values['keyword']."%'";							
		}
		$query .= " Order By id desc";
		$query .= " LIMIT ".$start.", ".$limit."";
		$res   = $this->db->query($query);
		$resArr = $res->result_array();
		
		return $resArr;
	}
	
}
?>