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

	.ten_pix{width:10%;}
	.twny_pix{width:25%;}
	.middle_align{text-align:center;}
	.payment_info th{padding:8px;text-align:center;border:1px solid #e3e3e3;}
	.payment_info td{padding:8px;text-align:center;border:1px solid #e3e3e3;}

	.error{color:red;}

	.no_margin{margin-top:0px !important;}
	.change_email {
		background: #00a4ef none repeat scroll 0 0;
		border: medium none;
		color: #fff;
		display: inline-block;
		float: left;
		margin-bottom: 15px;
		padding: 1px 7px;
		text-decoration: none;
	}
</style>
<script src="<?php echo $this->config->item('admin_js_path');?>lightbox.js"></script>
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
                        <div class="right_first_box"><img src="<?php echo $this->config->item('admin_image_path');?>home.png"><a href="<?php echo $this->config->item('login_url');?>">Home</a> > <a href="<?php echo $this->config->item('admin_organiser');?>">Manage Organisation</a> > <a href="#">Edit Organisation</a></div>
                    </div>
                </div>
                <div class="row">
                   <div class="col-md-12 col-sm-12 col-xs-12"><h4 class="blue_top  heading">Edit Organisation</h4></div>
				</div>
				<?php
				//echo "hello world";
					//echo "<pre>";
					//print_r($data);
					//echo "</pre>";
				?>
				<div class="table_white_box" style="padding:25px;">
					<form enctype="multipart/form-data" method="POST" action="<?php echo $this->config->item('save_admin_organiser');?>" name="organiser_admin_form" id="organiser_admin_form">
                     <div class="col-md-12 col-sm-12 col-xs-12"><h4 class=" blue_top heading no_margin">Primary Contact (Event Manager)</h4></div>

					<div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                         <label for="email">Position Title<span class="red_star">*</span></label>
                         <input type="text" class="form-control" id="title" name="title" value="<?php echo $data['title'];?>">
                        </div>
                    </div>
                    <br class="clear">

					<div class="col-md-6 col-sm-12 col-xs-12">
                    	<div class="form-group">
                          <label for="email">Salutation<span class="red_star">*</span></label>
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
                         <label for="email">Name<span class="red_star">*</span></label>
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
						<div>
							<label data-toggle="modal" data-target="#myModal" class="change_email" style="margin-bottom:30px;cursor:pointer;">Change Email</label>
						</div>
                    </div>
                    <br class="clear">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                    	<div class="form-group">
                         <label for="email">Phone</label>
<input type="text" class="form-control" id="phone" name="phone" value="<?php if($data['phone'] == 0){ echo "";}else{ echo $data['phone'];}?>">
                        </div>
                    </div>
                    <br class="clear">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                    	<div class="form-group">
                         <label for="email">Fax</label>
                         <input type="text" class="form-control" id="fax" name="fax" value="<?php if($data['fax'] == 0){ echo "";}else{ echo $data['fax'];}?>">
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12"><h4 class="blue_top  heading">ORGANISATION DETAILS</h4></div>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                    	<div class="form-group">
                         <label for="email">Organisation Name<span class="red_star">*</span></label>
                         <input type="text" class="form-control" id="organisation_name" name="organisation_name" value="<?php echo $data['organization_name'];?>">
                        </div>
                    </div>
                    <br class="clear">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                    	<div class="form-group">
                         <label for="email">IRD Number</label>
                         <input type="text" class="form-control" id="ird" name="ird" value="<?php echo $data['ird_number'];?>">
                        </div>
                    </div>
                    <br class="clear">


                    <div class="col-md-6 col-sm-12 col-xs-12">
                    	<div class="form-group">

                        <label for="email">Organisation Type<span class="red_star">*</span></label>
                          <select class="search_events form-control dropdown" id="organization_nature" name="organization_nature">
                               <option value="">-- Please Select --</option>
                   <?php foreach($get_organisation_type as $org_type){ ?>
                <option value="<?php echo $org_type['key_name']; ?>" <?php if($data['organization_nature']==$org_type['key_name']){echo "selected";}else{"";}?>><?php echo $org_type['name']; ?></option>
               <?php } ?>
                            </select>
                        </div>
                    </div>


                    <!--<div class="col-md-6 col-sm-12 col-xs-12">
                    	<div class="form-group">
                         <label for="email">What is the nature of your Organization ?</label>
                         <input value="<?php //echo $data['organization_nature'];?>" type="text" class="form-control" id="organization_nature" name="organization_nature">
                        </div>
                    </div>-->

                    <br class="clear">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                    	<div class="form-group">
                         <label for="email">Are you approved for the donee status under the Income Tax Act 2007 ?</label>
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
                         <label for="email">Do you hold a registration with the Charities Commission ?</label>
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
                         <label for="email">If Yes, What is your registration number ? If No,leave this field blank.</label>
                         <input type="text" class="form-control" id="registration_number" name="registration_number" value="<?php echo $data['registration_number'];?>">
                        </div>
                    </div>
                    <br class="clear">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                    	<div class="form-group">
                         <label for="charity_name">Preferred Organization name.<span class="red_star">*</span></label>
                         <input type="text" class="form-control" id="charity_name" name="charity_name" value="<?php echo $data['charity_name'];?>">
                        </div>
                    </div>
                    <br class="clear">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                    	<div class="form-group">
                         <label for="charity_overview">Overview</label>
                         <textarea class="form-control" id="charity_overview" name="charity_overview"><?php echo $data['charity_overview'];?></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                            <label for="">Choose which areas your organisation is involved in.</label>
                            <div class="row">
                                <div class="col-md-3 col-sm-3">
								<?php $parts = explode(',', $data['areas']);?>
    <input type="checkbox" value="1" name="areas[]" <?php if (in_array('1', $parts)){ echo "checked=checked";}?>><label class="chkbox_space">Aged Care</label>
                                </div>
                                <div class="col-md-3 col-sm-3">
                                    <input type="checkbox" value="2" name="areas[]" <?php if (in_array('2', $parts)){ echo "checked=checked";}?>><label class="chkbox_space">HIV and AIDS </label>
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
                                    <input type="checkbox" value="14" name="areas[]" <?php if (in_array('14', $parts)){ echo "checked=checked";}?>><label class="chkbox_space">Animal Wlefare</label>
                                </div>
								 <div class="col-md-3 col-sm-3">
                                    <input type="checkbox" value="15" name="areas[]" <?php if (in_array('15', $parts)){ echo "checked=checked";}?>><label class="chkbox_space">Other</label>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                           <div class="form-group">
                               <label for="upload">Logo<span class="red_star">*</span> <b>(Max size 500kb)</b></label>
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
							<img id="blah" height="100px" width="100px" src="<?php echo $this->config->item("organisation_logo")."/".$data["logo"]; ?>" alt=""/>
						</div>
						<br class="clear">
                        <div class="col-md-12 col-sm-12 col-xs-12"><h4 class="blue_top heading">REGISTERED ADDRESS</h4></div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                             <label for="email">Street Address<span class="red_star">*</span></label>
                             <input type="text" class="form-control" id="street_address" name="street_address" value="<?php echo $data['street_address'];?>">
                            </div>
                        </div>
                        <br class="clear">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                             <div class="form-group">
                             <div class="row">
                                 <div class="col-md-6 col-sm-6 col-xs-6">
                                 	<label for="email">Suburb<span class="red_star">*</span></label>
                                    <input type="text" class="form-control" id="region" name="region" value="<?php echo $data['region'];?>">
                                 </div>
								 <div class="col-md-6 col-sm-6 col-xs-6">
                                 	<label for="email">City<span class="red_star">*</span></label>
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
                                 	<label for="email">Postal Code<span class="red_star">*</span></label>
                                    <input type="text" class="form-control" id="postal_code" name="postal_code" placeholder="Postal Code" value="<?php if($data['postal_code'] == 0){ echo "";}else{ echo $data['postal_code'];}?>">
                                 </div>
                                 <div class="col-md-6 col-sm-6 col-xs-6">
                                 	<label for="email">Country<span class="red_star">*</span></label>
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
                             <label for="email">Finance Officer Position<span class="red_star">*</span></label>
 <input type="text" class="form-control" id="finance_position" name="finance_position" value="<?php echo $data['finance_position'];?>">
                            </div>
                        </div>
                        <br class="clear">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                             <div class="form-group">
                             <div class="row">
                                 <div class="col-md-6 col-sm-6 col-xs-6">
                                 	<label for="email">First Name<span class="red_star">*</span></label>
                                    <input type="text" class="form-control" id="finance_first_name" name="finance_first_name" placeholder="First Name" value="<?php echo $data['finance_first_name'];?>">
                                 </div>
                                 <div class="col-md-6 col-sm-6 col-xs-6">
                                 	<label for="email">Last Name<span class="red_star">*</span></label>
                                    <input type="text" class="form-control" id="finance_last_name" name="finance_last_name" placeholder="Last Name" value="<?php echo $data['finance_last_name'];?>">
                                 </div>
                             </div>
                             </div>
                        </div>
                        <br class="clear">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                             <label for="email">Email<span class="red_star">*</span></label>
                             <input type="text" class="form-control" id="finance_email" name="finance_email" placeholder="Email" value="<?php echo $data['finance_email'];?>">
                            </div>
                        </div>
                        <br class="clear">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                             <label for="email">Phone</label>
                             <input type="text" class="form-control" id="finance_phone" name="finance_phone" placeholder="finance_phone" value="<?php if($data['finance_phone'] == 0){ echo "";}else{ echo $data['finance_phone'];}?>">
                            </div>
                        </div>
                        <br class="clear">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                             <label for="email">Fax</label>
                             <input type="text" class="form-control" id="finance_fax" name="finance_fax" placeholder="finance_fax" value="<?php if($data['finance_fax'] == 0){ echo "";}else{ echo $data['finance_fax'];}?>">
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12"><h4 class=" blue_top heading">BANK DETAILS (for the settlement of funds received)</h4></div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                             <label for="email">Bank Name<span class="red_star">*</span></label>
                             <input type="text" class="form-control" id="bank_name" name="bank_name" value="<?php echo $data['bank_name'];?>">
                            </div>
                        </div>
                        <br class="clear">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                             <label for="email">Bank Account Number<span class="red_star">*</span></label>
                             <input type="text" class="form-control" id="bank_details" name="bank_details" value="<?php echo $data['bank_details'];?>">
                            </div>
                        </div>
						<br class="clear">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                           <div class="form-group">
                               	<label for="upload">Attach Your Bank Statement<span class="red_star">*</span></label>
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
                             <label for="email">Bank Name<span class="red_star">*</span></label>
                             <input type="text" class="form-control" name="bank_name_for_ts" id="bank_name_for_ts" value="<?php echo $data['bank_name_for_ticket_suite'];?>">
                            </div>
                        </div>
                        <br class="clear">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                             <label for="email">Bank Account Number<span class="red_star">*</span></label>
                             <input type="text" class="form-control" name="bank_account_no_for_ts" id="bank_account_no_for_ts" value="<?php echo $data['account_number_ticket_suite'];?>">
                            </div>
                        </div>
						<br class="clear">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                           <div class="form-group">
                               	<label for="upload">Attach Your Bank Statement<span class="red_star">*</span></label>
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
						<div class="col-md-12 col-sm-12 col-xs-12"><h4 class=" blue_top heading">Receipt Details</h4></div>
						<br class="clear">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                             <label for="email">Receipt Text</label>
                             <textarea class="form-control" name="receipt_text" id="receipt_text"><?php echo $data['receipt_text'];?></textarea>
                            </div>
                        </div>
						<br class="clear">
						 <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                             <label for="sig_text">Signature Text</label>
                             <textarea class="form-control" name="sig_text" id="sig_text"><?php echo $data['signature_text'];?></textarea>
                            </div>
                        </div>
						<br class="clear">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                           <div class="form-group">
                               <label for="upload">Attach Your Electronic Signature<span class="red_star">*</span></label>
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
							<img id="blah2" src="<?php echo $this->config->item("organisation_signature")."/".$data["signature"]; ?>" alt="" style="height:100px;"/>
						</div>

						<br class="clear"><br class="clear">
						<div class="col-md-6 col-sm-12 col-xs-12">
							<div class="form-group">
							  <label for="plan_select">The 12 month plan I am seeking is :<span class="red_star">*</span></label>
								<select class="search_events form-control dropdown" id="plan_select" name="plan_select" >
									<option value="">-- Please Select --</option>
									<option value="1" <?php if($data['plan_select'] == "1"){ echo "selected";}else{ echo "";}?>>Standard Suite Plan – 1.5% fee per transaction</option>
									<option value="2" <?php if($data['plan_select'] == "2"){ echo "selected";}else{ echo "";}?>>Deluxe Suite Plan – 4% fee per transaction</option>
								</select>
							</div>
						</div>



						<br class="clear">
						<div class="col-md-12 col-sm-12 col-xs-12"><h4 class=" blue_top heading">SetUp Payment Details</h4></div>
						<div class="col-md-10 col-sm-10 col-xs-12">
							<table border="1px solid #e3e3e3;" class="payment_info">
								<tr>
									<th style="width:5%;">Sr.No.</th>
									<th class="ten_pix">Gateway</th>
									<th class="ten_pix">TicketingSystem</th>
									<th class="ten_pix">Organizer</th>
									<th class="twny_pix">Reference</th>
								</tr>
								<?php if(isset($payment_data) && (empty($payment_data))){ ?>
								<tr>
									<td style="width:5%;">1</td>
									<td class="ten_pix">Alipay</td>
									<td class="ten_pix"><input onclick="populate('alipay_reference');"  value="2" name="alipay_method" type="radio" class="middle_align"></td>
									<td class="ten_pix"><input value="1" onclick="un_populate('alipay_reference');" name="alipay_method" type="radio" class="middle_align" checked></td>
									<td class="twny_pix"><input id="alipay_reference" name="alipay_reference" type="text" class="form-control" readonly></td>
								</tr>
								<tr>
									<td style="width:5%;">3</td>
									<td class="ten_pix">Credit Card</td>
									<td class="ten_pix"><input onclick="populate('cc_reference');"  value="2" name="cc_method" type="radio" class="middle_align"></td>
									<td class="ten_pix"><input value="1" onclick="un_populate('cc_reference');" name="cc_method" type="radio" class="middle_align" checked></td>
									<td class="twny_pix"><input id="cc_reference" name="cc_reference" type="text" class="form-control" readonly></td>
								</tr>
								<tr>
									<td style="width:5%;">2</td>
									<td class="ten_pix">Dynamic Payment</td>
									<td class="ten_pix"><input onclick="populate('dynamic_payment_reference');" value="2" name="dynamic_payment_method" type="radio" class="middle_align"></td>
									<td class="ten_pix"><input value="1" onclick="un_populate('dynamic_payment_reference');"name="dynamic_payment_method" type="radio" class="middle_align" checked></td>
									<td class="twny_pix"><input name="dynamic_payment_reference" id="dynamic_payment_reference" type="text" class="form-control" readonly></td>
								</tr>

								<tr>
									<td style="width:5%;">4</td>
									<td class="ten_pix">Poli</td>
									<td class="ten_pix"><input onclick="populate('poli_reference');"  value="2" name="poli_method" type="radio" class="middle_align"></td>
									<td class="ten_pix"><input value="1" onclick="un_populate('poli_reference');" name="poli_method" type="radio" class="middle_align" checked></td>
									<td class="twny_pix"><input id="poli_reference" name="poli_reference" type="text" class="form-control" readonly></td>
								</tr>
								<?php }else{
									$i = 1;
									foreach($payment_data as $data_result){
								?>
									<tr>
										<td style="width:5%;"><?php echo $i++;?></td>
										<td class="ten_pix">
											<?php
												echo ucfirst($data_result['payment_key']);
												if($data_result['payment_method'] != 2){
													$readonly = "readonly";
													$required = "";
												}else{
													$readonly = "";
													$required = "required";
												}
											?>
										</td>
										<td class="ten_pix">
											<input onclick="populate('<?php echo $data_result['payment_key'];?>_reference');" value="2" id="<?php echo $data_result['payment_key'];?>_method" name="<?php echo $data_result['payment_key'];?>_method" type="radio" class="middle_align" <?php if($data_result['payment_method'] == 2){echo "Checked";}else{echo "";};?>>
										</td>
										<td class="ten_pix">
											<input value="1" onclick="un_populate('<?php echo $data_result['payment_key'];?>_reference');" id="<?php echo $data_result['payment_key'];?>_method" name="<?php echo $data_result['payment_key'];?>_method" type="radio" class="middle_align" <?php if($data_result['payment_method'] == 1){echo "Checked";}else{echo "";};?>>
										</td>
										<td class="twny_pix">
											<input value="<?php echo $data_result['reference_number'];?>" id="<?php echo $data_result['payment_key'];?>_reference" name="<?php echo $data_result['payment_key'];?>_reference" type="text" class="form-control" value="" <?php echo $readonly?> <?php echo $required?>>
										</td>
									</tr>
								<?php
									}
									}
								?>
							</table>
						</div>
                </div><!--row end-->
				<br class="clear"><br>
                <div class="row buttons">
                    <div class="col-md-12">
						<button class="btn btn-primary save_btn" type="submit">Update</button>

						<?php if($data['main_status'] == "1"){ ?>
							<a href="#" onclick="submit_form(0);" class="btn btn-primary save_btn">Update & Deactivate</a>
						<?php }else{ ?>
							<a href="#" onclick="submit_form(1);" class="btn btn-primary save_btn">Update & Activate</a>
						<?php } ?>

						<a href="" onclick="confirmAction(<?php echo $data['id'];?>,'Are you sure you want to mark this organisation as incomplete?', changeStatus); return false;" class="btn btn-primary save_btn" title="in-progress">Mark As In-Complete</a>

						<a href="" onclick="window.history.back();" class="btn btn-primary save_btn">Cancel</a>
						<input type="hidden" class="form-control" id="organiser_id" name="organiser_id" value="<?php echo $data['id'];?>">

						<input type="hidden" value="0" name="activation_change" id="activation_change">
						<input type="hidden" value="<?php echo $data['main_status'];?>" name="old_status" id="old_status">
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

<div class="col-md-2 col-sm-2 col-xs-10">
         <form id="modalform" action="" >
          <div id="myModal" class="modal fade" role="dialog">
           <div class="modal-dialog modal-md">
            <div class="modal-content">
             <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title hr_header" id="model_title">Change Email Request <span class="modal_champion_title"></span></h4>
             </div>
             <div class="modal-body">
                <input type="hidden" name="user_id" value="<?php echo $data['id']; ?>">
           <div class="row">
               <div class="col-sm-4">
                <label>Email</label><span class="red_span">*</span>
               </div>
               <div class="col-sm-6">
             <input type="text" class="form-control" name="email1" id="email_name" value="<?php echo $data['email'];?>">
                                         <div id="email_error" style="color:red; "></div>
            <div id="message" style="color:red"></div>
            <div id="success_message" style="color:green"></div>
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
	$(document).on("keyup", "#email_name", function(){
        var emailreg=/^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
		var em=$(this).val();
		if(!emailreg.test(em)){
			$('.save_sponser').prop('disabled', true);
		}else{
			$('.save_sponser').prop('disabled', false);
		}
   });



$('#modalform').on('submit',function(e){
  e.preventDefault();
  $('#message').text('');
  $('#success_message').text('');
  var id = "<?php echo $data['id'];?>";
  var a = $('#email_name').val();
  var form_data= {email : a,id : id};
  var email = "<?php echo $data['email']; ?>";
  var email_reg=/^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
  if(a!=email){
     $.ajax({
     url : "<?php echo base_url(); ?>index.php/backend/organiser/has_email_organiser",
     type: "POST",
     data : form_data,
     cache: false,
     success : function(response) {
        try{
        if(response=='false'){
			$('#message').text('Email is registered with other account');
        }else if(response=='blank'){
			$('#message').text('Email id cannot be blank');
        }else if(response=='wrong'){
			$('#message').text('Invalid email id');
        }else{
			$('#success_message').text('Email successfully updated');
			location.reload();
		}
       }catch(e){
        $('#message').text('Error while catching..');
       }
     },
      error: function() {
      $('#message').text('Error while request..');
      },
   });
 }else if(!email_reg.test(a)){
   $('#message').text('Email field is invalid');
 }else{
    $('#message').text('Email same as old email');
 }

});


	function un_populate(result){
		document.getElementById(result).value = "";
		document.getElementById(result).readOnly = true;
		document.getElementById(result).required = false;
	}

	function populate(result){
		document.getElementById(result).removeAttribute('readonly');
		document.getElementById(result).required = true;
		$("#"+result).attr("maxlength", 20);
	}

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
					organization_nature:{
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
                    },
					bank_name_for_ts: {
                        required: true,
                    },
					bank_account_no_for_ts: {
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
<link href="<?php echo $this->config->item('admin_css_path');?>alertify.core.css" rel="stylesheet">
<link href="<?php echo $this->config->item('admin_css_path');?>alertify.bootstrap.css" rel="stylesheet">
<link href="<?php echo $this->config->item('admin_css_path');?>alertify.default.css" rel="stylesheet">
<script src="<?php echo $this->config->item('admin_js_path');?>/alertify.min.js"></script>
<script>
	function confirmAction(status, message, action){
		alertify.confirm(message, function(e) {
			if (e) {
				// a_element is the <a> tag that was clicked
				if (action) {
					action(status);
				}
			}
		});
	}

	function changeStatus(org_id){

		$.ajax({
			type: "POST",
			dataType: 'json',
			url: "<?php echo base_url(); ?>index.php/backend/organiser/mark_as_incomplete",
			data: "org_id="+org_id,
			success: function(Rid1) {
				if (Rid1) {
				//	location.reload();
					alertify.success("Organisation marked as incomplete");
					window.location.href = "<?php echo base_url(); ?>index.php/backend/organiser/redirect_organiser_for_edit";
				}else{
					alertify.error("Unable to update changes");
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
</script>