<?php
session_start();
define('IS_ADMIN', true);

define('ROOT_PATH', realpath(dirname(__FILE__) . '/../../') . '/');

require_once ROOT_PATH . 'security/config.php';
require_once ROOT_PATH . 'core/functions/functions.php';
secureSession();

$db = getDBConnection($config);
$language_code = getLanguageSetting($db);
$translations = getTranslations($db, $language_code);

$result = ['success' => false];

if (isset($_POST['post_title'], $_POST['post_content'], $_POST['post_menu'], $_POST['post_status'], $_POST['post_tags'], $_POST['role'])) {
    
    $title = $_POST['post_title'];
    $content = $_POST['post_content'];
    $menuId = (int)$_POST['post_menu'];
    $status = $_POST['post_status'];
    $tags = $_POST['post_tags'];
    $role = $_POST['role'];
    $author = $_SESSION['user_id']; 

    $insert = createPost($db, $title, $content, $menuId, $status, $author, $tags, $role);

    if ($insert) {
        $_SESSION['success_message'] = t('Record successfully added.');
        $result['success'] = true;
    } else {
        $_SESSION['error_message'] = t('Error adding Record. Try again.');
    }
}

echo json_encode($result);
exit;
?>
