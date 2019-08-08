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
<style>
.error{color:red;}
.no_margin{margin-top:0px !important;}
</style>
<script src="<?php echo $this->config->item('admin_js_path');?>lightbox.js"></script>
<script src="<?php echo $this->config->item('admin_js_path');?>jquery.copy-to-clipboard.js"></script>
<link href="<?php echo $this->config->item('admin_css_path');?>lightbox.css" rel="stylesheet" type="text/css">
<script>
	function closeAlertPopUp(){
		$(".lightbox, .lightbox-panel").remove();
	}
</script>
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="right_first_box"><img src="<?php echo $this->config->item('admin_image_path');?>home.png"><a href="<?php echo $this->config->item('login_url');?>">Home</a> > <a href="<?php echo $this->config->item('admin_organiser');?>"> Manage Organization Submission</a> > <a href="#">Edit Organization</a></div>
                    </div>
                </div>
                <div class="row">
                   <div class="col-md-12 col-sm-12 col-xs-12"><h4 class="blue_top  heading">Edit Organization Submission</h4></div>
				</div>
				<?php
				//echo "hello world";
					//echo "<pre>";
					//print_r($data);
					//echo "</pre>";
				?>
				<div class="table_white_box" style="padding:25px;">
					<form enctype="multipart/form-data" method="POST" action="<?php echo $this->config->item('save_admin_organiser_submission');?>" name="organiser_admin_form" id="organiser_admin_form">
					 <div class="col-md-12 col-sm-12 col-xs-12"><h4 class=" blue_top heading no_margin">Primary Contact (Event Manager)</h4></div>
					<div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                         <label for="title">Position Title<span class="red_star">*</span></label>
                         <input type="text" placeholder="Title" class="form-control" id="title" name="title" value="<?php echo $data['title'];?>">
                        </div>
                    </div>
                    <br class="clear">

					<div class="col-md-6 col-sm-12 col-xs-12">
                    	<div class="form-group">
                          <label for="salutation">Salutation<span class="red_star">*</span></label>
                          <select class="search_events form-control dropdown" id="salutation" name="salutation" >
                             <option value="">-- Please Select --</option>
                    <option value="Mr" <?php if($data['salutation'] == "Mr"){ echo "selected";}else{ echo "";}?>>Mr</option>
                    <option value="Mrs" <?php if($data['salutation'] == "Mrs"){ echo "selected";}else{ echo "";}?>>Mrs</option>
                    <option value="Ms" <?php if($data['salutation'] == "Ms"){ echo "selected";}else{ echo "";}?>>Ms</option>
                            </select>
                        </div>
                    </div>
                    <!--<div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                         <label for="email">Salutation<span class="red_star">*</span></label>
                         <input type="text" class="form-control" id="salutation" name="salutation" value="<?php echo $data['salutation'];?>">
                        </div>
                    </div>-->

                    <br class="clear">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                         <div class="form-group">
                         <label for="first_name">Name<span class="red_star">*</span></label>
                         <div class="row">
                             <div class="col-md-6 col-sm-6 col-xs-6">
                                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" value="<?php echo $data['first_name'];?>">
                             </div>
                             <div class="col-md-6 col-sm-6 col-xs-6">
                                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" value="<?php echo $data['last_name'];?>">
                             </div>
                         </div>
                         </div>
                    </div>
					<br class="clear">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                    	<div class="form-group">
                         <label for="preferred_name">Preferred Name</label>
                         <input type="text" class="form-control" id="preferred_name" name="preferred_name" value="<?php echo $data['preferred_name'];?>">
                        </div>
                    </div>
                    <br class="clear">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                    	<div class="form-group">
                         <label for="email">Email<span class="red_star">*</span></label>
                         <input type="text" class="form-control" id="email" name="email" value="<?php echo $data['email'];?>" readonly>
                        </div>
                    </div>
                    <br class="clear">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                    	<div class="form-group">
                         <label for="phone">Contact Number</label>
<input type="text" class="form-control" placeholder="Contact Number" id="phone" name="phone" value="<?php if($data['phone'] == 0){ echo "";}else{ echo $data['phone'];}?>">
                        </div>
                    </div>
                    <br class="clear">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                    	<div class="form-group">
                         <label for="fax">Fax</label>
                         <input type="text" class="form-control" id="fax" name="fax" value="<?php if($data['fax'] == 0){ echo "";}else{ echo $data['fax'];}?>">
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12"><h4 class="blue_top  heading">ORGANIZATION DETAILS</h4></div>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                    	<div class="form-group">
                         <label for="organisation_name">Organization Name<span class="red_star">*</span></label>
                         <input placeholder="Organization Name" type="text" class="form-control" id="organisation_name" name="organisation_name" value="<?php echo $data['organization_name'];?>">
                        </div>
                    </div>
                    <br class="clear">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                    	<div class="form-group">
                         <label for="ird">IRD Number</label>
                         <input placeholder="IRD" type="text" class="form-control" id="ird" name="ird" value="<?php echo $data['ird_number'];?>">
                        </div>
                    </div>
                    <br class="clear">


                    <div class="col-md-6 col-sm-12 col-xs-12">
                    	<div class="form-group">

                        <label for="organization_nature">Organization Type<span class="red_star"></span></label>
                          <select class="search_events form-control dropdown" id="organization_nature" name="organization_nature">
                               <option value="">-- Please Select --</option>
                   <?php foreach($get_organisation_type as $org_type){ ?>
                <option value="<?php echo $org_type['key_name']; ?>" <?php if($data['organization_nature']==$org_type['key_name']){echo "selected";}else{"";}?>><?php echo $org_type['name']; ?></option>
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
								<option value="1" <?php if($data['donee_status'] == "1"){ echo "selected";}else{ echo "";}?>>Yes</option>
								<option value="0" <?php if($data['donee_status'] == "0"){ echo "selected";}else{ echo "";}?>>No</option>
                            </select>
                        </div>
                    </div>
                    <br class="clear">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                    	<div class="form-group">
                         <label for="charities_commission">Do you hold a registration with the Charities Commission ?</label>
                          <select class="search_events form-control dropdown" id="charities_commission" name="charities_commission">
                                <option value="">-- Please Select --</option>
			<option value="1" <?php if($data['charities_commission'] == "1"){ echo "selected";}else{ echo "";}?>>Yes</option>
			<option value="0" <?php if($data['charities_commission'] == "0"){ echo "selected";}else{ echo "";}?>>No</option>
                            </select>
                        </div>
                    </div>
                    <br class="clear">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                    	<div class="form-group">
                         <label for="registration_number">If Yes, What is your registration number ? If No,leave this field blank.</label>
                         <input placeholder="Registration Number" type="text" class="form-control" id="registration_number" name="registration_number" value="<?php echo $data['registration_number'];?>">
                        </div>
                    </div>
                    <br class="clear">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                    	<div class="form-group">
                         <label for="charity_name">Preferred Organization name.<span class="red_star"></span></label>
                         <input type="text" placeholder="Preffered Organization Name" class="form-control" id="charity_name" name="charity_name" value="<?php echo $data['charity_name'];?>">
                        </div>
                    </div>
                    <br class="clear">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                    	<div class="form-group">
                         <label for="charity_overview">Overview</label>
                         <textarea placeholder="Overview" class="form-control" id="charity_overview" name="charity_overview"><?php echo $data['charity_overview'];?></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                            <label for="email">Choose up the three couse areas your organization is involved in.</label>
                            <div class="row">
                                <div class="col-md-3 col-sm-3">
								<?php $parts = explode(',', $data['areas']);?>
									<input type="checkbox" value="1" name="areas[]" <?php if (in_array('1', $parts)){ echo "checked=checked";}?>><label class="chkbox_space">Aged Care</label>
                                </div>
                                <div class="col-md-3 col-sm-3">
                                    <input type="checkbox" value="2" name="areas[]" <?php if (in_array('2', $parts)){ echo "checked=checked";}?>><label class="chkbox_space">HIV and AIDS</label>
                                </div>
                                <div class="col-md-3 col-sm-3">
                                    <input type="checkbox" value="3" name="areas[]" <?php if (in_array('3', $parts)){ echo "checked=checked";}?>><label class="chkbox_space">Prenatal and infants</label>
                                </div>
                                <div class="col-md-3 col-sm-3">
                                    <input type="checkbox" value="4" name="areas[]" <?php if (in_array('4', $parts)){ echo "checked=checked";}?>><label class="chkbox_space">Cancer</label>
                                </div>
                                <div class="col-md-3 col-sm-3">
                                    <input type="checkbox" value="5" name="areas[]" <?php if (in_array('5', $parts)){ echo "checked=checked";}?>><label class="chkbox_space">Youth</label>
                                </div>
                                <div class="col-md-3 col-sm-3">
                                    <input type="checkbox" value="6" name="areas[]" <?php if (in_array('6', $parts)){ echo "checked=checked";}?>><label class="chkbox_space">Sports</label>
                                </div>

                                <div class="col-md-3 col-sm-3">
                                    <input type="checkbox" value="7" name="areas[]" <?php if (in_array('7', $parts)){ echo "checked=checked";}?>><label class="chkbox_space">Education</label>
                                </div>
                                <div class="col-md-3 col-sm-3">
                                    <input type="checkbox" value="8" name="areas[]" <?php if (in_array('8', $parts)){ echo "checked=checked";}?>><label class="chkbox_space">Religion</label>
                                </div>
                                <div class="col-md-3 col-sm-3">
                                    <input type="checkbox" value="9" name="areas[]" <?php if (in_array('9', $parts)){ echo "checked=checked";}?>><label class="chkbox_space">School</label>
                                </div>
                                <div class="col-md-3 col-sm-3">
                                    <input type="checkbox" value="10" name="areas[]" <?php if (in_array('10', $parts)){ echo "checked=checked";}?>><label class="chkbox_space">Human Rights</label>
                                </div>
                                <div class="col-md-3 col-sm-3">
                                    <input type="checkbox" value="11" name="areas[]" <?php if (in_array('11', $parts)){ echo "checked=checked";}?>><label class="chkbox_space">Protection</label>
                                </div>

                                <div class="col-md-3 col-sm-3">
                                    <input type="checkbox" value="12" name="areas[]" <?php if (in_array('12', $parts)){ echo "checked=checked";}?>><label class="chkbox_space">Drugs & Alcohol</label>
                                </div>
                                <div class="col-md-3 col-sm-3">
                                    <input type="checkbox" value="13" name="areas[]" <?php if (in_array('13', $parts)){ echo "checked=checked";}?>><label class="chkbox_space">Health</label>
                                </div>

								 <div class="col-md-3 col-sm-3">
                                    <input type="checkbox" value="14" name="areas[]" <?php if (in_array('14', $parts)){ echo "checked=checked";}?>><label class="chkbox_space">Animal Welfare</label>
                                </div>

								 <div class="col-md-3 col-sm-3">
                                    <input type="checkbox" value="15" name="areas[]" <?php if (in_array('15', $parts)){ echo "checked=checked";}?>><label class="chkbox_space">Other</label>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                           <div class="form-group">
                               <label for="upload">Logo<span class="red_star"></span> <b>(Max size 500kb)</b></label>
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
							<?php if($data["logo"]){?>
								<img id="blah" height="100px" width="100px" src="<?php echo $this->config->item("organisation_logo")."/".$data["logo"]; ?>" alt=""/>
							<?php }else{ ?>
								<img id="blah" height="100px" width="100px" src="#" style="display:none;" alt=""/>
							<?php }?>
							</div>
						<br class="clear">
                        <div class="col-md-12 col-sm-12 col-xs-12"><h4 class="blue_top heading">REGISTERED ADDRESS</h4></div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                             <label for="street_address">Street Address<span class="red_star"></span></label>
                             <input placeholder="Street Address" type="text" class="form-control" id="street_address" name="street_address" value="<?php echo $data['street_address'];?>">
                            </div>
                        </div>
                        <br class="clear">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                             <div class="form-group">
                             <div class="row">
                                 <div class="col-md-6 col-sm-6 col-xs-6">
                                 	<label for="region">Suburb<span class="red_star"></span></label>
                                    <input placeholder="Suburb" type="text" class="form-control" id="region" name="region" value="<?php echo $data['region'];?>">
                                 </div>
								 <div class="col-md-6 col-sm-6 col-xs-6">
                                 	<label for="email">City<span class="red_star"></span></label>
                                    <input type="text" class="form-control" id="city" placeholder="City" id="city" name="city" value="<?php echo $data['city'];?>">
                                 </div>
                             </div>
                             </div>
                        </div>
                        <br class="clear">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                             <div class="form-group">
                             <div class="row">
                                 <div class="col-md-6 col-sm-6 col-xs-6">
                                 	<label for="postal_code">Postal Code<span class="red_star"></span></label>
                                    <input type="text" class="form-control" id="postal_code" name="postal_code" placeholder="Postal Code" value="<?php if($data['postal_code'] == 0){ echo "";}else{ echo $data['postal_code'];}?>">
                                 </div>
                                 <div class="col-md-6 col-sm-6 col-xs-6">
                                 	<label for="country">Country<span class="red_star"></span></label>
                                   <!-- <input type="text" class="form-control" id="country" name="country" placeholder="Country" value="<?php //echo $data['country'];?>">-->

								    <select class="search_events form-control dropdown" id="country" name="country">
										<option value="">-- Please Select --</option>
										<option <?php if($data['country'] == "NewZealand"){ echo "selected ";}else{ echo "";}?> value="NewZealand">New Zealand</option>
										<option <?php if($data['country'] == "Australia"){ echo "selected ";}else{ echo "";}?> value="Australia">Australia</option>
									</select>
                                 </div>
                             </div>
                             </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12"><h4 class=" blue_top heading">FINANCIAL CONTACT</h4></div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                             <label for="finance_position">Finance Officer Position<span class="red_star"></span></label>
 <input type="text" class="form-control" placeholder="Position" id="finance_position" name="finance_position" value="<?php echo $data['finance_position'];?>">
                            </div>
                        </div>
                        <br class="clear">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                             <div class="form-group">
                             <div class="row">
                                 <div class="col-md-6 col-sm-6 col-xs-6">
                                 	<label for="finance_first_name">First Name<span class="red_star"></span></label>
                                    <input type="text" class="form-control" id="finance_first_name" name="finance_first_name" placeholder="First Name" value="<?php echo $data['finance_first_name'];?>">
                                 </div>
                                 <div class="col-md-6 col-sm-6 col-xs-6">
                                 	<label for="finance_last_name">Last Name<span class="red_star"></span></label>
                                    <input type="text" class="form-control" id="finance_last_name" name="finance_last_name" placeholder="Last Name" value="<?php echo $data['finance_last_name'];?>">
                                 </div>
                             </div>
                             </div>
                        </div>
                        <br class="clear">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                             <label for="finance_email">Email<span class="red_star"></span></label>
                             <input type="text" class="form-control" id="finance_email" name="finance_email" placeholder="Email" value="<?php echo $data['finance_email'];?>">
                            </div>
                        </div>
                        <br class="clear">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                             <label for="finance_phone">Phone</label>
                             <input type="text" class="form-control" id="finance_phone" name="finance_phone" placeholder="Phone" value="<?php if($data['finance_phone'] == 0){ echo "";}else{ echo $data['finance_phone'];}?>">
                            </div>
                        </div>
                        <br class="clear">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                             <label for="finance_fax">Fax</label>
                             <input type="text" class="form-control" id="finance_fax" name="finance_fax" placeholder="Fax" value="<?php if($data['finance_fax'] == 0){ echo "";}else{ echo $data['finance_fax'];}?>">
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12"><h4 class=" blue_top heading">BANK DETAILS (for the settlement of funds received)</h4></div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                             <label for="bank_name">Bank Name<span class="red_star"></span></label>
                             <input type="text" placeholder="Bank Name" class="form-control" id="bank_name" name="bank_name" value="<?php echo $data['bank_name'];?>">
                            </div>
                        </div>
                        <br class="clear">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                             <label for="bank_details">Bank Account Number<span class="red_star"></span></label>
                             <input type="text" placeholder="Account Number" class="form-control" id="bank_details" name="bank_details" value="<?php echo $data['bank_details'];?>">
                            </div>
                        </div>
						<br class="clear">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                           <div class="form-group">
                               	<label for="upload">Attach Your Bank Statement<span class="red_star"></span></label>
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
							<a style="color:blue !important;" href="<?php echo $this->config->item("organisation_statement")."/".$data["bank_statement"]; ?>" data-lightbox="" target="_blank"><?php echo $data["bank_statement"];?></a>
						</div>



						<br class="clear">
						<div class="col-md-6 col-sm-6 col-xs-12">
							<label id="attach_statement" style="display:none;">Bank statement successfully attached</label>
						</div>
						<br class="clear">
 <div class="col-md-12 col-sm-12 col-xs-12"><h4 class=" blue_top heading">BANK DETAILS (for payments to TicketingSystem & POLi)</h4></div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                             <label for="bank_name_for_ts">Bank Name<span class="red_star"></span></label>
                             <input type="text" placeholder="Bank Name" class="form-control" name="bank_name_for_ts" id="bank_name_for_ts" value="<?php echo $data['bank_name_for_ticket_suite'];?>">
                            </div>
                        </div>
                        <br class="clear">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                             <label for="bank_account_no_for_ts">Bank Account Number<span class="red_star"></span></label>
                             <input type="text" placeholder="Account Number" class="form-control" name="bank_account_no_for_ts" id="bank_account_no_for_ts" value="<?php echo $data['account_number_ticket_suite'];?>">
                            </div>
                        </div>
						<br class="clear">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                           <div class="form-group">
                               	<label for="upload">Attach Your Bank Statement<span class="red_star"></span></label>
                               <div class="input-group">
                					<label class="input-group-btn">
                   					 	<span class="btn btn-primary">
                        			  	Browse&hellip; <input type="file" style="display: none;" id="bank_attachment_for_ts" name="bank_attachment_for_ts">
                    				 	</span>
                					</label>
                				<input type="text" class="form-control" readonly id="bank_va1" name="bank_va1">
            				   </div>
                           </div>
                        </div>
						<br class="clear">
						<div class="col-md-6 col-sm-6 col-xs-12">
							<a style="color:blue !important;" href="<?php echo $this->config->item("organisation_statement")."/".$data["bank_statement_ticket_suite"]; ?>" data-lightbox="" target="_blank"><?php echo $data["bank_statement_ticket_suite"];?></a>
						</div>
						<br class="clear">
						<div class="col-md-6 col-sm-6 col-xs-12">
							<label id="attach_statement" style="display:none;">Bank statement successfully attached</label>
						</div>


						<br class="clear">
						<div class="col-md-6 col-sm-6 col-xs-12">
							<label id="attach_statement1" style="display:none;">Bank statement successfully attached</label>
						</div>


                     	<br class="clear">
						<div class="col-md-12 col-sm-12 col-xs-12"><h4 class=" blue_top heading">RECEIPT DETAILS</h4></div>
						<br class="clear">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                             <label for="receipt_text">Receipt Text</label>
                             <textarea placeholder="Receipt Text" class="form-control" name="receipt_text" id="receipt_text"><?php echo $data['receipt_text'];?></textarea>
                            </div>
                        </div>
						<br class="clear">
						 <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                             <label for="sig_text">Signature Text</label>
                             <textarea palceholder="Signature Text" class="form-control" name="sig_text" id="sig_text"><?php echo $data['signature_text'];?></textarea>
                            </div>
                        </div>
						<br class="clear">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                           <div class="form-group">
                               <label for="upload">Attach Your Electronic Signature<span class="red_star"></span></label>
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
							<?php if($data["signature"]){?>
								<img id="blah2" src="<?php echo $this->config->item("organisation_signature")."/".$data["signature"]; ?>" alt="" style="height:100px;"/>
							<?php }else{ ?>
								<img id="blah2" src="<?php echo $this->config->item("organisation_signature")."/".$data["signature"]; ?>" alt="" style="display:none;height:100px;"/>

							<?php }?>
						</div>

						<br class="clear"><br class="clear">
						<div class="col-md-6 col-sm-12 col-xs-12">
							<div class="form-group">
							  <label for="plan_select">The 12 month plan I am seeking is:</label>
								<select class="search_events form-control dropdown" id="plan_select" name="plan_select" >
									<option value="">-- Please Select -- </option>
									<option value="1" <?php if($data['plan_select'] == "1"){ echo "selected";}else{ echo "";}?>>Standard Suite Plan – 1.5% fee per transaction</option>
									<option value="2" <?php if($data['plan_select'] == "2"){ echo "selected";}else{ echo "";}?>>Deluxe Suite Plan – 4% fee per transaction</option>
								</select>
							</div>
						</div>

                </div><!--row end-->
				<br class="clear"><br>
                <div class="row buttons">
                    <div class="col-md-12">
						<button class="btn btn-primary save_btn" type="submit">Update</button>
						<a href="" onclick="window.history.back();" class="btn btn-primary save_btn">Cancel</a>
						<input type="hidden" class="form-control" id="organiser_id" name="organiser_id" value="<?php echo $data['id'];?>">

						<button type="button" class="btn btn-primary" data-clipboard-target=".demo">Copy Link</button>
						<?php
							$key_code = md5($data['email']);
							$link = $this->config->item("organizer_set_up")."/".$key_code;
						?>
						<textarea class="demo form-control" style="display:none"><?php echo $link;?></textarea>

						<input type="hidden" value="0" name="activation_change" id="activation_change">
						<input type="hidden" value="<?php echo $data['main_status'];?>" name="status" id="status" value="<?php echo $data['main_status'];?>">
						<input type="hidden" value="<?php echo $data['logo'];?>" name="old_logo" id="old_logo">
						<input type="hidden" value="<?php echo $data['signature'];?>" name="old_signature" id="old_signature">
						<input type="hidden" value="<?php echo $data['bank_statement'];?>" name="old_bank_statement" id="old_bank_statement">
					    <input type="hidden" value="<?php echo $data['bank_statement_ticket_suite'];?>" name="old_bank_ticket_suite_statement" id="old_bank_ticket_suite_statement">
                    </div>
             	</div></form>
				<br class="clear"><br>
          </div>
      </div>
<script>
	 $('.demo-2').click(function(){
			$(this).CopyToClipboard();
		});
</script>
<script>
	function submit_form(result){
		document.getElementById("status").value = result;
		document.getElementById("activation_change").value = 1;
		document.getElementById("organiser_admin_form").submit();
	}

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
			document.getElementById('bank_va1').value = filename;
		}

		document.getElementById('attach_statement1').style.color = 'green';
		document.getElementById('attach_statement1').style.display = 'block';
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
<script src="<?php echo $this->config->item('frontend_js_path');?>jquery.validate.min.js"></script>
<script>
	(function($,W,D){
    var user_validation = {};
    user_validation.UTIL =
    {
        setupFormValidation: function()
        {
            //form validation rules
            $("#organiser_admin_form").validate({
                rules: {
                   	title: {
                        required: true,
                    },
					salutation: {
                        required: true,
                    },
					organization_name: {
                        required: true,
                    },
					phone:{
						number: true,
					},
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
<style>
	.ten_pix{width:10%;}
	.twny_pix{width:25%;}
	.middle_align{text-align:center;}
	.payment_info th{padding:8px;text-align:center;border:1px solid #e3e3e3;}
	.payment_info td{padding:8px;text-align:center;border:1px solid #e3e3e3;}
</style>