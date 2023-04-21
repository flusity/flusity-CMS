<?php
    session_start();
    define('IS_ADMIN', true);

    define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../') . '/');

    require_once ROOT_PATH . 'security/config.php';
    require_once ROOT_PATH . 'core/functions/functions.php';
    secureSession();
    // Duomenų gavimas iš duomenų bazės
    $db = getDBConnection($config);

    if (defined('IS_ADMIN') && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_customblock' && isset($_POST['customblock_id'])) {

        $customBlockId = intval($_POST['customblock_id']);
        $result = deleteCustomBlock($db, $customBlockId);

        if ($result) {
            $_SESSION['success_message'] = 'Custom Block sėkmingai ištrintas.';
        } else {
            $_SESSION['error_message'] = 'Klaida trinant Custom Block. Bandykite dar kartą.';
        }
    }

    header("Location: customblock.php");
    exit;
?>
