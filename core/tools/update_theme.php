<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

define('IS_ADMIN', true);

define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../') . '/');

require_once ROOT_PATH . 'security/config.php';
require_once ROOT_PATH . 'core/functions/functions.php';

 $db = getDBConnection($config);
secureSession($db, $prefix);
$language_code = getLanguageSetting($db, $prefix);
$translations = getTranslations($db, $prefix, $language_code);

if (defined('IS_ADMIN') && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'install_theme' && isset($_POST['theme'])) {
    $themeName = $_POST['theme'];
    $result = updateThemeSetting($db, $prefix, $themeName);
    
    $response = array();
    if ($result) {
        $_SESSION['success_message'] = t('Theme installed successfully.');
        $response['status'] = 'success';
    } else {
        $_SESSION['error_message'] = t('There was an error installing the theme. Please try again.');
        $response['status'] = 'error';
    }
    echo json_encode($response);
    exit;
}