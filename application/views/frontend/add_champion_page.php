<style>
	span{
		color:red;
		font-weight: bold;
	}
	.special_message{font-weight: normal;color:grey;}
	.error{color:red;font-weight: normal;}
	.special_text{padding-bottom: 0px;}
	hr{margin:10px 1px 1px 1px;}
	.right-space{margin-right:15px;}
</style>



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
              <h2>Create A Fundraising Page</h2>
          </div>

				</div>
				<!--ROW END-->
			</div>
		</div>
		<!--Kode-our-speaker-heading End-->
		<div class="kode-blog-style-2">
			<div class="container">
				<div class="row">
					<div class="col-md-6 col-sm-10 special_text">
						 Here you can set up a profile page and share the page link with your network via social media<br> or email to fundraise for the cause you care about.
						<hr>
					</div>
				</div>
               <div class="row">
                   <form enctype="multipart/form-data" method="POST" action="<?php echo $this->config->item('save_fundraising');?>" name="add_champion_form" id="add_champion_form">

                     <?php
						if(isset($this->session->userdata['logged_in']['first_name'])){
							$display_name = $this->session->userdata['logged_in']['first_name'];
						}else{
							$display_name = $this->session->userdata['logged_in']['first_name'];
						}
                    ?>

                    <div class="col-md-6 col-sm-10">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="page_title">Page Title<span>*</span></label>
                                <input value="Help <?php echo $display_name;?> fundraise for this cause" type="text" id="page_title" name="page_title" class="search_events form-control" placeholder="Enter your fundraising page title">
                                <?php echo form_error('page_title'); ?>
                            </div>
                            <div class="clear"></div>
                            <div class="col-md-12">
                                <label for="page_title">Display Name<span>*</span></label>
                                <input type="text" id="display_name" name="display_name" class="search_events form-control" placeholder="" value="<?php echo $display_name;?>">
                                <?php echo form_error('display_name'); ?>
                            </div>
                            <div class="clear"></div>
                            <div class="col-md-12">
                                <label for="amount">Set Target<span>*</span><span class="special_message">(This is the amount i plan to raise)</span></label>
                                <div class="row">
                                   <div class="col-md-3 col-sm-3 col-xs-6">
                                       <button type="button" class="three_inline_buttons" onclick="update_amount(500);">$ 500 </button>
                                   </div>
                                   <div class="col-md-3 col-sm-3 col-xs-6">
                                       <button type="button" class="three_inline_buttons" onclick="update_amount(1000);">$ 1000</button>
                                   </div>
                                   <div class="col-md-3 col-sm-3 col-xs-6">
                                       <button type="button" class="three_inline_buttons" onclick="update_amount(1500);">$ 1500</button>
                                   </div>
                                   <div class="col-md-3 col-sm-3 col-xs-6">
                                       <input type="text" id="target_amount" name="target_amount" class="form-control search_events" placeholder="Amount in $" maxlength="6">
                                   </div>
                               </div>
                               <?php echo form_error('target_amount'); ?>
                           </div>
                       </div>
                   </div>
                  <div class="clear"></div>
                   <div class="col-md-6 col-sm-10">
                     <div class="row">
                        <div class="col-md-12">
                            <label for="select_charity">Select Charity<span>*</span></label>
                            <select class="search_events select_charity" id="select_charity" name="select_charity" onchange="load_event_by_organization_id(this);">		<option value="">-- Please select charity --</option>
                              <?php foreach($organization_list as $list){ ?>
                              <option value="<?php echo $list['id'];?>" <?php if($list['id'] == $get_charity_id){ echo "selected";}?>><?php echo $list['charity_name'];?></option>
                              <?php } ?>
                          </select>
                          <?php echo form_error('select_charity'); ?>
                      </div>
                  </div>
              </div>
             <div class="clear"></div>
              <div class="col-md-6 col-sm-10">
                 <div class="row">
                    <div class="col-md-12">
                        <label for="select_event">Select Events<span>*</span></label>
                        <select class="search_events select_charity" id="select_event" name="select_event" onchange="load_sub_event_by_event_id(this)";>
                          <option value="">-- Please select event --</option>
                      </select>
                      <?php echo form_error('select_event'); ?>
                  </div>
              </div>
          </div>
          <div class="clear"></div>
          <div class="col-md-6 col-sm-10">
             <div class="row">
                <div class="col-md-12">
                    <label for="select_event">Select Sub Events<span>*</span></label>
                    <select class="search_events select_charity" id="select_sub_event" name="select_sub_event">
                      <option value="">-- Please select sub event --</option>
                  </select>
                  <?php echo form_error('select_sub_event'); ?>
              </div>
          </div>
      </div>
     <div class="clear"></div>
	   <div class="col-md-6 col-sm-10">
                 <div class="row">
                    <div class="col-md-12">
                        <input type="checkbox" name="no_image" id="no_image" value="1"/>
                        <label for="no_image">No Image</label>
                  </div>
              </div>
          </div>
       <br class="clear no_image_clear">
      <div class="col-md-6 col-sm-10 fundraising_p">
        <label for="email">Fundraising Profile Image</label>
        <div class="search_events  input-group">
            <label class="input-group-btn">
                <span class="btn btn-primary browse_btn">
                    Browse&hellip; <input type="file" id="fundraising_image" name="fundraising_image" class="search_events browse_txt_box" style="display: none;" placeholder="">
                </span>
            </label>
            <input type="text" id="fundraising_name" name="fundraising_name" class="search_events" placeholder="" readonly>
        </div>
        <?php echo form_error('fundraising_image'); ?>
    </div>
    <div class="clear" style="display:none;" id="extra_space_logo"></div>
    <div class="col-md-6 fundraising_p_image">
     <img id="blah" src="#" alt="" style="display:none;" width="200px;" class="img-responsive"/>
 </div>
 <div class="clear"></div>
 <div class="col-md-6 col-sm-10">
    <label for="message">Why I am a Champion ?<span>*</span><span class="special_message">(This message will appear on your fundraising page)</span></label>
    <textarea class="search_events form-control txt_field" rows="10" id="message" name="message"></textarea>
    <?php echo form_error('message'); ?>
</div>

</div>
            <div class="row">
               <div class="col-md-6 col-sm-10 col-xs-10">
					<input type="hidden" id="fundraise_old_image" name="fundraise_old_image" value="<?php echo $profile_image_name;?>">
                   <button class="search_events submit_btn right-space" type="submit">Submit</button>

                   <button id="my_md" type="button" class="search_events submit_btn right-space" data-toggle="modal" data-target="#myModal">Preview</button>
                   <div id="myModal" class="modal fade" role="dialog">
                      <div class="modal-dialog modal-lg">
                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title" id="model_title"></h4>
                        </div>
                        <div class="modal-body">
                            <div class="two_img_banner">
                                <div class="row">
                                    <div class="col-md-9 col-sm-9">
                                     <img src="" id="original_event_image" class="img-responsive" alt=""  style="width:100%;height:336px;">
                                 </div>
                                 <div class="col-md-3 col-sm-3">
                                   <?php if($profile_image != ""){	?>
                                   <img id="model_fundraising_image" style="height:336px;" src="<?php echo $profile_image; ?>" class="img-responsive" alt="">
                                   <?php }else{ ?>
                                   <img style="height:336px;" src="<?php echo $this->config->item('frontend_profileimage_path');?>fundraising_profile.jpg" class="img-responsive" alt="" id="model_fundraising_image">
                                   <?php } ?>
                                   <div class="name_bar" style="width:93%;">
                                    <h5 class="text-center" id="auto_fill_name"><?php echo $display_name;?></h5>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="wrapper_box search_event ">
                        <div class="row">
                            <div class="col-md-2 col-sm-2">
                              <span id="amount_span" style="color:white;">$0</span><br>
                              <b> My Goal</b>
                          </div>

                          <div class="col-md-1 col-sm-2">
                            $0<br>
                            <b>Given</b>
                        </div>
                        <div class="col-md-2 col-sm-2">
                            <span id="amount_span_needed" style="color:white;">$0</span><br>
                            <b> Still Needed</b>
                        </div>
                        <div class="col-md-3 col-sm-3">
                            $0<br>
                            <b>No. Of donations</b>
                        </div>
                        <div class="col-md-3 col-sm-3">
                            $0<br>
                            <b>Average Donation</b>
                        </div>

                    </div>
                </div>
               <div class="clear"></div>
                <h5 class="text-left">My Story</h5>
                 <div class="row">
        <div class="col-sm-12" id="preview_story">

        </div>
  </div>

                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default search_events" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
   <button class="search_events  submit_btn" type="button" onclick="window.history.back();">Cancel</button>
	<input type="hidden" name="default_profile_image" id="default_profile_image" value="fundraising_profile.jpg"/>
</div>
</div>
</form>
</div></div>

<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>  -->
<script src="https://apis.google.com/js/client.js"></script>
<script src="<?php echo $this->config->item('frontend_js_path');?>jquery.validate.min.js"></script>
<script type="text/javascript">
 function facebook_inprogress(){
    alert("In-Progress");
}

function auth() {
   var config = {
     'client_id': '858258808581-lnntk0smj71fmrm16c8ogibpjvh05nbj.apps.googleusercontent.com',
     'scope': 'email'
 };
 gapi.auth.authorize(config, function() {
     fetch(gapi.auth.getToken());

 });
}

function fetch(token) {
   $.ajax({
      url: "https://www.google.com/m8/feeds/contacts/default/full?max-results=500&access_token=" + token.access_token + "&alt=json",
      dataType: "jsonp",
      success:function(data) {
				 //console.log(data.feed.entry);
                var primaryEmail;
                var output_data = "";
                for (var i=0; i < data.feed.entry.length; i++) {
                  if (typeof data.feed.entry[i].gd$email === "undefined") {
                  }else{
						//	document.getElementById('invite_list').style.display = 'block';
                     var assign = $.parseJSON(JSON.stringify(data.feed.entry[i].gd$email));
						//	output_data += '\n \n' + assign[0].address;

                     var message = '<tr>';
                     message += '<td><input type="checkbox" class="check_all_boxes" id="" name""></td>';
                     message += '<td></td>';
                     message += '<td>'+assign[0].address+'</td>';
                     message += '<td><img src="../../../images/gplus.png" class="center-block table_social img-responsive" alt=""></td>';
                     message += '<td><img src="../../../images/close.png" class="center-block table_social img-responsive" alt=""></td></tr>';

                     $("#table_invite tbody").append(message);
                 }
             }

             document.getElementById('invite_list').style.display = 'block';


         }
     });
}
</script>
<script>
	$(function() {
		$('#display_name').blur(function(){
			//$('#auto_fill_name').val(this.value);
			document.getElementById("auto_fill_name").innerHTML = this.value;
		});

		$('#target_amount').blur(function(){
			//$('#auto_fill_name').val(this.value);
			document.getElementById("amount_span").innerHTML = this.value;
			document.getElementById("amount_span_needed").innerHTML = this.value;
		});


		$('#page_title').blur(function(){
			document.getElementById("model_title").innerHTML = this.value;
		});

		<?php if($get_charity_id){?>
			// auto load events
				var charity_id = <?php echo $get_charity_id;?>;
				var event_id = <?php echo $recieved_event_id;?>;
				$("#select_event").load("<?php echo $this->config->item("on_load_event_by_organization");?>?organization_id="+charity_id+"&event_id="+event_id);
		<?php } ?>

		<?php if($recieved_event_id){?>
		var charity_id = <?php echo $recieved_event_id;?>;
		var sub_event_id = <?php echo $recieved_sub_event_id;?>;
		$("#select_sub_event").load("<?php echo $this->config->item("load_sub_event_by_event_id");?>?event_id="+charity_id+"&sub_event_id="+sub_event_id);
		<?php } ?>


	});

	function update_amount(amount){
		document.getElementById("target_amount").value=amount;
		document.getElementById("amount_span").innerHTML = amount;
		document.getElementById("amount_span_needed").innerHTML = amount;
	}

	// auto load events
	function load_event_by_organization_id(parent){
		$("#select_event").load("<?php echo $this->config->item("on_load_event_by_organization");?>?organization_id=" + parent.value);

		$("#select_sub_event").prepend("<option value=''></option>").val('');
    }

	// auto load sub events
	function load_sub_event_by_event_id(parent){
		$("#select_sub_event").load("<?php echo $this->config->item("load_sub_event_by_event_id");?>?event_id=" + parent.value);
    }


    $("#fundraising_image").change(function(){


		var fullPath = document.getElementById('fundraising_image').value;
		if (fullPath) {
			var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
			var filename = fullPath.substring(startIndex);
			if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
				filename = filename.substring(1);
			}
			document.getElementById('fundraising_name').value = filename;
		}

		read_fundraise_URL(this);

		document.getElementById('extra_space_logo').style.display = 'block';
		document.getElementById('blah').style.display = 'block';
	//	document.getElementById('logo_error').style.display = 'none';
  document.getElementById('blah').style.height = 'inherit';
  document.getElementById('blah').style.width = 'inherit';
});

    function read_fundraise_URL(input) {
      if (input.files && input.files[0]) {
         var reader = new FileReader();
         reader.onload = function (e) {
            $('#blah').attr('src', e.target.result);
            $('#model_fundraising_image').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

(function($,W,D){
    var user_validation = {};
    user_validation.UTIL =
    {
        setupFormValidation: function()
        {
            //form validation rules
            $("#add_champion_form").validate({
                ignore: "",
                rules: {
                    page_title: {
                        required: true,
                    },
                    display_name: {
                        required: true,
                    },
                    select_charity: {
                        required: true,
                    },
                    select_event: {
                        required: true,
                    },
                    select_sub_event: {
                        required: true,
                    },
                    message: {
                        required: true,
                    },
                    target_amount: {
                        required: true,
                        number:true,
                        maxlength: 6,
						greaterThanZero : true,
                    },
                    fundraising_image: {
					   required:function (element) {
					   if($("#no_image").is(':checked')){
						return false;
					   }
					   else
					   {
						return false;
					   }
					  },
                    },
                },
                messages: {
                   target_amount: {
                      number: jQuery.validator.format("Invalid amount."),
                      maxlength: jQuery.validator.format("target amount max can be 6 digits.")
                  },
              },
              submitHandler: function(form) {
                form.submit();
            }
        });
            jQuery.validator.addMethod("alpha", function(value, element) {
                return this.optional(element) || value == value.match(/^[a-zA-Z]+$/);
            },"Only alphabets are allowed for display name.");


            jQuery.validator.addMethod("greaterThanZero", function(value, element) {
              return this.optional(element) || (parseFloat(value) > 0);
            }, "invalid amount");
        }
    }
    //when the dom has loaded setup form validation rules
    $(D).ready(function($) {
        user_validation.UTIL.setupFormValidation();
    });
})(jQuery, window, document);
</script>


<script>

    $(document).ready(function(){

		 $('#my_md').click(function(){
			var value=$('#message').val();
			var get_val=value.replace(/\r?\n/g,'<br/>');
			$('#preview_story').html(get_val);
		});

       var event_path='<?php echo $this->config->item("event_image");?>';
       $('#select_event').change(function(){

        var event_id=$(this).val();
       // alert(event_id);
        $.ajax({
            type: "post",
            url: "<?php echo base_url(); ?>index.php/frontend/champion/get_event_image/"+event_id,
            cache: false,
            success: function(get_image_path){
               var full_path=event_path+'/'+get_image_path;
               $('#original_event_image').attr('src',full_path);
            },
           error: function(){
            alert('Error while request..');
          }
        });
      });
    });

	 $(document).ready(function(){



   $('#no_image').click(function(){


    if(document.getElementById('no_image').checked) {
      var default_img_path=$('#default_profile_image').val();
	  var image_url = "https://TicketingSystem.co.nz/assets/image_uploads/profile_images/"+default_img_path;
      $('.fundraising_p').slideUp();
      $('#model_fundraising_image').attr('src',image_url);
      $('.fundraising_p_image').slideUp();
	  $('.fundraise_old_image').val(default_img_path);

    } else {
    // alert('unchecked');

      $('.fundraising_p').slideDown();
      $('.fundraising_p_image').slideDown();
      $('#fundraising_name').val('');
      $("#fundraising_image").val("");
      $('#blah').css({'display':'none'});
      $('#blah').removeAttr('src');
	  <?php if($profile_image != ""){ ?>
	  $('#model_fundraising_image').attr('src','<?php echo $profile_image_name;?>');
	   $('.fundraise_old_image').val(default_img_path);
	  <?php }else{ ?>
	    $('.fundraise_old_image').val('fundraising_profile.jpg');
	  <?php } ?>
    }
  });

 });
</script>