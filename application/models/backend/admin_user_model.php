<?php 
	//class homeModel describes basic crud function on tables
	
	class Admin_user_model extends CI_Model {
		
		function __construct()
		{
			parent::__construct();
			$this->load->database();
			$this->config->load('dbtables', TRUE);
			
		}
		
	function get_all_users_count($search_values = NULL){
		$query = "SELECT *";
		$query .= " FROM " . $this->config->item('ems_admin','dbtables');		
	
		if((!empty($search_values))){			
	    	$query .= " WHERE {$search_values['searchby']} LIKE '%".$search_values['keyword']."%'";							
		}		
		
		$res   = $this->db->query($query);
		$resArr = $res->result_array();
				
		return count($resArr);
	}
	
	
	function get_all_users($limit, $start, $search_values){		
		
		$query = "SELECT *";
		$query .= " FROM " . $this->config->item('ems_admin','dbtables');		
	
		if((!empty($search_values))){			
	    	$query .= " WHERE {$search_values['searchby']} LIKE '%".$search_values['keyword']."%'";							
		}
		$query .= " Order By id desc";
		$query .= " LIMIT ".$start.", ".$limit."";
		$res   = $this->db->query($query);
		$resArr = $res->result_array();
		
		return $resArr;
	}
		function show_list()
		{
			$this->db->select('*');
			$this->db->from($this->config->item('ems_admin','dbtables'));
			$query=$this->db->get();
			return $query->result_array();
			
		}
			
			
		function insert_admin_user($data){
			$tablename='admin_users';
			
			$condition = "email = '".$data['email']."'";			
			
			$this->db->select('*');
			$this->db->from($tablename);
			$this->db->where($condition);
			$query=$this->db->get();
					
			if($query->num_rows() == 0){
				$this->db->insert($tablename,$data);
				return true;
			}
			else{
				return false;
			} 
			
		}

		function get_user_roles(){
			$this->db->select('*');
			$this->db->from($this->config->item('ems_admin_roles','dbtables'));
			$query = $this->db->get();
			return $query->result_array();
		}
		
		
		
	}