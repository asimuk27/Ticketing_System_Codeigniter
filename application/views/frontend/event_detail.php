<link rel="stylesheet" href="<?php echo $this->config->item('frontend_css_path');?>event_detail.css" type="text/css" media="all">
	<div class="content">
		<!-- Kode-Header End -->
		<div class="sub-header">
			<!-- SUB HEADER -->
		</div>
		<!-- Kode-Slider End -->
		<!--Kode-our-speaker-heading start-->
		<div class="Kode-page-heading">
			<div class="container">
				<!--ROW START-->
				<div class="row">
					<div class="col-md-6 col-sm-6">
						<h2>Event Details</h2>
					</div>					
				</div>
				<!--ROW END-->
			</div>
		</div>
		<!--Kode-our-speaker-heading End-->
		
		<div class="kode-blog-style-2">
	  	  <div class="container">
                <h4 class="text-left">
					<?php echo $event_info['0']['title'];?>
					<?php if($event_info['0']['status'] == 1){ ?>
						<a style="color:white;font-weight:bold;" class="search_event btn" href="#" onclick="
							window.open(
							  'https://www.facebook.com/sharer/sharer.php?app_id=1058287097627083&u='+encodeURIComponent(location.href), 
							  'facebook-share-dialog',
							  'width=640,height=480'); 
							return false;"> 
							<img src="<?php echo base_url();?>images/facebook_share.jpg" class="img-responsive" alt="share">
						</a>
					<?php } ?>
				</h4>
                <div class="banner_img_div" style="text-align: center;">
                    <img src="<?php echo $this->config->item('event_image').$event_info[0]['original_event_image']; ?>" class="img-responsive" alt="" style="width:inherit;">
                </div>
				<?php if($event_info['0']['status'] == 5){ ?>
					<div class="row event_cancel">
						<h5 style="color:lightgrey;font-size:40px;text-align:center;">Event Cancelled</h5>
					</div>
				<?php }else if($event_info['0']['status'] == 4){ ?>
					<div class="row event_cancel">
						<h5 style="color:lightgrey;font-size:40px;text-align:center;">Event Closed</h5>
					</div>
				<?php } ?>
                <div class="row">
               	  <div class="col-md-10 col-sm-9 col-xs-9">
					<?php $start_date = date_create($event_info[0]['event_start_date']); ?>
					<?php $start_time = date_create($event_info[0]['event_start_time']); ?>
					<?php $end_date = date_create($event_info[0]['event_end_date']); ?>
					<?php $end_time = date_create($event_info[0]['event_end_time']); ?>
					<h5 class="blue_txt text-left text-primary"><?php echo date_format($start_date,'l, F j \A\T ').date_format($start_time, 'g:i A').' - '.date_format($end_date,'l, F j \A\T ').date_format($end_time, 'g:i A');?></h5>
                  </div>                    
                </div>
                <div class="row">
                	<div class="col-md-12">
                    	<p class="text-left">
                        	<?php echo $event_info[0]['event_description']; ?>  
                        </p>
                    </div>
                </div>
                <div class="row">
                	<div class="col-md-6 col-sm-6 col-xs-6">
                    	Location: <?php echo $event_info[0]['event_location'];?>
                    </div>
                </div>
                <div class="row">
					<div class="col-md-6 col-sm-6 col-xs-6">
						Organiser: <?php if(!empty($organisation_info)){ echo $organisation_info->organization_name;} ?>
					</div>
                </div>  
				<!--<br class="clear">-->
				<div class="jumbotron add_event_jumbotron event_desc_jumbotron jumbo_padding">
                    <h5 class="text-left">Organiser Description</h5>
                        <p class="search_events text-left">
							<?php echo $event_info[0]['org_description']; ?>
                        </p>          
                </div>
				
                
                
                 <div class="event-left">
				<?php if($champion_allocation_status >= 1){ ?>
					<form action="<?php echo $this->config->item('fe_champion_search'); ?>" method="post">
						<input class="form-control" type="hidden" name="event_name" id="event_name" value="<?php echo $event_info['0']['title']; ?>">
						<input type="submit" value="View champion's for this event"  class="three_inline_buttons center-tags modalbox" style="margin-bottom:30px;cursor:pointer;width:100%;font-size:16px; padding:10px"/>
					</form>	
				<?php } ?>
				
				<?php
					if($event_info['0']['status'] == 1){

					if(isset($sub_event_info) && ($sub_event_info != "") ){
						foreach($sub_event_info as $sub_event_data){
							$sc_start_data = $sub_event_data[0]['schedule_start_date'];
							$sc_start_final=date("jS F, Y", strtotime($sc_start_data));
				?>
                <div class="search_events table-responsive table_white_box" style="margin-top:0;">
                   <h5><span style="font-size: 16px;"><?php echo $sub_event_data[0]['schedule_title']; ?></span>
				    -
					<span style="font-size: 16px;"><?php echo $sc_start_final;?></span>
				   </h5><?php
                if(isset($sub_event_data[0]['ticket_status']) && $sub_event_data[0]['ticket_status']==0){
                       if($owner_check==0 && $sub_event_data[0]['is_support_allowed']==1){
                  ?>
				  
                       <div class="row">	
			 <div class="col-md-4">
				<a href="<?php echo $this->config->item('add_champion_page'); ?>?event_id=<?php echo urlencode($event_info['0']['id']);?>&sub_event_id=<?php echo urlencode($sub_event_data[0]['id']); ?>"><button class="three_inline_buttons center-tags">Be a Champion</button></a>
							</div>
							<div class="col-md-6 include_padding">
								Want to help fundraise for this event ? Be a Champion
							</div>
                       </div>
						
                <?php }
                if($owner_check==1 && $sub_event_data[0]['is_support_allowed']==1){ ?>
                     <div class="row">
						<div class="col-md-4">
							<a href="#" class=""><button class="three_inline_buttons center-tags"  style="background-color: lightgray;">Be a Champion</button></a>
						</div>
						<div class="col-md-6 include_padding">
							Want to help fundraise for this event ? Be a Champion
						</div>
                     </div>
						
                <?php }
                }else{ ?>
                
 <table class="table-hover" id="ticket_booking" width="98%" cellpadding="5" cellspacing="2" align="center">
 
 <?php foreach($sub_event_data as $key => $individual_sub_event){
                //  echo $key;exit;
                  if($key!='sponsors' || $key=='0'){

                  if(empty($sub_event_data)){
                    if($owner_check == 0){ ?>
                     <!--<a href="<?php echo $this->config->item('add_champion_page');?>"><button class="three_inline_buttons center-tags">Be a Champion</button></a>-->

             <a class="three_inline_buttons center-tags" href="<?php echo $this->config->item('add_champion_page'); ?>?event_id=<?php echo urlencode($event_info['0']['id']);?>&sub_event_id=<?php echo urlencode($individual_sub_event['sub_event_id']); ?>">Be a Champion</a>
	
                   <?php }else{ ?>
                     <label class="three_inline_buttons center-tags" style="background-color: lightgray;">Be a Champion</label>
						
                   <?php
                     }
                  }else{

                ?>    
 
  <tr>
    <th scope="row" style="width:35%;" valign="top">Title</th>
     <td style="width:65%;"  valign="top"><?php echo $individual_sub_event['schedule_title'];?></td>
  </tr>
  <tr>
    <th scope="row"  valign="top">Time</th>
    <td  valign="top"><?php echo $individual_sub_event['schedule_start_time'];?></td>
  </tr>
  <tr>
    <th scope="row"  valign="top">Event Ticket Type</th>
    <td  valign="top"><?php echo $individual_sub_event['ticket_name'];?></td>
  </tr>
  <tr>
    <th scope="row"  valign="top">Price</th>
    <td  valign="top"><?php
                        if($individual_sub_event['ticket_type_id'] == 2){
                          echo "Free";
                        }else if($individual_sub_event['ticket_type_id'] == 1){
                          echo "$ ".number_format($individual_sub_event['price'],2);
                        }else if($individual_sub_event['ticket_type_id'] == 3){
                          echo "Donation";
                        }
                      ?></td>
  </tr>
  <tr>
   <?php  if($event_info[0]['show_remaining_tickets']==1){ ?>
	 <th scope="row"  valign="top">Ticket Sold</th>
                    <?php } ?>
    <?php  if($event_info[0]['show_remaining_tickets']==1){ ?>
                    <td   valign="top">
                        <?php
                            echo $individual_sub_event['quantity_sold'].'/'.$individual_sub_event['quantity'];
                        ?>
                    </td>
						<?php } ?>
  </tr>
    <tr>
    <th scope="row"  valign="top">Action</th>
    <td  valign="top"><?php if($individual_sub_event['out_of_stock'] == 0){ ?>
                      <?php if($owner_check == 0){ ?>
        <a href="<?php echo base_url(); ?>index.php/frontend/events/book_sub_events/<?php echo $individual_sub_event['sub_event_id']."/".$individual_sub_event['ticket_id'];  ?>" class="three_inline_buttons center-tags">Book</a>
                      <?php }else{ ?>
                      <label href="#" class="three_inline_buttons center-tags" style="background-color: lightgray;">Book</label>
                      <?php } ?>
                      <?php }else{ ?>
                        <label class="three_inline_buttons center-tags" style="background-color: lightgray;">Sold Out</label>
                      <?php } ?></td>
  
    <td  valign="top"><?php
                        if($individual_sub_event['is_support_allowed']){if($owner_check == 0){ ?>
                        <!--<a href="<?php echo $this->config->item('add_champion_page');?>"><button class="three_inline_buttons center-tags">Be a Champion</button></a>-->

                     <a class="three_inline_buttons center-tags" href="<?php echo $this->config->item('add_champion_page'); ?>?event_id=<?php echo urlencode($event_info['0']['id']);?>&sub_event_id=<?php echo urlencode($individual_sub_event['sub_event_id']); ?>">Be a Champion</a>


                      <?php }else{ ?>
                        <label class="three_inline_buttons center-tags" style="background-color: lightgray;">Be a Champion</label>
                      <?php
                        }
                        }
                      ?></td>
  <?php } ?></tr>
  
  
                <?php }}?>
</table>
     
       
						
              <?php   } ?>                       
                            <?php if(!empty($sub_event_data['sponsors'])){ ?>
								 <h5><span style="font-size: 16px;">Sponsors</span></h5><div class="row">					
                          <div class="col-md-12">  </div>

                        <?php foreach($sub_event_data['sponsors'] as $sponsers){  ?>

                          <div class="col-md-4 col-sm-4 col-xm-6">
                           <?php if($sponsers['hyperlink'] != ""){ 
						   if (substr($sponsers['hyperlink'], 0, 7) == "http://"){
									$res = $sponsers['hyperlink'];
								}else if (substr($sponsers['hyperlink'], 0, 8) == "https://"){
									$res = $sponsers['hyperlink'];
								}else{
									$res = "http://".$sponsers['hyperlink'];
								}	
						   
						   ?> <a href="<?php echo $res;?>" target="_blank">
						   <?php } ?>
                                      <img src="<?php echo base_url(); ?>/assets/image_uploads/sponsor_image/<?php echo $sponsers['sponsor_image'];?>" class="img-responsive"  alt="" style="height:100px; margin:10px 0px 10px 0px;">
                           <?php if($sponsers['hyperlink'] != ""){ ?> </a> <?php } ?>
                          </div>
                        <?php } ?>
						 </div>
                        <?php } ?>                  

                 </div>
				<?php } } } ?>
					
				<?php if($this->session->flashdata('message')){ ?>
					<div class="row">       
						<div class="col-md-12 col-sm-12 col-xs-12" id="spr" style="color: green;margin-bottom: 15px;">
							<?php echo $this->session->flashdata('message');?>
						</div>
					</div>
				<?php } ?>
				  
			<?php
				if($event_info[0]['allow_sponsor_request'] != '0'){					
			?>        
		<label data-toggle="modal" data-target="#myModal" onclick="hit_func();" class="three_inline_buttons center-tags modalbox" style="margin-bottom:30px;cursor:pointer;font-weight:normal;">Click here if you like to be a sponsor for this event</label>
			<?php } ?>
			
            </div>
            
            <div  class="event-right">
            	
				<?php if($event_info[0]['event_location_latitude'] != "" && $event_info[0]['event_location_longitude'] != ""){ ?>
				 <script src='https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyBK0eQ7Y2LugOD1v1S3n6emkWmRKdyoGqU'></script><div style='overflow:hidden;height:450px;width:100%;'><div id='gmap_canvas' style='height:450px;width:100%;'></div></div> <a href='https://addmap.net/'>&nbsp;</a> <script src='https://embedmaps.com/google-maps-authorization/script.js?id=627f60b9c8c6beb35b24b566b10816eb40a57477'></script><script>function init_map(){var myOptions = {zoom:12,center:new google.maps.LatLng(<?php echo $event_info[0]['event_location_latitude'];?>,<?php echo $event_info[0]['event_location_longitude'];?>),mapTypeId: google.maps.MapTypeId.ROADMAP};map = new google.maps.Map(document.getElementById('gmap_canvas'), myOptions);marker = new google.maps.Marker({map: map,position: new google.maps.LatLng(<?php echo $event_info[0]['event_location_latitude'];?>,<?php echo $event_info[0]['event_location_longitude'];?>)});google.maps.event.addListener(marker, 'click', function(){infowindow.open(map,marker);});infowindow.open(map,marker);}google.maps.event.addDomListener(window, 'load', init_map);</script>
				 
				<?php } ?>
                
                </div>
               <!-- <div class="col-md-12">
                     <button class="center-block add_more_btn">View Map</button>
                </div>-->
                <br class="clear">
                <br class="clear">
          </div><!--Container-->
        </div>
     </div><!--Content-->

	 <div class="col-md-2 col-sm-2 col-xs-10">
    	<form method="post" id="modalform" action="<?php echo base_url(); ?>index.php/frontend/events/save_new_sponsor_details">
    		<div id="myModal" class="modal fade" role="dialog">
    			<div class="modal-dialog modal-md">
    				<div class="modal-content">
    					<div class="modal-header">
    						<button type="button" class="close" data-dismiss="modal">&times;</button>
    						<h4 class="modal-title hr_header" id="model_title">Request to be a sponsor <span class="modal_champion_title"></span></h4>
    					</div>
    					<div class="modal-body">
                           <input type="hidden" name="event_id" value="<?php echo $event_info['0']['id']; ?>">
                           <input type="hidden" name="event_title" value="<?php echo $event_info['0']['title']; ?>">
						   <input type="hidden" name="event_organiser_id" value="<?php echo $event_info['0']['organiser_id']; ?>">
    						<div class="row">
    							<div class="col-sm-4">
    								<label>First Name</label><span class="red_span">*</span>
    							</div>
    							<div class="col-sm-6">
									<input type="text" class="form-control" name="first_name" id="first_name">
                                    <div id="first_name_error" style="color:red; font-weight:bold"></div>
    							</div>
    						</div>
							<div class="row">
    							<div class="col-sm-4">
    								<label>Last Name</label><span class="red_span">*</span>
    							</div>
    							<div class="col-sm-6">
									<input type="text" class="form-control" name="last_name" id="last_name">
                                     <div id="last_name_error" style="color:red; font-weight:bold"></div>
    							</div>
    						</div>
							<div class="row">
    							<div class="col-sm-4">
    								<label>Organisation Name</label><span class="red_span">*</span>
    							</div>
    							<div class="col-sm-6">
									<input type="text" class="form-control" name="org_name" id="org_name">
                                     <div id="org_error" style="color:red; font-weight:bold"></div>
                                    
    							</div>
    						</div>
							<div class="row">
    							<div class="col-sm-4">
    								<label>Contact Email</label><span class="red_span">*</span>
    							</div>
    							<div class="col-sm-6">
									<input type="text" class="form-control" name="email" id="email">
                                     <div id="email_error" style="color:red; font-weight:bold"></div>
    							</div>
    						</div>
							<div class="row">
    							<div class="col-sm-4">
    								<label>Contact Number</label><span class="red_span">*</span>
    							</div>
    							<div class="col-sm-6">
									<input type="text" class="form-control" name="contant_number" id="contact_number">
                                    
                                     <div id="contact_number_error" style="color:red; font-weight:bold"></div>
    							</div>
    						</div>
							<div class="row">
    							<div class="col-sm-9" style="margin-bottom:10px;">
    								Please inform us the type of sponsor you would like to be for this event.	
                                    <br>for example:
                                    monitory sponsorship,
                                    give products made by your organisation,
                                    other								
    							</div>								
    						</div>
							<div class="row">
    							<div class="col-sm-4">
    								<label>Type of Sponsorship</label><span class="red_span">*</span>
    							</div>
    							<div class="col-sm-6">
									<textarea class="form-control" name="sponsor_type" id="sponsor_type"></textarea>
                                      <div id="sponsor_error" style="color:red; font-weight:bold"></div>
                                    
    							</div>
    						</div>
							
							
    					</div>  
    					<div class="modal-footer">
    					 <input type="submit" value="Submit" style="float:left" class="btn btn-primary search_events save_sponser">
    						<button type="button" class="btn btn-default search_events" data-dismiss="modal" style="float:left">Close</button>
    						
    					</div>
    				</div>

    			</div>
    		</div> 
    	</form>
    </div>
	



<script>
$(document).ready(function(){
    //now validate all the fields
          var lname=$('#last_name').val();
          var fname=$('#first_name').val();
          var org=$('#org_name').val();
          var email=$('#email').val();
          var emailreg=/^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
          var phone=$('#contact_number').val();
          var phonereg=/^[0-9]+$/;
          var sponser=$('#sponsor_type').val();
           if(lname==''){
              $('.save_sponser').prop('disabled', true);
           }
           else if(fname==''){
               $('.save_sponser').prop('disabled', true);
           }
           else if(org==''){
              $('.save_sponser').prop('disabled', true);
           }
           else if(email==''){
              $('.save_sponser').prop('disabled', true);
           }
           else if(!emailreg.test(email)){
              $('.save_sponser').prop('disabled', true);
           }
           else if(phone==''){
              $('.save_sponser').prop('disabled', true);
           }
           else if(!phonereg.test(phone)){
              $('.save_sponser').prop('disabled', true);
           }
           else if(sponser==''){
              $('.save_sponser').prop('disabled', true);
           }
           else{
              $('.save_sponser').prop('disabled', false);
           }

         
   //validating the first name
   $('#first_name').keyup(function(){
      var fname=$(this).val();
      
     if(fname==''){
        $(this).attr('style','border-color:red');
        $('#first_name_error').text('Field is required');
     }
     else{
        $(this).attr('style','');
         $('#first_name_error').text('');
     }

    //now validate all the fields
          var lname=$('#last_name').val();
          var fname=$('#first_name').val();
          var org=$('#org_name').val();
          var email=$('#email').val();
          var emailreg=/^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
          var phone=$('#contact_number').val();
          var phonereg=/^[0-9]+$/;
          var sponser=$('#sponsor_type').val();
           if(lname==''){
              $('.save_sponser').prop('disabled', true);
           }
           else if(fname==''){
               $('.save_sponser').prop('disabled', true);
           }
           else if(org==''){
              $('.save_sponser').prop('disabled', true);
           }
           else if(email==''){
              $('.save_sponser').prop('disabled', true);
           }
           else if(!emailreg.test(email)){
              $('.save_sponser').prop('disabled', true);
           }
           else if(phone==''){
              $('.save_sponser').prop('disabled', true);
           }
           else if(!phonereg.test(phone)){
              $('.save_sponser').prop('disabled', true);
           }
           else if(sponser==''){
              $('.save_sponser').prop('disabled', true);
           }
           else{
              $('.save_sponser').prop('disabled', false);
           }

            
          
          
         



           

   });
    
    //validating last name
    $('#last_name').keyup(function(){
     var lname=$(this).val();
     var namereg =/^[a-zA-Z]+$/;
     if(lname==''){
         $(this).attr('style','border-color:red');
        $('#last_name_error').text('Field is required');
     }
     else{
         $(this).attr('style','');
         $('#last_name_error').text('');
     }


     //now validate all the fields
          var lname=$('#last_name').val();
          var fname=$('#first_name').val();
          var org=$('#org_name').val();
          var email=$('#email').val();
          var emailreg=/^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
          var phone=$('#contact_number').val();
          var phonereg=/^[0-9]+$/;
          var sponser=$('#sponsor_type').val();
           if(lname==''){
              $('.save_sponser').prop('disabled', true);
           }
           else if(fname==''){
               $('.save_sponser').prop('disabled', true);
           }
           else if(org==''){
              $('.save_sponser').prop('disabled', true);
           }
           else if(email==''){
              $('.save_sponser').prop('disabled', true);
           }
           else if(!emailreg.test(email)){
              $('.save_sponser').prop('disabled', true);
           }
           else if(phone==''){
              $('.save_sponser').prop('disabled', true);
           }
           else if(!phonereg.test(phone)){
              $('.save_sponser').prop('disabled', true);
           }
           else if(sponser==''){
              $('.save_sponser').prop('disabled', true);
           }
           else{
              $('.save_sponser').prop('disabled', false);
           }


   });

    

    //validating organisation name
    $('#org_name').keyup(function(){
       var org=$(this).val();
       
     if(org==''){
        $(this).attr('style','border-color:red');
        $('#org_error').text('Field is required');
     }
     else{
        $(this).attr('style','');
         $('#org_error').text('');
     }

      //now validate all the fields
          var lname=$('#last_name').val();
          var fname=$('#first_name').val();
          var org=$('#org_name').val();
          var email=$('#email').val();
          var emailreg=/^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
          var phone=$('#contact_number').val();
          var phonereg=/^[0-9]+$/;
          var sponser=$('#sponsor_type').val();
           if(lname==''){
              $('.save_sponser').prop('disabled', true);
           }
           else if(fname==''){
               $('.save_sponser').prop('disabled', true);
           }
           else if(org==''){
              $('.save_sponser').prop('disabled', true);
           }
           else if(email==''){
              $('.save_sponser').prop('disabled', true);
           }
           else if(!emailreg.test(email)){
              $('.save_sponser').prop('disabled', true);
           }
           else if(phone==''){
              $('.save_sponser').prop('disabled', true);
           }
           else if(!phonereg.test(phone)){
              $('.save_sponser').prop('disabled', true);
           }
           else if(sponser==''){
              $('.save_sponser').prop('disabled', true);
           }
           else{
              $('.save_sponser').prop('disabled', false);
           }


   });

    //validating email
    $('#email').keyup(function(){
       var email=$(this).val();
       var emailreg=/^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
     if(email==''){
       $(this).attr('style','border-color:red');
        $('#email_error').text('Field is required');
     }
     else if(!emailreg.test(email)){
         $(this).attr('style','border-color:red');
        $('#email_error').text('please provide valid email');
     }
     else{
        $(this).attr('style','');
         $('#email_error').text('');
     }

         //now validate all the fields
          var lname=$('#last_name').val();
          var fname=$('#first_name').val();
          var org=$('#org_name').val();
          var email=$('#email').val();
          var emailreg=/^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
          var phone=$('#contact_number').val();
          var phonereg=/^[0-9]+$/;
          var sponser=$('#sponsor_type').val();
           if(lname==''){
              $('.save_sponser').prop('disabled', true);
           }
           else if(fname==''){
               $('.save_sponser').prop('disabled', true);
           }
           else if(org==''){
              $('.save_sponser').prop('disabled', true);
           }
           else if(email==''){
              $('.save_sponser').prop('disabled', true);
           }
           else if(!emailreg.test(email)){
              $('.save_sponser').prop('disabled', true);
           }
           else if(phone==''){
              $('.save_sponser').prop('disabled', true);
           }
           else if(!phonereg.test(phone)){
              $('.save_sponser').prop('disabled', true);
           }
           else if(sponser==''){
              $('.save_sponser').prop('disabled', true);
           }
           else{
              $('.save_sponser').prop('disabled', false);
           }

   });

    //validating phone no
    $('#contact_number').keyup(function(){
       var phone=$(this).val();
       var phonereg=/^[0-9]+$/;
     if(phone==''){
         $(this).attr('style','border-color:red');
        $('#contact_number_error').text('Field is required');
     }
     else if(!phonereg.test(phone)){
         $(this).attr('style','border-color:red');
        $('#contact_number_error').text('please provide valid contact number');
     }
     else{
        $(this).attr('style','');
         $('#contact_number_error').text('');
     }

      //now validate all the fields
          var lname=$('#last_name').val();
          var fname=$('#first_name').val();
          var org=$('#org_name').val();
          var email=$('#email').val();
          var emailreg=/^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
          var phone=$('#contact_number').val();
          var phonereg=/^[0-9]+$/;
          var sponser=$('#sponsor_type').val();
           if(lname==''){
              $('.save_sponser').prop('disabled', true);
           }
           else if(fname==''){
               $('.save_sponser').prop('disabled', true);
           }
           else if(org==''){
              $('.save_sponser').prop('disabled', true);
           }
           else if(email==''){
              $('.save_sponser').prop('disabled', true);
           }
           else if(!emailreg.test(email)){
              $('.save_sponser').prop('disabled', true);
           }
           else if(phone==''){
              $('.save_sponser').prop('disabled', true);
           }
           else if(!phonereg.test(phone)){
              $('.save_sponser').prop('disabled', true);
           }
           else if(sponser==''){
              $('.save_sponser').prop('disabled', true);
           }
           else{
              $('.save_sponser').prop('disabled', false);
           }

   }); 

   $('#sponsor_type').keyup(function(){
        var sponser=$(this).val();
      
        if(sponser==''){
         $(this).attr('style','border-color:red');
        $('#sponsor_error').text('Field is required');
        }
     else{
        $(this).attr('style','');
         $('#sponsor_error').text('');
     }

       //now validate all the fields
          var lname=$('#last_name').val();
          var fname=$('#first_name').val();
          var org=$('#org_name').val();
          var email=$('#email').val();
          var emailreg=/^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
          var phone=$('#contact_number').val();
          var phonereg=/^[0-9]+$/;
          var sponser=$('#sponsor_type').val();
           if(lname==''){
              $('.save_sponser').prop('disabled', true);
           }
           else if(fname==''){
               $('.save_sponser').prop('disabled', true);
           }
           else if(org==''){
              $('.save_sponser').prop('disabled', true);
           }
           else if(email==''){
              $('.save_sponser').prop('disabled', true);
           }
           else if(!emailreg.test(email)){
              $('.save_sponser').prop('disabled', true);
           }
           else if(phone==''){
              $('.save_sponser').prop('disabled', true);
           }
           else if(!phonereg.test(phone)){
              $('.save_sponser').prop('disabled', true);
           }
           else if(sponser==''){
              $('.save_sponser').prop('disabled', true);
           }
           else{
              $('.save_sponser').prop('disabled', false);
           }

       

   }); 
 


});
</script>
