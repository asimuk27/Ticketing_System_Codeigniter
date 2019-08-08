 <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>



      <script>
        $(document).ready(function(){
          var events_list=[];

        	 $.ajax({
  				  type: "post",
				  url: "<?php echo base_url(); ?>index.php/frontend/champion/champion_event_list",
				  cache: false,  
  				  success: function(json){ 
               	     var obj = jQuery.parseJSON(json);
					 $.each(obj, function(key,value) {
					 	var val=value.title;
					 	if(jQuery.inArray(val, events_list) !== -1)
					 	{

					 	}
					 	else
					 	{
					 		events_list.push(value.title);
					 		//alert(events_list);
					 	}
                     
                     
							  
					
 					 
					});
   				  },
 				  error: function(){      
  				  alert('Error while request..');
 				  }
 				});


            $( "#automplete-3" ).autocomplete({
               source:events_list
            });

            $('#sub_val').click(function(){ $('#search_eve').submit(); });

           

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



					<div class="col-md-6 col-sm-6">



						<h2>My Champions Pages</h2>



					</div>



					<div class="col-md-6 col-sm-6">



						<ul>



							<li>



								<a href="#"><i class="fa fa-home"></i>Home</a>



							</li>



							<li>



								<a href="#"><i class="fa fa-angle-right"></i>My Champion Pages</a>



							</li>



						</ul>



					</div>



				</div>



				<!--ROW END-->



			</div>



		</div>



		<!--Kode-our-speaker-heading End-->



		<?php 
			//echo "<pre>";
			//print_r($data);exit;
		?>
		<div class="kode-blog-style-2">
		  <div class="container">
					<!--<h4>My Champion Pages</h4>-->
                <div class="row">
           	    <div class="col-md-12">



                       <div class="input-group stylish-input-group">


                       		<form id="search_eve" method="post" action="<?php echo base_url(); ?>index.php/frontend/champion/manage_champions">
                            <input type="text" class="search_events form-control"  placeholder="Search for Events" id="automplete-3" name="event_name">
                           
                             </form>


                            <span class="input-group-addon">



                                <button type="submit" id="sub_val">



                                    <span class="search_logo"><img src="<?php echo base_url();?>assets/image_uploads/default_images/search_icon.png" width="18" height="18" alt=""></span>



                                </button>  
                                


                            </span>



                        </div>



                  </div>



                </div>
                <br class="clear">
                <div class="row">
                    <div class="col-md-12 tabbing_box_attach">



                        <ul class="nav nav-tabs">



                            <li class="active"><a class="active" data-toggle="tab" href="#publish" >Live</a></li>



                            <li><a data-toggle="tab" href="#saved" >Pending</a></li>



                            <li><a data-toggle="tab" href="#past">Past</a></li>



                        </ul>



                    </div>



                    	<div class=" manage_event_tab tab-content">



                   		 	<div id="publish" class="tab-pane fade in active">



                                <div class="col-md-12 tab_border_div">

                                    <?php foreach($data as $get_value){
										
									
							if($get_value['image_path'] != ""){
								$profile_image = $this->config->item('frontend_profileimage_path').$get_value['image_path'];
							}else if($get_value['facebook_image_path'] != ""){
								$profile_image = $get_value['facebook_image_path'];
							}else{
								$profile_image = $this->config->item('frontend_profileimage_path').'/noimage.gif';
							}
						
                                          if($get_value['status']==1){
                                     ?>

                                    <div class="gray_desc_box">



                                        <div class="row">



                                            <div class="col-md-6 col-sm-6">



                                                <div class="row">



                                                    <div class="col-md-12">

                                                       <img style="width:400px;height:200px;" src="<?php echo $profile_image; ?>" alt=""/>
                                                    </div>



                                                </div>



                                            </div>



                                            



                                            <div class="col-md-6 col-sm-6">

    										 <h5><?php echo $get_value['display_name']; ?></h5>



                                                     



                                                        <p class="paragraph text-left text-primary" style="margin-top:5px"><?php echo $get_value['title']; ?></p>



                                                        <p class="paragraph text-left">Created On : <?php echo  $get_value['created_date']; ?></p>


                                                           <div class="row">



                                                         
															


                                                            <div class="col-md-3 col-sm-4 col-xs-6">



                                                            <a href="<?php echo $this->config->item('fe_champions_view')."/".$get_value['id']; ?>" class="three_inline_buttons">View</a>



                                                            </div>
														


                                                        </div>



                                            	
                        


                                            </div>



                                        </div>



                                    </div>
                                      <br class="clear">
                                   <?php } 
                                     }

                                   ?>


                                 


                                    <br class="clear">




                                 



                                </div>



                        	</div>



                            <div id="saved" class="tab-pane fade in">



                               <div class="col-md-12 tab_border_div">

                                    <?php foreach($data as $get_value){
                                          if($get_value['status']==0){
                                     ?>

                                    <div class="gray_desc_box">



                                        <div class="row">



                                            <div class="col-md-6 col-sm-6">



                                                <div class="row">



                                                    <div class="col-md-12">

                                                       <img style="width:400px;height:200px;" src="<?php echo $profile_image; ?>" alt=""/>

                                                      


                                                     


                                                    </div>



                                                </div>



                                            </div>



                                            



                                            <div class="col-md-6 col-sm-6">

    										 <h5><?php echo $get_value['display_name']; ?></h5>



                                                     



                                                        <p class="paragraph text-left text-primary" style="margin-top:5px"><?php echo $get_value['title']; ?></p>



                                                        <p class="paragraph text-left">Created On : <?php echo  $get_value['created_date']; ?></p>


                                                           <div class="row">



                                                         
															


                                                            <div class="col-md-3 col-sm-4 col-xs-6">



                                                            <a href="<?php echo $this->config->item('fe_champions_view')."/".$get_value['id']; ?>" class="three_inline_buttons">View</a>



                                                            </div>
														


                                                        </div>



                                            	
                        


                                            </div>



                                        </div>



                                    </div>
                                      <br class="clear">
                                   <?php } 
                                     }

                                   ?>


                                 


                                    <br class="clear">




                                 



                                </div>


                        	</div>
							<div id="past" class="tab-pane fade in">
                        	</div>
							


                        </div>



                    



                </div>



               	<br class="clear">



                <br class="clear">



		</div><!--Container-->



     </div>



     </div><!--Content-->
