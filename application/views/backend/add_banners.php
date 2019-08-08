<script>
	jQuery(document).ready(function(){ 
		jQuery(".pagination li a").click(function(e){ 
			document.getElementById('user_list_form').action = jQuery(this).attr('href');
			jQuery('#user_list_form').submit();   
			e.preventDefault();
		});
	});
</script>
<style>
	label{font-weight:normal;}	
	.row p{color:red;}

	.banner_spacing{
		margin-top:20px;
	}

	.btn-file {
		position: relative;
		overflow: hidden;
	}
	.btn-file input[type=file] {
		position: absolute;
		top: 0;
		right: 0;
		min-width: 100%;
		min-height: 100%;
		font-size: 100px;
		text-align: right;
		filter: alpha(opacity=0);
		opacity: 0;
		outline: none;
		background: white;
		cursor: inherit;
		display: block;
	}

	#img-upload{
		width: 100%;
	}
	
	span{color:red;}
	.error{color:red;}
</style>
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" media="all"  href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/smoothness/jquery-ui.css"    />
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> -->
<div id="page-wrapper">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="right_first_box">
					<img src="<?php echo $this->config->item('admin_image_path');?>home.png">
					<a href="#">Home</a> > <a href="#">Manage Banners</a>
				</div>
			</div>
		</div>  				 
		<div class="row margin_top margin_bottom">
			<div class="col-md-12">
				<div class="blue_top">Add Banner</div>
				<div class="table-responsive table_white_box" style="padding:25px;">
					<form enctype="multipart/form-data" method="post" action="<?php echo base_url(); ?>index.php/backend/banners/save_banner" id="upload_banner" name="upload_banner">
							<div class="col-lg-8 col-md-11">
											
							<!-- <div class="row">
								<div class="col-md-4"><label style="font-weight:bold">Title</label><span class="red">*</span></div>
								<div class="col-md-8"><input type="text" onkeyup="countChar(this)" class="inp" placeholder="enter banner title" name="title" id="title"/> <div id="charNum" style="color:green; font-weight:bold; margin-top:5px"></div><?php echo form_error('title'); ?></div>
								
							</div> -->

							<div class="row" style="margin-bottom:20px;">
								<div class="col-md-4"><label style="font-weight:bold">Image (1920X650)</label><span class="red">*</span></div>
								<div class="col-md-8">
									<div class="input-group">
										<label class="input-group-btn">
											<span class="btn btn-primary">
												Browse… <input style="display: none;" name="imgInp" type="file" id="imgInp"  name="banner_upload">
											</span>
										</label>
										<input type="text" class="form-control" readonly="readonly">								
									</div><?php echo form_error('imgInp'); ?>
									<label id="image_error" style="color: red;display:none;margin-top:10px;">Only valid image formats are allowed.</label>
									<img id='img-upload' style="margin-top:10px"/>
								</div>
							</div>
							<!--
							<div class="row">
								<div class="col-md-4"><label style="font-weight:bold">Start Date</label><span class="red">*</span></div>
								<div class="col-md-8"><input type="text" class="inp" placeholder="enter start date" id="dt1" name="dt1" readonly="readonly"/><?php echo form_error('dt1'); ?></div>								
							</div>

							<div class="row">
								<div class="col-md-4"><label style="font-weight:bold">End Date</label><span class="red">*</span></div>
								<div class="col-md-8"><input type="text" class="inp" placeholder="enter end date" id="dt2" name="dt2" readonly="readonly"/><?php echo form_error('dt2'); ?></div>
							</div>
							-->
							<div class="row">
								<div class="col-md-4"></div>
								<div class="col-md-8">
									<input class="btn btn-primary save_btn" type="submit" name="sub" value="Save">
									<input class="btn btn-primary save_btn" type="button" value="Cancel" onclick="goBack();">
								</div>
							</div>
						</div>						
					</div>


				</form>
			</div>
		</div>
	</div>
</div>
</div>
<script src="<?php echo $this->config->item('admin_js_path');?>jquery.validate.min.js"></script>

<script>
	function goBack(){
		 window.history.go(-1);
	}

	(function($,W,D){
		var user_validation = {}; 
		user_validation.UTIL =
		{
			setupFormValidation: function()
			{
				//form validation rules
				$("#upload_bannuer").validate({
					ignore: "",
					rules: {                   
						title: {
							required: true,							
						},
						dt1: {
							required: true,
						},
						dt2: {
							required: true,
						},
					},
					messages: {},
					submitHandler: function(form) {
						form.submit();
					}
				});
			}
		}
		//when the dom has loaded setup form validation rules
		$(D).ready(function($) {
			user_validation.UTIL.setupFormValidation();
		}); 
	})(jQuery, window, document);
</script>


<script>
	window.URL = window.URL || window.webkitURL;
	$(document).ready( function() {
		$(document).on('change', '.btn-file :file', function() {
			var input = $(this),
			label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
			input.trigger('fileselect', [label]);
		});

		$('.btn-file :file').on('fileselect', function(event, label) {
            
			var input = $(this).parents('.input-group').find(':text'),
			log = label;

			if( input.length ) {
				input.val(log);
			} else {
				if( log ) alert(log);
			}

		});
		function readURL(input) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();

				reader.onload = function (e) {
					$('#img-upload').attr('src', e.target.result);
				}

				reader.readAsDataURL(input.files[0]);
			}
		}

		$("#imgInp").change(function(){
			var fileExtension = ['pdf','jpg','jpeg','JPEG','Jpeg'];
            if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
			    document.getElementById('image_error').style.display= 'block';	
				return false;
			}else{
	            document.getElementById('image_error').style.display= 'none';	
			}
					
			readURL(this); 
			
		}); 	
	});
</script>

<script>
	$(document).ready(function () {

		$("#dt1").datepicker({
			dateFormat: "dd-M-yy",
			minDate: 0,
			onSelect: function (selected) {
				$("#dt2").datepicker("option","minDate", selected);			
            }
        });
		$('#dt2').datepicker({
			dateFormat: "dd-M-yy",
			minDate: 1,
		});
	});
</script>

<script>
	function countChar(val) {
		var len = val.value.length;
		if (len >= 15) {
			val.value = val.value.substring(0, 15);
		} else {
			$('#charNum').text(15 - len+" Characters remaining");
		}
	};
</script>




