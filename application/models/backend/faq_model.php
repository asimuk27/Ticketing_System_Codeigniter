<?php
class Faq_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->config->load('dbtables', TRUE);		
	}
	
		
	function save_faq($data){
		 $new_data=array();
		 $result = $this->db->insert("faq_settings", $data);
		 $faq_id=$this->db->insert_id();
		 $new_data['order_position']=$faq_id;	
		
		if($result){
			$insert_order=$this->db->insert("faq_order", $new_data);
			return true;
		}else{
			return false;
		}		 
	}

	function get_order_sequence(){
		$query = "SELECT *";
		$query .= " FROM faq_settings";
		$res   = $this->db->query($query);
		$resArr = $res->result_array();
		return count($resArr);
		
	}

	function get_all_faqs(){
		$query = "SELECT fo.id as order_id, fq.id as id, fq.header_title,fq.status";
		$query .= " FROM faq_settings as fq";
		$query .= " INNER JOIN faq_order fo ON fo.order_position = fq.id ";
		$query .= " ORDER BY fo.id ASC";	
		
		$res   = $this->db->query($query);
		$resArr = $res->result_array();

		if(count($resArr)){
			return $resArr;
		}else{
			return false;
		}
	}
	

	function get_all_faqs_count(){
		$query = "SELECT *";
		$query .= " FROM faq_settings";
		$res   = $this->db->query($query);
		$resArr = $res->result_array();
		
		return count($resArr);
	}

	function get_unique_faq($id){
		$query = "SELECT *";
		$query .= " FROM faq_settings";		
		$query .= " WHERE id = '".$id."'";
		$res   = $this->db->query($query);
		$resArr = $res->result_array();
		
		if(count($resArr)){
			return $resArr[0];
		}else{
			return false;
		}
	}

	function update_faq($data){
		$this->db->where('id', $data['id']);
		$queryResult = $this->db->update("faq_settings", $data);

        if($queryResult){
          return true;
        }else{
          return false;
        }

	}

	function ajax_update_faq_status($id, $status){		
		$data =array();
		if($status == 1){
			$data["status"] = 0;
		}else{
			$data["status"] = 1;
		}
		$this->db->where('id', $id);
		$queryResult = $this->db->update("faq_settings", $data);
		return true;
	}

	function update_faq_order($order_pos, $order_faq){    

		$query = "UPDATE faq_order";
        $query .=" SET order_position =$order_faq";
        $query .=" WHERE id =$order_pos";
        
		$res   = $this->db->query($query);	
	
	}

	function get_all_faqs_for_order_listing(){
		$query = "SELECT *";
		$query .= " FROM faq_settings";
		
		$res   = $this->db->query($query);
		$resArr = $res->result_array();
	
		if(count($resArr)){
			return $resArr;
		}else{
			return false;
		}
	}

	function get_all_order_ids(){
		$query = "SELECT id";
		$query .= " FROM faq_order";
		  
		$res   = $this->db->query($query);
		$resArr = $res->result_array();
		 
		if(count($resArr)){
		   return $resArr;
		}else{
		   return false;
		}
	}

	
}
?>