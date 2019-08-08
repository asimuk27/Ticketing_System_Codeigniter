<?php ?>
<style>
	.banner_img_div img{height:200px important;}
</style>
<!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid" style="background:#fff">
                <div class="row">
                    <div class="col-md-12">
                        <div class="right_first_box"><img src="<?php echo $this->config->item('admin_image_path');?>home.png"><a href="#">Home</a> > <a href="#">Manage Events</a> > <a href="org_edit.html">Events</a></div>
                    </div>
                   </div>
                   	<div class="banner_img_div" style="text-align:center;margin-top: 20px;">
                    	<img style="display:inline;" src="<?php echo $this->config->item('event_image').$event_info[0]['original_event_image']; ?>" class="img-responsive" alt="">
                	</div>
                    <br class="clear">
                    <div class="row blue_top">
                      <div class="col-md-10 col-sm-9 col-xs-9">
                        <?php $start_date = date_create($event_info[0]['event_start_date']); ?>
						<?php $start_time = date_create($event_info[0]['event_start_time']); ?>
						<?php $end_date = date_create($event_info[0]['event_end_date']); ?>
						<?php $end_time = date_create($event_info[0]['event_end_time']); ?>
						<h5 class="blue_txt text-left text-primary"><?php echo date_format($start_date,'l, F j \A\T ').date_format($start_time, 'g:i A').' - '.date_format($end_date,'l, F j \A\T ').date_format($end_time, 'g:i A');?></h5>
                      </div>
                        <div class="col-md-1 col-sm-1 col-xs-1">
                        <span class="share_icon"><!--i class="fa fa-share-alt fa-3" aria-hidden="true"></i--></span>
                        </div>
                        <div class="col-md-1 col-sm-2 col-xs-2">
                        <h5 class="blue_txt  text-right text-primary"><!--$ 70 --></h5>
                        </div>
                    </div>
                   <!--row end-->
                   <div class="row">
                        <div class="col-md-12">
                            <p class="search_events text-left">
                             <?php echo $event_info[0]['event_description']; ?>   
                            </p>
                        </div>
                    </div>
                    <div class="row">
                	<div class="col-md-2 col-sm-2 col-xs-3">
                    	<p class="paragraph text-left">Location :</h5>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-4">
                    	<p class="paragraph text-left"><?php echo $event_info[0]['event_location']; ?></h5>
                    </div>
                </div>
                <div class="row">
                	<div class="col-md-2 col-sm-2 col-xs-3">
                    	<p class="paragraph text-left">Organizer :</h5>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-4">
                    	<p class="paragraph text-left"><?php if(!empty($organisation_info)){ echo $organisation_info[0]['charity_name'];} ?></p>
                    </div>
                </div>
                <div class="row">
                	<div class="col-md-12">
                    	<div class="org_desc">
                        	<h4 class="text-left">ORGANIZER DESCRIPTION</h4>
                            <p class="search_events text-left">
                               <?php echo $event_info[0]['org_description'] ?>;
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row margin_top">
                   <div class="col-md-12">
                   <div class="blue_top">EVENTS DETAILS</div>
                   <div class="table-responsive table_white_box">
                   <table class="table table-striped">
                    <thead>
                       <tr class="text-center">
                        <th>Title</th>
                        <th>Start Date & Time</th>
                        <th>Event Type</th>
                        <th>Ticket Sold</th>                        
						</tr>
                    </thead>
                     <tbody>
                          <?php 
								if(isset($sub_event_info) && ($sub_event_info != "")){
									foreach($sub_event_info as $sub_event_data){
							?>
								<tr>
									<td><?php echo $sub_event_data['schedule_title'];?></td>
									<td><?php echo date("d-m-y", strtotime($sub_event_data['schedule_start_date']));?>
									<?php echo $sub_event_data['schedule_start_time'];?></td>
									
									<td><?php echo $sub_event_data['ticket_name'];?></td>
									<td><?php echo $sub_event_data['quantity_sold'];?>/<?php echo $sub_event_data['quantity'];?></td>                               
								</tr>
								<?php } } ?> 
                     </tbody>
                     </table>
                     </div>
                   </div>
                   </div>
                   <div class="row buttons">
                           <div class="col-md-12">                          
                           <div class="btn btn-primary" onclick="window.history.back();">Back</div>
                           </div>
             	   </div>
                    <br class="clear"><br>
                    <br class="clear"><br>
          </div>
      </div>
      </div>
          <br class="clear"><br>
        <!-- /#page-wrapper -->
<?php ?>