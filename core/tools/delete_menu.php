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
	secureSession($db);
    // Gaunamas kalbos nustatymas iš duomenų bazės  
    $language_code = getLanguageSetting($db);
    $translations = getTranslations($db, $language_code);

    if (defined('IS_ADMIN') && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_menu_item' && isset($_POST['menu_item_id'])) {

        $menuItemId = intval($_POST['menu_item_id']);
        $result = deleteMenuItem($db, $menuItemId);

        if ($result) {
            $_SESSION['success_message'] = t("Menu item successfully deleted.");
        } else {
            $_SESSION['error_message'] = t("Error deleting menu item. Try again.");
        }
    }

    echo json_encode($response);
    exit;
?>