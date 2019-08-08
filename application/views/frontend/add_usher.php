<link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script>
	jQuery(document).ready(function(){ 
		jQuery(".pagination li a").click(function(e){ 
			document.getElementById('event_form').action = jQuery(this).attr('href');
			jQuery('#event_form').submit();   
			e.preventDefault();
		});
	});
</script>
<style>
  .pag {text-align: left;}
  .pag .active a{background:#337ab7;}
  .error{
    color:red;
    font-weight: bold;
    text-align: center;
  }
  .odd{background:#f9f9f9;}
  .even{background:#ffffff;}
  .table-bordered th{padding:10px !important;}
  .table-bordered td{padding:10px !important;}

  .radioclass{
    margin-left:20px;
  }
 
  #sub_event_id{margin:0px;}
</style>


    <script>
 
 $(document).on('click','.delete_user',function(){

   var row=this.id;
  // alert(row);

   confirmAction(row,changeStatus);




  function confirmAction(id, action){
    //alert(id);
    alertify.confirm("are you sure you want to delete an usher?", function(e) {
      if (e) {
        // a_element is the <a> tag that was clicked
        if (action) {
          action(id);
        }
      }
    });
  } 
  
  function changeStatus(id){ 
    //alert(id)
    $.ajax({
      type: "POST",
      dataType: 'json',
       url: "<?php echo base_url(); ?>index.php/frontend/ushers/delete_user",
      data: "id="+id,
      success: function(Rid1) {
        if (Rid1) {
          //location.reload();
          alertify.success("Usher deleted successfully");
          //document.getElementsByClassName(id).remove();
         // alert($('.'+id).val());
         $('.'+id).remove();
        }else{          
          alertify.error("Unable to delete usher");
        }
      }
    }); 
  }
      
  function reset()
  {
    $("#toggleCSS").attr("href", "<?php echo $this->config->item("admin_css_path");?>/alertify.default.css");
    alertify.set({
       labels : {
        ok     : "OK",
        cancel : "Cancel"
       },
	   
       delay : 5000,
       buttonReverse : true,
       buttonFocus   : "ok"
    });
    }
 });




</script>



     <!-- <h4>Manage Events</h4> -->
     <link href="<?php echo $this->config->item('admin_css_path');?>alertify.core.css" rel="stylesheet">

     <link href="<?php echo $this->config->item('admin_css_path');?>alertify.bootstrap.css" rel="stylesheet">

     <link href="<?php echo $this->config->item('admin_css_path');?>alertify.default.css" rel="stylesheet">

     <script src="<?php echo $this->config->item('admin_js_path');?>/alertify.min.js"></script>



    <script>

      function load_sub_event_by_event_id(parent){



        if(parent.value != ""){

          $("#select_sub_event").load("<?php echo $this->config->item("load_sub_event_by_event_id");?>?event_id=" + parent.value);

        }else{

         $('#select_sub_event option').remove();

       }



     }



   </script>

   <?php if((isset($_POST['eid'])) && (isset($_POST['sub_eid']))){

     $eid=$_POST['eid'];

     $sub_id=$_POST['sub_eid'];

   }

   else

   {

     $eid='';

     $sub_id='';

   }

   ?>


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

            <h2>Create Usher</h2>

          </div>
        </div>
        <!--ROW END-->
      </div>
    </div>
   <?php   //if($this->session->flashdata('message')){
   // echo "<pre>";
   // print_r($this->session->flashdata('message'));
   echo ""
   // }?>
    <!--Kode-our-speaker-heading End-->
    <div class="kode-blog-style-2 search_table">
      <div class="container">
        <div class="row" style="margin-bottom:0px;">
          <form  method="post" action="<?php echo base_url(); ?>index.php/frontend/ushers/save_usher" id="event_form">
            <input type="hidden" name="event_id" value="<?php echo $events['id']; ?>" autocomplete="off">
            
            <div class="col-sm-12 usher_events">
				<div class="row">
					<div class="col-sm-3"><label for=""><b>Event</b></label></div>
					<div class="col-sm-4"><?php echo $events['title']; ?></div>
				</div>
            </div>
            
            <div class="col-sm-12 usher_events">
				<div class="row"> 
					 <div class="col-sm-3"><label for="event"><b>Select Sub Event</b></label></div>
					  <div class="col-sm-4">
               <?php //echo "<pre>";print_r($sub_events);exit; ?>
							<select class="form-control dropdown" name="sub_event_id" id="sub_event_id">
								<option value="0">-- Select Sub Event --</option>
								<?php foreach($sub_events as $sub){?>
                <?php
                $posted_data=$this->session->flashdata('message'); 
                if($this->session->flashdata('message')!=null){
                   $posted_data=$this->session->flashdata('message'); 
                  } ?>

                <?php 
                 if(isset($posted_data) && $posted_data['post_data']['sub_event_id']==$sub['id']){ ?>
                 <option value="<?php echo $sub['id']; ?>" selected><?php echo $sub['schedule_title']; ?></option>   
                <?php 
                 }
                 else{
                  ?>
                    <option value="<?php echo $sub['id']; ?>"><?php echo $sub['schedule_title']; ?></option>
                  <?php

                 }
                ?>  
							
								<?php } ?>
						</select>              
					  </div>
					  
				  </div>
             <?php echo form_error('sub_event_id'); ?>	
			
			<div class="err_task" style="color:red; font-weight:bold; position: relative; left:293px;" autocomplete=false>
			</div>
            </div>   
			<div class="col-sm-12 usher_events" id="show_dat" style="display:none">
				<div class="row">
					<div class="col-sm-3">
					<label for="event"><b>Start Date & Time</b></label>
					</div>
					<div class="col-sm-2" name="startdate" id="startdate">
					<?php if($this->session->flashdata('start')){
					echo $this->session->flashdata('start');} ?> 
					</div>
					<div class="col-sm-2" name="starttime" id="starttime"><?php if($this->session->flashdata('s_time')){
					echo $this->session->flashdata('s_time');}?>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
					<label for="event"><b>End Date & Time</b></label>
					</div>
					<div class="col-sm-2" name="enddate" id="enddate"> <?php if($this->session->flashdata('end')){
					echo $this->session->flashdata('end');}?></div>
					<div class="col-sm-2" name="endtime" id="endtime"><?php if($this->session->flashdata('e_time')){
					echo $this->session->flashdata('e_time');} ?></div>
				</div>
			</div>
			
			
			
			

            <div class="col-sm-12 usher_events">
              <div class="row">
			  <div class="col-sm-3"><label><b>Ticket Checking Method</b></label></div>
         <div class="col-sm-4"> 
         <?php
                $posted_data=$this->session->flashdata('message'); 
                if($this->session->flashdata('message')!=null){
                   $posted_data=$this->session->flashdata('message'); 
                 //echo "<pre>";
                // print_r($posted_data);exit;
                  } 
                  if(isset($posted_data) && $posted_data['usher_data'][0]['ticket_checking_method']==1){ 

                    ?>
                     <label class="">
                     <input type="radio" name="opt" class="o" value="1" checked="checked"> Online only
                    </label>
                       <label class="radioclass">
                <input type="radio" name="opt"  class="ob" value="2"> Online and offline
                </label>
                   <?php }else if(isset($posted_data) && $posted_data['usher_data'][0]['ticket_checking_method']==2){ ?> 
                  
                  <label class="">
                     <input type="radio" name="opt" class="o" value="1"> Online only
                    </label>
                   <label class="radioclass">
                <input type="radio" name="opt"  class="ob" value="2" checked="checked"> Online and offline
                </label>
                   <?php }else{?>
                     <label class="">
                <input type="radio" name="opt" class="o" value="1" checked="checked"> Online only
              </label>
              <label class="radioclass">
                <input type="radio" name="opt"  class="ob" value="2"> Online and offline
                </label>
                   <?php } ?>
             
            </div> 
				</div>
			
            </div>

            <div class="col-sm-12 usher_events">
				<div class="row">
					<div class="col-sm-3"><label><b>Add usher email address</b></label></div>
					<div class="col-sm-4" id="hidden_vals" ><input type="text" class="form-control search_events" name="email" id="email" required/><div class="err_email" style="color:red;" autocomplete=false><?php if($this->session->flashdata('email'))
			 {
				 echo $this->session->flashdata('email');
			 }?></div></div>
					<div class="col-sm-3"><input class="submit_btn usher_save" type="button" value="Add"/></div>
				</div>
			</div>   
             	
          </form>     
          <?php if($this->session->flashdata('message')): ?>
            <div class="row">
             <div class="col-md-6 respose_style" style="color:green;"></div>
           </div>			
         <?php endif; ?> 
         <div class="row" style="margin-bottom:0px;">

         </div>

         <div class="row">

          <div class="col-md-12">

            <div class="table-responsive">

              <table class="table table-bordered tbl_usher">

                <thead>

                  <tr>

                    <th>ID</th>

                    <th>Event Name</th> 

                    <th>Sub Event Name</th> 

                    <th>First Name</th>

                    <th>Last Name</th>

                    <th>Email</th>
                   
                    <th>Event status</th>

                    <th>Action</th>

                  </tr>

                </thead>

                <tbody class="tab_magic">
                  <?php if($this->session->flashdata('message')):
                  $data=$this->session->flashdata('message');
                 
                 foreach($data['usher_data'] as $dt){ 
                 if($dt['ticket_checking_method']==1){
                    $status_method="online";

                 }

                 if($dt['ticket_checking_method']==2){
                    $status_method="online and offline";

                 }
                  ?>

                 <tr class="<?php echo $dt['id']; ?>">
                 <td><?php echo $dt['id']; ?></td>
                 <td><?php echo $dt['title']; ?></td>
                 <td><?php echo $dt['schedule_title']; ?></td>
                 <td><?php echo $dt['first_name']; ?></td>
                 <td><?php echo $dt['last_name']; ?></td>
                 <td><?php echo $dt['email']; ?></td>
                 <td><?php echo $status_method; ?></td>
                 <td><a href="#" id="<?php echo $dt['id']; ?>" class="delete_user" >Delete</a></td>
                 
                 </tr>

              <?php  }

       
     ?>


   </div>

  <!-- <br class="clear"> -->
  




 <?php endif; ?>
                     

                




                </tbody>

              </table>

            </div>

          </div>

        </div>

        <div class="pag">
         <div class="col-md-12">
          <?php echo $this->pagination->create_links(); ?>
        </div>
      </div>
      </div>
      </div>


      <link href="<?php echo $this->config->item('admin_css_path');?>alertify.core.css" rel="stylesheet">
      <link href="<?php echo $this->config->item('admin_css_path');?>alertify.bootstrap.css" rel="stylesheet">
      <link href="<?php echo $this->config->item('admin_css_path');?>alertify.default.css" rel="stylesheet">
      <script src="<?php echo $this->config->item('admin_js_path');?>/alertify.min.js"></script>
     

 <script type="text/javascript">
 $(document).ready(function(){

  $('#email').keyup(function(){

   $('.err_email').text('');
  });
  
   $(".usher_save").click(function(e){

     var sbt=0;
     sub_id=$('#sub_event_id').val();
     email=$('#email').val();
     
     //alert(sub_id);
     //alert(email);
     if(sub_id == 0 && email == "")
     {
      sbt=1;
       $('.err_task').text('Please select sub event');
       $('.err_email').text('Email Id is Required');
       //$('.usher_save').prop('disabled',true)
     }
     if(sub_id !=0 && email == "")
     {
       sbt=1;
       //$('.err_task').text('Sub Task Not selected');
       $('.err_email').text('Email Id is Required');
       //$('.usher_save').prop('disabled',true)
     }
     
     if(sub_id == 0 && email != "")
     {
       sbt=1;
       $('.err_task').text('Please select a Sub Event');
       //$('.err_email').text('Email Id is Required');
       //$('.usher_save').prop('disabled',true)
     }

      if(sbt==0){
            var c = ress();
      }
     
       
   
     // alert(c);
     
   });  
          
  //$('.usher_save').prop('disabled',true)
         
       
     function ress() {
    // e.type is the type of event fired
            //alert('w');
      $('.err_email').text('');
          email=$('#email').val();
          sub_id=$('#sub_event_id').val();
          //alert(sub_id);

      if(sub_id == "")
      {
        counter_tix=1;
              $('.err_email').text('Please Select a Sub Event');
      }
      
    
          //e//ncode_email= encodeURIComponent(email);
        if(!$('#sub_event_id').val()){ 
           // alert('no sub event id');
          }
        $.ajax({
        type: "post",
        url: "<?php echo base_url(); ?>index.php/frontend/ushers/ajax_call_email",
        data: {'email': email,'sub_id':sub_id},
        cache: false,  
        success: function(status){
        //  alert(status);
        var sub_event=$('#sub_event_id').val();
        if(email!='')
        {
            if(status=='error')
            {  
             $('.err_email').text('Email address is not registered');
              counter_tix=1;
            }
            else if(status=='success'){
              $('#event_form').submit();
              counter_tix=0;
            }
            else if(status=='exists')
            {
             counter_tix=1;
                $('.err_email').text('Email address is already registered to this event');
            }
            else if(sub_event==0)
            {
               counter_tix=1;
               $('.err_email').text('Please Select a sub event');
               $('.err_task').text('');
            }
            else
            {
                $('#event_form').submit();
                $('.err_email').text('');
                counter_tix=0;
            }
        }
        else
        {
         $('.err_email').text('Please fill in the field');
         counter_tix=1;
        }    
           
        }
       }
      );

    
     }



    });
  

  
    </script>

        <script>
    $(document).ready(function(){
         
        
       
        $('#sub_event_id').change(function(){
      $('.err_email').text('');
      $('.err_task').text('');
         
     sub_event_id=$(this).val();

         if(sub_event_id==0)
     {
      document.getElementById("show_dat").style.display="none"; 
           $('.o').prop('checked',true)
         }
     else
     {
       $.ajax({
        type: "post",
        url: "<?php echo base_url(); ?>index.php/frontend/ushers/ajax_get_status/"+sub_event_id,
        cache: false,  
        success: function(status)
        { 
          //alert(status);
          if(status=="online")
          {
             $('.o').prop('checked',true)
          }
          else if(status=="both")
          {
            $('.ob').prop('checked',true)
          }
          else if(status=="default")
          {
            $('.ob').prop('checked',true)
          }
        }
      });
      
      
      $.ajax({
        type: "post",
        url: "<?php echo base_url(); ?>index.php/frontend/ushers/ajax_get_start_end_date/"+sub_event_id,
        cache: false,
        success: function(data)
        {
          if(data == "")
          {
            $('.o').prop('checked',true)
            
            document.getElementById("startdate").value = "";
            document.getElementById("enddate").value = ""; 
          }
          else
          {
            document.getElementById("show_dat").style.display=""; 
            var ne = data.split("*");
            document.getElementById("startdate").innerHTML = ne[0];
            document.getElementById("enddate").innerHTML = ne[1];
            document.getElementById("starttime").innerHTML = ne[2];
            document.getElementById("endtime").innerHTML = ne[3];
            $('.emty_bxes').remove();
            $('#hidden_vals').append('<input type="hidden" class="emty_bxes" name="start_date" value="'+ne[0]+'" /><input class="emty_bxes" type="hidden" name="end_date" value="'+ne[1]+'" /><input class="emty_bxes" type="hidden" name="start_time" value="'+ne[2]+'" /><input class="emty_bxes" type="hidden" name="end_time" value="'+ne[3]+'" />');

          }
        }
      });
      
      
    }
    


        
        $.ajax({
        type: "post",
        url: "<?php echo base_url(); ?>index.php/frontend/ushers/ajax_subevent_ushers/"+sub_event_id,
        cache: false,  
        success: function(data){
      
      //alert(data)
            $(".tab_magic").empty();
            var obj = jQuery.parseJSON(data);
            $.each(obj, function(key,value) {
            var val=value.title;
            if(value.ticket_checking_method==2){
               $status_method="online and offline";
            }
            
            if(value.ticket_checking_method==1){
               $status_method="online";
            }

            $('.tab_magic').append('<tr class="'+value.id+'"><td>'+value.id+'</td><td>'+value.title+'</td><td>'+value.schedule_title+'</td><td>'+value.first_name+'</td><td>'+value.last_name+'</td><td>'+value.email+'</td><td>'+$status_method+'</td><td><a href="#" id="'+value.id+'" class="delete_user" >Delete</a></td>');
                
           }
           );
           

        }
       }
      );









email=$('#email').val();

if(email!='' && sub_event_id!=''){

 $.ajax({
        type: "post",
        url: "<?php echo base_url(); ?>index.php/frontend/ushers/ajax_call_email",
        data: {'email': email,'sub_id':sub_event_id},
        cache: false,  
        success: function(status){
         var sub_event=$('#sub_event_id').val();
            if(email!=''){
                if(status=='error'){  
                 $('.err_email').text('Email address is not registered');
                 //$('.usher_save').prop('disabled',true)
              
                 }
                else if(status=='exists'){
                  //$('.usher_save').prop('disabled',true)
                  $('.err_email').text('Email address is already registered to this event');
                 }
                 else if(sub_event==''){
                  $('.usher_save').prop('disabled',true)
                 }
                 else{
                  $('.err_email').text('');
                  //$('.usher_save').prop('disabled',false)
                 }
            }
            else{
                 $('.err_email').text('Please fill in the field');
                 //$('.usher_save').prop('disabled',true)
            }    
           

        }
       }
      );


}
  







        });


        

     

    });
    </script>




    <script>
    $(document).ready(function(){
        
        $("input:radio").on("change", function(){
         var status= $(this).val();
         var sub_event_id= $('#sub_event_id').val();

         if(sub_event_id!=''){
        $.ajax({
        type: "post",
        url: "<?php echo base_url(); ?>index.php/frontend/ushers/ajax_change_status/"+sub_event_id+"/"+status,
        cache: false,  
        success: function(status){ 
            
           

        }
       }
      );
         }

        });

    });
    </script>