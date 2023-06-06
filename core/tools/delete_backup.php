<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
  }
define('IS_ADMIN', true);

define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../') . '/');

require_once ROOT_PATH . 'security/config.php';
require_once ROOT_PATH . 'core/functions/functions.php';

$db = getDBConnection($config);
secureSession($db);
$language_code = getLanguageSetting($db);
$translations = getTranslations($db, $language_code);

if (isset($_GET['file'])) {
    $backupDir = realpath(dirname(__FILE__) . '/backups/') . '/';
    $filename = $_GET['file'];
    $filePath = $backupDir . $filename;

    if (file_exists($filePath)) {
        if (unlink($filePath)) {
            $_SESSION['success_message'] = t("Backup deleted successfully!");
        } else {
            $_SESSION['error_message'] = t("Failed to delete backup.");
        }
        header("Location: settings.php");
        exit;
    } else {
        http_response_code(404);
        echo t("File not found.");
    }
} else {
    http_response_code(400);
    echo t("Error: Please specify a file name.");
}