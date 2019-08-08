<?php
class Banner_model extends CI_Model
{
	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->config->load('dbtables', TRUE);		
	}

	function save($data){
		$result = $this->db->insert($this->config->item('ems_event_banners','dbtables'), $data);		
		return $result;
	}
	
	function get_banner_list(){
          
        $query = "SELECT *";
		$query .= " FROM event_banners";

		 $res   = $this->db->query($query);
		 $resArr = $res->result_array();	
         
         if(isset($resArr['0'])){
			return $resArr;
		 }else{
			return false;
		 }

	}

	function delete_banner($banner_id){
		  $this ->db-> where('id', $banner_id);
          $this ->db-> delete('event_banners');

          return true;
	}

}	