<?php
class Banner_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->config->load('dbtables', TRUE);		
	}
	
		
	
	function get_banner_images(){
		$query = "SELECT image_name FROM event_banners";
		  
		$res   = $this->db->query($query);
		$resArr = $res->result_array();

		if(isset($resArr)){
		   return $resArr;
		}else{
		   $resArr = array();
		   return $resArr;
		}
	}
}

?>