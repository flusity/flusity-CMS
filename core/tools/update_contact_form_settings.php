<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
  }
define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../') . '/');
define('IS_ADMIN', true);

require_once ROOT_PATH . 'security/config.php';
require_once ROOT_PATH . 'core/functions/functions.php';


 $db = getDBConnection($config);
secureSession($db, $prefix);
$language_code = getLanguageSetting($db, $prefix);
$translations = getTranslations($db, $prefix, $language_code);

if (defined('IS_ADMIN') && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $db->prepare("UPDATE `".$prefix['table_prefix']."_flussi_contact_form_settings` SET `email_subject` = :email_subject, `email_body` = :email_body, `email_success_message` = :email_success_message, `email_error_message` = :email_error_message WHERE `id` = 1");
    $stmt->bindParam(':email_subject', $_POST['emailSubject']);
    $stmt->bindParam(':email_body', $_POST['emailBody']);
    $stmt->bindParam(':email_success_message', $_POST['emailSuccessMessage']);
    $stmt->bindParam(':email_error_message', $_POST['emailErrorMessage']);
    $result = $stmt->execute();

    if ($result) {
        $_SESSION['success_message'] = t('Settings successfully updated.');
    } else {
        $_SESSION['error_message'] = t('Error updating settings. Try again.');
    }
}

header('Location: contact_form.php');
?>
