<link href="<?php echo $this->config->item('admin_css_path');?>alertify.core.css" rel="stylesheet">
<link href="<?php echo $this->config->item('admin_css_path');?>alertify.bootstrap.css" rel="stylesheet">
<link href="<?php echo $this->config->item('admin_css_path');?>alertify.default.css" rel="stylesheet">
<script src="<?php echo $this->config->item('admin_js_path');?>/alertify.min.js"></script>
<noscript>



  <style type="text/css">
	.sold_class{padding:5px;}
    .content {display:none;}
  </style>



  <div class="noscriptmsg">



    You don't have javascript enabled.  Good luck with that.



  </div>



</noscript>



<script>

$(document).ready(function(){

$(document).on("click", ".mysponsers", function () {


      var get_image_name=$(this).next('img').attr('alt');

      confirmAction(get_image_name, 'Are you sure you want to delete a sponsor ?',delete_sponsor);

 });

  function confirmAction(a_element, message, action){
    alertify.confirm(message, function(e) {
      if (e) {
        // a_element is the <a> tag that was clicked
        if (action) {
          action(a_element);
        }
      }
    });
  }

  function delete_sponsor(result){
    $.ajax({
      type: "POST",
      dataType: 'json',
      url: "<?php echo base_url(); ?>index.php/frontend/events/delete_sponsor",
      data: "sponsor_image="+result,
      success: function(Rid1) {
        if (Rid1) {
          location.reload();
          alertify.success("Sponsor deleted successfully");
        }else{
          alertify.error("error in deleteing sponsor");
        }
      }
    });
  }

  function reset(){
    $("#toggleCSS").attr("href", "<?php echo $this->config->item("admin_css_path");?>/alertify.default.css");
    alertify.set({
       labels : {
        ok     : "OK",
        cancel : "Cancel"
       },

       delay : 5000,
       buttonReverse : true,
       buttonFocus   : "ok"
    });
    }





});

</script>



<style>


.ui-widget-header .ui-icon {
		background-image: url("/images/ui-icons_444444_256x240.png") !important;
	}
	.add_more_event{margin:0px;}



	span{color:red;}



	.error{color:red;font-weight:normal;}



	.cancel_button{



		background: #00a4ef none repeat scroll 0 0;



		border: medium none;



		color: #fff;



		display: block;



		font-family: "Montserrat",sans-serif;



		font-size: 16px;



		padding: 10px 25px;



		text-decoration: none;



	}



	.img-responsives{width:26px !important;}



	.remove_extra-padding{padding:20px;}



	#no_image{margin-right:5px;}



	.img_close_div{position:relative;margin-right:20px;}

	.close_button{position:absolute;right: -17px;top: -17px;font-size:24px;}

	.sponsor_class_data{color:inherit;}

</style>



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



      <h2>Edit Event</h2>



    </div>



  </div>



  <!--ROW END-->



</div>



</div>



<!--Kode-our-speaker-heading End-->



<div class="kode-blog-style-2">



  <div class="container">



    <form class="form-horizontal" id="add_event_form" name="add_event_form" method="post" action="<?php echo base_url(); ?>index.php/frontend/events/edit_event_posted_data" enctype="multipart/form-data">



      <h5 class="blue_txt paragraph">Master Event Details</h5>



      <br class="clear">



      <div class="row">



       <div class="col-md-8 col-sm-8">



         <div class="row">



           <div class="col-md-4 col-sm-4">



             <label for="email">Title<span>*</span></label>



           </div>



           <div class="col-md-8 col-sm-8">



             <input type="text" id="title" name="title" class="required create-event-text-validator" placeholder="" value="<?php echo set_value('title',$event_info['title']);?>">



             <?php echo form_error('title'); ?>



           </div>



         </div>



       </div>



       <br class="clear">



       <div class="col-md-8 col-sm-8">



         <div class="row">



           <div class="col-md-4 col-sm-4">



             <label for="email">Location<span>*</span></label>



           </div>



           <div class="col-md-8 col-sm-8">



             <input onblur="get_address();" type="text" id="event_location" name="event_location" class="required create-event-text-validator" placeholder="" value="<?php echo set_value('event_location',$event_info['event_location']);?>">



             <input type="hidden" id="event_location_latitude" name="event_location_latitude" value="<?php echo $event_info['event_location_latitude'];?>">



             <input type="hidden" id="event_location_longitude" name="event_location_longitude" value="<?php echo $event_info['event_location_longitude'];?>">



             <?php echo form_error('event_location'); ?>



           </div>



         </div>



       </div>



       <br class="clear">



       <div class="col-md-8 col-sm-8">



         <div class="row">



           <div class="col-md-4 col-sm-4">



             <label for="email">Start Date/Time<span>*</span></label>



           </div>



           <div class="col-md-8 col-sm-8">



             <div class="row">



               <div class="col-md-6 col-sm-6">



                <input type="text" id="event_start_date" name="event_start_date" class="required create-event-text-validator" placeholder="" value="<?php echo date("d-m-Y", strtotime($event_info['event_start_date']));?>" readonly="readonly">



                <?php echo form_error('event_start_date'); ?>



              </div>



              <div class="col-md-6 col-sm-6">



                <input type="text" id="event_start_time" name="event_start_time" class="required create-event-text-validator" placeholder="" value="<?php echo set_value('event_start_time',$event_info['event_start_time']);?>" readonly="readonly">



                <?php echo form_error('event_start_time'); ?>



              </div>



            </div>



          </div>



        </div>



      </div>



      <div class="col-md-8 col-sm-8">



       <div class="row">



         <div class="col-md-4 col-sm-4">



           <label for="email">End Date/Time<span>*</span></label>



         </div>



         <div class="col-md-8 col-sm-8">



           <div class="row">



             <div class="col-md-6 col-sm-6">



              <input type="text" id="event_end_date" name="event_end_date" class="required create-event-text-validator" placeholder="" value="<?php echo date("d-m-Y", strtotime($event_info['event_end_date']));?>">



              <?php echo form_error('event_end_date'); ?>



            </div>



            <div class="col-md-6 col-sm-6">



              <input type="text" id="event_end_time" name="event_end_time" class="required create-event-text-validator" placeholder="" value="<?php echo set_value('event_end_time',$event_info['event_end_time']);?>">



              <?php echo form_error('event_end_time'); ?>



            </div>



          </div>



        </div>



      </div>



    </div>



  </div>



  <div class="row">



    <div class="col-md-8 col-sm-8">



      <div class="row">



        <div class="col-md-4 col-sm-4">



          <label for="logo">Banner Image<span>*</span>(Use 780X336 resolution image for better quality)</label>



        </div>



        <div class="col-md-8 col-sm-8">



          <div class="input-group">



            <label class="input-group-btn">



              <span class="btn btn-primary browse_btn search_events">



                Browse&hellip; <input type="file" id="logo" name="logo" class="browse_txt_box create-event-file-validator" style="display: none;" placeholder="">



              </span>



            </label>



            <input type="text" id="name" name="name" class="" placeholder="" readonly>



          </div>



        </div>



        <?php echo form_error('logo'); ?>



      </div>



    </div>



    <br class="clear" id="extra_space_logo">



    <div class="col-md-8 col-sm-8" id="extra_space_logo2">



     <div class="row">



      <div class="col-md-4 col-sm-4">



       <label for="email">&nbsp;</label>



     </div>



     <div class="col-md-8 col-sm-8" style="margin-bottom:10px;">



       <img id="blah" src="<?php echo $this->config->item('event_image');?><?php echo $event_info['original_event_image'];?>" alt="" width="200px;"/>



       <input type="hidden" name="old_uploaded_logo" value="<?php echo $event_info['original_event_image'];?>" />



       <input type="hidden" name="update_event_id" value="<?php echo $event_id; ?>" />



     </div>



   </div>



 </div>



 <br class="clear">



 <div class="col-md-8 col-sm-8">



  <div class="row">



    <div class="col-md-4 col-sm-4">



      <label for="event_description">Event Description<span>*</span></label>



    </div>



    <div class="col-md-8 col-sm-8">



     <textarea rows="5" class="form-control txt_field create-event-text-area-validator" name="event_description" id="event_description"><?php echo set_value('event_description',strip_tags($event_info['event_description']));?></textarea>



     <?php echo form_error('event_description'); ?>



   </div>



 </div>



</div>



<div class="col-md-8 col-sm-8">



  <div class="row">



    <div class="col-md-4 col-sm-4">



      <label for="org_description">Organisation Description<span>*</span></label>



    </div>



    <div class="col-md-8 col-sm-8">



      <textarea rows="5" class="form-control txt_field create-event-text-area-validator" id="org_description" name="org_description"><?php echo set_value('org_description',strip_tags($event_info['org_description']));?></textarea>



      <?php echo form_error('org_description'); ?>



    </div>



  </div>



</div>



<div class="col-md-8 col-sm-8">



  <div class="row">



    <div class="col-md-4 col-sm-4">



      <label for="donation_receipt_text">Donation Receipt Text<span>*</span></label>



    </div>



    <div class="col-md-8 col-sm-8">



      <textarea rows="5" class="form-control txt_field create-event-text-area-validator" id="donation_receipt_text" name="donation_receipt_text"><?php echo set_value('donation_receipt_text',$event_info['donation_receipt_text']);?></textarea>



      <?php //echo form_error('org_description'); ?>



    </div>



  </div>



</div>



</div>



<div class="row">



  <div class="col-md-8 col-sm-8">



   <div class="row">



     <div class="col-md-4 col-sm-4">



       <label for="email">Event Category<span>*</span></label>



     </div>



     <div class="col-md-5 col-sm-5">



       <select class="form-control dropdown search_events create-event-select-validator" id="event_category" name="event_category">



        <option value="">--- Please Select ---</option>



        <?php foreach($event_category as $category){ ?>



        <option <?php if($category->id == $event_info['event_category']){ echo "Selected";}?><?php echo set_select('event_category', $category->id); ?> value="<?php echo $category->id;?>"><?php echo $category->category_name;?></option>



        <?php } ?>



      </select><?php echo form_error('event_category'); ?>



    </div>



  </div>



</div>



</div>



<div class="row">



  <div class="col-md-8">



   <div class="row">



    <div class="col-md-4">



     <label for="event_privacy">Privacy</label>



   </div>



   <div class="col-md-3">



     <input type="radio" value="1" id="event_privacy" name="event_privacy" class="search_events" <?php if($event_info['event_privacy'] == "1"){ echo "checked=checked";}?>>&nbsp;&nbsp;<label for="event_privacy">Private Page</label>



   </div>



   <div class="col-md-3">



     <input type="radio" value="0" id="event_privacy" name="event_privacy" class="search_events"  <?php if($event_info['event_privacy'] == "0"){ echo "checked=checked";}?>>&nbsp;&nbsp;<label for="event_privacy">Public Page</label>



   </div>



 </div>



</div>



</div>



<div class="row">



  <div class="col-md-8 col-sm-8">



   <div class="row">



     <div class="col-md-4 col-sm-4">



       <label for="remaining_tickets">Remaining Tickets</label>



     </div>



     <div class="col-md-8 col-sm-8">



       <input type="checkbox" value="" id="remaining_tickets" name="remaining_tickets" <?php if($event_info['show_remaining_tickets'] == "1"){ echo "checked=checked";}?>><label class="chkbox_space">Show the number of tickets remaining on the registration page</label>



     </div>



   </div>



 </div>



</div>
<div class="row">
				<div class="col-md-8 col-sm-8">
                	<div class="row">
                    	<div class="col-md-4 col-sm-4">
							<label for="sponsor_request">Sponsors Sign up</label>
                        </div>
                        <div class="col-md-8 col-sm-8">
                        	<input <?php if($event_info['allow_sponsor_request'] == "1"){ echo "checked=checked";}?> type="checkbox" value="1" id="sponsor_request" name="sponsor_request">
							<label class="chkbox_space" for="sponsor_request" style="margin-left:0px;">Show button on event screen for users to contact you to become</label><label class="chkbox_space"> a sponsor for the event</label>
                        </div>
                    </div>
                </div>
			</div>






<br class="clear">



<!-- /// -->



<h5 class="blue_txt paragraph">Schedule Events</h5>



<br class="clear">



<!-- New HTML GOES HERE 2618 -->	<div class="panel-group" id="accordion">



<?php



$i = 1;



$sub_event_counter=1;



$m=0;



$stop_status_counter=0;



                 //echo "<pre>";



                 //print_r($sub_event_data);exit;


foreach($sub_event_data as $sub_event_details){



 $variable="sub_id_counter_".$sub_event_counter;



 $sub_event_id_loop=$sub_event_details['id'];



 echo "<input type='hidden' name='".$variable."' id='".$variable."' value=".$sub_event_id_loop." />";



 $sub_event_counter++;







 ?>



 <div style="border:0px solid #ddd;margin-bottom:10px;" class="">



  <!-- repeat section start -->



  <div class="panel panel-default repeat_event_div">



   <div class="panel-heading">



    <h4 class="panel-title">



      <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $i;?>">Sub Event <?php echo $i;?></a>



    </h4>



  </div>



  <div id="collapse<?php echo $i;?>" class="panel-collapse collapse in">



   <div class="panel-body">



    <h5 class="blue_txt paragraph">A. Event Schedule</h5>



    <div class="jumbotron add_event_jumbotron jumbo_padding" id="more_event">



      <div class="row">



       <div class="col-md-8 col-sm-8">



         <div class="row">



           <div class="col-md-4 col-sm-4">



             <label for="schedule_title_<?php echo $i;?>">Title<span>*</span></label>



           </div>



           <div class="col-md-8 col-sm-8">



             <input type="text" id="schedule_title_<?php echo $i;?>" name="schedule_title_<?php echo $i;?>" class="search_events create-event-text-validator" placeholder="" value="<?php echo $sub_event_details['schedule_title'];?>" <?php if($sub_event_details['quantity_sold_counter']>0){ echo "readonly style='background-color:#F2F3F4'"; }else{ echo "";} ?>>



           </div>



         </div>



       </div>



       <div class="col-md-8 col-sm-8">



         <div class="row">



           <div class="col-md-4 col-sm-4">



             <label for="schedule_location_<?php echo $i;?>">Location<span>*</span></label>



           </div>



           <div class="col-md-8 col-sm-8">



             <input value="<?php echo $sub_event_details['schedule_location'];?>" type="text" id="schedule_location_<?php echo $i;?>" name="schedule_location_<?php echo $i;?>" class="search_events create-event-text-validator" placeholder="" <?php if($sub_event_details['quantity_sold_counter']>0){ echo "readonly style='background-color:#F2F3F4'"; }else{ echo "";} ?>>



           </div>



         </div>



       </div>



       <div class="col-md-8 col-sm-8">



         <div class="row">



           <div class="col-md-4 col-sm-4">



             <label for="schedule_start_date">Start Date/Time<span>*</span></label>



           </div>



           <div class="col-md-8 col-sm-8">



             <div class="row">



               <div class="col-md-6 col-sm-6">



                <input onclick="generate_date_clock('<?php echo $i;?>');" value="<?php echo date("d-m-Y", strtotime($sub_event_details['schedule_start_date']));?>" type="text" id="schedule_start_date_<?php echo $i;?>" name="schedule_start_date_<?php echo $i;?>" class="search_events create-event-text-validator" placeholder="" <?php if($sub_event_details['quantity_sold_counter']>0){ echo "readonly style='background-color:#F2F3F4'"; }else{ echo "";} ?>>



              </div>



              <div class="col-md-6 col-sm-6">



                <input onclick="generate_time_clock('<?php echo $i;?>');" value="<?php echo $sub_event_details['schedule_start_time'];?>" type="text" id="schedule_start_time_1" name="schedule_start_time_<?php echo $i;?>" class="search_events create-event-text-validator" placeholder="" <?php if($sub_event_details['quantity_sold_counter']>0){ echo "readonly style='background-color:#F2F3F4'"; }else{ echo "";} ?>>



              </div>



            </div>



          </div>



        </div>



      </div>



      <div class="col-md-8 col-sm-8">



       <div class="row">



         <div class="col-md-4 col-sm-4">



           <label for="email">End Date/Time<span>*</span></label>



         </div>



         <div class="col-md-8 col-sm-8">



           <div class="row">



             <div class="col-md-6 col-sm-6">



              <input onclick="generate_date_clock('<?php echo $i;?>');" value="<?php echo date("d-m-Y", strtotime($sub_event_details['schedule_end_date']));?>" type="text" id="schedule_end_date_<?php echo $i;?>" name="schedule_end_date_<?php echo $i;?>" class="search_events create-event-text-validator" placeholder="" <?php if($sub_event_details['quantity_sold_counter']>0){ echo "readonly style='background-color:#F2F3F4'"; }else{ echo "";} ?>>



            </div>



            <div class="col-md-6 col-sm-6">



              <input onclick="generate_time_clock('<?php echo $i;?>');" value="<?php echo $sub_event_details['schedule_end_time'];?>" type="text" id="schedule_end_time_<?php echo $i;?>" name="schedule_end_time_<?php echo $i;?>" class="search_events create-event-text-validator" placeholder="" <?php if($sub_event_details['quantity_sold_counter']>0){ echo "readonly style='background-color:#F2F3F4'"; }else{ echo "";} ?>>



            </div>



          </div>



        </div>



      </div>



    </div>



    <div class="col-md-8 col-sm-8">



      <div class="row">



       <div class="col-md-4 col-sm-4">



         <label for="">Event Description<span>*</span></label>



       </div>



       <div class="col-md-8 col-sm-8">



         <textarea <?php if($sub_event_details['quantity_sold_counter']>0){ echo "readonly style='background-color:#F2F3F4'"; }else{ echo "";} ?> class="form-control txt_field create-event-text-area-validator" style="margin-bottom:0px" id="schedule_event_description_<?php echo $i;?>" name="schedule_event_description_<?php echo $i;?>"><?php echo $sub_event_details['schedule_event_description'];?> </textarea>



       </div>



     </div>







   </div>



 </div>



</div>







<h5 class="blue_txt paragraph">B. Create Ticket</h5><!--<input type="checkbox" name="no_image" id="no_image" value="1"/>No Tickets<br>-->







<div class="jumbotron add_event_jumbotron jumbo_padding create_ticket_outer_<?php echo $i;?> tick_add" style="margin-bottom:0px;">



  <div class="row create_ticket_inner">



   <div class="col-md-2 col-sm-2 col-xs-2"><label>Ticket Name &nbsp;<span>*</span></label></div>
   <div class="col-md-1 col-sm-1 col-xs-1"><label>Quantity&nbsp;<span>*</span></label></div>
   <div class="col-md-2 col-sm-2 col-xs-2"><label>Price &nbsp;<span>*</span></label></div>
   <div class="col-md-2 col-sm-2 col-xs-2"><label>Sale End Date &nbsp;<span>*</span></label></div>
   <div class="col-md-1 col-sm-1 col-xs-1"><label>MinCount&nbsp;<span>*</span></label></div>
   <div class="col-md-1 col-sm-1 col-xs-1"><label>MaxCount&nbsp;<span>*</span></label></div>
   <div class="col-md-1 col-sm-1 col-xs-1"><label>Sold</label></div>
   <div class="col-md-1 col-sm-1 col-xs-1"><label>Stop</label></div>
   <div class="col-md-1 col-sm-1 col-xs-1"><label>Action</label></div>



 </div>



 <!-- Free -->



 <input type="hidden" id="ticket_count_<?php echo $i;?>" name="ticket_count_<?php echo $i;?>" value="1">



 <input type="hidden" id="ticket_alert" name="ticket_alert">







 <?php



 $counter = 1;



 foreach($sub_event_details['sub_event_ticket_data'] as $data){

   $j=0;



   echo "<input type='hidden' name='ss' class='ticketid_stop_status_".$stop_status_counter."' value='".$data['id']."'/>";



   if($data['ticket_type_id'] == 1){



    ?>



    <input type="hidden" name="paid_ticket_id_<?php echo $i;?>[]" value="<?php echo $data['id']; ?>">



    <div class="row repeatingSection create_ticket_inner row_delete_ticket_<?php echo $stop_status_counter; ?>">



      <div class="col-md-2 col-sm-2 col-xs-2 test_div">



       <input value="<?php echo $data['ticket_name'];?>" id="paid_name_<?php echo $i;?>" name="paid_name_<?php echo $i;?>[]" class="search_events stop_status_<?php echo $stop_status_counter; ?> ticket_validates" placeholder="Paid Ticket" type="text" <?php if($data['stop_status']==1){ echo "readonly style='background-color:#F2F3F4'";}else{ echo " ";} ?>>



     </div>



     <div class="col-md-1 col-sm-1 col-xs-1">



       <input value="<?php echo $data['quantity'];?>" id="paid_quantity_<?php echo $i;?>" name="paid_quantity_<?php echo $i;?>[]" class="search_events stop_status_<?php echo $stop_status_counter; ?> ticket_validates" placeholder="100" maxlength="5" onkeypress="return isNumber(event);" type="text" <?php if($data['stop_status']==1){ echo "readonly style='background-color:#F2F3F4'";}else{ echo " ";} ?>>



     </div>



     <div class="col-md-2 col-sm-2 col-xs-2">



       <input value="<?php echo $data['price'];?>" id="paid_price_<?php echo $i;?>" name="paid_price_<?php echo $i;?>[]" class="stop_status_<?php echo $stop_status_counter; ?> search_events ticket_validates ticket_amount" placeholder="1000" type="text" <?php if($data['stop_status']==1){ echo "readonly style='background-color:#F2F3F4'";}else{ echo " ";} ?>>



     </div>



     <div class="col-md-2 col-sm-2 col-xs-2">



       <input value="<?php echo date("d-m-Y", strtotime($data['sale_end_date']));?>" id="paid_start_ticket_date_<?php echo $counter++;?>" name="paid_start_ticket_date_<?php echo $i;?>[]" class="search_events stop_status_<?php echo $stop_status_counter; ?> free_quantity ticket_validates calend_end_date" placeholder="d-m-y" readonly="" type="text" <?php if($data['stop_status']==1){ echo "readonly style='background-color:#F2F3F4'";}else{ echo " ";} ?>>



     </div>



     <div class="col-md-1 col-sm-1 col-xs-1">



       <input value="<?php echo $data['min_ticket_allowed'];?>" id="donation_max_count_<?php echo $i;?>" name="paid_max_count_<?php echo $i;?>[]" class="search_events stop_status_<?php echo $stop_status_counter; ?> free_quantity ticket_validates" placeholder="1" maxlength="2" onkeypress="return isNumber(event);" type="text" <?php if($data['stop_status']==1){ echo "readonly style='background-color:#F2F3F4'";}else{ echo " ";} ?>>



     </div>



     <div class="col-md-1 col-sm-1 col-xs-1">



       <input name="paid_order_<?php echo $i;?>[]" id="paid_order_<?php echo $i;?>" value="1478849723053" type="hidden">



       <input value="<?php echo $data['max_ticket_allowed'];?>" id="paid_min_count_<?php echo $i;?>" name="paid_min_count_<?php echo $i;?>[]" class="search_events stop_status_<?php echo $stop_status_counter; ?> free_quantity ticket_validates" placeholder="10" maxlength="2" onkeypress="return isNumber(event);" type="text" <?php if($data['stop_status']==1){ echo "readonly style='background-color:#F2F3F4'";}else{ echo " ";} ?>>



     </div>


 <div class="col-md-1 col-sm-1 col-xs-1"><?php echo $data['quantity_sold'];?></div>
     <div class="col-md-1 col-sm-1 col-xs-1">



       <input type="checkbox" id="paid_stop_<?php echo $i;?>[]" value="1" name="paid_stop_<?php echo $i;?>[]" class="stop_status stop_status_<?php echo $stop_status_counter; ?>" <?php if($data['stop_status']==1){ echo "checked";}else{ echo " ";} ?>>



     </div>



     <div class="col-md-1 col-sm-1 col-xs-1">



      <?php if($data['quantity_sold']==0){?>



      <img src="https://TicketingSystem.co.nz/assets/backend/images/close.png" class="img-responsives delete_ticket delete_ticket_<?php echo $stop_status_counter; ?>" alt="">

      <input type="hidden" id="delete_ticket_<?php echo $stop_status_counter; ?>" value="<?php echo $data['id'];?>">



      <?php } ?>



    </div>



  </div>



  <?php



}else if($data['ticket_type_id'] == 2){



  ?>



  <input type="hidden" name="free_ticket_id_<?php echo $i;?>[]" value="<?php echo $data['id']; ?>">



  <div class="row repeatingSection create_ticket_inner row_delete_ticket_<?php echo $stop_status_counter; ?>">



    <div class="col-md-2 col-sm-2 col-xs-2 test_div">



     <input value="<?php echo $data['ticket_name'];?>" id="free_name_<?php echo $i;?>" name="free_name_<?php echo $i;?>[]" class="search_events stop_status_<?php echo $stop_status_counter; ?> free_name ticket_validates" placeholder="Free Ticket" type="text" <?php if($data['stop_status']==1){ echo "readonly style='background-color:#F2F3F4'";}else{ echo " ";} ?>>



   </div>



   <div class="col-md-1 col-sm-1 col-xs-1">



     <input value="<?php echo $data['quantity'];?>" id="free_quantity_<?php echo $i;?>" name="free_quantity_<?php echo $i;?>[]" class="search_events stop_status_<?php echo $stop_status_counter; ?> free_quantity ticket_validates" placeholder="100" maxlength="5" onkeypress="return isNumber(event);" type="text" <?php if($data['stop_status']==1){ echo "readonly style='background-color:#F2F3F4'";}else{ echo " ";} ?>>



   </div>



   <div class="col-md-2 col-sm-2 col-xs-2">



     <div class="search_events">Free</div>



     <input name="free_price_<?php echo $i;?>[]" id="free_price_<?php echo $i;?>" value="0" class="free_price" type="hidden" >



   </div>



   <div class="col-md-2 col-sm-2 col-xs-2">



     <input value="<?php echo date("d-m-Y", strtotime($data['sale_end_date']));?>" id="free_start_ticket_date_<?php echo $counter++;?>" name="free_start_ticket_date_1[]" class="search_events stop_status_<?php echo $stop_status_counter; ?> free_quantity ticket_validates calend_end_date" placeholder="d-m-y" readonly="" type="text" <?php if($data['stop_status']==1){ echo "readonly style='background-color:#F2F3F4'";}else{ echo " ";} ?>>



   </div>



   <div class="col-md-1 col-sm-1 col-xs-1">



     <input value="<?php echo $data['min_ticket_allowed'];?>" id="free_max_count_<?php echo $i;?>" name="free_max_count_<?php echo $i;?>[]" class="search_events stop_status_<?php echo $stop_status_counter; ?> free_quantity ticket_validates" placeholder="1" maxlength="2" onkeypress="return isNumber(event);" type="text" <?php if($data['stop_status']==1){ echo "readonly style='background-color:#F2F3F4'";}else{ echo " ";} ?>>



   </div>



   <div class="col-md-1 col-sm-1 col-xs-1">



     <input name="free_order_<?php echo $i;?>[]" id="free_order_<?php echo $i;?>" value="1478849356168" type="hidden">



     <input value="<?php echo $data['max_ticket_allowed'];?>" id="free_min_count_1<?php echo $i;?>" name="free_min_count_<?php echo $i;?>[]" class="search_events stop_status_<?php echo $stop_status_counter; ?> free_quantity ticket_validates" placeholder="10" maxlength="2" onkeypress="return isNumber(event);" type="text" <?php if($data['stop_status']==1){ echo "readonly style='background-color:#F2F3F4'";}else{ echo " ";} ?>>



   </div>


   <div class="col-md-1 col-sm-1 col-xs-1"><?php echo $data['quantity_sold'];?></div>
   <div class="col-md-1 col-sm-1 col-xs-1">



     <input type="checkbox" id="free_stop_<?php echo $i;?>[]" value="1" name="free_stop_<?php echo $i;?>[]" class="stop_status stop_status_<?php echo $stop_status_counter; ?>" <?php if($data['stop_status']==1){ echo "checked";}else{ echo " ";} ?>>



   </div>



   <div class="col-md-1 col-sm-1 col-xs-1">



    <?php if($data['quantity_sold']==0){?>



    <img src="https://TicketingSystem.co.nz/assets/backend/images/close.png" class="img-responsives delete_ticket delete_ticket_<?php echo $stop_status_counter; ?>" alt="">

    <input type="hidden" id="delete_ticket_<?php echo $stop_status_counter; ?>" value="<?php echo $data['id'];?>">



    <?php } ?>



  </div>



</div>



<?php



}else if($data['ticket_type_id'] == 3){



 ?>



 <input type="hidden" name="donation_ticket_id_<?php echo $i;?>[]" value="<?php echo $data['id']; ?>">



 <div class="row repeatingSection create_ticket_inner row_delete_ticket_<?php echo $stop_status_counter; ?>">



  <div class="col-md-2 col-sm-2 col-xs-2 test_div">



   <input value="<?php echo $data['ticket_name'];?>" id="donation_name_<?php echo $i;?>" name="donation_name_<?php echo $i;?>[]" class="search_events stop_status_<?php echo $stop_status_counter; ?> ticket_validates" placeholder="Donation Ticket" type="text" <?php if($data['stop_status']==1){ echo "readonly style='background-color:#F2F3F4'";}else{ echo " ";} ?>>



 </div>



 <div class="col-md-1 col-sm-1 col-xs-1">



   <input value="<?php echo $data['quantity'];?>" id="donation_quantity_<?php echo $i;?>" name="donation_quantity_<?php echo $i;?>[]" class="search_events stop_status_<?php echo $stop_status_counter; ?> ticket_validates" placeholder="100" maxlength="5" onkeypress="return isNumber(event);" type="text" <?php if($data['stop_status']==1){ echo "readonly style='background-color:#F2F3F4'";}else{ echo " ";} ?>>



 </div>



 <div class="col-md-2 col-sm-2 col-xs-2"><div class="search_events">Donation</div>



 <input name="free_donation_<?php echo $i;?>[]" id="free_donation_<?php echo $i;?>" value="0" type="hidden">



</div>



<div class="col-md-2 col-sm-2 col-xs-2">



 <input value="<?php echo date("d-m-Y", strtotime($data['sale_end_date']));?>" id="donation_start_ticket_date_<?php echo $counter++;?>" name="donation_start_ticket_date_<?php echo $i;?>[]" class="search_events stop_status_<?php echo $stop_status_counter; ?> free_quantity stop_status_<?php echo $stop_status_counter; ?> ticket_validates calend_end_date" placeholder="d-m-y" readonly="" type="text" <?php if($data['stop_status']==1){ echo "readonly style='background-color:#F2F3F4'";}else{ echo " ";} ?>>



</div>



<div class="col-md-1 col-sm-1 col-xs-1">



 <input value="<?php echo $data['min_ticket_allowed'];?>" id="donation_max_count_<?php echo $i;?>" name="donation_max_count_<?php echo $i;?>[]" class="search_events stop_status_<?php echo $stop_status_counter; ?> free_quantity ticket_validates" placeholder="1" maxlength="2" onkeypress="return isNumber(event);" type="text" <?php if($data['stop_status']==1){ echo "readonly style='background-color:#F2F3F4'";}else{ echo " ";} ?>>



</div>



<div class="col-md-1 col-sm-1 col-xs-1">



 <input name="donation_order_<?php echo $i;?>[]" id="donation_order_<?php echo $i;?>" value="1478849956967" type="hidden">



 <input value="<?php echo $data['max_ticket_allowed'];?>" id="donation_min_count_<?php echo $i;?>" name="donation_min_count_<?php echo $i;?>[]" class="search_events stop_status_<?php echo $stop_status_counter; ?> free_quantity ticket_validates" placeholder="10" maxlength="2" onkeypress="return isNumber(event);" type="text" <?php if($data['stop_status']==1){ echo "readonly style='background-color:#F2F3F4'";}else{ echo " ";} ?>>



</div>


 <div class="col-md-1 col-sm-1 col-xs-1"><?php echo $data['quantity_sold'];?></div>
<div class="col-md-1 col-sm-1 col-xs-1">



 <input type="checkbox" id="donation_stop_<?php echo $i;?>[]" value="1" name="donation_stop_<?php echo $i;?>[]" class="stop_status stop_status_<?php echo $stop_status_counter; ?>" <?php if($data['stop_status']==1){ echo "checked";}else{ echo " ";} ?> >



</div>



<div class="col-md-1 col-sm-1 col-xs-1">



  <?php if($data['quantity_sold']==0){?>



  <img src="https://TicketingSystem.co.nz/assets/backend/images/close.png" class="img-responsives delete_ticket delete_ticket_<?php echo $stop_status_counter; ?>" alt="">

  <input type="hidden" id="delete_ticket_<?php echo $stop_status_counter; ?>" value="<?php echo $data['id'];?>">



  <?php } ?>



</div>



</div>



<?php



}



$stop_status_counter++;







} ?>



</div><!--Jumbotron-->



<br class="clear">







<?php



			//



?>



<div class="row">



  <div class="col-md-12">



    <div class="row">



     <div class="col-md-2 col-sm-4 col-xs-12">



       <button type="button" class="center-block submit_btn search_events tick_add" onclick="add_more_tickets('free',<?php echo $i;?>);">+ Free Ticket</button>



     </div>



     <div class="col-md-2 col-sm-4 col-xs-12">



      <button onclick="add_more_tickets('paid',<?php echo $i;?>);" type="button" class="center-block submit_btn  search_events tick_add">+ Paid Ticket</button>



    </div>



    <div class="col-md-2 col-sm-4 col-xs-12">



      <button onclick="add_more_tickets('donation',<?php echo $i;?>);" type="button" class="center-block submit_btn  search_events tick_add">+ Donation</button>



    </div>



  </div>



</div>



</div>



<br class="clear">



<div class="row">



  <div class="col-md-12">



    <h5 class="blue_txt paragraph">C. Add a Sponsors</h5><br>



    <div class="col-md-8">



      <div class="row">



        <div class="col-md-4 col-sm-4">



          <label for="sponsor_image" class="align_to_txt_box">Image(Max size 200kb)</label>



        </div>



        <div class="col-md-8 col-sm-8">



          <div class="input-group">



           <label class="input-group-btn">



            <span class="btn btn-primary browse_btn search_events">



              Browse… <input onchange="add_sponsor_check(<?php echo $i;?>);" id="sponsor_image_<?php echo $i;?>" name="sponsor_image_<?php echo $i;?>" class="browse_txt_box create-event-file-validator" style="display: none;" placeholder="" type="file">



            </span>



          </label>



          <input id="name" name="name" class="search_events" placeholder="" readonly="" type="text">



        </div>



      </div>



    </div>



  </div>



  <div class="col-md-8" style="display:none;" id="preview_sponsor_div_<?php echo $i;?>">



    <div class="row">



      <div class="col-md-4 col-sm-4">



        <label class="align_to_txt_box">&nbsp;</label>



      </div>



      <div class="col-md-8 col-sm-8">



        <div class="input-group">



         <img id="sponsor_preview_<?php echo $i;?>" src="#" alt="" width="200px;"/>



       </div>



     </div>



   </div>



 </div>



 <div class="col-md-8">



  <div class="row">



   <div class="col-md-4 col-sm-4">



    <label for="hyperlink" class="align_to_txt_box">Hyperlink</label>



  </div>



  <div class="col-md-8 col-sm-8">



    <input id="hyperlink_<?php echo $i;?>" name="hyperlink_<?php echo $i;?>" class="search_events" placeholder=""  type="text">



    <label style="display:none;" id="sponsor_error_<?php echo $i;?>"></label>



    <button id="add_sponsors_<?php echo $i;?>" type="button" class="submit_btn search_events" onclick="add_sponsor_data_sub_event(<?php echo $i;?>,<?php echo $sub_event_details['id']; ?>,<?php echo $event_info['id']; ?>);">Add Sponsors</button>



    <img alt="loading..." style="display:none;width:150px;height:30px;" id="buttonreplacement_<?php echo $i;?>" src="<?php echo $this->config->item('frontend_image_path');?>images/ajax-loader.gif">



  </div>



</div>



</div>



<br class="clear">



<div class="jumbotron remove_extra-padding">



  <ul class="list-inline list-unstyled preview_content_<?php echo $i;?>">

  <?php  foreach($sub_event_details['sub_event_sponsor_data'] as $sponsor_data){ ?>

  <li><div class="img_close_div"><a class="sponsor_class_data mysponsers" href="javascript:void(0);" ><div class="close_button" ><i class="fa fa-times-circle" aria-hidden="true"></i></div></a><img style="width:60px;height:60px;" src="<?php echo base_url(); ?>/assets/image_uploads/sponsor_image/<?php echo $sponsor_data['sponsor_image'];?>" class="img-responsive" alt="<?php echo $sponsor_data['sponsor_image']; ?>"></img></div></li>
  <?php } ?>



                           <!-- <li>



	<img src="<?php echo $this->config->item('admin_image_path');?>adidas_small.png" class="img-responsive" alt="">



	</li> -->


 </ul>



          </div>







          <div class="col-md-12">



            <div class="row">



             <h5 class="blue_txt paragraph margin_down">D. Champions </h5>



             <div class="col-md-3">



              <label for="is_supporter_allowed">Champions Allowed</label>&nbsp;&nbsp;<input type="checkbox" id="is_supporter_allowed_<?php echo $i;?>" name="is_supporter_allowed_<?php echo $i;?>" class="adjust_checkbox" value="1" <?php if($sub_event_details['is_support_allowed'] == "1"){ echo "checked=checked";}?>>



            </div>



            <div class="col-md-3">



              <label for="verify_supporter">Verify Champions</label>&nbsp;&nbsp;<input type="checkbox" id="verify_supporter_<?php echo $i;?>" name="verify_supporter_<?php echo $i;?>" class="adjust_checkbox" value="1" <?php if($sub_event_details['verify_supporter'] == "1"){ echo "checked=checked";}?>>



              <input type="hidden" id="organiser_id" name="organiser_id" class="" value="">



              <input type="hidden" id="free_ticket_count" name="free_ticket_count" class="" value="0">



              <input type="hidden" id="paid_ticket_count" name="paid_ticket_count" class="" value="0">



              <input type="hidden" id="donation_ticket_count" name="donation_ticket_count" class="" value="0">



            </div>







          </div>



        </div>



      </div>



    </div>



  </div><!--1-->



</div><!--2-->



</div><!--3-->



</div>







<?php



$i++;



}



?>



</div><!--Repeating Div-->



<!-- sub event ends -->



<div class="row">



  <div class="col-md-12" id="sub_event_validation_message" style="display:none;color:red;">



   <label style="font-weight: normal;">Please fill in all necessery sub event details</label>



 </div>



 <div class="col-md-2 tick_add">



   <button onclick="validateAllInputBoxes(this);" type="button" class="center-block add_more_btn add_more_event search_event three_inline_buttons tick_add" style="display:inline;padding:10px;margin-top:10px;">Add More Events</button>



 </div>



 <div class="col-md-1">



   <input type="hidden" id="dynamic_event_count" name="dynamic_event_count" class="" value="<?php echo $dynamic_event_count;?>">


   <?php if($event_info['status']!=1){ ?>
   <button type="submit" class="three_inline_buttons" style="display:inline;margin-right:30px;margin-top:10px;" id="submit_event_data">Save</button>
   <?php } ?>
 </div>

 <?php if($event_info['status']!=3 && $event_info['status']!=4){ ?>
 <div class="col-md-3">
    <button type="submit" name="save_and_publish" class="three_inline_buttons" style="display:inline;margin-top:10px;margin-left: 30px;" id="submit_event_data">Save and publish</button>

 </div>
 <?php } ?>

 <input type="hidden" name="status_type" value="<?php echo $event_info['status']; ?>" />



 <div class="col-md-2">



   <button type="button" class="three_inline_buttons" style="display:inline;margin-top:10px;margin-left: 10px;" onclick="go_back();">Cancel</button>



 </div>



</div>



<?php //echo $sub_event_counter;?>



<input type="hidden" name="sub_event_counter" value="<?php echo $sub_event_counter; ?>" id="sub_event_counter"/>



</form>



</div> </div>



</div><!--Container-->



<link href="<?php echo $this->config->item('frontend_css_path');?>jquery-ui.css" rel="stylesheet">



<script src="<?php echo $this->config->item('frontend_js_path');?>jquery-ui.min.js"></script>







<link href="<?php echo $this->config->item('frontend_css_path');?>timepicki.css" rel="stylesheet">







<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">



<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>



<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyBK0eQ7Y2LugOD1v1S3n6emkWmRKdyoGqU"></script>



<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>



<!-- <script src="<?php echo $this->config->item('frontend_js_path');?>clone.js"></script> -->



<script src="<?php echo $this->config->item('frontend_js_path');?>jquery.blockUI.js"></script>











<script src="<?php echo $this->config->item('frontend_js_path');?>timepicki.js"></script>







<?php $image_url = $this->config->item('sponsor_image_url');?>



<script>



	$("#no_image").click(function() {



    if($(this).is(":checked")) {



      $(".tick_add").hide(300);



    } else {



      $(".tick_add").show(200);



    }



  });



			$('#submit_event_data').click(function(e) {



		var isValid = true;

		$('.create-event-text-validator').each(function() {

			if ($.trim($(this).val()) == '') {

				isValid = false;

				$(this).css({

					"border": "1px solid red",

				});

			} else {

				$(this).css({

				"border": "",

				});

			}

		});





			$('.ticket_validates').each(function() {

				if ($.trim($(this).val()) == '') {

					isValid = false;

					$(this).css({

						"border": "1px solid red",

					});

				} else {

					$(this).css({

					"border": "",

					"background": ""

					});

				}

			});





	 	$('.create-event-text-area-validator').each(function() {

			if ($.trim($(this).val()) == '') {

				isValid = false;

				$(this).css({

					"border": "1px solid red",

				//	"background": "#FFCECE"

				});

			} else {

				$(this).css({

				"border": "",

				"background": ""

				});

			}

		});





		// get ready focus

		$('.create-event-text-validator').each(function() {

			if ($.trim($(this).val()) == '') {

				isValid = false;

				$(this).css({

					"border": "1px solid red",

				});

				$(this).focus();

				return false;

			} else {

				$(this).css({

				"border": "",

				});

			}

		});



		if(!isValid){

			return false;

		}



			$('.ticket_validates').each(function() {

				if ($.trim($(this).val()) == '') {

					isValid = false;

					$(this).css({

						"border": "1px solid red",

					//	"background": "#FFCECE"

					});

					$(this).focus();

					e.preventDefault();

					return false;

				} else {

					$(this).css({

					"border": "",

					"background": ""

					});

				}

			});







	});













  $('body').on('focus',".calend_end_date", function(){



    $(this).datepicker({



     changeMonth: true,



     changeYear: true,



     dateFormat: 'dd-mm-yy',



     yearRange: "+0:+100",



     minDate: 1,



   });



  });







  function validate(evt){



   evt.value = evt.value.replace(/[^0-9]/g,"");



 }







 function isNumber(evt) {



  evt = (evt) ? evt : window.event;



  var charCode = (evt.which) ? evt.which : evt.keyCode;



  if (charCode > 31 && (charCode < 48 || charCode > 57)) {



    return false;



  }



  return true;



}







function go_back(){



  window.location = "<?php echo $this->config->item('base_url');?>index.php/frontend/events/manage_events";



}







function add_more_tickets(result,page_count){







		//$(".error").css("display", "none");







		var sub_event_size = document.querySelectorAll('.repeat_event_div').length;







		sub_event_size = page_count;







		var sale_end_date = document.getElementById('schedule_end_date_'+sub_event_size).value;







		var milliseconds = new Date().getTime();







		var free_html = '<div class="row repeatingSection create_ticket_inner"><div class="col-md-2 col-sm-2 col-xs-2 test_div"><input type="text" id="free_name_'+sub_event_size+'" name="free_name_'+sub_event_size+'[]" class="search_events free_name ticket_validates" placeholder="Free Ticket"></div><div class="col-md-1 col-sm-1 col-xs-1">			<input type="text" id="free_quantity_'+sub_event_size+'" name="free_quantity_'+sub_event_size+'[]" class="search_events free_quantity ticket_validates" placeholder="100" maxlength="5" onkeypress="return isNumber(event);"></div>	<div class="col-md-2 col-sm-2 col-xs-2"><div class="search_events">Free</div><input type="hidden" name="free_price_'+sub_event_size+'[]" id="free_price_'+sub_event_size+'" value="0" class="free_price"></div><div class="col-md-2 col-sm-2 col-xs-2"><input value="'+sale_end_date+'" type="text" id="free_start_ticket_date_'+sub_event_size+milliseconds+'" name="free_start_ticket_date_'+sub_event_size+'[]" class="search_events free_quantity ticket_validates calend_end_date" placeholder="d-m-y" readonly></div><div class="col-md-1 col-sm-1 col-xs-1"><input type="text" id="free_max_count_'+sub_event_size+'" name="free_max_count_'+sub_event_size+'[]" class="search_events free_quantity ticket_validates" placeholder="1" maxlength="2" onkeypress="return isNumber(event);"></div><div class="col-md-1 col-sm-1 col-xs-1"><input type="hidden" name="free_order_'+sub_event_size+'[]" id="free_order_'+sub_event_size+'" value="'+milliseconds+'"><input type="text" id="free_min_count_'+sub_event_size+'" name="free_min_count_'+sub_event_size+'[]" class="search_events free_quantity ticket_validates" placeholder="10" maxlength="2" onkeypress="return isNumber(event);"></div><div class="col-md-1 col-sm-1 col-xs-1 sold_class">0</div><div class="col-md-1 col-sm-1 col-xs-1"></div><div class="col-md-1 col-sm-1 col-xs-1"><img src="<?php echo $this->config->item('admin_image_path');?>close.png" class="img-responsives delete_ticket" alt=""></div></div>';
		var donation_html = '<div class="row repeatingSection create_ticket_inner"><div class="col-md-2 col-sm-2 col-xs-2 test_div">	<input type="text" id="donation_name_'+sub_event_size+'" name="donation_name_'+sub_event_size+'[]" class="search_events ticket_validates" placeholder="Donation Ticket"></div><div class="col-md-1 col-sm-1 col-xs-1"><input type="text" id="donation_quantity_'+sub_event_size+'" name="donation_quantity_'+sub_event_size+'[]" class="search_events ticket_validates" placeholder="100" maxlength="5" onkeypress="return isNumber(event);"></div><div class="col-md-2 col-sm-2 col-xs-2"><div class="search_events">Donation</div><input type="hidden" name="free_donation_'+sub_event_size+'[]" id="free_donation'+sub_event_size+'" value="0"></div><div class="col-md-2 col-sm-2 col-xs-2"><input value="'+sale_end_date+'" type="text" id="donation_start_ticket_date_'+sub_event_size+milliseconds+'" name="donation_start_ticket_date_'+sub_event_size+'[]" class="search_events free_quantity ticket_validates calend_end_date" placeholder="d-m-y" readonly></div><div class="col-md-1 col-sm-1 col-xs-1"><input type="text" id="donation_max_count_'+sub_event_size+'" name="donation_max_count_'+sub_event_size+'[]" class="search_events free_quantity ticket_validates" placeholder="1" maxlength="2" onkeypress="return isNumber(event);"></div><div class="col-md-1 col-sm-1 col-xs-1"><input type="hidden" name="donation_order_'+sub_event_size+'[]" id="donation_order_'+sub_event_size+'" value="'+milliseconds+'"><input type="text" id="donation_min_count_'+sub_event_size+'" name="donation_min_count_'+sub_event_size+'[]" class="search_events free_quantity ticket_validates" placeholder="10" maxlength="2" onkeypress="return isNumber(event);"></div><div class="col-md-1 col-sm-1 col-xs-1 sold_class">0</div><div class="col-md-1 col-sm-1 col-xs-1"></div><div class="col-md-1 col-sm-1 col-xs-1"><img src="<?php echo $this->config->item('admin_image_path');?>close.png" class="img-responsives delete_ticket" alt=""></div></div>';
		var paid_html = '<div class="row repeatingSection create_ticket_inner"><div class="col-md-2 col-sm-2 col-xs-2 test_div"><input type="text" id="paid_name_'+sub_event_size+'" name="paid_name_'+sub_event_size+'[]" class="search_events ticket_validates" placeholder="Paid Ticket"></div><div class="col-md-1 col-sm-1 col-xs-1"><input type="text" id="paid_quantity_'+sub_event_size+'" name="paid_quantity_'+sub_event_size+'[]" class="search_events ticket_validates" placeholder="100" maxlength="5" onkeypress="return isNumber(event);"></div><div class="col-md-2 col-sm-2 col-xs-2"><input type="text" id="paid_price_'+sub_event_size+'" name="paid_price_'+sub_event_size+'[]" class="ticket_amount search_events ticket_validates" placeholder="1000"></div><div class="col-md-2 col-sm-2 col-xs-2"><input value="'+sale_end_date+'" type="text" id="paid_start_ticket_date_'+sub_event_size+milliseconds+'" name="paid_start_ticket_date_'+sub_event_size+'[]" class="search_events free_quantity ticket_validates calend_end_date" placeholder="d-m-y" readonly></div><div class="col-md-1 col-sm-1 col-xs-1"><input type="text" id="donation_max_count_'+sub_event_size+'" name="paid_max_count_'+sub_event_size+'[]" class="search_events free_quantity ticket_validates" placeholder="1" maxlength="2" onkeypress="return isNumber(event);"></div><div class="col-md-1 col-sm-1 col-xs-1"><input type="hidden" name="paid_order_'+sub_event_size+'[]" id="paid_order_'+sub_event_size+'" value="'+milliseconds+'"><input type="text" id="paid_min_count_'+sub_event_size+'" name="paid_min_count_'+sub_event_size+'[]" class="search_events free_quantity ticket_validates" placeholder="10" maxlength="2" onkeypress="return isNumber(event);"></div><div class="col-md-1 col-sm-1 col-xs-1 sold_class">0</div><div class="col-md-1 col-sm-1 col-xs-1"></div><div class="col-md-1 col-sm-1 col-xs-1"><img src="<?php echo $this->config->item('admin_image_path');?>close.png" class="img-responsives delete_ticket" alt="">	</div></div>';

		if(result == 'free'){
			var data_out = free_html;
		}else if(result == 'paid'){
			var data_out = paid_html;
		}else if(result == 'donation'){
			var data_out = donation_html;
		}







		//e.preventDefault();



		var lastRepeatingGroup = $('.repeatingSection').last();



		$(".create_ticket_outer_"+page_count).append(data_out);







		var ticket_size_count = document.getElementById('ticket_count_1').value = sub_event_size+1;







		$("#add_event_form").validate();







	}















	$('#event_start_time').timepicki();



	$('#event_end_time').timepicki();



	$('#schedule_start_time_1').timepicki();



	$('#schedule_end_time_1').timepicki();











	$('#event_end_time').blur(function(){



		$('#schedule_end_time_1').val(this.value);



	});











	$('#event_start_time').blur(function(){



		$('#schedule_start_time_1').val(this.value);



	});















	function remove(link){



		//document.getElementById('sponsor_error').style.display = 'none';



		var image_name = link.getAttribute('alt');



		//link.parentNode.parentNode.removeChild(link.parentNode);



		$.ajax({



			type: "POST",



			url: "<?php echo $this->config->item('base_url');?>index.php/frontend/events/remove_sponsor_images",



			data: "image_name="+image_name,



			success: function(data){



				link.parentNode.parentNode.removeChild(link.parentNode);



			}



		});



	}







	function add_sponsor_data(){



		if ($('#sponsor_image').get(0).files.length === 0) {



			document.getElementById('sponsor_error').style.display = 'block';



			document.getElementById('sponsor_error').style.color = 'red';



			document.getElementById('sponsor_error').innerHTML = 'Please upload sponsor image';



			return false;



		}



		var formData = new FormData($('form')[0]);







		document.getElementById("add_sponsors").style.display = "none"; // to undisplay



		document.getElementById("buttonreplacement").style.display = ""; // to display







   $.ajax({



    type: "POST",



    url: "<?php echo $this->config->item('base_url');?>index.php/frontend/events/sponsor_data",



    data: formData,



    contentType: false,



    cache: false,



    processData:false,



    success: function(data){



     var json = $.parseJSON(data);



     if(json.status == 1){



				document.getElementById("add_sponsors").style.display = ""; // to undisplay

				document.getElementById("buttonreplacement").style.display = "none"; // to display

				document.getElementById("add_sponsors").bgcolor = 'grey';

				document.getElementById('sponsor_error').style.display = 'block';

				document.getElementById('sponsor_error').style.color = 'green';

				document.getElementById('sponsor_error').innerHTML = "Image successfully uploaded";

				document.getElementById('hyperlink').value = "";

				document.getElementById('sponsor_image').value = "";

				document.getElementById('preview_sponsor_div').style.display = 'none';



			//	$(".preview_content").append('<li><img onclick="remove(this)" style="width:60px;height:60px;" src="<?php echo $image_url;?>'+json.message+'" class="img-responsive" alt="'+json.message+'"></img></li>');

				$(".preview_content").append('<li><div class="img_close_div"><a class="sponsor_class_data mysponsers" href="javascript:void(0);"><div class="close_button" ><i class="fa fa-times-circle" aria-hidden="true"></i></div></a><img style="width:60px;height:60px;" src="<?php echo $image_url;?>'+json.message+'" class="img-responsive" alt="'+json.message+'"></img></div></li>');



			}else{

				document.getElementById("add_sponsors").style.display = ""; // to undisplay

				document.getElementById("buttonreplacement").style.display = "none"; // to display

				document.getElementById("add_sponsors").bgcolor = '#00a4ef';

				document.getElementById('sponsor_error').style.display = 'block';

				document.getElementById('sponsor_error').style.color = 'red';

				document.getElementById('sponsor_error').innerHTML = json.message;

			}



		}



	});



 }







 function add_sponsor_data_sub_event(id_value, sub_event_key, event_key){
 //alert(event_key);



  if ($('#sponsor_image_'+id_value).get(0).files.length === 0) {

   document.getElementById('sponsor_error_'+id_value).style.display = 'block';
   document.getElementById('sponsor_error_'+id_value).style.color = 'red';
   document.getElementById('sponsor_error_'+id_value).innerHTML = 'Please upload sponsor image';
   return false;



 }



    var formData = new FormData($('form')[0]);
		document.getElementById("add_sponsors_"+id_value).style.display = "none"; // to undisplay
		document.getElementById("buttonreplacement_"+id_value).style.display = ""; // to display


    $.ajax({
    type: "POST",
    url: "<?php echo $this->config->item('base_url');?>index.php/frontend/events/sponsor_sub_event_data_edit?id_value="+id_value+"&sub_event_key="+sub_event_key+"&event_key="+event_key,
    data: formData,
    contentType: false,
    cache: false,
    processData:false,




    success: function(data){

     var json = $.parseJSON(data);
     if(json.status == 1){

				document.getElementById("add_sponsors_"+id_value).style.display = ""; // to undisplay
				document.getElementById("buttonreplacement_"+id_value).style.display = "none"; // to display
				document.getElementById("add_sponsors_"+id_value).bgcolor = 'grey';
				document.getElementById('sponsor_error_'+id_value).style.display = 'block';
				document.getElementById('sponsor_error_'+id_value).style.color = 'green';
				document.getElementById('sponsor_error_'+id_value).innerHTML = "Image successfully uploaded";
				document.getElementById('hyperlink_'+id_value).value = "";
				document.getElementById('sponsor_image_'+id_value).value = "";
				document.getElementById('preview_sponsor_div_'+id_value).style.display = 'none';



				$(".preview_content_"+id_value).append('<li><div class="img_close_div"><a class="sponsor_class_data mysponsers" href="javascript:void(0);"><div class="close_button" ><i class="fa fa-times-circle" aria-hidden="true"></i></div></a><img style="width:60px;height:60px;" src="<?php echo $image_url;?>'+json.message+'" class="img-responsive" alt="'+json.message+'"></img></div></li>');



			}else{


				document.getElementById("add_sponsors_"+id_value).style.display = ""; // to undisplay
				document.getElementById("buttonreplacement_"+id_value).style.display = "none"; // to display
				document.getElementById("add_sponsors_"+id_value).bgcolor = '#00a4ef';
				document.getElementById('sponsor_error_'+id_value).style.display = 'block';
				document.getElementById('sponsor_error_'+id_value).style.color = 'red';
				document.getElementById('sponsor_error_'+id_value).innerHTML = json.message;



			}



		}



	});



 }







 (function($,W,D){



  var user_validation = {};







  user_validation.UTIL =



  {



    setupFormValidation: function()



    {



            //form validation rules



            $("#add_event_form").validate({



              ignore: "",



              rules: {



                title: {



                  required: true,



                },



                ticket_alert: {



                  checkTicketCount:true,



                },



                event_location: {



                  required: true,



                },



                event_start_date: {



                  required: true,



                },



                event_start_time: {



                  required: true,



                },



                event_end_date: {



                  required: true,



                },



                event_end_time: {



                  required: true,



                },



                event_description: {



                  required: true,



                },



                org_description: {



                  required: true,



                },



                donation_receipt_text: {



                  required: true,



                },



                event_category: {



                  required: true,



                },



                'schedule_title_1': {



                  required: true,



                },



                schedule_location_1: {



                  required: true,



                },



                schedule_start_date_1: {



                  required: true,



                },



                schedule_start_time_1: {



                  required: true,



                },



                schedule_end_date_1: {



                  required: true,



                },



                schedule_event_description_1: {



                  required: true,



                },



                schedule_end_time_1: {



                  required: true,



                },



					/*logo: {



                        required: true,



                      },*/



                    },



                    messages: {},



                    submitHandler: function(form) {



                      form.submit();



                    }



                  });



            jQuery.validator.addMethod("checkTicketCount", function(value, element) {



              var free_count = document.getElementById('ticket_count_1').value;







              if($("#no_image").is(':checked')){



               document.getElementById('extra_space_logo2').style.display = 'block';



               return true;



             }







             if(free_count == 0){



               return false;



             }else{



               return true;



             }







           }, "* Please create atleast one ticket");



            jQuery.validator.addMethod("alpha", function(value, element) {



              return this.optional(element) || value == value.match(/^[a-zA-Z]+$/);



            },"Only alphabets are allowed.");



          }



        }



    //when the dom has loaded setup form validation rules



    $(D).ready(function($) {



      user_validation.UTIL.setupFormValidation();



    });



  })(jQuery, window, document);







  function init() {



    var input = document.getElementById('event_location');



    var autocomplete = new google.maps.places.Autocomplete(input);



    google.maps.event.addListener(autocomplete, 'place_changed', function() {



      get_address();



    });



  }







  google.maps.event.addDomListener(window, 'load', init);







  function get_address(){



    var geocoder = new google.maps.Geocoder();



    var address = document.getElementById('event_location').value;



    $('#schedule_location_1').val(address);



    geocoder.geocode( { 'address': address}, function(results, status) {



     if (status == google.maps.GeocoderStatus.OK) {



      var latitude = results[0].geometry.location.lat();



      var longitude = results[0].geometry.location.lng();



      document.getElementById('event_location_latitude').value = latitude;



      document.getElementById('event_location_longitude').value = longitude;



    }



  });



  }







// auto fill textboxes



$('#event_location').keyup(function(){



  $('#schedule_location_1').val(this.value);



});







$('#event_location').blur(function(){



  $('#schedule_location_1').val(this.value);



});







$('#event_location').change(function(){



  $('#schedule_location_1').val(this.value);



});







$('#event_description').blur(function(){



  $('#schedule_event_description_1').val(this.value);



});







// auto fill textboxes



$('#title').keyup(function(){



  $('#schedule_title_1').val(this.value);



});







$('#title').blur(function(){



  $('#schedule_title_1').val(this.value);



});











function generate_time_clock(size){



	$('#schedule_start_time_'+size).timepicki();



	$('#schedule_end_time_'+size).timepicki();



}











function generate_date_clock(size){



	$("#schedule_start_date_"+size).datepicker({



   changeMonth: true,



   changeYear: true,



   dateFormat: 'dd-mm-yy',



   yearRange: "+0:+100",



   minDate: 1,



   onSelect: function(selected) {



    $("#schedule_end_date_"+size).datepicker("option","minDate", selected);



  }



});







	$("#schedule_end_date_"+size).datepicker({



   changeMonth: true,



   changeYear: true,



   dateFormat: 'dd-mm-yy',



   yearRange: "+0:+100",



   minDate: 1,



 });



}







$(function() {



  $("#event_start_date").datepicker({



   changeMonth: true,



   changeYear: true,



   dateFormat: 'dd-mm-yy',



   yearRange: "+0:+100",



   minDate: 1,



   onSelect: function(selected) {



     $("#event_end_date").datepicker("option","minDate", selected);



     $("#schedule_start_date_1").datepicker("option","minDate", selected);



     $("#schedule_end_date_1").datepicker("option","minDate", selected);



     $('#schedule_start_date_1').datepicker({ dateFormat: 'dd-mm-yy'}).datepicker("setDate", this.value);



   }



 });







  $("#event_end_date").datepicker({



   changeMonth: true,



   changeYear: true,



   dateFormat: 'dd-mm-yy',



   yearRange: "+0:+100",



   minDate: 1,



   onSelect: function(selected) {



    $("#schedule_start_date_1").datepicker("option","maxDate", selected);



    $("#schedule_end_date_1").datepicker("option","maxDate", selected);



    $('#schedule_end_date_1').datepicker({ dateFormat: 'dd-mm-yy'}).datepicker("setDate", this.value);







    var d = $("#event_end_time").val();



    $("#schedule_end_time_1").val(d);







    var e = $("#event_start_time").val();



    $("#schedule_start_time_1").val(e);







  }



});







  $("#schedule_start_date_1").datepicker({



   changeMonth: true,



   changeYear: true,



   dateFormat: 'dd-mm-yy',



   yearRange: "+0:+100",



   minDate: 1,



   onSelect: function(selected) {



    $("#schedule_end_date_1").datepicker("option","minDate", selected);



  }



});







  $("#schedule_end_date_1").datepicker({



   changeMonth: true,



   changeYear: true,



   dateFormat: 'dd-mm-yy',



   yearRange: "+0:+100",



   minDate: 1,



 });



});







// Add a new repeating section



var attrs = ['for', 'id', 'name'];



function resetAttributeNames(section) {



  var tags = section.find('input, label'), idx = section.index();



  tags.each(function() {



    var $this = $(this);



    $.each(attrs, function(i, attr) {



      var attr_val = $this.attr(attr);



      if (attr_val) {



        $this.attr(attr, attr_val.replace(/_\d+$/, '_'+(idx + 1)))



      }



    })



  })



}







//This function here is only a cross-browser events stopper

	function validateAllInputBoxes(ffevent){

	   // mark in red if field are blank

		var isValid = true;



		$('.date-text-validator').each(function() {

			if ($.trim($(this).val()) == '') {

				/* isValid = false;

				$(this).css({

					"border": "1px solid red",

				}); */

				$(this).focus();

				e.preventDefault();

				return false;

			} else {

				$(this).css({

				"border": "",

				"background": ""

				});

			}

		});



		$('.create-event-text-validator').each(function() {

			if ($.trim($(this).val()) == '') {

				isValid = false;

				$(this).css({

					"border": "1px solid red",

				//	"background": "#FFCECE"

				});

				$(this).focus();

				e.preventDefault();

				return false;

			} else {

				$(this).css({

				"border": "",

				"background": ""

				});

			}

		});





			$('.ticket_validates').each(function() {

				if ($.trim($(this).val()) == '') {

					isValid = false;

					$(this).css({

						"border": "1px solid red",

					//	"background": "#FFCECE"

					});

					$(this).focus();

					e.preventDefault();

					return false;

				} else {

					$(this).css({

					"border": "",

					"background": ""

					});

				}

			});



		$('.create-event-text-area-validator').each(function() {

			if ($.trim($(this).val()) == '') {

				isValid = false;

				$(this).css({

					"border": "1px solid red",

				//	"background": "#FFCECE"

				});

			} else {

				$(this).css({

				"border": "",

				"background": ""

				});

			}

		});



	   document.getElementById("sub_event_validation_message").style.display = "none";

	   // check if all mandatory ticket field are fill in properly

	   var reqlength = $('.ticket_validates').length;



		var value = $('.ticket_validates').filter(function () {

			return this.value != '';

		});



		if (value.length>=0 && (value.length !== reqlength)) {

			//alert('Please fill out all required ticket details.');

			document.getElementById("sub_event_validation_message").style.display = "block";

			return false;

		}



	    var reqlength = $('.create-event-text-validator').length;



		var value = $('.create-event-text-validator').filter(function () {

			return this.value != '';

		});



		if (value.length>=0 && (value.length !== reqlength)) {

			document.getElementById("sub_event_validation_message").style.display = "block";

			return false;

		}



		var reqlength = $('.create-event-text-area-validator').length;



		var value = $('.create-event-text-area-validator').filter(function () {

			return this.value != '';

		});



		if (value.length>=0 && (value.length !== reqlength)) {

			document.getElementById("sub_event_validation_message").style.display = "block";return false;

		}



	   adda_eventso();

	}







 function adda_eventso(){







  var value = parseInt(document.getElementById('dynamic_event_count').value);



  value++;



  document.getElementById('dynamic_event_count').value = value;





  var sub_counter=parseInt($('#sub_event_counter').val())+1;

  $('#sub_event_counter').val(sub_counter);



  var schedule_title = document.getElementById('title').value;



  var schedule_location = document.getElementById('event_location').value;



  var schedule_start_date = document.getElementById('event_start_date').value;



  var schedule_start_time = document.getElementById('event_start_time').value;



  var schedule_end_date = document.getElementById('event_end_date').value;



  var schedule_end_time = document.getElementById('event_end_time').value;



  var schedule_event_description =  document.getElementById('event_description').value;







  var sub_event_size = document.querySelectorAll('.repeat_event_div').length;







  var page_size = sub_event_size+1;



  var data_out = '<div style="border:0px solid #ddd;margin-bottom:10px;" class=""><div class="panel panel-default repeat_event_div"><div class="panel-heading"><h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse'+page_size+'">Sub Event '+page_size+'</a></h4></div><div id="collapse'+page_size+'" class="in panel-collapse collapse"><div class="panel-body">';







  data_out += '<h5 class="blue_txt paragraph">A. Event Schedule</h5><div class="jumbotron add_event_jumbotron jumbo_padding" id="more_event"><div class="row"><div class="col-md-8 col-sm-8"><div class="row"><div class="col-md-4 col-sm-4"><label for="schedule_title_'+page_size+'">Title</label></div><div class="col-md-8 col-sm-8"><input required="required" value="'+schedule_title+'" type="text" id="schedule_title_'+page_size+'" name="schedule_title_'+page_size+'" class="search_events create-event-text-validator" placeholder=""></div></div></div><div class="col-md-8 col-sm-8"><div class="row"><div class="col-md-4 col-sm-4"><label for="schedule_location">Location</label></div><div class="col-md-8 col-sm-8"><input required="required" type="text" value="'+schedule_location+'" id="schedule_location_'+page_size+'" name="schedule_location_'+page_size+'" class="search_events create-event-text-validator" placeholder=""></div></div></div><div class="col-md-8 col-sm-8"><div class="row"><div class="col-md-4 col-sm-4"><label for="schedule_start_date" >Start Date/Time<span>*</span></label></div><div class="col-md-8 col-sm-8"><div class="row"><div class="col-md-6 col-sm-6"><input readonly="readonly" required="required" type="text" onclick="generate_date_clock('+page_size+')" id="schedule_start_date_'+page_size+'" value="'+schedule_start_date+'" name="schedule_start_date_'+page_size+'" class="search_events create-event-text-validator" placeholder=""></div><div class="col-md-6 col-sm-6"><input type="text" id="schedule_start_time_'+page_size+'" value="'+schedule_start_time+'" onclick="generate_time_clock('+page_size+')" name="schedule_start_time_'+page_size+'" required="required" class="search_events create-event-text-validator" placeholder=""></div></div></div></div></div><div class="col-md-8 col-sm-8"><div class="row"><div class="col-md-4 col-sm-4"><label for="email">End Date/Time<span>*</span></label>    </div><div class="col-md-8 col-sm-8"><div class="row"><div class="col-md-6 col-sm-6">	<input  required="required" type="text" onclick="generate_date_clock('+page_size+')" value="'+schedule_end_date+'" id="schedule_end_date_'+page_size+'" name="schedule_end_date_'+page_size+'" class="search_events create-event-text-validator" placeholder=""></div><div class="col-md-6 col-sm-6">	<input  required="required" value="'+schedule_end_time+'" type="text" id="schedule_end_time_'+page_size+'" onclick="generate_time_clock('+page_size+')" name="schedule_end_time_'+page_size+'" class="search_events create-event-text-validator" placeholder=""></div></div></div></div></div><div class="col-md-8 col-sm-8"><div class="row"><div class="col-md-4 col-sm-4"><label for="email">Event Description<span>*</span></label></div><div class="col-md-8 col-sm-8"><textarea class="form-control txt_field create-event-text-area-validator" style="margin-bottom:0px" id="schedule_event_description_'+page_size+'" name="schedule_event_description_'+page_size+'" required="required">'+schedule_event_description+'</textarea></div></div></div></div></div>';







  data_out += '<h5 class="blue_txt paragraph">B. Create Ticket</h5><br><div class="jumbotron add_event_jumbotron jumbo_padding create_ticket_outer_'+page_size+'" style="margin-bottom:0px;"><div class="row create_ticket_inner"><div class="col-md-2 col-sm-2 col-xs-2"><label>Ticket Name &nbsp;<span>*</span></label></div><div class="col-md-1 col-sm-1 col-xs-13"><label>Quantity<span>*</span></label></div><div class="col-md-2 col-sm-2 col-xs-2"><label>Price &nbsp;<span>*</span></label></div>	<div class="col-md-2 col-sm-2 col-xs-2"><label>Sale End Date &nbsp;<span>*</span></label></div><div class="col-md-1 col-sm-1 col-xs-1"><label>MinCount<span>*</span></label></div><div class="col-md-1 col-sm-1 col-xs-1"><label>MinCount<span>*</span></label></div><div class="col-md-1 col-sm-1 col-xs-1"><label>Sold</label></div><div class="col-md-1 col-sm-1 col-xs-1"><label>Stop</label></div><div class="col-md-1 col-sm-1 col-xs-1"><label>Action</label></div></div>	<input type="hidden" id="ticket_alert" name="ticket_alert"></div><br class="clear">';







  data_out += '<div class="row"><div class="col-md-12"><div class="row"><div class="col-md-2 col-sm-4 col-xs-12"><button type="button" class="center-block submit_btn search_events" onclick="add_more_tickets('+"'free'"+','+page_size+')">+ Free Ticket</button></div><div class="col-md-2 col-sm-4 col-xs-12"><button type="button" class="center-block submit_btn  search_events" onclick="add_more_tickets('+"'paid'"+','+page_size+')">+ Paid Ticket</button></div><div class="col-md-2 col-sm-4 col-xs-12"><button type="button" class="center-block submit_btn search_events" onclick="add_more_tickets('+"'donation'"+','+page_size+')">+ Donation</button></div></div></div></div><br class="clear">';







  data_out += '<div class="row"><div class="col-md-12"><h5 class="blue_txt paragraph">C. Add a Sponsors</h5><br><div class="col-md-8"><div class="row"><div class="col-md-4 col-sm-4"><label for="sponsor_image" class="align_to_txt_box">Image(Max size 200kb)</label></div><div class="col-md-8 col-sm-8"><div class="input-group"><label class="input-group-btn"><span class="btn btn-primary browse_btn search_events">Browse… <input id="sponsor_image_'+page_size+'" name="sponsor_image_'+page_size+'" class="browse_txt_box create-event-file-validator" style="display: none;" placeholder="" type="file" onchange="add_sponsor_check('+page_size+');"></span></label><input id="name" name="name" class="search_events" placeholder="" readonly="" type="text"></div></div></div></div><div class="col-md-8" style="display:none;" id="preview_sponsor_div_'+page_size+'"><div class="row"><div class="col-md-4 col-sm-4"><label class="align_to_txt_box">&nbsp;</label></div><div class="col-md-8 col-sm-8"><div class="input-group"><img id="sponsor_preview_'+page_size+'" src="#" alt="" width="200px;"/></div></div></div></div><div class="col-md-8"><div class="row"><div class="col-md-4 col-sm-4"><label for="hyperlink" class="align_to_txt_box">Hyperlink</label></div><div class="col-md-8 col-sm-8"><input id="hyperlink_'+page_size+'" name="hyperlink_'+page_size+'" class="search_events" placeholder=""  type="text"><label style="display:none;" id="sponsor_error_'+page_size+'"></label><button id="add_sponsors_'+page_size+'" type="button" class="submit_btn search_events" onclick="add_sponsor_data_sub_event('+page_size+');">Add Sponsors</button><img alt="loading..." style="display:none;width:150px;height:30px;" id="buttonreplacement_'+page_size+'" src="<?php echo $this->config->item('frontend_image_path');?>images/ajax-loader.gif"></div></div></div><br class="clear"><div class="jumbotron remove_extra-padding"><ul class="list-inline list-unstyled preview_content_'+page_size+'"></ul></div><div class="col-md-12"><div class="row"><h5 class="blue_txt paragraph margin_down">D. Champions</h5><div class="col-md-3"><label for="is_supporter_allowed">Champions Allowed</label>&nbsp;&nbsp;<input type="checkbox" id="is_supporter_allowed_'+page_size+'" name="is_supporter_allowed_'+page_size+'" class="adjust_checkbox"></div><div class="col-md-3"><label for="verify_supporter">Verify Champions</label>&nbsp;&nbsp;<input type="checkbox" id="verify_supporter_'+page_size+'" name="verify_supporter_'+page_size+'" class="adjust_checkbox"><input type="hidden" id="organiser_id" name="organiser_id" class="" value=""><input type="hidden" id="free_ticket_count" name="free_ticket_count" class="" value="0"><input type="hidden" id="paid_ticket_count" name="paid_ticket_count" class="" value="0"><input type="hidden" id="donation_ticket_count" name="donation_ticket_count" class="" value="0"></div></div></div></div></div></div></div></div></div>';







   // e.preventDefault();







   var lastRepeatingGroup = $('.repeat_event_div').last();







   $(".panel-group" ).append(data_out);



 }











 function readURL(input) {



  if (input.files && input.files[0]) {



   var reader = new FileReader();



   reader.onload = function (e) {



    $('#blah').attr('src', e.target.result);



  }



  reader.readAsDataURL(input.files[0]);



}



}





function add_sponsor_check(page_count){

		var files = document.getElementById('sponsor_image_'+page_count).files;

		if(files[0].size > 200000){

			document.getElementById('sponsor_error_'+page_count).style.display = 'block';

			document.getElementById('sponsor_error_'+page_count).style.color = 'red';

			document.getElementById('sponsor_error_'+page_count).innerHTML = 'max allowed size is 200kb'

			return false;

		}

		readURL_Sponsor_2(page_count);



		document.getElementById('preview_sponsor_div_'+page_count).style.display = 'block';

		document.getElementById('preview_sponsor_div_'+page_count).style.marginBottom = "15px";

	}



	function readURL_Sponsor_2(page_count) {

		var files = document.getElementById('sponsor_image_'+page_count).files;

		var reader = new FileReader();

		reader.onload = function (e) {

			$('#sponsor_preview_'+page_count).attr('src', e.target.result);

			document.getElementById('sponsor_error_'+page_count).style.display = 'none';

		}

		reader.readAsDataURL(files[0]);

	}





$("#logo").change(function(){







  var d = $("#event_end_time").val();



  $("#schedule_end_time_1").val(d);







  var e = $("#event_start_time").val();



  $("#schedule_start_time_1").val(e);







  readURL(this);



  document.getElementById('extra_space_logo2').style.display = 'block';



  document.getElementById('extra_space_logo').style.display = 'block';



  document.getElementById('blah').style.display = 'block';



  document.getElementById("blah").style.marginBottom = "15px";



});







$("#sponsor_image").change(function(){







  var files = document.getElementById('sponsor_image').files;



  if(files[0].size > 200000){



   document.getElementById('sponsor_error').style.display = 'block';



   document.getElementById('sponsor_error').style.color = 'red';



   document.getElementById('sponsor_error').innerHTML = 'max allowed size is 200kb'



   return false;



 }



 readURL_Sponsor(this);



 document.getElementById('preview_sponsor_div').style.display = 'block';



 document.getElementById("preview_sponsor_div").style.marginBottom = "15px";



});







function readURL_Sponsor(input) {



  if (input.files && input.files[0]) {



   var reader = new FileReader();



   reader.onload = function (e) {



    $('#sponsor_preview').attr('src', e.target.result);



    document.getElementById('sponsor_error').style.display = 'none';



  }



  reader.readAsDataURL(input.files[0]);



}



}







$(document).ready(function(){



 //$('.calend_end_date').datepicker();



 $('.calend_end_date').on('change',function(){



   var index=$('.calend_end_date').index(this);



   $('.calend_end_date:eq('+index+')').val();







 });



});



</script>











<script>



  $(document).ready(function(){





	/*

    $('.add_more_event').click(function(){

      var sub_counter=parseInt($('#sub_event_counter').val())+1;

		$('#sub_event_counter').val(sub_counter);

    });

	*/





    $('.stop_status').click(function(){



        //alert('working');



        var lastClass = $(this).attr('class').split(' ').pop();



        var ticket_id=$('.ticketid_'+lastClass).val();



        //alert(ticket_id);







        if($(this).prop("checked") == true){



         $('.'+lastClass).attr('readonly','readonly');



         $('.'+lastClass).css('background-color','#F2F3F4');



         var stop_status=1;







         $.ajax({



          type: "post",



          url: "<?php echo base_url(); ?>index.php/frontend/events/update_stop_status/"+stop_status+'/'+ticket_id,



          cache: false,



          success: function(json){



                // alert('done');



              //



            }



            ,



            error: function(){



              alert('Error while request..');



            }



          }



          );



       }else{



        $('.'+lastClass).removeAttr("readonly");



        $('.'+lastClass).css('background-color','white');



        var stop_status=0;







        $.ajax({



          type: "post",



          url: "<?php echo base_url(); ?>index.php/frontend/events/update_stop_status/"+stop_status+'/'+ticket_id,



          cache: false,



          success: function(json){



            // alert('done');



          }



          ,



          error: function(){



            alert('Error while request..');



          }



        }



        );



      }















    });



















  });



</script>





<script type="text/javascript">







 $(document).on("click", ".delete_ticket", function () {



  var delete_ticket_last_class=$(this).attr('class').split(' ').pop();





  if(delete_ticket_last_class!='delete_ticket')

  {

    var ticket_id=$('#'+delete_ticket_last_class).val();



     $.ajax({



          type: "post",



          url: "<?php echo base_url(); ?>index.php/frontend/events/delete_ticket_ajax/"+ticket_id,



          cache: false,



          success: function(json){

          }

          ,

          error: function(){

            alert('Error while request..');

          }

        }

      );

    $('.row_'+delete_ticket_last_class).remove();

  }else{

    //e.preventDefault();

    var current_fight = $(this).parents('div').eq(1);

    var other_fights = current_fight.siblings('.repeatingSection_donation');

    current_fight.slideUp('fast', function() {

    current_fight.remove();

        // reset fight indexes

        other_fights.each(function() {

            resetAttributeNames($(this));

        })

    })



  var sub_event_size = document.querySelectorAll('.repeatingSection').length;

  document.getElementById('ticket_count_1').value = parseInt(sub_event_size-1);

  }





});



$('.create-event-text-validator').blur(function(){

		if( $(this).val().length === 0 ) {

			$(this).css({

				"border": "1px solid red",

			});

		}else{

			$(this).css({

				"border": "",

			});

		}

	});



	$('.create-event-text-area-validator').blur(function(){

		if( $(this).val().length === 0 ) {

			$(this).css({

				"border": "1px solid red",

			});

		}else{

			$(this).css({

				"border": "",

			});

		}

	});



	$(document).on("blur", ".ticket_validates", function () {

	if( $(this).val() == "") {

		$(this).css({

			"border": "1px solid red",

		});

	}else{

		$(this).css({

			"border": "",

		});

	}

});

</script>

<script type="text/javascript">
$(document).on("keyup", ".ticket_amount", function () {
    var r = /^(\d*)\.{0,1}(\d*)$/
    if (!r.test($(this).val())) {
        $(this).val(
        function(index, value){
            return value.substr(0, value.length - 1);
        });
    } else {
        return true;
    }
});


 $(document).on("keyup", ".ticket_amount", function (event) {
    $(this).val($(this).val().replace(/[^0-9\.]/g,''));
    if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
		event.preventDefault();
    }
	var number = ($(this).val().split('.'));
	if (number[1] && number[1].length > 2)
	{
	 var newnum = parseFloat($(this).val());
	   $(this).val(newnum.toFixed(2));
	}
});

 $(document).on("keyup", ".ticket_amount", function () {
    var outputPercentageString = $(this).val();
    var outputPercentage = parseInt(outputPercentageString);
        if (outputPercentage <= 0 || outputPercentage > 100000) {
            $(this).val(
            function(index, value){

                return value.substr(0, value.length - 1);
               });
            }

            var r = /^(\d*)\.{0,1}(\d*)$/
                if (!r.test($(this).val())) {
                    $(this).val(
                    function(index, value){
                    return value.substr(0, value.length - 1);
                    });
                } else {
                  return true;
            }
    });
</script>