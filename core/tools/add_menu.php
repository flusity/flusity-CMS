<?php
session_start();
define('IS_ADMIN', true);

define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../') . '/');

require_once ROOT_PATH . 'security/config.php';
require_once ROOT_PATH . 'core/functions/functions.php';
secureSession();
// Duomenų gavimas iš duomenų bazės
$db = getDBConnection($config);

if (defined('IS_ADMIN') && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_menu' && isset($_POST['menu_name']) && isset($_POST['page_url']) && isset($_POST['position']) && isset($_POST['template'])) {
    $menuName = $_POST['menu_name'];
    $page_url = $_POST['page_url'];
    $position = intval($_POST['position']);
    $template = $_POST['template'];
    $result = createMenuItem($db, $menuName, $page_url, $position, $template);

    $response = array();
    if ($result) {
        $_SESSION['success_message'] = 'Menu punktas sėkmingai pridėtas.';
    } else {
        $_SESSION['error_message'] = 'Klaida pridedant menu punktą. Bandykite dar kartą.';
    }
    echo json_encode($response);
    exit;
}

?>
