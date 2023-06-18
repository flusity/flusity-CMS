<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

define('IS_ADMIN', true);
require_once $_SERVER['DOCUMENT_ROOT'] . '/security/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/functions/functions.php';
define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'] . '/');

$db = getDBConnection($config);
secureSession($db);
$language_code = getLanguageSetting($db);
$translations = getTranslations($db, $language_code);

$result = ['error_message' => false];

if (isset($_POST['addon_name'], $_POST['show_front'])) { 
    $addon_name = $_POST['addon_name'];
    $show_front = $_POST['show_front'];
    
    $updateResult = updateAddonShowFront($db, $addon_name, $show_front); // Čia naudojama funkcija, kurią aprašėme ankstesniame komentare

    if ($updateResult) {
        $result['success_message'] =  t('Addon display status successfully updated.');
    } else {
        $result['error_message'] = t('Error updating addon display status. Try again.');
    }
 } else {
    $result['error_message'] = t('Invalid POST parameters.');
 }

echo json_encode($result);

?>
