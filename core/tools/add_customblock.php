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

$result = ['success' => false];

if (isset($_POST['customblock_name'], $_POST['customblock_menu_id'], $_POST['customblock_category_id'], $_POST['customblock_html_code'])) {
    $name = $_POST['customblock_name'];
    $menu_id = (int)$_POST['customblock_menu_id'];
    $category_id = (int)$_POST['customblock_category_id'];
    $html_code = $_POST['customblock_html_code'];

    $insert = createCustomBlock($db, $name, $menu_id, $category_id, $html_code);
                        
    if ($insert) {
        $_SESSION['success_message'] = 'Custom Block sėkmingai pridėtas.';
        $result['success'] = true;
    } else {
        $_SESSION['error_message'] = 'Klaida pridedant Custom Block. Bandykite dar kartą.';
    }
}

echo json_encode($result);
exit;
?>
