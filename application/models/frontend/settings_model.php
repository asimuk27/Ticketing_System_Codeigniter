<?php

class Settings_model extends CI_Model
{

	function __construct(){

		parent::__construct();
		$this->load->database();
		$this->config->load('dbtables', TRUE);	
	}

	function get_sql_status(){
		$query = "SELECT @@sql_mode as mode";
		$res   = $this->db->query($query);
		$resArr = $res->result_array();
		
		if(count($resArr)){
			return $resArr[0]['mode'];
		}else{
			return array();
		}
	}
}

?>