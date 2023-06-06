<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
  }
define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../') . '/');
define('IS_ADMIN', true);

require_once ROOT_PATH . 'security/config.php';
require_once ROOT_PATH . 'core/functions/functions.php';


$db = getDBConnection($config);
secureSession($db);
$language_code = getLanguageSetting($db);
$translations = getTranslations($db, $language_code);

if (defined('IS_ADMIN') && $_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST as $key => $value) {
        $stmt = $db->prepare("UPDATE `contact_form_settings` SET `setting_value` = :value WHERE `setting_key` = :key");
        $stmt->bindParam(':value', $value);
        $stmt->bindParam(':key', $key);
        $result = $stmt->execute();

        if ($result) {
            $_SESSION['success_message'] = t('Settings successfully updated.');
        } else {
            $_SESSION['error_message'] = t('Error updating settings. Try again.');
        }
    }
}

header('Location: contact_form.php');
?>
