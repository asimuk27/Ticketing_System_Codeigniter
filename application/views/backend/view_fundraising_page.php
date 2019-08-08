            <!-- Page Content -->
            <div id="page-wrapper">
             	<div class="container-fluid"  style="background:#fff">
                	
                    <div class="row">
                        <div class="col-md-12">
                            <div class="right_first_box"><img src="images/home.png"><a href="#">Home</a> > <a href="#">Manage Champions</a> > 
                                <a href="org_view.html">Fundraising Page View</a>
                            </div>
							
							<?php 
								//echo "<pre>";
								//	print_r($listing_data);
							?>
							
                        </div>
                        <div class="col-md-12">
						
						
                            <div class="row margin_top">
                            		<div class="fundraise_img">
                                        <div class="col-md-9 col-sm-9">
                                            <img src="<?php echo $this->config->item('event_image').$listing_data['event_image'];?>" class="img-responsive" alt="">	
                                        </div>
                                        <div class="col-md-3 col-sm-3">
											<?php 
												if($listing_data['image_path']){ 
													$image_name = $this->config->item('frontend_profileimage_path').'/'.$listing_data['image_path'];
												}else{
													$image_name = $this->config->item('default_image_url').'/fundraising_profile.jpg';
												}		
								
											?>
								
                                            <img src="<?php echo $image_name;?>" class="img-responsive" alt="">
                                            <div class="name_bar">
                                                <h5 class="text-center"><?php echo $listing_data['display_name']; ?></h5>
                                            </div>
                                        </div>
                                    </div>
                                
                            </div>
                        </div>
                        <div class="col-md-12">
                        	<div class="wrapper_box search_event ">
                               <div class="row">
                                    <div class="col-md-2 col-sm-2">
                                      $<?php echo $listing_data['target_amount']; ?><br>
                                     <b> My Goal</b>
                                    </div>
                                     <div class="col-md-1 col-sm-2">
                                      $0<br>
                                      <b>Given</b>
                                    </div>
                                    <div class="col-md-2 col-sm-2">
                                    $<?php echo $listing_data['target_amount']; ?><br>
                                    <b> Still Needed</b>
                                    </div>
                                    <div class="col-md-2 col-sm-2">  
                                    0<br>
                                    <b>No. Of donations</b>
                                    </div>
                                    <div class="col-md-2 col-sm-2">
                                    $0<br>  
                                    <b>Average Donation</b>
                                    </div>
                                    <!-- <div class="col-md-3 col-sm-5">
                                     <div class="search_event btn btn-success"><a href="donation.html">Give Now</a></div>
                                      <div class="search_event btn btn-primary">Share</div>
                                     </div>-->
                                </div>
                            </div>
                        </div><!--Col-md-12-->
                        <div class="col-md-12">
                        	<h4 class="blue_top heading"><?php echo $listing_data['title']; ?></h4>
                            <div class="org_desc bottom-margin">
                            	<div class="row">
                                	<div class="col-md-12">
                                    	<h4>My Story</h4>
                                    </div>
                                    <div class="col-md-12">
                                        <?php echo $listing_data['message']; ?>
                                    </div>                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--Page Wrapper-->
       <br class="clear">