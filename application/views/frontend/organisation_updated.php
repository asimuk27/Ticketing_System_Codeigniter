<link rel="stylesheet" href="<?php echo $this->config->item('frontend_css_path');?>pages/org_set_up.css" type="text/css" media="all">
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
              <h2>Organiser Sign Up</h2>
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
            <div class="col-md-6 font_special">
				<b>Registration</b>
				<p class="special_p">To register with <b>TicketingSystem</b>, complete and submit the online registration form below.</p>

				Registration checklist:
				<p class="special_p">
				NOTE: Please ensure you have the following information before you begin.
				</p>
				<ul class="ul_class">
					<li>Primary and financial contact person details</li>
					<li>Organisation details including IRD number</li>
					<li>Organisation logo (JPG or GIF image)</li>
					<li>Bank account details for deposits</li>
					<li>Scanned copy of bank statement to verify your account information</li>
					<li>Formatted electronic signature, if approved for Donee status</li>
				</ul>
			</div>
			<div class="clear"></div>
			<div class="col-md-6 fix_margin">
				<h5>Primary Contact (Event Manager)</h5>
			</div>
			<div class="clear"></div>
			<div class="col-md-6">
                <label for="title">Position Title<span>*</span></label>
                <input type="text" class="search_events form-control" placeholder="Position Title" name="title" id="title" value="<?php echo set_value('title');?>">
                <?php echo form_error('title'); ?>
            </div>
            <div class="clear"></div>
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
            <div class="clear"></div>
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

           <div class="clear"></div>
           <div class="col-md-6">
            <label for="preferred_name">Preferred Name</label>
            <input type="text" id="preferred_name" name="preferred_name" class="search_events form-control" placeholder="Preferred Name" value="">
        </div>

        <div class="clear"></div>
        <div class="col-md-6">
            <label for="email">Email<span>*</span>(This email will be registered against the organisation and can only be used for management of organisation)</label>
            <input type="text" id="email" name="email" placeholder="Email" class="search_events form-control" value="<?php echo set_value('email');?>">
            <?php echo form_error('email'); ?>
        </div>
        <div class="clear"></div>

        <div class="col-md-6">
            <label for="phone">Contact Number</label>
            <input type="text" id="phone" name="phone" class="search_events form-control" placeholder="Phone" value="<?php echo set_value('phone');?>">

        </div>
        <div class="clear"></div>
        <div class="col-md-6">
            <label for="fax">Fax</label>
            <input type="text" class="search_events form-control" placeholder="Fax" value="<?php echo set_value('fax');?>" id="fax" name="fax">
        </div>
    </div>
    <div class="row">
      <div class="col-md-6 fix_margin">
         <h5>Organisation Details</h5>
     </div>
     <div class="clear"></div>
     <div class="col-md-6">
        <label for="organisation_name">Organisation Name<span>*</span></label>
        <input type="text" placeholder="Organisation Name" name="organisation_name" id="organisation_name" class="search_events form-control" placeholder="" value="<?php echo set_value('organisation_name');?>">
        <?php echo form_error('organisation_name'); ?>
    </div>
    <div class="clear"></div>
    <div class="col-md-6">
        <label for="ird">IRD Number</label>
        <input type="text" name="ird" id="ird" class="search_events form-control" placeholder="IRD Number">
    </div>

    <div class="clear"></div>
    <div class="col-md-6">
        <label for="organization_nature">Organisation Type</label><span>*</span>
        <!-- <input type="text" name="organization_nature" id="organization_nature" class="search_events form-control" placeholder="Organization Nature" value="<?php //echo set_value('charity_name');?>"> -->
        <select class="search_events form-control dropdown" name="organization_nature" id="organization_nature">
                <option value="">-- Please Select --</option>
               <?php foreach($get_organisation_type as $org_type){ ?>
                <option value="<?php echo $org_type['key_name']; ?>"><?php echo $org_type['name']; ?></option>
               <?php } ?>
        </select>

    </div>

    <div class="clear"></div>
    <div class="col-md-6">
        <label for="donee_status">Are you approved for the donee status under the Income Tax Act 2007 ?</label>
        <select class="search_events form-control dropdown" id="donee_status" name="donee_status">
            <option value="">-- Please Select --</option>
            <option value="1">Yes</option>
            <option value="0">No</option>
        </select>
    </div>

    <div class="clear"></div>
    <div class="col-md-6">
        <label for="charities_commission">Do you hold a registration with the Charities Commission ?</label>
        <select class="search_events form-control dropdown" id="charities_commission" name="charities_commission">
            <option value="">-- Please Select --</option>
            <option value="1">Yes</option>
            <option value="0">No</option>
        </select>
    </div>

    <div class="clear"></div>
    <div class="col-md-6">
        <label for="registration_number">If Yes, What is your registration number ? If No,leave this field blank. </label>
        <input type="text" name="registration_number" id="registration_number" class="form-control search_events" placeholder="Registration Number" value="">

    </div>

    <div class="clear"></div>
    <div class="col-md-6">
        <label for="charity_name">Preferred Organisation name.<span>*</span></label>
        <input type="text" name="charity_name" id="charity_name" class="search_events form-control" placeholder="Preferred Organisation Name" value="<?php echo set_value('charity_name');?>">
        <?php echo form_error('charity_name'); ?>
    </div>
    <div class="clear"></div>
    <div class="col-md-6">
        <label for="charity_overview">Overview</label>
        <textarea class="search_events form-control" name="charity_overview" id="charity_overview" placeholder="Overview"></textarea>
    </div>
    <div class="clear"></div>
    <div class="col-md-12">
        <label>Choose which areas your organisation is involved in.</label>
        <div class="row">
            <div class="col-md-2 col-sm-3">
                <input type="checkbox" value="1" name="areas[]"><label class="chkbox_space">Aged Care</label>
            </div>
            <div class="col-md-2 col-sm-3">
                <input type="checkbox" value="2" name="areas[]"><label class="chkbox_space">HIV and AIDS</label>
            </div>
            <div class="col-md-2 col-sm-3">
                <input type="checkbox" value="3" name="areas[]"><label class="chkbox_space">Prenatal and infants</label>
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
                <input type="checkbox" value="8" name="areas[]"><label class="chkbox_space">Education</label>
            </div>
            <div class="col-md-2 col-sm-3">
                <input type="checkbox" value="9" name="areas[]"><label class="chkbox_space">Religion</label>
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
                <input type="checkbox" value="16" name="areas[]"><label class="chkbox_space">Animal Welfare</label>
            </div>
			<div class="col-md-2 col-sm-3">
                <input type="checkbox" value="15" name="areas[]"><label class="chkbox_space">Other</label>
            </div>
        </div>
    </div>
    <div class="clear"></div>
    <div class="col-md-6">
        <label for="logo" style="margin-bottom:15px;">Logo<span>*</span> <b>(Max size 500kb)</b></label>
        <div class="search_events input-group">
            <label class="input-group-btn">
                <span class="btn btn-primary browse_btn">
                    Browse&hellip; <input type="file" name="logo" id="logo" class="browse_txt_box" style="display: none;">
                </span>
            </label>
            <input type="text" id="logo_name" name="logo_name" class="search_events" placeholder="" readonly>
        </div>
        <?php echo form_error('logo'); ?>
    </div>
    <div class="clear" style="display:none;" id="extra_space_logo"></div>
    <div class="col-md-6" style="margin-bottom:10px;">
     <label id="logo_error"></label>
     <img id="blah" src="#" alt="" style="display:none;"/>
 </div>
 <div class="clear"></div>
 <div class="col-md-6">
    <h5>Registered Address</h5>
</div>
<div class="clear"></div>

<div class="col-md-6">
    <label for="street_address">Street Address<span>*</span></label>
    <input type="text" id="street_address" name="street_address" class="search_events form-control" placeholder="Street Address" value="<?php echo set_value('street_address');?>">
    <?php echo form_error('street_address'); ?>
</div>
<div class="clear"></div>
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
<div class="clear"></div>
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

<div class="clear"></div>
<div class="col-md-6">
    <h5>Financial Contact</h5>
</div>
<div class="clear"></div>
<div class="col-md-6">
    <label for="finance_position">Finance Officer Position<span>*</span></label>
    <input type="text" class="search_events form-control" placeholder="Position" id="finance_position" name="finance_position" value="<?php echo set_value('finance_position');?>">
    <?php echo form_error('finance_position'); ?>
</div>
<div class="clear"></div>
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
<div class="clear"></div>
<div class="col-md-6">
    <label for="finance_email">Email<span>*</span></label>
    <input type="text" id="finance_email" name="finance_email" type="text" class="search_events form-control" placeholder="Email" value="<?php echo set_value('finance_email');?>">
    <?php echo form_error('finance_email'); ?>
</div>
<div class="clear"></div>
<div class="col-md-6">
    <label for="finance_phone">Contact Number</label>
    <input type="text" name="finance_phone" id="finance_phone" type="text" class="search_events form-control" placeholder="Phone" value="<?php echo set_value('finance_phone');?>">
</div>
<div class="clear"></div>
<div class="col-md-6">
    <label for="finance_fax">Fax</label>
    <input type="text" placeholder="Fax" name="finance_fax" id="finance_fax" value="<?php echo set_value('finance_fax');?>" class="form-control">
</div>


<div class="clear"></div>
<div class="col-md-6">
    <h5>Bank Details (for the settlement of funds received)</h5>
</div>
<div class="clear"></div>
<div class="col-md-6">
    <label for="bank_name">Bank Name<span>*</span></label>
    <input type="text" name="bank_name" id="bank_name" type="text" class="form-control" placeholder="Bank Name" value="<?php echo set_value('bank_name');?>">
    <?php echo form_error('bank_name'); ?>
</div>
<div class="clear"></div>
<div class="col-md-6">
    <label for="bank_details">Banking Account Number<span>*</span></label>
    <input type="text" name="bank_details" id="bank_details" type="text" class="form-control" placeholder="Account Number" value="<?php echo set_value('bank_details');?>">
    <?php echo form_error('bank_details'); ?>
</div>
<div class="clear"></div>
<div class="col-md-6">
    <label for="bank_statement">Attach your Bank Statement<span>*</span></label>

    <div class="search_events input-group">

        <label class="input-group-btn">

            <span class="btn btn-primary browse_btn" data-toggle="popover" data-content="To verify your bank account, attach a copy of your donation bank account details on the bank statement. Confidential and financial information can be covered up.">

                Browse&hellip; <input type="file" id="bank_statement" name="bank_statement" class="browse_txt_box" style="display: none;">

            </span>
        </label>
        <input type="text" id="ste" name="ste" placeholder="" readonly>
    </div>
    <?php echo form_error('bank_statement'); ?>
</div>
<div class="clear"></div>
<div class="col-md-6 col-sm-6 col-xs-12">
 <p id="true" style="display:none;">Successfully attached</p>
 <p id="false" style="display:none;">Not a valid file. Only pdf and Image are allowed.</p>
</div>



<div class="clear"></div>
<div class="col-md-6">
    <h5>Bank Details (for payments to TicketingSystem & POLi)</h5>
</div>
<div class="clear"></div>
<div class="col-md-6">
   <input type="checkbox" name="bank_details_for_ticket_suit" id="bank_details_for_ticket_suit" value="0">&nbsp;&nbsp;&nbsp;<label>Same as above</label>
</div>

<div class="clear"></div>
<div  id="ticket_suit_bank_details">
    <div class="col-md-6">
        <label for="bank_name_for_ts">Bank Name<span>*</span></label>
        <input type="text" name="bank_name_for_ts" id="bank_name_for_ts" type="text" class="form-control" placeholder="Bank Name" value="<?php echo set_value('bank_name_for_ts');?>">
        <?php echo form_error('bank_name_for_ts'); ?>
        <div class="err_ts_one" style="color:red"></div>
    </div>
    <div class="clear"></div>
    <div class="col-md-6">
        <label for="bank_account_no_for_ts">Banking Account Number<span>*</span></label>
        <input type="text" name="bank_account_no_for_ts" id="bank_account_no_for_ts" type="text" class="form-control" placeholder="Account Number" value="<?php echo set_value('bank_account_no_for_ts');?>">
        <?php echo form_error('bank_account_no_for_ts'); ?>
        <div class="err_ts_two" style="color:red"></div>
    </div>
    <div class="clear"></div>
    <div class="col-md-6">
        <label for="bank_attachment_for_ts">Attach your Bank Statement<span>*</span></label>

        <div class="search_events input-group">

            <label class="input-group-btn">

                <span class="btn btn-primary browse_btn" data-toggle="popover" data-content="To verify your bank account, attach a copy of your donation bank account details on the bank statement. Confidential and financial information can be covered up.">

                    Browse&hellip; <input type="file" id="bank_attachment_for_ts" name="bank_attachment_for_ts" class="browse_txt_box" style="display: none;">

                </span>
            </label>
            <input type="text" id="ste2" name="ste2" placeholder="" readonly>
        </div>
        <?php echo form_error('bank_attachment_for_ts'); ?>
        <div class="err_ts_three" style="color:red"></div>

    </div>
    <div class="clear"></div>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <p id="true_ts" style="display:none; color:green">Successfully attached</p>
        <p id="false_ts" style="display:none;">Not a valid file. Only pdf and Image are allowed.</p>
    </div>

</div>



<div class="clear"></div>
<div class="col-md-6">
 <h5>Receipt Details</h5>
</div>
<div class="clear"></div>
<div class="col-md-6">
    <label for="recpt_txt">Receipt Text</label>
    <textarea class="search_events form-control" class="form-control" id="recpt_txt" name="recpt_txt" placeholder="Receipt Text"><?php echo set_value('recpt_txt');?></textarea>
</div>
<div class="clear"></div>
<div class="col-md-6">
    <label for="sig_txt">Signature Text</label>
    <textarea class="search_events form-control" class="form-control" id="sig_txt" name="sig_txt" placeholder="Signature Text"><?php echo set_value('sig_txt');?></textarea>
</div>
<div class="clear"></div>
<div class="col-md-6">
    <label for="bank_signature">Attach your Electronic Signature<span>*</span>(This is the signature that would appear on the receipt sent by the system.)</label>
    <div class="search_events input-group">
        <label class="input-group-btn">
            <span class="btn btn-primary browse_btn" data-toggle="popover" data-content=" If you are approved for Donee status under the Income Tax Act 2007, please upload a JPG or GIF formatted electronic signature for an officer authorised to accept donations, to be signatory on receipts.">
                Browse&hellip; <input type="file" id="bank_signature" name="bank_signature" class="browse_txt_box" style="display: none;">
            </span>
        </label>
        <input type="text" id="sing_name" name="sing_name"  placeholder="" readonly>
    </div>
    <?php echo form_error('bank_signature'); ?>
</div>

<div class="clear" style="display:none;" id="space_logo"></div>
<div class="col-md-6" style="margin-bottom:10px;">
 <img id="bank_signature_preview" src="#" alt="" style="display:none;" height="200"/>
</div>
<div class="clear"></div>


    <div class="col-md-6">
        <label for="plan_select">The 12 month plan I am seeking is :<span>*</span></label>
        <select class="search_events form-control dropdown" id="plan_select" name="plan_select">
            <option value="">-- Please Select --</option>
            <option value="1">Standard Suite Plan – 1.5% fee per transaction</option>
            <option value="2">Deluxe Suite Plan – 4% fee per transaction</option>
        </select>
    </div>
 <div class="clear"></div>
<div class="col-md-6">
   <input type="checkbox" name='tc' id="eve_tc" value="1" onclick="return false">&nbsp;&nbsp;&nbsp;<a class="search_events common_check" data-toggle="modal" data-target="#myModal" style="cursor:pointer">Event Manager and TicketingSystem Terms and Conditions</a>
<div class="tc_err" style="color:red">

</div>
</div>

<div class="clear"></div>

<div class="col-md-6">
   <input type="checkbox" name='poli_tc' id="poli_tc" value="1" onclick="return false">&nbsp;&nbsp;&nbsp;<a class="search_events common_check" data-toggle="modal" data-target="#myModal" style="cursor:pointer">POLi  Terms & Conditions</a>
   <div class="poli_tc_err" style="color:red">

   </div>
</div>

<div class="clear"></div>

<div class="col-md-6">
   <input type="checkbox" name='direct_debit_tc' id="direct_debit_tc" value="1" onclick="return false" >&nbsp;&nbsp;&nbsp;<a class="search_events common_check" data-toggle="modal" data-target="#myModal" style="cursor:pointer">TicketingSystem Direct Debit Authority</a>
   <div class="direct_debit_tc_err" style="color:red">

  </div>
</div>
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
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
<?php $email_url = $this->config->item('base_url')."index.php/frontend/registration/email_unique_check";?>
<?php $charity_check_url = $this->config->item('base_url')."index.php/frontend/registration/charity_name_unique_check";?>
<script>
count=0;






 $(document).ready(function(){

       $('form').submit(function(e){
        count=0;
        $('.err_ts_one').text('');
        $('.err_ts_two').text('');
        $('.err_ts_three').text('');
        $('.tc_err').text('');
        $('.poli_tc_err').text('');
         $('.direct_debit_tc_err').text('');

        if($('#tc').prop('checked')==false){
           $('.tc_err').text('field is required');
           count++;
         }

       if($('#poli_tc').prop('checked')==false){
           $('.poli_tc_err').text('field is required');
           count++;
        }

        if($('#direct_debit_tc').prop('checked')==false){
           $('.direct_debit_tc_err').text('field is required');
           count++;
        }


        if($('#bank_details_for_ticket_suit').is(':checked')){

        }
        else{

           var bank_name_for_ts = $('#bank_name_for_ts').val();
           var bank_account_no_for_ts = $('#bank_account_no_for_ts').val();
           var bank_attachment_for_ts = $('#bank_attachment_for_ts').val();

        if(bank_attachment_for_ts==''){
            $('.err_ts_one').text('field is required');
            count++;
        }
        if(bank_account_no_for_ts==''){
            $('.err_ts_two').text('field is required');
            count++;
        }
        if(bank_account_no_for_ts==''){
            $('.err_ts_three').text('field is required');
            count++;
        }



     }

        if(count>0){
            $('form').submit(false);
        }

});

   });






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
                    organization_nature: {
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
        plan_select: {
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

  },
  submitHandler: function(form) {
     if(count>0){
        $('form').submit(false);
     }else{
       form.submit();
     }

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


$("#bank_attachment_for_ts").change(function(){
  //  readURL(this);
  var fileExtension = ['pdf','jpg','jpeg','JPEG','Jpeg'];
  if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                    //alert("Only '.csv','.pdf' formats are allowed.");
                    document.getElementById('false').style.display= '';
                    document.getElementById('true').style.display= 'none';

                }
                else
                {
                    document.getElementById('true_ts').style.display='';
                    document.getElementById('false_ts').style.display= 'none';
                }
            });







        </script>

        <!-- Modal -->
        <div id="myModal" class="modal fade" role="dialog">
          <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title hr_header">&nbsp;</h4>
            </div>
            <div class="modal-body">
             <div style="width:100%; height:300px; overflow: auto;" class="body_info">

            </div>

        </div>
        <div class="modal-footer">
          <div  style="float:left">
           <input type="checkbox" name='modal_tc' id="modal_tc" value="" required="required">&nbsp;&nbsp;&nbsp;<label for="modal_tc" class="search_events">I Agree</label>
       </div>

       <button type="button" class="btn btn-default" data-dismiss="modal" id="modal_dimiss">Close</button>
   </div>
</div>

</div>
</div>




<script>
    var store_common_check="";
    $(document).ready(function(){

        $('.common_check').click(function(){
         var x = $(this).prev().attr('id');
         store_common_check=x;

         if($('#'+x).is(':checked')){
           $('#modal_tc').prop('checked', true);
       }
       else{
           $('#modal_tc').prop('checked', false);
       }



   });

        $('#modal_tc').click(function(){

            if($('#modal_tc').is(':checked')){
				  $('#myModal').modal('hide');
               $('#'+store_common_check).prop('checked', true);
           }else{
               $('#'+store_common_check).prop('checked', false);
           }


       });

        $('#modal_dimiss').click(function(){
         store_common_check="";

     });

        $('#bank_details_for_ticket_suit').click(function(){

         if($(this).is(':checked')){
           $('#ticket_suit_bank_details').slideUp();
       }else{
           $('#ticket_suit_bank_details').slideDown();
       }

   });

    });
</script>


<script>
    $(document).ready(function(){

     $('.common_check').click(function(){
      var key = $(this).prev().attr('id');

      $.ajax({
        type: "post",
        url: "<?php echo base_url(); ?>index.php/frontend/organiser/get_terms_and_conditions/"+key,
        cache: false,
        success: function(json){

            var obj = jQuery.parseJSON(json);

             $.each(obj, function(key,value) {
                $('.hr_header').text(value.header);
                $('.body_info').html(value.description);
             });

       }
   }

);




  });

 $('#bank_details_for_ticket_suit').click(function(){

          if($('#bank_details_for_ticket_suit').is(':checked')){
                $(this).val('1');
          }else{
                $(this).val('0');
          }

 });

 $('#organisation_name').keyup(function(){
      var name = $(this).val();
      $('#charity_name').val(name);

 });

 });

</script>





