<link rel="stylesheet" href="<?php echo $this->config->item('frontend_css_path');?>pages/user_sign_up.css" type="text/css" media="all">

<script>
  var facebook_status=0;

  function logInWithFacebook() {

  FB.login(function(response) {
      if (response.authResponse) {
      console.log(response.authResponse);

       FB.api('/me?fields=id,first_name,last_name,email,permissions', function(response)
       {


       /// alert ("Welcome " + response.first_name + ": Your UID is " + response.id + "Email is"+response.email);

        if(response.id!='' && response.email!=''){

          document.getElementById("id").value = response.id;
          document.getElementById("first_name_id").value = response.first_name;
          document.getElementById("last_name_id").value = response.last_name;
          document.getElementById("email_idz").value = response.email;
          document.forms["myForm"].submit();
        }





       });

      } else {

      }
    },{scope: 'email',return_scopes: true});
    return false;
  };
  window.fbAsyncInit = function() {
    FB.init({
      appId: '1058287097627083',
      cookie: true, // This is important, it's not enabled by default
      version: 'v2.2'
    });
  };

  (function(d, s, id){
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {return;}
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));
</script>
<script>
  $(document).ready(function(){
    $(".respose_style").fadeOut(6000);

    $('#show_terms').click(function(){
         facebook_status=0;
         $("#modal_tc").attr("checked", false);
    });

    $('#signup_facebook').click(function(){
         facebook_status=1;
         $("#modal_tc").attr("checked", false);
    });


  });
 </script>

<link href="<?php echo $this->config->item('frontend_css_path');?>jquery-ui.css" rel="stylesheet">

<script src="<?php echo $this->config->item('frontend_js_path');?>jquery-ui.min.js"></script>

<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>

<div class="content">


  <div class="sub-header">

 </div>


 <div class="Kode-page-heading">

   <div class="container">

    <div class="row">

     <div class="col-md-6 col-sm-6">
      <h2>User Sign Up</h2>
    </div>
  </div>

</div>

</div>

<div class="kode-blog-style-2">
 <div class="container">
  <?php if($this->session->flashdata('message')): ?>
    <div class="row">
     <div class="col-md-6 respose_style"><?php echo $this->session->flashdata('message'); ?></div>
   </div>
   <br class="clear">
 <?php endif; ?>


<form method="post" action="<?php echo base_url(); ?>index.php/frontend/users/register_user" id="signup_form" enctype="multipart/form-data">
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

      <label for="phone_no">Contact Number</label>

      <input type="text" id="phone_no" name="phone_no" class="search_events form-control" placeholder="Contact Number" value="<?php echo set_value('phone_no');?>">

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
        <option value="Samoa">Samoa</option>
        <option value="Niue">Niue</option>
        <option value="Tonga">Tonga</option>
        <option value="United States">United States</option>
        <option value="Sweden">Sweden</option>
        <option value="Holland">Holland</option>
        <option value="Australia">Denmark</option>
      </select>
    </div>

      <div class="clear"></div>

    <div class="col-md-6">

      <label for="birth_date">Birth Date</label>

      <input readonly="readonly" type="text" id="birth_date" name="birth_date" class="search_events form-control" placeholder="DD-MM-YYYY" value="<?php echo set_value('birth_date');?>">

    </div>

      <div class="clear"></div>

    <div class="col-md-6">

      <label for="profile_pic">Profile Image &nbsp;(Max size 500kb) </label>

      <div class="search_events input-group">

        <label class="input-group-btn">

          <span class="btn btn-primary browse_btn">

            Browse&hellip; <input type="file" name="profile_pic" id="profile_pic" class="browse_txt_box" style="display: none;">

          </span>

        </label>

        <input type="text" id="user_profile_name" name="user_profile_name" class="search_events" placeholder="" readonly>



      </div>

      <?php echo form_error('profile_pic'); ?>

    </div>

    <br class="clear" style="display:none;" id="extra_space_logo">

    <div class="col-md-6" style="margin-bottom:10px;">

     <label id="logo_error"></label>

     <img id="blah" src="#" alt="preview" style="display:none;"/>

   </div>



    <div class="clear"></div>

	<div class="col-md-6">
     <input class="common_no_check" type="checkbox" name='tc' id="tc" value="" required="required" onclick="return false" data-toggle="modal" data-target="#myModal2">&nbsp;&nbsp;&nbsp;<a class="search_events modal_click common_no_check" data-toggle="modal" data-target="#myModal2" style="cursor:pointer" id="show_terms">show terms and conditions</a>
   </div>
     <div class="clear"></div>

   <div class="col-md-6 terms">

   </div>
    <div class="clear"></div>

   <div class="col-md-12 col-sm-12 col-xs-12">
		 <input type="hidden" id="fund_raise_status" name="fund_raise_status" value="<?php echo $is_fund_raise;?>">
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

	  document.getElementById('blah').style.display = 'block';
      reader.readAsDataURL(input.files[0]);

    }

  }





  $("#profile_pic").change(function(){

	var selected_file_name = $(this).val();
    if ( selected_file_name.length > 0 ) {
		var fileExtension = ['jpg','jpeg','JPEG','Jpeg','PNG','png','Png'];
		if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
			document.getElementById('extra_space_logo').style.display = 'block';
			document.getElementById('logo_error').style.display = 'block';
			document.getElementById('logo_error').style.color = 'red';
			document.getElementById('logo_error').innerHTML = 'Please upload valid image';
			document.getElementById('user_profile_name').value = '';
			$('#blah').attr('src', '');
			document.getElementById('blah').style.display = 'none';
			return false;
		}
    }


	var files = document.getElementById('profile_pic').files;

	if(files[0].size > 500000){
		document.getElementById('extra_space_logo').style.display = 'block';
		document.getElementById('logo_error').style.display = 'block';
		document.getElementById('logo_error').style.color = 'red';
		document.getElementById('logo_error').innerHTML = 'Profile Image size should be less than 500KB';
		$('#blah').attr('src', '');
		document.getElementById('blah').style.display = 'none';
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


 </script>


 <!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title hr_header2">&nbsp;</h4>
      </div>
      <div class="modal-body">
		<div style="width:100%; height:300px; overflow: auto;" class="no_red body_info2"></div>
      </div>
      <div class="modal-footer">
      <div  style="float:left">
         <input onclick="logInWithFacebook()" type="checkbox" name='modal_tc' id="modal_tc" value="" class="">&nbsp;&nbsp;&nbsp;<label for="modal_tc" class="search_events">I agree</label>
      </div>
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>



<div id="myModal2" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title hr_header">&nbsp;</h4>
      </div>
      <div class="modal-body">
		<div style="width:100%; height:300px; overflow: auto;" class="no_red body_info"></div>
      </div>
      <div class="modal-footer">
      <div  style="float:left">
         <input type="checkbox" name='modal_tc2' id="modal_tc2" value="" class="">&nbsp;&nbsp;&nbsp;<label for="modal_tc2" class="search_events">I agree</label>
      </div>
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<form name="myForm" id="myForm" action="<?php echo base_url(); ?>index.php/frontend/login/signup_ajax" method="post">
     <input type="hidden" name="first_name" id="first_name_id">
     <input type="hidden" name="last_name" id="last_name_id">
     <input type="hidden" name="id" id="id">
     <input type="hidden" name="email_idz" id="email_idz">
</form>

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
	 $('.common_no_check2').click(function(){
      var key = 'tc';
      $.ajax({
        type: "post",
        url: "<?php echo base_url(); ?>index.php/frontend/organiser/get_terms_and_conditions/"+key,
        cache: false,
        success: function(json){

            var obj = jQuery.parseJSON(json);

             $.each(obj, function(key,value) {
                $('.hr_header2').text(value.header);
                  $('.body_info2').html(value.description);
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
       $('#myModal').modal('toggle');

   }

});

$('#modal_tc2').click(function(){
   if($(this).is(':checked')){
       $('#myModal2').modal('toggle');
       $('#tc').prop('checked',true);

   }

   if($(this).is(':unchecked')){
       $('#myModal2').modal('toggle');
       $('#tc').prop('checked',false);

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

});
</script>



