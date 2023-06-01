<?php 
if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/security/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/functions/functions.php';
secureSession();

define('IS_ADMIN', true);
// Duomenų gavimas iš duomenų bazės
$db = getDBConnection($config);
$settings = getSettings($db);
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $user_name = getUserNameById($db, $user_id);
    $translations = getTranslations($db, $language_code);

} else {
    header("Location: 404.php");
    exit;
}

if (!checkUserRole($user_id, 'admin', $db) && !checkUserRole($user_id, 'moderator', $db)) {
    header("Location: 404.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Index</title>
    <!--  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script> -->
    <link href="/assets/bootstrap-5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/font-awesome/6.1.0/css/all.min.css"> <script src="/assets/dist/js/jquery-3.6.0.min.js"></script>
    <script src="<?php $_SERVER['DOCUMENT_ROOT']; ?>/core/tools/js/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
    <link href="<?php $_SERVER['DOCUMENT_ROOT']; ?>/core/tools/css/admin-style.css" rel="stylesheet">
    <script src="/assets/bootstrap-5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="<?php $_SERVER['DOCUMENT_ROOT']; ?>/core/tools/css/admin-style-two.css" rel="stylesheet"> 
</head>
<body>
