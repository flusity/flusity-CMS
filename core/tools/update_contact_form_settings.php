<?php
define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../') . '/');

require_once ROOT_PATH . 'core/functions/functions.php';
require_once ROOT_PATH . 'security/config.php';

$db = getDBConnection($config);


foreach ($_POST as $key => $value) {
    $stmt = $db->prepare("UPDATE `contact_form_settings` SET `setting_value` = :value WHERE `setting_key` = :key");
    $stmt->bindParam(':value', $value);
    $stmt->bindParam(':key', $key);
    $stmt->execute();
}

header('Location: contact_form.php');
