
<?php
require_once("inc/functions.php");

$shop_param = $_GET['shop']; // Retrieve SHOP request parameter
$token_param = $_GET['token']; // Retrieve SHOP request parameter
$base_url = "https://".$_SERVER['HTTP_HOST']."/shopifyapps/ngdesk/";
$shop = explode(".myshopify.com",$shop_param)[0];
?>


<script type="text/javascript">
var token_param = "<?php echo $token_param; ?>";
if(token_param !== "") {
	sessionStorage.setItem("token", "<?php echo $token_param; ?>");
	window.location.href = '<?php echo $base_url; ?>appindex.php?shop=<?php echo $shop; ?>.myshopify.com&token=' + token_param;
} else {
	var token = sessionStorage.getItem("token");
	window.location.href = '<?php echo $base_url; ?>appindex.php?shop=<?php echo $shop; ?>.myshopify.com&token=' + token;
}
</script>
