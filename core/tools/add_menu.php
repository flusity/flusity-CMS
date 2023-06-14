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

if (defined('IS_ADMIN') && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_menu' && isset($_POST['menu_name']) && isset($_POST['page_url']) && isset($_POST['position']) && isset($_POST['template']) && isset($_POST['show_in_menu']) && isset($_POST['parent_id'])) {
    $menuName = $_POST['menu_name'];
    $page_url = $_POST['page_url'];

    // Check if the page_url already exists
    $existingMenu = getMenuByPageUrl($db, $page_url);
    if($existingMenu) {
        $_SESSION['error_message'] =  t('The page_url already exists. Please choose a different one.');
        echo json_encode($response);
        exit;
    }

    $position = intval($_POST['position']);
    $template = $_POST['template'];
    $show_in_menu = filter_var($_POST['show_in_menu'], FILTER_VALIDATE_BOOLEAN);
    $parent_id = intval($_POST['parent_id']);
    $result = createMenuItem($db, $menuName, $page_url, $position, $template, $show_in_menu, $parent_id);
    
    $response = array();
    if ($result) {
        $_SESSION['success_message'] = t('Menu item successfully added.');
    } else {
        $_SESSION['error_message'] = t('Error adding menu item. Try again.');
    }
    echo json_encode($response);
    exit;
}