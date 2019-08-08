<style>
	.red_span{color:red;}
</style>
<div class="content">
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
					<h2>View Order</h2>
				</div>
			</div>
			<!--ROW END-->
		</div>
    </div>
	<div class="kode-blog-style-2 search_table">
		<div class="container">
			<div class="row" style="margin-bottom:0px;">
				<div class="col-md-2 coms-sm-4 col-xs-6">
					<img class="img-responsive" src="<?php echo $this->config->item('email_template_image_path')."/logo.png";?>">
				</div>
			</div>

<table style="width:100%;">
	<tr style="background:#fff;">
		<td style="padding:20px;width:100%;color:#666666;">Hi <?php echo $order_info['first_name'];?> <?php echo $order_info['last_name'];?><br><br>
		Your order number #<?php echo $even_sub_events['order_id'];?> for <?php echo $event_details['title'];?> Organized by <?php echo $organizer_data->charity_name;?> has been confirmed<br>
		Please view the attachments in this email.
		<br><br>

Cheers! <br>
TicketingSystem
</td>
</tr>
</table>

<table style="width:100%;">
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
<?php } ?>-->

<div style="padding:10px;background:#dedede;float:left;width:100%;"></div>
<div style="color:#666666;float:left;font-size:13px;">Contact the organiser at <a href="mailto:<?php echo $organizer_email;?>" class="blue_anker"><?php echo $organizer_email;?></a>
</div>
<img src="<?php echo $this->config->item('email_template_image_path')."/top_line.jpg";?>" style="max-width:100%;">
<div class="col-md-12" style="padding:20px 30px;background:#ededed;">
<div class="table-responsive">
<table class="" style="width:100%;font-size:13px;color:#666666;">
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

</div>
<br>
<div style="color:#666666;">This order is subject to TicketingSystem <a href="https://local.ticketing_system.com/frontend/cms/terms" class="blue_anker">Terms & Conditions</a></div>
</div>
<img src="<?php echo $this->config->item('email_template_image_path')."/bottom_line.jpg";?>" style="max-width:100%;">

<table style="width:100%;">
<tr>
<td>
<div style="font-weight:bold;font-size:20px;margin-bottom:10px;">About this event</div>
<div style="color:#666666;float:left;width:100%;">
<span style="float:left;width:2%;"><img src="<?php echo $this->config->item('email_template_image_path')."/time.png";?>" style="width:20px;margin-top:5px;"></span>

<?php
	$start_date =date("F jS, Y", strtotime($event_details['event_start_date']));
?>

<span style="float: left; width: 80%; margin-left: 5px; margin-top: 5px;"><?php echo  $start_date; ?> at <?php echo $event_details['event_start_time']; ?></span>
</div>
<div  style="margin-top:10px;float:left;width:100%;">
<span style="float:left;width:2%;">
	<img src="<?php echo $this->config->item('email_template_image_path')."/location.png";?>" style="width:20px;margin-top:5px;">
</span>
<span style="float:left;width:80%;margin-left: 5px; margin-top: 5px;color:#666666;"><?php echo $event_details['event_location'];?></span>
</div>
</td>

</tr>
</table>
</td>
</tr>
</table>
<div class="row">
	<div class="col-sm-12"><?php echo form_error('to_email'); ?></div>
</div>
<?php if($this->session->flashdata('message')){ ?>
	<div class="row" id="success">
		<div class="col-md-12 col-sm-12 col-xs-12" id="spr" style="color: green;margin-bottom: 15px;">
			<?php echo $this->session->flashdata('message');?>
		</div>
	</div>
<?php } ?>
<div class="row">
	<div class="col-sm-12">
	   <button class="blue_box_title" type="button" style="padding: 9px 20px;margin-bottom:15px;" data-toggle="modal" data-target="#myModal">Resend Email</button>
	   <a href="<?php echo base_url(); ?>frontend/tickets/manage_ticket_booking" class="blue_box_title" type="button" style="padding: 9px 20px;margin-bottom:15px; margin-left: 10px">Back</a>
	</div>
</div>
</div></div>
 <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

      <div class="modal-content">
       <form action="<?php echo $this->config->item('base_url');?>frontend/manage_orders/resent_order_email" method="post">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Resend Email</h4>
        </div>

        <div class="modal-body modal-md">
			<div class="row">
				<div class="col-sm-4">
    				<label>Email</label><span class="red_span">*</span>
    			</div>
    			<div class="col-sm-6">
					<input type="email" id="to_email" name="to_email" class="search_events form-control" value="<?php echo $order_info['email']; ?>">
					<input type="hidden" name="order_id" id="order_id" value="<?php echo $even_sub_events['order_id'];?>">
					<span style="color:red" id="valiade_email"></span>
    			</div>
			</div>
        </div>
        <div class="modal-footer">
        	<button class="btn btn-default" type="submit" >Send</button>
        </div>
         </form>
      </div>
    </div>
  </div>



  <script type="text/javascript">
  	     $(document).on('submit','form',function(e){
  	    	  var email=$('#to_email').val();
  	    	  var pattern = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;

     if(email==''){
       $('#valiade_email').text('Please enter email address');
        e.preventDefault(e);
     }
	 if(!pattern.test(email))
     {

       $('#valiade_email').text('Please enter valid email address');
         e.preventDefault(e);

     }

    });


  	    $(document).on('keyup','#to_email',function(){
  	    	  $('#valiade_email').text('');

        });
  </script>














