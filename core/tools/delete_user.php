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

    if (defined('IS_ADMIN') && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_user' && isset($_POST['user_id'])) {

        $userId = intval($_POST['user_id']);
        $result = deleteUser($db, $prefix, $userId);
    
        if ($result) {
            $_SESSION['success_message'] = t('User deleted successfully.');
        } else {
            if (checkUserRole($userId, 'admin', $db, $prefix) && countAdmins($db, $prefix) <= 1){
                $_SESSION['error_message'] = t('Cannot delete the last admin.');
            } else {
                $_SESSION['error_message'] = t('Error deleting User. Try again.');
            }
        }
    }
    
    echo json_encode($result);
    exit;
