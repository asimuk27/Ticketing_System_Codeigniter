<style>
 .table-responsive th{padding:10px !important;}
 .table-responsive td{padding:10px !important;}
 .table{margin-bottom:0px;}
 .blue_box{margin-bottom:0px;}
 .top-margin{margin-top:10px;}
 .registration_section{margin-top: 10px;}
 input[type="password"] {
		border: 1px solid rgb(185, 193, 204);
		color: #666;
		height: 43px;
		margin-bottom: 10px;
		padding: 8px 10px;
		width: 100%;
	}
	.error{color:red;}
	.paragraph{font-weight: bold;}
	.internal_tab_space label{font-weight:normal;}
	.response_style{
		color: red;
		border-color: #4cae4c; 
		font-weight:bold;
		text-align:center;
	}
</style>

<link href="<?php echo $this->config->item('frontend_css_path');?>jquery-ui.css" rel="stylesheet">

<script src="<?php echo $this->config->item('frontend_js_path');?>jquery-ui.min.js"></script> 

<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script> 



<style>

	.color-red{color:red;}

	.error{color:red;}

</style>

<div>

 <form method="post" action="<?php echo base_url(); ?>frontend/orders/save_order_details" name="summary_form" id="summary_form">



   <input type="hidden" name="login_status" value="<?php echo $login_status; ?>" id="login_status" />

   <input type="hidden" name="user_id" value="<?php echo $user_id; ?>" id="user_id" />

   <div class="content">

     <div class="sub-header">

     </div>

     <div class="Kode-page-heading">

      <div class="container">

      <div class="row">
        <div class="col-md-6 col-sm-6">
         <h2>Checkout</h2>
       </div>
     
   </div>
 </div>

</div>

<div class="kode-blog-style-2">

  <div class="container">

   <hr class="hr_spacing">

   <div class="row">

    <div class="col-md-9">

     <div class="blue_box">

      <h5 class="paragraph">Ticket Summary</h5>

      <div class="row">

       <div class="col-md-12">

        <div class="search_events ">

         <table class="table"  width="100%" border="0" cellspacing="0" cellpadding="0">
        <!--   
          <thead>
           <tr class="text-center">
            <th style="width:30%;">Ticket Name</th>
            <th style="width:50%;">Location</th>
            <th style="width:10%;">Price</th>
            <th style="width:10%;">Quantity</th>
          </tr>
        </thead>-->
        <tbody>
         <?php 
			$tick_total=0;
			$total_qyt=0;
			$generator=0;
         ?>
         <?php 
			foreach($ticket_data as $key1 => $values){  
			foreach ($values as $key => $value) {
                if($key=="id"){

                }else if($key=="ticket_price"){
			 	echo  "<tr> <th scope='row' >Price</th>";
                  echo "<td><i class='fa fa-usd' aria-hidden='true'></i>".number_format($value,2)."</td>";
				  echo "</tr>";
                }else if($key=="fee"){

                }else if($key=="location"){
				echo  "<tr> <th scope='row'>Location</th>";
                    echo "<td style= overflow: auto;'> ".$value."</td>";
					 echo "</tr>";
                }else if($key=="ticket_name"){
				echo  "<tr> <th scope='row' style='width:120px;'>Ticket Name</th>";
                    echo "<td  overflow: auto;'> <i class='fa fa-ticket' aria-hidden='true'></i> ".$value."</td>";
					echo "</tr>";
                }else{
				echo  "<tr> <th scope='row'>Quantity</th>";
					echo "<td >".$value."</td>";
					echo "</tr>";
				}          

           ?>
      <?php 

    }
    



  }?>

  <input type="hidden" name="generator" value="<?php echo $generator; ?>">

  <input type="hidden" name="sub_event_id" value="<?php echo $sub_event_id; ?>">


<tr>
    <td colspan="2" scope="row"> <div class="order_total" style="float:right"><span ><b>Total Amount: <i class='fa fa-usd' aria-hidden='true'></i><?php echo number_format($temp_ticket_total,2); ?></b></span><span style="margin-left: 10px"><b>Total Quantity: <?php echo $total_qytt; ?></b></span></div></td>
  </tr>
 

</tbody>

</table>

</div>

</div>

</div>

</div>

</div>

<?php if(!empty($data)){ ?>
<div class="col-md-9">

 <div class="blue_box">

  <h5 class="paragraph">Support Summary</h5>

  <div class="row">

   <div class="col-md-12">

    <div class="search_events table-responsive">

     <table class="table">

      <thead>

       <tr class="text-center">

        <th>Champion Name</th>

        <th>Event Name</th>

        <th>Donation</th>

      </tr>

    </thead>

    <tbody>

     <?php $order_total=0; ?>

     <?php foreach($data as $key => $values){?>

     <tr>

      <?php foreach($values as $value => $v){?>  
            <?php if($value=="champ_amount"){?>
            <td> <i class='fa fa-usd' aria-hidden='true'></i><?php echo number_format(round($v)); ?></td>
            <?php }else if($value=="champ_choose" || $value=="champ_message"){ ?>
             
            <?php }else{ ?>
            <td><?php echo $v; ?></td>
            <?php } ?>

     <?php } ?>

   </tr>

   <?php } ?>

   <td colspan="6" style="margin-top:50px">

    <div class="order_total" style="float:right"><b>Total Amount: <i class='fa fa-usd' aria-hidden='true'></i><?php echo (isset($temp_champion_total) ? number_format(round($temp_champion_total)) : '0'); ?></b></span></div>

  </td>

</tbody>

</table>

</div>

</div>

</div>

</div>

</div>
<?php } ?>

</div>

<div class="row top-margin">

  <div class="col-md-6">  

   &nbsp;

 </div>
 <div class="col-md-3"><b class="check_out_Ototal">Order Total : <i class='fa fa-usd' aria-hidden='true'></i><?php echo number_format($order_amount,2); ?></b>
 </div>
</div>
<?php if($this->session->flashdata('message')): ?>
    <div class="row">
		<div class="col-md-9 response_style"><?php echo $this->session->flashdata('message'); ?></div>
	</div>
<?php endif; ?>
<div class="row">

  <div class="col-md-9">

   <div class="blue_box registration_section">

    <h5 class="paragraph">Purchaser Details</h5>

    <div class="row internal_tab_space">

     <div class="col-md-12 verify_lstatus2">

      




       <div class="row">
			<div class="col-md-3 col-sm-3">
			<label class="search_events">&nbsp;</label>
      </div>
      <div class="col-sm-6"> 
			<a href="#" onclick="logInWithFacebook()">
				<img src="<?php echo $this->config->item('frontend_image_path');?>images/fb1.png">
            </a>
	  </div>	    
      </div>

	  <div class="row">
			<div class="col-md-3 col-sm-3">
			<label class="search_events">&nbsp;</label>
      </div>
      <div class="col-sm-6"> 
			<img src="<?php echo $this->config->item('base_url')?>images/divider.png" class="img-responsive">
	  </div>	    
      </div>


      <div class="row">

       <div class="col-md-9 col-sm-9">

        <p class="paragraph">You already have a account?</p>

      </div>

      <div class="clear"></div>

      <div class="col-md-3 col-sm-3">

        <label for="login_email" class="search_events">Email<span class="color-red">*</span></label>

      </div>

      <div class="col-md-6 col-sm-6">

        <input type="text" placeholder="Email" class="search_events form-control" name="name" id="login_email">

      </div>



      <div class="clear"></div>

      <div class="col-md-3 col-sm-3">

        <label for="login_password" class="search_events">Password<span class="color-red">*</span></label>

      </div>

      <div class="col-md-6 col-sm-6">
    
        <input type="password" placeholder="Password" class="search_events form-control" name="name" id="login_password">
             <div id="invalid_user" style="color:red; font-weight: bold"></div>
      </div>

      <div class="clear"></div>

      <div class="col-md-offset-3 col-md-6 col-sm-offset-3 col-sm-6">

       <a class="for_large_btn three_inline_buttons logsin" style="text-align:center;cursor:pointer;">Login</a>

      </div>

    </div>

  </div>

  


   <div class="row hide_last" >
		<div class="col-md-3 col-sm-3">
			<label class="search_events">&nbsp;</label>
		</div>
    <div class="col-sm-6"> 
		<img src="<?php echo $this->config->item('base_url')?>images/divider.png" class="img-responsive">
	</div>	    
    </div>
	  
  <div class="col-md-12">

    <div class="row">

     <div class="col-md-9 col-sm-9 verify_lstatus">

      <p class="paragraph">Register Now</p>

    </div>
	<div class="clear"></div>
    <div class="col-md-3 col-sm-3">

      <label for="first_name" class="search_events">Name<span class="color-red">*</span></label>

    </div>

    <div class="col-md-6 col-sm-6">

      <div class="row">

       <div class="col-md-6 col-sm-6">

        <input type="text" placeholder="First Name" class="search_events form-control" name="g_fname" id="first_name" >

     </div>

     <div class="col-md-6 col-sm-6">

      <input type="text" placeholder="Last Name" class="search_events form-control" name="g_lname" id="last_name">

    </div>



 </div>

</div>

<div class="clear"></div>

<div class="col-md-3 col-sm-3">

  <label for="em" class="search_events">Email<span class="color-red">*</span></label>

</div>

<div class="col-md-6 col-sm-6">

  <input type="text" placeholder="Email" class="search_events form-control" name="g_email" id="em">

 

</div>

<div class="clear"></div>

<div class="col-md-3 col-sm-3">

  <label for="c_email" class="search_events">Confirm Email<span class="color-red">*</span></label>

  

</div>

<div class="col-md-6 col-sm-6">

  <input type="text" placeholder="Confirm Email" class="search_events form-control" name="g_cemail" id="c_email">

  <div id="confirm_email_error" style="color:maroon">



  </div>
  </div>
  
  <div class="clear"></div>
  
  <div class="col-md-3 col-sm-3">

  <label for="phone_no">Contact Number</label>
  

</div>

<div class="col-md-6 col-sm-6">
<input type="text" id="phone_no" name="phone_no" class="search_events form-control" placeholder="Contact Number" value="<?php echo set_value('phone_no');?>">



  </div>
  
  <?php
  if($this->session->userdata('logged_in')){
    
  }else{
  ?>

  <div class="clear"></div>

<div class="col-md-3 col-sm-3">

 <label for="password" class="search_events">Password<span class="color-red">*</span></label>

  

</div>

<div class="col-md-6 col-sm-6">

  <input type="password" id="password" name="password" class="search_events form-control" placeholder="Password">



  </div>
  
  
  <div class="clear"></div>

<div class="col-md-3 col-sm-3">

  <label for="confirm_password" class="search_events">Confirm Password<span class="color-red">*</span></label>

  

</div>

<div class="col-md-6 col-sm-6">

 <input type="password" id="confirm_password" name="confirm_password" class="search_events form-control" placeholder="Confirm Password">



  </div>
  
<?php
}
?>


</div>

     
    
     <div class="clear"></div>
<div class="row">

 <div class="col-md-9 col-sm-9">

  <p class="paragraph">Billing Information</p>

</div>
<div class="clear"></div>

<div class="col-md-3 col-sm-3">

  <label for="address1" class="search_events">Street<span class="color-red">*</span></label>

</div>

<div class="col-md-6 col-sm-6">

  <input  type="text" placeholder="Street" class="search_events form-control"  name="g_addr" id="address1">

 



</div>

<div class="clear"></div>

<div class="col-md-3 col-sm-3">

  <label for="address2" class="search_events">Suburb<span class="color-red">*</span></label>

</div>

<div class="col-md-6 col-sm-6">

  <input type="text" placeholder="Suburb" class="search_events form-control"  name="g_addr2" id="address2">

</div>

<div class="clear"></div>

<div class="col-md-3 col-sm-3">

  <label for="city" class="search_events">City<span class="color-red">*</span></label>

</div>

<div class="col-md-6 col-sm-6">

  <input type="text" placeholder="City" class="search_events form-control"  name="g_city" id="city">



</div>

<div class="clear"></div>

<div class="col-md-3 col-sm-3">

  <label for="postcode" class="search_events">Postal Code<span class="color-red">*</span></label>

</div>

<div class="col-md-6 col-sm-6">

  <input type="text" placeholder="Postal Code" class="search_events form-control"  name="g_postal" id="postcode" >

</div>

<div class="clear"></div>
<div class="col-md-3 col-sm-3">

  <label for="g_country" class="search_events">Country<span class="color-red">*</span><label>

</div>

<div class="col-md-6 col-sm-6">

  <select class="form-control dropdown"  name="g_country" id="g_country">

   <option value="" selected="selected"> Select Country</option>
                <option value="Australia">Australia</option>
                <option value="Austria">Austria</option>
                <option value="Belgium">Belgium</option>	
                <option value="Cook Islands">Cook Islands</option>	
                <option value="Denmark">Denmark</option>	
                <option value="France">France</option>	
                <option value="Fiji">Fiji</option>	
                <option value="Germany">Germany</option>	
                <option value="Itally">Itally</option>	
                <option value="New Zealand">New Zealand</option>
                <option value="Niue">Niue</option>	
                <option value="Norway">Norway</option>
                <option value="Samoa">Samoa</option>
                <option value="Switzerland">Switzerland</option>
                <option value="Tonga">Tonga</option>
                <option value="United States">United States</option>
                <option value="United Kingdom">United Kingdom</option>


 </select>

</div>

<div class="clear"></div>

<div class="col-md-6 col-md-offset-3 col-sm-offset-3">

   <input type="checkbox" name='tc' id="tc" value="" class="common_no_check" onclick="return false" data-toggle="modal" data-target="#myModal">&nbsp;&nbsp;&nbsp;<a for="email" class="search_events modal_click common_no_check" data-toggle="modal" data-target="#myModal" style="cursor:pointer" id="show_terms">show terms and conditions</a>
   <div class="tc_err" style="color:red"></div>
</div>
<div class="clear"></div>

<!--
<?php //if(!empty($payment_method)){ ?>
<div class="col-md-9 col-sm-9">
  <p class="paragraph">Payment Methods</p>
</div>
<?php //foreach($payment_method as $checkouts){ ?>
	<div class="col-md-9 col-sm-9">
	<input type="radio" id="<?php //echo $checkouts['payment_key']?>" name="check_out_method" class="" value="<?php //echo $checkouts['payment_key']?>" checked="checked">&nbsp;&nbsp;<label for="<?php echo $checkouts['payment_key']?>"><?php //echo $checkouts['payment_method_name']?></label> 
	</div>
<?php //} ?>
<div class="clear"></div>
<div class="col-md-offset-3 col-md-6 col-sm-offset-3 col-sm-6">
  <button class="for_large_btn three_inline_buttons sub" type="submit" >Pay Now</button>
</div>
<?php //} ?>
-->
<?php if($order_amount > 0){ ?>
<?php if(!empty($payment_method)){ ?>
<div class="col-md-9 col-sm-9">
  <p class="paragraph">Payment Methods</p>
</div>
<?php foreach($payment_method as $checkouts){ ?>
	<div class="col-md-9 col-sm-9">
	<input type="radio" id="<?php echo $checkouts['payment_key']?>" name="check_out_method" class="" value="<?php echo $checkouts['payment_key']?>" checked="checked">&nbsp;&nbsp;<label for="<?php echo $checkouts['payment_key']?>"><?php echo $checkouts['payment_method_name']?></label> 
	</div>
<?php } ?>
<br class="clear">
<div class="col-md-offset-3 col-md-6 col-sm-offset-3 col-sm-6">
  <button class="for_large_btn three_inline_buttons sub" type="submit" >Pay Now</button>
</div>
<?php } }else{ ?>
	<br class="clear">
	<div class="col-md-offset-3 col-md-6 col-sm-offset-3 col-sm-6">
		<button class="for_large_btn three_inline_buttons sub" type="submit" >Book Now</button>
		<input type="hidden" id="" name="check_out_method" class="" value="free" checked="checked">
	
	</div>
<?php } ?>



</div>

</div>

</div>

</div>

</div>

</div>

</div>

<!--Container-->

</div>

</div>

<!--Content-->

</form>

</div>




























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

   <div style="width:100%; height:300px; overflow: auto;" class="body_info">

    </div>



      </div>

      <div class="modal-footer">

      <div  style="float:left">  

         <input type="checkbox" name='modal_tc' id="modal_tc" value="" required="required">&nbsp;&nbsp;&nbsp;<label for="modal_tc" class="search_events">I agree</label>

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
var count=0;


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



 $('form').submit(function(e){
            $('.tc_err').text('');
         if($('#tc').prop('checked')==false){ 
           $('.tc_err').text('field is required');
           count++;
         } 

		  if($('#tc').prop('checked')==true){
           count=0;
         }

 })


});







 (function($,W,D){
    var user_validation = {}; 
    user_validation.UTIL =
    {
        setupFormValidation: function()
        {
            //form validation rules
          $("#summary_form").validate({
                rules: {
				g_fname: {
                    required: true, 
                },
			    g_lname: {
					required: true,					
				},
			    g_email: {
					required: true,
					email: true,        
				},
			    g_cemail: {
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
			    g_addr: {
					required: true,	
				},
			    g_addr2: {
					required: true,			
				},
			    g_city: {
					required: true, 					
				},
				g_postal: {
					required: true, 
					number:true,
                },
				},
                messages: {      
			  confirm_password: {                   

              equalTo: jQuery.validator.format("confirm password should be same as password")

            },	
        },

                submitHandler: function(form) {

                    if(count>0){
                       $('form').submit(false);
                     }else{
                        form.submit();
                     }

                }

            });
			jQuery.validator.addMethod("alpha", function(value, element) {
				return this.optional(element) || value == value.match(/^[a-zA-Z]+$/);
			 },"Only alphabets are allowed");
        }

    }

    //when the dom has loaded setup form validation rules

    $(D).ready(function($) {

        user_validation.UTIL.setupFormValidation();

    }); 

})(jQuery, window, document);
</script>


<script type="text/javascript">

 $(document).ready(function(){



  var login_status = $('#login_status').val();



  if(login_status==1)

  {

   $('.verify_lstatus').hide();
	$('.hide_last').hide();
   $('.verify_lstatus2').hide();

   var user_id=$('#user_id').val();

   $.ajax({

    type: "post",

    url: "<?php echo base_url(); ?>index.php/frontend/events/get_loggedin_user_details/"+user_id,

    cache: false,  

    success: function(json){

      var obj = jQuery.parseJSON(json);

      $.each(obj, function(key,value) {

        $('#first_name').val(value.first_name);

        $('#last_name').val(value.last_name);

        $('#em').val(value.email);

        $('#c_email').val(value.email);
        
         $('#phone_no').val(value.phone_no);
        $('#password').val(value.password);
          $('#confirm_password').val(value.password);
        $('#address1').val(value.street_address);

        $('#address2').val(value.suburb);

        $('#city').val(value.city);

        $('#city').val(value.city);

        $('#postcode').val(value.postcode);

       

      }

      );

    }

    ,

    error: function(){

      alert('Error while request..');

    }

  }

  );



 }



 $('.logsin').click(function(){

      var user_email=$('#login_email').val();

      var user_password=$('#login_password').val();

      

    $.ajax({

    type: "post",

    url: "<?php echo base_url(); ?>index.php/frontend/events/verify_login_user",

   data: "user_email="+user_email+"&user_password="+user_password,

    cache: false,  

    success: function(json){

      if(json=='invalid'){

        $('#invalid_user').text('Invalid email or password');

      }else{

		  var url = "http://infidigi.com/event_management_dev/index.php/frontend/events/save_ticket_details";

        

//$("#navigation").load(location.href+" #navigation>*","");

 location.reload();



		 var obj = jQuery.parseJSON(json);

         $('.verify_lstatus').hide();

         $('.verify_lstatus2').hide();          



           $.each(obj, function(key,value) {

           $('#first_name').val(value.first_name);

           $('#last_name').val(value.last_name);

           $('#em').val(value.email);

           $('#c_email').val(value.email);

           $('#address1').val(value.street_address);

           $('#address2').val(value.suburb);

           $('#city').val(value.city);

           $('#city').val(value.city);

           $('#postcode').val(value.postcode);

      }

      );



      }

     

      

    }

    ,

    error: function(){

      alert('Error while request..');

    }

  }

  );









 });



 





});
</script>


<form name="myForm" id="myForm" action="<?php echo base_url(); ?>frontend/login/checkout_login_ajax" method="post">
     <input type="hidden" name="first_name" id="first_name">
     <input type="hidden" name="last_name" id="last_name">
     <input type="hidden" name="id" id="id">
     <input type="hidden" name="email_idz" id="email_idz">
  </form>

<script>
  function logInWithFacebook() {
  
  FB.login(function(response) {
      if (response.authResponse) {        
     // console.log(response.authResponse);
       FB.api('/me?fields=id,first_name,last_name,email,permissions', function(response){
        
        if(response.id!='' && response.email!=''){          
          document.getElementById("id").value = response.id;
          document.getElementById("first_name").value = response.first_name;
          document.getElementById("last_name").value = response.last_name;
          document.getElementById("email_idz").value = response.email;
          document.forms["myForm"].submit();
        }
       });
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
  });
 </script>




















