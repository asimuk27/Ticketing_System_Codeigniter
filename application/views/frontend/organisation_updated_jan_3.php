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
		margin-bottom: 10px;
		padding: 8px 10px;
		width: 100%;
	}
	input[type="text"] { 
		margin-bottom: 10px;
	}
	.error{
		color:red;
	}
	#true{
		color:green;
	}
	#false{
		color:red;
	}
   .fix_margin{margin-top:10px;}
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
						<h2>Organizer Sign Up</h2>
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
                            <label for="title">Position Title<span>*</span></label>
                            <input type="text" class="search_events form-control" placeholder="Position Title" name="title" id="title" value="<?php echo set_value('title');?>">
							<?php echo form_error('title'); ?>
                        </div>
                        <br class="clear">
                        <div class="col-md-6">
                            <label for="salutation">Salutation<span>*</span></label>
                           <select class="search_events form-control dropdown" id="salutation" name="salutation">
                                <option value="">-- Please Select --</option>
								<option value="Mr">Mr</option>
								<option value="Mrs">Mrs</option>
								<option value="Ms">Ms</option>	
                            </select>
							<?php echo form_error('salutation'); ?>
                        </div>                       
                        <br class="clear">
                        <div class="col-md-6">
                            <label for="first_name">Name<span>*</span></label>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" name="first_name" id="first_name" class="search_events form-control" placeholder="First Name" value="<?php echo set_value('first_name');?>">
									<?php echo form_error('first_name'); ?>
                                </div>
                                <div class="col-md-6">
                                     <input type="text" id="last_name" name="last_name" class="search_events form-control" placeholder="Last Name" value="<?php echo set_value('last_name');?>">
									<?php echo form_error('last_name'); ?>
                                </div>
                            </div>
                        </div>
						
						<br class="clear">
                        <div class="col-md-6">
                            <label for="preferred_name">Preferred Name</label>
                             <input type="text" id="preferred_name" name="preferred_name" class="search_events form-control" placeholder="Preferred Name" value="">						
                        </div>
						
                        <br class="clear">
                        <div class="col-md-6">
                            <label for="email">Email<span>*</span>(This email will be registered against the organization and can only be used for management of organization)</label>
                             <input type="text" id="email" name="email" placeholder="Email" class="search_events form-control" placeholder="" value="<?php echo set_value('email');?>">
							<?php echo form_error('email'); ?>
                        </div>
						<br class="clear">
                        <div class="col-md-6">
                            <label for="password">Password<span>*</span></label>
                           <input type="password" id="password" name="password" placeholder="Password" class="search_events form-control" placeholder="" value="<?php echo set_value('password');?>">
                        </div>
						<br class="clear">
                        <div class="col-md-6">
                            <label for="confirm_password">Confirm Password<span>*</span></label>
                            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" class="search_events form-control" placeholder="" value="<?php echo set_value('password');?>"> 
                        </div>
                        <br class="clear">
                        <div class="col-md-6">
                            <label for="phone">Phone</label>
                           <input type="text" id="phone" name="phone" class="search_events form-control" placeholder="Phone" value="<?php echo set_value('phone');?>">

                        </div>
                        <br class="clear">
                        <div class="col-md-6">
                            <label for="fax">Fax</label>
                            <input type="text" id="fax" name="fax" class="search_events form-control" placeholder="Fax" value="<?php echo set_value('fax');?>" id="fax" name="fax">
                        </div>                        
                </div>
				<div class="row">
						<div class="col-md-6 fix_margin"> 
							<h5>Organization Details</h5>
						</div>
						<br class="clear">
                        <div class="col-md-6">
                            <label for="organisation_name">Organization Name<span>*</span></label>
                              <input type="text" placeholder="Organization Name" name="organisation_name" id="organisation_name" class="search_events form-control" placeholder="" value="<?php echo set_value('organisation_name');?>">
							<?php echo form_error('organisation_name'); ?>
                        </div>
                        <br class="clear">
                        <div class="col-md-6">
                            <label for="ird">IRD Number</label>
                           <input type="text" name="ird" id="ird" class="search_events form-control" placeholder="IRD Number">
                        </div>
						
						<br class="clear">
                        <div class="col-md-6">
                            <label for="organization_nature">What is the nature of your Organization ?</label>
                            <input type="text" name="organization_nature" id="organization_nature" class="search_events form-control" placeholder="Organization Nature" value="<?php //echo set_value('charity_name');?>">
							
                        </div>
						
						<br class="clear">
                        <div class="col-md-6">
                            <label for="donee_status">Are you approved for the donee status under the Income Tax Act 2007 ?</label>
                             <select class="search_events form-control dropdown" id="donee_status" name="donee_status">
                                <option value="">-- Please Select --</option>
								<option value="1">Yes</option>
								<option value="0">No</option>
                            </select>							
                        </div>
						
						<br class="clear">
                        <div class="col-md-6">
                            <label for="charities_commission">Do you hold a registration with the Charities Commission ?</label>
                            <select class="search_events form-control dropdown" id="charities_commission" name="charities_commission">
                                <option value="">-- Please Select --</option>
								<option value="1">Yes</option>
								<option value="0">No</option>
                            </select>							
                        </div>
						
						<br class="clear">
                        <div class="col-md-6">
                            <label for="registration_number">If Yes, What is your registration number ? If No,leave this field blank. </label>
                            <input type="text" name="registration_number" id="registration_number" class="form-control search_events" placeholder="Registration Number" value="">
							
                        </div>
						
                        <br class="clear">
                        <div class="col-md-6">
                            <label for="charity_name">Preferred Organization name.<span>*</span></label>
                            <input type="text" name="charity_name" id="charity_name" class="search_events form-control" placeholder="Preferred Organization Name" value="<?php echo set_value('charity_name');?>">
							<?php echo form_error('charity_name'); ?>
                        </div>
                        <br class="clear">
                        <div class="col-md-6">
                            <label for="charity_overview">Overview</label>
                            <textarea class="search_events form-control" name="charity_overview" id="charity_overview" placeholder="Overview" value="<?php echo set_value('charity_overview');?>"></textarea>
                        </div>
                        <br class="clear">
                        <div class="col-md-12">
                            <label>Choose up the couse areas your organization is involved in.</label>
                            <div class="row">
                                <div class="col-md-2 col-sm-3">
                                    <input type="checkbox" value="1" name="areas[]"><label class="chkbox_space">Aged Care</label>
                                </div>
                                <div class="col-md-2 col-sm-3">
                                    <input type="checkbox" value="2" name="areas[]"><label class="chkbox_space">AIDs</label>
                                </div>
                                <div class="col-md-2 col-sm-3">
                                    <input type="checkbox" value="3" name="areas[]"><label class="chkbox_space">Babies</label>
                                </div>
                                <div class="col-md-2 col-sm-3">
                                    <input type="checkbox" value="4" name="areas[]"><label class="chkbox_space">Cancer</label>
                                </div>
                                <div class="col-md-2 col-sm-3">
                                    <input type="checkbox" value="5" name="areas[]"><label class="chkbox_space">Youth</label>
                                </div>
                                <div class="col-md-2 col-sm-3">
                                    <input type="checkbox" value="6" name="areas[]"><label class="chkbox_space">Sports</label>
                                </div>
                                
                                <div class="col-md-2 col-sm-3">
                                    <input type="checkbox" value="8" name="areas[]"><label class="chkbox_space">Food Rescue</label>
                                </div>
                                <div class="col-md-2 col-sm-3">
                                    <input type="checkbox" value="9" name="areas[]"><label class="chkbox_space">Women</label>
                                </div>
                                <div class="col-md-2 col-sm-3">
                                    <input type="checkbox" value="10" name="areas[]"><label class="chkbox_space">School</label>
                                </div>
                                <div class="col-md-2 col-sm-3">
                                    <input type="checkbox" value="11" name="areas[]"><label class="chkbox_space">Human Rights</label>
                                </div>
                                <div class="col-md-2 col-sm-3">
                                    <input type="checkbox" value="12" name="areas[]"><label class="chkbox_space">Protection</label>
                                </div>
                                
                                <div class="col-md-2 col-sm-3">
                                    <input type="checkbox" value="13" name="areas[]"><label class="chkbox_space">Drugs & Alcohol</label>
                                </div>
                                <div class="col-md-2 col-sm-3">
                                    <input type="checkbox" value="14" name="areas[]"><label class="chkbox_space">Health</label>
                                </div>
                                <div class="col-md-2 col-sm-3">
                                    <input type="checkbox" value="15" name="areas[]"><label class="chkbox_space">Education</label>
                                </div>
                                <div class="col-md-2 col-sm-3">
                                    <input type="checkbox" value="16" name="areas[]"><label class="chkbox_space">Animal Welfare</label>
                                </div>
                                
                            </div>
                        </div>
                        <br class="clear">
                        <div class="col-md-6">
                            <label for="logo" style="margin-bottom:15px;">Logo<span>*</span> <b>(Max size 500kb)</b></label>
                            <div class="search_events input-group">
                                <label class="input-group-btn">
                                    <span class="btn btn-primary browse_btn">
                                    Browse&hellip; <input type="file" name="logo" id="logo" class="browse_txt_box" style="display: none;" placeholder="">
                                    </span>
                                </label>
                            <input type="text" id="logo_name" name="logo_name" class="search_events" placeholder="" readonly>
                           </div>
						    <?php echo form_error('logo'); ?>
                        </div>
						<br class="clear" style="display:none;" id="extra_space_logo">						
						<div class="col-md-6" style="margin-bottom:10px;">
							<label id="logo_error"></label>
							<img id="blah" src="#" alt="" style="display:none;"/>
						</div>
                        <br class="clear">
                       <div class="col-md-6"> 
					   <h5>Registered Address</h5>
					   </div> 
                        <br class="clear">
                    
                        <div class="col-md-6">
                            <label for="street_address">Street Address<span>*</span></label>
                            <input type="text" id="street_address" name="street_address" class="search_events form-control" placeholder="Street Address" value="<?php echo set_value('street_address');?>">
							 <?php echo form_error('street_address'); ?>
                        </div>
                        <br class="clear">
                        <div class="col-md-6">
                            <div class="row">
                                 <div class="col-md-6">
                                	<label for="state">Suburb<span>*</span></label>
                                     <input type="text" placeholder="Suburb" name="state" id="state" value="<?php echo set_value('state');?>" class="search_events form-control">
									 <?php echo form_error('state'); ?>
                                </div>
								<div class="col-md-6">
                                    <label for="city">City<span>*</span></label>
                                    <input type="text" id="city" name="city" class="search_events form-control" placeholder="City" id="city" name="city" value="<?php echo set_value('city');?>">
									 <?php echo form_error('city'); ?>
                                </div>                               
                            </div>
                        </div>
                        <br class="clear">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="postal_code">Postal Code<span>*</span></label>
                                       <input type="text" class="search_events form-control" placeholder="Postal Code" id="postal_code" name="postal_code" value="<?php echo set_value('postal_code');?>">
									<?php echo form_error('postal_code'); ?>
                                </div>
                                <div class="col-md-6">
                                	<label for="country">Country<span>*</span></label>
                                     <select class="search_events form-control dropdown" id="country" name="country">										
										<option value="NewZealand">New Zealand</option>
										<option value="Australia">Australia</option>
									</select>										 

                                </div>
                            </div>
                        </div>
                        
                        <br class="clear">
						<div class="col-md-6"> 
                        <h5>Financial Contact</h5>
						</div>
                        <br class="clear">
                        <div class="col-md-6">
                            <label for="finance_position">Finance Officer Position<span>*</span></label>
                           <input type="text" class="search_events form-control" placeholder="Finace Position" id="finance_position" name="finance_position" value="<?php echo set_value('finance_position');?>">
							<?php echo form_error('finance_position'); ?>
                        </div>
                        <br class="clear">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="finance_first_name">First Name<span>*</span></label>
                                   <input type="text" id="finance_first_name" name="finance_first_name" type="text" class="search_events form-control" placeholder="First Name" value="<?php echo set_value('finance_first_name');?>">
									<?php echo form_error('finance_first_name'); ?>
                                </div>
                                <div class="col-md-6">
                                	<label for="finance_last_name">Last Name<span>*</span></label>
                                     <input type="text" id="finance_last_name" name="finance_last_name" type="text" class="search_events form-control" placeholder="Last Name" value="<?php echo set_value('finance_last_name');?>">
									<?php echo form_error('finance_last_name'); ?>
                                </div>
                            </div>
                        </div>
                        <br class="clear">
                        <div class="col-md-6">
                            <label for="finance_email">Email<span>*</span></label>
                             <input type="text" id="finance_email" name="finance_email" type="text" class="search_events form-control" placeholder="Finance Email" value="<?php echo set_value('finance_email');?>">
							<?php echo form_error('finance_email'); ?>
                        </div>
                        <br class="clear">
                        <div class="col-md-6">
                            <label for="finance_phone">Phone</label>
                            <input type="text" name="finance_phone" id="finance_phone" type="text" class="search_events form-control" placeholder="Phone Number" value="<?php echo set_value('finance_phone');?>">
                        </div>
                        <br class="clear">
                        <div class="col-md-6">
                            <label for="finance_fax">Fax</label>
                             <input type="text" placeholder="Fax Number" name="finance_fax" id="finance_fax" value="<?php echo set_value('finance_fax');?>" class="form-control">
                        </div>
                        
                       
                        <br class="clear">
						<div class="col-md-6"> 
                        <h5>Bank Details</h5>  
						</div>
                        <br class="clear">
                        <div class="col-md-6">
                            <label for="bank_name">Bank Name<span>*</span></label>
                            <input type="text" name="bank_name" id="bank_name" type="text" class="form-control" placeholder="Bank Name" value="<?php echo set_value('bank_name');?>">
							<?php echo form_error('bank_name'); ?>
                        </div>
                        <br class="clear">
                        <div class="col-md-6">
                            <label for="bank_details">Banking Account Number<span>*</span></label>
                            <input type="text" name="bank_details" id="bank_details" type="text" class="form-control" placeholder="Account Number" value="<?php echo set_value('bank_details');?>">
							<?php echo form_error('bank_details'); ?>
                        </div>
                        <br class="clear">
                        <div class="col-md-6">
                            <label for="bank_statement">Attach your Bank Statement<span>*</span></label>

                            <div class="search_events input-group">

                                <label class="input-group-btn">

                                    <span class="btn btn-primary browse_btn" data-toggle="popover" data-content="To verify your bank account, attach a copy of your donation bank account details on the bank statement. Confidential and financial information can be covered up.">

                                    Browse&hellip; <input type="file" id="bank_statement" name="bank_statement" class="browse_txt_box" style="display: none;" placeholder="">

                                    </span>
                                </label>
                            <input type="text" id="ste" name="ste" placeholder="" readonly>
                           </div>
						   <?php echo form_error('bank_statement'); ?>							
                        </div> 
						<br class="clear">
						<div class="col-md-6 col-sm-6 col-xs-12">							
							<p id="true" style="display:none;">Successfully attached</p>
						    <p id="false" style="display:none;">Not a valid file. Only pdf and Image are allowed.</p>
						</div>					
						
                        <br class="clear">
						<div class="col-md-6"> 
							<h5>Receipt Details</h5> 
						</div>
						<br class="clear">  
                        <div class="col-md-6">
                            <label for="recpt_txt">Receipt Text</label>
                            <textarea class="search_events form-control" type="text" class="form-control" id="recpt_txt" name="recpt_txt" placeholder="Receipt Text"><?php echo set_value('recpt_txt');?></textarea>
                        </div>
						<br class="clear">  
                        <div class="col-md-6">
                            <label for="sig_txt">Signature Text</label>
                            <textarea class="search_events form-control" type="text" class="form-control" id="sig_txt" name="sig_txt" placeholder="Signature Text"><?php echo set_value('sig_txt');?></textarea>
                        </div>
                        <br class="clear">
                        <div class="col-md-6">
                            <label for="bank_signature">Attach your Electronic Signature<span>*</span>(This is the signature that would appear on the receipt sent by the system.)</label>
                            <div class="search_events input-group">
                                <label class="input-group-btn">
                                    <span class="btn btn-primary browse_btn" data-toggle="popover" data-content=" If you are approved for Donee status under the Income Tax Act 2007, please upload a JPG or GIF formatted electronic signature for an officer authorised to accept donations, to be signatory on receipts.">
                                    Browse&hellip; <input type="file" id="bank_signature" name="bank_signature" class="browse_txt_box" style="display: none;" placeholder="">
                                    </span>
                                </label>
                            <input type="text" id="sing_name" name="sing_name"  placeholder="" readonly>
                           </div>
							<?php echo form_error('bank_signature'); ?>
                        </div>
						
						<br class="clear" style="display:none;" id="space_logo">
						<div class="col-md-6" style="margin-bottom:10px;">
							<img id="bank_signature_preview" src="#" alt="" style="display:none;" height="200px;"/>
						</div>					
                         <br class="clear">

                        <div class="col-md-6">
     <input type="checkbox" name='tc' id="tc" value="" required="required" onclick="return false" >&nbsp;&nbsp;&nbsp;<a for="tc" class="search_events" data-toggle="modal" data-target="#myModal" style="cursor:pointer">show terms and conditions</a>
   </div>
    <br class="clear">
                        <br class="clear">
                        <div class="col-md-1 col-sm-1 col-xs-6" style="margin-right:30px;">
							<button class="submit_btn" type="submit">Submit</button>
                        </div>
						<div class="col-md-2 col-sm-2 col-xs-6">
                        <button type="button" class="submit_btn" onclick="javascript:history.back();">Cancel</button>
                    </div>
                </div>
			</div>
		</form>
	</div>
</div>
<link href="<?php echo $this->config->item('frontend_css_path');?>jquery-ui.css" rel="stylesheet">
<script src="<?php echo $this->config->item('frontend_js_path');?>jquery-ui.min.js"></script>	
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>	
<?php $email_url = $this->config->item('base_url')."index.php/frontend/registration/email_unique_check";?>
<?php $charity_check_url = $this->config->item('base_url')."index.php/frontend/registration/charity_name_unique_check";?>
<script>
	(function($,W,D){
    var user_validation = {}; 
    user_validation.UTIL =
    {
        setupFormValidation: function()
        {
            //form validation rules
            $("#organiser_form").validate({
				ignore: [],
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
					logo: {
                        required: true,
                    },
					bank_signature: {
                        required: true,						
                    },
					bank_statement: {
                        required: true,						
                    },
					email: {
                        required: true,
                        email: true,
						"remote":
							{
								url: "<?php echo $email_url;?>",
								type: "post",
								data:
								{
									email: function()
								{
									return $('#email').val();
								}
							}
						}
                    },
					organisation_name: {
                        required: true,
                    },
					phone:{
						number:true,
					},
					fax:{
						number:true,
					},
					finance_phone:{
						number:true,
					},
					finance_fax:{
						number:true,
					},
					password: {
                        required: true,	
						minlength: 7,
                    },
					confirm_password: {
                        required: true,
						minlength: 7,
						equalTo: "#password"
                    },
					charity_name: {
                        required: true,
						"remote":
							{
								url: "<?php echo $charity_check_url;?>",
								type: "post",
								data:
								{
									charity_name: function()
								{
									return $('#charity_name').val();
								}
							}
						}
                    },
					street_address: {
                        required: true,
                    },
					city: {
                        required: true,
                    },
					state: {
                        required: true,
                    },
					postal_code: {
                        required: true,
						digits:true,						
                    },
					country: {
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
                    }			
                },
                messages: {
					email: {                   
						remote: jQuery.validator.format("{0} already in use.")
					},
					charity_name: {                   
						remote: jQuery.validator.format("{0} already in use.")
					},
					phone: {                   
						minlength: jQuery.validator.format("Phone should be 10 digit length."),
						maxlength: jQuery.validator.format("Phone should be 10 digit length.")
					},
					fax: {                   
						minlength: jQuery.validator.format("Fax number should be 10 digit length."),
						maxlength: jQuery.validator.format("Fax number should be 10 digit length.")
					},
					finance_fax: {                   
						minlength: jQuery.validator.format("Fax number should be 10 digit length."),
						maxlength: jQuery.validator.format("Fax number should be 10 digit length.")
					},
					finance_phone: {                   
						minlength: jQuery.validator.format("Phone should be 10 digit length."),
						maxlength: jQuery.validator.format("Phone should be 10 digit length.")
					},
					postal_code: {
						minlength: jQuery.validator.format("Postal Code should be 6 digit"),
						maxlength: jQuery.validator.format("Postal Code should be 6 Digit.")
					},
					confirm_password: {                   
						equalTo: jQuery.validator.format("confirm password should be same as password")
					},
				},
                submitHandler: function(form) {
                    form.submit();
                }
            });
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

$("#bank_statement").change(function(){
  //  readURL(this);
	var fileExtension = ['pdf','jpg','jpeg','JPEG','Jpeg'];
                if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                    //alert("Only '.csv','.pdf' formats are allowed.");
				  document.getElementById('false').style.display= '';
				  document.getElementById('true').style.display= 'none';
			
				}
					else
					{
	                document.getElementById('true').style.display='';
					document.getElementById('false').style.display= 'none';
					}
});


</script>

 <!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title hr_header">Terms and conditions</h4>
      </div>
      <div class="modal-body">
   <div style="width:100%; height:300px; overflow: auto;" >
    The terms and conditions document includes the following provisions: a licence of the copyright in the website (and restrictions on what may be done with the material on the website) a disclaimer of liability a clause governing the use of passwords and restricted areas of the website an acceptable use clause a variation clause an entire agreement clause a clause specifying the applicable law and the jurisdiction in which disputes will be decided a provision specifying some of the information which needs to be disclosed under the Ecommerce Regulations a licence of the copyright in the website (and restrictions on what may be done with the material on the website) a disclaimer of liability a clause governing the use of passwords and restricted areas of the website an acceptable use clause a variation clause an entire agreement clause a clause specifying the applicable law and the jurisdiction in which disputes will be decided a provision specifying some of the information which needs to be disclosed under the Ecommerce Regulations a licence of the copyright in the website (and restrictions on what may be done with the material on the website) a disclaimer of liability a clause governing the use of passwords and restricted areas of the website an acceptable use clause a variation clause an entire agreement clause a clause specifying the applicable law and the jurisdiction in which disputes will be decided a provision specifying some of the information which needs to be disclosed under the Ecommerce Regulations Please read the notes accompanying the terms and conditions very carefully. You will of course need to adapt the terms to suit your website and business. 
</div>

      </div>
      <div class="modal-footer">
      <div  style="float:left">  
         <input type="checkbox" name='modal_tc' id="modal_tc" value="" required="required">&nbsp;&nbsp;&nbsp;<label for="modal_tc" class="search_events">I agree</label>
      </div>

        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>




<script>
$(document).ready(function(){

$('#tc').click(function(){

  if($(this).is(':checked')){
     $(this).attr('checked', false); // Unchecks it
  }

});

$('#modal_tc').click(function(){

  if($(this).is(':checked')){
     $('#tc').prop( "checked", true ); // checks it
      $('#myModal').modal('hide');
      }
     
  
  else{
      $('#tc').prop( "checked", false ); // unchecks it
  }

});

});
</script>

