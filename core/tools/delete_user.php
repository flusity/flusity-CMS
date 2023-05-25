<?php
    session_start();
    define('IS_ADMIN', true);

    define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../') . '/');

    require_once ROOT_PATH . 'security/config.php';
    require_once ROOT_PATH . 'core/functions/functions.php';
    secureSession();
    // Duomenų gavimas iš duomenų bazės
    $db = getDBConnection($config);
// Gaunamas kalbos nustatymas iš duomenų bazės  
$language_code = getLanguageSetting($db);
$translations = getTranslations($db, $language_code);

    if (defined('IS_ADMIN') && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_user' && isset($_POST['user_id'])) {

        $userId = intval($_POST['user_id']);
        $result = deleteUser($db, $userId);

        if ($result) {
            $_SESSION['success_message'] = 'User deleted successfully.';
        } else {
            $_SESSION['error_message'] = 'Error deleting User. Try again.';
        }
    }

    header("Location: users.php");
    exit;
?>