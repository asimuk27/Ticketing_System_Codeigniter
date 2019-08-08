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
		$this->db->select('merchant_name');
		$this->db->where('user_id',$user_id);
		$query=$this->db->get($this->config->item('ems_dynamic_payment_method','dbtables'))->result_array();
		if($query){
			$this->db->where('user_id',$user_id);
			$this->db->update($this->config->item('ems_dynamic_payment_method','dbtables'), $data_dynamic);
			return true;
		}else{
			$this->db->insert($this->config->item('ems_dynamic_payment_method','dbtables'),$data_dynamic);
			return true;
		}
		return false;
	}

	function flo2cash_payment_method($data_flo2cash){
		$user_id=$data_flo2cash['user_id'];
		$this->db->where('user_id',$user_id);

		$query=$this->db->get($this->config->item('ems_flo2cash_payment_method','dbtables'))->result_array();

		if($query){
			$this->db->update($this->config->item('ems_flo2cash_payment_method','dbtables'), $data_flo2cash);
			return true;
		}else{
			$this->db->insert($this->config->item('ems_flo2cash_payment_method','dbtables'),$data_flo2cash);
			return true;
		}
		return false;
	}

    function poli_payment_method($data_poli){
		$user_id=$data_poli['user_id'];
		$this->db->where('user_id',$user_id);
		$this->db->where('login_type',1);
		$query=$this->db->get($this->config->item('ems_poli_payment_method','dbtables'))->result_array();

		if($query){
			$this->db->where('user_id',$user_id);
			$this->db->where('login_type',1);
			$this->db->update($this->config->item('ems_poli_payment_method','dbtables'), $data_poli);
			return true;
		}else{
			$this->db->insert($this->config->item('ems_poli_payment_method','dbtables'),$data_poli);
			return true;
		}
		return false;
	}



	function dps_payment_method($data_dps){
		$user_id=$data_dps['user_id'];
		$this->db->where('user_id',$user_id);
		$query=$this->db->get($this->config->item('ems_dps_payment_method','dbtables'))->result_array();
		if($query){
			$this->db->update($this->config->item('ems_dps_payment_method','dbtables'), $data_dps);
			return true;
		}else{
			$this->db->insert($this->config->item('ems_dps_payment_method','dbtables'),$data_dps);
			return true;
		}
		return false;
	}

	function alipay_payment_method($data_dps){
		$user_id=$data_dps['user_id'];
		$this->db->where('user_id',$user_id);
		$query=$this->db->get($this->config->item('ems_alipay_payment_method','dbtables'))->result_array();
		if($query){
			$this->db->update($this->config->item('ems_alipay_payment_method','dbtables'), $data_dps);
			return true;
		}else{
			$this->db->insert($this->config->item('ems_alipay_payment_method','dbtables'),$data_dps);
			return true;
		}
		return false;
	}

	// get all payment details for organizer
	function flo_2_cash_details($id){
		$this->db->where('user_id',$id);
		$query=$this->db->get($this->config->item('ems_flo2cash_payment_method','dbtables'))->result_array();
		if(!empty($query)){
			return $query;
		}else{
			return false;
		}
	}

	function dps_payment_details($id){
		$this->db->where('user_id',$id);
		$query=$this->db->get($this->config->item('ems_dps_payment_method','dbtables'))->result_array();
		if(!empty($query)){
			return $query;
		}else{
			return false;
		}
	}

	function dynamic_payment_details($id){
		$this->db->where('user_id',$id);
		$query=$this->db->get($this->config->item('ems_dynamic_payment_method','dbtables'))->result_array();
		if(!empty($query)){
			return $query;
		}else{
			return false;
		}
	}

	function poli_payment_details($id){
		$this->db->where('user_id',$id);
		$query=$this->db->get($this->config->item('ems_poli_payment_method','dbtables'))->result_array();
		if(!empty($query)){
			return $query;
		}else{
			return false;
		}
	}

	function alipay_payment_details($id){
		$this->db->where('user_id',$id);
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
		$data = array('txn_number' => $txn_id,'email_status'=>1);
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
		$data = array('status' => '1','is_notified_on_email'=>1);
		$this->db->where('order_id',$order_id);
		$this->db->update($this->config->item('ems_donations','dbtables'), $data);

		return true;
	}

	function check_email_order_status($order_id = NULL){
		$query = "SELECT id";
		$query .= " FROM " . $this->config->item('ems_payment_history','dbtables');

		$query .= " WHERE email_status = 0 AND order_id = $order_id";
		$res   = $this->db->query($query);
		$resArr = $res->result_array();

		if(!empty($resArr)){
			return $resArr;
		}else{
			$data = array();
			return $data;
		}
	}

	function check_email_donation_status($order_id = NULL){
		$query = "SELECT id";
		$query .= " FROM " . $this->config->item('ems_donations','dbtables');

		$query .= " WHERE is_notified_on_email = 0 AND order_id = $order_id";
		$res   = $this->db->query($query);
		$resArr = $res->result_array();

		if(!empty($resArr)){
			return $resArr;
		}else{
			$data = array();
			return $data;
		}
	}

	function save_dps_organiser($data){
		$query = $this->db->get_where($this->config->item('ems_dps_payment_method','dbtables'), array('user_id' => $data['user_id']));

        $count = $query->num_rows(); //counting result from query

        if ($count === 0) {
            $this->db->insert($this->config->item('ems_dps_payment_method','dbtables'), $data);
        }else{
        	$this->db->where('user_id',$data['user_id']);
            $this->db->update($this->config->item('ems_dps_payment_method','dbtables'),$data);
        }
        return true;

	}

	function save_flo2_organiser($data){

		$query = $this->db->get_where($this->config->item('ems_flo2cash_payment_method','dbtables'), array('user_id' => $data['user_id']));

        $count = $query->num_rows(); //counting result from query

        if ($count === 0) {
            $this->db->insert($this->config->item('ems_flo2cash_payment_method','dbtables'), $data);
        }else{
        	$this->db->where('user_id',$data['user_id']);
            $this->db->update($this->config->item('ems_flo2cash_payment_method','dbtables'),$data);
        }
        return true;

	}

	function get_dps_data($login_id){
		$query = "SELECT *";
		$query .= " FROM " . $this->config->item('ems_dps_payment_method','dbtables');

		$query .= " WHERE user_id = ".$login_id;
		$res   = $this->db->query($query);
		$resArr = $res->result_array();

		if(!empty($resArr)){
			return $resArr;
		}else{
			$data = array();
			return $data;
		}
	}

	function get_flo2_data($login_id){
		$query = "SELECT *";
		$query .= " FROM " . $this->config->item('ems_flo2cash_payment_method','dbtables');

		$query .= " WHERE user_id = ".$login_id;
		$res   = $this->db->query($query);
		$resArr = $res->result_array();

		if(!empty($resArr)){
			return $resArr;
		}else{
			$data = array();
			return $data;
		}
	}

	function save_flo2_settings($flo2_settins){
		$query = $this->db->get_where('organizer_payment_settings', array('organizer_id' => $flo2_settins['organizer_id'],'payment_key'=>$flo2_settins['payment_key']));

        $count = $query->num_rows();


        if ($count===0) {
            $this->db->insert('organizer_payment_settings', $flo2_settins);
        }else{
        	$this->db->where(array('organizer_id' => $flo2_settins['organizer_id'], 'payment_key' => $flo2_settins['payment_key']));
            $this->db->update('organizer_payment_settings',$flo2_settins);
        }
        return true;
	}

	function save_dps_settings($dps_settins){
		$query = $this->db->get_where('organizer_payment_settings', array('organizer_id' => $dps_settins['organizer_id'],'payment_key'=>$dps_settins['payment_key']));

        $count = $query->num_rows();

        if ($count === 0) {
            $this->db->insert('organizer_payment_settings', $dps_settins);
        }else{
        	$this->db->where(array('organizer_id' => $dps_settins['organizer_id'], 'payment_key' => $dps_settins['payment_key']));
            $this->db->update('organizer_payment_settings',$dps_settins);
        }
        return true;
	}

	function get_organiser_settings($login_id){
		$query = "SELECT *";
		$query .= " FROM organizer_payment_settings";
		$query .= " WHERE organizer_id = ".$login_id." AND status=1";
		$res   = $this->db->query($query);
		$resArr = $res->result_array();

		if(!empty($resArr)){
			return $resArr;
		}else{
			$data = array();
			return $data;
		}
	}

	function get_org_tick_setting($login_id,$key){
		$query = "SELECT payment_method";
		$query .= " FROM organization_payment_setup";
		$query .= " WHERE organizer_id = ".$login_id." AND payment_key = '".$key."'";
		$res   = $this->db->query($query);
		$resArr = $res->result_array();

		if(!empty($resArr)){
			return $resArr['0']['payment_method'];
		}else{
			$data = array();
			return $data;
		}
	}


	// get organizer payment methods available
	function get_organizer_payment_methods($organizer = NULL){
		$query = "SELECT distinct(payment_key),payment_method_name";
		$query .= " FROM " . $this->config->item('ems_organizer_payment_settings','dbtables');
		$query .= " WHERE organizer_id = $organizer AND status = 1";

		$res   = $this->db->query($query);
		$resArr = $res->result_array();

		if(!empty($resArr)){
			return $resArr;
		}else{
			$data = array();
			return $data;
		}
	}

	// get email id based on order id
	function get_email_by_order_id($order_id){
		$query = "SELECT email";
		$query .= " FROM " . $this->config->item('ems_payment_history','dbtables');
		$query .= " WHERE order_id = $order_id";
		$res   = $this->db->query($query);
		$resArr = $res->result_array();

		if(!empty($resArr)){
			return $resArr['0']['email'];
		}else{
			$data = array();
			return $data;
		}
	}


	function update_payment_settings($pay_details,$organizer_id){
		$pay_details['organizer_id'] = $organizer_id;
		$key = $pay_details['payment_key'];
		$query = "SELECT id";
		$query .= " FROM ".$this->config->item('ems_organization_payment_setup','dbtables');
		$query .= " WHERE organizer_id = '$organizer_id' AND payment_key = '$key'";

		$res   = $this->db->query($query);
		$resArr = $res->result_array();

		if(empty($resArr)){
			$this->db->insert($this->config->item('ems_organization_payment_setup','dbtables'), $pay_details);
			return true;
		}else{
			// build where clause array
			$where_data = array('organizer_id'=>$organizer_id,'payment_key'=>$key);
			$this->db->where($where_data);
			$queryResult = $this->db->update($this->config->item('ems_organization_payment_setup','dbtables'), $pay_details);

			return true;
		}
	}

	// get dps details
	function get_dps_credential_details($user_id,$type){
		$query = "SELECT user_id,login_type,pxpayuserid,pxpaykey";
		$query .= " FROM " . $this->config->item('ems_dps_payment_method','dbtables');
	//	$query .= " WHERE user_id = $user_id AND login_type = '$type'";

		if($type == 3){
			$query .= " WHERE login_type = 3";
		}
                else if($type == 4){
			$query .= " WHERE login_type = 1";
		}
                else{
			$query .= " WHERE user_id = $user_id AND login_type = '$type'";
		}

		$res   = $this->db->query($query);
		$resArr = $res->result_array();

		if(!empty($resArr)){
			return $resArr['0'];
		}else{
			$data = array();
			return $data;
		}
	}

	// get dps details
	function get_poli_credential_details($user_id,$type = NULL){
		$query = "SELECT user_id,login_type,account_id,password";
		$query .= " FROM " . $this->config->item('ems_poli_payment_method','dbtables');

		if($type == 3){
			$query .= " WHERE login_type = 3";
		}else{
			$query .= " WHERE user_id = $user_id AND login_type = '$type'";
		}

		$res   = $this->db->query($query);
		$resArr = $res->result_array();

		if(!empty($resArr)){
			return $resArr['0'];
		}else{
			$data = array();
			return $data;
		}
	}

	// get dps details
	function get_flo2_credential_details($user_id){
		$query = "SELECT user_id,login_type,account_id";
		$query .= " FROM " . $this->config->item('ems_flo2cash_payment_method','dbtables');
		$query .= " WHERE user_id = $user_id";
		$res   = $this->db->query($query);
		$resArr = $res->result_array();

		if(!empty($resArr)){
			return $resArr['0'];
		}else{
			$data = array();
			return $data;
		}
	}

	// get dps details
	function get_cup_credential_details($user_id){
		$query = "SELECT user_id,login_type,merchant_id";
		$query .= " FROM " . $this->config->item('ems_dynamic_payment_method','dbtables');
		$query .= " WHERE user_id = $user_id";
		$res   = $this->db->query($query);
		$resArr = $res->result_array();

		if(!empty($resArr)){
			return $resArr['0'];
		}else{
			$data = array();
			return $data;
		}
	}


	// get dps details
	function get_ticket_suite_dps($user_id){
		$query = "SELECT organizer_id,payment_method,reference_number";
		$query .= " FROM " . $this->config->item('ems_organization_payment_setup','dbtables');
		$query .= " WHERE organizer_id = $user_id AND payment_key = 'cc'";

		$res   = $this->db->query($query);
		$resArr = $res->result_array();

		if(!empty($resArr)){
			return $resArr['0'];
		}else{
			$data = array();
			return $data;
		}
	}

	// get dps details
	function get_ticket_suite_poli($user_id){
		$query = "SELECT organizer_id,payment_method,reference_number";
		$query .= " FROM " . $this->config->item('ems_organization_payment_setup','dbtables');
		$query .= " WHERE organizer_id = $user_id AND payment_key = 'poli'";

		$res   = $this->db->query($query);
		$resArr = $res->result_array();

		if(!empty($resArr)){
			return $resArr['0'];
		}else{
			$data = array();
			return $data;
		}
	}

	 function get_organiser_id_for_bookings($sub_event_id){
		$query =   "SELECT event.organiser_id";
		$query .= " FROM ".$this->config->item('ems_sub_events','dbtables')." sub_event";
		$query .= " INNER JOIN ".$this->config->item('ems_events','dbtables')." as event ON event.id = sub_event.event_id";
		$query .= " WHERE sub_event.id = $sub_event_id";

		$res   = $this->db->query($query);
		$resArr = $res->result_array();
		if(!empty($resArr)){
			return $resArr[0]['organiser_id'];
		}else{
			return array();
		}
	 }
}

?>