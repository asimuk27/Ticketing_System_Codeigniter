<?php ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
</head>
<style>
body{font-family: arial,sans-serif;}
table tr td{line-height:26px;}
.find_events a { color: #aaaaaa;font-size:14px;}
.blue_anker{color:#1090ba;}
</style>

<body>
<div style="width:100%;padding:2% 5%;background:#f7f7f7;margin:0 auto;float:left;margin-bottom:5%;">
<div style="width: 70%; margin: auto;" align="center">
<table style="width:100%;">
<tr>
<td style="width:33%;padding:5px;" align="left">
<img src="<?php echo $this->config->item('email_template_image_path')."/logo.png";?>">
</td>
</tr>
</table>
<table style="width:100%;">
	<tr style="background:#fff;">
		<td style="padding:20px;width:100%;color:#666666;">Hi <?php echo $order_info['first_name'];?> <?php echo $order_info['last_name'];?><br><br>
		Your order number #<?php echo $even_sub_events['order_id'];?> for <?php echo $event_details['title'];?> Organized by <?php echo $organizer_data->charity_name;?> has been confirmed<br>
		Please view the attachments in this email.
		<br><br>
Cheers! <br><br>
TicketingSystem<br><br>
</td>
</tr>
</table>

<table style="width:100%;margin-top:20px;">
<tr style="background:#fff;">
<td style="padding:20px;width:100%;">
<!--
<?php if(!empty($ticket_data)){ ?>
<div style="width:100%;float:left;">
<table style="width:100%;">
<tr style="width:100%;">
<td style="width:100%;"><div style="font-weight:bold;font-size:20px;margin-bottom:20px;letter-spacing:1px;">Here are your tickets</div></td>
</tr>
</table>

<table style="width:42%;float:left;">
<tr>
<td>
 <div style="font-weight:bold;text-align:center;margin-top:10px;">Paper Tickets</div>
 <div style="color:#666666;text-align:center;">Open the email attachment or <a target="_blank" href="<?php echo $this->config->item('base_url')?>assets/tickets_generated/<?php echo $even_sub_events['order_id'].".pdf";?>" class="blue_anker">download here</a></div>
</td>

</tr>
</table>
</div>
<?php } ?>
-->
<div style="padding:10px;background:#dedede;float:left;width:96%;margin-top:20px;"></div>
<div style="color:#666666;float:left;margin-top:10px;font-size:13px;margin-bottom:5%;">Contact the organiser at <a href="mailto:<?php echo $organizer_email;?>" class="blue_anker"><?php echo $organizer_email;?></a>
</div>
<img src="<?php echo $this->config->item('email_template_image_path')."/top_line.jpg";?>" style="max-width:100%;">
<div style="padding:20px 30px;background:#ededed;width:88%;float:left;margin-top:5px;">

<table style="width:100%;font-size:13px;color:#666666;">
<tr style="width:100%;">
<td style="width:50%;font-weight:bold;font-size:20px;color:#000;">Order Summary</td>
<td style="width:50%;text-align:right;"><?php echo date("d-m-Y", strtotime($order_info['txn_date']));?></td>
</tr>
</table>

<table style="width:100%;">
<tr style="width:100%;">
<td style="width:100%;font-weight:bold;font-size:20px;"><div style="border-bottom:2px dotted #dedede;width:100%;float:left;"></div></td>
</tr>
</table>
<table style="width:100%;">
<tr style="width:100%;">
<td style="width:100%;color:#666666;">Order #: <?php echo $even_sub_events['order_id'];?></td>
</tr>
<tr>
<td style="width:100%;color:#666666;">Order Amount: $<?php echo number_format($order_info['amount'],2);?></td>
</tr>
</table>
<?php if(!empty($ticket_data)){ ?>
<br>
<label><u>Ticket Summary - Total $<?php echo number_format($ticket_total_price,2);?></u></label>
<table style="width:100%;font-size:14px;color:#666666;">
<tr style="width:100%;">
<td style="width:40%;">Ticket Category</td>
<td style="width:5%;text-align:right;">Quantity</td>
<td style="width:25%;text-align:right;">Price</td>
</tr>
</table>

<table style="width:100%;">
<tr style="width:100%;">
<td style="width:100%;font-weight:bold;font-size:20px;"><div style="border-bottom:2px dotted #dedede;width:100%;float:left;"></div></td>
</tr>
</table>
<?php foreach($ticket_data as $tickets){ ?>
	<table style="width:100%;font-size:14px;color:#666666;">
	<tr style="width:100%;">
	<td style="width:40%;"><?php echo $tickets['ticket_name'];?></td>
	<td style="width:5%;text-align:right;"><?php echo $tickets['quantity'];?></td>
	<td style="width:25%;text-align:right;"><?php echo number_format(($tickets['quantity']*$tickets['price']),2);?></td>
	</tr>
	</table>
<?php } } ?>
<?php if(!empty($order_donation_summary)){ ?>
<br>
<label><u>Support Summary - Total $<?php echo number_format($total_order_donation,2);?></u></label>
<table style="width:100%;font-size:14px;color:#666666;">
<tr style="width:100%;">
<td style="width:50%;">Champion Name</td>
<td style="width:50%;">Support Amount</td>
</tr>
</table>

<table style="width:100%;">
<tr style="width:100%;">
<td style="width:100%;font-weight:bold;font-size:20px;"><div style="border-bottom:2px dotted #dedede;width:100%;float:left;"></div></td>
</tr>
</table>
<?php foreach($order_donation_summary as $tickets){ ?>
	<table style="width:100%;font-size:14px;color:#666666;">
	<tr style="width:100%;">
	<td style="width:50%;"><?php echo $tickets['display_name'];?></td>
	<td style="width:50%;">$<?php echo number_format($tickets['donation_amount'],2);?></td>
	</tr>
	</table>
<?php } ?>

<?php } ?>
<br>
<div style="color:#666666;">This order is subject to TicketingSystem <a href="http://local.ticketing_system.com/frontend/cms/terms" class="blue_anker">Terms & Conditions</a></div>
</div>
<img src="<?php echo $this->config->item('email_template_image_path')."/bottom_line.jpg";?>" style="max-width:100%;">

<table style="width:100%;">
<tr>
<td style="width:50%;">
<div style="font-weight:bold;font-size:20px;margin-bottom:10px;">About this event</div>
<div style="color:#666666;float:left;width:100%;">
<span style="float:left;width:6%;"><img src="<?php echo $this->config->item('email_template_image_path')."/time.png";?>" style="width:20px;margin-top:5px;"></span>

<?php
	$start_date =date("F jS, Y", strtotime($event_details['event_start_date']));
?>

<span style="float: left; width: 80%; margin-left: 5px; margin-top: 7px;"><?php echo  $start_date; ?> at <?php echo $event_details['event_start_time']; ?></span>
</div>
<div  style="margin-top:10px;float:left;width:100%;">
<span style="float:left;width:6%;">
	<img src="<?php echo $this->config->item('email_template_image_path')."/location.png";?>" style="width:20px;margin-top:5px;">
</span>
<span style="float:left;width:80%;margin-left: 5px; margin-top: 7px;color:#666666;"><?php echo $event_details['event_location'];?></span>
</div>
</td>
<td style="width:50%;">
	<!--<img src="<?php //echo $this->config->item('email_template_image_path')."/map.png";?>">-->
	<script src='https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyBK0eQ7Y2LugOD1v1S3n6emkWmRKdyoGqU'></script><div style='overflow:hidden;height:160px;width:240px;'><div id='gmap_canvas' style='height:160px;width:240px;;'></div><style>#gmap_canvas img{max-width:none!important;background:none!important}</style></div> <a href='https://addmap.net/'>&nbsp;</a><script type='text/javascript' src='https://embedmaps.com/google-maps-authorization/script.js?id=627f60b9c8c6beb35b24b566b10816eb40a57477'></script><script type='text/javascript'>function init_map(){var myOptions = {zoom:12,center:new google.maps.LatLng(<?php echo $event_details['event_location_latitude'];?>,<?php echo $event_details['event_location_longitude'];?>),mapTypeId: google.maps.MapTypeId.ROADMAP};map = new google.maps.Map(document.getElementById('gmap_canvas'), myOptions);marker = new google.maps.Marker({map: map,position: new google.maps.LatLng(<?php echo $event_details['event_location_latitude'];?>,<?php echo $event_details['event_location_longitude'];?>)});google.maps.event.addListener(marker, 'click', function(){infowindow.open(map,marker);});infowindow.open(map,marker);}google.maps.event.addDomListener(window, 'load', init_map);</script>
</td>
</tr>
</table>
</td>
</tr>
</table>

</div></div>

</body>
</html>















