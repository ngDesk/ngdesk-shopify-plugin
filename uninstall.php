<?php
  
  $shop = $_GET['shop'];
  $revoke_url   = "https://" . $shop . ".myshopify.com/admin/api_permissions/current.json";
  $base_url = 'https://'.$_SERVER['HTTP_HOST'].'/shopifyapps/ngdesk';
  $file = 'token.txt';
  $access_token =  file_get_contents($file);
  
  file_put_contents($file, '');
  
  $headers = array(
    "Content-Type: application/json",
    "Accept: application/json",
    "Content-Length: 0",
    "X-Shopify-Access-Token: " . $access_token
  );
  $handler = curl_init($revoke_url);
  curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "DELETE");
  curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($handler, CURLOPT_HTTPHEADER, $headers);

  curl_exec($handler);
  if(!curl_errno($handler))
  {
    $info = curl_getinfo($handler);
    // $info['http_code'] == 200 for success
  }

  curl_close($handler);
  header("Location: https://" . $shop . ".myshopify.com/admin/apps");
?>
