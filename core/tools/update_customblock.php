<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
define('IS_ADMIN', true);

define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../') . '/');

require_once ROOT_PATH . 'security/config.php';
require_once ROOT_PATH . 'core/functions/functions.php';

// Duomenų gavimas iš duomenų bazės
$db = getDBConnection($config);
secureSession($db, $prefix);
$language_code = getLanguageSetting($db, $prefix);
$translations = getTranslations($db, $prefix, $language_code);

$result = ['success' => false];

// Check if all necessary POST data is available, excluding name for now
if (isset($_POST['customblock_id'], $_POST['customblock_menu_id'], $_POST['customblock_place_id'], $_POST['customblock_html_code'])) {
    $customBlockId = (int)$_POST['customblock_id'];
    
    // Handle potential nullable name
    $name = isset($_POST['customblock_name']) && !empty($_POST['customblock_name']) ? $_POST['customblock_name'] : null;
    
    $menuId = (int)$_POST['customblock_menu_id'];
    $placeId = (int)$_POST['customblock_place_id'];
    $htmlCode = $_POST['customblock_html_code'];

    $update = updateCustomBlock($db, $prefix, $customBlockId, $name, $menuId, $placeId, $htmlCode);

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
