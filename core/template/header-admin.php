<?php if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/security/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/functions/functions.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/core/classes/sidebar_class.php';

$configurations = require $_SERVER['DOCUMENT_ROOT'] . '/security/config.php';
$prefix = $configurations['prefix'];
$config = $configurations['config'];

 $db = getDBConnection($config);
secureSession($db, $prefix);

define('IS_ADMIN', true);

$settings = getSettings($db, $prefix);
$languages = getAllLanguages($db, $prefix);
$site_title = isset($settings['site_title']) ? $settings['site_title'] : '';
$footer_text = isset($settings['footer_text']) ? $settings['footer_text'] : '';
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $user_name = getUserNameById($db, $prefix, $user_id);
    
    $language_code = getLanguageSetting($db, $prefix);
    $translations = getTranslations($db, $prefix, $language_code);

} else {
    header("Location: 404.php");
    exit;
}

if (!checkUserRole($user_id, 'admin', $db, $prefix)) {
    header("Location: 404.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $site_title;?></title>
    <link href="/assets/bootstrap-5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"> 
    <link rel="stylesheet" href="<?php $_SERVER['DOCUMENT_ROOT']; ?>/assets/font-awesome/6.1.0/css/all.min.css">
    <link href='/core/tools/css/font-raleway.css' rel='stylesheet'>
    <link href="/core/tools/css/admin-style.css" rel="stylesheet">
    <link href="/core/tools/css/admin-style-two.css" rel="stylesheet">
    <script src="/assets/dist/js/jquery-3.6.0.min.js"></script>  
    <script src="/core/tools/js/admin-post-edit.js"></script> 
    <script src="/core/tools/js/admin-customblock-edit.js"></script>  
<!--     <link type="text/css" href="/assets/ckeditor/sample/css/sample.css" rel="stylesheet" media="screen" /> -->
</head>
<body>