<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

define('IS_ADMIN', true);
define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'] . '/');
require_once ROOT_PATH . 'security/config.php';
require_once ROOT_PATH . 'core/functions/functions.php';

$db = getDBConnection($config);
secureSession($db, $prefix);
$language_code = getLanguageSetting($db, $prefix);
$translations = getTranslations($db, $prefix, $language_code);

$response = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
 { 
    $addon_post_id = intval($_POST['addon_post_id']);


    try {
        $stmt = $db->prepare("DELETE FROM " . $prefix['table_prefix'] . "_social_block_links WHERE id = :id");
        $stmt->bindParam(':id', $addon_post_id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $_SESSION['success_message'] = t("The addon has been successfully deleted.");
            $response = [
                'status' => 'success',
                'message' => $_SESSION['success_message']
            ];
        } else {
            $_SESSION['error_message'] = t("Addon not found.");
            $response = [
                'status' => 'error',
                'message' => $_SESSION['error_message']
            ];
        }
        
        
        echo json_encode($response);
        exit();

    } catch (Exception $e) {
        $_SESSION['error_message'] = $e->getMessage();
    }
    
    header('Location: ' . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/core/tools/addons_model.php?name=social_block_links&id=' . $_POST['id']);
    exit();
}
?>
