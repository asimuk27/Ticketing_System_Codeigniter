   <style>
    label {     
        font-weight: normal;
    }       
    span{
        color:red;
        font-weight: bold;
    }
    input[type="password"] {
        border: 1px solid rgb(185, 193, 204);
        color: #666;
        height: 43px;
        margin-bottom: 30px;
        padding: 8px 10px;
        width: 100%;
    }
    .error{
        color:red;
    }
</style>
<link href="<?php echo $this->config->item('frontend_css_path');?>jquery-ui.css" rel="stylesheet">
<script src="<?php echo $this->config->item('frontend_js_path');?>jquery-ui.min.js"></script>   
<script src="<?php echo $this->config->item('frontend_js_path');?>validator.js"></script>   
    <div class="content" style="display:none;">
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
                        <h2>Edit Profile</h2>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <ul>
                            <li>
                                <a href="#"><i class="fa fa-home"></i>Home</a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-angle-right"></i>Sign Up</a>
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
             <?php if($this->session->userdata("facebook")!=NULL):?>
        <?php
        $me = $this->facebook->api("/me?fields=email,first_name,last_name");
      
        ?>

      <!-- <a href="<?php //echo base_url(); ?>index.php/frontend/auth/logout">logout</a>-->

    <?php else:?>
       <!-- <a href="<?php //echo base_url(); ?>index.php/frontend/auth/login">Login</a>-->
    <?php endif;?>

            <form action="<?php echo base_url(); ?>index.php/frontend/login/facebook_authentication" method="post" id="authconfirm" style="display:none;">
                    <input type="text" value="<?php echo $me['email'];?>" name="email"/>
                    <input type="text" value="<?php echo $me['first_name'];?>" name="first_name"/>
                    <input type="text" value="<?php echo $me['last_name'];?>" name="last_name"/>
                    <input type="submit" value="Verify"/>
            </form>
            </div>
        </div>
    </div>



<script>
$(document).ready(function(){
     $("#authconfirm").submit();
});
</script>


