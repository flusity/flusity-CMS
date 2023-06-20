<?php
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
      }
    define('IS_ADMIN', true);
    define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../') . '/');

    require_once ROOT_PATH . 'security/config.php';
    require_once ROOT_PATH . 'core/functions/functions.php';
    
     $db = getDBConnection($config);
	secureSession($db, $prefix);
    $language_code = getLanguageSetting($db, $prefix);
    $translations = getTranslations($db, $prefix, $language_code);

    if (defined('IS_ADMIN') && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_customblock' && isset($_POST['customblock_id'])) {

        $customBlockId = intval($_POST['customblock_id']);
        $result = deleteCustomBlock($db, $prefix, $customBlockId);

        if ($result) {
            $_SESSION['success_message'] = t("Custom Block successfully deleted.");
        } else {
            $_SESSION['error_message'] = t("Error deleting Custom Block. Try again.");
        }
    }

    header("Location: customblock.php");
    exit;
?>
