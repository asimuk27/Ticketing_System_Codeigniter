<style>
.respose_style{
	padding:20px;
    color: #fff;
	background-color: #5cb85c;
	border-color: #4cae4c;
	font-weight:bold;
	margin-top:15px;
	text-align:center;
}
</style>
<div class="content">

		<!-- Kode-Header End -->

		<div class="sub-header">

			<!-- SUB HEADER -->

		</div>

<div class="Kode-page-heading">
	<div class="container">
		<!--ROW START-->
		<div class="row">
			<div class="col-md-6 col-sm-6">
				<h2>Donation Details</h2>
			</div>
		</div>
		<!--ROW END-->
	</div>
</div>
<div class="kf_content">
	<div class="container">
		<?php if($this->session->flashdata('msg')){ ?>
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12 respose_style">
				<?php echo $this->session->flashdata('msg');?>
			</div>
		</div>
		<?php } ?>

		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<!--Who Am I Wrap Start-->
				<div class="kf_who_am center-block view_block_user">
					<div class="row">
						<div class="col-md-8 col-sm-8">
							<div class="text-center center-block">
								<ul class="user_view_ul">
									<li>
                                        <strong>Organisation Name</strong>
										<span><?php echo $data['org_charity_name'];?></span>
									</li>
									<li>
                                        <strong>Event Name</strong>
										<span><?php echo $data['event_name'];?></span>
									</li>
									<li>
                                        <strong>Sub Event Name</strong>
										<span><?php echo $data['sub_event_name'];?></span>
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
										  <span><?php echo $data['donation_message'];?></span>
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
										<span>
											<?php
												if($data['communication_required']){
													echo "Yes";
												}else{
													echo "No";
												}
											?>
										</span>
									</li>

									<li>
										<strong>Payment Method</strong>
										<span>
											<?php
												if($data['payment_method'] == 'dps'){
													echo "Credit Card (DPS)";
												}else{
													echo "POLi";
												}
											?>
										</span>
									</li>

									<li>
										<strong>TicketingSystem Order Id </strong>
										<span>#<?php echo $data['donation_order'];?></span>
									</li>

									<li>
										<strong>Payment Id </strong>
										<span><?php echo $data['txn_number'];?></span>
									</li>

									<li>
										<strong>Payment Trans Date</strong>
										<span><?php echo date("d-m-Y", strtotime($data['created_date']));?></span>
									</li>

									<li>
										<strong>Payment Gateway Status</strong>
										<span>
											<?php
												if($data['txn_status'] == 1){
													echo "Completed Successfully";
												}else{
													echo "Unsuccessfull";
												}
											?>
										</span>
									</li>

								</ul>
								<br class="clear">
								<div class="view_page_edit">
									<button class="search_events  submit_btn" type="button" onclick="window.history.back();">Back</button>
								</div>
							</div>
						</div><!--row-->

					</div>
				</div>
			</div>
		</div>
	</div>

<script>
	function edit_page(id){
		window.location.href = '<?php echo $this->config->item('base_url')?>index.php/frontend/users/edit_user_profile';
	}

	$(document).ready(function(){
		$(".respose_style").fadeOut(3000);
	});
</script>
