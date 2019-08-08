<meta property="og:title" content="<?php echo $data['title']; ?>" />
<meta property="og:description" content="<?php echo htmlspecialchars($data['message']);?>" />
<meta property="og:image" content="<?php echo $this->config->item('fundraising_image_url').$data['fundraising_image'];?>" />
<link rel="stylesheet" href="<?php echo $this->config->item('frontend_css_path');?>pages/donation_page.css" type="text/css" media="all">

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
						<h2>Donation</h2>
					</div>
				</div>
				<!--ROW END-->
			</div>
		</div>
		<!--Kode-our-speaker-heading End-->
		<div class="kode-blog-style-2">
	  	  <div class="container">
            <h4 class="text-left">Donation to <?php echo $data['display_name']; ?> in support of <?php ?><?php
						if(!empty($organizer_data)){
							echo $organizer_data->charity_name;
						}
					?></h4>

			<form enctype="multipart/form-data" method="POST" action="<?php echo $this->config->item('base_url').'/frontend/donation_orders/save_donation/'.$data['id'];?>" name="add_donation_form" id="add_donation_form">

                <div class="clear"></div>
                <div class="paragraph blue_txt">1.Donation Amount<span>*</span></div>
                <div class="clear"></div>
                <div class="col-md-8 col-sm-8">
                 	<div class="row">
                    	<div class="col-md-2">
                        	<div class="gray_bg_radio">
                            	<input type="radio" id="name_200" name="name" class="" onclick="update_amount(200);">&nbsp;&nbsp;&nbsp;<label for="name_200">$200</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                        	<div class="gray_bg_radio">
                            	<input type="radio" id="name_100" name="name" class="" onclick="update_amount(100);">&nbsp;&nbsp;&nbsp;<label for="name_100">$100</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                        	<div class="gray_bg_radio">
                            	<input type="radio" id="name_50" name="name" class="" onclick="update_amount(50);">&nbsp;&nbsp;&nbsp;<label for="name_50">$50</label>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4">
							<div class="row adjust_donation_box_margin">
								<div class="col-md-3 col-sm-3" style="padding:0px;">
								<label for="target_amount" class="align_to_txt_box">Other &nbsp;$</label></div>
								<div class="col-md-9 col-sm-9">
									<input type="text" id="target_amount" name="target_amount" value="<?php echo set_value('target_amount'); ?>" class="form-control required" placeholder="Amount in $" maxlength="4">
									<?php echo form_error('target_amount'); ?>
								</div></div>
						</div>
						 <div class="col-md-2 col-sm-2"><div class="row adjust_donation_box_margin"><label class="align_to_txt_box normal">Max $1,000</label></div></div>

                    </div>
                </div>

               <!--
                <div class="col-md-6 col-sm-6">
                	<div class="row">
                    	<div class="row align_to_txt_box">

                      	</div>
                    </div>
                </div>-->
                <div class="clear"></div>
                <div class="col-md-12 col-sm-12">
                	<!--<h5 class="search_events text-left">Donor Message</h5>
                    <br class="clear">-->
                    <p class="search_events text-left">
                    	The donor message your enter below will appear next to your friend's supporter page.
                    </p>
                    <div class="row">
                    	<div class="col-md-2">
                        	<label for="donor_mssg" class="search_events">Donor Message<span>*</span></label>
                        </div>
                        <div class="col-md-6 message_error">
							<textarea style="width:475px;margin-left:60px;" rows="5" cols="20" id="donor_mssg" name="donor_mssg" class="form-control search_events" placeholder=""></textarea>
							<?php echo form_error('donor_mssg'); ?>
						</div>

                    </div>
                </div>
					<div class="paragraph blue_txt">2.Donor Details</div>
					<div class="clear"></div>
					<div class="col-md-2 col-sm-2">
						<label for="org_name" class="search_events">I am donating as an<span>*</span></label>
					</div>
					<div class="col-md-2 col-sm-2">
						<input type="radio" id="name" name="org_name" value="individual" <?php echo  set_radio('org_name', 'individual', TRUE); ?> class="search_events" onclick="ShowHideDiv();">&nbsp;&nbsp;&nbsp;<label for="email">Individual</label>
					</div>
					<div class="col-md-2 col-sm-2">
						<input type="radio" id="chkYes" name="org_name" value="organisation" <?php echo  set_radio('org_name', 'organisation'); ?> class="search_events" onclick="ShowHideDiv();">&nbsp;&nbsp;&nbsp;<label>Organization</label>
					</div>
					<div class="col-md-2 col-sm-2" style="display:none;" id="dvPassport">
						<input type="text" id="org_name" name="organisation_name" class="form-control " style="margin-bottom:0px;" placeholder="organization name">
					</div>
                <div class="clear"></div>
				<div class="col-md-12">
					 <p class="search_events text-left">The receipt will be issued to this person if donating as an individual,
					 or in the company name if donating as a company or organization.</p>
				</div>
				<div class="clear"></div>
				<div class="col-md-12">
					<h5 class="paragraph text-left">Personal Details</h5>
				</div>
                <div class="clear"></div>
				<div class="col-md-8">
					<div class="row">
						<div class="col-md-4">
							<label for="select_salutation" class="search_events">Salutation<span>*</span></label>
						</div>
						<div class="col-md-8">
							<select class="search_events form-control dropdown" id="select_salutation" name="select_salutation" >
								<option value="Mr" <?php echo set_select('select_salutation', 'Mr'); ?>>Mr</option>
								<option value="Ms" <?php echo set_select('select_salutation', 'Ms'); ?>>Ms</option>
								<option value="Mrs" <?php echo set_select('select_salutation', 'Mrs'); ?>>Mrs</option>
								<?php echo form_error('select_salutation'); ?>
							</select>

						</div>
					</div>
				</div>

				<div class="clear"></div>
                <div class="col-md-8">
					<div class="row">
						<div class="col-md-4">
							<label for="first_name" class="search_events">Name<span>*</span></label>
						</div>
						<div class="col-md-8">
<input type="text" id="first_name" name="first_name" value="<?php echo set_value('first_name',$user_data['first_name']);?>" class="form-control search_events" placeholder="Name">
							<?php echo form_error('first_name'); ?>
						</div>
					</div>
				</div>
				<div class="clear"></div>
				<div class="col-md-8">
					<div class="row">
						<div class="col-md-4">
							<label for="email" class="search_events">Email<span>*</span></label>
						</div>
						<div class="col-md-8">
							<input type="email" id="email" name="email" value="<?php echo set_value('email',$user_data['email']); ?>" class="form-control search_events" placeholder="Email">
							<?php echo form_error('email'); ?>
						</div>
					</div>
				</div>
				<div class="clear"></div>
				<div class="col-md-8">
					<div class="row">
						<div class="col-md-4">
							<label for="phone" class="search_events">Phone</label>
						</div>
						<div class="col-md-8">
							<input type="text" id="phone" name="phone" class="form-control search_events" value="<?php echo set_value('phone',$user_data['phone_no']); ?>" placeholder="Phone">
							<?php echo form_error('phone'); ?>
						</div>
					</div>
				</div>

				<div class="clear"></div>
				<div class="col-md-8">
					<div class="row">
						<div class="col-md-4">
							<label for="street" class="search_events">Street</label>
						</div>
						<div class="col-md-8">
							<input type="text" id="street" name="street" value="<?php echo set_value('street',$user_data['street_address']); ?>" class="form-control search_events" placeholder="Street">
						</div>
					</div>
				</div>

				<div class="clear"></div>
				<div class="col-md-8">
					<div class="row">
						<div class="col-md-4">
							<label for="suburb" class="search_events">Suburb</label>
						</div>
						<div class="col-md-8">
							<input type="text" id="suburb" name="suburb" value="<?php echo set_value('suburb',$user_data['suburb']); ?>" class="form-control search_events" placeholder="Suburb">
						</div>
					</div>
				</div>

				<div class="clear"></div>
				<div class="col-md-8">
					<div class="row">
						<div class="col-md-4">
							<label for="city" class="search_events">City</label>
						</div>
						<div class="col-md-8">
							<input type="text" id="city" name="city" value="<?php echo set_value('city',$user_data['city']); ?>" class="form-control search_events" placeholder="City">
						</div>
					</div>
				</div>

				<div class="clear"></div>
				<div class="col-md-8">
					<div class="row">
						<div class="col-md-4">
							<label for="postal_code" class="search_events">Postal Code</label>
						</div>
						<div class="col-md-8">
							<input type="text" id="postal_code" name="postal_code" value="<?php echo set_value('postal_code',$user_data['postcode']); ?>" class="form-control search_events" placeholder="Postal Code">
						</div>
					</div>
				</div>

				<div class="clear"></div>
				<div class="col-md-8">
					<div class="row">
						<div class="col-md-4">
							<label class="search_events">Country<span>*</span></label>
						</div>
						<div class="col-md-8">
							<select class="search_events form-control dropdown" id="country" name="country" >
								<option value="New Zealand" <?php echo set_select('country', 'New Zealand', TRUE);?> >New Zealand</option>
                                <option value="Australia" <?php echo set_select('country', 'Australia');?> >Australia</option>
                                <option value="Samoa" <?php echo set_select('country', 'Samoa');?>>Samoa</option>
                                <option value="Niue" <?php echo set_select('country', 'Niue');?>>Niue</option>
                                <option value="Tonga" <?php echo set_select('country', 'Tonga');?>>Tonga</option>
                                <option value="United States" <?php echo set_select('country', 'United States');?>>United States</option>
                                <option value="Sweden" <?php echo set_select('country', 'Sweden');?> >Sweden</option>
                                <option value="Holland" <?php echo set_select('country', 'Holland');?> >Holland</option>
                                <option value="Australia" <?php echo set_select('country', 'Denmark');?> >Denmark</option>
							</select>
						</div>
						<?php echo form_error('country'); ?>
					</div>
				</div>
				<div class="clear"></div>
                <div class="paragraph blue_txt">3.Further Communication</div>
			<!--	<div class="col-md-12">
					<p class="search_events text-left">
						<?php
							//if(!empty($organizer_data)){
							//	echo $organizer_data->charity_overview;
							//}
						?>
					</p>
				</div>
				<br class="clear">-->
				<div class="col-md-6 col-sm-6">
					<input checked="checked" type="checkbox" id="charity_name" name="charity_name" value="1" class="search_events">&nbsp;&nbsp;<label for="charity_name" class="search_events">I am happy to be contacted by
					<?php
						if(!empty($organizer_data)){
							echo $organizer_data->charity_name;
						}
					?></label>
				</div>

				<div class="clear"></div>
				<?php if(!empty($payment_method)){ ?>
                <div class="paragraph  blue_txt">4.Payment Method<span>*</span>
				<div class="clear"></div>
				</div>

				<?php foreach($payment_method as $checkouts){ ?>
					<div class="col-md-12 col-sm-12">
						<input type="radio" id="<?php echo $checkouts['payment_key']?>" name="check_out_method" class="" value="<?php echo $checkouts['payment_key']?>" checked="checked">&nbsp;&nbsp;<label for="<?php echo $checkouts['payment_key']?>"><?php echo $checkouts['payment_method_name']?></label>
					</div>
				<?php } ?>


				<div class="col-md-1" style="margin-right:40px;">
					<button class="search_events add_more_btn" type="submit">Submit</button>
				</div>
				<div class="col-md-1">
					<button onclick="goBack();" type="button" class="search_events add_more_btn">Cancel</button>
				</div>
				<?php } ?>
				</form>
          </div><!--Container-->
        </div>
     </div><!--Content-->

<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
<script>

function goBack() {
    window.history.back();
}

function update_amount(amount){
		document.getElementById("target_amount").value=amount;
	}

	function ShowHideDiv() {
        var chkYes = document.getElementById("chkYes");
        var dvPassport = document.getElementById("dvPassport");
        dvPassport.style.display = chkYes.checked ? "block" : "none";
    }

			(function($,W,D){
    var user_validation = {};
    user_validation.UTIL =
    {
        setupFormValidation: function()
        {
            //form validation rules
            $("#add_donation_form").validate({
                rules: {
                   target_amount: {
                        required: true,
						number:true,
						zero_check:true,
						thousand_check:true,
                    },
					org_name: {
                        required: true,
                    },
					select_salutation: {
                        required: true,
                    },
					email: {
                        required: true,
						email:true,
                    },
					first_name: {
                        required: true,
                    },
					donor_mssg:{
						required:true,
					},
                    phone: {
                        number:true,
                    },
					country: {
                        required: true,
                    },
                },
                messages: {
					target_amount: {
						number: jQuery.validator.format("amount should be between $1 and $1000 .")
					},
					phone: {
						minlength: jQuery.validator.format("phone number should be 10 digit length."),
						maxlength: jQuery.validator.format("phone number should be 10 digit length.")
					}
				},
                submitHandler: function(form) {
                    form.submit();
                }
            });
			jQuery.validator.addMethod("alpha", function(value, element) {
				return this.optional(element) || value == value.match(/^[a-zA-Z]+$/);
			},"Only alphabets are allowed.");

			jQuery.validator.addMethod("zero_check", function(value, element) {
				var count = parseInt(document.getElementById('target_amount').value);
				if(count <= 0){
					return false;
				}else{
					return true;
				}
			}, "Min donation can be $1");

			jQuery.validator.addMethod("thousand_check", function(value, element) {
				var count = document.getElementById('target_amount').value;
				if(count > 1000){
					return false;
				}else{
					return true;
				}
			}, "Max donation can be $1000");


        }
    }
    //when the dom has loaded setup form validation rules
    $(D).ready(function($) {
        user_validation.UTIL.setupFormValidation();
    });
})(jQuery, window, document);




</script>