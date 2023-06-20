<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

define('IS_ADMIN', true);
require_once $_SERVER['DOCUMENT_ROOT'] . '/security/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/functions/functions.php';

 $db = getDBConnection($config);
secureSession($db, $prefix);
$language_code = getLanguageSetting($db, $prefix);
$translations = getTranslations($db, $prefix, $language_code);

if (defined('IS_ADMIN') && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'uninstall_addon' && isset($_POST['addonName'])) {

    $addonName = $_POST['addonName'];
    $result = uninstallAddon($db, $prefix, $addonName);
    $response = array();
    if ($result) {
        $_SESSION['success_message'] = t("Addon successfully uninstalled.");
        $response['success'] = 'true';
    } else {
        $_SESSION['error_message'] = t("Error uninstalling addon. Try again.");
        $response['success'] = 'false';
    }
    echo json_encode($response);
    exit;
}
