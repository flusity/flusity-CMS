<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
define('IS_ADMIN', true);

define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../') . '/');
$configurations = require $_SERVER['DOCUMENT_ROOT'] . '/security/config.php';

// Čia jūs gaunate $config ir $prefix kintamuosius
$config = $configurations['config'];
$prefix = $configurations['prefix'];

require_once ROOT_PATH . 'core/functions/functions.php';

$db = getDBConnection($config);
secureSession($db, $prefix);
$language_code = getLanguageSetting($db, $prefix);
$translations = getTranslations($db, $prefix, $language_code);

if (defined('IS_ADMIN') && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_place' && isset($_POST['place_id']) && isset($_POST['place_name'])) {
    $placeId = $_POST['place_id'];
    $placeName = $_POST['place_name'];
    $result = updatePlace($db, $prefix, $placeId, $placeName);

    $response = array();
    if ($result === 'Place updated successfully') {
        $_SESSION['success_message'] = t('Place successfully updated.');
    } elseif ($result === 'Place already exists') {
        $_SESSION['error_message'] = t('Place with this name already exists. Try a different name.');
    } else {
        $_SESSION['error_message'] = t('Error updating place. Try again.');
    }
    echo json_encode($response);
    exit;
}
