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
	.error{
		color:red;
	}
     .respose_style{
        padding:20px;
        color: #fff;
        background-color: #5cb85c;
        border-color: #4cae4c;
        font-weight:bold;
    }
	hr{
		margin-bottom: 10px;
		margin-top: 10px;
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
						<h2>Setup Payment</h2>
					</div>
				</div>
				<!--ROW END-->
			</div>
		</div>
		<!--Kode-our-speaker-heading End-->
		<div class="kode-blog-style-2">
		<div class="container" id="tabs">
            <?php if($this->session->flashdata('msg')): ?>
				<div class="row">
					<div class="col-md-6 respose_style"><?php echo $this->session->flashdata('msg'); ?></div>
				</div>
				<br class="clear">
			<?php endif; ?>
			<ul class="nav nav-tabs responsive-tabs" role="tablist">
				<li role="presentation" class="active"><a href="#cc"  role="tab" data-toggle="tab">CC</a></li>
				<li role="presentation"><a href="#dyanamic"  role="tab" data-toggle="tab">UnionPay</a></li>
				<li role="presentation"><a href="#poli" role="tab" data-toggle="tab">POLi</a></li>
				<li role="presentation"><a href="#alipay" role="tab" data-toggle="tab">Alipay</a></li>
			</ul>
            <div class="tab-content">
				<div role="tabpanel" class="tab-pane active" id="cc">
				    <form action="<?php echo base_url(); ?>index.php/frontend/payment/cc_payment_method" method="post" id="cc_form">
				    <?php if(!empty($get_organiser_settings)){?>
				    <input type="hidden" name="" value="<?php echo $get_organiser_settings[0]['payment_key']; ?>" id="payment_mtd"/>
				    <?php } ?>
					<div class="row">
						<div class="col-lg-8 col-md-10">
							<div class="row check_box">
								<div class="col-md-3">
								     <?php if(!empty($dps_data)){ ?>
									<input name="cc_used" id="cc_used" type="checkbox" value="<?php echo $dps_data[0]['use_card']; ?>"><label for="cc_used" class="chkbox_space" >Use CreditCard</label>
									<?php }else{ ?>
                                     <input name="cc_used" id="cc_used" type="checkbox" value="0"><label for="cc_used" class="chkbox_space" >Use CreditCard</label>
									<?php } ?>
								</div>
								<div class="col-md-4 col-md-offset-1">
									<input name="cc_setting" id="" type="radio" <?php if($cc_setting == 1){echo "checked=true";}else{echo "";} ?> value="1">
									<label for="" class="chkbox_space" >Organiser</label>

									<?php if($cc_setting == 2){?>
										<input name="cc_setting" id="" type="radio" <?php if($cc_setting == 2){echo "checked=true";}else{echo "";} ?> value="2">
										<label for="" class="chkbox_space" >TicketingSystem <?php echo $cc_settings;?></label>
									<?php } ?>

								</div>
							</div>
							<hr>
							<div class="row">
								<div class="col-lg-4 col-md-5">
									<input <?php if($dps_data['0']['status'] == 1){ echo "checked=true";}?> value="1" type="radio" id="cc_dps" name="pay_type" value="1"><label class="chkbox_space" for="cc_dps" >DPS</label>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-4 col-md-5"><label>PxPayUserId<span class="mandatory">*</span></label></div>
								<div class="col-lg-6 col-md-7">
								    <?php if(!empty($dps_data)){ ?>
									<input type="text" id="pax_pay_userid" name="pax_pay_userid" value="<?php echo $dps_data[0]['pxpayuserid'];?>" class="form-control cc_mer_id">
									<?php }else{ ?>
                                     <input type="text" id="pax_pay_userid" name="pax_pay_userid" value="" class="form-control cc_mer_id">
									<?php } ?>
									<?php echo form_error("pxpayuserid");?>
									<div class="pax_pay_userid_err" style="color:red"></div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-4 col-md-5"><label >PxPayKey</label><span class="mandatory">*</span></div>
								<div class="col-lg-6 col-md-7">
                                 <?php if(!empty($dps_data)){ ?>
								<input type="text" id="pax_pay_key" name="pax_pay_key" value="<?php echo $dps_data[0]['pxpaykey'];?>" class="form-control cc_mcc">
                                <?php }else{ ?>
                                <input type="text" id="pax_pay_key" name="pax_pay_key" value="" class="form-control cc_mcc">
                                <?php } ?>
								<?php echo form_error("mcc");?>
                                    <div class="pax_pay_key_err" style="color:red"></div>
								</div>
							</div>
							<hr>
							<div class="row">
								<div class="col-lg-4 col-md-5">
									<input <?php if($dps_flo2['0']['status'] == 1){ echo "checked=true";}?> type="radio" name="pay_type" id="cc_flo2cash" value="2"><label class="chkbox_space" for="cc_flo2cash" value="2" >Flo2Cash</label>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-4 col-md-5"><label>Flo2Cash Account ID<span class="mandatory">*</span></label></div>
								<div class="col-lg-6 col-md-7">
								 <?php if(!empty($dps_flo2)){ ?>
									<input type="text" id="flo_acc_id" name="flo_acc_id" value="<?php echo $dps_flo2[0]['account_id'];?>" class="form-control flo_mer">
									<?php }else{ ?>
                                    <input type="text" id="flo_acc_id" name="flo_acc_id" value="" class="form-control flo_mer">
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
                <div role="tabpanel" class="tab-pane" id="dyanamic">
					<form role="form" method="post" action="<?php echo base_url(); ?>index.php/frontend/payment/dynamic_payment_method" id="dynamic_form" enctype="multipart/form-data">
						<div class="row">
							<div class="col-lg-8 col-md-10">
								<div class="row check_box">
									<div class="col-md-3">
										<input <?php if($data_result_dynamic_payment['use_card'] == "1"){ echo "checked=checked";}?> name="cup_used" id="cup_used" value="1" type="checkbox"><label for="cup_used" class="chkbox_space"  >Use UnionPay</label>
									</div>
									<div class="col-md-4 col-md-offset-1">
									<input name="dynamic_setting" id="" type="radio" <?php if($dynamic_setting == 1){echo "checked=true";}else{echo "";} ?> value="1">
									<label for="" class="chkbox_space" >Organiser</label>

									<?php if($dynamic_setting == 2){ ?>
											<input name="dynamic_setting" id="" type="radio" <?php if($dynamic_setting == 2){echo "checked=true";}else{echo "";} ?> value="2">
											<label for="" class="chkbox_space" >TicketingSystem</label>
									<?php } ?>

								</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-lg-4 col-md-5"><label>Merchant ID<span class="mandatory">*</span></label></div>
									<div class="col-lg-6 col-md-7">
										<input class="form-control" type="text" id="merchant_id" name="merchant_id" value="<?php echo $data_result_dynamic_payment['merchant_id'];?>">
										<?php echo form_error("merchant_id");?>
									</div>
								</div>
								<br class="clear">
								<div class="row buttons">
									<div class="col-lg-2 col-lg-offset-4 col-md-2 col-md-offset-5 col-sm-2 col-xs-4">
									   <button class="submit_btn search_events" type="submit">Save</button>
									</div>
									<div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
										<button type="button" class="submit_btn search_events" onclick="window.history.back();">Cancel</button>
									</div>
								</div>
							</div><!--content col end-->
						</div>
                    </form>
                </div>
				<div role="tabpanel" class="tab-pane" id="poli">
                <form role="form" method="post" action="<?php echo base_url(); ?>index.php/frontend/payment/poli_payment_method" id="poli_form" enctype="multipart/form-data">
				<div class="row">
					<div class="col-lg-8 col-md-10">
						<div class="row check_box">
							<div class="col-md-3">
								<input <?php if($data_result_poli['use_card'] == "1"){ echo "checked=checked";}?> name="poli_used" id="poli_used" value="1" type="checkbox"><label for="poli_used" class="chkbox_space">Use Poli</label>
							</div>
							<div class="col-md-4 col-md-offset-1">
								<input name="poli_setting" id="" type="radio" <?php if($poli_setting == 1){echo "checked=true";}else{echo "";} ?> value="1">
								<label for="" class="chkbox_space" >Organiser</label>
								<?php if($poli_setting == 2){ ?>
									<input name="poli_setting" id="" type="radio" <?php if($poli_setting == 2){echo "checked=true";}else{echo "";} ?> value="2">
									<label for="" class="chkbox_space" >TicketingSystem</label>
								<?php }?>
							</div>
						</div>
						<hr>
						<div class="row">
						<div class="col-lg-4 col-md-5"><label >Poli Account ID</label><span class="mandatory">*</span></div>
						<div class="col-lg-6 col-md-7"><input class="form-control" type="text" id="poli_account_id" name="poli_account_id" value="<?php echo $data_result_poli['account_id'];?>"><?php echo form_error("poli_account_id");?></div>
						</div>
						 <div class="row">
						<div class="col-lg-4 col-md-5"><label >Poli Password</label><span class="mandatory">*</span></div>
						<div class="col-lg-6 col-md-7"><input class="form-control" type="text" id="poli_password" name="poli_password" value="<?php echo $data_result_poli['password'];?>"><?php echo form_error("poli_password");?></div>
						</div>

						<br class="clear">
						<div class="row buttons">
							   <div class="col-lg-2 col-lg-offset-4 col-md-2 col-md-offset-5 col-sm-2 col-xs-4">
							   <button class="submit_btn search_events" type="submit">Save</button>
							   </div>
							   <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
							   <div class="submit_btn search_events" onclick="window.history.back();">Cancel</div>
							   </div>
						</div>
					</div></div>
				</form>
          </div>
		  <div role="tabpanel" class="tab-pane" id="alipay">
			 <form role="form" method="post" action="<?php echo base_url(); ?>index.php/frontend/payment/alipay_payment_method" id="alipay_form" enctype="multipart/form-data">
				<div class="row">
					<div class="col-lg-8 col-md-10">
				<div class="row check_box">
					<div class="col-md-3">
						<input name="alipay_used" id="alipay_used" value="1" type="checkbox"><label for="alipay_used" class="chkbox_space">Use Alipay</label>
					</div>
					<div class="col-md-4 col-md-offset-1">
						<input name="alipay_setting" id="" type="radio" <?php if($alipay_setting == 1){echo "checked=true";}else{echo "";} ?> value="1">
						<label for="" class="chkbox_space" >Organiser</label>
						<?php if($alipay_setting == 2){ ?>
							<input name="alipay_setting" id="" type="radio" <?php if($alipay_setting == 2){echo "checked=true";}else{echo "";} ?> value="2">
							<label for="" class="chkbox_space" >TicketingSystem</label>
						<?php } ?>
					</div>
				</div>
				<hr>
                <div class="row">
                <div class="col-lg-4 col-md-5"><label>Service Name<span class="mandatory">*</span></label></div>
                <div class="col-lg-6 col-md-7"><input type="text" name="service_name" id="service_name" value="<?php echo $data_result_alipay['service'];?>" class="form-control"><?php echo form_error("service_name");?></div>
                </div>
                 <div class="row">
                <div class="col-lg-4 col-md-5"><label >Alipay Partner ID</label><span class="mandatory">*</span></div>
                <div class="col-lg-6 col-md-7"><input class="form-control" type="text" name="alipay_partner_id" id="alipay_partner_id" value="<?php echo $data_result_alipay['alipay_partner_id'];?>"><?php echo form_error("alipay_partner_id");?></div>
                </div>
                 <div class="row">
                <div class="col-lg-4 col-md-5"><label >Alipay Partner Key</label><span class="mandatory">*</span></div>
                <div class="col-lg-6 col-md-7"><input class="form-control" type="text"  name="alipay_partner_key" id="alipay_partner_key" value="<?php echo $data_result_alipay['alipay_partner_key'];?>"><?php echo form_error("alipay_partner_key");?></div>
                </div>
                 <div class="row">
                <div class="col-lg-4 col-md-5"><label>Character set on merchant website<span class="mandatory">*</span></label></div>
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
                <div class="col-lg-4 col-md-5"><label>Transaction currency</label><span class="mandatory">*</span></div>
                <div class="col-lg-6 col-md-7"><input class="form-control" type="text" name="alipay_currency" id="alipay_currency" value="<?php echo $data_result_alipay['currency'];?>">
				<?php echo form_error("alipay_currency");?></div>
                </div>

                <br class="clear">
                <div class="row buttons">
                       <div class="col-lg-2 col-lg-offset-4 col-md-2 col-md-offset-5 col-sm-2 col-xs-4">
                       <button class="submit_btn search_events" type="button">Save</button>
                       </div>
                       <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
                       <div class="submit_btn search_events" onclick="window.history.back();">Cancel</div>
                       </div>
                </div>
          </div>
		  </div>
		  </form>
          </div><!--content col end-->
          </div><!--Container-->
		  </div>
		  </div><!--Content-->
<script src="<?php echo $this->config->item('frontend_js_path');?>jquery.validate.min.js"></script>
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
<script src="<?php echo $this->config->item('frontend_js_path');?>jscolor.min.js"></script>
<script>
	$(document).ready(function(){
		$("html, body").animate({ scrollTop: 0 }, "slow");
		$(".respose_style").fadeOut(3000);
	});
</script>


<script>
$(document).ready(function(){
    var pm=$('#payment_mtd').val();
    var credit_crd=$('#cc_used').val();

    if(credit_crd==1){
    	 $('#cc_used').prop('checked',true);
    }

    if($('#cc_used').is(':checked')){
          $(this).val('1');
    }

    if(pm=='flo_2_cash'){
      $('#cc_flo2cash').prop('checked',true);
    }

    if(pm=='dps'){
      $('#cc_dps').prop('checked',true);
    }


	$("#cc_form").submit(function(e){


        $('.pax_pay_userid_err').text('');
        $('.pax_pay_key_err').text('');
        $('.flo_acc_id_err').text('');
        $('.dynamic_err').text('');


              if($('#cc_dps').is(':checked')){
              	var pax_pay_userid=$('#pax_pay_userid').val();
              	var pax_pay_key=$('#pax_pay_key').val();



                if(pax_pay_userid==''){
                    $('.pax_pay_userid_err').text('Field is required');
                	return false;
                }
                if(pax_pay_key==''){

                    $('.pax_pay_key_err').text('Field is required');
                	return false;
                }
               }else if($('#cc_flo2cash').is(':checked')){
               	var flo_acc_id=$('#flo_acc_id').val();
               	    if(flo_acc_id==''){
                       $('.flo_acc_id_err').text('Account id is required');
                       return false;
               	    }
               }else{
                  $('.dynamic_err').text('Please select payment methods');
                  return false;

               }



       });

});
</script>