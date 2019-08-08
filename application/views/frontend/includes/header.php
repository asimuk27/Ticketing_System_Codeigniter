<!DOCTYPE HTML>
<html lang="en">
<head>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-MWHRT2R');</script>
<!-- End Google Tag Manager -->
 <!-- Facebook Pixel Code -->

<script>

!function(f,b,e,v,n,t,s)

{if(f.fbq)return;n=f.fbq=function(){n.callMethod?

n.callMethod.apply(n,arguments):n.queue.push(arguments)};

if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';

n.queue=[];t=b.createElement(e);t.async=!0;

t.src=v;s=b.getElementsByTagName(e)[0];

s.parentNode.insertBefore(t,s)}(window,document,'script',

'https://connect.facebook.net/en_US/fbevents.js');

fbq('init', '153154212188763');

fbq('track', 'PageView');

</script>

<noscript>

<img height="1" width="1"

src="https://www.facebook.com/tr?id=153154212188763&ev=PageView

&noscript=1"/>

</noscript>

<!-- End Facebook Pixel Code -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="TicketingSystem is a product of Telelink Limited.We are proud to produce TicketingSystem and we believe it will improve the experience to run events">
	<meta name="keywords" content="TicketingSystem,events,organiser,fundraising,champions,chairty,book,suspended,telelink">
	<?php if($this->uri->segment(1) == 'view-champion'){
		if($data['fundraising_image']){
			if(filter_var($data['fundraising_image'], FILTER_VALIDATE_URL)){
				$image_name = $data['fundraising_image'];
			}else{
				$image_name = $this->config->item('frontend_profileimage_path').'/'.$data['fundraising_image'];
			}
		}else{
			$image_name = $this->config->item('default_image_url').'/fundraising_profile.jpg';
		}
		?>
		<meta property="og:title" content="<?php echo $data['title']; ?>" />
		<meta property="og:description" content="<?php echo htmlspecialchars(strip_tags($data['message']));?>" />
		<meta property="og:image" content="<?php echo $image_name;?>" />
		<title>View Champion</title>
	<?php }else if($this->uri->segment(1) == 'view-event'){ ?>

		<meta property="og:title" content="<?php echo $meta['title']; ?>" />
		<meta property="og:description" content="<?php echo htmlspecialchars(strip_tags($meta['description']));?>" />
		<meta property="og:image" content="<?php echo $meta['image'];?>" />
		<title>View Event - <?php echo $meta['title']; ?></title>
	 <?php }else{ ?>
		<meta property="og:title" content="TicketingSystem" />
		<meta property="og:description" content="TicketingSystem" />
		<meta property="og:image" content=""/>
		<title>TICKETING SYSTEM<?php if(isset($seo_title)){ echo " - ".$seo_title;}?></title>
	<?php } ?>
	<link rel="icon" type="image/png" href="<?php echo $this->config->item('fe_assets_url');?>favicon/favicon.ico"/>
	<link rel="stylesheet" href="<?php echo $this->config->item('frontend_css_path');?>bootstrap.min.css" type="text/css" media="all">
	<!-- bxSlider CSS file -->
	<link href="<?php echo $this->config->item('frontend_css_path');?>jquery.bxslider.css" rel="stylesheet" />
	<!-- Important Owl stylesheet -->
	<link rel="stylesheet" href="<?php echo $this->config->item('frontend_css_path');?>owl.carousel.css">
    <!-- Full Calender stylesheet -->
	<link rel="stylesheet" href="<?php echo $this->config->item('frontend_css_path');?>fullcalendar.css">
	<!-- Typo css -->
	<link rel="stylesheet" href="<?php echo $this->config->item('frontend_css_path');?>typo.css" type="text/css" media="all">
	<!-- Font Awesome css -->
	<link rel="stylesheet" href="<?php echo $this->config->item('frontend_css_path');?>font-awesome.min.css" type="text/css" media="all">
	<!-- Ihover css -->
	<link href="<?php echo $this->config->item('frontend_css_path');?>ihover.css" rel="stylesheet">
    <!-- Widget css -->
	<link href="<?php echo $this->config->item('frontend_css_path');?>widget.css" rel="stylesheet">
    <!-- Style css -->
	<link rel="stylesheet" href="<?php echo $this->config->item('frontend_css_path');?>style.css" type="text/css" media="all">
	<!--Side MENU-->
    <link rel="stylesheet" href="<?php echo $this->config->item('frontend_css_path');?>jquery.sidr.dark.css" type="text/css" media="all">
	<!-- PrettyPhoto css -->
	<link rel="stylesheet" href="<?php echo $this->config->item('frontend_css_path');?>prettyPhoto.css" type="text/css" media="all">
    <!-- Responsive css -->
	<link rel="stylesheet" href="<?php echo $this->config->item('frontend_css_path');?>responsive.css" type="text/css" media="all">
    <!-- Color css -->
	<link rel="stylesheet" href="<?php echo $this->config->item('frontend_css_path');?>color.css" type="text/css" media="all">
	<link rel="stylesheet" href="<?php echo $this->config->item('frontend_css_path');?>placeholder.css">
	<!--Jquery Lib-->
<script src="<?php echo $this->config->item('frontend_js_path');?>jquery.js"></script>
<!--Bootstrap Javascript File-->
<script src="<?php echo $this->config->item('frontend_js_path');?>bootstrap.min.js"></script>
<!-- bxSlider Javascript file -->
<script src="<?php echo $this->config->item('frontend_js_path');?>jquery.bxslider.js"></script>
<!-- OWL Javascript file -->
<script src="<?php echo $this->config->item('frontend_js_path');?>owl.carousel.min.js"></script>
<!--Image Filterable Gallery-->
<script src="<?php echo $this->config->item('frontend_js_path');?>jquery-filterable.js"></script>
<!--Number Count Script-->
<script src="<?php echo $this->config->item('frontend_js_path');?>waypoints-min.js"></script>
<!--Full Calender Script-->
<script src="<?php echo $this->config->item('frontend_js_path');?>moment.min.js"></script>
<script src="<?php echo $this->config->item('frontend_js_path');?>fullcalendar.min.js"></script>
<!--Time Counter Script-->
<script src="<?php echo $this->config->item('frontend_js_path');?>jquery.downCount.js"></script>
<!--Internet Explore Script-->
<script src="<?php echo $this->config->item('frontend_js_path');?>ie.js"></script>
<!--Accordian Explore Script-->
<script src="<?php echo $this->config->item('frontend_js_path');?>jquery.accordion.js"></script>
<!--RESPONSIVE MENU-->
<script src="<?php echo $this->config->item('frontend_js_path');?>jquery.sidr.min.js"></script>
<!--PrettyPhoto Js -->
<script src="<?php echo $this->config->item('frontend_js_path');?>jquery.prettyPhoto.js"></script>
<link rel="stylesheet" href="<?php echo $this->config->item('frontend_css_path');?>custom_css.css" type="text/css" media="all">

</head>
<body>

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MWHRT2R"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<!-- Wrapper start -->
<div id="wrapper">
	<div id="mobile-header">
        <a id="responsive-menu-button" href="#sidr-main"><span class="fa fa-bars"></span></a>
    </div>
	<header id="kode-header" >
		<strong class="kode-logo">
			<a href="<?php echo $this->config->item('base_url')?>"><img src="<?php echo $this->config->item('frontend_image_path');?>images/TicketSuitLogo1_transparent.png" alt="logo_image"></a>
		</strong>
		<nav class="kode-nav" id="navigation">
			<ul>
				<li class="<?php if($this->uri->segment(1) == "events"){ echo "active";}?>"><a href="<?php echo $this->config->item('base_url')?>events/">Events</a></li>

				<?php
					if(!isset($this->session->userdata['logged_in']) || (isset($this->session->userdata['logged_in']) && ($this->session->userdata['logged_in']['login_type'] == 0))){
				?>
				<li class="<?php if($this->uri->segment(1) == "fund-raise"){ echo "active";}?>"><a href="<?php echo $this->config->item('base_url')?>fund-raise">Fund Raise</a></li>
				<li class="<?php if($this->uri->segment(1) == "donate"){ echo "active";}?>"><a href="<?php echo $this->config->item('base_url')?>donate">Donate</a></li>
				<?php } ?>

				<li class="<?php if($this->uri->segment(1) == "learn-more"){ echo "active";}?>"><a href="<?php echo $this->config->item('base_url')?>learn-more">Learn More</a></li>

				<?php
				    if(isset($this->session->userdata['logged_in']['login_type'])){
					if($this->session->userdata['logged_in']['login_type']==1){
				?>
				<li><a href="">Profile</a>
					<ul>
						<li><a href="<?php echo $this->config->item('base_url')?>index.php/frontend/champion/approve_champions_list">Approve Champions</a></li>
						<li><a href="<?php echo $this->config->item('base_url')?>frontend/payment/set_up_payment">Set up Payment</a></li>
						<li><a href="<?php echo $this->config->item('base_url')?>frontend/organiser/view_profile">View Profile</a></li>
						<li><a href="<?php echo $this->config->item('base_url')?>frontend/organiser/edit_profile">Edit Profile</a></li>
						<li><a href="<?php echo $this->config->item('base_url')?>frontend/login/logout">Logout</a></li>
					</ul>
				</li>
				<?php }

				if(isset($this->session->userdata['logged_in']['login_type']) && ($this->session->userdata['logged_in']['login_type'] == 0)){
				?>
				<li><a href="">Profile</a>
					<ul>
						<li><a href="<?php echo $this->config->item('base_url')?>frontend/users/view_user_profile">View Profile</a></li>
						<li><a href="<?php echo $this->config->item('base_url')?>frontend/users/edit_user_profile">Edit Profile</a></li>
						<li><a href="<?php echo $this->config->item('base_url')?>frontend/login/logout">Logout</a></li>
					</ul>
				</li>
				<li><a href="">My Pages</a>
					<ul>
						<li><a href="<?php echo $this->config->item('base_url')?>frontend/champion/manage_champions">My Champion Pages</a></li>
						<li><a href="<?php echo $this->config->item('base_url')?>frontend/my_donation">My Donations</a></li>
						<li><a href="<?php echo $this->config->item('base_url')?>frontend/tickets/manage_user_ticket_booking">My Ticket Bookings</a></li>
					</ul>
				</li>
				<?php }

				}else{ ?>
						<li class="<?php if($this->uri->segment(1) == "login"){ echo "active";}?>"><a href="<?php echo $this->config->item('base_url')?>login">Login</a></li>
				<?php } ?>

				<?php
					if(isset($this->session->userdata['logged_in']['login_type']) && ($this->session->userdata['logged_in']['login_type'] == 1)){
				?>
				<li><a href="">Dashboard</a>
					<ul>
						<li><a href="<?php echo $this->config->item('add_event')?>">Create Event</a></li>
						<li><a href="<?php echo $this->config->item('base_url')?>frontend/events/manage_events">Manage Event</a></li>
						<li><a href="<?php echo $this->config->item('base_url')?>frontend/tickets/manage_ticket_booking">Manage Tickets</a></li>

						<li><a href="<?php echo $this->config->item('base_url')?>frontend/events/sponsor_request_listing">Sponsorship Request</a></li>

						<li><a href="<?php echo $this->config->item('base_url')?>index.php/frontend/donation_reports/index">Donation Reports</a></li>

						<li><a href="<?php echo $this->config->item('base_url')?>frontend/statistics/index">Event Statistics</a></li>
					</ul>
				</li>
				<?php } ?>

			</ul>
		</nav>


		<div class="col-right">
			<ul class="header-social">
				<li><a target="_blank" href="https://www.facebook.com/TicketingSystem/" data-toggle="tooltip" title="Facebook" data-placement="bottom"><span class="fa fa-facebook fa_special_icons"></span></a></li>

                <li><a target="_blank" href="https://www.linkedin.com/company/18339625/" data-toggle="tooltip" title="LinkedIn" data-placement="bottom"><span class="fa fa-linkedin fa_special_icons"></span></a></li>

				 <li><a target="_blank" href="https://twitter.com/TicketingSystemNZ" data-toggle="tooltip" title="Twitter" data-placement="bottom"><span class="fa fa-twitter fa_special_icons"></span></a></li>

				 <li><a target="_blank" href="https://plus.google.com/u/0/102494399881110349877" data-toggle="tooltip" title="Google+" data-placement="bottom"><span class="fa fa-google-plus fa_special_icons"></span></a></li>

				 <li><a target="_blank" href="https://www.youtube.com/channel/UCekd5LpaBgM3V4vmfw4Xhdw/featured" data-toggle="tooltip" title="YouTube" data-placement="bottom"><span class="fa fa-youtube fa_special_icons"></span></a></li>

				 <li><a target="_blank" href="https://TicketingSystem.blogspot.co.nz/" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="Blogger"><img src="<?php echo $this->config->item('base_url')?>assets/frontend/images/social/blogger_50x50.png" class="blogger_fa_custom" alt="Blogger"></a></li>
            </ul>
		</div>
        <div class="searchtop"><form action="<?php echo $this->config->item('base_url');?>frontend/search" method="post"><input type="text" id="srch" name="srch" class="topsearch"><input type="submit" class="topsearchbtn" value="Search"></form>
		    </div>
        <!--<?php
					// if(isset($this->session->userdata['logged_in']['first_name'])){ ?>
						<div class="col-right"><span class="header-social"><?php
					//	echo "Hello ".$this->session->userdata['logged_in']['first_name']." !!!";?>
						</span></div>	<?php
					//}
				?>-->
	</header>
	<!-- Kode-Header End -->
