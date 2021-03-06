
<?php
require_once("inc/functions.php");

$shop_param = $_GET['shop']; // Retrieve SHOP request parameter	
//$token_param = $_GET['token']; // Retrieve SHOP request parameter
$config['base_url'] = 'https://'.$_SERVER['HTTP_HOST'].'/shopifyapps/ngdesk';
$file = 'token.txt';
$token =  file_get_contents($file);

/*if($token_param != null || $token_param != '') {
$token = $token_param;
}*/
$shop = explode(".myshopify.com",$shop_param)[0];
//Adding script tag
$script_array = array(
			'script_tag' => array(
					'event' => 'onload', 
					'src' => $config['base_url'].'/js/script.js'
				)
			);
			

//$scriptTag = shopify_call($token, $shop, "/admin/api/2020-01/script_tags/108103204918.json", $script_array, 'DELETE');
$scriptTagCount = shopify_call($token, $shop, "/admin/api/2020-01/script_tags/count.json", $script_array, 'GET');
$scriptTagCount = json_decode($scriptTagCount['response'], JSON_PRETTY_PRINT);
$scriptPresent = false;
if($scriptTagCount['count'] > 0) {
	$scriptTag = shopify_call($token, $shop, "/admin/api/2020-01/script_tags.json", $script_array, 'GET');
	$scriptTag = json_decode($scriptTag['response'], JSON_PRETTY_PRINT);

	foreach($scriptTag as $cur_script) {
		foreach($cur_script as $value) {
			if($value['src'] === $config['base_url'].'/js/script.js') {
				$scriptPresent = true;
			}
		}
	}
	if($scriptPresent === false) {
		$scriptTag = shopify_call($token, $shop, "/admin/api/2020-01/script_tags.json", $script_array, 'POST');
		$scriptTag = json_decode($scriptTag['response'], JSON_PRETTY_PRINT);
	}
} else {
	$scriptTag = shopify_call($token, $shop, "/admin/api/2020-01/script_tags.json", $script_array, 'POST');
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
$metafieldCount = shopify_call($token, $shop, "/admin/api/2020-01/metafields/count.json", $field_array, 'GET');
$metafieldCount = json_decode($metafieldCount['response'], JSON_PRETTY_PRINT);

if($metafieldCount['count'] > 0) {
	$metafield = shopify_call($token, $shop, "/admin/api/2020-01/metafields.json", $field_array, 'GET');
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
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
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
	<div class="modal fade" id="myModal" role="dialog">
		<div class="modal-dialog">
		  <div class="modal-content">
			<div class="modal-header">
			<h4 class="modal-title" style="float:left;">Setup instructions: </h4>
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<ul>
					<li>If you don't have an account on ngDesk, <a href="https://signup.ngdesk.com/landing-pages/signup" target="new">create one for free!</a></li>
					<li>Login with your credentials and navigate to 
					Company Settings 
					<span class="glyphicon glyphicon-arrow-right"></span> 
					Plugins
					<span class="glyphicon glyphicon-arrow-right"></span> 
					Shopify
					</li>
					<li>Use the highlighted subdomain and widget Id to enter under shopify ngDesk app and click on save.</li>
					<li>Go to shopify home page of your shop and reload. A chat widget will appear on the bottom-right corner.</li>
					<strong>
						Still having trouble and need some help? Check out our <a href="https://support.ngdesk.com/guide" target="new">Knowledge Base</a>
					</strong>
				</ul>
			</div>
			<div class="modal-footer">
			  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		  </div>
		</div>
	</div>
  
	<div class="well" style="width:45%; margin-left:25%; margin-right:25%; border:inset; padding: 20px;margin-top:15px;background-color: white;">
			<div style="display: inline-flex;">
				<img style="width: 60px; height: 60px;" src="assets/ngdesk-logo.png">
				<h3 style="text-align: center;margin-left:20px;margin-top:20px;">ngDesk Settings</h3>
			</div>
			<hr>
			<form role="form" method="Post">
				<div class="form-group" style="display: inline-flex; width: 100%; margin-top: 10px; align-items: baseline;">
				
					<p style="text-align: left; width: 25%">Subdomain:</p>
					<input name="subdomain" id="subdomain" class="form-control" type="text"   style="height:30px; width:250px;"  value="<?php echo $currentSubdomain; ?>" placeholder="Enter your Subdomain" />
				</div>
				<div class="form-group" style="display: inline-flex; width: 100%; align-items: baseline;">
					<p style="text-align: left;  width: 25%;">Chat Widget Id:</p>
					<input name="widgetId" id="widgetId" class="form-control" type="text"  style="height:30px; width:250px;" value="<?php echo $currentWidgetId; ?>" placeholder="Enter your Widget Id" />
				</div>
				<div style=" text-align: center;">
					<button  type="submit" class="btn btn-success" formaction="savewidget.php?shop=<?php echo $shop; ?>&action=add" style="margin-top: 10px;width:160px;background-color:white;color:#5cb85c;">Add widget</button>
					<button  type="submit" class="btn btn-danger" formaction="savewidget.php?shop=<?php echo $shop; ?>&action=remove" style="width:160px;margin-top: 10px;margin-left:10%;background-color:white;color:#d9534f;">Remove widget</button>
				</div>
				<hr>
				<div class="form-group" style="margin-top: 20px">
					For setup instructions <a href="#" data-toggle="modal" data-target="#myModal">click here!</a></br>
					Connect to your ngDesk account!
					 <div class="btn-group">
						<button class="btn btn-default"><a href="https://signup.ngdesk.com/landing-pages/signup" target="new">Sign Up</a></button>
						<button class="btn btn-default"><a href="https://prod.ngdesk.com/login-support" target="new">Log in</a></button>
					 </div>
					</br>
				</div>
			</form>
		</div>
	</body>
	
</html>
	
