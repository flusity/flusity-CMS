<?php
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
      }
    define('IS_ADMIN', true);

    define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../') . '/');

    require_once ROOT_PATH . 'security/config.php';
    require_once ROOT_PATH . 'core/functions/functions.php';
    
    // Duomenų gavimas iš duomenų bazės
     $db = getDBConnection($config);
	secureSession($db, $prefix);
    $language_code = getLanguageSetting($db, $prefix);
    $translations = getTranslations($db, $prefix, $language_code);
    
    if (defined('IS_ADMIN') && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_place' && isset($_POST['place_id'])) {

        $placeId = intval($_POST['place_id']);
        $result = deletePlace($db, $prefix, $placeId);

        if ($result) {
            $_SESSION['success_message'] = t("Place successfully deleted.");
        } else {
            $_SESSION['error_message'] = t("Error deleting place. Try again.");
        }
    }
    echo json_encode($result);
    exit;
?>