<style>

    label {  
        font-weight: normal;
    }       

    span{
        color:red;
        font-weight: bold;
    }

    input[type="password"] {

        border: 1px solid rgb(185, 193, 204);

        color: #666;

        height: 43px;

        margin-bottom: 30px;

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
	.change_email {
    background: #00a4ef none repeat scroll 0 0;
    border: medium none;
    color: #fff;
    display: inline-block;
    float: left;
    margin-bottom: 15px;
    padding: 1px 7px;
    text-decoration: none;
 }
	.changes_email{
		background: grey none repeat scroll 0 0;
		border: medium none;
		color: #fff;
		display: inline-block;
		float: left;
		margin-bottom: 15px;
		padding: 1px 7px;
		text-decoration: none;
	}

	.can_css{margin-left:10px;}
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
                        <h2>Edit User</h2>
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





            <form role="form" method="post" action="<?php echo base_url(); ?>index.php/frontend/users/edit_user" id="edit_form" enctype="multipart/form-data">                

                <div class="row">     

                        <div class="col-md-6">

                            <label for="first_name">First Name<span>*</span></label>

                            <input type="text" id="first_name" name="first_name" class="search_events form-control" placeholder="" value="<?php echo set_value('first_name',$data->first_name);?>">

                        </div>

                        <div class="clear"></div>

                        <div class="col-md-6">

                            <label for="last_name">Last Name<span>*</span></label>

                            <input type="text" id="last_name" name="last_name" class="search_events form-control" placeholder="Last Name" value="<?php echo set_value('last_name',$data->last_name);?>">

                        </div>

                        <div class="clear"></div>

                        <div class="col-md-6">

                            <label for="preferred_name">Preferred Name</label>

                            <input type="text" id="preferred_name" name="preferred_name" class="search_events form-control" placeholder="Preferred Name" value="<?php echo set_value('preferred_name',$data->preffered_name);?>">

                        </div>

                       

					   <div class="clear"></div>

                        <div class="col-md-6">
                            <label for="preferred_name">Email <span>*</span></label>
                            <input type="text" name="email" class="search_events form-control" placeholder="Email" value="<?php echo set_value('email',$data->email);?>" readonly>
							
							<?php if($data->facebook_id==''){ ?>
                              <label data-toggle="modal" data-target="#myModal" class="change_email" style="margin-bottom:30px;cursor:pointer;">Change Email</label>
                            <?php }else{ ?>
								<label title="(This account login is via Facebook and this email is has been provided by Facebook)" class="changes_email" style="margin:0px;cursor:pointer;">Change Email</label>
							<?php } ?>
                        </div>
						<?php if($data->facebook_id != ''){ ?>
							<div class="clear"></div>
							<div class="col-md-6">(This account login is via Facebook and this email is has been provided by Facebook)</div>
						<?php } ?>	

                        <div class="clear"></div>

                         <div class="col-md-6">

                            <label for="phone_no">Phone</label>

                            <input type="text" id="phone_no" name="phone_no" class="search_events form-control" placeholder="Phone" value="<?php echo set_value('phone_no',$data->phone_no);?>">

                        </div>

                        

                        <div class="clear"></div>

                         <div class="col-md-6">

                            <label for="street_address">Street Address</label>

                            <input type="text" id="street_address" name="street_address" class="search_events form-control" placeholder="Street Address" value="<?php echo set_value('street_address',$data->street_address);?>">

                        </div>

                        

                        <div class="clear"></div>

                         <div class="col-md-6">

                            <label for="suburb">Suburb</label>

                            <input type="text" id="suburb" name="suburb" class="search_events form-control" placeholder="Suburb" value="<?php echo set_value('suburb',$data->suburb);?>">

                        </div>

                        

                        <div class="clear"></div>

                         <div class="col-md-6">

                            <label for="city">City</label>

                            <input type="text" id="city" name="city" class="search_events form-control" placeholder="City" value="<?php echo set_value('city',$data->city);?>">

                        </div>

                        

                        <div class="clear"></div>

                         <div class="col-md-6">

                            <label for="postcode">PostCode</label>

                            <?php if($data->postcode!=0){ ?>

                            <input type="text" id="postcode" name="postcode" class="search_events form-control" placeholder="PostCode" value="<?php echo set_value('postcode',$data->postcode);?>">
                            
                            <?php }else{ ?>
                                 <input type="text" id="postcode" name="postcode" class="search_events form-control" placeholder="" value="">
                            <?php } ?>

                        </div>

                        

                        <div class="clear"></div>

                         <div class="col-md-6">

                            <label for="country">Country</label>
						       <select class="search_events form-control dropdown" id="country" name="country">										
									<option value="NewZealand">New Zealand</option>
									<option value="Australia">Australia</option>
								</select>
                        </div>

                        

                        <div class="clear"></div>

                         <div class="col-md-6">

                            <label for="birth_date">Birthday</label>

                            <?php if($data->birth_date=='0000-00-00'){ ?>

                            <input type="text" id="birth_date" name="birth_date" class="search_events form-control" placeholder="" value="" readonly>

                            <?php }else{ ?>

                            <input type="text" id="birth_date" name="birth_date" class="search_events" placeholder="" value="<?php echo set_value('birth_date',date('d-m-Y', strtotime($data->birth_date)));?>" readonly>

                            <?php } ?>



                        </div>

                        <div class="clear"></div>

                        <div class="col-md-6">

                            <label for="profile_pic">Profile Image &nbsp;(Max size 500kb)</label>

                            <div class="search_events input-group">

                                <label class="input-group-btn">

                                    <span class="btn btn-primary browse_btn">

                                    Browse&hellip; <input type="file" name="profile_pic" id="profile_pic" class="browse_txt_box" style="display: none;" placeholder="" value="<?php echo set_value('profile_pic',$data->image_path);?>">

                                    </span>

                                </label>

                            <input type="text" id="profic_imag_name" name="profic_imag_name" class="search_events" placeholder="" readonly>

                            <input type="hidden" id="" name="old_image" value="<?php echo $data->image_path; ?>" placeholder="" readonly>





                           </div>

                             <?php echo form_error('profile_pic'); ?>

                        </div>

                        <div class="clear" style="display:none;" id="extra_space_logo"></div>

                        <div class="col-md-12">
                            <?php if($data->image_path=='' && $data->facebook_id!=''){ ?>
                               
                            <img id="blah" alt="" style="width:100px;margin-bottom:15px;" src="<?php echo $data->facebook_image_path; ?>"/>
                            <?php }
                                else if($data->image_path==''){ ?>
								<label id="logo_error"></label>
                              <img id="blah" alt="" style="width:100px;margin-bottom:15px;" src="<?php echo $this->config->item('frontend_profileimage_path');?>/noimage.gif"/>


                           <?php  }else{?><label id="logo_error"></label>
                              <img id="blah" alt="" style="width:100px;margin-bottom:15px;" src="<?php echo $this->config->item('frontend_profileimage_path');?><?php echo $data->image_path; ?>"/>
                            <?php } ?>
                        </div>



                        <div class="clear"></div>                   

                        <div class="col-md-4">
							<button class="search_events submit_btn" type="submit">Update</button>
                       		<button type="button" class="search_events submit_btn can_css" onclick="goBack();">Cancel</button>
                        </div>

                </div>

                </form>

            </div>

        </div>

    </div>

	<div class="col-md-2 col-sm-2 col-xs-10">
         <form id="modalform" action="" >
          <div id="myModal" class="modal fade" role="dialog">
           <div class="modal-dialog modal-md">
            <div class="modal-content">
             <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title hr_header" id="model_title">Change Email Request <span class="modal_champion_title"></span></h4>
             </div>
             <div class="modal-body">
                <input type="hidden" name="user_id" value="<?php echo $data->id; ?>">
           <div class="row">
               <div class="col-sm-4">
                <label>Email</label><span class="red_span">*</span>
               </div>
               <div class="col-sm-6">
             <input type="text" class="form-control" name="email" id="email" value="<?php echo $data->email;?>">
                                         <div id="email_error" style="color:red; "></div>
            <div id="message" style="color:red"></div>
            <div id="success_message" style="color:green"></div>
               </div>
              </div>
             </div>
             <div class="modal-footer">
              <input type="submit" value="Submit" style="float:left" class="btn btn-primary search_events save_sponser">
              <button type="button" class="btn btn-default search_events" data-dismiss="modal" style="float:left">Close</button>
           </div>
          </div>
         </div>
        </div>
       </form>
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


(function($,W,D){

    var user_validation = {}; 

    user_validation.UTIL =

    {

        setupFormValidation: function()
        {
            //form validation rules
            $("#edit_form").validate({
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
                    postcode: {
						number: true,
                    },       
                    phone_no: {
                        number:true,
                    },
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

      maxDate:'0',

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

	var fileExtension = ['jpg','jpeg','JPEG','Jpeg','PNG','Png','png'];
	if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
		document.getElementById('extra_space_logo').style.display = 'block';
		document.getElementById('logo_error').style.display = 'block';
		document.getElementById('logo_error').style.color = 'red';
		document.getElementById('logo_error').innerHTML = 'Please enter valid image';
		$('#blah').attr('src', '');
		document.getElementById('profic_imag_name').value = '';
		return false;
	}
				
	var files = document.getElementById('profile_pic').files;
	
	//alert(files[0].size);
	
	if(files[0].size > 500000){
		document.getElementById('extra_space_logo').style.display = 'block';
		document.getElementById('logo_error').style.display = 'block';
		document.getElementById('logo_error').style.color = 'red';
		document.getElementById('logo_error').innerHTML = 'Profile Image size should be less then 500kb';
		$('#blah').attr('src', '');
		document.getElementById('profic_imag_name').value = '';
		return false;
	}
	
	var fullPath = document.getElementById('profile_pic').value;
	if (fullPath) {
	var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
	var filename = fullPath.substring(startIndex);
	if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
		filename = filename.substring(1);
	}
		document.getElementById('logo_error').style.display = 'none';
		document.getElementById('profic_imag_name').value = filename;
	}	
	
    readURL(this);

    document.getElementById('extra_space_logo').style.display = 'block';

    document.getElementById('blah').style.display = 'block';

    document.getElementById("blah").style.marginBottom = "15px";

    document.getElementById("blah").style.width = "100px";

});

</script>

<script>
	$(document).ready(function(){
	 $(".respose_style").fadeOut(3000);
	});
</script>

<script>
$(document).ready(function(){
  $('#modalform').on('submit',function(e){
  //  alert('Working');
   $('#message').text('');
      $('#success_message').text('');
	  e.preventDefault();
	  var id = "<?php echo $data->id;?>";
	  var a = $('#email').val();
	  //document.getElementById("modalform").submit();
	  var form_data= {email : a,id : id};
	  var email = "<?php echo $data->email; ?>" ;

      if(a!=email){
		   $.ajax({
		   url : "<?php echo base_url(); ?>index.php/frontend/users/has_email_individual",
		   type: "POST",
		   data : form_data,
		   cache: false,
		   success : function(response) {
			  try{
			  if(response=='false'){
					$('#message').text('email already exist');
			  }else if(response=='blank'){
				  $('#message').text('email cannot be blank');
			  }else{
					$('#success_message').text('email changed successfully');
					location.reload();
			  }
			 }catch(e) {
			  $('#message').text('Error while catching..');
			 }
		   },
			error: function() {
			$('#message').text('Error while request..');

			},
		 });
	}else{
		$('#message').text('email is same as old email');
	}
  });
});
</script>









