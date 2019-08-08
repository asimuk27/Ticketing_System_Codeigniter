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
	/*function check_login($username, $password){
		// Read data using username and password
		$condition = "email = "."'".$username."' AND "."password = "."'".md5($password)."'";
		$this->db->select('*');
		$this->db->from($this->config->item('ems_users','dbtables'));
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();

		$condition2 = "email = "."'".$username."' AND "."password = "."'".md5($password)."'";
		$this->db->select('*');
		$this->db->from($this->config->item('ems_organisers','dbtables'));
		$this->db->where($condition);
		$this->db->limit(1);
		$query2 = $this->db->get();

		if ($query->num_rows() == 1) {
			return $query->result();
		}else if($query2->num_rows() == 1){
			return $query2->result();
		}else {
			return false;
		}
	}
	*/
	// function to check valid agent/client login
	function check_login($username, $password){
		// Read data using username and password
		$condition = "email = "."'".$username."' AND "."password = "."'".md5($password)."'";
		$this->db->select('*');
		$this->db->from($this->config->item('ems_users','dbtables'));
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();

		if ($query->num_rows() == 1) {
			return $query->result();
		}else{
			$condition2 = "email = "."'".$username."' AND "."password = "."'".md5($password)."'";
			$this->db->select('*');
			$this->db->from($this->config->item('ems_organisers','dbtables'));
			$this->db->where($condition);
			$this->db->limit(1);
			$query2 = $this->db->get();

			if($query2->num_rows() == 1){
				return $query2->result();
			}else{
				return false;
			}
		}
	}
	
	/*function checkEmailExist($email){
		$verifyCreds = $this->db->get_where($this->config->item('ems_organisers','dbtables'),array("email"=>$email));
		return $verifyCreds->row();
	}*/
	function checkEmailExist($email){
		$verifyOrganiserCreds = $this->db->get_where($this->config->item('ems_organisers','dbtables'),array("email"=>$email));
		$data = $verifyOrganiserCreds->row();
		if(empty($data)){
			$verifyUserCreds = $this->db->get_where($this->config->item('ems_users','dbtables'),array("email"=>$email));
			$data = $verifyUserCreds->row();
				if(empty($data)){
					return false;
				}else{
					return $verifyUserCreds->row();
				}		
		}else{
			return $verifyOrganiserCreds->row();
		}		
	}
	
	function updatePswd($userId,$type,$newCode){
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
	
		public function check_login_approval($email){
		// Read data using username and password			
	//	$condition = "email = "."'".$email."' AND status = 0";
		$condition = "email = "."'".$email."' AND (status = 0 || status = 2 )";
		$this->db->select('*');
		$this->db->from($this->config->item('ems_organisers','dbtables'));
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();

		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	function add_user($data){
		$this->db->insert($this->config->item('ems_users','dbtables'), $data);
	}

	function check_mail($email)
	{
		$this->db->from('user_master');

        $this->db->where('email', $email);


        $query = $this->db->get();

        return $query;

	}
	
	function get_editable_contents($get_id)
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

	function edit_user($data, $user_id)
	{
		$this->db->where('id', $user_id);
        $this->db->update('user_master', $data);
	}

	function authenticate_facebook_email($email)
	{
		$condition = "email ='".$email."'";
		$this->db->select('*');
		$this->db->from('user_master');
		$this->db->where($condition);
		$query = $this->db->get();

		$condition2 = "email ='".$email."'";
		$this->db->select('*');
		$this->db->from('organisation_contact');
		$this->db->where($condition);
		$query2 = $this->db->get();

		if ($query->num_rows() == 1) {
			return true;
		} else if($query2->num_rows() == 1){
 			return true;
		}else {
			return false;
		}


	}
	
	function authenticate_reg_email($email)
	{
		$condition = "email ='".$email."'";
		$this->db->select('*');
		$this->db->from('user_master');
		$this->db->where($condition);
		$query = $this->db->get();

		if ($query->num_rows() == 1) {
			return true;
		}else{			
			$condition2 = "email ='".$email."'";
			$this->db->select('*');
			$this->db->from('organisation_contact');
			$this->db->where($condition);
			$query2 = $this->db->get();
			
			if($query2->num_rows() == 1){
				return true;
			}else{
				return false;
			}
		}
	}

	function retrive_auth_records($email)
	{
		$condition = "email ='".$email."'";
		$this->db->select('*');
		$this->db->from('user_master');
		$this->db->where($condition);
		$query = $this->db->get();

		$condition2 = "email ='".$email."'";
		$this->db->select('*');
		$this->db->from('organisation_contact');
		$this->db->where($condition);
		$query2 = $this->db->get();

		if ($query->num_rows() == 1) {
			return $query->row();
		} else if($query2->num_rows() == 1){
 			return $query->row();
		}else {
			return false;
		}
	}

	function get_profile_contents($id)
	{
		$condition = "id =".$id;
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

	function add_facebook_user($data,$email){

	    $condition = "email ='".$email."'";
		$this->db->select('*');
		$this->db->from('user_master');
		$this->db->where($condition);
		$query = $this->db->get();


		if ($query->num_rows() == 1) {
			
		} else {
			$this->db->insert('user_master', $data);
		}
	}
	
	function check_user_email($email){
		$condition = "email ='".$email."'";
		$this->db->select('*');
		$this->db->from('user_master');
		$this->db->where($condition);
		$query = $this->db->get();


		if ($query->num_rows() == 1) {
			return 1;
		} else {
			return 2;
		}
	}
	
		 /////////////////////////////
  function check_login_status($username){
   // Read data using username and password

   $condition = "email = "."'".$username."' AND status = 1";
   $this->db->select('*');
   $this->db->from($this->config->item('ems_users','dbtables'));
   $this->db->where($condition);
   $this->db->limit(1);
   $query = $this->db->get();

   if ($query->num_rows() == 1) {
		return $query->result();
   }else{
		$condition2 = "email = "."'".$username."' AND status = 1";
		$this->db->select('*');
		$this->db->from($this->config->item('ems_organisers','dbtables'));
		$this->db->where($condition2);
		$this->db->limit(1);
		$query2 = $this->db->get();
		
		if($query2->num_rows() == 1){
			return $query2->result();	
		}else{
			return false;
		}		
	}
  }
  
  /////////////////////////////
 public function check_login_approved($email){
	   // Read data using username and password
	   $condition = "email = "."'".$email."' AND status = 0";
	   $this->db->select('*');
	   $this->db->from($this->config->item('ems_users','dbtables'));
	   $this->db->where($condition);
	   $this->db->limit(1);
	   $query = $this->db->get();

	   if ($query->num_rows() == 1){
			return $query->result();
	   }else{
		   $condition2 = "email = "."'".$email."' AND status = 0";
		   $this->db->select('*');
		   $this->db->from($this->config->item('ems_organisers','dbtables'));
		   $this->db->where($condition2);
		   $this->db->limit(1);
		   $query2 = $this->db->get();
		   
		   if($query2->num_rows() == 1){
				return $query2->result();	
		   }else{
				return false;
		   }		  	   
	   }	   
	}
	
	function check_facebook_email($email){
		$condition = "email = "."'".$email."' AND facebook_id != ''";
		$this->db->select('*');
		$this->db->from($this->config->item('ems_users','dbtables'));
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();

		if($query->num_rows() == 1) {
			 return '2';		
		}else{
			return '1';
		}
	}
	
	public function update_user_password($password){
		$data=array('password'=>md5($password));
		$this->db->where('id',$this->session->userdata['logged_in']['id']);
		$result = $this->db->update($this->config->item('ems_users','dbtables'),$data);
		return $result;
	}
	
	function check_profile_user_password($password){		
		$id = $this->session->userdata['logged_in']['id'];		
		$query  = " SELECT id";
		$query .= " FROM " . $this->config->item('ems_users','dbtables');
		$query .= " WHERE id = $id AND password = '".md5($password)."'";				
		$res = $this->db->query($query);
		$resArr = $res->result();		
		return count($resArr);
	}
	
	function update_individual_email($email,$id){
		$id = $this->session->userdata['logged_in']['id'];	
		if($id){
			$data = array('email'=>$email);
			$this->db->where('id', $id);
			$this->db->update($this->config->item('ems_users','dbtables'), $data);
			return true;
		}else{
			return false;
		}		
	}
}
?>