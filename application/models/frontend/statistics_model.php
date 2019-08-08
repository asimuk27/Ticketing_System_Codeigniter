<?php
class Statistics_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->config->load('dbtables', TRUE);		
	}
	
		
	function get_all_tickets_on_subevents($sub_event_id){
		$query  = " SELECT ticket_id";
		$query .= " FROM ticket_generated"; 
		$query .= " WHERE is_deleted = 0 AND payment_processed = 1 AND sub_event_id=".$sub_event_id;	
		$res   = $this->db->query($query);
		$resArr = $res->result_array();
        
        $free=0;
        $paid=0;
        $donation=0;	
       
		foreach($resArr as $ticket_looper){
			$query  = " SELECT ticket_type_id";
		    $query .= " FROM tickets_master"; 
		    $query .= " WHERE id=".$ticket_looper['ticket_id'];	
		    $res   = $this->db->query($query);
		    $resArr = $res->result_array();

		    if($resArr[0]['ticket_type_id']==2){
              $free++;
		    }else if($resArr[0]['ticket_type_id']==1){
              $paid++;
		    }else{
              $donation++;
		    }
		    
		}
		
		 $all_tickets_count=array('paid'=>$paid,'free'=>$free,'donation'=>$donation);
		 return $all_tickets_count;
	}
	
	
	public function get_event_info($event_id){
		$query  = " SELECT *";
		$query .= " FROM event_master"; 
		$query .= " WHERE id=".$event_id;	
		$res   = $this->db->query($query);
		$resArr = $res->result_array();



		if(count($resArr) > 0){
			return $resArr[0];
		}else{
			return false;
		}
	}
	
	// function to get price
	function get_price_by_id($type,$id){
		$query = "SELECT count(*) as count,(tg.price*count(*)) as price_d";		
		$query .= " FROM tickets_master as tm";	
		$query .= " INNER JOIN ticket_generated as tg";
		$query .= " ON tm.id = tg.ticket_id";	
		$query .= " WHERE tm.ticket_type_id = 1";
	 	if($type == 1){
			$query .= " AND tg.sub_event_id = $id";	
		}else if($type == 2){
			$query .= " AND tg.event_id = $id";	
		}		
		 
		$query .= " GROUP BY ticket_type_id";
		
		$res   = $this->db->query($query);
		$resArr = $res->result_array();	
		
	}
	
	
	
	function get_event_tickets_on_subevents($sub_event_id){
		$query  = " SELECT event_id,price";
		$query .= " FROM ticket_generated"; 
		$query .= " WHERE is_deleted = 0 AND payment_processed = 1 AND sub_event_id=".$sub_event_id."";	
		$res   = $this->db->query($query);
		$resArr = $res->result_array();
		
		if(count($resArr) > 0){
			return $resArr;
		}else{
			return false;
		}
	}
	
	 function get_pending_tickets_on_subevents_old($sub_event_id){
       $query="SELECT ticket_type_id,(tm.quantity-count(*)) as total_pending";
       $query .= " FROM tickets_master AS tm";
       $query .= " LEFT JOIN ticket_generated AS tg ON tm.id = tg.ticket_id";
       $query .= " WHERE is_deleted =0";
       $query .= " AND tg.sub_event_id =".$sub_event_id;
       $query .= " GROUP BY ticket_type_id"; 
	   
		$res   = $this->db->query($query);
		$resArr = $res->result_array();

         $count_free_pending=0;
        $count_paid_pending=0;
        $count_donation_pending=0;
    for($i=0; $i<count($resArr); $i++){
       if($resArr[$i]['ticket_type_id']==2){
         $count_free_pending=$count_free_pending+$resArr[$i]['total_pending'];
       }

       if($resArr[$i]['ticket_type_id']==1){
         $count_paid_pending=$count_paid_pending+$resArr[$i]['total_pending'];
       }

        if($resArr[$i]['ticket_type_id']==3){
         $count_donation_pending=$count_donation_pending+$resArr[$i]['total_pending'];
       }
    }

    if(count($resArr) > 0){
   $tickets_pending=array('pending_free_tickets'=>$count_free_pending,'pending_paid_tickets'=>$count_paid_pending,'pending_donation_tickets'=>$count_donation_pending);
   return $tickets_pending;
  }else{
   return false;
  }


 }
	function get_pending_tickets_on_subevents($sub_event_id){
		$count_paid_pending=0;
		$count_donation_pending =0;
		$count_free_pending=0;
			$query1  = " SELECT (quantity - quantity_sold) as quantity_available";
			$query1 .= " FROM tickets_master"; 
			$query1 .= " WHERE ticket_type_id=2 AND sub_event_id=".$sub_event_id;	
			$res2   = $this->db->query($query1);
			$resArr2 = $res2->result_array(); 

		    if(count($resArr2) > 0){
				for($i=0; $i<count($resArr2); $i++){
					$count_free_pending = $count_free_pending+$resArr2[$i]['quantity_available'];
				}
			}

			$query2  = " SELECT (quantity - quantity_sold) as quantity_available";
			$query2 .= " FROM tickets_master"; 
			$query2 .= " WHERE ticket_type_id=1 AND sub_event_id=".$sub_event_id;	
			$res3   = $this->db->query($query2);
			$resArr3 = $res3->result_array(); 

		    if(count($resArr3) > 0){
		   	  for($i=0; $i<count($resArr3); $i++){
		   	 	 $count_paid_pending = $count_paid_pending+$resArr3[$i]['quantity_available'];
		   	   }
		   }

			$query3  = " SELECT (quantity - quantity_sold) as quantity_available";
			$query3 .= " FROM tickets_master"; 
			$query3 .= " WHERE ticket_type_id=3 AND sub_event_id=".$sub_event_id;	
			$res4   = $this->db->query($query3);
			$resArr4 = $res4->result_array(); 

		    if(count($resArr4) > 0){
		   	  for($i=0; $i<count($resArr4); $i++){
		   	 	 $count_donation_pending = $count_donation_pending+$resArr4[$i]['quantity_available'];
		   	   }
		   }

		   $tickets_pending=array('pending_free_tickets'=>$count_free_pending,'pending_paid_tickets'=>$count_paid_pending,'pending_donation_tickets'=>$count_donation_pending);

			return $tickets_pending;
	}
	
	
	public function set_dropdown_data($event_id){
        $query  = " SELECT id, schedule_title";
		$query .= " FROM sub_events"; 
		$query .= " WHERE event_id=".$event_id;	
		$res   = $this->db->query($query);
		$resArr = $res->result_array();

		if(count($resArr) > 0){
			return $resArr;
		}else{
			return false;
		}
	}
	
	function get_event_tickets($event_id){
		$query  = " SELECT event_id,price";
		$query .= " FROM ticket_generated"; 
		$query .= " WHERE payment_processed = 1 AND event_id=".$event_id."";	
		$res   = $this->db->query($query);
		$resArr = $res->result_array();
		
		if(count($resArr) > 0){
			return $resArr;
		}else{
			return false;
		}
	}
	
	function get_pending_tickets($event_id){
		$query  = " SELECT id";
  $query .= " FROM ".$this->config->item('ems_sub_events','dbtables').""; 
  $query .= " WHERE event_id=".$event_id; 
  $res   = $this->db->query($query);
  $resArr = $res->result_array();
   $count_free_pending=0;
   $count_paid_pending=0;
   $count_donation_pending=0;
         

		if(count($resArr) > 0){
			foreach($resArr as $sub_event_id){
				    
                   	$query1  = " SELECT (quantity - quantity_sold) as quantity_available";
		            $query1 .= " FROM tickets_master"; 
		            $query1 .= " WHERE ticket_type_id=2 AND sub_event_id=".$sub_event_id['id'];	
		            $res2   = $this->db->query($query1);
		            $resArr2 = $res2->result_array(); 

		           if(count($resArr2) > 0){
		           	 	 for($i=0; $i<count($resArr2); $i++){
		   	 	            $count_free_pending = $count_free_pending+$resArr2[$i]['quantity_available'];
		             	 }
		           }

		           	$query2  = " SELECT (quantity - quantity_sold) as quantity_available";
		            $query2 .= " FROM tickets_master"; 
		            $query2 .= " WHERE ticket_type_id=1 AND sub_event_id=".$sub_event_id['id'];	
		            $res3   = $this->db->query($query2);
		            $resArr3 = $res3->result_array(); 

		           if(count($resArr3) > 0){
		           	 	 for($i=0; $i<count($resArr3); $i++){
		   	 	           $count_paid_pending = $count_paid_pending+$resArr3[$i]['quantity_available'];
		            	 }
		           }

		            $query3  = " SELECT (quantity - quantity_sold) as quantity_available";
		            $query3 .= " FROM tickets_master"; 
		            $query3 .= " WHERE ticket_type_id=3 AND sub_event_id=".$sub_event_id['id'];	
		            $res4   = $this->db->query($query3);
		            $resArr4 = $res4->result_array(); 

		           if(count($resArr4) > 0){
		           	 for($i=0; $i<count($resArr4); $i++){
		   	 	           $count_donation_pending = $count_donation_pending+$resArr4[$i]['quantity_available'];
		            	 } 
		           }
			}
			//echo $count_free_pending."<br>".$count_paid_pending."<br>".$count_free_pending;exit;

			$tickets_pending=array('pending_free_tickets'=>$count_free_pending,'pending_paid_tickets'=>$count_paid_pending,'pending_donation_tickets'=>$count_donation_pending);

			return $tickets_pending;
		}else{
			return false;
		}
	}
	
	public function check_event_id($event_id){
	  $query = "SELECT *";
	  $query .= " FROM " . $this->config->item('ems_events','dbtables');

	  $query .= " WHERE id = $event_id ";
	  $res   = $this->db->query($query);
	  $resArr = $res->result_array();
	  return count($resArr);
	 }
	
	function get_all_tickets($event_id){
		$query  = " SELECT ticket_id";
		$query .= " FROM ticket_generated"; 
		$query .= " WHERE is_deleted = 0 AND payment_processed = 1 AND event_id=".$event_id;	
		$res   = $this->db->query($query);
		$resArr = $res->result_array();
        
        $free=0;
        $paid=0;
        $donation=0;
		
       
		foreach($resArr as $ticket_looper){
			$query  = " SELECT ticket_type_id";
		    $query .= " FROM tickets_master"; 
		    $query .= " WHERE id=".$ticket_looper['ticket_id'];	
		    $res   = $this->db->query($query);
		    $resArr = $res->result_array();

		    if($resArr[0]['ticket_type_id']==2){
              $free++;
		    }else if($resArr[0]['ticket_type_id']==1){
              $paid++;
		    }else{
              $donation++;
		    }

		    
		}
		
		 $all_tickets_count=array('paid'=>$paid,'free'=>$free,'donation'=>$donation);
		 return $all_tickets_count;
	}
	
	
	function get_donation_summary($id,$type,$detail){				
		if($detail == "main_summary"){
			$query = "SELECT sum(donation_amount) as total_donation_value,count(distinct(donate.email)) as total_supporters,count(*) as total_donations,max(donation_amount) as maximiun_donation,avg(donation_amount) as average";
		}else if($detail == "sponsors"){
			$query = "SELECT donate.first_name,donate.email,count(*) as support_count,sum(donation_amount) as amount";
		}else if($detail == "champion"){
			$query = "SELECT champ.id,champ.display_name,sum(donation_amount) as total_donation_received";
		}
		
		$query .= " FROM " .$this->config->item('ems_organisers','dbtables'). " as a";	
		$query .= " INNER JOIN " . $this->config->item('ems_organisers_details','dbtables'). " as b";
		$query .= " ON a.id = b.organization_id";	
		$query .= " INNER JOIN " . $this->config->item('ems_organisers_finance','dbtables'). " as c";
		$query .= " ON a.id = c.organization_id";
		$query .= " INNER JOIN " . $this->config->item('ems_champions','dbtables'). " as champ";
		$query .= " ON a.id = champ.charity_id";
		$query .= " INNER JOIN " . $this->config->item('ems_donations','dbtables'). " as donate";
		$query .= " ON champ.id = donate.champion_page_id";
		$query .= " INNER JOIN " . $this->config->item('ems_events','dbtables'). " as events";
		$query .= " ON events.id = champ.event_id";
			
		if($type == "event_id"){
			$query .= " WHERE events.id = $id AND donate.status = 1";
		}else if($type == "sub_event_id"){
			$query .= " WHERE champ.sub_event_id = $id AND donate.status = 1";
		}
		
		if($detail == "sponsors"){
			$query .= " GROUP BY donate.email ORDER BY amount DESC LIMIT 0,20";
		}
		
		if($detail == "champion"){
			$query .= " GROUP BY champ.id ORDER BY total_donation_received DESC LIMIT 0,20";
		}
				
		$res  = $this->db->query($query);
		$resArr = $res->result_array();
		
		if(count($resArr) > 0){						
			return $resArr;						
		}else{
			return array();
		}
	}
	
	function get_events_of_organiser($org_id){
        $query = "SELECT id, title";
		$query .= " FROM " . $this->config->item('ems_events','dbtables');	
		
		$query .= " WHERE organiser_id = $org_id ";
		$res   = $this->db->query($query);
		$resArr = $res->result_array();
		return $resArr;
	}
}

?>