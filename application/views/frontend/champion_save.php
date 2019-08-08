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
						&nbsp;
					</div>
					<div class="col-md-6 col-sm-6">
						&nbsp;
					</div>
				</div>
				<!--ROW END-->
			</div>
		</div>
		<!--Kode-our-speaker-heading End-->
		<div class="kode-blog-style-2">
		  	<div class="container">
                     <br class="clear">
                     <div class="white_desc_box ">
                     	<h4 class="text-center blue_txt">Thank You</h4>
                            <hr class="center-block hori_line">
                            <p class="paragraph text-center">       
								Thank you for submitting your request to be a champion in <?php echo $charity_data['event_name'];?>.
								<?php if($supporter_verification_status == 0){ ?>
									Your submission will be reviewed by <?php echo $charity_data['charity_name'];?> and you will be notified once it is approved
								<?php }else{ ?>
									Click <a href="<?php echo base_url(); ?>index.php/frontend/champion/view_fundraising/<?php echo $result;?>">here</a> to view your champion page
								<?php } ?>
                            </p>                          
                     </div>
                    <br class="clear">
                    <br class="clear">
			</div><!--Container-->
        </div>
     </div><!--Content-->
	