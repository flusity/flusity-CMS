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
$language_code = getLanguageSetting($db);
$translations = getTranslations($db, $language_code);

if (defined('IS_ADMIN') && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_menu' && isset($_POST['menu_id']) && isset($_POST['menu_name']) && isset($_POST['page_url']) && isset($_POST['position']) && isset($_POST['template']) && isset($_POST['show_in_menu']) && isset($_POST['parent_id'])) {
    $menuId = $_POST['menu_id'];
    $menuName = $_POST['menu_name'];
    $page_url = $_POST['page_url'];
    $position = intval($_POST['position']);
    $template = $_POST['template'];
    $show_in_menu = filter_var($_POST['show_in_menu'], FILTER_VALIDATE_BOOLEAN);
    $parent_id = intval($_POST['parent_id']);
    $result = updateMenuItem($db, $menuId, $menuName, $page_url, $position, $template, $show_in_menu, $parent_id);
  
    $response = array();
    if ($result) {
        $_SESSION['success_message'] = t("The menu item has been updated successfully.");
    } else {
        $_SESSION['error_message'] = t("Error updating menu item. Try again.");
    }
    echo json_encode($response);
    exit;
}

