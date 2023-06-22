<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

define('IS_ADMIN', true);
define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../') . '/');
require_once $_SERVER['DOCUMENT_ROOT'] . '/security/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/functions/functions.php';

$db = getDBConnection($config);
secureSession($db, $prefix);
$target_dir = ROOT_PATH . "uploads/";

$allowed_file_types = ['image/png', 'image/jpeg', 'image/gif', 'application/pdf', 'application/msword', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
$max_file_size = 5 * 1024 * 1024;

$file_id = handleFileUpload($db, $prefix['table_prefix'], $target_dir, $allowed_file_types, $max_file_size);

if ($file_id !== false) {
    // Jei failo įkėlimas pavyko, galima papildomai papildyti atliekami veiksmai su duomenų baze...
}

header("Location: files.php");
exit();
?>
