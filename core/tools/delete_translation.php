<?php
session_start();
define('IS_ADMIN', true);

define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../') . '/');

require_once ROOT_PATH . 'security/config.php';
require_once ROOT_PATH . 'core/functions/functions.php';
secureSession();
// Duomenų gavimas iš duomenų bazės
$db = getDBConnection($config);
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    if (deleteTranslation($db, $id)) {
        $_SESSION['success_message'] = "Vertimas sėkmingai ištrintas.";
    } else {
        $_SESSION['error_message'] = "Nepavyko ištrinti vertimo.";
    }
} else {
    $_SESSION['error_message'] = "Klaida: Prašome nurodyti vertimo ID.";
}

header("Location: language.php");
exit;
