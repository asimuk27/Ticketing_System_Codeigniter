<link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
<!--<script src="https://code.jquery.com/jquery-1.10.2.js"></script>-->
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
	.label_status{font-weight:normal;color:lightgrey;}
	.blue_box_title{margin-bottom:15px !important;}
</style>
<script>
	function page_count_check(){
		 document.getElementById("event_form").submit();
	}

  $(document).ready(function(){
    var events_names=[];
    var events_city=[];
    $.ajax({
      type: "post",
      url: "<?php echo base_url(); ?>index.php/frontend/events/ajax_event_names",
      cache: false,  
      success: function(json){
        var obj = jQuery.parseJSON(json);
        $.each(obj, function(key,value) {
          var val=value.title;
          if(jQuery.inArray(val, events_names) !== -1)
          {
          }
          else
          {
            events_names.push(value.title);
          //  alert(events_names);
          }
        }
		);
      }
      ,
      error: function(){
        alert('Error while request..');
      }
    }
    );
        
	$.ajax({

      type: "post",

      url: "<?php echo base_url(); ?>index.php/frontend/events/ajax_event_city_names",

      cache: false,  

      success: function(json){

        var obj = jQuery.parseJSON(json);

        $.each(obj, function(key,value) {

          var val=value.event_location;

          if(jQuery.inArray(val, events_city) !== -1)

          {

          }

          else

          {

            events_city.push(value.event_location);

            

          }

        }

              );

      }

      ,

      error: function(){

        alert('Error while request..');

      }

    }

          );







    $( "#event_names" ).autocomplete({

      source:events_names

    }

    );



    $( "#event_cities" ).autocomplete({
      source:events_city
    }
    );
  

  }

                   );

</script>

 <?php if((isset($_POST['e_name'])) && (isset($_POST['e_city'])) && (isset($_POST['e_category'])) ){

                           $name=$_POST['e_name'];

                           $city=$_POST['e_city'];

                           $category=$_POST['e_category'];

                         }

                         else

                         {

                           $name='';

                           $city='';

                           $category='';

                         }

                      ?>

     <!-- <h4>Manage Events</h4> -->

<link href="<?php echo $this->config->item('admin_css_path');?>alertify.core.css" rel="stylesheet">

<link href="<?php echo $this->config->item('admin_css_path');?>alertify.bootstrap.css" rel="stylesheet">

<link href="<?php echo $this->config->item('admin_css_path');?>alertify.default.css" rel="stylesheet">

<script src="<?php echo $this->config->item('admin_js_path');?>/alertify.min.js"></script>

<script>

  $(".nav-tabs").tabs({
        select: function(event, ui) {  
            window.location.hash = ui.tab.hash;
        }
    });

  
  function confirmAction(status,a_element, message, action){    

    alertify.confirm(message, function(e) {

      if (e) {

        // a_element is the <a> tag that was clicked

        if (action) {

          action(status,a_element);

        }

      }

    });

  } 

  

  function changeStatus(status,result){   

    $.ajax({

      type: "POST",

      dataType: 'json',

      url: '<?php echo $this->config->item('update_fundraising_status');?>',

      data: "champion_id="+result+"&status="+status,

      success: function(Rid1) {

        if (Rid1) {

          location.reload();

          alertify.success("status updated successfully");

        }else{          

          alertify.error("error in updating status");

        }

      }

    }); 

  }

      

  function reset(){

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

</script>

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

            <h2>Manage Events</h2>

          </div>
        </div>
        <!--ROW END-->
      </div>
    </div>
    <!--Kode-our-speaker-heading End-->
    <div class="kode-blog-style-2 search_table">
      <div class="container">
            <div class="row" style="margin-bottom:0px;">
          <form  method="post" action="<?php echo base_url(); ?>index.php/frontend/events/manage_events" id="event_form">

      <div class="col-sm-2">

              <select class="form-control dropdown" id="event_category" name="e_category">

                <option value="">-- All Categories --</option>

                <?php foreach($category_list as $cat){ ?>

                <option <?php if($category == $cat->id){ echo "selected";}?> value="<?php echo $cat->id; ?>">

                  <?php echo $cat->category_name; ?>

                </option>

                <?php } ?>

              </select>

            </div>

            <div class="col-sm-3">

              <input type="text" class="form-control" placeholder="Event Name" id="event_names" name="e_name" value="<?php if(isset($_POST['e_name'])){echo $_POST['e_name'];}else{ echo '';} ?>"/>

            </div>

            <div class="col-sm-2">

              <input type="text" class="form-control" placeholder="Event Location" id="event_cities" name="e_city" value="<?php if(isset($_POST['e_city'])){echo $_POST['e_city'];}else{ echo '';} ?>"/>

            </div>

			<div class="col-sm-2">
              <select class="form-control dropdown" id="event_status" name="event_status">
                <option value="">-- All --</option>
				<option value="1" <?php if(isset($_POST['event_status']) && ($_POST['event_status'] == 1)){echo "selected";} ?>>Published</option>
				<option value="2" <?php if(isset($_POST['event_status']) && ($_POST['event_status'] == 2)){echo "selected";} ?>>UnPublished</option>
				<option value="3" <?php if(isset($_POST['event_status']) && ($_POST['event_status'] == 3)){echo "selected";} ?>>Suspended</option>
				<option value="4" <?php if(isset($_POST['event_status']) && ($_POST['event_status'] == 4)){echo "selected";} ?>>Closed</option>
				<option value="5" <?php if(isset($_POST['event_status']) && ($_POST['event_status'] == 5)){echo "selected";} ?>>Cancelled</option>
              </select>

            </div>
			
            <div class="col-sm-3">
				<button class="blue_box_title" type="submit" style="padding: 9px 29px;margin-right:15px;">Search</button>
				<button class="blue_box_title" type="reset" style="padding: 9px 29px;" onclick="fr_fresh();">Reset</button>
            </div>

         


        <div class="col-sm-9 error"></div>

      </div>             

	  <div class="row" style="margin-bottom:0px;">
		<div class="col-sm-1">
			<label style="padding:10px;">Records</label>
		</div>
		<div class="col-sm-1">				
			<select class="form-control dropdown" id="per_page" name="per_page" onchange="page_count_check();">
				<option value="5" <?php if($page_count  == '5'){ echo " selected";}else{ echo "";}?>>5</option>
				<option value="10" <?php if($page_count  == '10'){ echo " selected";}else{ echo "";}?>>10</option>
				<option value="20" <?php if($page_count  == '20'){ echo " selected";}else{ echo "";}?>>20</option>
				<option value="30" <?php if($page_count  == '30'){ echo " selected";}else{ echo "";}?>>30</option>
				<option value="40" <?php if($page_count  == '40'){ echo " selected";}else{ echo "";}?>>40</option>
				<option value="50" <?php if($page_count  == '50'){ echo " selected";}else{ echo "";}?>>50</option>
			</select>
		</div>
       </div>
           </form>     
			<?php if($this->session->flashdata('message')): ?>
				<div class="row">
					<div class="col-md-6 respose_style" style="color:green;"><?php echo $this->session->flashdata('message'); ?></div>
				</div>			
			<?php endif; ?> 
		   <div class="row" style="margin-bottom:0px;"></div>
                <div class="row">
                <div class="col-md-12">
                <div class="table-responsive">
                <table class="table table-bordered">
                <thead>
                <tr>
					<th>ID</th>
					<th>Event Name</th> 
					<th>Location</th> 
					<th>Start Date</th>
					<th>End Date</th>
					<th>Status</th>
					<th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
				if(count($data) > 0){
					$i = 0;
				foreach($data as $get_value){					
					if($i % 2 == 0) {	$class = "even"; }else{	$class="odd"; }
				?>
                <tr class="<?php echo $class;?>">
					<?php   $start_date =date("F jS, Y", strtotime($get_value['event_start_date']));
					$end_date =  date("F jS, Y", strtotime($get_value['event_end_date']));
					?>
				  <td><?php echo $get_value['event_id']; ?></td>
				  <td><?php echo substr($get_value['event_main_tile'], 0, 30); ?></td>
				  <td><?php echo substr($get_value['event_location'], 0, 30); ?></td>
				  <td><?php echo date("d-m-Y", strtotime($start_date));?></td>
				  <td><?php echo date("d-m-Y", strtotime($end_date));?></td>
				 <td><?php 
						if($get_value['event_status']==1){
							echo "published";
						}else if($get_value['event_status']==2){
							echo "unpublished";
						}else if($get_value['event_status']==3){
							echo "suspended";
						}else if($get_value['event_status']==4){
							echo "closed";
						}else if($get_value['event_status']==5){
							echo "cancelled";
						}
					?>
					</td>
				  <td>
						<a target="_blank" href="<?php echo base_url(); ?>frontend/events/event_details/<?php echo $get_value['event_id']; ?>">View</a> 
						| 
						<?php if($get_value['event_status'] != 4 && $get_value['event_status'] != 5){ ?>
							<a href="<?php echo base_url(); ?>frontend/events/edit_event/<?php echo $get_value['event_id']; ?>">Edit</a> 
						<?php }else{ ?>
							<label class="label_status" title="this event is closed">Edit</label> 
						<?php }?>
											
						<?php if($get_value['event_status'] == 1){ ?>
							| <a href="javascript:void(0)" onclick="confirmAction(<?php echo $get_value['event_id'];?>, 'Are you sure you want to suspend this event?', suspend_event); return false;">Suspend</a>
							| <a href="javascript:void(0)"  onclick="confirmAction(<?php echo $get_value['event_id'];?>, 'Are you sure you want to cancel this event?', cancel_event); return false;">Cancel</a>
							|
							<a target="_blank" href="<?php echo base_url(); ?>frontend/ushers/add_usher/<?php echo $get_value['event_id']; ?>">Usher</a>
						<?php } ?> 
						
						<?php if($get_value['event_status'] == 2){ ?>
							| <label class="label_status" title="only published event can be suspended">Suspend</label> 
							| <label class="label_status" title="only published event can be cancelled">Cancel</label> 
							| <label class="label_status">Usher</label>	
						<?php } ?> 
						
						<?php if($get_value['event_status'] == 3){ ?>
							| <a href="javascript:void(0)" onclick="confirmAction(<?php echo $get_value['event_id'];?>, 'Are you sure you want to activate this event?', activate_event); return false;">Activate</a>
							| <label class="label_status" title="suspended event cannot be cancelled">Cancel</label>
							| <label class="label_status">Usher</label>
						<?php } ?>

						<?php if($get_value['event_status'] == 4){ ?>
							| <label class="label_status" title="this event is closed">Suspend</label> 
							| <label class="label_status" title="this event is closed">Cancel</label> 
							| <label class="label_status">Usher</label>
						<?php } ?> 
						
						<?php if($get_value['event_status'] == 5){ ?>
							| <label class="label_status" title="cancelled event cannot be suspended">Suspend</label> 
							| <a href="javascript:void(0)" onclick="confirmAction(<?php echo $get_value['event_id'];?>, 'Are you sure you want to restart this event?', restart_event); return false;">Restart</a> 
							| <label class="label_status">Usher</label>
						<?php } ?> 
						| <a href="<?php echo base_url(); ?>frontend/events/event_stats/<?php echo $get_value['event_id'];?>">Statistics</a>		
				  </td>
                </tr>
                <?php 
					$i++;
				}}else{ ?>
					<tr><td colspan="7"><?php echo "No events found";?></td></tr>
				<?php } ?>

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
          </div></div>

<script>
	function fr_fresh(){
		window.location = "<?php echo base_url();?>frontend/events/manage_events";		
	}
 
	function confirmAction(a_element, message, action){
		alertify.confirm(message, function(e) {
			if (e) {
				// a_element is the <a> tag that was clicked
				if (action) {
					action(a_element);
				}
			}
		});
	}	
				
	function reset(){
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
		
	function cancel_event(result){		
		$.ajax({
			type: "POST",
			dataType: 'json',
			url: "<?php echo $this->config->item('base_url');?>index.php/frontend/events/set_event_event_as_cancelled",
			data: "event_id="+result,
			success: function(Rid2) {
				if (Rid2) {
					location.reload();
					alertify.success("event marked as cancelled");
				}else{					
					alertify.error("error in updating status");
				}
			}
		}); 
	}	
	
	function restart_event(result){		
		$.ajax({
			type: "POST",
			dataType: 'json',
			url: "<?php echo $this->config->item('base_url');?>index.php/frontend/events/set_event_as_active",
			data: "event_id="+result,
			success: function(Rid2) {
				if (Rid2) {
					location.reload();
					alertify.success("event marked as published");
				}else{					
					alertify.error("error in updating status");
				}
			}
		}); 
	}
		
	function activate_event(result){		
		$.ajax({
			type: "POST",
			dataType: 'json',
			url: "<?php echo $this->config->item('base_url');?>index.php/frontend/events/set_event_as_active",
			data: "event_id="+result,
			success: function(Rid2) {
				if (Rid2) {
					location.reload();
					alertify.success("event marked as published");
				}else{					
					alertify.error("error in updating status");
				}
			}
		}); 
	}
	function suspend_event(result){			
		$.ajax({
			type: "POST",
			dataType: 'json',
			url: "<?php echo $this->config->item('base_url');?>index.php/frontend/events/set_event_as_in_active",
			data: "event_id="+result,
			success: function(Rid2) {
				if (Rid2) {
					location.reload();
					alertify.success("event is suspended");
				}else{					
					alertify.error("error in updating status");
				}
			}
		}); 
	}	
	
</script>

