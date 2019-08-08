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
  .special_class{ 
    color: #fff;
    background-color: #286090;
    border-color: #204d74;
    margin-right:10px;
  }
  .white_box_content{padding:10px;}
</style>

  <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="right_first_box"><img src="<?php echo $this->config->item('admin_image_path');?>home.png"><a href="#">Home</a> > <a href="#">Manage Donations</a></div>
                    </div>
                </div>	

                             <div class="row">
                       <div class="col-lg-12 col-md-12">
                       <div class="white_box_two">
                            <div class="blue_top">
                            	Search Donation
                            <?php	?>
                            </div>
                            <div class="white_box_content">
                                           <form class="form-horizontal" role="form" method="post" name="user_list_form" id="user_list_form">
                              <div class="box-body">
                  <div class="form-group">
                    <label for="searchby_org_id" class="col-sm-2 control-label">Charity Name</label>
                    <div class="col-md-3">
                      <select class="space_right form-control" id="searchby_org_id" name="searchby_org_id" >
                        <option value="">-- ALL --</option>
                        <?php foreach($organisers_list as $data2){ ?>
                        <option value="<?php echo $data2['organization_id'];?>"><?php echo $data2['charity_name'];?></option>
                        <?php } ?>                  
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="searchby_event_id" class="col-sm-2 control-label">Event Name</label>
                    <div class="col-md-3">
                      <select class="space_right form-control" id="searchby_event_id" name="searchby_event_id" >
                        <option value="">-- ALL --</option>
                      </select>
                    </div>
                    
                    <label for="searchby_sub_event_id" class="col-sm-2 control-label">Sub Event Name</label>
                    <div class="col-md-3">
                        <select class="space_right form-control" id="searchby_sub_event_id" name="searchby_sub_event_id" >
                          <option value="">-- ALL --</option>
                      </select>
                    </div>                    
                  </div>                  
                  <div class="form-group">
                    <label for="from_date" class="col-sm-2 control-label">From Date</label>
                    <div class="col-md-3">
                      <input type="" name="from_date" id="from_date" class="space_right form-control" <?php if(isset($_POST) && !empty($_POST['from_date'])){
                      echo 'value="'.$_POST['from_date'].'"';}else{ echo ""; } ?> readonly>
                      </div>
                     
                      <label for="to_date" class="col-sm-2 control-label">To Date</label>
                    <div class="col-md-3">
                       <input type="" name="to_date" id="to_date" class="space_right form-control" <?php if(isset($_POST) && !empty($_POST['to_date'])){
                       echo 'value="'.$_POST['to_date'].'"';}else{ echo ""; } ?> readonly>
                      </div>  
                  </div>
                  <div class="form-group">
                    <label for="payment_type" class="col-sm-2 control-label">Payment</label>
                                      <div class="col-md-3">
                    <select class="space_right form-control" id="payment_type" name="payment_type" >
                    <option value="">-- ALL --</option>
                    <option <?php if(isset($_POST) && !empty($_POST['payment_type']) && $_POST['payment_type']=='dps'){
                      echo 'value="dps" selected';}else{ echo 'value="dps"'; } ?>>DPS</option>                  
                    <option <?php if(isset($_POST) && !empty($_POST['payment_type']) && $_POST['payment_type']=='poli'){
                      echo 'value="poli" selected' ;}else{ echo 'value="poli"'; } ?>>POLi</option>                
                   </select>

                    

                   </div>

                   <label for="payment_type" class="col-sm-2 control-label">Status</label>

                      <div class="col-md-3">
                       <select class="space_right form-control" id="status" name="status" >
                    <option value="">-- ALL --</option>
                    <option <?php if(isset($_POST) && !empty($_POST['status']) && $_POST['status']=='1'){
                      echo 'value="1" selected';}else{ echo 'value="1"'; } ?>>successful</option>                 
                    <option <?php if(isset($_POST) && !empty($_POST['status']) && $_POST['status']=='2'){
                      echo 'value="2" selected';}else{ echo 'value="2"'; } ?>>unsuccessful</option>                 
                   </select>
                   

                    

                   </div>
                  </div>
                </div>
                
                <div class="form-group">
                  <div class="col-sm-offset-2 col-md-10">
                    <button id="seach_rec"type="submit" class="btn special_class">Search</button>
                    <button  id="export_to_csv" onclick = "get_csv();" id="download" class="btn special_class" type="button" style="">Export To CSV</button>
					
					<a  class="btn special_class" href="<?php echo $this->config->item("base_url");?>backend/donation_reports/refresh_listing">Reset</a>
					
                  </div>
                </div>        
               </form>
                                </div>
                            </div> 
                       </div>
                    </div>
			   
                <div class="row margin_top">
                   <div class="col-md-12">
                   <div class="blue_top">Donation Listing</div>
				   
				    
					  <?php if($this->session->flashdata('message') != ''){ ?>
							<div class="row" style="margin-bottom:5px;">								
								<div class="col-md-9" style="color:green;margin-top:10px;">
						<?php echo $this->session->flashdata('message');  ?>
								</div>
							</div>	
						<?php } ?>
						
                   <div class="table-responsive table_white_box">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>Event Name</th>
								<th>Sub Event Name</th>
								<th>Donation From</th>									
								<th>Donation To</th>						
								<th>Amount</th>
								<th>Donation Date</th>
								<th>Action</th>
							</tr>
						</thead>
                        <tbody>
							<?php 
						foreach($data as $user_data){ ?>
							<tr>
								<td><?php echo $user_data['event_name'];?></td>
								<td><?php echo $user_data['sub_event_name'];?></td>
								<td><?php echo $user_data['first_name'];?></td>	
								<td><?php echo $user_data['title'];?></td>	
								<td><?php echo number_format($user_data['donation_amount'],2);?></td>
								<td><?php echo date("d-m-Y",strtotime($user_data['created_date']));?></td>
								
								<td>
									<a href="<?php echo $this->config->item("base_url");?>backend/donation_reports/view_details_donation/<?php echo $user_data['main_id'];?>">View</a>
								</td>
							</tr>   
							<?php } ?>
							
							<?php if(empty($data)){ ?>
								<tr>
									<td colspan="7">No Records Found</td>
								</tr>
							<?php } ?>
                        </tbody>
                     </table>
                     </div>
                   </div>
                   </div>
				   <div class="row">
                   <div class="col-md-12">
						<?php echo $this->pagination->create_links(); ?>
                   </div>
                   </div>
                   </div>
                   </div>     
               </div>

               <script>
   $('#searchby_org_id').on('change',function(){
   $('#searchby_event_id option').remove();
   $('#searchby_sub_event_id option').remove();
  var charity_id=$(this).val();

      $.ajax({
        type: "post",
        url: "<?php echo base_url(); ?>index.php/backend/donation_reports/get_charity_events/"+charity_id,
        cache: false,
        success: function(json){
             $('#searchby_event_id').append("<option value=''>-- ALL --</option>");
              var obj = jQuery.parseJSON(json);
              $.each(obj, function(key,value) {
                  $('#searchby_event_id').append("<option value="+value.id+">"+value.title+"</option>");
           
           }
           );

        }
       }
      );
    });


  $('#searchby_event_id').on('change',function(){
     $('#searchby_sub_event_id option').remove();
     
  var event_id=$(this).val();

      $.ajax({
        type: "post",
        url: "<?php echo base_url(); ?>index.php/backend/donation_reports/get_sub_events/"+event_id,
        cache: false,
        success: function(json){
              
              var obj = jQuery.parseJSON(json);
              $('#searchby_sub_event_id').append("<option value=''>-- ALL --</option>");
              $.each(obj, function(key,value) {
                  $('#searchby_sub_event_id').append("<option value="+value.id+">"+value.schedule_title+"</option>");
           
           }
           );

        }
       }
      );
    });
</script>

<?php if($_POST){ ?>
<script>
   $(document).ready(function(){
        var get_organisation_id="<?php echo $_POST['searchby_org_id']; ?>";
        var get_event_id="<?php echo $_POST['searchby_event_id']; ?>";
        var get_sub_event_id="<?php echo $_POST['searchby_sub_event_id']; ?>";
       
        
        $.ajax({
        type: "post",
        url: "<?php echo base_url(); ?>index.php/backend/donation_reports/get_charity_events/"+get_organisation_id,
        cache: false,
        success: function(json){
               $('#searchby_event_id option').remove();
               $('#searchby_sub_event_id option').remove();
              var obj = jQuery.parseJSON(json);
              $('#searchby_event_id').append("<option value=''>-- ALL --</option>");
              $.each(obj, function(key,value) {
              	   if(value.id==get_event_id){
                     selected="selected";
              	   }else{
                     selected="";
              	   }
                  $('#searchby_event_id').append("<option value="+value.id+" "+selected+">"+value.title+"</option>");
           
           }
           );

        }
       }
      );


        //for sub events
         $.ajax({
        type: "post",
        url: "<?php echo base_url(); ?>index.php/backend/donation_reports/get_sub_events/"+get_event_id,
        cache: false,
        success: function(json){
              $('#searchby_sub_event_id option').remove();
              var obj = jQuery.parseJSON(json);
                $('#searchby_sub_event_id').append("<option value=''>-- ALL --</option>");
              $.each(obj, function(key,value) {
              	 if(value.id==get_sub_event_id){
              	 	
                     selected="selected";
              	   }else{
                     selected="";
              	   }
                  $('#searchby_sub_event_id').append("<option value="+value.id+" "+selected+">"+value.schedule_title+"</option>");
           
           }
           );

        }
       }
      );
       
       //selection for organiser
      $("#searchby_org_id > option").each(function() {
          if(this.value==get_organisation_id){
              $(this).attr("selected","selected");
          }
       });   

   });
</script>

<?php } ?>
<link rel="stylesheet" href="<?php echo $this->config->item('frontend_css_path');?>fullcalendar.css">
<script src="<?php echo $this->config->item('frontend_js_path');?>moment.min.js"></script>
<script src="<?php echo $this->config->item('frontend_js_path');?>fullcalendar.min.js"></script>
<link href="<?php echo $this->config->item('frontend_css_path');?>jquery-ui.css" rel="stylesheet">
<script src="<?php echo $this->config->item('frontend_js_path');?>jquery-ui.min.js"></script>
<script>

 $(document).ready(function(){
    
   $("#from_date").datepicker({
	  changeMonth: true,
      changeYear: true,
	  dateFormat: 'dd-mm-yy',
	  //yearRange: "+0:+100",
     // minDate: 1,
	  onSelect: function(selected) {
	  	$("#to_date").datepicker("option","minDate", selected);
		$('#from_date').css({"border": "1px solid rgb(185, 193, 204)"});
	  }
    });
	
	$("#to_date").datepicker({
	  changeMonth: true,
      changeYear: true,
	  dateFormat: 'dd-mm-yy',
	 // yearRange: "+0:+100",
     // minDate: 1,	
	  onSelect: function(selected) {	

		$('#to_date').css({"border": "1px solid rgb(185, 193, 204)"});
	  }
    });	

 });
</script>

<script>
$(document).ready(function(){
        $('#export_to_csv').click(function(){
      $('form').attr('action','<?php echo base_url(); ?>index.php/backend/donation_reports/export_csv');
      $('form').submit();
    });

    $('#seach_rec').click(function(){
      $('form').attr('action','');
      $('form').submit();
    });
  });
</script>

<?php if($_POST){ ?>
   <script>
      $(document).ready(function(){
            var fromdate="<?php echo $_POST['from_date']; ?>";

            if(fromdate!=''){
                  $("#to_date").datepicker("option","minDate", fromdate);
            }
      });
   </script> 
<?php } ?>

















