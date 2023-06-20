<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

define('IS_ADMIN', true);
require_once $_SERVER['DOCUMENT_ROOT'] . '/security/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/functions/functions.php';
define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'] . '/');

 $db = getDBConnection($config);
secureSession($db, $prefix);
$language_code = getLanguageSetting($db, $prefix);
$translations = getTranslations($db, $prefix, $language_code);

if (isset($_POST['addon_name'], $_POST['show_front'])) { 
    $addon_name = $_POST['addon_name'];
    $show_front = $_POST['show_front'];
    

  $updateResult = updateAddonShowFront($db, $prefix, $addon_name, $show_front);

    if ($updateResult) {
        $_SESSION['success_message'] =  t('Addon display status successfully updated.');
    } else {
        $_SESSION['error_message'] = t('Error updating addon display status. Try again.');
    }
 } else {
    $_SESSION['error_message'] = t('Invalid POST parameters.');
 }

echo json_encode($updateResult);
?>
