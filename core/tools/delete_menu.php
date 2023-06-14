<?php
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    define('IS_ADMIN', true);
    define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../') . '/');

    require_once ROOT_PATH . 'security/config.php';
    require_once ROOT_PATH . 'core/functions/functions.php';

    $db = getDBConnection($config);
    secureSession($db);
    $language_code = getLanguageSetting($db);
    $translations = getTranslations($db, $language_code);

    $response = array();

    if (defined('IS_ADMIN') && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_menu_item' && isset($_POST['menu_item_id'])) {
        $menuItemId = intval($_POST['menu_item_id']);
        $menuItem = getMenuItemById($db, $menuItemId);

        if ($menuItem['page_url'] === 'index') {
           $_SESSION['error_message'] = t("The main page cannot be deleted.");
            echo json_encode($response);
            exit;
        }

        $result = deleteMenuItem($db, $menuItemId);

        if ($result) {
            $_SESSION['success_message'] = t("Menu item successfully deleted.");
        } else {
            $_SESSION['error_message'] = t("Error deleting menu item. Try again.");
        }
    }

    echo json_encode($response);
    exit;

