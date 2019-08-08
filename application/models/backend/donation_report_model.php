<?php

class Donation_report_model extends CI_Model

{

	function __construct(){

		parent::__construct();

		$this->load->database();

		$this->config->load('dbtables', TRUE);

	}





  function get_my_donation_count($search_values = NULL){



	$query = "SELECT *";

	$query .= " FROM ".$this->config->item('ems_champions','dbtables')." chmp";

	$query .= " INNER JOIN ".$this->config->item('ems_events','dbtables')." evt ON evt.id = chmp.event_id ";

	$query .= " INNER JOIN ".$this->config->item('ems_sub_events','dbtables')." sub_evt ON sub_evt.id = chmp.sub_event_id ";

	$query .= " INNER JOIN ".$this->config->item('ems_organisers_details','dbtables')." eorg ON eorg.organization_id = chmp.charity_id ";

	$query .= " INNER JOIN ".$this->config->item('ems_donations','dbtables')." evt_don ON evt_don.champion_page_id = chmp.id ";

	$query .= " INNER JOIN ".$this->config->item('ems_payment_history','dbtables')." pay_hist ON pay_hist.order_id = evt_don.order_id ";




	$query .= "WHERE 1";




    if((!empty($search_values['searchby_org_id']))){

        $query .= " AND eorg.organization_id =".$search_values['searchby_org_id']."";

    }



    if((!empty($search_values['searchby_event_id']))){

        $query .= " AND evt.id =".$search_values['searchby_event_id']."";

    }

     if((!empty($search_values['searchby_sub_event_id']))){

        $query .= " AND sub_evt.id =".$search_values['searchby_sub_event_id']."";

     }
/*
    if((!empty($search_values['from_date'])) && (!empty($search_values['to_date'])) ){
        $query .= " AND (pay_hist.created_date BETWEEN ".$search_values['from_date']." and ".$search_values['to_date'].")";
    } */

      if((!empty($search_values['from_date'])) && (!empty($search_values['to_date'])) ){
        $fromdate = new DateTime($search_values['from_date']);
        $todate = new DateTime($search_values['to_date']);
        $from=$fromdate->format('Y-m-d H:i:s');
        $to=$todate->format('Y-m-d H:i:s');
        $query .= " AND (pay_hist.created_date BETWEEN '".$from."' and '".$to."')";
     }else if((!empty($search_values['from_date']))){
        $fromdate = new DateTime($search_values['from_date']);
        $todate = new DateTime(date("Y-m-d"));
        $from=$fromdate->format('Y-m-d H:i:s');
        $to=$todate->format('Y-m-d H:i:s');
        $query .= " AND (pay_hist.created_date >= '".$from."')";
     }else if((!empty($search_values['to_date']))){
        $todate = new DateTime($search_values['to_date']);
		$to=$todate->format('Y-m-d H:i:s');
	    $query .= " AND (pay_hist.created_date <='".$to."')";
     }

       if((!empty($search_values['donation_from']))){

        $query .= " AND pay_hist.email LIKE '%".$search_values['donation_from']."%'";

     }

      if((!empty($search_values['donation_to']))){

        $query .= " AND us.email LIKE '%".$search_values['donation_to']."%'";

      }

      if((!empty($search_values['payment_type']))){

        $query .= " AND pay_hist.payment_method LIKE '%".$search_values['payment_type']."%'";

      }

      if((!empty($search_values['status']))){
         if($search_values['status']==1){
            $don_status=1;
			 $query .= " AND evt_don.status =".$don_status."";
         }else if($search_values['status']==2){
            $don_status=0;
			 $query .= " AND evt_don.status =".$don_status."";
         }
	 }





    $res   = $this->db->query($query);

    $resArr = $res->result_array();



    return count($resArr);

  }



  function get_my_donation($limit = NULL, $start = NULL,$search_values = NULL){

	 $query = "SELECT evt_don.id as main_id,chmp.id as donation_id,chmp.display_name as title,pay_hist.created_date,evt_don.order_id as donation_order,evt_don.first_name as first_name,eorg.organization_id as organiser_id,evt.id as event_id,evt.title as event_name, sub_evt.schedule_title as sub_event_name,sub_evt.id as sub_event_id,chmp.id as champ_id,donation_amount";

 $query .= " FROM ".$this->config->item('ems_champions','dbtables')." chmp";

	$query .= " INNER JOIN ".$this->config->item('ems_events','dbtables')." evt ON evt.id = chmp.event_id ";

	$query .= " INNER JOIN ".$this->config->item('ems_sub_events','dbtables')." sub_evt ON sub_evt.id = chmp.sub_event_id ";

	$query .= " INNER JOIN ".$this->config->item('ems_organisers_details','dbtables')." eorg ON eorg.organization_id = chmp.charity_id ";

	$query .= " INNER JOIN ".$this->config->item('ems_donations','dbtables')." evt_don ON evt_don.champion_page_id = chmp.id ";

	$query .= " INNER JOIN ".$this->config->item('ems_payment_history','dbtables')." pay_hist ON pay_hist.order_id = evt_don.order_id ";

	$query .= " INNER JOIN ".$this->config->item('ems_users','dbtables')." us ON us.id = chmp.creator_id ";




	$query .= "WHERE 1";



    if((!empty($search_values['searchby_org_id']))){

        $query .= " AND eorg.organization_id =".$search_values['searchby_org_id']."";

    }



    if((!empty($search_values['searchby_event_id']))){

        $query .= " AND evt.id =".$search_values['searchby_event_id']."";

    }

     if((!empty($search_values['searchby_sub_event_id']))){

        $query .= " AND sub_evt.id =".$search_values['searchby_sub_event_id']."";

     }

      if((!empty($search_values['from_date'])) && (!empty($search_values['to_date'])) ){
        $fromdate = new DateTime($search_values['from_date']);
        $todate = new DateTime($search_values['to_date']);
        $from=$fromdate->format('Y-m-d H:i:s');
        $to=$todate->format('Y-m-d H:i:s');
        $query .= " AND (pay_hist.created_date BETWEEN '".$from."' and '".$to."')";
     }else if((!empty($search_values['from_date']))){
        $fromdate = new DateTime($search_values['from_date']);
        $todate = new DateTime(date("Y-m-d"));
        $from=$fromdate->format('Y-m-d H:i:s');
        $to=$todate->format('Y-m-d H:i:s');
        $query .= " AND (pay_hist.created_date >= '".$from."')";
     }else if((!empty($search_values['to_date']))){
        $todate = new DateTime($search_values['to_date']);
		$to=$todate->format('Y-m-d H:i:s');
	    $query .= " AND (pay_hist.created_date <='".$to."')";
     }

      if((!empty($search_values['donation_from']))){

        $query .= " AND pay_hist.email LIKE '%".$search_values['donation_from']."%'";

     }

      if((!empty($search_values['donation_to']))){

        $query .= " AND us.email LIKE '%".$search_values['donation_to']."%'";

      }

      if((!empty($search_values['payment_type']))){

        $query .= " AND pay_hist.payment_method LIKE '%".$search_values['payment_type']."%'";

      }

       if((!empty($search_values['status']))){
         if($search_values['status']==1){
            $don_status=1;
			 $query .= " AND evt_don.status =".$don_status."";
         }else if($search_values['status']==2){
            $don_status=0;
			 $query .= " AND evt_don.status =".$don_status."";
         }
	 }


	$query .= " ORDER BY evt_don.id DESC";


    $query .= " LIMIT ".$start.", ".$limit."";

    $res   = $this->db->query($query);

    $resArr = $res->result_array();



    return $resArr;

  }

  public function get_all_organisers(){
  	$query = "SELECT organization_id, charity_name";
	$query .= " FROM ".$this->config->item('ems_organisers_details','dbtables')." as od";
	$query .= " INNER JOIN organisation_contact as oc ON oc.id=od.organization_id";
	$query .= " WHERE oc.status = 1";

    $res   = $this->db->query($query);
    $resArr = $res->result_array();
    return $resArr;
  }

  public function get_charity_events($charity_id){
       $query = "SELECT id, title";

	    $query .= " FROM ".$this->config->item('ems_events','dbtables');
      $query .= " WHERE organiser_id=".$charity_id;
        $res   = $this->db->query($query);

        $resArr = $res->result_array();

         return $resArr;

  }

  public function get_sub_events($event_id){
  	  $query = "SELECT id, schedule_title";

	    $query .= " FROM ".$this->config->item('ems_sub_events','dbtables');
      $query .= " WHERE event_id=".$event_id;
        $res   = $this->db->query($query);

        $resArr = $res->result_array();

         return $resArr;

  }

   function view_data($id){
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



      function csv_download($search_values = NULL){
      $this->load->dbutil();
      $this->load->helper('file');
      $this->load->helper('download');
      $delimiter = ",";
      $newline = "\r\n";
      $filename = "donation_reports.csv";


      $query = "SELECT eorg.organization_name as OrganisationName,evt.title as EventName, sub_evt.schedule_title as SubEventName,chmp.display_name as ChampionPageTitle,us.email as DonationToEmail,donation_amount as AmountDonated$,evt_don.donor_message as Message,pay_hist.created_date as DonationDate,donor_name as DonationAs,evt_don.donar_organisation as DonationByOrg,evt_don.salutation as DonorSalutation,evt_don.first_name as DonorName,evt_don.email as DonorEmail,evt_don.phone as Phone,evt_don.street as Street,evt_don.suburb as Suburb,evt_don.city as City,evt_don.postal_code as PostalCode,evt_don.country as Country,evt_don.communication_required as Communication,evt_don.payment_method as PaymentMethod,evt_don.order_id as TicketingSystemOrderId,pay_hist.Txn_Number as PaymentOrderId,pay_hist.created_date as PaymentTransDate,evt_don.status as PaymentGatewayStatus";

$query .= " FROM ".$this->config->item('ems_champions','dbtables')." chmp";

  $query .= " INNER JOIN ".$this->config->item('ems_events','dbtables')." evt ON evt.id = chmp.event_id ";

  $query .= " INNER JOIN ".$this->config->item('ems_sub_events','dbtables')." sub_evt ON sub_evt.id = chmp.sub_event_id ";

  $query .= " INNER JOIN ".$this->config->item('ems_organisers_details','dbtables')." eorg ON eorg.organization_id = chmp.charity_id ";

  $query .= " INNER JOIN ".$this->config->item('ems_donations','dbtables')." evt_don ON evt_don.champion_page_id = chmp.id ";

  $query .= " INNER JOIN ".$this->config->item('ems_payment_history','dbtables')." pay_hist ON pay_hist.order_id = evt_don.order_id ";

  $query .= " INNER JOIN ".$this->config->item('ems_users','dbtables')." us ON us.id = chmp.creator_id ";




  $query .= "WHERE 1";



    if((!empty($search_values['searchby_org_id']))){

        $query .= " AND eorg.organization_id =".$search_values['searchby_org_id']."";

    }



    if((!empty($search_values['searchby_event_id']))){

        $query .= " AND evt.id =".$search_values['searchby_event_id']."";

    }

     if((!empty($search_values['searchby_sub_event_id']))){

        $query .= " AND sub_evt.id =".$search_values['searchby_sub_event_id']."";

     }

      if((!empty($search_values['from_date'])) && (!empty($search_values['to_date'])) ){
        $fromdate = new DateTime($search_values['from_date']);
        $todate = new DateTime($search_values['to_date']);
        $from=$fromdate->format('Y-m-d H:i:s');
        $to=$todate->format('Y-m-d H:i:s');
        $query .= " AND (pay_hist.created_date BETWEEN '".$from."' and '".$to."')";
     }else if((!empty($search_values['from_date']))){
        $fromdate = new DateTime($search_values['from_date']);
        $todate = new DateTime(date("Y-m-d"));
        $from=$fromdate->format('Y-m-d H:i:s');
        $to=$todate->format('Y-m-d H:i:s');
        $query .= " AND (pay_hist.created_date >= '".$from."')";
     }else if((!empty($search_values['to_date']))){
        $todate = new DateTime($search_values['to_date']);
		$to=$todate->format('Y-m-d H:i:s');
	    $query .= " AND (pay_hist.created_date <='".$to."')";
     }

      if((!empty($search_values['donation_from']))){

        $query .= " AND pay_hist.email LIKE '%".$search_values['donation_from']."%'";

     }

      if((!empty($search_values['donation_to']))){

        $query .= " AND us.email LIKE '%".$search_values['donation_to']."%'";

      }

      if((!empty($search_values['payment_type']))){

        $query .= " AND pay_hist.payment_method LIKE '%".$search_values['payment_type']."%'";

      }

       if((!empty($search_values['status']))){
         if($search_values['status']==1){
             $don_status=1;
         }

         if($search_values['status']==2){
              $don_status=0;
         }
         $query .= " AND evt_don.status =".$don_status."";
        // echo $query;exit;
       }









      $res   = $this->db->query($query);

      $resArr = $res->result_array();

      if(empty($resArr)){
        return false;
      }else{
        $data = $this->dbutil->csv_from_result($res, $delimiter, $newline);
        force_download($filename, $data);
      }
    }





}
