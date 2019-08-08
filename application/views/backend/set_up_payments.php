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
	.search_events {
    font-family: "Montserrat",sans-serif;
    font-size: 14px;
}.submit_btn {
    background: #00a4ef none repeat scroll 0 0;
    border: medium none;
    color: #fff;
    display: inline-block;
    float: left;
    margin-bottom: 15px;
    padding: 13px 29px;
    text-decoration: none;
}
	.error{
		color:red;
	}
     .respose_style
    {
        padding:20px;
        color: #fff;
        background-color: #5cb85c;
        border-color: #4cae4c;
        font-weight:bold;
    }
</style>
<script>
	$(function(){
	  var hash = window.location.hash;
	  hash && $('ul.nav a[href="' + hash + '"]').tab('show');

	  $('.nav-tabs a').click(function (e) {
		$(this).tab('show');
		var scrollmem = $('body').scrollTop() || $('html').scrollTop();
		window.location.hash = this.hash;
		$('html,body').scrollTop(scrollmem);
	  });
	});
</script>

 <div id="page-wrapper">
          <div class="container-fluid">
              <div class="row">
                 <div class="col-md-12">
						<div class="right_first_box"><img src="<?php echo $this->config->item('admin_image_path');?>home.png" width="21" height="19"><a href="#">Home</a> > <a href="#">Setup Payment Connection</a> </div>
                 </div>
               </div>
               <br class="clear">

				<?php if($this->session->flashdata('msg')): ?>
				<div class="row">
				<div class="col-md-12">
					<div class="col-md-6 respose_style"><?php echo $this->session->flashdata('msg'); ?></div>
				</div>
				</div>
				<br class="clear">
			<?php endif; ?>


       <div class="row">
    <div class="col-md-12">


      <ul class="nav nav-tabs responsive-tabs">

                <li role="presentation" class="active"><a href="#cc"  role="tab" data-toggle="tab">CC</a></li>            	<li role="presentation"><a href="#dyanamic"  role="tab" data-toggle="tab">UnionPay</a></li>                <li role="presentation"><a href="#poli" role="tab" data-toggle="tab">POLi</a></li>

      </ul>

	  <div class="tab-content">
              <div role="tabpanel" class="tab-pane" id="dyanamic">
                  <div class="row">                    <form role="form" method="post" action="" id="dynamic_form" enctype="multipart/form-data">
                      <div class="row">
                        <div class="col-lg-8 col-md-10">

                          <div class="row">
                            <div class="col-lg-4 col-md-5"><label>Merchant ID<span class="mandatory">*</span></label></div>
                            <div class="col-lg-6 col-md-7">
                              <input class="inp" type="text" id="merchant_id" name="merchant_id" value="<?php echo $data_result_dynamic_payment['merchant_id'];?>">
                              <?php echo form_error("merchant_id");?>
                            </div>
                          </div>
                          <br class="clear">
                          <div class="row buttons">
                            <div class="col-lg-2 col-lg-offset-4 col-md-2 col-md-offset-5 col-sm-2 col-xs-4">
                               <button class="submit_btn search_events" type="button">Save</button>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
                              <button type="button" class="submit_btn search_events" onclick="window.history.back();">Cancel</button>
                            </div>
                          </div>
                        </div><!--content col end-->
                      </div>
                   </form>

                 </div>


                  </div>
                <div role="tabpanel" class="tab-pane active" id="cc">                  <form action="<?php echo base_url(); ?>index.php/backend/payment/cc_payment_method" method="post" id="cc_form">
                 <?php if(!empty($get_organiser_settings)){?>
                 <input type="hidden" name="" value="<?php echo $get_organiser_settings[0]['payment_key']; ?>" id="payment_mtd"/>
                 <?php } ?>
               <div class="row">
                 <div class="col-lg-8 col-md-10">

                   <div class="row">
                     <div class="col-lg-4 col-md-5">
                       <input type="radio" id="cc_dps" name="pay_type" value="1" <?php if((isset( $dps_data[0]['status'])) && $dps_data[0]['status']==1){ echo "checked"; }else{ echo ""; }?>><label class="chkbox_space" for="cc_dps">DPS</label>
                     </div>
                   </div>
                   <div class="row">
                     <div class="col-lg-4 col-md-5"><label>PxPayUserId<span class="mandatory">*</span></label></div>
                   <div class="col-lg-6 col-md-7">
                         <?php if(!empty($dps_data)){ ?>
                       <input type="text" id="pax_pay_userid" name="pax_pay_userid" value="<?php echo $dps_data[0]['pxpayuserid'];?>" class="inp cc_mer_id">
                       <?php }else{ ?>
                         <input type="text" id="pax_pay_userid" name="pax_pay_userid" value="" class="inp cc_mer_id">
                       <?php } ?>
                       <?php echo form_error("pxpayuserid");?>
                       <div class="pax_pay_userid_err" style="color:red"></div>
                     </div>
                   </div>
                   <div class="row">
                     <div class="col-lg-4 col-md-5"><label >PxPayKey</label><span class="mandatory">*</span></div>
                     <div class="col-lg-6 col-md-7">
                                       <?php if(!empty($dps_data)){ ?>
                     <input type="text" id="pax_pay_key" name="pax_pay_key" value="<?php echo $dps_data[0]['pxpaykey'];?>" class="inp cc_mcc">
                                      <?php }else{ ?>
                                      <input type="text" id="pax_pay_key" name="pax_pay_key" value="" class="inp cc_mcc">
                                      <?php } ?>
                     <?php echo form_error("mcc");?>
                                          <div class="pax_pay_key_err" style="color:red"></div>
                     </div>
                   </div>
                   <hr>
                   <div class="row">
                     <div class="col-lg-4 col-md-5">
                       <input type="radio" name="pay_type" id="cc_flo2cash" value="2"  <?php if((isset( $dps_data[0]['status'])) && $dps_flo2[0]['status']==1){ echo "checked"; }else{ echo ""; }?>><label class="chkbox_space" for="cc_flo2cash">Flo2Cash</label>
                     </div>
                   </div>
                   <div class="row">
                     <div class="col-lg-4 col-md-5"><label>Flo2Cash Account ID<span class="mandatory">*</span></label></div>
                     <div class="col-lg-6 col-md-7">
                      <?php if(!empty($dps_flo2)){ ?>
                       <input type="text" id="flo_acc_id" name="flo_acc_id" value="<?php echo $dps_flo2[0]['account_id'];?>" class="inp flo_mer">
                       <?php }else{ ?>
                        <input type="text" id="flo_acc_id" name="flo_acc_id" value="" class="inp flo_mer">
                       <?php } ?>
                       <?php echo form_error("merchant_id");?>
                       <div class="flo_acc_id_err" style="color:red"></div>
                     </div>

                   </div>

               <hr>
               <div class="dynamic_err" style="text-align: center; color:red;"></div>

               <div class="row buttons">



                 <div class="col-lg-2 col-lg-offset-4 col-md-2 col-md-offset-5 col-sm-2 col-xs-4">

                    <button class="submit_btn search_events" >Save</button>
                 </div>
                 <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
                   <button type="button" class="submit_btn search_events" onclick="window.history.back();">Cancel</button>
                 </div>
               </div>
               </div>
               </div>
               </form>
                  </div>
                  <div role="tabpanel" class="tab-pane" id="dps">
				  <form role="form" method="post" action="<?php echo base_url();?>index.php/backend/payment/dps_payment_method" id="dps_form" enctype="multipart/form-data">
                  <div class="row">
          <div class="col-lg-8 col-md-10">
                <div class="row">
                <div class="col-lg-4 col-md-5"><label>PxPayUserId</label><span class="mandatory">*</span></div>
                <div class="col-lg-6 col-md-7"><input type="text" class="inp" id="pxpayuserid" name="pxpayuserid" value="<?php echo $data_result_dps['pxpayuserid'];?>"><?php echo form_error("pxpayuserid");?></div>
                </div>
                 <div class="row">
                <div class="col-lg-4 col-md-5"><label >PxPayKey</label><span class="mandatory">*</span></div>
                <div class="col-lg-6 col-md-7 "><input type="text"  class="inp" id="pxpaykey" name="pxpaykey" value="<?php echo $data_result_dps['pxpaykey'];?>"><?php echo form_error("pxpaykey");?></div>
                </div>
                 <div class="row">
                <div class="col-lg-4 col-md-5"><label >PxPayUrl</label><span class="mandatory">*</span></div>
                <div class="col-lg-6 col-md-7"><input type="text"  value="<?php echo $data_result_dps['pxpaykey'];?>" class="inp" id="pxpayurl" name="pxpayurl"><?php echo form_error("paypayurl");?></div>
                </div>
                 <div class="row">
                <div class="col-lg-4 col-md-5"><label>Transaction Type</label><span class="mandatory">*</span></div>
                <div class="col-lg-6 col-md-7"><input type="text" value="<?php echo $data_result_dps['transaction_type'];?>"  class="inp" id="transaction_type_dps" name="transaction_type_dps"><?php echo form_error("transaction_type_dps");?></div>
                </div>
                 <div class="row">
                <div class="col-lg-4 col-md-5"><label >Transaction Currency</label><span class="mandatory">*</span></div>
                <div class="col-lg-6 col-md-7"><input type="text"  class="inp" id="transaction_currency_dps" value="<?php echo $data_result_dps['currency'];?>" name="transaction_currency_dps"><?php echo form_error("transaction_currency_dps");?></div>
                </div>
                 <div class="row">
                <div class="col-lg-4 col-md-5"><label >Email</label><span class="mandatory">*</span></div>
                <div class="col-lg-6 col-md-7"><input type="text" class="inp" id="email" value="<?php echo $data_result_dps['email'];?>" name="email"><?php echo form_error("email");?></div>
                </div>
                 <!--<div class="row">
                <div class="col-lg-4 col-md-5"><label >Success URL </label><span class="mandatory">*</span></div>
                <div class="col-lg-6 col-md-7"><input type="text" class="inp" ></div>
                </div>-->
                 <!--<div class="row">
                <div class="col-lg-4 col-md-5"><label >Failure URL</label><span class="mandatory">*</span></div>
                <div class="col-lg-6 col-md-7"><input type="text"  class="inp"></div>
                </div>-->

                <div class="row">
                <div class="col-lg-4 col-md-5 col-sm-7 col-xs-8"><label>Supported Cards</label></div>
                <div class="col-lg-7 col-md-7 col-sm-4 col-xs-4">
                <div class="row check_box">
                <div class="col-md-4"><input type="checkbox" name="dps_visa" id="dps_visa" value="1" <?php if($data_result_dps['visa'] == "1"){ echo "checked=checked";}?>><label class="chkbox_space">Visa</label></div>
				<div class="col-md-4"><input type="checkbox" name="dps_american_express" id="1" value="dps_american_express" <?php if($data_result_dps['american_express'] == "1"){ echo "checked=checked";}?>><label class="chkbox_space">AmeExp</label></div>
				<div class="col-md-4"><input type="checkbox" name="dps_dinner_club" id="dps_dinner_club" value="1" <?php if($data_result_dps['dinner_club'] == "1"){ echo "checked=checked";}?>><label class="chkbox_space">DinClub</label></div>
                </div>
                </div>
                </div>
               <br class="clear">
                <div class="row buttons">
                       <div class="col-lg-2 col-lg-offset-4 col-md-2 col-md-offset-5 col-sm-2 col-xs-4">
                      <button class="submit_btn search_events">Save</button>
                       </div>
                       <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
                       <div type="button" class="submit_btn search_events" onclick="window.history.back();">Cancel</div>
                       </div>
                </div>
          </div><!--content col end-->
          </form>          </div>


                 </div>
                  <div role="tabpanel" class="tab-pane" id="poli">                    <form role="form" method="post" action="<?php echo base_url(); ?>index.php/backend/payment/poli_payment_method" id="poli_form" enctype="multipart/form-data">            <div class="row">                  <div class="col-lg-8 col-md-10">            <div class="row">                    <div class="col-lg-4 col-md-5"><label >Poli Account ID</label><span class="mandatory">*</span></div>                    <div class="col-lg-6 col-md-7"><input class="inp" type="text" id="poli_account_id" name="poli_account_id" value="<?php echo $data_result_poli['account_id'];?>"><?php echo form_error("poli_account_id");?></div>                    </div>                     <div class="row">                    <div class="col-lg-4 col-md-5"><label >Poli Password</label><span class="mandatory">*</span></div>                    <div class="col-lg-6 col-md-7"><input class="inp" type="text" id="poli_password" name="poli_password" value="<?php echo $data_result_poli['password'];?>"><?php echo form_error("poli_password");?></div>                    </div>                    <br class="clear">                    <div class="row buttons">                           <div class="col-lg-2 col-lg-offset-4 col-md-2 col-md-offset-5 col-sm-2 col-xs-4">                           <button class="submit_btn search_events" type="submit">Save</button>                           </div>                           <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">                           <div class="submit_btn search_events" onclick="window.history.back();">Cancel</div>                           </div>                    </div>                     </div></div>            </form>                  </div>



		  <div role="tabpanel" class="tab-pane" id="alipay">
                 <form role="form" method="post" action="<?php echo base_url(); ?>index.php/backend/payment/alipay_payment_method" id="alipay_form" enctype="multipart/form-data">
                 <div class="row">
                <div class="col-lg-8 col-md-10">
                <div class="row">
                <div class="col-lg-4 col-md-5"><label >Service Name</label><span class="mandatory">*</span></div>
                <div class="col-lg-6 col-md-7"><input type="text" value="<?php echo $data_result_alipay['service'];?>" class="inp" name="service_name" id="service_name"><?php echo form_error("service_name");?></div>
                </div>
                 <div class="row">
                <div class="col-lg-4 col-md-5"><label >Alipay Partner ID</label><span class="mandatory">*</span></div>
                <div class="col-lg-6 col-md-7"><input type="text" class="inp" name="alipay_partner_id" id="alipay_partner_id" value="<?php echo $data_result_alipay['alipay_partner_id'];?>"><?php echo form_error("alipay_partner_id");?></div>
                </div>
                 <div class="row">
                <div class="col-lg-4 col-md-5"><label >Alipay Partner Key</label><span class="mandatory">*</span></div>
                <div class="col-lg-6 col-md-7"><input type="text"  class="inp" name="alipay_partner_key" id="alipay_partner_key" value="<?php echo $data_result_alipay['alipay_partner_key'];?>"><?php echo form_error("alipay_partner_key");?></div>
                </div>
                <div class="row">
                <div class="col-lg-4 col-md-5"><label >Character set on merchant website</label><span class="mandatory">*</span></div>
                <div class="col-lg-6 col-md-7">
					<select class="form-control dropdown search_events" name="character_set" id="character_set">
						<option value="utf-8" <?php if($data_result_alipay['character_set'] == "utf-8"){ echo "selected";}else{ echo "";}?>>utf-8</option>

						<option value="gbk" <?php if($data_result_alipay['character_set'] == "gbk"){ echo "selected";}else{ echo "";}?>>gbk</option>

						<option value="gb2312" <?php if($data_result_alipay['character_set'] == "gb2312"){ echo "selected";}else{ echo "";}?>>gb2312</option>
					</select>
					<?php echo form_error("character_set");?>
				</div>
                </div>
                 <div class="row">
                <div class="col-lg-4 col-md-5"><label >Transaction currency</label><span class="mandatory">*</span></div>
                <div class="col-lg-6 col-md-7"><input type="text" class="inp" name="alipay_currency" id="alipay_currency" value="<?php echo $data_result_alipay['currency'];?>">
				<?php echo form_error("alipay_currency");?></div>
                </div>
                 <div class="row">
                <div class="col-lg-4 col-md-5"><label >Return URL</label><span class="mandatory">*</span></div>
                <div class="col-lg-6 col-md-7"><input type="text" class="inp" name="alipay_return_url" id="alipay_return_url" value="<?php echo $data_result_alipay['return_url'];?>"><?php echo form_error("alipay_return_url");?></div>
                </div>
                 <div class="row">
                <div class="col-lg-4 col-md-5"><label >Notification URL</label><span class="mandatory">*</span></div>
                <div class="col-lg-6 col-md-7"><input type="text" class="inp" name="alipay_notification_url" id="alipay_notification_url" value="<?php echo $data_result_alipay['notification_url'];?>"><?php echo form_error("alipay_notification_url");?></div>
                </div>
                 <div class="row">
                <div class="col-lg-4 col-md-5"><label>Order valid time</label><span class="mandatory">*</span></div>
                <div class="col-lg-6 col-md-7"><input type="text" class="inp" name="alipay_order_time" id="alipay_order_time" value="<?php echo $data_result_alipay['order_valid_time'];?>"><?php echo form_error("alipay_order_time");?></div>
                </div>
                <div class="row">
                <div class="col-lg-4 col-md-5 col-sm-7 col-xs-12"><label>Active Payment Method</label></div>
                <div class="col-lg-7 col-md-7 col-sm-5 col-xs-12">
                <div class="row check_box">
                <div class="col-md-5"><input type="checkbox" name="alipay_pay_method" id="alipay_pay_method" value="1" <?php if($data_result_alipay['supported_method'] == "1"){ echo "checked=checked";}?>>
				<label class="chkbox_space">Alipay</label></div>
                </div>
                </div>
                </div>
                <br class="clear">
                <div class="row buttons">
                       <div class="col-lg-2 col-lg-offset-4 col-md-2 col-md-offset-5 col-sm-2 col-xs-4">
                         <button type="submit" class="submit_btn search_events">Save</button>
                       </div>
                       <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
                      <div type="button" class="submit_btn search_events" onclick="window.history.back();">Cancel</div>
                       </div>
                </div>
                </div></div></form>
          </div>

          </div><!--content col end-->

    </div>
  </div>



              </div><!--Container-fluid end-->
           </div><!--Page-wrapper-->
     <script src="<?php echo $this->config->item('admin_js_path');?>jquery.validate.min.js"></script>
<script>
(function($,W,D){
    var user_validation = {};
    user_validation.UTIL =
    {
        setupFormValidation: function()
        {
            //form validation rules
            $("#alipay_form").validate({
                rules: {
					service_name: {
                        required: true,
                    },
					alipay_partner_id: {
                        required: true,
                    },
					alipay_partner_key: {
                        required: true,
                    },
					character_set: {
                        required: true,
                    },
					alipay_currency: {
                        required: true,
                    },
                     alipay_return_url: {
                        required:true,
                    },
					alipay_notification_url:{
						required:true,
					},
					alipay_order_time :{
						required:true,
					}
                },
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
<script>
(function($,W,D){
    var user_validation = {};
    user_validation.UTIL =
    {
        setupFormValidation: function()
        {
            //form validation rules
            $("#dynamic_form").validate({
                rules: {
					merchant_id: {
                        required: true,

                    },
					mcc: {
                        required: true,
                    },
					trasanction_type: {
                        required: true,
                    },
					merchant_name: {
                        required: true,
                    },
					commodity_url: {
                        required: true,
						url:true,
                    },
                     transaction_currency: {
                        required:true,
                    },
					order_time_out:{
						required:true,
					},
					merchant_reserved_field :{
						required:true,
					}
                },
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
<script>
(function($,W,D){
    var user_validation = {};
    user_validation.UTIL =
    {
        setupFormValidation: function()
        {
            //form validation rules
            $("#flo2Cash_form").validate({
                rules: {
					web_payments_integration_service: {
                        required: true,

                    },
					flo2Cash_account_id: {
                        required: true,
                    },
					flo2Cash_secret_hash_key: {
                        required: true,
                    },
					return_url: {
                        required: true,
						url:true,
                    },
					himage: {
						url:true,
                    },
                },
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





<script>
(function($,W,D){
    var user_validation = {};
    user_validation.UTIL =
    {
        setupFormValidation: function()
        {
            //form validation rules
            $("#dps_form").validate({
                rules: {
					pxpayuserid: {
                        required: true,

                    },
					pxpaykey: {
                        required: true,
                    },
					pxpayurl: {
                        required: true,

                    },
					transaction_type_dps: {
                        required: true,
                    },
					transaction_currency_dps: {
                        required: true,
                    },
					email: {
                        required: true,
						email:true,
                    },
                },
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

<script>
(function($,W,D){
    var user_validation = {};
    user_validation.UTIL =
    {
        setupFormValidation: function()
        {
            //form validation rules
            $("#poli_form").validate({
                rules: {
					poli_account_id: {
                        required: true,
                    },
					poli_password: {
                        required: true,
                    },
					currency_code: {
                        required: true,

                    },
					merchant_reference: {
                        required: true,
                    },
					merchant_reference_format: {
                        required: true,
                    },
					merchant_data: {
                        required: true,
                    },
					merchant_homepage_url: {
                        required: true,
                    },
					success_url: {
                        required: true,
                    },
					failure_url: {
                        required: true,
                    },
					cancellation_url: {
                        required: true,
                    },
					notification_url: {
                        required: true,
                    },
					timeout: {
                        required: true,
                    },
                },
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
<script src="<?php echo $this->config->item('admin_js_path');?>jscolor.min.js"></script>
<script>
	$(document).ready(function(){    $("#cc_form").submit(function(e){          $('.pax_pay_userid_err').text('');          $('.pax_pay_key_err').text('');          $('.flo_acc_id_err').text('');          $('.dynamic_err').text('');                if($('#cc_dps').is(':checked')){                  var pax_pay_userid=$('#pax_pay_userid').val();                  var pax_pay_key=$('#pax_pay_key').val();                  if(pax_pay_userid==''){                      $('.pax_pay_userid_err').text('Field is required');                    return false;                  }                  if(pax_pay_key==''){                      $('.pax_pay_key_err').text('Field is required');                    return false;                  }                 }else if($('#cc_flo2cash').is(':checked')){                  var flo_acc_id=$('#flo_acc_id').val();                      if(flo_acc_id==''){                         $('.flo_acc_id_err').text('Account id is required');                         return false;                      }                 }else{                    $('.dynamic_err').text('Please select payment methods');                    return false;                 }         });
		$("html, body").animate({ scrollTop: 0 }, "slow");
		$(".respose_style").fadeOut(3000);
	});
</script>
