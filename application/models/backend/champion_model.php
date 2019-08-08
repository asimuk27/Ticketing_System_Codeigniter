<?php
class Champion_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->config->load('dbtables', TRUE);		
	}
	
	function get_all_champion_count($search_values = NULL){
		$query = "SELECT a.id,a.display_name,a.target_amount,b.title,d.schedule_title,a.status";
		
		$query .= " FROM " .$this->config->item('ems_champions','dbtables'). " as a";	
		$query .= " INNER JOIN " . $this->config->item('ems_events','dbtables'). " as b";
		$query .= " ON a.event_id = b.id";	
		$query .= " INNER JOIN " . $this->config->item('ems_organisers_details','dbtables'). " as c";
		$query .= " ON a.charity_id = c.organization_id";	
		$query .= " INNER JOIN " . $this->config->item('ems_sub_events','dbtables'). " as d";
		$query .= " ON a.sub_event_id = d.id";	
		$query .= " WHERE 1";
		
		if((!empty($search_values['supporter']))){			
	    	$query .= " AND a.display_name LIKE '%".$search_values['supporter']."%'";							
		}
		
		if((!empty($search_values['organization_name']))){			
	    	$query .= " AND c.organization_name LIKE '%".$search_values['organization_name']."%'";							
		}
		
		if((!empty($search_values['event_name']))){			
	    	$query .= " AND b.title LIKE '%".$search_values['event_name']."%'";							
		}
		 		
		
		$query .= " GROUP BY a.id";
		
		$res   = $this->db->query($query);
		$resArr = $res->result_array();
		return count($resArr);
	}
	
	function get_all_champion($limit, $start, $search_values){		
		
		$query = "SELECT a.id,a.display_name,a.target_amount,b.title,d.schedule_title,a.status";
		
		$query .= " FROM " .$this->config->item('ems_champions','dbtables'). " as a";	
		$query .= " INNER JOIN " . $this->config->item('ems_events','dbtables'). " as b";
		$query .= " ON a.event_id = b.id";	
		$query .= " INNER JOIN " . $this->config->item('ems_organisers_details','dbtables'). " as c";
		$query .= " ON a.charity_id = c.organization_id";	
		$query .= " INNER JOIN " . $this->config->item('ems_sub_events','dbtables'). " as d";
		$query .= " ON a.sub_event_id = d.id";	
		$query .= " WHERE 1";
		
		if((!empty($search_values['supporter']))){			
	    	$query .= " AND a.display_name LIKE '%".$search_values['supporter']."%'";							
		}
		
		if((!empty($search_values['organization_name']))){			
	    	$query .= " AND c.organization_name LIKE '%".$search_values['organization_name']."%'";							
		}
		
		if((!empty($search_values['event_name']))){			
	    	$query .= " AND b.title LIKE '%".$search_values['event_name']."%'";							
		}
		
		$query .= " GROUP BY a.id ORDER BY id DESC";

		$query .= " LIMIT ".$start.", ".$limit."";
		$res   = $this->db->query($query);
		$resArr = $res->result_array();
		
		return $resArr;

	}
	
	function popular_champions(){


		$this->db->select('*');
		$this->db->from('popular_champions');
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function update_popular_champions($data)
	{
		foreach($data as $key => $value){
			$popular_records = array('champion_id' => $value);
			$this->db->where('position', $key);
			$queryResult = $this->db->update('popular_champions', $popular_records);
			$popular_records = array();
		}
	}

	public function check_active_champion_clause($id){

		$where_data = array('id' => $id, 'status' => 1);
		
		$this->db->select('*');
		$this->db->from($this->config->item('ems_champions','dbtables'));
		$this->db->where($where_data); 
		$query = $this->db->get();
        
       
		if ($query->num_rows()) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function fetch_champion_records($id)
	{
		 $query = "SELECT message,fundraising_image,champ.title,champ.id,image_path,display_name,target_amount,charity_name,eve_de.title as event_name,champ.created_date,eve_de.original_event_image as event_image";
		$query .= " FROM ".$this->config->item('ems_champions','dbtables')." champ";	
		$query .= " INNER JOIN ".$this->config->item('ems_users','dbtables')." eo ON eo.id = champ.creator_id ";
		$query .= " INNER JOIN ".$this->config->item('ems_organisers_details','dbtables')." cha_de ON cha_de.organization_id = champ.charity_id ";
		$query .= " INNER JOIN ".$this->config->item('ems_events','dbtables')." eve_de ON eve_de.id = champ.event_id ";
		$query .= " WHERE champ.id=".$id;

		$res   = $this->db->query($query);
		$resArr = $res->result_array();

		if(!empty($resArr)){
			return $resArr;
		}else{
			return false;
		}
	}
}
?>