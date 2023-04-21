<?php
    session_start();
    define('IS_ADMIN', true);

    define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../') . '/');

    require_once ROOT_PATH . 'security/config.php';
    require_once ROOT_PATH . 'core/functions/functions.php';
    secureSession();
    // Duomenų gavimas iš duomenų bazės
    $db = getDBConnection($config);

    if (defined('IS_ADMIN') && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_category' && isset($_POST['category_id'])) {

        $categoryId = intval($_POST['category_id']);
        $result = deleteCategory($db, $categoryId);

        if ($result) {
            $_SESSION['success_message'] = 'Kategorija sėkmingai ištrinta.';
        } else {
            $_SESSION['error_message'] = 'Klaida trinant kategoriją. Bandykite dar kartą.';
        }
    }

    header("Location: categories.php");
    exit;
?>