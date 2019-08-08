<noscript>
    <style type="text/css">
        .content {display:none;}
    </style>
    <div class="noscriptmsg">
    You don't have javascript enabled.  Good luck with that.
    </div>
</noscript>
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
	::-webkit-input-placeholder {	
		color: #cccccc;
	}
	:-moz-placeholder {
		color: #cccccc;
	}
	::-moz-placeholder {
		color: #cccccc; 
	}
	:-ms-input-placeholder {  
		color: #cccccc; 
	}

</style>		
	<div class="content">
		<!-- Kode-Header End -->
		<div class="sub-header">
			<!-- SUB HEADER -->
		</div>
		<div class="Kode-page-heading">
			<div class="container">
				<!--ROW START-->
				<div class="row">
					<div class="col-md-6 col-sm-6">
						<h2>Create Event</h2>
					</div>								
				</div>
				<!--ROW END-->
			</div>
		</div>
		<!--Kode-our-speaker-heading End-->
		<div class="kode-blog-style-2">
		  <div class="container">
				<form class="form-horizontal" id="add_event_form" name="add_event_form" method="post" action="<?php echo $this->config->item('save_fe_event');?>" enctype="multipart/form-data">                
  				<h5 class="blue_txt paragraph">Master Event Details</h5>
                <br class="clear">				
                <div class="row">
                	<div class="col-md-8 col-sm-8">
                    	<div class="row">
                        	<div class="col-md-4 col-sm-4">
                            	<label for="title">Title<span>*</span></label>
                            </div>
                            <div class="col-md-8 col-sm-8">
                            	<input type="text" id="title" name="title" class="required create-event-text-validator" placeholder="" value="<?php echo set_value('title');?>">
								<?php echo form_error('title'); ?>
                            </div>
                      	</div>
                    </div>
                    <br class="clear">
                    <div class="col-md-8 col-sm-8">
                    	<div class="row">
                        	<div class="col-md-4 col-sm-4">
                            	<label for="event_location">Location<span>*</span></label>
                            </div>
                            <div class="col-md-8 col-sm-8">
                            	<input onblur="get_address();" type="text" id="event_location" name="event_location" class="required create-event-text-validator" placeholder="" value="<?php echo set_value('event_location');?>">
								<input type="hidden" id="event_location_latitude" name="event_location_latitude" value="">
								<input type="hidden" id="event_location_longitude" name="event_location_longitude" value="">
								<?php echo form_error('event_location'); ?>
                            </div>
                      	</div>
                    </div>
                    <br class="clear">
      				<div class="col-md-8 col-sm-8">
                    	<div class="row">
                        	<div class="col-md-4 col-sm-4">
                            	<label for="event_start_date">Start Date/Time<span>*</span></label>
                            </div>
                            <div class="col-md-8 col-sm-8">
                            	<div class="row">                                	
                                	<div class="col-md-6 col-sm-6">
                                		<input type="text" id="event_start_date" name="event_start_date" class="required create-event-text-validator remove_date_border" placeholder="" value="<?php echo set_value('event_start_date');?>" readonly="readonly">
										<?php echo form_error('event_start_date'); ?>
                                	</div>
                                	<div class="col-md-6 col-sm-6">
                                		<input type="text" id="event_start_time" name="event_start_time" class="required create-event-text-validator remove_date_border" placeholder="" value="<?php echo set_value('event_start_time');?>" readonly="readonly">
										<?php echo form_error('event_start_time'); ?>
                                	</div>                                    
                                </div>
                            </div>                            
                      	</div>
                    </div>
					<div class="col-md-8 col-sm-8">
                    	<div class="row">
                        	<div class="col-md-4 col-sm-4">
                            	<label for="event_end_date">End Date/Time<span>*</span></label>
                            </div>
                            <div class="col-md-8 col-sm-8">
                            	<div class="row">                                	
                                	<div class="col-md-6 col-sm-6">
                                		<input type="text" id="event_end_date" name="event_end_date" class="required create-event-text-validator remove_date_border" placeholder="" value="<?php echo set_value('event_end_date');?>" readonly="readonly">
										<?php echo form_error('event_end_date'); ?>
                                	</div>
                                	<div class="col-md-6 col-sm-6">
                                		<input type="text" id="event_end_time" name="event_end_time" class="required create-event-text-validator remove_date_border" placeholder="" value="<?php echo set_value('event_end_time');?>" readonly="readonly">
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
                                    Browse&hellip; <input type="file" id="logo_event_image" name="logo" class="browse_txt_box create-event-file-validator" style="display: none;" placeholder="">
                                    </span>
                                </label>
                                <input type="text" id="event_logo_name" name="event_logo_name" class="" placeholder="" readonly>
                            </div>							
                         </div>		
						 <?php echo form_error('logo'); ?>				
                     </div>
                </div>
				<br class="clear" style="display:none;" id="extra_space_logo">
				<div class="col-md-8 col-sm-8" style="display:none;" id="extra_space_logo2">
					<div class="row">
						<div class="col-md-4 col-sm-4">
							<label>&nbsp;</label>
						</div>
						<div class="col-md-8 col-sm-8">
							<label id="logo_error"></label>
							<img id="blah" src="#" alt="" style="display:none;" width="200px;"/>
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
                           <textarea rows="5" class="form-control txt_field create-event-text-area-validator" name="event_description" id="event_description"><?php echo set_value('event_description');?></textarea>
                           <?php echo form_error('event_description'); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 col-sm-8">
                 	<div class="row">
                        <div class="col-md-4 col-sm-4">
                            <label for="org_description">Organization Description<span>*</span></label>
                        </div>
                        <div class="col-md-8 col-sm-8">
                            <textarea rows="5" class="form-control txt_field create-event-text-area-validator" id="org_description" name="org_description"><?php echo $organization_description->charity_overview; ?></textarea>
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
                            <textarea rows="5" class="form-control txt_field create-event-text-area-validator" id="donation_receipt_text" name="donation_receipt_text"><?php echo $organization_receipt;?></textarea>
							<?php //echo form_error('org_description'); ?>
                        </div>
                    </div>
                </div>
            </div>
			<div class="row">	
                <div class="col-md-8 col-sm-8">
                	<div class="row">
                    	<div class="col-md-4 col-sm-4">
                         <label for="event_category">Event Category<span>*</span></label>
                        </div>
                        <div class="col-md-5 col-sm-5">
                        	<select class="change_category form-control dropdown search_events create-event-select-validator" id="event_category" name="event_category">
                                <option value="">--- Please Select ---</option>
									<?php foreach($event_category as $category){ ?>
									<option <?php echo set_select('event_category', $category->id); ?> value="<?php echo $category->id;?>"><?php echo $category->category_name;?></option>
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
							<input type="radio" value="1" id="event_privacy" name="event_privacy" class="search_events">&nbsp;&nbsp;<label for="event_privacy">Private Page</label>
						</div>
						<div class="col-md-3">
							<input type="radio" value="0" id="event_public" name="event_privacy" class="search_events" checked>&nbsp;&nbsp;<label for="event_public">Public Page</label>
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
                        	<input type="checkbox" value="1" id="remaining_tickets" name="remaining_tickets"><label class="chkbox_space" for="remaining_tickets">Show the number of tickets remaining on the registration page</label>
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
                        	<input type="checkbox" value="1" id="sponsor_request" name="sponsor_request">
							<label class="chkbox_space" for="sponsor_request" style="margin-left:0px;">Show button on event screen for users to contact you to become</label><label class="chkbox_space"> a sponsor for the event</label>
                        </div>
                    </div>
                </div>
			</div>

			
			
			<br class="clear">					    
			<h5 class="blue_txt paragraph">Schedule Events</h5>
			<br class="clear">
			<!-- New HTML GOES HERE 2618 -->
			<div class="panel-group" id="accordion">
                 <div style="border:0px solid #ddd;margin-bottom:10px;" class="">
                <!-- repeat section start -->
				<div class="panel panel-default repeat_event_div">
                  	<div class="panel-heading">
                        <h4 class="panel-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">Sub Event 1</a>
                        </h4>
                  	</div>
                  	<div id="collapse1" class="panel-collapse collapse in">
                    	<div class="panel-body">
                            <h5 class="blue_txt paragraph">A. Event Schedule</h5>
				<div class="jumbotron add_event_jumbotron jumbo_padding" id="more_event">				
					 <div class="row">
                	<div class="col-md-8 col-sm-8">
                    	<div class="row">
                        	<div class="col-md-4 col-sm-4">
                            	<label for="schedule_title_1">Title<span>*</span></label>
                            </div>
                            <div class="col-md-8 col-sm-8">
                            	<input type="text" id="schedule_title_1" name="schedule_title_1" class="search_events create-event-text-validator" placeholder="">
                            </div>
                      	</div>
                    </div>
                    <div class="col-md-8 col-sm-8">
                    	<div class="row">
                        	<div class="col-md-4 col-sm-4">
                            	<label for="schedule_location_1">Location<span>*</span></label>
                            </div>
                            <div class="col-md-8 col-sm-8">
                            	<input type="text" id="schedule_location_1" name="schedule_location_1" class="search_events create-event-text-validator" placeholder="">
                            </div>
                      	</div>
                    </div>
      				<div class="col-md-8 col-sm-8">
                    	<div class="row">
                        	<div class="col-md-4 col-sm-4">
                            	<label for="schedule_start_date_1">Start Date/Time<span>*</span></label>
                            </div>
                            <div class="col-md-8 col-sm-8">
                            	<div class="row">                                	
                                	<div class="col-md-6 col-sm-6">
                                		<input readonly="readonly" type="text" id="schedule_start_date_1" name="schedule_start_date_1" class="search_events create-event-text-validator" placeholder="">
                                	</div>
                                	<div class="col-md-6 col-sm-6">
                                		<input type="text" id="schedule_start_time_1" name="schedule_start_time_1" class="search_events create-event-text-validator" placeholder="">
                                	</div>                                    
                                </div>
                            </div>                            
                      	</div>
                    </div>
					<div class="col-md-8 col-sm-8">
                    	<div class="row">
                        	<div class="col-md-4 col-sm-4">
                            	<label for="schedule_end_date_1">End Date/Time<span>*</span></label>
                            </div>
                            <div class="col-md-8 col-sm-8">
                            	<div class="row">                                	
                                	<div class="col-md-6 col-sm-6">
                                		<input readonly="readonly" type="text" id="schedule_end_date_1" name="schedule_end_date_1" class="search_events create-event-text-validator" placeholder="">
                                	</div>
                                	<div class="col-md-6 col-sm-6">
                                		<input type="text" id="schedule_end_time_1" name="schedule_end_time_1" class="search_events create-event-text-validator" placeholder="">
                                	</div>                                    
                                </div>
                            </div>                            
                      	</div>
                    </div>
					<div class="col-md-8 col-sm-8">
						<div class="row">
                        	<div class="col-md-4 col-sm-4">
                            	<label for="schedule_event_description_1">Event Description<span>*</span></label>
                            </div>
                            <div class="col-md-8 col-sm-8">
                            	<textarea class="form-control txt_field create-event-text-area-validator" style="margin-bottom:0px" id="schedule_event_description_1" name="schedule_event_description_1"></textarea>
                            </div>                            
                      	</div>
						
                  </div>
                </div>
				</div>
			
			<h5 class="blue_txt paragraph">B. Create Ticket</h5><input type="checkbox" name="no_image" id="no_image" value="1"/><label for="no_image">No Tickets</label><br>
            
			<div class="jumbotron add_event_jumbotron jumbo_padding create_ticket_outer_1 tick_add" style="margin-bottom:0px;">
				<div class="row create_ticket_inner">
					<div class="col-md-2 col-sm-2 col-xs-2"><label>Ticket Name &nbsp;<span>*</span></label></div>
					<div class="col-md-1 col-sm-2 col-xs-1"><label>Quantity&nbsp;<span>*</span></label></div>
					<div class="col-md-2 col-sm-2 col-xs-2"><label>Price &nbsp;<span>*</span></label></div>
					<div class="col-md-2 col-sm-2 col-xs-2"><label>Sale End Date &nbsp;<span>*</span></label></div>
					<div class="col-md-2 col-sm-2 col-xs-2"><label>Min Ticket Count &nbsp;<span>*</span></label></div>
					<div class="col-md-2 col-sm-2 col-xs-2"><label>Max Ticket Count &nbsp;<span>*</span></label></div>	
					<div class="col-md-1 col-sm-1 col-xs-1"><label>Action</label></div>
				</div>
				<!-- Free -->
				<input type="hidden" id="ticket_count_1" name="ticket_count_1" value="0">
				<input type="hidden" id="ticket_alert" name="ticket_alert">
			</div><!--Jumbotron-->
            <br class="clear">
			<div class="row">
				<div class="col-md-12">
                    <div class="row">
                      	<div class="col-md-2 col-sm-4 col-xs-12">
							<button type="button" class="center-block submit_btn search_events tick_add" onclick="add_more_tickets('free',1);">+ Free Ticket</button>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-12">
                            <button onclick="add_more_tickets('paid',1);" type="button" class="center-block submit_btn  search_events tick_add">+ Paid Ticket</button>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-12">
                            <button onclick="add_more_tickets('donation',1);" type="button" class="center-block submit_btn  search_events tick_add">+ Donation</button>
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
										Browse… <input id="sponsor_image" name="sponsor_image" class="browse_txt_box create-event-file-validator" style="display: none;" placeholder="" type="file">
										</span>
									</label>
									<input id="name" name="name" class="search_events" placeholder="" readonly="" type="text">
								</div>                         
                            </div>							
                         </div>
                    </div>
					<div class="col-md-8" style="display:none;" id="preview_sponsor_div">
						<div class="row">
                            <div class="col-md-4 col-sm-4">
                                <label class="align_to_txt_box">&nbsp;</label>
                            </div>
							<div class="col-md-8 col-sm-8">                	
								<div class="input-group">
									<img id="sponsor_preview" src="#" alt="" width="200px;"/>
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
								<input id="hyperlink" name="hyperlink" class="search_events" placeholder=""  type="text">
                               <label style="display:none;" id="sponsor_error"></label>
							   <button id="add_sponsors" type="button" class="submit_btn search_events" onclick="add_sponsor_data();">Add Sponsors</button>
							   <img alt="loading..." style="display:none;width:150px;height:30px;" id="buttonreplacement" src="<?php echo $this->config->item('frontend_image_path');?>images/ajax-loader.gif">
							</div>							
						</div>
					</div>
                    <br class="clear">
                    <div class="jumbotron remove_extra-padding">
                        <ul class="list-inline list-unstyled preview_content">
                           <!-- <li>
								<img src="<?php echo $this->config->item('admin_image_path');?>adidas_small.png" class="img-responsive" alt="">
							</li> -->                               
                        </ul>
                    </div>
						
					<div class="col-md-12">					
						<div class="row">							
							<h5 class="blue_txt paragraph margin_down">D. Champions</h5>	
							<div class="col-md-3">
								<label for="is_supporter_allowed">Champions Allowed</label>&nbsp;&nbsp;<input type="checkbox" id="is_supporter_allowed" name="is_supporter_allowed_1" class="adjust_checkbox" value="1">
							</div>
							<div class="col-md-3">
								<label for="verify_supporter">Verify Champions</label>&nbsp;&nbsp;<input type="checkbox" id="verify_supporter" name="verify_supporter_1" class="adjust_checkbox" value="1">
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
                   </div><!--Repeating Div-->
			
			<div class="row">
				<div class="col-md-12" id="sub_event_validation_message" style="display:none;color:red;">
					<label style="font-weight: normal;">Please fill in all necessery sub event details</label>
				</div>
				<div class="col-md-2 tick_add">
					<button onclick="validateAllInputBoxes(this);" type="button" class="center-block add_more_btn add_more_event search_event three_inline_buttons tick_add" style="display:inline;padding:10px;margin-top:10px;">Add More Events</button>
				</div>						
				<div class="col-md-1">
					<input type="hidden" id="dynamic_event_count" name="dynamic_event_count" class="" value="1">
					<button type="submit" class="three_inline_buttons" style="display:inline;margin-right:30px;margin-top:10px;" id="submit_event_data">Submit</button>	
				</div>		
				<div class="col-md-2">
					<button type="button" class="three_inline_buttons" style="display:inline;margin-top:10px;margin-left: 50px;" onclick="go_back();">Cancel</button>
				</div>						
				</div>					
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
<script src="<?php echo $this->config->item('frontend_js_path');?>clone.js"></script>
<script src="<?php echo $this->config->item('frontend_js_path');?>jquery.blockUI.js"></script>


<script src="<?php echo $this->config->item('frontend_js_path');?>timepicki.js"></script>

<?php $image_url = $this->config->item('sponsor_image_url');?>
<script>
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
	
	$("#no_image").click(function() {
    if($(this).is(":checked")) {
        $(".tick_add").hide(300);
    } else {
        $(".tick_add").show(200);
    }
});

	$('#submit_event_data').click(function(e) {
		$('#event_category').filter(function(){
			return $.trim(this.value).length == 0;
		}).css("border","1px solid red");

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
					
		if(document.getElementById('no_image').checked == false){
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
		}
				
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
				
		/* $('.create-event-text-area-validator').each(function() {
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
				"background": ""
				});
			}			
		});
		
		
		if(!isValid){			
			return false;
		} */
		
		/*if(document.getElementById('no_image').checked == false){
			$('.ticket_validates').each(function() {
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
					"background": ""
					});
				}			
			});	

			if(!isValid){			
				return false;
			}
		}*/
		
		if(document.getElementById('no_image').checked == false){
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
		}
		
		
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
		window.location = "<?php echo $this->config->item('base_url');?>";
	}
	
	function add_more_tickets(result,page_count){		

		//$(".error").css("display", "none");
		
		var sub_event_size = document.querySelectorAll('.repeat_event_div').length;
		
		sub_event_size = page_count;
		
		var sale_end_date = document.getElementById('schedule_end_date_'+sub_event_size).value;		
		
		var milliseconds = new Date().getTime();	

		var free_html = '<div class="row repeatingSection create_ticket_inner"><div class="col-md-2 col-sm-2 col-xs-2 test_div"><input type="text" id="free_name_'+sub_event_size+'" name="free_name_'+sub_event_size+'[]" class="search_events free_name ticket_validates" placeholder="Free Ticket"></div><div class="col-md-1 col-sm-2 col-xs-1">			<input type="text" id="free_quantity_'+sub_event_size+'" name="free_quantity_'+sub_event_size+'[]" class="search_events free_quantity ticket_validates" placeholder="100" maxlength="5" onkeypress="return isNumber(event);"></div>	<div class="col-md-2 col-sm-2 col-xs-2"><div class="search_events">Free</div><input type="hidden" name="free_price_'+sub_event_size+'[]" id="free_price_'+sub_event_size+'" value="0" class="free_price"></div><div class="col-md-2 col-sm-2 col-xs-2"><input value="'+sale_end_date+'" type="text" id="free_start_ticket_date_'+sub_event_size+milliseconds+'" name="free_start_ticket_date_'+sub_event_size+'[]" class="search_events free_quantity ticket_validates calend_end_date" placeholder="dd-mm-yyyy" readonly></div><div class="col-md-2 col-sm-2 col-xs-2"><input type="text" id="free_max_count_'+sub_event_size+'" name="free_max_count_'+sub_event_size+'[]" class="search_events free_quantity ticket_validates" placeholder="1" maxlength="2" onkeypress="return isNumber(event);"></div><div class="col-md-2 col-sm-2 col-xs-2"><input type="hidden" name="free_order_'+sub_event_size+'[]" id="free_order_'+sub_event_size+'" value="'+milliseconds+'"><input type="text" id="free_min_count_'+sub_event_size+'" name="free_min_count_'+sub_event_size+'[]" class="search_events free_quantity ticket_validates" placeholder="10" maxlength="2" onkeypress="return isNumber(event);"></div><div class="col-md-1 col-sm-1 col-xs-1"><img src="<?php echo $this->config->item('admin_image_path');?>close.png" class="img-responsives delete_ticket" alt=""></div></div>';
		
		var donation_html = '<div class="row repeatingSection create_ticket_inner"><div class="col-md-2 col-sm-2 col-xs-2 test_div">	<input type="text" id="donation_name_'+sub_event_size+'" name="donation_name_'+sub_event_size+'[]" class="search_events ticket_validates" placeholder="Donation Ticket"></div><div class="col-md-1 col-sm-2 col-xs-1"><input type="text" id="donation_quantity_'+sub_event_size+'" name="donation_quantity_'+sub_event_size+'[]" class="search_events ticket_validates" placeholder="100" maxlength="5" onkeypress="return isNumber(event);"></div><div class="col-md-2 col-sm-2 col-xs-2"><div class="search_events">Donation</div><input type="hidden" name="free_donation_'+sub_event_size+'[]" id="free_donation'+sub_event_size+'" value="0"></div><div class="col-md-2 col-sm-2 col-xs-2"><input value="'+sale_end_date+'" type="text" id="donation_start_ticket_date_'+sub_event_size+milliseconds+'" name="donation_start_ticket_date_'+sub_event_size+'[]" class="search_events free_quantity ticket_validates calend_end_date" placeholder="dd-mm-yyyy" readonly></div><div class="col-md-2 col-sm-2 col-xs-2"><input type="text" id="donation_max_count_'+sub_event_size+'" name="donation_max_count_'+sub_event_size+'[]" class="search_events free_quantity ticket_validates" placeholder="1" maxlength="2" onkeypress="return isNumber(event);"></div><div class="col-md-2 col-sm-2 col-xs-2"><input type="hidden" name="donation_order_'+sub_event_size+'[]" id="donation_order_'+sub_event_size+'" value="'+milliseconds+'"><input type="text" id="donation_min_count_'+sub_event_size+'" name="donation_min_count_'+sub_event_size+'[]" class="search_events free_quantity ticket_validates" placeholder="10" maxlength="2" onkeypress="return isNumber(event);"></div><div class="col-md-1 col-sm-1 col-xs-1"><img src="<?php echo $this->config->item('admin_image_path');?>close.png" class="img-responsives delete_ticket" alt=""></div></div>';
		
		var paid_html = '<div class="row repeatingSection create_ticket_inner"><div class="col-md-2 col-sm-2 col-xs-2 test_div"><input type="text" id="paid_name_'+sub_event_size+'" name="paid_name_'+sub_event_size+'[]" class="search_events ticket_validates" placeholder="Paid Ticket"></div><div class="col-md-1 col-sm-2 col-xs-1"><input type="text" id="paid_quantity_'+sub_event_size+'" name="paid_quantity_'+sub_event_size+'[]" class="search_events ticket_validates" placeholder="100" maxlength="5" onkeypress="return isNumber(event);"></div><div class="col-md-2 col-sm-2 col-xs-2"><input type="text" id="paid_price_'+sub_event_size+'" name="paid_price_'+sub_event_size+'[]" class="search_events ticket_validates ticket_amount" placeholder="1000"></div><div class="col-md-2 col-sm-2 col-xs-2"><input value="'+sale_end_date+'" type="text" id="paid_start_ticket_date_'+sub_event_size+milliseconds+'" name="paid_start_ticket_date_'+sub_event_size+'[]" class="search_events free_quantity ticket_validates calend_end_date" placeholder="dd-mm-yyyy" readonly></div><div class="col-md-2 col-sm-2 col-xs-2"><input type="text" id="donation_max_count_'+sub_event_size+'" name="paid_max_count_'+sub_event_size+'[]" class="search_events free_quantity ticket_validates" placeholder="1" maxlength="2" onkeypress="return isNumber(event);"></div><div class="col-md-2 col-sm-2 col-xs-2"><input type="hidden" name="paid_order_'+sub_event_size+'[]" id="paid_order_'+sub_event_size+'" value="'+milliseconds+'"><input type="text" id="paid_min_count_'+sub_event_size+'" name="paid_min_count_'+sub_event_size+'[]" class="search_events free_quantity ticket_validates" placeholder="10" maxlength="2" onkeypress="return isNumber(event);"></div><div class="col-md-1 col-sm-1 col-xs-1"><img src="<?php echo $this->config->item('admin_image_path');?>close.png" class="img-responsives delete_ticket" alt="">	</div></div>';
		
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
		//console.log(link);
		document.getElementById('sponsor_error').style.display = 'none';
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
				//$('#add_sponsors').attr('disabled',false);				
				//unblockDiv('add_sponsors');
				
				document.getElementById("add_sponsors").style.display = ""; // to undisplay
				document.getElementById("buttonreplacement").style.display = "none"; // to display
				
				document.getElementById("add_sponsors").bgcolor = 'grey';
				document.getElementById('sponsor_error').style.display = 'block';
				document.getElementById('sponsor_error').style.color = 'green';
				document.getElementById('sponsor_error').innerHTML = "Image successfully uploaded";
				document.getElementById('hyperlink').value = "";
				document.getElementById('sponsor_image').value = "";
				document.getElementById('preview_sponsor_div').style.display = 'none';
			//	$(".preview_content").append('<li><img style="width:60px;height:60px;" src="<?php echo $image_url;?>'+json.message+'" class="img-responsive" alt="'+json.message+'"></img></li>');	
			
			$(".preview_content").append('<li><div class="img_close_div"><a class="sponsor_class_data" href="javascript:void(0);" onclick="remove(this);"><div class="close_button" ><i class="fa fa-times-circle" aria-hidden="true"></i></div></a><img style="width:60px;height:60px;" src="<?php echo $image_url;?>'+json.message+'" class="img-responsive" alt="'+json.message+'"></img></div></li>');
			}else{
			//	$('#add_sponsors').attr('disabled',false);
			//	unblockDiv('add_sponsors');
				
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

function add_sponsor_data_sub_event(id_value){
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
		url: "<?php echo $this->config->item('base_url');?>index.php/frontend/events/sponsor_sub_event_data",
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
			//	$(".preview_content_"+id_value).append('<li><img style="width:60px;height:60px;" src="<?php echo $image_url;?>'+json.message+'" class="img-responsive" alt="'+json.message+'"></img></li>');	
				$(".preview_content_"+id_value).append('<li><div class="img_close_div"><a class="sponsor_class_data" href="javascript:void(0);" onclick="remove(this);"><div class="close_button"><i class="fa fa-times-circle" aria-hidden="true"></i></div></a><img style="width:60px;height:60px;" src="<?php echo $image_url;?>'+json.message+'" class="img-responsive" alt="'+json.message+'"></img></div></li>');
			}else{
			//	$('#add_sponsors').attr('disabled',false);
			//	unblockDiv('add_sponsors');
				
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
					logo: {
                        required: true,
                    },
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
		$('#schedule_location_1').css({"border": ""});
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
	$('#schedule_location_1').css({"border": ""});
});

$('#event_location').blur(function(){
    $('#schedule_location_1').val(this.value);
	$('#schedule_location_1').css({"border": ""});
});

$('#event_location').change(function(){
    $('#schedule_location_1').val(this.value);
	$('#schedule_location_1').css({"border": ""});
});

$('#event_description').blur(function(){
    $('#schedule_event_description_1').val(this.value);
	$('#schedule_event_description_1').css({"border": ""});
});  
      
// auto fill textboxes
$('#title').keyup(function(){
    $('#schedule_title_1').val(this.value);
	$('#schedule_title_1').css({"border": ""});
});

$('#title').blur(function(){
    $('#schedule_title_1').val(this.value);
	$('#schedule_title_1').css({"border": ""});
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
		$('#schedule_start_date_1').css({"border": ""});
		$('#event_start_date').css({"border": "1px solid rgb(185, 193, 204)"});
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
		$('#schedule_end_date_1').css({"border": ""});
		var d = $("#event_end_time").val();
		$("#schedule_end_time_1").val(d);
		
		var e = $("#event_start_time").val();
		$("#schedule_start_time_1").val(e);
		$('#event_end_date').css({"border": "1px solid rgb(185, 193, 204)"});
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
		$('#schedule_start_date_1').css({"border": "1px solid rgb(185, 193, 204)"});
	  }
    });
	
	$("#schedule_end_date_1").datepicker({
	  changeMonth: true,
      changeYear: true,
	  dateFormat: 'dd-mm-yy',
	  yearRange: "+0:+100",
      minDate: 1,	
	  onSelect: function(selected) {	  
		$('#schedule_end_date_1').css({"border": "1px solid rgb(185, 193, 204)"});
	  }
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
		
		if(document.getElementById('no_image').checked == false){
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
		}
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
	
	data_out += '<h5 class="blue_txt paragraph">A. Event Schedule</h5><div class="jumbotron add_event_jumbotron jumbo_padding" id="more_event"><div class="row"><div class="col-md-8 col-sm-8"><div class="row"><div class="col-md-4 col-sm-4"><label for="schedule_title_'+page_size+'">Title</label></div><div class="col-md-8 col-sm-8"><input required="required" value="'+schedule_title+'" type="text" id="schedule_title_'+page_size+'" name="schedule_title_'+page_size+'" class="search_events create-event-text-validator" placeholder=""></div></div></div><div class="col-md-8 col-sm-8"><div class="row"><div class="col-md-4 col-sm-4"><label for="schedule_location">Location</label></div><div class="col-md-8 col-sm-8"><input required="required" type="text" value="'+schedule_location+'" id="schedule_location_'+page_size+'" readonly="readonly" name="schedule_location_'+page_size+'" class="search_events create-event-text-validator" placeholder=""></div></div></div><div class="col-md-8 col-sm-8"><div class="row"><div class="col-md-4 col-sm-4"><label for="schedule_start_date" >Start Date/Time<span>*</span></label></div><div class="col-md-8 col-sm-8"><div class="row"><div class="col-md-6 col-sm-6"><input readonly="readonly" required="required" type="text" onclick="generate_date_clock('+page_size+')" id="schedule_start_date_'+page_size+'" value="'+schedule_start_date+'" name="schedule_start_date_'+page_size+'" class="search_events create-event-text-validator" placeholder=""></div><div class="col-md-6 col-sm-6"><input type="text" id="schedule_start_time_'+page_size+'" value="'+schedule_start_time+'" onclick="generate_time_clock('+page_size+')" name="schedule_start_time_'+page_size+'" required="required" class="search_events create-event-text-validator" placeholder=""></div></div></div></div></div><div class="col-md-8 col-sm-8"><div class="row"><div class="col-md-4 col-sm-4"><label for="email">End Date/Time<span>*</span></label>    </div><div class="col-md-8 col-sm-8"><div class="row"><div class="col-md-6 col-sm-6">	<input  required="required" type="text" onclick="generate_date_clock('+page_size+')" value="'+schedule_end_date+'" id="schedule_end_date_'+page_size+'" name="schedule_end_date_'+page_size+'" class="search_events create-event-text-validator" placeholder=""></div><div class="col-md-6 col-sm-6">	<input  required="required" value="'+schedule_end_time+'" type="text" id="schedule_end_time_'+page_size+'" onclick="generate_time_clock('+page_size+')" name="schedule_end_time_'+page_size+'" class="search_events create-event-text-validator" placeholder=""></div></div></div></div></div><div class="col-md-8 col-sm-8"><div class="row"><div class="col-md-4 col-sm-4"><label for="email">Event Description<span>*</span></label></div><div class="col-md-8 col-sm-8"><textarea class="form-control txt_field create-event-text-area-validator" style="margin-bottom:0px" id="schedule_event_description_'+page_size+'" name="schedule_event_description_'+page_size+'" required="required">'+schedule_event_description+'</textarea></div></div></div></div></div>';
	
	data_out += '<h5 class="blue_txt paragraph">B. Create Ticket</h5><br><div class="jumbotron add_event_jumbotron jumbo_padding create_ticket_outer_'+page_size+'" style="margin-bottom:0px;"><div class="row create_ticket_inner"><div class="col-md-2 col-sm-2 col-xs-2"><label>Ticket Name &nbsp;<span>*</span></label></div><div class="col-md-1 col-sm-1 col-xs-13"><label>Quantity&nbsp;<span>*</span></label></div><div class="col-md-2 col-sm-2 col-xs-2"><label>Price &nbsp;<span>*</span></label></div>	<div class="col-md-2 col-sm-2 col-xs-2"><label>Sale End Date &nbsp;<span>*</span></label></div><div class="col-md-2 col-sm-2 col-xs-2"><label>Max Ticket Count &nbsp;<span>*</span></label></div><div class="col-md-2 col-sm-2 col-xs-2"><label>Min Ticket Count &nbsp;<span>*</span></label></div><div class="col-md-1 col-sm-1 col-xs-1"><label>Action</label></div></div>	<input type="hidden" id="ticket_alert" name="ticket_alert"></div><br class="clear">';
	
	data_out += '<div class="row"><div class="col-md-12"><div class="row"><div class="col-md-2 col-sm-4 col-xs-12"><button type="button" class="center-block submit_btn search_events" onclick="add_more_tickets('+"'free'"+','+page_size+')">+ Free Ticket</button></div><div class="col-md-2 col-sm-4 col-xs-12"><button type="button" class="center-block submit_btn  search_events" onclick="add_more_tickets('+"'paid'"+','+page_size+')">+ Paid Ticket</button></div><div class="col-md-2 col-sm-4 col-xs-12"><button type="button" class="center-block submit_btn search_events" onclick="add_more_tickets('+"'donation'"+','+page_size+')">+ Donation</button></div></div></div></div><br class="clear">';
	
	data_out += '<div class="row"><div class="col-md-12"><h5 class="blue_txt paragraph">C. Add a Sponsors</h5><br><div class="col-md-8"><div class="row"><div class="col-md-4 col-sm-4"><label for="sponsor_image_'+page_size+'" class="align_to_txt_box">Image(Max size 200kb)</label></div><div class="col-md-8 col-sm-8"><div class="input-group"><label class="input-group-btn"><span class="btn btn-primary browse_btn search_events">Browse… <input id="sponsor_image_'+page_size+'" name="sponsor_image_'+page_size+'" class="browse_txt_box create-event-file-validator" style="display: none;" placeholder="" type="file" onchange="add_sponsor_check('+page_size+');"></span></label><input id="name" name="name" class="search_events" placeholder="" readonly="" type="text"></div></div></div></div><div class="col-md-8" style="display:none;" id="preview_sponsor_div_'+page_size+'"><div class="row"><div class="col-md-4 col-sm-4"><label class="align_to_txt_box">&nbsp;</label></div><div class="col-md-8 col-sm-8"><div class="input-group"><img id="sponsor_preview_'+page_size+'" src="#" alt="" width="200px;"/></div></div></div></div><div class="col-md-8"><div class="row"><div class="col-md-4 col-sm-4"><label for="hyperlink" class="align_to_txt_box">Hyperlink</label></div><div class="col-md-8 col-sm-8"><input id="hyperlink_'+page_size+'" name="hyperlink_'+page_size+'" class="search_events" placeholder=""  type="text"><label style="display:none;" id="sponsor_error_'+page_size+'"></label><button id="add_sponsors_'+page_size+'" type="button" class="submit_btn search_events" onclick="add_sponsor_data_sub_event('+page_size+');">Add Sponsors</button><img alt="loading..." style="display:none;width:150px;height:30px;" id="buttonreplacement_'+page_size+'" src="<?php echo $this->config->item('frontend_image_path');?>images/ajax-loader.gif"></div></div></div><br class="clear"><div class="jumbotron remove_extra-padding"><ul class="list-inline list-unstyled preview_content_'+page_size+'"></ul></div><div class="col-md-12"><div class="row"><h5 class="blue_txt paragraph margin_down">D. Champions</h5><div class="col-md-3"><label for="is_supporter_allowed">Champions Allowed</label>&nbsp;&nbsp;<input type="checkbox" id="is_supporter_allowed_'+page_size+'" name="is_supporter_allowed_'+page_size+'" class="adjust_checkbox"></div><div class="col-md-3"><label for="verify_supporter">Verify Champions</label>&nbsp;&nbsp;<input type="checkbox" id="verify_supporter_'+page_size+'" name="verify_supporter_'+page_size+'" class="adjust_checkbox"><input type="hidden" id="organiser_id" name="organiser_id" class="" value=""><input type="hidden" id="free_ticket_count" name="free_ticket_count" class="" value="0"><input type="hidden" id="paid_ticket_count" name="paid_ticket_count" class="" value="0"><input type="hidden" id="donation_ticket_count" name="donation_ticket_count" class="" value="0"></div></div></div></div></div></div></div></div></div>';	

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

	$("#logo_event_image").change(function(){

	 	var fileExtension = ['jpg','jpeg','JPEG','Jpeg','PNG','png','Png'];
		if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
			document.getElementById('extra_space_logo').style.display = 'block';
			document.getElementById('extra_space_logo2').style.display = 'block';
			document.getElementById('logo_error').style.display = 'block';
			document.getElementById('logo_error').style.color = 'red';
			document.getElementById('logo_error').innerHTML = 'Please upload valid image';
			document.getElementById('event_logo_name').value = '';
			$('#blah').attr('src', '');
			return false;
		} 
	
		var fullPath = document.getElementById('logo_event_image').value;
		if (fullPath) {
			var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
			var filename = fullPath.substring(startIndex);
		if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
			filename = filename.substring(1);
		}
			document.getElementById('event_logo_name').value = filename;
			document.getElementById('logo_error').innerHTML = '';
			document.getElementById('logo_error').style.display = 'none';
		}	
	
		
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
	
	
	
	$('.create-event-text-validator').click(function(){
		var lastClass = $(this).attr('class').split(' ').pop();
		
		if(lastClass=="remove_date_border")
		{
			$(this).attr('style','border:1px solid rgb(185, 193, 204)');
		}
	});
	
	$('.create-event-text-validator').change(function(){
		var lastClass = $(this).attr('class').split(' ').pop();
		
		if(lastClass=="remove_date_border")
		{
			$(this).attr('style','border:1px solid rgb(185, 193, 204)');
		}
	});
	
   $('.calend_end_date').datepicker(); 
    $('.calend_end_date').on('change',function(){
       var index=$('.calend_end_date').index(this);
       $('.calend_end_date:eq('+index+')').val();
        
    });
});


$(document).on("keypress", ".ticket_validates", function () {	
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


$(document).on("blur", ".create-event-text-area-validator", function () {	
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
<script>
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
	
$(document).on("keyup", ".ticket_amount", function (event){  
    $(this).val($(this).val().replace(/[^0-9\.]/g,''));
 
	if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
        event.preventDefault();
    }
    var number = ($(this).val().split('.'));
    if (number[1] && number[1].length > 2){
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
	
	$(document).on("change", ".change_category", function () {    
		var category_evt = $(this).val();
		if(category_evt==''){
			$(this).css({"border": "1px solid red"});
		}else{
			$(this).css({"border": ""});
		}
    });
</script>