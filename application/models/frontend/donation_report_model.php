<?php
class Donation_report_model extends CI_Model
{
	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->config->load('dbtables', TRUE);
	}


  function get_my_donation_count($search_values = NULL){

    $organizer_id = $this->session->userdata['logged_in'];


	$query = "SELECT *";
	$query .= " FROM ".$this->config->item('ems_champions','dbtables')." chmp";
	$query .= " INNER JOIN ".$this->config->item('ems_events','dbtables')." evt ON evt.id = chmp.event_id ";
	$query .= " INNER JOIN ".$this->config->item('ems_sub_events','dbtables')." sub_evt ON sub_evt.id = chmp.sub_event_id ";
	$query .= " INNER JOIN ".$this->config->item('ems_organisers_details','dbtables')." eorg ON eorg.organization_id = chmp.charity_id ";
	$query .= " INNER JOIN ".$this->config->item('ems_donations','dbtables')." evt_don ON evt_don.champion_page_id = chmp.id ";
	$query .= " INNER JOIN ".$this->config->item('ems_payment_history','dbtables')." pay_hist ON pay_hist.order_id = evt_don.order_id ";

	$query .= " WHERE eorg.organization_id = '".$organizer_id['id']."'";

    if((!empty($search_values['eid']))){
        $query .= " AND evt.id =".$search_values['eid']."";
    }

    if((!empty($search_values['sub_eid']))){
        $query .= " AND sub_evt.id =".$search_values['sub_eid']."";
    }

	if((!empty($search_values['donation_from']))){
		$query .= " AND evt_don.first_name LIKE '%".$search_values['donation_from']."%' ";
	}

	if((!empty($search_values['pay_status']))){
		if($search_values['pay_status'] == 1){
			$query .= " AND evt_don.status = '1'";
		}else if($search_values['pay_status'] == 2){
			$query .= " AND evt_don.status = '0'";
		}
	}else{
		$query .= " AND evt_don.status = '1'";
	 }

	/*else{
		$query .= " AND pay_hist.txn_number!=''";
	}*/

     //$query .= " AND evt.id LIKE '%".$search_values['search_by_order_id']."%'";
    $res   = $this->db->query($query);
    $resArr = $res->result_array();

    return count($resArr);
  }

  function get_my_donation($limit = NULL, $start = NULL,$search_values = NULL){
    $organizer_id = $this->session->userdata['logged_in'];

	 $query = "SELECT evt_don.email as email,evt_don.status as status,evt_don.id as main_id,chmp.id as donation_id,chmp.display_name as title,pay_hist.created_date,evt_don.order_id as donation_order,evt_don.first_name as first_name,eorg.organization_id as organiser_id,evt.id as event_id,evt.title as event_name, sub_evt.schedule_title as sub_event_name,sub_evt.id as sub_event_id,chmp.id as champ_id,donation_amount,evt_don.order_id";
 	 $query .= " FROM ".$this->config->item('ems_champions','dbtables')." chmp";
 	 $query .= " INNER JOIN ".$this->config->item('ems_events','dbtables')." evt ON evt.id = chmp.event_id ";
 	 $query .= " INNER JOIN ".$this->config->item('ems_sub_events','dbtables')." sub_evt ON sub_evt.id = chmp.sub_event_id ";
 	 $query .= " INNER JOIN ".$this->config->item('ems_organisers_details','dbtables')." eorg ON eorg.organization_id = chmp.charity_id ";
 	 $query .= " INNER JOIN ".$this->config->item('ems_donations','dbtables')." evt_don ON evt_don.champion_page_id = chmp.id ";
 	 $query .= " INNER JOIN ".$this->config->item('ems_payment_history','dbtables')." pay_hist ON pay_hist.order_id = evt_don.order_id ";

 	 $query .= " WHERE eorg.organization_id = '".$organizer_id['id']."'";

	 if((!empty($search_values['eid']))){
			 $query .= " AND evt.id =".$search_values['eid']." ";
	 }

	 if((!empty($search_values['sub_eid']))){
			 $query .= " AND sub_evt.id =".$search_values['sub_eid']." ";
	 }

	 if((!empty($search_values['donation_from']))){
			 $query .= " AND evt_don.first_name LIKE '%".$search_values['donation_from']."%' ";
	 }

	  if((!empty($search_values['pay_status']))){
		if($search_values['pay_status'] == 1){
			$query .= " AND evt_don.status = '1'";
		}else if($search_values['pay_status'] == 2){
			$query .= " AND evt_don.status = '0'";
		}
	 }else{
		$query .= " AND evt_don.status = '1'";
	 }

	/*else{
		$query .= " AND pay_hist.txn_number!=''";
	}*/

    $query .= "ORDER BY evt_don.id DESC";

    $query .= " LIMIT ".$start.", ".$limit."";
    $res   = $this->db->query($query);
    $resArr = $res->result_array();

  // echo "<pre>";
  // print_r($resArr);exit;
    return $resArr;
  }

	public function view_my_donations($id=null){
		$query = "SELECT eorg.charity_name,pay_hist.country,evt_don.phone,pay_hist.email as payhist_email,sub_evt.schedule_title,chmp.display_name, pay_hist.order_id as hist_order, txn_number, evt_don.id,chmp.title,pay_hist.created_date,evt_don.order_id as donation_order,evt_don.first_name as first_name,eorg.organization_id as organiser_id,evt.id as event_id,evt.title as event_name, sub_evt.schedule_title as sub_event_name,sub_evt.id as sub_event_id,chmp.id as champ_id,donation_amount";
		$query .= " FROM ".$this->config->item('ems_champions','dbtables')." chmp";
		$query .= " INNER JOIN ".$this->config->item('ems_events','dbtables')." evt ON evt.id = chmp.event_id ";
		$query .= " INNER JOIN ".$this->config->item('ems_sub_events','dbtables')." sub_evt ON sub_evt.id = chmp.sub_event_id ";
		$query .= " INNER JOIN ".$this->config->item('ems_organisers_details','dbtables')." eorg ON eorg.organization_id = chmp.charity_id ";
		$query .= " INNER JOIN ".$this->config->item('ems_donations','dbtables')." evt_don ON evt_don.champion_page_id = chmp.id ";
		$query .= " INNER JOIN ".$this->config->item('ems_payment_history','dbtables')." pay_hist ON pay_hist.order_id = evt_don.order_id ";

		$query .= " WHERE evt_don.id = ".$id."";

		$res   = $this->db->query($query);
		$resArr = $res->result_array();

	// echo "<pre>";
	// print_r($resArr);exit;
		return $resArr[0];
	}

	function get_all_sub_events($id){
		$query = "SELECT id,schedule_title";
		$query .= " FROM ".$this->config->item('ems_sub_events','dbtables');
		$query .= " WHERE event_id = $id";
		$res   = $this->db->query($query);
		$resArr = $res->result_array();

		if(count($resArr) > 0){
			return $resArr;
		}else{
			return false;
		}
	}


	  function csv_download($search_values = NULL){
			$this->load->dbutil();
			$this->load->helper('file');
			$this->load->helper('download');
			$delimiter = ",";
			$newline = "\r\n";
			$filename = "donation_reports.csv";
			$organizer_id = $this->session->userdata['logged_in'];

			$query = "SELECT eorg.organization_name as OrganisationName,evt.title as EventName, sub_evt.schedule_title as SubEventName,chmp.display_name as ChampionPageTitle,us.email as DonationToEmail,donation_amount as AmountDonated$,evt_don.donor_message as Message,pay_hist.created_date as DonationDate,donor_name as DonationAs,evt_don.donar_organisation as DonationByOrg,evt_don.salutation as DonorSalutation,evt_don.first_name as DonorName,evt_don.email as DonorEmail,evt_don.phone as Phone,evt_don.street as Street,evt_don.suburb as Suburb,evt_don.city as City,evt_don.postal_code as PostalCode,evt_don.country as Country,evt_don.communication_required as Communication,evt_don.payment_method as PaymentMethod,evt_don.order_id as TicketingSystemOrderId,pay_hist.Txn_Number as PaymentOrderId,pay_hist.created_date as PaymentTransDate,evt_don.status as PaymentGatewayStatus";

			$query .= " FROM ".$this->config->item('ems_champions','dbtables')." chmp";
			$query .= " INNER JOIN ".$this->config->item('ems_events','dbtables')." evt ON evt.id = chmp.event_id ";
			$query .= " INNER JOIN ".$this->config->item('ems_sub_events','dbtables')." sub_evt ON sub_evt.id = chmp.sub_event_id ";
			$query .= " INNER JOIN ".$this->config->item('ems_organisers_details','dbtables')." eorg ON eorg.organization_id = chmp.charity_id ";
			$query .= " INNER JOIN ".$this->config->item('ems_donations','dbtables')." evt_don ON evt_don.champion_page_id = chmp.id ";
			$query .= " INNER JOIN ".$this->config->item('ems_payment_history','dbtables')." pay_hist ON pay_hist.order_id = evt_don.order_id ";
			$query .= " INNER JOIN ".$this->config->item('ems_users','dbtables')." us ON us.id = chmp.creator_id ";

			$query .= " WHERE eorg.organization_id = '".$organizer_id['id']."'";

			if((!empty($search_values['eid']))){
				$query .= " AND evt.id =".$search_values['eid']." ";
    		}
			if((!empty($search_values['sub_eid']))){
				$query .= " AND sub_evt.id =".$search_values['sub_eid']." ";
     		}
			if((!empty($search_values['donation_from']))){
				$query .= " AND evt_don.first_name LIKE '%".$search_values['donation_from']."%' ";
			}

			if((!empty($search_values['pay_status']))){
				if($search_values['pay_status'] == 1){
					$query .= " AND evt_don.status = '1'";
				}else if($search_values['pay_status'] == 2){
					$query .= " AND evt_don.status = '0'";
				}
			}else{
				$query .= " AND evt_don.status = '1'";
			}

			$query .= "ORDER BY evt_don.id DESC";

			$res   = $this->db->query($query);

			$resArr = $res->result_array();

			if(empty($resArr)){
				return false;
			}else{
				$data = $this->dbutil->csv_from_result($res, $delimiter, $newline);
				force_download($filename, $data);
			}
		}

	public function get_view_donation($id=null){
		$organizer_id = $this->session->userdata['logged_in'];

	 $query = "SELECT chmp.title as champ_title,evt_don.status as txn_status, pay_hist.txn_number,pay_hist.txn_date, evt_don.order_id as donation_order_id,evt_don.communication_required,evt_don.country as donation_country,evt_don.postal_code as py_postal_code,evt_don.city as py_city,evt_don.suburb as suburb,evt_don.street as donation_street,evt_don.phone as donation_phone,evt_don.email as donation_email,evt_don.salutation,eorg.organization_name,evt_don.donor_message as donation_message, evt_don.donor_name,us.email as users_email,chmp.id as donation_id,chmp.display_name as display_name, pay_hist.created_date,evt_don.order_id as donation_order,evt_don.first_name as donar_first_name,eorg.organization_id as organiser_id,evt.id as event_id,evt.title as event_name, sub_evt.schedule_title as sub_event_name,sub_evt.id as sub_event_id,chmp.id as champ_id,donation_amount, eorg.charity_name as org_charity_name,donar_organisation,evt_don.payment_method";
	 $query .= " FROM ".$this->config->item('ems_champions','dbtables')." chmp";
	 $query .= " INNER JOIN ".$this->config->item('ems_events','dbtables')." evt ON evt.id = chmp.event_id ";
	 $query .= " INNER JOIN ".$this->config->item('ems_sub_events','dbtables')." sub_evt ON sub_evt.id = chmp.sub_event_id ";
	 $query .= " INNER JOIN ".$this->config->item('ems_organisers_details','dbtables')." eorg ON eorg.organization_id = chmp.charity_id ";
	 $query .= " INNER JOIN ".$this->config->item('ems_donations','dbtables')." evt_don ON evt_don.champion_page_id = chmp.id ";
	 $query .= " INNER JOIN ".$this->config->item('ems_payment_history','dbtables')." pay_hist ON pay_hist.order_id = evt_don.order_id ";
	 $query .= " INNER JOIN ".$this->config->item('ems_users','dbtables')." us ON us.id = chmp.creator_id ";

	$query .= " WHERE evt_don.id = ".$id."";

	 $res   = $this->db->query($query);
	 $resArr = $res->result_array();

	 return $resArr[0];

	}

	function get_purchaser_details($order_id){
		$query = "SELECT created_date,txn_number,email,first_name,address1,address2,city,postal_code";
		$query .= " FROM ".$this->config->item('ems_payment_history','dbtables');
		$query .= " WHERE order_id = $order_id";
		$res   = $this->db->query($query);
		$resArr = $res->result_array();

		if(count($resArr) > 0){
			return $resArr;
		}else{
			return false;
		}
	}

}
