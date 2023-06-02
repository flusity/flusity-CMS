<?php if (session_status() !== PHP_SESSION_ACTIVE) {
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

if (defined('IS_ADMIN') && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_category' && isset($_POST['category_name'])) {
    $categoryName = $_POST['category_name'];
    $result = createCategory($db, $categoryName);

    $response = array();
    if ($result === 'Place added successfully') {
        $_SESSION['success_message'] = t('Place successfully added.');
    } elseif ($result === 'Place already exists') {
        $_SESSION['error_message'] = t('Place with this name already exists. Try a different name.');
    } else {
        $_SESSION['error_message'] = t('Error adding place. Try again.');
    }
    echo json_encode($response);
    exit;
}
