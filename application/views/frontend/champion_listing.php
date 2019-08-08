<link href="<?php echo $this->config->item('frontend_css_path');?>jquery-ui.css" rel="stylesheet">
<script src="<?php echo $this->config->item('frontend_js_path');?>jquery-ui.min.js"></script>   
<link href="<?php echo $this->config->item('admin_css_path');?>alertify.core.css" rel="stylesheet">
<link href="<?php echo $this->config->item('admin_css_path');?>alertify.bootstrap.css" rel="stylesheet">
<link href="<?php echo $this->config->item('admin_css_path');?>alertify.default.css" rel="stylesheet">
<script src="<?php echo $this->config->item('admin_js_path');?>/alertify.min.js"></script>
<script src="<?php echo $this->config->item('frontend_js_path');?>jquery.validate.min.js"></script>   	
<link rel="stylesheet" href="<?php echo $this->config->item('frontend_css_path');?>pages/champion_list.css" type="text/css" media="all">
<div class="content">
	<div class="sub-header">
	</div>
	<div class="Kode-page-heading">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-sm-6">
					<h2>Champions Pages</h2>
				</div>
			</div>
			<!--ROW END-->
		</div>
	</div>
	<!--Kode-our-speaker-heading End-->
	<div class="kode-blog-style-2 special_text">
			<div class="container">
				Click <a href="<?php echo $this->config->item('add_champion_page')?>">here</a> to be a Champion for an event
				<hr>
			</div>
		</div>
	<div class="kode-blog-style-2 search_table" style="min-height:500px;">
		<div class="container">
			<div class="row" style="margin-bottom:0px;"> 
				<form method="post" action="<?php echo base_url();?>frontend/champion/manage_champions" id="champion_form" name="champion_form">
					<div class="col-sm-3">
						<input class="form-control" type='text' name='event_name' id='eve_names' value="<?php if(isset($_POST['event_name'])){echo $_POST['event_name'];} ?>" placeholder="Event Name"/>   
					</div>
					<div class="col-sm-3">			
						<select class="form-control dropdown" id="event_list"  name="champ_status"> 
							<option value="">-- Status (All) --</option>
							<option value="1" <?php if(isset($_POST['champ_status']) &&  ($_POST['champ_status'] == '1')){ echo "selected";}?>>Approved</option>
							<option value="0" <?php if(isset($_POST['champ_status']) &&  ($_POST['champ_status'] == '0')){ echo "selected";}?>>Pending</option>
						</select>  
					</div>
					<div class="col-md-3">   
						<button class="blue_box_title" type="submit" style="padding: 9px 29px;margin-right:15px;">Search</button>   
						<button class="blue_box_title" type="reset" style="padding: 9px 29px;" onclick="fr_fresh();">Reset</button>   
					</div>	
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
			 
				  <?php if($this->session->flashdata('message') != ''){ ?>
					<div class="row">
						<div class="col-md-12" style="color:green;margin-top:10px;">
						<?php echo $this->session->flashdata('message');  ?>
						</div>
					</div>	
				  <?php } ?>
			<div class="row">
				<div class="col-md-12">
					<div class="table-responsive">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th>ID</th>
									<th>Title</th>
									<th>Display Name</th>
									<th>Event Name</th> 
									<th>Target Amount</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>

							<tbody>
								<?php 
								if(count($data) > 0){
								$i = 0;
								foreach($data as $get_value){ 
					$title=urlencode($get_value['champ_title']);
                    $url=urlencode($this->config->item('fe_champions_view').'/'.$get_value['id']);
                    $image=urlencode($this->config->item('event_image').'/'.$get_value['original_event_image']);
						if($i % 2 == 0) {	$class = "even"; }else{	$class="odd"; }
								?>
								<tr class="<?php echo $class;?>">

									<td><?php echo $get_value['id']; ?></td>
									<td><?php echo $get_value['champ_title']; ?></td>
									<td><?php echo $get_value['display_name']; ?></td>
									<td><?php echo $get_value['title']; ?></td>
									<td><?php echo $get_value['target_amount']; ?></td>
									
									<?php if($get_value['event_status'] == 1){ ?>
										<?php if($get_value['status']==0){ ?>
										<td>
											<?php if($get_value['delete_status']==1){ ?>	
												<font color="red">Pending</font>
											<?php }else{
												echo "Pending";
											} ?>
										</td>
										<?php }else if($get_value['status']==1){ ?>
										<td>
											<?php if($get_value['delete_status']==1){ ?>	
												<font color="red">Approved</font>
											<?php }else{
												echo "Approved";
											} ?>
											</td>
										<?php }else if($get_value['status']==2){ ?>
										<td>									
											<?php if($get_value['delete_status']==1){ ?>	
												<font color="red">Declined</font>
											<?php }else{
												echo "Declined";
											} ?>
											</td>
										<?php } ?>
									<?php }else if($get_value['event_status'] == 3){  ?>
										<td>Event Suspended</td>
									<?php }else if($get_value['event_status'] == 4){ ?>
										<td>Event Closed</td>
									<?php }else if($get_value['event_status'] == 5){ ?>
										<td>Event Cancelled</td>
									<?php }?>									
									<td>
									
									<?php if($get_value['event_status'] == 1){ ?>
									<?php if($get_value['status'] == 1 && $get_value['delete_status'] == 0){ ?>
										<a rel="nofollow" onClick="window.open('https://www.facebook.com/sharer.php?s=100&p[title]=<?php echo $title;?>&p[url]=<?php echo $url; ?>&p[images][0]=<?php echo $image;?>', 'sharer', 'toolbar=0,status=0,width=548,height=325');" target="_parent" href="javascript: void(0)">
									Share
									</a>																		
									<?php }else{ ?>										
										<label class="label_status">Share</label>
									<?php } ?>										
									|
									<?php if($get_value['status'] == 1 && $get_value['delete_status'] == 0){ ?>
									<a href="#" class="modalbox" data-toggle="modal" data-target="#myModal">Invite</a>
									<?php }else{ ?>									
									<label class="label_status">Invite</label>									
									<?php } ?>
									| 
										<a href="<?php echo base_url(); ?>index.php/frontend/champion/edit_champion_page/<?php echo $get_value['id']; ?>">Edit</a>
									<?php }else{ ?>
										<label class="label_status">Share</label>
									|	<label class="label_status">Invite</label>
									| 	<label class="label_status">Edit</label>
									<?php } ?>
									
									<input type="hidden" class="get_champ_id" value="<?php echo $get_value['id']; ?>" />
            						<input type="hidden" class="get_champ_title" value="<?php echo $get_value['champ_title']; ?>"/>
									|
										<a target="_blank" href="<?php echo base_url(); ?>index.php/frontend/champion/view_fundraising/<?php echo $get_value['id']; ?>">View</a> 
									
									<?php if($get_value['event_status'] == 1){ ?>
									| 
									<?php if($get_value['delete_status'] == 0){ ?>
										<a href="#" onclick="confirmAction(<?php echo $get_value['id'];?>,<?php echo $get_value['delete_status'];?>, 'Do you want to stop this page?', changeStatus); return false;">Stop</a>
									<?php }else{ ?>
										<a href="#" onclick="confirmAction(<?php echo $get_value['id'];?>,<?php echo $get_value['delete_status'];?>, 'Do you want to reactivate this page?', changeStatus); return false;">Restart</a>
									<?php } ?>									
									<?php }else{ ?>
										|
										<label class="label_status">Stop</label>
									<?php }?>
									</td>
								</tr>
								<?php $i++; } }else{
									?><tr><td colspan="7"><?php echo "No champions are available";?></td></tr><?php
								 } ?>
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
</div><!--Content-->
<div class="col-md-2 col-sm-2 col-xs-10">
    	<form method="post" id="modalform" action="<?php echo base_url(); ?>index.php/frontend/champion/get_invites">
    		<div id="myModal" class="modal fade" role="dialog">
    			<div class="modal-dialog modal-lg">
    				<div class="modal-content">
    					<div class="modal-header">
    						<button type="button" class="close" data-dismiss="modal">&times;</button>
    						<h4 class="modal-title" id="model_title">Invites for <span class="modal_champion_title"></span></h4>
    					</div>
    					<div class="modal-body">

    						<div class="row">
    							<div class="col-sm-2">
    								<label>Recipients</label>
    							</div>
    							<div class="col-sm-8">
    								<textarea placeholder="Please enter email address (Mulitple email address should be seperated by comma)" rows="10" class="form-control" id='emailTest' name='emailTest'></textarea>
    								<input type="hidden" name="modal_champ_id" id="modal_champ_id"/>
									<input type="hidden" name="modal_champ_title" id="modal_champ_title"/>
    							</div>
    							<div class="col-sm-4"></div>
    							<div class="col-sm-6" id="modalerror" style="color:red; font-weight: bold"></div>
    						</div>


    					</div>  
    					<div class="modal-footer">
    					 <input type="submit" value="Send" style="float:left" class="btn btn-primary search_events">
    						<button type="button" class="btn btn-default search_events" data-dismiss="modal" style="float:left">Close</button>
    						
    					</div>
    				</div>

    			</div>
    		</div> 
    	</form>
    </div>

<script>
	function fr_fresh(){
		window.location = "<?php echo base_url();?>frontend/champion/manage_champions";		
	}
 
	function page_count_check(){
		 document.getElementById("champion_form").submit();
	}
	
	$(document).ready(function(){
		$('.modalbox').click(function(){
		   // alert('working');
			var champion_id = $(this).siblings('.get_champ_id').val();
			var champion_title = $(this).siblings('.get_champ_title').val();

			$('#emailTest').val('');
			$('#modalerror').text('');
			$('.modal_champion_title').text(champion_title);
			$('#modal_champ_id').val(champion_id);
			$('#modal_champ_title').val(champion_title);
		});
	});

	$(document).on('submit','#modalform',function(e){
			
			var array = $('#emailTest').val().split(",");
			$('#modalerror').text('');
			$.each(array,function(i){
				var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
				if(testEmail.test(array[i]))
				{
				}else{
				   $('#modalerror').text('Please enter valid emails with no whitespaces');
					e.preventDefault(e);
				}
				});
	 });
</script>
<script>
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
  

  function changeStatus(result,status){
    $.ajax({
      type: "POST",
	  dataType: 'json',
      url: '<?php echo $this->config->item('stopActivateMyPage');?>',
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
	
	
    var events_names=[];
	$(document).ready(function(){


		$.ajax({

			type: "post",

			url: "<?php echo base_url(); ?>index.php/frontend/champion/ajax_event_names_for_my_champions",

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



    $( "#eve_names" ).autocomplete({
      source:events_names
    }

    );


	});
</script>




