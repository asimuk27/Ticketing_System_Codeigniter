<style>
	.submit_btn{width:100%;}
	.container input{margin-bottom:10px;}
	.submit_btn{margin-bottom:10px;}
	
	input[type="password"] {
		border: 1px solid rgb(185, 193, 204);
		color: #666;
		height: 43px;
		margin-bottom: 15px;
		padding: 8px 10px;
		width: 100%;
	}
	input[type="email"] {
		border: 1px solid rgb(185, 193, 204);
		color: #666;
		height: 43px;
		margin-bottom: 15px;
		padding: 8px 10px;
		width: 100%;
	}
	.error{color:red !important;}
	#user_login p{color:red !important;}
	
	.special_label label {font-weight:normal;cursor: pointer;}
	.special_label:hover{
		height:100%;
		opacity: 0.6;		
	}
</style>
<div class="content">
	<!-- Kode-Header End -->
		<div class="sub-header"></div>
		<div class="Kode-page-heading">
			<div class="container">
				<div class="row">
					<div class="col-md-6 col-sm-6">
						<h2>New Member SignUp</h2>
					</div>					
				</div>
			</div>
		</div>
		<div class="kode-blog-style-2" style="min-height:500px;">
			<div class="container">
                <div class="row" >
                    <div class="col-md-4 col-sm-8 col-xm-8"> 						 
                        <div class="submit_btn special_label kode-event-blog3" style="color:#fff;background:#00a4ef none repeat scroll 0 0;">
							<label for="user_sign_up">
								<b>Select this to register as -</b>
								<br>
								<b>Ticket Purchaser</b> (some one who buys ticket for event)
								<br>
								<b>Supporter</b> (someone who makes a donation to a champion)
								<br>
								<b>Champion</b> (someone who does peer to peer fundraising for event/cause)
							</label>
							<form method="post" action="<?php echo $this->config->item('base_url')?>frontend/login/user_sign_up">
								<input type="submit" style="display:none;" id="user_sign_up" name="user_sign_up">
							</form>
						</div>
                    </div>
					<br class="clear">					
                    <div class="col-md-4 col-sm-8 col-xm-8"> 						 
                        <div class="submit_btn special_label kode-event-blog3" style="color:#fff;background:#228B22 none repeat scroll 0 0;">
							<label for="org_sign_up">
								<b>Select this to register as an Organisation -</b>
								<br>
								<b>An Organisation</b> is an entity(business or non-profit) who wants to organise events and/or do peer-to-peer fundraising
							</label>
							<form method="post" action="<?php echo $this->config->item('base_url')?>frontend/login/organiser_sign_up">
								<input type="submit" style="display:none;" id="org_sign_up" name="org_sign_up">
							</form>
						</div>
                    </div>
                </div><!--outer row-->
			</div>
		</div>
	</div>
	
	
<!--- new html --->

<script>
	$(document).ready(function(){
		$(".respose_style").fadeOut(3000);
	});
	
	function call_func(){
		alert("result");
	}
 </script>