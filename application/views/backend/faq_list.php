
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
$(function () {
    $("#sortable").sortable({
        update: function (event, ui) {
            var order = $(this).sortable('serialize');

            $(document).on("click", "button", function () { //that doesn't work
			
            });
        }
    }).disableSelection();
    $('#save_faq_order').on('click', function () {
        var r = $("#sortable").sortable("toArray");
        var a = $("#sortable").sortable("serialize", {
            attribute: "id"
        });
		$.ajax({
   type: "POST",
   data: {a:r},
   url: "<?php echo base_url(); ?>index.php/backend/faq/update_faq_order",
   success: function(msg){
     alert('success');
    }
     });
        console.log(r, a);
    });
});
</script>
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
<script>
 
function confirmAction(a_element, status, message, action){
		alertify.confirm(message, function(e) {
		if (e) {
			// a_element is the <a> tag that was clicked
			if (action) {
				action(a_element,status);
			}
		}
		});
	} 
  

  
  function changeStatus(id,status){ 
    //==alert(id)
    $.ajax({
      type: "POST",
      dataType: 'json',
       url: "<?php echo base_url(); ?>index.php/backend/faq/ajax_update_faq_status",
      data: "status="+status+" &id="+id,
      success: function(Rid1) {
        if (Rid1) {
			location.reload();
			alertify.success("Status updated successfully");       
        }else{          
          alertify.error("Unable to update status");
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
<style>
	.margin_extra{margin-top:10px;}
</style>

  <div id="page-wrapper">
             <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="right_first_box"><img src="<?php echo $this->config->item('admin_image_path');?>home.png"><a href="#">Home</a> > <a href="#">Manage FAQs</a></div>
                    </div>
                </div>			   
                <div class="row margin_top">
                   <div class="col-md-12">
                   <div class="blue_top">FAQ Listing</div>
				   
				     <div class="row">
						<a type="button" href="<?php echo base_url(); ?>index.php/backend/faq/add_faq" class="btn btn-primary pull-left" style="margin-left: 15px;">Add New</a>
					</div>
					  <?php if($this->session->flashdata('message') != ''){ ?>
							<div class="row" style="margin-bottom:5px;">								
								<div class="col-md-9" style="color:green;margin-top:10px;">
						<?php echo $this->session->flashdata('message');  ?>
								</div>
							</div>	
						<?php } ?>
						
                   <div class="table-responsive table_white_box">
                    <form action="<?php echo base_url(); ?>index.php/backend/faq/update_form" method="post">
					<table class="table table-striped">					
						<thead>
							<tr>								
								<th>Title</th>
								<th>Action</th>
							</tr>
						</thead>
                        <tbody id="sortable">
							<?php 
						foreach($listing_data as $user_data){ ?>
							<tr>
							 <input type="hidden" name="order_list[]" value="<?php echo $user_data['id'];?>"/>			
								<td><?php echo $user_data['header_title'];?></td>
								<td>
									<a href="<?php echo base_url(); ?>index.php/backend/faq/edit_faq/<?php echo $user_data['id']; ?>">Edit</a> |
                                    <?php if($user_data['status']=='0'){ ?>
                                         <a href="" class="change_status" id="<?php echo $user_data['id']; ?>" onclick="confirmAction(<?php echo $user_data['id'];?>,<?php echo $user_data['status'];?>,'Are you sure you want to disable this FAQ?', changeStatus); return false;">Disable</a>
                                     <?php }else{ ?>
                                          <a href="" class="change_status" id="<?php echo $user_data['id']; ?>" onclick="confirmAction(<?php echo $user_data['id'];?>,<?php echo $user_data['status'];?>,'Are you sure you want to enable this FAQ?', changeStatus); return false;">Enable</a>
                                     <?php } ?>									
								</td>
							</tr>   
							<?php } ?>
                        </tbody>
                        
                     </table>
                    
                     </div>
					
                       <input type="submit" value="Save order" class="btn btn-primary margin_extra" style="margin-bottom:10px;"/>
					  
                        </form>
						
                   </div>
                   </div>
                   </div>
                   </div>
				  




























