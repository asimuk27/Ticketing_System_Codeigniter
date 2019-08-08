<?php
class Login_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->config->load('dbtables', TRUE);		
	}
	
	// function to check valid agent/client login
	function check_login($username, $password){
		// Read data using username and password
		$condition = "email = "."'".$username."' AND "."password = "."'".md5($password)."'";
		$this->db->select('*');
		$this->db->from($this->config->item('ems_admin','dbtables'));
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();

		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function check_login_approval($email){
		// Read data using username and password
		$condition = "email = "."'".$email."' AND status = 0 ";
		$this->db->select('*');
		$this->db->from($this->config->item('ems_admin','dbtables'));
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();

		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}	
	
	public function update_last_login($email){
		$data=array('last_login'=>date('Y-m-d H:i:s'));
		$this->db->where('email',$email);
		$result = $this->db->update($this->config->item('ems_admin','dbtables'),$data);
		return $result;	
	}
	
	public function update_my_profile($name){
		$id = $this->session->userdata['admin_logged_in']['id'];
		$data=array('name'=>$name);
		$this->db->where('id',$id);
		$result = $this->db->update($this->config->item('ems_admin','dbtables'),$data);
			
		return $result;	
	}
	
	public function get_admin_profile($id){
		$this->db->select('*');
		$this->db->where('id',$id);
		$result = $this->db->from($this->config->item('ems_admin','dbtables'));
		$query = $this->db->get();

		if ($query->num_rows() == 1) {
			return $query->result()['0'];
		} else {
			return false;
		}		
	}
	
	function check_login_user_password($password){
		
		$id = $this->session->userdata['admin_logged_in']['id'];
		
		$query  = " SELECT id";
		$query .= " FROM " . $this->config->item('ems_admin','dbtables');
		$query .= " WHERE id = $id AND password = '".md5($password)."'";
				
		$res = $this->db->query($query);
		$resArr = $res->result();		
		return count($resArr);
	}
	
	public function update_password($password){
		$data=array('password'=>md5($password));
		$this->db->where('id',$this->session->userdata['admin_logged_in']['id']);
		$result = $this->db->update($this->config->item('ems_admin','dbtables'),$data);
		return $result;		
	}
	
	public function get_roles_by_id($ids){
		$query  = " SELECT GROUP_CONCAT(key_name) as roles";
		$query .= " FROM " . $this->config->item('ems_admin_roles','dbtables');
		$query .= " WHERE id IN ($ids) ";
		
		$res = $this->db->query($query);
		$resArr = $res->result_array();		
		
		if(count($resArr) > 0) {
			return $resArr['0'];
		} else {
			return array();
		}
	}
}
?>