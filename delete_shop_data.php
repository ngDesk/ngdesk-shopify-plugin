<?php

$webhook_payload = file_get_contents('php://input');
$webhook_payload = json_decode($webhook_payload, true);

$file = 'token.txt';
$token =  file_get_contents($file);
$shop_id = $webhook_payload['shop_id'];
$shop_domain = $webhook_payload['shop_domain'];

//Get shop data
$shopData shopify_call($token, $shop_id, "/admin/api/2019-10/shop/.json", array(), 'GET');
$shopData = json_decode($shopData['response'], JSON_PRETTY_PRINT);
$shop = $shopData['shop'];
$shopCustomerEmail = $shop['customer_email'];

//Get customer data
$customers = shopify_call($token, $shop_id, "/admin/api/2019-10/customers/.json", array() , 'GET');
$customers = json_decode($customers['response'], JSON_PRETTY_PRINT);

//Get product data
$products = shopify_call($token, $shop_id, "/admin/api/2019-10/products/.json", array() , 'GET');
$products = json_decode($products['response'], JSON_PRETTY_PRINT);

//Get order data
$orders = shopify_call($token, $shop_id, "/admin/api/2019-10/orders/.json", array() , 'GET');
$orders = json_decode($orders['response'], JSON_PRETTY_PRINT);

//Delete data
foreach($products as $currentProduct){
	foreach($currentProduct as $product) {
		$productId = $product['id'];
		shopify_call($token, $shop_id, "/admin/api/2019-10/products/" . $productId . ".json", array() , 'DELETE');
	}
}

foreach($customers as $currentCustomer) {
	foreach($currentCustomer as $customer) {
		if($customer['email'] === $shopCustomerEmail) {
			$customerId = $customer['id'];
			$customerOrderCount = $customer['orders_count'];
			if($customerOrderCount == 1) {
				$customerLastOrderId = $customer['last_order_id'];
				shopify_call($token, $shop_id, "/admin/api/2019-10/orders/" . $customerLastOrderId . ".json", array() , 'DELETE');
			} else if($customerOrderCount > 1) {
				foreach($orders as $currentOrder){
					foreach($currentOrder as $order) {
						$orderId = $order['id'];
						shopify_call($token, $shop_id, "/admin/api/2019-10/orders/" . $orderId . ".json", array() , 'DELETE');
					}
				}
			}
			shopify_call($token, $shop_id, "/admin/api/2019-10/customers/" . $customerId . ".json", array() , 'DELETE');
		} 
	}
}





