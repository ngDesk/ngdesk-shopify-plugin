<?php
require_once("inc/functions.php");
require_once("conf.php");

$shop = $_GET['shop']; // Retrieve SHOP request parameter
$token = $_GET['token']; // Retrieve SHOP request parameter

$subdomain = $_POST['subdomain'];
$widgetId = $_POST['widgetId'];

$field_array1 = array(
			'metafield' => array(
					 "namespace" => "ngdesk",
					 "key" => "subdomain",
					 "value" => $subdomain,
					 "value_type" => "string"
				)
				
			);
$field_array2 = array(
			'metafield' => array(
					 "namespace" => "ngdesk",
					 "key" => "widgetId",
					 "value" => $widgetId,
					 "value_type" => "string"
				)
				
			);			
shopify_call($token, $shop, "/admin/api/2019-10/metafields.json", $field_array1, 'POST');			
shopify_call($token, $shop, "/admin/api/2019-10/metafields.json", $field_array2, 'POST');
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
						title : 'Enter widget details',
						buttons : {
							primary: [{
								label  : 'Back',
								href   : 'appindex.php?shop=<?php echo $shop; ?>&token=<?php echo $token; ?>',
								target : 'app'
							}]
						}
					});
				});
				if($('#subdomain').val !== null && $('#widgetId').val !== null)
				ShopifyApp.flashNotice("Settings saved successfully!!");
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
					<input name="subdomain" id="subdomain" class="form-control" type="text"   style="height:30px; width:250px;" value="<?php echo $subdomain; ?>" placeholder="Enter your Subdomain" />
				</div>
				<div class="form-group" style="display: inline-flex; width: 100%; align-items: baseline;">
					<p style="text-align: left;  width: 25%;">Chat Widget Id:</p>
					<input name="widgetId" id="widgetId" class="form-control" type="text"  style="height:30px; width:250px;" value="<?php echo $widgetId; ?>" placeholder="Enter your Widget Id" />
				</div>
				<div style=" text-align: center;">
					<button  type="submit" style="background: #03A84E; color: #fff; height:40px; width:160px;">Save widget</button>
				</div>
				<div class="form-group" style="margin-top: 40px">
					Having trouble and need some help? Check out our <a href="https://support.ngdesk.com/guide" target="new">Knowledge Base</a>.	
				</div>
			</form>
			
			
		</div>
	</body>
	
</html>
