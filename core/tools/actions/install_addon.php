<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
   // var_dump($_POST);
}

define('IS_ADMIN', true);
require_once $_SERVER['DOCUMENT_ROOT'] . '/security/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/functions/functions.php';
$configurations = require $_SERVER['DOCUMENT_ROOT'] . '/security/config.php';

$prefix = $configurations['prefix'];

 $db = getDBConnection($config);
secureSession($db, $prefix);
$language_code = getLanguageSetting($db, $prefix);
$translations = getTranslations($db, $prefix, $language_code);


if (defined('IS_ADMIN') && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'install_addon' && isset($_POST['addon'])) {
    $addonName = $_POST['addon'];
    $result = installAddon($db, $prefix, $addonName);

    $response = array();
    if ($result) {
        $_SESSION['success_message'] = t('Addon successfully installed.');
        $response['status'] = 'true';
    } else {
        $_SESSION['error_message'] = t('Error installing addon. Try again.');
        $response['status'] = 'false';
    }
    echo json_encode($response);
    exit;
}
