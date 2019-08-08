<?php
class Organiser_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->config->load('dbtables', TRUE);		
	}
	
	
	function get_all_users_count($search_values = NULL){
		$query = "SELECT *";
		$query .= " FROM " .$this->config->item('ems_organisers','dbtables'). " as a";	
		$query .= " INNER JOIN " . $this->config->item('ems_organisers_details','dbtables'). " as b";		
		$query .= " ON a.id = b.organization_id";	
		$query .= " WHERE a.in_complete = 0 ";
		
		if((!empty($search_values))){			
	    	$query .= " AND {$search_values['searchby']} LIKE '%".$search_values['keyword']."%'";				
		}		
		
		$res   = $this->db->query($query);
		$resArr = $res->result_array();
				
		return count($resArr);
	}
	
	function get_organiser_email($id){
		$query = "SELECT email";
		$query .= " FROM ".$this->config->item('ems_organisers','dbtables');			
		$query .= " WHERE id = '$id'";
		
		$res   = $this->db->query($query);
		$resArr = $res->result_array();
				
		return $resArr;
	}
	
	function get_pending_for_approval(){
		$query = "SELECT count(*) as request_pending";
		$query .= " FROM ".$this->config->item('ems_organisers','dbtables');			
		$query .= " WHERE status = 2";
		
		$res   = $this->db->query($query);
		$resArr = $res->result_array();
				
		return $resArr;
	}
	
	function get_organiser_areas($id){
		$query = "SELECT course_id";
		$query .= " FROM ".$this->config->item('ems_organiser_areas','dbtables');			
		$query .= " WHERE organization_id = '$id'";
		
		$res   = $this->db->query($query);
		$resArr = $res->result_array();
				
		return $resArr;
	}
	
	function get_all_users($limit, $start, $search_values){		
		
	 	$query = "SELECT *";
		$query .= " FROM " .$this->config->item('ems_organisers','dbtables'). " as a";	
		$query .= " INNER JOIN " . $this->config->item('ems_organisers_details','dbtables'). " as b";		
		$query .= " ON a.id = b.organization_id";	
		$query .= " WHERE a.in_complete = 0";
	
		if((!empty($search_values))){			
	    	$query .= " AND {$search_values['searchby']} LIKE '%".$search_values['keyword']."%'";							
		}
		$query .= " ORDER BY FIELD(status, 2, 0, 1),1 DESC";
		$query .= " LIMIT ".$start.", ".$limit."";
		$res   = $this->db->query($query);
		$resArr = $res->result_array();
			
		return $resArr;
	}
	
	
	/*function view_organisation($id = null){
		$query = "SELECT areas,organization_nature,donee_status,charities_commission,registration_number,a.preferred_name,a.id as id, a.title as title,a.salutation as salutation,a.first_name as first_name,a.last_name as last_name,a.email as email,a.phone as phone,a.fax as fax,b.organization_name as organization_name,b.ird_number as ird_number,b.charity_name as charity_name,b.charity_overview as charity_overview,b.street_address as street_address,b.city as city,b.region as region,b.postal_code as postal_code,b.country as country,c.position as finance_position,c.first_name as finance_first_name,c.last_name as finance_last_name,c.email as finance_email,c.phone as finance_phone,c.fax as finance_fax,bank_details,bank_name,receipt_text,signature,bank_statement,logo,a.status as main_status,c.signature_text";
		
		$query .= " FROM " .$this->config->item('ems_organisers','dbtables'). " as a";	
		$query .= " INNER JOIN " . $this->config->item('ems_organisers_details','dbtables'). " as b";
		$query .= " ON a.id = b.organization_id";	
		$query .= " INNER JOIN " . $this->config->item('ems_organisers_finance','dbtables'). " as c";
		$query .= " ON a.id = c.organization_id";	
		$query .= " WHERE a.id = '$id'";
		$query .= " GROUP BY a.id";

		$res   = $this->db->query($query);
		$resArr = $res->result_array();
			
		return $resArr;
	}*/
	
	function view_organisation($id = null){
		$query = "SELECT areas,organization_nature,donee_status,charities_commission,registration_number,a.preferred_name,a.id as id, a.title as title,a.salutation as salutation,a.first_name as first_name,a.last_name as last_name,a.email as email,a.phone as phone,a.fax as fax,b.organization_name as organization_name,b.ird_number as ird_number,b.charity_name as charity_name,b.charity_overview as charity_overview,b.street_address as street_address,b.city as city,b.region as region,b.postal_code as postal_code,b.country as country,c.position as finance_position,c.first_name as finance_first_name,c.last_name as finance_last_name,c.email as finance_email,c.phone as finance_phone,c.fax as finance_fax,bank_details,bank_name,receipt_text,signature,bank_statement,bank_name_for_ticket_suite,account_number_ticket_suite,bank_statement_ticket_suite,logo,a.status as main_status,c.signature_text,c.plan_select";
		
		$query .= " FROM " .$this->config->item('ems_organisers','dbtables'). " as a";	
		$query .= " INNER JOIN " . $this->config->item('ems_organisers_details','dbtables'). " as b";
		$query .= " ON a.id = b.organization_id";	
		$query .= " INNER JOIN " . $this->config->item('ems_organisers_finance','dbtables'). " as c";
		$query .= " ON a.id = c.organization_id";	
		$query .= " WHERE a.id = '$id'";
		$query .= " GROUP BY a.id";

		
		$res   = $this->db->query($query);
		$resArr = $res->result_array();
			
		return $resArr;
	}
	
		
	
	function update_organiser_status($status,$organiser_id){
		$data = array();
		if($status == 1){
			$data['status'] = "0";
		}else if($status == 0 || $status == 2){
			$data['status'] = "1";
		}				
		$this->db->where('id', $organiser_id);
		$queryResult = $this->db->update($this->config->item('ems_organisers','dbtables'), $data);
	
		return $queryResult;
	}	
	
	function save_organiser($data){		
		$this->db->where('id', $data['id']);
		$queryResult = $this->db->update($this->config->item('ems_organisers','dbtables'), $data);	
		
		return $queryResult;
	}
	
	function save_organiser_additional_details($data){		
		$this->db->where('organization_id', $data['organization_id']);
		$queryResult = $this->db->update($this->config->item('ems_organisers_details','dbtables'), $data);	
		return $queryResult;
	}
	
		
	function save_organiser_finance_details($data){
		$this->db->where('organization_id', $data['organization_id']);
		$queryResult = $this->db->update($this->config->item('ems_organisers_finance','dbtables'), $data);	
		return $queryResult;
	}
	
	// function to get organiser name
	function get_organiser_details($id = NULL){   
		$query  = " SELECT organization_name,charity_name";
		$query .= " FROM " . $this->config->item('ems_organisers_details','dbtables');
		$query .= " WHERE organization_id = $id ";  
		//$dataBindArr = array($id);
		$res = $this->db->query($query);//, $dataBindArr ;
		$resArr = $res->result_array();  
		return ($resArr);
	}
	
	function get_payment_information($id){
		$query  = " SELECT *";
		$query .= " FROM " . $this->config->item('ems_organization_payment_setup','dbtables');
		$query .= " WHERE organizer_id = $id Group by payment_key";  
		$res = $this->db->query($query);
		$resArr = $res->result_array();  
		return ($resArr);
	}
	
	function update_payment_details($pay_details,$organizer_unique_id){		
		$pay_details['organizer_id'] = $organizer_unique_id;
		$key = $pay_details['payment_key'];
		$query = "SELECT id";
		$query .= " FROM ".$this->config->item('ems_organization_payment_setup','dbtables');			
		$query .= " WHERE organizer_id = '$organizer_unique_id' AND payment_key = '$key'";
	
		$res   = $this->db->query($query);
		$resArr = $res->result_array();  
		
		if(empty($resArr)){
			$this->db->insert($this->config->item('ems_organization_payment_setup','dbtables'), $pay_details);
			return true;
		}else{
			// build where clause array
			$where_data = array('organizer_id'=>$organizer_unique_id,'payment_key'=>$key);
			
			$this->db->where($where_data);
						
			$queryResult = $this->db->update($this->config->item('ems_organization_payment_setup','dbtables'), $pay_details);	
			return true;
		}
	}
	public function get_organisation_type(){
		$query  = " SELECT *";
		$query .= " FROM organization_type"; 
		$res   = $this->db->query($query);
		$resArr = $res->result_array();

		if(count($resArr) > 0){
			return $resArr;
		}else{
			return false;
		}
	}
	
	function get_terms_check_status($type,$org_id){
		$query  = " SELECT id";
		$query .= " FROM " . $this->config->item('organizer_terms_conditions','dbtables');
		$query .= " WHERE organizer_id = $org_id AND key_name = '$type' AND status = 1";  
		$res = $this->db->query($query);
		$resArr = $res->result_array();  
		return count($resArr); 
	}
	
	function mark_as_incomplete($org_id){
		$data=array('in_complete'=>'1','password'=>'');
		$this->db->where('id', $org_id);
		$queryResult = $this->db->update($this->config->item('ems_organisers','dbtables'), $data);

		return $queryResult;
	}
	
	function authenticate_reg_email($email){		 
		$query = "select email from (select email from user_master union all select email from organisation_contact)a where email = '".$email."'";     
		$query = $this->db->query($query); 
		if ($query->num_rows() == 1) {
			return true;
		}else{
			return false;
		}		 
	}

	function update_organiser_email($email,$id){
		$session_data=$this->session->userdata['admin_logged_in'];
		if(isset($session_data['id'])){
			$data = array('email'=>$email);
			$this->db->where('id', $id);
			$this->db->update($this->config->item('ems_organisers','dbtables'), $data);
			return true;
		}else{
			return false;	
		}
	}
	
	function terms_n_conditions_view($id){
		$query  = " SELECT *";
		$query .= " FROM " . $this->config->item('organizer_terms_conditions','dbtables');
		$query .= " WHERE organizer_id=".$id;  
		$res = $this->db->query($query);
		$resArr = $res->result_array();  
		
		if(count($resArr) > 0){
			return $resArr;
		}else{
			return array();
		}
	}
}
?>