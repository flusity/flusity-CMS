<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
  }
define('IS_ADMIN', true);

define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../') . '/');

require_once ROOT_PATH . 'security/config.php';
require_once ROOT_PATH . 'core/functions/functions.php';
secureSession();
// Duomenų gavimas iš duomenų bazės
$db = getDBConnection($config); 
$language_code = getLanguageSetting($db);
$translations = getTranslations($db, $language_code);

if (defined('IS_ADMIN') && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_menu' && isset($_POST['menu_id']) && isset($_POST['menu_name']) && isset($_POST['page_url']) && isset($_POST['position']) && isset($_POST['template'])) {
    $menuId = $_POST['menu_id'];
    $menuName = $_POST['menu_name'];
    $page_url = $_POST['page_url'];
    $position = intval($_POST['position']);
    $template = $_POST['template'];
    $result = updateMenuItem($db, $menuId, $menuName, $page_url, $position, $template);

    $response = array();
    if ($result) {
        $_SESSION['success_message'] = t("The menu item has been updated successfully.");
    } else {
        $_SESSION['error_message'] = t("Error updating menu item. Try again.");
    }
    echo json_encode($response);
    exit;
}

