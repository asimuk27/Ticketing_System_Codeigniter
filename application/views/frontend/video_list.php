<style>
	.ul_class {
		margin:inherit;
		padding:inherit;
		display: block;
		margin-left: 30px;
		margin-bottom: 7px;
	}

	.ul_class li{
		 list-style: disc;
	}

	p{margin-bottom:5px;}

	.active_link{
		font-weight:bold;
		background: white;
	}	

	.own_class{
		cursor: pointer; margin-bottom:10px;padding:2px;border-radius:5px;
	}
	
	.special_text{
		min-height:400px;
	}
</style>



<div class="content">

<div class="sub-header">

          

        </div>

	

		<div class="Kode-page-heading">

			<div class="container">

			

				<div class="row">

					<div class="col-md-8 col-sm-8">
                      <h2>How To Videos</h2>
						

					</div>					

				</div>

				

			</div>

		</div>

	

	

    <div id="main" class="kode-blog-style-2 special_text">
            <div class="container">

                  		<div class="row">
               			<div class="col-md-3">
                        	<div class="blue_box">
                            	<h5 class="text-center">Categories</h5>
                                <div class="row internal_tab_space">
                                <?php $i=1; ?>
                                        <?php foreach($data as $cat){
                                           if($i==1){
                                           	$active_link="active_link";
                                           }else{
                                           	 $active_link="";
                                           }
                                           $i++;
                                        	?>
                                		<div class="col-md-12">
                                        <p class="video_cat paragraph <?php echo $active_link; ?> own_class" id="<?php echo $cat['id'] ?>"><?php echo $cat['category'];?></p>
                                        </div>
                                        <?php } ?>
                                       
                                       
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                        	<div class="blue_box">
                            	<h5>
                                	<div class="row">
                                    	<div class="col-md-4 col-sm-8 col-xs-8">Content</div>
                                		
                                    </div>
                                </h5>
                                <div class="row internal_tab_space">
                                	<br class="clear">
                                    <div class="col-md-12" id="dynamic_content">
                                    	<?php echo htmlspecialchars_decode(stripslashes($data[0]['content']))?>
                                    </div>
                                   
                                  
                                
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
    </div>


<script>
$(document).ready(function(){

$('.video_cat').click(function(){
 var cat_id=this.id;
 

       $.ajax({
        type: "post",

        url: "<?php echo base_url(); ?>index.php/frontend/video_cms/get_content/"+cat_id,
        cache: false,  
        success: function(data){
           $('#dynamic_content').html('');
         
          $('#dynamic_content').html(data);

        },
        error: function(){
        alert('Error while request..');
       }
       }
      );

      $(".video_cat").each(function() {
        $(this).removeClass('active_link');
      }); 

      $('#'+cat_id).addClass('active_link').fadeIn();





});

});
</script>
	

	

	