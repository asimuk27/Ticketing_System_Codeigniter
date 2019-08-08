<style>
    label {        font-weight: normal;
    }
    span{
        color:red;
        font-weight: bold;
    }
    input[type="password"] {
        border: 1px solid rgb(185, 193, 204);
        color: #666;
        height: 43px;
        margin-bottom: 15px;
        padding: 8px 10px;
        width: 100%;
    }
    .error{
        color:red;
    }

    .respose_style
    {
        padding:20px;

                   color: #fff;

        background-color: #5cb85c;

        border-color: #4cae4c;

        font-weight:bold;

    }

</style>
<style>
.submit_btn1:hover {
    background: #000;
}

.submit_btn1 {
    background: #00a4ef;
    border: medium none;
    color: #fff;
    display: inline-block;
    float: left;
    margin-right: 40px;
    padding: 13px 29px;
    text-decoration: none;
}
</style>
<style>
	label{font-weight:normal;}	#change_password p{color:red;}
</style>

<link href="<?php echo $this->config->item('frontend_css_path');?>jquery-ui.css" rel="stylesheet">

<script src="<?php echo $this->config->item('frontend_js_path');?>jquery-ui.min.js"></script>

<script src="<?php echo $this->config->item('frontend_js_path');?>jquery.validate.min.js"></script>

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
                        <h2>Change Password</h2>
                    </div>

                </div>

                <!--ROW END-->

            </div>

        </div>

        <!--Kode-our-speaker-heading End-->

        <div class="kode-blog-style-2">

            <div class="container">

          <?php if($this->session->flashdata('msg')): ?>

              <div class="row">

             <div class="col-md-6 respose_style"><?php echo $this->session->flashdata('msg'); ?></div>



             </div>

                <div class="clear"></div>

<?php endif; ?>


<?php //print_r($data);?>

<div class="row margin_top margin_bottom">
			<div class="col-md-12">
				<div class="blue_top"></div>
            <div >
					<form method="post" action="<?php echo $this->config->item('organizer_save_change_password');?>" id="change_password" name="change_password">
					<div class="col-lg-7 col-md-11">
						<?php if($this->session->flashdata('message') != ''){ ?>
							<div class="row" style="margin-bottom:5px;">
								<div class="col-md-3"><label class="control_lable">&nbsp;</label></div>
								<div class="col-md-9" style="color:green;margin-top:10px;">
						<?php echo $this->session->flashdata('message');  ?>
								</div>
							</div>
						<?php } ?>



						<div class="row">
							<div class="col-md-3"><label class="control_lable">Old Password</label></div>
							<div class="col-md-6"><input style="margin-bottom:20px" type="password"  placeholder="Old Password" class="inp valid form-control" id="current_password" name="current_password"> 	<?php if($this->session->flashdata('message1') != ''){ ?>


								<span  style="color:red">
						<?php echo $this->session->flashdata('message1');  ?>
          </span>

						<?php } ?>	<?php echo form_error('current_password'); ?></div>

						</div>
						<div class="row">
							<div class="col-md-3"><label class="control_lable">New Password</label></div>
							<div class="col-md-6"><input style="margin-bottom:20px" type="password" placeholder="New Password" class="inp valid form-control"  id="new_password" name="new_password"> <?php echo form_error('new_password'); ?></div>
						</div>
						<div class="row">
							<div class="col-md-3"><label class="control_lable">Confirm Password</label></div>
							<div class="col-md-6"><input style="margin-bottom:20px" type="password" placeholder="Confirm Password" class="inp valid form-control"
							id="confirm_password" name="confirm_password"> <?php echo form_error('confirm_password'); ?></div>
						</div>
						<br>
            <div class="row">
              <div class="col-md-3"></div>
              <div class="col-md-8">	<input type="submit" value="Update" class="search_events submit_btn1" >
    						<input type="button" value="Cancel" class="search_events submit_btn1"  onclick="window.history.back();"></div>

            </div>
						<br>
					</div>
					</form>
					</div>
					</div>
					</div>
				</div>

            </div>

        </div>

    </div>


<script>


function goBack() {
    window.history.back();
}

$(document).ready(function(){

    $('[data-toggle="popover"]').popover({
        placement : 'right',
        trigger : 'hover'
    });
});



	  (function($,W,D){		var user_validation = {};		user_validation.UTIL =		{
			setupFormValidation: function()			{
				//form validation rules
				$("#change_password").validate({
					rules: {
						current_password: {
							required: true,
						},
						new_password: {
							required: true,
							minlength: 7,
						},
						confirm_password: {
							required: true,
							minlength: 7,
							equalTo: "#new_password",
						},					},
					messages: {},
					submitHandler: function(form) {
						form.submit();
					}
				});
			}
		}
		//when the dom has loaded setup form validation rules		$(D).ready(function($) {			user_validation.UTIL.setupFormValidation();
		});
	})(jQuery, window, document);
</script>



<script>

$(document).ready(function(){



 $(".respose_style").fadeOut(3000);

});

</script
