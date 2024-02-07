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

if (!checkIfAdmin()) { // Naudojama funkcija, kad patikrintų ar vartotojas yra administratorius
    http_response_code(403);
    echo "Klaida: Neturite teisių.";
    exit;
}

if (isset($_GET['file'])) {
    $backupDir = realpath(dirname(__FILE__) . '/backups/') . '/';
    $filename = basename($_GET['file']); // Naudojama basename() funkciją, kad pašalinti kelio manipuliavimą
    $filePath = $backupDir . $filename;

    // Patikrinama, ar failas egzistuoja ir yra saugomų failų aplanke
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
        echo "Failas nerastas.";
    }
} else {
    http_response_code(400);
    echo "Klaida: Prašome nurodyti failo pavadinimą.";
}
?>
