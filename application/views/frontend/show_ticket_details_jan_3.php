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
</style>

<link href="<?php echo $this->config->item('frontend_css_path');?>jquery-ui.css" rel="stylesheet">

<script src="<?php echo $this->config->item('frontend_js_path');?>jquery-ui.min.js"></script> 

<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script> 



<style>

	.color-red{color:red;}

	.error{color:red;}

</style>

<div>

 <form method="post" action="<?php echo base_url(); ?>index.php/frontend/orders/save_order_details" name="summary_form" id="summary_form">



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

        <div class="search_events table-responsive">

         <table class="table">

          <thead>

           <tr class="text-center">

            <th>TICKET TYPE</th>

            <th>LOCATION</th>

            <th>FEE</th>

            <th>PRICE</th>

            <th >QUANTITY</th>

          </tr>

        </thead>

        <tbody>

         <?php $tick_total=0;

         $total_qyt=0;







         $generator=0;







         ?>

         <?php foreach($ticket_data as $key1 => $values){ 

          echo  "<tr>";







          foreach ($values as $key => $value) {
               if($key=="id")   
               {

               }
               else if($key=="ticket_price")
               {
                  echo "<td><i class='fa fa-usd' aria-hidden='true'></i>".number_format(round($value))."</td>";
               }
               else
               {
                 echo "<td>".$value."</td>";
               }
              

           ?>



     

      <?php 

    }







    echo "</tr>";














  }?>

  <input type="hidden" name="generator" value="<?php echo $generator; ?>">

  <input type="hidden" name="sub_event_id" value="<?php echo $sub_event_id; ?>">

  <tr>

    <td colspan="6" style="margin-top:50px">

     <div class="order_total" style="float:right"><span ><b>Total Amount: <i class='fa fa-usd' aria-hidden='true'></i><?php echo $temp_ticket_total; ?></b></span><span style="margin-left: 20px"><b>Total Quantity: <?php       echo $total_qytt; ?></b></span></div>

   </td>

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

        <th>CHAMPION</th>

        <th>ORGANISATION</th>

        <th>SUBTOTAL</th>

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
 <div class="col-md-3"><b class="check_out_Ototal">Order Total : <i class='fa fa-usd' aria-hidden='true'></i><?php echo number_format(round($order_amount)); ?></b>
 </div>
</div>
<div class="row">

  <div class="col-md-9">

   <div class="blue_box registration_section">

    <h5 class="paragraph">Registration</h5>

    <div class="row internal_tab_space">

     <div class="col-md-12 verify_lstatus2">

      




       <div class="row">
			<div class="col-md-3 col-sm-3">
			<label class="search_events">&nbsp;</label>
      </div>
      <div class="col-sm-6"> 
			<a href="<?php echo base_url(); ?>index.php/frontend/auth/login_checkout">
				<img src="<?php echo $this->config->item('frontend_image_path');?>images/fb1.png">
            </a>
	  </div>	    
      </div>

	 <div class="row">
			<div class="col-md-3 col-sm-3">
			<label class="search_events">&nbsp;</label>
      </div>
      <div class="col-sm-6" style="text-align:center;font-weight:bold;margin-top:10px;"> 
			OR
	  </div>	    
      </div>


      <div class="row">

       <div class="col-md-9 col-sm-9">

        <p class="paragraph">You already have a account?</p>

      </div>

      <br class="clear">

      <div class="col-md-3 col-sm-3">

        <label for="login_email" class="search_events">Email<span class="color-red">*</span></label>

      </div>

      <div class="col-md-6 col-sm-6">

        <input type="text" placeholder="email" class="search_events form-control" name="name" id="login_email">

      </div>



      <br class="clear">

      <div class="col-md-3 col-sm-3">

        <label for="login_password" class="search_events">Password<span class="color-red">*</span></label>

      </div>

      <div class="col-md-6 col-sm-6">
    
        <input type="password" placeholder="password" class="search_events form-control" name="name" id="login_password">
             <div id="invalid_user" style="color:red; font-weight: bold"></div>
      </div>

      <br class="clear">

      <div class="col-md-offset-3 col-md-6 col-sm-offset-3 col-sm-6">

       <a class="for_large_btn three_inline_buttons logsin" style="text-align:center;cursor:pointer;">Login</a>

      </div>

    </div>

  </div>

  



  <div class="col-md-12">

    <div class="row">

     <div class="col-md-9 col-sm-9 verify_lstatus">

      <p class="paragraph">Continue as Guest</p>

    </div>
	<br class="clear">
    <div class="col-md-3 col-sm-3">

      <label for="first_name" class="search_events">Name<span class="color-red">*</span></label>

    </div>

    <div class="col-md-6 col-sm-6">

      <div class="row">

       <div class="col-md-6 col-sm-6">

        <input type="text" placeholder="firstname" class="search_events form-control" name="g_fname" id="first_name" >

     </div>

     <div class="col-md-6 col-sm-6">

      <input type="text" placeholder="last name" class="search_events form-control" name="g_lname" id="last_name">

    </div>



 </div>

</div>

<br class="clear">

<div class="col-md-3 col-sm-3">

  <label for="em" class="search_events">Email<span class="color-red">*</span></label>

</div>

<div class="col-md-6 col-sm-6">

  <input type="text" placeholder="enter email" class="search_events form-control" name="g_email" id="em">

 

</div>

<br class="clear">

<div class="col-md-3 col-sm-3">

  <label for="c_email" class="search_events">Confirm Email<span class="color-red">*</span></label>

  

</div>

<div class="col-md-6 col-sm-6">

  <input type="text" placeholder="enter confirm email" class="search_events form-control" name="g_cemail" id="c_email">

  <div id="confirm_email_error" style="color:maroon">



  </div>

</div>

</div>

<div class="row">

 <div class="col-md-9 col-sm-9">

  <p class="paragraph">Billing Information</p>

</div>
<br class="clear">

<div class="col-md-3 col-sm-3">

  <label for="address1" class="search_events">Street<span class="color-red">*</span></label>

</div>

<div class="col-md-6 col-sm-6">

  <input  type="text" placeholder="enter address 1" class="search_events form-control"  name="g_addr" id="address1">

 



</div>

<br class="clear">

<div class="col-md-3 col-sm-3">

  <label for="address2" class="search_events">Suburb<span class="color-red">*</span></label>

</div>

<div class="col-md-6 col-sm-6">

  <input type="text" placeholder="enter address 2" class="search_events form-control"  name="g_addr2" id="address2">

</div>

<br class="clear">

<div class="col-md-3 col-sm-3">

  <label for="city" class="search_events">City<span class="color-red">*</span></label>

</div>

<div class="col-md-6 col-sm-6">

  <input type="text" placeholder="enter city" class="search_events form-control"  name="g_city" id="city">



</div>

<br class="clear">

<div class="col-md-3 col-sm-3">

  <label for="postcode" class="search_events">Postal Code<span class="color-red">*</span></label>

</div>

<div class="col-md-6 col-sm-6">

  <input type="text" placeholder="enter postal code" class="search_events form-control"  name="g_postal" id="postcode" >

</div>

<br class="clear">
<div class="col-md-3 col-sm-3">

  <label for="g_country" class="search_events">Country<span class="color-red">*</span><label>

</div>

<div class="col-md-6 col-sm-6">

  <select class="form-control dropdown"  name="g_country" id="g_country">

   <option value="New Zealand">New Zealand</option>

   <option value="Australia">Australia</option>

 </select>

</div>

<br class="clear">

<div class="col-md-6 col-md-offset-3 col-sm-offset-3">

  <input type="checkbox" name='tc' value="" required="required">&nbsp;&nbsp;&nbsp;<label for="tc" class="search_events">Accept the terms and conditions</label>

</div>
<br class="clear">
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



<script>





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
			  	
        },

                submitHandler: function(form) {

                    form.submit();

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