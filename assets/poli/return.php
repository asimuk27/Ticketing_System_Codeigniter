<?php
	$token = $_POST["Token"];
	if(is_null($token)) {
		$token = $_GET["token"];
	}
 
	echo "<pre>";
	print_r($token);
?>

