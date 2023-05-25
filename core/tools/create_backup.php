<?php
session_start();
define('IS_ADMIN', true);

define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../') . '/');

require_once ROOT_PATH . 'security/config.php';
require_once ROOT_PATH . 'core/functions/functions.php';

$db = getDBConnection($config);
// Gaunamas kalbos nustatymas iš duomenų bazės  
$language_code = getLanguageSetting($db);
$translations = getTranslations($db, $language_code);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create_backup'])) {
        $backupFilename = createBackupFilename($db);

        if (createDatabaseBackup($db, $backupFilename)) {
            $_SESSION['success_message'] = "Atsarginė kopija sėkmingai sukurta.";
        } else {
            $_SESSION['error_message'] = "Nepavyko sukurti atsarginės kopijos.";
        }
        header("Location: settings.php");
        exit;
    }
}
