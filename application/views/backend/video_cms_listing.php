<script>

	jQuery(document).ready(function(){ 

		jQuery(".pagination li a").click(function(e){ 

			document.getElementById('user_list_form').action = jQuery(this).attr('href');

			jQuery('#user_list_form').submit();   

			e.preventDefault();

		});

	});

</script>
<link href="<?php echo $this->config->item('admin_css_path');?>alertify.core.css" rel="stylesheet">
<link href="<?php echo $this->config->item('admin_css_path');?>alertify.bootstrap.css" rel="stylesheet">
<link href="<?php echo $this->config->item('admin_css_path');?>alertify.default.css" rel="stylesheet">
<script src="<?php echo $this->config->item('admin_js_path');?>/alertify.min.js"></script>

<div id="page-wrapper">

            <div class="container-fluid">

                <div class="row">

                    <div class="col-md-12">

                        <div class="right_first_box"><img src="<?php echo $this->config->item('admin_image_path');?>home.png"><a href="#">Home</a> > <a href="#">Manage Video CMS</a></div>

                    </div>

                </div>			   

                <div class="row margin_top">

                   <div class="col-md-12">

                   <div class="blue_top">Manage Video Cms</div>	 
						
                   <div>
                   	<a href="<?php echo base_url(); ?>index.php/backend/manage_videos/add_page" class="btn btn-primary btn-sm">Add New</a>
                   </div>
				   
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

								<th>Category Name</th>

								<th>Action</th>

							</tr>

						</thead>

                        <tbody>

						<?php 

						if($full_data)

						{

							foreach($full_data as $values)

							{

							?>

							<tr>

							<td><?php echo $values['category'];?></td>

							<td><a href="<?php echo base_url(); ?>backend/manage_videos/edit_page/<?php echo $values['id']; ?>">Edit</a>
									| <a  href="#" onclick="confirmAction(<?php echo $values['id'];?>, 'Are you sure you want to delete page?', changeStatus); return false;">Delete</a>
							</td>

							</tr>

						<?php }} ?>

                        </tbody>

                     </table>

                     </div>

                   </div>

                   </div>

				   <div class="row">

                   <div class="col-md-12">

                   </div>

                   </div>

                   </div>

               </div>
               <script>
	function confirmAction(id, message, action){
		alertify.confirm(message, function(e) {
			if (e) {
				// a_element is the <a> tag that was clicked
				if (action) {
					action(id);
				}
			}
		});
	}	
	
	function changeStatus(id){		
		$.ajax({
			type: "POST",
			dataType: 'json',
			url: "<?php echo base_url(); ?>backend/manage_videos/delete_cms",
			data: "cms_id="+id,
			success: function(Rid1) {
				if (Rid1) {
					location.reload();
					alertify.success("CMS page deleted successfully");
				}else{					
					alertify.error("Unable to delete item");
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