<style>
.respose_style{
	padding:20px;
    color: #fff;
	background-color: #5cb85c; 
	border-color: #4cae4c; 
	font-weight:bold;
	margin-top:15px;
	text-align:center;
}
</style>
<div class="content">

		<!-- Kode-Header End -->

		<div class="sub-header">

			<!-- SUB HEADER -->

		</div>

<div class="Kode-page-heading">

	<div class="container">

		<!--ROW START-->

		<div class="row">

			<div class="col-md-6 col-sm-6">

				<h2>User Profile</h2>

			</div>
			

		</div>

		<!--ROW END-->

	</div>

</div>   

<div class="kf_content">

	<div class="container">
		<?php if($this->session->flashdata('msg')){ ?>
		<div class="row">		
			<div class="col-md-12 col-sm-12 col-xs-12 respose_style">
				<?php echo $this->session->flashdata('msg');?>
			</div>
		</div>
		<?php } ?>
		
		<div class="row">		

			<div class="col-md-12 col-sm-12 col-xs-12">

				<!--Who Am I Wrap Start-->

				<div class="kf_who_am center-block view_block_user">

					<div class="row">

						<div class="col-md-3 col-sm-4">

						 <figure class="">

                                <?php if($data->image_path=='' && $data->facebook_id!=''){ ?>
                               
                            <img id="blah" alt="" src="<?php echo $data->facebook_image_path; ?>"/>
                            <?php }
                                else if($data->image_path==''){ ?>

                              <img id="blah" alt=""  src="<?php echo $this->config->item('frontend_profileimage_path');?>/fundraising_profile.jpg"/>


                           <?php  }else{?>
                              <img id="blah" alt=""  src="<?php echo $this->config->item('frontend_profileimage_path');?><?php echo $data->image_path; ?>"/>
                            <?php } ?>           

                                <figcaption class="blue_top kf_speaker_socil">

                                    <h4 class="text-center"><?php echo $data->first_name;?> <?php echo $data->last_name;?></h4>

                                </figcaption>

                            </figure>

						</div>

						<?php 

							//echo "<pre>";

							//print_r($data);

						?>

						<div class="col-md-8 col-sm-8">
							<div class="text-center center-block">
								<ul class="user_view_ul">
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

								<br class="clear">
								<div class="view_page_edit">
									<input type="button" value="Edit" class="search_events  submit_btn" style="width:150px;" onclick="edit_page();">									
									<?php if($data->facebook_id ==''){;?>
										<input type="button" id="change" value="Change Password" class="search_events submit_btn"  onclick="change_page();" style="margin-left:10px;">
									<?php }else{};?>									
								</div>
								
								</div>
						</div>
					</div><!--row-->
				</div>
			</div>  
		</div>  
	</div>        

</div>

<script>
	function edit_page(id){
		window.location.href = '<?php echo $this->config->item('base_url')?>index.php/frontend/users/edit_user_profile';
	}

	function change_page(id){
		window.location.href = '<?php echo $this->config->item('base_url')?>frontend/users/change_user_password';
	}
	
	$(document).ready(function(){
		$(".respose_style").fadeOut(3000);
	});
</script>