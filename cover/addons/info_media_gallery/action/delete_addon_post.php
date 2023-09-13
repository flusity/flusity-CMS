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
        $db->beginTransaction();

        $stmt = $db->prepare("DELETE FROM " . $prefix['table_prefix'] . "_info_media_gallery WHERE id = :id");
        $stmt->bindParam(':id', $addon_post_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $stmt2 = $db->prepare("DELETE FROM " . $prefix['table_prefix'] . "_info_media_gallery_item WHERE id_info_media_gallery = :id");
        $stmt2->bindParam(':id', $addon_post_id, PDO::PARAM_INT);
        $stmt2->execute();

        $db->commit();
        
        $_SESSION['success_message'] = t("The addon and its related items have been successfully deleted.");
        $response = [
            'status' => 'success',
            'message' => $_SESSION['success_message']
        ];

    } catch (Exception $e) {
        $db->rollback();
        $_SESSION['error_message'] = $e->getMessage();
        $response = [
            'status' => 'error',
            'message' => $_SESSION['error_message']
        ];
    }

    echo json_encode($response);
    exit();
}

?>