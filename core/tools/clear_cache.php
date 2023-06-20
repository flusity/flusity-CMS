<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
  }
  require_once $_SERVER['DOCUMENT_ROOT'] . '/security/config.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/core/functions/functions.php';
  define('IS_ADMIN', true);
    // Duomenų gavimas iš duomenų bazės
     $db = getDBConnection($config);
    $language_code = getLanguageSetting($db, $prefix);
    $translations = getTranslations($db, $prefix, $language_code);

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['clear_cache'])) {
    if (function_exists('apcu_clear_cache')) {
        apcu_clear_cache();
        $_SESSION['success_message'] = t("Cache cleared successfully!");
    } else {
        $_SESSION['error_message'] = t("Failed to clear cache, APCu is not installed!");
    }
    header("Location: ../../core/tools/settings.php"); 
    exit();
}
?>
