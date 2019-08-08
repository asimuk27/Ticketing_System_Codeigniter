<?php
$token = $_POST["Token"];
if(is_null($token)) {
	$token = $_GET["token"];
}
 
 $auth = base64_encode('SS64005103:Poli#Ahura$$16');
 $header = array();
 $header[] = 'Authorization: Basic '.$auth;
 
 $ch = curl_init("https://poliapi.apac.paywithpoli.com/api/Transaction/GetTransaction?token=".urlencode($token));
 //See the cURL documentation for more information: http://curl.haxx.se/docs/sslcerts.html
 //We recommend using this bundle: https://raw.githubusercontent.com/bagder/ca-bundle/master/ca-bundle.crt
 curl_setopt( $ch, CURLOPT_CAINFO, "ca-bundle.crt");
 curl_setopt( $ch, CURLOPT_SSLVERSION, 6);
 curl_setopt( $ch, CURLOPT_HTTPHEADER, $header);
 curl_setopt( $ch, CURLOPT_HEADER, 0);
 curl_setopt( $ch, CURLOPT_POST, 0);
 curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 0);
 curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
 $response = curl_exec( $ch );
 curl_close ($ch);
 
 $json = json_decode($response, true);
 
 echo "<pre>";
 print_r($json);
?>

