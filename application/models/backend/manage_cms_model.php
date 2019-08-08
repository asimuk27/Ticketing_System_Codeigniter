<?php



class manage_cms_model extends CI_Model

{



	function __construct()

	{

		parent::__construct();

		$this->load->database();

		$this->config->load('dbtables', TRUE);

	}



	function getdata()

	{

		$this->db->select('*');

		return $this->db->get('cms')->result_array();		

	}

	

	function getselecteddata($id)

	{

		$this->db->select('content,title,id,content_key');

		$this->db->where('id',$id);

		return $this->db->get('cms')->result_array();

	}

	

	

	function update_cms($data,$id)

	{

		$this->db->where('id',$id);

		return $this->db->update('cms',$data);

	}

	function insert_video_cms($data){
		$result = $this->db->insert('video_cms',$data);

       if($result){
         return true;
       }else{
         return false;
       }
	}

	function video_listing(){
	//	$this->db->select('*');

	//	return $this->db->get('video_cms')->result_array();		
		
		$query = "SELECT *";
		$query .= " FROM video_cms";
				
		$res   = $this->db->query($query);
		$resArr = $res->result_array();

		if(count($resArr)){
			return $resArr;
		}else{
			return false;
		}
	}

	function get_video_edit_data($id){
		$this->db->select('content,category,id');

		$this->db->where('id',$id);

		return $this->db->get('video_cms')->result_array();
	}

	function update_video_cms($data,$id){
		$this->db->where('id',$id);
		return $this->db->update('video_cms',$data);
	}

	function delete_cms($id){
		 $this->db->where('id', $id);
         $this->db->delete('video_cms');
         return true;
	}

}



