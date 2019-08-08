<style>
	.kf_who_am_des ul li{text-align:left;}
	.extra_padding{padding:6px 50px;}
	.special_class strong{width:200px !important;padding:10px !important;}
</style>

<div id="page-wrapper">
<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="right_first_box"><img src="<?php echo $this->config->item('admin_image_path');?>home.png"><a href="<?php echo $this->config->item('login_url');?>">Home</a> > <a href="#">Donation</a> > <a href="#">Donation Details</a></div>
			</div>
	   </div>
	   <div class="row margin_top margin_bottom">
			<div class="col-md-12">
				<div class="blue_top">Donation Details</div>

				<div class="table-responsive table_white_box" style="padding:25px;">
					<div class="kf_who_am center-block">
                        <div class="row margin_top">


                            <div class="col-md-10">
                                <div class="kf_who_am_des text-center center-block" style="padding:0px;">

                                    <ul class="list-unstyled center-block special_class">
                                        <li>
                                            <strong>Organisation Name</strong>
                                            <span><?php echo $data['organization_name'];?></span>
                                        </li>
										<li>
                                            <strong>Event Name</strong>
                                            <span><?php echo $data['event_name'];?></span>
                                        </li>
                                        <li>
                                            <strong>Sub Event Name</strong>
                                            <span><?php echo $data['event_name'];?></span>
                                        </li>
                                        <li>
                                            <strong>Champion Page Title</strong>
                                            <span><?php echo $data['champ_title'];?></span>
                                        </li>
										 <li>
                                            <strong>Display Name</strong>
                                            <span><?php echo $data['display_name'];?></span>
                                        </li>
										 <li>
                                            <strong>Donation To (email)</strong>
                                            <span><?php echo $data['users_email'];?></span>
                                        </li>
										 <li>
                                            <strong>Amount Donated ($)</strong>
                                            <span><?php echo number_format($data['donation_amount'],2);?></span>
                                        </li>
										 <li>
                                            <strong>Message</strong>
                                            <span><?php echo $string = (strlen($data['donation_message']) > 60) ? substr( $data['donation_message'],0,60).'...' :  $data['donation_message'];?></span>
                                        </li>
										 <li>
                                            <strong>Donation Date</strong>
                                            <span><?php echo date("d-m-Y", strtotime($data['created_date']));?></span>
                                        </li>
										<li>
											<strong>Donating As</strong>
											<span><?php echo $data['donor_name'];?></span>
										</li>
										<?php if($data['donor_name'] == 'organisation'){ ?>
											<li>
												<strong>Donation By Org</strong>
												<span><?php echo $data['donar_organisation'];?></span>
											</li>
										<?php } ?>
										 <li>
                                            <strong>Donor Salutation</strong>
                                            <span><?php echo $data['salutation'];?></span>
                                        </li>
										 <li>
                                            <strong>Donor Name</strong>
                                            <span><?php echo $data['donar_first_name'];?></span>
                                        </li>
										 <li>
                                            <strong>Donor Email</strong>
                                            <span><?php echo $data['donation_email'];?></span>
                                        </li>
										 <li>
                                            <strong>Phone</strong>
                                            <span><?php echo $data['donation_phone'];?></span>
                                        </li>
										 <li>
                                            <strong>Street</strong>
                                            <span><?php echo $data['donation_street'];?></span>
                                        </li>

										 <li>
                                            <strong>Suburb</strong>
                                            <span><?php echo $data['suburb'];?></span>
                                        </li>
										 <li>
                                            <strong>City</strong>
                                            <span><?php echo $data['py_city'];?></span>
                                        </li>
										 <li>
                                            <strong>Post Code</strong>
                                            <span><?php echo $data['py_postal_code'];?></span>
                                        </li>
										 <li>
                                            <strong>Country</strong>
                                            <span><?php echo $data['donation_country'];?></span>
                                        </li>
										 <li>
                                            <strong>Communication</strong>
                                            <span><?php if($data['communication_required'] == 0)
											{
												echo "No";
											}
											else
											{
												echo "Yes";
											}
											?></span>
                                        </li>
										 <li>
                                            <strong>Payment Method</strong>
                                            <span><?php
												if($data['payment_method'] == 'dps'){
													echo "Credit Card (DPS)";
												}else{
													echo "POLi";
												}
											?></span>
                                        </li>

										<li>
                                            <strong>TicketingSystem Order Id</strong>
                                            <span><?php echo $data['donation_order_id'];?></span>
                                        </li>
										<li>
                                            <strong>Payment Id</strong>
                                            <span><?php echo $data['txn_number'];?></span>
                                        </li>
										<li>
                                            <strong>Payment Trans Date</strong>
                                            <span><?php echo date("d-m-Y", strtotime($data['created_date']));?></span>
                                        </li>
										<li>
                                            <strong>Payment Gateway Status</strong>
                                            <span><?php
												if($data['txn_status'] == 1){
													echo "Completed Successfully";
												}else{
													echo "Unsuccessfull";
												}
											?></span>
                                        </li>
                                    </ul>
									<button type="button" onclick="goBack()" class="btn btn-primary" style="float:left;">Back</button>
                                </div>
                            </div>

                        </div><!--row   IMG_09082016_112041.png      brand_logo4.png -->
                    </div>
				</div>


			</div>
		</div>


<script>
	function edit_page(id){
		window.location.href = '<?php echo $this->config->item('edit_organiser_profile')."/";?>'+id;
	}



	function goBack() {
		window.history.go(-1);
	}

</script>