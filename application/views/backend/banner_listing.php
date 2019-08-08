<link href="<?php echo $this->config->item('admin_css_path');?>alertify.core.css" rel="stylesheet">
<link href="<?php echo $this->config->item('admin_css_path');?>alertify.bootstrap.css" rel="stylesheet">
<link href="<?php echo $this->config->item('admin_css_path');?>alertify.default.css" rel="stylesheet">
<script src="<?php echo $this->config->item('admin_js_path');?>/alertify.min.js"></script>
<link rel="stylesheet" href="<?php echo $this->config->item("admin_css_path"); ?>/lightbox.css" />
<script type="text/javascript" src="<?php echo $this->config->item("admin_js_path"); ?>/lightbox.js"></script>
<script>
	function confirmAction(status, message, action){
		alertify.confirm(message, function(e) {
			if (e) {
				// a_element is the <a> tag that was clicked
				if (action) {
					action(status);
				}
			}
		});
	}	
	
	function changeStatus(banner_id){	

		$.ajax({
			type: "POST",
			dataType: 'json',
			url: "<?php echo base_url(); ?>index.php/backend/banners/delete_banner",
			data: "banner_id="+banner_id,
			success: function(Rid1) {
				if (Rid1) {
					location.reload();
					alertify.success("Banner deleted successfully");
				}else{					
					alertify.error("Unable to delete banner");
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
<div id="page-wrapper">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="right_first_box">
					<img src="<?php echo $this->config->item('admin_image_path');?>home.png">
						<a href="#">Home</a> > <a href="#">Manage Banners</a>
				</div>
			</div>
		</div>
		<div class="row margin_top margin_bottom">
			<div class="col-md-12">				
			   <div class="blue_top">Banner Listing</div>		                   
			   
			   <button class="btn btn-primary" onclick="location.href='<?php echo $this->config->item("add_banner"); ?>'"  type="button'">Add New Banner</button>
			   
			     <?php if($this->session->flashdata('message') != ''){ ?>
					<div class="row">
						<div class="col-md-12" style="color:green;margin-top:10px;">
						<?php echo $this->session->flashdata('message');  ?>
						</div>
					</div>	
				<?php } ?> 
				
			   <div class="table-responsive table_white_box">
				<table class="table table-striped">
						<thead>
							<tr>
								<th>Id</th>
								<!--<th>Event Name</th>
								<th>Start Date</th>-->								
								<th>Image Name</th>
								<th>Created Date</th>
								<th>Action</th>
							</tr>
						</thead>
                        <tbody>
							<?php
								if($get_banner_list){
								foreach($get_banner_list as $list){ ?>
							<tr>
								<td><?php echo $list['id'];?></td>											
								<td><?php echo $list['image_name'];?></td>
								<td><?php echo date("d-m-Y", strtotime($list['created_date']));?></td>
								<td>								  
									 <a class="preview_banner" data-toggle="modal" data-target="#myModal" id="<?php echo $list['image_name']; ?>">Preview</a>														 
									| <a href="#" onclick="confirmAction(<?php echo $list['id'];?>,'Are you sure you want to delete this banner?', changeStatus); return false;">Delete</a>
								</td>
							</tr>   
							<?php } }else{ ?>
								<tr>
									<td colspan="6">No banner record are available</td>
								</tr>
							<?php } ?>						
							
                        </tbody>
                     </table>
				 </div>
				  <div class="row">
                   <div class="col-md-12">
						<?php echo $this->pagination->create_links(); ?>
                   </div>
                   </div>
				   <br class="clear">
			</div>
  
			   
<script>
	function page_count_check(){
		 document.getElementById("user_list_form").submit();
	}
</script>

	<div id="myModal" class="modal fade" role="dialog">
    			<div class="modal-dialog modal-lg">
    				<div class="modal-content">
    					<div class="modal-header">
    						<button type="button" class="close" data-dismiss="modal">&times;</button>
    						<h4 class="modal-title" id="model_title">Preview Image<span class="modal_champion_title"></span></h4>
    					</div>
    					<div class="modal-body">
                         <img id="preview_image_model" src="" style="height:294px"/>
							
							
    					</div>  
    					<div class="modal-footer">
    					
    						<button type="button" class="btn btn-default search_events" data-dismiss="modal" style="float:left">Close</button>
    						
    					</div>
    				</div>

    			</div>
    		</div> 



   <script>
   $(document).ready(function(){
     
     $('.preview_banner').click(function(){
       var image_name = this.id;
       var image_path="<?php echo base_url(); ?>assets/image_uploads/banner_images/";
       $('#preview_image_model').attr('src',image_path+image_name);




     });

   });
   </script> 		