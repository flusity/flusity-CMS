<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../') . '/');

require_once ROOT_PATH . 'security/config.php';
require_once ROOT_PATH . 'core/functions/functions.php';

$db = getDBConnection($config);
secureSession($db, $prefix);
$language_code = getLanguageSetting($db, $prefix);
$translations = getTranslations($db, $prefix, $language_code);

if (!checkIfAdmin()) { // A function is used to check if the user is an administrator
    http_response_code(403);
    echo t("Error: You do not have rights.");
    exit;
}

if (isset($_GET['file'])) {
    $backupDir = realpath(dirname(__FILE__) . '/backups/') . '/';
    $filename = basename($_GET['file']); //Uses the basename() function to eliminate path manipulation
    $filePath = $backupDir . $filename;

    // Checks if the file exists and is in the stored files folder
    if (file_exists($filePath) && is_file($filePath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath);
        exit;
    } else {
        http_response_code(404);
        echo t("File not found.");
    }
} else {
    http_response_code(400);
    echo t("Error: Specify a file name.");
}
?>
