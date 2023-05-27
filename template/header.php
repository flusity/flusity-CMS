<?php 
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
  }
define('ROOT_PATH', realpath(dirname(__FILE__)) . '../../');
require_once ROOT_PATH . 'security/config.php';
require_once ROOT_PATH . 'core/functions/functions.php';
secureSession();
$db = null;

if (isset($config)) {
    $db = getDBConnection($config);
}
$settings = getSettings($db);

// Check if the keys exist in the array before using them
$site_title = isset($settings['site_title']) ? $settings['site_title'] : '';
$meta_description = isset($settings['meta_description']) ? $settings['meta_description'] : '';
$footer_text = isset($settings['footer_text']) ? $settings['footer_text'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
    <title><?php echo $site_title;?></title>
    <meta http-equiv="Content-Security-Policy" content="default-src 'self' gap:; script-src 'self' data: https://ssl.gstatic.com 'unsafe-eval'; object-src *; img-src 'self' data:; media-src 'self' data:;  style-src 'self' data: 'unsafe-inline'; font-src 'self' data:; connect-src *">
    <script src="assets/dist/js/jquery-3.6.0.min.js"></script>

    <link href="assets/bootstrap-5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="/assets/bootstrap-5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="assets/main/style.css" rel="stylesheet">
   
</head>
<body>