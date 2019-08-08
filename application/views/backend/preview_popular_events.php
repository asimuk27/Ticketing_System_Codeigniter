
        <div id="page-wrapper">
         	<div class="container-fluid" style="background:#fff">
            	<div class="row">
                	<div class="col-md-12">
                      <div class="right_first_box"><img src="<?php echo $this->config->item('admin_image_path');?>home.png"><a href="#">Home</a> > <a href="#">Event Management</a> > 
                            <a href="org_view.html">Popular Events</a>
                        </div>
                    </div>
                    <div class="col-md-12 margin_top">
                    	<div class="blue_top">POPULAR EVENTS</div>
                    </div>
					<?php foreach($data as $popular_events){ ?>
						<div class="col-md-4">
							<div class="hovereffect">
								<img style="height:211px;width:359px;" src="<?php echo $this->config->item('event_image');?><?php echo $popular_events['original_event_image'];?>" class="img-responsive" alt="">
								<div class="overlay">
								   <a class="info" href="<?php echo $this->config->item('admin_view_events').'/'.$popular_events['id'];?>" target="_blank"><b>View</b></a>
								</div>
							</div>
							<div class="kode-thumb-caption">
								<h4><?php echo strtoupper($popular_events['title']);?></h4>
								<ul class="list-inline">
									<li><i class="fa fa-calendar"></i><?php 
												echo date("M j / Y", strtotime($popular_events['event_start_date']));
											?></li>
									<li><i class="fa fa-location-arrow"></i><?php echo substr($popular_events['event_location'],0,20);?></li>
								</ul>
								<!--<span><a href="event-detail.html">Read More</a></span>-->
							</div>
						</div> 
					<?php } ?>
                </div>
            </div>   
      	</div>
      </div>
          <br class="clear"><br>
        