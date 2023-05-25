<?php
session_start();

define('IS_ADMIN', true);

define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../') . '/');
require_once $_SERVER['DOCUMENT_ROOT'] . '/security/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/functions/functions.php';

secureSession();
$db = getDBConnection($config);
// Gaunamas kalbos nustatymas iš duomenų bazės  
$language_code = getLanguageSetting($db);
$translations = getTranslations($db, $language_code);

if (!empty($_GET['id'])) {
    $file_id = intval($_GET['id']);
    $file = getFileById($db, $file_id);

    if ($file) {
        $filename = $file['name'];
        $file_path = ROOT_PATH . "uploads/" . $filename;

        if (unlink($file_path)) {
            if (deleteFileFromDatabase($db, $file_id)) {
                $_SESSION['success_message'] = t("File"). " " . $filename . " ". t("deleted successfully.");//Failas pav. sėkmingai ištrintas.
                } else {
                    $_SESSION['error_message'] = t("Error deleting file from database.");//Klaida trinant failą iš duomenų bazės.
                    }
                    } else {
                        $_SESSION['error_message'] = t("Error deleting file from system.");//Klaida trinant failą iš sistemos.
                    }
                    } else {
                        $_SESSION['error_message'] = t("No such file found."); //Toks failas nerastas.
                    }
                    } else {
                        $_SESSION['error_message'] = t("No file ID specified."); //Nenurodytas failo ID.
                    }
                
                header("Location: files.php");
                exit();
?>