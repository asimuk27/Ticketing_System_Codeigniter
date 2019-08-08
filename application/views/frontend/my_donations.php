<link rel="stylesheet" href="<?php echo $this->config->item('frontend_css_path');?>placeholder.css">
<script>
	jQuery(document).ready(function(){ 
		jQuery(".pagination li a").click(function(e){ 
			document.getElementById('my_donation_form').action = jQuery(this).attr('href');
			jQuery('#my_donation_form').submit();   
			e.preventDefault();
		});
	});
</script>	
<style>
	.table-bordered th{padding:10px !important;}
	.table-bordered td{padding:10px !important;}
	.odd{background:#f9f9f9;}
	.even{background:#ffffff;}
</style>
<div class="content">
	<div class="sub-header">
	</div>
	<div class="Kode-page-heading">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-sm-6">
					<h2>My Donations</h2>
				</div>				
			</div>
			<!--ROW END-->
		</div>
	</div>
	<!--Kode-our-speaker-heading End-->
	<div class="kode-blog-style-2 search_table" style="min-height:500px;">
		<div class="container">
			<form method="post" action="" id="my_donation_form" name="my_donation_form">
				<div class="row" style="margin-bottom:0px;"> 
					<div class="col-sm-3">					
						<input type="text" class="search_events form-control" placeholder="Order Id" name="search_by_order_id" id="search_by_order_id" value="<?php if(isset($_POST['search_by_order_id'])){ echo $_POST['search_by_order_id']; }else{ echo ''; }; ?>">
					</div>
					<div class="col-sm-3">
						<input type="text" class="search_events form-control" placeholder="Transaction Id" name="search_by_transact_id" id="search_by_transact_id" value="<?php if(isset($_POST['search_by_transact_id'])){ echo $_POST['search_by_transact_id']; }else{ echo ''; }; ?>">
					</div>
					<div class="col-md-1">   
						<button class="blue_box_title" type="submit" style="padding: 9px 20px;margin-bottom:15px;">Search</button> 
					</div>
					<div class="col-md-1">   
						<button class="blue_box_title" type="button" style="padding: 9px 20px;margin-bottom:15px;" onclick="clear_search_form();">Reset</button> 
					</div>
				</div>	
				<div class="row" style="margin-bottom:0px;">
					<div class="col-sm-1">
						<label style="padding:10px;">Records</label>
					</div>
					<div class="col-sm-2">				
						<select class="form-control dropdown" id="per_page" name="per_page" onchange="page_count_check();">
							<option value="5" <?php if($page_count  == '5'){ echo " selected";}else{ echo "";}?>>5</option>
							<option value="10" <?php if($page_count  == '10'){ echo " selected";}else{ echo "";}?>>10</option>
							<option value="20" <?php if($page_count  == '20'){ echo " selected";}else{ echo "";}?>>20</option>
							<option value="30" <?php if($page_count  == '30'){ echo " selected";}else{ echo "";}?>>30</option>
							<option value="40" <?php if($page_count  == '40'){ echo " selected";}else{ echo "";}?>>40</option>
							<option value="50" <?php if($page_count  == '50'){ echo " selected";}else{ echo "";}?>>50</option>
						</select>
					</div>
				</div>			
			</form>
			 
				  <?php if($this->session->flashdata('message') != ''){ ?>
					<div class="row">
						<div class="col-md-12" style="color:green;margin-top:10px;">
						<?php echo $this->session->flashdata('message');  ?>
						</div>
					</div>	
				  <?php } ?>
			<div class="row">
				<div class="col-md-12">
					<div class="table-responsive">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th>Champion Page Title</th>
									<th>Charity Name</th>
									<th>Display Name</th>
									<th>Amount($)</th>
									<th>Order Id</th> 
									<th>Transaction Id</th>
									<th colspan="2">Action</th>
								</tr>
							</thead>

							<tbody>
								<?php 
								if(count($data) > 0){
								$i = 0;
								foreach($data as $get_value){ 
									
									if($i % 2 == 0) {	$class = "even"; }else{	$class="odd"; }
									$i++;
								?>
								<tr class="<?php echo $class;?>">
									<td><a target="_blank" href="<?php echo base_url();?>index.php/frontend/champion/view_fundraising/<?php echo $get_value['champ_id'];?>"><?php echo $get_value['title'];?></a></td>
									<td><?php echo $get_value['charity_name'];?></td>
									<td><?php echo $get_value['display_name'];?></td>
									<td><?php echo $get_value['donation_amount'];?></td>
									<td>#<?php echo $get_value['order_id'];?></td>
									<!--<td><?php echo date("jS F, Y", strtotime($get_value['txn_date']));?></td>-->
									<td>
										<?php 
											if($get_value['txn_number']){
												echo $get_value['txn_number'];
											}else{
												echo "txn failed";
											}												
										?>
									</td>
									<td colspan="2">
										<a href="<?php echo $this->config->item('view_donation_details').'/'.$get_value['id'];?>">Details</a>
										|
										<?php if($get_value['status'] == 1){ ?>
											<a target="_blank" href="<?php echo $this->config->item('base_url')?>assets/donation_pdf/<?php echo "Receipts-".$get_value['order_id'].".pdf";?>">Receipt</a>
										<?php }else{
											echo "Receipt";
										}?>
									</td>
									</tr>
								<?php } }else{ ?>
								<tr>
									<td colspan="8"><?php echo "No records are available";?></td></tr><?php
								 } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="pag">
                   <div class="col-md-12">
						<?php echo $this->pagination->create_links(); ?>
                   </div>
                   </div>
			</div>
		</div>
	</div>
</div><!--Content-->


<script>
	function page_count_check(){
		 document.getElementById("my_donation_form").submit();
	}
	
	function clear_search_form(){
		document.getElementById('search_by_order_id').value = "";
		document.getElementById('search_by_transact_id').value = "";
		document.getElementById('per_page').value = "20";
		
		document.getElementById("my_donation_form").submit();
	}
</script>