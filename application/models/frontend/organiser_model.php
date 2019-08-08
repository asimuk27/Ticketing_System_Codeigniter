<?php
class Organiser_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->config->load('dbtables', TRUE);		
	}
	
		
	function save_organiser($data){
		$result = $this->db->insert($this->config->item('ems_organisers','dbtables'), $data);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}
	
	function save_organiser_additional_details($data){
		$result = $this->db->insert($this->config->item('ems_organisers_details','dbtables'), $data);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}
	
	function save_organiser_areas($data){
		$result = $this->db->insert($this->config->item('ems_organiser_areas','dbtables'), $data);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}
		
	function save_organiser_finance_details($data){
		$result = $this->db->insert($this->config->item('ems_organisers_finance','dbtables'), $data);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}
	
	function get_organisation_details_by_id($id = null){
		$query = "SELECT areas,organization_nature,donee_status,charities_commission,	registration_number,a.preferred_name,a.id as id, a.title as title,a.salutation as salutation,a.first_name as first_name,a.last_name as last_name,a.email as email,a.phone as phone,a.fax as fax,b.organization_name as organization_name,b.ird_number as ird_number,b.charity_name as charity_name,b.charity_overview as charity_overview,b.street_address as street_address,b.city as city,b.region as region,b.postal_code as postal_code,b.country as country,c.position as finance_position,c.first_name as finance_first_name,c.last_name as finance_last_name,c.email as finance_email,c.phone as finance_phone,c.fax as finance_fax,bank_details,bank_name,receipt_text,signature,c.signature_text as sign_text,bank_statement,logo,bank_name_for_ticket_suite,account_number_ticket_suite,bank_statement_ticket_suite,plan_select";
		
		$query .= " FROM " .$this->config->item('ems_organisers','dbtables'). " as a";	
		$query .= " INNER JOIN " . $this->config->item('ems_organisers_details','dbtables'). " as b";
		$query .= " ON a.id = b.organization_id";	
		$query .= " INNER JOIN " . $this->config->item('ems_organisers_finance','dbtables'). " as c";
		$query .= " ON a.id = c.organization_id";	
		$query .= " WHERE a.id = '$id'";
		$query .= " GROUP BY a.id";

		$res   = $this->db->query($query);
		$resArr = $res->result_array();
		
		return $resArr['0'];
	}
	
	function update_organiser($data){		
		$this->db->where('id', $data['id']);
		$queryResult = $this->db->update($this->config->item('ems_organisers','dbtables'), $data);	
		
		return $queryResult;
	}
	
	function update_organiser_additional_details($data){		
		$this->db->where('organization_id', $data['organization_id']);
		$queryResult = $this->db->update($this->config->item('ems_organisers_details','dbtables'), $data);	
		return $queryResult;
	}
	
		
	function update_organiser_finance_details($data){
		$this->db->where('organization_id', $data['organization_id']);
		$queryResult = $this->db->update($this->config->item('ems_organisers_finance','dbtables'), $data);	
		return $queryResult;
	}
	
	// function to check if email exist during registration
	function isEmailPresent($email = NULL){			
		$query  = " SELECT id";
		$query .= " FROM " . $this->config->item('ems_organisers','dbtables');
		$query .= " WHERE email = ? ";		
		$dataBindArr = array($email);
		$res = $this->db->query($query, $dataBindArr);
		$resArr = $res->result();		
		return count($resArr);
	}
	
	// function to check if email exist during registration
	function isCharityNamePresent($name = NULL){			
		$query  = " SELECT id";
		$query .= " FROM " . $this->config->item('ems_organisers_details','dbtables');
		$query .= " WHERE charity_name = ? ";		
		$dataBindArr = array($name);
		$res = $this->db->query($query, $dataBindArr);
		$resArr = $res->result();		
		return count($resArr);
	}
	
	// function to check if email exist during registration
	function get_charity_details($name = NULL){			
		$query  = " SELECT organization_id,charity_name,charity_overview";
		$query .= " FROM " . $this->config->item('ems_organisers_details','dbtables');
		$query .= " WHERE charity_name = ? ";		
		$dataBindArr = array($name);
		$res = $this->db->query($query, $dataBindArr);
		$resArr = $res->result();		
		
		if(count($resArr) > 0){
			return $resArr[0];
		}else{
			return false;
		}
	}

	function get_event_tickets($event_id){
		$query  = " SELECT event_id,price";
		$query .= " FROM ticket_generated"; 
		$query .= " WHERE event_id=".$event_id."";	
		$res   = $this->db->query($query);
		$resArr = $res->result_array();
		
		if(count($resArr) > 0){
			return $resArr;
		}else{
			return false;
		}
	}

	function get_event_tickets_on_subevents($sub_event_id){
		$query  = " SELECT event_id,price";
		$query .= " FROM ticket_generated"; 
		$query .= " WHERE sub_event_id=".$sub_event_id."";	
		$res   = $this->db->query($query);
		$resArr = $res->result_array();
		
		if(count($resArr) > 0){
			return $resArr;
		}else{
			return false;
		}
	}


	/*function get_donations($event_id){
		$query  = " SELECT event_id,donation_amount";
		$query .= " FROM event_donations"; 
		$query .= " WHERE event_id=".$event_id."";	
		$res   = $this->db->query($query);
		$resArr = $res->result_array();
		
		if(count($resArr) > 0){
			return $resArr;
		}else{
			return false;
		}
	}

	function get_donations_on_subevents($sub_event_id){
		$query  = " SELECT event_id,donation_amount";
		$query .= " FROM event_donations"; 
		$query .= " WHERE sub_event_id=".$sub_event_id."";	
		$res   = $this->db->query($query);
		$resArr = $res->result_array();
		
		if(count($resArr) > 0){
			return $resArr;
		}else{
			return false;
		}
	}*/

	function get_all_tickets($event_id){
		$query  = " SELECT ticket_id";
		$query .= " FROM ticket_generated"; 
		$query .= " WHERE event_id=".$event_id;	
		$res   = $this->db->query($query);
		$resArr = $res->result_array();
        
        $free=0;
        $paid=0;
        $donation=0;
		
       
		foreach($resArr as $ticket_looper){
			$query  = " SELECT ticket_type_id";
		    $query .= " FROM tickets_master"; 
		    $query .= " WHERE id=".$ticket_looper['ticket_id'];	
		    $res   = $this->db->query($query);
		    $resArr = $res->result_array();

		    if($resArr[0]['ticket_type_id']==2){
              $free++;
		    }else if($resArr[0]['ticket_type_id']==1){
              $paid++;
		    }else{
              $donation++;
		    }

		    
		}
		
		 $all_tickets_count=array('paid'=>$paid,'free'=>$free,'donation'=>$donation);
		 return $all_tickets_count;
	}

	function get_all_tickets_on_subevents($sub_event_id){
		$query  = " SELECT ticket_id";
		$query .= " FROM ticket_generated"; 
		$query .= " WHERE sub_event_id=".$sub_event_id;	
		$res   = $this->db->query($query);
		$resArr = $res->result_array();
        
        $free=0;
        $paid=0;
        $donation=0;
		
       
		foreach($resArr as $ticket_looper){
			$query  = " SELECT ticket_type_id";
		    $query .= " FROM tickets_master"; 
		    $query .= " WHERE id=".$ticket_looper['ticket_id'];	
		    $res   = $this->db->query($query);
		    $resArr = $res->result_array();

		    if($resArr[0]['ticket_type_id']==2){
              $free++;
		    }else if($resArr[0]['ticket_type_id']==1){
              $paid++;
		    }else{
              $donation++;
		    }

		    
		}
		
		 $all_tickets_count=array('paid'=>$paid,'free'=>$free,'donation'=>$donation);
		 return $all_tickets_count;
	}

	

	function get_pending_tickets($event_id){
		$query  = " SELECT DISTINCT sub_event_id";
		$query .= " FROM ticket_generated"; 
		$query .= " WHERE event_id=".$event_id;	
		$res   = $this->db->query($query);
		$resArr = $res->result_array();
		 $count_free_pending=0;
		 $count_paid_pending=0;
		 $count_donation_pending=0;
         

		if(count($resArr) > 0){
			foreach($resArr as $sub_event_id){
				    
                   	$query1  = " SELECT quantity_available";
		            $query1 .= " FROM tickets_master"; 
		            $query1 .= " WHERE ticket_type_id=2 AND sub_event_id=".$sub_event_id['sub_event_id'];	
		            $res2   = $this->db->query($query1);
		            $resArr2 = $res2->result_array(); 

		           if(count($resArr2) > 0){
                     $count_free_pending = $count_free_pending+$resArr2[0]['quantity_available'];

		           }

		           	$query2  = " SELECT quantity_available";
		            $query2 .= " FROM tickets_master"; 
		            $query2 .= " WHERE ticket_type_id=1 AND sub_event_id=".$sub_event_id['sub_event_id'];	
		            $res3   = $this->db->query($query2);
		            $resArr3 = $res3->result_array(); 

		           if(count($resArr3) > 0){
                     $count_paid_pending = $count_paid_pending+$resArr3[0]['quantity_available'];

		           }

		            $query3  = " SELECT quantity_available";
		            $query3 .= " FROM tickets_master"; 
		            $query3 .= " WHERE ticket_type_id=3 AND sub_event_id=".$sub_event_id['sub_event_id'];	
		            $res4   = $this->db->query($query3);
		            $resArr4 = $res4->result_array(); 

		           if(count($resArr4) > 0){
                     $count_donation_pending = $count_donation_pending+$resArr4[0]['quantity_available'];

		           }
			}
			//echo $count_free_pending."<br>".$count_paid_pending."<br>".$count_free_pending;exit;

			$tickets_pending=array('pending_free_tickets'=>$count_free_pending,'pending_paid_tickets'=>$count_paid_pending,'pending_donation_tickets'=>$count_donation_pending);

			return $tickets_pending;
		}else{
			return false;
		}
	}

	function get_pending_tickets_on_subevents($sub_event_id){
		$count_paid_pending=0;
		$count_donation_pending =0;
		$count_free_pending=0;
               	$query1  = " SELECT quantity_available";
		            $query1 .= " FROM tickets_master"; 
		            $query1 .= " WHERE ticket_type_id=2 AND sub_event_id=".$sub_event_id;	
		            $res2   = $this->db->query($query1);
		            $resArr2 = $res2->result_array(); 

		           if(count($resArr2) > 0){
                     $count_free_pending = $count_free_pending+$resArr2[0]['quantity_available'];
                    // echo $count_free_pending;exit;

		           }

		           	$query2  = " SELECT quantity_available";
		            $query2 .= " FROM tickets_master"; 
		            $query2 .= " WHERE ticket_type_id=1 AND sub_event_id=".$sub_event_id;	
		            $res3   = $this->db->query($query2);
		            $resArr3 = $res3->result_array(); 

		           if(count($resArr3) > 0){
                     $count_paid_pending = $count_paid_pending+$resArr3[0]['quantity_available'];

		           }

		            $query3  = " SELECT quantity_available";
		            $query3 .= " FROM tickets_master"; 
		            $query3 .= " WHERE ticket_type_id=3 AND sub_event_id=".$sub_event_id;	
		            $res4   = $this->db->query($query3);
		            $resArr4 = $res4->result_array(); 

		           if(count($resArr4) > 0){
                     $count_donation_pending = $count_donation_pending+$resArr4[0]['quantity_available'];

		           }

		           $tickets_pending=array('pending_free_tickets'=>$count_free_pending,'pending_paid_tickets'=>$count_paid_pending,'pending_donation_tickets'=>$count_donation_pending);

			        return $tickets_pending;
	}

	public function set_dropdown_data($event_id){
        $query  = " SELECT id, schedule_title";
		$query .= " FROM sub_events"; 
		$query .= " WHERE event_id=".$event_id;	
		$res   = $this->db->query($query);
		$resArr = $res->result_array();



		if(count($resArr) > 0){
			return $resArr;
		}else{
			return false;
		}
	}

	public function get_event_info($event_id){
		$query  = " SELECT *";
		$query .= " FROM event_master"; 
		$query .= " WHERE id=".$event_id;	
		$res   = $this->db->query($query);
		$resArr = $res->result_array();



		if(count($resArr) > 0){
			return $resArr[0];
		}else{
			return false;
		}
	}

	public function get_terms_and_conditions($key){
		$query  = " SELECT *";
		$query .= " FROM terms_and_conditions"; 
		$query .= " WHERE key_name='".$key."'";	
		$res   = $this->db->query($query);
		$resArr = $res->result_array();



		if(count($resArr) > 0){
			return $resArr;
		}else{
			return false;
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
	
	public function save_terms_n_conditions($data_save_tc){
		$result = $this->db->insert("organizer_terms_conditions", $data_save_tc);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
		
	}

	public function get_organiser_terms_n_conditions($id){
        $query  = " SELECT *";
		$query .= " FROM organizer_terms_conditions"; 
		$query .= " WHERE organizer_id='".$id."'"; 
		$res   = $this->db->query($query);
		$resArr = $res->result_array();

		if(count($resArr) > 0){
			return $resArr;
		}else{
			return false;
		}
	}

	function update_save_terms_n_conditions($data){
        $query  = " SELECT id";
		$query .= " FROM organizer_terms_conditions"; 
		$query .= " WHERE organizer_id=".$data['organizer_id']." AND key_name='".$data['key_name']."'"; 
		$res   = $this->db->query($query);
		$resArr = $res->result_array();

		if(count($resArr) > 0){
			 $this->db->where('organizer_id', $data['organizer_id']);
			 $this->db->where('key_name', $data['key_name']);
	    	 $queryResult = $this->db->update("organizer_terms_conditions", $data);	
		     return $queryResult;
		}else{		    
		    $result = $this->db->insert("organizer_terms_conditions", $data);
		    $insert_id = $this->db->insert_id();
		    return  $insert_id;
		}
	}
	
	function get_email_by_key($key){
		$query  = " SELECT id";
		$query .= " FROM " . $this->config->item('ems_organisers','dbtables');
		$query .= " WHERE md5(email) = ? ";		
		$dataBindArr = array($key);
		$res = $this->db->query($query, $dataBindArr);
		$resArr = $res->result();		
		
		if(count($resArr > 0)){
			return $resArr['0']->id;
		}else{
			return array();
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
	
	function check_in_complete_status($email){
		$query  = " SELECT id";
		$query .= " FROM " . $this->config->item('ems_organisers','dbtables');
		$query .= " WHERE id = '$email' AND in_complete = 0";		
		$res = $this->db->query($query);
		$resArr = $res->result();		
	
		if(count($resArr > 0)){
			return $resArr['0']->id;
		}else{
			return array();
		}	
	}
	
	function check_profile_org_password($password){		
		$id = $this->session->userdata['logged_in']['id'];		
		$query  = " SELECT id";
		$query .= " FROM " . $this->config->item('ems_organisers','dbtables');
		$query .= " WHERE id = $id AND password = '".md5($password)."'";				
		$res = $this->db->query($query);
		$resArr = $res->result();		
		return count($resArr);
	}
	
	public function update_password($password){
		$data=array('password'=>md5($password));
		$this->db->where('id',$this->session->userdata['logged_in']['id']);
		$result = $this->db->update($this->config->item('ems_organisers','dbtables'),$data);
		return $result;
	}
	
	function authenticate_reg_email($email){
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

	function update_organiser_email($email,$id){
		$session_data=$this->session->userdata['logged_in'];

		if(isset($session_data['id'])){
			$data = array('email'=>$email);
			$this->db->where('id', $session_data['id']);
			$this->db->update($this->config->item('ems_organisers','dbtables'), $data);
			return true;
		}else{
			return false;	
		}
	}
}

?>