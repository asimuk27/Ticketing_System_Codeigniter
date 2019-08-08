<?php
class Donation_model extends CI_Model
{
	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->config->load('dbtables', TRUE);		
	}

	function view_champion_by_id($id){
		$query = "SELECT message,fundraising_image,champ.title,champ.id,image_path,display_name,target_amount,charity_name,eve_de.title as event_name,champ.created_date";
		$query .= " FROM ".$this->config->item('ems_champions','dbtables')." champ";	
		$query .= " INNER JOIN ".$this->config->item('ems_users','dbtables')." eo ON eo.id = champ.creator_id ";
		$query .= " INNER JOIN ".$this->config->item('ems_organisers_details','dbtables')." cha_de ON cha_de.organization_id = champ.charity_id ";
		$query .= " INNER JOIN ".$this->config->item('ems_events','dbtables')." eve_de ON eve_de.id = champ.event_id ";
		$query .= " WHERE champ.id = '$id'";
		$res   = $this->db->query($query);
		$resArr = $res->result_array();
		
		if(count($resArr) > 0){
			return $resArr[0];
		}else{
			return false;
		}
	}
	
	function save_donation($data){
		$result = $this->db->insert($this->config->item('ems_donations','dbtables'), $data);
		$insert_id = $this->db->insert_id();
		
		return  $insert_id;
	}
	
	function amount_given($id){
		$query = "SELECT count(id) as donation_no, sum(donation_amount) as given";
		$query .= " FROM ".$this->config->item('ems_donations','dbtables');		
		$query .= " WHERE champion_page_id = $id";
		$query .= " GROUP BY champion_page_id";
		$res   = $this->db->query($query);
		$resArr = $res->result_array();
		
		if(count($resArr) > 0){
			return $resArr;
		}else{
			return false;
		}				
	}
	
	function get_donation_by_champion_id($id){
		$query = "SELECT *";
		$query .= " FROM ".$this->config->item('ems_donations','dbtables');		
		$query .= " WHERE champion_page_id = '$id' AND status = 1";
		$res   = $this->db->query($query);
		$resArr = $res->result_array();
		
		if(count($resArr) > 0){
			return $resArr;
		}else{
			$resArr = array();
			return $resArr;
		}
	}
	
	
	function get_user_information($id){
		$query = "SELECT first_name,email,phone_no,street_address,city,country,suburb,postcode";
		$query .= " FROM ".$this->config->item('ems_users','dbtables');		
		$query .= " WHERE id = '$id'";
		
		$res   = $this->db->query($query);
		$resArr = $res->result_array();
		
		if(count($resArr) > 0){
			return $resArr[0];
		}else{
			return false;
		}
	}
	
	function get_organizer_information($id){
		$query = "SELECT first_name,last_name,email,phone as phone_no,fax";
		$query .= " FROM ".$this->config->item('ems_organisers','dbtables');		
		$query .= " WHERE id = '$id'";
	
		$res   = $this->db->query($query);
		$resArr = $res->result_array();
		
		if(count($resArr) > 0){
			return $resArr[0];
		}else{
			return false;
		}
	}
	
	function get_information_by_order_id($order_id){
		$query = "SELECT *";
		$query .= " FROM ".$this->config->item('ems_payment_history','dbtables');		
		$query .= " WHERE order_id = '$order_id'";
		
		$res   = $this->db->query($query);
		$resArr = $res->result_array();
		
		if(count($resArr) > 0){
			return $resArr[0];
		}else{
			return false;
		}
	}
	
	
	function get_charity_information_by_order_id($order_id){
		$query = "SELECT donate.salutation as salute,c.signature,c.position,c.first_name,c.last_name,b.charity_name,c.receipt_text,b.street_address,b.city,b.region,b.postal_code,b.country,a.email,donate.first_name as donar_first_name,b.charity_overview,b.logo,events.donation_receipt_text,c.signature_text,a.registration_number";
		
		$query .= " FROM " .$this->config->item('ems_organisers','dbtables'). " as a";	
		$query .= " INNER JOIN " . $this->config->item('ems_organisers_details','dbtables'). " as b";
		$query .= " ON a.id = b.organization_id";	
		$query .= " INNER JOIN " . $this->config->item('ems_organisers_finance','dbtables'). " as c";
		$query .= " ON a.id = c.organization_id";
		$query .= " INNER JOIN " . $this->config->item('ems_champions','dbtables'). " as champ";
		$query .= " ON a.id = champ.charity_id";
		$query .= " INNER JOIN " . $this->config->item('ems_donations','dbtables'). " as donate";
		$query .= " ON champ.id = donate.champion_page_id";
		$query .= " INNER JOIN " . $this->config->item('ems_events','dbtables'). " as events";
		$query .= " ON events.id = champ.event_id";
		
		$query .= " WHERE donate.order_id = '$order_id'";
		$query .= " GROUP BY a.id";

		$res   = $this->db->query($query);
		$resArr = $res->result_array();
		
		return $resArr['0'];
	}
	
	//get charity id based on champion id
	function get_organizer_id($id = NULL){
		$query = "SELECT charity_id";
		$query .= " FROM " . $this->config->item('ems_champions','dbtables');
		$query .= " WHERE id = $id";
		
		$res   = $this->db->query($query);
		$resArr = $res->result_array();
		
		if(count($resArr) > 0){
			return $resArr[0]['charity_id'];
		}else{
			return array();
		}
	}
	
	//get charity id based on champion id
	function get_organizer_by_order_id($order_id = NULL){
		$query = "SELECT organiser_id";
		$query .= " FROM " . $this->config->item('ems_payment_history','dbtables');
		$query .= " WHERE order_id = $order_id";
		
		$res   = $this->db->query($query);
		$resArr = $res->result_array();
		
		if(count($resArr) > 0){
			return $resArr[0]['organiser_id'];
		}else{
			return array();
		}
	}
	
	function get_event_details_by_order_id($order_id){
		$query = "SELECT charity_name,event.title,donate.order_id";
		
		$query .= " FROM " . $this->config->item('ems_organisers_details','dbtables'). " as org";
		$query .= " INNER JOIN " . $this->config->item('ems_champions','dbtables'). " as champ";
		$query .= " ON org.organization_id = champ.charity_id";
		$query .= " INNER JOIN " . $this->config->item('ems_donations','dbtables'). " as donate";
		$query .= " ON champ.id = donate.champion_page_id";
		$query .= " INNER JOIN " . $this->config->item('ems_events','dbtables'). " as event";
		$query .= " ON event.id = champ.event_id";
		
		$query .= " WHERE donate.order_id = '$order_id'";
		$query .= " GROUP BY org.id";

		
		$res   = $this->db->query($query);
		$resArr = $res->result_array();
		
		return $resArr['0'];
	}
	
	function get_champion_id_by_order_id($order_id){
		$query = "SELECT champion_page_id";
		$query .= " FROM " . $this->config->item('ems_donations','dbtables');
		$query .= " WHERE order_id = $order_id";
		
		$res   = $this->db->query($query);
		$resArr = $res->result_array();
		
		if(count($resArr) > 0){
			return $resArr[0]['champion_page_id'];
		}else{
			return array();
		}
	}
	
	function get_donar_info($order_id,$id){
		$query = "SELECT *";
		$query .= " FROM ".$this->config->item('ems_donations','dbtables')." champ";			
		$query .= " WHERE champ.champion_page_id = '$id' AND champ.order_id = '$order_id'";
		$res   = $this->db->query($query);
		$resArr = $res->result_array();
		
		if(count($resArr) > 0){
			return $resArr[0];
		}else{
			return array();;
		}
	}
}