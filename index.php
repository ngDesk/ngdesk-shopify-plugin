
<?php
require_once("inc/functions.php");

$shop_param = $_GET['shop']; // Retrieve SHOP request parameter
$is_token_set = $_GET['token']; // Retrieve SHOP request parameter
$base_url = "https://".$_SERVER['HTTP_HOST']."/shopifyapps/ngdesk/";
$shop = explode(".myshopify.com",$shop_param)[0];
$file = 'token.txt';
$access_token =  file_get_contents($file);
?>


<script type="text/javascript">
var is_token_set = "<?php echo $is_token_set; ?>";
if(is_token_set !== "") {
	sessionStorage.setItem("token", "<?php echo $access_token; ?>");
	window.location.href = '<?php echo $base_url; ?>appindex.php?shop=<?php echo $shop; ?>.myshopify.com';
} else {
	var token = sessionStorage.getItem("token");
	if(token !== null)
	{
		window.location.href = '<?php echo $base_url; ?>appindex.php?shop=<?php echo $shop; ?>.myshopify.com';
	} else {
		window.location.href = '<?php echo $base_url; ?>install.php?shop=<?php echo $shop; ?>';
	}	
}
</script>
