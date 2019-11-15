
<?php
require_once("inc/functions.php");

$shop_param = $_GET['shop']; // Retrieve SHOP request parameter	
$token_param = $_GET['token']; // Retrieve SHOP request parameter
$config['base_url'] = 'https://'.$_SERVER['HTTP_HOST'].'/shopifyapps/ngdesk';

if($token_param != null || $token_param != '') {
$token = $token_param;
}
$shop = explode(".myshopify.com",$shop_param)[0];

//Adding script tag
$script_array = array(
			'script_tag' => array(
					'event' => 'onload', 
					'src' => $config['base_url'].'/js/script.js'
				)
			);
			

//$scriptTag = shopify_call($token, $shop, "/admin/api/2019-10/script_tags/108103204918.json", $script_array, 'DELETE');
$scriptTagCount = shopify_call($token, $shop, "/admin/api/2019-10/script_tags/count.json", $script_array, 'GET');
$scriptTagCount = json_decode($scriptTagCount['response'], JSON_PRETTY_PRINT);
$scriptPresent = false;
if($scriptTagCount['count'] > 0) {
	$scriptTag = shopify_call($token, $shop, "/admin/api/2019-10/script_tags.json", $script_array, 'GET');
	$scriptTag = json_decode($scriptTag['response'], JSON_PRETTY_PRINT);

	foreach($scriptTag as $cur_script) {
		foreach($cur_script as $value) {
			if($value['src'] === $config['base_url'].'/js/script.js') {
				$scriptPresent = true;
			}
		}
	}
	if($scriptPresent === false) {
		$scriptTag = shopify_call($token, $shop, "/admin/api/2019-10/script_tags.json", $script_array, 'POST');
		$scriptTag = json_decode($scriptTag['response'], JSON_PRETTY_PRINT);
	}
} else {
	$scriptTag = shopify_call($token, $shop, "/admin/api/2019-10/script_tags.json", $script_array, 'POST');
	$scriptTag = json_decode($scriptTag['response'], JSON_PRETTY_PRINT);
}


//Getting meta fields
$field_array = array(
			'metafield' => array(
					 "namespace" => "ngdesk",
					 "key" => "",
					 "value" => "",
					 "value_type" => "string"
				)
				
			);
$metafieldCount = shopify_call($token, $shop, "/admin/api/2019-10/metafields/count.json", $field_array, 'GET');
$metafieldCount = json_decode($metafieldCount['response'], JSON_PRETTY_PRINT);

if($metafieldCount['count'] > 0) {
	$metafield = shopify_call($token, $shop, "/admin/api/2019-10/metafields.json", $field_array, 'GET');
	$metafield = json_decode($metafield['response'], JSON_PRETTY_PRINT);

	foreach($metafield as $cur_metafield) {
		foreach($cur_metafield as $value) {
			if($value['key'] === 'subdomain') {
				$currentSubdomain = $value['value'];
			}
			if($value['key'] === 'widgetId') {
				$currentWidgetId = $value['value'];
			}
		}
	}
} 

?>

<html>
	<head>
		<link href="css/bootstrap.min.css" rel="stylesheet" />
		<script src="https://cdn.shopify.com/s/assets/external/app.js"></script>
		<script type="text/javascript" src="js/jquery-1.11.0.min.js"></script>
		<script type="text/javascript">
		$(document).ready(function(){
				
				ShopifyApp.init({
					apiKey : '5a57e032dc260da0e683d01167654f3f',
					shopOrigin : 'https://<?php echo $shop; ?>.myshopify.com',
					forceRedirect : true,
					debug : true
				});
				ShopifyApp.ready(function() {
					ShopifyApp.Bar.initialize({
						title : 'Enter widget details'
					});
				});
		});
	</script>
	</head>
	<body>
	<div style="width:45%; margin-left:25%; margin-right:25%; border:inset; padding: 20px;margin-top:15px;">
			<div style="display: inline-flex;">
				<img style="width: 60px; height: 60px;" src="assets/ngdesk-logo.png">
				<h3 style="text-align: center;margin-left:20px;margin-top:20px;">ngDesk Settings</h3>
			</div>
			<hr>
			<form role="form" method="Post" action="savewidget.php?shop=<?php echo $shop; ?>&token=<?php echo $token; ?>">
				<div class="form-group" style="display: inline-flex; width: 100%; align-items: baseline;">
				
					<p style="text-align: left; width: 25%">Subdomain:</p>
					<input name="subdomain" id="subdomain" class="form-control" type="text"   style="height:30px; width:250px;"  value="<?php echo $currentSubdomain; ?>" placeholder="Enter your Subdomain" />
				</div>
				<div class="form-group" style="display: inline-flex; width: 100%; align-items: baseline;">
					<p style="text-align: left;  width: 25%;">Chat Widget Id:</p>
					<input name="widgetId" id="widgetId" class="form-control" type="text"  style="height:30px; width:250px;" value="<?php echo $currentWidgetId; ?>" placeholder="Enter your Widget Id" />
				</div>
				<div style=" text-align: center;">
					<button  type="submit" style="background: #03A84E; color: #fff; height:40px; width:160px;">Save widget</button>
				</div>
				<div class="form-group" style="margin-top: 40px">
					Having trouble and need some help? Check out our <a href="https://support.ngdesk.com/guide">Knowledge Base</a>.	
				</div>
			</form>
			
			
		</div>
	</body>
	
</html>
	