
<?php if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/security/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/functions/functions.php';
// Duomenų gavimas iš duomenų bazės
$db = getDBConnection($config);
secureSession($db);

define('IS_ADMIN', true);

$settings = getSettings($db);
$languages = getAllLanguages($db);
$site_title = isset($settings['site_title']) ? $settings['site_title'] : '';
$footer_text = isset($settings['footer_text']) ? $settings['footer_text'] : '';
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $user_name = getUserNameById($db, $user_id);
    $translations = getTranslations($db, $language_code);

} else {
    header("Location: 404.php");
    exit;
}

if (!checkUserRole($user_id, 'admin', $db)) {
    header("Location: 404.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $site_title;?></title>
    <link href="<?php $_SERVER['DOCUMENT_ROOT']; ?>/assets/bootstrap-5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"> 
    <link rel="stylesheet" href="<?php $_SERVER['DOCUMENT_ROOT']; ?>/assets/font-awesome/6.1.0/css/all.min.css">
    <link href="<?php $_SERVER['DOCUMENT_ROOT']; ?>/core/tools/css/admin-style.css" rel="stylesheet">
    <link href="<?php $_SERVER['DOCUMENT_ROOT']; ?>/core/tools/css/admin-style-two.css" rel="stylesheet">
    <script src="<?php $_SERVER['DOCUMENT_ROOT']; ?>/assets/dist/js/jquery-3.6.0.min.js"></script>
     
</head>
<body>