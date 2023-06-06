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
// Gaunamas kalbos nustatymas iš duomenų bazės  
$language_code = getLanguageSetting($db);
$translations = getTranslations($db, $language_code);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create_backup'])) {
        $backupFilename = createBackupFilename($db);

        if (createDatabaseBackup($db, $backupFilename)) {
            $_SESSION['success_message'] = t("Backup successfully created.");
        } else {
            $_SESSION['error_message'] = t("Failed to create a backup.");
        }
        header("Location: settings.php");
        exit;
    }
}
