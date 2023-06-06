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
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath);
        exit;
        } else {
            http_response_code(404);
            echo "Failas nerastas.";
        }
    } else {
        http_response_code(400);
        echo t("Error: Please specify a file name.");
    }

