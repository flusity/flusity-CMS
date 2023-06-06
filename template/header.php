<?php 
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
  }
define('ROOT_PATH', realpath(dirname(__FILE__)) . '../../');
require_once ROOT_PATH . 'security/config.php';
require_once ROOT_PATH . 'core/functions/functions.php';

$db = null;
if (isset($config)) {
    $db = getDBConnection($config);
}

secureSession($db);

$settings = getSettings($db);
$site_title = isset($settings['site_title']) ? $settings['site_title'] : '';
$meta_default_description = isset($settings['meta_description']) ? $settings['meta_description'] : '';
$meta_default_keywords = isset($settings['default_keywords']) ? $settings['default_keywords'] : '';
$footer_text = isset($settings['footer_text']) ? $settings['footer_text'] : '';
$meta = [
    'description' => $meta_default_description,
    'keywords' => $meta_default_keywords,
];

if (!empty($postSeo)) {
    foreach ($postSeo as $postS) {
        if ($postS['priority'] == 1) {
        
            $meta['description'] = $postS['description'];
            $meta['keywords'] = $postS['keywords'];
            break;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $site_title;?></title>
    <meta name="description" content="<?= isset($meta['description']) ? $meta['description'] : '' ?>">
    <meta name="keywords" content="<?= isset($meta['keywords']) ? $meta['keywords'] : '' ?>">
    <meta http-equiv="Content-Security-Policy: script-src 'self' 'unsafe-inline' https://ssl.gstatic.com 'unsafe-eval'">
    <link href="assets/bootstrap-5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/fonts/fonts-quicksand.css" rel="stylesheet">
    <link href="assets/main/style.css" rel="stylesheet"> <!-- -->
   <style>
    .navbar-shrink {
        height: 80px;
        transition: height 0.5s ease;
    }
  </style>
</head>
<body>
