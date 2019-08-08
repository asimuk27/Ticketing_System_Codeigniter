	<div class="kode-slider">
		<div class="container">
		<div class="col-md-4">
			<div class="our-speaker-social-section">
				<h1 class="header-class">Ticketing & Fundraising <br> Made Easy!</h1>
				<p style="text-align:center;">TicketingSystem is the only platform for event ticketing and fundraising.<br>Proudly New Zealand owned and operated. <br>Designed to be simple, easy and more beneficial for your cause.</p>
			</div>
		</div>
		<div class="col-md-8">
		<ul class="bxslider-banner">
			<?php if(empty($get_banner_images)){ ?>

			<li>
				<img src="<?php echo $this->config->item('frontend_image_path');?>extra-images/image_01_2.jpg" alt="" />
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
				<img src="<?php echo $this->config->item('frontend_image_path');?>extra-images/image_02_2.jpg" alt="" />
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
		</div></div>
	</div>
	<div class="content">
		<div class="kode-overview-holder">
			<div class="container">
				<div class="row">
					<form method="post" action="<?php echo $this->config->item('base_url');?>event-listing">
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
							<button type="submit" value="Search" class="submit_btn special_sub">Search</button>
						</div>
					</form>
				</div>
				<div class="row">
					<div class="col-md-4 special_cols">
						<span class="popular_span">Popular Events:</span>
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
						<div class="kode-event-blog3 story-small">
							<figure>
								<img src="<?php echo $this->config->item('event_image');?><?php echo $result['original_event_image'];?>" alt="<?php echo $result['original_event_image'];?>" class="event_image_height"/>
								<div class="kode-fig-capstion">
                                    <a href="<?php echo $this->config->item('base_url').'view-event/'.$result['event_id']; ?>"><span class="big_font"><?php echo $header_status;?></span></a>
								</div>
							</figure>
							<div class="kode-thumb-caption">
								<h4><?php echo strtoupper(substr($result['event_main_title'],0,25));?></h4>
								<ul>
									<li>
										<a href="#"><span class="fa fa-calendar"></span>
											<?php
												echo date("M j / Y", strtotime($result['event_start_date']));
											?>
										</a>
									</li>
									<li><a href="#"><span class="fa fa-location-arrow"></span><?php echo substr($result['event_location'],0,25);?></a></li>
								</ul>
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

	</div></div>
	<script>
	$(document).ready(function() {
    $('.story-small img').each(function() {
     //   var maxWidth = 100; // Max width for the image
        var maxHeight = 247;    // Max height for the image
        var ratio = 0;  // Used for aspect ratio
        var width = $(this).width();    // Current image width
        var height = $(this).height();  // Current image height

        // Check if the current width is larger than the max
      /*   if(width > maxWidth){
            ratio = maxWidth / width;   // get ratio for scaling image
            $(this).css("width", maxWidth); // Set new width
            $(this).css("height", height * ratio);  // Scale height based on ratio
            height = height * ratio;    // Reset height to match scaled image
            width = width * ratio;    // Reset width to match scaled image
        } */

        // Check if current height is larger than max
        if(height > maxHeight){
            ratio = maxHeight / height; // get ratio for scaling image
            $(this).css("height", maxHeight);   // Set new height
            $(this).css("width", width * ratio);    // Scale width based on ratio
            width = width * ratio;    // Reset width to match scaled image
            height = height * ratio;    // Reset height to match scaled image
        }
    });
});
</script>