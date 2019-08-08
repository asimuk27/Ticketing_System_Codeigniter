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
				<div class="blue_top">Organisation View</div>
				<?php
					//echo "<pre>";
					//print_r($data);
				?>
				<div class="table-responsive table_white_box" style="padding:25px;">
					<div class="kf_who_am center-block">
                        <div class="row margin_top">
                            <div class="col-md-4 col-md-offset-4">
                            <figure class="org_view center-block">
                                <img src="<?php echo $this->config->item('organisation_logo');?>/<?php echo $data['logo'];?>" alt="Image Here">
                                <figcaption class="blue_top kf_speaker_socil">
                                    <h4 class="text-center"><?php echo $data['first_name'];?> <?php echo $data['last_name'];?></h4>
                                </figcaption>
                            </figure>
                            </div>

                            <div class="col-md-8 col-md-offset-2">
                                <div class="kf_who_am_des text-center center-block" style="padding:0px;">

                                    <span><?php echo $data['organization_name'];?></span>
                                    <p><?php echo $data['charity_overview'];?></p>
                                    <ul class="list-unstyled center-block">
                                        <li>
                                            <strong>Charity Name</strong>
                                            <span><?php echo $data['charity_name'];?></span>
                                        </li>
										<li>
                                            <strong>Address</strong>
                                            <span><?php echo $data['street_address'];?></span>
                                        </li>
                                        <li>
                                            <strong>Phone</strong>
                                            <span><?php echo $data['phone'];?></span>
                                        </li>
                                        <li>
                                            <strong>Email</strong>
                                            <span><?php echo $data['email'];?></span>
                                        </li>

										 <?php foreach($ip_details as $details){ ?>
                                         <?php if($details['key_name']=='tc'){ ?>
                                         <li>
                                            <strong>TicketingSystem T&C</strong>
                                            <span><?php echo $details['date']." ".$details['time'];?> </span>
                                            <span><?php echo $details['ip_address'];?></span>

                                        </li>
                                         <?php } ?>
                                          <?php if($details['key_name']=='poli_tc'){ ?>
                                         <li>
                                            <strong>POLI T&C</strong>
                                             <span><?php echo $details['date']." ".$details['time'];?> </span>
                                            <span><?php echo $details['ip_address'];?></span>
                                        </li>
                                         <?php } ?>
                                          <?php if($details['key_name']=='direct_debit_tc'){ ?>
                                         <li>
                                            <strong>Direct Debit T&C</strong>
                                            <span><?php echo $details['date']." ".$details['time'];?> </span>
                                            <span><?php echo $details['ip_address'];?></span>
                                        </li>
                                         <?php } ?>

                                         <?php } ?>
                                    </ul>
									<span><input type="button" value="Edit" class="btn btn-primary save_btn extra_padding" onclick="edit_page(<?php echo $data['id'];?>);"></span>
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