<style>
	.kode-overview-holder{padding-top:30px;}
	.special_padding{padding:0px !important;}
	.kf_accordian_des p{word-break: keep-all;}
	.header_none{display:none;}
	.event_list_image{height:247px !important;}
	.submit_btn{padding:9px 29px !important;}
	.pop_events{color:#666;font-weight:bold;font-size:20px !important;}
	.pop_events_div{margin-bottom:10px;}
</style>
	<div class="kode-slider">
		<h1 class="header_none"></h1>
		<ul class="bxslider-banner">
			<?php if(empty($get_banner_images)){ ?>

			<li>
				<img src="<?php echo $this->config->item('frontend_image_path');?>extra-images/image_01_2.jpg" alt="image_01_2.jpg" />
				<div class="kode-content">
					<div class="container">
						<div class="row">
							<div class="kode-slider-content">
								<h2>Half Marathon NZ. 2016</h2>
								<div class="overflow">
									<h3>November  25 - 26</h3>
									<h3 class="right-float">Joine The Event</h3>
								</div>
							</div>
						</div>
					</div>
				</div>
			</li>
			<li>
				<img src="<?php echo $this->config->item('frontend_image_path');?>extra-images/image_02_2.jpg" alt="image_01_2.jpg" />
				<div class="kode-content">
					<div class="container">
						<div class="row">
							<div class="kode-slider-content">
								<h2>Epic Swim Auckland 2016</h2>
								<div class="overflow">
									<h3>November  20 - 23</h3>
									<h3 class="right-float">Joine The Event</h3>
								</div>
							</div>
						</div>
					</div>
				</div>
			</li>
			<?php }else{ ?>
				 <?php foreach($get_banner_images as $images){?>
				   <li>
					<img src="<?php echo base_url(); ?>assets/image_uploads/banner_images/<?php echo $images['image_name']; ?>" alt="<?php echo $images['image_name']; ?>" />
				   </li>
			<?php } ?>
			<?php } ?>
		</ul>
	</div>
	<div class="content">
		<div class="kode-overview-holder">
			<div class="container">
				<div class="row">
					<form method="post" action="<?php echo $this->config->item('search_events');?>">
						<div class="col-md-3 col-sm-3">
							<select class="search_select" id="category_name" name="category_name">
								<option value="">Select Category</option>
								<option value="1">Sports</option>
								<option value="2">Music</option>
								<option value="3">Entertainment</option>
								<option value="4">Games</option>
							</select>
						</div>
						<div class="col-md-3 col-sm-3"><input class="form-control" name="event_name" id="event_name" type="text" placeholder="Event Name"></div>
						<div class="col-md-2 col-sm-2"><input name="event_location" id="event_location" type="text" placeholder="Location" class="form-control"></div>
						<div class="col-md-2 col-sm-2">
							<select class="search_select" name="date_selection" id="date_selection">
								<option value="">-- Please Select --</option>
								<option value="1">Today</option>
								<option value="2">Tomorrow</option>
								<option value="4">This Week</option>
								<option value="5">This Weekend</option>
								<option value="7">Next Week</option>
								<option value="30">After This Month</option>
							</select>
						</div>
						<div class="col-md-2 col-sm-2">
							<button type="submit" value="Search" class="submit_btn">Search</button>
						</div>
					</form>
				</div>
				<div class="row">
					<div class="col-md-4 pop_events_div">
						<span class="pop_events"><h1 class="pop_events">Popular Events:</h1></span>
					</div>
				</div>
				<!--FIRST ROW START-->
				<div class="row">
					<!--COL-MD-4 START-->

						<?php if(isset($data) && (!empty($data))){ ?>
					<?php foreach($data as $result){
						if($result['status'] == "4"){
							$header_status = "Closed";
						}else if($result['status'] == "5"){
							$header_status = "Cancelled";
						}else if($result['status'] == "3"){
							$header_status = "Suspended";
						}else{
							$header_status = "Book";
						}
					?><div class="col-md-4">
						<!--KODE_EVENT_BLOG2 START-->
						<div class="kode-event-blog3">
							<figure>
								<img src="<?php echo $this->config->item('event_image');?><?php echo $result['original_event_image'];?>" alt="event_image" class="event_list_image"/>
								<div class="kode-fig-capstion">
									<a href="<?php echo $this->config->item('fe_view_event').'/'.$result['id']; ?>"><b><?php echo $header_status;?></b></a>
								</div>
							</figure>
							<div class="kode-thumb-caption">
								<h4><?php echo strtoupper(substr($result['title'],0,25));?></h4>
								<ul>
									<li>
										<a href="#"><i class="fa fa-calendar"></i>
											<?php
												echo date("M j / Y", strtotime($result['event_start_date']));
											?>
										</a>
									</li>
									<li><a href="#"><i class="fa fa-location-arrow"></i><?php echo substr($result['event_location'],0,25);?></a></li>
								</ul>
								<!--<span><a href="event-detail.html">Read More</a></span>-->
							</div>
						</div>
						<!--KODE_EVENT_BLOG2 START-->
				</div>
					<?php
						} }
					?>
					<!--COL-MD-4 END-->

					<!--COL-MD-4 END-->
			</div>
		</div>
		<!--Faq Wrap Start-->
        <div class="kf_faq_bg">
        	<div class="container">
            	<div class="kf_heading_1">
                	<h2>FAQs</h2>
                    <span class="special_padding">&nbsp;</span>
                </div>

                <div class="row">
					 <div class="col-md-12">
                    	<div class="kf_faq_accordian">
                        	<div class="kf_accordian_hdg accordion" id="section1">
                            	<h5>Who is TicketingSystem?</h5>
                            </div>
                            <div class="kf_accordian_des">
                            	<p>TicketingSystem is a product of Telelink Limited. Telelink Contact Centres were established in 1993 and have worked in Charity, Corporate and Government sectors for over 23 years. Telelink values feedback from its clients and have listened to their needs to provide a facility that connects their clients and customers to help each other. We are proud to produce TicketingSystem and we believe it will improve the experience to run events, fundraise and connect for sponsorship.</p>
                            </div>
                        </div>
                    </div>
					<div class="col-md-2 col-sm-2">
						<button type="button" onclick="location.href = '<?php echo base_url();?>/frontend/cms/faq';" value="Search" class="submit_btn">More FAQ's</button>
					</div>

                </div>

            </div>
        </div>
	</div>
