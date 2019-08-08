<script src="<?php echo $this->config->item('admin_js_path');?>lightbox.js"></script>
<link href="<?php echo $this->config->item('admin_css_path');?>lightbox.css" rel="stylesheet" type="text/css">
<script>
	function closeAlertPopUp(){
		$(".lightbox, .lightbox-panel").remove();
	}
</script>
<style>
	.terms_check{color:#337ab7 !important;}
	.error{ color:red;font-weight: inherit;}
	.no_margin{margin-top:0px !important;}
</style>
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="right_first_box"><img src="<?php echo $this->config->item('admin_image_path');?>home.png"><a href="<?php echo $this->config->item('login_url');?>">Home</a> > <a href="<?php echo $this->config->item('admin_organiser');?>">Manage Organization Submission</a> > <a href="#">Set Up Organization</a></div>
                    </div>
                </div>
                <div class="row">
                   <div class="col-md-12 col-sm-12 col-xs-12"><h4 class="blue_top  heading">Set Up Organization</h4></div>
				</div>

				<div class="table_white_box" style="padding:25px;">
					<form enctype="multipart/form-data" method="POST" action="<?php echo $this->config->item('save_set_organizations');?>" name="organiser_admin_form" id="organiser_admin_form">
                    <div class="col-md-12 col-sm-12 col-xs-12"><h4 class=" blue_top heading no_margin">Primary Contact (Event Manager)</h4></div>
				   <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                         <label for="title">Position Title<span class="red_star">*</span></label>
                         <input type="text" class="form-control" id="title" name="title" value="" placeholder="Position Title">
                        </div>
						<?php echo form_error('title'); ?>
                    </div>
                    <br class="clear">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                         <label for="salutation">Salutation<span class="red_star">*</span></label>
                         <select class="search_events form-control dropdown" id="salutation" name="salutation">
                    <option value="">-- Please Select --</option>
                    <option value="Mr">Mr</option>
                    <option value="Mrs">Mrs</option>
                    <option value="Ms">Ms</option>
                </select>
                        </div>
						<?php echo form_error('salutation'); ?>
                    </div>
                    <br class="clear">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                         <div class="form-group">
                         <label for="first_name">Name<span class="red_star">*</span></label>
                         <div class="row">
                             <div class="col-md-6 col-sm-6 col-xs-6">
                                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" value="">
                             </div>
                             <div class="col-md-6 col-sm-6 col-xs-6">
                                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" value="">
                             </div>
                         </div>
						 <?php echo form_error('first_name'); ?>
						 <?php echo form_error('last_name'); ?>
                         </div>
                    </div>
					<br class="clear">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                    	<div class="form-group">
                         <label for="preferred_name">Preferred Name</label>
                         <input type="text" placeholder="Preferred Name" class="form-control" id="preferred_name" name="preferred_name" value="">
                        </div>
                    </div>
                    <br class="clear">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                    	<div class="form-group">
                         <label for="email">Email<span class="red_star">*</span></label>
                         <input type="text" class="form-control" id="email" name="email" value="" placeholder="Email">
                        </div>
						<?php echo form_error('email'); ?>
                    </div>
                    <br class="clear">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                    	<div class="form-group">
                         <label for="phone">Contact Number</label>
							<input type="text" class="form-control" id="phone" name="phone" value="" placeholder="Contact Number">
                        </div>
                    </div>
                    <br class="clear">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                    	<div class="form-group">
                         <label for="fax">Fax</label>
                         <input type="text" class="form-control" id="fax" name="fax" value="" placeholder="Fax">
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12"><h4 class="blue_top  heading">ORGANISATION DETAILS</h4></div>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                    	<div class="form-group">
                         <label for="organisation_name">Organization Name<span class="red_star">*</span></label>
                         <input placeholder="Organisation Name" type="text" class="form-control" id="organisation_name" name="organisation_name" value="">
                        </div>
						<?php echo form_error('organisation_name'); ?>
                    </div>
                    <br class="clear">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                    	<div class="form-group">
                         <label for="ird">IRD Number</label>
                         <input type="text" class="form-control" id="ird" name="ird" value="" placeholder="IRD Number">
                        </div>
                    </div>
                    <br class="clear">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                    	<div class="form-group">
                         <label for="organization_nature">Organization Type<span class="red_star">*</span></label>
							<select class="search_events form-control" name="organization_nature" id="organization_nature">
								<option value="">--Select--</option>
								<?php foreach($organisation_type_list as $org_type){ ?>
								<option value="<?php echo $org_type['key_name']; ?>"><?php echo $org_type['name']; ?></option>
							   <?php } ?>
							</select>
						</div>
                    </div>
                    <br class="clear">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                    	<div class="form-group">
                         <label for="donee_status">Are you approved for the donee status under the Income Tax Act 2007 ?</label>
                          <select class="search_events form-control dropdown" id="donee_status" name="donee_status">
                                <option value="">-- Please Select --</option>
								<option value="1">Yes</option>
								<option value="0">No</option>
                            </select>
                        </div>
                    </div>
                    <br class="clear">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                    	<div class="form-group">
                         <label for="charities_commission">Do you hold a registration with the Charities Commission ?</label>
                          <select class="search_events form-control dropdown" id="charities_commission" name="charities_commission">
                                <option value="">-- Please Select --</option>
			<option value="1">Yes</option>
			<option value="0">No</option>
                            </select>
                        </div>
                    </div>
                    <br class="clear">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                    	<div class="form-group">
                         <label for="registration_number">If Yes, What is your registration number ? If No,leave this field blank.</label>
                         <input placeholder="Registration Number" type="text" class="form-control" id="registration_number" name="registration_number" value="">
                        </div>
                    </div>
                    <br class="clear">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                    	<div class="form-group">
                         <label for="charity_name">Preferred Organization name.</label><span class="red_star">*</span>
                         <input placeholder="Preferred Organization Name" type="text" class="form-control" id="charity_name" name="charity_name" value="">
                        </div>
						<?php echo form_error('charity_name'); ?>
                    </div>
                    <br class="clear">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                    	<div class="form-group">
                         <label for="charity_overview">Overview</label>
                         <textarea placeholder="Overview" class="form-control" id="charity_overview" name="charity_overview"></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                            <label for="">Choose up the three couse areas your organization is involved in.</label>
                            <div class="row">
                                <div class="col-md-3 col-sm-3">
								<?php
									if(isset($data['areas'])){
										$parts = explode(',', $data['areas']);
									}else{
										$parts = array();
									}
								?>
    <input type="checkbox" value="1" name="areas[]" <?php if (in_array('1', $parts)){ echo "checked=checked";}?> id="1_area"><label class="chkbox_space" for="1_area">Aged Care</label>
                                </div>
                                <div class="col-md-3 col-sm-3">
                                    <input type="checkbox" value="2" name="areas[]" <?php if (in_array('2', $parts)){ echo "checked=checked";}?> id="2_area"><label for="2_area" class="chkbox_space">HIV and AIDS</label>
                                </div>
                                <div class="col-md-3 col-sm-3">
                                    <input type="checkbox" value="3" name="areas[]" <?php if (in_array('3', $parts)){ echo "checked=checked";}?> id="3_area" ><label for="3_area" class="chkbox_space">Prenatal and infants</label>
                                </div>
                                <div class="col-md-3 col-sm-3">
                                    <input type="checkbox" value="4" name="areas[]" <?php if (in_array('4', $parts)){ echo "checked=checked";}?> id="4_area"><label for="4_area" class="chkbox_space">Cancer</label>
                                </div>
                                <div class="col-md-3 col-sm-3">
                                    <input type="checkbox" value="5" name="areas[]" <?php if (in_array('5', $parts)){ echo "checked=checked";}?> id="5_area"><label for="5_area" class="chkbox_space">Youth</label>
                                </div>
                                <div class="col-md-3 col-sm-3">
                                    <input type="checkbox" value="6" name="areas[]" <?php if (in_array('6', $parts)){ echo "checked=checked";}?> id="6_area"><label for="6_area" class="chkbox_space">Sports</label>
                                </div>

                                <div class="col-md-3 col-sm-3">
                                    <input type="checkbox" value="7" name="areas[]" <?php if (in_array('7', $parts)){ echo "checked=checked";}?> id="7_area"><label for="7_area" class="chkbox_space">Education</label>
                                </div>
                                <div class="col-md-3 col-sm-3">
                                    <input type="checkbox" value="8" name="areas[]" <?php if (in_array('8', $parts)){ echo "checked=checked";}?> id="8_area"><label for="8_area" class="chkbox_space">Religion</label>
                                </div>
                                <div class="col-md-3 col-sm-3">
                                    <input type="checkbox" value="9" name="areas[]" <?php if (in_array('9', $parts)){ echo "checked=checked";}?> id="9_area"><label for="9_area" class="chkbox_space">School</label>
                                </div>
                                <div class="col-md-3 col-sm-3">
                                    <input type="checkbox" value="10" name="areas[]" <?php if (in_array('10', $parts)){ echo "checked=checked";}?> id="10_area"><label for="10_area" class="chkbox_space">Human Rights</label>
                                </div>
                                <div class="col-md-3 col-sm-3">
                                    <input type="checkbox" value="11" name="areas[]" <?php if (in_array('11', $parts)){ echo "checked=checked";}?> id="11_area"><label for="11_area" class="chkbox_space">Protection</label>
                                </div>

                                <div class="col-md-3 col-sm-3">
                                    <input type="checkbox" value="12" name="areas[]" <?php if (in_array('12', $parts)){ echo "checked=checked";}?> id="12_area"><label for="12_area" class="chkbox_space">Drugs & Alcohol </label>
                                </div>
                                <div class="col-md-3 col-sm-3">
                                    <input type="checkbox" value="13" name="areas[]" <?php if (in_array('13', $parts)){ echo "checked=checked";}?> id="13_area"><label for="13_area" class="chkbox_space">Health</label>
                                </div>
								<div class="col-md-3 col-sm-3">
                                    <input type="checkbox" value="14" name="areas[]" <?php if (in_array('14', $parts)){ echo "checked=checked";}?> id="14_area"><label for="14_area" class="chkbox_space">Animal Welfare</label>
                                </div>
								<div class="col-md-3 col-sm-3">
                                    <input type="checkbox" value="15" name="areas[]" <?php if (in_array('15', $parts)){ echo "checked=checked";}?> id="15_area"><label for="15_area" class="chkbox_space">Other</label>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                           <div class="form-group">
                               <label for="upload">Logo <b>(Max size 500kb)</b></label>
                               <div class="input-group">
                					<label class="input-group-btn">
                   					 	<span class="btn btn-primary">
                        			  	Browse&hellip; <input type="file" style="display: none;" id="logo" name="logo">
                    				 	</span>
                					</label>
                				<input type="text" class="form-control" readonly>
            				   </div>
                           </div>
                        </div>
						<br class="clear" id="extra_space_logo">
						<div class="col-md-6 col-sm-6 col-xs-12">
							<label id="logo_error"></label>
							<img id="blah" height="100px" width="100px" src="" alt="" style="display:none"/>
						</div>
						<br class="clear">
                        <div class="col-md-12 col-sm-12 col-xs-12"><h4 class="blue_top heading">REGISTERED ADDRESS</h4></div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                             <label for="street_address">Street Address</label>
                             <input placeholder="Street Address" type="text" class="form-control" id="street_address" name="street_address" value="">
                            </div>
                        </div>
                        <br class="clear">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                             <div class="form-group">
                             <div class="row">
                                 <div class="col-md-6 col-sm-6 col-xs-6">
                                 	<label for="region">Suburb</label>
                                    <input placeholder="Suburb" type="text" class="form-control" id="region" name="region" value="">
                                 </div>
								 <div class="col-md-6 col-sm-6 col-xs-6">
                                 	<label for="city">City</label>
                                    <input type="text" class="form-control" id="city" placeholder="City" id="city" name="city" value="">
                                 </div>
                             </div>
                             </div>
                        </div>
                        <br class="clear">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                             <div class="form-group">
                             <div class="row">
                                 <div class="col-md-6 col-sm-6 col-xs-6">
                                 	<label for="postal_code">Postal Code</label>
                                    <input type="text" class="form-control" id="postal_code" name="postal_code" placeholder="Postal Code" value="">
                                 </div>
                                 <div class="col-md-6 col-sm-6 col-xs-6">
                                 	<label for="country">Country</label>
                                   <!-- <input type="text" class="form-control" id="country" name="country" placeholder="Country" value="<?php //echo $data['country'];?>">-->

								    <select class="search_events form-control dropdown" id="country" name="country">
										<option value="">-- Please Select --</option>
										<option value="NewZealand">New Zealand</option>
										<option value="Australia">Australia</option>
									</select>
                                 </div>
                             </div>
                             </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12"><h4 class=" blue_top heading">FINANCIAL CONTACT</h4></div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                             <label for="finance_position">Finance Officer Position</label>
 <input type="text" class="form-control" id="finance_position" name="finance_position" value="" placeholder="Finance Position">
                            </div>
                        </div>
                        <br class="clear">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                             <div class="form-group">
                             <div class="row">
                                 <div class="col-md-6 col-sm-6 col-xs-6">
                                 	<label for="finance_first_name">First Name</label>
                                    <input type="text" class="form-control" id="finance_first_name" name="finance_first_name" placeholder="First Name" value="">
                                 </div>
                                 <div class="col-md-6 col-sm-6 col-xs-6">
                                 	<label for="finance_last_name">Last Name</label>
                                    <input type="text" class="form-control" id="finance_last_name" name="finance_last_name" placeholder="Last Name" value="">
                                 </div>
                             </div>
                             </div>
                        </div>
                        <br class="clear">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                             <label for="finance_email">Email</label>
                             <input type="text" class="form-control" id="finance_email" name="finance_email" placeholder="Email" value="" >
                            </div>
                        </div>
                        <br class="clear">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                             <label for="finance_phone">Contact Number</label>
                             <input type="text" class="form-control" id="finance_phone" name="Phone" placeholder="Contact Number" value="">
                            </div>
                        </div>
                        <br class="clear">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                             <label for="finance_fax">Fax</label>
                             <input type="text" class="form-control" id="finance_fax" name="Fax" placeholder="Fax" value="">
                            </div>
                        </div>


						  <div class="col-md-12 col-sm-12 col-xs-12"><h4 class=" blue_top heading">BANK DETAILS (for the settlement of fund received)</h4></div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                             <label for="bank_name">Bank Name</label>
                             <input type="text" class="form-control" id="bank_name" name="bank_name" value="" placeholder="Bank Name">
                            </div>
                        </div>
                        <br class="clear">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                             <label for="bank_details">Bank Account Number</label>
                             <input type="text" class="form-control" id="bank_details" name="bank_details" value="" placeholder="Account Number">
                            </div>
                        </div>
						<br class="clear">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                           <div class="form-group">
                               	<label for="upload">Attach Your Bank Statement</label>
                               <div class="input-group">
                					<label class="input-group-btn">
                   					 	<span class="btn btn-primary">
                        			  	Browse&hellip; <input type="file" style="display: none;" id="bank_statement" name="bank_statement">
                    				 	</span>
                					</label>
                				<input type="text" class="form-control" readonly id="bank_va" name="bank_va">
            				   </div>
                           </div>
                        </div>

						<br class="clear">
						<div class="col-md-6 col-sm-6 col-xs-12">
							<label id="attach_statement" style="display:none;">Bank statement successfully attached</label>
						</div>
						<br class="clear">

						  <div class="col-md-12 col-sm-12 col-xs-12"><h4 class=" blue_top heading">BANK DETAILS (for payment to TicketingSystem & POLi)</h4></div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                             <label for="bank_name">Bank Name</label>
                             <input type="text" class="form-control" name="bank_name_for_ts" id="bank_name_for_ts" value="" placeholder="Bank Name">
                            </div>
                        </div>
                        <br class="clear">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                             <label for="bank_details">Bank Account Number</label>
                             <input placeholder="Account Number" type="text" class="form-control" name="bank_account_no_for_ts" id="bank_account_no_for_ts" value="">
                            </div>
                        </div>
						<br class="clear">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                           <div class="form-group">
                               	<label for="upload">Attach Your Bank Statement</label>
                               <div class="input-group">
                					<label class="input-group-btn">
                   					 	<span class="btn btn-primary">
                        			  	Browse&hellip; <input type="file" style="display: none;" id="bank_attachment_for_ts" name="bank_attachment_for_ts">
                    				 	</span>
                					</label>
                				<input type="text" class="form-control" readonly id="bank_va_ts" name="bank_va_ts">
            				   </div>
                           </div>
                        </div>
						<br class="clear">
						<div class="col-md-6 col-sm-6 col-xs-12">
							<label id="attach_statement2" style="display:none;">Bank statement successfully attached</label>
						</div>

						<br class="clear">
						<div class="col-md-12 col-sm-12 col-xs-12"><h4 class=" blue_top heading">RECEIPT DETAILS</h4></div>
						<br class="clear">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                             <label for="receipt_text">Receipt Text</label>
                             <textarea placeholder="Receipt Text" class="form-control" name="receipt_text" id="receipt_text"></textarea>
                            </div>
                        </div>
						<br class="clear">
						 <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                             <label for="sig_text">Signature Text</label>
                             <textarea placeholder="Signature Text" class="form-control" name="sig_text" id="sig_text"></textarea>
                            </div>
                        </div>
						<br class="clear">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                           <div class="form-group">
                               <label for="upload">Attach Your Electronic Signature</label>
                               <div class="input-group">
                					<label class="input-group-btn">
                   					 	<span class="btn btn-primary">
                        			  	Browse&hellip; <input type="file" style="display: none;" id="signature" name="signature">
                    				 	</span>
                					</label>
                				<input type="text" class="form-control" readonly>
            				   </div>
                           </div>
                        </div>
						<br class="clear">
						<div class="col-md-6 col-sm-6 col-xs-12">
							<img id="blah2" src="" alt="" style="height:100px; display:none"/>
						</div>
						<br class="clear">
						<div class="col-md-6 col-sm-12 col-xs-12">
							<div class="form-group">
							  <label for="plan_select">The 12 month plan I am seeking is:</label>
								<select class="search_events form-control dropdown" id="plan_select" name="plan_select" >
									<option value="">-- Please Select --</option>
									<option value="1" <?php if($data['plan_select'] == "1"){ echo "selected";}else{ echo "";}?>>Standard Suite Plan – 1.5% fee per transaction</option>
									<option value="2" <?php if($data['plan_select'] == "2"){ echo "selected";}else{ echo "";}?>>Deluxe Suite Plan – 4% fee per transaction</option>
								</select>
							</div>
						</div>

				</div><!--row end-->
				<br class="clear"><br>
                <div class="row buttons">
                    <div class="col-md-12">
						<button class="btn btn-primary save_btn" type="submit">Submit</button>
						<a href="" onclick="window.history.back();" class="btn btn-primary save_btn">Cancel</a>
						<input type="hidden" class="form-control" id="organiser_id" name="organiser_id" value="">

                    </div>
             	</div></form>
				<br class="clear"><br>
          </div>
      </div>
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
<script>
	<?php $email_url = $this->config->item('base_url')."index.php/frontend/registration/email_unique_check";?>
<?php $charity_check_url = $this->config->item('base_url')."index.php/frontend/registration/charity_name_unique_check";?>
	(function($,W,D){
    var user_validation = {};
    user_validation.UTIL =
    {
        setupFormValidation: function()
        {
            //form validation rules
            $("#organiser_admin_form").validate({
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
					organization_nature:{
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

		var fullPath = document.getElementById('bank_statement').value;
		if (fullPath) {
			var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
			var filename = fullPath.substring(startIndex);
			if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
				filename = filename.substring(1);
			}
			document.getElementById('bank_va').value = filename;
		}

		document.getElementById('attach_statement').style.color = 'green';
		document.getElementById('attach_statement').style.display = 'block';
	});

    $("#bank_attachment_for_ts").change(function(){

        var fullPath = document.getElementById('bank_attachment_for_ts').value;
        if (fullPath) {
            var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
            var filename = fullPath.substring(startIndex);
            if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
                filename = filename.substring(1);
            }
            document.getElementById('bank_va_ts').value = filename;
        }

        document.getElementById('attach_statement2').style.color = 'green';
        document.getElementById('attach_statement2').style.display = 'block';
    });

	$("#logo").change(function(){
		var files = document.getElementById('logo').files;
		if (!files[0].name.match(/\.(jpg|jpeg|png|gif)$/)){
			document.getElementById('extra_space_logo').style.display = 'block';
			document.getElementById('logo_error').style.display = 'block';
			document.getElementById('logo_error').style.color = 'red';
			document.getElementById('logo_error').innerHTML = 'please upload valid image file';
			$('#blah').attr('src', '');
			return false;
		}

		if(files[0].size > 500000){
			document.getElementById('extra_space_logo').style.display = 'block';
			document.getElementById('logo_error').style.display = 'block';
			document.getElementById('logo_error').style.color = 'red';
			document.getElementById('logo_error').innerHTML = 'logo image size should be less then 500kb';
			$('#blah').attr('src', '');
			return false;
		}else{
			readURL(this);
			document.getElementById('logo_error').style.display = 'none';
			document.getElementById('blah').style.display = 'block';
		}
	});

	function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$('#blah').attr('src', e.target.result);
			}
			reader.readAsDataURL(input.files[0]);
		}
	}

	$("#signature").change(function(){
		read_signature_URL(this);
		document.getElementById('blah2').style.display = 'block';
	});

	function read_signature_URL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$('#blah2').attr('src', e.target.result);
			}
			reader.readAsDataURL(input.files[0]);
		}
	}

</script>
<style>
	.ten_pix{width:10%;}
	.twny_pix{width:25%;}
	.middle_align{text-align:center;}
	.payment_info th{padding:8px;text-align:center;border:1px solid #e3e3e3;}
	.payment_info td{padding:8px;text-align:center;border:1px solid #e3e3e3;}
</style>