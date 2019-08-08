<style>
	input[type="password"]{
		border: 1px solid rgb(185, 193, 204);
		color: #666;
		height: 43px;
		margin-bottom: 15px;
		padding: 8px 10px;
		width: 100%;
	}
	
	span{color:red;}
	
	label {		
		font-weight: normal;
	}
</style>
<link rel="stylesheet" href="<?php echo $this->config->item('frontend_css_path');?>placeholder.css">
<script src="<?php echo $this->config->item('admin_js_path');?>lightbox.js"></script>
<link href="<?php echo $this->config->item('admin_css_path');?>lightbox.css" rel="stylesheet" type="text/css">	
<script>
	function closeAlertPopUp(){
		$(".lightbox, .lightbox-panel").remove();
	}
</script>
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
					<h2>Edit Organization</h2>
				</div>				
			</div>
			<!--ROW END-->
		</div>
	</div>
	<!--Kode-our-speaker-heading End-->
	<div class="kode-blog-style-2">
		<div class="container">	
		<form enctype="multipart/form-data" method="POST" action="<?php echo $this->config->item('update_fe_organization_details')?>" name="organiser_edit_form" id="organiser_edit_form">		
			<div class="row">				
				<?php 
					if($data['phone'] == 0){ $data['phone'] = "";}
					if($data['fax'] == 0){ $data['fax'] = "";}
					if($data['postal_code'] == 0){ $data['postal_code'] = "";}
					if($data['finance_phone'] == 0){ $data['finance_phone'] = "";}
					if($data['finance_fax'] == 0){ $data['finance_fax'] = "";}				
				?>
					<div class="col-md-6">
						<label for="title">Position Title<span>*</span></label>
						<input value="<?php echo set_value('title',$data['title']);?>" type="text" id="title" name="title" class="form-control search_events" placeholder="">
						<?php echo form_error('title'); ?>
					</div>
					<br class="clear">
					<div class="col-md-6">
						<label for="salutation">Salutation<span>*</span></label>
						<input value="<?php echo set_value('salutation',$data['salutation']);?>" type="text" id="salutation" name="salutation" class="form-control search_events" placeholder="">
						<?php echo form_error('salutation'); ?>
					</div>                       
					<br class="clear">
					<div class="col-md-6">
						<label for="first_name">Name<span>*</span></label>
						<div class="row">
							<div class="col-md-6">
								<input type="text" id="first_name" name="first_name" class="form-control search_events" placeholder="First Name" value="<?php echo set_value('first_name',$data['first_name']);?>">
							</div>
							
							<div class="col-md-6">
								<input type="text" id="last_name" name="last_name" class="form-control search_events" placeholder="Last Name" value="<?php echo set_value('last_name',$data['last_name']);?>">
							</div>							
						</div>
							<?php echo form_error('first_name'); ?>
							<?php echo form_error('last_name'); ?>
					</div>
					<br class="clear">
					<div class="col-md-6">
						<label for="email">Email<span>*</span>(This email will be registered against the organization and can only be used for management of organization)</label>
						<input value="<?php echo set_value('email',$data['email']);?>" type="text" id="email" name="email" class="form-control search_events" placeholder="" readonly>
						<?php echo form_error('email'); ?>
					</div>					
					<br class="clear">
					<div class="col-md-6">
						<label for="phone">Phone</label>
						<input value="<?php echo set_value('phone',$data['phone']);?>" type="text" id="phone" name="phone" class="form-control search_events" placeholder="Phone">
					</div>
					<br class="clear">
					<div class="col-md-6">
						<label for="fax">Fax</label>
						<input value="<?php echo set_value('fax',$data['fax']);?>" type="text" id="fax" name="fax" class="form-control search_events" placeholder="Fax">
					</div>                        
			</div>
			<div class="row">	
					<div class="col-md-12">
						<h5>Organization Details</h5>
					</div>
					<br class="clear">
					<div class="col-md-6">
						<label for="organization_name">Organization Name<span>*</span></label>
						<input value="<?php echo set_value('organization_name',$data['organization_name']);?>" type="text" id="organization_name" name="organization_name" class="form-control search_events" placeholder="">
						<?php echo form_error('organization_name'); ?>
					</div>
					<br class="clear">
					<div class="col-md-6">
						<label for="ird">IRD Number</label>
						<input type="text" id="ird" name="ird" class="form-control search_events" value="<?php echo set_value('ird',$data['ird_number']);?>" placeholder="IRD Number">
					</div>
					<br class="clear">
					<div class="col-md-6">
						<label for="organization_nature">What is the nature of your Organization ?</label>
						<input value="<?php echo $data['organization_nature'];?>" type="text" id="organization_nature" name="organization_nature" class="form-control search_events" placeholder="Organization Nature">
						<?php echo form_error('organization_nature'); ?>
					</div>
					<br class="clear">
					<div class="col-md-6">
						<label for="donee_status">Are you approved for the donee status under the Income Tax Act 2007 ?</label>
						<select class="search_events form-control dropdown" id="donee_status" name="donee_status">
                                <option value="">-- Please Select --</option>
								<option value="1" <?php if($data['donee_status'] == "1"){ echo "selected";}else{ echo "";}?>>Yes</option>
								<option value="0" <?php if($data['donee_status'] == "0"){ echo "selected";}else{ echo "";}?>>No</option>
                            </select>
					</div>
					<br class="clear">
					<div class="col-md-6">
						<label for="charities_commission">Do you hold a registration with the Charities Commission  ?</label>
						<select class="search_events form-control dropdown" id="charities_commission" name="charities_commission">
                                <option value="">-- Please Select --</option>
			<option value="1" <?php if($data['charities_commission'] == "1"){ echo "selected";}else{ echo "";}?>>Yes</option>
			<option value="0" <?php if($data['charities_commission'] == "0"){ echo "selected";}else{ echo "";}?>>No</option>
                            </select>
					</div>
					<br class="clear">
					<div class="col-md-6">
						<label for="registration_number">If Yes, What is your registration number ? If No,leave this field blank.</label>
						<input type="text" id="registration_number" name="registration_number" class="form-control search_events" placeholder="" value="<?php echo $data['registration_number'];?>">
					</div>
					<br class="clear">
					<div class="col-md-6">
						<label for="charity_name">Preferred Organization Name.<span>*</span></label>
						<input value="<?php echo $data['charity_name'];?>" type="text" id="charity_name" name="charity_name" class="form-control search_events" placeholder="">
						<?php echo form_error('charity_name'); ?>
					</div>
					<br class="clear">
					<div class="col-md-6">
						<label for="charity_overview">Overview</label>
		<textarea class="search_events form-control" id="charity_overview" name="charity_overview"><?php echo $data['charity_overview'];?></textarea>
					</div>
					<br class="clear">
					<div class="col-md-12">
						<label for="email">Choose the couse areas your organization is involved in.</label>
						<div class="row">
							<?php $parts = explode(',', $data['areas']);?>
							<div class="col-md-2 col-sm-3">
								<input type="checkbox" value="1" name="areas[]" <?php if (in_array('1', $parts)){ echo "checked=checked";}?>><label class="chkbox_space">Aged Care</label>
							</div>
							<div class="col-md-2 col-sm-3">
								<input type="checkbox" value="2" name="areas[]" <?php if (in_array('2', $parts)){ echo "checked=checked";}?>><label class="chkbox_space">AIDs</label>
							</div>
							<div class="col-md-2 col-sm-3">
								<input type="checkbox" value="3" name="areas[]" <?php if (in_array('3', $parts)){ echo "checked=checked";}?>><label class="chkbox_space">Babies</label>
							</div>
							<div class="col-md-2 col-sm-3">
								<input type="checkbox" value="4" name="areas[]" <?php if (in_array('4', $parts)){ echo "checked=checked";}?>><label class="chkbox_space">Cancer</label>
							</div>
							<div class="col-md-2 col-sm-3">
								<input type="checkbox" value="5" name="areas[]" <?php if (in_array('5', $parts)){ echo "checked=checked";}?>><label class="chkbox_space">Youth</label>
							</div>
							<div class="col-md-2 col-sm-3">
								<input type="checkbox" value="6" name="areas[]" <?php if (in_array('6', $parts)){ echo "checked=checked";}?>><label class="chkbox_space">Sports</label>
							</div>
							
							<div class="col-md-2 col-sm-3">
								<input type="checkbox" value="8" name="areas[]" <?php if (in_array('8', $parts)){ echo "checked=checked";}?>><label class="chkbox_space">Food Rescue</label>
							</div>
							<div class="col-md-2 col-sm-3">
								<input type="checkbox" value="9" name="areas[]" <?php if (in_array('9', $parts)){ echo "checked=checked";}?>><label class="chkbox_space">Women</label>
							</div>
							<div class="col-md-2 col-sm-3">
								<input type="checkbox" value="10" name="areas[]" <?php if (in_array('10', $parts)){ echo "checked=checked";}?>><label class="chkbox_space">School</label>
							</div>
							<div class="col-md-2 col-sm-3">
								<input type="checkbox" value="11" name="areas[]" <?php if (in_array('11', $parts)){ echo "checked=checked";}?>><label class="chkbox_space">Human Rights</label>
							</div>
							<div class="col-md-2 col-sm-3">
								<input type="checkbox" value="12" name="areas[]" <?php if (in_array('12', $parts)){ echo "checked=checked";}?>><label class="chkbox_space">Protection</label>
							</div>
							
							<div class="col-md-2 col-sm-3">
								<input type="checkbox" value="13" name="areas[]" <?php if (in_array('13', $parts)){ echo "checked=checked";}?>><label class="chkbox_space">Drugs & Alcohol</label>
							</div>
							<div class="col-md-2 col-sm-3">
								<input type="checkbox" value="14" name="areas[]" <?php if (in_array('14', $parts)){ echo "checked=checked";}?>><label class="chkbox_space">Health</label>
							</div>
							<div class="col-md-2 col-sm-3">
								<input type="checkbox" value="15" name="areas[]" <?php if (in_array('15', $parts)){ echo "checked=checked";}?>><label class="chkbox_space">Education</label>
							</div>
							<div class="col-md-2 col-sm-3">
								<input type="checkbox" value="16" name="areas[]" <?php if (in_array('16', $parts)){ echo "checked=checked";}?>><label class="chkbox_space">Animal Welfare</label>
							</div>							
						</div>
					</div>
					<br class="clear">
					<div class="col-md-6">
						<label for="logo" style="margin-bottom:15px;">Logo<span>*</span><b>(Max size 500kb)</b><!--<a style="color:blue !important;" rel="lightbox" href="<?php echo $this->config->item("organisation_logo")."/".$data["logo"]; ?>" data-lightbox="" title="sponsor">View</a>--></label>
						<div class="search_events input-group">
							<label class="input-group-btn">
								<span class="btn btn-primary browse_btn">
								Browse&hellip; <input type="file" id="logo" name="logo" class="browse_txt_box" style="display: none;" placeholder="">
								</span>
							</label>
						<input type="text" id="logo_name" name="logo_name" class="search_events" placeholder="" readonly>
					   </div>
					</div>					
					<br class="clear" id="extra_space_logo">						
					<div class="col-md-6">
						<label id="logo_error" style="display:none;"></label>
		<img id="blah" src="<?php echo $this->config->item("organisation_logo")."/".$data["logo"]; ?>" alt="" style="width:inherit;height:inherit"/>
					</div>
					<br class="clear">	
					<div class="col-md-12">
						<h5>Registered Address</h5>
					</div>
					<br class="clear">
				
					<div class="col-md-6">
						<label for="street_address">Street Address<span>*</span></label>
						<input value="<?php echo set_value('street_address',$data['street_address']);?>" type="text" id="street_address" name="street_address" class="form-control search_events" placeholder="">
					</div>
					<br class="clear">
					<div class="col-md-6">
						<div class="row">							
							<div class="col-md-6">
								<label for="region">Suburb<span>*</span></label>
								<input value="<?php echo set_value('region',$data['region']);?>" type="text" id="region" name="region" class="form-control search_events" placeholder="Region">
							</div>
							<div class="col-md-6">
								<label for="email">City<span>*</span></label>
								<input value="<?php echo set_value('city',$data['city']);?>" type="text" id="city" name="city" class="form-control search_events" placeholder="City">
							</div>
						</div>
					</div>
					<br class="clear">
					<br class="clear">
					<div class="col-md-6">
						<div class="row">
							<div class="col-md-6">
								<label for="postal_code">Postal Code<span>*</span></label>
								<input value="<?php echo set_value('postal_code',$data['postal_code']);?>" type="text" id="postal_code" name="postal_code" class="form-control search_events" placeholder="Postal Code">
							</div>
							<div class="col-md-6">
								<label for="country">Country<span>*</span></label>
								<select class="search_events form-control dropdown" id="country" name="country">
									<option value="">-- Please Select --</option>
									<option value="NewZealand" selected>New Zealand</option>
									<option value="Australia">Australia</option>
								</select>
								<!--
								<input value="<?php echo set_value('country',$data['country']);?>" type="text" id="country" name="country" class="search_events" placeholder="country">
								-->
							</div>
						</div>
					</div>
					
					<br class="clear">
					<div class="col-md-12">
						<h5>Financial Contact</h5>
					</div>
					<br class="clear">
					<div class="col-md-6">
						<label for="finance_position">Finance Officer Position<span>*</span></label>
						<input type="text" value="<?php echo set_value('finance_position',$data['finance_position']);?>" id="finance_position" name="finance_position" class="form-control search_events" placeholder="">
					</div>
					<br class="clear">
					<div class="col-md-6">
						<div class="row">
							<div class="col-md-6">
								<label for="finance_first_name">First Name<span>*</span></label>
								<input type="text" id="finance_first_name" name="finance_first_name" class="form-control search_events" placeholder="" value="<?php echo set_value('finance_first_name',$data['finance_first_name']);?>">
							</div>
							<div class="col-md-6">
								<label for="finance_last_name">Last Name<span>*</span></label>
								<input type="text" id="finance_last_name" name="finance_last_name" class="form-control search_events" placeholder="" value="<?php echo set_value('finance_last_name',$data['finance_last_name']);?>">
							</div>
						</div>
					</div>
					<br class="clear">
					<div class="col-md-6">
						<label for="finance_email">Email<span>*</span></label>
						<input type="text" id="finance_email" name="finance_email" class="form-control search_events" placeholder="" value="<?php echo set_value('finance_email',$data['finance_email']);?>">
					</div>
					<br class="clear">
					<div class="col-md-6">
						<label for="finance_phone">Phone</label>
						<input type="text" id="finance_phone" name="finance_phone" class="form-control search_events" placeholder="Phone" value="<?php echo set_value('finance_phone',$data['finance_phone']);?>">
					</div>
					<br class="clear">
					<div class="col-md-6">
						<label for="finance_fax">Fax</label>
						<input value="<?php echo set_value('finance_fax',$data['finance_fax']);?>" type="text" id="finance_fax" name="finance_fax" class="form-control search_events" placeholder="Fax">
					</div>
					
				   
					<br class="clear">
					<div class="col-md-12">
					<h5>Bank Details</h5>         
					</div>
					<br class="clear">
					<div class="col-md-6">
						<label for="bank_name">Bank Name<span>*</span></label>
						<input type="text" id="bank_name" name="bank_name" class="form-control search_events" placeholder="Bank Name" value="<?php echo set_value('bank_name',$data['bank_name']);?>">
					</div>
					<br class="clear">
					<div class="col-md-6">
						<label for="bank_details">Banking Account Number<span>*</span></label>
						<input type="text" id="bank_details" name="bank_details" class="form-control search_events" placeholder="" value="<?php echo set_value('bank_details',$data['bank_details']);?>">
					</div>
					
					<br class="clear">
					<div class="col-md-12">
						<h5>Receipt Details</h5>          
					</div>
					<br class="clear">
					<div class="col-md-6">
						<label for="receipt_text">Receipt Text</label>
						<textarea class="search_events form-control" id="receipt_text" name="receipt_text"><?php echo $data['receipt_text'];?></textarea>
					</div>
					<br class="clear">
					<div class="col-md-6">

						<label for="bank_signature">Attach your Electronic Signature<span>*</span>(This is the signature that would appear on the receipt sent by the system.)<!--<a style="color:blue !important;" rel="lightbox" href="<?php echo $this->config->item("organisation_signature")."/".$data["signature"]; ?>" data-lightbox="" title="sponsor">View</a>--></label>

						<div class="search_events input-group">

							<label class="input-group-btn">

								<span class="btn btn-primary browse_btn" data-toggle="popover" data-content=" If you are approved for Donee status under the Income Tax Act 2007, please upload a JPG or GIF formatted electronic signature for an officer authorised to accept donations, to be signatory on receipts.">

								Browse&hellip; <input type="file" id="bank_signature" name="bank_signature" class="browse_txt_box" style="display: none;" placeholder="">

								</span>
							</label>
						<input type="text" id="sing_name" name="sing_name" class="search_events" placeholder="" readonly>

					   </div>
					</div>
					<br class="clear" id="space_logo">
						<div class="col-md-6">
							<img id="bank_signature_preview" src="<?php echo $this->config->item("organisation_signature")."/".$data["signature"]; ?>" alt="" height="200px;"/>
						</div>

					<br class="clear">

					<!--
					<div class="col-md-6">

						<label for="email">Attach your Bank Statement<span>*</span><a style="color:blue !important;" target="_blank" href="<?php echo $this->config->item("organisation_statement")."/".$data["bank_statement"]; ?>">View</a></label>
						<div class="search_events input-group">
							<label class="input-group-btn">
								<span class="btn btn-primary browse_btn" data-toggle="popover" data-content="To verify your bank account, attach a copy of your donation bank account details on the bank statement. Confidential and financial information can be covered up.">
								Browse&hellip; <input type="file" id="bank_statement" name="bank_statement" class="browse_txt_box" style="display: none;" placeholder="">
								</span>
							</label>
						<input type="text" id="ste" name="ste" class="" placeholder="" readonly>
					   </div>
					</div>
					<br class="clear">
						<div class="col-md-6 col-sm-6 col-xs-12">							
							<label id="attach_statement" style="display:none;">bank statement successfully attached</label>
						</div>
					-->	<br class="clear">
					
					<div class="col-md-1 col-sm-2 col-xs-6">
					<button class="search_events submit_btn" type="submit">Update</button>
					</div>
					<div class="col-md-2 col-sm-2 col-xs-6">
					<button class="submit_btn" onclick="window.history.back();" type="button" style="margin-left:40px;"> Cancel</button>
					</div>
					<input type="hidden" value="<?php echo $data['id'];?>" name="organiser_id" id="organiser_id">			
					<input type="hidden" value="<?php echo $data['logo'];?>" name="old_logo" id="old_logo">
					<input type="hidden" value="<?php echo $data['signature'];?>" name="old_signature" id="old_signature">
					<input type="hidden" value="<?php echo $data['bank_statement'];?>" name="old_bank_statement" id="old_bank_statement">					
			</div>
			</form>
		</div>
	</div>
</div>
<style>
	.error{
        color:red;
    }
</style>
<script src="<?php echo $this->config->item('frontend_js_path');?>jquery.validate.min.js"></script> 
<script>
	(function($,W,D){
    var user_validation = {}; 
    user_validation.UTIL =
    {
        setupFormValidation: function()
        {
            //form validation rules
            $("#organiser_edit_form").validate({
                rules: {                   
                   	title: {
                        required: true,
                    },
					salutation: {
                        required: true,
                    },
					fax: {
                        number: true,
                    },
					finance_fax: {
                        number: true,
                    },
					first_name: {
                        required: true,					
                    },
					last_name: {
                        required: true,
                    },
					organization_name: {
                        required: true,					
                    },
					phone:{
						number: true,
					},
					finance_phone:{
						number: true,
					},
					charity_name: {
                        required: true,
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
					region: {
						required: true,                        
                    },
					postal_code: {
                        required: true,
						number:true,						
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
					phone: {                   
						minlength: jQuery.validator.format("phone should be 10 digit length."),
						maxlength: jQuery.validator.format("phone should be 10 digit length.")
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

</script>