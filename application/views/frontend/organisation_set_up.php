<style>
	label {		
		font-weight: normal;
	}	
	
	span{
		color:red;
		font-weight: bold;
	}

	input[type="password"] {

		border: 1px solid rgb(185, 193, 204);

		color: #666;

		height: 43px;

		margin-bottom: 30px;

		padding: 8px 10px;

		width: 100%;

	}
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
						<h2>Organization Registration</h2>
					</div>
					<div class="col-md-6 col-sm-6">
						<ul>
							<li>
								<a href="#"><i class="fa fa-home"></i>Home</a>
							</li>
							<li>
								<a href="#"><i class="fa fa-angle-right"></i>Organisation Registration</a>
							</li>
						</ul>
					</div>
				</div>
				<!--ROW END-->
			</div>
		</div>
		<!--Kode-our-speaker-heading End-->
		<div class="kode-blog-style-2">
			<form enctype="multipart/form-data" method="POST" action="<?php echo $this->config->item('save_organiser');?>" name="organiser_form" id="organiser_form">
			<div class="container">
				<div class="row">	                      
                    <div class="col-md-6">
                        <label for="email">Position Title<span>*</span></label>
                        <input type="text" class="search_events" placeholder="" name="title" id="title" value="<?php echo set_value('title');?>">
						<?php echo form_error('title'); ?>
                    </div>
                    <br class="clear">
                        <div class="col-md-6">
                            <label for="email">Salutation<span>*</span></label>
                            <select class="search_events form-control dropdown" id="salutation" name="salutation">
                                <option value="">-- Please Select --</option>
								<option value="Mr.">Mr</option>
								<option value="Mrs.">Mrs</option>
								<option value="Ms.">Ms</option>		
                            </select>
							<?php echo form_error('salutation'); ?>
                        </div> 
                        <br class="clear">
                        <div class="col-md-6">
                            <label for="email">Name<span>*</span></label>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" name="first_name" id="first_name" class="search_events" placeholder="First Name" value="<?php echo set_value('first_name');?>">
									<?php echo form_error('first_name'); ?>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" id="last_name" name="last_name" class="search_events" placeholder="Last Name" value="<?php echo set_value('last_name');?>">
									<?php echo form_error('last_name'); ?>
                                </div>
                            </div>
                        </div>
                        <br class="clear">
                        <div class="col-md-6">
                            <label for="email">Email<span>*</span></label>
                            <input type="text" id="email" name="email" class="search_events" placeholder="" value="<?php echo set_value('email');?>">
							<?php echo form_error('email'); ?>
                        </div>
						<br class="clear">
                        <div class="col-md-6">
                            <label for="email">Password<span>*</span></label>
                            <input type="password" id="password" name="password" class="search_events" placeholder="" value="<?php echo set_value('password');?>">
                        </div>
						<br class="clear">
                        <div class="col-md-6">
                            <label for="email">Confirm Password<span>*</span></label>
                            <input type="password" id="confirm_password" name="confirm_password" class="search_events" placeholder="" value="<?php echo set_value('password');?>"> 
                        </div>
                        <br class="clear">
                        <div class="col-md-6">

                            <label for="email">Phone</label>

                            <input type="text" id="phone" name="phone" class="search_events" placeholder="" value="<?php echo set_value('phone');?>">

                        </div>

                        <br class="clear">

                        <div class="col-md-6">

                            <label for="email">Fax</label>

                            <input type="text" id="fax" name="fax" class="search_events" placeholder="" value="<?php echo set_value('fax');?>" id="fax" name="fax">
                        </div>      
                </div>
				<div class="row"> 
                    <h5>Organization details</h5>
						<br class="clear">
                        <div class="col-md-6">
                            <label for="email">Organization Name<span>*</span></label>
                            <input type="text" name="organisation_name" id="organisation_name" class="search_events" placeholder="" value="<?php echo set_value('organisation_name');?>">
							<?php echo form_error('organisation_name'); ?>
                        </div>
                        <br class="clear">
                        <div class="col-md-6">
                            <label for="email">IRD Number</label>
                            <input type="text" name="ird" id="ird" class="search_events" placeholder="">
                        </div>               
                        <br class="clear">
                        <div class="col-md-6">
                            <label for="email">Preferred charity name<span>*</span></label>
                            <input type="text" name="charity_name" id="charity_name" class="search_events" placeholder="Charity Name" value="<?php echo set_value('charity_name');?>">
							<?php echo form_error('charity_name'); ?>
                        </div>
                        <br class="clear">
                        <div class="col-md-6">
                            <label for="email">Charity Overview</label>
                            <textarea class="search_events form-control txt_field" name="charity_overview" id="charity_overview" placeholder="Please enter charity overview" value="<?php echo set_value('charity_overview');?>"></textarea>
                        </div>
                        <br class="clear">
                        <div class="col-md-12">
                            <label for="email">Choose up the three couse areas your organization is involved in.</label>
                            <div class="row">
                                <div class="col-md-2 col-sm-3">
                                    <input type="checkbox" value=""><label class="chkbox_space">Aged Care</label>
                                </div>
                                <div class="col-md-2 col-sm-3">
                                    <input type="checkbox" value=""><label class="chkbox_space">AIDs</label>
                                </div>
                                <div class="col-md-2 col-sm-3">
                                    <input type="checkbox" value=""><label class="chkbox_space">Babies</label>
                                </div>
                                <div class="col-md-2 col-sm-3">
                                    <input type="checkbox" value=""><label class="chkbox_space">Cancer</label>
                                </div>
                                <div class="col-md-2 col-sm-3">
                                    <input type="checkbox" value=""><label class="chkbox_space">Youth</label>
                                </div>
                                <div class="col-md-2 col-sm-3">
                                    <input type="checkbox" value=""><label class="chkbox_space">Sports</label>
                                </div>     
                                <div class="col-md-2 col-sm-3">
                                    <input type="checkbox" value=""><label class="chkbox_space">Youth</label>
                                </div>
                                <div class="col-md-2 col-sm-3">
                                    <input type="checkbox" value=""><label class="chkbox_space">Food Rescue</label>
                                </div>
                                <div class="col-md-2 col-sm-3">
                                    <input type="checkbox" value=""><label class="chkbox_space">Women</label>
                                </div>
                                <div class="col-md-2 col-sm-3">
                                    <input type="checkbox" value=""><label class="chkbox_space">School</label>
                                </div>
                                <div class="col-md-2 col-sm-3">
                                    <input type="checkbox" value=""><label class="chkbox_space">Human Rights</label>
                                </div>
                                <div class="col-md-2 col-sm-3">
                                    <input type="checkbox" value=""><label class="chkbox_space">Protection</label>
                                </div> 
                                <div class="col-md-2 col-sm-3">
                                    <input type="checkbox" value=""><label class="chkbox_space">Drugs & Alcohol</label>
                                </div>
                                <div class="col-md-2 col-sm-3">
                                    <input type="checkbox" value=""><label class="chkbox_space">Health</label>
                                </div>
                                <div class="col-md-2 col-sm-3">
                                    <input type="checkbox" value=""><label class="chkbox_space">Education</label>
                                </div>
                                <div class="col-md-2 col-sm-3">
                                    <input type="checkbox" value=""><label class="chkbox_space">Animal Welfare</label>
                                </div> 
                            </div>
                        </div>
                        <br class="clear">
                        <div class="col-md-6">
                            <label for="email">Logo<span>*</span></label>
                            <div class="search_events input-group">
                                <label class="input-group-btn">
                                    <span class="btn btn-primary browse_btn">
                                    Browse&hellip; <input type="file" name="logo" id="logo" class="browse_txt_box" style="display: none;" placeholder="">
                                    </span>
                                </label>
                            <input type="text" id="name" name="name" class="search_events" placeholder="" readonly>
                           </div>
						   <?php echo form_error('logo'); ?>
                        </div>
                        <br class="clear">
                        <h5>Registered Address</h5>
                        <br class="clear">   
                        <div class="col-md-6">
                            <label for="email">Street Address<span>*</span></label>
                            <input type="text" id="street_address" name="street_address" class="search_events" placeholder="Please enter street address" value="<?php echo set_value('street_address');?>">
							 <?php echo form_error('street_address'); ?>
                        </div>
                        <br class="clear">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="email">City<span>*</span></label>
                                    <input type="text" id="city" name="city" class="search_events" placeholder="Please enter city" id="city" name="city" value="<?php echo set_value('city');?>">
									 <?php echo form_error('city'); ?>
                                </div>
                                <div class="col-md-6">
                                	<label for="email">State/Region<span>*</span></label>
                                    <input type="text" placeholder="Please enter state name" name="state" id="state" value="<?php echo set_value('state');?>" class="search_events">
									 <?php echo form_error('state'); ?>
                                </div>
                            </div>
                        </div>
                        <br class="clear">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="email">Postal Code<span>*</span></label>
                                    <input type="text" class="search_events" placeholder="Please enter postal code" id="postal_code" name="postal_code" value="<?php echo set_value('postal_code');?>">
									<?php echo form_error('postal_code'); ?>
                                </div>
                                <div class="col-md-6">
                                	<label for="email">Country<span>*</span></label>
                                    <input type="text" id="country" name="country" type="text" class="search_events" placeholder="Please enter country name" value="<?php echo set_value('country');?>">
									<?php echo form_error('country'); ?>
                                </div>
                            </div>
                        </div>    
                        <br class="clear">
                        <h5>Financial Contact</h5>
                        <br class="clear">
                        <div class="col-md-6">
                            <label for="email">Finance Officer Position</label>
                            <input type="text" class="search_events" placeholder="Please enter finace position" id="finance_position" name="finance_position" value="<?php echo set_value('finance_position');?>">
							<?php echo form_error('finance_position'); ?>
                        </div>
                        <br class="clear">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="email">First Name<span>*</span></label>
                                    <input type="text" name="finance_first_name" type="text" class="search_events" placeholder="Please enter first name" value="<?php echo set_value('finance_first_name');?>">
									<?php echo form_error('finance_first_name'); ?>
                                </div>
                                <div class="col-md-6">
                                	<label for="email">Last Name<span>*</span></label>
                                    <input type="text" id="finance_last_name" name="finance_last_name" type="text" class="search_events" placeholder="Please enter last name" value="<?php echo set_value('finance_last_name');?>">
									<?php echo form_error('finance_last_name'); ?>
                                </div>
                            </div>
                        </div>
                        <br class="clear">
                        <div class="col-md-6">
                            <label for="email">Email<span>*</span></label>
                            <input type="text" id="finance_email" name="finance_email" type="text" class="search_events" placeholder="Please enter finance email address" value="<?php echo set_value('finance_email');?>">
							<?php echo form_error('finance_email'); ?>
                        </div>
                        <br class="clear">
                        <div class="col-md-6">
                            <label for="email">Phone</label>
                            <input type="text" name="finance_phone" id="finance_phone" type="text" class="search_events" placeholder="Please enter phone number" value="<?php echo set_value('finance_phone');?>">
							
                        </div>
                        <br class="clear">
                        <div class="col-md-6">
                            <label for="email">Fax</label>
                            <input type="text" placeholder="Please enter fax number" name="finance_fax" id="finance_fax" value="<?php echo set_value('finance_fax');?>">
                        </div>
                        <br class="clear">
                        <h5>Bank Details</h5>    
                        <br class="clear">
                        <div class="col-md-6">
                            <label for="email">Bank Name<span>*</span></label>
                            <input type="text" name="bank_name" id="bank_name" type="text" class="inp" placeholder="Please enter bank name" value="<?php echo set_value('bank_name');?>">
							<?php echo form_error('bank_name'); ?>
                        </div>
                        <br class="clear">
                        <div class="col-md-6">
                            <label for="email">Banking Details<span>*</span></label>
                            <input type="text" name="bank_details" id="bank_details" type="text" class="inp" placeholder="Please enter bank details" value="<?php echo set_value('bank_details');?>">
							<?php echo form_error('bank_details'); ?>
                        </div>
                        <br class="clear">
                        <div class="col-md-6">
                            <label for="email">Receipt Text</label>
                            <textarea class="search_events form-control txt_field" type="text" class="inp" id="recpt_txt" name="recpt_txt"><?php echo set_value('recpt_txt');?></textarea>
							
                        </div>
                        <br class="clear">
                        <div class="col-md-6">
                            <label for="email">Attach your Electronic Signature<span>*</span></label>
                            <div class="search_events input-group">
                                <label class="input-group-btn">
                                    <span class="btn btn-primary browse_btn">
                                    Browse&hellip; <input type="file" id="bank_signature" name="bank_signature" class="browse_txt_box" style="display: none;" placeholder="">
                                    </span>
                                </label>
                            <input type="text" id="name" name="name" class="search_events" placeholder="" readonly>
                           </div>
						   <?php echo form_error('bank_signature'); ?>
                        </div>
                        <br class="clear">
                        <div class="col-md-6">
                            <label for="email">Attach your Bank Statement<span>*</span></label>
                            <div class="search_events input-group">
                                <label class="input-group-btn">
                                    <span class="btn btn-primary browse_btn">
                                    Browse&hellip; <input type="file" id="bank_statement" name="bank_statement" class="browse_txt_box" style="display: none;" placeholder="">
                                    </span>
                                </label>
                            <input type="text" id="name" name="name" class="required" placeholder="" readonly>
                           </div>						  
                        </div>
						<?php echo form_error('bank_statement'); ?>
                        <br class="clear">
                        <div class="col-md-2 col-sm-2 col-xs-6">
                       <button class="search_events submit_btn" type="submit">Submit</button>
                        </div>
						<div class="col-md-2 col-sm-2 col-xs-6">
                        <button class="search_events submit_btn">Cancel</button>
                        </div>
                </div>
			</div>
			</form>
		</div>
</div>
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
<script>
(function($,W,D){
    var user_validation = {}; 
    user_validation.UTIL =
    {
        setupFormValidation: function()
        {
            //form validation rules
            $("#organiser_form").validate({
                rules: {                   
                   	title: {
                        required: true,
                    },
					salutation: {
                        required: true,
                    },
					first_name: {
                        required: true,						
                    },
					last_name: {
                        required: true,						
                    },
					password: {
                        required: true,						
                    },
					confirm_password: {
                        required: true,						
                    },
					email: {
                        required: true,
						email:true,
                    },
					organisation_name: {
                        required: true,
                    },
					charity_name: {
                        required: true,
                    },
					finance_position: {
                        required: true,
                    },
					finance_first_name: {
                        required: true,
                    },
					finance_last_name: {
                        required: true,
                    },
					finance_email: {
                        required: true,
						email:true,
                    },
					bank_name: {
                        required: true,
                    },
					bank_details: {
                        required: true,
                    },
					bank_signature: {
                        required: true,
                    },
					bank_statement: {
                        required: true,
                    }					
                },
                messages: {},
                submitHandler: function(form) {
                    form.submit();
                }
            });
        }
    }
    //when the dom has loaded setup form validation rules
    $(D).ready(function($) {
        user_validation.UTIL.setupFormValidation();
    }); 
})(jQuery, window, document);

</script>