

<div id="page-wrapper">
<div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="right_first_box"><img src="<?php echo $this->config->item('admin_image_path');?>home.png"><a href="<?php echo $this->config->item('login_url');?>">Home</a> > <a href="<?php echo $this->config->item('admin_organiser');?>">Manage User</a> > <a href="#">User View</a></div>
            </div>
       </div>
       <div class="row margin_top margin_bottom">
            <div class="col-md-12">
                <div class="blue_top">User View</div>       
                <?php 
                 
                ?>
                <div class="table-responsive table_white_box" style="padding:25px;">
                    <div class="kf_who_am center-block">
                        <div class="row margin_top">
                            
                            <div class="col-md-4 col-md-offset-4">
                            <figure class="org_view center-block">
                                <?php if($data->image_path!=''){?>
                                <img src="<?php echo $this->config->item('frontend_profileimage_path');?><?php echo $data->image_path; ?>" alt="Image Here">
                                  <?php } ?>            
                                <figcaption class="blue_top kf_speaker_socil">
                                    <h4 class="text-center"><?php echo $data->first_name;?> <?php echo $data->last_name;?></h4>
                                </figcaption>
                            </figure>
                            </div>
                           
                                       
                            <div class="col-md-8 col-md-offset-2">
                                <div class="kf_who_am_des text-center center-block" style="padding:0px;">                                
                                    
                                   
                                    <ul class="list-unstyled center-block">
                                        <li>
                                            <strong>Name</strong>
                                            <span><?php echo $data->first_name." ".$data->last_name;?></span>
                                        </li>
                                        <li>
                                            <strong>Preferred Name</strong>
                                            <span><?php echo  $data->preffered_name;?></span>
                                        </li>
                                        <li>
                                            <strong>Email</strong>
                                            <span><?php echo $data->email;?></span>
                                        </li>
                                        <li>
                                            <strong>Street Address</strong>
                                            <span><?php echo $data->street_address;?></span>
                                        </li>  
                                         <li>
                                            <strong>Suburb</strong>
                                            <span><?php echo $data->suburb;?></span>
                                        </li>      
                                         <li>
                                            <strong>City</strong>
                                            <span><?php echo $data->city;?></span>
                                        </li>        
                                         <li>
                                            <strong>Country</strong>
                                            <span><?php echo $data->country;?></span>
                                        </li>                                 
                                    </ul>
                                    
                                </div>                              
                            </div>
                            
                        </div><!--row   IMG_09082016_112041.png      brand_logo4.png -->                        
                    </div>
                </div>
                
                
            </div>
        </div>
                    
                    
