<?php
require_once("inc/functions.php");
require_once("conf.php");

$shop = $_GET['shop']; // Retrieve SHOP request parameter
//$token = $_GET['token']; // Retrieve SHOP request parameter

$file = 'token.txt';
$token =  file_get_contents($file);
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
						title : 'Enter widget details',
						buttons : {
							primary: [{
								label  : 'Back',
								href   : 'appindex.php?shop=<?php echo $shop; ?>',
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
					<li>Note down your subdomain entered while signing up to ngDesk.</li>
					<li>Login with your credentials and navigate to Modules from side bar.</li>
					<li>
						Go to Chats 
						<span class="glyphicon glyphicon-arrow-right"></span> 
						Channel
						<span class="glyphicon glyphicon-arrow-right"></span>
						Chat
						<span class="glyphicon glyphicon-arrow-right"></span>
						Setup Tab
					</li>
					<li>Note down the widgetId mentioned against script src. (Refer screenshots)</li>
					<li>Under shopify ngDesk app, enter subdomain (use the subdomain, you used while signing up)</li>
					<li>Enter widgetId (use the widgetId mentioned under script) and click on save.</li>
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
	<div style="width:45%; margin-left:25%; margin-right:25%; border:inset; padding: 20px;margin-top:15px;">
			<div style="display: inline-flex;">
				<img style="width: 60px; height: 60px;" src="assets/ngdesk-logo.png">
				<h3 style="text-align: center;margin-left:20px;margin-top:20px;">ngDesk Settings</h3>
			</div>
			<hr>
			<form role="form" method="Post" action="savewidget.php?shop=<?php echo $shop; ?>">
				<div class="form-group" style="display: inline-flex; width: 100%; margin-top: 10px; align-items: baseline;">
				
					<p style="text-align: left; width: 25%">Subdomain:</p>
					<input name="subdomain" id="subdomain" class="form-control" type="text"   style="height:30px; width:250px;" value="<?php echo $subdomain; ?>" placeholder="Enter your Subdomain" />
				</div>
				<div class="form-group" style="display: inline-flex; width: 100%; align-items: baseline;">
					<p style="text-align: left;  width: 25%;">Chat Widget Id:</p>
					<input name="widgetId" id="widgetId" class="form-control" type="text"  style="height:30px; width:250px;" value="<?php echo $widgetId; ?>" placeholder="Enter your Widget Id" />
				</div>
				<div style=" text-align: center;">
					<button  type="submit" style="background: #03A84E; color: #fff; height:40px; width:160px;margin-top: 10px;">Save widget</button>
				</div>
				<div class="form-group" style="margin-top: 20px">
					For setup instructions <a href="#" data-toggle="modal" data-target="#myModal">click here!</a></br>
					Don't have a ngDesk account? <a href="https://signup.ngdesk.com/landing-pages/signup" target="new">Create one for free here!</a></br>
				</div>
			</form>
		</div>
	</body>
</html>
