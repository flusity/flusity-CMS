<?php    
 if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
      }
define('IS_ADMIN', true);

define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../') . '/');

require_once ROOT_PATH . 'security/config.php';
require_once ROOT_PATH . 'core/functions/functions.php';
secureSession();
// Duomenų gavimas iš duomenų bazės
$db = getDBConnection($config);
// Gaunamas kalbos nustatymas iš duomenų bazės  
$language_code = getLanguageSetting($db);
$translations = getTranslations($db, $language_code);


if (isset($_POST['edit_id']) && isset($_POST['translation_key']) && isset($_POST['translation_value']) && isset($_POST['language_code'])) {
    $id = intval($_POST['edit_id']);
    $translation_key = trim($_POST['translation_key']);
    $translation_value = trim($_POST['translation_value']);
    $language_code = trim($_POST['language_code']);

    if ($language_code === 'new') {
        $language_code = trim($_POST['new_language_code']);
    }

    $updateResult = updateTranslation($db, $id, $language_code, $translation_key, $translation_value);

    if ($updateResult === "duplicate_key") {
        $_SESSION['error_message'] = t("Error: Translation word already exists.");
    } else {
        $_SESSION['success_message'] = t("Translation updated successfully.");
    }
} else {
    $_SESSION['error_message'] = t("Error: Please fill in all fields.");
}

header("Location: language.php");
exit;
