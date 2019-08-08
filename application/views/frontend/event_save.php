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
							<?php 
								if($this->session->flashdata('event_id') != ''){
									$id = $this->session->flashdata('event_id');
								}else{
									$id = "";
								}
							 if($id){ ?>
							 Congratulations, You have successfully saved your event ! Click <a target="_blank" href="<?php echo $this->config->item('fe_view_event').'/'.$id; ?>">here</a> to view your event</p> 
							 <?php 
								}else{								 
									redirect('frontend/home', 'refresh');	
								} 
							 ?>
                     </div>
                    <br class="clear">
			</div><!--Container-->
        </div>
     </div><!--Content-->