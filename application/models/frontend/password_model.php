<?php
class Password_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->config->load('dbtables', TRUE);		
	}
	
		
	// function to check if email exist during registration
	function isMd5EmailPresent($email = NULL){			
		$query  = " SELECT id";
		$query .= " FROM " . $this->config->item('ems_organisers','dbtables');
		$query .= " WHERE md5(email) = ? ";		
		$dataBindArr = array($email);
		$res = $this->db->query($query, $dataBindArr);
		$resArr = $res->result();		
		
		if(count($resArr > 0)){
			return $resArr['0']->id;
		}else{
			return array();
		}	
	}
	
	// check if email address present in our system
	// Read data using username and password
	function check_registered_users($username){
	   $condition = "md5(email) = "."'".$username."' AND status = 1";
	   $this->db->select('*');
	   $this->db->from($this->config->item('ems_users','dbtables'));
	   $this->db->where($condition);
	   $this->db->limit(1);
	   $query = $this->db->get();

	   if ($query->num_rows() == 1) {
			return $query->result();
	   }else{
			$condition2 = "md5(email) = "."'".$username."' AND status = 1";
			$this->db->select('*');
			$this->db->from($this->config->item('ems_organisers','dbtables'));
			$this->db->where($condition2);
			$this->db->limit(1);
			$query2 = $this->db->get();
			
			if($query2->num_rows() == 1){
				return $query2->result();	
			}else{
				return array();
			}		
		}
	}
	
	function update_profile_password($userId,$type,$newCode){
		$updateArr["password"] = MD5($newCode);			
		
		if($type == 1){
			$this->db->where("id",$userId);		
			$res = $this->db->update($this->config->item('ems_organisers','dbtables'),$updateArr); 
		}else if($type == 0){
			$this->db->where("id",$userId);		
			$res = $this->db->update($this->config->item('ems_users','dbtables'),$updateArr); 
		}else{
			return false;
		}		
		return $res;
	}
	
}

?>