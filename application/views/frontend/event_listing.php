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
						<h2>Event Listing</h2>
					</div>					
				</div>
				<!--ROW END-->
			</div>
		</div>
		<!--Kode-our-speaker-heading End-->	
		<div class="kode-blog-style-2">
			<div class="container">
				<div class="row">
				<form action="<?php echo $this->config->item('base_url');?>event-listing" method="post">
					<div class="col-md-3 col-sm-3">
						<select class="search_select" name="category_name" id="category_name">
                            <option value="">-- Select Category --</option>
							<?php foreach($category_data as $event_categories){ ?>
		<option value="<?php echo $event_categories->id;?>" <?php if($_POST['category_name'] == $event_categories->id){ echo "selected";}?>><?php echo $event_categories->category_name;?></option>								
							<?php  } ?>
                        </select>
					</div>
					<div class="col-md-3 col-sm-3"><input class="form-control" name="event_name" id="event_name" type="text" placeholder="Event Name" value="<?php echo $_POST['event_name'];?>"></div>
					<div class="col-md-2 col-sm-2"><input class="form-control" name="event_location" id="event_location" type="text" placeholder="Event Location" value="<?php echo $_POST['event_location'];?>"></div>
					<div class="col-md-2 col-sm-2">
						<select class="search_select" name="search_by_date" id="search_by_date">
                            <option value="1" <?php //if($_POST['search_by_date'] == 1){ echo "selected";}?>>Today</option>
                            <option value="2" <?php //if($_POST['search_by_date'] == 2){ echo "selected";}?>>Tomorrow</option>
                            <option value="7" <?php //if($_POST['search_by_date'] == 7){ echo "selected";}?>>This Week</option>
                            <option value="14" <?php //if($_POST['search_by_date'] == 14){ echo "selected";}?>>Next Week</option>
                            <option value="30" <?php //if($_POST['search_by_date'] == 30){ echo "selected";}?>>After This Month</option>
                        </select>
					</div>	
					<div class="col-md-2 col-sm-2">
						<button type="submit" value="Search" class="submit_btn" style="padding:9px 29px;">Search</button>
					</div>
					</form>
				</div>		
				
				<div class="row" style="min-height:400px;">	
				<?php if(isset($listing_data) && (!empty($listing_data))){ 
					 foreach($listing_data as $data){					
						if($data['status'] == "4"){
							$header_status = "Closed";								
						}else if($data['status'] == "5"){
							$header_status = "Cancelled";						
						}else{
							$header_status = "Book";							
						}	
					?>	
					<div class="col-md-4">
						<div class="kode-event-blog3">
							<figure>
								<img style="height:247px;" src="<?php echo $this->config->item('event_image');?><?php echo $data['original_event_image'];?>" alt=""/>
								<div class="kode-fig-capstion">								
									<a href="<?php echo $this->config->item('base_url').'view-event/'.$data['id']; ?>"><b><?php echo $header_status;?></b></a>
								</div>
							</figure>
							<div class="kode-thumb-caption">								
								<h4><?php echo substr($data['title'],0,35);?></h4>
								<ul>
									<li>
										<a href="#"><i class="fa fa-calendar"></i>
											<?php 													
												echo date("M j / Y", strtotime($data['event_start_date']));
											?>
										</a>
									</li>
				<li><a href="#"><i class="fa fa-location-arrow"></i><?php echo substr($data['event_location'],0,20);?></a></li>
								</ul>								
							</div>
						</div>
					</div>
				<?php } }else{
					?>
						<div class="col-md-4">
							No events found matching your criteria
						</div>
				<?php } ?>
				</div>
				
			</div>
		</div>
		<!--KODE-EVENT-SHEDULE END-->	
	</div>