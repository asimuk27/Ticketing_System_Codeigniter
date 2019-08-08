<?php
class Champion_model extends CI_Model
{
	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->config->load('dbtables', TRUE);		
	}
	
	function get_organisations(){
		$query = "SELECT a.id,b.charity_name";		
		$query .= " FROM " .$this->config->item('ems_organisers','dbtables'). " as a";	
		$query .= " INNER JOIN " . $this->config->item('ems_organisers_details','dbtables'). " as b";
		$query .= " ON a.id = b.organization_id";	
		$query .= " INNER JOIN " . $this->config->item('ems_organisers_finance','dbtables'). " as c";
		$query .= " ON a.id = c.organization_id WHERE a.status = 1";	
		$query .= " GROUP BY a.id";

		$res   = $this->db->query($query);
		$resArr = $res->result_array();
		
		if(count($resArr) > 0){
			return $resArr;
		}else{
			return false;
		}
		
	}

		function get_all_events_for_champions($id){
		$query = "SELECT ee.id,ee.title";
		$query .= " FROM ".$this->config->item('ems_events','dbtables')." ee";	
		$query .= " INNER JOIN ".$this->config->item('ems_organisers','dbtables')." eo ON eo.id = ee.organiser_id ";
		$query .= " WHERE ee.status = 1 AND ee.organiser_id = $id";
		$res   = $this->db->query($query);
		$resArr = $res->result_array();
		
		if(count($resArr) > 0){
			return $resArr;
		}else{
			return false;
		}	
	}
	
	function get_all_events($id){
		$query = "SELECT ee.id,ee.title";
		$query .= " FROM ".$this->config->item('ems_events','dbtables')." ee";	
		$query .= " INNER JOIN ".$this->config->item('ems_organisers','dbtables')." eo ON eo.id = ee.organiser_id ";
		$query .= " WHERE ee.organiser_id = $id";
		$res   = $this->db->query($query);
		$resArr = $res->result_array();
		
		if(count($resArr) > 0){
			return $resArr;
		}else{
			return false;
		}	
	}
	
	function get_charity_name_by_id($id){
		$query = "SELECT id,charity_name";
		$query .= " FROM ".$this->config->item('ems_organisers_details','dbtables');		
		$query .= " WHERE organization_id = '$id'";
					
		$res   = $this->db->query($query);
		$resArr = $res->result_array();
			
		if(count($resArr) > 0){
			return $resArr[0]['charity_name'];
		}else{
			return false;
		}	
	}
	
	function get_event_name_by_id($id){
		$query = "SELECT id,title";
		$query .= " FROM ".$this->config->item('ems_events','dbtables');		
		$query .= " WHERE id = '$id'";
					
		$res   = $this->db->query($query);
		$resArr = $res->result_array();
			
		if(count($resArr) > 0){
			return $resArr[0]['title'];
		}else{
			return false;
		}	
	}
	
	
	function get_all_champion_listing(){

		$query = "SELECT distinct(a.id),image_path,facebook_image_path,display_name,target_amount,charity_name,b.title,a.created_date,SUM(eve_don.donation_amount) as raised_amount,fundraising_image";
		
		$query .= " FROM " .$this->config->item('ems_champions','dbtables'). " as a";	
		$query .= " INNER JOIN " . $this->config->item('ems_events','dbtables'). " as b";		
		$query .= " ON a.event_id = b.id";	
		$query .= " INNER JOIN ".$this->config->item('ems_users','dbtables')." d ON d.id = a.creator_id ";
		$query .= " INNER JOIN " . $this->config->item('ems_organisers_details','dbtables'). " as c";
		$query .= " ON a.charity_id = c.organization_id";
		$query .= " LEFT JOIN ".$this->config->item('ems_donations','dbtables')." eve_don ON eve_don.champion_page_id = a.id ";
		
		$query .= " WHERE 1 ";

		
		 /*   $query = "SELECT distinct(champ.id),image_path,facebook_image_path,display_name,target_amount,charity_name,eve_de.title,champ.created_date,SUM(eve_don.donation_amount) as raised_amount,champ.fundraising_image";
			$query .= " FROM ".$this->config->item('ems_champions','dbtables')." champ";	
			$query .= " INNER JOIN ".$this->config->item('ems_users','dbtables')." eo ON eo.id = champ.creator_id ";		
			$query .= " INNER JOIN ".$this->config->item('ems_organisers_details','dbtables')." cha_de ON cha_de.organization_id = champ.charity_id ";
			$query .= " INNER JOIN ".$this->config->item('ems_events','dbtables')." eve_de ON eve_de.id = champ.event_id ";
			$query .= " INNER JOIN ".$this->config->item('ems_donations','dbtables')." eve_don ON eve_don.champion_page_id = champ.id ";			
			*/
		//	$query .= " WHERE champ.id IN ($ids) ORDER BY FIELD(champ.id,$ids)";

			
			$res   = $this->db->query($query);
			$resArr = $res->result_array();

				return $resArr;			
		}
	
	function search($search_values = NULL){
		$query = "SELECT distinct(a.id),image_path,facebook_image_path,display_name,target_amount,charity_name,b.title,a.created_date,fundraising_image";
		
		$query .= " FROM " .$this->config->item('ems_champions','dbtables'). " as a";	
		$query .= " INNER JOIN " . $this->config->item('ems_events','dbtables'). " as b";		
		$query .= " ON a.event_id = b.id";	
		$query .= " INNER JOIN ".$this->config->item('ems_users','dbtables')." d ON d.id = a.creator_id ";
		$query .= " INNER JOIN " . $this->config->item('ems_organisers_details','dbtables'). " as c";
		$query .= " ON a.charity_id = c.organization_id";
		//$query .= " LEFT JOIN ".$this->config->item('ems_donations','dbtables')." eve_don ON eve_don.champion_page_id = a.id ";
		
		$query .= " WHERE 1 AND d.status = 1 AND a.status = 1 AND a.delete_status = 0";
		
		if((!empty($search_values['champion_name']))){			
	    	$query .= " AND a.display_name LIKE '%".$search_values['champion_name']."%'";							
		}
		
		if((!empty($search_values['organization_name']))){			
	    	$query .= " AND c.charity_name LIKE '%".$search_values['organization_name']."%'";							
		}
		
		if((!empty($search_values['event_name']))){			
	    	$query .= " AND b.title LIKE '%".$search_values['event_name']."%'";							
		}
		
		
		$query .= " GROUP BY a.id ORDER BY display_name ASC";
		
		$res   = $this->db->query($query);
		$resArr = $res->result_array();
		
		return $resArr;
	}
	
	function get_raised_donation($champ_id){
		$query = "SELECT id,champion_page_id,SUM(donation_amount) AS raised_amount";
		$query .= " FROM ".$this->config->item('ems_donations','dbtables');
		$query .= " WHERE status = 1 AND champion_page_id= $champ_id AND donation_amount is NOT NULL";
		
		$res   = $this->db->query($query);
		
		$resArr = $res->result_array();		
		
		if(count($resArr > 0)){
			if($resArr[0]['raised_amount']){
				return $resArr[0]['raised_amount'];
			}else{
				return 0;
			}	
		}else{
			return 0;	
		}		
	}
	
	function view_champion_by_id($id){
		$query = "SELECT eve_de.status as event_status,event_description,message,fundraising_image,champ.title,champ.id,image_path,display_name,target_amount,charity_name,eve_de.title as event_name,champ.created_date,champ.status,eve_de.id as event_id,champ.delete_status";
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
	
	function get_user_profie($type,$id){
		if($type == 1){
			$query = "SELECT organization_id as id,logo";
			$query .= " FROM ".$this->config->item('ems_organisers_details','dbtables');		
			$query .= " WHERE organization_id = $id";
					
			$res   = $this->db->query($query);
			$resArr = $res->result_array();
			
			if(count($resArr) > 0){
				return $resArr;
			}else{
				return false;
			}	
		}else if($type == 0){
			$query = "SELECT id,image_path,facebook_image_path";
			$query .= " FROM ".$this->config->item('ems_users','dbtables');		
			$query .= " WHERE id = $id";
			$res   = $this->db->query($query);
			$resArr = $res->result_array();
			
			if(count($resArr) > 0){
				return $resArr;
			}else{
				return false;
			}	
		}else{
			return false;
		}
	}
	
	function get_all_sub_events($id){
		$query = "SELECT id,schedule_title";
		$query .= " FROM ".$this->config->item('ems_sub_events','dbtables');		
		$query .= " WHERE event_id = $id AND is_support_allowed = 1";
		$res   = $this->db->query($query);
		$resArr = $res->result_array();
		
		if(count($resArr) > 0){
			return $resArr;
		}else{
			return false;
		}	
	}
	
	function save_champion($data){
		$result = $this->db->insert($this->config->item('ems_champions','dbtables'), $data);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}
	
	function list_manage_champions($id)
		{
		       $query = "SELECT champ.id,image_path,facebook_image_path,display_name,target_amount,charity_name,eve_de.title,champ.created_date, champ.title, champ.fundraising_image,champ.status";
			 	 $query .= " FROM ".$this->config->item('ems_champions','dbtables')." champ";	
				$query .= " INNER JOIN ".$this->config->item('ems_users','dbtables')." eo ON eo.id = champ.creator_id ";
				$query .= " INNER JOIN ".$this->config->item('ems_organisers_details','dbtables')." cha_de ON cha_de.organization_id = champ.charity_id ";
				$query .= " INNER JOIN ".$this->config->item('ems_events','dbtables')." eve_de ON eve_de.id = champ.event_id ";
			$query .= " WHERE champ.creator_id = ".$id;

				
				$res   = $this->db->query($query);
				$resArr = $res->result_array();

				//print_r($resArr);exit;

				return $resArr;
			

		}

		function user_champion_events($id)
		{
			    $query = "SELECT eve_de.title";
			 	$query .= " FROM ".$this->config->item('ems_champions','dbtables')." champ";	
				$query .= " INNER JOIN ".$this->config->item('ems_events','dbtables')." eve_de ON eve_de.id = champ.event_id ";
		    	$query .= " WHERE champ.creator_id = ".$id;

				
				$res   = $this->db->query($query);
				$resArr = $res->result_array();

				//print_r($resArr);exit;

				return $resArr;
		}

		function event_based_listing($id, $event_name)
		{
			    $query = "SELECT champ.id,image_path,facebook_image_path,display_name,target_amount,charity_name,eve_de.title,champ.created_date, champ.title, champ.fundraising_image,champ.status";
			 	$query .= " FROM ".$this->config->item('ems_champions','dbtables')." champ";	
				$query .= " INNER JOIN ".$this->config->item('ems_users','dbtables')." eo ON eo.id = champ.creator_id ";
				$query .= " INNER JOIN ".$this->config->item('ems_organisers_details','dbtables')." cha_de ON cha_de.organization_id = champ.charity_id ";
				$query .= " INNER JOIN ".$this->config->item('ems_events','dbtables')." eve_de ON eve_de.id = champ.event_id ";
			    $query .= " WHERE champ.creator_id = ".$id." AND eve_de.title='".$event_name."'";

				
				$res   = $this->db->query($query);
				$resArr = $res->result_array();

				//print_r($resArr);exit;

				return $resArr;
		}

		function list_events($id)
		{
			$query = "SELECT id, title";
		   	$query .= " FROM ".$this->config->item('ems_events','dbtables');		
			$query .= " WHERE organiser_id = $id";
			$res   = $this->db->query($query);
			$resArr = $res->result_array();
			
			if(count($resArr) > 0){
				return $resArr;
			}else{
				return false;
			}	
		}

		function list_sub_events($event_id)
		{
			$query = "SELECT id, schedule_title";
		   	$query .= " FROM ".$this->config->item('ems_sub_events','dbtables');		
			$query .= " WHERE event_id = $event_id";
			$res   = $this->db->query($query);
			$resArr = $res->result_array();
			
			if(count($resArr) > 0){
				return $resArr;
			}else{
				return false;
			}	
		}

		function approve_champion_list($id)
		{
			   $query = "SELECT champ.id,image_path,facebook_image_path,display_name,target_amount,charity_name,eve_de.title,champ.created_date, champ.title as champ_title, champ.fundraising_image,champ.status, champ.charity_id";
			 	$query .= " FROM ".$this->config->item('ems_champions','dbtables')." champ";	
				$query .= " INNER JOIN ".$this->config->item('ems_users','dbtables')." eo ON eo.id = champ.creator_id ";
				$query .= " INNER JOIN ".$this->config->item('ems_organisers_details','dbtables')." cha_de ON cha_de.organization_id = champ.charity_id ";
				$query .= " INNER JOIN ".$this->config->item('ems_events','dbtables')." eve_de ON eve_de.id = champ.event_id ";
			    $query .= " WHERE champ.charity_id = ".$id." ORDER BY champ.id DESC";

				
				$res   = $this->db->query($query);
				$resArr = $res->result_array();
              

				return $resArr;
		}

		function approved_selected_champion_list($eid, $sub_eid = NULL, $status = NULL, $org_id)
		{
			    $query = "SELECT champ.id,image_path,facebook_image_path,display_name,target_amount,charity_name,eve_de.title,champ.created_date, champ.title as champ_title, champ.fundraising_image,champ.status, champ.charity_id, champ.target_amount";
			 	$query .= " FROM ".$this->config->item('ems_champions','dbtables')." champ";	
				$query .= " INNER JOIN ".$this->config->item('ems_users','dbtables')." eo ON eo.id = champ.creator_id ";
				$query .= " INNER JOIN ".$this->config->item('ems_organisers_details','dbtables')." cha_de ON cha_de.organization_id = champ.charity_id ";
				$query .= " INNER JOIN ".$this->config->item('ems_events','dbtables')." eve_de ON eve_de.id = champ.event_id ";
				$query .= " WHERE champ.charity_id = ".$org_id." AND champ.event_id='".$eid."'";
				
				if($sub_eid){
					$query .= "AND champ.sub_event_id='".$sub_eid."'";					
				}
				
				if($status){
					$query .= "AND champ.status='".$status."'";
				}	
				
				$query .= "ORDER BY champ.id DESC";				
				$res   = $this->db->query($query);
				$resArr = $res->result_array();             

				return $resArr;
		}


		function get_selected_subevent($sub_eid){
			$query = "SELECT *";
			$query .= " FROM sub_events";	
			$query .= " WHERE id=".$sub_eid;

			$res = $this->db->query($query);
			$resArr = $res->result_array();
              
			 if(!empty($resArr)){
				 return $resArr;
			 }else{
				 $resArr = array();
				 return $resArr;
			 }
		}
		
		function update_fundraising_status($data){
			$this->db->where('id', $data['id']);
			$queryResult = $this->db->update($this->config->item('ems_champions','dbtables'), $data);		
			return $queryResult;			
		}
		
		function load_event_names($loggedin_id)
		{
			$query = "SELECT eve_de.title";
			$query .= " FROM ".$this->config->item('ems_champions','dbtables')." champ";	
			$query .= " INNER JOIN ".$this->config->item('ems_events','dbtables')." eve_de ON eve_de.id = champ.event_id ";
			$query .= " WHERE champ.creator_id =".$loggedin_id;

			$res   = $this->db->query($query);
				$resArr = $res->result_array();
              

			return $resArr;
		}

		function champion_listing_for_mychamions($loggedin_id){
			    $query = "SELECT champ.id,image_path,facebook_image_path,display_name,target_amount,charity_name,eve_de.title,champ.created_date, champ.title as champ_title, champ.fundraising_image,champ.status, champ.charity_id,champ.delete_status, champ.target_amount,original_event_image";
			 	$query .= " FROM ".$this->config->item('ems_champions','dbtables')." champ";	
				$query .= " INNER JOIN ".$this->config->item('ems_users','dbtables')." eo ON eo.id = champ.creator_id ";
				$query .= " INNER JOIN ".$this->config->item('ems_organisers_details','dbtables')." cha_de ON cha_de.organization_id = champ.charity_id ";
				$query .= " INNER JOIN ".$this->config->item('ems_events','dbtables')." eve_de ON eve_de.id = champ.event_id ";
			    $query .= " WHERE champ.creator_id=".$loggedin_id." ORDER BY champ.id DESC";

				
				$res   = $this->db->query($query);
				$resArr = $res->result_array();


              

				return $resArr;
		}

		public function champion_listing_on_search($status, $event_name, $user_id){

			    $query = "SELECT champ.id,image_path,facebook_image_path,display_name,target_amount,charity_name,eve_de.title,champ.created_date, champ.title as champ_title, champ.fundraising_image,champ.status, champ.charity_id, champ.target_amount,original_event_image";
			 	$query .= " FROM ".$this->config->item('ems_champions','dbtables')." champ";	
				$query .= " INNER JOIN ".$this->config->item('ems_users','dbtables')." eo ON eo.id = champ.creator_id ";
				$query .= " INNER JOIN ".$this->config->item('ems_organisers_details','dbtables')." cha_de ON cha_de.organization_id = champ.charity_id ";
				$query .= " INNER JOIN ".$this->config->item('ems_events','dbtables')." eve_de ON eve_de.id = champ.event_id ";
			    $query .= " WHERE champ.creator_id=".$user_id;

			    if((!empty($event_name))){			
	    	       $query .= " AND eve_de.title LIKE '%".$event_name."%'";							
		        }
		        if(($status!='')){			
	    	       $query .= " AND champ.status=".$status;							
		        } 

				$res   = $this->db->query($query);

				if(empty($res))
				{
     
				}
				else
				{
                 $resArr = $res->result_array();
                 return $resArr;
				}
				
				
				
		}
		
		
	public function stopActivateMyPage($result){
		
		if($result['status'] == '0'){
			$data['delete_status'] = "1";
		}else if($result['status'] == '1'){
			$data['delete_status'] = "0";
		}else{
			return false;
		}			
		$this->db->where('id', $result['id']);
		$queryResult = $this->db->update($this->config->item('ems_champions','dbtables'), $data);
	
		return $queryResult;
	}
	
	public function get_image_path($event_id){
		  $query = "SELECT * FROM event_master WHERE id=".$event_id;
				
		  $res   = $this->db->query($query);
		  $resArr = $res->result_array();

		  return $resArr;
	}

	public function get_verified_status($sub_eid){
		 $query = "SELECT * FROM sub_events WHERE id=".$sub_eid;
				
		  $res   = $this->db->query($query);
		  $resArr = $res->result_array();

		  return $resArr;
	}
	
	public function get_authentication_details($event_id, $sub_event_id){
        $query = "SELECT id,event_id";
		$query .= " FROM ".$this->config->item('ems_sub_events','dbtables');    
		$query .= " WHERE id=".$sub_event_id." AND event_id=".$event_id; 

		$res   = $this->db->query($query);   
         
        if($res->num_rows()>0){
            return "success";
        }
        else{
          return "error";
		} 
	}

	public function get_charity_id($event_id){
		$query = "SELECT *";
		$query .= " FROM ".$this->config->item('ems_events','dbtables');    
		$query .= " WHERE id=".$event_id; 
		$res   = $this->db->query($query);   
         
         if($res->num_rows()>0){
			$resArr = $res->result_array();
			return $resArr[0]['organiser_id'];
		}else{
          
        }
	}
	
	public function get_user_details($user_id){
		$query = "SELECT *";
		$query .= " FROM ".$this->config->item('ems_users','dbtables');    
		$query .= " WHERE id=".$user_id; 
		$res   = $this->db->query($query);   
         
         if($res->num_rows()>0){
			$resArr = $res->result_array();
			return $resArr[0];
		}else{
			$resArr = array();
			return $resArr;
        }
	}
	
	function edit_champion_by_id($id){
		$query = "SELECT event_description,message,fundraising_image,champ.title,champ.id,image_path,display_name,target_amount,charity_name,eve_de.title as event_name,champ.created_date,champ.status,eve_de.id as event_id,charity_id, champ.sub_event_id";
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
	
	function update_champion_page($data){		
		$this->db->where('id', $data['id']);
		$queryResult = $this->db->update($this->config->item('ems_champions','dbtables'), $data);	
		
		return $queryResult;
	}
	
	public function get_all_champion_count($search_values = NULL)
	{
		$organizer_id = $this->session->userdata['logged_in'];
		$query = "SELECT ee.title as event_title";
		$query .= " FROM champions ec";	
		$query .= " INNER JOIN ".$this->config->item('ems_events','dbtables')." ee ON ec.event_id = ee.id ";
		$query .= " INNER JOIN ".$this->config->item('ems_sub_events','dbtables')." ees ON ee.id = ees.event_id ";
		$query .= " WHERE charity_id = '".$organizer_id['id']."'";
      
	    if(isset($search_values['eid']) && !empty($search_values['eid'])){
		  	$query .=" AND ee.id=".$search_values['eid'];
		}
		if(isset($search_values['sub_eid']) && !empty($search_values['sub_eid'])){
		  	$query .=" AND ees.id=".$search_values['sub_eid'];
		}
		if((isset($search_values['e_status'])) && ($search_values['e_status'] != "")){
			$query .=" AND ec.status='".$search_values['e_status']."'";						
	    }
		
		$query .= " GROUP BY ec.id";
		$res   = $this->db->query($query);
		$resArr = $res->result_array();	
		return count($resArr);
	}

	function get_all_details($limit, $start, $search_values){
	 
		$organizer_id = $this->session->userdata['logged_in'];
		$query = "SELECT ec.id as id,display_name,ee.title as title, ec.title as champ_title, ec.id as champ_id, ec.status as champ_status,ec.target_amount";
		$query .= " FROM champions ec";	
		$query .= " INNER JOIN ".$this->config->item('ems_events','dbtables')." ee ON ec.event_id = ee.id ";
		$query .= " INNER JOIN ".$this->config->item('ems_sub_events','dbtables')." ees ON ee.id = ees.event_id ";
		$query .= " WHERE charity_id = '".$organizer_id['id']."'";
      

	    if(isset($search_values['eid']) && !empty($search_values['eid'])){
		  	$query .=" AND ee.id=".$search_values['eid'];
		}
		if(isset($search_values['sub_eid']) && !empty($search_values['sub_eid'])){
		  	$query .=" AND ees.id=".$search_values['sub_eid'];
		}
		if((isset($search_values['e_status'])) && ($search_values['e_status'] != "")){
			$query .=" AND ec.status='".$search_values['e_status']."'";						
	    }
		
		$query .= " GROUP BY ec.id";
		$query .= " ORDER BY FIELD(ec.status, 0, 1, 2) ASC";
		
        $query .= " LIMIT ".$start.", ".$limit."";
		
		$res   = $this->db->query($query);
		$resArr = $res->result_array();

		return $resArr;
	}
	
	public function champion_listing_search_count($search_values, $user_id){
			$query = "SELECT champ.delete_status,champ.id,image_path,facebook_image_path,display_name,target_amount,charity_name,eve_de.title,champ.created_date, champ.title as champ_title, champ.fundraising_image,champ.status, champ.charity_id, champ.target_amount,original_event_image";
			$query .= " FROM ".$this->config->item('ems_champions','dbtables')." champ";	
			$query .= " INNER JOIN ".$this->config->item('ems_users','dbtables')." eo ON eo.id = champ.creator_id ";
			$query .= " INNER JOIN ".$this->config->item('ems_organisers_details','dbtables')." cha_de ON cha_de.organization_id = champ.charity_id ";
			$query .= " INNER JOIN ".$this->config->item('ems_events','dbtables')." eve_de ON eve_de.id = champ.event_id ";
			$query .= " WHERE champ.creator_id=".$user_id;

			if(!empty($search_values['event_name'])){			
	    	    $query .= " AND eve_de.title LIKE '%".$search_values['event_name']."%'";							
		    }
		    
			if(!empty($search_values['status'])){			
	    	    $query .= " AND champ.status=".$search_values['status'];							
		    } 
			
			$res = $this->db->query($query);

			if(empty($res)){
				$resArr = array();
				return count($resArr);
			}else{
                $resArr = $res->result_array();
                return count($resArr);
			}				
		}
		
		public function champion_listing_search_data($limit, $start, $search_values, $user_id){
			$query = "SELECT champ.delete_status,champ.id,image_path,facebook_image_path,display_name,target_amount,charity_name,eve_de.status as event_status,eve_de.title,champ.created_date, champ.title as champ_title, champ.fundraising_image,champ.status, champ.charity_id, champ.target_amount,original_event_image";
			$query .= " FROM ".$this->config->item('ems_champions','dbtables')." champ";	
			$query .= " INNER JOIN ".$this->config->item('ems_users','dbtables')." eo ON eo.id = champ.creator_id ";
			$query .= " INNER JOIN ".$this->config->item('ems_organisers_details','dbtables')." cha_de ON cha_de.organization_id = champ.charity_id ";
			$query .= " INNER JOIN ".$this->config->item('ems_events','dbtables')." eve_de ON eve_de.id = champ.event_id ";
			$query .= " WHERE champ.creator_id=".$user_id;

			if(!empty($search_values['event_name'])){			
	    	    $query .= " AND eve_de.title LIKE '%".$search_values['event_name']."%'";							
		    }
		    
			if(isset($search_values['champ_status']) && ($search_values['champ_status'] != "")){			
	    	    $query .= " AND champ.status=".$search_values['champ_status'];							
		    } 

			$query .= " ORDER BY champ.id DESC";
			$query .= " LIMIT ".$start.", ".$limit."";
			
			$res = $this->db->query($query);

			if(empty($res)){
				$resArr = array();
				return $resArr;
			}else{
                $resArr = $res->result_array();
                return $resArr;
			}				
		}
		
	function list_events_user($id){
	   $query = "SELECT distinct em.title, tg.user_id, tg.event_id";
	   $query .= " FROM ticket_generated as tg";//.$this->config->item('ems_events','dbtables');  
	   $query .= " INNER JOIN event_master as em ON em.id = tg.event_id";
	   $query .= " WHERE user_id = $id";
	   
	   $res   = $this->db->query($query);
	   $resArr = $res->result_array();
	   
	   
	   
	   if(count($resArr) > 0){
		return $resArr;
	   }else{
		return false;
	   } 
  }
  
  public function get_popular_champions(){
		$query = "SELECT (GROUP_CONCAT(Distinct(champion_id))) champion_id FROM popular_champions WHERE champion_id != '' Order By position";
		$res   = $this->db->query($query);
		$resArr = $res->result_array();

		$ids=$resArr[0]['champion_id'];
		if($resArr[0]['champion_id'] != ""){
			$query = "SELECT distinct(a.id),image_path,facebook_image_path,display_name,target_amount,charity_name,b.title,a.created_date,fundraising_image";

			$query .= " FROM " .$this->config->item('ems_champions','dbtables'). " as a";
			$query .= " INNER JOIN " . $this->config->item('ems_events','dbtables'). " as b";
			$query .= " ON a.event_id = b.id";
			$query .= " INNER JOIN ".$this->config->item('ems_users','dbtables')." d ON d.id = a.creator_id ";
			$query .= " INNER JOIN " . $this->config->item('ems_organisers_details','dbtables'). " as c";
			$query .= " ON a.charity_id = c.organization_id";
			$query .= " WHERE a.status = 1 AND a.delete_status = 0 AND a.id IN ($ids) ORDER BY FIELD(a.id,$ids) ";
			$res   = $this->db->query($query);
			$resArr = $res->result_array();
			return $resArr;
		}else{
			return false;
		}
	}
}

?>