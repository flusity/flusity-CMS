<?php
session_start();
define('IS_ADMIN', true);

define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../') . '/');

require_once ROOT_PATH . 'security/config.php';
require_once ROOT_PATH . 'core/functions/functions.php';

$db = getDBConnection($config);


if (isset($_GET['file'])) {
    $backupDir = realpath(dirname(__FILE__) . '/backups/') . '/';
    $filename = $_GET['file'];
    $filePath = $backupDir . $filename;

    if (file_exists($filePath)) {
        if (unlink($filePath)) {
            $_SESSION['success_message'] = "Atsarginė kopija sėkmingai ištrinta!";
        } else {
            $_SESSION['error_message'] = "Nepavyko ištrinti atsarginės kopijos.";
        }
        header("Location: settings.php");
        exit;
    } else {
        http_response_code(404);
        echo "Failas nerastas.";
    }
} else {
    http_response_code(400);
    echo "Klaida: Prašome nurodyti failo pavadinimą.";
}