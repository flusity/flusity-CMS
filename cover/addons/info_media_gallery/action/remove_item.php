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

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $input = json_decode(file_get_contents('php://input'), true);
        $id = $input['id'];
        
        // SQL DELETE užklausa
        $sql = "DELETE FROM " . $prefix['table_prefix'] . "_info_media_gallery_item WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);

        echo json_encode(['success' => true, 'message' => 'The addon was updated successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
