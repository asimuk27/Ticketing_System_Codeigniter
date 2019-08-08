<?php
$json_builder = '{
  "LinkType":"0",
  "Amount":"110.2",
  "CurrencyCode":"AUD",
  "MerchantData":"CustomerRef12345",
  "MerchantReference":"CustomerRef12345",
  "ConfirmationEmail":"false",
  "AllowCustomerReference":"false",
  "ViaEmail":"false",
  "RecipientName":"false",
  "LinkExpiry":"2020-10-24 16:00:00+11",
  "RecipientEmail":"false"
}';
 
 $auth = base64_encode("SS64005103:Poli#Ahura$$16");
 $header = array();
 $header[] = 'Content-Type: application/json';
 $header[] = 'Authorization: Basic '.$auth;
 
 $ch = curl_init("https://poliapi.apac.paywithpoli.com/api/POLiLink/Create");
 //See the cURL documentation for more information: http://curl.haxx.se/docs/sslcerts.html
 //We recommend using this bundle: https://raw.githubusercontent.com/bagder/ca-bundle/master/ca-bundle.crt
 curl_setopt( $ch, CURLOPT_CAINFO, "ca-bundle.crt");
 curl_setopt( $ch, CURLOPT_SSLVERSION, 6);
 curl_setopt( $ch, CURLOPT_HTTPHEADER, $header);
 curl_setopt( $ch, CURLOPT_HEADER, 0);
 curl_setopt( $ch, CURLOPT_POST, 1);
 curl_setopt( $ch, CURLOPT_POSTFIELDS, $json_builder);
 curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 0);
 curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
 $response = curl_exec( $ch );
 curl_close ($ch);
 
 $json = json_decode($response, true);
 
 print_r($json);
?>

