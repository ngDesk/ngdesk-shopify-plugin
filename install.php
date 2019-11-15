<?php
require_once("conf.php");

// Set variables for our request
$shop = $_GET['shop'];
$api_key = NGDESK_SHOPIFY_APP_API_KEY;
$scopes = "read_orders,write_products,write_script_tags";
$config['base_url'] = "https://".$_SERVER['HTTP_HOST']."/shopifyapps/ngdesk";
$redirect_uri = $config['base_url'].'/generate_token.php';

// Build install/approval URL to redirect to
$install_url = "https://" . $shop . ".myshopify.com/admin/oauth/authorize?client_id=" . $api_key . "&scope=" . $scopes . "&redirect_uri=" . urlencode($redirect_uri);

// Redirect
header("Location: " . $install_url);
die();