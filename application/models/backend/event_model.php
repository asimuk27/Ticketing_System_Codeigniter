<?php
class Event_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->config->load('dbtables', TRUE);		
	}
	
	
	function get_all_users_count($search_values = NULL){
		$query = "SELECT *";
		$query .= " FROM ".$this->config->item('ems_events','dbtables')." ee";	
		$query .= " INNER JOIN ".$this->config->item('ems_organisers','dbtables')." eo ON eo.id = ee.organiser_id ";
		
		if((!empty($search_values))){			
			$query .= " WHERE (event_category LIKE '%".$search_values['searchby']."%' AND ee.title LIKE '%".$search_values['keyword']."%' AND event_location LIKE '%".$search_values['keyword1']."%' AND eo.title LIKE '%".$search_values['keyword2']."%')";			
		}
		
		$res   = $this->db->query($query);
		$resArr = $res->result_array();				
		return count($resArr);
	}
	
	function get_all_users($limit, $start, $search_values){		
		
		$query = "SELECT ee.id,ee.title,ee.event_location,ee.event_start_date,ee.event_end_date,ee.status,ee.admin_status,ee.is_popular";
		$query .= " FROM ".$this->config->item('ems_events','dbtables')." ee";	
		$query .= " INNER JOIN ".$this->config->item('ems_organisers','dbtables')." eo ON eo.id = ee.organiser_id ";
		
		if((!empty($search_values))){
			$query .= " WHERE (event_category LIKE '%".$search_values['searchby']."%' AND ee.title LIKE '%".$search_values['keyword']."%' AND event_location LIKE '%".$search_values['keyword1']."%' AND eo.title LIKE '%".$search_values['keyword2']."%')";			
		}
		
		$query .= " ORDER BY FIELD(ee.status, 1, 2, 3, 4, 5),event_start_date DESC";
		
		$query .= " LIMIT ".$start.", ".$limit."";
		$res   = $this->db->query($query);
		$resArr = $res->result_array();
		
		return $resArr;
	}
	
	function get_event_details($id){
		$query = "SELECT *";
		$query .= " FROM " . $this->config->item('ems_events','dbtables');	
		
		$query .= " WHERE id = $id ";
		$res   = $this->db->query($query);
		$resArr = $res->result_array();
		return $resArr;
		
	}
	
	
	
	
	function get_categories(){
		$query = "SELECT *";
		$query .= " FROM " . $this->config->item('ems_event_category','dbtables');	
		$query .= " WHERE status = 1 ";
		$res   = $this->db->query($query);
		$resArr = $res->result_array();
		return $resArr;
	}
	
	function popular_events(){
		$this->db->select('*');
		$this->db->from($this->config->item('ems_popular_events','dbtables'));
		$query = $this->db->get();
		if ($query->num_rows()) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	function set_popular_events($id){
		$data['is_popular'] = "1";
		
		$this->db->where('id', $id);
		$queryResult = $this->db->update($this->config->item('ems_events','dbtables'), $data);
	
		return $queryResult;
	}
	
	function disable_popular_events($id){
		$data['is_popular'] = "0";
		
		$this->db->where('id',$id);
		$queryResult = $this->db->update($this->config->item('ems_events','dbtables'), $data);
		return $queryResult;
	}
	
	function set_active_events($id){
		$data['admin_status'] = "1";
		
		$this->db->where('id', $id);
		$queryResult = $this->db->update($this->config->item('ems_events','dbtables'), $data);
	
		return $queryResult;
	}
	function set_inActive_events($id){
		$data['admin_status'] = "0";
		$this->db->where('id', $id);
		$queryResult = $this->db->update($this->config->item('ems_events','dbtables'), $data);
	
		return $queryResult;
	}
	
	public function get_sub_event_by_event_id($id){		
		$query = "SELECT *";
		$query .= " FROM ".$this->config->item('ems_sub_events','dbtables')." sub_event";	
		$query .= " INNER JOIN ".$this->config->item('ems_sub_event_ticket_master','dbtables')." tickets ON sub_event.id = tickets.sub_event_id WHERE sub_event.id = $id AND ticket_name != ''";
		
		$res   = $this->db->query($query);
		$resArr = $res->result_array();
		
		
		if(!empty($resArr)){
			return $resArr;
		}else{
			return false;
		}		
	}
	public function get_sub_event_id_by_event_id($id){
		$this->db->select('id');
		$this->db->from($this->config->item('ems_sub_events','dbtables'));
		$this->db->where('event_id =', $id);
		$query = $this->db->get();

		if ($query->num_rows()) {
			return $query->result();
		} else {
			$data = array();
			return $data;
		}		
	}
	public function check_active_event_clause($id){
		$where_data = array('id' => $id, 'status' => 1);
		
		$this->db->select('*');
		$this->db->from($this->config->item('ems_events','dbtables'));
		$this->db->where($where_data); 
		$query = $this->db->get();

		if ($query->num_rows()) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	function update_popular_events($data){
		foreach($data as $key => $value){
			$popular_records = array('event_id' => $value);
			$this->db->where('position', $key);
			$queryResult = $this->db->update($this->config->item('ems_popular_events','dbtables'), $popular_records);
			$popular_records = array();
		}
	}
	
	function is_event_popular($event_id){
		$query = "SELECT position";
		$query .= " FROM " . $this->config->item('ems_popular_events','dbtables');	
		$query .= " WHERE event_id = $event_id ";
		$res   = $this->db->query($query);
		$resArr = $res->result_array();
		return $resArr;
	}
	
	function remove_event_popular($position){
		$data['event_id'] = "";		
		$this->db->where('position', $position);
		$queryResult = $this->db->update($this->config->item('ems_popular_events','dbtables'), $data);
	
		return $queryResult;
	}
	
	public function live_events(){
		
		$query = "SELECT (GROUP_CONCAT(Distinct(event_id))) event_id FROM ".$this->config->item('ems_popular_events','dbtables')." WHERE event_id != '' Order By position";	
		$res   = $this->db->query($query);
		$resArr = $res->result_array();
		
		
		if(!empty($resArr)){			
			$ids = $resArr['0']['event_id'];
			$query = "SELECT * FROM ".$this->config->item('ems_events','dbtables')." WHERE id IN ($ids) ORDER BY FIELD(id,$ids);";
			
			$res   = $this->db->query($query);
			$resArr = $res->result_array();

			return $resArr;
		} else {
			return false;
		}
	}
}
?>