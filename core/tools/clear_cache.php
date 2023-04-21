<?php
session_start();
define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../') . '/');

require_once ROOT_PATH . 'core/template/header-admin.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Įsitikinkite, kad naudojate tinkamą kelį į prisijungimo puslapį
    exit();
}

if (isset($_POST['clear_cache'])) {
    if (function_exists('apcu_clear_cache')) {
        apcu_clear_cache();
        $_SESSION['success_message'] = "Cache sėkmingai išvalytas!";
    } else {
        $_SESSION['error_message'] = "Nepavyko išvalyti cache, APCu nėra įdiegta!";
    }
    header("Location: admin.php"); // Įsitikinkite, kad naudojate tinkamą kelį į admin puslapį
    exit();
}
?>
