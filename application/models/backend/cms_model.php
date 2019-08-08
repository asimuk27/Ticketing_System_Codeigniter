<?php
class Cms_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->config->load('dbtables', TRUE);		
	}
	
	function get_faq_content(){
		$query = "SELECT *";
		$query .= " FROM faq_settings as fs";
		$query .= " INNER JOIN faq_order fo ON fs.id = fo.order_position";		
		$query .= " WHERE status = 0";
		$query .= " ORDER BY fo.id ASC";
		$res   = $this->db->query($query);
		$resArr = $res->result_array();
		
		if(count($resArr)){
			return $resArr;
		}else{
			return false;
		}
	}
	
	function get_all_users_count($id = NULL){
		$query = "SELECT *";
		$query .= " FROM " . $this->config->item('ems_cms','dbtables');		
		
		$res   = $this->db->query($query);
		$resArr = $res->result_array();
				
		return count($resArr);
	}
	
	function get_all_users($limit, $start){		
		
		$query = "SELECT *";
		$query .= " FROM " . $this->config->item('ems_cms','dbtables');		
		$query .= " LIMIT ".$start.", ".$limit."";
		$res   = $this->db->query($query);
		$resArr = $res->result_array();
		
		return $resArr;
	}
	
	function get_data_by_id($id){
		$query = "SELECT *";
		$query .= " FROM " . $this->config->item('ems_cms','dbtables');		
		$query .= " WHERE id = '".$id."'";
		$res   = $this->db->query($query);
		$resArr = $res->result_array();
		
		if(count($resArr)){
			return $resArr['0'];
		}else{
			return false;
		}
		
		
		
		
	}
	
	
	function save($data){
		if(isset($data['id']) && ($data['id'] != "")){
			$this->db->where('id', $data['id']);
			$queryResult = $this->db->update($this->config->item('ems_cms','dbtables'), $data);
			$result = 0;
		}else{
			$result = $this->db->insert($this->config->item('ems_cms','dbtables'), $data);
			$result = 1;
		}	
		
		return $result;
	}
	
}
?>