<style>
	hr{margin:5px;}
	.table{width:100%;}
	.email_class{width:35%;text-align:left;}
	.spon_class{width:25%;}
	.table td{border:1px solid #ddd !important;padding:10px !important;}
	.table th{border:1px solid #ddd !important;padding:10px !important;}
	.table_white_box{margin:15px 0;}
	.event-details{margin-top:12px;}
</style>

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

						<h2>Event Statistics</h2>

					</div>

				</div>

				<!--ROW END-->

			</div>

		</div>

		<!--Kode-our-speaker-heading End-->

		<div class="kode-blog-style-2" style="min-height:300px;">

		  	<div class="container">            
				<div class="col-md-6">					
					<div class="row">
						<div class="col-md-3">
							<label for="search_select_event" class="search_events">Event</label>
						</div>
						<div class="col-md-6">
							<form method="post">                                          
								<select id="search_select_event" class="search_events form-control event_dropdown dropdown" name="search">
									<option value=""> -- All -- </option>
									<?php foreach($get_all_events as $events){ ?>
										<option <?php if($event_id!=''){ if($event_id==$events['id']){ echo "selected"; } } ?> value="<?php echo $events['id']; ?>" > <?php echo $events['title']; ?></option>
									<?php } ?>
								</select>
							</form>
						</div>
					</div>					
					<div class="row">
						<div class="col-md-3">
							<label for="search_select" class="search_events">Sub Event</label>
						</div>
						<div class="col-md-6">
							<form method="post">
								<select id="search_select" class="search_events form-control dropdown auto_submit_item" name="search">
										<option value="all"> -- ALL -- </option>
										<?php foreach($set_dropdown_data as $sub){ ?>
											<option <?php if(isset($_POST['search']) && $_POST['search']==$sub['id']){ echo "selected"; } ?> value="<?php echo $sub['id']; ?>" > <?php echo $sub['schedule_title']; ?></option>
										<?php } ?>
								</select>
							</form>
						</div>
					</div>					
                </div>   
				<div class="clear"></div>
				
				 <?php if(!empty($event_id)){  ?>
				 <hr>
                    	<div class="col-md-12">
                            <p class="paragraph event-details"><?php echo $get_event_info['title'].',<br>'.$get_event_info['event_location']; ?><br><?php $timestamp = $get_event_info['event_start_date'];
                           $timestamp2 = $get_event_info['event_end_date'];
							echo date("F jS, Y", strtotime($timestamp)); ?> AT <?php echo $get_event_info['event_start_time'];?> | <?php $timestamp = $get_event_info['event_end_date'];
													   $timestamp2 = $get_event_info['event_end_date'];

							echo date("F jS, Y", strtotime($timestamp)); ?> AT <?php echo $get_event_info['event_end_time'];?></p>
                        </div>    
                        <?php } ?> 
                <?php if(!empty($event_id)){  ?>
				<div class="clear"></div>
                   <hr>
             	       <div class="col-md-12">

                                            <div class="search_events table_white_box">

                                                <h5 class="paragraph">Event Statistics</h5>

                                                <div class="row">

                                                    <div class="col-md-4 col-sm-4">

                                                        <div class="list-group">

                                                          <label for="email" class="search_events">Ticket Sales</label>

       <div  class="list-group-item">Paid<span class="price_tag_list"><i class="fa fa-usd" aria-hidden="true"></i> <?php echo number_format($data['ticket_sales'],2); ?></span></div>

                                                        </div>



                                                    </div>

                                                    <div class="col-md-4 col-sm-4">

                                                        <div class="list-group">

                                                          <label for="email" class="search_events">Tickets Booked</label>

                                                          <div  class="list-group-item">Free<span class="price_tag_list"><i class="fa fa-ticket" aria-hidden="true"></i> <?php echo $data['get_free_tickets']; ?></span></div>

                                                          <div  class="list-group-item list-group-item-action">Paid<span class="price_tag_list"><i class="fa fa-ticket" aria-hidden="true"></i> <?php echo $data['get_paid_tickets']; ?></span></div>

                                                          <div  class="list-group-item list-group-item-action">Donation<span class="price_tag_list"><i class="fa fa-ticket" aria-hidden="true"></i> <?php echo $data['get_donation_tickets']; ?></span></div>





                                                          <div  class="list-group-item list-group-item-action">Total<span class="price_tag_list"><i class="fa fa-ticket" aria-hidden="true"></i> <?php echo $data['get_donation_tickets']+$data['get_free_tickets']+$data['get_paid_tickets']; ?></span></div>

                                                        </div>



                                                    </div>

                                                    <div class="col-md-4 col-sm-4">

                                                        <div class="list-group">

                                                          <label for="email" class="search_events">Tickets Available</label>

                                                          <div  class="list-group-item ">Free<span class="price_tag_list"><i class="fa fa-ticket" aria-hidden="true"></i> <?php echo $get_pending_tickets['pending_free_tickets']; ?></span></div>

                                                           <div  class="list-group-item ">Paid<span class="price_tag_list"><i class="fa fa-ticket" aria-hidden="true"></i> <?php echo $get_pending_tickets['pending_paid_tickets']; ?></span></div>

                                                            <div  class="list-group-item ">Donation<span class="price_tag_list"><i class="fa fa-ticket" aria-hidden="true"></i> <?php echo $get_pending_tickets['pending_donation_tickets']; ?></span></div>

                                                            <div  class="list-group-item ">Total<span class="price_tag_list"><i class="fa fa-ticket" aria-hidden="true"></i> <?php echo $get_pending_tickets['pending_donation_tickets']+$get_pending_tickets['pending_paid_tickets']+$get_pending_tickets['pending_free_tickets']; ?></span></div>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>

                                    </div>

								<hr>
            	       <div class="col-md-12">
							<div class="search_events table_white_box">
								<h5 class="paragraph">Donation Statistics</h5>														
								<div class="row">
									<div class="col-md-4 col-sm-4">
										<div class="list-group">
										  <label class="search_events">Donation Summary</label>
										  
										  <div  class="list-group-item">Total Number Of Supporters<span class="price_tag_list">
											
											<?php echo $main_summary['0']['total_supporters']; ?></span>
										  </div>
										  
										   <div  class="list-group-item">Total Number Of Donations<span class="price_tag_list">
											 
											<?php echo $main_summary['0']['total_donations']; ?></span>
										  </div>
										  
										  <div  class="list-group-item">Total Value Of Donations<span class="price_tag_list">
											<i class="fa fa-usd" aria-hidden="true"></i><?php echo number_format($main_summary['0']['total_donation_value'],2); ?></span>
										  </div>
										  
										  <div  class="list-group-item">Max Donation Amount<span class="price_tag_list">
											<i class="fa fa-usd" aria-hidden="true"></i><?php echo number_format($main_summary['0']['maximiun_donation'],2); ?></span>
										  </div>
										
										  <div  class="list-group-item">Average Donation Amount<span class="price_tag_list">
											<i class="fa fa-usd" aria-hidden="true"></i><?php echo round($main_summary['0']['average'],2); ?></span>
										  </div>
										</div>
									</div>
									<br class="clear">
									<div class="col-md-4 col-sm-4">
										<div class="list-group">
										  <label class="search_events">Top 20 Champions</label>
										  
										  <div  class="list-group-item"><b>Name</b><span class="price_tag_list">
											<b>Amount</b></span>
										  </div>										  
										   
										   <?php foreach($champion_data as $data){ ?>
												<div  class="list-group-item"><?php echo $data['display_name'];?><span class="price_tag_list"><i class="fa fa-usd" aria-hidden="true"></i><?php echo number_format($data['total_donation_received'],2);?></span>
												</div>	
										   <?php } ?>	
										</div>
									</div>
									<div class="col-md-8 col-sm-8 table-responsive">										
										<label class="search_events">Top 20 Supporters</label>
										<table class="table">
											<tr>
												<th class="spon_class">Name</th>
												<th class="email_class">Email</th>
												<th>Champions</th>
												<th>Amount</th>
											</tr>														
											<?php foreach($sponsor_data as $data_s){ ?>
											<tr>
												<td><?php echo $data_s['first_name'];?></td>
												<td class="email_class"><?php echo $data_s['email'];?></td>
												<td><?php echo $data_s['support_count'];?></td>
												<td><?php echo number_format($data_s['amount'],2);?></td>
											</tr>
											<?php } ?>
										</table>										
									</div>
									
									<?php 
									//	echo "<pre>";
										//print_r($sponsor_data);
									?>
									
								</div>
							</div>
                        </div>
                        <?php } ?>

                    </div>

            </div><!--Container-->

        </div>

     </div><!--Content-->





     <script>

       $(document).ready(function(){



           $(".auto_submit_item").change(function() {



                 $("form").submit();





            });
        

            $(".event_dropdown").change(function() {

               var evt_id=$(this).val();

                window.location.href = "<?php echo base_url(); ?>frontend/statistics/index/"+evt_id;





            });




       });

     </script>
