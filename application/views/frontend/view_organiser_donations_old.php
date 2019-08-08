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
                                        <strong>Champion Page Title</strong>
										<span><?php echo $data['title'];?></span>
									</li>
									<li>
                                        <strong>Charity Name</strong>
										<span><?php echo $data['charity_name'];?></span>
									</li>
									<li>
                                        <strong>Display Name</strong>
										<span><?php echo $data['display_name'];?></span>
									</li>
									<li>
                                        <strong>Amount Donated ($)</strong>
                                        <span><?php echo $data['donation_amount'];?></span>
                                    </li>
                                    <li>
                                        <strong>Order Id</strong>
                                        <span>#<?php echo $data['hist_order'];?></span>
                                    </li>
									<li>
										<strong>Transaction Id</strong>
                                        <span><?php echo $data['txn_number'];?></span>
                                    </li>
                                    <li>
                                        <strong>Transaction Date</strong>
                                        <span><?php echo $data['created_date'];?></span>
                                    </li>
									 <li>
                                        <strong>Transaction Status</strong>
                                        <span>
											<?php
												if($data['txn_number']){
													echo "Success";
												}else{
													echo "Failure";
												}
											?>
										</span>
                                    </li>
                                    <li>
										<strong>Event Title</strong>
										<span><?php echo $data['event_name'];?></span>
									</li>
									<li>
										<strong>Sub Event Title</strong>
										<span><?php echo $data['schedule_title'];?></span>
									</li>
									<li>
										<strong>User Email</strong>
										<span><?php echo $data['payhist_email'];?></span>
									</li>
									<li>
										<strong>User Phone</strong>
										<span><?php echo $data['phone'];?></span>
									</li>
									<li>
										<strong>User Country</strong>
										<span><?php echo $data['country'];?></span>
									</li>
									<li>
										<strong>Payment Method</strong>
										<span><?php //echo $data['payment_method'];?>Credit Card</span>
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
