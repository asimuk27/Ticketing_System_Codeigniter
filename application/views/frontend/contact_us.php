<style>
	.response_style{
        color: #5cb85c;
        font-weight:bold;
    }

	.failure_style{
        color: red;
        border-color: #4cae4c;
        font-weight:bold;
    }
</style>
 <script src="https://www.google.com/recaptcha/api.js" async defer></script>
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
						<h2>Contact Us</h2>
					</div>
				</div>
				<!--ROW END-->
			</div>

		</div>

		<!--Kode-our-speaker-heading End-->

		<div class="kode-blog-style-2">

			<div class="container">
				<div class="row">
					<div class="col-md-8">
						 <script src='https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyBK0eQ7Y2LugOD1v1S3n6emkWmRKdyoGqU'></script><div style='overflow:hidden;height:250px;width:100%;'><div id='gmap_canvas' style='height:450px;width:100%;'></div><style>#gmap_canvas img{max-width:none!important;background:none!important}</style></div> <a href='https://addmap.net/'>&nbsp;</a> <script type='text/javascript' src='https://embedmaps.com/google-maps-authorization/script.js?id=627f60b9c8c6beb35b24b566b10816eb40a57477'></script><script type='text/javascript'>function init_map(){var myOptions = {zoom:12,center:new google.maps.LatLng(-36.8574617,174.76204189999999),mapTypeId: google.maps.MapTypeId.ROADMAP};map = new google.maps.Map(document.getElementById('gmap_canvas'), myOptions);marker = new google.maps.Marker({map: map,position: new google.maps.LatLng(-36.8574617,174.76204189999999)});google.maps.event.addListener(marker, 'click', function(){infowindow.open(map,marker);});infowindow.open(map,marker);}google.maps.event.addDomListener(window, 'load', init_map);</script>


                        <div class="kode-contact-heading">
							<h4>Stay in Touch</h4>
							<p>Good relationships make good business. TicketingSystem wants to stay in touch with you. Please feel free to give us a call or send us a message and we will be happy to assist you.</p>
							<span class="border-left"></span>
						</div>
						<div class="kode-contact-area col-md-12">
                            <form method="post" class="comments-form row" id="contact_form" action="<?php echo base_url(); ?>index.php/frontend/cms/contact_send">
								<?php if($this->session->flashdata('msg')){ ?>
									<div class="row" id="msg_div">
										<?php echo $this->session->flashdata('msg'); ?>
									</div>
									<br class="clear">
								<?php } ?>
                            	<div class="row">
                                	<div class="col-md-6 col-sm-6">
                                    	<input type="text" id="name" name="name" class="form-control required" placeholder="Name" value="<?php echo set_value('name');?>" required>
                                       <?php echo form_error('name'); ?>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                    	<input type="email" id="email" name="email" class="form-control required email" placeholder="Email" value="<?php echo set_value('email');?>" required/>
  										   <?php echo form_error('email'); ?>
                                     </div>
                                     <div class="col-md-12 col-sm-12">
                                    	<input type="text" class="form-control" placeholder="Subject" value="<?php echo set_value('subject');?>" required>
                                    </div>
                                    <div class="col-md-12 col-sm-12">

                                    	<textarea class="form-control" name="message" id="message" placeholder="Message" value="<?php echo set_value('message');?>" required></textarea>

                                    	   <?php echo form_error('message'); ?>

                                    </div>

									<div class="col-md-12" style="margin-bottom:10px;">
										<div class="g-recaptcha" data-sitekey="6Lct7w0UAAAAAFzi8GzMBwxdwzlCAhPrG1jgHRTb"></div>
									</div>
                                </div>
								<button class="thbg-color" value="Send Reply">Submit</button>
                            </form>
						</div>
					</div>
					<div class="col-md-4">
                    	<div class="kode-ask-question">
                            <h3>Contact Details</h3>
							<p><b>Address of our Auckland Office</b></p>

							<p>7 St Benedicts Street,</p>
							<p>Eden Terrace,</p>
							<p>Auckland 1010</p>

							<p><b>Postal Address</b></p>
							<p>PO Box 6691</p>
							<p>Wellesley Street</p>
							<p>Auckland 1141</p>
							<p>New Zealand</p>
							<p><b>Phone</b></p>
							<p>+64 9 965-4905</p>
                        </div>
					</div>
				</div>
			</div>
		</div>
	</div>
