<?php
$json_builder = '{
  "Amount":"110.2",
  "CurrencyCode":"NZD",
  "MerchantReference":"DPA",
  "MerchantHomepageURL":"http://infidigi.com/event_management_live/poli/return.php",
  "SuccessURL":"http://infidigi.com/event_management_live/poli/return.php",
  "FailureURL":"http://infidigi.com/event_management_live/poli/return.php",
  "CancellationURL":"http://infidigi.com/event_management_live/poli/return.php",
  "NotificationURL":"http://infidigi.com/event_management_live/poli/return.php" 
}';
 
 $auth = base64_encode('SS64005103:Poli#Ahura$$16');
 $header = array();
 $header[] = 'Content-Type: application/json';
 $header[] = 'Authorization: Basic '.$auth;
 
 $ch = curl_init("https://poliapi.apac.paywithpoli.com/api/Transaction/Initiate");
 //See the cURL documentation for more information: http://curl.haxx.se/docs/sslcerts.html
 //We recommend using this bundle: https://raw.githubusercontent.com/bagder/ca-bundle/master/ca-bundle.crt
 curl_setopt( $ch, CURLOPT_CAINFO, "ca-bundle.crt");
 curl_setopt( $ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
 curl_setopt( $ch, CURLOPT_HTTPHEADER, $header);
 curl_setopt( $ch, CURLOPT_HEADER, 0);
 curl_setopt( $ch, CURLOPT_POST, 1);
 curl_setopt( $ch, CURLOPT_POSTFIELDS, $json_builder);
 curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 0);
 curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
 $response = curl_exec( $ch );
 curl_close ($ch);
 
 $json = json_decode($response, true);
 
 if(!empty($json)){
	header('Location: '.$json["NavigateURL"]);
 }else{
	print_r($json);
 }

?>

