<?php
/*
* Page Name: layout.php
* Purpose: Displays header- dynamic midsection - footer and all other common files
*/
?>
<!-- load session library -->
<?php
$this->load->library('session'); 
$this->load->helper('array');
?>
<!-- Load Header -->
<?php $this->load->view('backend/includes/header');?>
<!-- Load Dynamic View Page -->
<?php 
if($this->session->userdata('session_id') != "" )// if logged in
{
	$this->load->view('backend/'.$viewPage);
} 
else //if dynamic view is not supplied, load default page
{	
	$this->load->view('backend/home');
}?>
<!-- Load  Footer -->
<?php $this->load->view('backend/includes/footer');?>
