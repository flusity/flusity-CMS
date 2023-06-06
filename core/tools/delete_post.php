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

    if (defined('IS_ADMIN') && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_post' && isset($_POST['post_id'])) {

        $postId = intval($_POST['post_id']);
        $result = deletePost($db, $postId);

        if ($result) {
            $_SESSION['success_message'] = t("Post deleted successfully.");
        } else {
            $_SESSION['error_message'] = t("Error deleting post. Try again.");
        }
    }
    header("Location: posts.php");
    exit;
?>
