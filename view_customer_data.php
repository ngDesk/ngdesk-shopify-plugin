<?php

$webhook_payload = file_get_contents('php://input');
$webhook_payload = json_decode($webhook_payload, true);

$file = 'token.txt';
$token =  file_get_contents($file);
$shop_id = $webhook_payload['shop_id'];
$shop_domain = $webhook_payload['shop_domain'];
$customer_id = $webhook_payload['customer']['id'];

//Send customer data to shop owner
$customerData = shopify_call($token, $shop_id, "/admin/api/2019-10/customers/". $customer_id . ".json", array() , 'GET');
$customerData = json_decode($customerData['response'], JSON_PRETTY_PRINT);

$shopData shopify_call($token, $shop_id, "/admin/api/2019-10/shop/.json", array() , 'GET');
$shopData = json_decode($shopData['response'], JSON_PRETTY_PRINT);
$shop = $shopData['shop'];
$shopEmail = $shop['email'];

$subject = "Details of customer";
         
$header = "From:support@shopify.com \r\n";
$header .= "MIME-Version: 1.0\r\n";
$header .= "Content-type: text/html\r\n";
         
mail($shopEmail,$subject,$customerData,$header);
