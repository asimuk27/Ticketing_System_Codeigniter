<link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
<!--<script src="https://code.jquery.com/jquery-1.10.2.js"></script>-->
<script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<link rel="stylesheet" href="<?php echo $this->config->item('frontend_css_path');?>pages/book_event.css" type="text/css" media="all">
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
          <h2>Buy Ticket
          </h2>
        </div>
      </div>
      <!--ROW END-->
    </div>
  </div>
  <!--Kode-our-speaker-heading End-->
  <form action="<?php echo base_url(); ?>index.php/frontend/events/save_ticket_details" method="post" id="book_form">
    <input type="hidden" name="loop_counter" class='loop_counter' />
    <div class="kode-blog-style-2">
      <div class="container">
        <!--<h4>Automation & Robotics EXPO 2016</h4>-->              
        <div class="jumbotron add_event_jumbotron event_desc_jumbotron jumbo_padding">
          <h5 class="text-left">
            <?php echo $data[0]['schedule_title']; ?> Description
          </h5>
          <p class="search_events text-left">
            <?php echo $data[0]['schedule_event_description'];?>
            <?php   $start_date =date("F jS, Y", strtotime($data[0]['schedule_start_date']));
            $end_date =  date("F jS, Y", strtotime($data[0]['schedule_end_date']));
            ?>
          </p>
          <p class="search_events  text-left event_details">
            <strong>Location: 
            </strong>
            <?php echo $data[0]['schedule_location']; ?>
            <br/>
            <strong>Date & Time: 
            </strong> 
            <?php echo $start_date; ?> At 
            <?php echo $data[0]['schedule_start_time']; ?> -  
            <?php echo $end_date; ?> At 
            <?php echo $data[0]['schedule_end_time']; ?>
            <br/>
          </p>
        </div>
        <div class="search_events table_white_box table_special">
          <h5>Ticket Information
          </h5>
          <table class="table">
      <!--      <thead>
              <tr class="text-center">
                <th style='width: 300px;overflow:auto;'>Ticket Name</th>
                <th>Ticket Type</th>
                <th>Sale End Date</th>
                <th style="width:17%;">Price</th>
                <th style="width:20%;">Quantity</th>
              </tr>
            </thead>-->
            <tbody>
              <?php $ticket_counter=0; ?>
              <?php foreach($ticket_data as $tdata){ ?>
					
              <tr>
               <th style='width: 300px;overflow:auto;'>Ticket Name</th>
                <td style='width: 300px;overflow:auto;'>
                 <i class="fa fa-ticket" aria-hidden="true"></i>  <?php echo $tdata['ticket_name'];?>
                </td>
                </tr>
                
                
                <tr>
                <th>Ticket Type</th>
                <?php if($tdata['ticket_type_id']==1){ ?>
                <td>Paid</td>
                <?php }else if($tdata['ticket_type_id']==2){ ?>
                <td>Free
                </td>
                <?php }else{ ?>
                <td>Donation
                </td>
                <?php } ?>
                </tr>
                
                 <tr>
                 <th>Sale End Date</th>
                <td>
					<?php 			
						$newdate = date("jS F, Y", strtotime ($tdata['sale_end_date'])) ;
						echo $newdate;
					?>
				</td>
                <?php if($tdata['ticket_type_id']!=3){ ?>
                <input type="hidden" value="<?php echo $tdata['id'];  ?>" name="ticket_id[]"/>
                <input type="hidden" value="<?php echo $tdata['ticket_name'];  ?>" name="ticket_name[]"/>
                <input type="hidden" value="<?php echo $tdata['price'];  ?>" name="ticket_price[]" id="tc_price"/>
                
                </tr>
                
                <tr>
                <th style="width:17%;">Price</th>
                <td>
                  <?php 
						if($tdata['price']){
							echo "<i class='fa fa-usd' aria-hidden='true'></i> ".number_format($tdata['price'],2);
						}else{
							echo "Free";
						}
					?>
                </td>
                </tr>
                
                <tr>
                 <th style="width:20%;">Quantity</th>
                <td >
             <?php if($tdata['out_of_stock'] == 0){ ?>
            <select class="form-control tic_qyt tic_three" name="qyt[]" id="<?php echo $tdata['id']; ?>">
              <option value='0'>0
              </option>
              <?php 
			  if($tdata['min_ticket_allowed']>$tdata['max_ticket_allowed']){
				  $max=$tdata['min_ticket_allowed'];
				  $min=$tdata['max_ticket_allowed'];
			  }
			  else{
				  $max=$tdata['max_ticket_allowed']; 
				  $min=$tdata['min_ticket_allowed'];;
			    }
              for($i=$min; $i<=$max; $i++)
              {
               echo "<option value='".$i."'>".$i."</option>";
              }

             ?>
           </select>
           <div class="err_in_qyt" style="color:red;"></div>
           <?php }else{
            echo "<input type='hidden' name='qyt[]' value='0' />";
            echo "Sold Out";
          } ?>
        </td>
                <?php }else{ ?>
                <input type="hidden" value="<?php echo $tdata['id'];  ?>" name="ticket_id[]"/>
                <input type="hidden" value="<?php echo $tdata['ticket_name'];  ?>" name="ticket_name[]"/>
                <input type="hidden" value="" id="tc_price" class="dm_amt" />
                <td>
                   <input type="text"  name="ticket_price[]" placeholder="$ amount" id="donations" class="tic_three donate <?php echo $tdata['id']; ?>" maxlength="4"/>
                   <span class='err_span' style='color:red;'></span>
               </td>
              
              

                 <td style="width:20%;">
             <?php if($tdata['out_of_stock'] == 0){ ?>
            <select class="form-control tic_qyt tic_three" name="qyt[]" id="<?php echo $tdata['id']; ?>">
              <option value='0'>0
              </option>
              <?php 
        if($tdata['min_ticket_allowed']>$tdata['max_ticket_allowed']){
          $max=$tdata['min_ticket_allowed'];
          $min=$tdata['max_ticket_allowed'];
        }
        else{
          $max=$tdata['max_ticket_allowed']; 
          $min=$tdata['min_ticket_allowed'];;
        }
              for($i=$min; $i<=$max; $i++)
              {
               echo "<option value='".$i."'>".$i."</option>";
              }

             ?>
           </select>
           <div class="err_in_qyt" style="color:red;"></div>
           <?php }else{
            echo "<input type='hidden' name='qyt[]' value='0' />";
            echo "Sold Out";
          } ?>
        </td>



              
                <?php } ?>
                <?php if($tdata['ticket_type_id']==3){ ?>
                <input type="hidden" value="3" id="verify_donations" />
                <?php }else{?>
                <input type="hidden" value="0" id="verify_tickets" />
                <?php } ?>
              </tr>
              <?php
              $ticket_counter++;
            } ?>
            <input type="hidden" name="ticket_counter" value="<?php echo $ticket_counter; ?>">
            <input type="hidden" name="sub_event_id" value="<?php echo $sub_event_id; ?>">
          </tbody>
        </table>
      </div>
	 <?php if(!empty($get_sponsors)){ ?> 
      <div class="table_white_box">
        <h5>Sponsors
        </h5>
        <div class="row">
         <?php  foreach ($get_sponsors as $sp) {
              ?>
              <div class="col-md-4 col-sm-4 col-xs-4">
                <?php if($sp['hyperlink']==''){ ?>
                <img src="<?php echo base_url(); ?>/assets/image_uploads/sponsor_image/<?php echo $sp['sponsor_image'];?>" class="img-responsive"  alt="" style="height:100px; margin:10px;border-bottom: 0 none;
                box-shadow: 0 1px 5px rgba(0, 0, 0, 0.46);">
                <?php }else{ ?>
               <!-- <a href="<?php echo $sp['hyperlink'];?>" target="_blank"> -->
				
				<a href="<?php echo preg_match('/https\:\/\//', $sp['hyperlink']) ? $sp['hyperlink'] : "https://" . $sp['hyperlink']; ?>" target="_blank">
				
                  <img src="<?php echo base_url(); ?>/assets/image_uploads/sponsor_image/<?php echo $sp['sponsor_image'];?>" class="img-responsive"  alt="" style="height:100px; margin:10px;border-bottom: 0 none;
                  box-shadow: 0 1px 5px rgba(0, 0, 0, 0.46);">
                </a>
                <?php } ?>
              </div>
              <?php }
            ?>
          </div>
        </div>
	 <?php } ?>
		
		
      <?php if(empty($champion_data) || $data[0]['is_support_allowed']==0){


    }else{?>
    <div class="table_white_box">
        <h5>Support a Champion</h5>
			<div class="row" style="margin:5px;">
				<div class="col-md-12">
					<?php if($data[0]['is_support_allowed']==0){?>
						<p class="search_events  text-left">
							Champions are not supported for this event
						</p>
					<?php }else if(empty($champion_data)){ ?>
					<p class="search_events  text-left">No Champions available for this event</p>
					<?php }else{ ?>
					<p class="search_events  text-left" style="margin-bottom:0px;">
						Supporting a Champion is important to this event. Please select a champion from the list to view their profile page
					</p>
					<?php } ?>
				</div>
			</div>
			<input type="hidden" name="champion_counter" id="champion_counter"/>
			<input type="hidden" name="clone_genrator" class="clone_genrator"/>
			<?php if(empty($champion_data) || $data[0]['is_support_allowed']==0){
			}else{ ?>
			<div id="add_supporter" class="row cln clone_main cln_hidden" style="margin:0px 30px 30px 30px;padding: 20px;border:1px solid #ddd;">
			<div class="col-md-6">
				<input class="form-control dropdown champion_select select_champs" name="champion_choose[]" placeholder="Type in champion name and select champion from the list" /> 
       
			</div>
       
			  <div class="col-md-2">
				<input type="text" id="name" name="champion_amt[]" placeholder="Amount" class="search_events champion_amount only_num">
        <span class="err_amt" style="color:red; font-weight:bold"></span>
			  </div>
  <div class="col-md-2">
    <a href=""  target="_blank" class="three_inline_buttons label_text_align_center view_champion" id="" style="text-align:center;">View
    </a>
  </div>
  <br class="clear">
  <div class="col-md-6">
    <textarea class="search_events form-control txt_field remove_extra_space" placeholder="Message to Champion" name="champion_msg[]">
    </textarea>
  </div>
</div>
<div class="col-sm-12 error_message" style="color:red; font-weight:bold; margin-left: 20px">
</div>
<div class="col-sm-12 last_champ_message" style="color:red; font-weight:bold; margin-bottom:20px; margin-left:15px">
</div>
<div class="row" style="margin: 0px 30px 30px;">
  <div class="col-md-3" style="padding-left: 0px;">
    <button class="three_inline_buttons add_more_champion" type="button">
      <i class="fa fa-plus" aria-hidden="true">
      </i> Add Champion
    </button>
  </div>
  <div class="col-md-3" style="padding-left: 0px;">
    <button class="three_inline_buttons remove_last_champion" type="button">
      <i class="fa fa-times" aria-hidden="true">
      </i> Remove Champion
    </button>
  </div>
</div>
<?php } ?>
</div>



<?php } ?>

<div class='err_both' style="color:red;font-weight:bold;clear:both;margin-bottom:10px;"></div>
<div class="row">
	<div class="col-md-6">
		<button class="blue_box_title space_right" id="order_nw">Order Now</button>
		<button class="blue_box_title" id="order_cancel" onclick="javascript:history.back();" type="button">Cancel</button>
	</div>
</div>
</div>
<!--Container-->
</div>
</form>
</div>
<!--Content-->
<script>
  var counter=1;
  var genrator=1;
  var champion_details=[];

  $(document).ready(function(){
    $('.cln_hidden').hide();
    $('.clone_genrator').val(genrator);
    $('.remove_last_champion').hide();

    $('.add_more_champion').click(function(){
      $('.error_message').text('');
      if(counter==1 || genrator==1)
      {
        $('.remove_last_champion').hide();
        $('div.cln:last').show();
        $('.last_champ_message').text('');

        $(".clone_main").last().clone().insertAfter("div.cln:last");
        $('div.cln:last').find('.champion_select').next().remove();
        $('div.cln:last').find(".err_amt").text("");
        $('div.cln:last').find(".err_champ").text("");
        var lastClass = $('div.cln:last').attr('class').split(' ').pop();
        $('div.cln:last').removeClass(lastClass);
        $('div.cln:last').find('.champion_select').attr('style','');
        $('div.cln:last').find('.champion_amount').attr('style','');
        if(genrator==1)
        {
          $('div.cln:first').find('.champion_select').addClass('select_champs');
          $('div.cln:first').find('.champion_amount').addClass('only_num');
        }
        else
        {
          $('div.cln:first').find('.champion_select').removeClass('select_champs');
          $('div.cln:first').find('.champion_amount').removeClass('only_num');
          var lastClass = $('div.cln:last').attr('class').split(' ').pop();
          $('div.cln:first').addClass(lastClass);
        }
        $('div.cln:first').hide();
        $('div.cln:last').find('.champion_amount,.champion_select,textarea').each(function () {
          $(this).val('');
        }
        );
        $('div.cln:last').find('.champion_select').attr('id', 'champ'+counter);
        $('div.cln:last').find('.view_champion').attr('id', 'viewchamp'+counter);
        $('div.cln:last').find('.view_champion').attr('href', 'javascript:void(0)');
        genrator++;
        $('.clone_genrator').val(genrator);
        counter++;
        $('#champion_counter').val(counter);
        if(genrator==1)
        {
          $('.remove_last_champion').hide();
        }
        else
        {
          $('.remove_last_champion').show();
        }
      }
      else
      {
        $('.error_message').text('');
        $('.last_champ_message').text('');
        
        $(".clone_main").last().clone().insertAfter("div.cln:last");
         $('div.cln:last').find(".err_amt").text("");
         $('div.cln:last').find(".err_champ").text("");
        $('div.cln:last').find('.champion_select').next().remove();
        $('div.cln:last').find('.champion_amount,.champion_select,textarea').each(function () {
          $(this).val('');
        }
        );
        $('div.cln:last').find('.champion_select').attr('style','');
        $('div.cln:last').find('.champion_amount').attr('style','');
        $('div.cln:last').find('.champion_select').attr('id', 'champ'+counter);
        $('div.cln:last').find('.view_champion').attr('id', 'viewchamp'+counter);
        $('div.cln:last').find('.view_champion').attr('href', 'javascript:void(0)');
        genrator++;
        $('.clone_genrator').val(genrator);
        counter++;
        $('#champion_counter').val(counter);
        if(genrator==1)
        {
          $('.remove_last_champion').hide();
        }
        else
        {
          $('.remove_last_champion').show();
        }
      }
    }
    );

  }
  );
  












       $(document).on("focus", ".select_champs", function () {
          $(".select_champs" ).autocomplete({
          
            source: champion_details,
            minLength: 1,
            select: function(event, ui) {
               event.preventDefault();
              $(this).val(ui.item.label);  //selecting by its id(value)
              $(this).next().remove();
              $(this).after("<input type='hidden' value='"+ui.item.value+"' name='champion_ids[]'  />");

              var get_id = ui.item.value;
              var new_id=this.id;
             // alert(get_id);
              var set_href="<?php echo base_url(); ?>index.php/frontend/champion/view_fundraising/"+ui.item.value;
              $('#view'+new_id).attr('href',set_href);


            },
             focus: function(event, ui) {
             event.preventDefault();
             $(this).val(ui.item.label);
            
            }

          }

           );


        });
 
    //removing support champions
    $(document).ready(function(){
      $.ajax({
        type: "post",
        url: "<?php echo base_url(); ?>index.php/frontend/events/ajax_get_champion_data",
        cache: false,  
        success: function(json){
         var obj = jQuery.parseJSON(json);
         $.each(obj, function(key,value) {
           var val=value.title;
            if(jQuery.inArray(val, champion_details) !== -1)
            {
            }
            else
             {
               var objPush = {};
               objPush.value = value.id;
               objPush.label = value.display_name+'//'+value.title;
               champion_details.push(objPush);
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


     







      $('.remove_last_champion').click(function(){
        $('.error_message').text('');
        if(genrator==1)
        {
          $('.remove_last_champion').hide();
        }
        else
        {
          $('div.cln:last').remove();
          $('.last_champ_message').text('');
          genrator--;
          $('.clone_genrator').val(genrator);
          counter--;
          $('#champion_counter').val(counter);
          if(genrator==1)
          {
            $('.remove_last_champion').hide();
            $('div.cln:first').find('.champion_select').addClass('select_champs');
            $('div.cln:first').find('.champion_amount').addClass('only_num');
            $('div.cln:first').find('.champion_amount').attr('name','champion_amt[]');
            $('div.cln:first').find('.champion_select').attr('name','champion_choose[]');
            $('div.cln:first').find('.champion_select').attr('name','champion_choose[]');
            $('div.cln:first').find('textarea').attr('name','champion_msg[]');
          }
          else
          {
            $('.remove_last_champion').show();
          }
        }
      }
      );
    }
    );
  </script>
  <!-- Script to allow only numbers-->
  <!-- Script for empty fields one by one-->
  <script>
    $(document).ready(function(){
      $("#book_form").submit(function(e){
       $('.err_both').text("");
      
       $('.err_span').each(function(i){
          $(this).text("");
       });

       if($(".donate")[0]){
           
           $('.donate').each(function(i){
            
            var get_donation_last_class=$(this).attr('class').split(' ').pop();
            var donation_qyt=parseInt($('#'+get_donation_last_class).val());
            var exact_donation=parseInt(donation_qyt);
            var get_donation_value=$(this).val();
            var newrejex = /^\d+$/;
            if(get_donation_value!='' && donation_qyt==0)
            {
              //$(this).attr("style","");
              $('#'+get_donation_last_class).attr("style","border-color:red");
              $('#'+get_donation_last_class).next(".err_in_qyt").text("Select Quantity");
              
              e.preventDefault(e);
            }
            if(!(newrejex.test(get_donation_value)) && get_donation_value!=''){
                 //$(this).attr("style","border-color:red");
                 $(this).css("border-color", "red");
                 $(this).next(".err_span").text("Enter valid amount");
                 e.preventDefault(e);
             
             }
             if(get_donation_value=='' && exact_donation>0){
             
             $(this).css("border-color", "red");
              $(this).next(".err_span").text("Enter donation");
              e.preventDefault(e);
             }

              if(get_donation_value==0 && exact_donation>0){
                 
                 $(this).css("border-color", "red");
                 $(this).next(".err_span").text("Invalid amount");
              
              e.preventDefault(e);
             }

             
             



           }
          );
       } else {
  
       }
       $(this).next(".err_span").text("");
         


        $('#donations').attr('style','');
        $('.error_donations').text('');
        $('div.cln:first').find('.champion_select').removeClass('select_champs');
        $('div.cln:first').find('.champion_amount').removeClass('only_num');
        $('div.cln:first').find('.champion_amount').attr('name','');
        $('div.cln:first').find('.champion_select').attr('name','');
        $('div.cln:first').find('textarea').attr('name','');
        var ticket_valid_counter=0;
        var temp_counter=0;
        $('.tic_three').each(function(i){

         temp_counter++;
         var ticket_val=$(this).val();

         if(ticket_val=='0' || ticket_val=='')
         {
          ticket_valid_counter++;
        }
        var get_last_donation=$(this).attr('class').split(' ').pop();
        if(get_last_donation=='donate')
        {
          if(ticket_val!='')
          {
            var intRegex = /^\d+$/
            if(!(intRegex.test(ticket_val))){
             // alert("Donation amount must be amount and not characters");
              $(this).attr('style','border-color:red');
              $('div.cln:first').find('.champion_select').addClass('select_champs');
              $('div.cln:first').find('.champion_amount').addClass('only_num');
              $('div.cln:first').find('.champion_amount').attr('name','champion_amt[]');
              $('div.cln:first').find('.champion_select').attr('name','champion_choose[]');
              $('div.cln:first').find('textarea').attr('name','champion_msg[]');
              $('.error_donations').text('');
              $('.error_donations').text('Donations should only have numbers');
              e.preventDefault(e);
              $('.donate_qyt').val('0');
            }
            else
            {
              if(ticket_val=='')
              {
                $('.donate_qyt').val('0');
              }
              else
              {
                $('.donate_qyt').val('1');
              }
                //alert(ticket_val);
              }
            }
            else
            {
              $('.donate_qyt').val('0');
            }
          }
        }
        );


        if(ticket_valid_counter==temp_counter)
        {
          if(genrator==1)
          {
           $('.err_both').text("No details provided, please fill in the details and order");
           $('div.cln:first').find('.champion_select').addClass('select_champs');
           $('div.cln:first').find('.champion_amount').addClass('only_num');
           $('div.cln:first').find('.champion_amount').attr('name','champion_amt[]');
           $('div.cln:first').find('.champion_select').attr('name','champion_choose[]');
           $('div.cln:first').find('textarea').attr('name','champion_msg[]');
           e.preventDefault(e);
          }
          else
          {
             $('.err_both').text("");
          }
         
        }

        var get_generator=$('.clone_genrator').val();
        var check_generator=parseInt(get_generator);
        //   alert(check_generator);
        if(check_generator==1)
        {
          $('.loop_counter').val(check_generator);
        }
        else
        {
          $('.select_champs').each(function(i){
            var champ_list=$(this).val();
            $(this).attr('style','');
          }
          );
          $('.only_num').each(function(i){
            $(this).attr('style','');
          }
          );
          $('.select_champs').each(function(i){
            var champ_list=$(this).val();
            if(champ_list=='')
            {
              $(this).next(".err_champ").text("");
              $(this).attr('style','border-color:red');
              $(this).after("<span class='err_champ' style='color:red; font-weight:bold'></span>");
              $(this).next(".err_champ").text("field is required");
              e.preventDefault(e);
            }
          }
          );
          $('.only_num').each(function(i){
             var amt=$(this).val();
             var value=$.trim($(this).val());
             $(this).attr('style','');
              $(this).next(".err_amt").text("");
            if(value === '' || value==0)
            {
              $(this).attr('style','border-color:red');
              $(this).next(".err_amt").text("field is required");
              e.preventDefault(e);
              
            }
            else
            {
              var intRegex = /^\d+$/;
             if(intRegex.test(amt)){
             }
             else
             {
              $(this).attr('style','border-color:red');
              $(this).next(".err_amt").text("characters not allowed");
              e.preventDefault(e);
             }
            }
            
          }
          );
          $('.loop_counter').val(check_generator);
        }
      }
      );
}
);
</script> 

<script>
  $(document).ready(function(){
   
  }
  );
</script>
<script>
   $('.tic_qyt').on('change',function(){

      var ticket_id=this.id;
      var selected_qyt=$(this).val();
     

      $.ajax({
        type: "post",
        url: "<?php echo base_url(); ?>index.php/frontend/events/check_available_quantity/"+ticket_id+'/'+selected_qyt,
        cache: false,  
        success: function(quantity_status){
               
            if(quantity_status=='success')
            {  
              $('#'+ticket_id).attr('style','');
              $('#'+ticket_id).siblings('.err_in_qyt').text('');
              
            }
            else
            {
               $('#'+ticket_id).val('0');
               $('#'+ticket_id).attr('style','border-color:red');
               
                 $('#'+ticket_id).siblings('.err_in_qyt').text('Remaining tickets are '+quantity_status);
            }

        },
        error: function(){
        alert('Error while request..');
       }
       }
      );
    });
</script>