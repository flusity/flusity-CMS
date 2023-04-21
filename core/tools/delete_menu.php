<?php
    session_start();
    define('IS_ADMIN', true);

    define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../') . '/');

    require_once ROOT_PATH . 'security/config.php';
    require_once ROOT_PATH . 'core/functions/functions.php';
    secureSession();
    // Duomenų gavimas iš duomenų bazės
    $db = getDBConnection($config);

    if (defined('IS_ADMIN') && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_menu_item' && isset($_POST['menu_item_id'])) {

        $menuItemId = intval($_POST['menu_item_id']);
        $result = deleteMenuItem($db, $menuItemId);

        if ($result) {
            $_SESSION['success_message'] = 'Meniu punktas sėkmingai ištrintas.';
        } else {
            $_SESSION['error_message'] = 'Klaida trinant meniu punktą. Bandykite dar kartą.';
        }
    }

    echo json_encode($response);
    exit;
?>