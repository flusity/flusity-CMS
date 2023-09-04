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

if (isset($_POST['customblock_menu_id'], $_POST['customblock_place_id'], $_POST['customblock_html_code'], $_POST['lang_custom_name'], $_POST['lang_custom_content'])) {

    $name = isset($_POST['customblock_name']) && !empty($_POST['customblock_name']) ? $_POST['customblock_name'] : null;
    
    $menu_id = (int)$_POST['customblock_menu_id'];
    $place_id = (int)$_POST['customblock_place_id'];
    // Čia naudojame htmlspecialchars funkciją
    $html_code = htmlspecialchars($_POST['customblock_html_code'], ENT_QUOTES, 'UTF-8');
    $lang_custom_name = $_POST['lang_custom_name'];
    $lang_custom_content = htmlspecialchars($_POST['lang_custom_content'], ENT_QUOTES, 'UTF-8');

    $insert = createCustomBlock($db, $prefix, $name, $menu_id, $place_id, $html_code, $lang_custom_name, $lang_custom_content);
                        
    if ($insert) {
        $_SESSION['success_message'] = 'Custom Block successfully added.';
        $result['success'] = true;
    } else {
        $_SESSION['error_message'] = 'Error adding Custom Block. Try again.';
    }
}

echo json_encode($result);
exit;
?>
