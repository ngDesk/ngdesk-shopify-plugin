<?php

$webhook_payload = file_get_contents('php://input');
$webhook_payload = json_decode($webhook_payload, true);

$file = 'token.txt';
$token =  file_get_contents($file);
$shop_id = $webhook_payload['shop_id'];
$shop_domain = $webhook_payload['shop_domain'];
$customer_id = $webhook_payload['customer']['id'];
$orders_requested = $webhook_payload['orders_requested'];

//Delete customer data
$customerData = shopify_call($token, $shop_id, "/admin/api/2019-10/customers/" . $customer_id . ".json", array() , 'GET');
$customerData = json_decode($customerData['response'], JSON_PRETTY_PRINT);
$customer = $customerData['customer'];
$customerOrderCount = $customer['orders_count'];
if($customerOrderCount > 0 ) {
	foreach($orders_requested as $orderId) {
		shopify_call($token, $shop_id, "/admin/api/2019-10/orders/" . $orderId . ".json", array() , 'DELETE');
	}
}
shopify_call($token, $shop_id, "/admin/api/2019-10/customers/" . $customer_id . ".json", array() , 'DELETE');
