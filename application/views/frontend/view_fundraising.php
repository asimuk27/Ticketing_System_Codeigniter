<script>
   $(document).ready(function(){
        var img = $("#your_banner_img");
        // Create dummy image to get real width and height
        $("<img>").attr("src", $(img).attr("src")).load(function(){
        $('#your_champ_img').attr('style','width:863px;height:292px');
        $('#your_banner_img').attr('style','width:863px;height:292px');
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
					<div class="col-md-10 col-sm-10">
						<h2><?php echo $data['title']; ?> - <?php echo $data['display_name'];?></h2>
					</div>				
				</div>
				<!--ROW END-->
			</div>
		</div>
		<!--Kode-our-speaker-heading End-->
		<div class="kode-blog-style-2">
	  	  <div class="container">
                <div class="two_img_banner">
                    <div class="row">
                            <div class="col-md-9 col-sm-9">
                             <img src="<?php echo $this->config->item('event_image').$event_image;?>" class="img-responsive" alt="your_banner_img" id="your_banner_img">	
                            </div>
                            <div class="col-md-3 col-sm-3">
								<?php 																	
									if($data['fundraising_image']){ 
										if(filter_var($data['fundraising_image'], FILTER_VALIDATE_URL)){
											$image_name = $data['fundraising_image'];
										}else{
											$image_name = $this->config->item('frontend_profileimage_path').'/'.$data['fundraising_image'];
										}
									}else{
										$image_name = $this->config->item('default_image_url').'/fundraising_profile.jpg';
									}										
								?>									
							   <img src="<?php echo $image_name;?>" class="img-responsive " alt="your_champ_img" id="your_champ_img">
                                <div class="name_bar">
                                    <h5 class="text-center"><?php echo $data['display_name'];?></h5>
                                </div>
                          </div>
                        
                    </div>
                </div>

         <div class="wrapper_box search_event ">
            <div class="row">
            <div class="col-md-2 col-sm-2">
              $<?php echo $data['target_amount'];?><br>
             <b> My Goal</b>
            </div>
             <div class="col-md-1 col-sm-2">
              $<?php echo $statistics_array['given'];?><br>
              <b>Given</b>
            </div>
            <div class="col-md-2 col-sm-2">
            $<?php 
				if($statistics_array['still_needed']){
					echo $statistics_array['still_needed'];
				}else{
					echo "0.00";
				}?>
			<br>
            <b> Still Needed</b>
            </div>
            <div class="col-md-2 col-sm-2">  
            <?php echo $statistics_array['no_of_donations'];?><br>
            <b>No. Of donations</b>
            </div>
            <div class="col-md-2 col-sm-2">
            $<?php echo round($statistics_array['avg_donations'],2);?><br>  
            <b>Average Donation</b>
            </div>
     
			<?php if($data['event_status'] == 1){ ?>
				<?php if($data['status'] == "1" && $data['delete_status'] == "0"){ ?>
				 <div class="col-md-3 col-sm-5">
				 <div class="search_event btn btn-success"><a style="color:white;font-weight:bold;" href="<?php echo $this->config->item('base_url').'frontend/donation_orders/view_donation/'.$data['id']; ?>">Give Now</a></div>
					<a style="color:white;font-weight:bold;" class="search_event btn btn-primary" href="#" onclick="
						window.open(
						  'https://www.facebook.com/sharer/sharer.php?app_id=1058287097627083&u='+encodeURIComponent(location.href), 
						  'facebook-share-dialog',
						  'width=626,height=436'); 
						return false;">
						Fb Share
					</a>
				 </div>
			<?php } } ?>
			
			
           
            
            </div>
            </div>
           <!-- <br class="clear">-->
            <br class="clear">
               <!--<h4 class="text-left"><?php echo $data['title']; ?></h4>-->
			    <div class="fundraise_jumbotron add_event_jumbotron event_desc_jumbotron jumbo_padding remove_margin_top">
				<?php echo $data['event_description'];?> 
			</div>
            <div class="fundraise_jumbotron add_event_jumbotron event_desc_jumbotron jumbo_padding">
            	<div class="row">
                	<div class="col-md-12 col-sm-12">
                    	<h5 class="text-left">Why I am a Champion ?</h5>
                            <p class="search_events text-left">
                                <?php echo $data['message'];?>
                            </p>
						<?php 						
						if(!empty($donation_data)){ ?>
                         <h5 class="text-left text-primary">Supported By</h5>
                         <br/>
                         <div class="row">
							<?php
							
							 foreach($donation_data as $donated_money){								
							?>
                         	<div class="col-md-8 col-sm-8" style="margin-bottom:5px;overflow: hidden;">
                            	<span class="search_events text-left">
                                	<i class="fa fa-users fund_raise_user" aria-hidden="true"></i><span class="paragraph"><?php echo $donated_money['first_name'];?></span>	&bull;	<span class="search_events text-success">Gave $<?php echo number_format($donated_money['donation_amount'],2);?></span>
                                    <br>
                                	<span class="fund_raise_amnt search_events text-muted"><?php echo $donated_money['donor_message'];?></span>
                                </span>                                											
                            </div>                           
                            <br class="clear">
                            <?php } } ?>
                         </div>	
						 
                    </div>
                 
                </div>
            </div>
          </div><!--Container-->
        </div>
     </div><!--Content-->
