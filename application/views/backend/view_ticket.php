<style>
	.kf_who_am_des ul li{text-align:left;}
	.extra_padding{padding:6px 50px;}
</style>

<div id="page-wrapper">
<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="right_first_box"><img src="<?php echo $this->config->item('admin_image_path');?>home.png"><a href="<?php echo $this->config->item('login_url');?>">Home</a> > <a href="<?php echo $this->config->item('admin_organiser');?>">Manage Organisation</a> > <a href="#">Organisation View</a></div>
			</div>
	   </div>
	   <div class="row margin_top margin_bottom">
			<div class="col-md-12">
				<div class="blue_top">View Ticket</div>		
				<?php 
					//echo "<pre>";
					//print_r($data);
				?>
				<div class="table-responsive table_white_box" style="padding:25px;">
					<div class="kf_who_am center-block">
                        <div class="row margin_top">   
                            <div class="col-md-8">
                                <div class="kf_who_am_des text-center center-block" style="padding:0px;">   
									<ul class="list-unstyled center-block">
                                        <li>
                                            <strong>Charity Name</strong>
                                            <span></span>
                                        </li>
										<li>
                                            <strong>Address</strong>
                                            <span></span>
                                        </li>
                                        <li>
                                            <strong>Phone</strong>
                                            <span></span>
                                        </li>
                                        <li>
                                            <strong>Email</strong>
                                            <span></span>
                                        </li>                                        
                                    </ul>									
                                </div>								
                            </div>
							
                        </div><!--row   IMG_09082016_112041.png      brand_logo4.png -->						
                    </div>
				</div>				
				
			</div>
		</div>
					
					
<script>
	function edit_page(id){
		window.location.href = '<?php echo $this->config->item('edit_organiser_profile')."/";?>'+id;
	}
</script>