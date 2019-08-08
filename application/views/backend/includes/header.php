<?php if(!empty($this->session->userdata['admin_logged_in'])){ ?>
	<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>TicketingSystem Admin</title>
    <!-- Bootstrap Core CSS -->
    <!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="<?php echo $this->config->item('admin_css_path');?>bootstrap.min.css">
    <!-- Custom CSS -->
    <link href="<?php echo $this->config->item('admin_css_path');?>style.css" rel="stylesheet">
    <!--Custom Fonts-->
    <link href='https://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet' type='text/css'>
    <!--Font Awesome-->
    <link href="<?php echo $this->config->item('admin_css_path');?>font-awesome.min.css" rel="stylesheet" type="text/css">
	<script src="<?php echo $this->config->item('admin_js_path');?>jquery.min.js"></script>
	<script src="<?php echo $this->config->item('admin_js_path');?>bootstrap.min.js"></script>
    <script src="<?php echo $this->config->item('admin_js_path');?>sb-admin-2.js"></script>
<style>
.row .form-group{ margin-top:15px;}
.from_to_txt { display:inline-block; font-size:16px; margin:15px 10px 0 0}
.margin_bottom{ margin-bottom:20px;}
ul.statement_ul{ margin:0px; padding:0px;}
.note{ color:#000; font-size:16px; margin:10px 0}
</style>
</head>
<body>
  <div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
             <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="" class="navbar-brand text-center" style="float: left; height: 50px; padding: 25px 50px;">TicketingSystem</a>
            </div>
            <!-- /.navbar-header -->
            <ul class="nav navbar-top-links navbar-right right_side_name">
                <li><?php echo $this->session->userdata['admin_logged_in']['email'];?></li>
                <li><a class="dropdown-toggle" href="<?php echo $this->config->item('logout_url');?>">Logout</a></li>
            </ul>
			<?php
				if(isset($this->session->userdata['admin_logged_in']['user_roles'])){
					$data_modules = $this->session->userdata['admin_logged_in']['user_roles'];
					if($data_modules){
						$allowed_modules = explode(",",$data_modules);
					}else{
						$allowed_modules = array();
					}
				}else{
					$allowed_modules = array();
				}
			?>
            <!-- /.navbar-top-links -->
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                   		<li><a href="<?php echo $this->config->item('admin_dashboard');?>">Dashboard</a></li>
                        <?php if(in_array("manage_individual_users",$allowed_modules)){ ?>
						<li>
                            <a href="<?php echo $this->config->item('admin_users');?>">Manage Individual Users<img src="<?php echo $this->config->item('admin_image_path');?>active_arrow.png" class="down_arrow"></a>
                            <ul class="nav inner_nav inner_nav2">
								<li><a href="<?php echo $this->config->item('admin_users');?>">Search Individual Users</a></li>
							</ul>
                        </li>
						<?php } ?>
						<?php if(in_array("manage_admins",$allowed_modules)){ ?>
						<li>
                            <a href="<?php echo $this->config->item('admin_user');?>">Manage Admin Users<img src="<?php echo $this->config->item('admin_image_path');?>active_arrow.png" class="down_arrow"></a>
                            <ul class="nav inner_nav inner_nav2">
								<li><a href="<?php echo $this->config->item('admin_user');?>">Search Admin Users</a></li>
							</ul>
                        </li>
						<?php } ?>
						<?php if(in_array("manage_events",$allowed_modules)){ ?>
						<li>
                            <a href="<?php echo $this->config->item('admin_events');?>">Manage Events<img src="<?php echo $this->config->item('admin_image_path');?>active_arrow.png" class="down_arrow"></a>
                            <ul class="nav inner_nav inner_nav2">
								<li><a href="<?php echo $this->config->item('admin_events');?>">List and Search Events</a></li>
							</ul>
                        </li>
						<?php } ?>
						<?php if(in_array("manage_popular_events",$allowed_modules)){ ?>
						<li>
							<a href="<?php echo $this->config->item('get_popular_events');?>">Manage Popular Events<img src="<?php echo $this->config->item('admin_image_path');?>active_arrow.png" class="down_arrow"></a>
                            <ul class="nav inner_nav inner_nav2">
                            <li><a href="<?php echo $this->config->item('get_popular_events');?>">Popular Events</a></li>
							</ul>
                        </li>
						<?php } ?>
						<?php if(in_array("manage_popular_champions",$allowed_modules)){ ?>
						 <li>
							<a href="<?php echo $this->config->item('get_popular_champions');?>">Manage Popular Champions<img src="<?php echo $this->config->item('admin_image_path');?>active_arrow.png" class="down_arrow"></a>
							<ul class="nav inner_nav inner_nav2">
                            <li><a href="<?php echo $this->config->item('get_popular_champions');?>">Popular Champions</a></li>
							</ul>
                        </li>
						<?php } ?>
						<?php if(in_array("manage_organizations",$allowed_modules)){ ?>
						<li>
                            <a href="<?php echo $this->config->item('admin_organiser');?>">Manage Organizations<img src="<?php echo $this->config->item('admin_image_path');?>active_arrow.png" class="down_arrow"></a>
                            <ul class="nav inner_nav inner_nav2">
								<li><a href="<?php echo $this->config->item('admin_organiser');?>">Search Organizations</a></li>
							</ul>
                        </li>
						<?php } ?>
						<?php if(in_array("manage_champions",$allowed_modules)){ ?>
						<li>
                            <a href="<?php echo $this->config->item('be_champion_listing');?>">Manage Champions<img src="<?php echo $this->config->item('admin_image_path');?>active_arrow.png" class="down_arrow"></a>
                            <ul class="nav inner_nav inner_nav2">
								<li><a href="<?php echo $this->config->item('be_champion_listing');?>">Search Champions</a></li>
							</ul>
                        </li>
						<?php } ?>
						<?php if(in_array("manage_banners",$allowed_modules)){ ?>
						<li>
                            <a href="">Manage Banners<img src="<?php echo $this->config->item('admin_image_path');?>active_arrow.png" class="down_arrow"></a>
                            <ul class="nav inner_nav inner_nav2">
								<li><a href="<?php echo $this->config->item('admin_banners');?>">Manage Banners</a></li>
							</ul>
                        </li>
						<?php } ?>
						<li>
							<a href="<?php echo $this->config->item('admin_profile');?>">My Profile<img src="<?php echo $this->config->item('admin_image_path');?>active_arrow.png" class="down_arrow"></a>
                            <ul class="nav inner_nav inner_nav2">
							<li><a href="<?php echo $this->config->item('admin_profile');?>">Profile</a></li>
							</ul>
						</li>
						<li>
							<a href="<?php echo $this->config->item('admin_change_password');?>">Change Password<img src="<?php echo $this->config->item('admin_image_path');?>active_arrow.png" class="down_arrow"></a>
                            <ul class="nav inner_nav inner_nav2">
							<li><a href="<?php echo $this->config->item('admin_change_password');?>">Password</a></li>
							</ul>
                        </li>
						<?php if(in_array("organizer_set_up",$allowed_modules)){ ?>
						<li>
							<a href="<?php echo $this->config->item('set_up_organizations');?>">Set Up Organization<img src="<?php echo $this->config->item('admin_image_path');?>active_arrow.png" class="down_arrow"></a>
                            <ul class="nav inner_nav inner_nav2">
							<li><a href="<?php echo $this->config->item('set_up_organizations');?>">Set Up Organization</a></li>
							</ul>
                        </li>
						<?php } ?>

						<li>
							<a href="<?php echo $this->config->item('admin_payment_set_up');?>">Payment SetUp<img src="<?php echo $this->config->item('admin_image_path');?>active_arrow.png" class="down_arrow"></a>
                            <ul class="nav inner_nav inner_nav2">
							<li><a href="<?php echo $this->config->item('admin_payment_set_up');?>">Payment SetUp</a></li>
							</ul>
                        </li>

						<li>
							<a href="<?php echo $this->config->item('base_url');?>backend/faq">Manage FAQ<img src="<?php echo $this->config->item('admin_image_path');?>active_arrow.png" class="down_arrow"></a>
                            <ul class="nav inner_nav inner_nav2">
							<li><a href="<?php echo $this->config->item('base_url');?>backend/faq">Manage FAQ</a></li>
							</ul>
                        </li>
						<li>
							<a href="<?php echo $this->config->item('base_url');?>backend/donation_reports">Manage Donation Reports<img src="<?php echo $this->config->item('admin_image_path');?>active_arrow.png" class="down_arrow"></a>
                            <ul class="nav inner_nav inner_nav2">
							<li><a href="<?php echo $this->config->item('base_url');?>backend/donation_reports">Manage Donation Reports</a></li>
							</ul>
                        </li>
						<li>
							<a href="<?php echo $this->config->item('base_url');?>backend/ticket_reports">Manage Ticket Reports<img src="<?php echo $this->config->item('admin_image_path');?>active_arrow.png" class="down_arrow"></a>
                            <ul class="nav inner_nav inner_nav2">
							<li><a href="<?php echo $this->config->item('base_url');?>backend/ticket_reports">Manage Ticket Reports</a></li>
							</ul>
                        </li>

						<li>
							<a href="<?php echo $this->config->item('base_url');?>backend/manage_videos">Manage Video CMS<img src="<?php echo $this->config->item('admin_image_path');?>active_arrow.png" class="down_arrow"></a>
                            <ul class="nav inner_nav inner_nav2">
							<li><a href="<?php echo $this->config->item('base_url');?>backend/manage_videos">Manage Video CMS</a></li>
							</ul>
                        </li>

                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
<?php } ?>