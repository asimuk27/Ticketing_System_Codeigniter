<footer id="footer">
		<div class="black_footer">
            <div class="container-fluid">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                         	<h5 class="blue_txt text-left">Use TicketingSystem</h5>
                            <hr class="hr_footer">
                            <div class="foot_1_links">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
									<a href="<?php echo $this->config->item('base_url')?>about-us" class="paragraph search_events">About Us</a><br>
									<a href="<?php echo $this->config->item('base_url')?>contact-us" class="paragraph search_events">Contact Us</a><br>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
									<a href="<?php echo $this->config->item('base_url')?>faqs" class="paragraph search_events">FAQ's</a><br>
									<a href="<?php echo $this->config->item('base_url')?>terms-and-conditions" class="paragraph search_events">Terms & Conditions</a><br>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
									<a href="<?php echo $this->config->item('base_url')?>how-to-videos" class="paragraph search_events">How To Videos</a><br>
									<a href="<?php echo $this->config->item('base_url')?>fund-raise" class="paragraph search_events">Fund Raise</a><br>
								</div>
                    		</div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                         	<h5 class="blue_txt  text-left">Event Categories</h5>
                            <hr class="hr_footer">
                            <div class="foot_1_links">
    							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
									<a href="<?php echo $this->config->item('base_url').'events/sport';?>" class="paragraph search_events">Sport</a><br>
									<a href="<?php echo $this->config->item('base_url').'events/music';?>" class="paragraph search_events">Music</a><br>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
									<a href="<?php echo $this->config->item('base_url').'events/entertainment';?>" class="paragraph search_events">Entertainment</a><br>
									<a href="<?php echo $this->config->item('base_url').'events/games';?>" class="paragraph search_events">Games</a><br>
								</div>
                    		</div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
		<!--kode-footer-text End-->
		<div class="footer-copyright">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<p>&copy; All Rights Reserved</p>
					</div>
				</div>
			</div>
			<div class="back-to-top">
				<a href="#"><span class="fa fa-arrow-up fa_special_icons"></span></a>
			</div>
		</div>
		<!--copyright End-->
	</footer>
</div>


<!--Jquery Lib-->
<script src="<?php echo $this->config->item('frontend_js_path');?>custom.js"></script>

<script>
$(document).ready(function(){
    $('[data-toggle="popover"]').popover({
        placement : 'right',
        trigger : 'hover'
    });
});

$("#bank_statement").change(function(){

	var fullPath = document.getElementById('bank_statement').value;
	if (fullPath) {
	var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
	var filename = fullPath.substring(startIndex);
	if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
		filename = filename.substring(1);
	}
		document.getElementById('ste').value = filename;
	}
	document.getElementById('attach_statement').style.color = 'green';
	document.getElementById('attach_statement').style.display = 'block';
});



function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#blah').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

$("#logo").change(function(){

	var files = document.getElementById('logo').files;

	//alert(files[0].size);

	if(files[0].size > 500000){
		document.getElementById('extra_space_logo').style.display = 'block';
		document.getElementById('logo_error').style.display = 'block';
		document.getElementById('logo_error').style.color = 'red';
		document.getElementById('logo_error').innerHTML = 'logo image size should be less then 500kb';
		$('#blah').attr('src', '');
		return false;
	}

	var fullPath = document.getElementById('logo').value;
	if (fullPath) {
	var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
	var filename = fullPath.substring(startIndex);
	if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
		filename = filename.substring(1);
	}
		document.getElementById('logo_name').value = filename;
	}

    readURL(this);

	document.getElementById('extra_space_logo').style.display = 'block';
	document.getElementById('blah').style.display = 'block';
	document.getElementById('logo_error').style.display = 'none';
	document.getElementById('blah').style.height = 'inherit';
	document.getElementById('blah').style.width = 'inherit';
});

function readURL_Preview(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#bank_signature_preview').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

$("#bank_signature").change(function(){
	var fullPath = document.getElementById('bank_signature').value;
	if (fullPath) {
	var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
	var filename = fullPath.substring(startIndex);
	if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
		filename = filename.substring(1);
	}
		document.getElementById('sing_name').value = filename;
	}

    readURL_Preview(this);
	document.getElementById('space_logo').style.display = 'block';
	document.getElementById('bank_signature_preview').style.display = 'block';
});
</script>
</body>
</html>