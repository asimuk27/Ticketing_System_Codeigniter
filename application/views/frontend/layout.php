<?php
/*
* Page Name: layout.php
* Purpose: Displays header- dynamic midsection - footer and all other common files
*/
?>
<?php
$this->load->library('session'); 
$this->load->helper('array');
$this->load->view('frontend/includes/header');
?>
<!-- Load Dynamic View Page -->
<?php 
if($this->session->userdata('session_id') != "" )// if logged in
{
	$this->load->view('frontend/'.$viewPage);
} 
else //if dynamic view is not supplied, load default page
{	
	$this->load->view('frontend/home');
}?>
<!-- Load  Footer -->
<?php $this->load->view('frontend/includes/footer');?>
