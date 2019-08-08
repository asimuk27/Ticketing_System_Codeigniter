<link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-1.10.2.js">
</script>
<script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js">
</script>

<style>
  .error{
    color:red;
    font-weight: bold;
    text-align: center;
  }
</style>
<script>
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

     //Check if the fields are empty
      
      $('#event_form').submit(function(){
           

           var get_cities=$('#event_cities').val();
           var get_names=$('#event_names').val();
           var get_cat=$('#event_category').val();
            

           if(get_names=='' && get_cities=='' && get_cat=='')
           {
              $('.error').text('All The Fields Are Empty, Please Enter Atleast One');
              return false;
           }

      });
    



  }
                   );
</script>
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
          <h2>Manage Events
          </h2>
        </div>
        <div class="col-md-6 col-sm-6">
          <ul>
            <li>
              <a href="#">
                <i class="fa fa-home">
                </i>Home
              </a>
            </li>
            <li>
              <a href="#">
                <i class="fa fa-angle-right">
                </i>Manage Events
              </a>
            </li>
          </ul>
        </div>
      </div>
      <!--ROW END-->
    </div>
  </div>
  <!--Kode-our-speaker-heading End-->
  <div class="kode-blog-style-2">
    <div class="container">
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

      <div class="row">
        <div class="col-lg-12">
          <form  method="post" action="<?php echo base_url(); ?>index.php/frontend/events/manage_events" id="event_form">
            <div class="col-sm-1 col-sm-1">
				<label for="event_list" class="space_right" style="padding:10px 0px;">Search</label>
			</div>
			<div class="col-sm-3">
              <select class="form-control dropdown" id="event_category" name="e_category">
                <option value="">--Category--
                </option>
                <?php foreach($category_list as $cat){ ?>
                <option <?php if($category == $cat->id){ echo "selected";}?> value="<?php echo $cat->id; ?>">
                  <?php echo $cat->category_name; ?>
                </option>
                <?php } ?>
              </select>
            </div>
            <div class="col-sm-3">
              <input type="text" class="" placeholder="Search by event name" id="event_names" name="e_name" value="<?php if(isset($_POST['e_name'])){echo $_POST['e_name'];}else{ echo '';} ?>"/>
            </div>
            <div class="col-sm-3">
              <input type="text" class="" placeholder="Search by city" id="event_cities" name="e_city" value="<?php if(isset($_POST['e_city'])){echo $_POST['e_city'];}else{ echo '';} ?>"/>
            </div>
            <div class="col-sm-2">
              <button class="blue_box_title" type="submit" style="padding: 9px 29px;">Search
              </button>
            </div>
          </form>
        </div>
        <div class="col-sm-9 error"></div>
      </div>
      <div class="row">
        <div class="col-md-12 tabbing_box_attach">
          <ul class="nav nav-tabs">
            <li class="active">
              <a class="active" data-toggle="tab" href="#publish" >Live
              </a>
            </li>
            <li>
              <a data-toggle="tab" href="#saved" >Pending
              </a>
            </li>
            <li>
              <a data-toggle="tab" href="#past">Past
              </a>
            </li>
          </ul>
        </div>
        <div class=" manage_event_tab tab-content">
          <div id="publish" class="tab-pane fade in active">
            <div class="col-md-12 tab_border_div">
              <?php foreach($data as $get_value){
if($get_value['status']==1){
?>
             <div class="gray_desc_box">
                <div class="row">
                  <div class="col-md-6 col-sm-6">
                    <div class="row">
                      <div class="col-md-12">
                        <img style="width:400px;height:200px;" src="<?php echo base_url();?>assets/image_uploads/event_image/<?php echo $get_value['original_event_image']; ?>" alt=""/>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-6">
                    <h5>
                      <?php echo $get_value['title']; ?>
                    </h5>
                    <p class="paragraph text-left text-primary" style="margin-top:5px">
                      <?php echo "Location : ".$get_value['event_location']; ?>
                    </p>
                   
                    <p class="paragraph text-left">Created On : 
                      <?php echo  $get_value['created_date']; ?>
                    </p>
                    <div class="row">
                      <div class="col-md-3 col-sm-4 col-xs-6">
                        <a href="<?php echo $this->config->item('fe_view_event').'/'.$get_value['id']; ?>" class="three_inline_buttons">View
                        </a>
                      </div>
                      
                    </div>
                  </div>
                </div>
              </div>
              <br class="clear">
              <?php } 
}
?>
              <br class="clear">
            </div>
          </div>
          <div id="saved" class="tab-pane fade in">
            <div class="col-md-12 tab_border_div">
              <?php foreach($data as $get_value){
if($get_value['status']==0){
?>
              <div class="gray_desc_box">
                <div class="row">
                  <div class="col-md-6 col-sm-6">
                    <div class="row">
                      <div class="col-md-12">
                        <img style="width:400px;height:200px;" src="<?php echo base_url();?>assets/image_uploads/event_image/<?php echo $get_value['original_event_image']; ?>" alt=""/>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-6">
                    <h5>
                      <?php echo $get_value['title']; ?>
                    </h5>
                    <p class="paragraph text-left text-primary" style="margin-top:5px">
                      <?php echo "Location : ".$get_value['event_location']; ?>
                    </p>
                   
                    <p class="paragraph text-left">Created On : 
                      <?php echo  $get_value['created_date']; ?>
                    </p>
                    <div class="row">
                      <div class="col-md-3 col-sm-4 col-xs-6">
                        <a href="<?php echo $this->config->item('fe_view_event').'/'.$get_value['id']; ?>" class="three_inline_buttons">View
                        </a>
                      </div>
                      
                    </div>
                  </div>
                </div>
              </div>
              <br class="clear">
              <?php } 
}
?>
              <br class="clear">
            </div>
          </div>
          <div id="past" class="tab-pane fade in">
            
          </div>
        </div>
      </div>
      <br class="clear">
      <br class="clear">
    </div>
    <!--Container-->
  </div>
</div>
<!--Content-->

