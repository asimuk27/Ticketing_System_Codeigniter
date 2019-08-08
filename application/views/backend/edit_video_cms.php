<script type="text/javascript" src="<?php echo $this->config->item('base_url');?>/assets/backend/tinymce/js/tinymce/tinymce.min.js"></script>
<script>		
	tinymce.init({

	extended_valid_elements : "iframe[src|frameborder|style|scrolling|class|width|height|name|align]",
	selector:'textarea',
	auto_focus: "elm1",
	fontsize_formats: "8pt 9pt 10pt 11pt 12pt 26pt 36pt 40pt",
	plugins: [
                "advlist autolink autosave link image lists charmap print preview hr anchor pagebreak spellchecker",
                "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                "table contextmenu directionality emoticons template textcolor paste textcolor"
        ],



        toolbar1: "newdocument | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | link unlink anchor image media code | forecolor backcolor",



		toolbar2: "styleselect formatselect fontselect fontsizeselect | visualchars visualblocks nonbreaking template pagebreak restoredraft",



        toolbar3: "print fullscreen | searchreplace | bullist numlist | outdent indent blockquote | undo redo | inserttime preview | table | hr removeformat | subscript superscript | spellchecker",







    menubar: false,



	autosave_interval: "2s",



	relative_urls: false,



	spellchecker_wordchar_pattern: "/[^\s,\.]+/g",



	toolbar_items_size: 'small',



});







	function getElementLeft(elm) 



	{



		var x = 0;		



		//set x to elm’s offsetLeft



		x = elm.offsetLeft;		



		//set elm to its offsetParent



		elm = elm.offsetParent;		



		//use while loop to check if elm is null



		// if not then add current elm’s offsetLeft to x



		//offsetTop to y and set elm to its offsetParent



		



    	while(elm != null)



		{



			x = parseInt(x) + parseInt(elm.offsetLeft);



			elm = elm.offsetParent;



		}



		return x;



		}



		



		function getElementTop(elm) 



		{



		var y = 0;



		



		//set x to elm’s offsetLeft



		y = elm.offsetTop;



		



		//set elm to its offsetParent



		elm = elm.offsetParent;



		



		//use while loop to check if elm is null



		// if not then add current elm’s offsetLeft to x



		//offsetTop to y and set elm to its offsetParent



		



		while(elm != null)



		{



        y = parseInt(y) + parseInt(elm.offsetTop);



        elm = elm.offsetParent;



		}



		



		return y;



		}



		



		



		function Large(obj)



		{



		var imgbox=document.getElementById("imgbox");



		imgbox.style.visibility='visible';



		var img = document.createElement("img");



		img.src=obj.src;



		img.style.width='2000px';



		img.style.height='2000px';



		



		if(img1.addEventListener){



        img1.addEventListener('mouseout',Out,false);



		} else {



        img1.attachEvent('onmouseout',Out);



		}             



		imgbox.innerHTML='';



		imgbox.appendChild(img);



		imgbox.style.left=(getElementLeft(obj)-50) +'px';



		imgbox.style.top=(getElementTop(obj)-50) + 'px';



		}



</script>



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



	.input-disabled{background-color:#EBEBE4;border:1px solid #ABADB3;}



	#my_profile p{color:red !important;}



	.red{color:red;}



</style>



<div id="page-wrapper">



	<div class="container-fluid">



		<div class="row">



			<div class="col-md-12">



				<div class="right_first_box">



					<img src="<?php echo $this->config->item('admin_image_path');?>home.png">



						<a href="#">Home</a> > <a href="#">EDIT VIDEO CMS</a>



				</div>



			</div>



		</div>  	



		

		



			



		<div class="row margin_top margin_bottom">



			<div class="col-md-12">



				<div class="blue_top">Edit Video CMS</div>



				<div class="table-responsive table_white_box" style="padding:25px;">



					<form method="post" action="<?php echo base_url(); ?>index.php/backend/manage_videos/update_video_cms" id="my_profile" name="my_profile">



					<input type="hidden" name="cms_update" value="<?php echo $data[0]['id'];?>"/>



					<div class="col-lg-10 col-md-11">

						<div class="row">
							<div class="col-md-3"><label for="category">Category</label><span class="red"> *</span></div>
							<div class="col-md-6"> <input type="text" class="inp form-control" id="category" name="category" value="<?php  echo $data[0]['category']; ?>" placeholder="category"><?php echo form_error('category'); ?></div>
						</div>
						<input type="hidden" name="old_category" value="<?php echo $data[0]['category']; ?>">
						
						<div class="row">
							 <div class="col-md-3"><label for="ird">Content</label><span class="red"> *</span></div>							 
							 <div class="col-md-9" style="z-index:9999"> <textarea name="content" id="editor1" rows="20" cols="80" class="inp">
							<?php 	
							if(isset($data)){
								echo $data[0]['content'];
							}
							?>
							</textarea>
                            <?php echo form_error('content'); ?>
							<script>
								CKEDITOR.replace('editor1');
							</script>
							</div>
						
						</div>
						<br>
						<div class="row">				
							<div class="col-md-3"></div>	
							<div class="col-md-6">
								<input type="submit" value="Update" class="btn btn-primary save_btn"> 
								<input type="button" value="Cancel" class="btn btn-primary save_btn" onclick="window.history.back();">
							</div>
						</div>
						<br>
					</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="<?php echo $this->config->item('admin_js_path');?>jquery.validate.min.js"></script>


