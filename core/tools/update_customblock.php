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
$language_code = getLanguageSetting($db);
$translations = getTranslations($db, $language_code);

$result = ['success' => false];

if (isset($_POST['customblock_id'], $_POST['customblock_name'], $_POST['customblock_menu_id'], $_POST['customblock_category_id'], $_POST['customblock_html_code'])) {
    $customBlockId = (int)$_POST['customblock_id'];
    $name = $_POST['customblock_name'];
    $menuId = (int)$_POST['customblock_menu_id'];
    $categoryId = (int)$_POST['customblock_category_id'];
    $htmlCode = $_POST['customblock_html_code'];

    $update = updateCustomBlock($db, $customBlockId, $name, $menuId, $categoryId, $htmlCode);

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
