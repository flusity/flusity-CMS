<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
define('IS_ADMIN', true);

define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../') . '/');

require_once ROOT_PATH . 'security/config.php';
require_once ROOT_PATH . 'core/functions/functions.php';

$db = getDBConnection($config);
secureSession($db, $prefix);
$language_code = getLanguageSetting($db, $prefix);
$translations = getTranslations($db, $prefix, $language_code);

$result = ['success' => false];

if (isset($_POST['customblock_id'], $_POST['customblock_menu_id'], $_POST['customblock_place_id'], $_POST['customblock_html_code'], $_POST['lang_custom_name'], $_POST['lang_custom_content'])) {
    $customBlockId = (int)$_POST['customblock_id'];
    
    $name = isset($_POST['customblock_name']) && !empty($_POST['customblock_name']) ? $_POST['customblock_name'] : null;
    
    $menuId = (int)$_POST['customblock_menu_id'];
    $placeId = (int)$_POST['customblock_place_id'];
    $htmlCode = $_POST['customblock_html_code'];
    $lang_custom_name = $_POST['lang_custom_name'];
    $lang_custom_content = $_POST['lang_custom_content'];

    $update = updateCustomBlock($db, $prefix, $customBlockId, $name, $menuId, $placeId, $htmlCode, $lang_custom_name, $lang_custom_content);

    if ($update) {
        $_SESSION['success_message'] = t('The Block has been updated successfully.');
        $result['success'] = true;
    } else {
        $_SESSION['error_message'] = t('Error update the Block. Try again.');
    }
}

echo json_encode($result);
exit;
?>