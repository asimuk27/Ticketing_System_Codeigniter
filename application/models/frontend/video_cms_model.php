<?php

class Video_cms_model extends CI_Model
{

	function __construct()

	{

		parent::__construct();

		$this->load->database();

		$this->config->load('dbtables', TRUE);		

	}

	function get_video_categories(){
		$query = "SELECT *";

		$query .= " FROM video_cms";

		
         

        $res   = $this->db->query($query);

		$resArr = $res->result_array();

		if(!empty($resArr)){
           return $resArr;
		}else{
           return false;
		}

		
	}

	function get_content($id){
		$query = "SELECT content";

		$query .= " FROM video_cms";

		$query .= " WHERE id=".$id;

		
         

        $res   = $this->db->query($query);

		$resArr = $res->result_array();

		if(!empty($resArr)){
           return $resArr[0];
		}else{
           return false;
		}
	}
}

?>