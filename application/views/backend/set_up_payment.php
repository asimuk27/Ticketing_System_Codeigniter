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
					<!--<div class="col-md-6 col-sm-6">
						<ul>
							<li>
								<a href="#"><i class="fa fa-home"></i>Home</a>
							</li>
							<li>
								<a href="#"><i class="fa fa-angle-right"></i>SetUp Payment</a>
							</li>
						</ul>
					</div>-->
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
				<li role="presentation" class="active"><a href="#dyanamic"  role="tab" data-toggle="tab">Dynamic</a></li>
				<li role="presentation"><a href="#flo2Cash"  role="tab" data-toggle="tab">Flo2Cash</a></li>
				<li role="presentation"><a href="#dps" role="tab" data-toggle="tab">DPS</a></li>
				<li role="presentation"><a href="#poli" role="tab" data-toggle="tab">POLi</a></li>
				<li role="presentation"><a href="#alipay" role="tab" data-toggle="tab">Alipay</a></li>
			</ul>
            <br class="clear">
            <div class="tab-content">			    
                <div role="tabpanel" class="tab-pane  active" id="dyanamic">
					<form role="form" method="post" action="<?php echo base_url(); ?>index.php/frontend/payment/dynamic_payment_method" id="dynamic_form" enctype="multipart/form-data">		
						<div class="row">
							<div class="col-lg-8 col-md-10">
								<div class="row">
									<div class="col-lg-4 col-md-5"><label>Merchant ID<span class="mandatory">*</span></label></div>
									<div class="col-lg-6 col-md-7">
										<input type="text" id="merchant_id" name="merchant_id" value="<?php echo $data_result_dynamic_payment['merchant_id'];?>">
										<?php echo form_error("merchant_id");?>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4 col-md-5"><label >MCC</label><span class="mandatory">*</span></div>
									<div class="col-lg-6 col-md-7"><input type="text" id="mcc" name="mcc" value="<?php echo $data_result_dynamic_payment['mcc'];?>"><?php echo form_error("mcc");?></div>
								</div>
								<div class="row">
									<div class="col-lg-4 col-md-5"><label >Transaction Type</label><span class="mandatory">*</span></div>
									<div class="col-lg-6 col-md-7"><input type="text" id="trasanction_type" name="trasanction_type" value="<?php echo $data_result_dynamic_payment['trasanction_type'];?>"><?php echo form_error("trasanction_type");?></div>
								</div>
								<div class="row">
									<div class="col-lg-4 col-md-5"><label >Marchant Name</label><span class="mandatory">*</span></div>
									<div class="col-lg-6 col-md-7"><input value="<?php echo $data_result_dynamic_payment['merchant_name'];?>" type="text" id="merchant_name" name="merchant_name" ><?php echo form_error("merchant_name");?></div>								
								</div>
								<div class="row">
									<div class="col-lg-4 col-md-5"><label>Commodity URL</label><span class="mandatory">*</span></div>
									<div class="col-lg-6 col-md-7"><input type="text" id="commodity_url" name="commodity_url" value="<?php echo $data_result_dynamic_payment['commodity_url'];?>"><?php echo form_error("commodity_url");?></div>								
								</div>
								<div class="row">
									<div class="col-lg-4 col-md-5"><label >Transaction Currency </label><span class="mandatory">*</span></div>
									<div class="col-lg-6 col-md-7"><input type="text" id="transaction_currency" name="transaction_currency" value="<?php echo $data_result_dynamic_payment['currency'];?>"><?php echo form_error("transaction_currency");?></div>
								</div>
								<div class="row">
									<div class="col-lg-4 col-md-5"><label >Order Timeout</label><span class="mandatory">*</span></div>
									<div class="col-lg-6 col-md-7"><input type="text" id="order_time_out" name="order_time_out" value="<?php echo $data_result_dynamic_payment['timeout'];?>"><?php echo form_error("order_time_out");?></div>
								</div>
								<div class="row">
									<div class="col-lg-4 col-md-5"><label >Merchant Reserved Field</label><span class="mandatory">*</span></div>
									<div class="col-lg-6 col-md-7"><input type="text" id="merchant_reserved_field" name="merchant_reserved_field" value="<?php echo $data_result_dynamic_payment['merchant_reserved_field'];?>"><?php echo form_error("merchant_reserved_field");?></div>
								</div>
							   	<div class="row">
									<div class="col-lg-4 col-md-5 col-sm-7 col-xs-8"><label>Supported Payment Method</label></div>
									<div class="col-lg-7 col-md-7 col-sm-4 col-xs-4">
										<div class="row check_box">
											<div class="col-md-4"><input type="checkbox" name="supported_method" id="supported_method" value="1" <?php if($data_result_dynamic_payment['supported_method'] == "1"){ echo "checked=checked";}?>><label class="chkbox_space">Cup</label></div>
										</div>
									</div>
								</div>
								<br class="clear">
								<div class="row buttons">
									<div class="col-lg-2 col-lg-offset-4 col-md-2 col-md-offset-5 col-sm-2 col-xs-4">
									   <button class="submit_btn search_events" >Save</button>
									</div>
									<div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
										<button type="button" class="submit_btn search_events" onclick="window.history.back();">Cancel</button>
									</div>
								</div>
							</div><!--content col end-->
						</div>
                    </form>
                </div>				
                <div role="tabpanel" class="tab-pane" id="flo2Cash">
					<form role="form" method="post" action="<?php echo base_url(); ?>index.php/frontend/payment/flo2Cash_form_method" id="flo2Cash_form" enctype="multipart/form-data">  
						<div class="row">
							<div class="col-lg-8 col-md-10">
								<div class="row">
									<div class="col-md-5"><label>Web Payments Integration Service</label><span class="mandatory">*</span></div>
									<div class="col-md-7"><input type="text" id="web_payments_integration_service" name="web_payments_integration_service" value="<?php echo $data_result_flo_2_cash['service'];?>"><?php echo form_error("web_payments_integration_service");?></div>
								</div>
								<div class="row">
									<div class="col-md-5"><label >Flo2Cash Account ID</label><span class="mandatory">*</span></div>
					<div class="col-md-7"><input value="<?php echo $data_result_flo_2_cash['account_id'];?>" type="text" id="flo2Cash_account_id" name="flo2Cash_account_id"><?php echo form_error("flo2Cash_account_id");?></div>
								</div>
								<div class="row">
									<div class="col-md-5"><label >Flo2Cash Secret Hash Key</label><span class="mandatory">*</span></div>
									<div class="col-md-7"><input type="text" id="flo2Cash_secret_hash_key" name="flo2Cash_secret_hash_key" value="<?php echo $data_result_flo_2_cash['secret_key'];?>"><?php echo form_error("flo2Cash_secret_hash_key");?></div>
								</div>
							    <div class="row">
									<div class="col-md-5"><label>Merchant Reference</label></div>
									<div class="col-md-7"><input type="text" name="m_ref" id="m_ref" value="<?php echo $data_result_flo_2_cash['merchant_reference'];?>"></div>
								</div>
								<div class="row">
									<div class="col-md-5"><label >Return URL</label><span class="mandatory">*</span></div>
									<div class="col-md-7"><input type="text" id="return_url" name="return_url" value="<?php echo $data_result_flo_2_cash['return_url'];?>"><?php echo form_error("return_url");?></div>
								</div>
								<div class="row">
									<div class="col-md-5"><label >Notification URL(MNS)</label></div>
									<div class="col-md-7"><input type="text" name="nurl" id="nurl" value="<?php echo $data_result_flo_2_cash['notification_url'];?>"></div>
								</div>
								<div class="row">
									<div class="col-md-5"><label >Header Image Url</label></div>
									<div class="col-md-7"><input type="text"  name="himage" id="himage" value="<?php echo $data_result_flo_2_cash['header_image'];?>"></div>
								</div>
								<div class="row">
									<div class="col-md-5 col-sm-7 col-xs-8"><label>Header Bottom Border Color</label></div>
									<div class="col-md-7 col-sm-4 col-xs-4"><input type="text" class="jscolor" value="" name="hbtcolor" id="hbtcolor" value="<?php echo $data_result_flo_2_cash['header_bottom_border_color'];?>"></div>
								</div>
								<div class="row">
									<div class="col-md-5 col-sm-7 col-xs-8"><label>Header Background Color</label></div>
									<div class="col-md-7 col-sm-4 col-xs-4"><input type="text" class="jscolor" value="" name="hbgcolor" value="hbgcolor" value="<?php echo $data_result_flo_2_cash['header_background_color'];?>"></div>
								</div>
								<div class="row">
									<div class="col-md-5"><label>Merchant defined Custom Data</label></div>
									<div class="col-md-7"><input type="text" name="mdcd" id="mdcd" value="<?php echo $data_result_flo_2_cash['custom_data'];?>"></div>
								</div>                
								<div class="row">
									<div class="col-md-5"><label>Store Card</label></div>
									<div class="col-md-7">
										<select class="form-control dropdown search_events" name="storecard" id="storecard">
											<option value="0" <?php if($data_result_flo_2_cash['store_card'] == "0"){ echo "selected";}else{ echo "";}?>>No</option>
											<option value="1" <?php if($data_result_flo_2_cash['store_card'] == "1"){ echo "selected";}else{ echo "";}?>>Yes</option>
										</select>
									</div>
								</div>                
								<div class="row">
									<div class="col-md-5"><label class="control_lable">Display Customer Email</label></div>
									<div class="col-md-7">
										<select class="form-control dropdown search_events" name="dce" id="dce">
											<option value="0" <?php if($data_result_flo_2_cash['display_customer_email'] == "0"){ echo "selected";}else{ echo "";}?>>No</option>
											<option value="1" <?php if($data_result_flo_2_cash['display_customer_email'] == "1"){ echo "selected";}else{ echo "";}?>>Yes</option>
										</select>
									</div>
								</div>
                
                 <div class="row">
                <div class="col-md-5"><label class="control_lable">Payment Method</label></div>
                <div class="col-md-7">
                <select class="form-control dropdown search_events" name="paymethod" id="paymethod">
					<option value="0" <?php if($data_result_flo_2_cash['payment_method'] == "0"){ echo "selected";}else{ echo "";}?>>Standard</option>
					<option value="1" <?php if($data_result_flo_2_cash['payment_method'] == "1"){ echo "selected";}else{ echo "";}?>>Normal</option>
                </select>
                </div>
                </div>
                
                <div class="row">
                <div class="col-md-3 col-sm-3"><label>Supported Cards</label></div>
                <div class="col-md-9 col-sm-9">
                <div class="row check_box">
                <div class="col-md-4 col-sm-4">
					<input type="checkbox" name="visa" id="visa" value="1" <?php if($data_result_flo_2_cash['visa'] == "1"){ echo "checked=checked";}?>>
					<label class="chkbox_space">Visa / Master</label>
				</div>
                <div class="col-md-4 col-sm-4">
					<input type="checkbox" name="american_express" id="1" value="american_express" <?php if($data_result_flo_2_cash['american_express'] == "1"){ echo "checked=checked";}?>>
					<label class="chkbox_space">American Express</label>
				</div>
                <div class="col-md-4 col-sm-4">
					<input type="checkbox" name="dinner_club" id="dinner_club" value="1" <?php if($data_result_flo_2_cash['dinner_club'] == "1"){ echo "checked=checked";}?>>
					<label class="chkbox_space">Diners Club</label>
				</div>
                </div>
                </div>
                </div>
                
               <br class="clear">
                <div class="row buttons">
                       <div class="col-md-2 col-md-offset-5 col-sm-2 col-xs-4">
                       <button class="submit_btn search_events">Save</button>
                       </div>
                       <div class="col-md-2 col-sm-2 col-xs-4">
                       <div class="submit_btn search_events" onclick="window.history.back();">Cancel</div>
                       </div>
                </div>
               
                </div>
             
                </div>
                  </form>
                  </div>
				  
				  
				  
				  
        <div role="tabpanel" class="tab-pane" id="dps">
			<form role="form" method="post" action="<?php echo base_url();?>index.php/frontend/payment/dps_payment_method" id="dps_form" enctype="multipart/form-data">
			<div class="row">
					<div class="col-lg-8 col-md-10">
						<div class="row">
							<div class="col-lg-4 col-md-5"><label>PxPayUserId</label><span class="mandatory">*</span></div>
							<div class="col-lg-6 col-md-7"><input type="text" class="inp" id="pxpayuserid" name="pxpayuserid" value="<?php echo $data_result_dps['pxpayuserid'];?>">
							<?php echo form_error("pxpayuserid");?></div>
                </div>
                 <div class="row">
                <div class="col-lg-4 col-md-5"><label >PxPayKey</label><span class="mandatory">*</span></div>
                <div class="col-lg-6 col-md-7 "><input type="text" id="pxpaykey" name="pxpaykey" value="<?php echo $data_result_dps['pxpaykey'];?>">
    <?php echo form_error("pxpaykey");?></div>
                </div>
                 <div class="row">
                <div class="col-lg-4 col-md-5"><label >PxPayUrl</label><span class="mandatory">*</span></div>
                <div class="col-lg-6 col-md-7"><input value="<?php echo $data_result_dps['pxpaykey'];?>" type="text" id="pxpayurl" name="pxpayurl"><?php echo form_error("paypayurl");?></div>
                </div>
                 <div class="row">
                <div class="col-lg-4 col-md-5"><label>Transaction Type</label><span class="mandatory">*</span></div>
                <div class="col-lg-6 col-md-7"><input value="<?php echo $data_result_dps['transaction_type'];?>" type="text" id="transaction_type_dps" name="transaction_type_dps"><?php echo form_error("transaction_type_dps");?></div>
                </div>
                 <div class="row">
                <div class="col-lg-4 col-md-5"><label >Transaction Currency</label><span class="mandatory">*</span></div>
                <div class="col-lg-6 col-md-7"><input type="text" id="transaction_currency_dps" name="transaction_currency_dps" value="<?php echo $data_result_dps['currency'];?>"><?php echo form_error("transaction_currency_dps");?></div>
                </div>
                 <div class="row">
                <div class="col-lg-4 col-md-5"><label >Email</label><span class="mandatory">*</span></div>
                <div class="col-lg-6 col-md-7"><input type="text" id="email" name="email" value="<?php echo $data_result_dps['email'];?>"><?php echo form_error("email");?></div>
                </div>
                <!--
				<div class="row">
                <div class="col-lg-4 col-md-5"><label >Success URL </label><span class="mandatory">*</span></div>
                <div class="col-lg-6 col-md-7"><input type="text" id="success_url" name="success_url" value="<?php echo $data_result_dps['success_url'];?>"><?php echo form_error("success_url");?></div>
                </div>
                 <div class="row">
                <div class="col-lg-4 col-md-5"><label >Failure URL</label><span class="mandatory">*</span></div>
                <div class="col-lg-6 col-md-7"><input type="text" id="failure_url" name="failure_url" value="<?php echo $data_result_dps['failure_url'];?>"><?php echo form_error("failure_url");?></div>
                </div>-->
               
                <div class="row">
                <div class="col-md-3 col-sm-3"><label>Supported Cards</label></div>
                <div class="col-md-9 col-sm-9">
                <div class="row check_box">
                <div class="col-md-4 col-sm-4">
					<input type="checkbox" name="dps_visa" id="dps_visa" value="1" <?php if($data_result_dps['visa'] == "1"){ echo "checked=checked";}?>>
					<label class="chkbox_space">Visa / Master</label>
				</div>
                <div class="col-md-4 col-sm-4">
					<input type="checkbox" name="dps_american_express" id="1" value="dps_american_express" <?php if($data_result_dps['american_express'] == "1"){ echo "checked=checked";}?>>
					<label class="chkbox_space">American Express</label>
				</div>
                <div class="col-md-4 col-sm-4">
					<input type="checkbox" name="dps_dinner_club" id="dps_dinner_club" value="1" <?php if($data_result_dps['dinner_club'] == "1"){ echo "checked=checked";}?>>
					<label class="chkbox_space">Diners Club</label>
				</div>
                </div>
                </div>
                </div>
               <br class="clear">
                <div class="row buttons">
                       <div class="col-lg-2 col-lg-offset-4 col-md-2 col-md-offset-5 col-sm-2 col-xs-4">
                       <button class="submit_btn search_events">Save</button>
                       </div>
                       <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
                       <div class="submit_btn search_events" onclick="window.history.back();">Cancel</div>
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
                <div class="row">
                <div class="col-lg-4 col-md-5"><label >Poli Account ID</label><span class="mandatory">*</span></div>
                <div class="col-lg-6 col-md-7"><input type="text" id="poli_account_id" name="poli_account_id" value="<?php echo $data_result_poli['account_id'];?>"><?php echo form_error("poli_account_id");?></div>
                </div>
                 <div class="row">
                <div class="col-lg-4 col-md-5"><label >Poli Password</label><span class="mandatory">*</span></div>
                <div class="col-lg-6 col-md-7"><input type="text" id="poli_password" name="poli_password" value="<?php echo $data_result_poli['password'];?>"><?php echo form_error("poli_password");?></div>
                </div>
                 <div class="row">
                <div class="col-lg-4 col-md-5"><label >Currency Code</label><span class="mandatory">*</span></div>
                <div class="col-lg-6 col-md-7"><input type="text" id="currency_code" name="currency_code" value="<?php echo $data_result_poli['currency_code'];?>"><?php echo form_error("currency_code");?></div>
                </div>
                 <div class="row">
                <div class="col-lg-4 col-md-5"><label >Merchant Reference</label><span class="mandatory">*</span></div>
                <div class="col-lg-6 col-md-7"><input type="text" id="merchant_reference" name="merchant_reference" value="<?php echo $data_result_poli['merchant_reference'];?>"><?php echo form_error("merchant_reference");?></div>
                </div>
                 <div class="row">
                <div class="col-lg-4 col-md-5"><label >Merchant Reference Format</label><span class="mandatory">*</span></div>
                <div class="col-lg-6 col-md-7"><input type="text" id="merchant_reference_format" name="merchant_reference_format" value="<?php echo $data_result_poli['merchant_reference_format'];?>"><?php echo form_error("merchant_reference_format");?></div>
                </div>
                 <div class="row">
                <div class="col-lg-4 col-md-5"><label >Merchant Data</label><span class="mandatory">*</span></div>
                <div class="col-lg-6 col-md-7"><input type="text" id="merchant_data" name="merchant_data" value="<?php echo $data_result_poli['merchant_data'];?>"><?php echo form_error("merchant_data");?></div>
                </div>
                 <div class="row">
                <div class="col-lg-4 col-md-5"><label >Merchant Homepage URL</label><span class="mandatory">*</span></div>
                <div class="col-lg-6 col-md-7"><input type="text" id="merchant_homepage_url" name="merchant_homepage_url" value="<?php echo $data_result_poli['homepage_url'];?>"><?php echo form_error("merchant_homepage_url");?></div>
                </div>
                 <div class="row">
                <div class="col-lg-4 col-md-5"><label>Success URL</label><span class="mandatory">*</span></div>
                <div class="col-lg-6 col-md-7"><input type="text" id="success_url" name="success_url" value="<?php echo $data_result_poli['success_url'];?>"><?php echo form_error("success_url");?></div>
                </div>
                 <div class="row">
                <div class="col-lg-4 col-md-5"><label >Failure URL</label><span class="mandatory">*</span></div>
                <div class="col-lg-6 col-md-7"><input type="text" id="failure_url" name="failure_url" value="<?php echo $data_result_poli['failure_url'];?>"><?php echo form_error("failure_url");?></div>
                </div>
                <div class="row">
                <div class="col-lg-4 col-md-5"><label >Cancellation URL</label><span class="mandatory">*</span></div>
                <div class="col-lg-6 col-md-7"><input type="text" id="cancellation_url" name="cancellation_url" value="<?php echo $data_result_poli['cancel_url'];?>"><?php echo form_error("cancellation_url");?></div>
                </div>
                <div class="row">
                <div class="col-lg-4 col-md-5"><label>Notification URL</label><span class="mandatory">*</span></div>
                <div class="col-lg-6 col-md-7"><input type="text" id="notification_url" name="notification_url" value="<?php echo $data_result_poli['notification_url'];?>"><?php echo form_error("notification_url");?></div>
                </div>
               <div class="row">
                <div class="col-lg-4 col-md-5"><label>Timeout</label><span class="mandatory">*</span></div>
                <div class="col-lg-6 col-md-7"><input type="text" id="timeout" name="timeout" value="<?php echo $data_result_poli['timeout'];?>"><?php echo form_error("timeout");?></div>
                </div>
                <div class="row">
                <div class="col-lg-4 col-md-5"><label>Selected FI Code</label></div>
                <div class="col-lg-6 col-md-7"><input type="text" id="selected_fi_code" name="selected_fi_code" value="<?php echo $data_result_poli['fi_code'];?>"></div>
                </div>
                <div class="row">
                <div class="col-lg-4 col-md-5"><label>Company Code</label></div>
                <div class="col-lg-6 col-md-7"><input type="text" id="company_code" name="company_code" value="<?php echo $data_result_poli['company_code'];?>"></div>
                </div>
                <div class="row">
                <div class="col-lg-4 col-md-5 col-sm-7 col-xs-12"><label>Supported Payment Method</label></div>
                <div class="col-lg-7 col-md-7 col-sm-5 col-xs-12">
                <div class="row check_box">
                <div class="col-md-5"><input type="checkbox" id="supported_method_poli" name="supported_method_poli" value="1" <?php if($data_result_poli['payment_method'] == "1"){ echo "checked=checked";}?>><label class="chkbox_space">Poli Account</label></div>
                </div>
                </div>
                </div>
                <br class="clear">
                <div class="row buttons">
                       <div class="col-lg-2 col-lg-offset-4 col-md-2 col-md-offset-5 col-sm-2 col-xs-4">
                       <button class="submit_btn search_events">Save</button>
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
                <div class="row">
                <div class="col-lg-4 col-md-5"><label>Service Name<span class="mandatory">*</span></label></div>
                <div class="col-lg-6 col-md-7"><input type="text" name="service_name" id="service_name" value="<?php echo $data_result_alipay['service'];?>"><?php echo form_error("service_name");?></div>
                </div>
                 <div class="row">
                <div class="col-lg-4 col-md-5"><label >Alipay Partner ID</label><span class="mandatory">*</span></div>
                <div class="col-lg-6 col-md-7"><input type="text" name="alipay_partner_id" id="alipay_partner_id" value="<?php echo $data_result_alipay['alipay_partner_id'];?>"><?php echo form_error("alipay_partner_id");?></div>
                </div>
                 <div class="row">
                <div class="col-lg-4 col-md-5"><label >Alipay Partner Key</label><span class="mandatory">*</span></div>
                <div class="col-lg-6 col-md-7"><input type="text"  name="alipay_partner_key" id="alipay_partner_key" value="<?php echo $data_result_alipay['alipay_partner_key'];?>"><?php echo form_error("alipay_partner_key");?></div>
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
                <div class="col-lg-4 col-md-5"><label>Transaction currency</label><span class="mandatory">*</span></div>
                <div class="col-lg-6 col-md-7"><input type="text" name="alipay_currency" id="alipay_currency" value="<?php echo $data_result_alipay['currency'];?>">
				<?php echo form_error("alipay_currency");?></div>
                </div>
                 <div class="row">
                <div class="col-lg-4 col-md-5"><label >Return URL</label><span class="mandatory">*</span></div>
                <div class="col-lg-6 col-md-7"><input type="text" name="alipay_return_url" id="alipay_return_url" value="<?php echo $data_result_alipay['return_url'];?>"><?php echo form_error("alipay_return_url");?></div>
                </div>
                 <div class="row">
                <div class="col-lg-4 col-md-5"><label >Notification URL</label><span class="mandatory">*</span></div>
                <div class="col-lg-6 col-md-7"><input type="text" name="alipay_notification_url" id="alipay_notification_url" value="<?php echo $data_result_alipay['notification_url'];?>"><?php echo form_error("alipay_notification_url");?></div>
                </div>
                 <div class="row">
                <div class="col-lg-4 col-md-5"><label >Order valid time</label><span class="mandatory">*</span></div>
                <div class="col-lg-6 col-md-7"><input type="text" name="alipay_order_time" id="alipay_order_time" value="<?php echo $data_result_alipay['order_valid_time'];?>"><?php echo form_error("alipay_order_time");?></div>
                </div>
               
                <div class="row">
                <div class="col-lg-4 col-md-5 col-sm-7 col-xs-8"><label>Active Payment Method</label></div>
                <div class="col-lg-7 col-md-7 col-sm-4 col-xs-4">
                <div class="row check_box">
                <div class="col-md-4">
					<input type="checkbox" name="alipay_pay_method" id="alipay_pay_method" value="1" <?php if($data_result_alipay['supported_method'] == "1"){ echo "checked=checked";}?>>
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
                       <div class="submit_btn search_events" onclick="window.history.back();">Cancel</div>
                       </div>
                </div>
          </div><!--content col end-->
          
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
<script src="<?php echo $this->config->item('frontend_js_path');?>jscolor.min.js"></script>
<script>
	$(document).ready(function(){
		$("html, body").animate({ scrollTop: 0 }, "slow");
		$(".respose_style").fadeOut(3000);
	});
</script>