<?php
class Payment_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->config->load('dbtables', TRUE);
	}



	function dynamic_payment_method($data_dynamic){
		$user_id=$data_dynamic['user_id'];
		$login_type = $data_dynamic['login_type'];
        /*echo "<pre>"	;
		print_r($login_type);
		echo "</pre>";
		echo "<pre>"	;
		print_r($user_id);
		echo "</pre>";
		exit;*/

		$this->db->select('merchant_name');
		$this->db->where('user_id',$user_id);
		$this->db->where('login_type',$login_type);
		$query=$this->db->get($this->config->item('ems_dynamic_payment_method','dbtables'))->result_array();

		if($query){
			$this->db->where('login_type',$login_type);
			$this->db->update($this->config->item('ems_dynamic_payment_method','dbtables'), $data_dynamic);
			return true;
		}else{
			$this->db->where('login_type',$login_type);
			$this->db->insert($this->config->item('ems_dynamic_payment_method','dbtables'),$data_dynamic);
			return true;
		}
		return false;
	}

	function flo2cash_payment_method($data_flo2cash){
		$user_id=$data_flo2cash['user_id'];
		$login_type = $data_flo2cash['login_type'];
		$this->db->where('user_id',$user_id);
		$this->db->where('login_type',$login_type);
		$query=$this->db->get($this->config->item('ems_flo2cash_payment_method','dbtables'))->result_array();

		if($query){
			$this->db->where('login_type',$login_type);
			$this->db->update($this->config->item('ems_flo2cash_payment_method','dbtables'), $data_flo2cash);
			return true;
		}else{
			$this->db->where('login_type',$login_type);
			$this->db->insert($this->config->item('ems_flo2cash_payment_method','dbtables'),$data_flo2cash);
			return true;
		}
		return false;
	}

    



	function dps_payment_method($data_dps){
		$user_id=$data_dps['user_id'];
		$login_type=$data_dps['login_type'];
		$this->db->where('user_id',$user_id);
		$this->db->where('login_type',$login_type);
		$query=$this->db->get($this->config->item('ems_dps_payment_method','dbtables'))->result_array();
		if($query){
			$this->db->where('login_type',$login_type);
			$this->db->update($this->config->item('ems_dps_payment_method','dbtables'), $data_dps);
			return true;
		}else{
			$this->db->where('login_type',$login_type);
			$this->db->insert($this->config->item('ems_dps_payment_method','dbtables'),$data_dps);
			return true;
		}
		return false;
	}

	function alipay_payment_method($data_dps){
		$user_id=$data_dps['user_id'];
		$login_type=$data_dps['login_type'];
		$this->db->where('user_id',$user_id);
		$this->db->where('login_type',$login_type);
		$query=$this->db->get($this->config->item('ems_alipay_payment_method','dbtables'))->result_array();
		if($query){
			$this->db->where('login_type',$login_type);
			$this->db->update($this->config->item('ems_alipay_payment_method','dbtables'), $data_dps);
			return true;
		}else{
			$this->db->where('login_type',$login_type);
			$this->db->insert($this->config->item('ems_alipay_payment_method','dbtables'),$data_dps);
			return true;
		}
		return false;
	}

	// get all payment details for organizer
	function flo_2_cash_details($id,$login_type){
		$this->db->where('user_id',$id);
		$this->db->where('login_type',$login_type);
		$query=$this->db->get($this->config->item('ems_flo2cash_payment_method','dbtables'))->result_array();
		if(!empty($query)){
			return $query;
		}else{
			return false;
		}
	}

	function dps_payment_details($id,$login_type){
		$this->db->where('user_id',$id);
		$this->db->where('login_type',$login_type);
		$query=$this->db->get($this->config->item('ems_dps_payment_method','dbtables'))->result_array();
		if(!empty($query)){
			return $query;
		}else{
			return false;
		}
	}

	function dynamic_payment_details($id,$login_type){
		$this->db->where('user_id',$id);
		$this->db->where('login_type',$login_type);
		$query=$this->db->get($this->config->item('ems_dynamic_payment_method','dbtables'))->result_array();
		if(!empty($query)){
			return $query;
		}else{
			return false;
		}
	}



	function alipay_payment_details($id,$login_type){
		$this->db->where('user_id',$id);
		$this->db->where('login_type',$login_type);
		$query=$this->db->get($this->config->item('ems_alipay_payment_method','dbtables'))->result_array();
		if(!empty($query)){
			return $query;
		}else{
			return false;
		}
	}

	// function to save payment details
	function save_order_information($data){
		$this->db->insert($this->config->item('ems_payment_history','dbtables'),$data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	function get_last_payment_id(){
		$this->db->select('MAX(id) AS unique_id');
		$this->db->from($this->config->item('ems_payment_history','dbtables'));
		$query = $this->db->get();

		if ($query->num_rows() == 1) {
			$result = $query->result();
			return $result['0'];
		} else {
			return false;
		}
	}

	function update_payment_status($txn_id,$order_id){
		$data = array('txn_number' => $txn_id);
		$this->db->where('order_id',$order_id);
		$this->db->update($this->config->item('ems_payment_history','dbtables'), $data);
		return true;
	}

	function update_donation_with_order_id($id,$order_id){
		$data = array('order_id' => $order_id);
		$this->db->where('id',$id);
		$this->db->update($this->config->item('ems_donations','dbtables'), $data);
		return true;
	}

	function update_donation_status($order_id){
		$data = array('status' => '1');
		$this->db->where('order_id',$order_id);
		$this->db->update($this->config->item('ems_donations','dbtables'), $data);

		return true;

	}

}

?>