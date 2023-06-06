<?php
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
      }

define('IS_ADMIN', true);

define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../') . '/');
require_once $_SERVER['DOCUMENT_ROOT'] . '/security/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/functions/functions.php';


$db = getDBConnection($config);
secureSession($db);
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
                $_SESSION['success_message'] = t("File"). " " . $filename . " ". t("deleted successfully.");
                } else {
                    $_SESSION['error_message'] = t("Error deleting file from database.");
                    }
                    } else {
                        $_SESSION['error_message'] = t("Error deleting file from system.");
                    }
                    } else {
                        $_SESSION['error_message'] = t("No such file found."); 
                    }
                    } else {
                        $_SESSION['error_message'] = t("No file ID specified.");
                    }
                
                header("Location: files.php");
                exit();
