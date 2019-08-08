<style>
	label {	
		font-weight: normal;
	}		

	span{
		color:red;
		font-weight: bold;
	}

	.no_red span{color:inherit;}
	input[type="text"] {
		border: 1px solid rgb(185, 193, 204);
		color: #666;
		height: 43px;
		margin-bottom: 10px;
		padding: 8px 10px;
		width: 100%;
	}
	
	input[type="password"] {
		border: 1px solid rgb(185, 193, 204);
		color: #666;
		height: 43px;
		margin-bottom: 10px;
		padding: 8px 10px;
		width: 100%;
	}

	.error{
		color:red;
	}

 .respose_style{
  padding:20px;
  color: #fff;
  background-color: #5cb85c; 
  border-color: #4cae4c; 
  font-weight:bold;
}
.sub_margin{margin-right:10px}

.fix-width{width:360px !important;}
</style>

<link href="<?php echo $this->config->item('frontend_css_path');?>jquery-ui.css" rel="stylesheet">

<script src="<?php echo $this->config->item('frontend_js_path');?>jquery-ui.min.js"></script>	

<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>	

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
      <h2>User Sign Up</h2>
    </div>	
  </div>

  <!--ROW END-->

</div>

</div>

<!--Kode-our-speaker-heading End-->

<div class="kode-blog-style-2">
 <div class="container">  
  <?php if($this->session->flashdata('message')): ?>
    <div class="row">
     <div class="col-md-6 respose_style"><?php echo $this->session->flashdata('message'); ?></div>


   </div>

   <div class="clear"></div>





 <?php endif; ?>



 <div class="row" style="">

   <div class="col-md-6" style="text-align:center;">

      <a href="#" data-toggle="modal" data-target="#myModal" id="signup_facebook">

       <img src="<?php echo base_url(); ?>assets/image_uploads/facebook_images/fbsignup.jpg" class="img-responsive fix-width"/>

     </a>



   </div>







 </div>

 <div class="clear"></div>





 <div class="row">

   <div class="col-md-6">



    <div style=" font-weight:bold; font-size:20px;text-align:center;">      
		<img src="<?php echo base_url(); ?>images/divider.png" class="img-responsive" style="margin:15px 0px;">
    </div>
  </div>
</div>


<form role="form" method="post" action="<?php echo base_url(); ?>index.php/frontend/users/register_user" id="signup_form" enctype="multipart/form-data">              	
	<input type="hidden" name="fb_status" id="fb_status" value="0"/>   
  <div class="row">	  

    <div class="col-md-6">

      <label for="first_name">First Name<span>*</span></label>

      <input type="text" id="first_name" name="first_name" class="search_events form-control" placeholder="First Name"  value="<?php echo set_value('first_name');?>">

    </div>

    <div class="clear"></div>

    <div class="col-md-6">

      <label for="last_name">Last Name<span>*</span></label>

      <input type="text" id="last_name" name="last_name" class="search_events form-control" placeholder="Last Name" value="<?php echo set_value('last_name');?>">

    </div>

    <div class="clear"></div>

    <div class="col-md-6">

      <label for="preferred_name">Preferred Name</label>

      <input type="text" id="preferred_name" name="preferred_name" class="search_events form-control" placeholder="Preferred Name" value="<?php echo set_value('preferred_name');?>">

    </div>

    <div class="clear"></div>

    <div class="col-md-6">

      <label for="email">Email<span>*</span></label>

      <input type="text" id="email" name="email" class="search_events form-control" placeholder="Email" value="<?php echo set_value('email');?>">

      <?php echo form_error('email'); ?>		

    </div>

    <div class="clear"></div>

    <div class="col-md-6">

      <label for="password">Password<span>*</span></label>

      <input type="password" id="password" name="password" class="search_events form-control" placeholder="Password">

    </div>

    <div class="clear"></div>

    <div class="col-md-6">

      <label for="confirm_password">Confirm Password<span>*</span></label>

      <input type="password" id="confirm_password" name="confirm_password" class="search_events form-control" placeholder="Confirm Password">

    </div>

    <div class="clear"></div>

    <div class="col-md-6">

      <label for="phone_no">Phone No</label>

      <input type="text" id="phone_no" name="phone_no" class="search_events form-control" placeholder="Phone" value="<?php echo set_value('phone_no');?>">

    </div>



    <div class="clear"></div>

    <div class="col-md-6">

      <label for="street_address">Street Address</label>

      <input type="text" id="street_address" name="street_address" class="search_events form-control" placeholder="Street Address" value="<?php echo set_value('street_address');?>">

    </div>



    <div class="clear"></div>

    <div class="col-md-6">

      <label for="suburb">Suburb</label>

      <input type="text" id="suburb" name="suburb" class="search_events form-control" placeholder="Suburb" value="<?php echo set_value('suburb');?>">

    </div>



    <div class="clear"></div>

    <div class="col-md-6">

      <label for="city">City</label>

      <input type="text" id="city" name="city" class="search_events form-control" placeholder="City" value="<?php echo set_value('city');?>">

    </div>



    <div class="clear"></div>

    <div class="col-md-6">

      <label for="postcode">Postcode</label>

      <input type="text" id="postcode" name="postcode" class="search_events form-control" placeholder="Postcode" value="<?php echo set_value('postcode');?>">

    </div>



    <div class="clear"></div>

    <div class="col-md-6">
      <label for="country">Country</label>
      <select class="search_events form-control dropdown" id="country" name="country">                               
        <option value="New Zealand">New Zealand</option>
        <option value="Australia">Australia</option>								
      </select>
    </div>					

    <div class="clear"></div>

    <div class="col-md-6">

      <label for="contact_date">Birth Date</label>

      <input readonly="readonly" type="text" id="birth_date" name="birth_date" class="search_events form-control" placeholder="DD-MM-YYYY" value="<?php echo set_value('birth_date');?>">

    </div>

    <div class="clear">	</div>

    <div class="col-md-6">

      <label for="profile_pic">Profile Image &nbsp;(Max size 500kb) </label>

      <div class="search_events input-group">

        <label class="input-group-btn">

          <span class="btn btn-primary browse_btn">

            Browse&hellip; <input type="file" name="profile_pic" id="profile_pic" class="browse_txt_box" style="display: none;" placeholder="" value="<?php echo set_value('profile_pic');?>" >

          </span>

        </label>

        <input type="text" id="user_profile_name" name="user_profile_name" class="search_events" placeholder="" readonly>



      </div>

      <?php echo form_error('profile_pic'); ?>

    </div>

    <div class="clear" style="display:none;" id="extra_space_logo"></div>

    <div class="col-md-6" style="margin-bottom:10px;">

     <label id="logo_error"></label>

     <img id="blah" src="#" alt="" style="display:none;"/>

   </div>



   <div class="clear"></div>		

	<div class="col-md-6">
     <input type="checkbox" name='tc' id="tc" value="" required="required" onclick="return false" >&nbsp;&nbsp;&nbsp;<a for="email" class="search_events modal_click common_no_check" data-toggle="modal" data-target="#myModal" style="cursor:pointer" id="show_terms">show terms and conditions</a>
   </div>	
   <br class="clear">
   <div class="col-md-6 terms">

   </div>  
   <div class="clear"></div>

   <div class="col-md-12 col-sm-12 col-xs-12">
		 <button class="search_events submit_btn sub_margin" type="submit">Submit</button>
		 <button type="button" class="search_events submit_btn" onclick="javascript:history.back();">Cancel</button>
   </div>
<!--
<div class="col-md-1 col-sm-2 col-xs-5">
   
</div>
<div class="col-md-2 col-sm-2 col-xs-5 col-md-offset-1">
   
</div>-->



</div>

</form>

</div>

</div>

</div>





<?php $email_url = $this->config->item('frontend_user_sign_up');?>

<script>

  $(document).ready(function(){

    $('[data-toggle="popover"]').popover({

      placement : 'right',

      trigger : 'hover'

    });

  });





  (function($,W,D){

    var user_validation = {}; 

    user_validation.UTIL =

    {

      setupFormValidation: function(){

            //form validation rules

            $("#signup_form").validate({

              rules: {
               first_name: {
                required: true,	                        
              },
              last_name: {
                required: true,
              },
              email: {
                required: true,
                email: true,
              },
              password: {
                required: true,	
                minlength:7,
              },
              confirm_password: {
                required: true,	
                equalTo: "#password",
                minlength:7,
              },	
              phone_no: {
                number:true,
              },
              postcode: {	
                digits:true,
              },
            },

            messages: {

             email: {                   

              remote: jQuery.validator.format("{0} already in use.")

            },

            phone_no: {                   

              minlength: jQuery.validator.format("phone should be 10 digit length."),

              maxlength: jQuery.validator.format("phone should be 10 digit length.")

            },

            confirm_password: {                   

              equalTo: jQuery.validator.format("confirm password should be same as password")

            },

            postcode: {

              minlength: jQuery.validator.format("Post Code should be 6 digit"),

              maxlength: jQuery.validator.format("Post Code should be 6 Digit.")

            },

          },
          errorPlacement: function (error, element) {
           if (element.attr("type") == "checkbox") {
            $('.terms').append(error);
          }else{
           error.insertAfter(element);
         }
       },


       submitHandler: function(form) {

        form.submit();

      }

    });

            jQuery.validator.addMethod("alpha", function(value, element) {

              return this.optional(element) || value == value.match(/^[a-zA-Z]+$/);

            },"Only alphabets are allowed.");

          }



        }

    //when the dom has loaded setup form validation rules

    $(D).ready(function($) {

      user_validation.UTIL.setupFormValidation();

    }); 

  })(jQuery, window, document);









  $(function() {

    $( "#birth_date" ).datepicker({

     changeMonth: true,

     changeYear: true,

     dateFormat: 'dd-mm-yy',

     yearRange: "-100:+0",

     maxDate: '-1d'





   });

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





  $("#profile_pic").change(function(){


   var files = document.getElementById('profile_pic').files;

	//alert(files[0].size);
	
	if(files[0].size > 500000){
		document.getElementById('extra_space_logo').style.display = 'block';
		document.getElementById('logo_error').style.display = 'block';
		document.getElementById('logo_error').style.color = 'red';
		document.getElementById('logo_error').innerHTML = 'Profile Image size should be less then 500kb';
		$('#blah').attr('src', '');
		return false;
	}
	
	var fullPath = document.getElementById('profile_pic').value;
	if (fullPath) {
   var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
   var filename = fullPath.substring(startIndex);
   if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
    filename = filename.substring(1);
  }
  document.getElementById('user_profile_name').value = filename;
}

readURL(this);

document.getElementById('extra_space_logo').style.display = 'block';
document.getElementById('blah').style.display = 'block';
document.getElementById('logo_error').style.display = 'none';
document.getElementById('blah').style.height = 'inherit';
document.getElementById('blah').style.width = 'inherit';
});




  function goBack() {

    window.history.back();

  }



</script>



<script>
  $(document).ready(function(){
  // $(".respose_style").fadeOut(15000);
 });


 </script


 <!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title hr_header"></h4>
      </div>
      <div class="modal-body">
		<div style="width:100%; height:300px; overflow: auto;" class="no_red body_info"></div>
      </div>
      <div class="modal-footer">
      <div  style="float:left">  
         <input type="checkbox" name='modal_tc' id="modal_tc" value="" required="required" class="">&nbsp;&nbsp;&nbsp;<label for="modal_tc" class="search_events">I agree</label>
      </div>
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<script>
	  $(document).ready(function(){
	 $('.common_no_check').click(function(){
      var key = 'tc';
      $.ajax({
        type: "post",
        url: "<?php echo base_url(); ?>index.php/frontend/organiser/get_terms_and_conditions/"+key,
        cache: false,
        success: function(json){

            var obj = jQuery.parseJSON(json);

             $.each(obj, function(key,value) {
                $('.hr_header').text(value.header);
                  $('.body_info').html(value.description);
             });
       }
   }
);
  }); });

$(document).ready(function(){

$('#tc').click(function(){

  if($(this).is(':checked')){
     $(this).attr('checked', false); // Unchecks it
  }

});

$('#modal_tc').click(function(){

  if($(this).is(':checked')){
     $('#tc').prop( "checked", true ); // checks it
     var fb_status=$('#fb_status').val();
     if(fb_status==1){
       var path="<?php echo base_url(); ?>index.php/frontend/auth/login";
       window.location = path;
     }else{
      $('#myModal').modal('hide');
     }
  }
  else{
      $('#tc').prop( "checked", false ); // checks it
  }

});

});
</script>


<script>
$(document).ready(function(){
 $('#show_terms').click(function(){
    $('#fb_status').val('0');


 });

 $('#signup_facebook').click(function(){
    $('#fb_status').val('1');

 });



$('#tc').click(function(){

  if($(this).is(':checked')){
     $(this).attr('checked', false); // Unchecks it
  }

});

$('#modal_tc').click(function(){

  if($(this).is(':checked')){
     $('#tc').prop( "checked", true ); // checks it
     var fb_status=$('#fb_status').val();
     if(fb_status==1){
       var path="<?php echo base_url(); ?>index.php/frontend/auth/login";
       window.location = path;
     }
  }
  else{
      $('#tc').prop( "checked", false ); // checks it
  }

});

});
</script>