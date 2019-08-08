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
	.error{color:red;}
	.input-disabled{background-color:#EBEBE4;border:1px solid #ABADB3;}
</style>
<div id="page-wrapper">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="right_first_box">
					<img src="<?php echo $this->config->item('admin_image_path');?>home.png">
						<a href="#">Home</a> > <a href="#">Popular Champions</a>
				</div>
			</div>
		</div>  				 
		<div class="row margin_top margin_bottom">
			<div class="col-md-12">
				<div class="blue_top">Popular Champions</div>
					<?php if($this->session->flashdata('message') != ''){ ?>
							<div class="row" style="margin-bottom:5px;">								
								<div class="col-md-9" style="color:green;margin-top:10px;">
						<?php echo $this->session->flashdata('message');  ?>
								</div>
							</div>	
						<?php } ?>
				<div class="table-responsive table_white_box" style="padding:25px;">
					<form method="post" action="<?php echo $this->config->item('save_popular_champions');?>" id="popular_champions" name="popular_champions">
					<div class="col-lg-8 col-md-11">
								
						<?php if(!empty($data)){ ?>
						<?php foreach($data as $popular_records){	
							 ?>
							<div class="row">
								<div class="col-md-4">
									<label style="margin-top:6px;">Popular Champion <?php echo $popular_records->position;?></label>
								</div>
								<div class="col-md-4"><input placeholder="Enter Champion ID" value="<?php echo $popular_records->champion_id;?>" type="text" class="form-control" id="popular_<?php echo $popular_records->position;?>" name="popular_<?php echo $popular_records->position;?>" onblur="call_function(this,'popular_<?php echo $popular_records->position;?>');"></div>
								<label class="error" id="label_popular_<?php echo $popular_records->position;?>"></label>
								
							</div>	
							<br class="clear">
						<?php } } ?>	
							<div class="row">
								<div class="col-md-4">
									<label style="margin-top:6px;"></label>
								</div>
								<div class="col-md-10">
									<input type="submit" value="Update" class="btn btn-primary save_btn"> 
									<!--<input type="button" value="Preview Champions" class="btn btn-primary save_btn" onclick="view_previes_events();"> -->
									<input type="button" value="Cancel" class="btn btn-primary save_btn" onclick="window.history.back();">	
								</div>
							</div>
						<br>
					</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script>

	function view_previes_events(){
		window.open('<?php echo $this->config->item('base_url');?>index.php/backend/events/preview_popular_events'); 
	}
	
	function call_function(champion_id,text_box_id){		
		if(champion_id.value != ""){
			
		$.ajax({
		type: "POST",
		url: "<?php echo $this->config->item('base_url');?>index.php/backend/champions/check_champion_validity",
		data: "champion_id="+champion_id.value,   
		success: function(data){	
			if(data == "0"){			
				document.getElementById('label_'+text_box_id).innerHTML = "Please enter valid active champion id";
				document.getElementById(text_box_id).value = "";
			}else{
				
			}			
		}
		});
		}
	}
</script>